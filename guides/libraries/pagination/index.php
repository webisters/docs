<?php
$pageTitle = 'Webisters Docs';
require_once __DIR__ . '/../../../includes/header.php';
require_once __DIR__ . '/../../../includes/sidebar.php';
?>
<div class="section" id="pagination">
<h1>Pagination</h1>
<p>Webisters Pagination Library.</p>
<ul>
    <li>
            <a href="#installation">Installation</a>
        </li>
    <li>
            <a href="#getting-started">Getting Started</a>
        </li>
    <li>
            <a href="#rendering-views">Rendering Views</a>
        </li>
    <li>
            <a href="#custom-language">Custom Language</a>
        </li>
    <li>
            <a href="#url">URL</a>
        </li>
    <li>
            <a href="#json-encoding">JSON-Encoding</a>
        </li>
    <li>
            <a href="#conclusion">Conclusion</a>
        </li>
</ul>
<div class="section" id="installation">
<h2>Installation</h2>
<p>The installation of this library can be done with Composer:</p>
<pre><code class="language- " >composer require Webisters/pagination
</code></pre>
</div>
<div class="section" id="getting-started">
<h2>Getting Started</h2>
<p>With the Pagination Library it is possible to work with objects of the Pager class.</p>
<p>And a Pager can be instantiated as in the example below:</p>
<pre><code class="language-php " >use Framework\Pagination\Pager;
$currentPage = 3;
$itemsPerPage = 10;
$totalItems = 230;
$pager = new Pager($currentPage, $itemsPerPage, $totalItems);
</code></pre>
</div>
<div class="section" id="rendering-views">
<h2>Rendering Views</h2>
<p>You can work with various Pager methods, but the ultimate goal is usually to
render views to be displayed on the page.</p>
<p>The following features are available for rendering views: <a href="#pagination">Pagination</a>,
<a href="#html-head-links">HTML Head Links</a>, <a href="#http-header-link">HTTP Header Link</a>, <a href="#front-end-frameworks-support">Front-end Frameworks Support</a>,
<a href="#default-rendering-view">Default Rendering View</a>, <a href="#custom-views">Custom Views</a>.</p>
<div class="section" id="pagination">
<h3>Pagination</h3>
<p>The default view name is <code>pagination</code> and it can be rendered as follows:</p>
<pre><code class="language-php " >echo $pager-&gt;render();
</code></pre>
<p>An HTML code similar to this will be displayed:</p>
<pre><code class="language-html " >&lt;ul class=&quot;pagination&quot;&gt;
    &lt;li&gt;
        &lt;a rel=&quot;prev&quot; href=&quot;https://domain.tld/blog/posts?page=2&quot; title=&quot;Previous&quot;&gt;&amp;laquo;&lt;/a&gt;
    &lt;/li&gt;
    &lt;li&gt;
        &lt;a href=&quot;https://domain.tld/blog/posts?page=1&quot;&gt;1&lt;/a&gt;
    &lt;/li&gt;
    &lt;li&gt;
        &lt;a href=&quot;https://domain.tld/blog/posts?page=2&quot;&gt;2&lt;/a&gt;
    &lt;/li&gt;
    &lt;li&gt;
        &lt;a rel=&quot;canonical&quot; href=&quot;https://domain.tld/blog/posts?page=3&quot; class=&quot;active&quot;&gt;3&lt;/a&gt;
    &lt;/li&gt;
    &lt;li&gt;
        &lt;a href=&quot;https://domain.tld/blog/posts?page=4&quot;&gt;4&lt;/a&gt;
    &lt;/li&gt;
    &lt;li&gt;
        &lt;a href=&quot;https://domain.tld/blog/posts?page=5&quot;&gt;5&lt;/a&gt;
    &lt;/li&gt;
    &lt;li&gt;
        &lt;a rel=&quot;next&quot; href=&quot;https://domain.tld/blog/posts?page=4&quot; title=&quot;Next&quot;&gt;&amp;raquo;&lt;/a&gt;
    &lt;/li&gt;
    &lt;li&gt;
        &lt;a href=&quot;https://domain.tld/blog/posts?page=23&quot;&gt;Last&lt;/a&gt;
    &lt;/li&gt;
&lt;/ul&gt;
</code></pre>
<p>In addition to &quot;full&quot; rendering, it is also possible to render &quot;short views&quot;:</p>
<pre><code class="language-php " >echo $pager-&gt;renderShort();
</code></pre>
<p>See HTML below. It only has the <strong>previous</strong> and <strong>next</strong> links:</p>
<pre><code class="language-html " >&lt;ul class=&quot;pagination&quot;&gt;
    &lt;li&gt;
        &lt;a rel=&quot;prev&quot; href=&quot;https://domain.tld/blog/posts?page=2&quot; title=&quot;Previous&quot;&gt;
            &amp;laquo; Previous
        &lt;/a&gt;
    &lt;/li&gt;
    &lt;li&gt;
        &lt;a rel=&quot;next&quot; href=&quot;https://domain.tld/blog/posts?page=4&quot; title=&quot;Next&quot;&gt;
            Next &amp;raquo;
        &lt;/a&gt;
    &lt;/li&gt;
&lt;/ul&gt;
</code></pre>
</div>
<div class="section" id="html-head-links">
<h3>HTML Head Links</h3>
<p>One way to optimize the indexing of pages visited by web crawlers and also SEO
ranks is to print the pagination links in the <code>head</code> tag of the HTML page:</p>
<pre><code class="language-php " >&lt;head&gt;
&lt;title&gt;Webisters Pagination&lt;/title&gt;
&lt;?= $pager-&gt;render(&#039;head&#039;) ?&gt;
&lt;/head&gt;
</code></pre>
<p>Example of rendering links with <code>head</code> view:</p>
<pre><code class="language-html " >&lt;head&gt;
&lt;title&gt;Webisters Pagination&lt;/title&gt;
&lt;link rel=&quot;prev&quot; href=&quot;https://domain.tld/blog/posts?page=2&quot;&gt;
&lt;link rel=&quot;canonical&quot; href=&quot;https://domain.tld/blog/posts?page=3&quot;&gt;
&lt;link rel=&quot;next&quot; href=&quot;https://domain.tld/blog/posts?page=4&quot;&gt;
&lt;/head&gt;
</code></pre>
</div>
<div class="section" id="http-header-link">
<h3>HTTP Header Link</h3>
<p>When working with APIs it may be necessary to paginate the results and for this
there is the <a href="https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Link">HTTP Link Header</a>.</p>
<p>With the Pager defined, it is possible to render the <code>header</code> view:</p>
<pre><code class="language-php " >header(&#039;Link: &#039; . $pager-&gt;render(&#039;header&#039;));
</code></pre>
<p>The Link sent header field will look like this:</p>
<pre><code class="language-http " >Link: &lt;https://domain.tld/blog/posts?page=1&gt;; rel=&quot;first&quot;,&lt;https://domain.tld/blog/posts?page=2&gt;; rel=&quot;prev&quot;,&lt;https://domain.tld/blog/posts?page=4&gt;; rel=&quot;next&quot;,&lt;https://domain.tld/blog/posts?page=23&gt;; rel=&quot;last&quot;
</code></pre>
</div>
<div class="section" id="front-end-frameworks-support">
<h3>Front-end Frameworks Support</h3>
<p>The Webisters Pagination Library works with the following front-end frameworks:</p>
<ul>
    <li>
            <a href="https://getbootstrap.com/">Bootstrap</a>
        </li>
    <li>
            <a href="https://bulma.io/">Bulma</a>
        </li>
    <li>
            <a href="https://get.foundation/">Foundation</a>
        </li>
    <li>
            <a href="https://materializecss.com/">Materialize</a>
        </li>
    <li>
            <a href="https://primer.style/">Primer</a>
        </li>
    <li>
            <a href="https://semantic-ui.com/">Semantic UI</a>
        </li>
    <li>
            <a href="https://tailwindcss.com/">Tailwind</a>
        </li>
    <li>
            <a href="https://www.w3schools.com/w3css/default.asp/">W3.CSS</a>
        </li>
</ul>
<p>Note that it is necessary to load links from CSS files.</p>
<p>See an example using Bootstrap:</p>
<ul>
    <li>
            Insert the link tag with the CSS file.
        </li>
</ul>
<pre><code class="language-html " >&lt;link rel=&quot;stylesheet&quot; href=&quot;https://cdn.jsdelivr.net/npm/<a href="../cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="bbd9d4d4cfc8cfc9dacbfb8e958b958a">[email&#160;protected]</a>/dist/css/bootstrap.min.css&quot;&gt;
</code></pre>
<ul>
    <li>
            Render pagination using the <code>bootstrap</code> view:
        </li>
</ul>
<pre><code class="language-php " >echo $pager-&gt;render(&#039;bootstrap&#039;);
</code></pre>
<p>The result will be like the image below:</p>
<img
    src="../guides/libraries/pagination/img/bootstrap.png"
                alt="Webisters Pagination - Bootstrap View"    />
<p>It is also possible to render the &quot;short view&quot;. Note the view name suffixed with <code>-short</code>:</p>
<pre><code class="language-php " >echo $pager-&gt;render(&#039;bootstrap-short&#039;);
</code></pre>
<p>And the result:</p>
<img
    src="../guides/libraries/pagination/img/bootstrap-short.png"
                alt="Webisters Pagination - Bootstrap Short View"    />
</div>
<div class="section" id="default-rendering-view">
<h3>Default Rendering View</h3>
<p>You can always render views by passing their name in the render method.</p>
<p>The most common is that an application works with only one pagination style and
for that it is possible to set the default view.</p>
<p>Once this is done, the Pager&#039;s <code>render</code> method can be called with no arguments
and the default view will be rendered.</p>
<p>See an example setting the <code>bulma</code> view to default:</p>
<pre><code class="language-php " >$pager-&gt;setDefaultView(&#039;bulma&#039;); // static
</code></pre>
<p>And the call to render:</p>
<pre><code class="language-php " >&lt;link rel=&quot;stylesheet&quot; href=&quot;https://cdn.jsdelivr.net/npm/<a href="../cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="4f2d3a23222e0f7f6176617d">[email&#160;protected]</a>/css/bulma.min.css&quot;&gt;
&lt;?= $pager-&gt;render() ?&gt;
</code></pre>
<p>And the result in the web browser:</p>
<img
    src="../guides/libraries/pagination/img/bulma.png"
                alt="Webisters Pagination - Bulma View"    />
<p>The default view will also be used by the <code>renderShort</code> method</p>
<pre><code class="language-php " >echo $pager-&gt;renderShort();
</code></pre>
<p>which will render the &quot;short view&quot;:</p>
<img
    src="../guides/libraries/pagination/img/bulma-short.png"
                alt="Webisters Pagination - Bulma Short View"    />
</div>
<div class="section" id="custom-views">
<h3>Custom Views</h3>
<p>If you need to use a different view style, add the view name and filepath:</p>
<pre><code class="language-php " >$name = &#039;my-pager&#039;;
$filepath = __DIR__ . &#039;/Views/my-pager.php&#039;;
$pager-&gt;setView($name, $filepath); // static
</code></pre>
<p>And then you can render it:</p>
<pre><code class="language-php " >echo $pager-&gt;render(&#039;my-pager&#039;);
</code></pre>
<p>Note that it is possible to set the default view and call the <code>render</code> method
with no arguments.</p>
</div>
</div>
<div class="section" id="custom-language">
<h2>Custom Language</h2>
<p>The default language used is English.</p>
<p>To set a different language, do this in the Pager constructor:</p>
<pre><code class="language-php " >$language = new Framework\Language\Language(&#039;es&#039;);
$pager = new Pager($currentPage, $itemsPerPage, $totalItems, $language);
</code></pre>
<p>Or when needed via the <code>setLanguage</code> method:</p>
<pre><code class="language-php " >$pager-&gt;setLanguage($language); // static
</code></pre>
<p>After setting the language, it is possible to render the pagination.</p>
<pre><code class="language-php " >&lt;link rel=&quot;stylesheet&quot; href=&quot;https://cdn.jsdelivr.net/npm/<a href="../cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="35465058545b415c5618405c75071b011b07">[email&#160;protected]</a>/dist/semantic.min.css&quot;&gt;
&lt;?= $pager-&gt;render(&#039;semantic-ui&#039;) ?&gt;
</code></pre>
<p>Example using Semantic UI with Spanish language:</p>
<img
    src="../guides/libraries/pagination/img/semantic-ui.png"
                alt="Webisters Pagination - Semantic UI View"    />
<p>If the Pagination Library is not localized in your language, you can contribute by adding
it with a <a href="https://github.com/webisters/pagination/pulls">Pull Request</a>.</p>
<p>It is also possible to add custom languages at runtime. See the
<a href="https://github.com/webisters/language">Language Library</a> to know more.</p>
</div>
<div class="section" id="url">
<h2>URL</h2>
<p>The URL used by the Pager is obtained through the HTTP request.</p>
<p>In some cases it is necessary to generate pagination for other resources or,
also, when working from the command line.</p>
<p>Then the URL can be passed into the constructor:</p>
<pre><code class="language-php " >$url = &#039;https://domain.tld/blog/posts&#039;;
$pager = new Pager($currentPage, $itemsPerPage, $totalItems, url: $url);
</code></pre>
<p>Or whenever you want via the <code>setUrl</code> method:</p>
<pre><code class="language-php " >$pager-&gt;setUrl($url); // static
</code></pre>
</div>
<div class="section" id="json-encoding">
<h2>JSON-Encoding</h2>
<p>Nowadays, it is very common to use JSON to work with interactions through AJAX or APIs.</p>
<p>An application can respond the pagination links via the <a href="#http-header-link">HTTP Header Link</a>.
However, it is also an option to put the links next to the message content.</p>
<p>Having a Pager object instantiated, just put it in to be encoded:</p>
<pre><code class="language-php " >$contents = [
    &#039;data&#039; =&gt; [],
    &#039;links&#039; =&gt; $pager,
];
echo json_encode($contents, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
</code></pre>
<p>And the result will be similar to this:</p>
<pre><code class="language-json " >{
    &quot;data&quot;: [],
    &quot;links&quot;: {
        &quot;self&quot;: &quot;https://domain.tld/blog/posts?page=3&quot;,
        &quot;first&quot;: &quot;https://domain.tld/blog/posts?page=1&quot;,
        &quot;prev&quot;: &quot;https://domain.tld/blog/posts?page=2&quot;,
        &quot;next&quot;: &quot;https://domain.tld/blog/posts?page=4&quot;,
        &quot;last&quot;: &quot;https://domain.tld/blog/posts?page=23&quot;
    }
}
</code></pre>
</div>
<div class="section" id="conclusion">
<h2>Conclusion</h2>
<p>Webisters Pagination Library is an easy-to-use tool for PHP developers, beginners and experienced.<br>It&#039;s perfect for building full-featured pagination in a very simple way.<br>The more you use it, the more you will learn.</p>
<div class="phpdocumentor-admonition -note ">
            <svg class="phpdocumentor-admonition__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path></svg>
                    <article>
        <p>Did you find something wrong?<br>Be sure to let us know about it with an
<a href="https://github.com/webisters/pagination/issues">issue</a>.<br>Thank you!</p>
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
