<?php
$pageTitle = 'Webisters Docs';
require_once __DIR__ . '/../../../includes/header.php';
require_once __DIR__ . '/../../../includes/sidebar.php';
?>
<div class="section" id="api">
    <h1>API</h1>
    <p>Webisters API Project.</p>
    <ul>
        <li><a href="#installation">Installation</a></li>
        <li><a href="#structure">Structure</a></li>
    </ul>
    <div class="section" id="installation">
        <h2>Installation</h2>
        <p>The installation of this project can be done with Composer:</p>
        <pre><code class="language- " >composer create-project webisters/api api</code></pre>
        <p>Or, using the Webisters CLI:</p>
        <pre><code class="language- " >composer global require webisters/webisters
composer global exec webisters setup
webisters new-api api
# If `webisters` is not on PATH yet:
# composer global exec webisters new-api api
cd api
composer install</code></pre>
    </div>
    <div class="section" id="structure">
        <h2>Structure</h2>
        <p>This is the basic directory tree:</p>
        <pre><code class="language- " >.
├── .editorconfig
├── .env.php
├── .gitignore
├── .php-cs-fixer.dist.php
├── App.php
├── app/
│   ├── Controllers/
│   ├── Languages/
│   └── Models/
├── boot/
│   ├── app.php
│   ├── constants.php
│   ├── helpers.php
│   ├── init.php
│   └── routes.php
├── composer.json
├── composer.local.json
├── config/
├── phpdoc.dist.xml
├── phpunit.xml.dist
├── preload.php
├── public/
│   └── index.php
├── README.md
├── SECURITY.md
├── storage/
├── tests/
├── vendor/
└── webisters
</code></pre>
    </div>
</div>
<?php
require_once __DIR__ . '/../../../includes/footer.php';
?>