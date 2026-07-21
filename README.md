# WebToolsStation

WebToolsStation is a public Laravel website for free browser-based utility tools and practical technical guides. The platform is built for developers, creators, students, content editors, and everyday web users who need quick tools without sign-up friction.

Live website: [https://webtoolsstation.com](https://webtoolsstation.com)

The project focuses on:

- Fast public pages for online tools
- SEO-friendly tool and guide pages
- Helpful long-form content around real workflows
- Client-side utilities where practical
- Clear trust pages for About, Contact, Privacy, Terms, and Author information
- Sitemap, robots, ads.txt, schema markup, and cookie consent support

## Project Status

This repository contains the production code for the public WebToolsStation website. The app is intentionally simple: most public catalog data is stored in PHP arrays instead of a database, making it easy to review, edit, and deploy.

Current public inventory:

- 30 online tools
- 20 practical guides
- Public homepage, guides index, author page, contact page, privacy policy, terms page
- XML sitemap and robots.txt routes
- Static public assets including `ads.txt`, favicon files, manifest, and author fallback page

## Tech Stack

- PHP 8.3+
- Laravel 13
- Blade templates
- PHPUnit feature tests
- Browser-side JavaScript for tool actions
- Static catalog data in `app/Data`

## Main Features

### Browser Tools

Tool pages are rendered by Laravel and run most utility actions in the browser. This keeps common workflows fast and avoids unnecessary server processing for pasted text, colors, timestamps, hashes, and file checks.

Current tools:

- JSON Formatter
- Base64 Encode Decode
- URL Encode Decode
- JWT Decoder
- Timestamp Converter
- UUID Generator
- SHA 256 Hash Generator
- Regex Tester
- Text Case Converter
- Color Converter
- HEX to RGB Converter
- RGB to HEX Converter
- Favicon Generator
- Word Counter
- Password Generator
- Slug Generator
- HTML Entity Encode Decode
- Text to Binary Converter
- Binary to Text Converter
- JPG to PNG Converter
- PNG to JPG Converter
- CSV to JSON Converter
- URL Parser
- Lorem Ipsum Generator
- Line Sorter
- Text Diff Checker
- PDF Page Counter
- PDF Metadata Viewer
- PDF Text Finder
- PDF Security Checker

### Guide Content

Guides are written to support the tools with practical explanations, common mistakes, examples, FAQ content, and editorial context. They are part of the SEO and user education layer of the platform.

Current guides:

- How to Format JSON Without Errors
- Best Way to Check a JWT Token
- How to Use a Password Generator Well
- What PDF Metadata Can Tell You
- How to Clean Text for URLs and Slugs
- How to Use HEX and RGB Colors Correctly
- When to Use Base64 Encoding and Decoding
- Common Regex Mistakes Beginners Make
- How to Compare Text Differences Quickly
- Best Way to Clean CSV Before Converting to JSON
- How to Read Unix Timestamps in Real Logs
- Why Decoding a JWT Is Not the Same as Verifying It
- How to Check if a Password Is Actually Strong
- What Makes a URL Slug Good for Users and SEO
- How to Tell if Color Conversion Results Are Correct
- Why PDF Text Search Fails on Some Files
- How to Review PDF Metadata Before Sharing a File
- How to Use a Word Counter for Real Editing Work
- How Line Sorting Helps Clean Messy Lists Fast
- When to Use URL Encoding in API and Form Work

## SEO, Trust, and Publisher Readiness

The project includes several production-facing items that help search engines, users, and ad review systems understand the website:

- `public/sitemap.xml` lists public URLs for discovery.
- `public/robots.txt` allows crawling and points to the sitemap.
- `public/ads.txt` supports Google AdSense publisher verification.
- Tool pages include SoftwareApplication structured data.
- Guide pages include Article and FAQ style content.
- Public pages include clear trust content, last-updated style context, and policy information.
- The footer contains compact navigation and professional site context.
- Cookie consent UI is included in the shared layout.
- The author profile is available at `/author.html`.
- The old `/authors/tj-verse` path is handled as a crawler-safe fallback.

Important note: AdSense approval is controlled by Google. This codebase provides the technical and content signals needed for review, but final approval depends on Google's live evaluation, policy checks, indexing state, and account status.

## Repository Structure

```text
app/
  Data/
    authors.php
    guide-depth.php
    guide-metadata.php
    guides.php
    tool-depth.php
    tool-editorial.php
    tool-guide-map.php
    tools.php
  Http/Controllers/Frontend/
    SiteController.php
  Support/
    WebToolsStationCatalog.php

public/
  .htaccess
  ads.txt
  author.html
  authors/tj-verse
  favicon.ico
  index.php
  manifest.json
  robots.txt
  sitemap.xml

resources/views/site/
  article.blade.php
  author.blade.php
  contact.blade.php
  guides.blade.php
  home.blade.php
  layout.blade.php
  page.blade.php
  tool.blade.php

routes/
  web.php

tests/
  Feature/
    ContactFormTest.php
    PublicPagesTest.php
```

## Key Files

- `routes/web.php` defines all public routes.
- `app/Http/Controllers/Frontend/SiteController.php` prepares homepage, tool pages, guide pages, policy pages, sitemap, and robots responses.
- `app/Support/WebToolsStationCatalog.php` loads catalog arrays from `app/Data`.
- `app/Data/tools.php` stores the tool catalog.
- `app/Data/guides.php` stores core guide content.
- `app/Data/tool-editorial.php` and `app/Data/tool-depth.php` add deeper tool page content.
- `app/Data/guide-metadata.php` and `app/Data/guide-depth.php` add author, date, FAQ, and extended guide data.
- `resources/views/site/layout.blade.php` contains the shared HTML layout, header, footer, meta tags, analytics hook, and cookie banner.
- `resources/views/site/tool.blade.php` renders the tool interface, tool content, structured data, FAQ content, and browser-side utility scripts.
- `resources/views/site/article.blade.php` renders guide pages with article metadata, examples, related tools, and FAQ sections.
- `public/sitemap.xml`, `public/robots.txt`, and `public/ads.txt` are public crawler and advertising files.

## Local Development

Clone the repository, install PHP dependencies, and start the Laravel development server.

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan serve
```

The local app will usually run at:

```text
http://127.0.0.1:8000
```

If `.env.example` is not present in your checkout, create a standard Laravel `.env` file with at least:

```env
APP_NAME=WebToolsStation
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://127.0.0.1:8000

LOG_CHANNEL=stack
MAIL_MAILER=log
```

Then run:

```bash
php artisan key:generate
```

## Composer Scripts

The project defines a few useful Composer scripts:

```bash
composer run setup
composer run dev
composer test
```

`composer test` clears cached config and then runs the Laravel test suite.

## Testing

Run the feature tests with:

```bash
composer test
```

or:

```bash
php artisan test
```

Current tests cover:

- Core public pages returning successful responses
- Known tool pages rendering expected catalog content
- Known guide pages rendering expected content
- Contact form validation
- Contact form success behavior
- 404 handling for unknown tool and guide slugs

## Adding a New Tool

1. Add the tool entry to `app/Data/tools.php`.
2. Add deeper editorial content to `app/Data/tool-editorial.php`.
3. Add extra usage and FAQ content to `app/Data/tool-depth.php`.
4. If the tool has a related guide, update `app/Data/tool-guide-map.php`.
5. Add the browser-side interface and action handling in `resources/views/site/tool.blade.php` if a new UI type is needed.
6. Add the URL to `public/sitemap.xml`.
7. Add or update feature tests if the new page changes shared behavior.

## Adding a New Guide

1. Add the guide entry to `app/Data/guides.php`.
2. Add author, dates, FAQ, and related metadata in `app/Data/guide-metadata.php`.
3. Add deeper content sections in `app/Data/guide-depth.php`.
4. Connect related tools in `app/Data/tool-guide-map.php`.
5. Add the URL to `public/sitemap.xml`.
6. Run the test suite.

## Deployment Notes

For a typical shared hosting or VPS deployment:

1. Point the web root to the Laravel `public` directory.
2. Install production Composer dependencies.
3. Set production `.env` values.
4. Run Laravel optimization commands.
5. Confirm public crawler files are accessible.

Example:

```bash
composer install --no-dev --optimize-autoloader
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

Production checks after deploy:

```bash
curl -I https://webtoolsstation.com/
curl -I https://webtoolsstation.com/sitemap.xml
curl -I https://webtoolsstation.com/robots.txt
curl -I https://webtoolsstation.com/ads.txt
curl -I https://webtoolsstation.com/author.html
```

## Public Routes

Main routes:

- `/`
- `/tools/{slug}`
- `/guides`
- `/guides/{slug}`
- `/author.html`
- `/authors/tj-verse`
- `/about`
- `/contact`
- `/privacy-policy`
- `/terms-of-use`
- `/sitemap.xml`
- `/robots.txt`

## Maintenance Checklist

Before pushing production changes:

- Run `composer test`.
- Check that sitemap URLs match the live pages.
- Keep old public URLs redirected or handled safely.
- Avoid publishing thin placeholder pages.
- Keep page titles and meta descriptions unique.
- Keep author, contact, privacy, and terms pages accurate.
- Confirm `robots.txt`, `sitemap.xml`, and `ads.txt` return `200 OK`.
- Keep tool and guide content useful, example-driven, and specific.

## License

This project is open-sourced under the MIT license.
