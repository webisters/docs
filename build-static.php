<?php declare(strict_types=1);
/**
 * Webisters Docs - Static site generator.
 *
 * Crawls the PHP built-in dev server (see router.php) starting from "/" and
 * mirrors every reachable page to plain HTML under _site/, so the docs can be
 * hosted on a static host such as GitHub Pages (which cannot run PHP).
 *
 * Internal ".php" links are rewritten to ".html". The dynamically generated
 * class-detail pages (/classes/Framework-*.php) are captured by following the
 * links found on the package pages.
 *
 * Usage:
 *   1. Terminal A:  php -S 127.0.0.1:8099 router.php
 *   2. Terminal B:  php build-static.php
 *
 * Env overrides: BASE (default http://127.0.0.1:8099), OUT (default ./_site).
 */

error_reporting(E_ALL & ~E_DEPRECATED & ~E_NOTICE);

$BASE = rtrim(getenv('BASE') ?: 'http://127.0.0.1:8099', '/');
$OUT  = getenv('OUT') ?: (__DIR__ . DIRECTORY_SEPARATOR . '_site');

// --- URL helpers -------------------------------------------------------------

/** Is this link value external / non-navigable? */
function is_external(string $val): bool {
    return $val === ''
        || $val[0] === '#'
        || str_starts_with($val, 'http://')
        || str_starts_with($val, 'https://')
        || str_starts_with($val, '//')
        || str_starts_with($val, 'mailto:')
        || str_starts_with($val, 'tel:')
        || str_starts_with($val, 'javascript:')
        || str_starts_with($val, 'data:');
}

/** Resolve a (possibly relative) link against the current URL path directory. */
function resolve_url(string $currentPath, string $link): string {
    // Split off query/hash – only the path participates in resolution.
    $link = preg_replace('/[?#].*$/', '', $link) ?? $link;
    if ($link === '') {
        return $currentPath;
    }
    if ($link[0] === '/') {
        $segments = explode('/', ltrim($link, '/'));
    } else {
        $dir = rtrim(substr($currentPath, 0, (int) strrpos($currentPath, '/')), '/');
        $segments = array_merge(
            $dir === '' ? [] : explode('/', ltrim($dir, '/')),
            explode('/', $link)
        );
    }
    $out = [];
    foreach ($segments as $seg) {
        if ($seg === '' || $seg === '.') {
            continue;
        }
        if ($seg === '..') {
            array_pop($out); // clamp at root
            continue;
        }
        $out[] = $seg;
    }
    return '/' . implode('/', $out);
}

/** Map a URL path to its output file path (relative, using '/'). */
function url_to_file(string $path): string {
    $path = ltrim($path, '/');
    if ($path === '' || str_ends_with($path, '/')) {
        return $path . 'index.html';
    }
    if (str_ends_with($path, '.php')) {
        return substr($path, 0, -4) . '.html'; // index.php -> index.html, X.php -> X.html
    }
    return $path; // assets and the like
}

/** Should we crawl (fetch + save) this internal path? Only HTML-producing pages. */
function is_page(string $path): bool {
    return str_ends_with($path, '.php') || str_ends_with($path, '/') || $path === '';
}

/** Rewrite internal .php links inside an href/src attribute value to .html. */
function rewrite_link(string $val): string {
    if (is_external($val)) {
        return $val;
    }
    // Separate path from query/hash.
    $suffix = '';
    if (preg_match('/^([^?#]*)([?#].*)$/', $val, $m)) {
        $val = $m[1];
        $suffix = $m[2];
    }
    if (str_ends_with($val, '.php')) {
        $val = substr($val, 0, -4) . '.html';
    }
    return $val . $suffix;
}

/** Rewrite all internal .php links in a full HTML document. */
function rewrite_html(string $html): string {
    return preg_replace_callback(
        '/\b(href|src)\s*=\s*("|\')(.*?)\2/is',
        static function (array $m): string {
            return $m[1] . '=' . $m[2] . rewrite_link($m[3]) . $m[2];
        },
        $html
    ) ?? $html;
}

/** Recursively copy a directory. */
function copy_dir(string $src, string $dst): void {
    if (!is_dir($src)) {
        return;
    }
    @mkdir($dst, 0777, true);
    /** @var iterable<SplFileInfo> $it */
    $it = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($src, FilesystemIterator::SKIP_DOTS),
        RecursiveIteratorIterator::SELF_FIRST
    );
    foreach ($it as $item) {
        $target = $dst . DIRECTORY_SEPARATOR . $it->getSubPathName();
        if ($item->isDir()) {
            @mkdir($target, 0777, true);
        } else {
            copy($item->getPathname(), $target);
        }
    }
}

// --- Crawl -------------------------------------------------------------------

$queue   = ['/'];
$seen    = ['/' => true];
$saved   = 0;
$errors  = [];

echo "Crawling {$BASE} -> {$OUT}\n";

while ($queue) {
    $path = array_shift($queue);
    $ctx = stream_context_create(['http' => ['ignore_errors' => true, 'timeout' => 30]]);
    $html = @file_get_contents($BASE . $path, false, $ctx);
    $status = 0;
    foreach (($http_response_header ?? []) as $h) {
        if (preg_match('#^HTTP/\S+\s+(\d+)#', $h, $sm)) {
            $status = (int) $sm[1];
        }
    }
    if ($html === false || $status >= 400) {
        $errors[] = sprintf('[%s] %s', $status ?: 'ERR', $path);
        continue;
    }

    // Save (rewriting internal links).
    $file = $OUT . '/' . url_to_file($path);
    @mkdir(dirname($file), 0777, true);
    file_put_contents($file, rewrite_html($html));
    $saved++;
    if ($saved % 25 === 0) {
        echo "  ... {$saved} pages\n";
    }

    // Discover links.
    if (preg_match_all('/\b(?:href|src)\s*=\s*("|\')(.*?)\1/is', $html, $mm)) {
        foreach ($mm[2] as $raw) {
            $raw = html_entity_decode($raw, ENT_QUOTES | ENT_HTML5);
            if (is_external($raw)) {
                continue;
            }
            $resolved = resolve_url($path, $raw);
            if (!is_page($resolved) || isset($seen[$resolved])) {
                continue;
            }
            $seen[$resolved] = true;
            $queue[] = $resolved;
        }
    }
}

// --- Static assets & host files ---------------------------------------------

copy_dir(__DIR__ . '/assets', $OUT . '/assets');
file_put_contents($OUT . '/.nojekyll', '');       // don't run Jekyll on GitHub Pages

echo "\nDone. Saved {$saved} pages.\n";
if ($errors) {
    echo 'Errors (' . count($errors) . "):\n  " . implode("\n  ", array_slice($errors, 0, 40)) . "\n";
}
