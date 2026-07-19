<?php
$pageTitle = 'Coding Standard · Webisters Docs';
require_once __DIR__ . '/../../../includes/header.php';
require_once __DIR__ . '/../../../includes/sidebar.php';
?>
<div class="section" id="coding-standard">
<h1>Coding Standard</h1>
<p>Webisters Coding Standard is the shared PHP-CS-Fixer rule set used across every Webisters library and project. Drop it in once and your codebase formats consistently with the rest of the ecosystem.</p>
<ul>
    <li><a href="#installation">Installation</a></li>
    <li><a href="#configure-your-project">Configure your project</a></li>
    <li><a href="#running-the-fixer">Running the fixer</a></li>
    <li><a href="#what-it-enforces">What it enforces</a></li>
    <li><a href="#editor-integration">Editor integration</a></li>
    <li><a href="#conclusion">Conclusion</a></li>
</ul>

<div class="section" id="installation">
<h2>Installation</h2>
<pre><code class="language-bash">composer require --dev webisters/coding-standard</code></pre>
<p>This pulls in <code>friendsofphp/php-cs-fixer</code> as a transitive dependency.</p>
</div>

<div class="section" id="configure-your-project">
<h2>Configure your project</h2>
<p>Create a <code>.php-cs-fixer.dist.php</code> at the root of your project and use the helpers provided by this library:</p>
<pre><code class="language-php">&lt;?php
use Framework\CodingStandard\Config;
use Framework\CodingStandard\Finder;

return Config::create()
    -&gt;setFinder(Finder::create()-&gt;in([__DIR__ . '/src', __DIR__ . '/tests']));</code></pre>
<p><code>Config::create()</code> returns a pre-configured <code>PhpCsFixer\Config</code> with the Webisters rule set already applied. <code>Finder::create()</code> returns a <code>PhpCsFixer\Finder</code> with sensible exclusions for <code>vendor</code>, <code>build</code>, and similar directories.</p>
</div>

<div class="section" id="running-the-fixer">
<h2>Running the fixer</h2>
<p>Format your code in place:</p>
<pre><code class="language-bash">vendor/bin/php-cs-fixer fix</code></pre>
<p>Or dry-run to see what would change without writing files:</p>
<pre><code class="language-bash">vendor/bin/php-cs-fixer fix --dry-run --diff</code></pre>
<p>Use the dry-run in CI to fail the build when style drifts.</p>
</div>

<div class="section" id="what-it-enforces">
<h2>What it enforces</h2>
<p>The rule set is built on top of the PSR-12 base with stricter additions:</p>
<ul>
    <li>Declare strict types and namespace ordering on every file.</li>
    <li>Short array syntax, trailing commas in multi-line arrays.</li>
    <li>Single-quoted strings unless interpolation is needed.</li>
    <li>Ordered imports, no unused imports, no leading slash on use statements.</li>
    <li>PHPDoc alignment and removal of redundant tags.</li>
    <li>Modern PHP 8 features encouraged (named arguments, constructor promotion, match).</li>
</ul>
</div>

<div class="section" id="editor-integration">
<h2>Editor integration</h2>
<p>PhpStorm, VS Code (via the <em>PHP CS Fixer</em> extension), and Vim all support running the fixer on save. Point them at your project's <code>.php-cs-fixer.dist.php</code> and they'll pick up the Webisters rule set automatically.</p>
</div>

<div class="section" id="conclusion">
<h2>Conclusion</h2>
<p>Consistent style is one less thing to argue about in code review. Adding this library to your dev dependencies is a one-time cost that pays back forever.</p>
<div class="phpdocumentor-admonition -note">
    <svg class="phpdocumentor-admonition__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/></svg>
    <article><p>Did you find something wrong? Be sure to let us know with an <a href="https://github.com/webisters/coding-standard/issues">issue</a>. Thank you!</p></article>
</div>
</div>
</div>
<?php
require_once __DIR__ . '/../../../includes/footer.php';
?>
