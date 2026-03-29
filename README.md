# WebToolsStation

WebToolsStation is a focused Laravel application for a public tools website. It serves SEO-friendly content pages plus browser-based utilities for developer, text, image, and PDF workflows without carrying over the old admin, payment, upload, or database-heavy platform structure.

## What This App Contains

- Public homepage and navigation pages
- Tool detail pages with browser-side utilities
- Guide/article pages for SEO and education
- Contact, privacy policy, terms, sitemap, and robots routes
- Static catalog data stored outside the controller for easier maintenance

## Local Development

From [/Users/tjverse/projects/webtoolsstation](/Users/tjverse/projects/webtoolsstation):

```bash
composer install
php artisan key:generate
php artisan serve
```

The local app runs at [http://127.0.0.1:8000](http://127.0.0.1:8000) when started with the default Laravel server command.

## Testing

```bash
php artisan test
```

The current feature tests cover core public pages, representative tool and guide pages, contact form submission, and 404 handling for unknown slugs.
