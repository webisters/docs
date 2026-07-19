<?php
$pageTitle = 'Webisters Docs';
require_once __DIR__ . '/../../../includes/header.php';
require_once __DIR__ . '/../../../includes/sidebar.php';
?>
<div class="section" id="image">
<h1>Image</h1>
<p>Webisters Image Library.</p>
<ul>
    <li>
            <a href="#installation">Installation</a>
        </li>
    <li>
            <a href="#instantiating-a-new-image">Instantiating a new Image</a>
        </li>
    <li>
            <a href="#getting-image-information">Getting Image Information</a>
        </li>
    <li>
            <a href="#setting-new-properties">Setting new Properties</a>
        </li>
    <li>
            <a href="#image-manipulation">Image Manipulation</a>
        </li>
    <li>
            <a href="#rendering-methods">Rendering Methods</a>
        </li>
    <li>
            <a href="#conclusion">Conclusion</a>
        </li>
</ul>
<div class="section" id="installation">
<h2>Installation</h2>
<p>The installation of this library can be done with Composer:</p>
<pre><code class="language- " >composer require Webisters/image
</code></pre>
</div>
<div class="section" id="instantiating-a-new-image">
<h2>Instantiating a new Image</h2>
<pre><code class="language-php " >&lt;?php
require __DIR__ . &#039;/vendor/autoload.php&#039;;
use Framework\Image\Image;
$filename = __DIR__ . &#039;/tree.png&#039;;
$image = new Image($filename);
</code></pre>
<div class="section" id="detecting-if-a-file-is-acceptable">
<h3>Detecting if a file is Acceptable</h3>
<p>Indicates if a given file has an acceptable (PNG, JPEG or GIF) image type.</p>
<pre><code class="language-php " >$isAcceptable = Image::isAcceptable($filename); // bool
</code></pre>
</div>
</div>
<div class="section" id="getting-image-information">
<h2>Getting Image Information</h2>
<div class="section" id="get-width">
<h3>Get Width</h3>
<p>Gets the image width.</p>
<pre><code class="language-php " >$width = $image-&gt;getWidth(); // int
</code></pre>
</div>
<div class="section" id="get-height">
<h3>Get Height</h3>
<p>Gets the image height.</p>
<pre><code class="language-php " >$height = $image-&gt;getHeight(); // int
</code></pre>
</div>
<div class="section" id="get-resolution">
<h3>Get Resolution</h3>
<p>Gets the image resolution.</p>
<pre><code class="language-php " >$resolution = $image-&gt;getResolution(); // array of integers
</code></pre>
<p>The $resolution value will be an array like the following:</p>
<pre><code class="language-php " >[
    &#039;horizontal&#039; =&gt; 300,
    &#039;vertical&#039; =&gt; 300,
]
</code></pre>
</div>
<div class="section" id="get-quality">
<h3>Get Quality</h3>
<p>Gets the image quality/compression level.</p>
<pre><code class="language-php " >$quality = $image-&gt;getQuality(); // int or null
</code></pre>
<ul>
    <li>
            Returns an integer for PNG and JPEG types or null for GIF.
        </li>
</ul>
</div>
<div class="section" id="get-mime-type">
<h3>Get MIME Type</h3>
<p>Gets the image MIME type.</p>
<pre><code class="language-php " >$mime = $image-&gt;getMime(); // string
</code></pre>
<ul>
    <li>
            Returns a string with the MIME type (e.g. <em>image/png</em>).
        </li>
</ul>
</div>
<div class="section" id="get-extension">
<h3>Get Extension</h3>
<p>Gets a file extension based in the image type.</p>
<pre><code class="language-php " >$extension = $image-&gt;getExtension(); // string or false
</code></pre>
<ul>
    <li>
            Returns a string with the extension (e.g. <em>.png</em>) or false on fail.
        </li>
</ul>
</div>
<div class="section" id="get-gdimage">
<h3>Get GdImage</h3>
<p>Gets the image GD instance.</p>
<pre><code class="language-php " >$gdImage = $image-&gt;getInstance(); // GdImage
</code></pre>
</div>
</div>
<div class="section" id="setting-new-properties">
<h2>Setting new Properties</h2>
<div class="section" id="set-quality">
<h3>Set Quality</h3>
<p>Sets the image quality/compression level.</p>
<pre><code class="language-php " >$image-&gt;setQuality(8); // static
</code></pre>
<ul>
    <li>
            The quality value must not be set on GIF images.
        </li>
    <li>
            PNG images must have a value between 0 and 9.
        </li>
    <li>
            JPEG images must have a value between 0 and 100.
        </li>
</ul>
</div>
<div class="section" id="set-resolution">
<h3>Set Resolution</h3>
<p>Sets the image resolution.</p>
<pre><code class="language-php " >$horizontal = 96;
$vertical = 96;
$image-&gt;setResolution($horizontal, $vertical); // static
</code></pre>
<ul>
    <li>
            The resolution values are in DPI. Default is set 96 to both.
        </li>
</ul>
</div>
<div class="section" id="set-gdimage">
<h3>Set GdImage</h3>
<p>Sets the image GD instance.</p>
<pre><code class="language-php " >$gdImage = imagecreatefrompng($filename);
$image-&gt;setInstance($gdImage); // static
</code></pre>
</div>
</div>
<div class="section" id="image-manipulation">
<h2>Image Manipulation</h2>
<p>The Image class has methods to <a href="#crop">Crop</a>, <a href="#filter">Filter</a>, <a href="#flatten">Flatten</a>, <a href="#flip">Flip</a>, <a href="#rotate">Rotate</a>,
<a href="#scale">Scale</a> and add <a href="#watermark">Watermark</a>.</p>
<p>The image below is the original used for our demonstration.
It is a PNG file, with transparent background.</p>
<img
    src="../guides/libraries/image/img/tree.png"
                alt="Webisters Image - Manipulation"    />
<div class="section" id="crop">
<h3>Crop</h3>
<p>Crops the image.</p>
<pre><code class="language-php " >$width = 200;
$height = 200;
$marginLeft = 100;
$marginTop = 100;
$image-&gt;crop($width, $height, $marginLeft, $marginTop); // static
</code></pre>
<ul>
    <li>
            Argument value sizes are in pixels.
        </li>
    <li>
            If a margin is negative or larger than the canvas, it will add extra space to the image size.
        </li>
</ul>
<p>The cropped image will be like the following:</p>
<img
    src="../guides/libraries/image/img/tree-crop.png"
                alt="Webisters Image - Crop"    />
</div>
<div class="section" id="filter">
<h3>Filter</h3>
<p>Applies a filter to the image.</p>
<pre><code class="language-php " >$image-&gt;filter(IMG_FILTER_NEGATE); // static
</code></pre>
<ul>
    <li>
            The first param is an
        </li>
</ul>
<p><a href="https://www.php.net/manual/en/function.imagefilter.php">image filter</a> constant.
- The second param is an <em>spread</em> of image filter arguments.</p>
<p>The filtered image will be like the following:</p>
<img
    src="../guides/libraries/image/img/tree-filter.png"
                alt="Webisters Image - Filter"    />
</div>
<div class="section" id="flatten">
<h3>Flatten</h3>
<p>Flattens the image.</p>
<p>Replaces transparency with an RGB color.</p>
<pre><code class="language-php " >$red = 128;
$green = 0;
$blue = 128;
$image-&gt;flatten($red, $green, $blue); // static
</code></pre>
<p>The flattened image will be like the following:</p>
<img
    src="../guides/libraries/image/img/tree-flatten.png"
                alt="Webisters Image - Flatten"    />
</div>
<div class="section" id="flip">
<h3>Flip</h3>
<p>Flips the image.</p>
<pre><code class="language-php " >$direction = &#039;horizontal&#039;;
$image-&gt;flip($direction); // static
</code></pre>
<p>The allowed $direction values are:</p>
<ul>
    <li>
            <code>h</code> or <code>horizontal</code> to horizontal flip.
        </li>
    <li>
            <code>v</code> or <code>vertical</code> to vertical flip.
        </li>
    <li>
            <code>b</code> or <code>both</code> to both, horizontal and vertical, flip.
        </li>
</ul>
<p>The flipped image will be like the following:</p>
<img
    src="../guides/libraries/image/img/tree-flip-h.png"
                alt="Webisters Image - Flip"    />
</div>
<div class="section" id="rotate">
<h3>Rotate</h3>
<p>Rotates the image with a given angle.</p>
<pre><code class="language-php " >$angle = 45;
$image-&gt;rotate($angle); // static
</code></pre>
<ul>
    <li>
            The rotation angle is in degrees. Clockwise direction.
        </li>
</ul>
<p>The rotated image will be like the following:</p>
<img
    src="../guides/libraries/image/img/tree-rotate.png"
                alt="Webisters Image - Rotate"    />
</div>
<div class="section" id="scale">
<h3>Scale</h3>
<p>Scales the image.</p>
<pre><code class="language-php " >$width = 80;
$height = -1;
$image-&gt;scale($width, $height); // static
</code></pre>
<ul>
    <li>
            Width and height sizes are in <em>pixels</em>.
        </li>
    <li>
            Height can be <code>-1</code> to be automatically proportional to the width.
        </li>
</ul>
<p>The scaled image will be like the following:</p>
<img
    src="../guides/libraries/image/img/tree-scale.png"
                alt="Webisters Image - Scale"    />
</div>
<div class="section" id="watermark">
<h3>Watermark</h3>
<p>Adds a watermark to the image.</p>
<pre><code class="language-php " >$watermark = new Image($filename);
$watermark-&gt;scale(100);
$horizontalPosition = -10;
$verticalPosition = -10;
$image-&gt;watermark(
    $watermark,
    $horizontalPosition,
    $verticalPosition
); // static
</code></pre>
<ul>
    <li>
            Watermark must be an Image instance.
        </li>
    <li>
            Horizontal position direction is left-to-right when the value is positive, otherwise is right-to-left.
        </li>
    <li>
            Vertical position direction is top-to-bottom when the value is positive, otherwise is bottom-to-top.
        </li>
</ul>
<p>The watermarked image will be like the following:</p>
<img
    src="../guides/libraries/image/img/tree-watermark.png"
                alt="Webisters Image - Watermark"    />
</div>
</div>
<div class="section" id="rendering-methods">
<h2>Rendering Methods</h2>
<div class="section" id="send">
<h3>Send</h3>
<p>When necessary, it is possible to send the Image contents directly to the
PHP Output Buffer, to the User-Agent, to the browser...</p>
<pre><code class="language-php " >$image-&gt;send(); // bool
</code></pre>
</div>
<div class="section" id="save">
<h3>Save</h3>
<p>To save the Image contents in a file, use the <code>save</code> method:</p>
<pre><code class="language-php " >$image-&gt;save($filename); // bool
</code></pre>
<p>The $filename argument is optional.</p>
<p>The default $filename value is <code>null</code>, which indicates to save the contents in
the original file set in the constructor.</p>
</div>
<div class="section" id="render">
<h3>Render</h3>
<p>When need to set the Image contents in a variable, use the <code>render</code> method:</p>
<pre><code class="language-php " >$contents = $image-&gt;render(); // string
</code></pre>
</div>
<div class="section" id="get-data-url">
<h3>Get Data URL</h3>
<p>It is possible embed the Image contents in a document with the
<a href="https://developer.mozilla.org/en-US/docs/Web/HTTP/Basics_of_HTTP/Data_URIs">Data URL</a>
format.</p>
<pre><code class="language-php " >$dataUrl = $image-&gt;getDataUrl(); // string
</code></pre>
<p>The $dataUrl value will be like:</p>
<pre><code class="language- " >data:image/png;base64,...
</code></pre>
<p>Where <em>...</em> is the base64 encoded binary image contents.</p>
</div>
<div class="section" id="json-serialize">
<h3>JSON Serialize</h3>
<p>The Image class implements the
<a href="https://www.php.net/manual/en/class.jsonserializable">JsonSerializable</a> interface.</p>
<p>When an Image object is inside a value to be JSON encoded, it is transformed in
a Data URL string:</p>
<pre><code class="language-php " >$data = [
    &#039;id&#039; =&gt; 1,
    &#039;src&#039; =&gt; $image,
];
$json = json_encode($data);
</code></pre>
<p>The JSON <em>pretty print</em> string will be like this:</p>
<pre><code class="language-json " >{
    &quot;id&quot;: 1,
    &quot;src&quot;: &quot;data:image/png;base64,...&quot;
}
</code></pre>
</div>
<div class="section" id="to-string">
<h3>To String</h3>
<p>The Image class implements the
<a href="https://www.php.net/manual/en/class.stringable.php">Stringable</a> interface.</p>
<p>When an Image object is converted to string, it is transformed to the Data URL
format:</p>
<pre><code class="language-php " >$dataUrl = (string) $image;
</code></pre>
<p>The $dataUrl value will be like:</p>
<pre><code class="language- " >data:image/png;base64,...
</code></pre>
<p><strong>Usage with HTML</strong></p>
<pre><code class="language-php " >&lt;img src=&quot;&lt;?= $image ?&gt;&quot;&gt;
</code></pre>
</div>
</div>
<div class="section" id="conclusion">
<h2>Conclusion</h2>
<p>Webisters Image Library is an, easy to use, tool for PHP, beginners and experienced, developers.<br>It is perfect for manipulation of, simple and full-featured, images.<br>The more you use it, the more you will learn.</p>
<div class="phpdocumentor-admonition -note ">
            <svg class="phpdocumentor-admonition__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path></svg>
                    <article>
        <p>Did you find something wrong?<br>Be sure to let us know about it with an
<a href="https://github.com/webisters/image/issues">issue</a>.<br>Thank you!</p>
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
