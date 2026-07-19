<?php
$pageTitle = 'Webisters Docs';
require_once __DIR__ . '/../../../includes/header.php';
require_once __DIR__ . '/../../../includes/sidebar.php';
?>
<div class="section" id="mvc">
<h1>MVC</h1>
<p>Webisters MVC (Model-View-Controller) Library.</p>
<ul>
    <li>
            <a href="#installation">Installation</a>
        </li>
    <li>
            <a href="#app">App</a>
        </li>
    <li>
            <a href="#services">Services</a>
        </li>
    <li>
            <a href="#models">Models</a>
        </li>
    <li>
            <a href="#entities">Entities</a>
        </li>
    <li>
            <a href="#validator">Validator</a>
        </li>
    <li>
            <a href="#views">Views</a>
        </li>
    <li>
            <a href="#controllers">Controllers</a>
        </li>
    <li>
            <a href="#conclusion">Conclusion</a>
        </li>
</ul>
<div class="section" id="installation">
<h2>Installation</h2>
<p>The installation of this library can be done with Composer:</p>
<pre><code class="language- " >composer require Webisters/mvc
</code></pre>
</div>
<div class="section" id="app">
<h2>App</h2>
<p>The App class is the MVC &quot;kernel&quot;. It is through it that an application
receives and responds to CLI and HTTP requests. It contains the various <a href="#services">services</a>
that can be called from anywhere, with multiple instances with various predefined
configurations.</p>
<p>Using it directly or <a href="#extending">extending</a> it is optional. In it, services communicate
internally and are used in <a href="#controllers">Controllers</a> and <a href="#models">Models</a>.</p>
<p>It is designed to integrate several Webisters libraries and, in a simple
way, provide a powerful application.</p>
<p>Initialization:</p>
<pre><code class="language-php " >use Framework\MVC\App;
$app = new App();
</code></pre>
<p>The App class first param can receive a
<a href="../config/index.php">Config</a>
instance, config options as array or a config directory path as string.</p>
<p>For example:</p>
<pre><code class="language-php " >$app = new App(__DIR__ . &#039;/configs&#039;);
</code></pre>
<p>After initialization, it is also possible set configurations.</p>
<p>Let&#039;s see an example using the <strong>view</strong> and <strong>database</strong> services.</p>
<p>We can use the <code>App::config</code> method:</p>
<pre><code class="language-php " >App::config()-&gt;setMany([
    &#039;view&#039; =&gt; [
        &#039;default&#039; =&gt; [
            &#039;views_dir&#039; =&gt; __DIR__ . &#039;/views&#039;,
        ],
    ],
    &#039;database&#039; =&gt; [
        &#039;default&#039; =&gt; [
            &#039;username&#039; =&gt; &#039;root&#039;,
            &#039;schema&#039; =&gt; &#039;app&#039;,
        ],
        &#039;replica&#039; =&gt; [
            &#039;host&#039; =&gt; &#039;192.168.1.10&#039;,
            &#039;username&#039; =&gt; &#039;root&#039;,
            &#039;password&#039; =&gt; &#039;Secr3tt&#039;,
            &#039;schema&#039; =&gt; &#039;app&#039;,
        ],
    ],
]);
</code></pre>
<p>Then the service config instances will be available.</p>
<p>Prints the contents of the view file <code>__DIR__ . '/views/home/index.php'</code>:</p>
<pre><code class="language-php " >echo App::view()-&gt;render(&#039;home/index&#039;);
</code></pre>
<p>Fetch all rows in the database <code>default</code> instance and move to the <code>replica</code>
instance:</p>
<pre><code class="language-php " >$result = App::database()-&gt;select()-&gt;from(&#039;Users&#039;)-&gt;run(); // Framework\Database\Result
while($user = $result-&gt;fetch()) {
    App::database(&#039;replica&#039;)-&gt;replace()-&gt;into(&#039;Users&#039;)-&gt;set($user)-&gt;run();
}
</code></pre>
<p>See config options at <a href="#services">Services</a>.</p>
<div class="section" id="running">
<h3>Running</h3>
<p>App is designed to <a href="#run-http">run HTTP</a> and <a href="#run-cli">run CLI</a> requests, sharing the same services.</p>
<div class="section" id="run-http">
<h4>Run HTTP</h4>
<p>App handles the internet Hypertext Transfer Protocol in a very easy-to-use way.</p>
<p>Let&#039;s see an example creating a little application:</p>
<p>We will need to autoload classes, so we will set default configs for the
<a href="#autoloader-service">Autoloader Service</a>.</p>
<p>This app will respond to two origins. One is the web front end. Another is the REST API.</p>
<p>The default <a href="#router-service">Router Service</a> will load one file for each origin.</p>
<p>This is the <strong>public/index.php</strong> file:</p>
<pre><code class="language-php " >use Framework\MVC\App;
(new App([
    &#039;autoloader&#039; =&gt; [
        &#039;default&#039; =&gt; [
            &#039;namespaces&#039; =&gt; [
                &#039;Api&#039; =&gt; __DIR__ . &#039;/../api&#039;,
            ],
        ],
    ],
    &#039;router&#039; =&gt; [
        &#039;default&#039; =&gt; [
            &#039;files&#039; =&gt; [
                __DIR__ . &#039;/../routes/front.php&#039;,
                __DIR__ . &#039;/../routes/api.php&#039;,
            ],
        ],
    ],
]))-&gt;runHttp(); // void
</code></pre>
<p>And now, let&#039;s create the router files:</p>
<p>The <strong>routes/front.php</strong> file is for the front end. The origin will be
<a href="https://domain.tld/">https://domain.tld</a>. Change if you want:</p>
<pre><code class="language-php " >use Framework\MVC\App;
use Framework\Routing\RouteCollection;
App::router()-&gt;serve(&#039;https://domain.tld&#039;, function (RouteCollection $routes) {
    $routes-&gt;get(&#039;/&#039;, fn () =&gt; &#039;&lt;h1&gt;Homepage&lt;/h1&gt;&#039;);
}); // static
</code></pre>
<p>The <strong>routes/api.php</strong> is for the REST API. The origin will be
<a href="https://api.domain.tld/">https://api.domain.tld</a>. Change if you need:</p>
<pre><code class="language-php " >use Framework\MVC\App;
use Framework\Routing\RouteCollection;
App::router()-&gt;serve(&#039;https://api.domain.tld&#039;, function (RouteCollection $routes) {
    $routes-&gt;get(&#039;/&#039;, fn () =&gt; App::router()-&gt;getMatchedCollection());
    $routes-&gt;post(&#039;/users&#039;, &#039;Api\UsersController::create&#039;);
    $routes-&gt;get(&#039;/users/{int}&#039;, &#039;Api\UsersController::show/0&#039;, &#039;users.show&#039;);
}, &#039;api&#039;); // static
</code></pre>
<p>This is the <strong>api/UsersController.php</strong> example:</p>
<pre><code class="language-php " >namespace Api;
use Framework\HTTP\Response;
use Framework\HTTP\ResponseHeader;
use Framework\HTTP\Status;
use Framework\MVC\App;
use Framework\MVC\Controller;
class UsersController extends Controller
{
    public function create() : Response
    {
        $data = $this-&gt;request-&gt;getPost();
        $errors = $this-&gt;validate($data, [
            &#039;name&#039; =&gt; &#039;minLength:5|maxLength:64&#039;,
            &#039;email&#039; =&gt; &#039;email&#039;,
        ]);
        if ($errors) {
            return $this-&gt;response
                -&gt;setStatus(Status::BAD_REQUEST)
                -&gt;setJson([
                    &#039;errors&#039; =&gt; $errors,
                ]);
        }
        // TODO: Create the UsersModel to insert the new user
        // ...
        $user = [
            &#039;id&#039; =&gt; rand(1, 1000000),
            &#039;name&#039; =&gt; $data[&#039;name&#039;],
            &#039;email&#039; =&gt; $data[&#039;email&#039;],
        ];
        return $this-&gt;response
            -&gt;setStatus(Status::CREATED)
            -&gt;setHeader(
                ResponseHeader::LOCATION,
                App::router()-&gt;getNamedRoute(&#039;api.users.show&#039;)
                    -&gt;getUrl(pathArgs: [$user[&#039;id&#039;]])
            )-&gt;setJson($user);
    }
}
</code></pre>
<p>After that, the application will have the following files:</p>
<ul>
    <li>
            public/index.php
        </li>
    <li>
            routes/front.php
        </li>
    <li>
            routes/api.php
        </li>
    <li>
            api/UsersController.php
        </li>
</ul>
<p>Put you server to run and access the URLs <a href="https://domain.tld/">https://domain.tld</a> and
<a href="https://api.domain.tld/">https://api.domain.tld</a>.</p>
<p>You can make a POST request with curl to <a href="https://api.domain.tld/users">https://api.domain.tld/users</a>:</p>
<pre><code class="language- " >curl -i -X POST https://api.domain.tld/users \
-H &quot;Content-Type: application/x-www-form-urlencoded&quot; \
-d &quot;name=John&amp;<a href="../cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="d6b3bbb7bfbaebbcb9beb896b0b9b9bbb7bfbaf8b5b9bb">[email&#160;protected]</a>&quot;
</code></pre>
<p>That&#039;s it. The basic HTTP application structure is created and working.</p>
<p>You can improve it with <a href="#models">Models</a>, <a href="#views">Views</a> and <a href="#controllers">Controllers</a>.</p>
</div>
<div class="section" id="run-cli">
<h4>Run CLI</h4>
<p>App handles Command-Line Interface with the <a href="#console-service">Console Service</a>.</p>
<p>Let&#039;s create the <strong>console.php</strong> file:</p>
<pre><code class="language-php " >use Framework\MVC\App;
$app = new App();
$app::config()-&gt;set(&#039;console&#039;, [
    &#039;directories&#039; =&gt; [
        __DIR__ . &#039;/commands&#039;,
    ]
]);
$app-&gt;runCli(); // void
</code></pre>
<p>Now, let&#039;s add a command in the <strong>commands/Meet.php</strong> file:</p>
<pre><code class="language-php " >use Framework\CLI\CLI;
use Framework\CLI\Command;
class Meet extends Command
{
    public function run() : void
    {
        $name = CLI::prompt(&#039;What is your name?&#039;, &#039;Tadandan&#039;);
        CLI::write(&quot;Nice to meet you, $name. I&#039;m Webisters.&quot;);
    }
}
</code></pre>
<p>Go to the terminal and run:</p>
<pre><code class="language- " >php console.php
</code></pre>
<p>The console will output <strong>meet</strong> as an available command.</p>
<p>To execute it, run:</p>
<pre><code class="language- " >php console.php meet
</code></pre>
<p>That&#039;s it.</p>
</div>
</div>
<div class="section" id="services">
<h3>Services</h3>
<p>Services are static methods in the App class. With them it is possible to make
quick calls with predefined configurations for different object instances, with
automated dependency injection.</p>
<p>App services can be extended. See <a href="#extending">Extending</a>.</p>
<p>Built-in services:</p>
<ul>
    <li>
            <a href="#anti-csrf-service">Anti-CSRF Service</a>
        </li>
    <li>
            <a href="#autoloader-service">Autoloader Service</a>
        </li>
    <li>
            <a href="#cache-service">Cache Service</a>
        </li>
    <li>
            <a href="#console-service">Console Service</a>
        </li>
    <li>
            <a href="#database-service">Database Service</a>
        </li>
    <li>
            <a href="#debugger-service">Debugger Service</a>
        </li>
    <li>
            <a href="#exception-handler-service">Exception Handler Service</a>
        </li>
    <li>
            <a href="#language-service">Language Service</a>
        </li>
    <li>
            <a href="#locator-service">Locator Service</a>
        </li>
    <li>
            <a href="#logger-service">Logger Service</a>
        </li>
    <li>
            <a href="#mailer-service">Mailer Service</a>
        </li>
    <li>
            <a href="#migrator-service">Migrator Service</a>
        </li>
    <li>
            <a href="#request-service">Request Service</a>
        </li>
    <li>
            <a href="#response-service">Response Service</a>
        </li>
    <li>
            <a href="#router-service">Router Service</a>
        </li>
    <li>
            <a href="#session-service">Session Service</a>
        </li>
    <li>
            <a href="#validation-service">Validation Service</a>
        </li>
    <li>
            <a href="#view-service">View Service</a>
        </li>
</ul>
<div class="section" id="anti-csrf-service">
<h4>Anti-CSRF Service</h4>
<p>Gets an instance of
<a href="https://docs.webisters.com/classes/Framework-HTTP-AntiCSRF.php">Framework\HTTP\AntiCSRF</a>:</p>
<pre><code class="language-php " >App::antiCsrf()
</code></pre>
<p>More details about Anti-CSRF can be found
<a href="../http/index.php#anticsrf">here</a>.</p>
<div class="section" id="anti-csrf-config-options">
<h5>Anti-CSRF Config Options</h5>
<pre><code class="language-php " >[
    &#039;antiCsrf&#039; =&gt; [
        &#039;default&#039; =&gt; [
            &#039;enabled&#039; =&gt; true,
            &#039;token_name&#039; =&gt; &#039;csrf_token&#039;,
            &#039;token_bytes_length&#039; =&gt; 8,
            &#039;generate_token_function&#039; =&gt; &#039;base64_encode&#039;,
            &#039;session_instance&#039; =&gt; &#039;default&#039;,
            &#039;request_instance&#039; =&gt; &#039;default&#039;,
        ],
    ],
]
</code></pre>
<div class="section" id="enabled">
<h6>enabled</h6>
<p>Set <code>true</code> to enable and <code>false</code> to disable. By default it is enabled.</p>
</div>
<div class="section" id="c4027f42fbababa258f3d5ecd8e80afe100c408aname">
<h6>tokenname</h6>
<p>Sets the token name. The default is <code>csrf_token</code>.</p>
</div>
<div class="section" id="7baf8d9f976a4d3f56cae66de183e6cbaab9038fd126bf3081b8d1b8bd728a7a88099004e057dce2length">
<h6>tokenbyteslength</h6>
<p>Sets the length of random bytes used to generate the token. The default is
<code>8</code>.</p>
</div>
<div class="section" id="c1889b822ece63c47e14f5a4af8dfaeb3eecf56b5f86a95b42e57726ac12fd234cbe8fc0ca5adb1bfunction">
<h6>generatetokenfunction</h6>
<p>Sets the function to generate the token. Available values are:
<code>base64_encode</code>, <code>bin2hex</code>, <code>md5</code>. The default is <code>base64_encode</code>.</p>
</div>
<div class="section" id="b08466b7671f18b8e483a9aa83f139678520a964instance">
<h6>sessioninstance</h6>
<p>Set the <a href="#session-service">Session Service</a> instance name. The default is <code>default</code>.</p>
</div>
<div class="section" id="e5fe85c965d35964e810c19d0321953716fae5ceinstance">
<h6>requestinstance</h6>
<p>Set the <a href="#request-service">Request Service</a> instance name. The default is <code>default</code>.</p>
</div>
</div>
</div>
<div class="section" id="autoloader-service">
<h4>Autoloader Service</h4>
<p>Gets an instance of
<a href="https://docs.webisters.com/classes/Framework-Autoload-Autoloader.php">Framework\Autoload\Autoloader</a>:</p>
<pre><code class="language-php " >App::autoloader()
</code></pre>
<p>More details about Autoloader can be found
<a href="../autoload/index.php#autoloader">here</a>.</p>
<div class="section" id="autoloader-config-options">
<h5>Autoloader Config Options</h5>
<pre><code class="language-php " >[
    &#039;autoloader&#039; =&gt; [
        &#039;default&#039; =&gt; [
            &#039;register&#039; =&gt; true,
            &#039;extensions&#039; =&gt; &#039;.php&#039;,
            &#039;namespaces&#039; =&gt; null,
            &#039;classes&#039; =&gt; null,
        ],
    ],
]
</code></pre>
<div class="section" id="register">
<h6>register</h6>
<p>Set <code>true</code> to register as an autoload function or <code>false</code> to disable. The
default is to leave it enabled.</p>
</div>
<div class="section" id="extensions">
<h6>extensions</h6>
<p>A comma-separated list of extensions. The default is <code>.php</code>.</p>
</div>
<div class="section" id="namespaces">
<h6>namespaces</h6>
<p>Sets the mapping from namespaces to directories. By default it is not set.</p>
</div>
<div class="section" id="classes">
<h6>classes</h6>
<p>Sets the mapping of classes to files. By default it is not set.</p>
</div>
</div>
</div>
<div class="section" id="cache-service">
<h4>Cache Service</h4>
<p>Gets an instance of
<a href="https://docs.webisters.com/classes/Framework-Cache-Cache.php">Framework\Cache\Cache</a>:</p>
<pre><code class="language-php " >App::cache()
</code></pre>
<p>More details about Cache can be found
<a href="../cache/index.php#cache">here</a>.</p>
<div class="section" id="cache-config-options">
<h5>Cache Config Options</h5>
<pre><code class="language-php " >[
    &#039;cache&#039; =&gt; [
        &#039;default&#039; =&gt; [
            &#039;class&#039; =&gt; ???, // Must be set
            &#039;configs&#039; =&gt; [],
            &#039;prefix&#039; =&gt; null,
            &#039;serializer&#039; =&gt; Framework\Cache\Serializer::PHP,
            &#039;default_ttl&#039; =&gt; null,
            &#039;logger_instance&#039; =&gt; &#039;default&#039;,
        ],
    ],
]
</code></pre>
<div class="section" id="class">
<h6>class</h6>
<p>The Fully Qualified Class Name of a class that extends <code>Framework\Cache\Cache</code>.</p>
<p>There is no default value, it must be set.</p>
</div>
<div class="section" id="configs">
<h6>configs</h6>
<p>The configurations passed to the class. By default it is an empty array.</p>
</div>
<div class="section" id="prefix">
<h6>prefix</h6>
<p>A prefix for the name of cache items. By default nothing is set.</p>
</div>
<div class="section" id="serializer">
<h6>serializer</h6>
<p>Sets the serializer with a value from the enum Framework\Cache\Serializer,
which can be a case of the enum or a string.</p>
<p>The default value is <code>Framework\Cache\Serializer::PHP</code>.</p>
</div>
<div class="section" id="51e67307ac0ca43f5ffcbf9f20037153c694fa12ttl">
<h6><a href="#default">default</a>ttl</h6>
<p>Sets the default Time To Live, in seconds, for caching items.</p>
<p>The default value is <code>null</code> to use the class value (<code>60</code>).</p>
</div>
<div class="section" id="97ca5dd8f261d2c26461bddb122b0b21c92b1572instance">
<h6>loggerinstance</h6>
<p>Set the <a href="#logger-service">Logger Service</a> instance name. If not set, the Logger instance will
not be set in the Cache class.</p>
</div>
</div>
</div>
<div class="section" id="console-service">
<h4>Console Service</h4>
<p>Gets an instance of
<a href="https://docs.webisters.com/classes/Framework-CLI-Console.php">Framework\CLI\Console</a>:</p>
<pre><code class="language-php " >App::console()
</code></pre>
<p>More details about Console can be found
<a href="../cli/index.php#console">here</a>.</p>
<div class="section" id="console-config-options">
<h5>Console Config Options</h5>
<pre><code class="language-php " >[
    &#039;console&#039; =&gt; [
        &#039;default&#039; =&gt; [
            &#039;find_in_namespaces&#039; =&gt; false,
            &#039;directories&#039; =&gt; null,
            &#039;commands&#039; =&gt; null,
            &#039;language_instance&#039; =&gt; &#039;default&#039;,
            &#039;locator_instance&#039; =&gt; &#039;default&#039;,
        ],
    ],
]
</code></pre>
<div class="section" id="23679ebc6b85e2d52e941e7cb15ddd52340ca08f56147427c700cac8b0fe6cd3a00c277fa3de356enamespaces">
<h6>findinnamespaces</h6>
<p>Set <code>true</code> to find commands in all Commands subdirectories of all namespaces.
The default is not to find in namespaces.</p>
</div>
<div class="section" id="directories">
<h6>directories</h6>
<p>Sets an array of directories where commands will be looked for. By default there
is no directory.</p>
<p>These commands are added after finding in namespaces.</p>
</div>
<div class="section" id="commands">
<h6>commands</h6>
<p>Sets an array of Fully Qualified Class Names or instances of the
Framework\CLI\Command class. By default, no additional classes are set.</p>
<p>These commands are added after finding through namespaces and directories.</p>
</div>
<div class="section" id="422880ebe08bbb4ca6fcbeb4e8286cec8bacd018instance">
<h6><a href="#language">language</a>instance</h6>
<p>Set a <a href="#language-service">Language Service</a> instance name. If not set, the Language instance will
not be set in the Console class.</p>
</div>
<div class="section" id="10f259aaca45afbef4dcbc8c8daca2a43c12bfcfinstance">
<h6>locatorinstance</h6>
<p>Set the <a href="#locator-service">Locator Service</a> instance name. By default it is <code>default</code>.</p>
</div>
</div>
</div>
<div class="section" id="database-service">
<h4>Database Service</h4>
<p>Gets an instance of
<a href="https://docs.webisters.com/classes/Framework-Database-Database.php">Framework\Database\Database</a>:</p>
<pre><code class="language-php " >App::database()
</code></pre>
<p>More details about Database can be found
<a href="../database/index.php#database">here</a>.</p>
<div class="section" id="database-config-options">
<h5>Database Config Options</h5>
<pre><code class="language-php " >[
    &#039;database&#039; =&gt; [
        &#039;default&#039; =&gt; [
            &#039;config&#039; =&gt; ???, // Must be set
            &#039;logger_instance&#039; =&gt; &#039;default&#039;,
        ],
    ],
]
</code></pre>
<div class="section" id="config">
<h6>config</h6>
<p>Set an array of configurations. Usually just the <code>username</code>, the <code>password</code>
and the <code>schema</code>.</p>
<p>The complete list of configurations can be seen
<a href="../database/index.php#connection">here</a>.</p>
</div>
<div class="section" id="3a618201737cec7536db97f278174e62f2e337c3instance">
<h6>loggerinstance</h6>
<p>Set the <a href="#logger-service">Logger Service</a> instance name. If not set, the Logger instance will
not be set in the Database class.</p>
</div>
</div>
</div>
<div class="section" id="debugger-service">
<h4>Debugger Service</h4>
<p>Gets an instance of
<a href="https://docs.webisters.com/classes/Framework-Debug-Debugger.php">Framework\Debug\Debugger</a>:</p>
<pre><code class="language-php " >App::debugger()
</code></pre>
<p>More details about Debugger can be found
<a href="../debug/index.php#debugger">here</a>.</p>
<div class="section" id="debugger-config-options">
<h5>Debugger Config Options</h5>
<pre><code class="language-php " >[
    &#039;debugger&#039; =&gt; [
        &#039;default&#039; =&gt; [
            &#039;debugbar_view&#039; =&gt; null,
            &#039;options&#039; =&gt; null,
        ],
    ],
]
</code></pre>
<div class="section" id="08f25fd5bf460788f648767105c9ce339ac02854view">
<h6>debugbarview</h6>
<p>Sets the path of a file to be used instead of the debugbar view. The default is
to use the original.</p>
</div>
<div class="section" id="options">
<h6>options</h6>
<p>Sets an array of options for the Debugger. The default is to set nothing.</p>
<p>You can find more details about the options
<a href="../debug/index.php#options">here</a>.</p>
</div>
</div>
</div>
<div class="section" id="exception-handler-service">
<h4>Exception Handler Service</h4>
<p>Gets an instance of
<a href="https://docs.webisters.com/classes/Framework-Debug-ExceptionHandler.php">Framework\Debug\ExceptionHandler</a>:</p>
<pre><code class="language-php " >App::exceptionHandler()
</code></pre>
<p>More details about Exception Handler can be found
<a href="../debug/index.php#exception-handler">here</a>.</p>
<div class="section" id="exception-handler-config-options">
<h5>Exception Handler Config Options</h5>
<pre><code class="language-php " >[
    &#039;exceptionHandler&#039; =&gt; [
        &#039;default&#039; =&gt; [
            &#039;environment&#039; =&gt; Framework\Debug\ExceptionHandler::PRODUCTION,
            &#039;logger_instance&#039; =&gt; &#039;default&#039;,
            &#039;language_instance&#039; =&gt; &#039;default&#039;,
            &#039;development_view&#039; =&gt; null,
            &#039;production_view&#039; =&gt; null,
            &#039;initialize&#039; =&gt; true,
            &#039;handle_errors&#039; =&gt; true,
            &#039;search_engine&#039; =&gt; &#039;google&#039;,
            &#039;show_log_id&#039; =&gt; true,
            &#039;json_flags&#039; =&gt; null,
            &#039;hidden_inputs&#039; =&gt; [],
        ],
    ],
]
</code></pre>
<div class="section" id="environment">
<h6>environment</h6>
<p>Set the environment, default is <strong>production</strong>. Use the <code>ExceptionHandler::DEVELOPMENT</code>
or <code>ExceptionHandler::PRODUCTION</code> constants.</p>
</div>
<div class="section" id="05a3d9f3a6693089abef82c47738c563d40e7999instance">
<h6>loggerinstance</h6>
<p>Set the <a href="#logger-service">Logger Service</a> instance name. If not set, the Logger instance will
not be set in the ExceptionHandler class.</p>
</div>
<div class="section" id="dff9eb7c3e2329b1f80ce2172d65b74ccb3489d1instance">
<h6><a href="#language">language</a>instance</h6>
<p>Set a <a href="#language-service">Language Service</a> instance name. If not set, the Language instance will
not be passed.</p>
</div>
<div class="section" id="393fd51b724222e60cd8a22301357d3fe931a6eeview">
<h6>developmentview</h6>
<p>Set the file path to a view when in the development environment.</p>
</div>
<div class="section" id="920ef5ecd5ae9a6e192bca3548cf5413c78fbb3fview">
<h6>productionview</h6>
<p>Set the file path to a view when in the production environment.</p>
</div>
<div class="section" id="initialize">
<h6>initialize</h6>
<p>Set if it is to initialize by setting the class as exception handler. The
default value is <code>true</code>.</p>
</div>
<div class="section" id="f663ed164e12865d46ab23ae3b5d2e50ea3ef617errors">
<h6>handleerrors</h6>
<p>If initialize is <code>true</code>, this option defines whether to set the class as an
error handler. The default value is <code>true</code>.</p>
</div>
<div class="section" id="9eb064223beb37d87a61d759e59c7d3f7f0408f8engine">
<h6>searchengine</h6>
<p>Set the search engine used to create search links on exception error messages.
Valid values are: <code>ask</code>, <code>baidu</code>, <code>bing</code>, <code>duckduckgo</code>, <code>google</code>,
<code>yahoo</code> and <code>yandex</code>. The default is <code>google</code>.</p>
</div>
<div class="section" id="b63a1786077730cf278ed1bbc404225ff13ffce44adccc792b3baf01f05bb7763d291d8b1ee37a8cid">
<h6>showlogid</h6>
<p>Allow to show or hide the log id in the production view. The default is <code>true</code>,
to show.</p>
</div>
<div class="section" id="6a43ff19ef8d0a4831c99ebc3421fdeb52e5f372flags">
<h6>jsonflags</h6>
<p>Set the flags to encode JSON responses.</p>
<p>The default values are: <code>JSON_THROW_ON_ERROR | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE</code>.</p>
</div>
<div class="section" id="e8a530d77fdd8108fb426a0884315f6268096ea5inputs">
<h6>hiddeninputs</h6>
<p>Set which input variables will not be shown on the exception page in development.</p>
<p>Available values are: <code>$_COOKIE</code>, <code>$_ENV</code>, <code>$_FILES</code>, <code>$_GET</code>, <code>$_POST</code> and <code>$_SERVER</code>.</p>
<p>By default, no input variables are hidden.</p>
</div>
</div>
</div>
<div class="section" id="language-service">
<h4>Language Service</h4>
<p>Gets an instance of
<a href="https://docs.webisters.com/classes/Framework-Language-Language.php">Framework\Language\Language</a>:</p>
<pre><code class="language-php " >App::language()
</code></pre>
<p>More details about Language can be found
<a href="../language/index.php#language">here</a>.</p>
<div class="section" id="language-config-options">
<h5>Language Config Options</h5>
<pre><code class="language-php " >[
    &#039;language&#039; =&gt; [
        &#039;default&#039; =&gt; [
            &#039;default&#039; =&gt; &#039;en&#039;,
            &#039;current&#039; =&gt; &#039;en&#039;,
            &#039;supported&#039; =&gt; null,
            &#039;negotiate&#039; =&gt; false,
            &#039;request_instance&#039; =&gt; &#039;default&#039;,
            &#039;fallback_level&#039; =&gt; Framework\Language\FallbackLevel::none,
            &#039;directories&#039; =&gt; [],
            &#039;find_in_namespaces&#039; =&gt; false,
            &#039;autoloader_instance&#039; =&gt; &#039;default&#039;,
        ],
    ],
]
</code></pre>
<div class="section" id="default">
<h6>default</h6>
<p>Sets the default language code. The default is <code>en</code>.</p>
</div>
<div class="section" id="current">
<h6>current</h6>
<p>Sets the current language code. The default is <code>en</code>.</p>
</div>
<div class="section" id="supported">
<h6>supported</h6>
<p>Set an array with supported languages. The default is to set none.</p>
</div>
<div class="section" id="negotiate">
<h6>negotiate</h6>
<p>Set <code>true</code> to negotiate the locale on the command line or HTTP request.</p>
</div>
<div class="section" id="c76e2629b089c1ac85b81feedce40422428c48d0instance">
<h6>requestinstance</h6>
<p>Set the <a href="#request-service">Request Service</a> instance name to negotiate the current locale. The
default is <code>default</code>.</p>
</div>
<div class="section" id="35700ac7f7e8b1037a52714b92e85b76f42daf14level">
<h6>fallbacklevel</h6>
<p>Sets the Fallback Level to a Framework\Language\FallbackLevel enum case or an
integer. The default is to set none.</p>
</div>
<div class="section" id="directories">
<h6>directories</h6>
<p>Sets directories that contain subdirectories with the locale and language files.
The default is to set none.</p>
</div>
<div class="section" id="02f928473063b5721e8feedb2bf9fccbab82adf95d390b3fdd7f352ee5c7f9763b336ce67d62bc33namespaces">
<h6>findinnamespaces</h6>
<p>If set to <code>true</code> it will cause subdirectories called Language to be searched
in all namespaces and added to Language directories.</p>
</div>
<div class="section" id="b53e39f758760cec8afe8bbdc35026375e376a1binstance">
<h6>autoloaderinstance</h6>
<p>Sets the <a href="#autoloader-service">Autoloader Service</a> instance name of the autoloader used to find in
namespaces.</p>
</div>
</div>
</div>
<div class="section" id="locator-service">
<h4>Locator Service</h4>
<p>Gets an instance of
<a href="https://docs.webisters.com/classes/Framework-Autoload-Locator.php">Framework\Autoload\Locator</a>:</p>
<pre><code class="language-php " >App::locator()
</code></pre>
<p>More details about Locator can be found
<a href="../autoload/index.php#locator">here</a>.</p>
<div class="section" id="locator-config-options">
<h5>Locator Config Options</h5>
<pre><code class="language-php " >[
    &#039;locator&#039; =&gt; [
        &#039;default&#039; =&gt; [
            &#039;autoloader_instance&#039; =&gt; &#039;default&#039;,
        ],
    ],
]
</code></pre>
<div class="section" id="a07bb645b20f9bb07339ebe4e439333144a8e2fdinstance">
<h6>autoloaderinstance</h6>
<p>The <a href="#autoloader-service">Autoloader Service</a> instance name. The default is <code>default</code>.</p>
</div>
</div>
</div>
<div class="section" id="logger-service">
<h4>Logger Service</h4>
<p>Gets an instance of
<a href="https://docs.webisters.com/classes/Framework-Log-Logger.php">Framework\Log\Logger</a>:</p>
<pre><code class="language-php " >App::logger()
</code></pre>
<p>More details about Logger can be found
<a href="../log/index.php#log">here</a>.</p>
<div class="section" id="logger-config-options">
<h5>Logger Config Options</h5>
<pre><code class="language-php " >[
    &#039;logger&#039; =&gt; [
        &#039;default&#039; =&gt; [
            &#039;class&#039; =&gt; Framework\Log\Logger\MultiFileLogger::class,
            &#039;destination&#039; =&gt; ???, // Must be set
            &#039;level&#039; =&gt; Framework\Log\LogLevel::DEBUG,
            &#039;config&#039; =&gt; [],
        ],
    ],
]
</code></pre>
<div class="section" id="class">
<h6>class</h6>
<p>A Fully Qualified Class Name of a child class of Framework\Log\Logger.</p>
<p>The default is <code>Framework\Log\Logger\MultiFileLogger</code>.</p>
</div>
<div class="section" id="destination">
<h6>destination</h6>
<p>Set the destination where the logs will be stored or sent. It must be set
according to the class used.</p>
</div>
<div class="section" id="level">
<h6>level</h6>
<p>Sets the level of logs with a case of Framework\Log\LogLevel or an integer. If
none is set, the <code>DEBUG</code> level will be used.</p>
</div>
<div class="section" id="config">
<h6>config</h6>
<p>Sets an array with extra configurations for the class. The default is to pass an
empty array.</p>
</div>
</div>
</div>
<div class="section" id="mailer-service">
<h4>Mailer Service</h4>
<p>Gets an instance of
<a href="https://docs.webisters.com/classes/Framework-Email-Mailer.php">Framework\Email\Mailer</a>:</p>
<pre><code class="language-php " >App::mailer()
</code></pre>
<p>More details about Mailer can be found
<a href="../email/index.php#email">here</a>.</p>
<div class="section" id="mailer-config-options">
<h5>Mailer Config Options</h5>
<pre><code class="language-php " >[
    &#039;mailer&#039; =&gt; [
        &#039;default&#039; =&gt; [
            &#039;host&#039; =&gt; &#039;localhost&#039;,
            &#039;port&#039; =&gt; 587,
            &#039;tls&#039; =&gt; true,
            &#039;username&#039; =&gt; null,
            &#039;password&#039; =&gt; null,
            &#039;charset&#039; =&gt; &#039;utf-8&#039;,
            &#039;crlf&#039; =&gt; &quot;\r\n&quot;,
            &#039;keep_alive&#039; =&gt; false,
        ],
    ],
]
</code></pre>
<p>Set an array with Mailer settings. Normally you just set the <code>username</code>, the
<code>password</code>, the <code>host</code> and the <code>port</code>.</p>
<p>The complete list of configurations can be seen
<a href="../email/index.php#mailer-connection">here</a>.</p>
</div>
</div>
</div>
<div class="section" id="migrator-service">
<h4>Migrator Service</h4>
<p>Gets an instance of
<a href="https://docs.webisters.com/classes/Framework-Database-Extra-Migrator.php">Framework\Database\Extra\Migrator</a>:</p>
<pre><code class="language-php " >App::migrator()
</code></pre>
<p>More details about Migrator can be found
<a href="../database-extra/index.php#migrations">here</a>.</p>
<div class="section" id="migrator-config-options">
<h5>Migrator Config Options</h5>
<pre><code class="language-php " >[
    &#039;migrator&#039; =&gt; [
        &#039;default&#039; =&gt; [
            &#039;database_instance&#039; =&gt; &#039;default&#039;,
            &#039;directories&#039; =&gt; ???, // Must be set
            &#039;table&#039; =&gt; &#039;Migrations&#039;,
        ],
    ],
]
</code></pre>
<div class="section" id="11b6689ffa623070b73b46ee6fd6c873d97388b6instance">
<h6>databaseinstance</h6>
<p>Set the <a href="#database-service">Database Service</a> instance name. The default is <code>default</code>.</p>
</div>
<div class="section" id="directories">
<h6>directories</h6>
<p>Sets an array of directories that contain Migrations files. It must be set.</p>
</div>
<div class="section" id="table">
<h6>table</h6>
<p>The name of the migrations table. The default name is <code>Migrations</code>.</p>
</div>
</div>
</div>
<div class="section" id="request-service">
<h4>Request Service</h4>
<p>Gets an instance of
<a href="https://docs.webisters.com/classes/Framework-HTTP-Request.php">Framework\HTTP\Request</a>:</p>
<pre><code class="language-php " >App::request()
</code></pre>
<p>More details about Request can be found
<a href="../http/index.php#request">here</a>.</p>
<div class="section" id="request-config-options">
<h5>Request Config Options</h5>
<pre><code class="language-php " >[
    &#039;request&#039; =&gt; [
        &#039;default&#039; =&gt; [
            &#039;server_vars&#039; =&gt; [],
            &#039;allowed_hosts&#039; =&gt; [],
            &#039;force_https&#039; =&gt; false,
            &#039;json_flags&#039; =&gt; null,
        ],
    ],
]
</code></pre>
<div class="section" id="159d5e5b5246ae93eed3d3ccf3549dc1e9d806acvars">
<h6>servervars</h6>
<p>An array of values to be set in the $_SERVER superglobal on the command line.</p>
</div>
<div class="section" id="3e901c2e0e68e5c09f94a938650079da4b0654b9hosts">
<h6>allowedhosts</h6>
<p>Sets an array of allowed hosts. The default is an empty array, so any host is allowed.</p>
</div>
<div class="section" id="0d118bad23af453e8643610b544935673edb41bfhttps">
<h6>forcehttps</h6>
<p>Set <code>true</code> to automatically redirect to the HTTPS version of the current URL.<br>By default it is not set.</p>
</div>
<div class="section" id="06054c798503926becedbdc821106f74eb925876flags">
<h6>jsonflags</h6>
<p>Flags for <code>json_decode</code>. The default is set to none.</p>
</div>
</div>
</div>
<div class="section" id="response-service">
<h4>Response Service</h4>
<p>Gets an instance of
<a href="https://docs.webisters.com/classes/Framework-HTTP-Response.php">Framework\HTTP\Response</a>:</p>
<pre><code class="language-php " >App::response()
</code></pre>
<p>More details about Response can be found
<a href="../http/index.php#response">here</a>.</p>
<div class="section" id="response-config-options">
<h5>Response Config Options</h5>
<pre><code class="language-php " >[
    &#039;response&#039; =&gt; [
        &#039;default&#039; =&gt; [
            &#039;headers&#039; =&gt; [],
            &#039;auto_etag&#039; =&gt; false,
            &#039;auto_language&#039; =&gt; false,
            &#039;language_instance&#039; =&gt; &#039;default&#039;,
            &#039;cache&#039; =&gt; null,
            &#039;csp&#039; =&gt; [],
            &#039;csp_report_only&#039; =&gt; [],
            &#039;json_flags&#039; =&gt; null,
            &#039;replace_headers&#039; =&gt; false,
            &#039;request_instance&#039; =&gt; &#039;default&#039;,
        ],
    ],
]
</code></pre>
<div class="section" id="headers">
<h6>headers</h6>
<p>Sets an array where the keys are the name and the values are the header values.
The default is to set none.</p>
</div>
<div class="section" id="0498e488016a5e8c9e947c4bfc4fe658e9f7c30cetag">
<h6>autoetag</h6>
<p><code>true</code> allow to enable ETag auto-negotiation on all responses. It can also be
an array with the keys <code>active</code> and <code>hash_algo</code>.</p>
</div>
<div class="section" id="291751f0ce61976814d656f23efefa6665768a85language">
<h6>autolanguage</h6>
<p>Set <code>true</code> to set the Content-Language header to the current locale. The
default is no set.</p>
</div>
<div class="section" id="fa079abb19fade11dd16b211c1c3750af204c944instance">
<h6><a href="#language">language</a>instance</h6>
<p>Set <a href="#language-service">Language Service</a> instance name of the Language used in <strong>autolanguage</strong>.</p>
</div>
<div class="section" id="cache">
<h6>cache</h6>
<p>Set <code>false</code> to set Cache-Control to <code>no-cache</code> or an array with key <code>seconds</code>
to set cache seconds and optionally <code>public</code> to true or false to <code>private</code>.</p>
<p>The default is not to set these settings.</p>
</div>
<div class="section" id="csp">
<h6>csp</h6>
<p>If it is empty, it does nothing.</p>
<p>It can take an array of directives to initialize an instance of
<code>Framework\HTTP\CSP</code> and pass it as the <strong>Content-Security-Policy</strong> of the
response.</p>
</div>
<div class="section" id="658bdea6ed9e664398fea5804b7d75eda445a61a7bd1cdab19e4c149f08017b337bb7a282b2b37cdonly">
<h6><a href="#csp">csp</a>reportonly</h6>
<p>If it is empty, it does nothing.</p>
<p>It can take an array of directives to initialize an instance of
<code>Framework\HTTP\CSP</code> and pass it as the <strong>Content-Security-Policy-Report-Only</strong>
of the response.</p>
</div>
<div class="section" id="b9f92f598b40b2de3b4bd1fa62d402eb4dfd7895flags">
<h6>jsonflags</h6>
<p>Flags for <code>json_encode</code>. The default is set to none.</p>
</div>
<div class="section" id="38c30c9a49afdcc7c3df1f3f08e5be0261c7fde7headers">
<h6><a href="#replace">replace</a>headers</h6>
<p>Set <code>true</code> to force header replacement. Default is <code>false</code> to not replace.</p>
</div>
<div class="section" id="e1088e3edc760579a0ced68303b4f28e8b07f240instance">
<h6>requestinstance</h6>
<p>Set the <a href="#request-service">Request Service</a> instance name. The default is <code>default</code>.</p>
</div>
</div>
</div>
<div class="section" id="router-service">
<h4>Router Service</h4>
<p>Gets an instance of
<a href="https://docs.webisters.com/classes/Framework-Routing-Router.php">Framework\Routing\Router</a>:</p>
<pre><code class="language-php " >App::router()
</code></pre>
<p>More details about Router can be found
<a href="../routing/index.php#router">here</a>.</p>
<div class="section" id="router-config-options">
<h5>Router Config Options</h5>
<pre><code class="language-php " >[
    &#039;router&#039; =&gt; [
        &#039;default&#039; =&gt; [
            &#039;files&#039; =&gt; [],
            &#039;placeholders&#039; =&gt; [],
            &#039;auto_options&#039; =&gt; null,
            &#039;auto_methods&#039; =&gt; null,
            &#039;response_instance&#039; =&gt; &#039;default&#039;,
            &#039;language_instance&#039; =&gt; &#039;default&#039;,
        ],
    ],
]
</code></pre>
<div class="section" id="callback">
<h6>callback</h6>
<p>Sets a callback to be executed when the Router starts up. The callback receives
the Router instance in the first parameter.
By default no callback is set.</p>
</div>
<div class="section" id="files">
<h6>files</h6>
<p>Sets an array with the path of files that will be inserted to serve the routes.
The default is to set none.</p>
</div>
<div class="section" id="placeholders">
<h6>placeholders</h6>
<p>A custom placeholder array. Where the key is the placeholder and the value is
the pattern. The default is to set none.</p>
</div>
<div class="section" id="e418cbfe4d935f6a1543d1032cb93da01a91a7d0options">
<h6>autooptions</h6>
<p>If set to <code>true</code> it enables the feature to automatically respond to OPTIONS
requests. The default is no set.</p>
</div>
<div class="section" id="3425a3327fb6ae5c7d60db0e6a3031000d6a8fcamethods">
<h6>automethods</h6>
<p>If set to <code>true</code> it enables the feature to respond with the status 405 Method
Not Allowed and the Allow header containing valid methods. The default is no set.</p>
</div>
<div class="section" id="b57526383342e6205f0cd0cfbde3dcfdd1e469d4instance">
<h6>responseinstance</h6>
<p>Set the <a href="#response-service">Response Service</a> instance name. The default value is <code>default</code>.</p>
</div>
<div class="section" id="4cd7e41a83215ba11020470c55cca5303d647fe1instance">
<h6><a href="#language">language</a>instance</h6>
<p>Set a <a href="#language-service">Language Service</a> instance name. If not set, the Language instance will
not be passed.</p>
</div>
</div>
</div>
<div class="section" id="session-service">
<h4>Session Service</h4>
<p>Gets an instance of
<a href="https://docs.webisters.com/classes/Framework-Session-Session.php">Framework\Session\Session</a>:</p>
<pre><code class="language-php " >App::session()
</code></pre>
<p>More details about Session can be found
<a href="../session/index.php#session">here</a>.</p>
<div class="section" id="session-config-options">
<h5>Session Config Options</h5>
<pre><code class="language-php " >[
    &#039;session&#039; =&gt; [
        &#039;default&#039; =&gt; [
            &#039;save_handler&#039; =&gt; [
                &#039;class&#039; =&gt; null,
                &#039;config&#039; =&gt; [],
            ],
            &#039;options&#039; =&gt; [],
            &#039;auto_start&#039; =&gt; null,
            &#039;logger_instance&#039; =&gt; &#039;default&#039;,
        ],
    ],
]
</code></pre>
<div class="section" id="7c2669ca874865881b3cb89399ad60de270d49a3handler">
<h6><a href="#save">save</a>handler</h6>
<p>Optional. Sets an array containing the <code>class</code> key with the Fully Qualified
Class Name of a child class of Framework\Session\SaveHandler. And also the
<code>config</code> key with the configurations passed to the SaveHandler.</p>
<p>If the <code>class</code> is an instance of Framework\Session\SaveHandlers\DatabaseHandler
it is possible to set the instance of a <a href="#database-service">Database Service</a> through the key<br><code>database_instance</code>.</p>
</div>
<div class="section" id="options">
<h6>options</h6>
<p>Sets an array with the options to be passed in the construction of the Session
class.</p>
</div>
<div class="section" id="14be948ed5d666a8073494524b40717254bbe320start">
<h6>autostart</h6>
<p>Set to <code>true</code> to automatically start the session when the service is called.
The default is not to start.</p>
</div>
<div class="section" id="016a07e4caf0fbe85bc5835940a7f0b58ca8fd7ainstance">
<h6>loggerinstance</h6>
<p>Set the <a href="#logger-service">Logger Service</a> instance name. If not set, the Logger instance will
not be set in the save handler.</p>
</div>
</div>
</div>
<div class="section" id="validation-service">
<h4>Validation Service</h4>
<p>Gets an instance of
<a href="https://docs.webisters.com/classes/Framework-Validation-Validation.php">Framework\Validation\Validation</a>:</p>
<pre><code class="language-php " >App::validation()
</code></pre>
<p>More details about Validation can be found
<a href="../validation/index.php#validation">here</a>.</p>
<div class="section" id="validation-config-options">
<h5>Validation Config Options</h5>
<pre><code class="language-php " >[
    &#039;validation&#039; =&gt; [
        &#039;default&#039; =&gt; [
            &#039;validators&#039; =&gt; [
                Framework\MVC\Validator::class,
                Framework\Validation\FilesValidator::class,
            ],
            &#039;language_instance&#039; =&gt; &#039;default&#039;,
        ],
    ],
]
</code></pre>
<div class="section" id="validators">
<h6>validators</h6>
<p>Sets an array of Validators. The default is an array with the <a href="#validator">Validator</a> from the
mvc package and the FilesValidator from the Validation package.</p>
</div>
<div class="section" id="321c361ff0dc4f399f6dd916f28fb7775040f5e0instance">
<h6><a href="#language">language</a>instance</h6>
<p>Set the <a href="#language-service">Language Service</a> instance name. The default is not to set an
instance of Language.</p>
</div>
</div>
</div>
<div class="section" id="view-service">
<h4>View Service</h4>
<p>Gets an instance of
<a href="https://docs.webisters.com/classes/Framework-MVC-View.php">Framework\MVC\View</a>:</p>
<pre><code class="language-php " >App::view()
</code></pre>
<p>More details about View can be found
<a href="#views">here</a>.</p>
<div class="section" id="view-config-options">
<h5>View Config Options</h5>
<pre><code class="language-php " >[
    &#039;view&#039; =&gt; [
        &#039;default&#039; =&gt; [
            &#039;base_dir&#039; =&gt; ???, // Must be set
            &#039;extension&#039; =&gt; &#039;.php&#039;,
            &#039;layout_prefix&#039; =&gt; null,
            &#039;include_prefix&#039; =&gt; null,
            &#039;show_debug_comments&#039; =&gt; true,
            &#039;throw_exceptions_in_destructor&#039; =&gt; true,
        ],
    ],
]
</code></pre>
<div class="section" id="2a528a3e8719f0f3a609362f207f472580230d92dir">
<h6>basedir</h6>
<p>Sets the base directory from which views will be loaded. The default is to not
set any directories.</p>
</div>
<div class="section" id="extension">
<h6>extension</h6>
<p>Sets the extension of view files. The default is <code>.php</code>.</p>
</div>
<div class="section" id="ff93ed23f136595d52efde7bbcc2682a34606341prefix">
<h6>layoutprefix</h6>
<p>Sets the layout prefix. The default is to set none.</p>
</div>
<div class="section" id="8d7812926437f3f0968de3234e2a00f4cfb80c62prefix">
<h6>includeprefix</h6>
<p>Set the includes prefix. The default is to set none.</p>
</div>
<div class="section" id="c9eed2ccab357ecd77abf5836653532c19822d41305da01cc73fde81eaec3b59f5b367a68251c11acomments">
<h6>showdebugcomments</h6>
<p>Set to <code>false</code> to disable HTML comments when in debug mode.</p>
</div>
<div class="section" id="a7030ac202660ad1646c1b7ca3e24c03d0c590ee18b8d1ed578c94983c3844a8e0bed8ece86b3dd192fc7fb7e19dfd078fd1185be795baace6a552efdestructor">
<h6>throwexceptionsindestructor</h6>
<p>Set <code>false</code> to not throw exceptions in the class destructor. The default is to
throw. Disabling this will help you debug exceptions thrown inside views.</p>
</div>
</div>
</div>
<div class="section" id="extending">
<h3>Extending</h3>
<p>Built-in services are designed to be extended.</p>
<p>Let&#039;s look at an example extending the HTTP Request class and adding two custom
methods, <code>isGet</code> and <code>isPost</code>:</p>
<pre><code class="language-php " >namespace Lupalupa\HTTP;
class Request extends \Framework\HTTP\Request
{
    public function isGet() : bool
    {
        return $this-&gt;isMethod(&#039;get&#039;);
    }
    public function isPost() : bool
    {
        return $this-&gt;isMethod(&#039;post&#039;);
    }
}
</code></pre>
<p>Now, let&#039;s extend the App class:</p>
<p>The <code>App::request</code> method return type can be replaced by a child class thanks
to <a href="https://www.php.net/manual/en/language.oop5.variance.php#language.oop5.variance.covariance">Covariance</a>.</p>
<p>The example below adds a new method, <code>App::other</code>, which also uses
<a href="https://www.php.net/manual/en/language.oop5.late-static-bindings.php#language.oop5.late-static-bindings.usage">Late Static Bindings</a>.</p>
<pre><code class="language-php " >use Lupalupa\HTTP\Request;
use Lupalupa\Other;
class App extends \Framework\MVC\App
{
    public static function request(string $instance = &#039;default&#039;) : Request
    {
        $service = static::getService(&#039;request&#039;, $instance);
        if ($service) {
            return $service;
        }
        $config = static::config()-&gt;get(&#039;request&#039;, $instance);
        return static::setService(
            &#039;request&#039;,
            new Request($config[&#039;allowed_hosts&#039;] ?? null),
            $instance
        );
    }
    public static function other(string $instance = &#039;default&#039;) : Other
    {
        $service = static::getService(&#039;other&#039;, $instance);
        if ($service) {
            return $service;
        }
        $config = static::config()-&gt;get(&#039;other&#039;, $instance);
        $service = new Other(
            static::request($config[&#039;request_instance&#039;] ?? &#039;default&#039;)
        );
        if (isset($config[&#039;foo&#039;])) {
            $service-&gt;setFoo($config[&#039;foo&#039;]);
        }
        return static::setService(&#039;other&#039;, $service, $instance);
    }
}
</code></pre>
<p>Finally, you will be able to use the custom instance of <code>Request</code> and <code>Other</code>
anywhere in your application:</p>
<pre><code class="language-php " >App::request()-&gt;isGet();
App::request()-&gt;isPost();
App::other()-&gt;doSomething();
App::other(&#039;other_instance&#039;)-&gt;doSomething();
</code></pre>
<p><strong>Tip</strong>: Use a <a href="https://www.jetbrains.com/phpstorm/">smart IDE</a>. Webisters loves it.
Be happy.</p>
</div>
</div>
<div class="section" id="models">
<h2>Models</h2>
<p>Models represent tables in databases. They have basic CRUD (create, read, update
and delete) methods, with validation, localization and performance
optimization with caching and separation of read and write data.</p>
<p>To create a model that represents a table, just create a class that extends the
<strong>Framework\MVC\Model</strong> class.</p>
<pre><code class="language-php " >use Framework\MVC\Model;
class Users extends Model
{
}
</code></pre>
<p>The example above is very simple, but with it it would be possible to read data
in the <strong>Users</strong> table.</p>
<div class="section" id="table-name">
<h3>Table Name</h3>
<p>The table name can be set in the <code>$table</code> property.</p>
<pre><code class="language-php " >protected string $table;
</code></pre>
<p>If the name is not set the first time the <code>getTable</code> method is called, the
table name will automatically be set to the class name. For example, if the
class is called <strong>App\Models\PostsModel</strong>, the table name will be <strong>Posts</strong>.</p>
</div>
<div class="section" id="database-connections">
<h3>Database Connections</h3>
<p>Each model allows two database connections, one for reading and one for writing.</p>
<p>The connections are obtained through the <code>Framework\MVC\App::database</code> method
and the name of the instances must be defined in the model.</p>
<p>To set the name of the read connection instance, use the <code>$connectionRead</code>
property.</p>
<pre><code class="language-php " >protected string $connectionRead = &#039;default&#039;;
</code></pre>
<p>The name of the connection can be obtained through the <code>getConnectionRead</code>
method and the instance of <strong>Framework\Database\Database</strong> can be obtained
through the <code>getDatabaseToRead</code> method.</p>
<p>The name of the write connection, by default, is also <code>default</code>. But it can
be modified through the <code>$connectionWrite</code> property.</p>
<pre><code class="language-php " >protected string $connectionWrite = &#039;default&#039;;
</code></pre>
<p>The name of the write connection can be taken by the <code>getConnectionWrite</code>
method and the instance by <code>getDatabaseToWrite</code>.</p>
</div>
<div class="section" id="primary-key">
<h3>Primary Key</h3>
<p>To work with a model, it is necessary that its database table has an
auto-incrementing Primary Key, because it is through it that data is found by
the <code>read</code> method, and rows are also updated and deleted.</p>
<p>By default, the name of the primary key is <code>id</code>, as in the example below:</p>
<pre><code class="language-php " >protected string $primaryKey = &#039;id&#039;;
</code></pre>
<p>It can be obtained with the <code>getPrimaryKey</code> method.</p>
<p>The primary key field is protected by default, preventing it from being changed
in write methods such as <code>create</code>, <code>update</code> and <code>replace</code>:</p>
<pre><code class="language-php " >protected bool $protectPrimaryKey = true;
</code></pre>
<p>You can check if the primary key is being protected by the
<code>isProtectPrimaryKey</code> method.</p>
<p>If it is protected, but allowed in <a href="#allowed-fields">Allowed Fields</a>, an exception will be
thrown saying that the primary key field is protected and cannot be changed by
writing methods.</p>
</div>
<div class="section" id="allowed-fields">
<h3>Allowed Fields</h3>
<p>To manipulate a table making changes it is required that the fields allowed for
writing are set, otherwise a <strong>LogicException</strong> will be thrown.</p>
<p>Using the <code>$allowedFields</code> property, you can set an array with the names of
the allowed fields:</p>
<pre><code class="language-php " >protected array $allowedFields = [
    &#039;name&#039;,
    &#039;email&#039;,
];
</code></pre>
<p>This list can be obtained with the <code>getAllowedFields</code> method.</p>
<p>Note that the data is filtered on write operations, removing all disallowed
fields.</p>
</div>
<div class="section" id="return-type">
<h3>Return Type</h3>
<p>When reading data, by default the rows are converted into <code>stdClass</code> objects,
making it easier to work with object orientation.</p>
<p>But, the <code>$returnType</code> property can also be set as <code>array</code> (making the
returned rows an associative array) or as a class-string of a child class of
<strong>Framework\MVC\Entity</strong>.</p>
<pre><code class="language-php " >protected string $returnType = stdClass::class;
</code></pre>
<p>The return type can be obtained with the <code>getReturnType</code> method.</p>
<p>Results are automatically converted to the return type in the <code>read</code>,
<code>list</code> and <code>paginate</code> methods.</p>
</div>
<div class="section" id="automatic-timestamps">
<h3>Automatic Timestamps</h3>
<p>With models it is possible to save the creation and update dates of rows
automatically.</p>
<p>To do this, just set the <code>$autoTimestamps</code> property to true:</p>
<pre><code class="language-php " >protected bool $autoTimestamps = false;
</code></pre>
<p>To find out if automatic timestamps are enabled, you can use the
<code>isAutoTimestamps</code> method.</p>
<p>By default, the name of the field with the row creation timestamp is
<code>createdAt</code> and the field with the update timestamp is called <code>updatedAt</code>.</p>
<p>Both fields can be changed via the <code>$fieldCreated</code> and <code>$fieldUpdated</code>
properties:</p>
<pre><code class="language-php " >protected string $fieldCreated = &#039;createdAt&#039;;
protected string $fieldUpdated = &#039;updatedAt&#039;;
</code></pre>
<p>To get the name of the automatic timestamp fields you can use the
<code>getFieldCreated</code> and <code>getFieldUpdated</code> methods.</p>
<p>The timestamp format can also be customized. The default is like the example
below:</p>
<pre><code class="language-php " >protected string $timestampFormat = &#039;Y-m-d H:i:s&#039;;
</code></pre>
<p>And, the format can be obtained through the <code>getTimestampFormat</code> method.</p>
<p>The timestamps are generated using the timezone of the write connection and,
if it is not set, it uses UTC.</p>
<p>A timestamp formatted in <code>$timestampFormat</code> can be obtained with the
<code>getTimestamp</code> method.</p>
<p>When the fields of <code>$fieldCreated</code> or <code>$fieldUpdated</code> are set to
<code>$allowedFields</code> they will not be removed by filtering, and you can set
custom values.</p>
</div>
<div class="section" id="validation">
<h3>Validation</h3>
<p>When one of the <code>create</code>, <code>update</code> or <code>replace</code> methods is called for the
first time, the <code>$validation</code> property will receive an instance of
<strong>Framework\Validation\Validation</strong> for exclusive use in the model, which can be
obtained by the <code>getValidation</code> method.</p>
<p>To make changes it is required that the validation rules are set, otherwise a
<strong>RuntimeException</strong> will be thrown saying that the rules were not set.</p>
<p>You can set the rules in the <code>$validationRules</code> property:</p>
<pre><code class="language-php " >protected array $validationRules = [
    &#039;name&#039; =&gt; &#039;minLength:5|maxLength:32&#039;,
    &#039;email&#039; =&gt; &#039;email&#039;,
];
</code></pre>
<p>Or returning in the <code>getValidationRules</code> method.</p>
<p>Validators can also be customized. By default, the ones used are
<strong>Framework\MVC\Validator</strong> and <strong>Framework\Validation\FilesValidator</strong>:</p>
<pre><code class="language-php " >protected array $validationValidators = [
    Validator::class,
    FilesValidator::class,
];
</code></pre>
<p>The list of validators can be obtained using the <code>getValidationValidators</code>
method.</p>
<p>The labels with the name of the fields in the error messages can also be
customized, being set in the <code>$validationLabels</code> property:</p>
<pre><code class="language-php " >protected array $validationLabels;
</code></pre>
<p>Or through the <code>getValidationLabels</code> method, as in the example below, setting
the labels in the current language:</p>
<pre><code class="language-php " >protected function getValidationLabels() : array
{
    return $this-&gt;validationLabels ??= [
        &#039;name&#039; =&gt; $this-&gt;getLanguage()-&gt;render(&#039;users&#039;, &#039;name&#039;),
        &#039;email&#039; =&gt; $this-&gt;getLanguage()-&gt;render(&#039;users&#039;, &#039;email&#039;),
    ];
}
</code></pre>
<p>The same goes for setting custom error messages. They can be set in the
<code>$validationMessages</code> property:</p>
<pre><code class="language-php " >protected array $validationMessages;
</code></pre>
<p>And obtained by the <code>getValidationMessages</code> method.</p>
<p>When <code>create</code>, <code>update</code> or <code>replace</code> return <code>false</code>, errors can be
retrieved via the <code>getErrors</code> method.</p>
</div>
<div class="section" id="pagination">
<h3>Pagination</h3>
<p>Using the <code>paginate</code> method, you can perform pagination with all the data in
a table.</p>
<p>Below, we take the first 30 items from the table:</p>
<pre><code class="language-php " >$page = 1;
$perPage = 30;
$data = $model-&gt;paginate($page, $perPage); // array
</code></pre>
<p>Also, it is possible to pass an array to the WHERE clause, as in the example
below:</p>
<pre><code class="language-php " >$where = [
    [&#039;id&#039;, &#039;&lt;&#039;, 100], // WHERE `id` &lt; 100
    [&#039;author&#039;, &#039;is not null&#039;], // AND `author` IS NOT NULL
];
$data = $model-&gt;paginate($page, $perPage, $where); // array
</code></pre>
<p>The following SQL will be appended to the query:</p>
<pre><code class="language-sql " >WHERE `id` &lt; 100
AND `author` IS NOT NULL
</code></pre>
<p>Also, it is possible to order the results by the last parameters:</p>
<pre><code class="language-php " >$orderBy = &#039;title&#039;; // Column name
$orderByDirection = &#039;asc&#039;; // asc or desc
$data = $model-&gt;paginate(
    $page,
    $perPage,
    $where,
    $orderBy,
    $orderByDirection
); // array
</code></pre>
<p>After calling the <code>paginate</code> method, the <code>$pager</code> property will have an
instance of the <strong>Framework\Pagination\Pager</strong> class, which can be obtained by
the <code>getPager</code> method.</p>
<p>So you can render the pagination wherever you need it, like in the HTTP Link
header or as HTML in views:</p>
<pre><code class="language-php " >echo $model-&gt;getPager()-&gt;render(&#039;bootstrap&#039;);
</code></pre>
<p>In the <code>$pagerView</code> property you can define the default Pager view:</p>
<pre><code class="language-php " >protected string $pagerView = &#039;bootstrap&#039;;
</code></pre>
<p>So this view will always render by default:</p>
<pre><code class="language-php " >echo $model-&gt;getPager()-&gt;render();
</code></pre>
<p>Also, it is possible to set the Pager URL in the <code>$pagerUrl</code> property, which
is unnecessary in HTTP requests, but required in the command line.</p>
</div>
<div class="section" id="cache">
<h3>Cache</h3>
<p>The model has a cache system that works with individual results. For example,
once the <code>$cacheActive</code> property is set to <code>true</code>, when obtaining a row
via the <code>read</code> method, the result will be stored in the cache and will be
available directly from it for the duration of the Time To Live, defined in the
<code>$cacheTtl</code> property.</p>
<p>When an item is updated via the <code>update</code> method, the cached item will also be
updated.</p>
<p>When an item is deleted from the database, it is also deleted from the cache.</p>
<p>With the active caching system it reduces the load on the database server, as
the rows are obtained from files or directly from memory.</p>
<p>Below is the example with the cache inactive. To activate it, just set the value
to <code>true</code>.</p>
<pre><code class="language-php " >protected bool $cacheActive = false;
</code></pre>
<p>Whenever you want to know if the cache is active, you can use the
<code>isCacheActive</code> method.</p>
<p>And the name of the service instance obtained through the method
<code>Framework\MVC\App::cache</code> can be set as in the property below:</p>
<pre><code class="language-php " >protected string $cacheInstance = &#039;default&#039;;
</code></pre>
<p>Whenever it is necessary to get the name of the cache instance, you can use the
<code>getCacheInstance</code> method and to get the object instance of the
<strong>Framework\Cache\Cache</strong> class, you can use the <code>getCache</code> method.</p>
<p>The default Time To Live value for each item is 60 seconds, as shown below:</p>
<pre><code class="language-php " >protected int $cacheTtl = 60;
</code></pre>
<p>This value can be obtained through the <code>getCacheTtl</code> method.</p>
</div>
<div class="section" id="language">
<h3>Language</h3>
<p>Some features, such as validation, on labels and error messages, or pagination
need an instance of <strong>Framework\Language\Language</strong> to locate the displayed
texts.</p>
<p>The name of the instance defined in the <code>$languageInstance</code> property is
obtained through the service available in the <code>Framework\MVC\App::language</code>
method, and can be obtained through the <code>getLanguage</code> method.</p>
<p>The default instance is <code>default</code>, as shown below:</p>
<pre><code class="language-php " >protected string $languageInstance = &#039;default&#039;;
</code></pre>
</div>
<div class="section" id="crud">
<h3>CRUD</h3>
<p>The model has methods to work with basic CRUD operations, which are:</p>
<ul>
    <li>
            <a href="#create">Create</a>
        </li>
    <li>
            <a href="#read">Read</a>
        </li>
    <li>
            <a href="#update">Update</a>
        </li>
    <li>
            <a href="#delete">Delete</a>
        </li>
</ul>
<div class="section" id="create">
<h5>Create</h5>
<p>The <code>create</code> method inserts a new row and returns the LAST_INSERT_ID() on
success or <code>false</code> if validation fails:</p>
<pre><code class="language-php " >$data = [
    &#039;name&#039; =&gt; &#039;John Doe&#039;,
    &#039;email&#039; =&gt; &#039;<a href="../cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="b7ddd8dfd9d3d8d2f7d3d8dad6ded999c3dbd3">[email&#160;protected]</a>&#039;,
];
$id = $model-&gt;create($data); // Insert ID or false
</code></pre>
<p>If it returns <code>false</code>, it is possible to get the errors through the
<code>getErrors</code> method:</p>
<pre><code class="language-php " >if ($id === false) {
    $errors = $model-&gt;getErrors();
}
</code></pre>
</div>
<div class="section" id="read">
<h5>Read</h5>
<p>The <code>read</code> method reads a row based on the Primary Key and returns the row
with the type set in the <code>$returnType</code> property or <code>null</code> if the row is not
found.</p>
<pre><code class="language-php " >$id = 1;
$row = $model-&gt;read($id);
</code></pre>
<p>It is also possible to read all rows, with limit and offset, by returning an
array with items in the <code>$returnType</code>.</p>
<pre><code class="language-php " >$limit = 10;
$offset = 20;
$rows = $model-&gt;list($limit, $offset); // array
</code></pre>
</div>
<div class="section" id="update">
<h5>Update</h5>
<p>The <code>update</code> method updates based on the Primary Key and returns the number
of rows affected or <code>false</code> if validation fails.</p>
<pre><code class="language-php " >$id = 1;
$data = [
    &#039;name&#039; =&gt; &#039;Johnny Doe&#039;,
];
$affectedRows = $model-&gt;update($id, $data); // int, string or false
</code></pre>
</div>
<div class="section" id="delete">
<h5>Delete</h5>
<p>The <code>delete</code> method deletes based on the Primary Key and returns the number
of affected rows:</p>
<pre><code class="language-php " >$id = 1;
$affectedRows = $model-&gt;delete($id); // int, string or false
</code></pre>
</div>
<div class="section" id="extra">
<h5>Extra</h5>
<p>The Model has some extra methods for doing common operations:</p>
<div class="section" id="count">
<h6>Count</h6>
<p>A basic function to count rows in the table.</p>
<pre><code class="language-php " >$count = $model-&gt;count(); // int
</code></pre>
<p>Optionally, with a parameter to the WHERE clause:</p>
<pre><code class="language-php " >$where = [
    [&#039;id&#039;, &#039;&lt;&#039;, 100], // WHERE `id` &lt; 100
    [&#039;name&#039;, &#039;like&#039;, &#039;Pa%&#039;], // AND `name` LIKE &#039;Pa%&#039;
];
$count = $model-&gt;count($where); // int
</code></pre>
</div>
<div class="section" id="replace">
<h6>Replace</h6>
<p>Replace based on Primary Key and return the number of affected rows or <code>false</code>
if validation fails.</p>
<pre><code class="language-php " >$id = 1;
$data = [
    &#039;name&#039; =&gt; &#039;John Morgan&#039;,
    &#039;email&#039; =&gt; &#039;<a href="../cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="e68c898e88828983a682898b878f88c8928a82">[email&#160;protected]</a>&#039;,
];
$affectedRows = $model-&gt;replace($id, $data); // int, string or false
</code></pre>
</div>
<div class="section" id="save">
<h6>Save</h6>
<p>Save a row. Updates if the Primary Key field is present, otherwise inserts a
new row.</p>
<p>Returns the number of rows affected in updates as an integer. The
LAST_INSERT_ID(), in inserts. Or <code>false</code> if validation fails.</p>
<pre><code class="language-php " >$data = [
    &#039;id&#039; =&gt; 1,
    &#039;email&#039; =&gt; &#039;<a href="../cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="1c767374725c7873717d757232687078">[email&#160;protected]</a>&#039;,
];
$result = $model-&gt;save($data); // int, string or false
</code></pre>
</div>
</div>
</div>
<div class="section" id="entities">
<h2>Entities</h2>
<p>Entities represent rows in a database table. They can be used as a <a href="#return-type">Return Type</a>
in models.</p>
<p>Let&#039;s see the entity <strong>User</strong> below:</p>
<pre><code class="language-php " >use Framework\Date\Date;
use Framework\HTTP\URL;
use Framework\MVC\Entity;
class User extends Entity
{
    protected int $id;
    protected string $name;
    protected string $email;
    protected string $passwordHash;
    protected URL $url;
    protected Date $createdAt;
    protected Date $updatedAt;
}
</code></pre>
<p>And, it can be instantiated as follows:</p>
<pre><code class="language-php " >$user = new User([
    &#039;id&#039; =&gt; 1,
    &#039;name&#039; =&gt; &#039;John Doe&#039;,
]);
</code></pre>
<div class="section" id="populate">
<h3>Populate</h3>
<p>The array keys will be set as the property name with their respective values in
the <code>populate</code> method.</p>
<p>If a setter method exists for the property, it will be called. For example, if
there is a <code>setId</code> method, it will be called to set the <code>id</code> property. If
the <code>setId</code> method does not exist, it will try to set the property, if it
exists, otherwise it will throw an exception saying that the property is not
defined. If set, it will attempt to set the value to the property&#039;s type,
casting type with the <a href="#type-hints">Type Hints</a> methods.</p>
</div>
<div class="section" id="init">
<h3>Init</h3>
<p>The init method is used to initialize settings, set custom properties, etc.
Called in the constructor just after the properties are populated.</p>
<pre><code class="language-php " >protected URL $url;
protected string $name;
protected function init() : void
{
    $this-&gt;name = $this-&gt;firstname . &#039; &#039; . $this-&gt;lastname;
    $this-&gt;url = new URL(&#039;https://domain.tld/users/&#039; . $this-&gt;id);
}
</code></pre>
</div>
<div class="section" id="magic-isset-and-unset">
<h3>Magic Isset and Unset</h3>
<p>To check if a property is set:</p>
<pre><code class="language-php " >$isSet = isset($user-&gt;id); // bool
</code></pre>
<p>To remove a property:</p>
<pre><code class="language-php " >unset($user-&gt;id);
</code></pre>
</div>
<div class="section" id="magic-getters">
<h3>Magic Getters</h3>
<p>Properties can be called directly. But first, it is always checked if there is
a getter for it and if there is, it will be used:</p>
<pre><code class="language-php " >$id = $user-&gt;id; // 1
$id = $user-&gt;getId(); // 1
</code></pre>
</div>
<div class="section" id="magic-setters">
<h3>Magic Setters</h3>
<p>Properties can be set directly. But before that, it is always checked if there
is a setter for it and if there is, the value will be set through it:</p>
<pre><code class="language-php " >$user-&gt;id = 3;
$user-&gt;setId(3);
</code></pre>
<div class="section" id="type-hints">
<h5>Type Hints</h5>
<p>It is common to need to convert types when setting property. For example,
setting a URL string to be converted as an object of the Framework\HTTP\URL
class.</p>
<p>Before a property is set, the Entity class checks the property&#039;s type and checks
the value&#039;s type. Then, try to convert the value to the property&#039;s type through
3 methods.</p>
<p>Each method must return the value in the converted type or null, indicating that
the conversion was not performed.</p>
<div class="section" id="type-hint-custom">
<h6>Type Hint Custom</h6>
<p>The <code>typeHintCustom</code> method must be overridden to make custom type changes.</p>
</div>
<div class="section" id="type-hint-native">
<h6>Type Hint Native</h6>
<p>The <code>typeHintNative</code> method converts to native PHP types, which are:
<code>array</code>, <code>bool</code>, <code>float</code>, <code>int</code>, <code>string</code> and <code>stdClass</code>.</p>
</div>
<div class="section" id="type-hint-Webisters">
<h6>Type Hint Webisters</h6>
<p>The <code>typeHintWebisters</code> method converts to Webisters class types, which are:
<code>Framework\Date\Date</code> and <code>Framework\HTTP\URL</code>.</p>
</div>
</div>
</div>
<div class="section" id="to-model">
<h3>To Model</h3>
<p>Through the <code>toModel</code> method, the object is transformed into an associative
array ready to be written to the database.</p>
<p>Conversion to array can be done directly, as below:</p>
<pre><code class="language-php " >$data = $user-&gt;toModel(); // Associative array
</code></pre>
<p>Or passed directly to one of a model&#039;s methods.</p>
<p>Let&#039;s see how to create a row using the variable <code>$user</code>, which is an entity:</p>
<pre><code class="language-php " >$id = $model-&gt;create($user); // Insert ID or false
</code></pre>
<div class="section" id="working-with-timezones">
<h5>Working with Timezones</h5>
<p>Let&#039;s see below how to work with timezones when exporting data to models.</p>
<pre><code class="language-php " >use Framework\Date\Date;
use Framework\MVC\Entity;
class User extends Entity
{
    public string $_timezone = &#039;+00:00&#039;; // Default value
    protected Date $createdAt;
}
</code></pre>
<p>We set PHP&#039;s default timezone to America/SaoPaulo (-03:00):</p>
<pre><code class="language-php " >date_default_timezone_set(&#039;America/Sao_Paulo&#039;);
</code></pre>
<p>The User object is created:</p>
<pre><code class="language-php " >$user = new User([
    &#039;createdAt&#039; =&gt; &#039;2024-08-02 10:30:00&#039;,
]);
</code></pre>
<p>Result using default timezone (-03:00):</p>
<pre><code class="language-php " >echo $user-&gt;createdAt-&gt;format(&#039;Y-m-d H:i:s&#039;); // &#039;2024-08-02 10:30:00&#039;
</code></pre>
<p>When passing through the <code>toModel</code> method, the value of <code>createdAt</code> is modified.</p>
<p>The conversion to the time zone of the <code>$_timezone</code> property (+00:00) is performed:</p>
<pre><code class="language-php " >$data = $user-&gt;toModel();
echo $data[&#039;createdAt&#039;]; // &#039;2024-08-02 13:30:00&#039;
</code></pre>
<p>When modifying <code>$_timezone</code>, the converted value will also change:</p>
<pre><code class="language-php " >$user-&gt;_timezone = &#039;+05:00&#039;;
$data = $user-&gt;toModel();
echo $data[&#039;createdAt&#039;]; // &#039;2024-08-02 18:30:00&#039;
</code></pre>
<p>We advise you to leave the Entity and database timezones with the default value
of <code>+00:00</code> (UTC). But if you really need to modify it don&#039;t forget to do it
when you <a href="../database/index.php#connection">connect the database</a>
and put the same timezone in the Entity.</p>
</div>
</div>
</div>
<div class="section" id="json-encoding">
<h3>JSON Encoding</h3>
<div class="section" id="json-vars">
<h5>JSON Vars</h5>
<p>When working with APIs, it may be necessary to convert an Entity to a JSON
object.</p>
<p>To set which properties will be JSON-encoded just list them in the property
<code>$_jsonVars</code>:</p>
<pre><code class="language-php " >use Framework\Date\Date;
use Framework\HTTP\URL;
use Framework\MVC\Entity;
class User extends Entity
{
    public array $_jsonVars = [
        &#039;id&#039;,
        &#039;name&#039;,
        &#039;url&#039;,
        &#039;createdAt&#039;,
        &#039;updatedAt&#039;,
        &#039;bio&#039;,
    ];
    protected int $id;
    protected string $name;
    protected ?string $bio = null;
    protected string $email;
    protected string $passwordHash;
    protected URL $url;
    protected Date $createdAt;
    protected Date $updatedAt;
}
</code></pre>
<pre><code class="language-php " >$user = new User([
    &#039;id&#039; =&gt; 1,
    &#039;name&#039; =&gt; &#039;John Doe&#039;,
    &#039;url&#039; =&gt; &#039;https://domain.tld/users/1&#039;,
    &#039;createdAt&#039; =&gt; &#039;now&#039;,
]);
</code></pre>
<p>Or set whenever you want:</p>
<pre><code class="language-php " >$user-&gt;_jsonVars = [
    &#039;id&#039;,
    &#039;name&#039;,
    &#039;url&#039;,
    &#039;createdAt&#039;,
    &#039;updatedAt&#039;,
    &#039;bio&#039;,
];
</code></pre>
<p>Once this is done, the entity can be encoded. Let&#039;s see in the following
example:</p>
<pre><code class="language-php " >echo json_encode($user, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
</code></pre>
<p>And then the JSON object:</p>
<pre><code class="language-json " >{
    &quot;id&quot;: 1,
    &quot;name&quot;: &quot;John Doe&quot;,
    &quot;url&quot;: &quot;https://domain.tld/users/1&quot;,
    &quot;createdAt&quot;: &quot;2024-08-02T10:30:00-03:00&quot;,
    &quot;bio&quot;: null
}
</code></pre>
<p>Note that the <code>url</code> and <code>createdAt</code> property objects have been json-serialized.</p>
<p>And, only properties with defined values will appear in the result. Note that
<code>bio</code> has the default value of <code>null</code> and appears in the result. On the other
hand, the <code>updatedAt</code> property does not have a defined value and therefore does
not appear in the result.</p>
</div>
<div class="section" id="json-flags">
<h5>JSON Flags</h5>
<p>Through the <code>$_jsonFlags</code> property, the flags to encode and decode JSON
internally in the Entity class are set.</p>
<p>The example below shows the flags with the default value:</p>
<pre><code class="language-php " >class User extends Entity
{
    public int $_jsonFlags = JSON_UNESCAPED_SLASHES
        | JSON_UNESCAPED_UNICODE
        | JSON_PRESERVE_ZERO_FRACTION
        | JSON_THROW_ON_ERROR;
}
</code></pre>
<p>You can find more details on the
<a href="https://www.php.net/manual/en/json.constants.php">JSON Constants</a> page.</p>
<p>Below is an example showing what can happen:</p>
<pre><code class="language-php " >class People extends Entity
{
    protected string $name;
    protected float $height;
    protected string $status;
    protected URL $link;
    protected array $config;
}
$people = new People([
    &#039;name&#039; =&gt; &#039;John Doe&#039;,
    &#039;height&#039; =&gt; 1,
    &#039;status&#039; =&gt; &#039;Happy! ❤️ ⚡⚡&#039;,
    &#039;link&#039; =&gt; &#039;https://domain.tld/john-doe&#039;,
    &#039;config&#039; =&gt; [
        &#039;theme&#039; =&gt; [
            &#039;color&#039; =&gt; &#039;magenta&#039;,
            &#039;background&#039; =&gt; &#039;black&#039;,
        ],
    ],
]);
echo (string) $people;
</code></pre>
<p>This is the result when the People entity is encoded without flags:</p>
<pre><code class="language-json " >{&quot;name&quot;:&quot;John Doe&quot;,&quot;height&quot;:1,&quot;status&quot;:&quot;Happy! \u2764\ufe0f \u26a1\u26a1&quot;,&quot;link&quot;:&quot;https:\/\/domain.tld\/john-doe&quot;,&quot;config&quot;:{&quot;theme&quot;:{&quot;color&quot;:&quot;magenta&quot;,&quot;background&quot;:&quot;black&quot;}}}
</code></pre>
<p>And, this is the result with the default flags:</p>
<pre><code class="language-json " >{&quot;name&quot;:&quot;John Doe&quot;,&quot;height&quot;:1.0,&quot;status&quot;:&quot;Happy! ❤️ ⚡⚡&quot;,&quot;link&quot;:&quot;https://domain.tld/john-doe&quot;,&quot;config&quot;:{&quot;theme&quot;:{&quot;color&quot;:&quot;magenta&quot;,&quot;background&quot;:&quot;black&quot;}}}
</code></pre>
<p>Note that <code>height</code> has a float value, the unicode in <code>status</code> is not escaped
and <code>link</code> has no backslashes.</p>
</div>
</div>
<div class="section" id="validator">
<h2>Validator</h2>
<p>The <strong>Framework\MVC\Validator</strong> class has additional rules that work, for example,
using database connections.</p>
<p>The following rules can be used alongside the
<a href="../validation/index.php#available-rules">default validation rules</a>:</p>
<ul>
    <li>
            <a href="#exist">exist</a>
        </li>
    <li>
            <a href="#existmany">existMany</a>
        </li>
    <li>
            <a href="#unique">unique</a>
        </li>
</ul>
<div class="section" id="exist">
<h3>exist</h3>
<p>Requires that a value exists in the database.</p>
<pre><code class="language-php " >exist:$tableColumn
exist:$tableColumn,$connection
</code></pre>
<p>The rule has two parameters: <code>$tableColumn</code> and <code>$connection</code>.</p>
<p><code>$tableColumn</code> is the table name and, optionally, the column name separated by
a dot. If the column is not defined, the field name will be used as the column name.</p>
<p><code>$connection</code> is the name of the database connection. The default is <code>default</code>.</p>
</div>
<div class="section" id="existmany">
<h3>existMany</h3>
<p>Requires that many values exists in the database.</p>
<pre><code class="language-php " >existMany:$tableColumn
existMany:$tableColumn,$connection
</code></pre>
<p>This rule is similar to <a href="#exist">exist</a>. Except it is able to check if many values are
present in a database table.</p>
<p>It can validate many values from a <code>select</code> HTML element:</p>
<pre><code class="language-html " >&lt;select name=&quot;fruits[]&quot; multiple&gt;
    &lt;option value=&quot;1&quot;&gt;Apple&lt;/option&gt;
    &lt;option value=&quot;2&quot;&gt;Orange&lt;/option&gt;
    &lt;option value=&quot;3&quot;&gt;Pear&lt;/option&gt;
    &lt;option value=&quot;5&quot;&gt;Banana&lt;/option&gt;
    &lt;option value=&quot;9&quot;&gt;Strawberry&lt;/option&gt;
&lt;/select&gt;
</code></pre>
<p>The following example will validate if the ids sent in the <code>fruits</code> field are
present in the <code>Fruits</code> table:</p>
<pre><code class="language- " >existMany:Fruits.id
</code></pre>
<p>If any value does not exist, validation will fail.</p>
</div>
<div class="section" id="unique">
<h3>unique</h3>
<p>Requires that a value is not registered in the database.</p>
<pre><code class="language-php " >unique:$tableColumn
unique:$tableColumn,$ignoreColumn,$ignoreValue
unique:$tableColumn,$ignoreColumn,$ignoreValue,$connection
</code></pre>
<p>The rule has four parameters: <code>$tableColumn</code>, <code>$ignoreColumn</code>,
<code>$ignoreValue</code> and <code>$connection</code>.</p>
<p><code>$tableColumn</code> is the table name and, optionally, the column name separated by
a dot. If the column is not defined, the field name will be used as the column name.</p>
<p><code>$ignoreColumn</code> is the name of the column to ignore if the value is already
registered. Usually when updating data.</p>
<p><code>$ignoreValue</code> is the value to be ignored in the <code>$ignoreColumn</code>.</p>
<p><code>$connection</code> is the name of the database connection. The default is <code>default</code>.</p>
</div>
</div>
<div class="section" id="views">
<h2>Views</h2>
<p>To obtain a View instance, the class can be instantiated individually, as shown
in the example below:</p>
<pre><code class="language-php " >use Framework\MVC\View;
$baseDir = __DIR__ . &#039;/views&#039;;
$extension = &#039;.php&#039;;
$view = new View($baseDir, $extension);
</code></pre>
<p>Or getting an instance of the <code>view</code> service in the App class:</p>
<pre><code class="language-php " >use Framework\MVC\App;
$view = App::view();
</code></pre>
<p>With the View instantiated, we can render files.</p>
<p>The file below will be used on the home page and is located at
<strong>views/home/index.php</strong>:</p>
<pre><code class="language-php " >&lt;h1&gt;&lt;?= $title ?&gt;&lt;/h1&gt;
&lt;p&gt;&lt;?= $description ?&gt;&lt;/p&gt;
</code></pre>
<p>Returning to the main file, we pass the data to the file to be rendered:</p>
<pre><code class="language-php " >$file = &#039;home/index&#039;;
$data = [
    &#039;title&#039; =&gt; &#039;Welcome!&#039;,
    &#039;description&#039; =&gt; &#039;Welcome to Webisters MVC.&#039;,
];
echo $view-&gt;render($file, $data);
</code></pre>
<p>And the output will be like this:</p>
<pre><code class="language-html " >&lt;h1&gt;Welcome!&lt;/h1&gt;
&lt;p&gt;Welcome to Webisters MVC.&lt;/p&gt;
</code></pre>
<div class="section" id="extending-layouts">
<h3>Extending Layouts</h3>
<p>The View has a basic layout system that other view files can extend.</p>
<p>Let&#039;s see the layout file <strong>views/_layouts/default.php</strong> below:</p>
<pre><code class="language-php " >&lt;!doctype html&gt;
&lt;html lang=&quot;en&quot;&gt;
&lt;head&gt;
    &lt;meta charset=&quot;UTF-8&quot;&gt;
    &lt;meta name=&quot;viewport&quot; content=&quot;width=device-width, initial-scale=1&quot;&gt;
    &lt;title&gt;&lt;?= $title ?&gt;&lt;/title&gt;
&lt;/head&gt;
&lt;body&gt;
&lt;?= $view-&gt;renderBlock(&#039;contents&#039;) // string or null ?&gt;
&lt;/body&gt;
&lt;/html&gt;
</code></pre>
<p>Then, in the view that will be rendered by the <code>render</code> method, the file
<code>_layouts/default</code> sets the content inside the <code>contents</code> block:</p>
<p><strong>views/home/index.php</strong></p>
<pre><code class="language-php " >&lt;?php
$view-&gt;extends(&#039;_layouts/default&#039;); // static
$view-&gt;block(&#039;contents&#039;); // static
?&gt;
&lt;h1&gt;&lt;?= $title ?&gt;&lt;/h1&gt;
&lt;p&gt;&lt;?= $description ?&gt;&lt;/p&gt;
&lt;?php
$view-&gt;endBlock(); // static
</code></pre>
<p>If you want to extend views always from the same directory, you can set the
layout prefix:</p>
<pre><code class="language-php " >$view-&gt;setLayoutPrefix(&#039;_layouts&#039;); // static
</code></pre>
<p>This will make it unnecessary to type the entire path. See the example below:</p>
<pre><code class="language-diff " >- $view-&gt;extends(&#039;_layout/default&#039;);
+ $view-&gt;extends(&#039;default&#039;);
</code></pre>
<p>When working with only one file that extends a layout, it is possible to
set the default block name in the second argument of <code>extends</code>.</p>
<p>Let&#039;s see how to extend the default layout and capture the content in the file
<strong>views/home/index.php</strong>:</p>
<pre><code class="language-php " >&lt;?php
$view-&gt;extends(&#039;default&#039;, &#039;contents&#039;); // static
?&gt;
&lt;h1&gt;&lt;?= $title ?&gt;&lt;/h1&gt;
&lt;p&gt;&lt;?= $description ?&gt;&lt;/p&gt;
</code></pre>
<p>So the rendered HTML file will look like this:</p>
<pre><code class="language-html " >&lt;!doctype html&gt;
&lt;html lang=&quot;en&quot;&gt;
&lt;head&gt;
    &lt;meta charset=&quot;UTF-8&quot;&gt;
    &lt;meta name=&quot;viewport&quot; content=&quot;width=device-width, initial-scale=1&quot;&gt;
    &lt;title&gt;Welcome!&lt;/title&gt;
&lt;/head&gt;
&lt;body&gt;
&lt;h1&gt;Welcome!&lt;/h1&gt;
&lt;p&gt;Welcome to Webisters MVC.&lt;/p&gt;
&lt;/body&gt;
&lt;/html&gt;
</code></pre>
</div>
<div class="section" id="view-includes">
<h3>View Includes</h3>
<p>It is often common to have parts of the layout that are repeated. Like for example,
a header, a footer, a sidebar.</p>
<p>These files are called <strong>includes</strong>.</p>
<p>Let&#039;s see an example of include with a navigation bar in the file
<strong>views/_includes/navbar.php</strong>:</p>
<pre><code class="language-php " >&lt;div class=&quot;navbar&quot;&gt;
&lt;ul&gt;
    &lt;li&lt;?= $active === &#039;home&#039; ? &#039; class=&quot;active&quot;&#039; : &#039;&#039;?&gt;&gt;
        &lt;a href=&quot;/&quot;&gt;Home&lt;/a&gt;
    &lt;/li&gt;
    &lt;li&lt;?= $active === &#039;contact&#039; ? &#039; class=&quot;active&quot;&#039; : &#039;&#039;?&gt;&gt;
        &lt;a href=&quot;/contact&quot;&gt;Contact&lt;/a&gt;
    &lt;/li&gt;
&lt;/ul&gt;
&lt;/div&gt;
</code></pre>
<p>This navbar will appear in several layouts, including the default one.</p>
<p>Let&#039;s see below how to make it appear in views that extend the layout
<strong>views/_layouts/default.php</strong>:</p>
<pre><code class="language-php " >&lt;body&gt;
&lt;?= $view-&gt;include(&#039;_includes/navbar&#039;) // string ?&gt;
&lt;h1&gt;&lt;?= $title ?&gt;&lt;/h1&gt;
</code></pre>
<p>As with layouts, you can set the includes path prefix:</p>
<pre><code class="language-php " >$view-&gt;setIncludePrefix(&#039;_includes&#039;);
</code></pre>
<p>Once the includes path is set, it is no longer necessary to include it
in the include method call:</p>
<pre><code class="language-diff " >- $view-&gt;include(&#039;_includes/navbar&#039;);
+ $view-&gt;include(&#039;navbar&#039;);
</code></pre>
<p>The call in the default layout will be like this:</p>
<pre><code class="language-php " >&lt;body&gt;
&lt;?= $view-&gt;include(&#039;navbar&#039;) // string ?&gt;
&lt;h1&gt;&lt;?= $title ?&gt;&lt;/h1&gt;
</code></pre>
<p>When necessary, you can pass an array of data to the include.</p>
<p>Let&#039;s see how to pass the variable <code>active</code> with the value <code>home</code>:</p>
<pre><code class="language-php " >&lt;body&gt;
&lt;?= $view-&gt;include(&#039;navbar&#039;, [&#039;active&#039; =&gt; &#039;home&#039;]) // string ?&gt;
&lt;h1&gt;&lt;?= $title ?&gt;&lt;/h1&gt;
</code></pre>
<p>When rendered, the include will show the <code>active</code> class on the Home line in the
navbar:</p>
<pre><code class="language-html " >&lt;div class=&quot;navbar&quot;&gt;
&lt;ul&gt;
    &lt;li class=&quot;active&quot;&gt;
        &lt;a href=&quot;/&quot;&gt;Home&lt;/a&gt;
    &lt;/li&gt;
    &lt;li&gt;
        &lt;a href=&quot;/contact&quot;&gt;Contact&lt;/a&gt;
    &lt;/li&gt;
&lt;/ul&gt;
&lt;/div&gt;
</code></pre>
</div>
<div class="section" id="view-blocks">
<h3>View Blocks</h3>
<p>Below we will see how to create a block called <code>contents</code> and another
called <code>scripts</code> in the <strong>views/home/index.php</strong> file:</p>
<pre><code class="language-php " >&lt;?php
$view-&gt;extends(&#039;default&#039;); // static
$view-&gt;block(&#039;contents&#039;); // static
?&gt;
&lt;h1&gt;&lt;?= $title ?&gt;&lt;/h1&gt;
&lt;p&gt;&lt;?= $description ?&gt;&lt;/p&gt;
&lt;?php
$view-&gt;endBlock(); // static
$view-&gt;block(&#039;scripts&#039;); // static
?&gt;
&lt;script&gt;
    console.log(&#039;Hello!&#039;);
&lt;/script&gt;
&lt;?php
$view-&gt;endBlock(); // static
</code></pre>
<p>In the <strong>views/_layouts/default.php</strong> file we can render the two blocks:</p>
<pre><code class="language-php " >&lt;body&gt;
&lt;?= $view-&gt;renderBlock(&#039;contents&#039;) // string or null ?&gt;
&lt;?= $view-&gt;renderBlock(&#039;scripts&#039;) // string or null ?&gt;
&lt;/body&gt;
</code></pre>
<p>And the output will be like this:</p>
<pre><code class="language-html " >&lt;body&gt;
&lt;h1&gt;Welcome!&lt;/h1&gt;
&lt;p&gt;Welcome to Webisters MVC.&lt;/p&gt;
&lt;script&gt;
    console.log(&#039;Hello!&#039;);
&lt;/script&gt;
&lt;/body&gt;
</code></pre>
</div>
</div>
<div class="section" id="controllers">
<h2>Controllers</h2>
<p>The abstract class <strong>Framework\MVC\Controller</strong> extends the class
<strong>Framework\Routing\RouteActions</strong>, inheriting the characteristics necessary
for your methods to be used as route actions.</p>
<p>Below we see an example with the <strong>Home</strong> class and the <code>index</code> action method
returning a string that will be appended to the HTTP Response body:</p>
<pre><code class="language-php " >use Framework\MVC\Controller;
class Home extends Controller
{
    public function index() : string
    {
        return &#039;Home page.&#039;
    }
}
</code></pre>
<div class="section" id="render-views">
<h3>Render Views</h3>
<p>Instead of building all the page content inside the <code>index</code> method, you can
use the <code>render</code> method, with the name of the file that will be rendered,
building the HTML page as a view.</p>
<p>In this case, we render the <code>home/index</code> view:</p>
<pre><code class="language-php " >use Framework\MVC\Controller;
class Home extends Controller
{
    public function index() : string
    {
        return $this-&gt;render(&#039;home/index&#039;);
    }
}
</code></pre>
</div>
<div class="section" id="validate-data">
<h3>Validate Data</h3>
<p>When necessary, you can validate data using the <code>validate</code> method.</p>
<p>In it, it is possible to put the data that will be validated, the rules, and,
optionally, the labels, the messages and the name of the validation service
instance, which by default is <code>default</code>.</p>
<p>In the example below we highlight the <code>create</code> method, which can be called by
the HTTP POST method to create a contact message.</p>
<p>Note that the rules are set and then the POST data is validated, returning an
array with the errors and showing them on the screen in a list or an empty array,
showing that no validation errors occurred and the message that was created
successfully:</p>
<pre><code class="language-php " >use Framework\MVC\Controller;
class Contact extends Controller
{
    public function index() : string
    {
        return $this-&gt;render(&#039;contact/index&#039;);
    }
    public function create() : void
    {
        $rules = [
            &#039;name&#039; =&gt; &#039;minLength:5|maxLength:32&#039;,
            &#039;email&#039; =&gt; &#039;email&#039;,
            &#039;message&#039; =&gt; &#039;minLength:10|maxLength:1000&#039;,
        ];
        $errors = $this-&gt;validate($this-&gt;request-&gt;getPost(), $rules);
        if ($errors) {
            echo &#039;&lt;h2&gt;Validation Errors&lt;/h2&gt;&#039;;
            echo &#039;&lt;ul&gt;&#039;;
            foreach($errors as $error) {
                echo &#039;&lt;li&gt;&#039; . $error . &#039;&lt;/li&gt;&#039;;
            }
            echo &#039;&lt;/ul&gt;&#039;;
            return;
        }
        echo &#039;&lt;h2&gt;Contact Successful Created&lt;/h2&gt;&#039;;
    }
}
</code></pre>
</div>
<div class="section" id="http-request-and-response">
<h3>HTTP Request and Response</h3>
<p>The Controller has instances of the two HTTP messages, the Request and the
Response, accessible through properties that can be called directly.</p>
<p>Let&#039;s see below how to use Request to get the current URL as a string and put it
in the Response body:</p>
<pre><code class="language-php " >use Framework\HTTP\Response;
use Framework\MVC\Controller;
class Home extends Controller
{
    public function index() : Response
    {
        $url = (string) $this-&gt;request-&gt;getUrl();
        return $this-&gt;response-&gt;setBody(
            &#039;Current URL is: &#039; . $url
        );
    }
}
</code></pre>
<p>The example above is simple, but $request and $response are powerful, having
numerous useful methods for working on HTTP interactions.</p>
</div>
<div class="section" id="model-instances">
<h3>Model Instances</h3>
<p>Each controller can have model instances in properties, which will be automatically
instantiated in the class constructor.</p>
<p>The properties must be child classes of the <code>Framework\MVC\Model</code> class.</p>
<p>Let&#039;s see below that <code>$users</code> receives the type name of the
<code>App\Models\UsersModel</code> class and in the <code>show</code> method the direct call to
the <code>$users</code> property is used, which has the instance of
<code>App\Models\UsersModel</code>:</p>
<pre><code class="language-php " >use App\Models\UsersModel;
use Framework\MVC\Controller;
class Users extends Controller
{
    protected UsersModel $users;
    public function show(int $id) : string
    {
        $user = $this-&gt;users-&gt;read($id);
        return $this-&gt;render(&#039;users/show&#039;, [
            &#039;user&#039; =&gt; $user,
        ]);
    }
}
</code></pre>
</div>
<div class="section" id="json-responses">
<h3>JSON Responses</h3>
<p>As with the Framework\Routing\RouteActions class, the controller action methods
can return an array, stdClass, or JsonSerializable instance so that the Response
is automatically set with the JSON Content-Type and the message body as well.</p>
<p>In the example below, we see how to get the users of a page, with an array
returned from the model&#039;s <code>paginate</code> method, and then returned to be
JSON-encoded and added to the Response body:</p>
<pre><code class="language-php " >use App\Models\UsersModel;
use Framework\MVC\Controller;
class Users extends Controller
{
    protected UsersModel $users;
    public function index() : array
    {
        $page = $this-&gt;request-&gt;getGet(&#039;page&#039;)
        $users = $this-&gt;users-&gt;paginate($page);
        return $users;
    }
}
</code></pre>
</div>
<div class="section" id="before-and-after-actions">
<h3>Before and After Actions</h3>
<p>Every controller has two methods inherited from Framework\Routing\RouteActions
that can be used to prepare configurations, filter input data, and also to
finalize configurations and filter output data.</p>
<p>They are <code>beforeAction</code> and <code>afterAction</code>.</p>
<p>Let&#039;s look at a simple example to validate a user&#039;s access to a dashboard&#039;s pages.</p>
<p>We create the <strong>AdminController</strong> class and put a check in it to see if the
<code>user_id</code> is set in the session. If not, the page will be redirected to the
location <code>/login</code>. Otherwise, access to the action method is released and
the user can access the admin area:</p>
<pre><code class="language-php " >use Framework\MVC\App;
use Framework\MVC\Controller;
abstract class AdminController extends Controller
{
    protected function beforeAction(string $method, array $arguments) : mixed
    {
        if (!App::session()-&gt;has(&#039;user_id&#039;)) {
            return $this-&gt;response-&gt;redirect(&#039;/login&#039;);
        }
        return null;
    }
}
</code></pre>
<p>Below, the Dashboard methods will only be executed if <code>beforeAction</code> returns
<code>null</code> in the parent class, AdminController:</p>
<pre><code class="language-php " >final class Dashboard extends AdminController
{
    public function index() : string
    {
        return &#039;You are in Admin Area!&#039;;
    }
}
</code></pre>
</div>
</div>
<div class="section" id="conclusion">
<h2>Conclusion</h2>
<p>Webisters MVC Library is an easy-to-use tool for, beginners and experienced, PHP developers.<br>It is perfect to create simple, fast and powerful MVC applications.<br>The more you use it, the more you will learn.</p>
<div class="phpdocumentor-admonition -note ">
            <svg class="phpdocumentor-admonition__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path></svg>
                    <article>
        <p>Did you find something wrong?<br>Be sure to let us know about it with an
<a href="https://github.com/webisters/mvc/issues">issue</a>.<br>Thank you!</p>
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
