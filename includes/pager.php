<?php
/**
 * Webisters Docs - Prev/Next pager.
 * Renders based on $PAGE_ORDER and $PAGE_TITLES from config.php.
 */
require_once __DIR__ . '/config.php';

$__currentPage = $CURRENT_PAGE ?? '';
if (!$__currentPage || !isset($PAGE_ORDER)) {
    return;
}

$idx = array_search($__currentPage, $PAGE_ORDER, true);
if ($idx === false) { return; }

$prev = $idx > 0 ? $PAGE_ORDER[$idx - 1] : null;
$next = $idx < count($PAGE_ORDER) - 1 ? $PAGE_ORDER[$idx + 1] : null;

if (!$prev && !$next) { return; }

$titleFor = function ($p) use ($PAGE_TITLES) {
    return $PAGE_TITLES[$p] ?? ucwords(str_replace(['-', '/', '.php', '_'], [' ', ' › ', '', ' '], $p));
};
?>
<nav class="wb-pager" aria-label="Page navigation">
    <?php if ($prev): ?>
        <a class="wb-pager__link -prev" href="<?php echo ROOT . htmlspecialchars($prev); ?>">
            <span class="wb-pager__label">← Previous</span>
            <span class="wb-pager__title"><?php echo htmlspecialchars($titleFor($prev)); ?></span>
        </a>
    <?php else: ?>
        <span class="wb-pager__placeholder"></span>
    <?php endif; ?>

    <?php if ($next): ?>
        <a class="wb-pager__link -next" href="<?php echo ROOT . htmlspecialchars($next); ?>">
            <span class="wb-pager__label">Next →</span>
            <span class="wb-pager__title"><?php echo htmlspecialchars($titleFor($next)); ?></span>
        </a>
    <?php else: ?>
        <span class="wb-pager__placeholder"></span>
    <?php endif; ?>
</nav>
