<div class="workspace-split">
    <!-- Input Pane -->
    <div class="pane-card">
        <div class="pane-header">
            <span>Input</span>
            <div class="pane-actions">
                <button type="button" class="btn btn-ghost btn-sm" onclick="clearInput()" title="Clear input">Clear</button>
                <button type="button" class="btn btn-ghost btn-sm" onclick="loadSample()" title="Load sample input">Sample</button>
                <button type="button" class="btn btn-ghost btn-sm" onclick="pasteFromClipboard()" title="Paste from clipboard">Paste</button>
            </div>
        </div>

        @if ($tool['slug'] === 'json-formatter')
            <textarea id="json-input" class="editor-textarea" placeholder='Paste JSON here (e.g. {"name":"WebToolsStation","version":"2.0"})...' spellcheck="false"></textarea>
        @elseif ($tool['slug'] === 'base64-encode-decode')
            <textarea id="base64-input" class="editor-textarea" placeholder="Type or paste text to encode, or Base64 string to decode..." spellcheck="false"></textarea>
        @elseif ($tool['slug'] === 'url-encode-decode')
            <textarea id="url-input" class="editor-textarea" placeholder="Paste URL or query string to encode or decode..." spellcheck="false"></textarea>
        @elseif ($tool['slug'] === 'jwt-decoder')
            <textarea id="jwt-input" class="editor-textarea" placeholder="Paste JSON Web Token (eyJhbGciOi...)..." spellcheck="false"></textarea>
        @elseif ($tool['slug'] === 'html-entity-encode-decode')
            <textarea id="html-input" class="editor-textarea" placeholder="Paste text or HTML with entities (e.g. &lt;div&gt; &amp; &quot;)..." spellcheck="false"></textarea>
        @elseif ($tool['slug'] === 'csv-to-json-converter')
            <textarea id="csv-input" class="editor-textarea" placeholder="name,email,role&#10;Alex,alex@example.com,Developer&#10;Sam,sam@example.com,Designer" spellcheck="false"></textarea>
        @elseif ($tool['slug'] === 'text-to-binary-converter')
            <textarea id="binary-text-input" class="editor-textarea" placeholder="Type text to convert into 8-bit binary..." spellcheck="false"></textarea>
        @elseif ($tool['slug'] === 'binary-to-text-converter')
            <textarea id="binary-input" class="editor-textarea" placeholder="Paste 8-bit binary bytes separated by spaces (e.g., 01001000 01101001)..." spellcheck="false"></textarea>
        @elseif ($tool['slug'] === 'text-case-converter')
            <textarea id="text-input" class="editor-textarea" placeholder="Type or paste text to convert case..." spellcheck="false"></textarea>
        @elseif ($tool['slug'] === 'line-sorter')
            <textarea id="line-sort-input" class="editor-textarea" placeholder="Paste list of items (one per line) to sort..." spellcheck="false"></textarea>
        @elseif ($tool['slug'] === 'text-diff-checker')
            <div style="display:flex; flex-direction:column; height:260px;">
                <textarea id="diff-left" class="editor-textarea" style="height:50%; border-bottom:1px solid var(--border);" placeholder="Original text..." spellcheck="false"></textarea>
                <textarea id="diff-right" class="editor-textarea" style="height:50%;" placeholder="Modified text to compare..." spellcheck="false"></textarea>
            </div>
        @elseif ($tool['slug'] === 'url-parser')
            <div style="padding:14px; display:flex; flex-direction:column; gap:10px;">
                <input id="url-parse-input" type="text" placeholder="https://example.com/products?category=tools&sort=asc#specs" style="width:100%; height:40px; font-family:var(--font-mono); font-size:0.9rem;">
                <div style="color:var(--text-muted); font-size:0.8rem;">Paste any URL to inspect protocol, hostname, pathname, search params, and hash fragments.</div>
            </div>
        @elseif ($tool['slug'] === 'regex-tester')
            <div style="display:flex; flex-direction:column; height:260px;">
                <div style="display:flex; gap:8px; padding:8px 10px; border-bottom:1px solid var(--border); background:var(--surface-subtle);">
                    <input id="regex-pattern" type="text" placeholder="Pattern (e.g. [A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,})" style="flex:2; font-family:var(--font-mono); font-size:0.88rem; height:32px;">
                    <input id="regex-flags" type="text" placeholder="Flags (e.g. gi)" value="g" style="flex:1; font-family:var(--font-mono); font-size:0.88rem; max-width:80px; height:32px;">
                </div>
                <textarea id="regex-text" class="editor-textarea" style="flex:1; height:auto;" placeholder="Paste test string here to test regex matching..." spellcheck="false"></textarea>
            </div>
        @endif

        <div style="padding:6px 12px; background:var(--surface-subtle); border-top:1px solid var(--border); font-size:0.75rem; color:var(--text-muted); display:flex; justify-content:space-between;">
            <span>Input Ready</span>
            <span>⚡ Live Auto-Processing</span>
        </div>
    </div>

    <!-- Output Pane -->
    <div class="pane-card">
        <div class="pane-header">
            <span id="output-label">Output</span>
            <div class="pane-actions">
                <button type="button" class="btn btn-secondary btn-sm" onclick="copyOutput('tool-output')">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg>
                    Copy
                </button>
                @if (in_array($tool['slug'], ['json-formatter', 'csv-to-json-converter']))
                    <button type="button" class="btn btn-ghost btn-sm" onclick="downloadOutput('tool-output', 'data.json')" title="Download as JSON file">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                        JSON
                    </button>
                @endif
            </div>
        </div>
        <pre id="tool-output" class="output-pre" aria-label="Tool result" placeholder="Output will appear here automatically..."></pre>
        @if ($tool['slug'] === 'regex-tester')
            <div id="regex-matches" style="padding:8px 10px; max-height:110px; overflow-y:auto; border-top:1px solid var(--border); font-size:0.82rem; font-family:var(--font-mono); background:var(--surface-subtle);"></div>
        @endif
        <div style="padding:6px 12px; background:var(--surface-subtle); border-top:1px solid var(--border); font-size:0.75rem; color:var(--text-muted); display:flex; justify-content:space-between;">
            <span>Result Pane</span>
            <span style="color:var(--brand-dark); font-weight:600;">Client-Side</span>
        </div>
    </div>
</div>

<!-- Compact Action & Options Toolbar -->
<div class="workspace-toolbar" style="margin-top:12px; padding:10px 14px; background:var(--surface-subtle); border:1px solid var(--border); border-radius:var(--radius-md);">
    <div class="workspace-btn-group">
        @if ($tool['slug'] === 'json-formatter')
            <div style="display:flex; align-items:center; gap:6px;">
                <label for="json-indent" style="font-size:0.82rem; font-weight:600; color:var(--text);">Indent:</label>
                <select id="json-indent" onchange="formatJson()" style="height:32px; font-size:0.84rem; font-weight:600; padding:0 8px; border-radius:var(--radius-sm); border:1px solid var(--border); background:#ffffff;">
                    <option value="2" selected>2 Spaces</option>
                    <option value="4">4 Spaces</option>
                    <option value="tab">1 Tab</option>
                </select>
            </div>
            <button class="btn btn-primary" onclick="formatJson()">{{ $tool['cta_text'] ?? 'Beautify JSON' }}</button>
            <button class="btn btn-secondary" onclick="minifyJson()">Minify JSON</button>
        @elseif ($tool['slug'] === 'base64-encode-decode')
            <button class="btn btn-primary" onclick="encodeBase64()">Encode to Base64</button>
            <button class="btn btn-secondary" onclick="decodeBase64()">Decode Base64</button>
        @elseif ($tool['slug'] === 'url-encode-decode')
            <button class="btn btn-primary" onclick="encodeUrl()">Encode URL</button>
            <button class="btn btn-secondary" onclick="decodeUrl()">Decode URL</button>
        @elseif ($tool['slug'] === 'jwt-decoder')
            <button class="btn btn-primary" onclick="decodeJwt()">Decode JWT Token</button>
        @elseif ($tool['slug'] === 'html-entity-encode-decode')
            <button class="btn btn-primary" onclick="encodeHtmlEntities()">Encode Entities</button>
            <button class="btn btn-secondary" onclick="decodeHtmlEntities()">Decode to Text</button>
        @elseif ($tool['slug'] === 'csv-to-json-converter')
            <button class="btn btn-primary" onclick="convertCsvToJson()">Convert CSV to JSON</button>
        @elseif ($tool['slug'] === 'text-to-binary-converter')
            <button class="btn btn-primary" onclick="convertTextToBinary()">Convert to Binary</button>
        @elseif ($tool['slug'] === 'binary-to-text-converter')
            <button class="btn btn-primary" onclick="convertBinaryToText()">Convert to Text</button>
        @elseif ($tool['slug'] === 'text-case-converter')
            <div style="display:flex; align-items:center; gap:6px;">
                <label for="text-mode" style="font-size:0.82rem; font-weight:600; color:var(--text);">Format:</label>
                <select id="text-mode" onchange="convertTextCase()" style="height:32px; font-size:0.84rem; font-weight:600; padding:0 8px; border-radius:var(--radius-sm); border:1px solid var(--border); background:#ffffff;">
                    <option value="title">Title Case</option>
                    <option value="camel">camelCase</option>
                    <option value="snake">snake_case</option>
                    <option value="kebab">kebab-case</option>
                    <option value="upper">UPPER CASE</option>
                    <option value="lower">lower case</option>
                </select>
            </div>
            <button class="btn btn-primary" onclick="convertTextCase()">Convert Case</button>
        @elseif ($tool['slug'] === 'line-sorter')
            <button class="btn btn-primary" onclick="sortLines('asc')">Sort A → Z</button>
            <button class="btn btn-secondary" onclick="sortLines('desc')">Sort Z → A</button>
        @elseif ($tool['slug'] === 'text-diff-checker')
            <button class="btn btn-primary" onclick="checkTextDiff()">Compare Texts</button>
        @elseif ($tool['slug'] === 'url-parser')
            <button class="btn btn-primary" onclick="parseUrl()">Parse URL Components</button>
        @elseif ($tool['slug'] === 'regex-tester')
            <button class="btn btn-primary" onclick="runRegex()">Run Regular Expression</button>
        @endif
        <button type="button" class="btn btn-ghost btn-sm" onclick="clearInput()">Clear</button>
    </div>

    <div style="font-size:0.75rem; color:var(--text-muted);">
        Keyboard: <kbd class="search-kbd">Ctrl/Cmd+Enter</kbd> to run
    </div>
</div>