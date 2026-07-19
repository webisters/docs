<?php
/**
 * Webisters Docs - Sidebar template
 */
require_once __DIR__ . '/config.php';

if (!function_exists('wb_is_active')) {
    function wb_is_active($link, $currentPage) {
        if (!$currentPage) return false;
        $link = ltrim($link, '/');
        $currentPage = ltrim($currentPage, '/');
        return $link === $currentPage;
    }
}

if (!function_exists('wb_renderNavMenu')) {
    function wb_renderNavMenu($items, $currentPage) {
        $output = '';
        foreach ($items as $label => $link) {
            if (is_array($link)) {
                // Determine if any child is active so we can open the group
                $isOpen = false;
                foreach ($link as $subLink) {
                    if (wb_is_active($subLink, $currentPage)) { $isOpen = true; break; }
                }
                $output .= '<div class="wb-group' . ($isOpen ? ' is-open' : '') . '" data-wb-group>';
                $output .= '<div class="wb-group__head" data-wb-group-toggle>';
                $output .= '<span>' . htmlspecialchars($label) . '</span>';
                $output .= '<svg class="wb-group__caret" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="9 18 15 12 9 6"/></svg>';
                $output .= '</div>';
                $output .= '<div class="wb-group__body">';
                $output .= '<ul class="phpdocumentor-list">';
                foreach ($link as $subLabel => $subLink) {
                    $active = wb_is_active($subLink, $currentPage) ? ' is-active' : '';
                    $output .= '<li><a class="' . trim('phpdocumentor-list__item' . $active) . '" href="' . ROOT . htmlspecialchars($subLink) . '">' . htmlspecialchars($subLabel) . '</a></li>';
                }
                $output .= '</ul></div></div>';
            } else {
                $active = wb_is_active($link, $currentPage) ? ' is-active' : '';
                $output .= '<h4 class="phpdocumentor-sidebar__root-namespace">';
                $output .= '<a class="' . trim($active) . '" href="' . ROOT . htmlspecialchars($link) . '">' . htmlspecialchars($label) . '</a>';
                $output .= '</h4>';
            }
        }
        return $output;
    }
}

$__currentPage = $CURRENT_PAGE ?? '';
?>
<aside class="phpdocumentor-column -four phpdocumentor-sidebar" aria-label="Documentation navigation">
    <section class="phpdocumentor-sidebar__category">
        <h2 class="phpdocumentor-sidebar__category-header">Guides</h2>
        <?php echo wb_renderNavMenu($NAVIGATION['Guides'], $__currentPage); ?>
    </section>
    <section class="phpdocumentor-sidebar__category">
        <h2 class="phpdocumentor-sidebar__category-header">Packages</h2>
        <ul class="phpdocumentor-list">
            <?php foreach ($PACKAGES as $pkg):
                $pkgPath = 'packages/' . $pkg . '.php';
                $active = wb_is_active($pkgPath, $__currentPage) ? ' is-active' : ''; ?>
                <li><a class="<?php echo trim($active); ?>" href="<?php echo ROOT; ?>packages/<?php echo htmlspecialchars($pkg); ?>.php"><?php echo htmlspecialchars($pkg); ?></a></li>
            <?php endforeach; ?>
        </ul>
    </section>
</aside>
<div class="phpdocumentor-column -eight phpdocumentor-content">
<?php
// Breadcrumb + page intro slot
require_once __DIR__ . '/breadcrumb.php';
