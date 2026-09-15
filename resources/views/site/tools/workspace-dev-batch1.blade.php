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
            <textarea id="yaml-fmt-input" class="editor-textarea" placeholder="Paste unformatted or messy YAML here..." spellcheck="false"></textarea>
            <div style="padding:8px 12px; background:var(--surface-subtle); border-top:1px solid var(--border); font-size:0.78rem; color:var(--text-muted); display:flex; justify-content:space-between;">
                <span id="yaml-fmt-input-stats">0 lines | 0 characters</span>
                <span>UTF-8 Client-Side</span>
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
            <div style="padding:8px 12px; background:var(--surface-subtle); border-top:1px solid var(--border); font-size:0.78rem; color:var(--text-muted); display:flex; justify-content:space-between;">
                <span id="yaml-fmt-output-stats">0 lines | 0 characters</span>
                <span style="color:var(--brand-dark); font-weight:600;">YAML Formatted</span>
            </div>
        </div>
    </div>

    <div style="display:flex; align-items:center; gap:12px; flex-wrap:wrap; margin-top:16px; padding:12px 16px; background:var(--surface-subtle); border:1px solid var(--border); border-radius:var(--radius-md);">
        <label for="yaml-indent-size" style="font-size:0.88rem; font-weight:600; color:var(--text);">Indentation:</label>
        <select id="yaml-indent-size" style="height:36px; padding:0 10px; font-weight:600; border-radius:var(--radius-sm); border:1px solid var(--border); background:#ffffff;">
            <option value="2" selected>2 Spaces (Recommended)</option>
            <option value="4">4 Spaces</option>
        </select>
    </div>

    <div id="yaml-fmt-error" style="display:none; margin-top:12px; padding:12px 16px; background:var(--danger-bg); border:1px solid var(--danger); border-radius:var(--radius-sm); color:var(--danger); font-size:0.9rem;">
        <strong>YAML Syntax Issue:</strong> <span id="yaml-fmt-error-msg"></span>
    </div>

    <div class="workspace-toolbar" style="margin-top:16px;">
        <div class="workspace-btn-group">
            <button type="button" class="btn btn-primary" onclick="runYamlFormatter()">Format YAML</button>
            <button type="button" class="btn btn-secondary" onclick="clearYamlFormatter()">Clear</button>
        </div>
        <div class="workspace-hint">
            <span>Keyboard: Press <kbd>Ctrl/Cmd+Enter</kbd> to format</span>
        </div>
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
            <textarea id="yaml-val-input" class="editor-textarea" placeholder="Paste YAML configuration to validate syntax and structure..." spellcheck="false"></textarea>
        </div>

        <div class="pane-card">
            <div class="pane-header">
                <span>Validation Diagnostic</span>
                <div class="pane-actions">
                    <button type="button" class="btn btn-secondary btn-sm" onclick="copyOutput('yaml-val-output')">Copy Parsed</button>
                </div>
            </div>

            <div id="yaml-val-status-box" style="padding:16px; border-bottom:1px solid var(--border); background:var(--surface-subtle);">
                <div id="yaml-val-initial" style="color:var(--text-muted); font-size:0.92rem; display:flex; align-items:center; gap:8px;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
                    Enter YAML and click "Validate YAML" to inspect for syntax errors.
                </div>
                <div id="yaml-val-success" style="display:none; padding:12px 16px; background:var(--success-bg); border:1px solid rgba(22,163,74,0.3); border-radius:var(--radius-sm); color:var(--success);">
                    <div style="font-weight:700; font-size:1rem; display:flex; align-items:center; gap:8px;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                        Valid YAML!
                    </div>
                    <div style="font-size:0.86rem; margin-top:4px; color:var(--text);">Document conforms to YAML specification with 0 syntax errors.</div>
                </div>
                <div id="yaml-val-failure" style="display:none; padding:12px 16px; background:var(--danger-bg); border:1px solid rgba(220,38,38,0.3); border-radius:var(--radius-sm); color:var(--danger);">
                    <div style="font-weight:700; font-size:1rem; display:flex; align-items:center; gap:8px;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
                        Invalid YAML Syntax
                    </div>
                    <div id="yaml-val-error-details" style="font-size:0.88rem; font-weight:600; margin-top:6px; font-family:var(--font-mono); color:#991b1b; white-space:pre-wrap;"></div>
                </div>
            </div>

            <textarea id="yaml-val-output" class="editor-textarea" readonly placeholder="Parsed structure (converted to JSON) will appear here after validation..." style="flex:1; background:#ffffff;"></textarea>
        </div>
    </div>

    <div class="workspace-toolbar" style="margin-top:16px;">
        <div class="workspace-btn-group">
            <button type="button" class="btn btn-primary" onclick="runYamlValidator()">Validate YAML</button>
            <button type="button" class="btn btn-secondary" onclick="clearYamlValidator()">Clear</button>
        </div>
        <div class="workspace-hint">
            <span>Keyboard: Press <kbd>Ctrl/Cmd+Enter</kbd> to validate</span>
        </div>
    </div>

@elseif ($tool['slug'] === 'jwt-generator')
    {{-- JWT Generator --}}
    <div class="workspace-split">
        <div class="pane-card" style="padding:20px;">
            <h3 style="margin-top:0; font-size:1.1rem; color:var(--text);">Token Configuration</h3>

            <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px; margin-top:14px;">
                <div>
                    <label for="jwt-gen-algo" style="display:block; font-size:0.88rem; font-weight:600; color:var(--text); margin-bottom:4px;">Algorithm:</label>
                    <select id="jwt-gen-algo" style="width:100%; height:38px; border-radius:var(--radius-sm); border:1px solid var(--border);">
                        <option value="HS256" selected>HS256 (Recommended)</option>
                        <option value="HS384">HS384</option>
                        <option value="HS512">HS512</option>
                    </select>
                </div>
                <div>
                    <label for="jwt-gen-secret" style="display:block; font-size:0.88rem; font-weight:600; color:var(--text); margin-bottom:4px;">Secret Key:</label>
                    <input type="text" id="jwt-gen-secret" placeholder="your-secret-key" style="width:100%; height:38px; font-family:var(--font-mono);">
                </div>
            </div>

            <div style="margin-top:14px;">
                <label for="jwt-gen-payload" style="display:block; font-size:0.88rem; font-weight:600; color:var(--text); margin-bottom:4px;">Payload (JSON Claims):</label>
                <textarea id="jwt-gen-payload" class="editor-textarea" style="height:160px; font-family:var(--font-mono); font-size:0.88rem;" placeholder='{"sub":"user123","name":"Jane Doe","role":"admin"}'></textarea>
            </div>

            <div style="margin-top:14px;">
                <label style="display:block; font-size:0.88rem; font-weight:600; color:var(--text); margin-bottom:8px;">Expiration Quick Presets:</label>
                <div style="display:flex; gap:8px; flex-wrap:wrap;">
                    <button type="button" class="btn btn-ghost btn-sm" onclick="setJwtExpiry(3600)">+1 Hour</button>
                    <button type="button" class="btn btn-ghost btn-sm" onclick="setJwtExpiry(86400)">+1 Day</button>
                    <button type="button" class="btn btn-ghost btn-sm" onclick="setJwtExpiry(604800)">+7 Days</button>
                    <button type="button" class="btn btn-ghost btn-sm" onclick="setJwtExpiry(2592000)">+30 Days</button>
                    <button type="button" class="btn btn-ghost btn-sm" onclick="loadJwtGenSample()">Sample Payload</button>
                </div>
            </div>

            <button type="button" class="btn btn-primary btn-lg" style="width:100%; margin-top:20px;" onclick="generateJwtToken()">Generate JWT Token</button>
        </div>

        <div class="pane-card">
            <div class="pane-header">
                <span>Generated JWT Token</span>
                <div class="pane-actions">
                    <button type="button" class="btn btn-secondary btn-sm" onclick="copyOutput('jwt-gen-output')">Copy Token</button>
                </div>
            </div>
            <textarea id="jwt-gen-output" class="editor-textarea" readonly placeholder="Signed JWT token will appear here..." style="background:#fafafa; word-break:break-all;"></textarea>
            <div id="jwt-gen-decoded-preview" style="display:none; padding:14px; border-top:1px solid var(--border);">
                <div style="font-size:0.75rem; font-weight:700; text-transform:uppercase; letter-spacing:0.06em; color:var(--brand); margin-bottom:8px;">Token Preview</div>
                <div style="font-family:var(--font-mono); font-size:0.82rem; word-break:break-all; line-height:1.6;">
                    <span id="jwt-part-header" style="color:#e34c26;"></span>.<span id="jwt-part-payload" style="color:#563d7c;"></span>.<span id="jwt-part-sig" style="color:#0086b3;"></span>
                </div>
                <div style="margin-top:10px; font-size:0.8rem; color:var(--text-muted);">
                    <a href="/tools/jwt-decoder" style="color:var(--brand);">→ Decode this token with JWT Decoder</a>
                </div>
            </div>
        </div>
    </div>

@elseif ($tool['slug'] === 'nanoid-generator')
    {{-- NanoID Generator --}}
    <div class="workspace-split">
        <div class="pane-card" style="padding:20px;">
            <h3 style="margin-top:0; font-size:1.1rem; color:var(--text);">NanoID Parameters</h3>

            <div style="margin-top:14px;">
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:6px;">
                    <label for="nanoid-length" style="font-size:0.88rem; font-weight:600; color:var(--text);">ID Length:</label>
                    <span id="nanoid-length-val" style="font-weight:700; color:var(--brand); font-family:var(--font-mono);">21</span>
                </div>
                <input type="range" id="nanoid-length" min="6" max="64" value="21" oninput="document.getElementById('nanoid-length-val').textContent = this.value" style="width:100%;">
                <div style="display:flex; justify-content:space-between; font-size:0.72rem; color:var(--text-muted);">
                    <span>6 (short)</span><span>21 (standard)</span><span>64 (max)</span>
                </div>
            </div>

            <div style="margin-top:16px;">
                <label style="display:block; font-size:0.88rem; font-weight:600; color:var(--text); margin-bottom:8px;">Alphabet Preset:</label>
                <div style="display:flex; gap:8px; flex-wrap:wrap;" id="nanoid-alphabet-btns">
                    <button type="button" class="btn btn-secondary btn-sm nanoid-preset active" onclick="setNanoIdAlphabet('url', this)">URL-Safe (Default)</button>
                    <button type="button" class="btn btn-ghost btn-sm nanoid-preset" onclick="setNanoIdAlphabet('numbers', this)">Numbers Only</button>
                    <button type="button" class="btn btn-ghost btn-sm nanoid-preset" onclick="setNanoIdAlphabet('hex', this)">Hexadecimal</button>
                    <button type="button" class="btn btn-ghost btn-sm nanoid-preset" onclick="setNanoIdAlphabet('lower', this)">Lowercase</button>
                </div>
            </div>

            <div style="margin-top:14px;">
                <label for="nanoid-custom-alpha" style="display:block; font-size:0.88rem; font-weight:600; color:var(--text); margin-bottom:4px;">Custom Alphabet (optional):</label>
                <input type="text" id="nanoid-custom-alpha" placeholder="e.g. 0123456789ABCDEF" style="width:100%; height:38px; font-family:var(--font-mono);" oninput="nanoidCustomAlphaChange()">
            </div>

            <div style="margin-top:14px;">
                <label for="nanoid-count" style="display:block; font-size:0.88rem; font-weight:600; color:var(--text); margin-bottom:4px;">Quantity (1–50):</label>
                <input type="number" id="nanoid-count" min="1" max="50" value="5" style="width:100%; height:40px; font-family:var(--font-mono);">
            </div>

            <button type="button" class="btn btn-primary btn-lg" style="width:100%; margin-top:20px;" onclick="generateNanoIds()">Generate NanoID(s)</button>
        </div>

        <div class="pane-card">
            <div class="pane-header">
                <span>Generated NanoIDs</span>
                <div class="pane-actions">
                    <button type="button" class="btn btn-secondary btn-sm" onclick="copyOutput('nanoid-output')">Copy All</button>
                </div>
            </div>
            <textarea id="nanoid-output" class="editor-textarea" readonly placeholder="Generated URL-safe NanoIDs will appear here, one per line..." style="background:#fafafa;"></textarea>
            <div style="padding:8px 12px; background:var(--surface-subtle); border-top:1px solid var(--border); font-size:0.78rem; color:var(--text-muted);">
                <span id="nanoid-entropy-note">21 chars × 64-char alphabet = ~126 bits of entropy per ID</span>
            </div>
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
        <div class="pane-card" style="margin-bottom:20px;">
            <div class="pane-header">
                <span>Input Plaintext</span>
                <div class="pane-actions">
                    <button type="button" class="btn btn-ghost btn-sm" onclick="document.getElementById('dedicated-hash-input').value=''; computeDedicatedHash();">Clear</button>
                    <button type="button" class="btn btn-ghost btn-sm" onclick="document.getElementById('dedicated-hash-input').value='WebToolsStation {{ $hashInfo['label'] }} checksum test'; computeDedicatedHash();">Sample</button>
                </div>
            </div>
            <textarea id="dedicated-hash-input" class="editor-textarea" style="height:130px;" placeholder="Enter or paste text to compute {{ $hashInfo['label'] }} hash in real time..." oninput="computeDedicatedHash()" spellcheck="false"></textarea>
        </div>

        <div class="pane-card" style="padding:20px;">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:14px; flex-wrap:wrap; gap:10px;">
                <h3 style="margin:0; font-size:1.05rem; color:var(--text);">{{ $hashInfo['label'] }} Digest ({{ $hashInfo['bits'] }}-bit / {{ $hashInfo['hexlen'] }} hex characters)</h3>
                <div style="display:flex; gap:8px;" id="hash-format-btns">
                    <button type="button" class="btn btn-secondary btn-sm dedicated-hash-fmt active" onclick="switchHashFormat('lower', this)">Lowercase</button>
                    <button type="button" class="btn btn-ghost btn-sm dedicated-hash-fmt" onclick="switchHashFormat('upper', this)">Uppercase</button>
                    <button type="button" class="btn btn-ghost btn-sm dedicated-hash-fmt" onclick="switchHashFormat('base64', this)">Base64</button>
                </div>
            </div>
            <div style="display:flex; gap:10px; align-items:stretch;">
                <div id="dedicated-hash-val" style="flex:1; font-family:var(--font-mono); font-size:0.9rem; word-break:break-all; padding:14px; background:var(--surface-subtle); border:1px solid var(--border); border-radius:var(--radius-sm); color:var(--text); min-height:50px; line-height:1.7;">—</div>
                <button type="button" class="btn btn-secondary btn-sm" onclick="copyDedicatedHash()" style="white-space:nowrap;">Copy Hash</button>
            </div>
            <div id="dedicated-hash-status" style="margin-top:10px; font-size:0.78rem; color:var(--text-muted);">
                Enter text above to compute the {{ $hashInfo['label'] }} digest.
            </div>
        </div>

        {{-- Security / Usage Note --}}
        @if ($tool['slug'] === 'md5-hash-generator')
        <div style="margin-top:16px; padding:12px 16px; background:#fffbeb; border:1px solid #f59e0b; border-radius:var(--radius-sm); font-size:0.85rem; color:#92400e;">
            <strong>⚠ Security Note:</strong> MD5 is cryptographically broken. Use MD5 only for non-security purposes like cache keys, Gravatar hashes, or legacy checksums.
        </div>
        @elseif ($tool['slug'] === 'sha1-hash-generator')
        <div style="margin-top:16px; padding:12px 16px; background:#fffbeb; border:1px solid #f59e0b; border-radius:var(--radius-sm); font-size:0.85rem; color:#92400e;">
            <strong>⚠ Security Note:</strong> SHA-1 is deprecated for certificates and signatures. Use SHA-256 or SHA-512 for new security applications.
        </div>
        @endif

        {{-- Hidden algo for JS to read --}}
        <input type="hidden" id="dedicated-hash-algo" value="{{ $hashInfo['algo'] }}">
    </div>

@elseif ($tool['slug'] === 'curl-command-generator')
    {{-- cURL Command Generator --}}
    <div class="workspace-split">
        <div class="pane-card" style="padding:20px;">
            <h3 style="margin-top:0; font-size:1.1rem; color:var(--text);">Request Builder</h3>

            <div style="display:grid; grid-template-columns:140px 1fr; gap:10px; margin-top:14px;">
                <div>
                    <label for="curl-method" style="display:block; font-size:0.88rem; font-weight:600; color:var(--text); margin-bottom:4px;">Method:</label>
                    <select id="curl-method" style="width:100%; height:40px; font-weight:700; border-radius:var(--radius-sm); border:1px solid var(--border);" onchange="buildCurlCommand()">
                        <option>GET</option>
                        <option selected>POST</option>
                        <option>PUT</option>
                        <option>PATCH</option>
                        <option>DELETE</option>
                        <option>HEAD</option>
                        <option>OPTIONS</option>
                    </select>
                </div>
                <div>
                    <label for="curl-url" style="display:block; font-size:0.88rem; font-weight:600; color:var(--text); margin-bottom:4px;">URL:</label>
                    <input type="text" id="curl-url" placeholder="https://api.example.com/v1/users" style="width:100%; height:40px; font-family:var(--font-mono);" oninput="buildCurlCommand()">
                </div>
            </div>

            <div style="margin-top:14px;">
                <label style="display:block; font-size:0.88rem; font-weight:600; color:var(--text); margin-bottom:6px;">Authentication:</label>
                <div style="display:flex; gap:8px; flex-wrap:wrap; margin-bottom:8px;" id="curl-auth-btns">
                    <button type="button" class="btn btn-ghost btn-sm curl-auth-btn active" onclick="setCurlAuth('none', this)">None</button>
                    <button type="button" class="btn btn-ghost btn-sm curl-auth-btn" onclick="setCurlAuth('bearer', this)">Bearer Token</button>
                    <button type="button" class="btn btn-ghost btn-sm curl-auth-btn" onclick="setCurlAuth('basic', this)">Basic Auth</button>
                </div>
                <div id="curl-auth-bearer" style="display:none;">
                    <input type="text" id="curl-bearer-token" placeholder="eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9..." style="width:100%; height:38px; font-family:var(--font-mono);" oninput="buildCurlCommand()">
                </div>
                <div id="curl-auth-basic" style="display:none; display:grid; grid-template-columns:1fr 1fr; gap:8px;">
                    <input type="text" id="curl-basic-user" placeholder="username" style="height:38px; font-family:var(--font-mono);" oninput="buildCurlCommand()">
                    <input type="password" id="curl-basic-pass" placeholder="password" style="height:38px; font-family:var(--font-mono);" oninput="buildCurlCommand()">
                </div>
            </div>

            <div style="margin-top:14px;">
                <label style="display:block; font-size:0.88rem; font-weight:600; color:var(--text); margin-bottom:6px;">Request Headers (key: value per line):</label>
                <textarea id="curl-headers" class="editor-textarea" style="height:90px; font-family:var(--font-mono); font-size:0.85rem;" placeholder="Content-Type: application/json&#10;Accept: application/json" oninput="buildCurlCommand()"></textarea>
            </div>

            <div style="margin-top:14px;" id="curl-body-section">
                <label style="display:block; font-size:0.88rem; font-weight:600; color:var(--text); margin-bottom:6px;">Request Body (JSON):</label>
                <textarea id="curl-body" class="editor-textarea" style="height:100px; font-family:var(--font-mono); font-size:0.85rem;" placeholder='{"key": "value"}' oninput="buildCurlCommand()"></textarea>
            </div>

            <div style="margin-top:14px; display:flex; flex-wrap:wrap; gap:12px;">
                <label style="font-size:0.88rem; display:flex; align-items:center; gap:6px; cursor:pointer;">
                    <input type="checkbox" id="curl-flag-L" onchange="buildCurlCommand()" style="width:16px; height:16px;"> -L Follow Redirects
                </label>
                <label style="font-size:0.88rem; display:flex; align-items:center; gap:6px; cursor:pointer;">
                    <input type="checkbox" id="curl-flag-s" onchange="buildCurlCommand()" style="width:16px; height:16px;"> -s Silent Mode
                </label>
                <label style="font-size:0.88rem; display:flex; align-items:center; gap:6px; cursor:pointer;">
                    <input type="checkbox" id="curl-flag-k" onchange="buildCurlCommand()" style="width:16px; height:16px;"> -k Skip SSL Verify
                </label>
                <label style="font-size:0.88rem; display:flex; align-items:center; gap:6px; cursor:pointer;">
                    <input type="checkbox" id="curl-flag-i" onchange="buildCurlCommand()" style="width:16px; height:16px;"> -i Include Headers
                </label>
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
            <textarea id="curl-output" class="editor-textarea" readonly placeholder="Your terminal-ready cURL command will appear here as you fill in the fields..." style="background:#fafafa; font-family:var(--font-mono); font-size:0.88rem;"></textarea>
        </div>
    </div>

@elseif ($tool['slug'] === 'http-header-analyzer')
    {{-- HTTP Header Analyzer --}}
    <div>
        <div class="pane-card" style="padding:20px; margin-bottom:16px;">
            <h3 style="margin-top:0; font-size:1.1rem; color:var(--text);">Paste Raw HTTP Response Headers</h3>
            <textarea id="http-headers-input" class="editor-textarea" style="height:160px; font-family:var(--font-mono); font-size:0.85rem;" placeholder="HTTP/2 200 OK&#10;content-type: text/html; charset=utf-8&#10;strict-transport-security: max-age=31536000; includeSubDomains&#10;..." spellcheck="false"></textarea>
            <div style="display:flex; gap:10px; margin-top:12px; flex-wrap:wrap;">
                <button type="button" class="btn btn-primary" onclick="analyzeHttpHeaders()">Analyze Headers</button>
                <button type="button" class="btn btn-secondary" onclick="loadHttpHeadersSample()">Load Sample</button>
                <button type="button" class="btn btn-ghost btn-sm" onclick="document.getElementById('http-headers-input').value=''; clearHttpHeadersReport();">Clear</button>
            </div>
        </div>

        <div id="http-headers-report" style="display:none;">
            {{-- Security Scorecard --}}
            <div class="pane-card" style="padding:20px; margin-bottom:16px;">
                <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px;">
                    <div>
                        <div style="font-size:0.75rem; font-weight:700; text-transform:uppercase; letter-spacing:0.06em; color:var(--brand); margin-bottom:4px;">Security Scorecard</div>
                        <h3 style="margin:0; font-size:1.1rem; color:var(--text);">Security Headers Quick Check (5 Core Headers)</h3>
                    </div>
                    <div id="http-score-badge" style="font-size:2.5rem; font-weight:900; color:var(--brand);">—</div>
                </div>
                <div id="http-score-grid" style="display:grid; grid-template-columns:repeat(auto-fit, minmax(160px, 1fr)); gap:10px; margin-top:16px;"></div>
            </div>

            {{-- Parsed Headers Table --}}
            <div class="pane-card" style="padding:20px;">
                <h3 style="margin:0 0 12px; font-size:1.05rem; color:var(--text);">Parsed Headers Table</h3>
                <div style="overflow-x:auto;">
                    <table style="width:100%; border-collapse:collapse; font-size:0.86rem;">
                        <thead>
                            <tr style="background:var(--surface-subtle); border-bottom:2px solid var(--border); text-align:left;">
                                <th style="padding:8px 12px;">Header Name</th>
                                <th style="padding:8px 12px;">Value</th>
                            </tr>
                        </thead>
                        <tbody id="http-headers-table-body">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@elseif ($tool['slug'] === 'mime-type-lookup')
    {{-- MIME Type Lookup --}}
    <div>
        <div class="pane-card" style="padding:20px; margin-bottom:16px;">
            <h3 style="margin-top:0; font-size:1.1rem; color:var(--text);">Search MIME Types & File Extensions</h3>
            <div style="display:flex; gap:10px; margin-top:12px;">
                <input type="text" id="mime-search" placeholder="Search by extension (e.g. .pdf) or MIME type (e.g. application/json)..." style="flex:1; height:44px; font-size:0.95rem;" oninput="searchMimeTypes()">
                <button type="button" class="btn btn-secondary" onclick="document.getElementById('mime-search').value=''; searchMimeTypes();">Clear</button>
            </div>
            <div style="display:flex; gap:8px; flex-wrap:wrap; margin-top:12px;" id="mime-category-btns">
                @foreach(['All', 'Application', 'Audio', 'Font', 'Image', 'Text', 'Video'] as $cat)
                    <button type="button" class="btn btn-ghost btn-sm mime-cat-btn {{ $cat === 'All' ? 'active' : '' }}"
                            onclick="filterMimeCategory('{{ strtolower($cat) }}', this)">{{ $cat }}</button>
                @endforeach
            </div>
        </div>

        <div class="pane-card" style="padding:16px;">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px; flex-wrap:wrap; gap:8px;">
                <span id="mime-results-count" style="font-size:0.88rem; font-weight:600; color:var(--text-muted);">Loading MIME database...</span>
                <span style="font-size:0.78rem; color:var(--text-muted);">80+ indexed MIME types</span>
            </div>
            <div style="overflow-x:auto; max-height:400px; overflow-y:auto;">
                <table style="width:100%; border-collapse:collapse; font-size:0.84rem;">
                    <thead style="position:sticky; top:0; z-index:1;">
                        <tr style="background:var(--surface-subtle); border-bottom:2px solid var(--border); text-align:left;">
                            <th style="padding:8px 12px;">Extension</th>
                            <th style="padding:8px 12px;">MIME Type</th>
                            <th style="padding:8px 12px;">Category</th>
                            <th style="padding:8px 12px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="mime-table-body">
                        <tr><td colspan="4" style="padding:20px; text-align:center; color:var(--text-muted);">Initializing MIME database...</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endif
