<?php
$pageTitle = 'One Project · Webisters Docs';
require_once __DIR__ . '/../../../includes/header.php';
require_once __DIR__ . '/../../../includes/sidebar.php';
?>
<div class="section" id="one">
<h1>One Project</h1>
<p>The <strong>One</strong> template is Webisters' single-file project. Every endpoint lives in one PHP file &mdash; perfect for quick APIs, prototypes, internal tools, or anything you want to deploy in under a minute. Same libraries as the App and API templates, none of the directory ceremony.</p>
<ul>
    <li><a href="#when-to-use-one">When to use One</a></li>
    <li><a href="#installation">Installation</a></li>
    <li><a href="#project-layout">Project layout</a></li>
    <li><a href="#defining-endpoints">Defining endpoints</a></li>
    <li><a href="#running-the-app">Running the app</a></li>
    <li><a href="#growing-out-of-one">Growing out of One</a></li>
    <li><a href="#conclusion">Conclusion</a></li>
</ul>

<div class="section" id="when-to-use-one">
<h2>When to use One</h2>
<ul>
    <li>A throwaway internal tool with three endpoints.</li>
    <li>A webhook receiver that just needs to validate a signature and forward.</li>
    <li>A prototype where you want to iterate on logic without thinking about file structure.</li>
    <li>A small JSON API exposed to a single client.</li>
</ul>
<p>When the file grows past a few hundred lines or you need fixtures, migrations, and views, move to the <a href="../app/index.php">App</a> or <a href="../api/index.php">API</a> template.</p>
</div>

<div class="section" id="installation">
<h2>Installation</h2>
<p>Create a project with Composer:</p>
<pre><code class="language-bash">composer create-project webisters/one my-app
cd my-app</code></pre>
<p>Or via the Webisters CLI:</p>
<pre><code class="language-bash">webisters new-one my-app
cd my-app
composer install</code></pre>
</div>

<div class="section" id="project-layout">
<h2>Project layout</h2>
<pre><code class="language- ">my-app/
├── composer.json
├── preload.php
├── public/
│   └── index.php        &lt;-- everything lives here
└── storage/</code></pre>
<p>That's it. <code>public/index.php</code> is your entire application.</p>
</div>

<div class="section" id="defining-endpoints">
<h2>Defining endpoints</h2>
<p>Open <code>public/index.php</code> and register handlers directly:</p>
<pre><code class="language-php">&lt;?php
require __DIR__ . '/../vendor/autoload.php';

use Framework\Routing\Router;
use Framework\HTTP\Response;

$router = new Router();

$router-&gt;get('/', fn () =&gt; new Response()-&gt;setBody('Hello, world!'));

$router-&gt;get('/users/{id:int}', function (int $id) {
    return new Response()-&gt;setJSON([
        'id'   =&gt; $id,
        'name' =&gt; 'User ' . $id,
    ]);
});

$router-&gt;post('/contact', function () {
    $data = json_decode(file_get_contents('php://input'), true) ?? [];
    // ... validate, send email, log, etc.
    return new Response()-&gt;setStatus(201);
});

$router-&gt;match($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI'])-&gt;run();</code></pre>
</div>

<div class="section" id="running-the-app">
<h2>Running the app</h2>
<p>Use PHP's built-in server for local development:</p>
<pre><code class="language-bash">php -S localhost:8000 -t public</code></pre>
<p>For production, point your web server (nginx, Caddy, Apache) at the <code>public/</code> directory.</p>
</div>

<div class="section" id="growing-out-of-one">
<h2>Growing out of One</h2>
<p>When you start splitting your handlers into classes or adding views, migrations, and seeders, scaffold an <a href="../app/index.php">App</a> project alongside and copy your routes across. Both templates share the same library set, so the move is mostly cut-and-paste plus a routes file.</p>
</div>

<div class="section" id="conclusion">
<h2>Conclusion</h2>
<p>One is the fastest path from idea to running PHP service. Don't be afraid to start here &mdash; you can always graduate to a richer template when the constraints start hurting.</p>
<div class="phpdocumentor-admonition -note">
    <svg class="phpdocumentor-admonition__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/></svg>
    <article><p>Did you find something wrong? Be sure to let us know with an <a href="https://github.com/webisters/one/issues">issue</a>. Thank you!</p></article>
</div>
</div>
</div>
<?php
require_once __DIR__ . '/../../../includes/footer.php';
?>
