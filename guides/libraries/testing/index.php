<?php
$pageTitle = 'Testing · Webisters Docs';
require_once __DIR__ . '/../../../includes/header.php';
require_once __DIR__ . '/../../../includes/sidebar.php';
?>
<div class="section" id="testing">
<h1>Testing</h1>
<p>Webisters Testing extends PHPUnit with base classes and HTTP/CLI assertions tuned for Webisters apps. You get a real <code>App</code> instance per test, painless request simulation, and expressive matchers for status codes, headers, and response bodies.</p>
<ul>
    <li><a href="#installation">Installation</a></li>
    <li><a href="#writing-a-test">Writing a test</a></li>
    <li><a href="#http-assertions">HTTP assertions</a></li>
    <li><a href="#cli-assertions">CLI assertions</a></li>
    <li><a href="#running-tests">Running tests</a></li>
    <li><a href="#conclusion">Conclusion</a></li>
</ul>

<div class="section" id="installation">
<h2>Installation</h2>
<pre><code class="language-bash">composer require --dev webisters/testing</code></pre>
<p>This pulls in PHPUnit as a transitive dependency.</p>
</div>

<div class="section" id="writing-a-test">
<h2>Writing a test</h2>
<p>Extend <code>TestCase</code> and use the <code>AppTesting</code> trait to boot a fresh app inside each test:</p>
<pre><code class="language-php">use Framework\Testing\TestCase;
use Framework\Testing\AppTesting;

final class HomePageTest extends TestCase
{
    use AppTesting;

    public function testHomepageReturnsWelcome(): void
    {
        $response = $this-&gt;get('/');

        $this-&gt;assertResponseStatus(200, $response);
        $this-&gt;assertResponseBodyContains('Welcome', $response);
    }
}</code></pre>
</div>

<div class="section" id="http-assertions">
<h2>HTTP assertions</h2>
<p>The library ships PHPUnit constraints for everything you typically check on a response:</p>
<pre><code class="language-php">$this-&gt;assertResponseStatus(201, $response);
$this-&gt;assertResponseStatusCode(204, $response);
$this-&gt;assertResponseStatusReason('OK', $response);
$this-&gt;assertResponseContainsHeader('Content-Type', $response);
$this-&gt;assertResponseHeader('Content-Type', 'application/json', $response);
$this-&gt;assertResponseBodyContains('{"id":42}', $response);
$this-&gt;assertResponseBodyNotContains('error', $response);
$this-&gt;assertMatchedRouteName('users.show', $router);</code></pre>
</div>

<div class="section" id="cli-assertions">
<h2>CLI assertions</h2>
<p>Constraints for testing console commands &mdash; check what landed on stdout/stderr:</p>
<pre><code class="language-php">$this-&gt;assertStdoutContains('Migration applied', $command);
$this-&gt;assertStdoutNotContains('error', $command);
$this-&gt;assertStderrContains('warning', $command);
$this-&gt;assertStderrNotContains('fatal', $command);</code></pre>
</div>

<div class="section" id="running-tests">
<h2>Running tests</h2>
<p>Use PHPUnit directly:</p>
<pre><code class="language-bash">vendor/bin/phpunit
vendor/bin/phpunit tests/Feature
vendor/bin/phpunit --filter testHomepageReturnsWelcome</code></pre>
</div>

<div class="section" id="conclusion">
<h2>Conclusion</h2>
<p>Treat your tests like a second client of the framework &mdash; the more you write, the more confidence you have to refactor freely.</p>
<div class="phpdocumentor-admonition -note">
    <svg class="phpdocumentor-admonition__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/></svg>
    <article><p>Did you find something wrong? Be sure to let us know with an <a href="https://github.com/webisters/testing/issues">issue</a>. Thank you!</p></article>
</div>
</div>
</div>
<?php
require_once __DIR__ . '/../../../includes/footer.php';
?>
