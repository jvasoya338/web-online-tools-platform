@extends('site.layout', [
    'seo' => [
        'title' => 'Page Not Found (404) | WebToolsStation',
        'description' => 'The page or utility you requested could not be found. Explore our directory of free online browser tools.',
        'keywords' => '404, page not found, webtoolsstation',
        'canonical' => url('/404'),
        'type' => 'website',
        'image' => url('/images/logo/webtoolsstation-logo.png'),
    ]
])

@section('content')
    <section class="hero">
        <div class="shell hero-grid">
            <div class="hero-card">
                <nav class="breadcrumbs" aria-label="Breadcrumb" style="margin-bottom:16px;">
                    <a href="{{ url('/') }}">Home</a>
                    <span aria-hidden="true">/</span>
                    <span>404 Not Found</span>
                </nav>
                <span class="eyebrow" style="background:#ffebee; color:#c62828;">Error 404</span>
                <h1 style="margin-top:14px;">We couldn't find the page or tool you're looking for.</h1>
                <p class="lede" style="margin-top:16px;">
                    The link you followed may have been updated, renamed, or typed incorrectly. You can explore all free browser tools below or search by category.
                </p>
                <div class="hero-actions" style="margin-top:24px;">
                    <a class="button button-primary" href="{{ url('/') }}">Browse All Tools</a>
                    <a class="button button-secondary" href="{{ url('/contact') }}">Report a Broken Link</a>
                </div>
            </div>
            <div class="hero-side">
                <span class="mini-kicker">Quick Navigation</span>
                <h2 style="margin:16px 0 12px; font-size:1.35rem;">Popular Categories</h2>
                <div class="mini-stack" style="margin-top:16px;">
                    <div class="mini-card">
                        <strong><a href="{{ url('/categories/developer-tools') }}">Developer Tools →</a></strong>
                        <p>JSON Formatter, Base64, JWT Decoder, Regex Tester, SQL Formatter.</p>
                    </div>
                    <div class="mini-card">
                        <strong><a href="{{ url('/categories/text-tools') }}">Text & Content Utilities →</a></strong>
                        <p>Word Counter, Diff Checker, Markdown Preview, Case Converters.</p>
                    </div>
                    <div class="mini-card">
                        <strong><a href="{{ url('/categories/pdf-tools') }}">PDF Utilities →</a></strong>
                        <p>Client-side PDF page counter, text extractor, metadata viewer, rotator.</p>
                    </div>
                    <div class="mini-card">
                        <strong><a href="{{ url('/categories/image-tools') }}">Image Tools →</a></strong>
                        <p>Image Resizer, SVG Viewer, Favicon Generator, Color Picker.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="page-section">
        <div class="shell">
            <div class="section-head">
                <div>
                    <div class="section-kicker">Helpful Destinations</div>
                    <h2>Looking for something specific?</h2>
                </div>
                <p>Check out our complete sitemap or contact support if you need help finding a particular tool.</p>
            </div>
            <div class="page-grid">
                <div class="card click-card">
                    <div class="tool-icon">HM</div>
                    <h3 style="margin-top:12px;">Tool Directory</h3>
                    <p>View all browser-based utilities organized with instant search and category filters.</p>
                    <a class="card-link" href="{{ url('/') }}">Go to Homepage <span aria-hidden="true">→</span></a>
                </div>
                <div class="card click-card">
                    <div class="tool-icon">GD</div>
                    <h3 style="margin-top:12px;">Help Guides</h3>
                    <p>Read in-depth articles on developer workflows, regex debugging, and data formatting.</p>
                    <a class="card-link" href="{{ url('/guides') }}">Read Guides <span aria-hidden="true">→</span></a>
                </div>
                <div class="card click-card">
                    <div class="tool-icon">SM</div>
                    <h3 style="margin-top:12px;">Complete Sitemap</h3>
                    <p>Inspect our dynamic XML index linking to all tools, guides, categories, and policies.</p>
                    <a class="card-link" href="{{ url('/sitemap.xml') }}">View Sitemap <span aria-hidden="true">→</span></a>
                </div>
                <div class="card click-card">
                    <div class="tool-icon">CT</div>
                    <h3 style="margin-top:12px;">Contact Support</h3>
                    <p>Reach out to TJ Verse directly to suggest a new tool or report an issue.</p>
                    <a class="card-link" href="{{ url('/contact') }}">Contact Us <span aria-hidden="true">→</span></a>
                </div>
            </div>
        </div>
    </section>
@endsection