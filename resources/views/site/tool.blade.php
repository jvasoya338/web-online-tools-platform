@extends('site.layout')

@section('content')
    <section class="tool-page">
        <div class="shell">
            <nav class="breadcrumbs" aria-label="Breadcrumb">
                <a href="{{ url('/') }}">Home</a>
                <span aria-hidden="true">/</span>
                <span>{{ $tool['title'] }}</span>
            </nav>
            <div class="tool-hero">
                <div>
                    <div class="tool-badge">{{ $tool['category'] }}</div>
                    <h1 style="margin-top:14px;">{{ $tool['title'] }}</h1>
                    <p class="meta-copy" style="margin-top:10px;">Last updated {{ \Illuminate\Support\Carbon::parse($tool['updated_at'])->format('F j, Y') }}</p>
                    <p class="lede" style="max-width:760px;">{{ $tool['description'] }}</p>
                </div>
                <div class="tool-side-icon">{{ $tool['icon'] }}</div>
            </div>

            <div class="tool-layout">
                <div class="tool-panel">
                    <h2>Use this {{ $tool['title'] }} online</h2>

                    @if ($tool['slug'] === 'json-formatter')
                        <div class="tool-stack">
                            <textarea id="json-input" class="tool-field" placeholder='Paste JSON here, for example: {"platform":"WebToolsStation"}'></textarea>
                            <div class="tool-actions">
                                <button class="button button-primary" onclick="formatJson()">Format JSON</button>
                                <button class="button button-secondary" onclick="minifyJson()">Minify JSON</button>
                                <button class="button button-ghost" onclick="copyOutput('tool-output')">Copy Output</button>
                            </div>
                            <pre id="tool-output" class="tool-output"></pre>
                        </div>
                    @elseif ($tool['slug'] === 'base64-encode-decode')
                        <div class="tool-stack">
                            <textarea id="base64-input" class="tool-field" placeholder="Type text or Base64 value"></textarea>
                            <div class="tool-actions">
                                <button class="button button-primary" onclick="encodeBase64()">Encode</button>
                                <button class="button button-secondary" onclick="decodeBase64()">Decode</button>
                                <button class="button button-ghost" onclick="copyOutput('tool-output')">Copy Output</button>
                            </div>
                            <pre id="tool-output" class="tool-output"></pre>
                        </div>
                    @elseif ($tool['slug'] === 'url-encode-decode')
                        <div class="tool-stack">
                            <textarea id="url-input" class="tool-field" placeholder="Paste text or encoded URL"></textarea>
                            <div class="tool-actions">
                                <button class="button button-primary" onclick="encodeUrl()">Encode</button>
                                <button class="button button-secondary" onclick="decodeUrl()">Decode</button>
                            </div>
                            <pre id="tool-output" class="tool-output"></pre>
                        </div>
                    @elseif ($tool['slug'] === 'jwt-decoder')
                        <div class="tool-stack">
                            <textarea id="jwt-input" class="tool-field" placeholder="Paste JWT token"></textarea>
                            <div class="tool-actions">
                                <button class="button button-primary" onclick="decodeJwt()">Decode Token</button>
                            </div>
                            <pre id="tool-output" class="tool-output"></pre>
                        </div>
                    @elseif ($tool['slug'] === 'timestamp-converter')
                        <div class="tool-stack">
                            <div class="tool-inline two">
                                <input id="timestamp-input" class="tool-field" type="text" placeholder="Unix timestamp">
                                <input id="date-input" class="tool-field" type="datetime-local">
                            </div>
                            <div class="tool-actions">
                                <button class="button button-primary" onclick="timestampToDate()">Timestamp to Date</button>
                                <button class="button button-secondary" onclick="dateToTimestamp()">Date to Timestamp</button>
                            </div>
                            <pre id="tool-output" class="tool-output"></pre>
                        </div>
                    @elseif ($tool['slug'] === 'uuid-generator')
                        <div class="tool-stack">
                            <div class="tool-inline two">
                                <input id="uuid-count" class="tool-field" type="number" min="1" max="20" value="5">
                                <button class="button button-primary" onclick="generateUuidList()">Generate UUIDs</button>
                            </div>
                            <pre id="tool-output" class="tool-output"></pre>
                        </div>
                    @elseif ($tool['slug'] === 'sha256-hash-generator')
                        <div class="tool-stack">
                            <textarea id="hash-input" class="tool-field" placeholder="Type text to hash"></textarea>
                            <div class="tool-actions">
                                <button class="button button-primary" onclick="generateHash()">Generate Hash</button>
                            </div>
                            <pre id="tool-output" class="tool-output"></pre>
                        </div>
                    @elseif ($tool['slug'] === 'regex-tester')
                        <div class="tool-stack">
                            <div class="tool-inline two">
                                <input id="regex-pattern" class="tool-field" type="text" placeholder="Pattern">
                                <input id="regex-flags" class="tool-field" type="text" placeholder="Flags, e.g. gi">
                            </div>
                            <textarea id="regex-text" class="tool-field" placeholder="Paste text to test"></textarea>
                            <div class="tool-actions">
                                <button class="button button-primary" onclick="runRegex()">Run Regex</button>
                            </div>
                            <div id="tool-output" class="tool-output"></div>
                            <div id="regex-matches" class="match-list"></div>
                        </div>
                    @elseif ($tool['slug'] === 'text-case-converter')
                        <div class="tool-stack">
                            <textarea id="text-input" class="tool-field" placeholder="Type text to convert"></textarea>
                            <div class="tool-inline two">
                                <select id="text-mode" class="tool-field">
                                    <option value="lower">lower case</option>
                                    <option value="upper">UPPER CASE</option>
                                    <option value="title">Title Case</option>
                                    <option value="camel">camelCase</option>
                                    <option value="snake">snake_case</option>
                                    <option value="kebab">kebab-case</option>
                                </select>
                                <button class="button button-primary" onclick="convertTextCase()">Convert Case</button>
                            </div>
                            <pre id="tool-output" class="tool-output"></pre>
                        </div>
                    @elseif ($tool['slug'] === 'color-converter')
                        <div class="tool-stack">
                            <input id="color-input" class="tool-field" type="text" placeholder="#c2410c or rgb(194,65,12)">
                            <div class="tool-actions">
                                <button class="button button-primary" onclick="convertColor()">Convert Color</button>
                            </div>
                            <div id="color-preview" class="color-preview"></div>
                            <pre id="tool-output" class="tool-output"></pre>
                        </div>
                    @elseif ($tool['slug'] === 'hex-to-rgb-converter')
                        <div class="tool-stack">
                            <input id="hex-input" class="tool-field" type="text" placeholder="#ff7a18">
                            <div class="tool-actions">
                                <button class="button button-primary" onclick="convertHexToRgb()">Convert HEX</button>
                            </div>
                            <pre id="tool-output" class="tool-output"></pre>
                        </div>
                    @elseif ($tool['slug'] === 'rgb-to-hex-converter')
                        <div class="tool-stack">
                            <div class="tool-inline two">
                                <input id="rgb-red" class="tool-field" type="number" min="0" max="255" placeholder="Red">
                                <input id="rgb-green" class="tool-field" type="number" min="0" max="255" placeholder="Green">
                            </div>
                            <input id="rgb-blue" class="tool-field" type="number" min="0" max="255" placeholder="Blue">
                            <div class="tool-actions">
                                <button class="button button-primary" onclick="convertRgbToHex()">Convert RGB</button>
                            </div>
                            <pre id="tool-output" class="tool-output"></pre>
                        </div>
                    @elseif ($tool['slug'] === 'favicon-generator')
                        <div class="tool-stack">
                            <input id="favicon-file" class="tool-field" type="file" accept="image/png,image/jpeg,image/webp,image/svg+xml">
                            <div class="tool-actions">
                                <button class="button button-primary" onclick="generateFavicons()">Generate Favicons</button>
                            </div>
                            <div id="favicon-downloads" class="match-list"></div>
                            <pre id="tool-output" class="tool-output"></pre>
                        </div>
                    @elseif ($tool['slug'] === 'word-counter')
                        <div class="tool-stack">
                            <textarea id="word-input" class="tool-field" placeholder="Paste text to count words, characters, lines, and sentences"></textarea>
                            <div class="tool-actions">
                                <button class="button button-primary" onclick="countWords()">Count Text</button>
                            </div>
                            <pre id="tool-output" class="tool-output"></pre>
                        </div>
                    @elseif ($tool['slug'] === 'password-generator')
                        <div class="tool-stack">
                            <div class="tool-inline two">
                                <input id="password-length" class="tool-field" type="number" min="6" max="64" value="16">
                                <select id="password-symbols" class="tool-field">
                                    <option value="yes">Include symbols</option>
                                    <option value="no">Letters and numbers only</option>
                                </select>
                            </div>
                            <div class="tool-actions">
                                <button class="button button-primary" onclick="generatePassword()">Generate Password</button>
                                <button class="button button-ghost" onclick="copyOutput('tool-output')">Copy Output</button>
                            </div>
                            <pre id="tool-output" class="tool-output"></pre>
                        </div>
                    @elseif ($tool['slug'] === 'slug-generator')
                        <div class="tool-stack">
                            <textarea id="slug-input" class="tool-field" placeholder="Type a title or phrase to convert into a URL slug"></textarea>
                            <div class="tool-actions">
                                <button class="button button-primary" onclick="generateSlug()">Generate Slug</button>
                            </div>
                            <pre id="tool-output" class="tool-output"></pre>
                        </div>
                    @elseif ($tool['slug'] === 'html-entity-encode-decode')
                        <div class="tool-stack">
                            <textarea id="html-input" class="tool-field" placeholder="Paste HTML text or encoded entities"></textarea>
                            <div class="tool-actions">
                                <button class="button button-primary" onclick="encodeHtmlEntities()">Encode</button>
                                <button class="button button-secondary" onclick="decodeHtmlEntities()">Decode</button>
                            </div>
                            <pre id="tool-output" class="tool-output"></pre>
                        </div>
                    @elseif ($tool['slug'] === 'text-to-binary-converter')
                        <div class="tool-stack">
                            <textarea id="binary-text-input" class="tool-field" placeholder="Type text to encode into binary"></textarea>
                            <div class="tool-actions">
                                <button class="button button-primary" onclick="convertTextToBinary()">Convert Text</button>
                                <button class="button button-ghost" onclick="copyOutput('tool-output')">Copy Output</button>
                            </div>
                            <pre id="tool-output" class="tool-output"></pre>
                        </div>
                    @elseif ($tool['slug'] === 'binary-to-text-converter')
                        <div class="tool-stack">
                            <textarea id="binary-input" class="tool-field" placeholder="01001000 01101001"></textarea>
                            <div class="tool-actions">
                                <button class="button button-primary" onclick="convertBinaryToText()">Convert Binary</button>
                                <button class="button button-ghost" onclick="copyOutput('tool-output')">Copy Output</button>
                            </div>
                            <pre id="tool-output" class="tool-output"></pre>
                        </div>
                    @elseif ($tool['slug'] === 'jpg-to-png-converter')
                        <div class="tool-stack">
                            <input id="jpg-file" class="tool-field" type="file" accept="image/jpeg,image/jpg">
                            <div class="tool-actions">
                                <button class="button button-primary" onclick="convertImageFile('jpg-file', 'image/png', 'png')">Convert to PNG</button>
                            </div>
                            <a id="image-download-link" class="button button-secondary" href="#" style="display:none;">Download Converted Image</a>
                            <pre id="tool-output" class="tool-output"></pre>
                        </div>
                    @elseif ($tool['slug'] === 'png-to-jpg-converter')
                        <div class="tool-stack">
                            <input id="png-file" class="tool-field" type="file" accept="image/png">
                            <div class="tool-actions">
                                <button class="button button-primary" onclick="convertImageFile('png-file', 'image/jpeg', 'jpg', '#ffffff')">Convert to JPG</button>
                            </div>
                            <a id="image-download-link" class="button button-secondary" href="#" style="display:none;">Download Converted Image</a>
                            <pre id="tool-output" class="tool-output"></pre>
                        </div>
                    @elseif ($tool['slug'] === 'csv-to-json-converter')
                        <div class="tool-stack">
                            <textarea id="csv-input" class="tool-field" placeholder="name,email&#10;Alex,alex@example.com&#10;Sam,sam@example.com"></textarea>
                            <div class="tool-actions">
                                <button class="button button-primary" onclick="convertCsvToJson()">Convert CSV</button>
                                <button class="button button-ghost" onclick="copyOutput('tool-output')">Copy Output</button>
                            </div>
                            <pre id="tool-output" class="tool-output"></pre>
                        </div>
                    @elseif ($tool['slug'] === 'url-parser')
                        <div class="tool-stack">
                            <input id="url-parse-input" class="tool-field" type="text" placeholder="https://example.com/products?id=10&sort=asc#details">
                            <div class="tool-actions">
                                <button class="button button-primary" onclick="parseUrl()">Parse URL</button>
                            </div>
                            <pre id="tool-output" class="tool-output"></pre>
                        </div>
                    @elseif ($tool['slug'] === 'lorem-ipsum-generator')
                        <div class="tool-stack">
                            <input id="lorem-count" class="tool-field" type="number" min="1" max="12" value="3">
                            <div class="tool-actions">
                                <button class="button button-primary" onclick="generateLoremIpsum()">Generate Paragraphs</button>
                                <button class="button button-ghost" onclick="copyOutput('tool-output')">Copy Output</button>
                            </div>
                            <pre id="tool-output" class="tool-output"></pre>
                        </div>
                    @elseif ($tool['slug'] === 'line-sorter')
                        <div class="tool-stack">
                            <textarea id="line-sort-input" class="tool-field" placeholder="banana&#10;Apple&#10;carrot"></textarea>
                            <div class="tool-actions">
                                <button class="button button-primary" onclick="sortLines('asc')">Sort A-Z</button>
                                <button class="button button-secondary" onclick="sortLines('desc')">Sort Z-A</button>
                                <button class="button button-ghost" onclick="copyOutput('tool-output')">Copy Output</button>
                            </div>
                            <pre id="tool-output" class="tool-output"></pre>
                        </div>
                    @elseif ($tool['slug'] === 'text-diff-checker')
                        <div class="tool-stack">
                            <div class="tool-inline two">
                                <textarea id="diff-left" class="tool-field" placeholder="First text"></textarea>
                                <textarea id="diff-right" class="tool-field" placeholder="Second text"></textarea>
                            </div>
                            <div class="tool-actions">
                                <button class="button button-primary" onclick="checkTextDiff()">Compare Text</button>
                            </div>
                            <pre id="tool-output" class="tool-output"></pre>
                        </div>
                    @elseif (str_starts_with($tool['slug'], 'pdf-'))
                        <div class="tool-stack">
                            <input id="pdf-file" class="tool-field" type="file" accept="application/pdf">
                            @if ($tool['slug'] === 'pdf-text-finder')
                                <input id="pdf-search" class="tool-field" type="text" placeholder="Word or phrase to search in extracted PDF text">
                            @endif
                            <div class="tool-actions">
                                @if ($tool['slug'] === 'pdf-page-counter')
                                    <button class="button button-primary" onclick="pdfPageCounter()">Analyze PDF</button>
                                @elseif ($tool['slug'] === 'pdf-metadata-viewer')
                                    <button class="button button-primary" onclick="pdfMetadataViewer()">View Metadata Signals</button>
                                @elseif ($tool['slug'] === 'pdf-text-finder')
                                    <button class="button button-primary" onclick="pdfTextFinder()">Find Text</button>
                                @elseif ($tool['slug'] === 'pdf-security-checker')
                                    <button class="button button-primary" onclick="pdfSecurityChecker()">Check Security Signals</button>
                                @endif
                            </div>
                            <pre id="tool-output" class="tool-output"></pre>
                        </div>
                    @endif
                </div>

                <aside class="tool-panel">
                    <h2>What is {{ $tool['title'] }}?</h2>
                    <p>{{ $tool['summary'] }}</p>
                    <ul class="detail-list">
                        @foreach ($tool['details'] as $detail)
                            <li>{{ $detail }}</li>
                        @endforeach
                    </ul>
                    <div style="margin-top:22px;">
                        <a class="button button-secondary" href="{{ url('/') }}">Back To All Tools</a>
                    </div>
                </aside>
            </div>

            <div class="tool-layout" style="margin-top:24px;">
                <div class="tool-panel">
                    <h2>How to use this {{ $tool['title'] }}</h2>
                    <ul class="detail-list">
                        @foreach ($tool['use_steps'] as $item)
                            <li>{{ $item }}</li>
                        @endforeach
                    </ul>
                </div>
                <aside class="tool-panel">
                    <h2>Where this {{ $tool['title'] }} helps most</h2>
                    <ul class="detail-list">
                        @foreach ($tool['use_cases'] as $item)
                            <li>{{ $item }}</li>
                        @endforeach
                    </ul>
                </aside>
            </div>

            <div class="tool-layout" style="margin-top:24px;">
                <div class="tool-panel">
                    <h2>{{ $tool['example_title'] }}</h2>
                    <p>{{ $tool['example_body'] }}</p>
                    <div class="mini-card" style="margin-top:18px;">
                        <strong>Privacy note</strong>
                        <p style="margin-top:10px;">{{ $tool['privacy_note'] }}</p>
                    </div>
                </div>
                <aside class="tool-panel">
                    <h2>Things to check before relying on the result</h2>
                    <ul class="detail-list">
                        @foreach ($tool['watch_out_for'] as $item)
                            <li>{{ $item }}</li>
                        @endforeach
                    </ul>
                </aside>
            </div>

            @if (!empty($tool['common_mistakes']) || !empty($tool['better_alternative']) || !empty($tool['output_notes']))
                <div class="tool-layout" style="margin-top:24px;">
                    <div class="tool-panel">
                        <h2>Common mistakes people make</h2>
                        @if (!empty($tool['common_mistakes']))
                            <ul class="detail-list">
                                @foreach ($tool['common_mistakes'] as $item)
                                    <li>{{ $item }}</li>
                                @endforeach
                            </ul>
                        @else
                            <p>Review the source input carefully before assuming the tool output is the problem.</p>
                        @endif
                    </div>
                    <aside class="tool-panel">
                        <h2>How to read the output well</h2>
                        @if (!empty($tool['output_notes']))
                            <ul class="detail-list">
                                @foreach ($tool['output_notes'] as $item)
                                    <li>{{ $item }}</li>
                                @endforeach
                            </ul>
                        @else
                            <p>The strongest results come when you compare the output with the source task and not just the raw text.</p>
                        @endif
                    </aside>
                </div>

                <div class="tool-panel" style="margin-top:24px;">
                    <h2>When to use a different workflow</h2>
                    @if (!empty($tool['better_alternative']))
                        <ul class="detail-list">
                            @foreach ($tool['better_alternative'] as $item)
                                <li>{{ $item }}</li>
                            @endforeach
                        </ul>
                    @else
                        <p>Browser-based tools are best for quick checks. For deeper audits, repeated batch work, or sensitive workflows, move into your full production tooling.</p>
                    @endif
                </div>
            @endif

            <div class="tool-panel" style="margin-top:24px;">
                <h2>Frequently Asked Questions</h2>
                <div class="tool-stack" style="margin-top:18px;">
                    @foreach ($tool['faq'] as $item)
                        <details class="mini-card">
                            <summary>{{ $item['question'] }}</summary>
                            <p style="margin-top:10px;">{{ $item['answer'] }}</p>
                        </details>
                    @endforeach
                </div>
            </div>

            <div class="tool-layout" style="margin-top:24px;">
                <div class="tool-panel">
                    <h2>Detailed workflow notes for {{ $tool['title'] }}</h2>
                    <p>
                        A useful {{ $tool['title'] }} page should do more than place a button beside an input box. The value comes from making the task clear before
                        you run it, keeping the output easy to review, and helping you understand what the result can and cannot prove. This {{ strtolower($tool['category']) }}
                        page is built for quick browser work, so it is best used when you need a focused answer without opening a larger application or creating an account.
                    </p>
                    <p>
                        Start by checking that your source input is complete and that it belongs in this specific workflow. For {{ $tool['title'] }}, that means reading
                        the short description, using the example input style when available, and running the tool once with a small sample before relying on a larger value.
                        If the result looks unexpected, compare it with the original source instead of copying it immediately. Many tool mistakes come from incomplete
                        pasted data, the wrong format, or an assumption about what the output is supposed to mean.
                    </p>
                    <p>
                        This page is also designed to support repeat use. The surrounding notes explain where the tool helps, common checks to make, related tools to try,
                        and guides that give additional context. That gives Google and human visitors a clearer reason for the page to exist: it is not only a thin utility
                        shell, but a practical reference for completing the task carefully.
                    </p>
                    <p>
                        If you return to this tool often, keep a consistent habit around naming, copying, storing, and reviewing the output. Small utilities are most valuable
                        when they reduce friction without hiding judgment. Use the page for the quick operation, then keep any final decision tied to your project rules,
                        team standards, file requirements, or application behavior.
                    </p>
                    <p>
                        For AdSense and search quality, this page is intentionally written as a complete utility reference rather than a bare widget. A visitor who lands here
                        should understand the purpose of {{ $tool['title'] }}, the situations where it helps, and the review steps that make the result safer to use. The tool
                        interface gives the immediate action, while the surrounding explanation gives the practical context that a real user needs before copying output into
                        a document, codebase, spreadsheet, content workflow, or application test.
                    </p>
                    <p>
                        The best way to use this page is to start with a small example, confirm the output shape, and then run the real value. That simple habit catches many
                        avoidable mistakes. If you are working with generated identifiers, encoded text, image files, PDF signals, URL values, hashes, colors, or structured
                        data, a one-second review can prevent a bad value from spreading into a larger workflow. WebToolsStation keeps these notes visible so the page has
                        standalone value even for visitors who are still learning the task.
                    </p>
                    <p>
                        Another useful habit is to decide what a successful result should look like before running the tool. For some pages that means valid structured output;
                        for others it means a readable converted value, a downloadable file, a sorted list, a matched pattern, a generated identifier, or a document signal that
                        deserves follow-up. Naming the expected result first makes it easier to notice when the output is technically produced but still not right for the job.
                    </p>
                    <p>
                        If the input comes from a third-party system, exported file, copied message, or teammate, treat the tool as a review checkpoint. It can make problems
                        visible quickly, but it cannot know the full business rule behind the value. That is why WebToolsStation pairs the interactive control with explanation:
                        the page should help both the person who already knows the workflow and the visitor who is still learning what the result means.
                    </p>
                </div>
                <aside class="tool-panel">
                    <h2>Review checklist for {{ $tool['title'] }}</h2>
                    <p>
                        Before you use the result in another system, check the output against the reason you opened the tool in the first place. A fast browser utility is
                        excellent for formatting, converting, inspecting, or generating a value, but important work still deserves a final human review.
                    </p>
                    <ul class="detail-list">
                        <li>Confirm the input was pasted or uploaded completely before running the tool.</li>
                        <li>Read the output for obvious formatting, encoding, naming, or file-type problems.</li>
                        <li>Use the related guide if you are unsure what a warning, field, or converted value means.</li>
                        <li>Avoid using sensitive data unless you understand the privacy note and your own security requirements.</li>
                        <li>Move to a fuller workflow when you need batch processing, legal review, security verification, or production validation.</li>
                    </ul>
                    <p style="margin-top:16px;">
                        The safest habit is simple: use WebToolsStation for the quick browser step, then confirm the result in the context where it will actually be used.
                    </p>
                    <p style="margin-top:16px;">
                        If the result will be shared with a client, teammate, public user, or production system, document what source input was used and what decision was made
                        after the tool ran. That note does not need to be formal, but it helps you avoid confusion later when someone asks where a value came from or why a
                        specific format was chosen.
                    </p>
                </aside>
            </div>

            @if (!empty($tool['related']))
                <div class="tool-panel" style="margin-top:24px;">
                    <h2>Related tools</h2>
                    <div class="page-grid" style="margin-top:18px;">
                        @foreach ($tool['related'] as $related)
                            <div class="card click-card">
                                <div class="tool-icon">{{ $related['icon'] }}</div>
                                <h3 style="margin-top:12px;">{{ $related['title'] }}</h3>
                                <p>{{ $related['summary'] }}</p>
                                <a class="card-link" href="{{ url('/tools/' . $related['slug']) }}">Open tool <span aria-hidden="true">→</span></a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            @if (!empty($tool['related_guides']))
                <div class="tool-panel" style="margin-top:24px;">
                    <h2>Helpful guides</h2>
                    <div class="page-grid" style="margin-top:18px;">
                        @foreach ($tool['related_guides'] as $guide)
                            <div class="card click-card">
                                <div class="tool-icon">GD</div>
                                <h3 style="margin-top:12px;">{{ $guide['title'] }}</h3>
                                <p>{{ $guide['seo_description'] }}</p>
                                <a class="card-link" href="{{ url('/guides/' . $guide['slug']) }}">Read guide <span aria-hidden="true">→</span></a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </section>

    <div id="copy-toast" class="toast" role="status" aria-live="polite"></div>
@endsection

@section('scripts')
    <script type="module">
        window.pdfjsLibPromise = import("https://cdn.jsdelivr.net/npm/pdfjs-dist@4/build/pdf.min.mjs")
            .then((pdfjsLib) => {
                pdfjsLib.GlobalWorkerOptions.workerSrc = "https://cdn.jsdelivr.net/npm/pdfjs-dist@4/build/pdf.worker.min.mjs";
                return pdfjsLib;
            });
    </script>
    <script>
        function setOutput(value, isError = false) {
            const el = document.getElementById("tool-output");
            el.textContent = value;
            el.style.color = isError ? "#b91c1c" : "#171717";
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
            const text = document.getElementById(id).textContent || "";
            if (!text.trim()) {
                showToast("There is no output to copy yet.", true);
                return;
            }

            try {
                await navigator.clipboard.writeText(text);
                showToast("Output copied to your clipboard.");
            } catch (error) {
                showToast("Copy failed. Please try again.", true);
            }
        }

        function formatJson() {
            try {
                setOutput(JSON.stringify(JSON.parse(document.getElementById("json-input").value.trim()), null, 2));
            } catch (error) {
                setOutput(error.message, true);
            }
        }

        function minifyJson() {
            try {
                setOutput(JSON.stringify(JSON.parse(document.getElementById("json-input").value.trim())));
            } catch (error) {
                setOutput(error.message, true);
            }
        }

        function encodeBase64() {
            try {
                setOutput(btoa(unescape(encodeURIComponent(document.getElementById("base64-input").value))));
            } catch (error) {
                setOutput("Unable to encode this value.", true);
            }
        }

        function decodeBase64() {
            try {
                setOutput(decodeURIComponent(escape(atob(document.getElementById("base64-input").value.trim()))));
            } catch (error) {
                setOutput("Invalid Base64 input.", true);
            }
        }

        function encodeUrl() {
            setOutput(encodeURIComponent(document.getElementById("url-input").value));
        }

        function decodeUrl() {
            try {
                setOutput(decodeURIComponent(document.getElementById("url-input").value));
            } catch (error) {
                setOutput("Invalid URL-encoded input.", true);
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
                if (pieces.length < 2) throw new Error("JWT must contain at least header and payload.");
                setOutput(JSON.stringify({ header: decodeJwtPart(pieces[0]), payload: decodeJwtPart(pieces[1]) }, null, 2));
            } catch (error) {
                setOutput(error.message, true);
            }
        }

        function timestampToDate() {
            const raw = document.getElementById("timestamp-input").value.trim();
            const num = Number(raw);
            if (!raw || Number.isNaN(num)) return setOutput("Enter a valid Unix timestamp.", true);
            const ms = raw.length <= 10 ? num * 1000 : num;
            const date = new Date(ms);
            setOutput("Local: " + date.toString() + "\nUTC: " + date.toUTCString());
        }

        function dateToTimestamp() {
            const raw = document.getElementById("date-input").value;
            if (!raw) return setOutput("Select a date and time first.", true);
            const date = new Date(raw);
            setOutput("Seconds: " + Math.floor(date.getTime() / 1000) + "\nMilliseconds: " + date.getTime());
        }

        function generateUuidList() {
            const count = Math.min(20, Math.max(1, Number(document.getElementById("uuid-count").value) || 1));
            const values = [];
            for (let i = 0; i < count; i += 1) values.push(crypto.randomUUID());
            setOutput(values.join("\n"));
        }

        async function generateHash() {
            const buffer = new TextEncoder().encode(document.getElementById("hash-input").value);
            const hashBuffer = await crypto.subtle.digest("SHA-256", buffer);
            const hash = Array.from(new Uint8Array(hashBuffer)).map((b) => b.toString(16).padStart(2, "0")).join("");
            setOutput(hash);
        }

        function runRegex() {
            const matches = document.getElementById("regex-matches");
            matches.innerHTML = "";

            try {
                const pattern = document.getElementById("regex-pattern").value;
                const flags = document.getElementById("regex-flags").value;
                const normalizedFlags = flags.includes("g") ? flags : flags + "g";
                const regex = new RegExp(pattern, normalizedFlags);
                const text = document.getElementById("regex-text").value;
                const found = [...text.matchAll(regex)];
                setOutput(found.length ? found.length + " match(es) found." : "No matches found.");

                found.forEach((item, index) => {
                    const div = document.createElement("div");
                    div.className = "match-item";
                    div.textContent = "#" + (index + 1) + " " + item[0];
                    matches.appendChild(div);
                });
            } catch (error) {
                setOutput(error.message, true);
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
            if (mode === "title") result = words.map((word) => word.charAt(0).toUpperCase() + word.slice(1)).join(" ");
            if (mode === "camel") result = words.map((word, index) => index === 0 ? word : word.charAt(0).toUpperCase() + word.slice(1)).join("");
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
            if (!probe.color) return setOutput("Enter a valid CSS color value.", true);
            const canvas = document.createElement("canvas");
            canvas.width = 1;
            canvas.height = 1;
            const ctx = canvas.getContext("2d");
            ctx.fillStyle = input;
            ctx.fillRect(0, 0, 1, 1);
            const [r, g, b] = ctx.getImageData(0, 0, 1, 1).data;
            const hex = "#" + [r, g, b].map((v) => v.toString(16).padStart(2, "0")).join("").toUpperCase();
            const hsl = rgbToHsl(r, g, b);
            document.getElementById("color-preview").style.background = `rgb(${r}, ${g}, ${b})`;
            setOutput("HEX: " + hex + "\nRGB: rgb(" + r + ", " + g + ", " + b + ")\nHSL: hsl(" + hsl.h + ", " + hsl.s + "%, " + hsl.l + "%)");
        }

        function convertHexToRgb() {
            const raw = document.getElementById("hex-input").value.trim().replace("#", "");
            if (![3, 6].includes(raw.length) || /[^0-9a-f]/i.test(raw)) {
                return setOutput("Enter a valid 3-digit or 6-digit HEX color.", true);
            }
            const normalized = raw.length === 3 ? raw.split("").map((char) => char + char).join("") : raw;
            const r = parseInt(normalized.slice(0, 2), 16);
            const g = parseInt(normalized.slice(2, 4), 16);
            const b = parseInt(normalized.slice(4, 6), 16);
            setOutput("RGB: rgb(" + r + ", " + g + ", " + b + ")");
        }

        function convertRgbToHex() {
            const values = ["rgb-red", "rgb-green", "rgb-blue"].map((id) => Number(document.getElementById(id).value));
            if (values.some((value) => Number.isNaN(value) || value < 0 || value > 255)) {
                return setOutput("Enter valid RGB values between 0 and 255.", true);
            }
            const hex = "#" + values.map((value) => value.toString(16).padStart(2, "0")).join("").toUpperCase();
            setOutput("HEX: " + hex);
        }

        function resetDownloadLink() {
            const link = document.getElementById("image-download-link");
            if (!link) return;
            link.style.display = "none";
            link.removeAttribute("href");
            link.removeAttribute("download");
        }

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
                    image.onerror = () => reject(new Error("Unable to read this image file."));
                    image.src = reader.result;
                };
                reader.onerror = () => reject(new Error("Unable to open this file."));
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

                setOutput("Converted image ready.\nOriginal size: " + image.width + "x" + image.height + "\nDownload format: " + extension.toUpperCase());
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
                    link.className = "button button-secondary";
                    link.href = canvas.toDataURL("image/png");
                    link.download = `favicon-${size}x${size}.png`;
                    link.textContent = `Download ${size}x${size}`;
                    list.appendChild(link);
                });

                setOutput("Favicon files generated from " + file.name + ".\nRecommended: use a square image for the best result.");
            } catch (error) {
                setOutput(error.message, true);
            }
        }

        function countWords() {
            const value = document.getElementById("word-input").value;
            const trimmed = value.trim();
            const words = trimmed ? trimmed.split(/\s+/).filter(Boolean).length : 0;
            const chars = value.length;
            const charsNoSpaces = value.replace(/\s/g, "").length;
            const lines = value ? value.split(/\r\n|\r|\n/).length : 0;
            const sentences = trimmed ? (trimmed.match(/[.!?]+/g) || []).length : 0;
            setOutput("Words: " + words + "\nCharacters: " + chars + "\nCharacters (no spaces): " + charsNoSpaces + "\nLines: " + lines + "\nSentences: " + sentences);
        }

        function generatePassword() {
            const length = Math.min(64, Math.max(6, Number(document.getElementById("password-length").value) || 16));
            const useSymbols = document.getElementById("password-symbols").value === "yes";
            let chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
            if (useSymbols) chars += "!@#$%^&*()_+-=[]{}<>?";
            const array = new Uint32Array(length);
            crypto.getRandomValues(array);
            let password = "";
            for (let i = 0; i < length; i += 1) {
                password += chars[array[i] % chars.length];
            }
            setOutput(password);
        }

        function generateSlug() {
            const value = document.getElementById("slug-input").value;
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
                    throw new Error("Use 8-bit binary values separated by spaces.");
                }
                const bytes = Uint8Array.from(parts.map((part) => parseInt(part, 2)));
                const text = new TextDecoder().decode(bytes);
                setOutput(text);
            } catch (error) {
                setOutput(error.message, true);
            }
        }

        function parseCsvLine(line) {
            const cells = [];
            let current = "";
            let inQuotes = false;

            for (let index = 0; index < line.length; index += 1) {
                const char = line[index];
                const next = line[index + 1];

                if (char === "\"") {
                    if (inQuotes && next === "\"") {
                        current += "\"";
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

            if (inQuotes) {
                throw new Error("Close each quoted CSV field before converting.");
            }

            cells.push(current.trim());

            return cells;
        }

        function convertCsvToJson() {
            try {
                const input = document.getElementById("csv-input").value.trim();
                if (!input) throw new Error("Paste CSV content first.");
                const rows = input.split(/\r\n|\r|\n/).filter(Boolean).map((line) => parseCsvLine(line));
                if (rows.length < 2) throw new Error("Add a header row and at least one data row.");
                const headers = rows[0];
                const output = rows.slice(1).map((row) => Object.fromEntries(headers.map((header, index) => [header || `column_${index + 1}`, row[index] ?? ""])));
                setOutput(JSON.stringify(output, null, 2));
            } catch (error) {
                setOutput(error.message, true);
            }
        }

        function parseUrl() {
            try {
                const raw = document.getElementById("url-parse-input").value.trim();
                if (!raw) throw new Error("Enter a full URL first.");
                const parsed = new URL(raw);
                const query = {};
                parsed.searchParams.forEach((value, key) => {
                    query[key] = value;
                });
                setOutput(JSON.stringify({
                    href: parsed.href,
                    origin: parsed.origin,
                    protocol: parsed.protocol,
                    host: parsed.host,
                    hostname: parsed.hostname,
                    port: parsed.port || "(default)",
                    pathname: parsed.pathname,
                    search: parsed.search,
                    hash: parsed.hash || "(none)",
                    query,
                }, null, 2));
            } catch (error) {
                setOutput("Enter a valid full URL including http:// or https://", true);
            }
        }

        function generateLoremIpsum() {
            const count = Math.min(12, Math.max(1, Number(document.getElementById("lorem-count").value) || 3));
            const source = "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent varius, neque eget gravida faucibus, risus mauris ultricies velit, vitae luctus massa justo id neque. Integer sodales, nibh id suscipit vulputate, nunc justo luctus lorem, vitae viverra leo ipsum in augue.";
            const paragraphs = Array.from({ length: count }, (_, index) => source + " Paragraph " + (index + 1) + ".");
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
            if (left === right) return setOutput("The two text blocks are identical.");

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

            setOutput("The text is different.\nFirst different character index: " + charIndex + "\nFirst different line: " + lineNumber);
        }

        async function getPdfjsLib() {
            if (!window.pdfjsLibPromise) {
                throw new Error("PDF tools are still loading. Please wait a moment and try again.");
            }

            try {
                return await window.pdfjsLibPromise;
            } catch (error) {
                throw new Error("PDF tools could not be loaded in this browser session.");
            }
        }

        async function readPdfDocument() {
            const file = document.getElementById("pdf-file").files[0];
            if (!file) throw new Error("Choose a PDF file first.");

            const pdfjsLib = await getPdfjsLib();
            const buffer = await file.arrayBuffer();
            const loadingTask = pdfjsLib.getDocument({ data: buffer });

            try {
                const pdf = await loadingTask.promise;
                return { file, pdf };
            } catch (error) {
                const message = error?.name === "PasswordException"
                    ? "This PDF is password protected and cannot be analyzed here."
                    : "This PDF could not be read. Try another file.";
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
                setOutput("File: " + file.name + "\nSize: " + file.size + " bytes\nPages: " + pdf.numPages);
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
                    "File: " + file.name +
                    "\nSize: " + file.size + " bytes" +
                    "\nPages: " + pdf.numPages +
                    "\nTitle: " + (info.Title || "Not detected") +
                    "\nAuthor: " + (info.Author || "Not detected") +
                    "\nSubject: " + (info.Subject || "Not detected") +
                    "\nCreator: " + (info.Creator || "Not detected") +
                    "\nProducer: " + (info.Producer || "Not detected")
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
                const text = (await extractPdfText(pdf)).join("\n");
                const lowerText = text.toLowerCase();
                const lowerKeyword = keyword.toLowerCase();
                const count = lowerText.split(lowerKeyword).length - 1;
                setOutput("File: " + file.name + "\nKeyword: " + keyword + "\nMatches found: " + Math.max(0, count) + "\nPages scanned: " + pdf.numPages);
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
                    "File: " + file.name +
                    "\nPages: " + pdf.numPages +
                    "\nDocument restrictions: " + (permissions && permissions.length ? permissions.join(", ") : "Not reported") +
                    "\nInteractive form fields: " + (hasForms ? "Detected" : "Not detected") +
                    "\nXFA form data: " + (hasXfa ? "Detected" : "Not detected") +
                    "\nEmbedded JavaScript actions: " + (hasJavaScript ? "Detected" : "Not detected")
                );
            } catch (error) {
                setOutput(error.message, true);
            }
        }
    </script>
@endsection
