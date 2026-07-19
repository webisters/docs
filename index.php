<?php
$pageTitle = 'Webisters Docs — Modern PHP framework';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/sidebar.php';
?>
<section class="wb-hero">
    <span class="wb-hero__eyebrow">Documentation</span>
    <h1>Build modern PHP apps,<br>without the boilerplate.</h1>
    <p class="wb-hero__lead">
        Webisters is a lightweight full-stack PHP framework. Pick a project template,
        plug in only the libraries you need, and ship.
    </p>
    <div class="wb-hero__ctas">
        <a class="wb-btn" href="<?php echo ROOT; ?>guides/webisters/index.php">
            Get started
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="9 18 15 12 9 6"/></svg>
        </a>
        <a class="wb-btn -ghost" href="<?php echo ROOT; ?>guides/framework/index.php">
            Read the docs
        </a>
    </div>
    <div class="wb-hero__install">
        <span class="dollar">$</span>
        <span>composer require webisters/webisters</span>
    </div>
</section>

<div class="wb-section-head">
    <h2>Project templates</h2>
    <a href="<?php echo ROOT; ?>guides/projects/index.php">All projects →</a>
</div>
<p>Start a new project from a curated template. Pick the one that matches your shape of work.</p>
<div class="wb-cards">
    <a class="wb-card" href="<?php echo ROOT; ?>guides/projects/app/index.php">
        <span class="wb-card__icon"><i class="fas fa-layer-group"></i></span>
        <h3 class="wb-card__title">App</h3>
        <p class="wb-card__desc">Full-stack MVC application — controllers, models, views, the works.</p>
    </a>
    <a class="wb-card" href="<?php echo ROOT; ?>guides/projects/api/index.php">
        <span class="wb-card__icon"><i class="fas fa-bolt"></i></span>
        <h3 class="wb-card__title">API</h3>
        <p class="wb-card__desc">MVC tuned for JSON responses — perfect for headless backends and SPAs.</p>
    </a>
    <a class="wb-card" href="<?php echo ROOT; ?>guides/projects/one/index.php">
        <span class="wb-card__icon"><i class="fas fa-file-code"></i></span>
        <h3 class="wb-card__title">One</h3>
        <p class="wb-card__desc">A single-file project — quick APIs and prototypes, all functions in one place.</p>
    </a>
    <a class="wb-card" href="<?php echo ROOT; ?>guides/projects/site/index.php">
        <span class="wb-card__icon"><i class="fas fa-globe"></i></span>
        <h3 class="wb-card__title">Site</h3>
        <p class="wb-card__desc">Static-site template for landing pages, marketing, and content-first builds.</p>
    </a>
</div>

<div class="wb-section-head">
    <h2>Popular libraries</h2>
    <a href="<?php echo ROOT; ?>guides/libraries/mvc/index.php">All libraries →</a>
</div>
<div class="wb-cards">
    <a class="wb-card" href="<?php echo ROOT; ?>guides/libraries/mvc/index.php">
        <span class="wb-card__icon"><i class="fas fa-cubes"></i></span>
        <h3 class="wb-card__title">MVC</h3>
        <p class="wb-card__desc">The kernel — App class, services, controllers, models and views.</p>
    </a>
    <a class="wb-card" href="<?php echo ROOT; ?>guides/libraries/routing/index.php">
        <span class="wb-card__icon"><i class="fas fa-route"></i></span>
        <h3 class="wb-card__title">Routing</h3>
        <p class="wb-card__desc">Expressive, fast HTTP routing with named routes and route groups.</p>
    </a>
    <a class="wb-card" href="<?php echo ROOT; ?>guides/libraries/database/index.php">
        <span class="wb-card__icon"><i class="fas fa-database"></i></span>
        <h3 class="wb-card__title">Database</h3>
        <p class="wb-card__desc">Query builder, prepared statements, and a clean PDO-backed layer.</p>
    </a>
    <a class="wb-card" href="<?php echo ROOT; ?>guides/libraries/http/index.php">
        <span class="wb-card__icon"><i class="fas fa-paper-plane"></i></span>
        <h3 class="wb-card__title">HTTP</h3>
        <p class="wb-card__desc">PSR-style request/response with first-class JSON support.</p>
    </a>
    <a class="wb-card" href="<?php echo ROOT; ?>guides/libraries/validation/index.php">
        <span class="wb-card__icon"><i class="fas fa-check-double"></i></span>
        <h3 class="wb-card__title">Validation</h3>
        <p class="wb-card__desc">Composable rules with friendly error messages.</p>
    </a>
    <a class="wb-card" href="<?php echo ROOT; ?>guides/libraries/cli/index.php">
        <span class="wb-card__icon"><i class="fas fa-terminal"></i></span>
        <h3 class="wb-card__title">CLI</h3>
        <p class="wb-card__desc">Build expressive console commands with input, output, and styling.</p>
    </a>
</div>

<div class="wb-section-head">
    <h2>Packages</h2>
    <a href="<?php echo ROOT; ?>packages/framework.php">Browse all →</a>
</div>
<ul class="wb-pills">
    <?php foreach ($PACKAGES as $pkg): ?>
        <li><a href="<?php echo ROOT; ?>packages/<?php echo htmlspecialchars($pkg); ?>.php"><?php echo htmlspecialchars($pkg); ?></a></li>
    <?php endforeach; ?>
</ul>

<div class="wb-section-head">
    <h2>Why Webisters</h2>
</div>
<div class="wb-cards">
    <div class="wb-card" style="cursor:default">
        <span class="wb-card__icon"><i class="fas fa-feather"></i></span>
        <h3 class="wb-card__title">Lightweight</h3>
        <p class="wb-card__desc">Small surface area, predictable conventions, no magic that surprises you at 2am.</p>
    </div>
    <div class="wb-card" style="cursor:default">
        <span class="wb-card__icon"><i class="fas fa-puzzle-piece"></i></span>
        <h3 class="wb-card__title">Modular</h3>
        <p class="wb-card__desc">Use only the libraries you need. Skip what you don't. Composable from the ground up.</p>
    </div>
    <div class="wb-card" style="cursor:default">
        <span class="wb-card__icon"><i class="fas fa-rocket"></i></span>
        <h3 class="wb-card__title">Fast</h3>
        <p class="wb-card__desc">Preload-friendly, autoloader-tuned, and built for PHP 8+ performance.</p>
    </div>
</div>

<?php
require_once __DIR__ . '/includes/footer.php';
?>
