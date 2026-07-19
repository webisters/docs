<?php
/**
 * Webisters Docs - Class / Interface / Trait detail page.
 *
 * Renders auto-generated API documentation for any Framework\* class
 * by introspecting it via Reflection.
 *
 * Expected input: $_SERVER['WEBISTERS_CLASS'] — fully-qualified class name
 *                 (e.g. "Framework\MVC\App"), set by router.php.
 *
 * If invoked directly without WEBISTERS_CLASS set, infers the class from
 * the current URL filename: "Framework-MVC-App.php" -> "Framework\MVC\App".
 */

// --- 1. Resolve the class name ------------------------------------------------
$wbClassName = $_SERVER['WEBISTERS_CLASS'] ?? null;
if (!$wbClassName) {
    $uri = parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH);
    $base = basename($uri ?? '', '.php');
    if ($base !== '') {
        $wbClassName = str_replace('-', '\\', $base);
    }
}
$wbClassName = trim((string) $wbClassName, '\\');

// --- 2. Register an autoloader for Framework\* classes ------------------------
// We map composer PSR-4 prefixes to the libraries/<slug>/src/ folders directly,
// independent of any vendor symlinks.
if (!function_exists('wb_register_framework_autoloader')) {
    function wb_register_framework_autoloader(): void {
        // The /libraries directory at the repo root (../../libraries from docs/).
        $librariesRoot = realpath(__DIR__ . '/../../libraries');
        if (!$librariesRoot) { return; }

        // PSR-4 prefix => library folder slug.
        // Order: longest prefix first so Framework\Database\Extra\ wins over Framework\Database\.
        $map = [
            'Framework\\Database\\Extra\\' => 'database-extra',
            'Framework\\HTTP\\Client\\'    => 'http-client',
            'Framework\\CLI\\Commands\\'   => 'dev-commands',
            'Framework\\Autoload\\'        => 'autoload',
            'Framework\\Cache\\'           => 'cache',
            'Framework\\CLI\\'             => 'cli',
            'Framework\\CodingStandard\\'  => 'coding-standard',
            'Framework\\Config\\'          => 'config',
            'Framework\\Crypto\\'          => 'crypto',
            'Framework\\Database\\'        => 'database',
            'Framework\\Date\\'            => 'date',
            'Framework\\Debug\\'           => 'debug',
            'Framework\\Email\\'           => 'email',
            'Framework\\Events\\'          => 'events',
            'Framework\\Factories\\'       => 'factories',
            'Framework\\Helpers\\'         => 'helpers',
            'Framework\\HTTP\\'            => 'http',
            'Framework\\Image\\'           => 'image',
            'Framework\\Language\\'        => 'language',
            'Framework\\Log\\'             => 'log',
            'Framework\\Minify\\'          => 'minify',
            'Framework\\MVC\\'             => 'mvc',
            'Framework\\Pagination\\'      => 'pagination',
            'Framework\\Routing\\'         => 'routing',
            'Framework\\Session\\'         => 'session',
            'Framework\\Testing\\'         => 'testing',
            'Framework\\Theme\\'           => 'theme',
            'Framework\\Validation\\'      => 'validation',
        ];

        spl_autoload_register(static function (string $class) use ($map, $librariesRoot) {
            foreach ($map as $prefix => $slug) {
                if (strpos($class, $prefix) === 0) {
                    $relative = substr($class, strlen($prefix));
                    $file = $librariesRoot . '/' . $slug . '/src/'
                          . str_replace('\\', '/', $relative) . '.php';
                    if (is_file($file)) {
                        require_once $file;
                        return;
                    }
                }
            }
        });

        // Best-effort: also load the project autoloader if available so external
        // deps (PSR interfaces etc.) resolve when Reflection inspects signatures.
        $projectAutoload = realpath(__DIR__ . '/../../projects/app/vendor/autoload.php');
        if ($projectAutoload && is_file($projectAutoload)) {
            try { require_once $projectAutoload; } catch (\Throwable $e) { /* ignore */ }
        }
    }
}
wb_register_framework_autoloader();

// --- 3. Try to reflect the class ---------------------------------------------
$reflection   = null;
$loadError    = null;
$elementType  = 'class';

if ($wbClassName !== '') {
    try {
        if (class_exists($wbClassName)) {
            $reflection = new ReflectionClass($wbClassName);
            $elementType = $reflection->isInterface() ? 'interface'
                         : ($reflection->isTrait() ? 'trait'
                         : ($reflection->isEnum() ? 'enum' : 'class'));
        } elseif (interface_exists($wbClassName)) {
            $reflection = new ReflectionClass($wbClassName);
            $elementType = 'interface';
        } elseif (trait_exists($wbClassName)) {
            $reflection = new ReflectionClass($wbClassName);
            $elementType = 'trait';
        } elseif (enum_exists($wbClassName)) {
            $reflection = new ReflectionClass($wbClassName);
            $elementType = 'enum';
        } else {
            $loadError = "The class “{$wbClassName}” could not be located.";
        }
    } catch (\Throwable $e) {
        $loadError = $e->getMessage();
    }
}

// --- 4. Helpers --------------------------------------------------------------
if (!function_exists('wb_doc_summary')) {
    /** Extract the short (first paragraph) description from a docblock. */
    function wb_doc_summary(?string $doc): string {
        if (!$doc) { return ''; }
        // Strip /** */ and leading * markers
        $doc = preg_replace('#^\s*/\*+|\*+/\s*$#', '', $doc);
        $lines = preg_split('/\r?\n/', $doc);
        $clean = [];
        foreach ($lines as $line) {
            $line = preg_replace('/^\s*\*\s?/', '', $line);
            if ($line === null) { continue; }
            $trim = trim($line);
            if ($trim === '' && empty($clean)) { continue; }
            if (str_starts_with($trim, '@')) { break; } // tags start
            if ($trim === '' && !empty($clean)) { break; } // blank ends summary
            $clean[] = $line;
        }
        return trim(implode(' ', array_map('trim', $clean)));
    }
}
if (!function_exists('wb_doc_description')) {
    function wb_doc_description(?string $doc): string {
        if (!$doc) { return ''; }
        $doc = preg_replace('#^\s*/\*+|\*+/\s*$#', '', $doc);
        $lines = preg_split('/\r?\n/', $doc);
        $bodyLines = [];
        $seenSummary = false; $summaryDone = false;
        foreach ($lines as $line) {
            $line = preg_replace('/^\s*\*\s?/', '', $line);
            if ($line === null) { $line = ''; }
            $trim = trim($line);
            if (str_starts_with($trim, '@')) { break; }
            if (!$seenSummary) {
                if ($trim === '') { continue; }
                $seenSummary = true; continue; // skip the summary line
            }
            if (!$summaryDone) {
                if ($trim === '') { $summaryDone = true; continue; }
                continue;
            }
            $bodyLines[] = $line;
        }
        return trim(implode("\n", $bodyLines));
    }
}
if (!function_exists('wb_doc_tags')) {
    /** Return docblock tags as list of [name, value]. */
    function wb_doc_tags(?string $doc): array {
        if (!$doc) { return []; }
        $doc = preg_replace('#^\s*/\*+|\*+/\s*$#', '', $doc);
        $lines = preg_split('/\r?\n/', $doc);
        $tags = [];
        $current = null;
        foreach ($lines as $line) {
            $line = preg_replace('/^\s*\*\s?/', '', $line);
            if ($line === null) { $line = ''; }
            $trim = trim($line);
            if (preg_match('/^@(\w[\w-]*)\s*(.*)$/', $trim, $m)) {
                if ($current) { $tags[] = $current; }
                $current = [$m[1], $m[2]];
            } elseif ($current !== null && $trim !== '') {
                $current[1] .= ' ' . $trim;
            }
        }
        if ($current) { $tags[] = $current; }
        return $tags;
    }
}
if (!function_exists('wb_render_type')) {
    function wb_render_type(?\ReflectionType $type): string {
        if ($type === null) { return ''; }
        if ($type instanceof \ReflectionUnionType) {
            return implode('|', array_map('wb_render_type', $type->getTypes()));
        }
        if ($type instanceof \ReflectionIntersectionType) {
            return implode('&', array_map('wb_render_type', $type->getTypes()));
        }
        if ($type instanceof \ReflectionNamedType) {
            $name = $type->getName();
            $short = (strpos($name, '\\') !== false)
                ? '\\' . ltrim($name, '\\')
                : $name;
            return ($type->allowsNull() && $name !== 'mixed' && $name !== 'null' ? '?' : '') . $short;
        }
        return (string) $type;
    }
}
if (!function_exists('wb_visibility')) {
    function wb_visibility(\ReflectionMethod|\ReflectionProperty $m): string {
        if ($m->isPublic())    { return 'public'; }
        if ($m->isProtected()) { return 'protected'; }
        if ($m->isPrivate())   { return 'private'; }
        return '';
    }
}
if (!function_exists('wb_method_signature')) {
    function wb_method_signature(\ReflectionMethod $m): string {
        $parts = [];
        $parts[] = wb_visibility($m);
        if ($m->isStatic())   { $parts[] = 'static'; }
        if ($m->isAbstract() && !$m->getDeclaringClass()->isInterface()) { $parts[] = 'abstract'; }
        if ($m->isFinal())    { $parts[] = 'final'; }
        $parts[] = 'function';
        $name = $m->getName();
        $args = [];
        foreach ($m->getParameters() as $p) {
            $arg = '';
            $type = wb_render_type($p->getType());
            if ($type !== '') { $arg .= $type . ' '; }
            if ($p->isPassedByReference()) { $arg .= '&'; }
            if ($p->isVariadic())          { $arg .= '...'; }
            $arg .= '$' . $p->getName();
            if ($p->isDefaultValueAvailable()) {
                try {
                    $default = $p->getDefaultValue();
                    $arg .= ' = ' . var_export($default, true);
                } catch (\Throwable $e) {
                    $arg .= ' = ?';
                }
            }
            $args[] = $arg;
        }
        $signature = implode(' ', array_filter($parts)) . ' ' . $name . '(' . implode(', ', $args) . ')';
        $returnType = wb_render_type($m->getReturnType());
        if ($returnType !== '') { $signature .= ': ' . $returnType; }
        return $signature;
    }
}
if (!function_exists('wb_property_signature')) {
    function wb_property_signature(\ReflectionProperty $p): string {
        $parts = [];
        $parts[] = wb_visibility($p);
        if ($p->isStatic())   { $parts[] = 'static'; }
        if ($p->isReadOnly()) { $parts[] = 'readonly'; }
        $type = wb_render_type($p->getType());
        if ($type !== '') { $parts[] = $type; }
        $parts[] = '$' . $p->getName();
        $sig = implode(' ', array_filter($parts));
        if ($p->hasDefaultValue()) {
            try { $sig .= ' = ' . var_export($p->getDefaultValue(), true); }
            catch (\Throwable $e) { /* ignore */ }
        }
        return $sig;
    }
}

// --- 5. Resolve docs root + chrome -------------------------------------------
// Tell header/sidebar/footer what the "current page" is so paths resolve.
$pageTitle = $reflection
    ? ucfirst($elementType) . ' ' . $reflection->getShortName() . ' · Webisters Docs'
    : 'Class not found · Webisters Docs';

$_SERVER['WEBISTERS_TARGET'] = $_SERVER['WEBISTERS_TARGET']
    ?? (__DIR__ . '/../classes/' . str_replace('\\', '-', $wbClassName) . '.php');
$CURRENT_PAGE = 'classes/' . str_replace('\\', '-', $wbClassName) . '.php';

require __DIR__ . '/header.php';
require __DIR__ . '/sidebar.php';
?>
<?php if ($loadError || !$reflection): ?>
    <article class="phpdocumentor-element -class">
        <h2 class="phpdocumentor-content__title">
            Class not found
            <span class="phpdocumentor-element__type">404</span>
        </h2>
        <p class="phpdocumentor-summary">
            <?php echo htmlspecialchars($loadError ?? 'No class name was provided.'); ?>
        </p>
        <p>Try browsing the <a href="<?php echo ROOT; ?>packages/framework.php">Packages</a> list,
        or head back to the <a href="<?php echo ROOT; ?>index.php">documentation home</a>.</p>
    </article>
<?php else: ?>
    <article class="phpdocumentor-element -<?php echo $elementType; ?>">
        <h2 class="phpdocumentor-content__title">
            <?php echo htmlspecialchars($reflection->getShortName()); ?>
            <span class="phpdocumentor-element__type"><?php echo $elementType; ?></span>
            <?php if ($reflection->isAbstract() && !$reflection->isInterface()): ?>
                <span class="phpdocumentor-element__type">abstract</span>
            <?php endif; ?>
            <?php if ($reflection->isFinal()): ?>
                <span class="phpdocumentor-element__type">final</span>
            <?php endif; ?>
        </h2>
        <p class="phpdocumentor-element__fully-qualified-name">
            <code><?php echo htmlspecialchars($reflection->getName()); ?></code>
        </p>

        <?php
        // Description from the class-level docblock.
        $classDoc      = $reflection->getDocComment() ?: '';
        $classSummary  = wb_doc_summary($classDoc);
        $classDescription = wb_doc_description($classDoc);
        ?>
        <?php if ($classSummary !== ''): ?>
            <p class="phpdocumentor-summary"><?php echo htmlspecialchars($classSummary); ?></p>
        <?php endif; ?>
        <?php if ($classDescription !== ''): ?>
            <div class="phpdocumentor-description">
                <?php foreach (preg_split('/\n{2,}/', $classDescription) as $para): ?>
                    <p><?php echo nl2br(htmlspecialchars($para)); ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php
        $parent     = $reflection->getParentClass();
        $interfaces = $reflection->getInterfaceNames();
        ?>
        <?php if ($parent): ?>
            <p class="phpdocumentor-element__extends">
                Extends <a href="<?php echo ROOT; ?>classes/<?php echo str_replace('\\', '-', $parent->getName()); ?>.php"><code><?php echo htmlspecialchars($parent->getName()); ?></code></a>
            </p>
        <?php endif; ?>
        <?php if ($interfaces): ?>
            <p class="phpdocumentor-element__implements">
                <?php echo $reflection->isInterface() ? 'Extends' : 'Implements'; ?>:
                <?php foreach ($interfaces as $i => $iface):
                    $ifaceFile = str_replace('\\', '-', $iface);
                    ?><a href="<?php echo ROOT; ?>classes/<?php echo $ifaceFile; ?>.php"><code><?php echo htmlspecialchars($iface); ?></code></a><?php
                    if ($i < count($interfaces) - 1) echo ', ';
                endforeach; ?>
            </p>
        <?php endif; ?>

        <?php
        // Found-in file path indicator
        $sourceFile = $reflection->getFileName();
        if ($sourceFile) {
            $librariesRoot = realpath(__DIR__ . '/../../libraries');
            $shortPath = $librariesRoot ? str_replace($librariesRoot, 'libraries', $sourceFile) : $sourceFile;
            $shortPath = str_replace('\\', '/', $shortPath);
            ?>
            <p class="phpdocumentor-element-found-in">
                Defined in <span class="phpdocumentor-element-found-in__file"><?php echo htmlspecialchars($shortPath); ?></span>
            </p>
        <?php } ?>

        <?php
        // -------- Constants --------
        $constants = $reflection->getReflectionConstants();
        if ($constants):
        ?>
        <h3 id="constants">
            Constants <a href="#constants" class="headerlink">#</a>
        </h3>
        <dl class="phpdocumentor-table-of-contents">
            <?php foreach ($constants as $c):
                if ($c->getDeclaringClass()->getName() !== $reflection->getName() && !$reflection->isInterface()) { continue; }
                $cDoc = wb_doc_summary($c->getDocComment() ?: '');
                ?>
                <dt class="phpdocumentor-table-of-contents__entry -constant">
                    <a href="#const-<?php echo htmlspecialchars($c->getName()); ?>"><?php echo htmlspecialchars($c->getName()); ?></a>
                </dt>
                <dd><?php echo htmlspecialchars($cDoc !== '' ? $cDoc : '—'); ?></dd>
            <?php endforeach; ?>
        </dl>
        <?php endif; ?>

        <?php
        // -------- Properties --------
        $properties = $reflection->getProperties();
        $ownProperties = array_filter($properties, fn ($p) => $p->getDeclaringClass()->getName() === $reflection->getName());
        if ($ownProperties):
        ?>
        <h3 id="properties">
            Properties <a href="#properties" class="headerlink">#</a>
        </h3>
        <dl class="phpdocumentor-table-of-contents">
            <?php foreach ($ownProperties as $p):
                $pDoc = wb_doc_summary($p->getDocComment() ?: '');
                ?>
                <dt class="phpdocumentor-table-of-contents__entry -property">
                    <a href="#prop-<?php echo htmlspecialchars($p->getName()); ?>">$<?php echo htmlspecialchars($p->getName()); ?></a>
                </dt>
                <dd><?php echo htmlspecialchars($pDoc !== '' ? $pDoc : '—'); ?></dd>
            <?php endforeach; ?>
        </dl>

        <?php foreach ($ownProperties as $p):
            $pDoc = $p->getDocComment() ?: '';
            ?>
            <div class="phpdocumentor-property" id="prop-<?php echo htmlspecialchars($p->getName()); ?>">
                <h4>$<?php echo htmlspecialchars($p->getName()); ?></h4>
                <div class="phpdocumentor-signature"><?php echo htmlspecialchars(wb_property_signature($p)); ?></div>
                <?php $sum = wb_doc_summary($pDoc); if ($sum) : ?>
                    <p class="phpdocumentor-summary"><?php echo htmlspecialchars($sum); ?></p>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
        <?php endif; ?>

        <?php
        // -------- Methods --------
        $methods = $reflection->getMethods();
        $ownMethods = array_filter($methods, fn ($m) => $m->getDeclaringClass()->getName() === $reflection->getName());
        // Sort: constructor first, then public methods, then protected, then private
        usort($ownMethods, function ($a, $b) {
            $rank = fn ($m) => $m->getName() === '__construct' ? 0
                : ($m->isPublic() ? 1 : ($m->isProtected() ? 2 : 3));
            return $rank($a) <=> $rank($b) ?: strcmp($a->getName(), $b->getName());
        });

        if ($ownMethods):
        ?>
        <h3 id="methods">
            Methods <a href="#methods" class="headerlink">#</a>
        </h3>
        <dl class="phpdocumentor-table-of-contents">
            <?php foreach ($ownMethods as $m):
                $mDoc = wb_doc_summary($m->getDocComment() ?: '');
                ?>
                <dt class="phpdocumentor-table-of-contents__entry -method">
                    <a href="#method-<?php echo htmlspecialchars($m->getName()); ?>"><?php echo htmlspecialchars($m->getName()); ?>()</a>
                </dt>
                <dd><?php echo htmlspecialchars($mDoc !== '' ? $mDoc : '—'); ?></dd>
            <?php endforeach; ?>
        </dl>

        <?php foreach ($ownMethods as $m):
            $mDoc     = $m->getDocComment() ?: '';
            $mSummary = wb_doc_summary($mDoc);
            $mDescription = wb_doc_description($mDoc);
            $tags     = wb_doc_tags($mDoc);
            $paramTags = [];
            $returnTag = null;
            $throwsTags = [];
            foreach ($tags as [$t, $v]) {
                if ($t === 'param') {
                    if (preg_match('/^(\S+)\s+(\$\S+)\s*(.*)$/', $v, $mm)) {
                        $paramTags[$mm[2]] = ['type' => $mm[1], 'desc' => trim($mm[3])];
                    }
                } elseif ($t === 'return') {
                    if (preg_match('/^(\S+)\s*(.*)$/', $v, $mm)) {
                        $returnTag = ['type' => $mm[1], 'desc' => trim($mm[2])];
                    }
                } elseif ($t === 'throws') {
                    $throwsTags[] = $v;
                }
            }
            ?>
            <div class="phpdocumentor-method" id="method-<?php echo htmlspecialchars($m->getName()); ?>">
                <h4><?php echo htmlspecialchars($m->getName()); ?>()</h4>
                <div class="phpdocumentor-signature"><?php echo htmlspecialchars(wb_method_signature($m)); ?></div>
                <?php if ($mSummary): ?>
                    <p class="phpdocumentor-summary"><?php echo htmlspecialchars($mSummary); ?></p>
                <?php endif; ?>
                <?php if ($mDescription): ?>
                    <div class="phpdocumentor-description">
                        <?php foreach (preg_split('/\n{2,}/', $mDescription) as $para): ?>
                            <p><?php echo nl2br(htmlspecialchars($para)); ?></p>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <?php $params = $m->getParameters(); if ($params): ?>
                    <div class="phpdocumentor-parameters">
                        <strong>Parameters</strong>
                        <ul class="phpdocumentor-parameters__list">
                            <?php foreach ($params as $p):
                                $type = wb_render_type($p->getType());
                                $tag  = $paramTags['$' . $p->getName()] ?? null;
                                ?>
                                <li class="phpdocumentor-parameters__item">
                                    <?php if ($type !== ''): ?>
                                        <span class="phpdocumentor-parameters__type"><?php echo htmlspecialchars($type); ?></span>
                                    <?php elseif ($tag && $tag['type']): ?>
                                        <span class="phpdocumentor-parameters__type"><?php echo htmlspecialchars($tag['type']); ?></span>
                                    <?php endif; ?>
                                    <span class="phpdocumentor-parameters__name">$<?php echo htmlspecialchars($p->getName()); ?></span>
                                    <?php if ($tag && $tag['desc']): ?>
                                        — <?php echo htmlspecialchars($tag['desc']); ?>
                                    <?php endif; ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <?php
                $returnType = wb_render_type($m->getReturnType());
                if ($returnType !== '' || $returnTag):
                ?>
                    <div class="phpdocumentor-returns">
                        <strong>Returns</strong>
                        <span class="phpdocumentor-returns__type"><?php echo htmlspecialchars($returnType ?: ($returnTag['type'] ?? '')); ?></span>
                        <?php if ($returnTag && $returnTag['desc']): ?>
                            — <?php echo htmlspecialchars($returnTag['desc']); ?>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <?php if ($throwsTags): ?>
                    <dl class="phpdocumentor-tag-list">
                        <?php foreach ($throwsTags as $t): ?>
                            <dt>throws</dt>
                            <dd><code><?php echo htmlspecialchars($t); ?></code></dd>
                        <?php endforeach; ?>
                    </dl>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
        <?php endif; ?>

        <?php
        // -------- Inherited members summary --------
        $inheritedMethods = array_filter($methods, fn ($m) => $m->getDeclaringClass()->getName() !== $reflection->getName());
        if ($inheritedMethods):
        ?>
        <h3 id="inherited">
            Inherited methods <a href="#inherited" class="headerlink">#</a>
        </h3>
        <ul class="phpdocumentor-list-of-elements">
            <?php foreach ($inheritedMethods as $m):
                $declaring = $m->getDeclaringClass()->getName();
                $href = ROOT . 'classes/' . str_replace('\\', '-', $declaring) . '.php#method-' . $m->getName();
                ?>
                <li>
                    <code><?php echo htmlspecialchars($m->getName()); ?>()</code>
                    from <a href="<?php echo htmlspecialchars($href); ?>"><code><?php echo htmlspecialchars($declaring); ?></code></a>
                </li>
            <?php endforeach; ?>
        </ul>
        <?php endif; ?>
    </article>
<?php endif; ?>
<?php
require __DIR__ . '/footer.php';
