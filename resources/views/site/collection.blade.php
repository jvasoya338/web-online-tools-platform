@extends('site.layout')

@section('content')
    <section class="hero">
        <div class="shell hero-grid">
            <div class="hero-card">
                <nav class="breadcrumbs" aria-label="Breadcrumb" style="margin-bottom:16px;">
                    <a href="{{ url('/') }}">Home</a>
                    <span aria-hidden="true">/</span>
                    <a href="{{ url('/#categories') }}">Collections</a>
                    <span aria-hidden="true">/</span>
                    <span>{{ $collection['short_title'] }}</span>
                </nav>
                <div style="display:flex; align-items:center; gap:12px; margin-bottom:12px;">
                    <div class="tool-icon" style="font-size:1.8rem; width:48px; height:48px;">{{ $collection['icon'] }}</div>
                    <span class="eyebrow" style="margin-bottom:0;">Curated Tool Collection</span>
                </div>
                <h1>{{ $collection['title'] }}</h1>
                <p class="lede" style="font-size:1.15rem; font-weight:600; color:var(--brand-dark); margin-top:12px;">
                    {{ $collection['tagline'] }}
                </p>
                <p class="lede" style="max-width:760px; margin-top:10px;">
                    {{ $collection['overview'] }}
                </p>
                <div class="hero-actions" style="margin-top:24px;">
                    <a class="button button-primary" href="#curated-tools">Explore {{ count($tools) }} Tools</a>
                    <a class="button button-secondary" href="#comparison">Compare Features</a>
                </div>
            </div>
            <div class="hero-side">
                <span class="mini-kicker">Recommended Workflow</span>
                <h2 style="margin:16px 0 12px; font-size:1.35rem;">Multi-Tool Engineering Flow</h2>
                <div class="mini-stack" style="margin-top:16px;">
                    @foreach ($collection['workflows'] as $wf)
                        <div class="mini-card">
                            <strong style="color:var(--brand); display:block; margin-bottom:4px;">{{ $wf['step'] }}</strong>
                            <p style="margin:0; font-size:0.9rem;">{{ $wf['description'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <!-- Curated Tools Grid -->
    <section class="page-section" id="curated-tools">
        <div class="shell">
            <div class="section-head">
                <div>
                    <div class="section-kicker">Curated Suite</div>
                    <h2>Tools in this Collection ({{ count($tools) }})</h2>
                </div>
                <p>Selected for accuracy, speed, and 100% client-side data confidentiality.</p>
            </div>

            <div class="tool-grid">
                @foreach ($tools as $tool)
                    <article class="card click-card tool-item" style="display:flex; flex-direction:column;">
                        <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:12px;">
                            <div class="tool-icon">{{ $tool['icon'] }}</div>
                            <span class="tool-badge" style="background:#eaf2fb; color:var(--brand-dark); font-weight:600; font-size:0.75rem;">{{ $tool['category'] }}</span>
                        </div>
                        <h3 style="margin-bottom:8px; font-size:1.15rem;">{{ $tool['title'] }}</h3>
                        <p style="flex:1; margin-bottom:14px; font-size:0.92rem; color:var(--text-muted);">{{ $tool['summary'] ?? $tool['description'] }}</p>
                        <div style="display:flex; justify-content:space-between; align-items:center; border-top:1px solid var(--border); padding-top:10px; margin-top:auto;">
                            <span style="font-size:0.8rem; color:var(--success); font-weight:600;">✓ In-browser memory</span>
                            <a class="card-link" href="{{ url('/tools/' . $tool['slug']) }}" style="font-weight:600;">Open Tool <span aria-hidden="true">→</span></a>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Tool Comparison Matrix -->
    @if (!empty($collection['comparison_matrix']))
        <section class="page-section" id="comparison" style="background:var(--surface-subtle); border-top:1px solid var(--border); border-bottom:1px solid var(--border);">
            <div class="shell">
                <div class="section-head">
                    <div>
                        <div class="section-kicker">Feature Matrix</div>
                        <h2>Tool Comparison &amp; Selection Guide</h2>
                    </div>
                    <p>Choose the right utility for your specific payload format, size, and transformation requirement.</p>
                </div>

                <div style="overflow-x:auto; background:var(--surface); border-radius:var(--radius-md); border:1px solid var(--border); box-shadow:var(--shadow-sm);">
                    <table style="width:100%; border-collapse:collapse; text-align:left; font-size:0.92rem;">
                        <thead>
                            <tr style="background:var(--surface-subtle); border-bottom:1px solid var(--border);">
                                <th style="padding:12px 16px; font-weight:700; color:var(--text);">Tool Name</th>
                                <th style="padding:12px 16px; font-weight:700; color:var(--text);">Primary Use Case</th>
                                <th style="padding:12px 16px; font-weight:700; color:var(--text);">Input Format</th>
                                <th style="padding:12px 16px; font-weight:700; color:var(--text);">Generated Output</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($collection['comparison_matrix'] as $row)
                                <tr style="border-bottom:1px solid var(--border);">
                                    <td style="padding:12px 16px; font-weight:600; color:var(--brand-dark);">{{ $row['tool'] }}</td>
                                    <td style="padding:12px 16px; color:var(--text);">{{ $row['best_for'] }}</td>
                                    <td style="padding:12px 16px; font-family:var(--font-mono); font-size:0.85rem; color:var(--text-muted);">{{ $row['input_type'] }}</td>
                                    <td style="padding:12px 16px; color:var(--text);">{{ $row['output'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    @endif

    <!-- Editorial FAQs -->
    <section class="page-section">
        <div class="shell page-layout">
            <div class="page-copy">
                <div class="page-section-card">
                    <div class="section-kicker">Knowledge Base</div>
                    <h2>Frequently Asked Questions</h2>
                    <div class="tool-stack" style="margin-top:18px;">
                        @foreach ($collection['faq'] as $faq)
                            <details class="mini-card" style="margin-bottom:10px;">
                                <summary style="cursor:pointer; font-weight:700; color:var(--text);">{{ $faq['question'] }}</summary>
                                <p style="margin-top:10px; color:var(--text-muted); line-height:1.6;">{{ $faq['answer'] }}</p>
                            </details>
                        @endforeach
                    </div>
                </div>
            </div>

            <aside class="page-copy">
                <div class="page-side-stack">
                    <div class="mini-card">
                        <span class="mini-kicker">Other Collections</span>
                        <h3 style="margin:8px 0 12px; font-size:1.15rem;">Explore Curated Suites</h3>
                        <ul style="list-style:none; padding:0; margin:0; display:flex; flex-direction:column; gap:8px;">
                            <li><a href="{{ url('/collections/best-developer-tools') }}" style="color:var(--brand); font-weight:600;">Best Developer Tools →</a></li>
                            <li><a href="{{ url('/collections/best-json-tools') }}" style="color:var(--brand); font-weight:600;">Best JSON Tools →</a></li>
                            <li><a href="{{ url('/collections/best-text-tools') }}" style="color:var(--brand); font-weight:600;">Best Text Tools →</a></li>
                            <li><a href="{{ url('/collections/best-image-tools') }}" style="color:var(--brand); font-weight:600;">Best Image Tools →</a></li>
                            <li><a href="{{ url('/collections/best-pdf-tools') }}" style="color:var(--brand); font-weight:600;">Best PDF Tools →</a></li>
                            <li><a href="{{ url('/collections/best-seo-tools') }}" style="color:var(--brand); font-weight:600;">Best SEO Tools →</a></li>
                        </ul>
                    </div>

                    <div class="mini-card" style="background:#f0fdf4; border-color:#bbf7d0;">
                        <span class="mini-kicker" style="color:#166534;">Privacy Standard</span>
                        <h4 style="margin:6px 0 8px; color:#15803d; font-size:1.05rem;">100% Client-Side Memory</h4>
                        <p style="font-size:0.88rem; color:#166534; margin:0;">
                            None of the tools in this collection upload your inputs or files to remote cloud servers. Transformations happen instantly in your browser runtime.
                        </p>
                    </div>
                </div>
            </aside>
        </div>
    </section>
@endsection
