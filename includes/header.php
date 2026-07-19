<?php
/**
 * Webisters Docs - Header template
 */
require_once __DIR__ . '/config.php';

// Auto-derive the current page's relative URL for active-state matching in the sidebar.
if (!isset($CURRENT_PAGE)) {
    $docsRoot = realpath(__DIR__ . '/..');
    $script = realpath($_SERVER['SCRIPT_FILENAME'] ?? '');
    $CURRENT_PAGE = '';
    if ($docsRoot && $script && strpos($script, $docsRoot) === 0) {
        $CURRENT_PAGE = ltrim(str_replace('\\', '/', substr($script, strlen($docsRoot))), '/');
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?php echo htmlspecialchars($pageTitle ?? 'Webisters Docs'); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#0052ff">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="<?php echo ASSETS; ?>override.css">
</head>
<body id="top"
      data-webisters-root="<?php echo ROOT; ?>"
      data-current-page="<?php echo htmlspecialchars($CURRENT_PAGE); ?>">

    <header class="wb-topbar" role="banner">
        <div class="wb-topbar__inner">
            <button class="wb-icon-btn wb-menu-toggle" type="button" aria-label="Toggle navigation" data-wb-menu>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                     stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <line x1="3" y1="6" x2="21" y2="6"/>
                    <line x1="3" y1="12" x2="21" y2="12"/>
                    <line x1="3" y1="18" x2="21" y2="18"/>
                </svg>
            </button>

            <a class="wb-brand" href="<?php echo ROOT; ?>index.php">
                <span class="wb-brand__logo" aria-hidden="true"><img src="<?php echo ASSETS; ?>logo.svg" alt="" width="36" height="36"></span>
                <span class="wb-brand__name">Docs</span>
            </a>

            <div class="wb-topbar__spacer"></div>

            <div class="wb-search" data-wb-search>
                <svg class="wb-search__icon" width="16" height="16" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2"
                     stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <circle cx="11" cy="11" r="7"/>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
                <input type="search"
                       class="wb-search__field"
                       placeholder="Search the docs…"
                       autocomplete="off"
                       spellcheck="false"
                       aria-label="Search the docs"
                       data-wb-search-input>
                <kbd class="wb-search__kbd">⌘K</kbd>
                <div class="wb-search__results" data-wb-search-results role="listbox"></div>
            </div>

            <nav class="wb-nav" aria-label="Primary">
                <a class="wb-nav__link" href="<?php echo ROOT; ?>guides/framework/index.php">Framework</a>
                <a class="wb-nav__link" href="<?php echo ROOT; ?>guides/libraries/index.php">Libraries</a>
                <a class="wb-nav__link" href="<?php echo ROOT; ?>guides/projects/index.php">Projects</a>
                <a class="wb-nav__link" href="<?php echo ROOT; ?>contributors.php">Contributors</a>
            </nav>

            <a class="wb-icon-btn" href="https://github.com/webisters" aria-label="GitHub" target="_blank" rel="noopener">
                <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                    <path d="M12 .5C5.65.5.5 5.65.5 12c0 5.08 3.29 9.39 7.86 10.91.58.11.79-.25.79-.56 0-.27-.01-1-.02-1.96-3.2.69-3.88-1.54-3.88-1.54-.52-1.33-1.27-1.69-1.27-1.69-1.04-.71.08-.7.08-.7 1.15.08 1.76 1.18 1.76 1.18 1.02 1.75 2.68 1.24 3.34.95.1-.74.4-1.24.73-1.53-2.55-.29-5.24-1.28-5.24-5.69 0-1.26.45-2.29 1.19-3.1-.12-.29-.51-1.46.11-3.04 0 0 .97-.31 3.18 1.18a11.05 11.05 0 0 1 5.79 0c2.2-1.49 3.17-1.18 3.17-1.18.62 1.58.23 2.75.12 3.04.74.81 1.18 1.84 1.18 3.1 0 4.42-2.69 5.39-5.26 5.68.41.36.77 1.06.77 2.15 0 1.56-.01 2.81-.01 3.19 0 .31.21.68.8.56 4.56-1.53 7.85-5.83 7.85-10.91C23.5 5.65 18.35.5 12 .5z"/>
                </svg>
            </a>
        </div>
    </header>

    <main class="phpdocumentor" role="main">
        <div class="phpdocumentor-section">
