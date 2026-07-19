<?php
$pageTitle = 'Webisters Docs';
require_once __DIR__ . '/../../includes/header.php';
require_once __DIR__ . '/../../includes/sidebar.php';
?>
<div class="section" id="framework">
    <h1>Framework</h1>
    <p>A modern, lightweight full-stack PHP framework with batteries-included libraries and project templates.</p>
    <ul>
        <li>
            <a href="#installation">Installation</a>
        </li>
        <li>
            <a href="#about">About</a>
        </li>
        <li>
            <a href="#autoloading-and-preloading">Autoloading and Preloading</a>
        </li>
        <li>
            <a href="#conclusion">Conclusion</a>
        </li>
    </ul>
    <div class="section" id="installation">
        <h2>Installation</h2>
        <p>The installation of this package can be done with Composer:</p>
        <pre><code class="language- " >composer require Webisters/framework
</code></pre>
    </div>
    <div class="section" id="about">
        <h2>About</h2>
        <p>This package is responsible for installing other Webisters libraries.</p>
        <p>It has the <strong>Webisters</strong> class, through which it is possible to get information
            about the current version of the installed framework:</p>
        <pre><code class="language-php " >echo Webisters::VERSION;
</code></pre>
        <p>With this package it is possible to create applications according to the need of
            the developer.</p>
        <p>As examples, you can analyze the <a href="../projects/app/index.php">App</a>
            and <a href="../projects/one/index.php">One</a>
            projects, which create structures using the <a href="../libraries/mvc/index.php">MVC</a>
            library.</p>
    </div>
    <div class="section" id="autoloading-and-preloading">
        <h2>Autoloading and Preloading</h2>
        <p>The <strong>framework</strong> package contains a file that loads and returns the autoloader
            with the paths to the defined namespaces, and also a file to preload all the
            framework classes.</p>
        <p>Let&#039;s say you want to work with the framework classes defined in just one place
            in such a way that you can update them all at once.</p>
        <p>We assume that the installation is performed via Composer in a directory called
            <code>composer</code> in your user&#039;s home directory.
        </p>
        <p>Create the directory:</p>
        <pre><code class="language- " >mkdir composer
</code></pre>
        <p>Enter the directory:</p>
        <pre><code class="language- " >cd composer
</code></pre>
        <p>Use Composer to install the framework files:</p>
        <pre><code class="language- " >composer require Webisters/framework
</code></pre>
        <p>Create a symlink to share the files with all users on the system:</p>
        <pre><code class="language- " >sudo ln -s ~/composer/vendor/Webisters /usr/share
</code></pre>
        <p>With this, you can autoload files from anywhere or preload them, as we&#039;ll see next.</p>
        <div class="section" id="autoloading">
            <h3>Autoloading</h3>
            <p><a href="https://www.php.net/manual/en/language.oop5.autoload.php">Autoload</a> lets you
                load classes automatically.</p>
            <p>To load the framework classes automatically, put this line at the top of your
                input file (front controller):</p>
            <pre><code class="language-php " >require &#039;/usr/share/Webisters/framework/autoload.php&#039;;
</code></pre>
            <p>If you want to use the Autoloader instance loaded, pass the <code>require</code> result
                to a variable:</p>
            <pre><code class="language-php " >$autoloader = require &#039;/usr/share/Webisters/framework/autoload.php&#039;;
</code></pre>
            <p>If using the <a href="../libraries/mvc/index.php">MVC</a>
                library, you can also define this Autoloader instance as a service:</p>
            <pre><code class="language-php " >use Framework\MVC\App;
App::setService(&#039;autoloader&#039;, $autoloader);
</code></pre>
            <div class="section" id="example-with-autoloading">
                <h4>Example with Autoloading</h4>
                <p>Let&#039;s see an example autoloading in the <code>index.php</code> file:</p>
                <pre><code class="language-php " >&lt;?php
use Framework\MVC\App;
$autoloader = require &#039;/usr/share/Webisters/framework/autoload.php&#039;;
$autoloader-&gt;setNamespace(&#039;App&#039;, __DIR__ . &#039;/app&#039;);
App::setService(&#039;autoloader&#039;, $autoloader);
(new App())-&gt;run();
</code></pre>
                <p>The Autoloader instance was reused, setting the directory to the <code>App</code> namespace
                    and also set as a service in the MVC
                    <a href="../libraries/mvc/index.php#app">App</a> class.
                </p>
            </div>
        </div>
        <div class="section" id="preloading">
            <h3>Preloading</h3>
            <p><a href="https://www.php.net/manual/en/opcache.preloading.php">Preloading</a> allows
                loading classes to be available on every request as if they were part of the
                PHP core.</p>
            <p>It makes requests faster and saves memory!</p>
            <p>Below we will see how to configure PHP to preload the Framework classes.</p>
            <div class="section" id="php-fpm">
                <h4>PHP-FPM</h4>
                <p>In production, it is very common to use <strong>FastCGI Process Manager</strong>.</p>
                <p>The <code>php.ini</code> file of <a href="https://www.php.net/manual/en/book.fpm.php">PHP-FPM</a>
                    on Debian-based distributions is located at <code>/etc/php/8.1/fpm/php.ini</code>.</p>
                <p>To enable preloading enter the path of the preload file and the username,
                    which is normally <code>www-data</code>:</p>
                <pre><code class="language-ini " >opcache.preload=/usr/share/Webisters/framework/preload.php
opcache.preload_user=www-data
</code></pre>
                <p>Then restart the PHP-FPM service:</p>
                <pre><code class="language- " >sudo systemctl restart php8.1-fpm.service
</code></pre>
                <p>And that&#039;s it! Loaded classes. We can use them directly as if they were part of
                    the PHP core!</p>
            </div>
            <div class="section" id="php-server">
                <h4>PHP Server</h4>
                <p>In development, you can use
                    <a href="https://github.com/natanfelles/php-server">this package</a>, creating a file
                    called <code>php-server.ini</code> and insert the path to the preload file in the
                    <code>ini</code> section:
                </p>
                <pre><code class="language-ini " >[ini]
opcache.preload=/usr/share/Webisters/framework/preload.php
</code></pre>
                <p>And then up the PHP server:</p>
                <pre><code class="language- " >php-server
</code></pre>
            </div>
            <div class="section" id="example-with-preloading">
                <h4>Example with Preloading</h4>
                <p>With the Framework preloaded, use the classes directly, without needing to
                    autoload or <code>include</code>. Because they are already in memory!</p>
                <p>Let&#039;s look at a basic file for responding to HTTP requests:</p>
                <pre><code class="language-php " >&lt;?php
use Framework\MVC\App;
(new App())-&gt;runHttp();
</code></pre>
                <p>And that&#039;s it!</p>
            </div>
        </div>
        <div class="section" id="conclusion">
            <h2>Conclusion</h2>
            <p>Webisters is an easy-to-use tool for, beginners and experienced, PHP developers.<br>It is perfect for
                creating high-performance applications of any size.<br>The more you use it, the more you will learn.</p>
            <div class="phpdocumentor-admonition -note ">
                <svg class="phpdocumentor-admonition__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z">
                    </path>
                </svg>
                <article>
                    <p>Did you find something wrong?<br>Be sure to let us know about it with an
                        <a href="https://github.com/webisters/framework/issues">issue</a>.<br>Thank you!
                    </p>
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
    require_once __DIR__ . '/../../includes/footer.php';
    ?>
      