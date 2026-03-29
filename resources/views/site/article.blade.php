@extends('site.layout')

@section('content')
    <section class="page-section">
        <div class="shell page-layout">
            <div class="page-copy">
                <div class="page-header-block">
                    <div class="section-kicker">Guide</div>
                    <h1 style="margin-top:16px;">{{ $article['title'] }}</h1>
                    <p style="margin-top:16px;">{{ $article['intro'] }}</p>
                </div>

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

                @if (!empty($relatedTools))
                    <div class="page-section-card" style="margin-top:24px;">
                        <div class="section-kicker">Recommended Tools</div>
                        <h3 style="margin-top:14px;">Useful tools related to this guide</h3>
                        <div class="page-grid" style="margin-top:18px;">
                            @foreach ($relatedTools as $tool)
                                <div class="card">
                                    <div class="tool-icon">{{ $tool['icon'] }}</div>
                                    <h3 style="margin-top:12px;">{{ $tool['title'] }}</h3>
                                    <p>{{ $tool['summary'] }}</p>
                                    <a class="card-link" href="{{ url('/tools/' . $tool['slug']) }}">Open tool</a>
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
                    <div class="page-grid">
                        @foreach (collect($guides)->reject(fn ($guide) => $guide['slug'] === $article['slug'])->take(4) as $guide)
                            <div class="card">
                                <div class="tool-icon">GD</div>
                                <h3 style="margin-top:12px;">{{ $guide['title'] }}</h3>
                                <p>{{ $guide['seo_description'] }}</p>
                                <a class="card-link" href="{{ url('/guides/' . $guide['slug']) }}">Read guide</a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </aside>
        </div>
    </section>
@endsection
