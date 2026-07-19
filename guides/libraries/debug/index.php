<?php
$pageTitle = 'Webisters Docs';
require_once __DIR__ . '/../../../includes/header.php';
require_once __DIR__ . '/../../../includes/sidebar.php';
?>
<div class="section" id="debug">
<h1>Debug</h1>
<p>Webisters Debug Library.</p>
<ul>
    <li>
            <a href="#installation">Installation</a>
        </li>
    <li>
            <a href="#exception-handler">Exception Handler</a>
        </li>
    <li>
            <a href="#debugger">Debugger</a>
        </li>
    <li>
            <a href="#conclusion">Conclusion</a>
        </li>
</ul>
<div class="section" id="installation">
<h2>Installation</h2>
<p>The installation of this library can be done with Composer:</p>
<pre><code class="language- " >composer require Webisters/debug
</code></pre>
</div>
<div class="section" id="exception-handler">
<h2>Exception Handler</h2>
<p>The ExceptionHandler class acts by catching exceptions and shows a screen
according to the environment, production or development.</p>
<p>Optionally, it can receive an instance of a logger to save messages from
exceptions.</p>
<p>In the example below, we see a basic configuration to initialize by setting the
object as an exception handler in a production environment:</p>
<pre><code class="language-php " >use Framework\Debug\ExceptionHandler;
use Framework\Log\Loggers\SysLogger;
$logger = new SysLogger();
$exceptionHandler = new ExceptionHandler(
    ExceptionHandler::PRODUCTION,
    $logger
);
$exceptionHandler-&gt;initialize();
</code></pre>
<p>In the <code>initialize</code> method it is possible to pass a argument to also set the
object as the error handler, which is the default. If you don&#039;t want to set it
as an error handler, pass the first argument to false:</p>
<pre><code class="language-php " >$exceptionHandler-&gt;initialize(false);
</code></pre>
<div class="section" id="production-environment">
<h3>Production Environment</h3>
<p>When the environment is production, a simple screen will appear informing that
something went wrong and, if the logger is set, the log id will appear:</p>
<pre><code class="language-php " >use Framework\Database\Database;
$database = new Database(&#039;root&#039;, &#039;lupalupa&#039;, logger: $logger);
</code></pre>
<img
    src="../guides/libraries/debug/img/exception-production.png"
                alt="Webisters Debug - Exception Handler in Production"    />
<p>It is possible to customize this screen by setting a view file using the
<code>setProductionView</code> method. See the original files inside the
<strong>src/Views/exceptions</strong> directory.</p>
<div class="section" id="show-log-id">
<h4>Show Log Id</h4>
<p>By default, the log id is shown in the production view.</p>
<p>If for some reason you don&#039;t want the log id to be shown, disable it as per the
example below:</p>
<pre><code class="language-php " >$exceptionHandler-&gt;setShowLogId(false);
</code></pre>
</div>
</div>
<div class="section" id="development-environment">
<h3>Development Environment</h3>
<p>When the ExceptionHandler environment is set to development, a screen is shown
with much more details about the exception; the message, file location and line
number, trace, server input information, and the latest log.</p>
<pre><code class="language-php " >$exceptionHandler = new ExceptionHandler(
    ExceptionHandler::DEVELOPMENT,
    $logger
);
</code></pre>
<p>Example:</p>
<img
    src="../guides/libraries/debug/img/exception-development.png"
                alt="Webisters Debug - Exception Handler in Development"    />
<p>The development view can also be customized. Set the file path via the
<code>setDevelopmentView</code> method.</p>
<div class="section" id="hidden-inputs">
<h4>Hidden Inputs</h4>
<p>All input global variables (<code>$_COOKIE</code>, <code>$_ENV</code>, <code>$_FILES</code>, <code>$_GET</code>,
<code>$_POST</code> and <code>$_SERVER</code>) are shown on the exception page under development.</p>
<p>If you want to hide any of them, do so as per the following example:</p>
<pre><code class="language-php " >$exceptionHandler-&gt;setHiddenInputs(&#039;$_ENV&#039;, &#039;$_POST&#039;);
</code></pre>
</div>
<div class="section" id="search-engine">
<h4>Search Engine</h4>
<p>On the development page there is a link to search for the exception in a search
engine.</p>
<p>You can choose between several predefined engines:</p>
<ul>
    <li>
            <a href="https://www.ask.com/web?q=Webisters+framework">ask</a>
        </li>
    <li>
            <a href="https://www.baidu.com/s?wd=Webisters+framework">baidu</a>
        </li>
    <li>
            <a href="https://www.bing.com/search?q=Webisters+framework">bing</a>
        </li>
    <li>
            <a href="https://duckduckgo.com/?q=Webisters+framework">duckduckgo</a>
        </li>
    <li>
            <a href="https://www.google.com/search?q=Webisters+framework">google</a>
        </li>
    <li>
            <a href="https://search.yahoo.com/search?p=Webisters+framework">yahoo</a>
        </li>
    <li>
            <a href="https://yandex.com/search/?text=Webisters+framework">yandex</a>
        </li>
</ul>
<p>The default engine is <code>google</code>.</p>
<p>If you want to change to another engine, do as in the example below:</p>
<pre><code class="language-php " >$exceptionHandler-&gt;getSearchEngines()-&gt;setCurrent(&#039;bing&#039;);
</code></pre>
</div>
</div>
<div class="section" id="command-line">
<h3>Command Line</h3>
<p>When the exception is thrown on the command line, it will be shown as in the
example below:</p>
<img
    src="../guides/libraries/debug/img/exception-cli.png"
                alt="Webisters Debug - Exception Handler in CLI"    />
</div>
<div class="section" id="language">
<h3>Language</h3>
<p>ExceptionHandler texts can be customized, using an instance of the Language
class, which can be passed by the constructor or the setter:</p>
<pre><code class="language-php " >use Framework\Language\Language;
$language = new Language(&#039;es&#039;);
$exceptionHandler-&gt;setLanguage($language);
</code></pre>
<p>Example of the exception page in production with the Spanish language:</p>
<img
    src="../guides/libraries/debug/img/exception-production-es.png"
                alt="Webisters Debug - Exception Handler in Production with Spanish language"    />
</div>
<div class="section" id="json-responses">
<h3>JSON Responses</h3>
<p>If the server variable <code>$_SERVER['HTTP_ACCEPT']</code> contains <code>application/json</code>
or the variable <code>$_SERVER['HTTP_CONTENT_TYPE']</code> starts with <code>application/json</code>
the exception response page will be a page with JSON.</p>
<p>Below is an example of what the body of the responses will look like:</p>
<div class="section" id="json-in-production">
<h4>JSON in Production</h4>
<p>The production page is very simple. Remember that the log id can be disabled:</p>
<pre><code class="language-json " >{
  &quot;status&quot;: {
    &quot;code&quot;: 500,
    &quot;reason&quot;: &quot;Internal Server Error&quot;
  },
  &quot;data&quot;: {
    &quot;message&quot;: &quot;Something went wrong. Please, back later.&quot;,
    &quot;log_id&quot;: &quot;632617344ccd&quot;
  }
}
</code></pre>
</div>
<div class="section" id="json-in-development">
<h4>JSON in Development</h4>
<p>The development page contains detailed information about the exception:</p>
<pre><code class="language-json " >{
  &quot;status&quot;: {
    &quot;code&quot;: 500,
    &quot;reason&quot;: &quot;Internal Server Error&quot;
  },
  &quot;data&quot;: {
    &quot;exception&quot;: &quot;mysqli_sql_exception&quot;,
    &quot;message&quot;: &quot;Access denied for user &#039;root&#039;@&#039;localhost&#039;&quot;,
    &quot;file&quot;: &quot;/var/www/app/vendor/Webisters/database/src/Database.php&quot;,
    &quot;line&quot;: 230,
    &quot;trace&quot;: [
      {
        &quot;file&quot;: &quot;/var/www/app/vendor/Webisters/database/src/Database.php&quot;,
        &quot;line&quot;: 230,
        &quot;function&quot;: &quot;real_connect&quot;,
        &quot;class&quot;: &quot;mysqli&quot;,
        &quot;type&quot;: &quot;-&gt;&quot;
      },
      {
        &quot;file&quot;: &quot;/var/www/app/vendor/Webisters/database/src/Database.php&quot;,
        &quot;line&quot;: 103,
        &quot;function&quot;: &quot;connect&quot;,
        &quot;class&quot;: &quot;Framework\\Database\\Database&quot;,
        &quot;type&quot;: &quot;-&gt;&quot;
      },
      {
        &quot;file&quot;: &quot;/var/www/app/public/index.php&quot;,
        &quot;line&quot;: 19,
        &quot;function&quot;: &quot;__construct&quot;,
        &quot;class&quot;: &quot;Framework\\Database\\Database&quot;,
        &quot;type&quot;: &quot;-&gt;&quot;
      }
    ],
    &quot;log_id&quot;: &quot;01884d106dd9&quot;
  }
}
</code></pre>
</div>
<div class="section" id="json-flags">
<h4>JSON Flags</h4>
<p>The default flags for encoding JSON data are:</p>
<pre><code class="language-php " >$flags = JSON_THROW_ON_ERROR | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE;
</code></pre>
<p>You can customize them as per the following example:</p>
<pre><code class="language-php " >$flags = JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT;
$exceptionHandler-&gt;setJsonFlags($flags);
</code></pre>
</div>
</div>
<div class="section" id="debugger">
<h2>Debugger</h2>
<p>The <code>Framework\Debug\Debugger</code> class has methods to help debug and, mainly,
render the debugbar.</p>
<pre><code class="language-php " >&lt;?php
require __DIR__ . &#039;/../vendor/autoload.php&#039;;
use Framework\Debug\Debugger;
$debugger = new Debugger();
echo $debugger-&gt;renderDebugbar();
</code></pre>
<p>The first time you render the debug bar it will be collapsed to the bottom left
of the page:</p>
<img
    src="../guides/libraries/debug/img/debugbar-empty-closed.png"
                alt="Webisters Debug - Debugbar Closed"    />
<p>When you click on the debug bar image, it will extend to the right of the page,
showing the &quot;info&quot; button:</p>
<img
    src="../guides/libraries/debug/img/debugbar-empty-open.png"
                alt="Webisters Debug - Debugbar Open and Empty"    />
<p>When you click on the info button, the panel will open and you will be able to
see some debug information:</p>
<img
    src="../guides/libraries/debug/img/debugbar-info-empty.png"
                alt="Webisters Debug - Open With Info Empty"    />
<div class="section" id="collections">
<h3>Collections</h3>
<p>Collections with information collected from various services can be added to the
debug bar.</p>
<p>See below how to create a collection:</p>
<pre><code class="language-php " >use Framework\Debug\Collection;
...
class DatabaseCollection extends Collection
{
}
$collection = new DatabaseCollection(&#039;Database&#039;);
$debugger-&gt;addCollection($collection);
</code></pre>
<p>The &quot;Database&quot; collection is created and added to the Debugger.</p>
<div class="section" id="collection-icon">
<h4>Collection Icon</h4>
<p>All collections can have an icon. Its path can be defined as in the example
below:</p>
<pre><code class="language-php " >class DatabaseCollection extends Collection
{
    protected string $iconPath = __DIR__ . &#039;/database.svg&#039;;
}
</code></pre>
<p>Icons downloaded from <a href="https://fontawesome.com/v5/download">Font Awesome</a> are
used in the Webisters libraries.</p>
<p>You can choose any icon you want from an SVG image. Copy and paste it into your
project.</p>
<p>To make the icon color change according to the text color, open the SVG file and
look for the <code>path</code> tag. In it, add the attribute <code>fill="currentColor"</code> as
shown in the example below and save the image.</p>
<pre><code class="language-svg " >&lt;svg ...&gt;...&lt;path fill=&quot;currentColor&quot; d=&quot;...&quot;/&gt;&lt;/svg&gt;
</code></pre>
<p>Next you will see the collection icon in action.</p>
</div>
</div>
</div>
<div class="section" id="collectors">
<h3>Collectors</h3>
<p>Every collection must have debug data collectors, which should be displayed in
the panel content.</p>
<p>See below how to add a collector to the collection:</p>
<pre><code class="language-php " >use Framework\Debug\Collector;
...
class DatabaseCollector extends Collector
{
    public function getContents() : string
    {
        return &#039;Collector: &#039; . $this-&gt;getName();
    }
}
$defaultCollector = new DatabaseCollector();
$collection-&gt;addCollector($defaultCollector);
</code></pre>
<p>Once done, the collection will appear in the debugbar with its icon and name:</p>
<img
    src="../guides/libraries/debug/img/debugbar-collector-default-closed.png"
                alt="Webisters Debug - Debugbar With Default Collector"    />
<p>After clicking the collection button, a panel will open showing its contents:</p>
<img
    src="../guides/libraries/debug/img/debugbar-collector-default-open.png"
                alt="Webisters Debug - Debugbar With Default Collector"    />
<p>You can add as many collectors as you want.</p>
<p>The example below shows how to add another collector. Think of it as another
instance connecting to a different database:</p>
<pre><code class="language-php " >...
$otherCollector = new DatabaseCollector(&#039;other&#039;);
$collection-&gt;addCollector($otherCollector);
</code></pre>
<p>Note that in the upper right part of the panel, a selection menu will appear in
which you can change the collector that is shown in the panel contents:</p>
<img
    src="../guides/libraries/debug/img/debugbar-collector-other-open.png"
                alt="Webisters Debug - Debugbar With Other Collector"    />
<div class="section" id="collector-activities">
<h4>Collector Activities</h4>
<p>Every collector can collect activity data that can be displayed in the content
panel, the information panel, or both.</p>
<p>See below how to return activities that will be merged between all debugger
collectors and will appear in the info panel:</p>
<pre><code class="language-php " >&lt;?php
...
class DatabaseCollector extends Collector
{
    public function getActivities() : array
    {
        $activities = [];
        foreach ($this-&gt;getData() as $index =&gt; $data) {
            $activities[] = [
                &#039;collector&#039; =&gt; $this-&gt;getName(),
                &#039;class&#039; =&gt; static::class,
                &#039;description&#039; =&gt; &#039;Statement &#039; . ($index + 1),
                &#039;start&#039; =&gt; $data[&#039;start&#039;],
                &#039;end&#039; =&gt; $data[&#039;end&#039;],
                &#039;statement&#039; =&gt; $data[&#039;statement&#039;],
            ];
        }
        return $activities;
    }
}
</code></pre>
</div>
<div class="section" id="collector-contents">
<h4>Collector Contents</h4>
<p>So far, we&#039;ve seen a very simple panel, showing only the collector&#039;s name.</p>
<p>In the example below, we will update the <code>getContents</code> method to return only
the collector name if there are no activities and a table with details if there
are activities:</p>
<pre><code class="language-php " >&lt;?php
...
class DatabaseCollector extends Collector
{
    ...
    public function getContents() : string
    {
        ob_start();
        ?&gt;
        &lt;p&gt;Collector: &lt;?= $this-&gt;getName() ?&gt;&lt;/p&gt;
        &lt;?php
        $activities = $this-&gt;getActivities();
        if (empty($activities)) {
            return ob_get_clean();
        }
        ?&gt;
        &lt;table&gt;
            &lt;thead&gt;
            &lt;tr&gt;
                &lt;th&gt;#&lt;/th&gt;
                &lt;th&gt;Statement&lt;/th&gt;
                &lt;th&gt;Time&lt;/th&gt;
            &lt;/tr&gt;
            &lt;/thead&gt;
            &lt;tbody&gt;
            &lt;?php foreach ($activities as $index =&gt; $activity) : ?&gt;
                &lt;tr&gt;
                    &lt;td&gt;&lt;?= $index + 1 ?&gt;&lt;/td&gt;
                    &lt;td&gt;
                        &lt;pre class=&quot;language-sql&quot;&gt;&lt;code&gt;&lt;?= htmlentities($activity[&#039;statement&#039;]) ?&gt;&lt;/code&gt;&lt;/pre&gt;
                    &lt;/td&gt;
                    &lt;td&gt;&lt;?= Debugger::roundSecondsToMilliseconds($activity[&#039;end&#039;] - $activity[&#039;start&#039;]) ?&gt;&lt;/td&gt;
                &lt;/tr&gt;
            &lt;?php endforeach ?&gt;
            &lt;/tbody&gt;
        &lt;/table&gt;
        &lt;?php
        return ob_get_clean();
    }
}
</code></pre>
<p>The panel hasn&#039;t changed visually because no data has been collected:</p>
<img
    src="../guides/libraries/debug/img/debugbar-collector-default-open.png"
                alt="Webisters Debug - Debugbar Collector With No Statement"    />
<p>Next, we&#039;ll see how to collect data and how it will be presented within the
table.</p>
</div>
<div class="section" id="collecting-data">
<h4>Collecting Data</h4>
<p>See the example below for how to collect data from a database connection:</p>
<pre><code class="language-php " >$mysqli = new mysqli(&#039;localhost&#039;, &#039;root&#039;, &#039;password&#039;, &#039;test&#039;);
$statement = &#039;SELECT * FROM `users` WHERE `id` = 1&#039;;
$start = microtime(true);
$result = $mysqli-&gt;query($statement);
$end = microtime(true);
$defaultCollector-&gt;addData([
    &#039;start&#039; =&gt; $start,
    &#039;end&#039; =&gt; $end,
    &#039;statement&#039; =&gt; $statement,
]);
$statement =&#039;SELECT * FROM `posts` WHERE `user_id` = 5&#039;;
$start = microtime(true);
$result = $mysqli-&gt;query($statement);
$end = microtime(true);
$defaultCollector-&gt;addData([
    &#039;start&#039; =&gt; $start,
    &#039;end&#039; =&gt; $end,
    &#039;statement&#039; =&gt; $statement,
]);
</code></pre>
<p>Note that the data was collected only by the &quot;default&quot; collector.</p>
<p>If you have another connection you can collect data with the collector &quot;other&quot;
or any other name.</p>
<p>See below how the contents were rendered in the &quot;default&quot; collector panel in the
&quot;Database&quot; collection:</p>
<img
    src="../guides/libraries/debug/img/debugbar-collector-with-statements.png"
                alt="Webisters Debug - Debugbar Collector With Statements"    />
<p>And also, the collected activities will appear in the info panel:</p>
<img
    src="../guides/libraries/debug/img/debugbar-info-with-activities.png"
                alt="Webisters Debug - Debugbar Info With Activities"    />
</div>
</div>
<div class="section" id="options">
<h3>Options</h3>
<p>The debugger allows for several customizations to make the debug bar fit your
brand.</p>
<p>The available options are:</p>
<ul>
    <li>
            <a href="#icon-path">Icon Path</a>
        </li>
    <li>
            <a href="#primary-color">Primary Color</a>
        </li>
    <li>
            <a href="#info-contents">Info Contents</a>
        </li>
</ul>
<div class="section" id="icon-path">
<h4>Icon Path</h4>
<p>Using the <code>icon_path</code> option you can set a different icon:</p>
<pre><code class="language-php " >$debugger-&gt;setOption(&#039;icon_path&#039;, __DIR__ . &#039;/logo-circle.png&#039;);
</code></pre>
<img
    src="../guides/libraries/debug/img/debugbar-custom-icon.png"
                alt="Webisters Debug - Debugbar With Custom Icon"    />
</div>
<div class="section" id="primary-color">
<h4>Primary Color</h4>
<p>Using the <code>color</code> option you can set a different primary color:</p>
<pre><code class="language-php " >$debugger-&gt;setOption(&#039;color&#039;, &#039;#00a5e3&#039;);
</code></pre>
<img
    src="../guides/libraries/debug/img/debugbar-custom-color.png"
                alt="Webisters Debug - Debugbar With Custom Color"    />
</div>
<div class="section" id="info-contents">
<h4>Info Contents</h4>
<p>Using the <code>info_contents</code> option, you can set different content for the info:</p>
<pre><code class="language-php " >$debugger-&gt;setOption(
    &#039;info_contents&#039;,
    &#039;&lt;p&gt;★ &lt;a href=&quot;https://domain.tld&quot;&gt;Your website link here&lt;/a&gt;&lt;/p&gt;&#039;
);
</code></pre>
<img
    src="../guides/libraries/debug/img/debugbar-custom-info-contents.png"
                alt="Webisters Debug - Debugbar With Custom Info Contents"    />
<p>It is also possible to remove personalized content from the info:</p>
<pre><code class="language-php " >$debugger-&gt;setOption(&#039;info_contents&#039;, &#039;&#039;);
</code></pre>
<img
    src="../guides/libraries/debug/img/debugbar-custom-info-contents-disabled.png"
                alt="Webisters Debug - Debugbar With Custom Info Contents Disabled"    />
<p>You can toggle the debugbar by pressing the <code>Ctrl + F12</code> keys.</p>
<p>Using the <code>setDebugbarView</code> method you can set a custom debug bar view for
your brand.</p>
<p>To see the debugbar being used in a real project, try the
<a href="https://github.com/webisters/app">App Project</a>.</p>
</div>
</div>
<div class="section" id="conclusion">
<h2>Conclusion</h2>
<p>Webisters Debug Library is an easy-to-use tool for, beginners and experienced, PHP developers.<br>It is perfect for high-level debugging and exception handling.<br>The more you use it, the more you will learn.</p>
<div class="phpdocumentor-admonition -note ">
            <svg class="phpdocumentor-admonition__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path></svg>
                    <article>
        <p>Did you find something wrong?<br>Be sure to let us know about it with an
<a href="https://github.com/webisters/debug/issues">issue</a>.<br>Thank you!</p>
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
