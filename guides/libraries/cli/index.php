<?php
$pageTitle = 'Webisters Docs';
require_once __DIR__ . '/../../../includes/header.php';
require_once __DIR__ . '/../../../includes/sidebar.php';
?>
<div class="section" id="cli">
<h1>CLI</h1>
<p>Webisters CLI (Command-Line Interface) Library.</p>
<ul>
    <li>
            <a href="#installation">Installation</a>
        </li>
    <li>
            <a href="#running">Running</a>
        </li>
    <li>
            <a href="#conclusion">Conclusion</a>
        </li>
</ul>
<div class="section" id="installation">
<h2>Installation</h2>
<p>The installation of this library can be done with Composer:</p>
<pre><code class="language- " >composer require Webisters/cli
</code></pre>
</div>
<div class="section" id="running">
<h2>Running</h2>
<p>Create a file (<strong>cli.php</strong>) with the following contents:</p>
<pre><code class="language-php " >&lt;?php
require __DIR__ . &#039;/vendor/autoload.php&#039;;
use Framework\CLI\Console;
$console = new Console();
$console-&gt;run(); // void
</code></pre>
<p>Go to the terminal an run:</p>
<pre><code class="language- " >php cli.php
</code></pre>
<p>The output will be like the image below:</p>
<img
    src="../guides/libraries/cli/img/index.png"
                alt="Webisters CLI - Index Command"    />
<div class="section" id="add-a-custom-language">
<h3>Add a Custom Language</h3>
<p>Edit the PHP file:</p>
<pre><code class="language-php " >use Framework\CLI\Console;
use Framework\Language\Language;
$language = new Language(&#039;pt-br&#039;);
$console = new Console($language);
$console-&gt;run(); // void
</code></pre>
<p>Run the file in the terminal.
The output will be like the following:</p>
<img
    src="../guides/libraries/cli/img/custom-language.png"
                alt="Webisters CLI - Index Command with Custom Language"    />
<p>If the CLI Library is not localized in your language, you can contribute by adding
it with a <a href="https://github.com/webisters/cli/pulls">Pull Request in the package repository</a>.</p>
<p>It is also possible to add custom languages at runtime. See the
<a href="https://github.com/webisters/language">Language Library</a> to know more.</p>
</div>
<div class="section" id="add-a-custom-command">
<h3>Add a Custom Command</h3>
<p>Now, let&#039;s add your first Command.</p>
<p>Edit the PHP file:</p>
<pre><code class="language-php " >use Framework\CLI\CLI;
use Framework\CLI\Command;
use Framework\CLI\Console;
class HelloCommand extends Command
{
    public function run() : void
    {
        CLI::write(&#039;Hello, Webisters!&#039;);
    }
}
$console = new Console();
$console-&gt;addCommand(HelloCommand::class); // static
$console-&gt;run(); // void
</code></pre>
<p>Go to the terminal and run:</p>
<pre><code class="language- " >php cli.php
</code></pre>
<p>Note that <strong>hello</strong> is listed as an available command:</p>
<img
    src="../guides/libraries/cli/img/custom-command.png"
                alt="Webisters CLI - Index Command with Custom Command"    />
<p>Run the <strong>hello</strong> command:</p>
<pre><code class="language- " >php cli.php hello
</code></pre>
<p>The output will be like this:</p>
<img
    src="../guides/libraries/cli/img/custom-command-run.png"
                alt="Webisters CLI - Run a Hello Command"    />
</div>
</div>
<div class="section" id="conclusion">
<h2>Conclusion</h2>
<p>Webisters CLI Library is an easy-to-use tool for PHP developers, beginners and experienced.<br>It is perfect for building simple and full-featured command-line interfaces.<br>The more you use it, the more you will learn.</p>
<div class="phpdocumentor-admonition -note ">
            <svg class="phpdocumentor-admonition__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path></svg>
                    <article>
        <p>Did you find something wrong?<br>Be sure to let us know about it with an
<a href="https://github.com/webisters/cli/issues">issue</a>.<br>Thank you!</p>
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
