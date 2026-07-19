<?php
$pageTitle = 'Webisters Docs';
require_once __DIR__ . '/../../../includes/header.php';
require_once __DIR__ . '/../../../includes/sidebar.php';
?>
<div class="section" id="autoload">
<h1>Autoload</h1>
<p>Webisters Autoload Library.</p>
<ul>
    <li>
            <a href="#installation">Installation</a>
        </li>
    <li>
            <a href="#autoloader">Autoloader</a>
        </li>
    <li>
            <a href="#locator">Locator</a>
        </li>
    <li>
            <a href="#preloader">Preloader</a>
        </li>
    <li>
            <a href="#conclusion">Conclusion</a>
        </li>
</ul>
<div class="section" id="installation">
<h2>Installation</h2>
<p>The installation of this library can be done with Composer:</p>
<pre><code class="language- " >composer require Webisters/autoload
</code></pre>
</div>
<div class="section" id="autoloader">
<h2>Autoloader</h2>
<p><a href="https://www.php.net/manual/en/language.oop5.autoload.php">Autoload</a>
makes it possible to load files with classes, interfaces, traits and
enums automatically if they are not declared.</p>
<p>This library allows <a href="#autoload-classes">Autoload Classes</a> and <a href="#autoload-with-namespaces">Autoload with Namespaces</a>.</p>
<p>For this, the Autoloader class is instantiated as shown in the following example:</p>
<pre><code class="language-php " >use Framework\Autoload\Autoloader;
$autoloader = new Autoloader();
</code></pre>
<p>It has two parameters. The first causes the class to be registered as an autoloader
and the second the file extensions that can be loaded, which by default is <code>.php</code>.</p>
<div class="section" id="register">
<h3>Register</h3>
<p>If the registration is not performed through the constructor, you can register
whenever you want through the <code>register</code> method:</p>
<pre><code class="language-php " >$autoloader-&gt;register(); // bool
</code></pre>
<p>Once this is done, the classes registered in the Autoloader can be automatically
loaded.</p>
</div>
<div class="section" id="autoload-classes">
<h3>Autoload Classes</h3>
<p>To register the name of a class that is in a given file, we can use the
<code>setClass</code> method:</p>
<div class="section" id="set-class">
<h4>Set Class</h4>
<pre><code class="language-php " >$name = &#039;App&#039;;
$filepath = __DIR__ . &#039;/App.php&#039;;
$autoloader-&gt;setClass($name, $filepath); // static
</code></pre>
</div>
<div class="section" id="set-classes">
<h4>Set Classes</h4>
<p>Or, register multiple classes at once with <code>setClasses</code>:</p>
<pre><code class="language-php " >$classes = [
    &#039;App&#039; =&gt; __DIR__ . &#039;/App.php&#039;,
    &#039;Config&#039; =&gt; __DIR__ . &#039;/Config.php&#039;,
];
$autoloader-&gt;setClasses($classes); // static
</code></pre>
</div>
<div class="section" id="get-class">
<h4>Get Class</h4>
<p>To get the file path of a registered class, you can use the <code>getClass</code> method:</p>
<pre><code class="language-php " >$autoloader-&gt;getClass($name); // string or null
</code></pre>
</div>
<div class="section" id="get-classes">
<h4>Get Classes</h4>
<p>And, to get an array with the class names as keys and the file paths as values,
use the <code>getClasses</code> method:</p>
<pre><code class="language-php " >$autoloader-&gt;getClasses(); // array of strings
</code></pre>
</div>
<div class="section" id="remove-class">
<h4>Remove Class</h4>
<p>If you need to remove a class from the Autoloader, use the <code>removeClass</code> method:</p>
<pre><code class="language-php " >$name = &#039;App&#039;;
$autoloader-&gt;removeClass($name); // static
</code></pre>
</div>
<div class="section" id="remove-classes">
<h4>Remove Classes</h4>
<p>Or <code>removeClasses</code> to remove multiple classes at once:</p>
<pre><code class="language-php " >$names = [
    &#039;App&#039;,
    &#039;Config&#039;,
];
$autoloader-&gt;removeClasses($names); // static
</code></pre>
</div>
</div>
<div class="section" id="autoload-with-namespaces">
<h3>Autoload with Namespaces</h3>
<p>Registering classes individually is great if the files are in different
directories or the file names are inconsistent.</p>
<p>However, a much more powerful way to load classes is to register namespaces
for directories.</p>
<p>Inside this directories, files with the name of the requested class will be
searched and, if found, will be loaded.</p>
<div class="section" id="add-namespace">
<h4>Add Namespace</h4>
<p>Let&#039;s see how to add namespaces in Autoloader:</p>
<pre><code class="language-php " >$namespace = &#039;App&#039;;
$directory = __DIR__ . &#039;/app&#039;;
$autoloader-&gt;addNamespace($namespace, $directory); // static
</code></pre>
<p>This causes Autoloader to look for classes starting with the <code>App</code> namespace
within the <code>__DIR__ . '/app'</code> directory.</p>
</div>
<div class="section" id="set-namespace">
<h4>Set Namespace</h4>
<p>Instead of adding namespaces, it may be necessary to set namespaces, removing
all others. For this, use the <code>setNamespace</code> method:</p>
<pre><code class="language-php " >$autoloader-&gt;setNamespace($namespace, $directory); // static
</code></pre>
</div>
<div class="section" id="get-namespace">
<h4>Get Namespace</h4>
<p>To know in which directory a namespace is looking for files we use the
<code>getNamespace</code> method. Which will return an array with the directories of a
namespace.</p>
<p>Let&#039;s see the example below, getting the directories from the <strong>App</strong> namespace:</p>
<pre><code class="language-php " >$directories = $autoloader-&gt;getNamespace(&#039;App&#039;); // array of strings
</code></pre>
</div>
<div class="section" id="set-namespaces">
<h4>Set Namespaces</h4>
<p>Also, it&#039;s possible to have multiple namespaces pointing to directories at once
with the <code>setNamespaces</code> method.</p>
<p>Let&#039;s see how to set a directory for the <strong>App</strong> namespace and another for
<strong>Config</strong>:</p>
<pre><code class="language-php " >$autoloader-&gt;setNamespaces([
    &#039;App&#039; =&gt; __DIR__ . &#039;/app&#039;,
    &#039;Config&#039; =&gt; __DIR__ . &#039;/config&#039;,
]); // static
</code></pre>
</div>
<div class="section" id="get-namespaces">
<h4>Get Namespaces</h4>
<p>To get all the namespaces, use the <code>getNamespaces</code> method:</p>
<pre><code class="language-php " >$namespaces = $autoloader-&gt;getNamespaces(); // array of array of strings
</code></pre>
</div>
<div class="section" id="remove-namespace">
<h4>Remove Namespace</h4>
<p>If necessary, a namespace can be removed as in the example below:</p>
<pre><code class="language-php " >$autoloader-&gt;removeNamespace(&#039;App&#039;); // static
</code></pre>
</div>
<div class="section" id="remove-namespaces">
<h4>Remove Namespaces</h4>
<p>Or remove multiple at once:</p>
<pre><code class="language-php " >$autoloader-&gt;removeNamespaces([
    &#039;App&#039;,
    &#039;Config&#039;,
]); // static
</code></pre>
</div>
<div class="section" id="find-class-path">
<h4>Find Class Path</h4>
<p>With Autoloader it is possible to obtain the file path that a class has.
Let&#039;s see:</p>
<pre><code class="language-php " >$filepath = $autoloader-&gt;findClassPath(&#039;App\Models\Users&#039;); // string or null
</code></pre>
</div>
</div>
<div class="section" id="locator">
<h2>Locator</h2>
<p>Locator makes it easy to find and list files in certain directories or namespaces.</p>
<p>To instantiate it you need an instance of Autoloader. Let&#039;s see:</p>
<pre><code class="language-php " >use Framework\Autoload\Autoloader;
use Framework\Autoload\Locator;
$autoloader = new Autoloader();
$locator = new Locator($autoloader);
</code></pre>
<p>Once this is done, we can locate files and get information about them.</p>
<div class="section" id="get-class-name">
<h3>Get Class Name</h3>
<p>With Locator we can get the class name of a file that contains a class,
interface, trait or enum.</p>
<p>Let&#039;s say there is a <strong>app/Models/Users.php</strong> file:</p>
<pre><code class="language-php " >&lt;?php
namespace App\Models;
class Users
{
    //
}
</code></pre>
<p>To find the Qualified Class Name in this file, we could use the <code>getClassName</code>
method. For example:</p>
<pre><code class="language-php " >$filename = __DIR__ . &#039;/app/Models/Users.php&#039;;
$className = $locator-&gt;getClassName($filename); // string or null
</code></pre>
<p>Which would return <strong>App\Models\Users</strong>.</p>
</div>
<div class="section" id="locate-files">
<h3>Locate Files</h3>
<p>In Locator, there are similar methods, but with slightly different features.</p>
<p>You can get a namespaced path, find files within namespaces, files within
subdirectories within namespaces, and files everywhere.</p>
<div class="section" id="get-namespaced-filepath">
<h4>Get Namespaced Filepath</h4>
<p>Get the first filename found in namespaces with the <code>getNamespacedFilepath</code> method:</p>
<pre><code class="language-php " >$file = &#039;Tests/Foo&#039;;
$filepath = $locator-&gt;getNamespacedFilepath($file, &#039;.php&#039;); // string or null
</code></pre>
</div>
<div class="section" id="find-files">
<h4>Find Files</h4>
<p>To find all files with the same name within all namespaces we can use the
<code>findFiles</code> method:</p>
<pre><code class="language-php " >$file = &#039;Foo&#039;;
$files = $locator-&gt;findFiles($filename, &#039;.php&#039;); // array of strings
</code></pre>
</div>
<div class="section" id="get-files">
<h4>Get Files</h4>
<p>To get a list of all files within a subdirectory within namespaces we can use the
<code>getFiles</code> method:</p>
<pre><code class="language-php " >$subDirectory = &#039;tests&#039;;
$files = $locator-&gt;getFiles($subDirectory, &#039;.php&#039;); // array of strings
</code></pre>
</div>
<div class="section" id="list-files">
<h4>List Files</h4>
<p>To list absolutely all the files inside a directory, we can use the
<code>listFiles</code> method:</p>
<pre><code class="language-php " >$directory = &#039;tests&#039;;
$files = $locator-&gt;listFiles($directory); // array of strings or null
</code></pre>
</div>
</div>
</div>
<div class="section" id="preloader">
<h2>Preloader</h2>
<p><a href="https://www.php.net/manual/en/opcache.preloading.php">Preloading</a> makes it
possible to load classes into memory, as if they were part of the PHP core.<br>Once loaded, they will be available on all requests.</p>
<p>To load the Webisters class files, just use the file with the Preloader
class and call the <code>load</code> method.</p>
<p>To load the Webisters class files, create a file like <strong>preload.php</strong>:</p>
<pre><code class="language-php " >&lt;?php
require __DIR__ . &#039;/vendor/Webisters/autoload/src/Preloader.php&#039;;
use Framework\Autoload\Preloader;
$preloader = new Preloader();
$preloader-&gt;load(); // array of strings
</code></pre>
<p>Then, edit the PHP-FPM <strong>php.ini</strong> file by setting the preload file path and,
if necessary, the user:</p>
<pre><code class="language-ini " >opcache.preload = /path/to/preload.php
opcache.preload_user = www-data
</code></pre>
<div class="section" id="autoloader-instance">
<h3>Autoloader Instance</h3>
<p>It is possible to pass an Autoloader instance into the Preloader constructor.</p>
<p>By doing this, all classes set directly or through namespaces will be included
for loading.</p>
<p>That way you can add classes that don&#039;t belong to the Framework.</p>
<pre><code class="language-php " >use Framework\Autoload\Autoloader;
use Framework\Autoload\Preloader;
$autoloader = new Autoloader();
$autoloader-&gt;addNamespace(&#039;Foo&#039;, __DIR__ . &#039;/foo&#039;); // static
$preloader = new Preloader($autoloader);
$preloader-&gt;load(); // array of strings
</code></pre>
</div>
<div class="section" id="packages">
<h3>Packages</h3>
<p>The packages directory is defined by default in the Preloader class&#039;s constructor.</p>
<p>The default directory is: <code>__DIR__ . '/../../'</code>. Which is compatible with the
structure created by Composer.</p>
<div class="section" id="packages-directory">
<h4>Packages Directory</h4>
<p>If necessary, you can set a different path to the parent directory of the
framework packages:</p>
<pre><code class="language-php " >$packagesDir = __DIR__ . &#039;/Webisters&#039;;
$preloader = new Preloader($autoloader, $packagesDir);
</code></pre>
</div>
<div class="section" id="get-packages-dir">
<h4>Get Packages Dir</h4>
<p>To get the current packages directory use <code>getPackagesDir</code>:</p>
<pre><code class="language-php " >$packagesDir = $preloader-&gt;getPackagesDir(); // string
</code></pre>
</div>
<div class="section" id="set-packages-dir">
<h4>Set Packages Dir</h4>
<p>Preloader can be instantiated without a packages directory.</p>
<p>To do so, set <code>packagesDir</code> to <code>null</code> which will prevent Framework packages
from being loaded.</p>
<pre><code class="language-php " >$preloader = new Preloader(packagesDir: null);
</code></pre>
<p>The packages directory can be set after the construction of the object with
the method <code>setPackagesDir</code>...</p>
<pre><code class="language-php " >$directory = __DIR__ . &#039;/Webisters&#039;;
$preloader-&gt;setPackagesDir($directory); // static
</code></pre>
</div>
<div class="section" id="with-packages">
<h4>With Packages</h4>
<p>If the construction is carried out without the packages directory, it will be
necessary to define that the packages must be loaded with the `withPackages`` method:</p>
<pre><code class="language-php " >$preloader-&gt;setPackagesDir($directory)-&gt;withPackages()-&gt;load();
</code></pre>
</div>
<div class="section" id="with-dev-packages">
<h4>With Dev Packages</h4>
<p>To load development packages, such as <strong>Coding Standard</strong> and <strong>Testing</strong>,
use the <code>withDevPackages</code> method:</p>
<pre><code class="language-php " >$preloader-&gt;withDevPackages()-&gt;load();
</code></pre>
</div>
</div>
</div>
<div class="section" id="preload-files">
<h3>Preload Files</h3>
<p>Preloader can list only framework files to load or list all files.</p>
<div class="section" id="list-packages-files">
<h4>List Packages Files</h4>
<p>To list only Webisters package files, use the <code>listPackagesFiles</code> method:</p>
<pre><code class="language-php " >$files = $preloader-&gt;listPackagesFiles(); // array of strings
</code></pre>
</div>
<div class="section" id="list-files">
<h4>List Files</h4>
<p>To list all the files that will be loaded, use the <code>listFiles</code> method:</p>
<pre><code class="language-php " >$files = $preloader-&gt;listFiles(); // array of strings
</code></pre>
</div>
</div>
<div class="section" id="load">
<h3>Load</h3>
<p>To load files into OPCache Preloading, just call the <code>load</code> method.</p>
<pre><code class="language-php " >$files = $preloader-&gt;load(); // array of strings
</code></pre>
<p>It will load all files from <a href="#list-files">List Files</a> into memory.</p>
</div>
<div class="section" id="declarations">
<h3>Declarations</h3>
<p>Through Preloader it is possible to obtain which classes, interfaces and traits
are declared.</p>
<div class="section" id="get-all-declarations">
<h4>Get All Declarations</h4>
<p>To get all declarations, use <code>getAllDeclaration</code>:</p>
<pre><code class="language-php " >$allDeclarations = $preloader::getAllDeclarations(); // array of strings
</code></pre>
</div>
<div class="section" id="get-declarations">
<h4>Get Declarations</h4>
<p>To get only Webisters declarations, use the method
``getDeclarations`:</p>
<pre><code class="language-php " >$declarations = $preloader::getDeclarations(); // array of strings
</code></pre>
</div>
</div>
<div class="section" id="conclusion">
<h2>Conclusion</h2>
<p>Webisters Autoload Library is an easy-to-use tool for, beginners and experienced, PHP developers.<br>It is perfect for autoload, locate files and optimize performance with preload.<br>The more you use it, the more you will learn.</p>
<div class="phpdocumentor-admonition -note ">
            <svg class="phpdocumentor-admonition__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path></svg>
                    <article>
        <p>Did you find something wrong?<br>Be sure to let us know about it with an
<a href="https://github.com/webisters/autoload/issues">issue</a>.<br>Thank you!</p>
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
