@if ($tool['slug'] === 'password-strength-analyzer')
    {{-- Password Strength Analyzer --}}
    <div class="workspace-split">
        <div class="pane-card">
            <div class="pane-header">
                <span>Password / Passphrase Input</span>
                <div class="pane-actions">
                    <button type="button" class="btn btn-ghost btn-sm" onclick="document.getElementById('pw-strength-input').value = '';">Clear</button>
                    <button type="button" class="btn btn-ghost btn-sm" onclick="document.getElementById('pw-strength-input').value = 'CorrectHorseBatteryStaple#2026!'; runPasswordStrengthAnalyzer();">Sample</button>
                </div>
            </div>
            <input type="text" id="pw-strength-input" class="editor-textarea" style="height:60px; font-size:1.1rem; font-family:var(--font-mono);" placeholder="Type any password to inspect entropy..." oninput="runPasswordStrengthAnalyzer()">
        </div>

        <div class="pane-card">
            <div class="pane-header"><span>Entropy & Crack Estimation</span></div>
            <div id="pw-strength-report" style="flex:1; padding:16px; background:#fafafa; border-radius:var(--radius-sm); border:1px solid var(--border);"></div>
        </div>
    </div>

@elseif ($tool['slug'] === 'hash-comparator')
    {{-- Hash Comparator --}}
    <div class="workspace-split">
        <div class="pane-card">
            <div class="pane-header"><span>Expected Hash (from Release / Author)</span></div>
            <textarea id="hash-cmp-1" class="editor-textarea" style="height:120px;" placeholder="Paste expected hash (e.g. 5d41402abc4b2a76b9719d911017c592)..." oninput="runHashComparator()"></textarea>
            <div class="pane-header" style="margin-top:10px; border-top:1px solid var(--border);"><span>Calculated Hash (from Local File / String)</span></div>
            <textarea id="hash-cmp-2" class="editor-textarea" style="height:120px;" placeholder="Paste calculated hash..." oninput="runHashComparator()"></textarea>
        </div>

        <div class="pane-card">
            <div class="pane-header">
                <span>Verification Result</span>
                <button type="button" class="btn btn-primary btn-sm" onclick="runHashComparator()">Compare</button>
            </div>
            <div id="hash-cmp-status" style="flex:1; padding:16px; background:#fafafa; border-radius:var(--radius-sm); border:1px solid var(--border);">
                <div style="color:var(--text-muted);">Paste both hashes to compare timing-safe integrity match.</div>
            </div>
        </div>
    </div>

@elseif ($tool['slug'] === 'api-key-generator')
    {{-- API Key Generator --}}
    <div class="workspace-split">
        <div class="pane-card" style="padding:20px; gap:14px;">
            <div style="font-weight:700; font-size:0.92rem; text-transform:uppercase; border-bottom:1px solid var(--border); padding-bottom:10px;">Token Configuration</div>
            <div>
                <label for="apikey-prefix" style="font-size:0.85rem; font-weight:600; display:block; margin-bottom:4px;">Prefix:</label>
                <input type="text" id="apikey-prefix" value="sk_live_" style="width:100%; height:36px; font-family:var(--font-mono);">
            </div>
            <div>
                <label for="apikey-length" style="font-size:0.85rem; font-weight:600; display:block; margin-bottom:4px;">Random Character Length:</label>
                <input type="number" id="apikey-length" value="32" min="16" max="128" style="width:100%; height:36px;">
            </div>
            <div>
                <label for="apikey-count" style="font-size:0.85rem; font-weight:600; display:block; margin-bottom:4px;">Quantity to Generate:</label>
                <input type="number" id="apikey-count" value="5" min="1" max="50" style="width:100%; height:36px;">
            </div>
            <button type="button" class="btn btn-primary btn-lg" onclick="runApiKeyGenerator()">Generate Cryptographic API Keys</button>
        </div>

        <div class="pane-card">
            <div class="pane-header">
                <span>Generated API Keys</span>
                <div class="pane-actions">
                    <button type="button" class="btn btn-secondary btn-sm" onclick="copyOutput('apikey-output')">Copy Keys</button>
                </div>
            </div>
            <pre id="apikey-output" class="output-pre" style="flex:1; min-height:260px; font-family:var(--font-mono);"></pre>
        </div>
    </div>

@elseif ($tool['slug'] === 'sri-hash-generator')
    {{-- SRI Generator --}}
    <div style="margin-bottom:12px; display:flex; gap:10px; align-items:center;">
        <label for="sri-url" style="font-size:0.88rem; font-weight:600;">CDN Resource URL:</label>
        <input type="text" id="sri-url" value="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" style="flex:1; height:34px;" oninput="runSriHashGenerator()">
        <button type="button" class="btn btn-primary btn-sm" onclick="runSriHashGenerator()">Compute SRI</button>
    </div>

    <div class="workspace-split">
        <div class="pane-card">
            <div class="pane-header">
                <span>Asset Code Content (JS / CSS)</span>
                <div class="pane-actions">
                    <button type="button" class="btn btn-ghost btn-sm" onclick="document.getElementById('sri-input').value = '';">Clear</button>
                    <button type="button" class="btn btn-ghost btn-sm" onclick="document.getElementById('sri-input').value = 'console.log(\"WebToolsStation Subresource Integrity Verified\");'; runSriHashGenerator();">Sample</button>
                </div>
            </div>
            <textarea id="sri-input" class="editor-textarea" placeholder="Paste exact script or stylesheet source code..." oninput="runSriHashGenerator()"></textarea>
        </div>

        <div class="pane-card">
            <div class="pane-header">
                <span>HTML Tag with Integrity Attribute</span>
                <div class="pane-actions">
                    <button type="button" class="btn btn-secondary btn-sm" onclick="copyOutput('sri-output')">Copy Tag</button>
                </div>
            </div>
            <textarea id="sri-output" class="editor-textarea" readonly placeholder="Computed SRI tag..."></textarea>
        </div>
    </div>

@elseif ($tool['slug'] === 'csp-generator')
    {{-- CSP Generator --}}
    <div class="workspace-split">
        <div class="pane-card" style="padding:16px; gap:10px;">
            <div>
                <label for="csp-default" style="font-size:0.85rem; font-weight:700;">default-src:</label>
                <input type="text" id="csp-default" value="'self'" style="width:100%; height:32px; font-family:var(--font-mono);" oninput="runCspGenerator()">
            </div>
            <div>
                <label for="csp-script" style="font-size:0.85rem; font-weight:700;">script-src:</label>
                <input type="text" id="csp-script" value="'self' https://cdn.jsdelivr.net" style="width:100%; height:32px; font-family:var(--font-mono);" oninput="runCspGenerator()">
            </div>
            <div>
                <label for="csp-style" style="font-size:0.85rem; font-weight:700;">style-src:</label>
                <input type="text" id="csp-style" value="'self' 'unsafe-inline'" style="width:100%; height:32px; font-family:var(--font-mono);" oninput="runCspGenerator()">
            </div>
            <div>
                <label for="csp-img" style="font-size:0.85rem; font-weight:700;">img-src:</label>
                <input type="text" id="csp-img" value="'self' data: https:" style="width:100%; height:32px; font-family:var(--font-mono);" oninput="runCspGenerator()">
            </div>
            <button type="button" class="btn btn-primary" onclick="runCspGenerator()">Generate CSP</button>
        </div>

        <div class="pane-card">
            <div class="pane-header">
                <span>Generated CSP Policy & Meta Tag</span>
                <div class="pane-actions">
                    <button type="button" class="btn btn-secondary btn-sm" onclick="copyOutput('csp-output')">Copy</button>
                </div>
            </div>
            <textarea id="csp-output" class="editor-textarea" readonly placeholder="Content-Security-Policy..."></textarea>
        </div>
    </div>

@elseif ($tool['slug'] === 'csp-validator')
    {{-- CSP Validator --}}
    <div class="workspace-split">
        <div class="pane-card">
            <div class="pane-header">
                <span>CSP Header String</span>
                <div class="pane-actions">
                    <button type="button" class="btn btn-ghost btn-sm" onclick="document.getElementById('csp-val-input').value = '';">Clear</button>
                    <button type="button" class="btn btn-ghost btn-sm" onclick="document.getElementById('csp-val-input').value = 'default-src \'self\'; script-src \'self\' \'unsafe-inline\' *; style-src \'self\';'; runCspValidator();">Sample</button>
                </div>
            </div>
            <textarea id="csp-val-input" class="editor-textarea" placeholder="Paste CSP header string..." oninput="runCspValidator()"></textarea>
        </div>

        <div class="pane-card">
            <div class="pane-header">
                <span>Security Audit Scorecard</span>
                <button type="button" class="btn btn-primary btn-sm" onclick="runCspValidator()">Audit Policy</button>
            </div>
            <div id="csp-val-report" style="flex:1; padding:16px; background:#fafafa; border-radius:var(--radius-sm); border:1px solid var(--border);"></div>
        </div>
    </div>

@elseif ($tool['slug'] === 'file-hash-calculator')
    {{-- File Hash Calculator --}}
    <div class="workspace-split">
        <div class="pane-card" style="padding:24px;">
            <div style="font-weight:700; font-size:0.92rem; text-transform:uppercase; margin-bottom:12px;">Local File Selection</div>
            <div style="border:2px dashed var(--border-hover); border-radius:var(--radius-md); padding:36px 20px; text-align:center; background:var(--surface-subtle); cursor:pointer;" onclick="document.getElementById('file-hash-picker').click()">
                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" style="color:var(--brand); margin-bottom:10px;"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline></svg>
                <div style="font-weight:700; font-size:1.05rem;">Choose file to compute hashes</div>
                <div style="font-size:0.82rem; color:var(--text-muted); margin-top:4px;">Executed client-side in browser memory · Zero uploads</div>
                <button type="button" class="btn btn-secondary btn-sm" style="margin-top:14px;">Select File</button>
            </div>
            <input type="file" id="file-hash-picker" style="display:none;" onchange="runFileHashCalculator(this)">
        </div>

        <div class="pane-card">
            <div class="pane-header">
                <span>Computed Digests (SHA-256 & SHA-1)</span>
                <div class="pane-actions">
                    <button type="button" class="btn btn-secondary btn-sm" onclick="copyOutput('file-hash-output')">Copy Hashes</button>
                </div>
            </div>
            <pre id="file-hash-output" class="output-pre" style="flex:1; min-height:260px;">Select a file on the left to compute cryptographic checksums.</pre>
        </div>
    </div>

@elseif ($tool['slug'] === 'sensitive-data-redactor')
    {{-- Sensitive Data Redactor --}}
    <div style="margin-bottom:12px; display:flex; gap:10px; align-items:center;">
        <label for="redact-mask" style="font-size:0.88rem; font-weight:600;">Mask Replacement:</label>
        <input type="text" id="redact-mask" value="[REDACTED]" style="width:140px; height:32px;" oninput="runSensitiveDataRedactor()">
        <button type="button" class="btn btn-primary btn-sm" onclick="runSensitiveDataRedactor()">Mask Sensitive Data</button>
    </div>

    <div class="workspace-split">
        <div class="pane-card">
            <div class="pane-header">
                <span>Raw Log / Text Input</span>
                <div class="pane-actions">
                    <button type="button" class="btn btn-ghost btn-sm" onclick="document.getElementById('redact-input').value = '';">Clear</button>
                    <button type="button" class="btn btn-ghost btn-sm" onclick="document.getElementById('redact-input').value = 'User alex@example.com purchased order with card 4532-1234-5678-9012 from IP 192.168.1.45 using Bearer secret_live_token99887766.'; runSensitiveDataRedactor();">Sample</button>
                </div>
            </div>
            <textarea id="redact-input" class="editor-textarea" placeholder="Paste server logs or user text..." oninput="runSensitiveDataRedactor()"></textarea>
        </div>

        <div class="pane-card">
            <div class="pane-header">
                <span>Sanitized Redacted Output</span>
                <div class="pane-actions">
                    <button type="button" class="btn btn-secondary btn-sm" onclick="copyOutput('redact-output')">Copy</button>
                </div>
            </div>
            <textarea id="redact-output" class="editor-textarea" readonly placeholder="Sanitized logs..."></textarea>
        </div>
    </div>
@endif
