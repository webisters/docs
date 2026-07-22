# Contributing to Webisters Docs

Thanks for taking the time to contribute. This repository holds the **source** of
https://docs.webisters.com. The site is authored in PHP and rendered to static HTML,
because GitHub Pages cannot run PHP: `main` holds the source, the built HTML is
published to the `gh-pages` branch.

By participating you agree to follow our [Code of Conduct](CODE_OF_CONDUCT.md).

## Ways to contribute

- Fix a typo, broken link, or unclear paragraph
- Write or expand a guide under `guides/`
- Improve a package landing page under `packages/`
- Improve the shared templates in `includes/` or the assets in `assets/`

Before starting work on an existing issue, comment on it and wait to be assigned so
two people do not do the same work.

## Reporting security issues

Do **not** open a public issue for security vulnerabilities. Follow
[SECURITY.md](SECURITY.md) and email `thewebisters@gmail.com` instead.

## Requirements

- PHP >= 8.2 (only the built-in server is needed, there is no Composer manifest)
- The full monorepo checked out if you are touching class-reference pages:
  `includes/class-page.php` reflects the real `Framework\*` classes from
  `../../libraries/<slug>/src`, so this folder must sit next to `../../libraries`

## Layout

- `index.php`, `contributors.php` - top-level pages
- `guides/` - hand-written guides (framework, projects, libraries)
- `packages/` - per-package landing pages
- `includes/` - shared templates (`header.php`, `sidebar.php`, `footer.php`, `config.php`)
- `assets/` - `override.css`, `layout.js` (client-side search), `logo.svg`
- `router.php` - router for the PHP built-in server, development only
- `build-static.php` - crawls the dev server and mirrors every page into `_site/`

## Preview locally

```bash
php -S 127.0.0.1:9090 router.php
# open http://127.0.0.1:9090/
```

Every page is a plain PHP file that includes the shared header, sidebar, and footer.
Add a new guide by creating the PHP file under `guides/` and linking it from
`includes/sidebar.php` so it appears in navigation and in the client-side search index.

## Build the static site

The build crawls the running dev server and mirrors each rendered page to `_site/`:

```bash
# 1. serve, in one terminal
php -S 127.0.0.1:9090 router.php

# 2. crawl into _site/, in another terminal
BASE=http://127.0.0.1:9090 OUT=./_site php build-static.php
```

Check `_site/` in a browser before opening a pull request. Do **not** commit `_site/`;
it is build output.

## Deploy

Deployment is automated. Pushing to `main` triggers the GitHub Actions workflow in
`.github/workflows/`, which runs the same serve-and-crawl build and publishes `_site/`
to the `gh-pages` branch, which GitHub Pages serves at https://docs.webisters.com.
Never edit the `gh-pages` branch by hand; it is overwritten on every deploy.

## Making a change

1. Fork the repository and create a branch off `main`:
   `git checkout -b docs/short-description`
2. Keep pull requests scoped to one topic.
3. Preview locally, and run the static build if you touched templates or the build script.
4. Use short, imperative commit subjects under 72 characters, for example
   `guides: clarify the boot order in the framework guide`.
5. Link the issue your pull request closes (`Closes #123`).

## Style

- British or American spelling is fine, just be consistent within a page.
- Prefer short sentences and runnable examples over prose.
- Code samples must be copy-pasteable and actually work against the current release.
- Reference classes by their full namespace on first mention, for example
  `Framework\Routing\RouteCollection`.

## Licence

Contributions are accepted under the MIT licence used by this repository.
