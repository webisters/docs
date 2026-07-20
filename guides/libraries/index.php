<?php
$pageTitle = 'Libraries · Webisters Docs';
require_once __DIR__ . '/../../includes/header.php';
require_once __DIR__ . '/../../includes/sidebar.php';

// One curated card per library: title, short description, FontAwesome icon.
$libraries = [
    ['mvc',             'MVC',              'cubes',            'The kernel - App class, services, controllers, models and views.'],
    ['routing',         'Routing',          'route',            'Expressive, fast HTTP routing with named routes and route groups.'],
    ['http',            'HTTP',             'paper-plane',      'PSR-style request/response with first-class JSON support.'],
    ['http-client',     'HTTP Client',      'paper-plane',      'Fluent client for making outbound HTTP requests.'],
    ['database',        'Database',         'database',         'Query builder, prepared statements, and a clean PDO-backed layer.'],
    ['database-extra',  'Database Extra',   'database',         'Migrations, schema management and seed helpers.'],
    ['session',         'Session',          'fingerprint',      'Session management with pluggable storage drivers.'],
    ['validation',      'Validation',       'check-double',     'Composable rules with friendly error messages.'],
    ['cache',           'Cache',            'bolt',             'Cache abstraction with file, Redis and Memcached drivers.'],
    ['config',          'Config',           'sliders',          'Strongly-typed configuration loader.'],
    ['events',          'Events',           'satellite-dish',   'Event dispatcher with listeners and subscribers.'],
    ['log',             'Log',              'file-lines',       'PSR-3 logger with multi-file and stream handlers.'],
    ['debug',           'Debug',            'bug',              'Debug toolbar, exception handler and runtime collectors.'],
    ['email',           'Email',            'envelope',         'Compose and deliver email via SMTP or sendmail.'],
    ['language',        'Language',         'language',         'i18n &mdash; localized messages with negotiation.'],
    ['date',            'Date',             'calendar-days',    'Immutable date and time helpers.'],
    ['crypto',          'Crypto',           'lock',             'Hashing, encryption and signed-token helpers.'],
    ['image',           'Image',            'image',            'Image manipulation, resizing and watermarking.'],
    ['helpers',         'Helpers',          'wrench',            'Small utility helpers used across the framework.'],
    ['factories',       'Factories',        'industry',         'Object factories for fixtures and seeding.'],
    ['pagination',      'Pagination',       'list-ol',          'Generate paginated listings with built-in views.'],
    ['cli',             'CLI',              'terminal',         'Build expressive console commands with input and output styling.'],
    ['dev-commands',    'Dev Commands',     'terminal',         'Migrations, route listing and dev-time CLI commands.'],
    ['autoload',        'Autoload',         'circle-nodes',     'PSR-4 autoloader the framework ships on top of.'],
    ['coding-standard', 'Coding Standard',  'check',            'Shared PHP CS Fixer rule set for Webisters code.'],
    ['minify',          'Minify',           'compress',         'HTML, CSS and JavaScript minifier for production responses.'],
    ['front',           'Front',            'palette',          'Shared front-end assets: Sass partials, compiler and views.'],
    ['testing',         'Testing',          'flask',            'PHPUnit base classes and HTTP/CLI constraints.'],
];
?>
<div class="section" id="libraries">
    <h1>Libraries</h1>
    <p>Webisters ships as a set of small, focused PHP libraries.
    Pull in the ones you need, ignore the rest. Every library is also documented
    as a Composer <a href="<?php echo ROOT; ?>packages/framework.php">package</a>.</p>

    <div class="wb-section-head">
        <h2>Core</h2>
    </div>
    <div class="wb-cards">
        <?php foreach (array_slice($libraries, 0, 8) as [$slug, $title, $icon, $desc]): ?>
            <a class="wb-card" href="<?php echo ROOT; ?>guides/libraries/<?php echo htmlspecialchars($slug); ?>/index.php">
                <span class="wb-card__icon"><i class="fas fa-<?php echo htmlspecialchars($icon); ?>"></i></span>
                <h3 class="wb-card__title"><?php echo htmlspecialchars($title); ?></h3>
                <p class="wb-card__desc"><?php echo $desc; ?></p>
            </a>
        <?php endforeach; ?>
    </div>

    <div class="wb-section-head">
        <h2>Application services</h2>
    </div>
    <div class="wb-cards">
        <?php foreach (array_slice($libraries, 8, 12) as [$slug, $title, $icon, $desc]): ?>
            <a class="wb-card" href="<?php echo ROOT; ?>guides/libraries/<?php echo htmlspecialchars($slug); ?>/index.php">
                <span class="wb-card__icon"><i class="fas fa-<?php echo htmlspecialchars($icon); ?>"></i></span>
                <h3 class="wb-card__title"><?php echo htmlspecialchars($title); ?></h3>
                <p class="wb-card__desc"><?php echo $desc; ?></p>
            </a>
        <?php endforeach; ?>
    </div>

    <div class="wb-section-head">
        <h2>CLI &amp; tooling</h2>
    </div>
    <div class="wb-cards">
        <?php foreach (array_slice($libraries, 20) as [$slug, $title, $icon, $desc]): ?>
            <a class="wb-card" href="<?php echo ROOT; ?>guides/libraries/<?php echo htmlspecialchars($slug); ?>/index.php">
                <span class="wb-card__icon"><i class="fas fa-<?php echo htmlspecialchars($icon); ?>"></i></span>
                <h3 class="wb-card__title"><?php echo htmlspecialchars($title); ?></h3>
                <p class="wb-card__desc"><?php echo $desc; ?></p>
            </a>
        <?php endforeach; ?>
    </div>

    <h2 id="installation">Installing a single library</h2>
    <p>Each library is independently installable via Composer:</p>
    <pre><code class="language-bash">composer require webisters/mvc
composer require webisters/routing
composer require webisters/database</code></pre>
    <p>Or install the complete framework bundle to get them all at once:</p>
    <pre><code class="language-bash">composer require webisters/framework</code></pre>
</div>
<?php
require_once __DIR__ . '/../../includes/footer.php';
?>
