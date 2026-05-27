@extends('site.layout')

@section('content')
    <section class="page-section">
        <div class="shell page-layout">
            <div class="page-copy">
                <div class="page-header-block">
                    <div class="section-kicker">{{ $page['label'] }}</div>
                    <h1 style="margin-top:16px;">{{ $page['title'] }}</h1>
                    <p class="meta-copy" style="margin-top:14px;">Last updated May 25, 2026</p>
                    <p style="margin-top:16px;">{{ $page['intro'] }}</p>
                </div>

                <div class="page-sections">
                    @foreach ($page['sections'] as $section)
                        <article class="page-section-card">
                            <h3>{{ $section['heading'] }}</h3>
                            @foreach ($section['paragraphs'] as $paragraph)
                                <p>{{ $paragraph }}</p>
                            @endforeach
                        </article>
                    @endforeach
                </div>

                <div class="page-section-card" style="margin-top:24px;">
                    <h2>How this page supports site quality</h2>
                    <p>
                        WebToolsStation treats public trust pages as part of the product, not as filler. A tools website asks visitors to interact with text, files, colors,
                        URLs, tokens, or document signals, so the surrounding pages need to explain who operates the site, how contact works, what limits apply, and how users
                        should think about privacy and responsibility. That context helps visitors decide whether the platform is appropriate for their workflow.
                    </p>
                    <p>
                        This page also supports search and AdSense quality because it gives reviewers and users a clearer view of the site beyond the individual tools. A
                        low-value site often has thin policy pages, anonymous ownership, and repeated boilerplate. WebToolsStation is being structured differently: ownership,
                        author information, contact details, policy explanations, sitemap access, crawl rules, and practical limitations are kept visible so the platform feels
                        maintained rather than automatically generated.
                    </p>
                    <p>
                        The same standard applies across the platform. Tool pages should explain what the utility does and how to review the output. Guide pages should provide
                        examples, mistakes, limitations, and useful next steps. Trust pages should make the site easier to understand before a visitor uses a browser-based
                        workflow. This page exists inside that larger quality system.
                    </p>
                    <p>
                        Visitors should also be able to understand the boundaries of the service without guessing. WebToolsStation is a browser-based utility and publishing
                        project, not a replacement for every professional workflow. The public pages explain this clearly because honest limits are part of trust. When a site is
                        transparent about ownership, contact, data handling, acceptable use, and review standards, the tools become easier to evaluate and the overall platform
                        becomes more useful.
                    </p>
                    <p>
                        This quality approach also helps keep the site consistent as it grows. New tools, guides, and policy updates should fit the same pattern: clear language,
                        practical examples where they help, visible review notes, and plain explanations of what the platform does not do. That makes the website easier for
                        visitors to trust and easier for search reviewers to understand as a maintained public resource rather than a group of disconnected pages.
                    </p>
                </div>
            </div>
            <aside class="page-copy">
                <div class="page-side-stack">
                    <div>
                        <div class="section-kicker">Overview</div>
                        <h3 style="margin-top:14px;">Important details in one place</h3>
                    </div>
                    <div class="page-grid">
                        @foreach ($page['cards'] as $card)
                            <div class="card">
                                <div class="tool-icon">{{ strtoupper(substr($card['title'], 0, 2)) }}</div>
                                <h3 style="margin-top:12px;">{{ $card['title'] }}</h3>
                                <p>{{ $card['value'] }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </aside>
        </div>
    </section>
@endsection
