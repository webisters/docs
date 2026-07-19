<?php
$pageTitle = 'Webisters Docs';
require_once __DIR__ . '/../../../includes/header.php';
require_once __DIR__ . '/../../../includes/sidebar.php';
?>
<div class="section" id="app">
<h1>App</h1>
<p>Webisters App Project.</p>
<ul>
    <li>
            <a href="#installation">Installation</a>
        </li>
    <li>
            <a href="#structure">Structure</a>
        </li>
    <li>
            <a href="https://getbootstrap.com/">Bootstrap</a>
        </li>
    <li>
            <a href="#configuration">Configuration</a>
        </li>
    <li>
            <a href="#storage">Storage</a>
        </li>
    <li>
            <a href="#the-global-class-app">The global class App</a>
        </li>
    <li>
            <a href="#the-app-namespace">The App namespace</a>
        </li>
    <li>
            <a href="#running-an-Webisters-app">Running an Webisters App</a>
        </li>
    <li>
            <a href="#testing">Testing</a>
        </li>
    <li>
            <a href="#deployment">Deployment</a>
        </li>
    <li>
            <a href="#conclusion">Conclusion</a>
        </li>
</ul>
<div class="section" id="installation">
<h2>Installation</h2>
<p>The installation of this project can be done with Composer:</p>
<pre><code class="language- " >composer create-project webisters/app app</code></pre>
<p>Or, using the Webisters CLI:</p>
<pre><code class="language- " >composer global require webisters/webisters
composer global exec webisters setup
webisters new-app app
# If `webisters` is not on PATH yet:
# composer global exec webisters new-app app
cd app
composer install</code></pre>
</div>
<div class="section" id="structure">
<h2>Structure</h2>
<p>The App has a standard structure to organize business logic.</p>
<p>And remember, it&#039;s highly customizable. You can adapt it as you like.</p>
<p>This is the basic directory tree:</p>
<pre><code class="language- " >.
├── .editorconfig
├── .env.php
├── .gitignore
├── .htaccess
├── .php-cs-fixer.dist.php
├── App.php
├── app/
│   ├── Commands/
│   ├── Controllers/
│   ├── Languages/
│   ├── Models/
│   └── Views/
├── bin/
│   └── console
├── boot/
│   ├── app.php
│   ├── constants.php
│   ├── helpers.php
│   ├── init.php
│   └── routes.php
├── composer.json
├── composer.local.json
├── config/
├── phpdoc.dist.xml
├── phpunit.xml.dist
├── preload.php
├── public/
│   └── index.php
├── README.md
├── SECURITY.md
├── storage/
├── tests/
├── vendor/
└── webisters
</code></pre>
</div>
<div class="section" id="bootstrap">
<h2>Bootstrap</h2>
<p>Inside the <strong>boot</strong> directory are located files that are part of the application
startup.</p>
<div class="section" id="app">
<h3>App</h3>
<p>The <strong>app.php</strong> file is responsible for loading the files needed for the app to work.
Such as the Composer autoloader or the initialization files.</p>
<p>It returns an instance of the <code>App</code> class, which is called to run the application
in HTTP or CLI.</p>
</div>
<div class="section" id="init">
<h3>Init</h3>
<p>The <strong>init.php</strong> file is responsible for setting the environment variables
that are defined in the <strong>.env.php</strong> file.</p>
<p>Also, initial settings are performed, such as setting
<a href="https://www.php.net/manual/en/function.error-reporting.php">error_reporting</a>
and <a href="https://www.php.net/manual/en/errorfunc.configuration.php#ini.display-errors">display_errors</a>.</p>
</div>
<div class="section" id="constants">
<h3>Constants</h3>
<p>In the <strong>constants.php</strong> file, the constants that will be available throughout
the application are set, such as the <strong>ENVIRONMENT</strong> and the paths to the
different directories.</p>
</div>
<div class="section" id="helpers">
<h3>Helpers</h3>
<p>The <strong>helpers.php</strong> file contains common functions that will always be available
in the application.</p>
</div>
<div class="section" id="routes">
<h3>Routes</h3>
<p>In the <strong>routes.php</strong> file, the application routes are served.</p>
</div>
</div>
<div class="section" id="configuration">
<h2>Configuration</h2>
<p>Webisters App is organized in such a way that its configuration files are all in the
same directory.</p>
<p>By default, the directory is called <strong>config</strong>. Located in the application&#039;s root
directory.</p>
<p>Configuration files serve to pre-establish values used by services
or routines needed for <a href="#helpers">helpers</a> and <a href="https://docs.webisters.com/guides/libraries/index.php">libraries</a>.</p>
<p>For more details see the <a href="../../libraries/config/index.php">Config</a>
and <a href="../../libraries/mvc/index.php">MVC</a>
libraries documentation.</p>
</div>
<div class="section" id="storage">
<h2>Storage</h2>
<p>In the <strong>storage</strong> directory, different types of files are stored in
subdirectories:</p>
<div class="section" id="cache">
<h3>Cache</h3>
<p>Cache files are stored in the <strong>cache</strong> directory.</p>
</div>
<div class="section" id="logs">
<h3>Logs</h3>
<p>Log files are stored in the <strong>logs</strong> directory.</p>
</div>
<div class="section" id="sessions">
<h3>Sessions</h3>
<p>Session files are stored in the <strong>sessions</strong> directory.</p>
</div>
<div class="section" id="uploads">
<h3>Uploads</h3>
<p>Upload files are stored in the <strong>uploads</strong> directory.</p>
</div>
</div>
<div class="section" id="the-global-class-app">
<h2>The global class App</h2>
<p>The global class <code>App</code>, whose file is located in the root directory, extends
the <code>Framework\MVC\App</code> class.</p>
<p>Through it, it is possible to customize features and
<a href="../../libraries/mvc/index.php#services">services</a>.</p>
</div>
<div class="section" id="the-app-namespace">
<h2>The App namespace</h2>
<p>Inside the <strong>app</strong> directory is registered the <code>App</code> namespace.</p>
<p>By default, some files are already inside it:</p>
<div class="section" id="commands">
<h3>Commands</h3>
<p>In the <strong>Commands</strong> directory is the <code>App\Commands</code> namespace.</p>
<p>In it, you can add commands that will be available in the console.</p>
</div>
<div class="section" id="controllers">
<h3>Controllers</h3>
<p>In the <strong>Controllers</strong> directory is the <code>App\Controllers</code> namespace.</p>
<p>In it, you can add controllers with methods that will act as routes.</p>
</div>
<div class="section" id="languages">
<h3>Languages</h3>
<p>In the subdirectories of <strong>Languages</strong> are stored application language files.</p>
</div>
<div class="section" id="models">
<h3>Models</h3>
<p>In the <strong>Models</strong> directory is the <code>App\Models</code> namespace.</p>
<p>In it it is possible to add models that represent tables of the application&#039;s
database schema.</p>
</div>
<div class="section" id="views">
<h3>Views</h3>
<p>In the <strong>Views</strong> directory are stored application view files.</p>
</div>
</div>
<div class="section" id="running-an-Webisters-app">
<h2>Running an Webisters App</h2>
<p>The Webisters App project is designed to run on HTTP and CLI.</p>
<div class="section" id="run-http">
<h3>Run HTTP</h3>
<p>Inside the <strong>public</strong> directory is the front-controller <strong>index.php</strong>.</p>
<p>The <strong>public</strong> directory must be the document root configured on the server.</p>
<p>Note that the directory name may vary by server. In some it may be called
<strong>publichtml</strong> and in others <strong>web</strong>, etc.</p>
<p>In development, you can use PHP server running <code>vendor/bin/php-server</code> or
Docker Compose.</p>
</div>
<div class="section" id="run-cli">
<h3>Run CLI</h3>
<p>Inside the <strong>bin</strong> directory is the <strong>console</strong> file.</p>
<p>Through it it is possible to run the various commands of the application,
running <code>./bin/console</code>.</p>
</div>
</div>
<div class="section" id="testing">
<h2>Testing</h2>
<p>Unit tests can be created within the <strong>tests</strong> directory. See the tests that
come inside it as an example.</p>
</div>
<div class="section" id="deployment">
<h2>Deployment</h2>
<p>We will see how to deploy to a <a href="#shared-hosting">Shared Hosting</a> and a <a href="#private-server">Private Server</a>:</p>
<p>In the following examples, configurations will be made for the domain <strong>domain.tld</strong>.
Replace it with the domain of your application.</p>
<div class="section" id="shared-hosting">
<h3>Shared Hosting</h3>
<p>In shared hosting, it is common that you can upload the project files only by FTP.</p>
<p>Also, typically the document root is a publicly accessible directory called
<strong>www</strong>, <strong>web</strong> or <strong>publichtml</strong>.</p>
<p>And the server is Apache, which allows configurations through files called
<strong>.htaccess</strong>.</p>
<p>In the following example the settings can be made locally and then sent to the
hosting server.</p>
<div class="section" id="environment-variables">
<h4>Environment Variables</h4>
<p>Environment variables are defined in the <strong>.env.php</strong> file.</p>
<p>Edit them according to the examples below:</p>
<div class="section" id="environment">
<h5>ENVIRONMENT</h5>
<p>Make sure ENVIRONMENT is set to <code>production</code>:</p>
<pre><code class="language-php " >$_ENV[&#039;ENVIRONMENT&#039;] = &#039;production&#039;;
</code></pre>
</div>
<div class="section" id="url-origin">
<h5>URL Origin</h5>
<p>Make sure that the URL Origin has the correct domain:</p>
<pre><code class="language-php " >$_ENV[&#039;app.default.origin&#039;] = &#039;http://domain.tld&#039;;
</code></pre>
</div>
</div>
</div>
<div class="section" id="install-dependencies">
<h4>Install Dependencies</h4>
<p>Install dependencies with Composer:</p>
<pre><code class="language- " >composer install --no-dev
</code></pre>
</div>
<div class="section" id="htaccess-files">
<h4>.htaccess files</h4>
<p>In the document root and in the <strong>public</strong> directory of the application has
<strong>.htaccess</strong> files that can be configured as needed.</p>
<p>For example, redirecting insecure requests to <strong>HTTPS</strong> or redirecting to the
<strong>www</strong> subdomain.</p>
</div>
<div class="section" id="finishing">
<h4>Finishing</h4>
<p>Upload the files to the public directory of your hosting.</p>
<p>Access the domain through the browser: <a href="http://domain.tld/">http://domain.tld</a></p>
<p>It should open the home page of your project.</p>
</div>
</div>
<div class="section" id="private-server">
<h3>Private Server</h3>
<p>We will be using Ubuntu 24.04 LTS which is supported until 2029 and already
comes with PHP 8.3.</p>
<p>Replace <code>domain.tld</code> with your domain.</p>
<p>Installing PHP and required packages:</p>
<pre><code class="language- " >sudo apt-get -y install \
composer \
curl \
git \
php8.3-apcu \
php8.3-cli \
php8.3-curl \
php8.3-fpm \
php8.3-gd \
php8.3-igbinary \
php8.3-intl \
php8.3-mbstring \
php8.3-memcached \
php8.3-msgpack \
php8.3-mysql \
php8.3-opcache \
php8.3-readline \
php8.3-redis \
php8.3-xml \
php8.3-yaml \
php8.3-zip \
unzip
</code></pre>
<p>Make the application directory:</p>
<pre><code class="language- " >sudo mkdir -p /var/www/domain.tld
</code></pre>
<p>Set directory ownership. Replace &quot;username&quot; with your username:</p>
<pre><code class="language- " >sudo chown username:username /var/www/domain.tld
</code></pre>
<p>Enter the application directory...</p>
<pre><code class="language- " >cd /var/www/domain.tld
</code></pre>
<p>... and clone or download your project.</p>
<p>As an example, we&#039;ll install a new app:</p>
<pre><code class="language- " >git clone https://github.com/webisters/app.git .
</code></pre>
<p>Set the owner of the storage directory:</p>
<pre><code class="language- " >sudo chown -R www-data:www-data storage
</code></pre>
<p>Edit the Environment and the URL Origin of your project in the <strong>.env.php</strong>
file:</p>
<pre><code class="language-php " >$_ENV[&#039;ENVIRONMENT&#039;] = &#039;production&#039;;
$_ENV[&#039;app.default.origin&#039;] = &#039;http://domain.tld&#039;;
</code></pre>
<p>Install the necessary PHP packages through Composer:</p>
<pre><code class="language- " >composer install --no-dev --ignore-platform-req=ext-xdebug
</code></pre>
<ul>
    <li>
            We use <code>install</code> instead of <code>update</code> to respect the <strong>composer.lock</strong> file if it exists in your repository.
        </li>
    <li>
            We use <code>--ignore-platform-req=ext-xdebug</code> because we don&#039;t need the xdebug extension in production.
        </li>
</ul>
<div class="section" id="web-servers">
<h4>Web Servers</h4>
<p>In these examples, we will see how to install and configure two web servers:</p>
<ul>
    <li>
            <a href="#apache">Apache</a>
        </li>
    <li>
            <a href="#nginx-recommended">Nginx (recommended)</a>
        </li>
</ul>
<div class="section" id="apache">
<h5>Apache</h5>
<p>Install required packages:</p>
<pre><code class="language- " >sudo apt install apache2 libapache2-mod-php
</code></pre>
<p>Enable modules:</p>
<pre><code class="language- " >sudo a2enmod rewrite
</code></pre>
<p>Create the file <strong>/etc/apache2/sites-available/domain.tld.conf</strong>:</p>
<pre><code class="language-apacheconf " >&lt;Directory /var/www/domain.tld/public&gt;
    Options Indexes FollowSymLinks
    AllowOverride All
    Require all granted
&lt;/Directory&gt;
&lt;VirtualHost *:80&gt;
    ServerName domain.tld
    SetEnv ENVIRONMENT production
    DocumentRoot /var/www/domain.tld/public
&lt;/VirtualHost&gt;
</code></pre>
<p>Enable the site:</p>
<pre><code class="language- " >sudo a2ensite domain.tld
</code></pre>
<p>Reload the server:</p>
<pre><code class="language- " >sudo systemctl reload apache2
</code></pre>
<p>Access the domain through the browser: <a href="http://domain.tld/">http://domain.tld</a></p>
<p>It should open the home page of your project.</p>
</div>
<div class="section" id="nginx-recommended">
<h5>Nginx (recommended)</h5>
<p>Edit the <strong>php.ini</strong> file:</p>
<pre><code class="language- " >sudo sed -i &#039;s/;cgi.fix_pathinfo=1/cgi.fix_pathinfo=0/g&#039; /etc/php/8.3/fpm/php.ini
</code></pre>
<p>Restart PHP-FPM:</p>
<pre><code class="language- " >sudo systemctl restart php8.3-fpm
</code></pre>
<p>Install required packages:</p>
<pre><code class="language- " >sudo apt install nginx
</code></pre>
<p>Create the file <strong>/etc/nginx/sites-available/domain.tld.conf</strong>:</p>
<pre><code class="language-nginx " >server {
    listen 80;
    root /var/www/domain.tld/public;
    index index.php;
    server_name domain.tld;
    location / {
        try_files $uri $uri/ /index.php?$args;
    }
    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_param ENVIRONMENT production;
        fastcgi_pass unix:/var/run/php/php8.3-fpm.sock;
    }
    location ~ /\. {
        deny all;
    }
}
</code></pre>
<p>Enable the site:</p>
<pre><code class="language- " >sudo ln -s /etc/nginx/sites-available/domain.tld.conf /etc/nginx/sites-enabled/
</code></pre>
<p>Test Nginx configurations:</p>
<pre><code class="language- " >sudo nginx -t
</code></pre>
<p>Restart Nginx:</p>
<pre><code class="language- " >sudo systemctl restart nginx
</code></pre>
<p>Access the domain through the browser: <a href="http://domain.tld/">http://domain.tld</a></p>
<p>It should open the home page of your project.</p>
</div>
</div>
<div class="section" id="conclusion">
<h2>Conclusion</h2>
<p>Webisters App Project is an easy-to-use tool for, beginners and experienced, PHP developers.<br>It is perfect for building powerful, high-performance applications.<br>The more you use it, the more you will learn.</p>
<div class="phpdocumentor-admonition -note ">
            <svg class="phpdocumentor-admonition__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path></svg>
                    <article>
        <p>Did you find something wrong?<br>Be sure to let us know about it with an
<a href="https://github.com/webisters/app/issues">issue</a>.<br>Thank you!</p>
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
