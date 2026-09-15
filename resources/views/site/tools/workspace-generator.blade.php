<div class="workspace-split">
    <!-- Left: Controls Panel -->
    <div class="pane-card" style="padding:20px; gap:16px;">
        <div style="font-weight:700; font-size:0.92rem; color:var(--text); text-transform:uppercase; letter-spacing:0.04em; border-bottom:1px solid var(--border); padding-bottom:10px;">
            Generator Settings
        </div>

        @if ($tool['slug'] === 'password-generator')
            <div>
                <label for="password-length" style="display:flex; justify-content:space-between; font-size:0.88rem; font-weight:600; margin-bottom:8px;">
                    <span>Password Length:</span>
                    <span id="length-val" style="font-family:var(--font-mono); color:var(--brand); font-weight:700;">16</span>
                </label>
                <input id="password-length" type="range" min="6" max="64" value="16" style="width:100%; cursor:pointer;" oninput="document.getElementById('length-val').textContent = this.value; generatePassword();">
            </div>

            <div>
                <label for="password-symbols" style="display:block; font-size:0.88rem; font-weight:600; margin-bottom:6px;">Character Sets & Complexity:</label>
                <div style="display:flex; flex-direction:column; gap:8px; margin-top:8px;">
                    <label style="font-size:0.88rem; display:flex; align-items:center; gap:8px; cursor:pointer;">
                        <input type="checkbox" id="pwd-upper" checked onchange="generatePassword()" style="width:16px; height:16px;"> Uppercase (A-Z)
                    </label>
                    <label style="font-size:0.88rem; display:flex; align-items:center; gap:8px; cursor:pointer;">
                        <input type="checkbox" id="pwd-lower" checked onchange="generatePassword()" style="width:16px; height:16px;"> Lowercase (a-z)
                    </label>
                    <label style="font-size:0.88rem; display:flex; align-items:center; gap:8px; cursor:pointer;">
                        <input type="checkbox" id="pwd-numbers" checked onchange="generatePassword()" style="width:16px; height:16px;"> Numbers (0-9)
                    </label>
                    <label style="font-size:0.88rem; display:flex; align-items:center; gap:8px; cursor:pointer;">
                        <input type="checkbox" id="pwd-symbols" checked onchange="generatePassword()" style="width:16px; height:16px;"> Symbols (!@#$%^&*)
                    </label>
                    <label style="font-size:0.88rem; display:flex; align-items:center; gap:8px; cursor:pointer;">
                        <input type="checkbox" id="pwd-no-ambiguous" onchange="generatePassword()" style="width:16px; height:16px;"> Exclude Ambiguous Characters (0, O, l, 1, I)
                    </label>
                </div>
            </div>

            <button class="btn btn-primary btn-lg" style="margin-top:8px;" onclick="generatePassword()">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21.5 2v6h-6M21.34 15.57a10 10 0 1 1-.57-8.38l5.67-5.67"/></svg>
                Generate New Password
            </button>

        @elseif ($tool['slug'] === 'uuid-generator')
            <div>
                <label for="uuid-count" style="display:block; font-size:0.88rem; font-weight:600; margin-bottom:6px;">Number of UUIDs to generate (1 - 20):</label>
                <input id="uuid-count" type="number" min="1" max="20" value="5" style="width:100%; height:40px; font-size:1rem;">
            </div>
            <div style="font-size:0.82rem; color:var(--text-muted);">
                Generated using cryptographic randomness (<code style="font-family:var(--font-mono); color:var(--brand-dark);">crypto.randomUUID()</code>) conforming to RFC 4122 v4 specifications.
            </div>
            <button class="btn btn-primary btn-lg" style="margin-top:8px;" onclick="generateUuidList()">Generate UUID v4 List</button>

        @elseif ($tool['slug'] === 'lorem-ipsum-generator')
            <div>
                <label for="lorem-count" style="display:block; font-size:0.88rem; font-weight:600; margin-bottom:6px;">Number of Paragraphs (1 - 12):</label>
                <input id="lorem-count" type="number" min="1" max="12" value="3" style="width:100%; height:40px; font-size:1rem;">
            </div>
            <div style="font-size:0.82rem; color:var(--text-muted);">
                Standard pseudo-Latin Cicero filler text with natural paragraph structures and punctuation.
            </div>
            <button class="btn btn-primary btn-lg" style="margin-top:8px;" onclick="generateLoremIpsum()">Generate Paragraphs</button>

        @elseif ($tool['slug'] === 'slug-generator')
            <div>
                <label for="slug-input" style="display:block; font-size:0.88rem; font-weight:600; margin-bottom:6px;">Input Title or String:</label>
                <textarea id="slug-input" style="width:100%; height:120px; font-size:0.95rem;" placeholder="e.g. 10 Best Developer Tools for Web Performance in 2026!" oninput="generateSlug()"></textarea>
            </div>
            <div style="font-size:0.82rem; color:var(--text-muted);">
                Automatically normalizes Unicode diacritics, converts to lowercase, and replaces spaces and symbols with clean hyphens.
            </div>
            <button class="btn btn-primary btn-lg" onclick="generateSlug()">Generate SEO Slug</button>
        @endif
    </div>

    <!-- Right: Result Card -->
    <div class="pane-card">
        <div class="pane-header">
            <span>Generated Result</span>
            <div class="pane-actions">
                <button type="button" class="btn btn-secondary btn-sm" onclick="copyOutput('tool-output')">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg>
                    Copy Result
                </button>
            </div>
        </div>

        @if ($tool['slug'] === 'password-generator')
            <div style="padding:14px 16px; background:var(--surface-subtle); border-bottom:1px solid var(--border); display:flex; align-items:center; justify-content:space-between;">
                <span style="font-size:0.82rem; font-weight:600; color:var(--text-muted);">Security Strength:</span>
                <span id="pw-strength-badge" class="privacy-badge">Strong (Cryptographically Random)</span>
            </div>
        @endif

        <pre id="tool-output" class="output-pre" style="flex:1; min-height:280px;" aria-label="Generated output"></pre>
    </div>
</div>