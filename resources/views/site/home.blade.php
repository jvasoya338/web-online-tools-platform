@extends('site.layout')

@section('content')
    <section class="hero">
        <div class="shell hero-grid">
            <div class="hero-card">
                <span class="eyebrow">Free Online Browser Utilities</span>
                <h1>{{ $toolCount }} Free Online Tools for Developers, Text, PDF, Security & Media</h1>
                <p class="lede">
                    WebToolsStation by TJ Verse provides fast, privacy-focused browser utilities that execute locally on your machine.
                    Format payloads, inspect PDFs, convert text, decode tokens, and test patterns without registration, subscriptions, or remote server storage.
                </p>
                <div class="hero-actions">
                    <a class="button button-primary" href="#tool-grid">Explore {{ $toolCount }} Tools</a>
                    <a class="button button-secondary" href="#categories">Browse Categories</a>
                </div>
                <div class="hero-stats">
                    <div class="stat">
                        <strong>{{ $toolCount }}</strong>
                        <p>Total tools available today</p>
                    </div>
                    <div class="stat">
                        <strong>{{ count($categories) }}</strong>
                        <p>Focused categories</p>
                    </div>
                    <div class="stat">
                        <strong>100%</strong>
                        <p>Client-side privacy</p>
                    </div>
                </div>
            </div>
            <div class="hero-side">
                <span class="mini-kicker">Platform Architecture</span>
                <h2 style="margin-top:16px; margin-bottom:12px; font-size:1.35rem;">Built for speed, accuracy, and data confidentiality</h2>
                <p>
                    WebToolsStation is engineered to deliver immediate results directly in your browser without passing sensitive data to remote servers.
                </p>
                <div class="mini-stack" style="margin-top:18px;">
                    <div class="mini-card">
                        <strong>Local Execution</strong>
                        <p>Formatting, hashing, parsing, and inspections run in client-side memory using modern JavaScript and Web APIs.</p>
                    </div>
                    <div class="mini-card">
                        <strong>Zero Friction</strong>
                        <p>No mandatory logins, API tokens, cookie paywalls, or usage caps on any standard browser utilities.</p>
                    </div>
                    <div class="mini-card">
                        <strong>In-Depth Documentation</strong>
                        <p>Each utility is accompanied by worked examples, common mistakes, technical standards, and related guides.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="page-section" id="categories" style="border-bottom:1px solid rgba(0, 109, 191, 0.08);">
        <div class="shell">
            <div class="section-head">
                <div>
                    <div class="section-kicker">Tool Categories</div>
                    <h2>Explore Tools by Category</h2>
                </div>
                <p>Browse our curated collections organized by technical domain and everyday workflow requirements.</p>
            </div>
            <div class="page-grid">
                @foreach ($categories as $cat)
                    <article class="card click-card">
                        <div style="display:flex; justify-content:space-between; align-items:center;">
                            <div class="tool-icon">{{ $cat['icon'] }}</div>
                            <span class="tool-badge" style="background:#eaf2fb; color:var(--brand-dark); font-weight:600;">Category</span>
                        </div>
                        <h3 style="margin-top:14px;">{{ $cat['name'] }}</h3>
                        <p>{{ $cat['tagline'] }}</p>
                        <a class="card-link" href="{{ url('/categories/' . $cat['slug']) }}">Explore category <span aria-hidden="true">→</span></a>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="page-section" id="tool-grid">
        <div class="shell">
            <div class="section-head">
                <div>
                    <div class="section-kicker">All Tools</div>
                    <h2>All {{ $toolCount }} Online Utilities</h2>
                </div>
                <p>Use the live search filter below to find tools instantly by name, keyword, or task.</p>
            </div>

            <div class="tool-filter-bar" style="margin:24px 0 28px; display:flex; flex-direction:column; gap:14px;">
                <div style="display:flex; gap:12px; align-items:center; flex-wrap:wrap;">
                    <input type="text" id="tool-search" class="tool-field" style="flex:1; min-width:200px; max-width:560px; padding:12px 16px; font-size:1rem; border-radius:10px; border:1px solid var(--border); background:#fff;" placeholder="Search tools (e.g. JSON, Base64, Regex, PDF, UUID)..." aria-label="Search tools">
                    <span id="tool-count-badge" class="tool-badge" style="background:var(--brand); color:#fff; font-weight:600; padding:8px 14px; border-radius:8px; white-space:nowrap;">Showing {{ $toolCount }} tools</span>
                </div>
                <div style="display:flex; flex-wrap:wrap; gap:8px;" id="filter-chips">
                    <button type="button" class="button button-primary filter-chip active" data-filter="all" style="font-size:0.88rem; padding:6px 14px;">All ({{ $toolCount }})</button>
                    @foreach ($categories as $cat)
                        <button type="button" class="button button-ghost filter-chip" data-filter="{{ $cat['slug'] }}" style="font-size:0.88rem; padding:6px 14px;">{{ $cat['name'] }}</button>
                    @endforeach
                </div>
            </div>

            <div class="tool-grid" id="tools-container">
                @foreach ($tools as $tool)
                    <article class="card click-card tool-item" data-category="{{ $tool['category_slug'] }}" data-title="{{ strtolower($tool['title']) }}" data-desc="{{ strtolower($tool['description']) }}">
                        <div class="tool-icon">{{ $tool['icon'] }}</div>
                        <div class="tool-badge">{{ $tool['category'] }}</div>
                        <h3 style="margin-top:14px;">{{ $tool['title'] }}</h3>
                        <p>{{ $tool['description'] }}</p>
                        <a class="card-link" href="{{ url('/tools/' . $tool['slug']) }}">Launch tool <span aria-hidden="true">→</span></a>
                    </article>
                @endforeach
            </div>

            <div id="no-tools-found" style="display:none; text-align:center; padding:48px 20px; background:#fff; border-radius:14px; border:1px dashed var(--line); margin-top:20px;">
                <h3 style="color:var(--brand-dark);">No matching tools found</h3>
                <p style="color:var(--muted); margin-top:8px;">Try searching for different keywords like JSON, Base64, Regex, PDF, or UUID.</p>
                <button type="button" id="reset-search-btn" class="button button-secondary" style="margin-top:16px;">Reset Search</button>
            </div>
        </div>
    </section>

    <section class="page-section" style="background:rgba(255,255,255,0.7); border-top:1px solid rgba(0, 109, 191, 0.08); border-bottom:1px solid rgba(0, 109, 191, 0.08);">
        <div class="shell">
            <div class="section-head">
                <div>
                    <div class="section-kicker">Technical Guides</div>
                    <h2>In-Depth Workflow Tutorials & References</h2>
                </div>
                <p>Read practical guides explaining data encoding standards, regex patterns, formatting best practices, and error troubleshooting.</p>
            </div>
            <div class="tool-grid">
                @foreach ($latestGuides as $index => $guide)
                    <article class="card click-card">
                        <div class="tool-icon">G{{ $index + 1 }}</div>
                        <h3 style="margin-top:14px;">{{ $guide['title'] }}</h3>
                        <p>{{ $guide['seo_description'] }}</p>
                        <a class="card-link" href="{{ url('/guides/' . $guide['slug']) }}">Read guide <span aria-hidden="true">→</span></a>
                    </article>
                @endforeach
            </div>
            <div style="text-align:center; margin-top:28px;">
                <a class="button button-secondary" href="{{ url('/guides') }}">View All Guides →</a>
            </div>
        </div>
    </section>

    <section class="page-section">
        <div class="shell page-layout">
            <div class="page-copy">
                <div class="page-header-block">
                    <div class="section-kicker">Platform Philosophy</div>
                    <h2 style="margin-top:16px;">Reliable, Transparent, and Private Online Utilities</h2>
                    <p style="margin-top:16px;">
                        WebToolsStation is built to solve immediate technical tasks without clutter, delays, or data collection.
                        Whether you are inspecting an API response, cleaning text for an article, testing regex syntax, or checking PDF metadata, each tool is designed to provide immediate clarity.
                    </p>
                </div>

                <div class="page-sections">
                    <article class="page-section-card">
                        <h3>Client-Side Privacy by Design</h3>
                        <p>
                            Most online tool platforms transmit your pasted inputs, tokens, and files to remote servers for processing.
                            WebToolsStation takes a privacy-first approach: whenever technically feasible, operations run locally in your browser using modern Web APIs.
                            Your payloads and documents remain in temporary browser memory and are discarded as soon as the session ends.
                        </p>
                    </article>
                    <article class="page-section-card">
                        <h3>Clear Technical Guidance & Examples</h3>
                        <p>
                            A tool should do more than present an empty input box. Every utility on WebToolsStation includes practical worked examples, common error checklists, and technical standards so you can verify results before copying them into production workflows.
                        </p>
                    </article>
                    <article class="page-section-card">
                        <h3>Honest Operating Boundaries</h3>
                        <p>
                            Browser utilities are great for quick debugging and conversions. However, for multi-gigabyte data pipelines or automated batch tasks, command-line scripts or dedicated servers are more appropriate. We clearly document the limits of every tool so you know when to transition to enterprise tooling.
                        </p>
                    </article>
                </div>

                <div class="page-section-card" style="margin-top:24px;">
                    <h2>Frequently Asked Questions</h2>
                    <div class="tool-stack" style="margin-top:18px;">
                        <details class="mini-card">
                            <summary><strong>Is my data safe when using WebToolsStation?</strong></summary>
                            <p style="margin-top:10px;">Yes. WebToolsStation executes data transformations, formatting, hashing, and parsing locally inside your browser runtime. Your inputs are never transmitted to our servers or stored in any database.</p>
                        </details>
                        <details class="mini-card">
                            <summary><strong>Are these tools free for commercial use?</strong></summary>
                            <p style="margin-top:10px;">Yes. All {{ $toolCount }} tools on WebToolsStation are 100% free to use for both personal and commercial projects without licensing fees or mandatory accounts.</p>
                        </details>
                        <details class="mini-card">
                            <summary><strong>Do I need to install any browser extensions or software?</strong></summary>
                            <p style="margin-top:10px;">No installation or extensions are needed. All utilities run directly inside any modern web browser on desktop, tablet, or mobile.</p>
                        </details>
                        <details class="mini-card">
                            <summary><strong>What should I do if a tool produces an unexpected result?</strong></summary>
                            <p style="margin-top:10px;">Check the "Common Mistakes" and "Worked Example" sections on the tool page to ensure your input format is valid. If you believe there is a bug, you can report it directly via our <a href="{{ url('/contact') }}" style="color:var(--brand); text-decoration:underline;">Contact Page</a>.</p>
                        </details>
                    </div>
                </div>
            </div>

            <aside class="page-copy">
                <div class="page-side-stack">
                    <div>
                        <div class="section-kicker">Platform Trust & Identity</div>
                        <h2 style="margin-top:14px;">Operator & Editorial Standards</h2>
                    </div>
                    <div class="page-grid">
                        <div class="card">
                            <div class="tool-icon">TJ</div>
                            <h3 style="margin-top:12px;">Founded by TJ Verse</h3>
                            <p>Owned and maintained by TJ Verse, providing dependable web utilities and technical guides.</p>
                            <a class="card-link" href="{{ url('/authors/tj-verse') }}">Author Profile →</a>
                        </div>
                        <div class="card">
                            <div class="tool-icon">DP</div>
                            <h3 style="margin-top:12px;">Data Privacy</h3>
                            <p>Transparent privacy terms and strict zero-retention principles for client data.</p>
                            <a class="card-link" href="{{ url('/privacy-policy') }}">Privacy Policy →</a>
                        </div>
                        <div class="card">
                            <div class="tool-icon">DC</div>
                            <h3 style="margin-top:12px;">Disclaimer & Terms</h3>
                            <p>Clear usage terms and operating boundaries for all browser-based calculations.</p>
                            <a class="card-link" href="{{ url('/disclaimer') }}">Legal Disclaimer →</a>
                        </div>
                        <div class="card">
                            <div class="tool-icon">CT</div>
                            <h3 style="margin-top:12px;">Active Support</h3>
                            <p>Direct contact channel for bug reports, tool requests, and general feedback.</p>
                            <a class="card-link" href="{{ url('/contact') }}">Contact Page →</a>
                        </div>
                    </div>
                </div>
            </aside>
        </div>
    </section>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('tool-search');
    const toolItems = document.querySelectorAll('.tool-item');
    const filterChips = document.querySelectorAll('.filter-chip');
    const countBadge = document.getElementById('tool-count-badge');
    const noResults = document.getElementById('no-tools-found');
    const resetBtn = document.getElementById('reset-search-btn');

    let activeFilter = 'all';

    function filterTools() {
        const query = (searchInput.value || '').trim().toLowerCase();
        let visibleCount = 0;

        toolItems.forEach(function(item) {
            const category = item.getAttribute('data-category') || '';
            const title = item.getAttribute('data-title') || '';
            const desc = item.getAttribute('data-desc') || '';

            const matchesCategory = (activeFilter === 'all' || category === activeFilter);
            const matchesQuery = !query || title.includes(query) || desc.includes(query);

            if (matchesCategory && matchesQuery) {
                item.style.display = '';
                visibleCount++;
            } else {
                item.style.display = 'none';
            }
        });

        countBadge.textContent = 'Showing ' + visibleCount + ' tool' + (visibleCount === 1 ? '' : 's');
        noResults.style.display = visibleCount === 0 ? 'block' : 'none';
    }

    if (searchInput) {
        searchInput.addEventListener('input', filterTools);
    }

    filterChips.forEach(function(chip) {
        chip.addEventListener('click', function() {
            filterChips.forEach(function(c) {
                c.classList.remove('active', 'button-primary');
                c.classList.add('button-ghost');
            });
            chip.classList.remove('button-ghost');
            chip.classList.add('active', 'button-primary');
            activeFilter = chip.getAttribute('data-filter') || 'all';
            filterTools();
        });
    });

    if (resetBtn) {
        resetBtn.addEventListener('click', function() {
            searchInput.value = '';
            filterChips[0].click();
        });
    }
});
</script>
@endsection