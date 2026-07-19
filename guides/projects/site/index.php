<?php
$pageTitle = 'Webisters Docs';
require_once __DIR__ . '/../../../includes/header.php';
require_once __DIR__ . '/../../../includes/sidebar.php';
?>
<div class="section" id="site">
                <h1>Site</h1>
                <p>Webisters Site Project.</p>
                <ul>
                    <li><a href="#installation">Installation</a></li>
                    <li><a href="#structure">Structure</a></li>
                </ul>
                <div class="section" id="installation">
                    <h2>Installation</h2>
                    <p>The installation of this project can be done with Composer:</p>
                    <pre><code class="language- " >composer create-project webisters/site site</code></pre>
                    <p>Or, using the Webisters CLI:</p>
                    <pre><code class="language- " >composer global require webisters/webisters
composer global exec webisters setup
webisters new-site site
# If `webisters` is not on PATH yet:
# composer global exec webisters new-site site
cd site
composer install</code></pre>
                </div>
                <div class="section" id="structure">
                    <h2>Structure</h2>
                    <p>This is the basic directory tree:</p>
                    <pre><code class="language- " >.
├── .gitignore
├── composer.json
├── composer.local.json
├── public/
│   ├── css/
│   │   └── style.css
│   ├── favicon.ico
│   ├── index.html
│   ├── index.php
│   ├── webisters-light.png
│   └── webisters.png
├── README.md
├── storage/
├── vendor/
└── webisters
</code></pre>
                </div>
            </div>
<?php
require_once __DIR__ . '/../../../includes/footer.php';
?>
