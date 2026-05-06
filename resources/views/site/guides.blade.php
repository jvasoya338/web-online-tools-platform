@extends('site.layout')

@section('content')
    <section class="hero">
        <div class="shell hero-grid">
            <div class="hero-card">
                <span class="eyebrow">Guides and practical articles</span>
                <h1>Articles that explain the tools, the workflows behind them, and the mistakes people make most often.</h1>
                <p class="lede">
                    WebToolsStation is not only a tools directory. This guides section exists so visitors can understand when a tool helps,
                    how to use it well, and where a fast browser check should give way to a deeper workflow. These articles are written to
                    support real debugging, editing, publishing, and document-review tasks rather than act like filler pages.
                </p>
                <div class="hero-actions">
                    <a class="button button-primary" href="{{ url('/') }}">Explore The Tools</a>
                    <a class="button button-secondary" href="{{ url('/about') }}">How We Review Pages</a>
                </div>
                <div class="hero-stats">
                    <div class="stat">
                        <strong>{{ $guideCount }}</strong>
                        <p>Published guides on the site</p>
                    </div>
                    <div class="stat">
                        <strong>20+</strong>
                        <p>Practical topics across tools and workflows</p>
                    </div>
                    <div class="stat">
                        <strong>TJ</strong>
                        <p>Maintained by the TJVerce editorial and product team</p>
                    </div>
                </div>
            </div>
            <div class="hero-side">
                <span class="mini-kicker">What You Will Find Here</span>
                <h3 style="margin:16px 0 12px;">Guides built around actual use, not just keywords.</h3>
                <p>
                    The articles on this page focus on practical tool usage, common mistakes, quick review steps, and situations where a
                    lightweight browser utility is helpful. They are meant to add context to the tools and help visitors decide what to do next.
                </p>
                <div class="mini-stack" style="margin-top:18px;">
                    <div class="mini-card">
                        <strong>Tool context</strong>
                        <p>Articles explain what a tool is for and how to use it with more confidence.</p>
                    </div>
                    <div class="mini-card">
                        <strong>Workflow guidance</strong>
                        <p>Pages call out common mistakes, limitations, and when to move into a bigger workflow.</p>
                    </div>
                    <div class="mini-card">
                        <strong>Clear ownership</strong>
                        <p>Every guide sits inside the same maintained WebToolsStation publishing and product structure.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="page-section">
        <div class="shell">
            <div class="section-head">
                <div>
                    <div class="section-kicker">Latest Guides</div>
                    <h2>Recent articles worth reading first</h2>
                </div>
                <p>These are some of the strongest starting points if you want to understand how the tools connect to real work instead of only testing the interface.</p>
            </div>
            <div class="tool-grid">
                @foreach (array_reverse($featuredGuides) as $guide)
                    <article class="card click-card">
                        <div class="tool-icon">GD</div>
                        <h3 style="margin-top:14px;">{{ $guide['title'] }}</h3>
                        <p>{{ $guide['seo_description'] }}</p>
                        <p class="meta-copy" style="margin-top:12px;">Updated {{ \Illuminate\Support\Carbon::parse($guide['updated_at'])->format('F j, Y') }} · {{ $guide['reading_time'] }}</p>
                        <a class="card-link" href="{{ url('/guides/' . $guide['slug']) }}">Read guide <span aria-hidden="true">→</span></a>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="page-section">
        <div class="shell">
            <div class="section-head">
                <div>
                    <div class="section-kicker">All Guides</div>
                    <h2>Browse the full WebToolsStation guide library</h2>
                </div>
                <p>Every article is written to support a practical browser-based task, from formatting JSON and checking JWTs to reviewing PDFs and cleaning URLs.</p>
            </div>
            <div class="tool-grid">
                @foreach (array_reverse($guides) as $guide)
                    <article class="card click-card">
                        <div class="tool-icon">AR</div>
                        <h3 style="margin-top:14px;">{{ $guide['title'] }}</h3>
                        <p>{{ $guide['seo_description'] }}</p>
                        <p class="meta-copy" style="margin-top:12px;">By {{ $guide['author']['name'] }} · {{ $guide['reading_time'] }}</p>
                        <a class="card-link" href="{{ url('/guides/' . $guide['slug']) }}">Open article <span aria-hidden="true">→</span></a>
                    </article>
                @endforeach
            </div>
        </div>
    </section>
@endsection
