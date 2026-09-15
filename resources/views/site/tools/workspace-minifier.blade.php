<div class="workspace-split">
    <!-- Input Pane -->
    <div class="pane-card">
        <div class="pane-header">
            <span>Source Code Input</span>
            <div class="pane-actions">
                <button type="button" class="btn btn-ghost btn-sm" onclick="clearMinifierInput()" title="Clear input">Clear</button>
                <button type="button" class="btn btn-ghost btn-sm" onclick="loadMinifierSample()" title="Load sample code">Sample</button>
                <button type="button" class="btn btn-ghost btn-sm" onclick="pasteMinifierClipboard()" title="Paste from clipboard">Paste</button>
            </div>
        </div>
        <textarea id="minifier-input" class="editor-textarea" placeholder="Paste unminified {{ str_replace(' Minifier', '', $tool['title']) }} here to compress..." spellcheck="false"></textarea>
        <div style="padding:8px 12px; background:var(--surface-subtle); border-top:1px solid var(--border); font-size:0.78rem; color:var(--text-muted); display:flex; justify-content:space-between;">
            <span id="input-stats">0 characters | 0 bytes</span>
            <span>UTF-8 Client-Side</span>
        </div>
    </div>

    <!-- Output Pane -->
    <div class="pane-card">
        <div class="pane-header">
            <span>Minified Output</span>
            <div class="pane-actions">
                <button type="button" class="btn btn-secondary btn-sm" onclick="copyOutput('minifier-output')">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg>
                    Copy
                </button>
                <button type="button" class="btn btn-ghost btn-sm" onclick="downloadMinifiedOutput()" title="Download minified file">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                    Download
                </button>
            </div>
        </div>
        <textarea id="minifier-output" class="editor-textarea" readonly placeholder="Minified code will appear here..." style="background:#fafafa;"></textarea>
        <div style="padding:8px 12px; background:var(--surface-subtle); border-top:1px solid var(--border); font-size:0.78rem; color:var(--text-muted); display:flex; justify-content:space-between;">
            <span id="output-stats">0 characters | 0 bytes</span>
            <span id="compression-stats" style="font-weight:600; color:var(--success);">0% reduction</span>
        </div>
    </div>
</div>

<!-- Compression Metrics Card -->
<div id="metrics-card" style="display:grid; grid-template-columns:repeat(auto-fit, minmax(140px, 1fr)); gap:12px; margin-top:16px; padding:14px; background:var(--surface-subtle); border:1px solid var(--border); border-radius:var(--radius-md);">
    <div style="text-align:center;">
        <div style="font-size:0.75rem; text-transform:uppercase; color:var(--text-muted); font-weight:600;">Original Size</div>
        <div id="stat-orig-size" style="font-size:1.15rem; font-weight:700; color:var(--text); margin-top:2px;">0 B</div>
    </div>
    <div style="text-align:center;">
        <div style="font-size:0.75rem; text-transform:uppercase; color:var(--text-muted); font-weight:600;">Minified Size</div>
        <div id="stat-mini-size" style="font-size:1.15rem; font-weight:700; color:var(--text); margin-top:2px;">0 B</div>
    </div>
    <div style="text-align:center;">
        <div style="font-size:0.75rem; text-transform:uppercase; color:var(--text-muted); font-weight:600;">Bytes Saved</div>
        <div id="stat-saved-bytes" style="font-size:1.15rem; font-weight:700; color:var(--success); margin-top:2px;">0 B</div>
    </div>
    <div style="text-align:center;">
        <div style="font-size:0.75rem; text-transform:uppercase; color:var(--text-muted); font-weight:600;">Reduction</div>
        <div id="stat-reduction-pct" style="font-size:1.15rem; font-weight:700; color:var(--brand-dark); margin-top:2px;">0.0%</div>
    </div>
</div>

<!-- Error Notice -->
<div id="minifier-error" style="display:none; margin-top:12px; padding:12px 16px; background:var(--danger-bg); border:1px solid var(--danger); border-radius:var(--radius-sm); color:var(--danger); font-size:0.9rem;">
    <strong>Error:</strong> <span id="minifier-error-msg"></span>
</div>

<!-- Bottom Action Toolbar -->
<div class="workspace-toolbar" style="margin-top:16px;">
    <div class="workspace-btn-group">
        <button type="button" class="btn btn-primary" onclick="runMinifier()">
            Minify {{ str_replace(' Minifier', '', $tool['title']) }}
        </button>
        <button type="button" class="btn btn-secondary" onclick="clearMinifierInput()">Clear</button>
    </div>
    <div class="workspace-hint">
        <span>Keyboard: Press <kbd>Ctrl/Cmd+Enter</kbd> to minify</span>
    </div>
</div>
