<?php
$pageTitle = 'Front · Webisters Docs';
require_once __DIR__ . '/../../../includes/header.php';
require_once __DIR__ . '/../../../includes/sidebar.php';
?>
<div class="section" id="front">
<h1>Front</h1>
<p>Webisters Front is the framework's shared front-end asset library: a curated set of Sass partials, a tiny Sass compiler script, and reusable view templates that ship with every Webisters project. It's CSS-first &mdash; there's no JavaScript framework dependency.</p>
<ul>
    <li><a href="#installation">Installation</a></li>
    <li><a href="#sass-partials">Sass partials</a></li>
    <li><a href="#compiling-styles">Compiling styles</a></li>
    <li><a href="#shared-views">Shared views</a></li>
    <li><a href="#conclusion">Conclusion</a></li>
</ul>

<div class="section" id="installation">
<h2>Installation</h2>
<pre><code class="language-bash">composer require webisters/front</code></pre>
</div>

<div class="section" id="sass-partials">
<h2>Sass partials</h2>
<p>The <code>sass/</code> directory contains the design tokens (colors, spacing, typography) plus reusable component partials: buttons, forms, cards, navigation, tables, alerts. Pull them into your project's main stylesheet:</p>
<pre><code class="language-scss">// app.scss
@use 'webisters/front/sass/tokens';
@use 'webisters/front/sass/buttons';
@use 'webisters/front/sass/forms';
@use 'webisters/front/sass/cards';</code></pre>
<p>Override any token by re-declaring it before the <code>@use</code> import.</p>
</div>

<div class="section" id="compiling-styles">
<h2>Compiling styles</h2>
<p>Front includes a small PHP-driven Sass compiler at <code>sass-compiler.php</code> so you don't need a Node toolchain just for CSS. Invoke it directly from Composer:</p>
<pre><code class="language-bash">php vendor/webisters/front/sass-compiler.php \
    --input=resources/app.scss \
    --output=public/css/app.css</code></pre>
<p>Or wire it into your <code>composer.json</code> scripts:</p>
<pre><code class="language-json">{
    "scripts": {
        "build:css": "php vendor/webisters/front/sass-compiler.php --input=resources/app.scss --output=public/css/app.css"
    }
}</code></pre>
</div>

<div class="section" id="shared-views">
<h2>Shared views</h2>
<p>The <code>views/</code> directory ships partials for things every project re-creates: layouts, flash messages, pagination, form fields. The <code>views-builder.php</code> helper copies them into your project's view directory so you can edit freely:</p>
<pre><code class="language-bash">php vendor/webisters/front/views-builder.php --to=resources/views</code></pre>
</div>

<div class="section" id="conclusion">
<h2>Conclusion</h2>
<p>Front is opinionated, lightweight, and easy to override. Use it as a starting point, not a constraint &mdash; bring in only the partials you want and replace anything that doesn't fit your design.</p>
<div class="phpdocumentor-admonition -note">
    <svg class="phpdocumentor-admonition__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/></svg>
    <article><p>Did you find something wrong? Be sure to let us know with an <a href="https://github.com/webisters/front/issues">issue</a>. Thank you!</p></article>
</div>
</div>
</div>
<?php
require_once __DIR__ . '/../../../includes/footer.php';
?>
