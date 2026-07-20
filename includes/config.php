<?php
/**
 * Webisters Docs - Core configuration
 * Defines:
 *   - ROOT / ASSETS paths
 *   - $NAVIGATION  : sidebar structure
 *   - $PACKAGES    : package list
 *   - $PAGE_ORDER  : ordered sequence of pages for prev/next nav
 *   - $PAGE_TITLES : friendly titles keyed by relative page path
 */

// Detect page depth and calculate root path
function calculateRootPath() {
    // Try multiple approaches to determine the current page depth
    
    // Approach 1: Use WEBISTERS_TARGET if provided by router
    $scriptPath = $_SERVER['WEBISTERS_TARGET'] ?? null;
    
    // Approach 2: Fall back to deriving from REQUEST_URI (the URL path)
    if (!$scriptPath) {
        $uri = parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH);
        $uri = ltrim($uri, '/');
        // If it's a recognized document path, calculate depth from that
        if ($uri && $uri !== '/') {
            // Count the number of "/" characters to determine depth
            $slashCount = substr_count($uri, '/');
            // For a URL like /classes/Framework-Config.php, slashCount=1, depth=1, ROOT='../'
            // For a URL like /guides/libraries/mvc/index.php, slashCount=3, depth=3, ROOT='../../../'
            $depth = $slashCount + 1; // +1 because we're one level below each directory
            return str_repeat('../', $depth);
        }
        $scriptPath = $_SERVER['SCRIPT_FILENAME'] ?? __FILE__;
    }
    
    $docsRoot = dirname(dirname(__FILE__)); // docs/ directory
    $currentDir = dirname($scriptPath);
    $relPath = str_replace($docsRoot, '', $currentDir);
    $relPath = str_replace('\\', '/', $relPath);
    $depth = max(0, substr_count(rtrim($relPath, '/'), '/'));
    
    return str_repeat('../', $depth);
}

$ROOT_PATH = calculateRootPath();
$ASSETS_PATH = $ROOT_PATH . 'assets/';

define('ROOT', $ROOT_PATH);
define('ASSETS', $ASSETS_PATH);

// Navigation structure
$NAVIGATION = [
    'Guides' => [
        'Webisters CLI' => 'guides/webisters/index.php',
        'Framework'     => 'guides/framework/index.php',
        'Projects' => [
            'Overview' => 'guides/projects/index.php',
            'App'      => 'guides/projects/app/index.php',
            'API'      => 'guides/projects/api/index.php',
            'One'      => 'guides/projects/one/index.php',
            'Site'     => 'guides/projects/site/index.php',
            'Template' => 'guides/projects/template/index.php',
        ],
        'Libraries' => [
            'Overview'         => 'guides/libraries/index.php',
            'Autoload'         => 'guides/libraries/autoload/index.php',
            'Cache'            => 'guides/libraries/cache/index.php',
            'CLI'              => 'guides/libraries/cli/index.php',
            'Coding Standard'  => 'guides/libraries/coding-standard/index.php',
            'Config'           => 'guides/libraries/config/index.php',
            'Crypto'           => 'guides/libraries/crypto/index.php',
            'Database'         => 'guides/libraries/database/index.php',
            'Database Extra'   => 'guides/libraries/database-extra/index.php',
            'Date'             => 'guides/libraries/date/index.php',
            'Debug'            => 'guides/libraries/debug/index.php',
            'Dev Commands'     => 'guides/libraries/dev-commands/index.php',
            'Email'            => 'guides/libraries/email/index.php',
            'Events'           => 'guides/libraries/events/index.php',
            'Factories'        => 'guides/libraries/factories/index.php',
            'Front'            => 'guides/libraries/front/index.php',
            'Helpers'          => 'guides/libraries/helpers/index.php',
            'HTTP'             => 'guides/libraries/http/index.php',
            'HTTP Client'      => 'guides/libraries/http-client/index.php',
            'Image'            => 'guides/libraries/image/index.php',
            'Language'         => 'guides/libraries/language/index.php',
            'Log'              => 'guides/libraries/log/index.php',
            'Minify'           => 'guides/libraries/minify/index.php',
            'MVC'              => 'guides/libraries/mvc/index.php',
            'Pagination'       => 'guides/libraries/pagination/index.php',
            'Routing'          => 'guides/libraries/routing/index.php',
            'Session'          => 'guides/libraries/session/index.php',
            'Testing'          => 'guides/libraries/testing/index.php',
            'Validation'       => 'guides/libraries/validation/index.php',
        ],
    ],
];

$PACKAGES = [
    'framework', 'app', 'api', 'autoload', 'cache', 'cli', 'coding-standard',
    'config', 'crypto', 'database', 'database-extra', 'date', 'debug',
    'dev-commands', 'email', 'events', 'factories', 'front', 'helpers', 'http',
    'http-client', 'image', 'language', 'log', 'minify', 'mvc', 'one',
    'pagination', 'routing', 'session', 'site', 'template', 'testing',
    'validation',
];

/**
 * Ordered reading sequence – drives the prev/next pager at the bottom of every
 * page. Order: intro → CLI → framework → projects → libraries (alphabetical).
 */
$PAGE_ORDER = [
    'index.php',
    'guides/webisters/index.php',
    'guides/framework/index.php',
    'guides/projects/index.php',
    'guides/projects/app/index.php',
    'guides/projects/api/index.php',
    'guides/projects/one/index.php',
    'guides/projects/site/index.php',
    'guides/projects/template/index.php',
    'guides/libraries/index.php',
    'guides/libraries/autoload/index.php',
    'guides/libraries/cache/index.php',
    'guides/libraries/cli/index.php',
    'guides/libraries/coding-standard/index.php',
    'guides/libraries/config/index.php',
    'guides/libraries/crypto/index.php',
    'guides/libraries/database/index.php',
    'guides/libraries/database-extra/index.php',
    'guides/libraries/date/index.php',
    'guides/libraries/debug/index.php',
    'guides/libraries/dev-commands/index.php',
    'guides/libraries/email/index.php',
    'guides/libraries/events/index.php',
    'guides/libraries/factories/index.php',
    'guides/libraries/front/index.php',
    'guides/libraries/helpers/index.php',
    'guides/libraries/http/index.php',
    'guides/libraries/http-client/index.php',
    'guides/libraries/image/index.php',
    'guides/libraries/language/index.php',
    'guides/libraries/log/index.php',
    'guides/libraries/minify/index.php',
    'guides/libraries/mvc/index.php',
    'guides/libraries/pagination/index.php',
    'guides/libraries/routing/index.php',
    'guides/libraries/session/index.php',
    'guides/libraries/testing/index.php',
    'guides/libraries/validation/index.php',
];

$PAGE_TITLES = [
    'index.php'                                 => 'Introduction',
    'contributors.php'                          => 'Contributors',
    'guides/webisters/index.php'                => 'Webisters CLI',
    'guides/framework/index.php'                => 'Framework',
    'guides/projects/index.php'                 => 'Projects Overview',
    'guides/projects/app/index.php'             => 'App Project',
    'guides/projects/api/index.php'             => 'API Project',
    'guides/projects/one/index.php'             => 'One Project',
    'guides/projects/site/index.php'            => 'Site Project',
    'guides/projects/template/index.php'        => 'Template',
    'guides/libraries/index.php'                => 'Libraries Overview',
    'guides/libraries/autoload/index.php'       => 'Autoload',
    'guides/libraries/cache/index.php'          => 'Cache',
    'guides/libraries/cli/index.php'            => 'CLI',
    'guides/libraries/coding-standard/index.php'=> 'Coding Standard',
    'guides/libraries/config/index.php'         => 'Config',
    'guides/libraries/crypto/index.php'         => 'Crypto',
    'guides/libraries/database/index.php'       => 'Database',
    'guides/libraries/database-extra/index.php' => 'Database Extra',
    'guides/libraries/date/index.php'           => 'Date',
    'guides/libraries/debug/index.php'          => 'Debug',
    'guides/libraries/dev-commands/index.php'   => 'Dev Commands',
    'guides/libraries/email/index.php'          => 'Email',
    'guides/libraries/events/index.php'         => 'Events',
    'guides/libraries/factories/index.php'      => 'Factories',
    'guides/libraries/front/index.php'          => 'Front',
    'guides/libraries/helpers/index.php'        => 'Helpers',
    'guides/libraries/http/index.php'           => 'HTTP',
    'guides/libraries/http-client/index.php'    => 'HTTP Client',
    'guides/libraries/image/index.php'          => 'Image',
    'guides/libraries/language/index.php'       => 'Language',
    'guides/libraries/log/index.php'            => 'Log',
    'guides/libraries/minify/index.php'         => 'Minify',
    'guides/libraries/mvc/index.php'            => 'MVC',
    'guides/libraries/pagination/index.php'     => 'Pagination',
    'guides/libraries/routing/index.php'        => 'Routing',
    'guides/libraries/session/index.php'        => 'Session',
    'guides/libraries/testing/index.php'        => 'Testing',
    'guides/libraries/validation/index.php'     => 'Validation',
];
