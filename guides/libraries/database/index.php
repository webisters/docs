<?php
$pageTitle = 'Webisters Docs';
require_once __DIR__ . '/../../../includes/header.php';
require_once __DIR__ . '/../../../includes/sidebar.php';
?>
<div class="section" id="database">
<h1>Database</h1>
<p>Webisters Database Library.</p>
<ul>
    <li>
            <a href="#installation">Installation</a>
        </li>
    <li>
            <a href="#introduction">Introduction</a>
        </li>
    <li>
            <a href="#basic-usage">Basic Usage</a>
        </li>
    <li>
            <a href="#connection">Connection</a>
        </li>
    <li>
            <a href="#executing-queries">Executing Queries</a>
        </li>
    <li>
            <a href="#prepared-statement">Prepared Statement</a>
        </li>
    <li>
            <a href="#result">Result</a>
        </li>
    <li>
            <a href="#data-manipulation-language-dml">Data Manipulation Language - DML</a>
        </li>
    <li>
            <a href="#select">SELECT</a>
        </li>
    <li>
            <a href="#insert">INSERT</a>
        </li>
    <li>
            <a href="#update">UPDATE</a>
        </li>
    <li>
            <a href="#delete">DELETE</a>
        </li>
    <li>
            <a href="#replace">REPLACE</a>
        </li>
    <li>
            <a href="#with">WITH</a>
        </li>
    <li>
            <a href="#load-data">LOAD DATA</a>
        </li>
    <li>
            <a href="#data-definition-language-ddl">Data Definition Language - DDL</a>
        </li>
    <li>
            <a href="#create-schema">CREATE SCHEMA</a>
        </li>
    <li>
            <a href="#alter-schema">ALTER SCHEMA</a>
        </li>
    <li>
            <a href="#drop-schema">DROP SCHEMA</a>
        </li>
    <li>
            <a href="#create-table">CREATE TABLE</a>
        </li>
    <li>
            <a href="#alter-table">ALTER TABLE</a>
        </li>
    <li>
            <a href="#drop-table">DROP TABLE</a>
        </li>
    <li>
            <a href="#conclusion">Conclusion</a>
        </li>
</ul>
<div class="section" id="installation">
<h2>Installation</h2>
<p>The installation of this library can be done with Composer:</p>
<pre><code class="language- " >composer require Webisters/database
</code></pre>
</div>
<div class="section" id="introduction">
<h2>Introduction</h2>
<p>The Database library is designed to work with MariaDB and MySQL databases.</p>
</div>
<div class="section" id="basic-usage">
<h2>Basic Usage</h2>
<p>The use of the entire library is centered on the Database class. In it, the
connection with the database is made and the desired queries are mounted.</p>
<div class="section" id="connection">
<h3>Connection</h3>
<p>The connection with the database server can be done in the Database class
construction. You can use all parameters:</p>
<pre><code class="language-php " >use Framework\Database\Database;
$database = new Database($username, $password, $schema, $host, $port, $logger);
</code></pre>
<p>Or, pass the configurations as an array in the first parameter:</p>
<pre><code class="language-php " >use Framework\Database\Database;
$database = new Database($config);
</code></pre>
<p>Below is the default class configuration. Normally, only the <code>username</code>, the
<code>password</code> and the <code>schema</code> are changed.</p>
<pre><code class="language-php " >$default = [
    &#039;host&#039; =&gt; &#039;localhost&#039;,
    &#039;port&#039; =&gt; 3306,
    &#039;username&#039; =&gt; null,
    &#039;password&#039; =&gt; null,
    &#039;schema&#039; =&gt; null,
    &#039;socket&#039; =&gt; null,
    &#039;persistent&#039; =&gt; false,
    &#039;engine&#039; =&gt; &#039;InnoDB&#039;,
    &#039;charset&#039; =&gt; &#039;utf8mb4&#039;,
    &#039;collation&#039; =&gt; &#039;utf8mb4_general_ci&#039;,
    &#039;timezone&#039; =&gt; &#039;+00:00&#039;,
    &#039;init_queries&#039; =&gt; true,
    &#039;ssl&#039; =&gt; [
        &#039;enabled&#039; =&gt; false,
        &#039;verify&#039; =&gt; true,
        &#039;key&#039; =&gt; null,
        &#039;cert&#039; =&gt; null,
        &#039;ca&#039; =&gt; null,
        &#039;capath&#039; =&gt; null,
        &#039;cipher&#039; =&gt; null,
    ],
    &#039;failover&#039; =&gt; [],
    &#039;options&#039; =&gt; [
        MYSQLI_OPT_CONNECT_TIMEOUT =&gt; 10,
        MYSQLI_OPT_INT_AND_FLOAT_NATIVE =&gt; true,
        MYSQLI_OPT_LOCAL_INFILE =&gt; 1,
    ],
    &#039;report&#039; =&gt; MYSQLI_REPORT_ALL &amp; ~MYSQLI_REPORT_INDEX,
];
</code></pre>
</div>
<div class="section" id="executing-queries">
<h3>Executing Queries</h3>
<p>You can read data via the <a href="#query">query</a> method and write via the <a href="#exec">exec</a> method.</p>
<div class="section" id="query">
<h4>query</h4>
<p>To query data obtaining a result, use the <code>query</code> method.</p>
<p>It will always return a <a href="#result">Result</a> instance, from which the query result rows
can be read.</p>
<pre><code class="language-php " >$result = $database-&gt;query(&#039;SELECT * FROM Users WHERE id = 1&#039;); // Result
</code></pre>
<p>Whenever you need to use dynamic data in the query, use the <code>quote</code> method to
sanitize values in order to avoid SQL Injection:</p>
<pre><code class="language-php " >$id = $database-&gt;quote($_GET[&#039;user_id&#039;]);
$result = $database-&gt;query(&#039;SELECT * FROM Users WHERE id = &#039; . $id); // Result
</code></pre>
</div>
<div class="section" id="exec">
<h4>exec</h4>
<p>With the <code>exec</code> method, the writing to the database is performed. And the return
is always a number, being the number of affected rows.</p>
<pre><code class="language-php " >$affectedRows = $database-&gt;exec(&#039;INSERT INTO Users SET name = &quot;John Doe&quot;&#039;); // int
</code></pre>
<p>Again, always use the <code>quote</code> method if you need to get dynamic data to build
the SQL statement:</p>
<pre><code class="language-php " >$name = $database-&gt;quote($_POST[&#039;name&#039;]);
$affectedRows = $database-&gt;exec(
    &#039;INSERT INTO Users SET name = &#039; . $name
); // int or string
</code></pre>
</div>
</div>
<div class="section" id="prepared-statement">
<h3>Prepared Statement</h3>
<p>To avoid having to quote data insuring against SQL Injection, you can use
Prepared Statements.</p>
<p>In the prepared statement the values are replaced by a question mark and when
executed returns an instance of the <strong>PreparedStatement</strong> class:</p>
<pre><code class="language-php " >$preparedStatement = $database-&gt;prepare(&#039;SELECT * FROM Users WHERE id = ?&#039;); // PreparedStatement
</code></pre>
<p>With the PreparedStatement instance, the <code>query</code> method is called for queries,
passing in the parameters the values used in place of the question marks:</p>
<pre><code class="language-php " >$result = $database-&gt;prepare(&#039;SELECT * FROM Users WHERE id = ?&#039;)-&gt;query(5); // Result
</code></pre>
<p>Another example querying with data that could be dynamic:</p>
<pre><code class="language-php " >$idGreaterThan = 3;
$nameLike = &#039;John %&#039;;
$result = $database-&gt;prepare(&#039;SELECT * FROM Users WHERE id &gt; ? AND name LIKE ?&#039;)
                   -&gt;query($idGreaterThan, $nameLike); // Result
</code></pre>
<p>And, to perform writings, use the <code>exec</code> method of the PreparedStatement
class, passing the values in order in the same way as in the <code>query</code> method:</p>
<pre><code class="language-php " >$affectedRows = $database-&gt;prepare(&#039;INSERT INTO Users SET name = ?&#039;)
                         -&gt;exec($_POST[&#039;name&#039;]); // int or string
</code></pre>
</div>
<div class="section" id="result">
<h3>Result</h3>
<p>The <code>query</code> method of the Database class will always return an instance of the
Result class.</p>
<p>With it it is possible to fetch the results in the form of arrays or objects.
Let&#039;s see:</p>
<pre><code class="language-php " >$result = $database-&gt;query(&#039;SELECT * FROM Users&#039;); // Result
$first = $result-&gt;fetch(); // object or null
$others = $result-&gt;fetchAll(); // array of objects or empty array
$userOnRow10 = $result-&gt;fetchRow(10); // object or null
</code></pre>
</div>
</div>
<div class="section" id="data-manipulation-language-dml">
<h2>Data Manipulation Language - DML</h2>
<p>To manipulate tables in a database schema we can use the various methods of the
Database class. Since they have a fluent interface and with automatic identifier
and quote protection.</p>
<p>The DML statements are these:</p>
<ul>
    <li>
            <a href="#select">SELECT</a>
        </li>
    <li>
            <a href="#insert">INSERT</a>
        </li>
    <li>
            <a href="#update">UPDATE</a>
        </li>
    <li>
            <a href="#delete">DELETE</a>
        </li>
    <li>
            <a href="#replace">REPLACE</a>
        </li>
    <li>
            <a href="#with">WITH</a>
        </li>
    <li>
            <a href="#load-data">LOAD DATA</a>
        </li>
</ul>
<div class="section" id="select">
<h3>SELECT</h3>
<p>SELECT lets you select rows from one or more tables.</p>
<p>Below we see an example setting up the query and calling the <code>run</code> method,
which will get a Result:</p>
<pre><code class="language-php " >$result = $database-&gt;select()
                   -&gt;from(&#039;Users&#039;)
                   -&gt;where(&#039;id&#039;, &#039;&lt;&#039;, 5)
                   -&gt;run(); // Result
// HTML table rows with users data
while($user = $result-&gt;fetch()) {
    echo &#039;&lt;tr&gt;&#039;;
    echo &#039;&lt;td&gt;&#039; . $user-&gt;id . &#039;&lt;/td&gt;&#039;;
    echo &#039;&lt;td&gt;&#039; . htmlentities($user-&gt;name) . &#039;&lt;/td&gt;&#039;;
    echo &#039;&lt;/tr&gt;&#039;;
}
</code></pre>
<p>Dynamic fields are automatically quoted. Here&#039;s an example getting the <code>user_id</code>
from the global variable <code>$_GET</code>:</p>
<pre><code class="language-php " >$sql = $database-&gt;select()
                -&gt;from(&#039;Users&#039;)
                -&gt;where(&#039;id&#039;, &#039;&lt;&#039;, $_GET[&#039;user_id&#039;])
                -&gt;sql(); // string
</code></pre>
<p>Notice that the value is quoted when using the <code>sql</code> method to build the
statement:</p>
<pre><code class="language-sql " >SELECT
 *
 FROM `Users`
 WHERE `id` &lt; &#039;5;drop table Users;&#039;
</code></pre>
</div>
<div class="section" id="insert">
<h3>INSERT</h3>
<p>INSERT is for inserting new rows into a table.</p>
<p>You can insert a row only using the SET clause:</p>
<pre><code class="language-php " >$affectedRows = $database-&gt;insert()
                         -&gt;into(&#039;Users&#039;)
                         -&gt;set([
                            &#039;name&#039; =&gt; &#039;John&#039;,
                            &#039;email&#039; =&gt; &#039;<a href="../cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="d2b4bdbd92b0b3a8fcb1bdbf">[email&#160;protected]</a>&#039;,
                         ])-&gt;run(); // int or string
</code></pre>
<pre><code class="language-sql " >INSERT
 INTO `Users`
 SET `name` = &#039;John&#039;, `email` = &#039;<a href="../cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="680e0707280a0912460b0705">[email&#160;protected]</a>&#039;
</code></pre>
<p>Or several at once using the <code>columns</code> and <code>values</code> methods:</p>
<pre><code class="language-php " >$affectedRows = $database-&gt;insert()
                         -&gt;into(&#039;Users&#039;)
                         -&gt;columns(&#039;name&#039;, &#039;email&#039;)
                         -&gt;values([
                             [&#039;John&#039;, &#039;<a href="../cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="45232a2a0527243f6b262a28">[email&#160;protected]</a>&#039;],
                             [&#039;Mary&#039;, &#039;<a href="../cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="cba9aab98ba9aab1e5a8a4a6">[email&#160;protected]</a>&#039;],
                         ])-&gt;run(); // int or string
</code></pre>
<p>SQL executed:</p>
<pre><code class="language-sql " >INSERT
 INTO `Users`
 (`name`, `email`)
 VALUES (&#039;John&#039;, &#039;<a href="../cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="1f7970705f7d7e65317c7072">[email&#160;protected]</a>&#039;),
 (&#039;Mary&#039;, &#039;<a href="../cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="73111201331112095d101c1e">[email&#160;protected]</a>&#039;)
</code></pre>
<div class="section" id="insert-id">
<h4>Insert ID</h4>
<p>Whenever a new row is inserted in an auto-increment table, it is possible to
obtain the id of the inserted row through the <code>insertId</code> method of the
Database class.</p>
<pre><code class="language-php " >$id = $database-&gt;insertId(); // int or string
</code></pre>
<p>When several rows are inserted in the same statement, the id returned is that of
the first inserted row.</p>
</div>
</div>
<div class="section" id="update">
<h3>UPDATE</h3>
<p>Through the UPDATE statement, update values in table columns.</p>
<p>Let&#039;s see an example updating the Users table, setting a new name where the id
is equal to one.</p>
<pre><code class="language-php " >$affectedRows = $database-&gt;update()
                         -&gt;table(&#039;Users&#039;)
                         -&gt;set([&#039;name&#039; =&gt; &#039;Johnny&#039;]);
                         -&gt;whereEqual(&#039;id&#039;, 1)
                         -&gt;run(); // int or string
</code></pre>
<p>The SQL statement executed above is the same as below:</p>
<pre><code class="language-sql " >UPDATE
 `Users`
 SET `name` = &#039;Johnny&#039;
 WHERE `id` = 1
</code></pre>
</div>
<div class="section" id="delete">
<h3>DELETE</h3>
<p>DELETE is for deleting rows in tables.</p>
<p>See the example below of how to delete rows in the Users table, where the id is
equal to 88:</p>
<pre><code class="language-php " >$affectedRows = $database-&gt;delete()
                         -&gt;from(&#039;Users&#039;)
                         -&gt;whereEqual(&#039;id&#039;, 88)
                         -&gt;run(); // int or string
</code></pre>
<p>The example above builds and executes the following SQL statement:</p>
<pre><code class="language-sql " >DELETE
 FROM `Users`
 WHERE `id` = 88
</code></pre>
</div>
<div class="section" id="replace">
<h3>REPLACE</h3>
<p>REPLACE works in the same way as <a href="#insert">INSERT</a>, except that if an old row has the
same primary or unique key, the old row will be deleted and then the new row
will be inserted.</p>
<p>Let&#039;s see an example replacing a row in the Users table:</p>
<pre><code class="language-php " >$affectedRows = $database-&gt;replace()
                         -&gt;into(&#039;Users&#039;)
                         -&gt;columns(&#039;id&#039;, &#039;name&#039;, &#039;email&#039;)
                         -&gt;values(1, &#039;John Doe&#039;, &#039;<a href="../cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="cfa5a0a7a1aba0aa8faaaca0bdbfe1bba3ab">[email&#160;protected]</a>&#039;)
                         -&gt;run(); // int or string
</code></pre>
<p>The SQL statement below is the one executed in the example above:</p>
<pre><code class="language-sql " >REPLACE
 INTO `Users`
 (`id`, `name`, `email`)
 VALUES (1, &#039;John Doe&#039;, &#039;<a href="../cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="345e5b5c5a505b517451575b46441a405850">[email&#160;protected]</a>&#039;)
</code></pre>
</div>
<div class="section" id="with">
<h3>WITH</h3>
<p>WITH allows you to refer to a subquery expression many times in a query, as if
having a temporary table that only exists for the duration of a query.</p>
<pre><code class="language-php " >$result = $database-&gt;with()-&gt;reference(&#039;t&#039;, function (Select $select) {
    return $select-&gt;expressions(&#039;a&#039;)
        -&gt;from(&#039;t1&#039;)
        -&gt;whereGreaterThanOrEqual(&#039;b&#039;, &#039;c&#039;)
        -&gt;sql(); // string
})-&gt;select(function (Select $select) {
    return $select-&gt;from(&#039;t2&#039;, &#039;t&#039;)
        -&gt;whereEqual(
            &#039;t2.c&#039;,
            fn (Database $db) =&gt; $db-&gt;protectIdentifier(&#039;t.a&#039;)
        )-&gt;sql(); // string
})-&gt;run(); // Result
</code></pre>
<p>The code above will build and execute the following statement:</p>
<pre><code class="language-sql " >WITH
`t` AS (SELECT
 `a`
 FROM `t1`
 WHERE `b` &gt;= &#039;c&#039;
)
SELECT
 *
 FROM `t2`, `t`
 WHERE `t2`.`c` = (`t`.`a`)
</code></pre>
</div>
<div class="section" id="load-data">
<h3>LOAD DATA</h3>
<p>LOAD DATA INFILE is able to read files and insert their data into a table.</p>
<p>Let&#039;s see an example below:</p>
<pre><code class="language-php " >use Framework\Database\Manipulation\LoadData;
$database-&gt;loadData()
         -&gt;infile(&#039;/home/developer/users.csv&#039;)
         -&gt;options(LoadData::OPT_LOCAL)
         -&gt;intoTable(&#039;Users&#039;)
         -&gt;charset(&#039;utf8&#039;)
         -&gt;columnsTerminatedBy(&#039;,&#039;)
         -&gt;run(); // int or string
</code></pre>
<p>Will run the following statement:</p>
<pre><code class="language-sql " >LOAD DATA
LOCAL
 INFILE &#039;/home/developer/users.csv&#039;
 INTO TABLE `Users`
 CHARACTER SET utf8
 COLUMNS
  TERMINATED BY &#039;,&#039;
</code></pre>
<p>For this statement to work, the <code>mysqli.allow_local_infile</code> directive must be
<code>On</code> in the <strong>php.ini</strong> file.</p>
</div>
</div>
<div class="section" id="data-definition-language-ddl">
<h2>Data Definition Language - DDL</h2>
<p>Through the DDL, the structure of a database is defined, with the definition of
schemas and tables.</p>
<p>Statements for defining schemas:</p>
<ul>
    <li>
            <a href="#create-schema">CREATE SCHEMA</a>
        </li>
    <li>
            <a href="#alter-schema">ALTER SCHEMA</a>
        </li>
    <li>
            <a href="#drop-schema">DROP SCHEMA</a>
        </li>
</ul>
<p>Statements for defining tables:</p>
<ul>
    <li>
            <a href="#create-table">CREATE TABLE</a>
        </li>
    <li>
            <a href="#alter-table">ALTER TABLE</a>
        </li>
    <li>
            <a href="#drop-table">DROP TABLE</a>
        </li>
</ul>
<div class="section" id="create-schema">
<h3>CREATE SCHEMA</h3>
<p>CREATE SCHEMA creates database schemas with a specific name.</p>
<p>Let&#039;s look at an example creating the <code>app</code> schema:</p>
<pre><code class="language-php " >$database-&gt;createSchema(&#039;app&#039;)-&gt;run(); // int or string
</code></pre>
<p>The statement executed above is the same as the example below:</p>
<pre><code class="language-sql " >CREATE SCHEMA `app`
</code></pre>
</div>
<div class="section" id="alter-schema">
<h3>ALTER SCHEMA</h3>
<p>ALTER SCHEMA makes it possible to change characteristics of a database schema.</p>
<p>Let&#039;s see, in the example below, how to change the charset of the app schema:</p>
<pre><code class="language-php " >$database-&gt;alterSchema(&#039;app&#039;)-&gt;charset(&#039;utf8&#039;)-&gt;run(); // int or string
</code></pre>
<pre><code class="language-sql " >ALTER SCHEMA `app`
 CHARACTER SET = &#039;utf8&#039;
</code></pre>
</div>
<div class="section" id="drop-schema">
<h3>DROP SCHEMA</h3>
<p>DROP SCHEMA drops all tables and drops the database schema.</p>
<p>Let&#039;s see how to remove the app schema:</p>
<pre><code class="language-php " >$database-&gt;dropSchema(&#039;app&#039;)-&gt;run(); // int or string
</code></pre>
<pre><code class="language-sql " >DROP SCHEMA `app`
</code></pre>
</div>
<div class="section" id="create-table">
<h3>CREATE TABLE</h3>
<p>CREATE TABLE is used to create tables within schemas.</p>
<p>Let&#039;s see in the example below how to create a table called Users, adding
columns and indexes in it:</p>
<pre><code class="language-php " >use Framework\Database\Definition\Table\TableDefinition;
$database-&gt;createTable(&#039;Users&#039;)
         -&gt;definition(function (TableDefinition $def) {
            $def-&gt;column(&#039;id&#039;)-&gt;int(11)-&gt;primaryKey();
            $def-&gt;column(&#039;email&#039;)-&gt;varchar(255);
            $def-&gt;column(&#039;name&#039;)-&gt;varchar(32)-&gt;null();
            $def-&gt;column(&#039;type&#039;)
                -&gt;enum(&#039;basic&#039;, &#039;premium&#039;)
                -&gt;default(&#039;basic&#039;)
                -&gt;comment(&#039;User type used in the authorization system&#039;);
            $def-&gt;index()-&gt;uniqueKey(&#039;email&#039;);
        })-&gt;run(); // int or string
</code></pre>
<p>The PHP example above will build and execute the following SQL:</p>
<pre><code class="language-sql " >CREATE TABLE `Users` (
  `id` int(11) NOT NULL PRIMARY KEY,
  `email` varchar(255) NOT NULL,
  `name` varchar(32) NULL,
  `type` enum(&#039;basic&#039;, &#039;premium&#039;) NOT NULL DEFAULT &#039;basic&#039; COMMENT &#039;User type used in the authorization system&#039;,
  UNIQUE KEY (`email`)
)
</code></pre>
</div>
<div class="section" id="alter-table">
<h3>ALTER TABLE</h3>
<p>ALTER TABLE allows you to change the structure of a table, such as adding or
removing columns and indexes.</p>
<p>Let&#039;s look at an example adding the <code>configs</code> and <code>birthday</code> columns to the
Users table:</p>
<pre><code class="language-php " >use Framework\Database\Definition\Table\TableDefinition;
$database-&gt;alterTable(&#039;Users&#039;)
         -&gt;add(function (TableDefinition $def) {
            $def-&gt;column(&#039;configs&#039;)-&gt;json()-&gt;default(&#039;{}&#039;);
            $def-&gt;column(&#039;birthday&#039;)-&gt;date()-&gt;null()-&gt;after(&#039;name&#039;);
         })-&gt;run(); // int or string
</code></pre>
<p>The code above will build and execute the following statement:</p>
<pre><code class="language-sql " >ALTER TABLE `Users`
  ADD COLUMN `configs` json NOT NULL DEFAULT &#039;{}&#039;,
  ADD COLUMN `birthday` date NULL AFTER `name`
</code></pre>
</div>
<div class="section" id="drop-table">
<h3>DROP TABLE</h3>
<p>DROP TABLE removes one or more tables from a database schema:</p>
<pre><code class="language-php " >$database-&gt;dropTable(&#039;Users&#039;)-&gt;run(); // int or string
</code></pre>
<pre><code class="language-sql " >DROP TABLE `Users`
</code></pre>
</div>
</div>
<div class="section" id="conclusion">
<h2>Conclusion</h2>
<p>Webisters Database Library is an easy-to-use tool for, beginners and experienced, PHP developers.<br>It is perfect for manipulating and defining databases quickly and securely.<br>The more you use it, the more you will learn.</p>
<div class="phpdocumentor-admonition -note ">
            <svg class="phpdocumentor-admonition__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path></svg>
                    <article>
        <p>Did you find something wrong?<br>Be sure to let us know about it with an
<a href="https://github.com/webisters/database/issues">issue</a>.<br>Thank you!</p>
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
