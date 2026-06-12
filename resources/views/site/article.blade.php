@extends('site.layout')

@section('content')
    <section class="page-section">
        <div class="shell page-layout">
            <div class="page-copy">
                <nav class="breadcrumbs" aria-label="Breadcrumb">
                    <a href="{{ url('/') }}">Home</a>
                    <span aria-hidden="true">/</span>
                    <a href="{{ url('/guides') }}">Guides</a>
                    <span aria-hidden="true">/</span>
                    <span>{{ $article['title'] }}</span>
                </nav>
                <div class="page-header-block">
                    <div class="section-kicker">Guide</div>
                    <h1 style="margin-top:16px;">{{ $article['title'] }}</h1>
                    <p class="meta-copy" style="margin-top:14px;">
                        By <a href="{{ $article['author']['url'] }}">{{ $article['author']['name'] }}</a> · Published {{ \Illuminate\Support\Carbon::parse($article['published_at'])->format('F j, Y') }}
                        · Updated {{ \Illuminate\Support\Carbon::parse($article['updated_at'])->format('F j, Y') }} · {{ $article['reading_time'] }}
                    </p>
                    <p style="margin-top:16px;">{{ $article['intro'] }}</p>
                </div>

                @if (!empty($article['field_note']))
                    <div class="page-section-card" style="margin-bottom:24px;">
                        <div class="section-kicker">Author Note</div>
                        <h2 style="margin-top:14px;">Why this guide was reviewed</h2>
                        <p>{{ $article['field_note'] }}</p>
                    </div>
                @endif

                <div class="page-sections">
                    @foreach ($article['sections'] as $section)
                        <article class="page-section-card">
                            <h2>{{ $section['heading'] }}</h2>
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
                            <h2 style="margin-top:14px;">{{ $article['example']['title'] }}</h2>
                            <p>{{ $article['example']['body'] }}</p>
                        @endif

                        @if (!empty($article['code_examples']))
                            <h2 style="margin-top:22px;">Code and input examples</h2>
                            <div class="tool-stack" style="margin-top:14px;">
                                @foreach ($article['code_examples'] as $example)
                                    <div class="mini-card">
                                        <strong>{{ $example['label'] }}</strong>
                                        <pre class="tool-output" style="margin-top:10px;">{{ $example['code'] }}</pre>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        @if (!empty($article['checklist']))
                            <h2 style="margin-top:22px;">Before you rely on the result</h2>
                            <ul class="detail-list">
                                @foreach ($article['checklist'] as $item)
                                    <li>{{ $item }}</li>
                                @endforeach
                            </ul>
                        @endif

                        @if (!empty($article['mistakes']))
                            <h2 style="margin-top:22px;">Common mistakes this guide helps prevent</h2>
                            <ul class="detail-list">
                                @foreach ($article['mistakes'] as $item)
                                    <li>{{ $item }}</li>
                                @endforeach
                            </ul>
                        @endif

                        @if (!empty($article['limits']))
                            <h2 style="margin-top:22px;">When not to use this as your only workflow</h2>
                            <p>{{ $article['limits'] }}</p>
                        @endif
                    </div>
                @endif

                <div class="page-section-card" style="margin-top:24px;">
                    <h2>Common Questions</h2>
                    <div class="tool-stack" style="margin-top:18px;">
                        @foreach ($article['faq'] as $item)
                            <details class="mini-card">
                                <summary>{{ $item['question'] }}</summary>
                                <p style="margin-top:10px;">{{ $item['answer'] }}</p>
                            </details>
                        @endforeach
                    </div>
                </div>

                <div class="page-section-card" style="margin-top:24px;">
                    <h2>About the author</h2>
                    <p>{{ $article['author']['name'] }} is the founder and product editor of WebToolsStation. This guide was reviewed for practical browser-tool usage, common mistakes, and clear limits before publication.</p>
                    <p><a class="card-link" href="{{ $article['author']['url'] }}">View author profile <span aria-hidden="true">→</span></a></p>
                </div>

                <div class="page-section-card" style="margin-top:24px;">
                    <h2>How this guide adds practical value</h2>
                    <p>
                        This guide is written to support a real task, not only to describe a tool name. A visitor reading about {{ $article['title'] }} should leave with a
                        clearer sense of what to paste, upload, check, compare, or avoid. That is why the page includes an author note, examples, a checklist, common mistakes,
                        limitations, and related tools instead of stopping after a short definition.
                    </p>
                    <p>
                        The most useful way to read this guide is to connect the explanation to your own workflow. If you are debugging an API, preparing content, reviewing a
                        document, cleaning a list, converting a color, checking a token, or validating text, do not treat the first output as the final answer automatically.
                        Review the source value, run a small sample when possible, and compare the result with the system or document where it will be used.
                    </p>
                    <p>
                        WebToolsStation also calls out where a lightweight browser check is not enough. That matters because a quick utility can save time, but it should not
                        pretend to replace production testing, security verification, legal review, accessibility review, OCR, version control, or a full application workflow.
                        The goal is practical clarity: use the tool for the fast step, understand the output, then decide whether the task needs deeper review.
                    </p>
                    <p>
                        This approach is part of how the site avoids low-value content. The page is meant to answer a specific user need with enough context to be useful on its
                        own, while still linking to the related browser tool for visitors who want to act immediately.
                    </p>
                    <p>
                        A stronger workflow also includes knowing what evidence would make you question the result. If an output looks valid but does not match the source task,
                        check the input format, the assumptions behind the tool, and any limits mentioned above. For technical topics, compare the example with your own value.
                        For document or text topics, review whether the source content has hidden formatting, missing data, scanned text, or context that a quick browser tool
                        cannot fully understand.
                    </p>
                    <p>
                        The guide should therefore work as a reference even before you touch the tool. You can use it to plan the task, avoid common mistakes, and decide when
                        to use a deeper workflow. That is the difference between a thin article and a useful support page: the content helps the visitor make a better decision,
                        not just find another button.
                    </p>
                </div>

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
                        <p><a href="{{ $article['author']['url'] }}">{{ $article['author']['name'] }}</a></p>
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
