<?php
/**
 * Webisters Docs - Package overview page (auto-discovered).
 *
 * Renders a phpDocumentor-style package overview by scanning the matching
 * library directory (../../libraries/<slug>/src/) for PHP source files and
 * extracting their namespace, type (class/interface/trait/enum), and short
 * docblock summary.
 *
 * Inputs (set by the caller before including this file):
 *   $packageSlug        – required, e.g. "mvc", "testing", "coding-standard"
 *   $packageTitle       – optional, override the page title (defaults to slug)
 *   $packageLead        – optional, lead paragraph above the class list
 *   $packageGuideUrl    – optional, link rendered when no PHP classes exist
 *                         (e.g. for sass-only or project-template packages)
 *   $packageExtraNotice – optional, additional HTML rendered above the list
 */

if (!isset($packageSlug) || $packageSlug === '') {
    http_response_code(500);
    echo 'package-page.php: $packageSlug is required.';
    return;
}

$pageTitle  = ($packageTitle ?? ucfirst($packageSlug)) . ' · Webisters Docs';
$librariesRoot = realpath(__DIR__ . '/../../libraries');
$srcDir     = $librariesRoot ? $librariesRoot . '/' . $packageSlug . '/src' : null;

// ----- Discover classes -----
$elements = []; // [type => [['fqcn' => ..., 'name' => ..., 'summary' => ...], ...]]

if ($srcDir && is_dir($srcDir)) {
    $iter = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($srcDir, RecursiveDirectoryIterator::SKIP_DOTS)
    );
    foreach ($iter as $file) {
        if (!$file->isFile() || $file->getExtension() !== 'php') { continue; }
        $contents = @file_get_contents($file->getPathname());
        if ($contents === false) { continue; }

        // Extract namespace
        $namespace = '';
        if (preg_match('/^\s*namespace\s+([^;]+);/m', $contents, $nm)) {
            $namespace = trim($nm[1]);
        }
        // Find first declaration with optional preceding docblock
        if (!preg_match('#(/\*\*[^*]*\*+(?:[^/*][^*]*\*+)*/)?\s*(?:abstract\s+|final\s+|readonly\s+)*\s*(class|interface|trait|enum)\s+([A-Za-z_][A-Za-z0-9_]*)#m', $contents, $cm)) {
            continue;
        }
        $docBlock  = $cm[1] ?? '';
        $type      = strtolower($cm[2]);
        $name      = $cm[3];
        $fqcn      = ($namespace !== '' ? $namespace . '\\' : '') . $name;
        $summary   = '';
        if ($docBlock !== '') {
            $body = preg_replace('#^\s*/\*+|\*+/\s*$#', '', $docBlock);
            foreach (preg_split('/\r?\n/', $body) as $line) {
                $line = preg_replace('/^\s*\*\s?/', '', $line);
                $line = trim($line);
                if ($line === '') { continue; }
                if (str_starts_with($line, '@')) { break; }
                $summary = $line;
                break;
            }
        }
        $elements[$type][] = [
            'fqcn'    => $fqcn,
            'name'    => $name,
            'summary' => $summary,
        ];
    }
    foreach ($elements as &$group) {
        usort($group, fn ($a, $b) => strcmp($a['name'], $b['name']));
    }
    unset($group);
}

require_once __DIR__ . '/header.php';
require_once __DIR__ . '/sidebar.php';
?>
<article class="phpdocumentor-element -package">
    <h2 class="phpdocumentor-content__title">
        <?php echo htmlspecialchars($packageTitle ?? $packageSlug); ?>
        <span class="phpdocumentor-element__type">package</span>
    </h2>

    <?php if (!empty($packageLead)): ?>
        <p class="phpdocumentor-summary"><?php echo $packageLead; ?></p>
    <?php endif; ?>

    <?php if (!empty($packageExtraNotice)) echo $packageExtraNotice; ?>

    <?php
    // Render each element group (interfaces first, then classes, traits, enums).
    $groupOrder = ['interface', 'class', 'trait', 'enum'];
    $hasAny = false;
    foreach ($groupOrder as $type) {
        if (empty($elements[$type])) { continue; }
        $hasAny = true;
        $heading = match ($type) {
            'interface' => 'Interfaces',
            'class'     => 'Classes',
            'trait'     => 'Traits',
            'enum'      => 'Enums',
        };
        ?>
        <h3 id="<?php echo $type; ?>s">
            <?php echo $heading; ?>
            <a href="#<?php echo $type; ?>s" class="headerlink">#</a>
        </h3>
        <dl class="phpdocumentor-table-of-contents">
            <?php foreach ($elements[$type] as $el):
                $href = ROOT . 'classes/' . str_replace('\\', '-', $el['fqcn']) . '.php';
                ?>
                <dt class="phpdocumentor-table-of-contents__entry -<?php echo $type; ?>">
                    <a href="<?php echo htmlspecialchars($href); ?>">
                        <abbr title="\<?php echo htmlspecialchars($el['fqcn']); ?>"><?php echo htmlspecialchars($el['name']); ?></abbr>
                    </a>
                </dt>
                <dd><?php echo htmlspecialchars($el['summary'] !== '' ? $el['summary'] : '–'); ?></dd>
            <?php endforeach; ?>
        </dl>
    <?php } ?>

    <?php if (!$hasAny): ?>
        <?php if (!empty($packageGuideUrl)): ?>
            <p>This package doesn't expose PHP classes directly &mdash; see the
            <a href="<?php echo htmlspecialchars($packageGuideUrl); ?>">user guide</a>
            for usage details.</p>
        <?php else: ?>
            <p>No public PHP classes have been published for this package yet.</p>
        <?php endif; ?>
    <?php endif; ?>
</article>

<?php require_once __DIR__ . '/footer.php'; ?>
