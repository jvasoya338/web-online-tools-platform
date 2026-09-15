@extends('site.layout')

@section('content')
    <section class="page-section">
        <div class="shell page-layout">
            <div class="page-copy">
                <div class="page-header-block">
                    <div class="section-kicker">Author</div>
                    <h1 style="margin-top:16px;">{{ $author['name'] }}</h1>
                    <p class="meta-copy" style="margin-top:14px;">{{ $author['role'] }} · {{ $author['location'] }}</p>
                    <p style="margin-top:16px;">{{ $author['bio'] }}</p>
                    <div class="hero-actions">
                        <a class="button button-primary" href="{{ url('/guides') }}">Read Guides</a>
                        <a class="button button-secondary" href="mailto:{{ $author['email'] }}">Contact Author</a>
                    </div>
                </div>

                <div class="page-section-card">
                    <h3>Editorial experience</h3>
                    <ul class="detail-list">
                        @foreach ($author['experience'] as $item)
                            <li>{{ $item }}</li>
                        @endforeach
                    </ul>
                </div>

                <div class="page-section-card" style="margin-top:24px;">
                    <h3>How this author reviews WebToolsStation guides</h3>
                    <p>
                        Each guide is reviewed against the related browser tool, the likely visitor task, and the limits of a lightweight online utility.
                        The goal is to explain the practical workflow clearly instead of publishing short pages that only repeat a keyword.
                    </p>
                    <p>
                        When a tool result should be double-checked in a stronger workflow, the guide says so. That is part of the trust standard for the platform.
                    </p>
                </div>

                <div class="page-section-card" style="margin-top:24px;">
                    <h3>Editorial & Technical Standards</h3>
                    <p>
                        WebToolsStation publishes utilities and guides designed to be immediately useful for engineers, digital creators, and content specialists. Every utility page is required to provide accurate input validation, clear output representations, and explicit technical boundaries.
                    </p>
                    <p>
                        Our technical documentation focuses on real-world edge cases: invalid character encodings, payload size thresholds, browser memory limits, and appropriate cryptographic practices.
                    </p>
                </div>

                <div class="page-section-card" style="margin-top:24px;">
                    <h3>Continuous Verification & Updates</h3>
                    <p>
                        Browser standards, web APIs, and formatting conventions evolve. We regularly audit our tools against modern ECMAScript standards, WHATWG specifications, and web platform capabilities to ensure that utilities remain reliable across current desktop and mobile web browsers.
                    </p>
                    <p>
                        User suggestions, bug reports, and pull requests are welcomed and reviewed through our contact channel.
                    </p>
                </div>
            </div>

            <aside class="page-copy">
                <div class="page-side-stack">
                    <div>
                        <div class="section-kicker">Published Guides</div>
                        <h3 style="margin-top:14px;">Guides reviewed under this author profile</h3>
                    </div>
                    <div class="page-grid">
                        @foreach ($guides as $guide)
                            <div class="card click-card">
                                <div class="tool-icon">TV</div>
                                <h3 style="margin-top:12px;">{{ $guide['title'] }}</h3>
                                <p>{{ $guide['seo_description'] }}</p>
                                <a class="card-link" href="{{ url('/guides/' . $guide['slug']) }}">Read guide <span aria-hidden="true">→</span></a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </aside>
        </div>
    </section>
@endsection
