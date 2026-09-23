@extends('site.layout')

@section('content')
    <div class="shell" style="padding-top:12px; padding-bottom:48px;">
        <!-- Breadcrumb -->
        <nav class="breadcrumbs" aria-label="Breadcrumb" style="font-size:0.78rem; margin-bottom:4px;">
            <a href="{{ url('/') }}">Home</a>
            <span aria-hidden="true">/</span>
            <a href="{{ url('/categories/' . $tool['category_slug']) }}">{{ $tool['category'] }}</a>
            <span aria-hidden="true">/</span>
            <span style="color:var(--text); font-weight:600;">{{ $tool['title'] }}</span>
        </nav>

        <!-- Tool Header -->
        <header class="tool-header-block" style="padding:4px 0 8px;">
            <div class="tool-title-row">
                <div class="tool-title-group">
                    <div class="tool-page-icon" style="width:34px; height:34px; font-size:0.9rem;">{{ $tool['icon'] }}</div>
                    <div>
                        <div style="display:flex; align-items:center; gap:8px; flex-wrap:wrap;">
                            <h1 class="tool-page-title" style="font-size:1.4rem; display:inline;">{{ $tool['title'] }}</h1>
                            <a href="{{ url('/categories/' . $tool['category_slug']) }}" class="badge" style="text-decoration:none; background:var(--surface-subtle); color:var(--text-muted); font-size:0.72rem; padding:1px 6px; border-radius:4px; border:1px solid var(--border);">
                                {{ $tool['category'] }}
                            </a>
                        </div>
                    </div>
                </div>

                <div class="privacy-badge" title="All operations run entirely in your web browser. No inputs or files are sent to any remote server.">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                    🔒 Processed locally in your browser · Zero uploads
                </div>
            </div>

            <p class="tool-page-desc" style="margin:4px 0 0; font-size:0.88rem; color:var(--text-muted);">{{ $tool['description'] }}</p>
        </header>

        <!-- MAIN HERO TOOL WORKSPACE -->
        @php
            $textCodeTools = [
                'json-formatter', 'base64-encode-decode', 'url-encode-decode', 'jwt-decoder',
                'html-entity-encode-decode', 'csv-to-json-converter', 'text-to-binary-converter',
                'binary-to-text-converter', 'text-case-converter', 'line-sorter', 'text-diff-checker',
                'url-parser', 'regex-tester'
            ];
            $generatorTools = ['uuid-generator', 'password-generator', 'lorem-ipsum-generator', 'slug-generator'];
            $colorTools = ['color-converter', 'hex-to-rgb-converter', 'rgb-to-hex-converter'];
            $imageTools = ['favicon-generator', 'png-to-jpg-converter', 'jpg-to-png-converter'];
            $pdfTools = ['pdf-page-counter', 'pdf-metadata-viewer', 'pdf-text-finder', 'pdf-security-checker'];
            $metricsTools = ['word-counter', 'timestamp-converter', 'sha256-hash-generator'];
            $minifierTools = ['html-minifier', 'css-minifier', 'javascript-minifier', 'json-minifier', 'xml-minifier'];
            $formatterTools = ['html-formatter', 'css-formatter', 'javascript-formatter', 'xml-formatter', 'sql-formatter'];
            $validatorTools = ['json-validator', 'xml-validator'];
            $converterTools = ['json-to-xml-converter', 'xml-to-json-converter', 'json-to-csv-converter', 'yaml-to-json-converter', 'json-to-yaml-converter'];
            $devHelperTools = ['ulid-generator', 'random-string-generator', 'hash-generator', 'hmac-generator', 'json-diff-checker', 'query-string-parser', 'cron-expression-helper'];
            $devBatch1Tools = [
                'yaml-formatter', 'yaml-validator', 'jwt-generator', 'nanoid-generator',
                'sha1-hash-generator', 'sha512-hash-generator', 'md5-hash-generator',
                'curl-command-generator', 'http-header-analyzer', 'mime-type-lookup',
            ];
            $textToolsBatch2 = [
                'remove-duplicate-lines', 'remove-empty-lines', 'find-and-replace',
                'reverse-text', 'markdown-to-html',
            ];
            $devBatch2bTools = [
                'html-to-markdown', 'unicode-inspector', 'text-escape-unescape',
                'csv-viewer', 'tsv-to-csv-converter',
            ];
        @endphp

        <section class="tool-workspace-hero" id="tool-workspace" aria-label="{{ $tool['title'] }} Workspace">
            @if (in_array($tool['slug'], $devBatch2bTools))
                @include('site.tools.workspace-dev-batch2b')
            @elseif (in_array($tool['slug'], $textToolsBatch2))
                @include('site.tools.workspace-text-tools')
            @elseif (in_array($tool['slug'], $devBatch1Tools))
                @include('site.tools.workspace-dev-batch1')
            @elseif (in_array($tool['slug'], $minifierTools))
                @include('site.tools.workspace-minifier')
            @elseif (in_array($tool['slug'], $formatterTools))
                @include('site.tools.workspace-formatter')
            @elseif (in_array($tool['slug'], $validatorTools))
                @include('site.tools.workspace-validator')
            @elseif (in_array($tool['slug'], $converterTools))
                @include('site.tools.workspace-converter')
            @elseif (in_array($tool['slug'], $devHelperTools))
                @include('site.tools.workspace-dev-helpers')
            @elseif (in_array($tool['slug'], $textCodeTools))
                @include('site.tools.workspace-text-code')
            @elseif (in_array($tool['slug'], $generatorTools))
                @include('site.tools.workspace-generator')
            @elseif (in_array($tool['slug'], $colorTools))
                @include('site.tools.workspace-color')
            @elseif (in_array($tool['slug'], $imageTools))
                @include('site.tools.workspace-image')
            @elseif (in_array($tool['slug'], $pdfTools))
                @include('site.tools.workspace-pdf')
            @elseif (in_array($tool['slug'], $metricsTools))
                @include('site.tools.workspace-metrics')
            @endif
        </section>

        <!-- CONTENT SECTIONS BELOW WORKSPACE (Strictly Preserving All AdSense Depth & Guides) -->
        <div class="content-section">
            <!-- 1. Quick Steps & Use Cases -->
            <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(320px, 1fr)); gap:20px; margin-bottom:24px;">
                <div class="content-card" style="margin-bottom:0;">
                    <h2>How to use this {{ $tool['title'] }}</h2>
                    <ul class="detail-list" style="margin-top:12px;">
                        @foreach ($tool['use_steps'] as $item)
                            <li>{{ $item }}</li>
                        @endforeach
                    </ul>
                </div>
                <div class="content-card" style="margin-bottom:0;">
                    <h2>Where this tool helps most</h2>
                    <ul class="detail-list" style="margin-top:12px;">
                        @foreach ($tool['use_cases'] as $item)
                            <li>{{ $item }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <!-- 2. Practical Worked Example -->
            @if (!empty($tool['worked_example']))
                <div class="content-card">
                    <div style="font-size:0.75rem; font-weight:700; text-transform:uppercase; letter-spacing:0.06em; color:var(--brand); margin-bottom:6px;">Verified Reference</div>
                    <h2>Practical Worked Example for {{ $tool['title'] }}</h2>
                    <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(280px, 1fr)); gap:14px; margin-top:16px;">
                        <div style="background:var(--surface-subtle); border:1px solid var(--border); border-radius:var(--radius-md); padding:14px;">
                            <strong style="display:block; font-size:0.82rem; color:var(--text-muted); text-transform:uppercase; letter-spacing:0.04em;">
                                {{ $tool['worked_example']['input_label'] ?? 'Sample Input' }}:
                            </strong>
                            <pre style="margin-top:8px; background:#ffffff; border:1px solid var(--border); border-radius:var(--radius-sm); padding:10px; font-size:0.85rem; font-family:var(--font-mono); overflow-x:auto; white-space:pre-wrap; word-break:break-all;"><code>{{ $tool['worked_example']['input'] }}</code></pre>
                        </div>
                        <div style="background:var(--surface-subtle); border:1px solid var(--border); border-radius:var(--radius-md); padding:14px;">
                            <strong style="display:block; font-size:0.82rem; color:var(--text-muted); text-transform:uppercase; letter-spacing:0.04em;">
                                {{ $tool['worked_example']['output_label'] ?? 'Expected Output' }}:
                            </strong>
                            <pre style="margin-top:8px; background:#ffffff; border:1px solid var(--border); border-radius:var(--radius-sm); padding:10px; font-size:0.85rem; font-family:var(--font-mono); overflow-x:auto; white-space:pre-wrap; word-break:break-all;"><code>{{ $tool['worked_example']['output'] }}</code></pre>
                        </div>
                    </div>
                    <p style="margin-top:14px; font-size:0.92rem; color:var(--text-muted); line-height:1.6;">
                        <strong style="color:var(--text);">Step-by-step walkthrough:</strong> {{ $tool['worked_example']['explanation'] }}
                    </p>
                </div>
            @endif

            <!-- 3. Things to check & Privacy Note -->
            <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(320px, 1fr)); gap:20px; margin-bottom:24px;">
                <div class="content-card" style="margin-bottom:0;">
                    <h2>Things to check before relying on results</h2>
                    <ul class="detail-list" style="margin-top:12px;">
                        @foreach ($tool['watch_out_for'] as $item)
                            <li>{{ $item }}</li>
                        @endforeach
                    </ul>
                </div>
                <div class="content-card" style="margin-bottom:0;">
                    <h2>Client-Side Processing & Privacy</h2>
                    <p style="margin-top:8px; line-height:1.65;">{{ $tool['privacy_note'] }}</p>
                </div>
            </div>

            <!-- 4. Common Mistakes & Output Interpretation -->
            @if (!empty($tool['common_mistakes']) || !empty($tool['output_notes']))
                <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(320px, 1fr)); gap:20px; margin-bottom:24px;">
                    <div class="content-card" style="margin-bottom:0;">
                        <h2>Common mistakes to avoid</h2>
                        @if (!empty($tool['common_mistakes']))
                            <ul class="detail-list" style="margin-top:12px;">
                                @foreach ($tool['common_mistakes'] as $item)
                                    <li>{{ $item }}</li>
                                @endforeach
                            </ul>
                        @else
                            <p>Review the source input carefully before assuming the tool output is invalid or incomplete.</p>
                        @endif
                    </div>
                    <div class="content-card" style="margin-bottom:0;">
                        <h2>How to interpret output</h2>
                        @if (!empty($tool['output_notes']))
                            <ul class="detail-list" style="margin-top:12px;">
                                @foreach ($tool['output_notes'] as $item)
                                    <li>{{ $item }}</li>
                                @endforeach
                            </ul>
                        @else
                            <p>Verify output against source specifications and test downstream consumers before deployment.</p>
                        @endif
                    </div>
                </div>
            @endif

            <!-- 5. Technical Specifications -->
            @if (!empty($tool['technical_notes']))
                <div class="content-card">
                    <div style="font-size:0.75rem; font-weight:700; text-transform:uppercase; letter-spacing:0.06em; color:var(--brand); margin-bottom:6px;">Specifications</div>
                    <h2>Execution architecture and standards for {{ $tool['title'] }}</h2>
                    <p style="margin-top:10px; line-height:1.7;">{{ $tool['technical_notes'] }}</p>
                </div>
            @endif

            <!-- 7. When to Use a Different Workflow -->
            @if (!empty($tool['better_alternative']))
                <div class="content-card">
                    <h2>When to use a different workflow</h2>
                    <ul class="detail-list" style="margin-top:12px;">
                        @foreach ($tool['better_alternative'] as $item)
                            <li>{{ $item }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- 8. Frequently Asked Questions -->
            <div class="content-card">
                <h2>Frequently Asked Questions</h2>
                <div style="display:flex; flex-direction:column; gap:12px; margin-top:16px;">
                    @foreach ($tool['faq'] as $item)
                        <details style="background:var(--surface-subtle); border:1px solid var(--border); border-radius:var(--radius-md); padding:14px 18px; cursor:pointer;">
                            <summary style="font-weight:600; color:var(--text); font-size:0.95rem; user-select:none;">
                                {{ $item['question'] }}
                            </summary>
                            <p style="margin-top:10px; margin-bottom:0; font-size:0.92rem; color:var(--text-muted); line-height:1.65;">
                                {{ $item['answer'] }}
                            </p>
                        </details>
                    @endforeach
                </div>
            </div>

            <!-- 9. About Tool & Category Context -->
            <div class="content-card">
                <h2>About {{ $tool['title'] }}</h2>
                <p style="margin-top:8px;">{{ $tool['summary'] }}</p>
                <ul class="detail-list" style="margin-top:12px;">
                    @foreach ($tool['details'] as $detail)
                        <li>{{ $detail }}</li>
                    @endforeach
                </ul>
                <div style="margin-top:20px; display:flex; gap:10px; flex-wrap:wrap;">
                    <a class="btn btn-secondary" href="{{ url('/categories/' . $tool['category_slug']) }}">
                        Explore All {{ $tool['category'] }}
                    </a>
                    <a class="btn btn-ghost" href="{{ url('/') }}">
                        View All Free Web Tools
                    </a>
                </div>
            </div>

            <!-- 10. Related Tools -->
            @if (!empty($tool['related']))
                <div style="margin-top:32px;">
                    <h2 style="font-size:1.25rem; font-weight:700; margin-bottom:14px; color:var(--text);">Related Tools</h2>
                    <div style="display:grid; grid-template-columns:repeat(auto-fill, minmax(260px, 1fr)); gap:14px;">
                        @foreach ($tool['related'] as $related)
                            <a href="{{ url('/tools/' . $related['slug']) }}" class="card click-card" style="text-decoration:none; padding:16px;">
                                <div style="display:flex; align-items:center; gap:10px; margin-bottom:8px;">
                                    <div class="tool-icon" style="width:32px; height:32px; font-size:0.75rem;">{{ $related['icon'] }}</div>
                                    <h3 style="margin:0; font-size:0.95rem; font-weight:600; color:var(--text);">{{ $related['title'] }}</h3>
                                </div>
                                <p style="font-size:0.83rem; color:var(--text-muted); line-height:1.45; margin:0 0 10px;">{{ $related['summary'] }}</p>
                                <span style="font-size:0.82rem; font-weight:600; color:var(--brand);">Open tool →</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- 11. Related Guides -->
            @if (!empty($tool['related_guides']))
                <div style="margin-top:32px;">
                    <h2 style="font-size:1.25rem; font-weight:700; margin-bottom:14px; color:var(--text);">Helpful Engineering Guides</h2>
                    <div style="display:grid; grid-template-columns:repeat(auto-fill, minmax(280px, 1fr)); gap:14px;">
                        @foreach ($tool['related_guides'] as $guide)
                            <a href="{{ url('/guides/' . $guide['slug']) }}" class="card click-card" style="text-decoration:none; padding:16px;">
                                <div style="display:flex; align-items:center; gap:10px; margin-bottom:8px;">
                                    <div class="tool-icon" style="width:32px; height:32px; font-size:0.75rem;">GD</div>
                                    <h3 style="margin:0; font-size:0.95rem; font-weight:600; color:var(--text);">{{ $guide['title'] }}</h3>
                                </div>
                                <p style="font-size:0.83rem; color:var(--text-muted); line-height:1.45; margin:0 0 10px;">{{ $guide['seo_description'] }}</p>
                                <span style="font-size:0.82rem; font-weight:600; color:var(--brand);">Read guide →</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Toast Notification -->
    <div id="copy-toast" class="toast" role="status" aria-live="polite"></div>
@endsection

@section('scripts')
    @if ($tool['category'] === 'PDF Tools' || in_array($tool['slug'], $pdfTools))
        <script type="module">
            window.pdfjsLibPromise = import("https://cdn.jsdelivr.net/npm/pdfjs-dist@4/build/pdf.min.mjs")
                .then((pdfjsLib) => {
                    pdfjsLib.GlobalWorkerOptions.workerSrc = "https://cdn.jsdelivr.net/npm/pdfjs-dist@4/build/pdf.worker.min.mjs";
                    return pdfjsLib;
                });
        </script>
    @endif
    @if ($tool['category'] === 'Text Tools' || in_array($tool['slug'], array_merge($textToolsBatch2, $devBatch2bTools)))
        <script src="/js/text-tools.js"></script>
    @endif
    @if ($tool['category'] === 'Developer Tools' || $tool['category'] === 'Security Tools' || $tool['category'] === 'Color Tools' || in_array($tool['slug'], array_merge($devBatch1Tools, $devBatch2bTools, $minifierTools, $formatterTools, $validatorTools, $converterTools, $devHelperTools, $textCodeTools, $generatorTools, $colorTools, $imageTools, $metricsTools)))
        <script src="/js/developer-tools.js"></script>
    @endif
    <script>
        const currentToolSlug = "{{ $tool['slug'] }}";

        function setOutput(value, isError = false) {
            const el = document.getElementById("tool-output");
            if (!el) return;
            el.textContent = value;
            el.style.color = isError ? "var(--danger)" : "var(--text)";
        }

        let toastTimer;
        function showToast(message, isError = false) {
            const toast = document.getElementById("copy-toast");
            if (!toast) return;
            toast.textContent = message;
            toast.classList.toggle("error", isError);
            toast.classList.add("show");
            window.clearTimeout(toastTimer);
            toastTimer = window.setTimeout(() => {
                toast.classList.remove("show");
            }, 2200);
        }

        async function copyOutput(id) {
            const target = document.getElementById(id);
            if (!target) return;
            const text = (target.value !== undefined ? target.value : target.textContent) || "";
            if (!text.trim()) {
                showToast("Nothing to copy yet.", true);
                return;
            }
            try {
                await navigator.clipboard.writeText(text);
                showToast("Copied to clipboard!");
            } catch (err) {
                showToast("Copy failed. Please allow clipboard permissions.", true);
            }
        }

        function downloadOutput(id, filename) {
            const text = document.getElementById(id)?.textContent || "";
            if (!text.trim()) {
                showToast("No data to download.", true);
                return;
            }
            const blob = new Blob([text], { type: "application/json;charset=utf-8" });
            const url = URL.createObjectURL(blob);
            const a = document.createElement("a");
            a.href = url;
            a.download = filename;
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            URL.revokeObjectURL(url);
            showToast("Downloaded " + filename);
        }

        function clearInput() {
            const inputs = [
                'json-input', 'base64-input', 'url-input', 'jwt-input', 'html-input',
                'csv-input', 'binary-text-input', 'binary-input', 'text-input',
                'line-sort-input', 'diff-left', 'diff-right', 'url-parse-input',
                'regex-pattern', 'regex-text', 'hash-input'
            ];
            inputs.forEach(id => {
                const el = document.getElementById(id);
                if (el) el.value = '';
            });
            const output = document.getElementById('tool-output');
            if (output) output.textContent = '';
            const matches = document.getElementById('regex-matches');
            if (matches) matches.innerHTML = '';
            showToast("Inputs cleared.");
        }

        async function pasteFromClipboard() {
            try {
                const text = await navigator.clipboard.readText();
                const inputs = [
                    'json-input', 'base64-input', 'url-input', 'jwt-input', 'html-input',
                    'csv-input', 'binary-text-input', 'binary-input', 'text-input',
                    'line-sort-input', 'diff-left', 'url-parse-input', 'regex-text', 'hash-input'
                ];
                for (const id of inputs) {
                    const el = document.getElementById(id);
                    if (el) {
                        el.value = text;
                        showToast("Pasted from clipboard!");
                        return;
                    }
                }
            } catch (err) {
                showToast("Unable to read clipboard. Please paste manually.", true);
            }
        }

        // Sample Data Provider
        function loadSample() {
            const samples = {
                'json-formatter': '{"name":"WebToolsStation","version":"2.0.0","active":true,"tags":["developer","utilities","privacy-first"],"author":{"handle":"webtools","verified":true}}',
                'base64-encode-decode': 'WebToolsStation: High performance browser-based utilities.',
                'url-encode-decode': 'https://webtoolsstation.test/search?q=developer tools & privacy=100%',
                'jwt-decoder': 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkFsZXggVmFzb3lhIiwiYWRtaW4iOnRydWUsImlhdCI6MTUxNjIzOTAyMn0.SflKxwRJSMeKKF2QT4fwpMeJf36POk6yJV_adQssw5c',
                'html-entity-encode-decode': '<div class="alert alert-info">Hello & welcome to "WebToolsStation" <2026>!</div>',
                'csv-to-json-converter': "id,name,role,department\n1,Alex Rivera,Tech Lead,Engineering\n2,Taylor Chen,Designer,Product\n3,Jordan Smith,Analyst,Data",
                'text-to-binary-converter': 'WebTools',
                'binary-to-text-converter': '01010111 01100101 01100010 01010100 01101111 01101111 01101100 01110011',
                'text-case-converter': 'hello world modern developer tools platform',
                'line-sorter': "Database Management\nAPI Gateway\nAuthentication\nContainerization\nObservability\nCI/CD Pipeline",
                'text-diff-checker': { left: "WebToolsStation provides fast client-side utilities.", right: "WebToolsStation provides secure client-side utilities." },
                'url-parser': 'https://api.webtoolsstation.test:8443/v1/endpoints?filter=active&sort=desc#specifications',
                'regex-tester': { pattern: '[A-Z0-9._%+-]+@[A-Z0-9.-]+\\.[A-Z]{2,}', flags: 'gi', text: 'Contact us at support@webtoolsstation.test or dev-team@internal.example.org.' }
            };

            const sample = samples[currentToolSlug];
            if (!sample) return;

            if (currentToolSlug === 'regex-tester') {
                document.getElementById('regex-pattern').value = sample.pattern;
                document.getElementById('regex-flags').value = sample.flags;
                document.getElementById('regex-text').value = sample.text;
                runRegex();
            } else if (currentToolSlug === 'text-diff-checker') {
                document.getElementById('diff-left').value = sample.left;
                document.getElementById('diff-right').value = sample.right;
                checkTextDiff();
            } else {
                const map = {
                    'json-formatter': 'json-input',
                    'base64-encode-decode': 'base64-input',
                    'url-encode-decode': 'url-input',
                    'jwt-decoder': 'jwt-input',
                    'html-entity-encode-decode': 'html-input',
                    'csv-to-json-converter': 'csv-input',
                    'text-to-binary-converter': 'binary-text-input',
                    'binary-to-text-converter': 'binary-input',
                    'text-case-converter': 'text-input',
                    'line-sorter': 'line-sort-input',
                    'url-parser': 'url-parse-input'
                };
                const id = map[currentToolSlug];
                if (id && document.getElementById(id)) {
                    document.getElementById(id).value = sample;
                    showToast("Sample loaded.");
                }
            }
        }

        function loadSampleWordCount() {
            const sampleText = "WebToolsStation is an engineering-first web utility suite built with strict adherence to client-side computing and digital privacy. Every utility runs synchronously within your local V8 JavaScript or WebAssembly runtime. No sensitive payloads, database tokens, proprietary code snippets, or confidential documents are transmitted across internet connections. This guarantees immediate transformation with zero network latency and maximum operational confidentiality.";
            const el = document.getElementById('word-input');
            if (el) {
                el.value = sampleText;
                countWords();
                showToast("Sample text loaded.");
            }
        }

        // Global hotkey: Ctrl/Cmd + Enter to trigger primary action
        document.addEventListener('keydown', (e) => {
            if ((e.ctrlKey || e.metaKey) && e.key === 'Enter') {
                e.preventDefault();
                triggerPrimaryAction();
            }
        });

        let debounceTimer;
        function debounceTrigger(fn, delay = 300) {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(fn, delay);
        }

        const autoProcessTools = [
            'json-formatter', 'base64-encode-decode', 'url-encode-decode', 'jwt-decoder',
            'html-entity-encode-decode', 'text-to-binary-converter', 'binary-to-text-converter',
            'text-case-converter', 'word-counter', 'color-converter', 'hex-to-rgb-converter',
            'rgb-to-hex-converter', 'slug-generator', 'html-minifier', 'css-minifier',
            'javascript-minifier', 'json-minifier', 'xml-minifier', 'html-formatter',
            'css-formatter', 'javascript-formatter', 'xml-formatter', 'sql-formatter',
            'json-validator', 'xml-validator', 'yaml-formatter', 'yaml-validator',
            'remove-duplicate-lines', 'remove-empty-lines', 'find-and-replace',
            'reverse-text', 'markdown-to-html', 'html-to-markdown', 'unicode-inspector',
            'text-escape-unescape', 'csv-viewer', 'tsv-to-csv-converter', 'query-string-parser',
            'csv-to-json-converter', 'json-to-xml-converter', 'xml-to-json-converter',
            'json-to-csv-converter', 'yaml-to-json-converter', 'json-to-yaml-converter'
        ];

        document.addEventListener('DOMContentLoaded', () => {
            if (autoProcessTools.includes(currentToolSlug)) {
                const workspace = document.getElementById('tool-workspace');
                if (workspace) {
                    workspace.addEventListener('input', (e) => {
                        if (e.target && (e.target.tagName === 'TEXTAREA' || (e.target.tagName === 'INPUT' && e.target.type === 'text') || e.target.tagName === 'SELECT')) {
                            debounceTrigger(triggerPrimaryAction, 300);
                        }
                    });
                }
            }
        });

        function triggerPrimaryAction() {
            const actionMap = {
                'json-formatter': formatJson,
                'base64-encode-decode': encodeBase64,
                'url-encode-decode': encodeUrl,
                'jwt-decoder': decodeJwt,
                'html-entity-encode-decode': encodeHtmlEntities,
                'csv-to-json-converter': convertCsvToJson,
                'text-to-binary-converter': convertTextToBinary,
                'binary-to-text-converter': convertBinaryToText,
                'text-case-converter': convertTextCase,
                'line-sorter': () => sortLines('asc'),
                'text-diff-checker': checkTextDiff,
                'url-parser': parseUrl,
                'regex-tester': runRegex,
                'password-generator': generatePassword,
                'uuid-generator': generateUuidList,
                'lorem-ipsum-generator': generateLoremIpsum,
                'slug-generator': generateSlug,
                'sha256-hash-generator': generateHash,
                'timestamp-converter': timestampToDate,
                'color-converter': convertColor,
                'hex-to-rgb-converter': convertHexToRgb,
                'rgb-to-hex-converter': convertRgbToHex,
                // Minifiers
                'html-minifier': runMinifier,
                'css-minifier': runMinifier,
                'javascript-minifier': runMinifier,
                'json-minifier': runMinifier,
                'xml-minifier': runMinifier,
                // Formatters
                'html-formatter': runFormatter,
                'css-formatter': runFormatter,
                'javascript-formatter': runFormatter,
                'xml-formatter': runFormatter,
                'sql-formatter': runFormatter,
                // Validators
                'json-validator': runValidator,
                'xml-validator': runValidator,
                // Converters
                'json-to-xml-converter': runConverter,
                'xml-to-json-converter': runConverter,
                'json-to-csv-converter': runConverter,
                'yaml-to-json-converter': runConverter,
                'json-to-yaml-converter': runConverter,
                // Dev Helpers & Generators
                'ulid-generator': generateUlids,
                'random-string-generator': generateRandomStrings,
                'hash-generator': computeAllHashes,
                'hmac-generator': computeHmac,
                'json-diff-checker': runJsonDiff,
                'query-string-parser': parseQueryString,
                'cron-expression-helper': evaluateCron,
                // Batch 1 Developer Tools
                'yaml-formatter': runYamlFormatter,
                'yaml-validator': runYamlValidator,
                'jwt-generator': generateJwtToken,
                'nanoid-generator': generateNanoIds,
                'sha1-hash-generator': computeDedicatedHash,
                'sha512-hash-generator': computeDedicatedHash,
                'md5-hash-generator': computeDedicatedHash,
                'curl-command-generator': buildCurlCommand,
                'http-header-analyzer': analyzeHttpHeaders,
                // Batch 2A Text Tools
                'remove-duplicate-lines': runDeduplicateLines,
                'remove-empty-lines': runRemoveEmptyLines,
                'find-and-replace': runFindAndReplace,
                'reverse-text': runReverseText,
                'markdown-to-html': runMarkdownToHtml,
                // Batch 2B Tools
                'html-to-markdown': runHtmlToMarkdown,
                'unicode-inspector': runUnicodeInspector,
                'text-escape-unescape': runTextEscape,
                'csv-viewer': runCsvViewer,
                'tsv-to-csv-converter': runTsvToCsv
            };
            if (actionMap[currentToolSlug]) {
                actionMap[currentToolSlug]();
            }
        }

        // Tool implementations
        function formatJson() {
            try {
                const input = document.getElementById("json-input").value.trim();
                if (!input) return setOutput("Please paste valid JSON first.", true);
                const indentVal = document.getElementById("json-indent")?.value || "2";
                const indent = indentVal === "4" ? 4 : (indentVal === "tab" ? "\t" : 2);
                setOutput(JSON.stringify(JSON.parse(input), null, indent));
            } catch (error) {
                setOutput("JSON Syntax Error: " + error.message, true);
            }
        }

        function minifyJson() {
            try {
                const input = document.getElementById("json-input").value.trim();
                if (!input) return setOutput("Please paste valid JSON first.", true);
                setOutput(JSON.stringify(JSON.parse(input)));
            } catch (error) {
                setOutput("JSON Syntax Error: " + error.message, true);
            }
        }

        function encodeBase64() {
            try {
                const input = document.getElementById("base64-input").value;
                setOutput(btoa(unescape(encodeURIComponent(input))));
            } catch (error) {
                setOutput("Unable to encode this value into Base64.", true);
            }
        }

        function decodeBase64() {
            try {
                const input = document.getElementById("base64-input").value.trim();
                setOutput(decodeURIComponent(escape(atob(input))));
            } catch (error) {
                setOutput("Invalid Base64 sequence. Ensure padding and characters are valid.", true);
            }
        }

        function encodeUrl() {
            setOutput(encodeURIComponent(document.getElementById("url-input").value));
        }

        function decodeUrl() {
            try {
                setOutput(decodeURIComponent(document.getElementById("url-input").value));
            } catch (error) {
                setOutput("Invalid URL-encoded input sequence.", true);
            }
        }

        function decodeJwtPart(part) {
            const normalized = part.replace(/-/g, "+").replace(/_/g, "/");
            const padded = normalized.padEnd(normalized.length + (4 - normalized.length % 4) % 4, "=");
            return JSON.parse(decodeURIComponent(escape(atob(padded))));
        }

        function decodeJwt() {
            try {
                const pieces = document.getElementById("jwt-input").value.trim().split(".");
                if (pieces.length < 2) throw new Error("JWT must contain at least a Header and Payload segment.");
                setOutput(JSON.stringify({ header: decodeJwtPart(pieces[0]), payload: decodeJwtPart(pieces[1]) }, null, 2));
            } catch (error) {
                setOutput("JWT Parse Error: " + error.message, true);
            }
        }

        function timestampToDate() {
            const raw = document.getElementById("timestamp-input").value.trim();
            const num = Number(raw);
            if (!raw || Number.isNaN(num)) return setOutput("Enter a valid Unix timestamp.", true);
            const ms = raw.length <= 10 ? num * 1000 : num;
            const date = new Date(ms);
            setOutput("ISO 8601: " + date.toISOString() + "\nUTC String: " + date.toUTCString() + "\nLocal Time: " + date.toString() + "\nLocale Format: " + date.toLocaleString());
        }

        function dateToTimestamp() {
            const raw = document.getElementById("date-input").value;
            if (!raw) return setOutput("Select a date and time first.", true);
            const date = new Date(raw);
            setOutput("Epoch Seconds: " + Math.floor(date.getTime() / 1000) + "\nEpoch Milliseconds: " + date.getTime());
        }

        function setNowTimestamp() {
            const now = Date.now();
            const input = document.getElementById("timestamp-input");
            if (input) {
                input.value = Math.floor(now / 1000);
                timestampToDate();
            }
        }

        function generateUuidList() {
            const count = Math.min(20, Math.max(1, Number(document.getElementById("uuid-count").value) || 1));
            const values = [];
            for (let i = 0; i < count; i += 1) values.push(crypto.randomUUID());
            setOutput(values.join("\n"));
        }

        async function generateHash() {
            const input = document.getElementById("hash-input").value;
            const buffer = new TextEncoder().encode(input);
            const hashBuffer = await crypto.subtle.digest("SHA-256", buffer);
            const hash = Array.from(new Uint8Array(hashBuffer)).map((b) => b.toString(16).padStart(2, "0")).join("");
            setOutput(hash);
        }

        function runRegex() {
            const matches = document.getElementById("regex-matches");
            if (matches) matches.innerHTML = "";
            try {
                const pattern = document.getElementById("regex-pattern").value;
                const flags = document.getElementById("regex-flags").value;
                const normalizedFlags = flags.includes("g") ? flags : flags + "g";
                const regex = new RegExp(pattern, normalizedFlags);
                const text = document.getElementById("regex-text").value;
                const found = [...text.matchAll(regex)];
                setOutput(found.length ? `${found.length} match(es) identified.` : "No matches found.");
                if (matches) {
                    found.forEach((item, index) => {
                        const div = document.createElement("div");
                        div.style.padding = "4px 0";
                        div.style.borderBottom = "1px solid var(--border)";
                        div.textContent = `Match #${index + 1} [Index ${item.index}]: ${item[0]}`;
                        matches.appendChild(div);
                    });
                }
            } catch (error) {
                setOutput("Regex Error: " + error.message, true);
            }
        }

        function wordsFromText(value) {
            return value.trim().replace(/[_-]+/g, " ").replace(/([a-z])([A-Z])/g, "$1 $2").split(/\s+/).filter(Boolean).map((part) => part.toLowerCase());
        }

        function convertTextCase() {
            const value = document.getElementById("text-input").value;
            const mode = document.getElementById("text-mode").value;
            const words = wordsFromText(value);
            if (!words.length) return setOutput("");
            let result = "";
            if (mode === "lower") result = value.toLowerCase();
            if (mode === "upper") result = value.toUpperCase();
            if (mode === "title") result = words.map((w) => w.charAt(0).toUpperCase() + w.slice(1)).join(" ");
            if (mode === "camel") result = words.map((w, i) => i === 0 ? w : w.charAt(0).toUpperCase() + w.slice(1)).join("");
            if (mode === "snake") result = words.join("_");
            if (mode === "kebab") result = words.join("-");
            setOutput(result);
        }

        function rgbToHsl(r, g, b) {
            r /= 255; g /= 255; b /= 255;
            const max = Math.max(r, g, b);
            const min = Math.min(r, g, b);
            let h, s;
            const l = (max + min) / 2;
            if (max === min) {
                h = s = 0;
            } else {
                const d = max - min;
                s = l > 0.5 ? d / (2 - max - min) : d / (max + min);
                switch (max) {
                    case r: h = (g - b) / d + (g < b ? 6 : 0); break;
                    case g: h = (b - r) / d + 2; break;
                    default: h = (r - g) / d + 4; break;
                }
                h /= 6;
            }
            return { h: Math.round(h * 360), s: Math.round(s * 100), l: Math.round(l * 100) };
        }

        function convertColor() {
            const input = document.getElementById("color-input").value.trim();
            const probe = new Option().style;
            probe.color = input;
            if (!probe.color) return setOutput("Enter a valid CSS color string.", true);
            const canvas = document.createElement("canvas");
            canvas.width = 1; canvas.height = 1;
            const ctx = canvas.getContext("2d");
            ctx.fillStyle = input;
            ctx.fillRect(0, 0, 1, 1);
            const [r, g, b] = ctx.getImageData(0, 0, 1, 1).data;
            const hex = "#" + [r, g, b].map((v) => v.toString(16).padStart(2, "0")).join("").toUpperCase();
            const hsl = rgbToHsl(r, g, b);
            const preview = document.getElementById("color-preview");
            if (preview) preview.style.background = `rgb(${r}, ${g}, ${b})`;
            const picker = document.getElementById("native-color-picker");
            if (picker) picker.value = hex;
            setOutput(`HEX: ${hex}\nRGB: rgb(${r}, ${g}, ${b})\nHSL: hsl(${hsl.h}, ${hsl.s}%, ${hsl.l}%)\nCSS: rgba(${r}, ${g}, ${b}, 1.0)`);
        }

        function convertHexToRgb() {
            const raw = document.getElementById("hex-input").value.trim().replace("#", "");
            if (![3, 6].includes(raw.length) || /[^0-9a-f]/i.test(raw)) {
                return setOutput("Enter a valid 3-digit or 6-digit HEX color.", true);
            }
            const normalized = raw.length === 3 ? raw.split("").map((c) => c + c).join("") : raw;
            const r = parseInt(normalized.slice(0, 2), 16);
            const g = parseInt(normalized.slice(2, 4), 16);
            const b = parseInt(normalized.slice(4, 6), 16);
            const preview = document.getElementById("color-preview");
            if (preview) preview.style.background = `rgb(${r}, ${g}, ${b})`;
            const picker = document.getElementById("native-color-picker");
            if (picker) picker.value = "#" + normalized;
            setOutput(`RGB: rgb(${r}, ${g}, ${b})\nRed: ${r}\nGreen: ${g}\nBlue: ${b}`);
        }

        function convertRgbToHex() {
            const values = ["rgb-red", "rgb-green", "rgb-blue"].map((id) => Number(document.getElementById(id).value));
            if (values.some((v) => Number.isNaN(v) || v < 0 || v > 255)) {
                return setOutput("Enter valid RGB channel values between 0 and 255.", true);
            }
            const hex = "#" + values.map((v) => v.toString(16).padStart(2, "0")).join("").toUpperCase();
            const preview = document.getElementById("color-preview");
            if (preview) preview.style.background = hex;
            const picker = document.getElementById("native-color-picker");
            if (picker) picker.value = hex;
            setOutput(`HEX: ${hex}`);
        }

        // Color picker sync
        const nativePicker = document.getElementById("native-color-picker");
        if (nativePicker) {
            nativePicker.addEventListener("input", (e) => {
                const hex = e.target.value;
                const colorInput = document.getElementById("color-input");
                if (colorInput) { colorInput.value = hex; convertColor(); }
                const hexInput = document.getElementById("hex-input");
                if (hexInput) { hexInput.value = hex; convertHexToRgb(); }
            });
        }

        function resetDownloadLink() {
            const link = document.getElementById("image-download-link");
            if (!link) return;
            link.style.display = "none";
            link.removeAttribute("href");
            link.removeAttribute("download");
        }

        function triggerFileInput() {
            const fileInput = document.getElementById("jpg-file") || document.getElementById("png-file") || document.getElementById("favicon-file");
            if (fileInput) fileInput.click();
        }

        function handleImageFile(input) {
            const file = input.files[0];
            if (!file) return;
            const bar = document.getElementById("file-info-bar");
            if (bar) bar.style.display = "block";
            const nameEl = document.getElementById("file-name-display");
            if (nameEl) nameEl.textContent = file.name;
            const sizeEl = document.getElementById("file-size-display");
            if (sizeEl) sizeEl.textContent = (file.size / 1024).toFixed(1) + " KB";
            showToast("File selected: " + file.name);
        }

        function handlePdfSelected(input) {
            const file = input.files[0];
            if (!file) return;
            const card = document.getElementById("pdf-info-card");
            if (card) card.style.display = "block";
            const nameEl = document.getElementById("pdf-filename");
            if (nameEl) nameEl.textContent = file.name;
            const sizeEl = document.getElementById("pdf-filesize");
            if (sizeEl) sizeEl.textContent = (file.size / 1024).toFixed(1) + " KB";
            showToast("PDF document loaded into memory.");
        }

        // Drag and drop setup
        ['image-dropzone', 'pdf-dropzone'].forEach(id => {
            const dropzone = document.getElementById(id);
            if (!dropzone) return;
            ['dragenter', 'dragover'].forEach(eventName => {
                dropzone.addEventListener(eventName, (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    dropzone.style.borderColor = 'var(--brand)';
                    dropzone.style.backgroundColor = 'var(--brand-light)';
                }, false);
            });
            ['dragleave', 'drop'].forEach(eventName => {
                dropzone.addEventListener(eventName, (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    dropzone.style.borderColor = 'var(--border-hover)';
                    dropzone.style.backgroundColor = 'var(--surface-subtle)';
                }, false);
            });
            dropzone.addEventListener('drop', (e) => {
                const files = e.dataTransfer.files;
                if (!files.length) return;
                if (id === 'pdf-dropzone') {
                    const input = document.getElementById('pdf-file');
                    if (input) { input.files = files; handlePdfSelected(input); }
                } else {
                    const input = document.getElementById('jpg-file') || document.getElementById('png-file') || document.getElementById('favicon-file');
                    if (input) { input.files = files; handleImageFile(input); }
                }
            });
        });

        function loadImageFromFile(inputId) {
            return new Promise((resolve, reject) => {
                const file = document.getElementById(inputId).files[0];
                if (!file) {
                    reject(new Error("Choose an image file first."));
                    return;
                }
                const reader = new FileReader();
                reader.onload = () => {
                    const image = new Image();
                    image.onload = () => resolve({ file, image });
                    image.onerror = () => reject(new Error("Unable to decode this image."));
                    image.src = reader.result;
                };
                reader.onerror = () => reject(new Error("Unable to read local file."));
                reader.readAsDataURL(file);
            });
        }

        async function convertImageFile(inputId, mimeType, extension, background = null) {
            resetDownloadLink();
            try {
                const { file, image } = await loadImageFromFile(inputId);
                const canvas = document.createElement("canvas");
                canvas.width = image.width;
                canvas.height = image.height;
                const ctx = canvas.getContext("2d");
                if (background) {
                    ctx.fillStyle = background;
                    ctx.fillRect(0, 0, canvas.width, canvas.height);
                }
                ctx.drawImage(image, 0, 0);
                const dataUrl = canvas.toDataURL(mimeType, 0.92);
                const link = document.getElementById("image-download-link");
                link.href = dataUrl;
                link.download = file.name.replace(/\.[^.]+$/, "") + "." + extension;
                link.style.display = "inline-flex";
                setOutput(`Conversion Completed Successfully!\nSource: ${file.name}\nDimensions: ${image.width} × ${image.height} px\nTarget Format: ${extension.toUpperCase()}`);
                showToast("Image ready for download!");
            } catch (error) {
                setOutput(error.message, true);
            }
        }

        async function generateFavicons() {
            try {
                const { file, image } = await loadImageFromFile("favicon-file");
                const sizes = [16, 32, 48, 180, 192, 512];
                const list = document.getElementById("favicon-downloads");
                list.innerHTML = "";
                sizes.forEach((size) => {
                    const canvas = document.createElement("canvas");
                    canvas.width = size;
                    canvas.height = size;
                    const ctx = canvas.getContext("2d");
                    ctx.clearRect(0, 0, size, size);
                    ctx.drawImage(image, 0, 0, size, size);
                    const link = document.createElement("a");
                    link.className = "btn btn-secondary btn-sm";
                    link.href = canvas.toDataURL("image/png");
                    link.download = `favicon-${size}x${size}.png`;
                    link.textContent = `${size}×${size} PNG`;
                    list.appendChild(link);
                });
                setOutput(`Favicon Assets Generated!\nSource: ${file.name}\nGenerated 6 standard dimensions (16px to 512px).`);
                showToast("Favicons generated!");
            } catch (error) {
                setOutput(error.message, true);
            }
        }

        function countWords() {
            const el = document.getElementById("word-input");
            if (!el) return;
            const value = el.value;
            const trimmed = value.trim();
            const words = trimmed ? trimmed.split(/\s+/).filter(Boolean).length : 0;
            const chars = value.length;
            const charsNoSpaces = value.replace(/\s/g, "").length;
            const lines = value ? value.split(/\r\n|\r|\n/).length : 0;
            const sentences = trimmed ? (trimmed.match(/[.!?]+(?=\s|$)/g) || []).length : 0;
            const readMinutes = Math.ceil(words / 200);

            const sw = document.getElementById("stat-words");
            if (sw) sw.textContent = words.toLocaleString();
            const sc = document.getElementById("stat-chars");
            if (sc) sc.textContent = chars.toLocaleString();
            const sn = document.getElementById("stat-nospaces");
            if (sn) sn.textContent = charsNoSpaces.toLocaleString();
            const ss = document.getElementById("stat-sentences");
            if (ss) ss.textContent = sentences.toLocaleString();
            const sl = document.getElementById("stat-lines");
            if (sl) sl.textContent = lines.toLocaleString();
            const sr = document.getElementById("stat-reading");
            if (sr) sr.textContent = (words === 0 ? "0m" : `${readMinutes}m`);

            setOutput(`Words: ${words}\nCharacters: ${chars}\nCharacters (no spaces): ${charsNoSpaces}\nSentences: ${sentences}\nLines: ${lines}\nEstimated Reading Time: ${readMinutes} min`);
        }

        function generatePassword() {
            const length = Math.min(64, Math.max(6, Number(document.getElementById("password-length")?.value) || 16));
            let chars = "";
            if (document.getElementById("pwd-upper") ? document.getElementById("pwd-upper").checked : true) chars += "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
            if (document.getElementById("pwd-lower") ? document.getElementById("pwd-lower").checked : true) chars += "abcdefghijklmnopqrstuvwxyz";
            if (document.getElementById("pwd-numbers") ? document.getElementById("pwd-numbers").checked : true) chars += "0123456789";
            if (document.getElementById("pwd-symbols") ? document.getElementById("pwd-symbols").checked : true) chars += "!@#$%^&*()_+-=[]{}<>?";
            if (document.getElementById("pwd-no-ambiguous")?.checked) {
                chars = chars.replace(/[0Ol1I]/g, "");
            }
            if (!chars) chars = "abcdefghijklmnopqrstuvwxyz0123456789";

            const array = new Uint32Array(length);
            crypto.getRandomValues(array);
            let password = "";
            for (let i = 0; i < length; i += 1) {
                password += chars[array[i] % chars.length];
            }
            setOutput(password);
        }

        function generateSlug() {
            const el = document.getElementById("slug-input");
            if (!el) return;
            const value = el.value;
            const slug = value
                .toLowerCase()
                .normalize("NFD")
                .replace(/[\u0300-\u036f]/g, "")
                .replace(/[^a-z0-9]+/g, "-")
                .replace(/^-+|-+$/g, "")
                .replace(/-{2,}/g, "-");
            setOutput(slug);
        }

        function encodeHtmlEntities() {
            const value = document.getElementById("html-input").value;
            const div = document.createElement("div");
            div.textContent = value;
            setOutput(div.innerHTML);
        }

        function decodeHtmlEntities() {
            const value = document.getElementById("html-input").value;
            const textarea = document.createElement("textarea");
            textarea.innerHTML = value;
            setOutput(textarea.value);
        }

        function convertTextToBinary() {
            const value = document.getElementById("binary-text-input").value;
            if (!value) return setOutput("Enter text to convert first.", true);
            const bytes = Array.from(new TextEncoder().encode(value)).map((byte) => byte.toString(2).padStart(8, "0"));
            setOutput(bytes.join(" "));
        }

        function convertBinaryToText() {
            try {
                const input = document.getElementById("binary-input").value.trim();
                if (!input) throw new Error("Paste binary values first.");
                const parts = input.split(/\s+/).filter(Boolean);
                if (parts.some((part) => !/^[01]{8}$/.test(part))) {
                    throw new Error("Format must be 8-bit binary strings separated by spaces (e.g. 01001000 01101001).");
                }
                const bytes = Uint8Array.from(parts.map((part) => parseInt(part, 2)));
                const text = new TextDecoder().decode(bytes);
                setOutput(text);
            } catch (error) {
                setOutput("Binary Conversion Error: " + error.message, true);
            }
        }

        function parseCsvLine(line) {
            const cells = [];
            let current = "";
            let inQuotes = false;
            for (let index = 0; index < line.length; index += 1) {
                const char = line[index];
                const next = line[index + 1];
                if (char === '"') {
                    if (inQuotes && next === '"') {
                        current += '"';
                        index += 1;
                    } else {
                        inQuotes = !inQuotes;
                    }
                    continue;
                }
                if (char === "," && !inQuotes) {
                    cells.push(current.trim());
                    current = "";
                    continue;
                }
                current += char;
            }
            if (inQuotes) throw new Error("Unclosed quote encountered in CSV input.");
            cells.push(current.trim());
            return cells;
        }

        function convertCsvToJson() {
            try {
                const input = document.getElementById("csv-input").value.trim();
                if (!input) throw new Error("Paste CSV content first.");
                const rows = input.split(/\r\n|\r|\n/).filter(Boolean).map((line) => parseCsvLine(line));
                if (rows.length < 2) throw new Error("CSV requires a header row and at least one data record.");
                const headers = rows[0];
                const output = rows.slice(1).map((row) => Object.fromEntries(headers.map((header, index) => [header || `col_${index + 1}`, row[index] ?? ""])));
                setOutput(JSON.stringify(output, null, 2));
            } catch (error) {
                setOutput("CSV Parse Error: " + error.message, true);
            }
        }

        function parseUrl() {
            try {
                const raw = document.getElementById("url-parse-input").value.trim();
                if (!raw) throw new Error("Enter a complete URL first.");
                const parsed = new URL(raw);
                const query = {};
                parsed.searchParams.forEach((value, key) => { query[key] = value; });
                setOutput(JSON.stringify({
                    href: parsed.href,
                    protocol: parsed.protocol,
                    host: parsed.host,
                    hostname: parsed.hostname,
                    port: parsed.port || "(default)",
                    pathname: parsed.pathname,
                    search: parsed.search,
                    hash: parsed.hash || "(none)",
                    query
                }, null, 2));
            } catch (error) {
                setOutput("URL Parse Error: Enter a valid full URL including http:// or https://", true);
            }
        }

        function generateLoremIpsum() {
            const count = Math.min(12, Math.max(1, Number(document.getElementById("lorem-count").value) || 3));
            const source = "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent varius, neque eget gravida faucibus, risus mauris ultricies velit, vitae luctus massa justo id neque. Integer sodales, nibh id suscipit vulputate, nunc justo luctus lorem, vitae viverra leo ipsum in augue.";
            const paragraphs = Array.from({ length: count }, (_, index) => source + " (Paragraph " + (index + 1) + ")");
            setOutput(paragraphs.join("\n\n"));
        }

        function sortLines(direction) {
            const input = document.getElementById("line-sort-input").value;
            const lines = input.split(/\r\n|\r|\n/).filter((line) => line.trim() !== "");
            if (!lines.length) return setOutput("Enter one item per line to sort.", true);
            lines.sort((a, b) => a.localeCompare(b, undefined, { sensitivity: "base" }));
            if (direction === "desc") lines.reverse();
            setOutput(lines.join("\n"));
        }

        function checkTextDiff() {
            const left = document.getElementById("diff-left").value;
            const right = document.getElementById("diff-right").value;
            if (!left && !right) return setOutput("Enter text into both fields first.", true);
            if (left === right) return setOutput("Identical: Both texts match 100%.");

            const maxLength = Math.max(left.length, right.length);
            let charIndex = -1;
            for (let i = 0; i < maxLength; i += 1) {
                if ((left[i] || "") !== (right[i] || "")) {
                    charIndex = i;
                    break;
                }
            }

            const leftLines = left.split(/\r\n|\r|\n/);
            const rightLines = right.split(/\r\n|\r|\n/);
            let lineNumber = -1;
            const maxLines = Math.max(leftLines.length, rightLines.length);
            for (let i = 0; i < maxLines; i += 1) {
                if ((leftLines[i] || "") !== (rightLines[i] || "")) {
                    lineNumber = i + 1;
                    break;
                }
            }

            setOutput("Difference Detected:\n- First differing line: " + lineNumber + "\n- Character offset: " + charIndex + "\n- Left text length: " + left.length + " chars\n- Right text length: " + right.length + " chars");
        }

        // PDF Helpers
        async function getPdfjsLib() {
            if (!window.pdfjsLibPromise) throw new Error("PDF parser loading. Please retry in a few moments.");
            return await window.pdfjsLibPromise;
        }

        async function readPdfDocument() {
            const file = document.getElementById("pdf-file").files[0];
            if (!file) throw new Error("Choose a PDF document first.");
            const pdfjsLib = await getPdfjsLib();
            const buffer = await file.arrayBuffer();
            const loadingTask = pdfjsLib.getDocument({ data: buffer });
            try {
                const pdf = await loadingTask.promise;
                return { file, pdf };
            } catch (error) {
                const message = error?.name === "PasswordException"
                    ? "Protected PDF: Document is encrypted with a password."
                    : "Unreadable PDF: File corrupted or invalid format.";
                throw new Error(message);
            }
        }

        async function extractPdfText(pdf) {
            const chunks = [];
            for (let pageNumber = 1; pageNumber <= pdf.numPages; pageNumber += 1) {
                const page = await pdf.getPage(pageNumber);
                const textContent = await page.getTextContent();
                const pageText = textContent.items.map((item) => item.str).join(" ").trim();
                chunks.push(pageText);
            }
            return chunks;
        }

        async function pdfPageCounter() {
            try {
                const { file, pdf } = await readPdfDocument();
                setOutput("Document Page Count Analysis:\n- Filename: " + file.name + "\n- Size: " + (file.size / 1024).toFixed(1) + " KB (" + file.size + " bytes)\n- Total Pages: " + pdf.numPages);
            } catch (error) {
                setOutput(error.message, true);
            }
        }

        async function pdfMetadataViewer() {
            try {
                const { file, pdf } = await readPdfDocument();
                const metadata = await pdf.getMetadata().catch(() => ({ info: {} }));
                const info = metadata.info || {};
                setOutput(
                    "PDF Metadata Inspection:\n" +
                    "- Filename: " + file.name + "\n" +
                    "- Size: " + (file.size / 1024).toFixed(1) + " KB\n" +
                    "- Page Count: " + pdf.numPages + "\n" +
                    "- Title: " + (info.Title || "(None)") + "\n" +
                    "- Author: " + (info.Author || "(None)") + "\n" +
                    "- Subject: " + (info.Subject || "(None)") + "\n" +
                    "- Creator: " + (info.Creator || "(None)") + "\n" +
                    "- Producer: " + (info.Producer || "(None)") + "\n" +
                    "- Creation Date: " + (info.CreationDate || "(None)") + "\n" +
                    "- Modification Date: " + (info.ModDate || "(None)")
                );
            } catch (error) {
                setOutput(error.message, true);
            }
        }

        async function pdfTextFinder() {
            try {
                const keyword = document.getElementById("pdf-search").value.trim();
                if (!keyword) throw new Error("Enter a word or phrase to search.");
                const { file, pdf } = await readPdfDocument();
                const pages = await extractPdfText(pdf);
                let totalMatches = 0;
                const matchSummary = [];
                pages.forEach((pageText, idx) => {
                    const lower = pageText.toLowerCase();
                    const count = lower.split(keyword.toLowerCase()).length - 1;
                    if (count > 0) {
                        totalMatches += count;
                        matchSummary.push(`  • Page ${idx + 1}: ${count} occurrence(s)`);
                    }
                });
                setOutput(
                    "PDF Text Search Summary:\n" +
                    "- Filename: " + file.name + "\n" +
                    "- Query Term: \"" + keyword + "\"\n" +
                    "- Pages Scanned: " + pdf.numPages + "\n" +
                    "- Total Matches Found: " + totalMatches + "\n" +
                    (matchSummary.length ? "\nBreakdown by Page:\n" + matchSummary.join("\n") : "\nNo occurrences found in document text.")
                );
            } catch (error) {
                setOutput(error.message, true);
            }
        }

        async function pdfSecurityChecker() {
            try {
                const { file, pdf } = await readPdfDocument();
                const permissions = pdf.getPermissions ? await pdf.getPermissions().catch(() => null) : null;
                const jsActions = pdf.getJSActions ? await pdf.getJSActions().catch(() => null) : null;
                const fieldObjects = pdf.getFieldObjects ? await pdf.getFieldObjects().catch(() => null) : null;
                const hasJavaScript = Boolean(jsActions && Object.keys(jsActions).length);
                const hasForms = Boolean(fieldObjects && Object.keys(fieldObjects).length);
                const hasXfa = Boolean(pdf.allXfaHtml || pdf.isPureXfa);

                setOutput(
                    "PDF Security & Feature Signals:\n" +
                    "- Document: " + file.name + "\n" +
                    "- Pages: " + pdf.numPages + "\n" +
                    "- Encrypted / Protected: False (unlocked session)\n" +
                    "- Access Permissions: " + (permissions && permissions.length ? permissions.join(", ") : "Standard / Unrestricted") + "\n" +
                    "- Embedded JavaScript: " + (hasJavaScript ? "DETECTED (Review actions)" : "None detected") + "\n" +
                    "- Interactive Form Fields: " + (hasForms ? "Detected" : "None detected") + "\n" +
                    "- XFA Dynamic XML Data: " + (hasXfa ? "Detected" : "None detected")
                );
            } catch (error) {
                setOutput(error.message, true);
            }
        }

        // Initialize tool state on page load
        window.addEventListener("DOMContentLoaded", () => {
            if (currentToolSlug === 'password-generator') generatePassword();
            if (currentToolSlug === 'uuid-generator') generateUuidList();
            if (currentToolSlug === 'ulid-generator') generateUlids();
            if (currentToolSlug === 'random-string-generator') generateRandomStrings();
            if (currentToolSlug === 'cron-expression-helper') evaluateCron();
            if (currentToolSlug === 'lorem-ipsum-generator') generateLoremIpsum();
            if (currentToolSlug === 'color-converter') convertColor();
            if (currentToolSlug === 'hex-to-rgb-converter') convertHexToRgb();
            if (currentToolSlug === 'rgb-to-hex-converter') convertRgbToHex();
            if (currentToolSlug === 'timestamp-converter') setNowTimestamp();
            // Batch 1 auto-inits
            if (currentToolSlug === 'nanoid-generator') generateNanoIds();
            if (currentToolSlug === 'jwt-generator') loadJwtGenSample();
            if (['sha1-hash-generator','sha512-hash-generator','md5-hash-generator'].includes(currentToolSlug)) computeDedicatedHash();
            if (currentToolSlug === 'mime-type-lookup') initMimeDatabase();
            if (currentToolSlug === 'curl-command-generator') loadCurlSample();
            if (currentToolSlug === 'http-header-analyzer') loadHttpHeadersSample();
            // Batch 2A auto-inits
            if (currentToolSlug === 'remove-duplicate-lines') loadDeduplicateLinesSample();
            if (currentToolSlug === 'remove-empty-lines') loadRemoveEmptyLinesSample();
            if (currentToolSlug === 'find-and-replace') loadFindAndReplaceSample();
            if (currentToolSlug === 'reverse-text') loadReverseTextSample();
            if (currentToolSlug === 'markdown-to-html') loadMarkdownSample();
            // Batch 2B auto-inits
            if (currentToolSlug === 'html-to-markdown') loadHtmlToMarkdownSample();
            if (currentToolSlug === 'unicode-inspector') loadUnicodeInspectorSample();
            if (currentToolSlug === 'text-escape-unescape') loadTextEscapeSample();
            if (currentToolSlug === 'csv-viewer') loadCsvViewerSample();
            if (currentToolSlug === 'tsv-to-csv-converter') loadTsvToCsvSample();
        });
    </script>
@endsection