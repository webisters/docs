<?php
$pageTitle = 'Webisters Docs';
require_once __DIR__ . '/../../../includes/header.php';
require_once __DIR__ . '/../../../includes/sidebar.php';
?>
<div class="section" id="language">
<h1>Language</h1>
<p>Webisters Language Library</p>
<ul>
    <li>
            <a href="#installation">Installation</a>
        </li>
    <li>
            <a href="#getting-started">Getting Started</a>
        </li>
    <li>
            <a href="#adding-language-lines">Adding Language lines</a>
        </li>
    <li>
            <a href="#rendering-messages">Rendering messages</a>
        </li>
    <li>
            <a href="#fallback">Fallback</a>
        </li>
    <li>
            <a href="#file-language-directories">File Language Directories</a>
        </li>
    <li>
            <a href="#localization-for-web-pages">Localization for web pages</a>
        </li>
    <li>
            <a href="#currencies-dates-and-ordinals">Currencies, dates and ordinals</a>
        </li>
    <li>
            <a href="#using-language-and-http-libraries-together">Using Language and HTTP libraries together</a>
        </li>
    <li>
            <a href="#database-integration">Database Integration</a>
        </li>
    <li>
            <a href="#conclusion">Conclusion</a>
        </li>
</ul>
<div class="section" id="installation">
<h2>Installation</h2>
<p>The installation of this library can be done with Composer:</p>
<pre><code class="language- " >composer require Webisters/language
</code></pre>
</div>
<div class="section" id="getting-started">
<h2>Getting Started</h2>
<p>The Language library is built to manage texts used for
<a href="https://en.wikipedia.org/wiki/Internationalization_and_localization">Internationalization and Localization</a>
of applications.</p>
<p>An object of the Language class can be instantiated like this:</p>
<pre><code class="language-php " >use Framework\Language\Language;
$language = new Language();
</code></pre>
<p>The default locale is <code>en</code>.</p>
<p>A different locale can be passed in the first argument of the constructor and an
array of <a href="#file-language-directories">File Language Directories</a> in the second:</p>
<pre><code class="language-php " >$language = new Language(&#039;jp&#039;, [
    __DIR__ . &#039;/Languages&#039;,
    __DIR__ . &#039;/foo&#039;,
    &#039;/usr/share/app/languages&#039;,
]);
</code></pre>
<div class="section" id="supported-locales">
<h3>Supported Locales</h3>
<p>Message lines will only be rendered in supported locales.</p>
<p>They can be set as in this example:</p>
<pre><code class="language-php " >$language-&gt;setSupportedLocales([
    &#039;es&#039;,
    &#039;pt&#039;,
    &#039;pt-br&#039;,
]); // static
</code></pre>
<p>And you can get them like this:</p>
<pre><code class="language-php " >$locales = $language-&gt;getSupportedLocales(); // array
</code></pre>
</div>
</div>
<div class="section" id="adding-language-lines">
<h2>Adding Language lines</h2>
<p>Message lines can be added at any time.</p>
<p>Let&#039;s see an example adding messages to the <code>contact</code> file, in the <code>en</code> and
<code>pt-br</code> locales:</p>
<pre><code class="language-php " >$language-&gt;addLines(&#039;en&#039;, &#039;contact&#039;, [
    &#039;name&#039; =&gt; &#039;Name&#039;,
    &#039;message&#039; =&gt; &#039;Message&#039;,
    &#039;send&#039; =&gt; &#039;Send&#039;,
    &#039;thanks&#039; =&gt; &#039;Thanks for contacting us, {name}!&#039;
])-&gt;addLines(&#039;pt-br&#039;, &#039;contact&#039;, [
    &#039;name&#039; =&gt; &#039;Nome&#039;,
    &#039;message&#039; =&gt; &#039;Mensagem&#039;,
    &#039;send&#039; =&gt; &#039;Enviar&#039;,
    &#039;thanks&#039; =&gt; &#039;Obrigado por nos contatar, {name}!&#039;,
]); // static
</code></pre>
</div>
<div class="section" id="rendering-messages">
<h2>Rendering messages</h2>
<p>It is possible to get the value of a line through the <code>Language::render</code> method.</p>
<p>In the first parameter, enter the name of the file and in the second, the name
of the line. As in the example below:</p>
<pre><code class="language-php " >echo $language-&gt;render(&#039;contact&#039;, &#039;name&#039;);
</code></pre>
<p>If the current locale is <code>en</code> it will print:</p>
<pre><code class="language- " >Name
</code></pre>
<div class="section" id="rendering-with-arguments">
<h3>Rendering with arguments</h3>
<p>The <code>thanks</code> line has the <code>{name}</code> placeholder.<br>With placeholders you can add custom values. Like, for example, to show a name:</p>
<pre><code class="language-php " >$name = &#039;John&#039;;
echo $language-&gt;render(&#039;contact&#039;, &#039;thanks&#039;, [&#039;name&#039; =&gt; $name]);
</code></pre>
<p>Will print:</p>
<pre><code class="language- " >Thanks for contacting us, John!
</code></pre>
</div>
<div class="section" id="rendering-messages-with-custom-locales-on-the-fly">
<h3>Rendering messages with custom locales on the fly</h3>
<p>In the fourth parameter of the <code>render</code> method, it is possible to set the name
of a supported locale:</p>
<pre><code class="language-php " >echo $language-&gt;render(&#039;contact&#039;, &#039;message&#039;, [], &#039;pt-br&#039;);
</code></pre>
<p>Will print:</p>
<pre><code class="language- " >Mensagem
</code></pre>
<p>Using placeholders:</p>
<pre><code class="language-php " >$name = &#039;João&#039;;
echo $language-&gt;render(&#039;contact&#039;, &#039;thanks&#039;, [&#039;name&#039; =&gt; $name], &#039;pt-br&#039;);
</code></pre>
<p>Will print:</p>
<pre><code class="language- " >Obrigado por nos contatar, João!
</code></pre>
</div>
<div class="section" id="current-locale">
<h3>Current Locale</h3>
<p>If the application has a default locale, but it is necessary to get the lines
from a different locale several times, it is more advantageous to use the
<code>Language::setCurrentLocale</code> method.</p>
<p>Once the current locale is set, all the next message lines will come to that
locale, if the line is available, otherwise it will enter the <a href="#fallback">Fallback</a> system.</p>
<p>In the example below, the default locale is still <code>en</code>. But by calling the
<code>setCurrentLocale</code> method it is no longer necessary to set the fourth parameter:</p>
<pre><code class="language-php " >$language-&gt;setCurrentLocale(&#039;pt-br&#039;); // static
echo $language-&gt;render(&#039;contact&#039;, &#039;name&#039;);
</code></pre>
<p>Will print:</p>
<pre><code class="language- " >Nome
</code></pre>
<pre><code class="language-php " >echo $language-&gt;render(&#039;contact&#039;, &#039;thanks&#039;, [&#039;name&#039; =&gt; &#039;Johnny Bravo&#039;]);
</code></pre>
<p>Will print:</p>
<pre><code class="language- " >Obrigado por nos contatar, Johnny Bravo!
</code></pre>
</div>
<div class="section" id="lang">
<h3>lang</h3>
<p>To render messages, you can also use the <code>lang</code> method. Which does the same
thing as the <code>render</code> method, but the file and line name must be concatenated
with a dot:</p>
<pre><code class="language-php " >echo $language-&gt;lang(&#039;contact.thanks&#039;, [&#039;name&#039; =&gt; $name]);
</code></pre>
</div>
</div>
<div class="section" id="fallback">
<h2>Fallback</h2>
<p>The fallback system allows rendering a non-existing line in the current locale
with a line from the parent locale, the default locale, or none.</p>
<p>The fallback levels are present in the enum <strong>Framework\Language\FallbackLevel</strong>.</p>
<ul>
    <li>
            <a href="#fallback-to-none">Fallback to None</a>
        </li>
    <li>
            <a href="#fallback-to-parent-locale">Fallback to Parent Locale</a>
        </li>
    <li>
            <a href="#fallback-to-default-locale">Fallback to Default Locale</a>
        </li>
</ul>
<div class="section" id="fallback-to-none">
<h3>Fallback to None</h3>
<p>You can disable fallback with:</p>
<pre><code class="language-php " >$language-&gt;setFallbackLevel(FallbackLevel::none); // static
</code></pre>
<p>This way, lines not found in the current locale will return a string.<br>For example: <code>contact.thanks</code>.</p>
</div>
<div class="section" id="fallback-to-parent-locale">
<h3>Fallback to Parent Locale</h3>
<p>Parent locales are, for example: <code>en</code> to <code>en-us</code> and <code>pt</code> to <code>pt-br</code>.</p>
<pre><code class="language-php " >$language-&gt;setFallbackLevel(FallbackLevel::parent); // static
</code></pre>
<p>In the example below, only lines to the <code>pt</code> locale will be added,
and calls to <code>pt-br</code> will work:</p>
<pre><code class="language-php " >$language-&gt;addLines(&#039;pt&#039;, &#039;words&#039;, [
    &#039;beautifulDay&#039; =&gt; &#039;Dia bonito.&#039;,
    &#039;busName&#039; =&gt; &#039;Nós chamamos &quot;bus&quot; de autocarro.&#039;,
]); // static
echo $language-&gt;render(&#039;beautifulDay&#039;, &#039;words&#039;, &#039;pt-br&#039;) . &#039;&lt;br&gt;&#039;;
echo $language-&gt;render(&#039;busName&#039;, &#039;words&#039;, &#039;pt-br&#039;) . &#039;&lt;br&gt;&#039;;
</code></pre>
<pre><code class="language- " >Dia bonito.&lt;br&gt;
Nós chamamos &quot;bus&quot; de autocarro.&lt;br&gt;
</code></pre>
<p>Some child languages have differences from the parent language.</p>
<p>This happens in Brazilian Portuguese, where some words have different
interpretations than Portuguese from Portugal.</p>
<p>For example, &quot;bus&quot; in Brazil is <code>ônibus</code> and in Portugal it is <code>autocarro</code>.</p>
<p>You can add specific lines for child locales. Let&#039;s see:</p>
<pre><code class="language-php " >$language-&gt;addLines(&#039;pt-br&#039;, &#039;words&#039;, [
    &#039;busName&#039; =&gt; &#039;Nós chamamos &quot;bus&quot; de ônibus.&#039;,
]); // static
echo $language-&gt;render(&#039;beautifulDay&#039;, &#039;words&#039;, &#039;pt-br&#039;) . &#039;&lt;br&gt;&#039;;
echo $language-&gt;render(&#039;busName&#039;, &#039;words&#039;, &#039;pt-br&#039;) . &#039;&lt;br&gt;&#039;;
</code></pre>
<p>Will render the message of <code>words.beautifulDay</code> found in the parent locale
<code>pt</code> and <code>words.busName</code> directly from <code>pt-br</code>:</p>
<pre><code class="language- " >Dia bonito.&lt;br&gt;
Nós chamamos &quot;bus&quot; de ônibus.&lt;br&gt;
</code></pre>
</div>
<div class="section" id="fallback-to-default-locale">
<h3>Fallback to Default Locale</h3>
<p>Language&#039;s behavior is to fetch the file from the current location.<br>If the file is not found, it looks for the parent locale.<br>If not found, it looks for the default locale.<br>If not found, the file and line names will be returned.</p>
<p>If the Fallback Level has been changed, you can set it like this:</p>
<pre><code class="language-php " >$language-&gt;setFallbackLevel(FallbackLevel::default); // static
</code></pre>
</div>
</div>
<div class="section" id="file-language-directories">
<h2>File Language Directories</h2>
<p>Language lines can be loaded automatically.</p>
<p>To do this, add a base directory:</p>
<pre><code class="language-php " >$directory = __DIR__ . &#039;/Languages&#039;;
$language-&gt;addDirectory($directory); // static
</code></pre>
<p>Inside the base directory there should be subdirectories with locale names and
inside them there should be language files that return an array.</p>
<p>Let&#039;s see an example with the language file <strong>Languages/en/contact.php</strong>:</p>
<pre><code class="language-php " >return [
    &#039;name&#039; =&gt; &#039;Name&#039;,
    &#039;message&#039; =&gt; &#039;Message&#039;,
    &#039;send&#039; =&gt; &#039;Send&#039;,
];
</code></pre>
<p>Then you can call them with the render methods:</p>
<pre><code class="language-php " >echo $language-&gt;lang(&#039;contact.message&#039;);
</code></pre>
<p>File loading may vary depending on the
<a href="https://en.wikipedia.org/wiki/Case_sensitivity#In_filesystems">Case Sensitivity</a>
of the operating systems file system.</p>
<p>For example, these two paths can be considered the same on Windows:</p>
<ul>
    <li>
            <strong>Languages/en-us/contact.php</strong>
        </li>
    <li>
            <strong>Languages/en-US/contact.php</strong>
        </li>
</ul>
<p>But they are different on Linux.</p>
<p>For greater compatibility, we advise using lowercase locale directory names and
hyphenated separations.<br>Lowercase,
<a href="https://en.wikipedia.org/wiki/Camel_case#Programming_and_coding">camel case</a>
or <a href="https://en.wikipedia.org/wiki/Snake_case">snake case</a>
for filenames and array keys.</p>
</div>
<div class="section" id="localization-for-web-pages">
<h2>Localization for web pages</h2>
<p>HTML documents can have the language specified by the <code>lang</code> attribute.</p>
<p>Let&#039;s look at an example, showing the Arabic language, <code>ar</code>.</p>
<pre><code class="language-php " >&lt;html lang=&quot;&lt;?= $language-&gt;getCurrentLocale() ?&gt;&quot;&gt;
</code></pre>
<p>Output:</p>
<pre><code class="language-html " >&lt;html lang=&quot;ar&quot;&gt;
</code></pre>
<p>It is also possible to specify the text direction through the <code>dir</code> attribute.</p>
<p>The Language class is able to identify the directionality of the current locale
automatically.</p>
<p>Let&#039;s see:</p>
<pre><code class="language-php " >&lt;html lang=&quot;&lt;?= $language-&gt;getCurrentLocale() ?&gt;&quot; dir=&quot;&lt;?=
$language-&gt;getCurrentLocaleDirection() ?&gt;&quot;&gt;
</code></pre>
<p>Will show:</p>
<pre><code class="language-html " >&lt;html lang=&quot;ar&quot; dir=&quot;rtl&quot;&gt;
</code></pre>
</div>
<div class="section" id="currencies-dates-and-ordinals">
<h2>Currencies, dates and ordinals</h2>
<div class="section" id="currencies">
<h3>Currencies</h3>
<p>Numbers with currency symbols can be obtained with the <code>Language::currency</code> method.</p>
<p>For example:</p>
<pre><code class="language-php " >echo $language-&gt;currency(10.5, &#039;USD&#039;); // US$ 10,50
echo $language-&gt;currency(10.5, &#039;JPY&#039;); // JP¥ 10
</code></pre>
<p>Note that the Language class does not do any currency conversion. Just format.</p>
</div>
<div class="section" id="dates">
<h3>Dates</h3>
<p>Dates can be rendered in multiple locales, in the following formats:</p>
<ul>
    <li>
            <a href="#short-dates">Short Dates</a>
        </li>
    <li>
            <a href="#medium-dates">Medium Dates</a>
        </li>
    <li>
            <a href="#long-dates">Long Dates</a>
        </li>
    <li>
            <a href="#full-dates">Full Dates</a>
        </li>
</ul>
<div class="section" id="short-dates">
<h4>Short Dates</h4>
<p>Second argument by default is <code>'short'</code>:</p>
<pre><code class="language-php " >echo $language-&gt;date(time());
</code></pre>
<p>It will print as in the example below:</p>
<pre><code class="language- " >8/13/18
</code></pre>
</div>
<div class="section" id="medium-dates">
<h4>Medium Dates</h4>
<p>Second argument can be <code>'medium'</code>:</p>
<pre><code class="language-php " >echo $language-&gt;date(time(), &#039;medium&#039;);
</code></pre>
<p>It will print as in the example below:</p>
<pre><code class="language- " >Aug 13, 2018
</code></pre>
</div>
<div class="section" id="long-dates">
<h4>Long Dates</h4>
<p>Second argument can be <code>'long'</code>:</p>
<pre><code class="language-php " >echo $language-&gt;date(time(), &#039;long&#039;);
</code></pre>
<p>It will print as in the example below:</p>
<pre><code class="language- " >August 13, 2018
</code></pre>
</div>
<div class="section" id="full-dates">
<h4>Full Dates</h4>
<p>Second argument can be <code>'full'</code>:</p>
<pre><code class="language-php " >echo $language-&gt;date(time(), &#039;full&#039;);
</code></pre>
<p>It will print as in the example below:</p>
<pre><code class="language- " >Monday, August 13, 2018
</code></pre>
</div>
</div>
<div class="section" id="ordinals">
<h3>Ordinals</h3>
<p>Ordinal numbers in English:</p>
<pre><code class="language-php " >$language-&gt;ordinal(1); // 1st
$language-&gt;ordinal(2); // 2nd
$language-&gt;ordinal(5); // 5th
</code></pre>
<p>Ordinal numbers in different locales:</p>
<pre><code class="language-php " >$language-&gt;ordinal(1, &#039;de&#039;); // 1º
$language-&gt;ordinal(2, &#039;fr&#039;); // 2º
$language-&gt;ordinal(5, &#039;id&#039;); // 3º
</code></pre>
</div>
</div>
<div class="section" id="using-language-and-http-libraries-together">
<h2>Using Language and HTTP libraries together</h2>
<p>Let&#039;s create a small structure to show an automatically localized page,
negotiating the User-Agent language using the
<a href="https://github.com/webisters/http">HTTP Library</a>.</p>
<p>Go to the terminal and run:</p>
<pre><code class="language- " >mkdir -p app/{languages/{en,es,pt-br},public}
cd app
composer require Webisters/{http,language}
</code></pre>
<p>This is the directory tree created:</p>
<pre><code class="language- " >app
├── languages
│   ├── en
│   ├── es
│   └── pt-br
├── public
└── vendor
</code></pre>
<p>Create the <strong>public/index.php</strong> file:</p>
<pre><code class="language-php " >&lt;?php
require __DIR__ . &#039;/../vendor/autoload.php&#039;;
use Framework\HTTP\Request;
use Framework\Language\Language;
$request = new Request();
$supported = [&#039;en&#039;, &#039;es&#039;, &#039;pt-br&#039;];
$negotiated = $request-&gt;negotiateLanguage($supported);
$language = new Language();
$language-&gt;addDirectory(__DIR__ . &#039;/../languages&#039;)
         -&gt;setSupportedLocales($supported)
         -&gt;setCurrentLocale($negotiated);
?&gt;
&lt;h1&gt;Webisters App&lt;/h1&gt;
&lt;p&gt;&lt;?= $language-&gt;lang(&#039;home.welcome&#039;) ?&gt;&lt;/p&gt;
</code></pre>
<p>If the language negotiated in the HTTP request is, for example, <code>es</code>, which
has been set as a supported locale, the Language object will try to get the value
of the <code>welcome</code> key from the array returned in the <strong>languages/es/home.php</strong> file:</p>
<p>This is the content of  <strong>languages/es/home.php</strong>:</p>
<pre><code class="language-php " >&lt;?php
return [
    &#039;welcome&#039; =&gt; &#039;¡Bienvenido!&#039;
];
</code></pre>
<p>Once this is done, up the PHP development server:</p>
<pre><code class="language- " >php -S localhost:8080 -t public/
</code></pre>
<p>In another terminal, make a request with curl:</p>
<pre><code class="language- " >curl -H &quot;Accept-Language: es&quot; http://localhost:8080
</code></pre>
<p>The content of the HTTP response will be:</p>
<pre><code class="language-html " >&lt;h1&gt;Webisters App&lt;/h1&gt;
&lt;p&gt;¡Bienvenido!&lt;/p&gt;
</code></pre>
<div class="section" id="challenge">
<h5>Challenge:</h5>
<ul>
    <li>
            Make requests with other languages.
        </li>
    <li>
            Add the default locale file.
        </li>
    <li>
            Implement an <a href="https://en.wikipedia.org/wiki/Right-to-left_script">RTL</a> page with HTML attributes and access it with a web browser.
        </li>
</ul>
</div>
</div>
<div class="section" id="database-integration">
<h2>Database Integration</h2>
<p>We will see how to fetch language messages in a database.</p>
<p>In this example, we will use the <a href="https://github.com/webisters/database">Database Library</a>
and we will extend the Language class.</p>
<p>First, we create the database schema called <strong>app</strong> and in it we will create the
table <strong>Language</strong> and we will insert some lines for testing:</p>
<pre><code class="language-php " >use Framework\Database\Database;
use Framework\Database\Definition\Table\TableDefinition;
$database = new Database(&#039;root&#039;, &#039;password&#039;);
$database-&gt;createSchema(&#039;app&#039;)-&gt;run();
$database-&gt;use(&#039;app&#039;);
$database-&gt;createTable(&#039;Languages&#039;)-&gt;definition(function (TableDefinition $def) {
    $def-&gt;column(&#039;locale&#039;)-&gt;varchar(5);
    $def-&gt;column(&#039;file&#039;)-&gt;varchar(32);
    $def-&gt;column(&#039;line&#039;)-&gt;varchar(64);
    $def-&gt;column(&#039;message&#039;)-&gt;varchar(255);
})-&gt;run();
$database-&gt;insert(&#039;Languages&#039;)-&gt;values([
    [&#039;en&#039;, &#039;home&#039;, &#039;welcome&#039;, &#039;Welcome!&#039;],
    [&#039;es&#039;, &#039;home&#039;, &#039;welcome&#039;, &#039;¡Bienvenido!&#039;],
    [&#039;pt-br&#039;, &#039;home&#039;, &#039;welcome&#039;, &#039;Bem-vindo!&#039;],
])-&gt;run();
</code></pre>
<p>Once that&#039;s done, we&#039;ll extend the Language class, adding functionality to
interact with the database:</p>
<pre><code class="language-php " >use Framework\Language\Language;
class DatabaseLanguage extends Language
{
    protected Database $database;
    protected string $databaseTable = &#039;Languages&#039;;
    public function setDatabase(Database $database) : static
    {
        $this-&gt;database = $database;
        return $this;
    }
    protected function findLines(string $locale, string $file) : static
    {
        parent::findLines($locale, $file);
        if (isset($this-&gt;database)) {
            $result = $this-&gt;database-&gt;select()
                -&gt;from($this-&gt;databaseTable)
                -&gt;whereEqual(&#039;locale&#039;, $locale)
                -&gt;whereEqual(&#039;file&#039;, $file)
                -&gt;run();
            $lines = [];
            while ($row = $result-&gt;fetch()) {
                $lines[$row-&gt;line] = $row-&gt;message;
            }
            $this-&gt;addLines($locale, $file, $lines);
        }
        return $this;
    }
}
</code></pre>
<p>So we can render the messages directly from the database:</p>
<pre><code class="language-php " >$database = new Database(&#039;root&#039;, &#039;password&#039;);
$database-&gt;use(&#039;app&#039;);
$language = new DatabaseLanguage();
$language-&gt;setDatabase($database);
echo $language-&gt;render(&#039;home&#039;, &#039;welcome&#039;);
</code></pre>
</div>
<div class="section" id="conclusion">
<h2>Conclusion</h2>
<p>Webisters Language Library is an easy-to-use tool for, beginners and experienced, PHP developers.<br>It is perfect for adapting applications to different languages.<br>The more you use it, the more you will learn.</p>
<div class="phpdocumentor-admonition -note ">
            <svg class="phpdocumentor-admonition__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path></svg>
                    <article>
        <p>Did you find something wrong?<br>Be sure to let us know about it with an
<a href="https://github.com/webisters/language/issues">issue</a>.<br>Thank you!</p>
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
                    