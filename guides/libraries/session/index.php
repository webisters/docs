<?php
$pageTitle = 'Webisters Docs';
require_once __DIR__ . '/../../../includes/header.php';
require_once __DIR__ . '/../../../includes/sidebar.php';
?>
<div class="section" id="session">
<h1>Session</h1>
<p>Webisters Session Library.</p>
<ul>
    <li>
            <a href="#installation">Installation</a>
        </li>
    <li>
            <a href="#getting-started">Getting Started</a>
        </li>
    <li>
            <a href="#managing-data">Managing Data</a>
        </li>
    <li>
            <a href="#temporary-data">Temporary Data</a>
        </li>
    <li>
            <a href="#flash-data">Flash Data</a>
        </li>
    <li>
            <a href="#save-handlers">Save Handlers</a>
        </li>
    <li>
            <a href="#conclusion">Conclusion</a>
        </li>
</ul>
<div class="section" id="installation">
<h2>Installation</h2>
<p>The installation of this library can be done with Composer:</p>
<pre><code class="language- " >composer require Webisters/session
</code></pre>
</div>
<div class="section" id="getting-started">
<h2>Getting Started</h2>
<p>The Session class has methods that facilitate session management.</p>
<pre><code class="language-php " >use Framework\Session\Session;
$session = new Session();
// Start the session
$session-&gt;start(); // bool
// Check if the session is active
$active = $session-&gt;isActive(); // bool
// Regenerate the session id
$session-&gt;regenerateId(); // bool
// Destroy the session
$session-&gt;destroy(); // bool
$session-&gt;destroyCookie(); // bool
// Stop the session, write and close
$session-&gt;stop(); // bool
</code></pre>
<p>To make sure the session is active you can use the <code>activate</code> method:</p>
<pre><code class="language-php " >$session-&gt;activate(); // bool
</code></pre>
<div class="section" id="options">
<h3>Options</h3>
<p>Options can be passed through the Session class constructor:</p>
<pre><code class="language-php " >$session = new Session([
    &#039;name&#039; =&gt; &#039;session_id&#039;
]);
</code></pre>
<p>or by the <code>start</code> method:</p>
<pre><code class="language-php " >$session = new Session();
$session-&gt;start([
    &#039;name&#039; =&gt; &#039;session_id&#039;
]); // bool
</code></pre>
</div>
<div class="section" id="custom-options">
<h3>Custom Options</h3>
<p>Custom options only work if they are passed through the Session constructor.</p>
<ul>
    <li>
            <a href="#auto-regenerate-id">Auto Regenerate ID</a>
        </li>
    <li>
            <a href="#set-cookie-permanent">Set-Cookie Permanent</a>
        </li>
</ul>
<div class="section" id="auto-regenerate-id">
<h4>Auto Regenerate ID</h4>
<p>It is possible to auto-regenerate the session id by passing the following
options:</p>
<ul>
    <li>
            <code>auto_regenerate_maxlifetime</code> to set the maximum file lifetime and
        </li>
    <li>
            <code>auto_regenerate_destroy</code> to destroy the old session file.
        </li>
</ul>
<pre><code class="language-php " >$session = new Session([
    &#039;auto_regenerate_maxlifetime&#039; =&gt; 7200,
    &#039;auto_regenerate_destroy&#039; =&gt; true,
]));
</code></pre>
<p>This will help avoid
<a href="https://owasp.org/www-community/attacks/Session_fixation">Session Fixation</a>.</p>
</div>
<div class="section" id="set-cookie-permanent">
<h4>Set-Cookie Permanent</h4>
<p>It is possible to send the session&#039;s Set-Cookie header in all HTTP responses by
setting the <code>set_cookie_permanent</code> option:</p>
<pre><code class="language-php " >$session = new Session([
    &#039;set_cookie_permanent&#039; =&gt; true,
]));
</code></pre>
<p>This will cause the session cookie expiration date to be updated in the browser
on every response.</p>
</div>
</div>
<div class="section" id="managing-data">
<h2>Managing Data</h2>
<p>Data manipulation can be performed with the <code>get</code> and <code>set</code> methods or by
calling the properties directly using the magic methods:</p>
<pre><code class="language-php " >// Set user_id as 1
$session-&gt;set(&#039;user_id&#039;, 1); // static
// Set user_id as 1 using magic setter
$session-&gt;user_id = 1;
// Get the value of user_id
$uid = $session-&gt;get(&#039;user_id&#039;); // 1
// Get the value of user_id using magic getter
$uid = $session-&gt;user_id; // 1
</code></pre>
<div class="section" id="multiple-items-at-once">
<h3>Multiple Items at Once</h3>
<p>Multiple items can be handled at once:</p>
<pre><code class="language-php " >$session-&gt;setMulti([
    &#039;user_id&#039; =&gt; 1,
    &#039;active&#039; =&gt; true,
]); // static
// Get an array with the two keys
$data = $session-&gt;getMulti([
    &#039;user_id&#039;,
    &#039;active&#039;,
]); // array
</code></pre>
</div>
<div class="section" id="abort">
<h3>Abort</h3>
<p>If necessary, you can abort the current session&#039;s modifications by returning to
the previous one using the <code>abort</code> method:</p>
<pre><code class="language-php " >$session-&gt;abort(); // bool
</code></pre>
</div>
<div class="section" id="session-id">
<h3>Session ID</h3>
<p>The session id can be obtained through the <code>id</code> method:</p>
<pre><code class="language-php " >$id = $session-&gt;id(); // string or false
</code></pre>
<p>and also set as follows:</p>
<pre><code class="language-php " >$oldId = $session-&gt;id(&#039;foo&#039;); // string or false
</code></pre>
</div>
<div class="section" id="getting-all-items">
<h3>Getting All Items</h3>
<p>Using the <code>getAll</code> method, you can get all the items in the session:</p>
<pre><code class="language-php " >$data = $session-&gt;getAll(); // array
</code></pre>
<p>With the <code>has</code> method, you can check if there is an item with a certain key:</p>
<pre><code class="language-php " >// Check if user_id key exists
$exists = $session-&gt;has(&#039;user_id&#039;); // bool
</code></pre>
</div>
<div class="section" id="removing-items">
<h3>Removing Items</h3>
<p>Item removal can be performed individually or multiple at once:</p>
<pre><code class="language-php " >// Remove user_id
$session-&gt;remove(&#039;user_id&#039;); // static
// Remove &#039;active&#039; and &#039;foo&#039;
$session-&gt;removeMulti([
    &#039;active&#039;,
    &#039;foo&#039;,
]); // static
</code></pre>
</div>
</div>
<div class="section" id="temporary-data">
<h2>Temporary Data</h2>
<p>Temporary data are items saved with a TTL (Time To Live) in seconds of how long
the item will be in the session.</p>
<pre><code class="language-php " >// Set &#039;message&#039; for 15 seconds
$session-&gt;setTemp(&#039;message&#039;, &#039;Hello!&#039;, 15); // static
// Get &#039;message&#039; value or null if expired
$msg = $session-&gt;getTemp(&#039;message&#039;); // mixed
</code></pre>
</div>
<div class="section" id="flash-data">
<h2>Flash Data</h2>
<p>Flash data are items to be used only for the next request.</p>
<pre><code class="language-php " >// Set &#039;message&#039; for the next request
$session-&gt;setFlash(&#039;message&#039;, &#039;Hi, John!&#039;); // static
// Get &#039;message&#039; value or null if expired
$session-&gt;getFlash(&#039;message&#039;); // mixed
</code></pre>
<p>Expired Flash and Temp data are automatically removed when the session starts.</p>
</div>
<div class="section" id="save-handlers">
<h2>Save Handlers</h2>
<p>Save Handlers make it possible to store session data in different ways.</p>
<p>Save Handlers are classes that can be set in the second argument of the Session
class:</p>
<pre><code class="language-php " >use Framework\Session\Session;
$session = new Session($options, $saveHandler);
</code></pre>
<p>These are the Save Handlers available by default:</p>
<div class="section" id="database-handler">
<h3>Database Handler</h3>
<p>Allows you to store session data in a database.</p>
<pre><code class="language-php " >use Framework\Session\SaveHandlers\DatabaseHandler;
$saveHandler = new DatabaseHandler($configs);
</code></pre>
<p>These are the DatabaseHandler configs:</p>
<pre><code class="language-php " >$configs = [
    // The name of the table used for sessions
    &#039;table&#039; =&gt; &#039;Sessions&#039;,
    // The maxlifetime used for locking
    &#039;maxlifetime&#039; =&gt; null, // Null to use the ini value of session.gc_maxlifetime
    // The custom column names as values
    &#039;columns&#039; =&gt; [
        &#039;id&#039; =&gt; &#039;id&#039;,
        &#039;data&#039; =&gt; &#039;data&#039;,
        &#039;timestamp&#039; =&gt; &#039;timestamp&#039;,
        &#039;ip&#039; =&gt; &#039;ip&#039;,
        &#039;ua&#039; =&gt; &#039;ua&#039;,
        &#039;ua&#039; =&gt; &#039;ua&#039;,
        &#039;user_id&#039; =&gt; &#039;user_id&#039;,
    ],
    // Match IP?
    &#039;match_ip&#039; =&gt; false,
    // Match User-Agent?
    &#039;match_ua&#039; =&gt; false,
    // Independent of match_ip, save the initial IP in the ip column?
    &#039;save_ip&#039; =&gt; false,
    // Independent of match_ua, save the initial User-Agent in the ua column?
    &#039;save_ua&#039; =&gt; false,
    // Save the user_id?
    &#039;save_user_id&#039; =&gt; false,
];
</code></pre>
<p>Note that the database connection configs must also be set.</p>
<div class="section" id="database-instance">
<h4>Database Instance</h4>
<p>It is also possible to pass an instance of the Database class directly, as in
the example below:</p>
<pre><code class="language-php " >use Framework\Database\Database;
use Framework\Session\SaveHandlers\DatabaseHandler;
$database = new Database(&#039;root&#039;, &#039;pass&#039;, &#039;app&#039;);
$saveHandler = new DatabaseHandler();
$saveHandler-&gt;setDatabase($database); // static
</code></pre>
</div>
<div class="section" id="database-table">
<h4>Database Table</h4>
<p>A basic example of a table for sessions is below:</p>
<pre><code class="language-sql " >CREATE TABLE `Sessions` (
    `id` varchar(128) NOT NULL,
    `timestamp` timestamp NOT NULL,
    `data` blob NOT NULL,
    `ip` varchar(45) NOT NULL, -- optional
    `ua` varchar(255) NOT NULL, -- optional
    PRIMARY KEY (`id`),
    KEY `timestamp` (`timestamp`),
    KEY `ip` (`ip`), -- optional
    KEY `ua` (`ua`) -- optional
);
</code></pre>
</div>
</div>
</div>
<div class="section" id="files-handler">
<h3>Files Handler</h3>
<p>Allows you to store session data as files in a directory.</p>
<pre><code class="language-php " >use Framework\Session\SaveHandlers\FilesHandler;
$saveHandler = new FilesHandler($configs);
</code></pre>
<p>These are the FilesHandler configs:</p>
<pre><code class="language-php " >$configs = [
    // The directory path where the session files will be saved
    &#039;directory&#039; =&gt; &#039;&#039;,
    // A custom directory name inside the `directory` path
    &#039;prefix&#039; =&gt; &#039;&#039;,
    // Match IP?
    &#039;match_ip&#039; =&gt; false,
    // Match User-Agent?
    &#039;match_ua&#039; =&gt; false,
];
</code></pre>
</div>
<div class="section" id="memcached-handler">
<h3>Memcached Handler</h3>
<p>Allows you to store session data on Memcached servers.</p>
<pre><code class="language-php " >use Framework\Session\SaveHandlers\MemcachedHandler;
$saveHandler = new MemcachedHandler($configs);
</code></pre>
<p>These are the MemcachedHandler configs:</p>
<pre><code class="language-php " >$configs = [
    // A custom prefix prepended in the keys
    &#039;prefix&#039; =&gt; &#039;&#039;,
    // A list of Memcached servers
    &#039;servers&#039; =&gt; [
        [
            &#039;host&#039; =&gt; &#039;127.0.0.1&#039;, // host always is required
            &#039;port&#039; =&gt; 11211, // port is optional, default to 11211
            &#039;weight&#039; =&gt; 0, // weight is optional, default to 0
        ],
    ],
    // An associative array of Memcached::OPT_* constants
    &#039;options&#039; =&gt; [
        Memcached::OPT_BINARY_PROTOCOL =&gt; true,
    ],
    // Maximum attempts to try lock a session id
    &#039;lock_attempts&#039; =&gt; 60,
    // Interval between the lock attempts in microseconds
    &#039;lock_sleep&#039; =&gt; 1_000_000,
    // TTL to the lock (valid for the current session only)
    &#039;lock_ttl&#039; =&gt; 600,
    // The maxlifetime (TTL) used for cache item expiration
    &#039;maxlifetime&#039; =&gt; null, // Null to use the ini value of session.gc_maxlifetime
    // Match IP?
    &#039;match_ip&#039; =&gt; false,
    // Match User-Agent?
    &#039;match_ua&#039; =&gt; false,
];
</code></pre>
<div class="section" id="memcached-instance">
<h4>Memcached Instance</h4>
<p>It is also possible to pass an instance of the Memcached class directly, as in
the example below:</p>
<pre><code class="language-php " >use Framework\Session\SaveHandlers\MemcachedHandler;
$memcached = new Memcached();
$saveHandler = new MemcachedHandler();
$saveHandler-&gt;setMemcached($memcached); // static
</code></pre>
</div>
</div>
<div class="section" id="redis-handler">
<h3>Redis Handler</h3>
<p>Allows you to store session data on a Redis server.</p>
<pre><code class="language-php " >use Framework\Session\SaveHandlers\RedisHandler;
$saveHandler = new RedisHandler($configs);
</code></pre>
<p>These are the RedisHandler configs:</p>
<pre><code class="language-php " >$configs = [
    // A custom prefix prepended in the keys
    &#039;prefix&#039; =&gt; &#039;&#039;,
    // The Redis host
    &#039;host&#039; =&gt; &#039;127.0.0.1&#039;,
    // The Redis host port
    &#039;port&#039; =&gt; 6379,
    // The connection timeout
    &#039;timeout&#039; =&gt; 0.0,
    // Optional auth password
    &#039;password&#039; =&gt; null,
    // Optional database to select
    &#039;database&#039; =&gt; null,
    // Maximum attempts to try lock a session id
    &#039;lock_attempts&#039; =&gt; 60,
    // Interval between the lock attempts in microseconds
    &#039;lock_sleep&#039; =&gt; 1_000_000,
    // TTL to the lock (valid for the current session only)
    &#039;lock_ttl&#039; =&gt; 600,
    // The maxlifetime (TTL) used for cache item expiration
    &#039;maxlifetime&#039; =&gt; null, // Null to use the ini value of session.gc_maxlifetime
    // Match IP?
    &#039;match_ip&#039; =&gt; false,
    // Match User-Agent?
    &#039;match_ua&#039; =&gt; false,
];
</code></pre>
<div class="section" id="redis-instance">
<h4>Redis Instance</h4>
<p>It is also possible to pass an instance of the Redis class directly, as in the
example below:</p>
<pre><code class="language-php " >use Framework\Session\SaveHandlers\RedisHandler;
$redis = new Redis();
$saveHandler = new RedisHandler();
$saveHandler-&gt;setRedis($redis); // static
</code></pre>
</div>
</div>
<div class="section" id="conclusion">
<h2>Conclusion</h2>
<p>Webisters Session Library is an easy-to-use tool for, beginners and experienced, PHP developers.<br>It is perfect for saving user sessions that can be easily scalable.<br>The more you use it, the more you will learn.</p>
<div class="phpdocumentor-admonition -note ">
            <svg class="phpdocumentor-admonition__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path></svg>
                    <article>
        <p>Did you find something wrong?<br>Be sure to let us know about it with an
<a href="https://github.com/webisters/session/issues">issue</a>.<br>Thank you!</p>
    </article>
</div>
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
