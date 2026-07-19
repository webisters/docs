<?php
$pageTitle = 'Webisters Docs';
require_once __DIR__ . '/../../../includes/header.php';
require_once __DIR__ . '/../../../includes/sidebar.php';
?>
<div class="section" id="database-extra">
<h1>Database Extra</h1>
<p>Webisters Database Extra Library.</p>
<ul>
    <li>
            <a href="#installation">Installation</a>
        </li>
    <li>
            <a href="#introduction">Introduction</a>
        </li>
    <li>
            <a href="#migrations">Migrations</a>
        </li>
    <li>
            <a href="#seeding">Seeding</a>
        </li>
    <li>
            <a href="#conclusion">Conclusion</a>
        </li>
</ul>
<div class="section" id="installation">
<h2>Installation</h2>
<p>The installation of this library can be done with Composer:</p>
<pre><code class="language- " >composer require Webisters/database-extra
</code></pre>
</div>
<div class="section" id="introduction">
<h2>Introduction</h2>
<p>The Database Extra library provides tools for working with database migrations
and seeding.</p>
</div>
<div class="section" id="migrations">
<h2>Migrations</h2>
<p>Migrations works like a database versioning.</p>
<p>With them, you can manage schemas and tables. Up and down for a given version.</p>
<p>The migration files are according to the template below:</p>
<pre><code class="language-php " >use Framework\Database\Extra\Migration;
return new class() extends Migration
{
    public function up() : void
    {
        //
    }
    public function down() : void
    {
        //
    }
};
</code></pre>
<p>In the <code>up</code> method, the creation and modification of schemas and tables must be
performed.<br>While in the <code>down</code> method, the opposite way is carried out, undoing the
modifications carried out in the up method.</p>
<p>The file names must follow an order, in which the migrations will go up and down.</p>
<p>You can use the date and time as a prefix and a brief description. For example:</p>
<p><code>2022_05_26_213000_create_table_users.php</code></p>
<p>Another way is simply numbering the start of the migration file. For example:</p>
<p><code>100_create_table_users.php</code></p>
<p>The important thing is that each migration system has its own standard.</p>
<p>In the examples that we will see, we will use a number as a prefix and a brief
description.</p>
<p>Inside the migration directory, we create the <code>100_create_table_users.php</code> file:</p>
<p><strong>migrations/100createtableusers.php</strong></p>
<pre><code class="language-php " >use Framework\Database\Definition\Table\TableDefinition;
use Framework\Database\Extra\Migration;
return new class() extends Migration
{
    protected string $table = &#039;Users&#039;;
    public function up() : void
    {
        $this-&gt;getDatabase()-&gt;createTable($this-&gt;table)
            -&gt;definition(function (TableDefinition $def) {
                $def-&gt;column(&#039;id&#039;)-&gt;int()-&gt;primaryKey()-&gt;autoIncrement();
                $def-&gt;column(&#039;name&#039;)-&gt;varchar(32);
                $def-&gt;column(&#039;birthday&#039;)-&gt;date();
            })-&gt;run();
    }
    public function down() : void
    {
        $this-&gt;getDatabase()-&gt;dropTable($this-&gt;table)-&gt;ifExists()-&gt;run();
    }
};
</code></pre>
<p>This file creates the Users table in the <code>up</code> method and drop it in the <code>down</code> method.</p>
<p>The file below creates the Posts table, which will run after
100createtableusers, due to it starting with the number 200.</p>
<p><strong>migrations/200createtableposts.php</strong></p>
<pre><code class="language-php " >use Framework\Database\Definition\Table\TableDefinition;
use Framework\Database\Extra\Migration;
return new class() extends Migration
{
    protected string $table = &#039;Posts&#039;;
    public function up() : void
    {
        $this-&gt;getDatabase()-&gt;createTable($this-&gt;table)
            -&gt;definition(function (TableDefinition $def) {
                $def-&gt;column(&#039;id&#039;)-&gt;int()-&gt;primaryKey()-&gt;autoIncrement();
                $def-&gt;column(&#039;userId&#039;)-&gt;int()-&gt;null();
                $def-&gt;column(&#039;title&#039;)-&gt;varchar(128);
                $def-&gt;column(&#039;contents&#039;)-&gt;text();
                $def-&gt;column(&#039;createdAt&#039;)-&gt;timestamp();
                $def-&gt;index()
                    -&gt;foreignKey(&#039;userId&#039;)
                    -&gt;references(&#039;Users&#039;, &#039;id&#039;)
                    -&gt;onDelete(&#039;SET NULL&#039;)
                    -&gt;onUpdate(&#039;CASCADE&#039;);
            })-&gt;run();
    }
    public function down() : void
    {
        $this-&gt;getDatabase()-&gt;dropTable($this-&gt;table)-&gt;ifExists()-&gt;run();
    }
};
</code></pre>
<p>In the next example, let&#039;s change the Users table, adding two columns to it on
the way up and removing them on the way down:</p>
<p><strong>migrations/300altertableusers.php</strong></p>
<pre><code class="language-php " >use Framework\Database\Definition\Table\TableDefinition;
use Framework\Database\Extra\Migration;
return new class() extends Migration
{
    protected string $table = &#039;Users&#039;;
    public function up() : void
    {
        $this-&gt;getDatabase()-&gt;alterTable($this-&gt;table)
            -&gt;add(function (TableDefinition $def) {
                $def-&gt;column(&#039;email&#039;)-&gt;varchar(255)-&gt;after(&#039;id&#039;);
                $def-&gt;column(&#039;password&#039;)-&gt;varchar(255);
            })-&gt;run();
    }
    public function down() : void
    {
        $this-&gt;getDatabase()-&gt;alterTable($this-&gt;table)
            -&gt;dropColumnIfExists(&#039;email&#039;)
            -&gt;dropColumnIfExists(&#039;password&#039;)
            -&gt;run();
    }
};
</code></pre>
<p>The files must return an instance of the <code>Framework\Database\Extra\Migration</code>
class to run in a Migrator.</p>
<div class="section" id="migrator">
<h3>Migrator</h3>
<p>Migrations are performed in a Migrator instance.</p>
<p>To instantiate it, you need a Database instance and at least one directory where
the migrations are stored.</p>
<pre><code class="language-php " >use Framework\Database\Database;
use Framework\Database\Extra\Migrator;
$database = new Database(&#039;root&#039;, &#039;password&#039;, &#039;app&#039;);
$directories = [
    __DIR__ . &#039;/migrations&#039;,
];
$migrator = new Migrator($database, $directories);
</code></pre>
<p>Once this is done, you can move the versioning of the migrations.</p>
<div class="section" id="migrate-up">
<h4>Migrate Up</h4>
<p>The <code>migrateUp</code> method runs migrations up.</p>
<p>Each time it runs the migration up method, it gives the migration name:</p>
<pre><code class="language-php " >foreach($migrator-&gt;migrateUp() as $name) {
    echo $name . PHP_EOL;
}
</code></pre>
</div>
<div class="section" id="migrate-down">
<h4>Migrate Down</h4>
<p>It is also possible to go down to undo all migrations:</p>
<pre><code class="language-php " >foreach($migrator-&gt;migrateDown() as $name) {
    echo $name . PHP_EOL;
}
</code></pre>
<p>Or, go down only a specific amount, as in the example below, going down only
3 migrations.</p>
<pre><code class="language-php " >foreach($migrator-&gt;migrateDown(3) as $name) {
    echo $name . PHP_EOL;
}
</code></pre>
</div>
<div class="section" id="migrate-to">
<h4>Migrate To</h4>
<p>With the <code>migrateTo</code> method you can automatically move to a certain version.<br>It will go up or down migrations according to the current version.</p>
<pre><code class="language-php " >foreach($migrator-&gt;migrateTo(&#039;2022_05_26_123000&#039;) as $name) {
    echo $name . PHP_EOL;
}
</code></pre>
</div>
</div>
<div class="section" id="seeding">
<h2>Seeding</h2>
<p>Seeding is a way of inserting data into database tables for testing purposes.</p>
<p>A Seeder is the class for performing this task.</p>
<p>They must extend the <code>Framework\Database\Extra\Seeder</code> class and perform data
insertion in the <code>run</code> method:</p>
<pre><code class="language-php " >use Framework\Database\Extra\Seeder;
class SeederName extends Seeder
{
    public function run() : void
    {
        //
    }
}
</code></pre>
<p>Let&#039;s look at an example for inserting data into the Users table:</p>
<p><strong>UsersSeeder.php</strong></p>
<pre><code class="language-php " >use Framework\Database\Extra\Seeder;
class UsersSeeder extends Seeder
{
    public function run() : void
    {
        $this-&gt;getDatabase()-&gt;insert(&#039;Users&#039;)
            -&gt;columns(&#039;name&#039;, &#039;birthday&#039;, &#039;email&#039;, &#039;password&#039;)
            -&gt;values([
                [
                    &#039;Seiya&#039;,
                    &#039;2009-12-01&#039;,
                    &#039;<a href="../cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="d7a7b2b0b6a4a2a497bcadf9a3bbb3">[email&#160;protected]</a>&#039;,
                    password_hash(&#039;password&#039;, PASSWORD_DEFAULT),
                ],
                [
                    &#039;Shiryu&#039;,
                    &#039;2008-10-04&#039;,
                    &#039;<a href="../cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="086c7a696f6766486372267c646c">[email&#160;protected]</a>&#039;,
                    password_hash(&#039;password&#039;, PASSWORD_DEFAULT),
                ],
                [
                    &#039;Hyoga&#039;,
                    &#039;2008-01-23&#039;,
                    &#039;<a href="../cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="04677d636a7177446f7e2a706860">[email&#160;protected]</a>&#039;,
                    password_hash(&#039;password&#039;, PASSWORD_DEFAULT),
                ],
                [
                    &#039;Shun&#039;,
                    &#039;2009-09-09&#039;,
                    &#039;<a href="../cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="f0919e94829f9d959491b09b8ade849c94">[email&#160;protected]</a>&#039;,
                    password_hash(&#039;password&#039;, PASSWORD_DEFAULT),
                ],
                [
                    &#039;Ikki&#039;,
                    &#039;2007-08-15&#039;,
                    &#039;<a href="../cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="14647c7b717a7d6c547f6e3a607870">[email&#160;protected]</a>&#039;,
                    password_hash(&#039;password&#039;, PASSWORD_DEFAULT),
                ],
            ])-&gt;run();
    }
}
</code></pre>
<p>Each seeder can be executed individually, but all the seeders that will be
called can be defined in a class.</p>
<p>Let&#039;s see an example with the <strong>DatabaseSeeder.php</strong> file, which uses the <code>call</code>
method to call and run other seeders:</p>
<pre><code class="language-php " >use Framework\Database\Extra\Seeder;
class DatabaseSeeder extends Seeder
{
    public function run() : void
    {
        $this-&gt;call([
            UsersSeeder::class,
            PostsSeeder::class,
        ]);
    }
}
</code></pre>
<p>Once this is done, just run the main seeder, which will call all the others to run:</p>
<pre><code class="language-php " >use Framework\Database\Database;
$database = new Database(&#039;root&#039;, &#039;password&#039;, &#039;app&#039;);
$seeder = new DatabaseSeeder($database);
$seeder-&gt;run();
</code></pre>
</div>
<div class="section" id="conclusion">
<h2>Conclusion</h2>
<p>Webisters Database Extra Library is an easy-to-use tool for PHP developers, beginners and experienced.<br>It is perfect for managing databases with versioning and tests with fake data.<br>The more you use it, the more you will learn.</p>
<div class="phpdocumentor-admonition -note ">
            <svg class="phpdocumentor-admonition__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path></svg>
                    <article>
        <p>Did you find something wrong?<br>Be sure to let us know about it with an
<a href="https://github.com/webisters/database-extra/issues">issue</a>.<br>Thank you!</p>
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
