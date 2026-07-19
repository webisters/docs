<?php
$pageTitle = 'Webisters Docs';
require_once __DIR__ . '/../../../includes/header.php';
require_once __DIR__ . '/../../../includes/sidebar.php';
?>
<div class="section" id="config">
<h1>Config</h1>
<p>Webisters Config Library.</p>
<ul>
    <li>
            <a href="#installation">Installation</a>
        </li>
    <li>
            <a href="#config-manipulation">Config Manipulation</a>
        </li>
    <li>
            <a href="#configuration-files">Configuration Files</a>
        </li>
    <li>
            <a href="#persistence">Persistence</a>
        </li>
    <li>
            <a href="#parsers">Parsers</a>
        </li>
    <li>
            <a href="#conclusion">Conclusion</a>
        </li>
</ul>
<div class="section" id="installation">
<h2>Installation</h2>
<p>The installation of this library can be done with Composer:</p>
<pre><code class="language- " >composer require Webisters/config
</code></pre>
</div>
<div class="section" id="config-manipulation">
<h2>Config Manipulation</h2>
<p>The Config Library allows you to manipulate configurations to be used by
services, storing them in a single place.</p>
<p>To instantiate the Config class, we can do as follows:</p>
<pre><code class="language-php " >&lt;?php
require __DIR__ . &#039;/vendor/autoload.php&#039;;
use Framework\Config\Config;
$config = new Config();
</code></pre>
<div class="section" id="the-structure-of-a-service-instance-configuration">
<h3>The structure of a service instance configuration</h3>
<p>All configurations are stored in arrays, in which there are keys with the name
of the service instances, such as <code>default</code>:</p>
<pre><code class="language-php " >[
    &#039;default&#039; =&gt; [],
]
</code></pre>
<p>And in these keys are inserted the configs of each service instance.</p>
<p>Let&#039;s look at a configuration file used to instantiate database services:</p>
<pre><code class="language-php " >&lt;?php
return [
    &#039;default&#039; =&gt; [
        &#039;host&#039; =&gt; &#039;localhost&#039;,
        &#039;username&#039; =&gt; &#039;root&#039;,
        &#039;password&#039; =&gt; &#039;password&#039;,
    ],
];
</code></pre>
<p>Note that the file returns an array with the <code>default</code> key.</p>
<p>It is possible to define more configurations, adding new keys, which are the
name of the service instances.</p>
<p>Let&#039;s see how to define the configurations for the <code>default</code> and <code>replica</code>
instances:</p>
<pre><code class="language-php " >[
    &#039;default&#039; =&gt; [
        &#039;host&#039; =&gt; &#039;localhost&#039;,
        &#039;username&#039; =&gt; &#039;root&#039;,
        &#039;password&#039; =&gt; &#039;password&#039;,
    ],
    &#039;replica&#039; =&gt; [
        &#039;host&#039; =&gt; &#039;192.168.0.100&#039;,
        &#039;username&#039; =&gt; &#039;root&#039;,
        &#039;password&#039; =&gt; &#039;foo&#039;,
    ],
]
</code></pre>
</div>
<div class="section" id="set-and-get">
<h3>Set and Get</h3>
<p>In the Config instance we can set and get configurations with the <code>set</code> and
<code>get</code> methods.</p>
<div class="section" id="set-service-configs">
<h4>Set Service Configs</h4>
<p>Let&#039;s see how to set the <strong>database</strong> service configs with host and username
information:</p>
<pre><code class="language-php " >$serviceName = &#039;database&#039;;
$serviceConfigs = [
    &#039;host&#039; =&gt; &#039;localhost&#039;,
    &#039;username&#039; =&gt; &#039;root&#039;,
];
$config-&gt;set($serviceName, $serviceConfigs); // array
</code></pre>
</div>
<div class="section" id="get-service-configs">
<h4>Get Service Configs</h4>
<p>So, we can get the information through the <code>get</code> method. Let&#039;s see:</p>
<pre><code class="language-php " >$serviceName = &#039;database&#039;;
$configs = $config-&gt;get($serviceName); // array or null
</code></pre>
<p>And, in the <code>$configs</code> variable, the database information will be defined:</p>
<pre><code class="language-php " >[
    &#039;host&#039; =&gt; &#039;localhost&#039;,
    &#039;username&#039; =&gt; &#039;root&#039;,
]
</code></pre>
</div>
<div class="section" id="custom-service-instance-names">
<h4>Custom Service Instance Names</h4>
<p>The default instance is the <code>default</code>. However, you can manipulate information
from other instances.</p>
<p>To set a non-default instance, use the third parameter of the <code>set</code> method.</p>
<p>Let&#039;s see how to add information to the <code>replica</code> instance:</p>
<pre><code class="language-php " >$serviceInstanceName = &#039;replica&#039;;
$configs = $config-&gt;set($serviceName, $serviceConfigs, $serviceInstanceName);
</code></pre>
<p>And to get information, we use the second parameter of the <code>get</code> method.</p>
<pre><code class="language-php " >$serviceInstanceName = &#039;replica&#039;;
$configs = $config-&gt;get($serviceName, $serviceInstanceName); // array or null
</code></pre>
</div>
</div>
<div class="section" id="add">
<h3>Add</h3>
<p>Above, we saw how to set configurations that overwrite existing instances.</p>
<p>But, it is possible to add only new configs, which will be merged.</p>
<p>For this, we use the <code>add</code> method:</p>
<pre><code class="language-php " >$config-&gt;add($serviceName, $serviceConfigs); // array
</code></pre>
<p>And, in the third parameter, you can define in which instance the configs will
be added:</p>
<pre><code class="language-php " >$config-&gt;add($serviceName, $serviceConfigs, &#039;default&#039;); // array
</code></pre>
</div>
<div class="section" id="set-many">
<h3>Set Many</h3>
<p>It is possible to set several configurations at once through the <code>setMany</code> method.</p>
<p>Let&#039;s see how to set two instances of database configurations (default and
replica) and one instance for the cache service (default):</p>
<pre><code class="language-php " >$config-&gt;setMany([
    &#039;database&#039; =&gt; [
        &#039;default&#039; =&gt; [
            &#039;host&#039; =&gt; &#039;localhost&#039;,
            &#039;username&#039; =&gt; &#039;root&#039;,
        ],
        &#039;replica&#039; =&gt; [
            &#039;host&#039; =&gt; &#039;192.168.0.100&#039;,
            &#039;username&#039; =&gt; &#039;root&#039;,
            &#039;password&#039; =&gt; &#039;P45SwopD&#039;,
        ],
    ],
    &#039;cache&#039; =&gt; [
        &#039;default&#039; =&gt; [
            &#039;handler&#039; =&gt; &#039;memcached&#039;,
        ],
    ],
]); // static
</code></pre>
</div>
<div class="section" id="get-all">
<h3>Get All</h3>
<p>To get all the configurations use the <code>getAll</code> method:</p>
<pre><code class="language-php " >$allConfigs = $config-&gt;getAll(); // array
</code></pre>
</div>
</div>
<div class="section" id="configuration-files">
<h2>Configuration Files</h2>
<p>Above, we saw how to set configurations individually by instances and also
several at once.</p>
<p>In addition to being able to modify the configurations by methods, it is also
possible to define configurations in files that contain the name of the services
and return an array with the instances.</p>
<p>To do this, use Config passing the directory where the configuration files will
be in the first argument:</p>
<pre><code class="language-php " >$directoryPath = __DIR__ . &#039;/configs&#039;;
$config = new Config($directoryPath);
</code></pre>
<p>It is desirable that all configuration files have the <code>default</code> instance.</p>
<p>In the file below we have two instances, <code>default</code> and <code>custom</code> and the file
name must be the name of the service, for example, <strong>database.php</strong>:</p>
<pre><code class="language-php " >return [
    &#039;default&#039; =&gt; [],
    &#039;custom&#039; =&gt; [],
];
</code></pre>
<p>When there is a directory defined, the configuration files will be loaded
automatically and the service settings will be filled in.</p>
<p>In the example below, let&#039;s get the database service information with the
<code>default</code> instance and then with the <code>custom</code> instance:</p>
<pre><code class="language-php " >$databaseDefaultConfigs = $config-&gt;get(&#039;database&#039;); // array or null
$databaseCustomConfigs = $config-&gt;get(&#039;database&#039;, &#039;custom&#039;); // array or null
</code></pre>
<p>If you try to get configs from a service that hasn&#039;t been set up yet and the
service file doesn&#039;t exist, an exception will be thrown.</p>
</div>
<div class="section" id="persistence">
<h2>Persistence</h2>
<p>In the second argument of the Config class it is possible to set persistent
configurations, which will not be overwritten by the <code>add</code>, <code>load</code>, <code>set</code>
and <code>setMany</code> methods:</p>
<pre><code class="language-php " >use Framework\Config\Config;
$directory = __DIR__ . &#039;/../configs&#039;;
$persistence = [
    &#039;database&#039; =&gt; [
        &#039;host&#039; =&gt; &#039;localhost&#039;,
    ]
]
$config = new Config($directory, $persistence);
</code></pre>
</div>
<div class="section" id="parsers">
<h2>Parsers</h2>
<p>The library has several parses for different types of files. With which it is
possible to set <a href="#persistence">Persistence</a> or several settings at once using the
<a href="#set-many">Set Many</a> method.</p>
<p>Let&#039;s see an example parsing a file of type <strong>env</strong> and setting various
configurations:</p>
<pre><code class="language-php " >use Framework\Config\Config;
use Framework\Config\Parsers\EnvParser;
$filename = __DIR__ . &#039;/../.env&#039;;
$configs = EnvParser::parse($filename); // array
$config = new Config();
$config-&gt;setMany($configs); // static
</code></pre>
<p>The same can be done to set persistent configurations:</p>
<pre><code class="language-php " >use Framework\Config\Config;
use Framework\Config\Parsers\EnvParser;
$filename = __DIR__ . &#039;/../.env&#039;;
$configs = EnvParser::parse($filename); // array
$config = new Config(persistence: $configs);
</code></pre>
<p>The Config Library provides the following parsers:</p>
<ul>
    <li>
            <a href="#ini-parser">INI Parser</a>
        </li>
    <li>
            <a href="#yaml-parser">YAML Parser</a>
        </li>
    <li>
            <a href="#database-parser">Database Parser</a>
        </li>
    <li>
            <a href="#json-parser">JSON Parser</a>
        </li>
    <li>
            <a href="#xml-parser">XML Parser</a>
        </li>
    <li>
            <a href="#env-parser">Env Parser</a>
        </li>
</ul>
<div class="section" id="ini-parser">
<h3>INI Parser</h3>
<p>Files of type <strong>INI</strong> can be parsed as shown below:</p>
<pre><code class="language-php " >use Framework\Config\Parsers\IniParser;
$filename = __DIR__ . &#039;/../config.ini&#039;;
$configs = IniParser::parse($filename); // array
</code></pre>
<p>The syntax of <strong>INI</strong> files is as follows:</p>
<pre><code class="language-ini " ># Service 1
[service1]
default.value1 = foo
default.value2 = 23
# Service 2
[service2]
default.array.0 = True
custom.array.1 = &#039;False&#039;
</code></pre>
</div>
<div class="section" id="yaml-parser">
<h3>YAML Parser</h3>
<p>Files of type <strong>YAML</strong> can be parsed as follows:</p>
<pre><code class="language-php " >use Framework\Config\Parsers\YamlParser;
$filename = __DIR__ . &#039;/../config.yaml&#039;;
$configs = YamlParser::parse($filename); // array
</code></pre>
<p>And below is an example of the syntax of a <strong>YAML</strong> file:</p>
<pre><code class="language-yaml " ># Service 1
service1:
  default:
    value1: foo
    value2: 23
# Service 2
service2:
  default:
    array: [True]
  custom:
    array: [&#039;False&#039;]
</code></pre>
</div>
<div class="section" id="database-parser">
<h3>Database Parser</h3>
<p>In addition to files, configurations of a <strong>database</strong> table can also be
obtained using the <a href="https://docs.webisters.com/guides/libraries/database/">Database Library</a>.</p>
<p>Instead of passing the file path to the <code>parse</code> method, you pass the
database connection information:</p>
<pre><code class="language-php " >use Framework\Config\Parsers\DatabaseParser;
$databaseConfigs = [
    &#039;username&#039; =&gt; &#039;dbuser&#039;
    &#039;password&#039; =&gt; &#039;p4$$30rT&#039;
    &#039;schema&#039; =&gt; &#039;app&#039;
    &#039;table&#039; =&gt; &#039;Configs&#039;
];
$configs = DatabaseParser::parse($databaseConfigs); // array
</code></pre>
<p>The configuration table in the database can be created as shown below:</p>
<pre><code class="language-sql " >USE `app`;
CREATE TABLE `Configs` (
    `key` varchar(255) NOT NULL PRIMARY KEY,
    `value` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
</code></pre>
<p>And the values of the services must have the service name as a prefix, followed
by a period and the name of the instance and after another period the name
of the configuration key.</p>
<p>Let&#039;s see how to enter example configurations:</p>
<pre><code class="language-sql " >INSERT INTO `Configs`
(`key`, `value`)
VALUES
(&#039;service1.default.value1&#039;, &#039;foo&#039;),
(&#039;service1.default.value2&#039;, 23),
(&#039;service2.default.0&#039;, &#039;True&#039;),
(&#039;service2.custom.0&#039;, &#039;&quot;False&quot;&#039;);
</code></pre>
<p>Below is an example file to create the Configs table and insert sample data
using the Database Library:</p>
<pre><code class="language-php " >use Framework\Database\Database;
use Framework\Database\Definition\Table\TableDefinition;
$username = &#039;dbuser&#039;;
$password = &#039;p4$$30rT&#039;;
$schema = &#039;app&#039;;
$table = &#039;Configs&#039;;
$database = new Database($username, $password, $schema);
$database-&gt;createTable($table)
    -&gt;definition(function (TableDefinition $definition) {
        $definition-&gt;column(&#039;key&#039;)-&gt;varchar(255)-&gt;primaryKey();
        $definition-&gt;column(&#039;value&#039;)-&gt;varchar(255);
    })-&gt;run();
$database-&gt;insert($table)
    -&gt;columns(&#039;key&#039;, &#039;value&#039;)
    -&gt;values([
        [&#039;service1.default.value1&#039;, &#039;foo&#039;],
        [&#039;service1.default.value2&#039;, 23],
        [&#039;service2.default.0&#039;, &#039;True&#039;],
        [&#039;service2.custom.0&#039;, &#039;&quot;False&quot;&#039;],
    ])-&gt;run();
</code></pre>
</div>
<div class="section" id="json-parser">
<h3>JSON Parser</h3>
<p>Configurations can also be stored in <strong>JSON</strong> files.</p>
<p>To get the configs, just use JsonParser:</p>
<pre><code class="language-php " >use Framework\Config\Parsers\JsonParser;
$filename = __DIR__ . &#039;/../config.json&#039;;
$configs = JsonParser::parse($filename); // array
</code></pre>
<p>Below is an example with the <strong>JSON</strong> syntax:</p>
<pre><code class="language-json " >{
    &quot;service1&quot;: {
        &quot;default&quot;: {
            &quot;value1&quot;: &quot;foo&quot;,
            &quot;value2&quot;: 23
        }
    },
    &quot;service2&quot;: {
        &quot;default&quot;: {
            &quot;array&quot;: [
                True
            ]
        },
        &quot;custom&quot;: {
            &quot;array&quot;: [
                &quot;False&quot;
            ]
        }
    }
}
</code></pre>
</div>
<div class="section" id="xml-parser">
<h3>XML Parser</h3>
<p>Configurations can also be stored in <strong>XML</strong>.</p>
<pre><code class="language-php " >use Framework\Config\Parsers\XmlParser;
$filename = __DIR__ . &#039;/../config.xml&#039;;
$configs = XmlParser::parse($filename); // array
</code></pre>
<p>Example <strong>XML</strong> file with configs:</p>
<pre><code class="language-xml " >&lt;?xml version=&quot;1.0&quot; encoding=&quot;UTF-8&quot; ?&gt;
&lt;config&gt;
    &lt;!-- Service 1 --&gt;
    &lt;service1&gt;
        &lt;default&gt;
            &lt;value1&gt;foo&lt;/value1&gt;
            &lt;value2&gt;23&lt;/value2&gt;
        &lt;/default&gt;
    &lt;/service1&gt;
    &lt;!-- Service 2 --&gt;
    &lt;service2&gt;
        &lt;default&gt;
            &lt;array&gt;True&lt;/array&gt;
        &lt;/default&gt;
        &lt;custom&gt;
            &lt;array&gt;&#039;False&#039;&lt;/array&gt;
        &lt;/custom&gt;
    &lt;/service2&gt;
&lt;/config&gt;
</code></pre>
</div>
<div class="section" id="env-parser">
<h3>Env Parser</h3>
<p>Also, you can use files with the <strong>ENV</strong> syntax:</p>
<pre><code class="language-php " >use Framework\Config\Parsers\EnvParser;
$filename = __DIR__ . &#039;/../config.env&#039;;
$configs = EnvParser::parse($filename); // array
</code></pre>
<pre><code class="language-bash " ># Service 1
service1.default.value1 = foo
service1.default.value2 = 23
# Service 2
service2.default.array.0 = True
service2.custom.array.1 = &#039;False&#039;
</code></pre>
</div>
</div>
<div class="section" id="conclusion">
<h2>Conclusion</h2>
<p>Webisters Config Library is an easy-to-use tool for, beginners and experienced, PHP developers.<br>It is perfect to organize, centralize and manipulate configurations.<br>The more you use it, the more you will learn.</p>
<div class="phpdocumentor-admonition -note ">
            <svg class="phpdocumentor-admonition__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path></svg>
                    <article>
        <p>Did you find something wrong?<br>Be sure to let us know about it with an
<a href="https://github.com/webisters/config/issues">issue</a>.<br>Thank you!</p>
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
