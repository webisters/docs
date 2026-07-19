<?php
$pageTitle = 'Webisters Docs';
require_once __DIR__ . '/../../../includes/header.php';
require_once __DIR__ . '/../../../includes/sidebar.php';
?>
<div class="section" id="validation">
<h1>Validation</h1>
<p>Webisters Validation Library.</p>
<ul>
    <li>
            <a href="#installation">Installation</a>
        </li>
    <li>
            <a href="#basic-usage">Basic Usage</a>
        </li>
    <li>
            <a href="#setting-rules">Setting Rules</a>
        </li>
    <li>
            <a href="#setting-labels">Setting Labels</a>
        </li>
    <li>
            <a href="#getting-errors">Getting Errors</a>
        </li>
    <li>
            <a href="#validating">Validating</a>
        </li>
    <li>
            <a href="#working-with-arrays">Working with Arrays</a>
        </li>
    <li>
            <a href="#custom-validator">Custom Validator</a>
        </li>
    <li>
            <a href="#available-rules">Available Rules</a>
        </li>
    <li>
            <a href="#conclusion">Conclusion</a>
        </li>
</ul>
<div class="section" id="installation">
<h2>Installation</h2>
<p>The installation of this library can be done with Composer:</p>
<pre><code class="language- " >composer require Webisters/validation
</code></pre>
</div>
<div class="section" id="basic-usage">
<h2>Basic Usage</h2>
<p>Validation logic typically occurs as follows:</p>
<pre><code class="language-php " >use Framework\Validation\Validation;
$validation = new Validation();
$validation-&gt;setRule(&#039;email&#039;, &#039;required|email&#039;); // static
$validated = $validation-&gt;validate($_POST); // bool
if ($validated) {
    echo &#039;Validated!&#039;;
} else {
    echo &#039;Invalid data:&#039;;
    echo &#039;&lt;ul&gt;&#039;;
    foreach ($validation-&gt;getErrors() as $error) {
        echo &quot;&lt;li&gt;{$error}&lt;/li&gt;&quot;;
    }
    echo &#039;&lt;/ul&gt;&#039;;
}
</code></pre>
<p>First load the Validation class. Then the rules are set and finally validated.
Then a response is shown if the validation was valid or not.</p>
</div>
<div class="section" id="setting-rules">
<h2>Setting Rules</h2>
<p>Rules can be set individually by the <code>setRule</code> method or several at once by
<code>setRules</code>. The first argument is the name of the field and the second is the
rules, which can be defined by string separating them with a pipe or by having
an array of rules as values.</p>
<pre><code class="language-php " >$validation-&gt;setRule(&#039;email&#039;, &#039;required|email&#039;); // static
$validation-&gt;setRule(&#039;firstname&#039;, [&#039;required&#039;, &#039;minLength:2&#039;]); // static
$validation-&gt;setRules([
    &#039;lastname&#039; =&gt; &#039;required|minLength:2|maxLength:32&#039;
]); // static
</code></pre>
</div>
<div class="section" id="setting-labels">
<h2>Setting Labels</h2>
<p>Error messages show field name as default. And often you need to show a custom
label like <strong>First Name</strong> instead of <strong>firstname</strong>.</p>
<p>Labels can be defined individually or by an array.:</p>
<pre><code class="language-php " >$validation-&gt;setLabel(&#039;email&#039;, &#039;E-mail&#039;); // static
$validation-&gt;setLabel(&#039;firstname&#039;, &#039;First Name&#039;); // static
// or
$validation-&gt;setLabels([
    &#039;email&#039; =&gt; &#039;E-mail&#039;,
    &#039;firstname&#039; =&gt; &#039;First Name&#039;,
]); // static
</code></pre>
</div>
<div class="section" id="getting-errors">
<h2>Getting Errors</h2>
<p>Errors can be obtained individually or all at once, as per the example below:</p>
<pre><code class="language-php " >// Email field error message, or null
$error = $validation-&gt;getError(&#039;email&#039;); // string or null
// All errors
$errors = $validation-&gt;getErrors(); // array
</code></pre>
</div>
<div class="section" id="validating">
<h2>Validating</h2>
<p>After defining the rules and labels, the validation of the received data occurs
through the <code>validate</code> method.</p>
<p>If you only need to validate the received fields, you can use the <code>validateOnly</code>
method. Useful for updating only a few fields in the database.</p>
<pre><code class="language-php " >// Validates all fields
$validated = $validation-&gt;validate($data); // bool
// Validates only received fields
$validated = $validation-&gt;validateOnly($data); // bool
</code></pre>
<div class="section" id="validator-check">
<h3>Validator Check</h3>
<p>To validate only one field is possible to use only the Validator:</p>
<pre><code class="language-php " >use Framework\Validation\Validator;
$validated = Validator::alpha(&#039;name&#039;, $data); // bool
</code></pre>
</div>
</div>
<div class="section" id="working-with-arrays">
<h2>Working with Arrays</h2>
<p>Validator uses the <a href="https://github.com/webisters/helpers">ArraySimple</a>
class to extract fields and get the correct data value.</p>
<pre><code class="language-php " >use Framework\Validation\Validation;
$validation = new Validation();
$validation-&gt;setLabel(&#039;user[pass]&#039;, &#039;Password&#039;) // static
           -&gt;setRule(&#039;user[pass]&#039;, &#039;required&#039;); // static
$data = [
    &#039;user&#039; =&gt; [
        &#039;pass&#039; =&gt; &#039;secret&#039;,
    ],
];
$validated = $validation-&gt;validate($data); // true
</code></pre>
</div>
<div class="section" id="custom-validator">
<h2>Custom Validator</h2>
<p>It is possible to create a validator with your custom rules.</p>
<pre><code class="language-php " >use Framework\Validation\Validator;
class CustomValidator extends Validator
{
    public static function phone(string $field, array $data): bool
    {
        $data = static::getData($field, $data);
        if ($data === null) {
            return false;
        }
        return \preg_match(&#039;/^\d{4}-\d{4}$/&#039;, $data);
    }
}
</code></pre>
<p>Do not forget to create the validation language file with your rules.</p>
<p>File <strong>Languages/en/validation.php</strong>:</p>
<pre><code class="language-php " >return [
    &#039;phone&#039; =&gt; &#039;The {field} field requires a valid phone number.&#039;
];
</code></pre>
<p>So, let the Validation know about your customizations:</p>
<pre><code class="language-php " >use CustomValidator;
use Framework\Language\Language;
use Framework\Validation\Validation;
$language = new Language();
$language-&gt;addDirectory(__DIR__ . &#039;/Languages&#039;);
$validation = new Validation([CustomValidator::class], $language);
$validation-&gt;setRule(&#039;telephone&#039;, &#039;required|phone&#039;); // static
$validated = $validation-&gt;validate($_POST); // bool
$errors = $validation-&gt;getErrors(); // array
</code></pre>
</div>
<div class="section" id="available-rules">
<h2>Available Rules</h2>
<p>The available rules are:</p>
<ul>
    <li>
            <a href="#alpha">alpha</a>
        </li>
    <li>
            <a href="#alphanumber">alphaNumber</a>
        </li>
    <li>
            <a href="#array">array</a>
        </li>
    <li>
            <a href="#base64">base64</a>
        </li>
    <li>
            <a href="#between">between</a>
        </li>
    <li>
            <a href="#blank">blank</a>
        </li>
    <li>
            <a href="#bool">bool</a>
        </li>
    <li>
            <a href="#datetime">datetime</a>
        </li>
    <li>
            <a href="#dim">dim</a>
        </li>
    <li>
            <a href="#email">email</a>
        </li>
    <li>
            <a href="https://www.php.net/empty">empty</a>
        </li>
    <li>
            <a href="#equals">equals</a>
        </li>
    <li>
            <a href="#ext">ext</a>
        </li>
    <li>
            <a href="#float">float</a>
        </li>
    <li>
            <a href="#greater">greater</a>
        </li>
    <li>
            <a href="#greaterorequal">greaterOrEqual</a>
        </li>
    <li>
            <a href="#hex">hex</a>
        </li>
    <li>
            <a href="#hexcolor">hexColor</a>
        </li>
    <li>
            <a href="#image">image</a>
        </li>
    <li>
            <a href="#in">in</a>
        </li>
    <li>
            <a href="#int">int</a>
        </li>
    <li>
            <a href="#ip">ip</a>
        </li>
    <li>
            <a href="#isset">isset</a>
        </li>
    <li>
            <a href="#json">json</a>
        </li>
    <li>
            <a href="#latin">latin</a>
        </li>
    <li>
            <a href="#length">length</a>
        </li>
    <li>
            <a href="#less">less</a>
        </li>
    <li>
            <a href="#lessorequal">lessOrEqual</a>
        </li>
    <li>
            <a href="#maxdim">maxDim</a>
        </li>
    <li>
            <a href="#maxlength">maxLength</a>
        </li>
    <li>
            <a href="#maxsize">maxSize</a>
        </li>
    <li>
            <a href="#md5">md5</a>
        </li>
    <li>
            <a href="#mimes">mimes</a>
        </li>
    <li>
            <a href="#mindim">minDim</a>
        </li>
    <li>
            <a href="#minlength">minLength</a>
        </li>
    <li>
            <a href="#notbetween">notBetween</a>
        </li>
    <li>
            <a href="#notequals">notEquals</a>
        </li>
    <li>
            <a href="#notin">notIn</a>
        </li>
    <li>
            <a href="#notregex">notRegex</a>
        </li>
    <li>
            <a href="#null">null</a>
        </li>
    <li>
            <a href="#number">number</a>
        </li>
    <li>
            <a href="#object">object</a>
        </li>
    <li>
            <a href="#optional">optional</a>
        </li>
    <li>
            <a href="#regex">regex</a>
        </li>
    <li>
            <a href="#required">required</a>
        </li>
    <li>
            <a href="#slug">slug</a>
        </li>
    <li>
            <a href="#specialchar">specialChar</a>
        </li>
    <li>
            <a href="#string">string</a>
        </li>
    <li>
            <a href="#timezone">timezone</a>
        </li>
    <li>
            <a href="#uploaded">uploaded</a>
        </li>
    <li>
            <a href="#url">url</a>
        </li>
    <li>
            <a href="#uuid">uuid</a>
        </li>
</ul>
<div class="section" id="alpha">
<h3>alpha</h3>
<p>The field requires only alphabetic characters.</p>
<pre><code class="language- " >alpha
</code></pre>
</div>
<div class="section" id="alphanumber">
<h3>alphaNumber</h3>
<p>The field requires only alphabetic and numeric characters.</p>
<pre><code class="language- " >alphaNumber
</code></pre>
</div>
<div class="section" id="array">
<h3>array</h3>
<p>The field requires an array.</p>
<pre><code class="language- " >array
</code></pre>
</div>
<div class="section" id="base64">
<h3>base64</h3>
<p>The field requires a valid base64 string.</p>
<pre><code class="language- " >base64
</code></pre>
</div>
<div class="section" id="between">
<h3>between</h3>
<p>The field must be between <code>{0}</code> and <code>{1}</code>.</p>
<pre><code class="language-php " >between:$min,$max
</code></pre>
<p>The rule must take two parameters: <code>$min</code> and <code>$max</code>.</p>
<p><code>$min</code> is the minimum value.</p>
<p><code>$max</code> is the maximum value.</p>
</div>
<div class="section" id="blank">
<h3>blank</h3>
<p>If the field has a blank string, the validation passes.</p>
<pre><code class="language- " >blank
</code></pre>
</div>
<div class="section" id="bool">
<h3>bool</h3>
<p>The field requires a boolean value.</p>
<pre><code class="language- " >bool
</code></pre>
</div>
<div class="section" id="datetime">
<h3>datetime</h3>
<p>The field must match a required datetime format.</p>
<pre><code class="language-php " >datetime
datetime:$format
</code></pre>
<p>The rule can take one parameter: <code>$format</code>.</p>
<p><code>$format</code> is the date format.</p>
<p>By default the format is <code>Y-m-d H:i:s</code>.</p>
</div>
<div class="section" id="dim">
<h3>dim</h3>
<p>The field requires an image with the exact dimensions of <code>{0}</code> in width and <code>{1}</code> in height.</p>
<pre><code class="language-php " >dim:$width,$height
</code></pre>
<p>The rule must take two parameters: <code>$width</code> and <code>$height</code>.</p>
<p><code>$width</code> is the exact width of the image.</p>
<p><code>$height</code> is the exact height of the image.</p>
</div>
<div class="section" id="email">
<h3>email</h3>
<p>The field requires a valid email address.</p>
<pre><code class="language- " >email
</code></pre>
</div>
<div class="section" id="empty">
<h3>empty</h3>
<p>If the field is defined and has an <a href="https://www.php.net/empty">empty</a> value,
the validation passes.</p>
<pre><code class="language- " >empty
</code></pre>
</div>
<div class="section" id="equals">
<h3>equals</h3>
<p>The field must be equals the <code>{0}</code> field.</p>
<pre><code class="language-php " >equals:$equalsField
</code></pre>
<p>The rule must take one parameter: <code>$equalsField</code>.</p>
<p><code>$equalsField</code> is the name of the field which must be equal to this one.</p>
</div>
<div class="section" id="ext">
<h3>ext</h3>
<p>The field requires a file with an accepted extension: <code>{args}</code>.</p>
<pre><code class="language-php " >ext:...$allowedExtensions
</code></pre>
<p>The rule can take several parameters: <code>...$allowedExtensions</code>.</p>
<p><code>...$allowedExtensions</code> is a comma-separated list of file extensions.</p>
</div>
<div class="section" id="float">
<h3>float</h3>
<p>The field requires a floating point number.</p>
<pre><code class="language- " >float
</code></pre>
</div>
<div class="section" id="greater">
<h3>greater</h3>
<p>The field must be greater than <code>{0}</code>.</p>
<pre><code class="language-php " >greater:$greaterThan
</code></pre>
<p>The rule must take one parameter: <code>$greaterThan</code>.</p>
<p><code>$greaterThan</code> is the value the field must be greater than this.</p>
</div>
<div class="section" id="greaterorequal">
<h3>greaterOrEqual</h3>
<p>The field must be greater than or equal to <code>{0}</code>.</p>
<pre><code class="language-php " >greaterOrEqual:$greaterThanOrEqualTo
</code></pre>
<p>The rule must take one parameter: <code>$greaterThanOrEqualTo</code>.</p>
<p><code>$greaterThanOrEqualTo</code> is the value that the field has greater than or equal to this.</p>
</div>
<div class="section" id="hex">
<h3>hex</h3>
<p>The field requires a valid hexadecimal string.</p>
<pre><code class="language- " >hex
</code></pre>
</div>
<div class="section" id="hexcolor">
<h3>hexColor</h3>
<p>The field requires a valid hexadecimal color.</p>
<pre><code class="language- " >hexColor
</code></pre>
</div>
<div class="section" id="image">
<h3>image</h3>
<p>The field requires an image.</p>
<pre><code class="language- " >image
</code></pre>
</div>
<div class="section" id="in">
<h3>in</h3>
<p>The field must have one of the listed values.</p>
<pre><code class="language-php " >in:$in,...$others
</code></pre>
<p>The rule must take one parameter: <code>$in</code>. And also <code>...$others</code>.</p>
<p><code>$in</code> is a value required to be in.</p>
<p><code>...$others</code> are other valid values to be in.</p>
</div>
<div class="section" id="int">
<h3>int</h3>
<p>The field requires an integer.</p>
<pre><code class="language- " >int
</code></pre>
</div>
<div class="section" id="ip">
<h3>ip</h3>
<p>The field requires a valid IP address.</p>
<pre><code class="language-php " >ip
ip:$version
</code></pre>
<p>The rule can take one parameter: <code>$version</code>.</p>
<p><code>$version</code> can be <code>0</code> for IPv4 and IPv6. <code>4</code> for IPv4 or <code>6</code> for IPv6.</p>
</div>
<div class="section" id="isset">
<h3>isset</h3>
<p>The field must be sent.</p>
<pre><code class="language- " >isset
</code></pre>
</div>
<div class="section" id="json">
<h3>json</h3>
<p>The field requires a valid JSON string.</p>
<pre><code class="language- " >json
</code></pre>
</div>
<div class="section" id="latin">
<h3>latin</h3>
<p>The field requires only latin characters.</p>
<pre><code class="language- " >latin
</code></pre>
</div>
<div class="section" id="length">
<h3>length</h3>
<p>The field requires exactly <code>{0}</code> characters in length.</p>
<pre><code class="language-php " >length:$length
</code></pre>
<p>The rule can take one parameter: <code>$length</code>.</p>
<p><code>$length</code> is the exact number of characters the field must receive.</p>
</div>
<div class="section" id="less">
<h3>less</h3>
<p>The field must be less than <code>{0}</code>.</p>
<pre><code class="language-php " >less:$lessThan
</code></pre>
<p>The rule can take one parameter: <code>$lessThan</code>.</p>
<p><code>$lessThan</code> is the value that the field has less than this.</p>
</div>
<div class="section" id="lessorequal">
<h3>lessOrEqual</h3>
<p>The field must be less than or equal to <code>{0}</code>.</p>
<pre><code class="language-php " >lessOrEqual:$lessThanOrEqualTo
</code></pre>
<p>The rule can take one parameter: <code>$lessThanOrEqualTo</code>.</p>
<p><code>$lessThanOrEqualTo</code> is the value that the field has less than or equal to this.</p>
</div>
<div class="section" id="maxdim">
<h3>maxDim</h3>
<p>The field requires an image that does not exceed the maximum dimensions of <code>{0}</code> in width and <code>{1}</code> in height.</p>
<pre><code class="language-php " >maxDim:$width,$height
</code></pre>
<p>The rule can take two parameters: <code>$width</code> and <code>$height</code>.</p>
<p><code>$width</code> is the maximum width the image can be.</p>
<p><code>$height</code> is the maximum height the image can be.</p>
</div>
<div class="section" id="maxlength">
<h3>maxLength</h3>
<p>The field requires <code>{0}</code> or less characters in length.</p>
<pre><code class="language-php " >maxLength:$maxLength
</code></pre>
<p>The rule can take one parameter: <code>$maxLength</code>.</p>
<p><code>$maxLength</code> is the maximum amount of characters that the field must receive.</p>
</div>
<div class="section" id="maxsize">
<h3>maxSize</h3>
<p>The field requires a file that does not exceed the maximum size of <code>{0}</code> kilobytes.</p>
<pre><code class="language-php " >maxSize:$kilobytes
</code></pre>
<p>The rule can take one parameter: <code>$kilobytes</code>.</p>
<p><code>$kilobytes</code> is the maximum number of kilobytes that the field file can receive.</p>
</div>
<div class="section" id="md5">
<h3>md5</h3>
<p>The field requires a valid MD5 hash.</p>
<pre><code class="language- " >md5
</code></pre>
</div>
<div class="section" id="mimes">
<h3>mimes</h3>
<p>The field requires a file with an accepted MIME type: <code>{args}</code>.</p>
<pre><code class="language-php " >mimes:...$allowedTypes
</code></pre>
<p>The rule can take many parameters: <code>...$allowedTypes</code>.</p>
<p><code>...$allowedTypes</code> are the MIME types of files the field can receive.</p>
</div>
<div class="section" id="mindim">
<h3>minDim</h3>
<p>The field requires an image having the minimum dimensions of <code>{0}</code> in width and <code>{1}</code> in height.</p>
<pre><code class="language-php " >minDim:$width,$height
</code></pre>
<p>The rule can take two parameters: <code>$width</code> and <code>$height</code>.</p>
<p><code>$width</code> is the minimum width the image can be.</p>
<p><code>$height</code> is the minimum height the image can be.</p>
</div>
<div class="section" id="minlength">
<h3>minLength</h3>
<p>The field requires <code>{0}</code> or more characters in length.</p>
<pre><code class="language-php " >minLength:$minLength
</code></pre>
<p>The rule can take one parameter: <code>$minLength</code>.</p>
<p><code>$minLength</code> is the minimum number of characters the field must receive.</p>
</div>
<div class="section" id="notbetween">
<h3>notBetween</h3>
<p>The field can not be between <code>{0}</code> and <code>{1}</code>.</p>
<pre><code class="language-php " >notBetween:$min,$max
</code></pre>
<p>The rule can take two parameters: <code>$min</code> and <code>$max</code>.</p>
<p><code>$min</code> is the minimum value that the field value must not have.</p>
<p><code>$max</code> is the maximum value the field value must not have.</p>
</div>
<div class="section" id="notequals">
<h3>notEquals</h3>
<p>The field can not be equals the <code>{0}</code> field.</p>
<pre><code class="language-php " >notEquals:$diffField
</code></pre>
<p>The rule can take one parameter: <code>$diffField</code>.</p>
<p><code>$diffField</code> is the name of the field that must have a value different from this one.</p>
</div>
<div class="section" id="notin">
<h3>notIn</h3>
<p>The field must have a value other than those listed.</p>
<pre><code class="language-php " >notIn:$notIn,...$others
</code></pre>
<p>The rule can take one parameter: <code>$notIn</code>. And also <code>...$others</code>.</p>
<p><code>$notIn</code> is the value required not to be in.</p>
<p><code>...$others</code> are other values to not be in.</p>
</div>
<div class="section" id="notregex">
<h3>notRegex</h3>
<p>The field matches a invalid pattern.</p>
<pre><code class="language-php " >notRegex:$pattern
</code></pre>
<p>The rule can take one parameter: <code>$pattern</code>.</p>
<p><code>$pattern</code> is the regular expression that the field value must not match.</p>
</div>
<div class="section" id="null">
<h3>null</h3>
<p>If the field value is null, the validation passes.</p>
<pre><code class="language- " >null
</code></pre>
</div>
<div class="section" id="number">
<h3>number</h3>
<p>The field requires only numeric characters.</p>
<pre><code class="language- " >number
</code></pre>
</div>
<div class="section" id="object">
<h3>object</h3>
<p>The field requires an object.</p>
<pre><code class="language- " >object
</code></pre>
</div>
<div class="section" id="optional">
<h3>optional</h3>
<p>The field is optional. If undefined, validation passes.</p>
<pre><code class="language- " >optional
</code></pre>
</div>
<div class="section" id="regex">
<h3>regex</h3>
<p>The field must match the required pattern.</p>
<pre><code class="language-php " >regex:$pattern
</code></pre>
<p>The rule can take one parameter: <code>$pattern</code>.</p>
<p><code>$pattern</code> is the regular expression that the value of the field must match.</p>
</div>
<div class="section" id="required">
<h3>required</h3>
<p>The field is required.</p>
<pre><code class="language- " >required
</code></pre>
</div>
<div class="section" id="slug">
<h3>slug</h3>
<p>The field requires a valid slug.</p>
<pre><code class="language- " >slug
</code></pre>
</div>
<div class="section" id="specialchar">
<h3>specialChar</h3>
<p>The field requires special characters.</p>
<pre><code class="language-php " >specialChar
specialChar:$quantity
specialChar:$quantity,$characters
</code></pre>
<p>The rule can take two parameters:: <code>$quantity</code> and <code>$characters</code>.</p>
<p><code>$quantity</code> is the number of special characters the field value must have.
By default the value is <code>1</code>.</p>
<p><code>$characters</code> are the characters considered special. By default they are these:
<code>!"#$%&\'()*+,-./:;=<>?@[\]^_`{|}~</code>.</p>
</div>
<div class="section" id="string">
<h3>string</h3>
<p>The field requires a string.</p>
<pre><code class="language- " >string
</code></pre>
</div>
<div class="section" id="timezone">
<h3>timezone</h3>
<p>The field requires a valid timezone.</p>
<pre><code class="language- " >timezone
</code></pre>
</div>
<div class="section" id="uploaded">
<h3>uploaded</h3>
<p>The field requires a file to be uploaded.</p>
<pre><code class="language- " >uploaded
</code></pre>
</div>
<div class="section" id="url">
<h3>url</h3>
<p>The field requires a valid URL address.</p>
<pre><code class="language- " >url
</code></pre>
</div>
<div class="section" id="uuid">
<h3>uuid</h3>
<p>The field requires a valid UUID.</p>
<pre><code class="language- " >uuid
</code></pre>
</div>
</div>
<div class="section" id="conclusion">
<h2>Conclusion</h2>
<p>Webisters Validation Library is an easy-to-use tool for, beginners and experienced, PHP developers.<br>It is perfect for validating data coming from a form or API.<br>The more you use it, the more you will learn.</p>
<div class="phpdocumentor-admonition -note ">
            <svg class="phpdocumentor-admonition__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path></svg>
                    <article>
        <p>Did you find something wrong?<br>Be sure to let us know about it with an
<a href="https://github.com/webisters/validation/issues">issue</a>.<br>Thank you!</p>
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
