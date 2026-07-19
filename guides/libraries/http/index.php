<?php
$pageTitle = 'Webisters Docs';
require_once __DIR__ . '/../../../includes/header.php';
require_once __DIR__ . '/../../../includes/sidebar.php';
?>
<div class="section" id="http">
<h1>HTTP</h1>
<p>Webisters HTTP (HyperText Transfer Protocol) Library.</p>
<ul>
    <li>
            <a href="#installation">Installation</a>
        </li>
    <li>
            <a href="#request">Request</a>
        </li>
    <li>
            <a href="#response">Response</a>
        </li>
    <li>
            <a href="#url">URL</a>
        </li>
    <li>
            <a href="#anticsrf">AntiCSRF</a>
        </li>
    <li>
            <a href="#content-security-policy">Content Security Policy</a>
        </li>
</ul>
<div class="section" id="installation">
<h2>Installation</h2>
<p>The installation of this library can be done with Composer:</p>
<pre><code class="language- " >composer require Webisters/http
</code></pre>
</div>
<div class="section" id="request">
<h2>Request</h2>
<p>With the Request class you can get Object Oriented information about the
requested Protocol, URL, Headers and Body.</p>
<p>Create a PHP file (<strong>users.php</strong>) with the following contents:</p>
<pre><code class="language-php " >&lt;?php
require __DIR__ . &#039;/vendor/autoload.php&#039;;
use Framework\HTTP\Request;
$request = new Request();
</code></pre>
<p><strong>Testing:</strong></p>
<p>Add the following lines to test get Request information:</p>
<pre><code class="language-php " >var_dump([
    &#039;method&#039; =&gt; $request-&gt;getMethod(),
    &#039;host&#039; =&gt; $request-&gt;getHeader(&#039;Host&#039;),
    &#039;isSecure&#039; =&gt; $request-&gt;isSecure(),
    &#039;isAjax&#039; =&gt; $request-&gt;isAjax(),
    &#039;url&#039; =&gt; $request-&gt;getUrl()-&gt;toString(),
    &#039;userAgent&#039; =&gt; $request-&gt;getUserAgent()-&gt;toString(),
]);
</code></pre>
<p>Now, lets try a call with Curl:</p>
<pre><code class="language- " >curl http://localhost:8080/users.php?page=1
</code></pre>
<p>Curl will connect to the server with an HTTP Message like this:</p>
<pre><code class="language-http " >GET /users.php?page=1 HTTP/1.1
Host: localhost:8080
User-Agent: curl/7.68.0
Accept: */*
</code></pre>
<p>In the PHP script, the Request class will be instantiated and the array will be set and dumped.</p>
<p>The Curl response body will be like this:</p>
<pre><code class="language- " >array(6) {
  [&quot;method&quot;]=&gt;
  string(3) &quot;GET&quot;
  [&quot;host&quot;]=&gt;
  string(14) &quot;localhost:8080&quot;
  [&quot;isSecure&quot;]=&gt;
  bool(false)
  [&quot;isAjax&quot;]=&gt;
  bool(false)
  [&quot;url&quot;]=&gt;
  string(38) &quot;http://localhost:8080/users.php?page=1&quot;
  [&quot;userAgent&quot;]=&gt;
  string(11) &quot;curl/7.68.0&quot;
}
</code></pre>
<div class="section" id="secure-request">
<h3>Secure Request</h3>
<p>To make sure that the application will only respond to secure requests, you can
force the request to be over HTTPS and also that it is responding only on
allowed hosts.</p>
<div class="section" id="force-https">
<h4>Force HTTPS</h4>
<p>If the request is not secure, we can force a redirect using HTTPS:</p>
<pre><code class="language-php " >$request-&gt;forceHttps(); // void
</code></pre>
<p>This method checks if the request scheme is HTTPS.</p>
<p>And only if is not, it set headers and status to redirect to the HTTPS version of the URL
and terminate the script.</p>
</div>
<div class="section" id="allowed-hosts">
<h4>Allowed Hosts</h4>
<p>If, for some unknown reason, the virtual host is incorrectly configured on the
server, it is possible to prevent unwanted access by whitelisting the allowed hosts.</p>
<p>See this example using nginx:</p>
<pre><code class="language-nginx " >root /var/www/app/public;
server_name domain.tld api.domain.tld other.tld;
</code></pre>
<p>A Company requires only <em>domain.tld</em> and <em>api.domain.tld</em> to work,
but one added the <em>other.tld</em> to the list of servernames.
Nginx will respond to this host accessing the application public folder.</p>
<p>To prevent that, whitelist the allowed hosts. Set it on the Request constructor:</p>
<pre><code class="language-php " >$allowedHosts = [&#039;domain.tld&#039;, &#039;domain.tld:8088&#039;, &#039;api.domain.tld&#039;];
$request = new Request($allowedHosts);
</code></pre>
<p>When a request for an unwanted host is done, an <code>UnexpectedValueException</code>
will thrown, with the message &quot;Invalid Host: other.tld&quot;.</p>
<p>With the throwable is possible, for example, to <em>catch</em> the Exception message
and log it.</p>
<p>If the $allowedHosts argument is not set, the Request will accept any host.</p>
</div>
</div>
<div class="section" id="content-negotiation">
<h3>Content Negotiation</h3>
<p>It is also in the request that information is acquired for
<a href="https://developer.mozilla.org/en-US/docs/Web/HTTP/Content_negotiation">Content Negotiation</a>.<br>Knowing what the HTTP Client accepts, and prioritizes, it is possible to
generate a more complete and featured <a href="#response">Response</a> for each user.</p>
<p>The Request class has methods for negotiating content.</p>
<p>In them it is possible to pass the values available by the application.</p>
<p>Let&#039;s look at an example negotiating the value of the headers, Content-Type and
Content-Language, which can be used in the Response:</p>
<pre><code class="language-php " >$availableTypes = [&#039;text/html&#039;, &#039;application/xml&#039;];
$negotiatedType = $request-&gt;negotiateAccept($availableTypes);
$availableLanguages = [&#039;en&#039;, &#039;es&#039;, &#039;pt-br&#039;];
$negotiatedLanguage = $request-&gt;negotiateLanguage($availableLanguages); // string
</code></pre>
<p>The negotiation takes the <a href="https://developer.mozilla.org/en-US/docs/Glossary/Quality_values">Quality Values</a>
from the header in order of priority and returns the first one in the list of<br>those accepted by the application.<br>If none of the Quality Values are available in the application, the value
returned is the first of the array of available.</p>
<p>Anyway, it is now possible to set the headers negotiated in the Response:</p>
<pre><code class="language-php " >$response-&gt;setHeader(&#039;Content-Type&#039;, $negotiatedType); // static
$response-&gt;setHeader(&#039;Content-Language&#039;, $negotiatedLanguage); // static
</code></pre>
</div>
<div class="section" id="request-with-json">
<h3>Request with JSON</h3>
<p>When working with JSON, has a method to check if the <code>Content-Type</code> is of JSON
type.</p>
<p>And also, a method to get the JSON data from the Request body:</p>
<pre><code class="language-php " >if ($request-&gt;isJson()) {
    $data = $request-&gt;getJson(); // object or false
}
</code></pre>
</div>
<div class="section" id="request-with-uploads">
<h3>Request with Uploads</h3>
<p>When the request is done via the POST method and has <code>multipart/form-data</code> as
Content-Type, it characterizes the upload of files.</p>
<p>The Request class has methods to work with uploaded files.</p>
<p>The <code>getFile</code> method returns an <code>UploadedFile</code> instance or <code>null</code>.</p>
<pre><code class="language-php " >$file = $request-&gt;getFile(&#039;fieldName&#039;); // UploadedFile or null
if ($file &amp;&amp; $file-&gt;isValid()) {
    $filename = &#039;rand0m&#039; . $file-&gt;getExtension();
    $filepath = &#039;/var/www/app/uploads/&#039; . $filename;
    $moved = $file-&gt;move($filepath); // bool
}
</code></pre>
</div>
<div class="section" id="request-with-authorization">
<h3>Request with Authorization</h3>
<p>To identify the type of authorization received, you can use the <code>getAuthType</code>
method. Which will return <code>null</code> if there is none, <code>Basic</code>, <code>Bearer</code> or
<code>Digest</code>:</p>
<pre><code class="language-php " >$request-&gt;getAuthType(); // string or null
</code></pre>
<p>Using the <code>getBasicAuth</code> method, we obtain an array containing two keys,
<code>username</code> and <code>password</code> or null:</p>
<pre><code class="language-php " >$request-&gt;getBasicAuth(); // array or null
</code></pre>
<p>Using the <code>getBearerAuth</code> method, we obtain an array containing one key,
<code>token</code> or null:</p>
<pre><code class="language-php " >$request-&gt;getBearerAuth(); // array or null
</code></pre>
<p>Using the <code>getDigestAuth</code> method, an array with 9 keys is obtained:
<code>username</code>, <code>realm</code>, <code>nonce</code>, <code>uri</code>, <code>response</code>, <code>opaque</code>,
<code>qop</code>, <code>nc</code> and <code>cnonce</code>.</p>
<pre><code class="language-php " >$request-&gt;getDigestAuth(); // array or null
</code></pre>
</div>
<div class="section" id="request-working-with-rest">
<h3>Request working with REST</h3>
<p>The Request class has methods that work very well with REST APIs.</p>
<p>With the <code>getMethod</code> method, we get the HTTP method used:</p>
<pre><code class="language-php " >$request-&gt;getMethod(); // string
</code></pre>
<p>With the <code>getGet</code> method, query parts from the current URL:</p>
<pre><code class="language-php " >$request-&gt;getGet(); // array
</code></pre>
<p>The <code>getPost</code> method get data from POST requests.</p>
<pre><code class="language-php " >$request-&gt;getPost(); // array
</code></pre>
<p>With the <code>getJson</code> method, the request body data is parsed in JSON, being an
object, array or false if there are syntax errors.</p>
<pre><code class="language-php " >$request-&gt;getJson(); // object, array or false
</code></pre>
<p>With the <code>getBody</code> method, the body string of the request is obtained.</p>
<pre><code class="language-php " >$request-&gt;getBody(); // string
</code></pre>
<p>And with the <code>getParsedBody</code> method you get parsed body parts, used when the
HTTP method is neither GET nor POST.</p>
<pre><code class="language-php " >$request-&gt;getParsedBody(); // array
</code></pre>
</div>
<div class="section" id="request-working-with-arrays">
<h3>Request working with Arrays</h3>
<p>The <code>getGet</code>, <code>getPost</code>, <code>getPut</code>, <code>getPatch</code>, <code>getFile</code>,
<code>getParsedBody</code>, <code>getEnv</code> and <code>getServer</code> methods can get data from arrays
via strings with square brackets.</p>
<p>For example, let&#039;s say <code>$_POST</code> equals the array below:</p>
<pre><code class="language-php " >$_POST = [
    &#039;user&#039; =&gt; [
        &#039;name&#039; =&gt; &#039;John Doe&#039;,
        &#039;address&#039; =&gt; [
            &#039;country&#039; =&gt; &#039;Brazil&#039;,
            &#039;city&#039; =&gt; &#039;Sapiranga&#039;,
        ],
    ],
];
</code></pre>
<p>User data can be obtained as follows:</p>
<pre><code class="language-php " >$name = $request-&gt;getPost(&#039;user[name]&#039;); // John Doe
$city = $request-&gt;getPost(&#039;user[address][city]&#039;); // Sapiranga
</code></pre>
</div>
</div>
<div class="section" id="response">
<h2>Response</h2>
<p>The HTTP response send the message status, headers and body to a client.</p>
<p>To use the Response class, just instantiate it:</p>
<pre><code class="language-php " >&lt;?php
require __DIR__ . &#039;/vendor/autoload.php&#039;;
use Framework\HTTP\Request;
use Framework\HTTP\Response;
$request = new Request();
$response = new Response($request);
</code></pre>
<div class="section" id="response-status">
<h3>Response Status</h3>
<p>Response status can be set with the <code>setStatusCode</code>, <code>setStatusReason</code> or
<code>setStatus</code> methods using the status number or the value of a constant of
the <strong>Status</strong> class:</p>
<pre><code class="language-php " >use Framework\HTTP\Status;
$response-&gt;setStatus(401); // static
$response-&gt;setStatus(Status::UNAUTHORIZED); // static
</code></pre>
</div>
<div class="section" id="response-headers">
<h3>Response Headers</h3>
<p>Headers can be set using the <code>setHeader</code> method, using a string in the first
parameter with the name of the header and in the second the value.</p>
<p>Also, you can use constants from the <strong>ResponseHeader</strong> class:</p>
<pre><code class="language-php " >use Framework\HTTP\ResponseHeader;
$response-&gt;setHeader(&#039;Content-Type&#039;, &#039;text/xml&#039;); // static
$response-&gt;setHeader(ResponseHeader::CONTENT_TYPE, &#039;text/xml&#039;); // static
$response-&gt;setContentType(&#039;text/xml&#039;); // static
</code></pre>
<div class="section" id="repeated-header-names">
<h4>Repeated Header Names</h4>
<p>The HTTP response allows some headers to be repeated, such as the
<strong>X-Robot-Tag</strong> header.</p>
<p>See the example below setting the header and appending one more:</p>
<pre><code class="language-php " >$response-&gt;setHeader(&#039;X-Robots-Tag&#039;, &#039;nofollow&#039;)
         -&gt;appendHeader(&#039;X-Robots-Tag&#039;, &#039;googlebot: noindex&#039;)
</code></pre>
<p>Then the response will send multiple headers with the same name:</p>
<pre><code class="language-http " >X-Robots-Tag: nofollow
X-Robots-Tag: googlebot: noindex
</code></pre>
<p>If you need to replace the headers, call the <code>setReplaceHeaders</code> method before
sending the response:</p>
<pre><code class="language-php " >$response-&gt;setReplaceHeaders();
$response-&gt;setHeader(&#039;X-Robots-Tag&#039;, &#039;nofollow&#039;)
         -&gt;appendHeader(&#039;X-Robots-Tag&#039;, &#039;googlebot: noindex&#039;)
</code></pre>
<p>Then the headers will be replaced. And only the last one is sent in the response:</p>
<pre><code class="language-http " >X-Robots-Tag: googlebot: noindex
</code></pre>
</div>
</div>
<div class="section" id="response-body">
<h3>Response Body</h3>
<p>Each time you call the <code>getBody</code> method the buffer will be appended to the
body. This is so that, for example, <code>echo</code> can be used.</p>
<p>Also, you can use the <code>setBody</code> method.</p>
<p>Let&#039;s see an example manipulating the body of the Response:</p>
<pre><code class="language-php " >echo &#039;Oi!&#039;;
$body = $response-&gt;getBody(); // Oi!
$response-&gt;setBody(&#039;Hi!&#039;);
$body = $response-&gt;getBody(); // Hi!
echo &#039; What is your name&#039;;
$body = $response-&gt;getBody(); // Hi! What is your name
$response-&gt;appendBody(&#039;???&#039;);
$body = $response-&gt;getBody(); // Hi! What is your name???
$response-&gt;setBody([&#039;name&#039; =&gt; &#039;A Framework&#039;]);
$body = $response-&gt;getBody(); // name=A+Framework
</code></pre>
</div>
<div class="section" id="response-with-json">
<h3>Response with JSON</h3>
<p>A response containing JSON can be set as:</p>
<pre><code class="language-php " >$users = [
    [
        &#039;id&#039; =&gt; 1,
        &#039;name&#039; =&gt; &#039;Adam&#039;,
    ],
    [
        &#039;id&#039; =&gt; 2,
        &#039;name&#039; =&gt; &#039;Eve&#039;,
    ],
];
$response-&gt;setHeader(&#039;Content-Type&#039;, &#039;application/json&#039;); // static
$response-&gt;setBody(json_encode($users)); // static
</code></pre>
<p>or simply:</p>
<pre><code class="language-php " >$response-&gt;setJson($users); // static
</code></pre>
</div>
<div class="section" id="response-with-html">
<h3>Response with HTML</h3>
<p>HTML, and any other Content-Type, can be set with the
<code>Response::{set,append,prepend}Body()</code> methods.</p>
<pre><code class="language-php " >$contents = &#039;&lt;h1&gt;Hello, Webisters!&lt;/h1&gt;&#039;;
$response-&gt;setBody($contents);
$contents = &#039;&lt;p&gt;I am so happy to meet you.&lt;/p&gt;&#039;;
$response-&gt;appendBody($contents);
</code></pre>
<p>If the Content-Type header is not set, it is automatically set to
<code>text/html; charset=UTF-8</code> when the Response is sent.</p>
</div>
<div class="section" id="response-with-download">
<h3>Response with Download</h3>
<p>To send a file as a download in the response, you can call:</p>
<pre><code class="language-php " >$response-&gt;setDownload(&#039;filepath.pdf&#039;); // static
</code></pre>
<p>With the second parameter set to true the content disposition is <code>inline</code>,
causing the browser to open the file in the window.</p>
<pre><code class="language-php " >$response-&gt;setDownload(&#039;filepath.pdf&#039;, inline: true); // static
</code></pre>
<p>The third parameter makes it possible to continue downloads or start downloading
a video at a certain time.</p>
<pre><code class="language-php " >$response-&gt;setDownload(&#039;filepath.pdf&#039;, true, acceptRanges: true); // static
</code></pre>
</div>
<div class="section" id="sending-the-response">
<h3>Sending the Response</h3>
<p>Now that you&#039;ve seen how to set the Response status, headers and body, it&#039;s time
to see how to send the response to the User-Agent:</p>
<pre><code class="language-php " >$response-&gt;send(); // void
</code></pre>
<p>The <code>send</code> method must be called only once, otherwise it will throw an exception.
Calling the <code>send</code> method is the last step of the HTTP response. After that,
nothing else should come out to the PHP Output Buffer. But, your script can
continue to run normally if necessary.</p>
</div>
<div class="section" id="response-cache">
<h3>Response Cache</h3>
<p>Response has methods to simplify the caching process in the browser.</p>
<p>You can use the <strong>Cache-Control</strong> header to enable the cache for a certain time
or negotiate the response through the <strong>ETag</strong> header:</p>
<div class="section" id="cache-control">
<h4>Cache-Control</h4>
<p>To set the <code>Cache-Control</code> header, you can use the <code>setCache</code> method passing
the number of seconds in the first parameter and in the second pass true for it
to be public or false to be private, which is the default .</p>
<pre><code class="language-php " >$response-&gt;setCache(60); // static
</code></pre>
<p>To not save anything in the cache, use the <code>setNoCache</code> method:</p>
<pre><code class="language-php " >$response-&gt;setNoCache(); // static
</code></pre>
</div>
<div class="section" id="etag">
<h4>ETag</h4>
<p>Through the ETag header it is possible to make the User-Agent cache the contents
of the response body by an identifier. This will cause the response to contain a
304 Not Modified status and the message body to be empty, saving data to be
transferred.</p>
<p>Likewise, it will avoid mid-air collisions on requests other than the GET or
HEAD method:</p>
<pre><code class="language-php " >$response-&gt;setAutoEtag(); // static
</code></pre>
</div>
</div>
<div class="section" id="url">
<h2>URL</h2>
<p>The library has a class for working with URLs. See how it works:</p>
<pre><code class="language-php " >use Framework\HTTP\URL;
$url = new URL(&#039;http://domain.tld:8080/slug?page=1#heading&#039;);
echo $url-&gt;getScheme(); // http
echo $url-&gt;getHost(); // domain.tld:8080
echo $url-&gt;getHostname(); // domain.tld
echo $url-&gt;getPort(); // 8080
$url-&gt;setHostname(&#039;foo-bar.com&#039;);
echo $url-&gt;getHost(); // foo-bar.com:8080
$url-&gt;setPort(80);
echo $url-&gt;getHost(); // foo-bar.com
echo $url-&gt;getPath(); // /slug
echo $url-&gt;getQuery(); // page=1
echo $url-&gt;getFragment(); // heading
</code></pre>
</div>
<div class="section" id="anticsrf">
<h2>AntiCSRF</h2>
<p>The HTTP library has a class to prevent
<a href="https://cheatsheetseries.owasp.org/cheatsheets/Cross-Site_Request_Forgery_Prevention_Cheat_Sheet.php#synchronizer-token-pattern">Cross-Site Request Forgery (CSRF)</a>
using the Synchronizer Token Pattern.</p>
<p>We will see below how AntiCSRF works.</p>
<p>We have a file called <strong>header.php</strong> that will be required by other files
because it loads the autoload file, starts the session and instantiates the
Request and AntiCSRF objects:</p>
<pre><code class="language-php " >&lt;?php
require __DIR__ . &#039;/vendor/autoload.php&#039;;
use Framework\HTTP\AntiCSRF;
use Framework\HTTP\Request;
session_start();
$request = new Request();
$antiCsrf = new AntiCSRF($request);
</code></pre>
<p>In this example, we have a form in the <strong>form.php</strong> file. In which there is a
call to the <code>$antiCsrf</code> variable that returns the field with the token saved
in the session.</p>
<p>The form action takes you to the <strong>save.php</strong> file using the POST method:</p>
<pre><code class="language-php " >&lt;?php
require __DIR__ . &#039;/header.php&#039;;
?&gt;
&lt;form action=&quot;save.php&quot; method=&quot;post&quot;&gt;
    &lt;?= $antiCsrf-&gt;input() ?&gt;
    &lt;label&gt;Name&lt;/label&gt;
    &lt;input name=&quot;name&quot;/&gt;
    &lt;label&gt;Message&lt;/label&gt;
    &lt;textarea name=&quot;message&quot;&gt;&lt;/textarea&gt;
    &lt;button&gt;Send&lt;/button&gt;
&lt;/form&gt;
</code></pre>
<p>Finally, we have the <strong>save.php</strong> file, where the verification of the token
received in the form is performed. If it is invalid, the script will terminate
showing that the request is invalid. If valid, it will show that the form
message can be saved.</p>
<pre><code class="language-php " >&lt;?php
require __DIR__ . &#039;/header.php&#039;;
if (!$request-&gt;isPost() || !$antiCsrf-&gt;verify()) {
    exit (&#039;Request is invalid.&#039;);
}
echo &#039;OK. Anti-CSRF is valid. You can save the message!&#039;;
</code></pre>
<p>Note that in this example we validated only the field with the anti-CSRF token
and did not validate the other fields. Which can be validated using the
<a href="https://github.com/webisters/validation">Validation Library</a>.</p>
</div>
<div class="section" id="content-security-policy">
<h2>Content Security Policy</h2>
<p>The Content-Security-Policy HTTP response header helps you reduce XSS risks on
modern browsers by declaring which dynamic resources are allowed to load.</p>
<p>You can get more information on these pages:</p>
<ul>
    <li>
            <a href="https://content-security-policy.com/">Content Security Policy Reference</a>
        </li>
    <li>
            <a href="https://developer.mozilla.org/en-US/docs/Web/HTTP/CSP">Content Security Policy (CSP)</a>
        </li>
</ul>
<p>CSP classes can be instantiated as in the following example.</p>
<p>Several directives can be passed in object construction or through the
<code>setDirectives</code> method:</p>
<pre><code class="language-php " >use Framework\HTTP\CSP;
$directives = [
    &#039;default-src&#039; =&gt; [
        &#039;self&#039;,
    ],
    &#039;style-src&#039; =&gt; [
        &#039;self&#039;,
        &#039;cdn.foo.tld&#039;,
    ],
];
$csp = new CSP($directives);
$csp-&gt;setDirectives($directives);
</code></pre>
<p>Values for a single directive can be passed with the <code>setDirective</code> method:</p>
<pre><code class="language-php " >$csp-&gt;setDirective(CSP::defaultSrc, [
    &#039;self&#039;,
]);
</code></pre>
<p>Methods that start with <code>set</code> override directive values. To just add new values,
use the <code>addValue</code> method:</p>
<pre><code class="language-php " >$csp-&gt;addValue(CSP::styleSrc, [
    &#039;self&#039;,
    &#039;cdn.foo.tld&#039;,
]);
</code></pre>
<div class="section" id="csp-nonces">
<h3>CSP Nonces</h3>
<p>By default, when the value is <code>self</code>, the contents of the <code>style</code> and
<code>script</code> tags do not execute.</p>
<p>To make them run, it is possible to add the <code>nonce</code> attribute to the tags, which
have a unique value generated at each page load.</p>
<p>Let&#039;s see the following examples:</p>
<p>The dynamic code below written with PHP:</p>
<pre><code class="language-php " >&lt;script&lt;?= $csp-&gt;getScriptNonceAttr() ?&gt;&gt;
    // ...
&lt;/script&gt;
</code></pre>
<p>Will render HTML similar to the following example:</p>
<pre><code class="language-html " >&lt;script nonce=&quot;2aca99c7ee6e0884&quot;&gt;
    // ...
&lt;/script&gt;
</code></pre>
<p>So, it is also possible to add the <code>nonce</code> attribute in the <code>style</code> tag:</p>
<pre><code class="language-php " >&lt;style&lt;?= $csp-&gt;getStyleNonceAttr() ?&gt;&gt;
    // ...
&lt;/style&gt;
</code></pre>
<p>Which renders similar to the example below:</p>
<pre><code class="language-html " >&lt;style nonce=&quot;ccd8147d8a8e275c&quot;&gt;
    // ...
&lt;/style&gt;
</code></pre>
<p>Using the nonce attribute is a very practical way, however, as the nonce values
are unique per request, it is impossible to cache the page in browsers.</p>
</div>
<div class="section" id="csp-hashes">
<h3>CSP Hashes</h3>
<p>To cache the page in browsers, such as by <a href="#etag">ETag</a>, we can use hashes of the
contents of the <code>script</code> and <code>style</code> tags.</p>
<p>Let&#039;s look at the following HTML page:</p>
<pre><code class="language-html " >&lt;!doctype html&gt;
&lt;html lang=&quot;en&quot;&gt;
&lt;head&gt;
    &lt;meta charset=&quot;UTF-8&quot;&gt;
    &lt;title&gt;CSP Test&lt;/title&gt;
    &lt;style&gt;
        body {
            background: cyan;
        }
    &lt;/style&gt;
&lt;/head&gt;
&lt;body&gt;
&lt;script&gt;
    console.log(&#039;Hello!&#039;);
&lt;/script&gt;
&lt;script&gt;
    console.log(&#039;Bye.&#039;);
    // it is a comment
&lt;/script&gt;
&lt;/body&gt;
&lt;/html&gt;
</code></pre>
<p>In order to get all the hashes of the <code>style</code> tags we can pass the content of
the HTML page in the <code>getStyleHashes</code> method and it will return an array with
all the hashes.</p>
<p>And then we can add them in the <code>style-src</code> directive via the <code>addValues</code>
method:</p>
<pre><code class="language-php " >$styleHashes = CSP::getStyleHashes($html);
$csp-&gt;addValue(CSP::styleSrc, $styleHashes);
</code></pre>
<p>The CSP header will look like the following:</p>
<pre><code class="language-http " >Content-Security-Policy: style-src &#039;sha256-CvbCUHrSwRhSRk6O3h7eTuSY9r3oKFudXNGTM/oLBI8=&#039;;
</code></pre>
<p>Similarly, we can get the hashes of the <code>script</code> tags and add them via the
<code>addValues</code> method:</p>
<pre><code class="language-php " >$scriptHashes = CSP::getScriptHashes($html);
$csp-&gt;addValue(CSP::scriptSrc, $scriptHashes);
</code></pre>
<p>The CSP header will look similar to the following example:</p>
<pre><code class="language-http " >Content-Security-Policy: style-src &#039;sha256-CvbCUHrSwRhSRk6O3h7eTuSY9r3oKFudXNGTM/oLBI8=&#039;; script-src &#039;sha256-IfEVrz7Me6SW7O7OHy04/VaUhErMLxjWHdJd8MYN5b0=&#039; &#039;sha256-0TppQmjw9at2nEl3givShY5l6nABmQ84qrh1dRgvMJ0=&#039;;
</code></pre>
</div>
<div class="section" id="csp-in-response">
<h3>CSP in Response</h3>
<p>An object of the CSP class can be set to an object of the Framework\HTTP\Response
class and then it will be sent with the response via the <code>send</code> method:</p>
<pre><code class="language-php " >$csp = new CSP([
    CSP::defaultSrc =&gt; [
        &#039;self&#039;,
    ],
    CSP::styleSrc =&gt; [
        &#039;self&#039;,
        &#039;cdn.foo.tld&#039;,
    ],
    CSP::scriptSrc =&gt; [
        &#039;self&#039;,
        &#039;cdn.foo.tld&#039;,
    ],
]);
$response = new Framework\HTTP\Response;
$response-&gt;setCsp($csp);
</code></pre>
<p>Only if you&#039;re sure the page doesn&#039;t have any malicious scripts, get the hashes
from the response body and add them to the CSP object:</p>
<pre><code class="language-php " >$scriptHashes = CSP::getScriptHashes($response-&gt;getBody());
$csp-&gt;addValue(CSP::scriptSrc, $scriptHashes);
</code></pre>
<p>Then the response can be sent:</p>
<pre><code class="language-php " >$response-&gt;send();
</code></pre>
</div>
<div class="section" id="csp-in-a-meta-tag">
<h3>CSP in a Meta Tag</h3>
<p>Another way to define the Content-Security-Policy is through an HTML meta tag.
See the example below:</p>
<pre><code class="language-php " >&lt;meta http-equiv=&quot;Content-Security-Policy&quot; content=&quot;&lt;?= $csp ?&gt;&quot;&gt;
</code></pre>
</div>
</div>
<div class="section" id="conclusion">
<h2>Conclusion</h2>
<p>Webisters HTTP Library is an easy-to-use tool for, beginners and experienced, PHP developers.<br>It is perfect for building, simple and full-featured, HTTP interactions.<br>The more you use it, the more you will learn.</p>
<div class="phpdocumentor-admonition -note ">
            <svg class="phpdocumentor-admonition__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path></svg>
                    <article>
        <p>Did you find something wrong?<br>Be sure to let us know about it with an
<a href="https://github.com/webisters/http/issues">issue</a>.<br>Thank you!</p>
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
