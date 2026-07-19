<?php
$pageTitle = 'Webisters Docs';
require_once __DIR__ . '/../../../includes/header.php';
require_once __DIR__ . '/../../../includes/sidebar.php';
?>
<div class="section" id="log">
<h1>Log</h1>
<p>Webisters Log Library.</p>
<ul>
    <li>
            <a href="#installation">Installation</a>
        </li>
    <li>
            <a href="#getting-started">Getting Started</a>
        </li>
    <li>
            <a href="#log-levels">Log Levels</a>
        </li>
    <li>
            <a href="#loggers">Loggers</a>
        </li>
    <li>
            <a href="#conclusion">Conclusion</a>
        </li>
</ul>
<div class="section" id="installation">
<h2>Installation</h2>
<p>The installation of this library can be done with Composer:</p>
<pre><code class="language- " >composer require Webisters/log
</code></pre>
</div>
<div class="section" id="getting-started">
<h2>Getting Started</h2>
<p>The Log Library allows you to save logs in several ways.</p>
<p>In the constructor of the Logger class it is possible to set the <strong>destination</strong>,
the <strong>level</strong> and configurations through the <strong>config</strong> parameter.</p>
<p>Let&#039;s see an example saving logs with CRITICAL level (5) or higher in the app.log
file:</p>
<pre><code class="language-php " >use Framework\Log\Loggers\FileLogger;
use Framework\Log\LogLevel;
$destination = __DIR__ . &#039;/app.log&#039;;
$level = LogLevel::CRITICAL;
$logger = new FileLogger($destination, $level);
$logger-&gt;logDebug(&#039;Debug message&#039;); // bool
$logger-&gt;logCritical(&#039;Critical message&#039;); // bool
$logger-&gt;logAlert(&#039;Alert message&#039;); // bool
</code></pre>
<p>Note that logs with a level lower than CRITICAL (5) are not saved in the
destination.</p>
</div>
<div class="section" id="log-levels">
<h2>Log Levels</h2>
<p>Logs can be defined at eight different levels:</p>
<ul>
    <li>
            <a href="#debug">DEBUG</a>
        </li>
    <li>
            <a href="#info">INFO</a>
        </li>
    <li>
            <a href="#notice">NOTICE</a>
        </li>
    <li>
            <a href="#warning">WARNING</a>
        </li>
    <li>
            <a href="#error">ERROR</a>
        </li>
    <li>
            <a href="#critical">CRITICAL</a>
        </li>
    <li>
            <a href="#alert">ALERT</a>
        </li>
    <li>
            <a href="#emergency">EMERGENCY</a>
        </li>
</ul>
<div class="section" id="debug">
<h3>DEBUG</h3>
<p>Level 0: Detailed debug information.</p>
</div>
<div class="section" id="info">
<h3>INFO</h3>
<p>Level 1: Interesting events.</p>
<p>Example: User logs in, SQL logs.</p>
</div>
<div class="section" id="notice">
<h3>NOTICE</h3>
<p>Level 2: Normal but significant events.</p>
</div>
<div class="section" id="warning">
<h3>WARNING</h3>
<p>Level 3: Exceptional occurrences that are not errors.</p>
<p>Example: Use of deprecated APIs, poor use of an API, undesirable things
that are not necessarily wrong.</p>
</div>
<div class="section" id="error">
<h3>ERROR</h3>
<p>Level 4: Runtime errors that do not require immediate action but should
typically be logged and monitored.</p>
</div>
<div class="section" id="critical">
<h3>CRITICAL</h3>
<p>Level 5: Critical conditions.</p>
<p>Example: Application component unavailable, unexpected exception.</p>
</div>
<div class="section" id="alert">
<h3>ALERT</h3>
<p>Level 6: Action must be taken immediately.</p>
<p>Example: Entire website down, database unavailable, etc. This should
trigger the SMS alerts and wake you up.</p>
</div>
<div class="section" id="emergency">
<h3>EMERGENCY</h3>
<p>Level 7: System is unusable.</p>
</div>
</div>
<div class="section" id="loggers">
<h2>Loggers</h2>
<p>The Log Library has five different loggers:</p>
<ul>
    <li>
            <a href="#email-logger">Email Logger</a>
        </li>
    <li>
            <a href="#file-logger">File Logger</a>
        </li>
    <li>
            <a href="#multi-file-logger">Multi File Logger</a>
        </li>
    <li>
            <a href="#sapi-logger">SAPI Logger</a>
        </li>
    <li>
            <a href="#sys-logger">Sys Logger</a>
        </li>
</ul>
<div class="section" id="email-logger">
<h3>Email Logger</h3>
<p>The message is sent by email to the address in the destination parameter.</p>
<pre><code class="language-php " >use Framework\Log\Loggers\EmailLogger;
$destination = &#039;<a href="../cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="deada7adbfbab3b7b09ebab1b3bfb7b0f0aab2ba">[email&#160;protected]</a>&#039;;
$logger = new EmailLogger($destination);
</code></pre>
<p>In the third parameter of the constructor, config, you can set custom headers
for the message:</p>
<pre><code class="language-php " >$logger = new EmailLogger($destination, config: [
    &#039;headers&#039; =&gt; [
        &#039;From&#039; =&gt; &#039;<a href="../cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="94e7ede7e0f1f9d4f0fbf9f5fdfabae0f8f0">[email&#160;protected]</a>&#039;,
        &#039;Subject&#039; =&gt; &#039;System Log&#039;,
    ],
]);
</code></pre>
</div>
<div class="section" id="file-logger">
<h3>File Logger</h3>
<p>The message is appended to the file destination.</p>
<pre><code class="language-php " >use Framework\Log\Loggers\FileLogger;
$destination = __DIR__ . &#039;/app.log&#039;;
$logger = new FileLogger($destination);
</code></pre>
</div>
<div class="section" id="multi-file-logger">
<h3>Multi File Logger</h3>
<p>The message is appended to a file with the date in the filename with a directory
as destination.</p>
<pre><code class="language-php " >use Framework\Log\Loggers\MultiFileLogger;
$destination = __DIR__ . &#039;/logs&#039;;
$logger = new MultiFileLogger($destination);
</code></pre>
<p>The filename has the following format: <code>Y-m-d.log</code></p>
</div>
<div class="section" id="sapi-logger">
<h3>SAPI Logger</h3>
<p>The message is sent directly to the SAPI logging handler.</p>
<pre><code class="language-php " >use Framework\Log\Loggers\SAPILogger;
$logger = new SAPILogger();
</code></pre>
</div>
<div class="section" id="sys-logger">
<h3>Sys Logger</h3>
<p>The message is sent to PHP&#039;s system logger, using the Operating System&#039;s system
logging mechanism or a file.</p>
<pre><code class="language-php " >use Framework\Log\Loggers\SysLogger;
$logger = new SysLogger();
</code></pre>
</div>
</div>
<div class="section" id="conclusion">
<h2>Conclusion</h2>
<p>Webisters Log Library is an easy-to-use tool for, beginners and experienced, PHP developers.<br>It is perfect for saving logs with different destinations.<br>The more you use it, the more you will learn.</p>
<div class="phpdocumentor-admonition -note ">
            <svg class="phpdocumentor-admonition__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path></svg>
                    <article>
        <p>Did you find something wrong?<br>Be sure to let us know about it with an
<a href="https://github.com/webisters/log/issues">issue</a>.<br>Thank you!</p>
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
