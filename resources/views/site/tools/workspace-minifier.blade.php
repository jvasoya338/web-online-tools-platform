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
        <textarea id="minifier-input" class="editor-textarea" placeholder="Paste uncompressed code here to minify automatically..." spellcheck="false"></textarea>
        <div style="padding:6px 12px; background:var(--surface-subtle); border-top:1px solid var(--border); font-size:0.75rem; color:var(--text-muted); display:flex; justify-content:space-between;">
            <span id="input-stats">0 characters | 0 bytes</span>
            <span>⚡ Live Auto-Minify</span>
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
        <textarea id="minifier-output" class="editor-textarea" readonly placeholder="Minified, compressed code will appear here..." style="background:#fafafa;"></textarea>
        <div style="padding:6px 12px; background:var(--surface-subtle); border-top:1px solid var(--border); font-size:0.75rem; color:var(--text-muted); display:flex; justify-content:space-between;">
            <span id="output-stats">0 characters | 0 bytes</span>
            <span id="compression-stats" style="font-weight:600; color:var(--success);">0% reduction</span>
        </div>
    </div>
</div>

<!-- Compact Compression Metrics Card & Action Toolbar -->
<div class="workspace-toolbar" style="margin-top:12px; padding:10px 14px; background:var(--surface-subtle); border:1px solid var(--border); border-radius:var(--radius-md);">
    <div id="metrics-card" style="display:flex; align-items:center; gap:16px; flex-wrap:wrap;">
        <div style="font-size:0.8rem; color:var(--text-muted);">
            Original: <strong id="stat-orig-size" style="color:var(--text);">0 B</strong>
        </div>
        <div style="font-size:0.8rem; color:var(--text-muted);">
            Minified: <strong id="stat-mini-size" style="color:var(--text);">0 B</strong>
        </div>
        <div style="font-size:0.8rem; color:var(--success);">
            Saved: <strong id="stat-saved-bytes">0 B</strong> (<span id="stat-reduction-pct">0.0%</span>)
        </div>
    </div>

    <div class="workspace-btn-group">
        <button type="button" class="btn btn-primary" onclick="runMinifier()">
            {{ $tool['cta_text'] ?? 'Minify Code' }}
        </button>
        <button type="button" class="btn btn-ghost btn-sm" onclick="clearMinifierInput()">Clear</button>
        <span style="font-size:0.75rem; color:var(--text-muted); margin-left:4px;">Ctrl+Enter</span>
    </div>
</div>

<!-- Error Notice -->
<div id="minifier-error" style="display:none; margin-top:10px; padding:10px 14px; background:var(--danger-bg); border:1px solid var(--danger); border-radius:var(--radius-sm); color:var(--danger); font-size:0.88rem;">
    <strong>Error:</strong> <span id="minifier-error-msg"></span>
</div>
