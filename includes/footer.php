<?php
/**
 * Webisters Docs - Footer template
 */
require_once __DIR__ . '/config.php';

// Render prev/next pager just before closing the content column (if applicable).
require_once __DIR__ . '/pager.php';
?>
        </div><!-- /.phpdocumentor-content -->
    </div><!-- /.phpdocumentor-section -->
</main>

<a href="#top" class="phpdocumentor-back-to-top" data-wb-top aria-label="Back to top">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="4"
         stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
        <polyline points="18 15 12 9 6 15"/>
    </svg>
</a>

<footer class="wb-footer" role="contentinfo">
    <div class="wb-footer__inner">
        <div class="wb-footer__brand">
            <a class="wb-brand" href="<?php echo ROOT; ?>index.php">
                <span class="wb-brand__logo" aria-hidden="true"><img src="<?php echo ASSETS; ?>logo.svg" alt="" width="40" height="40"></span>
                <span class="wb-brand__name">Webisters
                    <span class="wb-brand__suffix">docs</span>
                </span>
            </a>
            <p>A modern, lightweight full-stack PHP framework with batteries-included libraries and project templates.</p>
        </div>
        <div>
            <h4>Get Started</h4>
            <ul>
                <li><a href="<?php echo ROOT; ?>guides/webisters/index.php">Webisters CLI</a></li>
                <li><a href="<?php echo ROOT; ?>guides/framework/index.php">Framework</a></li>
                <li><a href="<?php echo ROOT; ?>guides/projects/index.php">Project Templates</a></li>
                <li><a href="<?php echo ROOT; ?>guides/libraries/index.php">Libraries</a></li>
            </ul>
        </div>
        <div>
            <h4>Libraries</h4>
            <ul>
                <li><a href="<?php echo ROOT; ?>guides/libraries/mvc/index.php">MVC</a></li>
                <li><a href="<?php echo ROOT; ?>guides/libraries/routing/index.php">Routing</a></li>
                <li><a href="<?php echo ROOT; ?>guides/libraries/database/index.php">Database</a></li>
                <li><a href="<?php echo ROOT; ?>guides/libraries/http/index.php">HTTP</a></li>
            </ul>
        </div>
        <div>
            <h4>Community</h4>
            <ul>
                <li><a href="<?php echo ROOT; ?>contributors.php">Contributors</a></li>
                <li><a href="https://webisters.com">webisters</a></li>
                <li><a href="https://github.com/webisters">GitHub</a></li>
                <li><a href="https://twitter.com/WebistersFramework">Twitter</a></li>
            </ul>
        </div>
    </div>
    <div class="wb-footer__bottom">
        <span>&copy; <?php echo date('Y'); ?> Webisters &middot; <span class="render-time">Powered by ZAWAT OFFICIALS </span></span>
        <span class="wb-footer__social">
            <a href="https://github.com/webisters" aria-label="GitHub"><i class="fab fa-github"></i></a>
            <a href="https://twitter.com/WebistersFramework" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
            <a href="https://www.youtube.com/@WebistersFramework" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
            <a href="https://www.facebook.com/WebistersFramework" aria-label="Facebook"><i class="fab fa-facebook"></i></a>
        </span>
    </div>
</footer>

<script src="<?php echo ASSETS; ?>layout.js" defer></script>
</body>
</html>
