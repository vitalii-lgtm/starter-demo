# Starter Demo — WordPress theme

This repository is a WordPress theme. The site owner edits it with Claude Code in plain language.
Pushing to the `main` branch deploys the theme to the live site automatically (Hostinger Git auto-deploy).

## How the site is built

- **No build step.** Plain PHP, CSS and JS. Edit files directly; there is no npm, Sass or bundler.
- **Global design** (colors, fonts, font sizes, content width, buttons) lives in `theme.json`.
  Change colors and typography there first, not in CSS.
- **Styles** are in `assets/css/main.css`. Sections use the `sd-` class prefix (`.sd-hero`, `.sd-features`, ...).
  Use theme.json presets in CSS: `var(--wp--preset--color--primary)`, `var(--wp--preset--font-size--large)`.
- **Page sections are block patterns** in `/patterns/*.php` (registered automatically by WordPress).
  Each pattern has a matching `.sd-*` block of styles in `main.css`.
- **Templates:** `header.php`, `footer.php`, `page.php` (all pages, including Home), `index.php` (posts, archives, 404).
- **JS:** `assets/js/main.js` (mobile menu only).

## Important: content vs. code

Page content (texts, images, the order of sections) is stored in the WordPress database, not in this repo.

- Changing CSS or `theme.json` updates every page immediately after deploy.
- Changing a file in `/patterns` does **not** change pages that already use that pattern.
  It only affects new insertions. To change text on an existing page, the owner edits it in the WordPress editor.
- To add a **new section**: create a new pattern file in `/patterns` (same header format as the others, category `starter-demo`)
  and its styles in `main.css`. Then tell the owner to open the page in WordPress, click **+** → **Patterns** → **Site sections**
  and insert it.

## Rules

- Keep it simple: no new dependencies, no build tools, no page builders.
- Use valid core block markup in patterns (`<!-- wp:... -->` comments must match the HTML).
- Escape output in PHP (`esc_html`, `esc_url`, `esc_attr`). Comments in English.
- Mobile first: check that new styles work below 782px.
- Never commit passwords, API keys or `wp-config.php`.
- Before pushing, briefly list what changed. Push only when the owner asks (pushing publishes to the live site).
- After a push, remind the owner to wait about a minute and refresh the site (Ctrl/Cmd + Shift + R).
