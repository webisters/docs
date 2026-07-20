<?php
/**
 * Webisters Docs - Router for the PHP built-in server.
 *
 * Usage:
 *     cd D:\WEBISTERS\docs
 *     php -S localhost:8000 router.php
 *
 * Why: phpDocumentor-generated pages under /classes/, /files/, /namespaces/,
 * and /interfaces/ are standalone HTML/PHP files that do NOT include the
 * Webisters header/sidebar/footer templates. This router transparently:
 *
 *   1. Detects requests for those auto-generated pages
 *   2. Buffers the original page output
 *   3. Extracts just the inner <body> content
 *   4. Re-renders it inside the redesigned chrome (topbar + sidebar + footer)
 *
 * For pages that already include header.php (index.php, guides/*, packages/*),
 * the router falls through to the default file handling and changes nothing.
 */

// What the built-in server sees as the request path
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = ltrim($uri, '/');

// Asset files (css/js/svg/images) -> let the server serve them as-is.
if (preg_match('#\.(css|js|svg|png|jpe?g|gif|ico|woff2?|ttf|eot|map)$#i', $uri)) {
    return false;
}

// If the path maps to a real file inside docs/, serve it (with wrapping if needed).
$target = __DIR__ . '/' . $uri;

// If empty path -> homepage
if ($uri === '' || $uri === '/') {
    require __DIR__ . '/index.php';
    return true;
}

// --- Dynamic class detail page ---
// Any /classes/Foo-Bar.php request renders the Reflection-based template,
// regardless of whether a static file exists at that path.
if (preg_match('#^classes/([^/]+)\.php$#i', $uri, $cm)) {
    $className = str_replace('-', '\\', $cm[1]);
    $_SERVER['WEBISTERS_CLASS']  = $className;
    // Help config.php compute the relative ROOT path correctly.
    $_SERVER['WEBISTERS_TARGET'] = __DIR__ . '/classes/' . $cm[1] . '.php';
    $_SERVER['SCRIPT_NAME']      = '/' . $uri;
    $_SERVER['PHP_SELF']         = '/' . $uri;
    require __DIR__ . '/includes/class-page.php';
    return true;
}

// If path is a directory, append /index.php
if (is_dir($target)) {
    $target = rtrim($target, '/') . '/index.php';
}

// Fallback: if the file doesn't exist, let the server handle (404).
if (!is_file($target)) {
    if (strpos($uri, 'classes') === 0) {
        error_log("ROUTER: Class file NOT FOUND: " . var_export($target, true));
    }
    return false;
}

// Determine if this page is one of the auto-generated phpDocumentor pages.
$autoWrap = preg_match('#^(classes|files|namespaces|interfaces|traits|enums|reports|graphs|markers)/#i', $uri) === 1;

// Store for debugging
$_SERVER['WEBISTERS_DEBUG_AUTO_WRAP'] = $autoWrap ? 'YES' : 'NO';

if (!$autoWrap) {
    // Normal page that already includes header.php/footer.php – serve as-is.
    // Set SCRIPT_FILENAME so config.php calculates ROOT correctly.
    $_SERVER['SCRIPT_FILENAME'] = $target;
    $_SERVER['SCRIPT_NAME']     = '/' . $uri;
    $_SERVER['PHP_SELF']        = '/' . $uri;
    // Store the actual target file for later use by config.php
    $_SERVER['WEBISTERS_TARGET'] = $target;
    
    require $target;
    return true;
}

// --- Auto-wrap phpDocumentor page in the Webisters chrome ---

// CRITICAL: tell config.php (loaded by header.php) that the "current script"
// is the target file, not router.php. Without this, ROOT collapses to "" and
// asset URLs like `assets/override.css` resolve to `/classes/assets/...` (404).
$_SERVER['SCRIPT_FILENAME'] = $target;
$_SERVER['SCRIPT_NAME']     = '/' . $uri;
$_SERVER['PHP_SELF']        = '/' . $uri;

// 1. Capture the original page's output
ob_start();
require $target;
$rawHtml = ob_get_clean();

// 2. Extract page title if present
$pageTitle = 'Webisters Docs';
if (preg_match('#<title>(.*?)</title>#is', $rawHtml, $m)) {
    $pageTitle = trim(strip_tags($m[1]));
    if ($pageTitle === '') { $pageTitle = 'Webisters Docs'; }
}

// 3. Extract just the inner body content (between <body> and </body>).
//    Fall back to the full doc if we can't find a body tag.
if (preg_match('#<body[^>]*>(.*?)</body>#is', $rawHtml, $m)) {
    $bodyHtml = $m[1];
} else {
    $bodyHtml = $rawHtml;
}

// 4. Strip any legacy phpDocumentor header / topnav / footer / sidebar / search
//    panels embedded in the raw output, since we provide our own chrome.
$bodyHtml = preg_replace('#<header[^>]*phpdocumentor-header[^>]*>.*?</header>#is', '', $bodyHtml);
$bodyHtml = preg_replace('#<aside[^>]*phpdocumentor-sidebar[^>]*>.*?</aside>#is', '', $bodyHtml);
$bodyHtml = preg_replace('#<nav[^>]*phpdocumentor-topnav[^>]*>.*?</nav>#is', '', $bodyHtml);
$bodyHtml = preg_replace('#<footer[^>]*phpdocumentor-footer[^>]*>.*?</footer>#is', '', $bodyHtml);
$bodyHtml = preg_replace('#<section[^>]*data-search-results[^>]*>.*?</section>#is', '', $bodyHtml);
$bodyHtml = preg_replace('#<input[^>]*phpdocumentor-sidebar__menu-button[^>]*>#is', '', $bodyHtml);
$bodyHtml = preg_replace('#<label[^>]*phpdocumentor-sidebar__menu-icon[^>]*>.*?</label>#is', '', $bodyHtml);
$bodyHtml = preg_replace('#<a[^>]*phpdocumentor-back-to-top[^>]*>.*?</a>#is', '', $bodyHtml);

// 5. Drop the outer <main class="phpdocumentor"> and <div class="phpdocumentor-section">
//    so we can re-render them through the wrapper.
$bodyHtml = preg_replace('#</?main[^>]*>#i', '', $bodyHtml);
$bodyHtml = preg_replace('#<div[^>]*phpdocumentor-section[^>]*>#i', '', $bodyHtml);
// Closing div for section is harder to target; let it stand – it's harmless.

// 6. Render with the Webisters chrome.
//    Pass the target file path to config.php via $_SERVER,
//    so it calculates ROOT correctly based on the actual page being rendered.
$_SERVER['SCRIPT_FILENAME'] = $target;
$_SERVER['SCRIPT_NAME']     = '/' . $uri;
$_SERVER['PHP_SELF']        = '/' . $uri;
// Store the actual target file for later use by config.php
$_SERVER['WEBISTERS_TARGET'] = $target;

if (strpos($uri, 'classes') === 0) {
    error_log("ROUTER: About to load header for class page");
    error_log("  target: " . var_export($target, true));
    error_log("  WEBISTERS_TARGET: " . var_export($_SERVER['WEBISTERS_TARGET'], true));
}

$CURRENT_PAGE = $uri;
require __DIR__ . '/includes/header.php';
require __DIR__ . '/includes/sidebar.php';

echo $bodyHtml;

require __DIR__ . '/includes/footer.php';

return true;
