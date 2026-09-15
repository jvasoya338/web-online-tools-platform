@if ($tool['slug'] === 'ulid-generator')
    <!-- ULID Generator -->
    <div class="workspace-split">
        <div class="pane-card" style="padding:20px;">
            <h3 style="margin-top:0; font-size:1.1rem; color:var(--text);">ULID Generation Settings</h3>
            <div style="margin-top:16px;">
                <label for="ulid-quantity" style="display:block; font-size:0.88rem; font-weight:600; color:var(--text); margin-bottom:6px;">Quantity:</label>
                <input type="number" id="ulid-quantity" min="1" max="50" value="5" style="width:100%; height:40px; font-family:var(--font-mono);">
                <span style="font-size:0.78rem; color:var(--text-muted); margin-top:4px; display:block;">Generate between 1 and 50 sortable ULIDs</span>
            </div>

            <div style="margin-top:20px;">
                <button type="button" class="btn btn-primary btn-lg" style="width:100%;" onclick="generateUlids()">
                    Generate ULID(s)
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
        <div class="pane-card" style="padding:20px;">
            <h3 style="margin-top:0; font-size:1.1rem; color:var(--text);">Random String Parameters</h3>
            <div style="margin-top:14px;">
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:6px;">
                    <label for="rand-length" style="font-size:0.88rem; font-weight:600; color:var(--text);">String Length:</label>
                    <span id="rand-length-val" style="font-weight:700; color:var(--brand); font-family:var(--font-mono);">32</span>
                </div>
                <input type="range" id="rand-length" min="4" max="256" value="32" oninput="document.getElementById('rand-length-val').textContent = this.value" style="width:100%;">
            </div>

            <div style="margin-top:16px;">
                <label for="rand-count" style="display:block; font-size:0.88rem; font-weight:600; color:var(--text); margin-bottom:6px;">Number of Strings:</label>
                <input type="number" id="rand-count" min="1" max="50" value="5" style="width:100%; height:40px; font-family:var(--font-mono);">
            </div>

            <div style="margin-top:16px; display:flex; flex-direction:column; gap:8px;">
                <label style="font-size:0.88rem; display:flex; align-items:center; gap:8px; cursor:pointer;">
                    <input type="checkbox" id="rand-upper" checked style="width:16px; height:16px;"> Uppercase Letters (A-Z)
                </label>
                <label style="font-size:0.88rem; display:flex; align-items:center; gap:8px; cursor:pointer;">
                    <input type="checkbox" id="rand-lower" checked style="width:16px; height:16px;"> Lowercase Letters (a-z)
                </label>
                <label style="font-size:0.88rem; display:flex; align-items:center; gap:8px; cursor:pointer;">
                    <input type="checkbox" id="rand-digits" checked style="width:16px; height:16px;"> Numbers (0-9)
                </label>
                <label style="font-size:0.88rem; display:flex; align-items:center; gap:8px; cursor:pointer;">
                    <input type="checkbox" id="rand-symbols" style="width:16px; height:16px;"> Symbols (!@#$%^&*)
                </label>
                <label style="font-size:0.88rem; display:flex; align-items:center; gap:8px; cursor:pointer;">
                    <input type="checkbox" id="rand-no-ambiguous" style="width:16px; height:16px;"> Exclude Ambiguous (0, O, l, 1, I)
                </label>
            </div>

            <div style="margin-top:20px;">
                <button type="button" class="btn btn-primary btn-lg" style="width:100%;" onclick="generateRandomStrings()">
                    Generate Random Strings
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
        <div class="pane-card" style="margin-bottom:20px;">
            <div class="pane-header">
                <span>Input Plaintext</span>
                <div class="pane-actions">
                    <button type="button" class="btn btn-ghost btn-sm" onclick="document.getElementById('hash-text-input').value=''; computeAllHashes();">Clear</button>
                    <button type="button" class="btn btn-ghost btn-sm" onclick="document.getElementById('hash-text-input').value='WebToolsStation secure hashing'; computeAllHashes();">Sample</button>
                </div>
            </div>
            <textarea id="hash-text-input" class="editor-textarea" style="height:120px;" placeholder="Type or paste text to compute MD5, SHA-1, SHA-256, SHA-384, and SHA-512 hashes..." oninput="computeAllHashes()"></textarea>
        </div>

        <div class="pane-card" style="padding:16px; background:#ffffff;">
            <h3 style="margin:0 0 14px; font-size:1.05rem; color:var(--text);">Computed Message Digests</h3>
            <div style="display:flex; flex-direction:column; gap:12px;">
                @foreach (['MD5', 'SHA-1', 'SHA-256', 'SHA-384', 'SHA-512'] as $algo)
                    @php $algoKey = strtolower(str_replace('-', '', $algo)); @endphp
                    <div style="display:flex; flex-direction:column; gap:4px; padding:10px 14px; background:var(--surface-subtle); border:1px solid var(--border); border-radius:var(--radius-sm);">
                        <div style="display:flex; justify-content:space-between; align-items:center;">
                            <span style="font-weight:700; font-size:0.85rem; color:var(--brand-dark);">{{ $algo }}</span>
                            <button type="button" class="btn btn-ghost btn-sm" onclick="copyDigest('hash-val-{{ $algoKey }}')" style="height:26px; padding:0 8px; font-size:0.75rem;">Copy</button>
                        </div>
                        <div id="hash-val-{{ $algoKey }}" style="font-family:var(--font-mono); font-size:0.86rem; word-break:break-all; color:var(--text);">—</div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

@elseif ($tool['slug'] === 'hmac-generator')
    <!-- HMAC Generator -->
    <div class="workspace-split">
        <div class="pane-card" style="padding:20px;">
            <h3 style="margin-top:0; font-size:1.1rem; color:var(--text);">HMAC Configuration</h3>
            <div style="margin-top:12px;">
                <label for="hmac-msg" style="display:block; font-size:0.88rem; font-weight:600; color:var(--text); margin-bottom:4px;">Message Data:</label>
                <textarea id="hmac-msg" class="editor-textarea" style="height:120px;" placeholder="Message string to sign..."></textarea>
            </div>
            <div style="margin-top:14px;">
                <label for="hmac-key" style="display:block; font-size:0.88rem; font-weight:600; color:var(--text); margin-bottom:4px;">Secret Key:</label>
                <input type="text" id="hmac-key" placeholder="Enter private HMAC secret key..." style="width:100%; height:40px; font-family:var(--font-mono);">
            </div>
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px; margin-top:14px;">
                <div>
                    <label for="hmac-algo" style="display:block; font-size:0.88rem; font-weight:600; color:var(--text); margin-bottom:4px;">Algorithm:</label>
                    <select id="hmac-algo" style="width:100%; height:38px;">
                        <option value="SHA-256">SHA-256</option>
                        <option value="SHA-384">SHA-384</option>
                        <option value="SHA-512">SHA-512</option>
                    </select>
                </div>
                <div>
                    <label for="hmac-format" style="display:block; font-size:0.88rem; font-weight:600; color:var(--text); margin-bottom:4px;">Output Format:</label>
                    <select id="hmac-format" style="width:100%; height:38px;">
                        <option value="hex">Hexadecimal</option>
                        <option value="base64">Base64</option>
                    </select>
                </div>
            </div>
            <div style="margin-top:20px;">
                <button type="button" class="btn btn-primary btn-lg" style="width:100%;" onclick="computeHmac()">Generate HMAC</button>
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
                <textarea id="diff-json-left" class="editor-textarea" style="height:260px;" placeholder='{"id":1, "status":"pending", "count":5}' spellcheck="false"></textarea>
            </div>

            <div class="pane-card">
                <div class="pane-header">
                    <span>Modified JSON (Right)</span>
                    <div class="pane-actions">
                        <button type="button" class="btn btn-ghost btn-sm" onclick="document.getElementById('diff-json-right').value=''">Clear</button>
                    </div>
                </div>
                <textarea id="diff-json-right" class="editor-textarea" style="height:260px;" placeholder='{"id":1, "status":"completed", "count":7, "newField":"active"}' spellcheck="false"></textarea>
            </div>
        </div>

        <div class="workspace-toolbar" style="margin-top:14px;">
            <button type="button" class="btn btn-primary" onclick="runJsonDiff()">Compare JSON Payloads</button>
        </div>

        <!-- Diff Report Container -->
        <div id="json-diff-report" style="margin-top:18px; display:none;">
            <div class="pane-card" style="padding:16px;">
                <div id="json-diff-summary" style="font-weight:700; font-size:1rem; margin-bottom:12px;"></div>
                <div id="json-diff-results" style="font-family:var(--font-mono); font-size:0.88rem; max-height:400px; overflow-y:auto; line-height:1.6;"></div>
            </div>
        </div>
    </div>

@elseif ($tool['slug'] === 'query-string-parser')
    <!-- Query String Parser -->
    <div>
        <div class="pane-card" style="padding:20px; margin-bottom:16px;">
            <h3 style="margin-top:0; font-size:1.1rem; color:var(--text);">Enter URL or Query String</h3>
            <div style="display:flex; gap:10px; margin-top:12px;">
                <input type="text" id="query-string-input" placeholder="https://example.com/api?user=alex&role=admin&tags=dev&tags=sec&active=true" style="flex:1; height:44px; font-family:var(--font-mono); font-size:0.92rem;">
                <button type="button" class="btn btn-primary" onclick="parseQueryString()">Parse</button>
                <button type="button" class="btn btn-secondary" onclick="loadQuerySample()">Sample</button>
            </div>
        </div>

        <div class="pane-card" style="padding:16px;">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px;">
                <h3 style="margin:0; font-size:1.05rem; color:var(--text);">Parsed Parameters Table</h3>
                <button type="button" class="btn btn-ghost btn-sm" onclick="copyQueryJson()">Copy as JSON</button>
            </div>
            <div id="query-results-table" style="overflow-x:auto;">
                <table style="width:100%; border-collapse:collapse; font-size:0.88rem; font-family:var(--font-mono);">
                    <thead>
                        <tr style="background:var(--surface-subtle); border-bottom:2px solid var(--border); text-align:left;">
                            <th style="padding:8px 12px;">Parameter Key</th>
                            <th style="padding:8px 12px;">Decoded Value</th>
                            <th style="padding:8px 12px;">Raw Value</th>
                        </tr>
                    </thead>
                    <tbody id="query-table-body">
                        <tr><td colspan="3" style="padding:20px; text-align:center; color:var(--text-muted);">Enter a query string above and click "Parse".</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@elseif ($tool['slug'] === 'cron-expression-helper')
    <!-- Cron Expression Helper -->
    <div>
        <div class="pane-card" style="padding:20px; margin-bottom:16px;">
            <h3 style="margin-top:0; font-size:1.1rem; color:var(--text);">Cron Schedule Expression</h3>
            <div style="display:flex; gap:10px; margin-top:12px; flex-wrap:wrap;">
                <input type="text" id="cron-input" value="0 9 * * 1-5" style="flex:1; min-width:220px; height:44px; font-family:var(--font-mono); font-size:1.1rem; font-weight:700; letter-spacing:0.05em;" oninput="evaluateCron()">
                <button type="button" class="btn btn-primary" onclick="evaluateCron()">Evaluate Schedule</button>
            </div>

            <!-- Quick Presets -->
            <div style="display:flex; gap:8px; flex-wrap:wrap; margin-top:14px;">
                <span style="font-size:0.8rem; font-weight:600; color:var(--text-muted); align-self:center;">Presets:</span>
                <button type="button" class="btn btn-ghost btn-sm" onclick="setCron('*/15 * * * *')">Every 15 mins</button>
                <button type="button" class="btn btn-ghost btn-sm" onclick="setCron('0 * * * *')">Every hour</button>
                <button type="button" class="btn btn-ghost btn-sm" onclick="setCron('0 0 * * *')">Daily at midnight</button>
                <button type="button" class="btn btn-ghost btn-sm" onclick="setCron('0 9 * * 1-5')">Weekdays at 9 AM</button>
                <button type="button" class="btn btn-ghost btn-sm" onclick="setCron('0 0 1 * *')">1st of month</button>
            </div>
        </div>

        <!-- Explanation Card -->
        <div class="workspace-split">
            <div class="pane-card" style="padding:18px;">
                <span style="font-size:0.75rem; text-transform:uppercase; letter-spacing:0.06em; color:var(--brand); font-weight:700;">Human Description</span>
                <h4 id="cron-human-desc" style="margin:8px 0 0; font-size:1.15rem; color:var(--text); line-height:1.4;">
                    At 09:00 AM, Monday through Friday
                </h4>
                <div id="cron-fields-breakdown" style="display:grid; grid-template-columns:repeat(5, 1fr); gap:8px; margin-top:16px; text-align:center; font-family:var(--font-mono);">
                    <div style="background:var(--surface-subtle); padding:8px; border-radius:6px;">
                        <div style="font-size:0.7rem; color:var(--text-muted);">MIN</div>
                        <div id="cron-f-min" style="font-weight:700;">0</div>
                    </div>
                    <div style="background:var(--surface-subtle); padding:8px; border-radius:6px;">
                        <div style="font-size:0.7rem; color:var(--text-muted);">HOUR</div>
                        <div id="cron-f-hour" style="font-weight:700;">9</div>
                    </div>
                    <div style="background:var(--surface-subtle); padding:8px; border-radius:6px;">
                        <div style="font-size:0.7rem; color:var(--text-muted);">DOM</div>
                        <div id="cron-f-dom" style="font-weight:700;">*</div>
                    </div>
                    <div style="background:var(--surface-subtle); padding:8px; border-radius:6px;">
                        <div style="font-size:0.7rem; color:var(--text-muted);">MONTH</div>
                        <div id="cron-f-mon" style="font-weight:700;">*</div>
                    </div>
                    <div style="background:var(--surface-subtle); padding:8px; border-radius:6px;">
                        <div style="font-size:0.7rem; color:var(--text-muted);">DOW</div>
                        <div id="cron-f-dow" style="font-weight:700;">1-5</div>
                    </div>
                </div>
            </div>

            <div class="pane-card" style="padding:18px;">
                <span style="font-size:0.75rem; text-transform:uppercase; letter-spacing:0.06em; color:var(--brand); font-weight:700;">Next 5 Scheduled Runs (Local Time)</span>
                <ul id="cron-next-runs" style="margin:12px 0 0; padding-left:18px; font-family:var(--font-mono); font-size:0.88rem; color:var(--text); line-height:1.7;">
                    <!-- Populated dynamically -->
                </ul>
            </div>
        </div>
    </div>
@endif
