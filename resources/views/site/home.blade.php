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
                    <article class="card click-card">
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
                    <article class="card click-card">
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
                    <article class="card click-card">
                        <div class="tool-icon">G{{ $index + 1 }}</div>
                        <h3 style="margin-top:14px;">{{ $guide['title'] }}</h3>
                        <p>{{ $guide['seo_description'] }}</p>
                        <a class="card-link" href="{{ url('/guides/' . $guide['slug']) }}">Read guide</a>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="page-section">
        <div class="shell page-layout">
            <div class="page-copy">
                <div class="page-header-block">
                    <div class="section-kicker">Why This Site Exists</div>
                    <h2 style="margin-top:16px;">WebToolsStation is meant to be useful before it tries to be big.</h2>
                    <p style="margin-top:16px;">
                        This project is built for the moments when a person needs one focused answer quickly: format a payload,
                        check a token, clean a slug, inspect a PDF, or convert a small file without opening a much larger workflow.
                        The goal is not to overwhelm visitors with hundreds of shallow pages. The goal is to make each tool understandable,
                        readable, and genuinely helpful the first time someone lands on it.
                    </p>
                </div>

                <div class="page-sections">
                    <article class="page-section-card">
                        <h3>What we try to publish</h3>
                        <p>
                            We prefer tools that solve a clear problem, explain the expected input and output, and help a visitor move
                            on with their work faster. That means each page should do more than exist for a keyword. It should explain
                            what the tool is for, where it helps, and what a user should double-check before relying on the result.
                        </p>
                        <p>
                            We also try to support tools with practical guides so the site is not just a directory of buttons.
                            Some visitors need a fast utility. Others need context, examples, and a clearer understanding of how
                            to use the tool well. Both audiences matter.
                        </p>
                    </article>
                    <article class="page-section-card">
                        <h3>How we think about trust</h3>
                        <p>
                            Useful tools should not feel anonymous or careless. That is why we keep public pages such as About,
                            Contact, Privacy Policy, and Terms of Use visible and written as real parts of the platform. We want
                            the site to feel maintained, understandable, and responsible instead of looking like a random collection
                            of scripts with no owner behind it.
                        </p>
                        <p>
                            When a tool handles text, links, tokens, or files, we want the page to make the workflow clear. If a result
                            is only a quick check and not a full professional verdict, the page should say so. That kind of honesty is
                            part of the product quality we want visitors to feel.
                        </p>
                    </article>
                </div>
            </div>

            <aside class="page-copy">
                <div class="page-side-stack">
                    <div>
                        <div class="section-kicker">Editorial Standards</div>
                        <h3 style="margin-top:14px;">What we review before a page earns its place</h3>
                    </div>
                    <div class="page-grid">
                        <div class="card">
                            <div class="tool-icon">CL</div>
                            <h3 style="margin-top:12px;">Clear purpose</h3>
                            <p>Every tool page should explain what problem it solves and who it is actually helpful for.</p>
                        </div>
                        <div class="card">
                            <div class="tool-icon">EX</div>
                            <h3 style="margin-top:12px;">Real examples</h3>
                            <p>Pages need practical use cases, not only feature labels or short generic blurbs.</p>
                        </div>
                        <div class="card">
                            <div class="tool-icon">CK</div>
                            <h3 style="margin-top:12px;">Check points</h3>
                            <p>We call out limitations and review notes so visitors know what to double-check.</p>
                        </div>
                        <div class="card">
                            <div class="tool-icon">TR</div>
                            <h3 style="margin-top:12px;">Trust signals</h3>
                            <p>Company identity, policies, contact details, and clear page ownership are part of the product.</p>
                        </div>
                    </div>
                </div>
            </aside>
        </div>
    </section>
@endsection
