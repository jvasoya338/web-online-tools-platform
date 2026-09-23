@if ($tool['slug'] === 'yaml-formatter')
    {{-- YAML Formatter --}}
    <div class="workspace-split">
        <div class="pane-card">
            <div class="pane-header">
                <span>YAML Source Input</span>
                <div class="pane-actions">
                    <button type="button" class="btn btn-ghost btn-sm" onclick="clearYamlFormatter()">Clear</button>
                    <button type="button" class="btn btn-ghost btn-sm" onclick="loadYamlFormatterSample()">Sample</button>
                    <button type="button" class="btn btn-ghost btn-sm" onclick="pasteYamlFormatterClipboard()">Paste</button>
                </div>
            </div>
            <textarea id="yaml-fmt-input" class="editor-textarea" placeholder="Paste unformatted YAML here to beautify automatically..." oninput="runYamlFormatter()" spellcheck="false"></textarea>
            <div style="padding:6px 12px; background:var(--surface-subtle); border-top:1px solid var(--border); font-size:0.75rem; color:var(--text-muted); display:flex; justify-content:space-between;">
                <span id="yaml-fmt-input-stats">0 lines | 0 characters</span>
                <span>⚡ Live Auto-Beautify</span>
            </div>
        </div>

        <div class="pane-card">
            <div class="pane-header">
                <span>Formatted YAML Output</span>
                <div class="pane-actions">
                    <button type="button" class="btn btn-secondary btn-sm" onclick="copyOutput('yaml-fmt-output')">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg>
                        Copy
                    </button>
                    <button type="button" class="btn btn-ghost btn-sm" onclick="downloadYamlFormatted()">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                        Download
                    </button>
                </div>
            </div>
            <textarea id="yaml-fmt-output" class="editor-textarea" readonly placeholder="Formatted YAML will appear here..." style="background:#fafafa;"></textarea>
            <div style="padding:6px 12px; background:var(--surface-subtle); border-top:1px solid var(--border); font-size:0.75rem; color:var(--text-muted); display:flex; justify-content:space-between;">
                <span id="yaml-fmt-output-stats">0 lines | 0 characters</span>
                <span style="color:var(--brand-dark); font-weight:600;">YAML Formatted</span>
            </div>
        </div>
    </div>

    <div class="workspace-toolbar" style="margin-top:12px; padding:10px 14px; background:var(--surface-subtle); border:1px solid var(--border); border-radius:var(--radius-md);">
        <div style="display:flex; align-items:center; gap:8px;">
            <label for="yaml-indent-size" style="font-size:0.82rem; font-weight:600; color:var(--text);">Indentation:</label>
            <select id="yaml-indent-size" onchange="runYamlFormatter()" style="height:32px; padding:0 8px; font-size:0.84rem; font-weight:600; border-radius:var(--radius-sm); border:1px solid var(--border); background:#ffffff;">
                <option value="2" selected>2 Spaces</option>
                <option value="4">4 Spaces</option>
            </select>
        </div>

        <div class="workspace-btn-group">
            <button type="button" class="btn btn-primary" onclick="runYamlFormatter()">{{ $tool['cta_text'] ?? 'Beautify YAML' }}</button>
            <button type="button" class="btn btn-ghost btn-sm" onclick="clearYamlFormatter()">Clear</button>
            <span style="font-size:0.75rem; color:var(--text-muted); margin-left:4px;">Ctrl+Enter</span>
        </div>
    </div>

    <div id="yaml-fmt-error" style="display:none; margin-top:10px; padding:8px 12px; background:var(--danger-bg); border:1px solid var(--danger); border-radius:var(--radius-sm); color:var(--danger); font-size:0.84rem;">
        <strong>YAML Syntax Issue:</strong> <span id="yaml-fmt-error-msg"></span>
    </div>

@elseif ($tool['slug'] === 'yaml-validator')
    {{-- YAML Validator --}}
    <div class="workspace-split">
        <div class="pane-card">
            <div class="pane-header">
                <span>YAML Input</span>
                <div class="pane-actions">
                    <button type="button" class="btn btn-ghost btn-sm" onclick="clearYamlValidator()">Clear</button>
                    <button type="button" class="btn btn-ghost btn-sm" onclick="loadYamlValidatorSample()">Sample</button>
                    <button type="button" class="btn btn-ghost btn-sm" onclick="pasteYamlValidatorClipboard()">Paste</button>
                </div>
            </div>
            <textarea id="yaml-val-input" class="editor-textarea" placeholder="Paste YAML configuration to validate syntax..." oninput="runYamlValidator()" spellcheck="false"></textarea>
            <div style="padding:6px 12px; background:var(--surface-subtle); border-top:1px solid var(--border); font-size:0.75rem; color:var(--text-muted); display:flex; justify-content:space-between;">
                <span>YAML Input</span>
                <span>⚡ Live Validation</span>
            </div>
        </div>

        <div class="pane-card">
            <div class="pane-header">
                <span>Validation Diagnostic</span>
                <div class="pane-actions">
                    <button type="button" class="btn btn-secondary btn-sm" onclick="copyOutput('yaml-val-output')">Copy Parsed</button>
                </div>
            </div>

            <div id="yaml-val-status-box" style="padding:10px 14px; border-bottom:1px solid var(--border); background:var(--surface-subtle);">
                <div id="yaml-val-initial" style="color:var(--text-muted); font-size:0.86rem; display:flex; align-items:center; gap:6px;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
                    Enter YAML to validate syntax in real time.
                </div>
                <div id="yaml-val-success" style="display:none; padding:8px 12px; background:var(--success-bg); border:1px solid rgba(22,163,74,0.3); border-radius:var(--radius-sm); color:var(--success);">
                    <div style="font-weight:700; font-size:0.92rem; display:flex; align-items:center; gap:6px;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                        Valid YAML!
                    </div>
                    <div style="font-size:0.82rem; margin-top:2px; color:var(--text);">Document conforms to YAML specification with 0 syntax errors.</div>
                </div>
                <div id="yaml-val-failure" style="display:none; padding:8px 12px; background:var(--danger-bg); border:1px solid rgba(220,38,38,0.3); border-radius:var(--radius-sm); color:var(--danger);">
                    <div style="font-weight:700; font-size:0.92rem; display:flex; align-items:center; gap:6px;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
                        Invalid YAML Syntax
                    </div>
                    <div id="yaml-val-error-details" style="font-size:0.84rem; font-weight:600; margin-top:4px; font-family:var(--font-mono); color:#991b1b; white-space:pre-wrap;"></div>
                </div>
            </div>

            <textarea id="yaml-val-output" class="editor-textarea" readonly placeholder="Parsed structure will appear here after validation..." style="flex:1; height:auto; background:#ffffff;"></textarea>
        </div>
    </div>

    <div class="workspace-toolbar" style="margin-top:12px; padding:10px 14px; background:var(--surface-subtle); border:1px solid var(--border); border-radius:var(--radius-md);">
        <div class="workspace-btn-group">
            <button type="button" class="btn btn-primary" onclick="runYamlValidator()">{{ $tool['cta_text'] ?? 'Validate YAML' }}</button>
            <button type="button" class="btn btn-ghost btn-sm" onclick="clearYamlValidator()">Clear</button>
        </div>
        <div class="workspace-hint" style="font-size:0.75rem; color:var(--text-muted);">
            <span>Keyboard: Press <kbd>Ctrl/Cmd+Enter</kbd> to validate</span>
        </div>
    </div>

@elseif ($tool['slug'] === 'jwt-generator')
    {{-- JWT Generator --}}
    <div class="workspace-split">
        <div class="pane-card" style="padding:14px;">
            <h3 style="margin-top:0; font-size:0.95rem; color:var(--text);">Token Configuration</h3>

            <div style="display:grid; grid-template-columns:1fr 1fr; gap:10px; margin-top:10px;">
                <div>
                    <label for="jwt-gen-algo" style="display:block; font-size:0.82rem; font-weight:600; color:var(--text); margin-bottom:3px;">Algorithm:</label>
                    <select id="jwt-gen-algo" style="width:100%; height:32px; font-size:0.84rem; border-radius:var(--radius-sm); border:1px solid var(--border);">
                        <option value="HS256" selected>HS256</option>
                        <option value="HS384">HS384</option>
                        <option value="HS512">HS512</option>
                    </select>
                </div>
                <div>
                    <label for="jwt-gen-secret" style="display:block; font-size:0.82rem; font-weight:600; color:var(--text); margin-bottom:3px;">Secret Key:</label>
                    <input type="text" id="jwt-gen-secret" placeholder="secret-key" style="width:100%; height:32px; font-size:0.84rem; font-family:var(--font-mono);">
                </div>
            </div>

            <div style="margin-top:10px;">
                <label for="jwt-gen-payload" style="display:block; font-size:0.82rem; font-weight:600; color:var(--text); margin-bottom:3px;">Payload Claims (JSON):</label>
                <textarea id="jwt-gen-payload" class="editor-textarea" style="height:110px; font-family:var(--font-mono); font-size:0.82rem;" placeholder='{"sub":"user123","name":"Jane Doe","role":"admin"}'></textarea>
            </div>

            <div style="margin-top:10px;">
                <div style="display:flex; gap:6px; flex-wrap:wrap;">
                    <button type="button" class="btn btn-ghost btn-sm" onclick="setJwtExpiry(3600)">+1h</button>
                    <button type="button" class="btn btn-ghost btn-sm" onclick="setJwtExpiry(86400)">+1d</button>
                    <button type="button" class="btn btn-ghost btn-sm" onclick="setJwtExpiry(604800)">+7d</button>
                    <button type="button" class="btn btn-ghost btn-sm" onclick="loadJwtGenSample()">Sample</button>
                </div>
            </div>

            <button type="button" class="btn btn-primary" style="width:100%; margin-top:12px;" onclick="generateJwtToken()">{{ $tool['cta_text'] ?? 'Generate JWT' }}</button>
        </div>

        <div class="pane-card">
            <div class="pane-header">
                <span>Generated JWT Token</span>
                <div class="pane-actions">
                    <button type="button" class="btn btn-secondary btn-sm" onclick="copyOutput('jwt-gen-output')">Copy Token</button>
                </div>
            </div>
            <textarea id="jwt-gen-output" class="editor-textarea" readonly placeholder="Signed JWT token will appear here..." style="background:#fafafa; word-break:break-all;"></textarea>
            <div id="jwt-gen-decoded-preview" style="display:none; padding:10px; border-top:1px solid var(--border);">
                <div style="font-size:0.72rem; font-weight:700; text-transform:uppercase; letter-spacing:0.06em; color:var(--brand); margin-bottom:4px;">Token Preview</div>
                <div style="font-family:var(--font-mono); font-size:0.78rem; word-break:break-all; line-height:1.5;">
                    <span id="jwt-part-header" style="color:#e34c26;"></span>.<span id="jwt-part-payload" style="color:#563d7c;"></span>.<span id="jwt-part-sig" style="color:#0086b3;"></span>
                </div>
            </div>
        </div>
    </div>

@elseif ($tool['slug'] === 'nanoid-generator')
    {{-- NanoID Generator --}}
    <div class="workspace-split">
        <div class="pane-card" style="padding:14px;">
            <h3 style="margin-top:0; font-size:0.95rem; color:var(--text);">NanoID Parameters</h3>

            <div style="margin-top:10px;">
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:4px;">
                    <label for="nanoid-length" style="font-size:0.82rem; font-weight:600; color:var(--text);">Length:</label>
                    <span id="nanoid-length-val" style="font-weight:700; color:var(--brand); font-family:var(--font-mono);">21</span>
                </div>
                <input type="range" id="nanoid-length" min="6" max="64" value="21" oninput="document.getElementById('nanoid-length-val').textContent = this.value" style="width:100%;">
            </div>

            <div style="margin-top:10px;">
                <div style="display:flex; gap:6px; flex-wrap:wrap;" id="nanoid-alphabet-btns">
                    <button type="button" class="btn btn-secondary btn-sm nanoid-preset active" onclick="setNanoIdAlphabet('url', this)">URL-Safe</button>
                    <button type="button" class="btn btn-ghost btn-sm nanoid-preset" onclick="setNanoIdAlphabet('numbers', this)">Numbers</button>
                    <button type="button" class="btn btn-ghost btn-sm nanoid-preset" onclick="setNanoIdAlphabet('hex', this)">Hex</button>
                </div>
            </div>

            <div style="margin-top:10px;">
                <label for="nanoid-count" style="display:block; font-size:0.82rem; font-weight:600; color:var(--text); margin-bottom:3px;">Quantity (1–50):</label>
                <input type="number" id="nanoid-count" min="1" max="50" value="5" style="width:100%; height:34px; font-size:0.86rem; font-family:var(--font-mono);">
            </div>

            <button type="button" class="btn btn-primary" style="width:100%; margin-top:12px;" onclick="generateNanoIds()">{{ $tool['cta_text'] ?? 'Generate NanoIDs' }}</button>
        </div>

        <div class="pane-card">
            <div class="pane-header">
                <span>Generated NanoIDs</span>
                <div class="pane-actions">
                    <button type="button" class="btn btn-secondary btn-sm" onclick="copyOutput('nanoid-output')">Copy All</button>
                </div>
            </div>
            <textarea id="nanoid-output" class="editor-textarea" readonly placeholder="Generated URL-safe NanoIDs will appear here..." style="background:#fafafa;"></textarea>
        </div>
    </div>

@elseif (in_array($tool['slug'], ['sha1-hash-generator', 'sha512-hash-generator', 'md5-hash-generator']))
    {{-- Dedicated Single-Hash Generator --}}
    @php
        $hashAlgoMap = [
            'sha1-hash-generator' => ['algo' => 'SHA-1', 'label' => 'SHA-1', 'bits' => 160, 'hexlen' => 40],
            'sha512-hash-generator' => ['algo' => 'SHA-512', 'label' => 'SHA-512', 'bits' => 512, 'hexlen' => 128],
            'md5-hash-generator' => ['algo' => 'MD5', 'label' => 'MD5', 'bits' => 128, 'hexlen' => 32],
        ];
        $hashInfo = $hashAlgoMap[$tool['slug']];
    @endphp
    <div>
        <div class="pane-card" style="margin-bottom:12px;">
            <div class="pane-header">
                <span>Input Plaintext</span>
                <div class="pane-actions">
                    <button type="button" class="btn btn-ghost btn-sm" onclick="document.getElementById('dedicated-hash-input').value=''; computeDedicatedHash();">Clear</button>
                    <button type="button" class="btn btn-ghost btn-sm" onclick="document.getElementById('dedicated-hash-input').value='WebToolsStation {{ $hashInfo['label'] }} checksum test'; computeDedicatedHash();">Sample</button>
                </div>
            </div>
            <textarea id="dedicated-hash-input" class="editor-textarea" style="height:90px;" placeholder="Enter or paste text to compute {{ $hashInfo['label'] }} hash in real time..." oninput="computeDedicatedHash()" spellcheck="false"></textarea>
            <div style="padding:6px 12px; background:var(--surface-subtle); border-top:1px solid var(--border); font-size:0.75rem; color:var(--text-muted); display:flex; justify-content:space-between;">
                <span>Input Ready</span>
                <span>⚡ Live Hash Calculation</span>
            </div>
        </div>

        <div class="pane-card" style="padding:14px;">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:10px; flex-wrap:wrap; gap:8px;">
                <h3 style="margin:0; font-size:0.95rem; color:var(--text);">{{ $hashInfo['label'] }} Digest ({{ $hashInfo['bits'] }}-bit)</h3>
                <div style="display:flex; gap:6px;" id="hash-format-btns">
                    <button type="button" class="btn btn-secondary btn-sm dedicated-hash-fmt active" onclick="switchHashFormat('lower', this)">Lower</button>
                    <button type="button" class="btn btn-ghost btn-sm dedicated-hash-fmt" onclick="switchHashFormat('upper', this)">Upper</button>
                    <button type="button" class="btn btn-ghost btn-sm dedicated-hash-fmt" onclick="switchHashFormat('base64', this)">Base64</button>
                </div>
            </div>
            <div style="display:flex; gap:8px; align-items:stretch;">
                <div id="dedicated-hash-val" style="flex:1; font-family:var(--font-mono); font-size:0.86rem; word-break:break-all; padding:10px; background:var(--surface-subtle); border:1px solid var(--border); border-radius:var(--radius-sm); color:var(--text); min-height:40px; line-height:1.5;">—</div>
                <button type="button" class="btn btn-secondary btn-sm" onclick="copyDedicatedHash()" style="white-space:nowrap;">Copy Hash</button>
            </div>
        </div>

        <input type="hidden" id="dedicated-hash-algo" value="{{ $hashInfo['algo'] }}">
    </div>

@elseif ($tool['slug'] === 'curl-command-generator')
    {{-- cURL Command Generator --}}
    <div class="workspace-split">
        <div class="pane-card" style="padding:14px;">
            <h3 style="margin-top:0; font-size:0.95rem; color:var(--text);">Request Builder</h3>

            <div style="display:grid; grid-template-columns:100px 1fr; gap:8px; margin-top:10px;">
                <div>
                    <label for="curl-method" style="display:block; font-size:0.82rem; font-weight:600; color:var(--text); margin-bottom:3px;">Method:</label>
                    <select id="curl-method" style="width:100%; height:34px; font-size:0.84rem; font-weight:700; border-radius:var(--radius-sm); border:1px solid var(--border);" onchange="buildCurlCommand()">
                        <option>GET</option>
                        <option selected>POST</option>
                        <option>PUT</option>
                        <option>PATCH</option>
                        <option>DELETE</option>
                    </select>
                </div>
                <div>
                    <label for="curl-url" style="display:block; font-size:0.82rem; font-weight:600; color:var(--text); margin-bottom:3px;">URL:</label>
                    <input type="text" id="curl-url" placeholder="https://api.example.com/v1/users" style="width:100%; height:34px; font-size:0.86rem; font-family:var(--font-mono);" oninput="buildCurlCommand()">
                </div>
            </div>

            <div style="margin-top:10px;">
                <label style="display:block; font-size:0.82rem; font-weight:600; color:var(--text); margin-bottom:4px;">Headers (key: value per line):</label>
                <textarea id="curl-headers" class="editor-textarea" style="height:60px; font-family:var(--font-mono); font-size:0.82rem;" placeholder="Content-Type: application/json" oninput="buildCurlCommand()"></textarea>
            </div>

            <div style="margin-top:10px;" id="curl-body-section">
                <label style="display:block; font-size:0.82rem; font-weight:600; color:var(--text); margin-bottom:4px;">Request Body (JSON):</label>
                <textarea id="curl-body" class="editor-textarea" style="height:70px; font-family:var(--font-mono); font-size:0.82rem;" placeholder='{"key": "value"}' oninput="buildCurlCommand()"></textarea>
            </div>
        </div>

        <div class="pane-card">
            <div class="pane-header">
                <span>Generated cURL Command</span>
                <div class="pane-actions">
                    <button type="button" class="btn btn-secondary btn-sm" onclick="copyOutput('curl-output')">Copy Command</button>
                    <button type="button" class="btn btn-ghost btn-sm" onclick="loadCurlSample()">Sample</button>
                </div>
            </div>
            <textarea id="curl-output" class="editor-textarea" readonly placeholder="Terminal-ready cURL command will appear here..." style="background:#fafafa; font-family:var(--font-mono); font-size:0.86rem;"></textarea>
        </div>
    </div>

@elseif ($tool['slug'] === 'http-header-analyzer')
    {{-- HTTP Header Analyzer --}}
    <div>
        <div class="pane-card" style="padding:14px; margin-bottom:12px;">
            <h3 style="margin-top:0; font-size:0.95rem; color:var(--text);">Paste Raw HTTP Response Headers</h3>
            <textarea id="http-headers-input" class="editor-textarea" style="height:110px; font-family:var(--font-mono); font-size:0.82rem;" placeholder="HTTP/2 200 OK&#10;content-type: text/html; charset=utf-8&#10;strict-transport-security: max-age=31536000; includeSubDomains" spellcheck="false" oninput="analyzeHttpHeaders()"></textarea>
            <div style="display:flex; gap:8px; margin-top:8px; flex-wrap:wrap;">
                <button type="button" class="btn btn-primary btn-sm" onclick="analyzeHttpHeaders()">{{ $tool['cta_text'] ?? 'Analyze Headers' }}</button>
                <button type="button" class="btn btn-ghost btn-sm" onclick="loadHttpHeadersSample()">Sample</button>
                <button type="button" class="btn btn-ghost btn-sm" onclick="document.getElementById('http-headers-input').value=''; clearHttpHeadersReport();">Clear</button>
            </div>
        </div>

        <div id="http-headers-report" style="display:none;">
            <div class="pane-card" style="padding:14px; margin-bottom:12px;">
                <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:8px;">
                    <div>
                        <h3 style="margin:0; font-size:0.95rem; color:var(--text);">Security Headers Scorecard</h3>
                    </div>
                    <div id="http-score-badge" style="font-size:1.8rem; font-weight:800; color:var(--brand);">—</div>
                </div>
                <div id="http-score-grid" style="display:grid; grid-template-columns:repeat(auto-fit, minmax(140px, 1fr)); gap:8px; margin-top:10px;"></div>
            </div>
        </div>
    </div>

@elseif ($tool['slug'] === 'mime-type-lookup')
    {{-- MIME Type Lookup --}}
    <div>
        <div class="pane-card" style="padding:14px; margin-bottom:12px;">
            <h3 style="margin-top:0; font-size:0.95rem; color:var(--text);">Search MIME Types & Extensions</h3>
            <div style="display:flex; gap:8px; margin-top:8px;">
                <input type="text" id="mime-search" placeholder="Search extension (e.g. .json, .pdf) or MIME type..." style="flex:1; height:36px; font-size:0.88rem;" oninput="searchMimeTypes()">
                <button type="button" class="btn btn-ghost btn-sm" onclick="document.getElementById('mime-search').value=''; searchMimeTypes();">Clear</button>
            </div>
            <div style="display:flex; gap:6px; flex-wrap:wrap; margin-top:8px;" id="mime-category-btns">
                @foreach(['All', 'Application', 'Audio', 'Font', 'Image', 'Text', 'Video'] as $cat)
                    <button type="button" class="btn btn-ghost btn-sm mime-cat-btn {{ $cat === 'All' ? 'active' : '' }}"
                            onclick="filterMimeCategory('{{ strtolower($cat) }}', this)" style="padding:2px 8px; font-size:0.75rem;">{{ $cat }}</button>
                @endforeach
            </div>
        </div>

        <div class="pane-card" style="padding:12px;">
            <div style="overflow-x:auto; max-height:350px; overflow-y:auto;">
                <table style="width:100%; border-collapse:collapse; font-size:0.82rem;">
                    <thead style="position:sticky; top:0; z-index:1;">
                        <tr style="background:var(--surface-subtle); border-bottom:2px solid var(--border); text-align:left;">
                            <th style="padding:6px 10px;">Extension</th>
                            <th style="padding:6px 10px;">MIME Type</th>
                            <th style="padding:6px 10px;">Category</th>
                            <th style="padding:6px 10px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="mime-table-body">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endif
