# AiSign API Documentation — Setup Guide

A self-contained, single-page documentation system built with Laravel Blade + Tailwind CSS.
No database, no backend search, no build step required.

---

## What's Included

| File | Where it goes |
|---|---|
| `documentation.blade.php` | `resources/views/` |
| `partials/documentation-header.blade.php` | `resources/views/partials/` |
| `partials/documentation-sidebar.blade.php` | `resources/views/partials/` |
| `partials/documentation-footer.blade.php` | `resources/views/partials/` |
| `public/js/docs-search.js` | `public/js/` |
| `public/search-index.json` | `public/` |
| `public/images/` _(icon images)_ | `public/images/` |

---

## Step 1 — Copy the Blade Files

```
resources/
└── views/
    ├── documentation.blade.php
    └── partials/
        ├── documentation-header.blade.php
        ├── documentation-sidebar.blade.php
        └── documentation-footer.blade.php
```

> The main `documentation.blade.php` includes the partials via `@include`.
> Do not rename the partials or the `@include` paths will break.

---

## Step 2 — Copy the Public Assets

```
public/
├── search-index.json
├── js/
│   └── docs-search.js
└── images/
    ├── Logomark-POS-GRADIENT.svg
    ├── documentation-search-icon.png
    ├── documentation-guide-icon.png
    ├── documentation-key-icon.png
    ├── documentation-template-icon.png
    ├── documentation-documents-icon.png
    ├── documentation-lock-icon.png
    ├── documentation-logs-icon.png
    ├── documentation-bell-icon.png
    ├── documentation-error-icon.png
    ├── documentation-lifecycle-icon.png
    ├── documentation-upload-icon.png
    ├── documentation-download-icon.png
    └── api-plan-section.png  (used in Quick Start screenshots)
```

> All paths are relative to `public/`. Laravel serves them as-is — no Vite/Mix config needed.

---

## Step 3 — Add the Route

In `routes/web.php`, add a single route pointing to the documentation view:

```php
Route::get('/docs', function () {
    return view('documentation');
})->name('docs');
```

If you want it at a nested URL (e.g. `/api/docs`):

```php
Route::get('/api/docs', function () {
    return view('documentation');
})->name('api.docs');
```

> No controller needed. The entire page is rendered from the Blade view.

---

## Step 4 — Include the Search Script

The search script tag is already present at the bottom of `documentation.blade.php`, just before `</body>`:

```html
<script src="/js/docs-search.js" defer></script>
```

The `defer` attribute is important — it ensures the script runs **after** the inline `<script>` block that defines `navTo()`, which the search relies on.

> **Do not** move this tag above the inline `<script>` block or search navigation will silently fail.

---

## Step 5 — Tailwind CSS

The documentation uses the **Tailwind CDN** loaded directly in the `<head>`:

```html
<script src="https://cdn.tailwindcss.com"></script>
```

No `tailwind.config.js`, no `npm install`, no Vite pipeline required.

If your project already uses a compiled Tailwind setup, you can remove the CDN tag and make sure your `tailwind.config.js` scans the documentation Blade files:

```js
// tailwind.config.js
content: [
  './resources/views/**/*.blade.php',
],
```

> ⚠️ If you switch to compiled Tailwind, **do not use** arbitrary values like `w-[34px]` or `bg-[#4080E0]`
> without enabling the JIT engine (`mode: 'jit'`), which is the default in Tailwind v3+.

---

## Step 6 — Verify the Search Index

Open your browser and visit:

```
https://your-app.test/search-index.json
```

You should see the raw JSON array. If you get a 404:

- Confirm `search-index.json` is in the `public/` folder (not `resources/`)
- Check that your web server serves files from `public/` (standard Laravel setup)

---

## How the Search Works

The search is fully **client-side** — no Laravel controller, no database query.

```
User types → Fuse.js loads (CDN, one-time) → fetches /search-index.json → fuzzy matches → shows dropdown
```

- **Fuse.js** is loaded lazily from jsDelivr on the first keystroke
- The index is fetched once and cached in memory for the session
- Results rank by: Title (60%) → Content (30%) → Section (10%)
- Keyboard: `↑↓` navigate · `↵` select · `Esc` close · `⌘K` / `Ctrl+K` open from anywhere

### Updating the Search Index

When you add or edit a documentation page, update `public/search-index.json` to match.
Each entry follows this shape:

```json
{
  "title":   "Upload Document",
  "section": "Documents",
  "content": "Plain text description of the page — no HTML tags.",
  "navKey":  "documents/upload"
}
```

| Field | Purpose |
|---|---|
| `title` | Page title shown in results |
| `section` | Section badge shown next to the title |
| `content` | Searchable body text (keep it plain, no HTML) |
| `navKey` | Must exactly match the key used in `PAGES` and `NAV_TREE` in the blade file |

---

## How Navigation Works

The documentation is a **single-page application** rendered entirely in JavaScript.

- `NAV_TREE` defines the sidebar sections and their pages
- `PAGES` holds the content blocks for every page
- `navigate(key)` / `navTo(key)` switch the visible page without a full reload

To **add a new page**:

1. Add an entry to the `pages` array inside the correct `NAV_TREE` section:
```js
{ id: 27, title: 'My New Page', slug: 'my-new-page', section: 'documents' }
```

2. Add the page content to the `PAGES` object:
```js
'documents/my-new-page': {
  title: 'My New Page',
  meta:  'Short description shown under the title.',
  blocks: [
    { type: 'text', data: { content: 'Your content here.' } },
  ]
},
```

3. Add a matching entry to `public/search-index.json`.

---

## External Dependencies (CDN)

The documentation loads three libraries from CDN — no npm install needed:

| Library | Version | Used for |
|---|---|---|
| Tailwind CSS | latest | All styling |
| Prism.js | 1.29.0 | Syntax highlighting in code blocks |
| Fuse.js | 7.0.0 | Client-side fuzzy search |

All three load from public CDNs. For a production environment with strict CSP headers,
download them locally and update the `<script src>` paths accordingly.

---

## Folder Structure — Final Overview

```
your-laravel-app/
├── public/
│   ├── search-index.json
│   ├── js/
│   │   └── docs-search.js
│   └── images/
│       ├── Logomark-POS-GRADIENT.svg
│       └── documentation-*.png  (all icon images)
└── resources/
    └── views/
        ├── documentation.blade.php
        └── partials/
            ├── documentation-header.blade.php
            ├── documentation-sidebar.blade.php
            └── documentation-footer.blade.php
```

---

## Quick Checklist

- [ ] Blade files copied to `resources/views/` and `resources/views/partials/`
- [ ] `public/js/docs-search.js` in place
- [ ] `public/search-index.json` in place and accessible at `/search-index.json`
- [ ] All icon images copied to `public/images/`
- [ ] Route added in `routes/web.php`
- [ ] Visiting `/docs` renders the page without errors
- [ ] Typing in the search bar shows results (not stuck on "Loading index…")
- [ ] Clicking a search result navigates to the correct page

---
