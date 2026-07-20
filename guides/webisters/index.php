<?php
$pageTitle = 'Webisters Docs';
require_once __DIR__ . '/../../includes/header.php';
require_once __DIR__ . '/../../includes/sidebar.php';
?>
<div class="section" id="Webisters">
<h1>Webisters</h1>
<p>Webisters Command Line Tool.</p>
<ul>
    <li>
            <a href="#requirements">Requirements</a>
        </li>
    <li>
            <a href="#installation">Installation</a>
        </li>
</ul>
<div class="section" id="requirements">
<h2>Requirements</h2>
<p>Before installing, make sure your environment meets these requirements. Missing PHP extensions are the most common cause of install failures, such as <code>Failed to download ... skipping</code> messages or Composer repeatedly reporting that an extension is not enabled.</p>
<ul>
    <li>PHP <code>&gt;=8.2</code></li>
    <li>Composer 2.x</li>
</ul>
<h3>Required PHP extensions</h3>
<p>Enable these before running <code>composer global require webisters/webisters</code> or any <code>webisters new-*</code> command:</p>
<ul>
    <li><code>intl</code>, <code>sodium</code>, <code>gd</code>, <code>mysqli</code>, <code>curl</code>, <code>fileinfo</code>, <code>json</code>, <code>simplexml</code>, <code>dom</code>, <code>libxml</code> - required by the framework libraries at runtime.</li>
    <li><code>zip</code>, <code>openssl</code> - required by Composer itself to download and extract packages. Without <code>zip</code>, Composer falls back to slow source downloads and may show <code>Failed to download ... skipping</code>; without <code>openssl</code> it cannot fetch packages over HTTPS.</li>
</ul>
<h3>Enable the extensions</h3>
<p>Windows: locate your <code>php.ini</code> with <code>php --ini</code>, uncomment the matching lines, then restart your terminal:</p>
<pre><code class="language- " >extension=intl
extension=sodium
extension=gd
extension=mysqli
extension=curl
extension=fileinfo
extension=openssl
extension=zip</code></pre>
<p>Ubuntu/Debian:</p>
<pre><code class="language- " >sudo apt update
sudo apt install php-intl php-sodium php-gd php-mysqli php-curl php-zip
# json, fileinfo, openssl, dom, and simplexml ship with most PHP builds</code></pre>
<p>Confirm everything is enabled (the list should include the extensions above):</p>
<pre><code class="language- " >php -m</code></pre>
</div>
<div class="section" id="installation">
<h2>Installation</h2>
<p>The installation of this package can be done with Composer:</p>
<pre><code class="language- " >composer global require webisters/webisters</code></pre>
<p>Windows (recommended): add Composer&#039;s global bin directory to your user PATH:</p>
<pre><code class="language- " >composer global exec webisters setup</code></pre>
<p>Create a project:</p>
<pre><code class="language- " >webisters new-app my-app
# No-PATH fallback:
composer global exec webisters new-app my-app</code></pre>
</div>
                <section data-search-results class="phpdocumentor-search-results phpdocumentor-search-results--hidden">
    <section class="phpdocumentor-search-results__dialog">
        <header class="phpdocumentor-search-results__header">
            <h2 class="phpdocumentor-search-results__title">Search results</h2>
            <button class="phpdocumentor-search-results__close"><i class="fas fa-times"></i></button>
        </header>
        <section class="phpdocumentor-search-results__body">
            <ul class="phpdocumentor-search-results__entries"></ul>
        </section>
    </section>
</section>
<?php
require_once __DIR__ . '/../../includes/footer.php';
?>
