<?php
$pageTitle = 'Contributors · Webisters Docs';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/sidebar.php';
?>
<section class="wb-hero" style="padding: 3rem 0 2.25rem;">
    <span class="wb-hero__eyebrow">Contributors</span>
    <h1>The people behind Webisters.</h1>
    <p class="wb-hero__lead">
        Webisters is built and maintained by a small group of engineers who
        believe PHP should feel fast, modular, and modern. Meet the people
        shipping it.
    </p>
</section>

<div class="wb-section-head">
    <h2>Top contributor</h2>
</div>

<div class="wb-cards" style="grid-template-columns: minmax(0, 1fr);">
    <div class="wb-card" style="cursor: default; padding: 1.75rem;">
        <div style="display: flex; gap: 1.25rem; align-items: flex-start; flex-wrap: wrap;">
            <img
                src="https://github.com/HafizMMoaz.png?size=160"
                alt="Hafiz Muhammad Moaz"
                width="96"
                height="96"
                loading="lazy"
                style="width:96px;height:96px;border-radius:999px;border:1px solid var(--border);flex-shrink:0;">
            <div style="flex: 1 1 280px; min-width: 0;">
                <h3 class="wb-card__title" style="margin: 0 0 .25rem;">Hafiz Muhammad Moaz</h3>
                <p style="margin: 0 0 .75rem; color: var(--muted); font-size: .95rem;">
                    CEO, Webisters &middot; CTO, Zawat Officials
                </p>
                <p style="margin: 0 0 1rem; color: var(--text-soft);">
                    Full-stack engineer working across every tech stack &mdash;
                    PHP, Node, Python, modern JS frameworks, mobile, and
                    infrastructure. Currently building AI tools, SaaS products,
                    and custom ERPs. Top contributor to Webisters and the
                    primary maintainer of its libraries and project templates.
                </p>
                <div style="display: flex; gap: .5rem; flex-wrap: wrap;">
                    <a class="wb-btn" href="https://github.com/HafizMMoaz" target="_blank" rel="noopener">
                        <i class="fab fa-github" aria-hidden="true"></i>
                        GitHub profile
                    </a>
                    <a class="wb-btn -ghost" href="https://zawatofficials.pk" target="_blank" rel="noopener">
                        Zawat Officials
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="wb-section-head">
    <h2>Affiliation</h2>
</div>
<p>
    The Webisters project is affiliated with
    <strong><a href="https://zawatofficials.pk" target="_blank" rel="noopener">Zawat Officials</a></strong>
    &mdash; a software studio building AI tools, SaaS platforms, and custom
    ERPs for clients worldwide. Zawat sponsors development time, hosting, and
    ongoing maintenance of the framework.
</p>

<div class="wb-section-head">
    <h2>Want to contribute?</h2>
</div>
<p>
    Webisters is open source and contributions are welcome &mdash; whether
    that's a bug report, a documentation tweak, or a new library.
</p>
<ul>
    <li><strong>Found a bug?</strong> Open an issue at
        <a href="https://github.com/webisters" target="_blank" rel="noopener">github.com/webisters</a>
        on the relevant package.</li>
    <li><strong>Have an idea?</strong> Start a discussion on the package's GitHub repository.</li>
    <li><strong>Want to write a library?</strong> Fork a template, implement
        your feature, and open a pull request.</li>
</ul>
<p>
    If you'd like your name listed here, send a PR to the documentation or
    drop us a note &mdash; we're happy to credit everyone who ships meaningful work.
</p>

<?php
require_once __DIR__ . '/includes/footer.php';
?>
