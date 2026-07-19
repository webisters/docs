<?php
$pageTitle = 'Webisters Docs';
require_once __DIR__ . '/../../../includes/header.php';
require_once __DIR__ . '/../../../includes/sidebar.php';
?>
<div class="section" id="http-client">
<h1>HTTP Client</h1>
<p>Webisters HTTP (HyperText Transfer Protocol) Client Library.</p>
<ul>
    <li>
            <a href="#installation">Installation</a>
        </li>
    <li>
            <a href="#usage">Usage</a>
        </li>
    <li>
            <a href="#request">Request</a>
        </li>
    <li>
            <a href="#client">Client</a>
        </li>
    <li>
            <a href="#response">Response</a>
        </li>
    <li>
            <a href="#conclusion">Conclusion</a>
        </li>
</ul>
<div class="section" id="installation">
<h2>Installation</h2>
<p>The installation of this library can be done with Composer:</p>
<pre><code class="language- " >composer require Webisters/http-client
</code></pre>
</div>
<div class="section" id="usage">
<h2>Usage</h2>
<p>The HTTP Client library is very simple and powerful which can be used as follows:</p>
<pre><code class="language-php " >use Framework\HTTP\Client\Client;
use Framework\HTTP\Client\Request;
$client = new Client();
$request = new Request(&#039;https://domain.tld/profile&#039;);
$request-&gt;setMethod(&#039;POST&#039;); // static
$request-&gt;setBasicAuth(&#039;johndoe&#039;, &#039;abc123&#039;); // static
$request-&gt;setJson([&#039;name&#039; =&gt; &#039;John Doe&#039;]); // static
$response = $client-&gt;run($request); // Framework\HTTP\Client\Response
echo $response-&gt;getStatus();
echo $response-&gt;getBody();
</code></pre>
</div>
<div class="section" id="request">
<h2>Request</h2>
<p>To perform the hypertext transfer it is necessary to send a request message.</p>
<p>The HTTP client needs objects of the Request class to connect to a URL address.</p>
<p>The object can be instantiated by passing the URL in the constructor:</p>
<pre><code class="language-php " >use Framework\HTTP\Client\Request;
$request = new Request(&#039;http://domain.tld&#039;);
</code></pre>
<p>Another way is using the <code>createRequest</code> method of the Client class:</p>
<pre><code class="language-php " >$request = $client-&gt;createRequest(&#039;http://domain.tld&#039;);
</code></pre>
<div class="section" id="request-url">
<h3>Request URL</h3>
<p>The URL can be changed using the <code>setUrl</code> method:</p>
<pre><code class="language-php " >$request-&gt;setUrl(&#039;http://domain.tld&#039;); // static
</code></pre>
<p>Note that when the URL is changed, the Host header will be as well.</p>
</div>
<div class="section" id="request-protocol">
<h3>Request Protocol</h3>
<p>With the Request object instantiated, it is possible to set the desired HTTP
protocol, through a string or a constant of the Protocol class:</p>
<pre><code class="language-php " >use Framework\HTTP\Protocol;
$request-&gt;setProtocol(&#039;HTTP/2&#039;); // static
$request-&gt;setProtocol(Protocol::HTTP_2); // static
</code></pre>
</div>
<div class="section" id="request-method">
<h3>Request Method</h3>
<p>By default, the request method is <code>GET</code>. And, it can be changed through the
<code>setMethod</code> method, passing a string or a constant from the Method class:</p>
<pre><code class="language-php " >use Framework\HTTP\Method;
$request-&gt;setMethod(&#039;post&#039;); // static
$request-&gt;setMethod(Method::POST); // static
</code></pre>
</div>
<div class="section" id="request-headers">
<h3>Request Headers</h3>
<p>Headers can be passed via the header set methods.</p>
<p>Below we see an example using string and a constant of the RequestHeader class:</p>
<pre><code class="language-php " >use Framework\HTTP\RequestHeader;
$request-&gt;setHeader(&#039;Content-Type&#039;, &#039;application/json&#039;); // static
$request-&gt;setHeader(RequestHeader::CONTENT_TYPE, &#039;application/json&#039;); // static
</code></pre>
<p>To set the Content-Type it is possible to use a method for this:</p>
<pre><code class="language-php " >$request-&gt;setContentType(&#039;application/json&#039;); // static
</code></pre>
<div class="section" id="json">
<h4>JSON</h4>
<p>When the request has the Content-Type as <code>application/json</code> and the body is a
JSON string, it is possible to set the header and the body at once using the
<code>setJson</code> method:</p>
<pre><code class="language-php " >$request-&gt;setJson($data); // static
</code></pre>
</div>
<div class="section" id="authorization">
<h4>Authorization</h4>
<p>When working with APIs it is very common that a username and password (or token)
is required to perform authorization.</p>
<p>To set Authorization as <code>Basic</code>, just use the <code>setBasicAuth</code> method:</p>
<pre><code class="language-php " >$username = &#039;johndoe&#039;;
$password = &#039;secr3t&#039;;
$request-&gt;setBasicAuth($username, $password); // static
</code></pre>
<p>To set Authorization as <code>Bearer</code>, just use the <code>setBearerAuth</code> method:</p>
<pre><code class="language-php " >$token = &#039;abc123&#039;;
$request-&gt;setBearerAuth($token); // static
</code></pre>
</div>
<div class="section" id="user-agent">
<h4>User-Agent</h4>
<p>The default User-Agent can be set by calling the <code>setUserAgent</code> method and it
is also possible to pass a name to it:</p>
<pre><code class="language-php " >$request-&gt;setUserAgent(); // static
$request-&gt;setUserAgent(&#039;Webisters HTTP Client&#039;); // static
</code></pre>
</div>
<div class="section" id="cookies">
<h4>Cookies</h4>
<p>Cookies can be set by the <code>setCookie</code> method:</p>
<pre><code class="language-php " >use Framework\HTTP\Cookie;
$cookie = new Cookie(&#039;session_id&#039;, &#039;abc123&#039;);
$request-&gt;setCookie($cookie); // static
</code></pre>
</div>
</div>
<div class="section" id="post-forms">
<h3>Post Forms</h3>
<p>To send data as a form you can set an array with fields and values using the
<code>setPost</code> method:</p>
<pre><code class="language-php " >$request-&gt;setPost([
    &#039;name&#039; =&gt; &#039;John Doe&#039;,
    &#039;email&#039; =&gt; &#039;<a href="../cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="81ebeee9efe5eee4c1e7eeeeafe2eeec">[email&#160;protected]</a>&#039;,
]); // static
</code></pre>
</div>
<div class="section" id="request-with-upload">
<h3>Request with Upload</h3>
<p>You can upload files with the <code>setFiles</code> method.</p>
<p>In it, you set the name of the array keys as field names and the values can be
the path to a file, an instance of <strong>CURLFile</strong> or <strong>CURLStringFile</strong>:</p>
<pre><code class="language-php " >$request-&gt;setFiles([
    &#039;invoices&#039; =&gt; [
        __DIR__ . &#039;/foo/invoice-10001.pdf&#039;,
        __DIR__ . &#039;/foo/invoice-10002.pdf&#039;,
    ],
    &#039;foo&#039; =&gt; new CURLStringFile(&#039;foo&#039;, &#039;foo.txt&#039;, &#039;text/plain&#039;)
]); // static
</code></pre>
</div>
<div class="section" id="request-to-download">
<h3>Request to Download</h3>
<p>When making requests to download files, define a callback in the
<code>setDownloadFunction</code> method, with the first parameter receiving the data
chunk:</p>
<pre><code class="language-php " >$request-&gt;setDownloadFunction(function (string $data) {
    file_put_contents(__DIR__ . &#039;/video.mp4&#039;, $data, FILE_APPEND);
}); // static
</code></pre>
<p>A simpler way is to use the <code>setDownloadFile</code> function, which requires the
file path in the first parameter and allows you to overwrite the file in the
second parameter:</p>
<pre><code class="language-php " >$request-&gt;setDownloadFile(__DIR__ . &#039;/video.mp4&#039;); // static
</code></pre>
<p>Note that when these functions are set the Response body will be set as an empty
string.</p>
</div>
</div>
<div class="section" id="client">
<h2>Client</h2>
<p>The HTTP client is capable of performing synchronous and asynchronous requests.</p>
<p>Let&#039;s see how to instantiate it:</p>
<pre><code class="language-php " >use Framework\HTTP\Client\Client;
$client = new Client();
</code></pre>
<div class="section" id="synchronous-requests">
<h3>Synchronous Requests</h3>
<p>A request can be made by passing a Request instance in the <code>run</code> method, which
will return a <a href="#response">Response</a> or throw an <code>Framework\HTTP\Client\RequestException</code>
if it fails:</p>
<pre><code class="language-php " >$response = $client-&gt;run($request); // Framework\HTTP\Client\Response
</code></pre>
<p>If you call the Request&#039;s <code>setGetInfo</code> method, it will be possible to obtain
information from Curl through the exception&#039;s <code>getInfo</code> method:</p>
<pre><code class="language-php " >$request-&gt;setGetInfo();
try {
    $response = $client-&gt;run($request); // Framework\HTTP\Client\Response
} catch (Framework\HTTP\Client\RequestException $exception) {
    echo $exception-&gt;getMessage(); // string
    var_dump($exception-&gt;getInfo()); // array
}
</code></pre>
</div>
<div class="section" id="asynchronous-requests">
<h3>Asynchronous Requests</h3>
<p>To perform asynchronous requests use the <code>runMulti</code> method, passing an array
with request identifiers as keys and Requests as values.</p>
<p>The <code>runMulti</code> method will return a
<a href="https://www.php.net/manual/en/language.generators.php">Generator</a> with the
request id in the key and a <a href="#response">Response</a>, or <a href="#response-error">Response Error</a>, instance as a value.</p>
<p>Responses will be delivered as requests are finalized:</p>
<pre><code class="language-php " >use Framework\HTTP\Client\Client;
use Framework\HTTP\Client\Request;
use Framework\HTTP\Client\ResponseError;
$client = new Client();
$requests = [
    1 =&gt; new Request(&#039;https://webisters.com&#039;),
    2 =&gt; new Request(&#039;https://webisters.tld&#039;),
];
foreach($client-&gt;runMulti($requests) as $id =&gt; $response) {
    if ($response instanceof ResponseError) {
        echo &quot;Request $id has error: &quot;;
        echo $response-&gt;getError() . &#039;.&lt;br&gt;&#039;;
        continue;
    }
    echo &quot;Request $id responded:&quot;;
    echo &#039;&lt;pre&gt;&#039; . htmlentities((string) $response) . &#039;&lt;/pre&gt;&#039;;
}
</code></pre>
<p>In the <code>run</code> method, the <code>Framework\HTTP\Client\RequestException</code> exception
is thrown if the connection fails. On the other hand, the <code>runMulti</code> method
does not throw exceptions so that requests are not interrupted.</p>
<p>To find out if a request failed, perform a check similar to the code example
above.</p>
</div>
</div>
<div class="section" id="response">
<h2>Response</h2>
<p>After running a Request in the Client, it may return an instance of the Response
class.</p>
<div class="section" id="response-protocol">
<h3>Response Protocol</h3>
<p>With it it is possible to obtain the protocol:</p>
<pre><code class="language-php " >$protocol = $response-&gt;getProtocol(); // string
</code></pre>
</div>
<div class="section" id="response-status">
<h3>Response Status</h3>
<p>Also, you can get the response status:</p>
<pre><code class="language-php " >$response-&gt;getStatusCode(); // int
$response-&gt;getStatusReason(); // string
$response-&gt;getStatus(); // string
</code></pre>
</div>
<div class="section" id="response-headers">
<h3>Response Headers</h3>
<p>It is also possible to get all headers at once:</p>
<pre><code class="language-php " >$headers = $response-&gt;getHeaders(); // array
</code></pre>
<p>Or, get the headers individually:</p>
<pre><code class="language-php " >use Framework\HTTP\ResponseHeader;
$response-&gt;getHeader(&#039;Content-Type&#039;); // string or null
$response-&gt;getHeader(ResponseHeader::CONTENT_TYPE); // string or null
</code></pre>
</div>
<div class="section" id="response-body">
<h3>Response Body</h3>
<p>The message body, when set, can be obtained with the <code>getBody</code> method:</p>
<pre><code class="language-php " >$body = $response-&gt;getBody(); // string
</code></pre>
</div>
<div class="section" id="json-response">
<h3>JSON Response</h3>
<p>Also, you can check if the response content type is JSON and get the JSON data
as an object or array in PHP:</p>
<pre><code class="language-php " >if ($response-&gt;isJson()) {
    $data = $response-&gt;getJson(); // object, array or false
}
</code></pre>
</div>
<div class="section" id="response-links">
<h3>Response Links</h3>
<p>The <code>getLinks</code> method get parsed Link header as array.</p>
<p>To be parsed, links must be in the
<a href="https://docs.github.com/en/rest/guides/using-pagination-in-the-rest-api#using-link-headers">GitHub REST API</a>
format and it is compatible with the
<a href="../pagination/index.php#http-header-link">Pagination HTTP Header Link</a>.</p>
<pre><code class="language-php " >$links = $response-&gt;getLinks(); // array
</code></pre>
</div>
</div>
<div class="section" id="response-error">
<h2>Response Error</h2>
<p>The <code>Framework\HTTP\Client\ResponseError</code> class is used when there is an
error on the connection.</p>
<p>With it is possible to obtain the instance of the Request that ran it with the
<code>getRequest</code> method and the error with the <code>getError</code> method.</p>
<p>If the Request is getting info, it is possible to obtain more information with
the <code>getInfo</code> method.</p>
</div>
<div class="section" id="conclusion">
<h2>Conclusion</h2>
<p>Webisters HTTP Client Library is an easy-to-use tool for, beginners and experienced,
PHP developers.<br>It is perfect for building, simple and full-featured, HTTP interactions.<br>The more you use it, the more you will learn.</p>
<div class="phpdocumentor-admonition -note ">
            <svg class="phpdocumentor-admonition__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path></svg>
                    <article>
        <p>Did you find something wrong?<br>Be sure to let us know about it with an
<a href="https://github.com/webisters/http-client/issues">issue</a>.<br>Thank you!</p>
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
