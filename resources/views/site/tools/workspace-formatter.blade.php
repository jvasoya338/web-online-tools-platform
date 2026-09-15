<div class="workspace-split">
    <!-- Input Pane -->
    <div class="pane-card">
        <div class="pane-header">
            <span>Source Code Input</span>
            <div class="pane-actions">
                <button type="button" class="btn btn-ghost btn-sm" onclick="clearFormatterInput()" title="Clear input">Clear</button>
                <button type="button" class="btn btn-ghost btn-sm" onclick="loadFormatterSample()" title="Load sample code">Sample</button>
                <button type="button" class="btn btn-ghost btn-sm" onclick="pasteFormatterClipboard()" title="Paste from clipboard">Paste</button>
            </div>
        </div>
        <textarea id="formatter-input" class="editor-textarea" placeholder="Paste unformatted or minified {{ str_replace(' Formatter', '', $tool['title']) }} here to beautify..." spellcheck="false"></textarea>
        <div style="padding:8px 12px; background:var(--surface-subtle); border-top:1px solid var(--border); font-size:0.78rem; color:var(--text-muted); display:flex; justify-content:space-between;">
            <span id="formatter-input-stats">0 lines | 0 characters</span>
            <span>UTF-8 Client-Side</span>
        </div>
    </div>

    <!-- Output Pane -->
    <div class="pane-card">
        <div class="pane-header">
            <span>Formatted Output</span>
            <div class="pane-actions">
                <button type="button" class="btn btn-secondary btn-sm" onclick="copyOutput('formatter-output')">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg>
                    Copy
                </button>
                <button type="button" class="btn btn-ghost btn-sm" onclick="downloadFormattedOutput()" title="Download formatted file">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                    Download
                </button>
            </div>
        </div>
        <textarea id="formatter-output" class="editor-textarea" readonly placeholder="Beautified, indented code will appear here..." style="background:#fafafa;"></textarea>
        <div style="padding:8px 12px; background:var(--surface-subtle); border-top:1px solid var(--border); font-size:0.78rem; color:var(--text-muted); display:flex; justify-content:space-between;">
            <span id="formatter-output-stats">0 lines | 0 characters</span>
            <span style="color:var(--brand-dark); font-weight:600;">Syntax Formatted</span>
        </div>
    </div>
</div>

<!-- Formatting Configuration Controls -->
<div style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:12px; margin-top:16px; padding:12px 16px; background:var(--surface-subtle); border:1px solid var(--border); border-radius:var(--radius-md);">
    <div style="display:flex; align-items:center; gap:10px;">
        <label for="indent-size" style="font-size:0.88rem; font-weight:600; color:var(--text);">Indentation:</label>
        <select id="indent-size" style="height:36px; padding:0 10px; font-weight:600; border-radius:var(--radius-sm); border:1px solid var(--border); background:#ffffff;">
            <option value="2">2 Spaces</option>
            <option value="4" selected>4 Spaces</option>
            <option value="tab">1 Tab</option>
        </select>
    </div>

    @if ($tool['slug'] === 'sql-formatter')
        <div style="display:flex; align-items:center; gap:10px;">
            <label style="font-size:0.88rem; font-weight:600; color:var(--text); display:flex; align-items:center; gap:6px; cursor:pointer;">
                <input type="checkbox" id="sql-uppercase-kw" checked style="width:16px; height:16px;">
                Uppercase SQL Keywords
            </label>
        </div>
    @endif
</div>

<!-- Error Notice -->
<div id="formatter-error" style="display:none; margin-top:12px; padding:12px 16px; background:var(--danger-bg); border:1px solid var(--danger); border-radius:var(--radius-sm); color:var(--danger); font-size:0.9rem;">
    <strong>Syntax Issue:</strong> <span id="formatter-error-msg"></span>
</div>

<!-- Bottom Action Toolbar -->
<div class="workspace-toolbar" style="margin-top:16px;">
    <div class="workspace-btn-group">
        <button type="button" class="btn btn-primary" onclick="runFormatter()">
            Format {{ str_replace(' Formatter', '', $tool['title']) }}
        </button>
        <button type="button" class="btn btn-secondary" onclick="clearFormatterInput()">Clear</button>
    </div>
    <div class="workspace-hint">
        <span>Keyboard: Press <kbd>Ctrl/Cmd+Enter</kbd> to format</span>
    </div>
</div>
