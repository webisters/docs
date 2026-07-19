<?php
$pageTitle = 'Webisters Docs';
require_once __DIR__ . '/../../../includes/header.php';
require_once __DIR__ . '/../../../includes/sidebar.php';
?>
<div class="section" id="email">
<h1>Email</h1>
<p>Webisters Email Library.</p>
<ul>
    <li>
            <a href="#installation">Installation</a>
        </li>
    <li>
            <a href="#sending-emails">Sending Emails</a>
        </li>
    <li>
            <a href="#plain-message">Plain Message</a>
        </li>
    <li>
            <a href="#html-message">HTML Message</a>
        </li>
    <li>
            <a href="#attachments">Attachments</a>
        </li>
    <li>
            <a href="#headers">Headers</a>
        </li>
    <li>
            <a href="#mailer-connection">Mailer Connection</a>
        </li>
    <li>
            <a href="#conclusion">Conclusion</a>
        </li>
</ul>
<div class="section" id="installation">
<h2>Installation</h2>
<p>The installation of this library can be done with Composer:</p>
<pre><code class="language- " >composer require Webisters/email
</code></pre>
</div>
<div class="section" id="sending-emails">
<h2>Sending Emails</h2>
<p>The process of sending messages by email follows the example code below.</p>
<pre><code class="language-php " >use Framework\Email\Mailer;
// Set the mailer that will send the messages
$mailer = new Mailer(&#039;johndoe&#039;, &#039;p$$word&#039;);
// The message is created
$message = $mailer-&gt;createMessage();
$message-&gt;setFrom(&#039;<a href="../cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="d8b2b7b0b6bcb7bd98bcb7b5b9b1b6f6acb4bc">[email&#160;protected]</a>&#039;)
        -&gt;addTo(&#039;<a href="../cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="157874676c55717a78747c7b3b617971">[email&#160;protected]</a>&#039;)
        -&gt;setPlainMessage(&#039;Hello, Mary! How are you?&#039;);
// Try to send the message
$sent = $mailer-&gt;send($message); // false or true
if ($sent) {
    echo &#039;Message sent.&#039;;
} else {
    echo &#039;The message was not sent: &#039;;
    echo $mailer-&gt;getLastResponse();
}
</code></pre>
</div>
<div class="section" id="plain-message">
<h2>Plain Message</h2>
<p>It is possible to set the plain text version of the message:</p>
<pre><code class="language-php " >$message-&gt;setPlainMessage(&#039;Hello, John Doe!&#039;);
</code></pre>
</div>
<div class="section" id="html-message">
<h2>HTML Message</h2>
<p>It is also possible to set the message as HTML:</p>
<pre><code class="language-php " >$message-&gt;setHtmlMessage(&#039;Hello, &lt;b&gt;John Doe&lt;/b&gt;!&#039;);
</code></pre>
<p>Or both versions:</p>
<pre><code class="language-php " >$message-&gt;setPlainMessage(&#039;Hello, John Doe!&#039;)
        -&gt;setHtmlMessage(&#039;Hello, &lt;b&gt;John Doe&lt;/b&gt;!&#039;);
</code></pre>
<div class="section" id="embed-images">
<h3>Embed Images</h3>
<p>When sending HTML messages it may be necessary to place images in the body of
the message.</p>
<p>This is done through an inline attachment with the <strong>cid</strong> in the <em>src</em>
attribute of the image:</p>
<pre><code class="language-php " >$message-&gt;setHtmlMessage(&#039;Hello, &lt;b&gt;John Doe&lt;/b&gt;!&lt;br&gt;
See how beautiful the sky was today:
&lt;img src=&quot;cid:sky&quot;&gt;&#039;);
$message-&gt;setInlineAttachment(__DIR__ . &#039;/blue-sky.png&#039;, &#039;sky&#039;)
</code></pre>
</div>
</div>
<div class="section" id="attachments">
<h2>Attachments</h2>
<p>The other attachments can be added with the <code>addAttachment</code> method:</p>
<pre><code class="language-php " >$message-&gt;addAttachment(__DIR__ . &#039;/storage/invoice-1001.pdf&#039;);
</code></pre>
</div>
<div class="section" id="headers">
<h2>Headers</h2>
<p>Message header fields can be set directly using the <code>setHeader</code> method:</p>
<pre><code class="language-php " >$message-&gt;setHeader(&#039;Subject&#039;, &#039;How are you?&#039;)
        -&gt;setHeader(&#039;From&#039;, &#039;<a href="../cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="eb818483858f848eab8f84868a8285c59f878f">[email&#160;protected]</a>&#039;)
        -&gt;setHeader(&#039;To&#039;, &#039;<a href="../cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="254844575c65414a48444c4b0b514941">[email&#160;protected]</a>&#039;);
</code></pre>
<pre><code class="language-php " >use Framework\Email\Header;
$message-&gt;setHeader(Header::SUBJECT, &#039;How are you?&#039;)
        -&gt;setHeader(Header::FROM, &#039;<a href="../cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="ddb7b2b5b3b9b2b89db9b2b0bcb4b3f3a9b1b9">[email&#160;protected]</a>&#039;)
        -&gt;setHeader(Header::TO, &#039;<a href="../cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="e28f83909ba2868d8f838b8ccc968e86">[email&#160;protected]</a>&#039;);
</code></pre>
<p>Or through setters of the most used headers:</p>
<pre><code class="language-php " >$message-&gt;setSubject(&#039;How are you?&#039;)
        -&gt;setFrom(&#039;<a href="../cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="2b414443454f444e6b4f44464a4245055f474f">[email&#160;protected]</a>&#039;)
        -&gt;addTo(&#039;<a href="../cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="315c50434871555e5c50585f1f455d55">[email&#160;protected]</a>&#039;);
</code></pre>
<div class="section" id="x-priority">
<h3>X-Priority</h3>
<p>The X-Priority can be set as below:</p>
<pre><code class="language-php " >use Framework\Email\XPriority
$message-&gt;setXPriority(XPriority::HIGH);
</code></pre>
</div>
</div>
<div class="section" id="mailer-connection">
<h2>Mailer Connection</h2>
<p>The default configs for connecting to the mail server are as follows:</p>
<pre><code class="language-php " >use Framework\Email\Mailer;
$config = [
    &#039;host&#039; =&gt; &#039;localhost&#039;,
    &#039;port&#039; =&gt; 587,
    &#039;tls&#039; =&gt; true,
    &#039;options&#039; =&gt; [
        &#039;ssl&#039; =&gt; [
            &#039;allow_self_signed&#039; =&gt; false,
            &#039;verify_peer&#039; =&gt; true,
            &#039;verify_peer_name&#039; =&gt; true,
        ],
    ],
    &#039;username&#039; =&gt; null,
    &#039;password&#039; =&gt; null,
    &#039;charset&#039; =&gt; &#039;utf-8&#039;,
    &#039;crlf&#039; =&gt; &quot;\r\n&quot;,
    &#039;connection_timeout&#039; =&gt; 10,
    &#039;response_timeout&#039; =&gt; 5,
    &#039;hostname&#039; =&gt; gethostname(),
    &#039;keep_alive&#039; =&gt; false,
    &#039;save_logs&#039; =&gt; false,
];
$mailer = new Mailer($config);
</code></pre>
<p>The <strong>username</strong> and <strong>password</strong> must be set.</p>
<p>The <strong>port</strong> is normally 25, 465 or 587. Check with your postmaster.</p>
<div class="section" id="keep-alive">
<h3>Keep Alive</h3>
<p>If you are going to send more than one message on the same connection, set
<strong>keepalive</strong> to <code>true</code>.<br>This will use the same connection for all submissions.</p>
</div>
<div class="section" id="logs">
<h3>Logs</h3>
<p>If you need to debug communication with the SMTP server, enable the option to
save logs in the configuration by setting <code>save_logs</code> to <code>true</code>. Then it
will be possible to obtain the logs with the <code>Mailer::getLogs</code> method.</p>
<p>It is possible to clear the logs after each submission using the
<code>Mailer::resetLogs</code> method.</p>
</div>
</div>
<div class="section" id="conclusion">
<h2>Conclusion</h2>
<p>Webisters Email Library is an easy-to-use tool for, beginners and experienced, PHP developers.<br>It is perfect for sending emails via SMTP in a very practical way.<br>The more you use it, the more you will learn.</p>
<div class="phpdocumentor-admonition -note ">
            <svg class="phpdocumentor-admonition__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path></svg>
                    <article>
        <p>Did you find something wrong?<br>Be sure to let us know about it with an
<a href="https://github.com/webisters/email/issues">issue</a>.<br>Thank you!</p>
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
