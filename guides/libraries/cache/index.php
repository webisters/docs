<?php
$pageTitle = 'Webisters Docs';
require_once __DIR__ . '/../../../includes/header.php';
require_once __DIR__ . '/../../../includes/sidebar.php';
?>
<div class="section" id="cache">
    <h1>Cache</h1>
    <p>Webisters Cache Library.</p>
    <ul>
        <li>
            <a href="#installation">Installation</a>
        </li>
        <li>
            <a href="#getting-started">Getting Started</a>
        </li>
        <li>
            <a href="#set-values">Set Values</a>
        </li>
        <li>
            <a href="#get-values">Get Values</a>
        </li>
        <li>
            <a href="#increment-and-decrement">Increment and
                Decrement</a>
        </li>
        <li>
            <a href="#flush">Flush</a>
        </li>
        <li>
            <a href="#close">Close</a>
        </li>
        <li>
            <a href="#cache-handlers">Cache Handlers</a>
        </li>
        <li>
            <a href="#conclusion">Conclusion</a>
        </li>
    </ul>
    <div class="section" id="installation">
        <h2>Installation</h2>
        <p>The installation of this library can be done with Composer:</p>
        <pre><code class="language- " >composer require Webisters/cache
</code></pre>
    </div>
    <div class="section" id="getting-started">
        <h2>Getting Started</h2>
        <p>The logic for caching values is similar to the example below:</p>
        <pre><code class="language-php " >use Framework\Cache\FilesCache;
$cache = new FilesCache([
    &#039;directory&#039; =&gt; &#039;/tmp/cache/&#039;
]);
$data = $cache-&gt;get(&#039;data&#039;); // Data value or null
if  ($data !== null) { // If data is cached, return now
    return $data;
}
$data = [&#039;foo&#039;, &#039;bar&#039;]; // Else, set again
$cache-&gt;set(&#039;data&#039;, $data, 15); // Cache for 15 seconds
return $data;
</code></pre>
        <p>If the value of &quot;data&quot; is cached it returns that value.</p>
        <p>Otherwise, the value is added to the cache to be responded to in the next request,
            within the 15 second TTL.</p>
    </div>
    <div class="section" id="set-values">
        <h2>Set Values</h2>
        <p>Items can be cached individually or several at a time.</p>
        <pre><code class="language-php " >// Set the value of &quot;key&quot; for 10 seconds
$cache-&gt;set(&#039;key&#039;, &#039;value&#039;, 10); // bool
// Set the values of &quot;key&quot; and &quot;foo&quot; for 10 seconds
$cache-&gt;setMulti([
    &#039;key&#039;=&gt; &#039;value&#039;,
    &#039;foo&#039;=&gt; &#039;bar&#039;,
], 10); // array of booleans
</code></pre>
        <p>The TTL can be set as the third argument of the <code>set</code> method or with the
            <code>setDefaultTtl</code> method:
        </p>
        <pre><code class="language-php " >$cache-&gt;setDefaultTtl(60);
</code></pre>
    </div>
    <div class="section" id="get-values">
        <h2>Get Values</h2>
        <p>Get values can also be individually or multiple at once:</p>
        <pre><code class="language-php " >// Data is the value of &quot;key&quot; or null
$data = $cache-&gt;get(&#039;key&#039;);
// Data is an array with the keys &quot;key&quot;, &quot;foo&quot; and &quot;baz&quot;
// Items not found have null value
$data = $cache-&gt;getMulti([&#039;key&#039;, &#039;foo&#039;, &#039;baz&#039;]);
</code></pre>
    </div>
    <div class="section" id="increment-and-decrement">
        <h2>Increment and Decrement</h2>
        <p>Some items may be simpler and only need to save increment or decrement values.
            Example below:</p>
        <pre><code class="language-php " >$data = $cache-&gt;increment(&#039;foo&#039;); // $data is 1
$data = $cache-&gt;increment(&#039;foo&#039;); // $data is 2
$data = $cache-&gt;increment(&#039;foo&#039;, 3); // $data is 5
</code></pre>
        <pre><code class="language-php " >$data = $cache-&gt;decrement(&#039;foo&#039;); // $data is -1
$data = $cache-&gt;decrement(&#039;foo&#039;); // $data is -2
$data = $cache-&gt;decrement(&#039;foo&#039;, 3); // $data is -5
</code></pre>
    </div>
    <div class="section" id="flush">
        <h2>Flush</h2>
        <p>If you want to remove all items from the cache use the <code>flush</code> method:</p>
        <pre><code class="language-php " >$flushed = $cache-&gt;flush(); // bool
</code></pre>
    </div>
    <div class="section" id="close">
        <h2>Close</h2>
        <p>By default, the cache handler will be closed upon deconstruction of the Cache
            class. You can close it at any time using the <code>close</code> method:</p>
        <pre><code class="language-php " >$closed = $cache-&gt;close(); // bool
</code></pre>
        <p>It is also possible to disable automatic closing with the <code>setAutoClose</code>
            method:</p>
        <pre><code class="language-php " >$cache-&gt;setAutoClose(false); // static
$isAutoClose = $cache-&gt;isAutoClose(); // bool
</code></pre>
    </div>
    <div class="section" id="cache-handlers">
        <h2>Cache Handlers</h2>
        <p>There are 4 cache handlers in the library and they are the following:</p>
        <ul>
            <li>
                <a href="#apcucache">ApcuCache</a>
            </li>
            <li>
                <a href="#filescache">FilesCache</a>
            </li>
            <li>
                <a href="#memcachedcache">MemcachedCache</a>
            </li>
            <li>
                <a href="#rediscache">RedisCache</a>
            </li>
        </ul>
        <p>All handlers receive configs, prefix, serializer and logger through the constructor:</p>
        <pre><code class="language-php " >public function __construct(
    mixed $configs = [],
    ?string $prefix = null,
    Serializer | string $serializer = Serializer::PHP,
    ?Logger $logger = null
) {...}
</code></pre>
        <div class="section" id="apcucache">
            <h3>ApcuCache</h3>
            <p>ApcuCache is the fastest caching system and can be instantiated as in the
                example below:</p>
            <pre><code class="language-php " >use Framework\Cache\ApcuCache;
$cache = new ApcuCache();
</code></pre>
        </div>
        <div class="section" id="filescache">
            <h3>FilesCache</h3>
            <p>The FilesCache config must have the value of <code>directory</code>. The other configs
                already have default values:</p>
            <pre><code class="language-php " >use Framework\Cache\FilesCache;
$configs = [
    &#039;directory&#039; =&gt; &#039;/patch/to/cache/directory&#039;,
    &#039;files_permission&#039; =&gt; 0644,
    &#039;gc&#039; =&gt; 1,
];
$cache = new FilesCache($configs);
</code></pre>
        </div>
        <div class="section" id="memcachedcache">
            <h3>MemcachedCache</h3>
            <p>The Memcached handler already comes with the configs set to connect to Memcached
                on localhost.</p>
            <p>If you want to set different configs, do as follows:</p>
            <pre><code class="language-php " >use Framework\Cache\MemcachedCache;
$configs = [
     &#039;servers&#039; =&gt; [
        [
            &#039;host&#039; =&gt; &#039;127.0.0.1&#039;,
            &#039;port&#039; =&gt; 11211,
            &#039;weight&#039; =&gt; 0,
        ],
        [
            &#039;host&#039; =&gt; &#039;192.168.0.100&#039;,
            &#039;port&#039; =&gt; 11211,
            &#039;weight&#039; =&gt; 0,
        ],
    ],
    &#039;options&#039; =&gt; [
        Memcached::OPT_BINARY_PROTOCOL =&gt; true,
    ],
];
$cache = new MemcachedCache($configs);
</code></pre>
            <p>If you want to use a custom Memcached instance, pass it in the first parameter
                of the constructor:</p>
            <pre><code class="language-php " >$memcached = new Memcached();
$cache = new MemcachedCache($memcached);
</code></pre>
            <p>Note that when using a custom Memcached instance, it will not be automatically
                closed by the destructor. You need to call the <code>close</code> method directly or
                enable it with <code>setAutoClose</code> for that if you want.</p>
        </div>
        <div class="section" id="rediscache">
            <h3>RedisCache</h3>
            <p>The Redis handler is also already configured to work on localhost.</p>
            <p>If it is necessary to define another address, do as in the example below:</p>
            <pre><code class="language-php " >use Framework\Cache\RedisCache;
$configs = [
    &#039;host&#039; =&gt; &#039;192.168.1.100&#039;,
    &#039;port&#039; =&gt; 6379,
    &#039;timeout&#039; =&gt; 0.0,
    &#039;password&#039; =&gt; null,
    &#039;database&#039; =&gt; null,
];
$cache = new RedisCache($configs);
</code></pre>
            <p>If you want to use a custom Redis instance, pass it in the first parameter
                of the constructor:</p>
            <pre><code class="language-php " >$redis = new Redis();
$cache = new RedisCache($redis);
</code></pre>
            <p>Note that when using a custom Redis instance, it will not be automatically
                closed by the destructor. You need to call the <code>close</code> method directly or
                enable it with <code>setAutoClose</code> for that if you want.</p>
        </div>
    </div>
    <div class="section" id="conclusion">
        <h2>Conclusion</h2>
        <p>Webisters Cache Library is an easy-to-use tool for, beginners and experienced, PHP
            developers.<br>With it you can optimize the performance of your applications.<br>The more
            you use it, the more you will learn.</p>
        <div class="phpdocumentor-admonition -note ">
            <svg class="phpdocumentor-admonition__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z">
                </path>
            </svg>
            <article>
                <p>Did you find something wrong?<br>Be sure to let us know about it with an
                    <a href="https://github.com/webisters/cache/issues">issue</a>.<br>Thank you!
                </p>
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