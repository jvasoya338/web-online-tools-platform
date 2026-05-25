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
