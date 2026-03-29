@extends('site.layout')

@section('content')
    <section class="page-section" id="tool-grid">
        <div class="shell">
            <div class="section-head">
                <div>
                    <div class="section-kicker">All Tools</div>
                    <h2>Explore the tools available on the platform</h2>
                </div>
                <p>Browse the collection and open the tool that fits your task. Each page keeps the experience simple and easy to follow.</p>
            </div>
            <div class="tool-grid">
                @foreach ($tools as $tool)
                    <article class="card">
                        <div class="tool-icon">{{ $tool['icon'] }}</div>
                        <div class="tool-badge">{{ $tool['category'] }}</div>
                        <h3 style="margin-top:14px;">{{ $tool['title'] }}</h3>
                        <p>{{ $tool['description'] }}</p>
                        <a class="card-link" href="{{ url('/tools/' . $tool['slug']) }}">Open tool</a>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="page-section">
        <div class="shell">
            <div class="section-head">
                <div>
                    <div class="section-kicker">Popular Tools</div>
                    <h2>Strong starting points for common tasks</h2>
                </div>
                <p>These pages are some of the easiest ways for new visitors to understand what WebToolsStation offers and get value quickly.</p>
            </div>
            <div class="tool-grid">
                @foreach ($featuredTools as $tool)
                    <article class="card">
                        <div class="tool-icon">{{ $tool['icon'] }}</div>
                        <div class="tool-badge">{{ $tool['category'] }}</div>
                        <h3 style="margin-top:14px;">{{ $tool['title'] }}</h3>
                        <p>{{ $tool['summary'] }}</p>
                        <a class="card-link" href="{{ url('/tools/' . $tool['slug']) }}">Try this tool</a>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="hero">
        <div class="shell hero-grid">
            <div class="hero-card">
                <span class="eyebrow">Developer tools and PDF utilities</span>
                <h1>Useful online tools presented in a cleaner and more comfortable way.</h1>
                <p class="lede">
                    WebToolsStation by TJVerce is designed for people who want quick results without a messy interface.
                    The platform keeps the focus on practical tools, readable pages, and a calmer browsing experience.
                </p>
                <div class="hero-actions">
                    <a class="button button-primary" href="{{ url('/about') }}">Learn About The Platform</a>
                    <a class="button button-secondary" href="{{ url('/contact') }}">Suggest A Tool</a>
                </div>
                <div class="hero-stats">
                    <div class="stat">
                        <strong>{{ $toolCount }}</strong>
                        <p>Total tools available today</p>
                    </div>
                    <div class="stat">
                        <strong>{{ $pdfCount }}</strong>
                        <p>PDF-focused tools on the platform</p>
                    </div>
                    <div class="stat">
                        <strong>TJ</strong>
                        <p>Built and managed by TJVerce</p>
                    </div>
                </div>
            </div>
            <div class="hero-side">
                <span class="mini-kicker">Platform Overview</span>
                <h3 style="margin:16px 0 12px;">A simple structure that keeps tools first and support pages easy to find.</h3>
                <p>
                    We shaped the website to feel more direct and easier to trust. Visitors can reach tools quickly,
                    while pages like About, Contact, Privacy Policy, and Terms of Use remain clearly available.
                </p>
                <div class="mini-stack" style="margin-top:18px;">
                    <div class="mini-card">
                        <strong>Fast access</strong>
                        <p>The main tool directory appears first so visitors immediately see the platform purpose.</p>
                    </div>
                    <div class="mini-card">
                        <strong>Clean reading</strong>
                        <p>Layouts are designed to feel calmer, simpler, and more readable across desktop and mobile.</p>
                    </div>
                    <div class="mini-card">
                        <strong>Professional presence</strong>
                        <p>Brand, contact details, and policy pages are visible so the website feels complete and reliable.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="page-section">
        <div class="shell">
            <div class="section-head">
                <div>
                    <div class="section-kicker">Help Guides</div>
                    <h2>Helpful reading for common tool and workflow questions</h2>
                </div>
                <p>These guides add depth to the platform and help visitors understand why certain tools are useful and how to use them more effectively.</p>
            </div>
            <div class="tool-grid">
                @foreach ($latestGuides as $index => $guide)
                    <article class="card">
                        <div class="tool-icon">G{{ $index + 1 }}</div>
                        <h3 style="margin-top:14px;">{{ $guide['title'] }}</h3>
                        <p>{{ $guide['seo_description'] }}</p>
                        <a class="card-link" href="{{ url('/guides/' . $guide['slug']) }}">Read guide</a>
                    </article>
                @endforeach
            </div>
        </div>
    </section>
@endsection
