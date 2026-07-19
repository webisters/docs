<?php
$pageTitle = 'Dev Commands · Webisters Docs';
require_once __DIR__ . '/../../../includes/header.php';
require_once __DIR__ . '/../../../includes/sidebar.php';
?>
<div class="section" id="dev-commands">
<h1>Dev Commands</h1>
<p>Webisters Dev Commands ships ready-made CLI commands for the work you do during local development: running migrations, listing routes, dumping a table, seeding fixtures, starting a dev server, and more. Add the library to your project and they appear under your <code>webisters</code> binary alongside your own commands.</p>
<ul>
    <li><a href="#installation">Installation</a></li>
    <li><a href="#registering-the-commands">Registering the commands</a></li>
    <li><a href="#database-commands">Database commands</a></li>
    <li><a href="#routing-commands">Routing commands</a></li>
    <li><a href="#dev-server">Dev server</a></li>
    <li><a href="#conclusion">Conclusion</a></li>
</ul>

<div class="section" id="installation">
<h2>Installation</h2>
<pre><code class="language-bash">composer require --dev webisters/dev-commands</code></pre>
</div>

<div class="section" id="registering-the-commands">
<h2>Registering the commands</h2>
<p>The commands are PSR-4 autoloaded under <code>Framework\CLI\Commands\</code>. Register the namespace with your console kernel:</p>
<pre><code class="language-php">use Framework\CLI\Console;

$console-&gt;addCommandsByNamespace('Framework\\CLI\\Commands');</code></pre>
<p>If you scaffolded your project from the App or API template, the commands are pre-registered.</p>
</div>

<div class="section" id="database-commands">
<h2>Database commands</h2>
<p>Run the standard migration lifecycle from the CLI:</p>
<pre><code class="language-bash">webisters migrate:up        # apply all pending migrations
webisters migrate:down      # roll back the last batch
webisters migrate:to 2024_01_15_000001  # migrate to a specific version

webisters seed              # run seeders
webisters list-schemas      # list every schema known to the configured connections
webisters show-schema users # describe one schema
webisters show-table users  # render a table's contents in the terminal
webisters query "SELECT * FROM users LIMIT 5"</code></pre>
</div>

<div class="section" id="routing-commands">
<h2>Routing commands</h2>
<pre><code class="language-bash">webisters routes            # tabular list of every registered route
webisters make-routes       # regenerate route attribute cache</code></pre>
</div>

<div class="section" id="dev-server">
<h2>Dev server</h2>
<p>Start a local dev server with preloading, watching, and logging enabled:</p>
<pre><code class="language-bash">webisters start</code></pre>
<p>Stop it with <kbd>Ctrl</kbd>+<kbd>C</kbd>.</p>
</div>

<div class="section" id="conclusion">
<h2>Conclusion</h2>
<p>Anything you find yourself running ten times a day during development is a candidate for becoming a command. Lean on the existing ones, then add your own following the same pattern in <a href="../cli/index.php">CLI</a>.</p>
<div class="phpdocumentor-admonition -note">
    <svg class="phpdocumentor-admonition__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/></svg>
    <article><p>Did you find something wrong? Be sure to let us know with an <a href="https://github.com/webisters/dev-commands/issues">issue</a>. Thank you!</p></article>
</div>
</div>
</div>
<?php
require_once __DIR__ . '/../../../includes/footer.php';
?>
