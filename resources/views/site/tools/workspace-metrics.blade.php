@if ($tool['slug'] === 'word-counter')
    <div>
        <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(130px, 1fr)); gap:12px; margin-bottom:16px;">
            <div class="pane-card" style="padding:14px; text-align:center;">
                <div style="font-size:0.78rem; font-weight:600; color:var(--text-muted); text-transform:uppercase;">Words</div>
                <div id="stat-words" style="font-size:1.8rem; font-weight:800; color:var(--brand); margin-top:4px;">0</div>
            </div>
            <div class="pane-card" style="padding:14px; text-align:center;">
                <div style="font-size:0.78rem; font-weight:600; color:var(--text-muted); text-transform:uppercase;">Characters</div>
                <div id="stat-chars" style="font-size:1.8rem; font-weight:800; color:var(--text); margin-top:4px;">0</div>
            </div>
            <div class="pane-card" style="padding:14px; text-align:center;">
                <div style="font-size:0.78rem; font-weight:600; color:var(--text-muted); text-transform:uppercase;">No Spaces</div>
                <div id="stat-nospaces" style="font-size:1.8rem; font-weight:800; color:var(--text); margin-top:4px;">0</div>
            </div>
            <div class="pane-card" style="padding:14px; text-align:center;">
                <div style="font-size:0.78rem; font-weight:600; color:var(--text-muted); text-transform:uppercase;">Sentences</div>
                <div id="stat-sentences" style="font-size:1.8rem; font-weight:800; color:var(--text); margin-top:4px;">0</div>
            </div>
            <div class="pane-card" style="padding:14px; text-align:center;">
                <div style="font-size:0.78rem; font-weight:600; color:var(--text-muted); text-transform:uppercase;">Lines</div>
                <div id="stat-lines" style="font-size:1.8rem; font-weight:800; color:var(--text); margin-top:4px;">0</div>
            </div>
            <div class="pane-card" style="padding:14px; text-align:center;">
                <div style="font-size:0.78rem; font-weight:600; color:var(--text-muted); text-transform:uppercase;">Read Time</div>
                <div id="stat-reading" style="font-size:1.4rem; font-weight:800; color:var(--text); margin-top:8px;">0m</div>
            </div>
        </div>

        <div class="pane-card">
            <div class="pane-header">
                <span>Text Editor (Live Metrics)</span>
                <div class="pane-actions">
                    <button type="button" class="btn btn-ghost btn-sm" onclick="document.getElementById('word-input').value = ''; countWords();">Clear</button>
                    <button type="button" class="btn btn-ghost btn-sm" onclick="loadSampleWordCount()">Sample</button>
                    <button type="button" class="btn btn-secondary btn-sm" onclick="copyOutput('word-input')">Copy Text</button>
                </div>
            </div>
            <textarea id="word-input" class="editor-textarea" style="height:320px;" placeholder="Start typing or paste text here to inspect live word, character, and sentence counts..." oninput="countWords()"></textarea>
            <!-- Hidden pre to maintain backward compatibility with any tests checking tool-output -->
            <pre id="tool-output" style="display:none;"></pre>
        </div>
    </div>

@elseif ($tool['slug'] === 'timestamp-converter')
    <div class="workspace-split">
        <div class="pane-card" style="padding:20px; gap:16px;">
            <div style="font-weight:700; font-size:0.92rem; color:var(--text); text-transform:uppercase; letter-spacing:0.04em; border-bottom:1px solid var(--border); padding-bottom:10px;">
                Timestamp Controls
            </div>

            <div>
                <label for="timestamp-input" style="display:block; font-size:0.85rem; font-weight:600; margin-bottom:6px;">Unix Epoch Timestamp (Seconds or Milliseconds):</label>
                <div style="display:flex; gap:8px;">
                    <input id="timestamp-input" type="text" placeholder="1710489600" style="flex:1; font-family:var(--font-mono);">
                    <button class="btn btn-primary" onclick="timestampToDate()">Convert to Date</button>
                </div>
            </div>

            <div style="display:flex; gap:8px;">
                <button type="button" class="btn btn-secondary btn-sm" onclick="setNowTimestamp()">Set to Current Time (Now)</button>
            </div>

            <div style="border-top:1px solid var(--border); padding-top:14px;">
                <label for="date-input" style="display:block; font-size:0.85rem; font-weight:600; margin-bottom:6px;">Select Date & Time (Local):</label>
                <div style="display:flex; gap:8px;">
                    <input id="date-input" type="datetime-local" style="flex:1;">
                    <button class="btn btn-secondary" onclick="dateToTimestamp()">Convert to Epoch</button>
                </div>
            </div>
        </div>

        <div class="pane-card">
            <div class="pane-header">
                <span>Converted Output</span>
                <div class="pane-actions">
                    <button class="btn btn-secondary btn-sm" onclick="copyOutput('tool-output')">Copy Result</button>
                </div>
            </div>
            <pre id="tool-output" class="output-pre" style="height:320px;" aria-label="Timestamp conversion output"></pre>
        </div>
    </div>

@elseif ($tool['slug'] === 'sha256-hash-generator')
    <div class="workspace-split">
        <div class="pane-card" style="padding:20px; gap:14px;">
            <div style="font-weight:700; font-size:0.92rem; color:var(--text); text-transform:uppercase; letter-spacing:0.04em; border-bottom:1px solid var(--border); padding-bottom:10px;">
                Input String
            </div>
            <textarea id="hash-input" class="editor-textarea" style="height:240px;" placeholder="Type or paste any text string to compute its deterministic SHA-256 digest..." oninput="generateHash()"></textarea>
            <div style="display:flex; gap:8px;">
                <button class="btn btn-primary" onclick="generateHash()">Generate SHA-256 Hash</button>
                <button class="btn btn-ghost" onclick="document.getElementById('hash-input').value = ''; generateHash();">Clear</button>
            </div>
        </div>

        <div class="pane-card">
            <div class="pane-header">
                <span>SHA-256 Digest (256-bit Hex)</span>
                <div class="pane-actions">
                    <button class="btn btn-secondary btn-sm" onclick="copyOutput('tool-output')">Copy Hash</button>
                </div>
            </div>
            <pre id="tool-output" class="output-pre" style="height:320px; font-weight:700; color:var(--brand-dark);" aria-label="SHA-256 hash output"></pre>
        </div>
    </div>
@endif