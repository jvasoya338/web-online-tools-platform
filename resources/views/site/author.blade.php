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
                    <h3>Editorial standards for low-value content prevention</h3>
                    <p>
                        WebToolsStation pages are reviewed with a practical question in mind: would this page still help a visitor if search traffic did not exist? A useful
                        page should explain the task, show examples where possible, include limitations, and connect the tool to a real workflow. Short pages that only repeat
                        a keyword or surround a basic widget with generic copy are not enough for the direction of the platform.
                    </p>
                    <p>
                        The author review process focuses on making each guide and tool page more specific. That includes checking whether the page has a clear purpose, whether
                        the examples match the tool, whether privacy or security cautions are visible, and whether a visitor can tell when they should move from a quick browser
                        check into a deeper professional workflow.
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
