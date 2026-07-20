<?php
$pageTitle = 'Projects · Webisters Docs';
require_once __DIR__ . '/../../includes/header.php';
require_once __DIR__ . '/../../includes/sidebar.php';

$projects = [
    ['app',      'App',      'layer-group', 'Full-stack MVC application – controllers, models, views, the works.', 'webisters/app',  'new-app'],
    ['api',      'API',      'bolt',        'MVC tuned for JSON responses – perfect for headless backends and SPAs.', 'webisters/api',  'new-api'],
    ['one',      'One',      'file-code',   'A single-file project – quick APIs and prototypes, all functions in one place.', 'webisters/one',  'new-one'],
    ['site',     'Site',     'globe',       'Static-site template for landing pages, marketing and content-first builds.',  'webisters/site', 'new-site'],
    ['template', 'Template', 'shapes',      'Shared view-template engine used by every Webisters project.',           'webisters/template', null],
];
?>
<div class="section" id="projects">
    <h1>Projects</h1>
    <p>Webisters ships four ready-to-use project templates plus a shared
    template engine. Pick the shape that matches your build – every template
    sits on top of the same library set, so you can swap or grow into another
    as your project evolves.</p>

    <div class="wb-cards">
        <?php foreach ($projects as [$slug, $title, $icon, $desc, $pkg, $cli]): ?>
            <a class="wb-card" href="<?php echo ROOT; ?>guides/projects/<?php echo htmlspecialchars($slug); ?>/index.php">
                <span class="wb-card__icon"><i class="fas fa-<?php echo htmlspecialchars($icon); ?>"></i></span>
                <h3 class="wb-card__title"><?php echo htmlspecialchars($title); ?></h3>
                <p class="wb-card__desc"><?php echo htmlspecialchars($desc); ?></p>
            </a>
        <?php endforeach; ?>
    </div>

    <h2 id="installation">Installation</h2>
    <p>Install any template directly with Composer's <code>create-project</code>:</p>
    <pre><code class="language-bash">composer create-project webisters/app app
composer create-project webisters/api api
composer create-project webisters/one one
composer create-project webisters/site site</code></pre>

    <p>Or, if you've installed the Webisters CLI globally, scaffold a project with one command:</p>
    <pre><code class="language-bash">composer global require webisters/webisters
composer global exec webisters setup

webisters new-app my-app
webisters new-api my-api
webisters new-one my-one
webisters new-site my-site</code></pre>

    <p>If the <code>webisters</code> binary isn't on your <code>PATH</code> yet, use Composer's fallback:</p>
    <pre><code class="language-bash">composer global exec webisters new-app my-app</code></pre>

    <p>Then install dependencies inside the new project:</p>
    <pre><code class="language-bash">cd my-app
composer install</code></pre>

    <h2 id="comparison">Picking a template</h2>
    <p>Not sure which one to start with? A short cheat-sheet:</p>
    <ul>
        <li><strong>App</strong> – start here for a typical web app with pages, forms, sessions and a database.</li>
        <li><strong>API</strong> – pick this for a JSON-only backend powering a SPA or mobile client.</li>
        <li><strong>One</strong> – perfect for a tiny service, a prototype, or a single endpoint you want in one file.</li>
        <li><strong>Site</strong> – content-driven sites without a database: marketing pages, documentation, landing pages.</li>
    </ul>
</div>
<?php
require_once __DIR__ . '/../../includes/footer.php';
?>
