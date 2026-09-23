@if ($tool['slug'] === 'ulid-generator')
    <!-- ULID Generator -->
    <div class="workspace-split">
        <div class="pane-card" style="padding:14px;">
            <h3 style="margin-top:0; font-size:0.95rem; color:var(--text);">ULID Generation Settings</h3>
            <div style="margin-top:10px;">
                <label for="ulid-quantity" style="display:block; font-size:0.82rem; font-weight:600; color:var(--text); margin-bottom:4px;">Quantity:</label>
                <input type="number" id="ulid-quantity" min="1" max="50" value="5" style="width:100%; height:34px; font-size:0.86rem; font-family:var(--font-mono);">
                <span style="font-size:0.75rem; color:var(--text-muted); margin-top:2px; display:block;">Generate between 1 and 50 sortable ULIDs</span>
            </div>

            <div style="margin-top:14px;">
                <button type="button" class="btn btn-primary" style="width:100%;" onclick="generateUlids()">
                    {{ $tool['cta_text'] ?? 'Generate ULIDs' }}
                </button>
            </div>
        </div>

        <div class="pane-card">
            <div class="pane-header">
                <span>Generated ULIDs</span>
                <div class="pane-actions">
                    <button type="button" class="btn btn-secondary btn-sm" onclick="copyOutput('ulid-output')">Copy All</button>
                </div>
            </div>
            <textarea id="ulid-output" class="editor-textarea" readonly placeholder="Generated 26-character Crockford Base32 ULIDs will appear here..." style="background:#fafafa;"></textarea>
        </div>
    </div>

@elseif ($tool['slug'] === 'random-string-generator')
    <!-- Random String Generator -->
    <div class="workspace-split">
        <div class="pane-card" style="padding:14px;">
            <h3 style="margin-top:0; font-size:0.95rem; color:var(--text);">Random String Parameters</h3>
            <div style="margin-top:10px;">
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:4px;">
                    <label for="rand-length" style="font-size:0.82rem; font-weight:600; color:var(--text);">String Length:</label>
                    <span id="rand-length-val" style="font-weight:700; color:var(--brand); font-family:var(--font-mono);">32</span>
                </div>
                <input type="range" id="rand-length" min="4" max="256" value="32" oninput="document.getElementById('rand-length-val').textContent = this.value" style="width:100%;">
            </div>

            <div style="margin-top:10px;">
                <label for="rand-count" style="display:block; font-size:0.82rem; font-weight:600; color:var(--text); margin-bottom:4px;">Number of Strings:</label>
                <input type="number" id="rand-count" min="1" max="50" value="5" style="width:100%; height:34px; font-size:0.86rem; font-family:var(--font-mono);">
            </div>

            <div style="margin-top:10px; display:grid; grid-template-columns:1fr 1fr; gap:6px;">
                <label style="font-size:0.8rem; display:flex; align-items:center; gap:6px; cursor:pointer;">
                    <input type="checkbox" id="rand-upper" checked style="width:15px; height:15px;"> Uppercase (A-Z)
                </label>
                <label style="font-size:0.8rem; display:flex; align-items:center; gap:6px; cursor:pointer;">
                    <input type="checkbox" id="rand-lower" checked style="width:15px; height:15px;"> Lowercase (a-z)
                </label>
                <label style="font-size:0.8rem; display:flex; align-items:center; gap:6px; cursor:pointer;">
                    <input type="checkbox" id="rand-digits" checked style="width:15px; height:15px;"> Numbers (0-9)
                </label>
                <label style="font-size:0.8rem; display:flex; align-items:center; gap:6px; cursor:pointer;">
                    <input type="checkbox" id="rand-symbols" style="width:15px; height:15px;"> Symbols (!@#$)
                </label>
            </div>

            <div style="margin-top:14px;">
                <button type="button" class="btn btn-primary" style="width:100%;" onclick="generateRandomStrings()">
                    {{ $tool['cta_text'] ?? 'Generate Strings' }}
                </button>
            </div>
        </div>

        <div class="pane-card">
            <div class="pane-header">
                <span>Output (Web Crypto CSPRNG)</span>
                <div class="pane-actions">
                    <button type="button" class="btn btn-secondary btn-sm" onclick="copyOutput('rand-output')">Copy All</button>
                </div>
            </div>
            <textarea id="rand-output" class="editor-textarea" readonly placeholder="Generated cryptographically secure random strings will appear here..." style="background:#fafafa;"></textarea>
        </div>
    </div>

@elseif ($tool['slug'] === 'hash-generator')
    <!-- Multi-Algorithm Hash Generator -->
    <div>
        <div class="pane-card" style="margin-bottom:12px;">
            <div class="pane-header">
                <span>Input Plaintext</span>
                <div class="pane-actions">
                    <button type="button" class="btn btn-ghost btn-sm" onclick="document.getElementById('hash-text-input').value=''; computeAllHashes();">Clear</button>
                    <button type="button" class="btn btn-ghost btn-sm" onclick="document.getElementById('hash-text-input').value='WebToolsStation secure hashing'; computeAllHashes();">Sample</button>
                </div>
            </div>
            <textarea id="hash-text-input" class="editor-textarea" style="height:90px;" placeholder="Type or paste text to compute MD5, SHA-1, SHA-256, SHA-384, and SHA-512 hashes live..." oninput="computeAllHashes()"></textarea>
            <div style="padding:6px 12px; background:var(--surface-subtle); border-top:1px solid var(--border); font-size:0.75rem; color:var(--text-muted); display:flex; justify-content:space-between;">
                <span>Plaintext Input</span>
                <span>⚡ Live Hash Generation</span>
            </div>
        </div>

        <div class="pane-card" style="padding:14px; background:#ffffff;">
            <h3 style="margin:0 0 10px; font-size:0.95rem; color:var(--text);">Computed Message Digests</h3>
            <div style="display:flex; flex-direction:column; gap:8px;">
                @foreach (['MD5', 'SHA-1', 'SHA-256', 'SHA-384', 'SHA-512'] as $algo)
                    @php $algoKey = strtolower(str_replace('-', '', $algo)); @endphp
                    <div style="display:flex; flex-direction:column; gap:2px; padding:8px 12px; background:var(--surface-subtle); border:1px solid var(--border); border-radius:var(--radius-sm);">
                        <div style="display:flex; justify-content:space-between; align-items:center;">
                            <span style="font-weight:700; font-size:0.8rem; color:var(--brand-dark);">{{ $algo }}</span>
                            <button type="button" class="btn btn-ghost btn-sm" onclick="copyDigest('hash-val-{{ $algoKey }}')" style="height:24px; padding:0 6px; font-size:0.72rem;">Copy</button>
                        </div>
                        <div id="hash-val-{{ $algoKey }}" style="font-family:var(--font-mono); font-size:0.82rem; word-break:break-all; color:var(--text);">—</div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

@elseif ($tool['slug'] === 'hmac-generator')
    <!-- HMAC Generator -->
    <div class="workspace-split">
        <div class="pane-card" style="padding:14px;">
            <h3 style="margin-top:0; font-size:0.95rem; color:var(--text);">HMAC Configuration</h3>
            <div style="margin-top:8px;">
                <label for="hmac-msg" style="display:block; font-size:0.82rem; font-weight:600; color:var(--text); margin-bottom:3px;">Message Data:</label>
                <textarea id="hmac-msg" class="editor-textarea" style="height:90px;" placeholder="Message string to sign..."></textarea>
            </div>
            <div style="margin-top:10px;">
                <label for="hmac-key" style="display:block; font-size:0.82rem; font-weight:600; color:var(--text); margin-bottom:3px;">Secret Key:</label>
                <input type="text" id="hmac-key" placeholder="Enter private HMAC secret key..." style="width:100%; height:34px; font-size:0.86rem; font-family:var(--font-mono);">
            </div>
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:10px; margin-top:10px;">
                <div>
                    <label for="hmac-algo" style="display:block; font-size:0.82rem; font-weight:600; color:var(--text); margin-bottom:3px;">Algorithm:</label>
                    <select id="hmac-algo" style="width:100%; height:32px; font-size:0.84rem;">
                        <option value="SHA-256">SHA-256</option>
                        <option value="SHA-384">SHA-384</option>
                        <option value="SHA-512">SHA-512</option>
                    </select>
                </div>
                <div>
                    <label for="hmac-format" style="display:block; font-size:0.82rem; font-weight:600; color:var(--text); margin-bottom:3px;">Format:</label>
                    <select id="hmac-format" style="width:100%; height:32px; font-size:0.84rem;">
                        <option value="hex">Hexadecimal</option>
                        <option value="base64">Base64</option>
                    </select>
                </div>
            </div>
            <div style="margin-top:14px;">
                <button type="button" class="btn btn-primary" style="width:100%;" onclick="computeHmac()">{{ $tool['cta_text'] ?? 'Generate HMAC' }}</button>
            </div>
        </div>

        <div class="pane-card">
            <div class="pane-header">
                <span>HMAC Signature Result</span>
                <div class="pane-actions">
                    <button type="button" class="btn btn-secondary btn-sm" onclick="copyOutput('hmac-output')">Copy Signature</button>
                </div>
            </div>
            <textarea id="hmac-output" class="editor-textarea" readonly placeholder="Cryptographic HMAC signature will appear here..." style="background:#fafafa;"></textarea>
        </div>
    </div>

@elseif ($tool['slug'] === 'json-diff-checker')
    <!-- JSON Diff Checker -->
    <div>
        <div class="workspace-split">
            <div class="pane-card">
                <div class="pane-header">
                    <span>Original JSON (Left)</span>
                    <div class="pane-actions">
                        <button type="button" class="btn btn-ghost btn-sm" onclick="document.getElementById('diff-json-left').value=''">Clear</button>
                        <button type="button" class="btn btn-ghost btn-sm" onclick="loadJsonDiffSample()">Sample</button>
                    </div>
                </div>
                <textarea id="diff-json-left" class="editor-textarea" style="height:200px;" placeholder='{"id":1, "status":"pending", "count":5}' spellcheck="false"></textarea>
            </div>

            <div class="pane-card">
                <div class="pane-header">
                    <span>Modified JSON (Right)</span>
                    <div class="pane-actions">
                        <button type="button" class="btn btn-ghost btn-sm" onclick="document.getElementById('diff-json-right').value=''">Clear</button>
                    </div>
                </div>
                <textarea id="diff-json-right" class="editor-textarea" style="height:200px;" placeholder='{"id":1, "status":"completed", "count":7, "newField":"active"}' spellcheck="false"></textarea>
            </div>
        </div>

        <div class="workspace-toolbar" style="margin-top:10px; padding:8px 12px; background:var(--surface-subtle); border:1px solid var(--border); border-radius:var(--radius-md);">
            <div class="workspace-btn-group">
                <button type="button" class="btn btn-primary" onclick="runJsonDiff()">{{ $tool['cta_text'] ?? 'Compare JSON' }}</button>
            </div>
        </div>

        <!-- Diff Report Container -->
        <div id="json-diff-report" style="margin-top:12px; display:none;">
            <div class="pane-card" style="padding:14px;">
                <div id="json-diff-summary" style="font-weight:700; font-size:0.95rem; margin-bottom:10px;"></div>
                <div id="json-diff-results" style="font-family:var(--font-mono); font-size:0.84rem; max-height:350px; overflow-y:auto; line-height:1.5;"></div>
            </div>
        </div>
    </div>

@elseif ($tool['slug'] === 'query-string-parser')
    <!-- Query String Parser -->
    <div>
        <div class="pane-card" style="padding:14px; margin-bottom:12px;">
            <h3 style="margin-top:0; font-size:0.95rem; color:var(--text);">Enter URL or Query String</h3>
            <div style="display:flex; gap:8px; margin-top:8px;">
                <input type="text" id="query-string-input" placeholder="https://example.com/api?user=alex&role=admin&tags=dev&tags=sec&active=true" style="flex:1; height:36px; font-family:var(--font-mono); font-size:0.88rem;" oninput="parseQueryString()">
                <button type="button" class="btn btn-primary btn-sm" onclick="parseQueryString()">{{ $tool['cta_text'] ?? 'Parse' }}</button>
                <button type="button" class="btn btn-ghost btn-sm" onclick="loadQuerySample()">Sample</button>
            </div>
        </div>

        <div class="pane-card" style="padding:14px;">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:10px;">
                <h3 style="margin:0; font-size:0.95rem; color:var(--text);">Parsed Parameters Table</h3>
                <button type="button" class="btn btn-ghost btn-sm" onclick="copyQueryJson()">Copy as JSON</button>
            </div>
            <div id="query-results-table" style="overflow-x:auto;">
                <table style="width:100%; border-collapse:collapse; font-size:0.84rem; font-family:var(--font-mono);">
                    <thead>
                        <tr style="background:var(--surface-subtle); border-bottom:2px solid var(--border); text-align:left;">
                            <th style="padding:6px 10px;">Parameter Key</th>
                            <th style="padding:6px 10px;">Decoded Value</th>
                            <th style="padding:6px 10px;">Raw Value</th>
                        </tr>
                    </thead>
                    <tbody id="query-table-body">
                        <tr><td colspan="3" style="padding:16px; text-align:center; color:var(--text-muted);">Enter a query string above to parse automatically.</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@elseif ($tool['slug'] === 'cron-expression-helper')
    <!-- Cron Expression Helper -->
    <div>
        <div class="pane-card" style="padding:14px; margin-bottom:12px;">
            <h3 style="margin-top:0; font-size:0.95rem; color:var(--text);">Cron Schedule Expression</h3>
            <div style="display:flex; gap:8px; margin-top:8px; flex-wrap:wrap;">
                <input type="text" id="cron-input" value="0 9 * * 1-5" style="flex:1; min-width:200px; height:36px; font-family:var(--font-mono); font-size:1rem; font-weight:700; letter-spacing:0.04em;" oninput="evaluateCron()">
                <button type="button" class="btn btn-primary btn-sm" onclick="evaluateCron()">{{ $tool['cta_text'] ?? 'Evaluate Cron' }}</button>
            </div>

            <!-- Quick Presets -->
            <div style="display:flex; gap:6px; flex-wrap:wrap; margin-top:10px;">
                <span style="font-size:0.75rem; font-weight:600; color:var(--text-muted); align-self:center;">Presets:</span>
                <button type="button" class="btn btn-ghost btn-sm" onclick="setCron('*/15 * * * *')">Every 15m</button>
                <button type="button" class="btn btn-ghost btn-sm" onclick="setCron('0 * * * *')">Hourly</button>
                <button type="button" class="btn btn-ghost btn-sm" onclick="setCron('0 0 * * *')">Daily Midnight</button>
                <button type="button" class="btn btn-ghost btn-sm" onclick="setCron('0 9 * * 1-5')">Weekdays 9 AM</button>
                <button type="button" class="btn btn-ghost btn-sm" onclick="setCron('0 0 1 * *')">1st of Month</button>
            </div>
        </div>

        <!-- Explanation Card -->
        <div class="workspace-split">
            <div class="pane-card" style="padding:14px;">
                <span style="font-size:0.72rem; text-transform:uppercase; letter-spacing:0.06em; color:var(--brand); font-weight:700;">Human Description</span>
                <h4 id="cron-human-desc" style="margin:6px 0 0; font-size:1.05rem; color:var(--text); line-height:1.4;">
                    At 09:00 AM, Monday through Friday
                </h4>
                <div id="cron-fields-breakdown" style="display:grid; grid-template-columns:repeat(5, 1fr); gap:6px; margin-top:12px; text-align:center; font-family:var(--font-mono);">
                    <div style="background:var(--surface-subtle); padding:6px; border-radius:4px;">
                        <div style="font-size:0.65rem; color:var(--text-muted);">MIN</div>
                        <div id="cron-f-min" style="font-weight:700; font-size:0.85rem;">0</div>
                    </div>
                    <div style="background:var(--surface-subtle); padding:6px; border-radius:4px;">
                        <div style="font-size:0.65rem; color:var(--text-muted);">HOUR</div>
                        <div id="cron-f-hour" style="font-weight:700; font-size:0.85rem;">9</div>
                    </div>
                    <div style="background:var(--surface-subtle); padding:6px; border-radius:4px;">
                        <div style="font-size:0.65rem; color:var(--text-muted);">DOM</div>
                        <div id="cron-f-dom" style="font-weight:700; font-size:0.85rem;">*</div>
                    </div>
                    <div style="background:var(--surface-subtle); padding:6px; border-radius:4px;">
                        <div style="font-size:0.65rem; color:var(--text-muted);">MONTH</div>
                        <div id="cron-f-mon" style="font-weight:700; font-size:0.85rem;">*</div>
                    </div>
                    <div style="background:var(--surface-subtle); padding:6px; border-radius:4px;">
                        <div style="font-size:0.65rem; color:var(--text-muted);">DOW</div>
                        <div id="cron-f-dow" style="font-weight:700; font-size:0.85rem;">1-5</div>
                    </div>
                </div>
            </div>

            <div class="pane-card" style="padding:14px;">
                <span style="font-size:0.72rem; text-transform:uppercase; letter-spacing:0.06em; color:var(--brand); font-weight:700;">Next 5 Scheduled Runs (Local Time)</span>
                <ul id="cron-next-runs" style="margin:8px 0 0; padding-left:16px; font-family:var(--font-mono); font-size:0.82rem; color:var(--text); line-height:1.6;">
                </ul>
            </div>
        </div>
    </div>
@endif
