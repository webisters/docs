<?php
$pageTitle = 'Routing · Webisters Docs';
require_once __DIR__ . '/../../../includes/header.php';
require_once __DIR__ . '/../../../includes/sidebar.php';
?>
<div class="section" id="routing">
<h1>Routing</h1>
<p>Webisters Routing maps incoming HTTP requests to handlers &mdash; closures, controller methods, or resources &mdash; with a fluent, expressive API. It supports named routes, route groups, prefixes, attribute-based routing, and CLI route inspection.</p>
<ul>
    <li><a href="#installation">Installation</a></li>
    <li><a href="#getting-started">Getting Started</a></li>
    <li><a href="#defining-routes">Defining Routes</a></li>
    <li><a href="#named-routes">Named Routes</a></li>
    <li><a href="#route-groups">Route Groups</a></li>
    <li><a href="#route-parameters">Route Parameters</a></li>
    <li><a href="#resources">Resources</a></li>
    <li><a href="#conclusion">Conclusion</a></li>
</ul>

<div class="section" id="installation">
<h2>Installation</h2>
<p>Install via Composer:</p>
<pre><code class="language-bash">composer require webisters/routing</code></pre>
</div>

<div class="section" id="getting-started">
<h2>Getting Started</h2>
<p>Create a <code>Router</code> instance and start registering routes:</p>
<pre><code class="language-php">use Framework\Routing\Router;
use Framework\HTTP\Response;

$router = new Router();

$router-&gt;get('/', function () {
    return new Response()-&gt;setBody('Hello, Webisters!');
});

$router-&gt;match($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI'])-&gt;run();</code></pre>
</div>

<div class="section" id="defining-routes">
<h2>Defining Routes</h2>
<p>The router exposes a method for every HTTP verb:</p>
<pre><code class="language-php">$router-&gt;get('/users',          [UsersController::class, 'index']);
$router-&gt;post('/users',         [UsersController::class, 'store']);
$router-&gt;put('/users/{id}',     [UsersController::class, 'update']);
$router-&gt;patch('/users/{id}',   [UsersController::class, 'partial']);
$router-&gt;delete('/users/{id}',  [UsersController::class, 'destroy']);</code></pre>
<p>Use <code>any()</code> to match every method, or pass an explicit array of verbs:</p>
<pre><code class="language-php">$router-&gt;any('/webhook', WebhookController::class);
$router-&gt;match(['GET', 'POST'], '/search', SearchController::class);</code></pre>
</div>

<div class="section" id="named-routes">
<h2>Named Routes</h2>
<p>Naming a route lets you generate URLs without hard-coding paths:</p>
<pre><code class="language-php">$router-&gt;get('/users/{id}', [UsersController::class, 'show'])
       -&gt;setName('users.show');

// Generate the URL anywhere:
echo $router-&gt;getNamedRoute('users.show')-&gt;getURL(['id' =&gt; 42]);
// =&gt; /users/42</code></pre>
</div>

<div class="section" id="route-groups">
<h2>Route Groups</h2>
<p>Group routes that share a prefix:</p>
<pre><code class="language-php">$router-&gt;group('/admin', function (Router $router) {
    $router-&gt;get('/dashboard', [AdminController::class, 'dashboard']);
    $router-&gt;get('/users',     [AdminController::class, 'users']);
});

// =&gt; /admin/dashboard and /admin/users</code></pre>
</div>

<div class="section" id="route-parameters">
<h2>Route Parameters</h2>
<p>Use placeholders in the path. Parameters are passed as arguments to the handler:</p>
<pre><code class="language-php">$router-&gt;get('/posts/{slug}/comments/{id}', function (string $slug, int $id) {
    return new Response()-&gt;setBody("post: {$slug}, comment: {$id}");
});</code></pre>
<p>Constrain parameter formats with patterns:</p>
<pre><code class="language-php">$router-&gt;get('/posts/{id:int}',       $handler);  // numeric only
$router-&gt;get('/users/{name:string}',  $handler);  // word characters
$router-&gt;get('/{any:.*}',             $handler);  // catch-all</code></pre>
</div>

<div class="section" id="resources">
<h2>Resources</h2>
<p>Bind a <code>ResourceInterface</code> class to register a full set of REST routes at once:</p>
<pre><code class="language-php">$router-&gt;resource('/posts', PostsResource::class);

// Generates:
//   GET    /posts          -&gt; index
//   POST   /posts          -&gt; store
//   GET    /posts/{id}     -&gt; show
//   PUT    /posts/{id}     -&gt; update
//   PATCH  /posts/{id}     -&gt; partial
//   DELETE /posts/{id}     -&gt; destroy</code></pre>
</div>

<div class="section" id="conclusion">
<h2>Conclusion</h2>
<p>Routing is the front door of every Webisters HTTP app. Pair it with the <a href="../mvc/index.php">MVC</a> library to get controllers, dependency injection, and the request/response lifecycle wired up automatically.</p>
<div class="phpdocumentor-admonition -note">
    <svg class="phpdocumentor-admonition__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/></svg>
    <article><p>Did you find something wrong? Be sure to let us know with an <a href="https://github.com/webisters/routing/issues">issue</a>. Thank you!</p></article>
</div>
</div>
</div>
<?php
require_once __DIR__ . '/../../../includes/footer.php';
?>
