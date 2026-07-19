/**
 * Webisters Docs - Front-end layout script
 * Handles:
 *   - Mobile sidebar toggle
 *   - Collapsible sidebar groups
 *   - Client-side search across sidebar links + headings on the current page
 *   - Copy-to-clipboard buttons on every <pre> code block
 *   - Back-to-top visibility
 *   - Rendered-at timestamp
 *   - Keyboard shortcuts (⌘K / Ctrl+K to focus search, Esc to clear)
 */
(function () {
    'use strict';

    const body = document.body;
    if (!body) return;

    const root = body.dataset.webistersRoot || './';

    /* ---------- Mobile menu ---------- */
    const menuBtn = document.querySelector('[data-wb-menu]');
    if (menuBtn) {
        menuBtn.addEventListener('click', function () {
            body.classList.toggle('wb-nav-open');
        });
        // Close on outside tap
        document.addEventListener('click', function (e) {
            if (!body.classList.contains('wb-nav-open')) return;
            const sidebar = document.querySelector('.phpdocumentor-sidebar');
            if (!sidebar) return;
            if (sidebar.contains(e.target) || menuBtn.contains(e.target)) return;
            body.classList.remove('wb-nav-open');
        });
    }

    /* ---------- Collapsible sidebar groups ---------- */
    document.querySelectorAll('[data-wb-group-toggle]').forEach(function (head) {
        head.addEventListener('click', function () {
            const group = head.closest('[data-wb-group]');
            if (group) group.classList.toggle('is-open');
        });
    });

    /* ---------- Client-side search ---------- */
    const searchEl = document.querySelector('[data-wb-search]');
    const searchInput = document.querySelector('[data-wb-search-input]');
    const searchResults = document.querySelector('[data-wb-search-results]');

    function buildIndex() {
        const index = [];
        // 1) Sidebar links (categories of "Guides" and "Packages")
        document.querySelectorAll('.phpdocumentor-sidebar a').forEach(function (a) {
            const label = (a.textContent || '').trim();
            if (!label) return;
            // Determine its category from nearest .phpdocumentor-sidebar__category
            const cat = a.closest('.phpdocumentor-sidebar__category');
            let catLabel = '';
            if (cat) {
                const head = cat.querySelector('.phpdocumentor-sidebar__category-header');
                if (head) catLabel = head.textContent.trim();
            }
            // Try to grab the wb-group head for subcategory context
            const group = a.closest('[data-wb-group]');
            if (group) {
                const head = group.querySelector('.wb-group__head span');
                if (head) catLabel += ' › ' + head.textContent.trim();
            }
            index.push({
                label: label,
                href: a.getAttribute('href'),
                section: catLabel || 'Docs',
                hay: (catLabel + ' ' + label).toLowerCase()
            });
        });
        // 2) Headings on the current page
        document.querySelectorAll('.phpdocumentor-content h1, .phpdocumentor-content h2, .phpdocumentor-content h3').forEach(function (h) {
            const label = (h.textContent || '').trim();
            if (!label) return;
            const id = h.id || (h.closest('[id]') ? h.closest('[id]').id : '');
            const href = id ? ('#' + id) : '#top';
            index.push({
                label: label,
                href: href,
                section: 'On this page',
                hay: ('on this page ' + label).toLowerCase()
            });
        });
        return index;
    }

    let SEARCH_INDEX = null;
    let activeIdx = -1;

    function ensureIndex() {
        if (!SEARCH_INDEX) SEARCH_INDEX = buildIndex();
        return SEARCH_INDEX;
    }

    function renderResults(q) {
        if (!searchResults) return;
        const query = q.trim().toLowerCase();
        if (!query) {
            searchResults.classList.remove('is-open');
            searchResults.innerHTML = '';
            return;
        }
        const items = ensureIndex();
        const matches = [];
        for (let i = 0; i < items.length && matches.length < 20; i++) {
            if (items[i].hay.indexOf(query) !== -1) matches.push(items[i]);
        }
        if (!matches.length) {
            searchResults.innerHTML = '<div class="wb-search__empty">No results for &ldquo;' + escapeHtml(q) + '&rdquo;</div>';
            searchResults.classList.add('is-open');
            return;
        }
        searchResults.innerHTML = matches.map(function (m, i) {
            return '<a class="wb-search__result' + (i === 0 ? ' is-active' : '') + '" href="' + m.href + '">' +
                escapeHtml(m.label) +
                '<small>' + escapeHtml(m.section) + '</small></a>';
        }).join('');
        activeIdx = 0;
        searchResults.classList.add('is-open');
    }

    function escapeHtml(s) {
        return String(s).replace(/[&<>"']/g, function (c) {
            return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c];
        });
    }

    if (searchInput && searchResults) {
        searchInput.addEventListener('input', function (e) {
            renderResults(e.target.value);
        });
        searchInput.addEventListener('focus', function () {
            if (searchInput.value.trim()) renderResults(searchInput.value);
        });
        searchInput.addEventListener('keydown', function (e) {
            const results = searchResults.querySelectorAll('.wb-search__result');
            if (e.key === 'ArrowDown') {
                e.preventDefault();
                if (!results.length) return;
                activeIdx = (activeIdx + 1) % results.length;
                updateActive(results);
            } else if (e.key === 'ArrowUp') {
                e.preventDefault();
                if (!results.length) return;
                activeIdx = (activeIdx - 1 + results.length) % results.length;
                updateActive(results);
            } else if (e.key === 'Enter') {
                if (results[activeIdx]) {
                    e.preventDefault();
                    window.location.href = results[activeIdx].getAttribute('href');
                }
            } else if (e.key === 'Escape') {
                searchInput.value = '';
                searchResults.classList.remove('is-open');
                searchInput.blur();
            }
        });
        function updateActive(results) {
            results.forEach(function (r, i) {
                r.classList.toggle('is-active', i === activeIdx);
                if (i === activeIdx) r.scrollIntoView({ block: 'nearest' });
            });
        }
        document.addEventListener('click', function (e) {
            if (!searchEl.contains(e.target)) searchResults.classList.remove('is-open');
        });
    }

    /* ⌘K / Ctrl+K keyboard shortcut */
    document.addEventListener('keydown', function (e) {
        if ((e.metaKey || e.ctrlKey) && e.key.toLowerCase() === 'k') {
            if (searchInput) {
                e.preventDefault();
                searchInput.focus();
                searchInput.select();
            }
        }
    });

    /* ---------- Copy-to-clipboard for code blocks ---------- */
    document.querySelectorAll('pre').forEach(function (pre) {
        // Skip if already has a button (idempotent)
        if (pre.querySelector('.code-copy')) return;
        const btn = document.createElement('button');
        btn.type = 'button';
        btn.className = 'code-copy';
        btn.textContent = 'Copy';
        btn.setAttribute('aria-label', 'Copy code to clipboard');
        pre.appendChild(btn);
        btn.addEventListener('click', function () {
            const code = pre.querySelector('code');
            const text = (code ? code.innerText : pre.innerText).replace(/\s*Copy\s*$/, '');
            const finalize = function (ok) {
                btn.textContent = ok ? 'Copied!' : 'Failed';
                btn.classList.toggle('is-copied', !!ok);
                setTimeout(function () {
                    btn.textContent = 'Copy';
                    btn.classList.remove('is-copied');
                }, 1500);
            };
            if (navigator.clipboard && navigator.clipboard.writeText) {
                navigator.clipboard.writeText(text).then(function () { finalize(true); }, function () { finalize(false); });
            } else {
                try {
                    const ta = document.createElement('textarea');
                    ta.value = text; document.body.appendChild(ta); ta.select();
                    document.execCommand('copy'); document.body.removeChild(ta); finalize(true);
                } catch (e) { finalize(false); }
            }
        });
    });

    /* ---------- Back-to-top visibility ---------- */
    const topBtn = document.querySelector('[data-wb-top]');
    if (topBtn) {
        const onScroll = function () {
            if (window.scrollY > 400) topBtn.classList.add('is-visible');
            else topBtn.classList.remove('is-visible');
        };
        window.addEventListener('scroll', onScroll, { passive: true });
        onScroll();
        topBtn.addEventListener('click', function (e) {
            e.preventDefault();
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    }

    /* ---------- Rendered-at timestamp ---------- */
    const renderedAt = document.querySelector('[data-wb-rendered-at]');
    if (renderedAt) {
        renderedAt.textContent = new Date().toLocaleString(undefined, {
            year: 'numeric', month: 'short', day: 'numeric',
            hour: '2-digit', minute: '2-digit'
        });
    }

    /* ---------- Add IDs to headings missing them (for hash links) ---------- */
    document.querySelectorAll('.phpdocumentor-content h1, .phpdocumentor-content h2, .phpdocumentor-content h3, .phpdocumentor-content h4').forEach(function (h) {
        if (h.id) return;
        const slug = (h.textContent || '').toLowerCase().trim().replace(/[^a-z0-9]+/g, '-').replace(/^-+|-+$/g, '');
        if (slug) h.id = slug;
    });
}());
