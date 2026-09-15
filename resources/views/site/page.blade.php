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
                    <h2>Transparency & User Inquiries</h2>
                    <p>
                        WebToolsStation maintains clear operating terms, data privacy disclosures, and contact channels to ensure transparent relationships with all visitors. When using browser-based utilities to inspect code, tokens, or documents, knowing how your data is handled is essential.
                    </p>
                    <p>
                        If you have questions regarding these terms, our privacy practices, or wish to report an issue with any tool on the platform, please visit our <a href="{{ url('/contact') }}" style="color:var(--brand); text-decoration:underline;">Contact Page</a>.
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
