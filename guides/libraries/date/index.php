<?php
$pageTitle = 'Webisters Docs';
require_once __DIR__ . '/../../../includes/header.php';
require_once __DIR__ . '/../../../includes/sidebar.php';
?>
<div class="section" id="date">
<h1>Date</h1>
<p>Webisters Date Library.</p>
<ul>
    <li>
            <a href="#installation">Installation</a>
        </li>
    <li>
            <a href="#date">Date</a>
        </li>
    <li>
            <a href="#conclusion">Conclusion</a>
        </li>
</ul>
<div class="section" id="installation">
<h2>Installation</h2>
<p>The installation of this library can be done with Composer:</p>
<pre><code class="language- " >composer require Webisters/date
</code></pre>
</div>
<div class="section" id="date">
<h2>Date</h2>
<p>The Date class adds some functionality to the native <strong>DateTime</strong> class.</p>
<p>It implements the <strong>JsonSerializable</strong> and <strong>Stringable</strong> interfaces,
optimizing work with APIs by transforming the Date object into a string in ATOM
format.</p>
<p>Example using the <code>__toString</code> method:</p>
<pre><code class="language-php " >use Framework\Date\Date;
$date = new Date();
echo $date; // 2019-11-08T15:40:57-03:00
</code></pre>
<div class="section" id="humanize">
<h3>Humanize</h3>
<p>With objects of the Date class it is possible to render time spaces that are
easier for humans to understand. For this, use the <code>humanize</code> method:</p>
<pre><code class="language-php " >echo $date-&gt;humanize(); // 3 days ago
</code></pre>
<p>It can also be in another language:</p>
<pre><code class="language-php " >$language = new Language(&#039;pt-br&#039;);
$date-&gt;setLanguage($language);
echo $date-&gt;humanize(); // 3 dias atrás
</code></pre>
</div>
</div>
<div class="section" id="conclusion">
<h2>Conclusion</h2>
<p>Webisters Date Library is an easy-to-use tool for, beginners and experienced, PHP developers.<br>It is perfect for working with APIs that need date manipulation.<br>The more you use it, the more you will learn.</p>
<div class="phpdocumentor-admonition -note ">
            <svg class="phpdocumentor-admonition__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path></svg>
                    <article>
        <p>Did you find something wrong?<br>Be sure to let us know about it with an
<a href="https://github.com/webisters/date/issues">issue</a>.<br>Thank you!</p>
    </article>
</div>
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
require_once __DIR__ . '/../../../includes/footer.php';
?>
