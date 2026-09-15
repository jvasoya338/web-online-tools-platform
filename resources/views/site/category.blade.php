@extends('site.layout')

@section('content')
    <section class="hero">
        <div class="shell hero-grid">
            <div class="hero-card">
                <nav class="breadcrumbs" aria-label="Breadcrumb" style="margin-bottom:16px;">
                    <a href="{{ url('/') }}">Home</a>
                    <span aria-hidden="true">/</span>
                    <a href="{{ url('/#categories') }}">Categories</a>
                    <span aria-hidden="true">/</span>
                    <span>{{ $category['name'] }}</span>
                </nav>
                <div style="display:flex; align-items:center; gap:12px; margin-bottom:12px;">
                    <div class="tool-icon" style="font-size:1.8rem; width:48px; height:48px;">{{ $category['icon'] }}</div>
                    <span class="eyebrow" style="margin-bottom:0;">{{ $category['name'] }}</span>
                </div>
                <h1>{{ $category['name'] }}</h1>
                <p class="lede" style="font-size:1.15rem; font-weight:600; color:var(--brand-dark); margin-top:12px;">
                    {{ $category['tagline'] }}
                </p>
                <p class="lede" style="max-width:760px; margin-top:10px;">
                    {{ $category['description'] }}
                </p>
                <div class="hero-actions" style="margin-top:24px;">
                    <a class="button button-primary" href="#category-tools">Browse {{ $toolCount }} Tools</a>
                    <a class="button button-secondary" href="{{ url('/') }}">All Tools</a>
                </div>
            </div>
            <div class="hero-side">
                <span class="mini-kicker">Core Workflows</span>
                <h2 style="margin:16px 0 12px; font-size:1.35rem;">Popular use cases in {{ $category['name'] }}</h2>
                <div class="mini-stack" style="margin-top:16px;">
                    @foreach ($category['key_workflows'] as $wf)
                        <div class="mini-card">
                            <p style="margin:0;">{{ $wf }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <section class="page-section" id="category-tools">
        <div class="shell">
            <div class="section-head">
                <div>
                    <div class="section-kicker">{{ $category['name'] }} Directory</div>
                    <h2>All utilities in this category ({{ $toolCount }})</h2>
                </div>
                <p>Fast, client-side browser utilities designed for immediate use without registration, subscriptions, or server storage.</p>
            </div>
            <div class="tool-grid">
                @foreach ($tools as $tool)
                    <article class="card click-card">
                        <div class="tool-icon">{{ $tool['icon'] }}</div>
                        <div class="tool-badge">{{ $tool['category'] }}</div>
                        <h3 style="margin-top:14px;">{{ $tool['title'] }}</h3>
                        <p>{{ $tool['description'] }}</p>
                        <a class="card-link" href="{{ url('/tools/' . $tool['slug']) }}">Launch tool <span aria-hidden="true">→</span></a>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    @if (!empty($relatedGuides))
        <section class="page-section" style="background:rgba(255,255,255,0.7); border-top:1px solid rgba(0, 109, 191, 0.08); border-bottom:1px solid rgba(0, 109, 191, 0.08);">
            <div class="shell">
                <div class="section-head">
                    <div>
                        <div class="section-kicker">In-Depth Reference</div>
                        <h2>Related guides and technical articles</h2>
                    </div>
                    <p>Read step-by-step guides, best practices, and edge case reviews related to {{ strtolower($category['name']) }}.</p>
                </div>
                <div class="tool-grid">
                    @foreach ($relatedGuides as $index => $guide)
                        <article class="card click-card">
                            <div class="tool-icon">G{{ $index + 1 }}</div>
                            <h3 style="margin-top:14px;">{{ $guide['title'] }}</h3>
                            <p>{{ $guide['seo_description'] }}</p>
                            <a class="card-link" href="{{ url('/guides/' . $guide['slug']) }}">Read guide <span aria-hidden="true">→</span></a>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <section class="page-section">
        <div class="shell page-layout">
            <div class="page-copy">
                <div class="page-header-block">
                    <div class="section-kicker">Architecture & Security</div>
                    <h2 style="margin-top:16px;">How {{ $category['name'] }} operate safely in your browser</h2>
                    <p style="margin-top:16px;">
                        {{ $category['extended_description'] }}
                    </p>
                </div>

                <div class="page-sections">
                    <article class="page-section-card">
                        <h3>Client-Side Processing Guarantee</h3>
                        <p>
                            When you use tools in {{ $category['name'] }}, operations such as formatting, encoding, hashing, parsing, or metadata inspection execute locally in your web browser using modern web APIs and JavaScript.
                        </p>
                        <p>
                            Your input data, payloads, or selected files are not sent to any remote server or stored in any database. When you refresh or close the tab, all in-memory data is instantly cleared.
                        </p>
                    </article>
                    <article class="page-section-card">
                        <h3>Operating Boundaries and Limitations</h3>
                        <p>
                            {{ $category['limitations'] }}
                        </p>
                        <p>
                            Web-based utilities provide fast feedback and zero-install convenience for debugging, inspection, and quick conversions. For automated batch workflows or production pipelines, dedicated command-line tools or server scripts should be used.
                        </p>
                    </article>
                </div>
            </div>

            <aside class="page-copy">
                <div class="page-side-stack">
                    <div>
                        <div class="section-kicker">Category Navigation</div>
                        <h3 style="margin-top:14px;">Explore other tool categories</h3>
                    </div>
                    <div class="mini-stack">
                        <div class="mini-card">
                            <strong><a href="{{ url('/categories/developer-tools') }}">Developer Tools →</a></strong>
                            <p>JSON formatters, Base64, JWT decoder, Regex tester, SQL formatter.</p>
                        </div>
                        <div class="mini-card">
                            <strong><a href="{{ url('/categories/text-tools') }}">Text & Content Utilities →</a></strong>
                            <p>Word counter, diff checker, markdown preview, case converters.</p>
                        </div>
                        <div class="mini-card">
                            <strong><a href="{{ url('/categories/image-tools') }}">Image Tools →</a></strong>
                            <p>Image resizer, compressor, SVG viewer, color picker, Favicon generator.</p>
                        </div>
                        <div class="mini-card">
                            <strong><a href="{{ url('/categories/security-tools') }}">Security & Network Tools →</a></strong>
                            <p>Hash generator, password generator, IP lookup, UUID generator.</p>
                        </div>
                        <div class="mini-card">
                            <strong><a href="{{ url('/categories/pdf-tools') }}">PDF Utilities →</a></strong>
                            <p>Client-side PDF page counter, text extractor, metadata viewer, rotator.</p>
                        </div>
                    </div>
                </div>
            </aside>
        </div>
    </section>
@endsection