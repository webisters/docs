<?php
$pageTitle = 'Minify · Webisters Docs';
require_once __DIR__ . '/../../../includes/header.php';
require_once __DIR__ . '/../../../includes/sidebar.php';
?>
<div class="section" id="minify">
<h1>Minify</h1>
<p>Webisters Minify shrinks HTML, CSS, and JavaScript before it leaves your server. It's stream-friendly, dependency-free, and safe with inline scripts and styles.</p>
<ul>
    <li><a href="#installation">Installation</a></li>
    <li><a href="#getting-started">Getting Started</a></li>
    <li><a href="#minifying-html">Minifying HTML</a></li>
    <li><a href="#minifying-css">Minifying CSS</a></li>
    <li><a href="#minifying-javascript">Minifying JavaScript</a></li>
    <li><a href="#response-middleware">As response middleware</a></li>
    <li><a href="#conclusion">Conclusion</a></li>
</ul>

<div class="section" id="installation">
<h2>Installation</h2>
<pre><code class="language-bash">composer require webisters/minify</code></pre>
</div>

<div class="section" id="getting-started">
<h2>Getting Started</h2>
<p>Instantiate the <code>Minify</code> class and pass content to one of its methods:</p>
<pre><code class="language-php">use Framework\Minify\Minify;

$minify = new Minify();</code></pre>
</div>

<div class="section" id="minifying-html">
<h2>Minifying HTML</h2>
<pre><code class="language-php">$html = '&lt;html&gt;
    &lt;body&gt;
        &lt;h1&gt;Hello&lt;/h1&gt;
    &lt;/body&gt;
&lt;/html&gt;';

echo $minify-&gt;html($html);
// =&gt; &lt;html&gt;&lt;body&gt;&lt;h1&gt;Hello&lt;/h1&gt;&lt;/body&gt;&lt;/html&gt;</code></pre>
<p>Inline <code>&lt;script&gt;</code> and <code>&lt;style&gt;</code> tags are minified in-place using the matching CSS and JS minifiers.</p>
</div>

<div class="section" id="minifying-css">
<h2>Minifying CSS</h2>
<pre><code class="language-php">$css = '
body {
    background: #fff;
    color: #0b1b2b;
}
';

echo $minify-&gt;css($css);
// =&gt; body{background:#fff;color:#0b1b2b}</code></pre>
</div>

<div class="section" id="minifying-javascript">
<h2>Minifying JavaScript</h2>
<pre><code class="language-php">$js = '
function greet(name) {
    return "Hello, " + name + "!";
}
';

echo $minify-&gt;js($js);
// =&gt; function greet(name){return"Hello, "+name+"!";}</code></pre>
</div>

<div class="section" id="response-middleware">
<h2>As response middleware</h2>
<p>Hook Minify into your response pipeline so every HTML response gets shrunk automatically:</p>
<pre><code class="language-php">use Framework\Minify\Minify;
use Framework\HTTP\Response;

$response = new Response();
$response-&gt;setBody($minify-&gt;html($html));
$response-&gt;setHeader('Content-Length', (string) strlen($response-&gt;getBody()));
$response-&gt;send();</code></pre>
<p>Pair this with gzip/brotli at the web-server level for the best wire weight.</p>
</div>

<div class="section" id="conclusion">
<h2>Conclusion</h2>
<p>Minification is a small win &mdash; usually 10-30% off your transfer size &mdash; but it's free, deterministic, and stacks well with compression.</p>
<div class="phpdocumentor-admonition -note">
    <svg class="phpdocumentor-admonition__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/></svg>
    <article><p>Did you find something wrong? Be sure to let us know with an <a href="https://github.com/webisters/minify/issues">issue</a>. Thank you!</p></article>
</div>
</div>
</div>
<?php
require_once __DIR__ . '/../../../includes/footer.php';
?>
