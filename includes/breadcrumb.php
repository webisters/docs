<?php
/**
 * Webisters Docs - Breadcrumb
 * Auto-derives breadcrumb segments from $CURRENT_PAGE.
 */
require_once __DIR__ . '/config.php';

$__currentPage = $CURRENT_PAGE ?? '';
if (!$__currentPage || $__currentPage === 'index.php') {
    return;
}

$parts = explode('/', trim($__currentPage, '/'));

// If the page is an index.php inside a directory, drop the trailing "index.php"
// segment so the parent directory becomes the breadcrumb leaf. Without this we
// render the directory and then "index.php" (prettified to the same name),
// producing duplicates like "… / Cache / Cache".
if (!empty($parts) && end($parts) === 'index.php' && count($parts) > 1) {
    array_pop($parts);
}

$count = count($parts);
$segments = [];
$accum = '';

foreach ($parts as $idx => $part) {
    $accum = $accum === '' ? $part : $accum . '/' . $part;
    $isLast = ($idx === $count - 1);

    // Prettify label: strip .php, replace dashes/underscores, title-case.
    $label = preg_replace('/\.php$/', '', $part);
    $label = str_replace(['-', '_'], ' ', $label);
    $label = ucwords($label);

    $special = [
        'Mvc'         => 'MVC',
        'Cli'         => 'CLI',
        'Api'         => 'API',
        'Http'        => 'HTTP',
        'Http Client' => 'HTTP Client',
        'Webisters'   => 'Webisters CLI',
    ];
    if (isset($special[$label])) { $label = $special[$label]; }

    // Build a link for non-leaf segments if there's an index.php at that dir.
    $href = null;
    if (!$isLast) {
        $candidate = realpath(__DIR__ . '/../' . $accum . '/index.php');
        if ($candidate) {
            $href = ROOT . $accum . '/index.php';
        }
    }
    $segments[] = ['label' => $label, 'href' => $href, 'is_last' => $isLast];
}
?>
<nav aria-label="Breadcrumb">
    <ol class="wb-breadcrumb">
        <li><a href="<?php echo ROOT; ?>index.php">Docs</a></li>
        <?php foreach ($segments as $seg): ?>
            <li class="wb-breadcrumb__sep" aria-hidden="true">/</li>
            <?php if ($seg['href'] && !$seg['is_last']): ?>
                <li><a href="<?php echo htmlspecialchars($seg['href']); ?>"><?php echo htmlspecialchars($seg['label']); ?></a></li>
            <?php else: ?>
                <li class="wb-breadcrumb__current"><?php echo htmlspecialchars($seg['label']); ?></li>
            <?php endif; ?>
        <?php endforeach; ?>
    </ol>
</nav>
