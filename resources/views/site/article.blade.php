@extends('site.layout')

@section('content')
    <section class="page-section">
        <div class="shell page-layout">
            <div class="page-copy">
                <div class="page-header-block">
                    <div class="section-kicker">Guide</div>
                    <h1 style="margin-top:16px;">{{ $article['title'] }}</h1>
                    <p class="meta-copy" style="margin-top:14px;">
                        By <a href="{{ url('/authors/' . $article['author']['slug']) }}">{{ $article['author']['name'] }}</a> · Published {{ \Illuminate\Support\Carbon::parse($article['published_at'])->format('F j, Y') }}
                        · Updated {{ \Illuminate\Support\Carbon::parse($article['updated_at'])->format('F j, Y') }} · {{ $article['reading_time'] }}
                    </p>
                    <p style="margin-top:16px;">{{ $article['intro'] }}</p>
                </div>

                @if (!empty($article['field_note']))
                    <div class="page-section-card" style="margin-bottom:24px;">
                        <div class="section-kicker">Author Note</div>
                        <h3 style="margin-top:14px;">Why this guide was reviewed</h3>
                        <p>{{ $article['field_note'] }}</p>
                    </div>
                @endif

                <div class="page-sections">
                    @foreach ($article['sections'] as $section)
                        <article class="page-section-card">
                            <h3>{{ $section['heading'] }}</h3>
                            @foreach ($section['paragraphs'] as $paragraph)
                                <p>{{ $paragraph }}</p>
                            @endforeach
                        </article>
                    @endforeach
                </div>

                @if (!empty($article['example']) || !empty($article['checklist']) || !empty($article['mistakes']) || !empty($article['limits']))
                    <div class="page-section-card" style="margin-top:24px;">
                        <div class="section-kicker">Practical Review</div>
                        @if (!empty($article['example']))
                            <h3 style="margin-top:14px;">{{ $article['example']['title'] }}</h3>
                            <p>{{ $article['example']['body'] }}</p>
                        @endif

                        @if (!empty($article['checklist']))
                            <h3 style="margin-top:22px;">Before you rely on the result</h3>
                            <ul class="detail-list">
                                @foreach ($article['checklist'] as $item)
                                    <li>{{ $item }}</li>
                                @endforeach
                            </ul>
                        @endif

                        @if (!empty($article['mistakes']))
                            <h3 style="margin-top:22px;">Common mistakes this guide helps prevent</h3>
                            <ul class="detail-list">
                                @foreach ($article['mistakes'] as $item)
                                    <li>{{ $item }}</li>
                                @endforeach
                            </ul>
                        @endif

                        @if (!empty($article['limits']))
                            <h3 style="margin-top:22px;">Where the tool stops being enough</h3>
                            <p>{{ $article['limits'] }}</p>
                        @endif
                    </div>
                @endif

                @if (!empty($relatedTools))
                    <div class="page-section-card" style="margin-top:24px;">
                        <div class="section-kicker">Recommended Tools</div>
                        <h3 style="margin-top:14px;">Useful tools related to this guide</h3>
                        <div class="page-grid" style="margin-top:18px;">
                            @foreach ($relatedTools as $tool)
                                <div class="card click-card">
                                    <div class="tool-icon">{{ $tool['icon'] }}</div>
                                    <h3 style="margin-top:12px;">{{ $tool['title'] }}</h3>
                                    <p>{{ $tool['summary'] }}</p>
                                    <a class="card-link" href="{{ url('/tools/' . $tool['slug']) }}">Open tool <span aria-hidden="true">→</span></a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <aside class="page-copy">
                <div class="page-side-stack">
                    <div>
                        <div class="section-kicker">More Reading</div>
                        <h3 style="margin-top:14px;">Helpful pages on WebToolsStation</h3>
                    </div>
                    <div class="card">
                        <div class="tool-icon">AU</div>
                        <h3 style="margin-top:12px;">About the author</h3>
                        <p><a href="{{ url('/authors/' . $article['author']['slug']) }}">{{ $article['author']['name'] }}</a></p>
                        <p>{{ $article['author']['role'] }}</p>
                        <p>{{ $article['author']['bio'] }}</p>
                    </div>
                    <div class="card">
                        <div class="tool-icon">RV</div>
                        <h3 style="margin-top:12px;">Article review</h3>
                        <p>Reviewed by: {{ $article['reviewer']['name'] }}</p>
                        <p>Review focus: {{ $article['reviewer']['role'] }}</p>
                    </div>
                    <div class="page-grid">
                        @foreach (collect($guides)->reject(fn ($guide) => $guide['slug'] === $article['slug'])->take(4) as $guide)
                            <div class="card click-card">
                                <div class="tool-icon">GD</div>
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
