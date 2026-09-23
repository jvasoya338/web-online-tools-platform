<div class="workspace-split">
    <!-- Input Pane -->
    <div class="pane-card">
        <div class="pane-header">
            <span>{{ str_replace(' Validator & Lint', '', str_replace(' Validator', '', $tool['title'])) }} Input</span>
            <div class="pane-actions">
                <button type="button" class="btn btn-ghost btn-sm" onclick="clearValidatorInput()" title="Clear input">Clear</button>
                <button type="button" class="btn btn-ghost btn-sm" onclick="loadValidatorSample()" title="Load sample">Sample</button>
                <button type="button" class="btn btn-ghost btn-sm" onclick="pasteValidatorClipboard()" title="Paste from clipboard">Paste</button>
            </div>
        </div>
        <textarea id="validator-input" class="editor-textarea" placeholder="Paste data here to validate syntax automatically..." spellcheck="false"></textarea>
        <div style="padding:6px 12px; background:var(--surface-subtle); border-top:1px solid var(--border); font-size:0.75rem; color:var(--text-muted); display:flex; justify-content:space-between;">
            <span>Input Ready</span>
            <span>⚡ Live Auto-Validation</span>
        </div>
    </div>

    <!-- Output / Status Pane -->
    <div class="pane-card">
        <div class="pane-header">
            <span>Validation Diagnostic</span>
            <div class="pane-actions">
                <button type="button" class="btn btn-secondary btn-sm" onclick="copyOutput('validator-output')">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg>
                    Copy
                </button>
            </div>
        </div>

        <!-- Validation Status Card -->
        <div id="validator-status-box" style="padding:10px 14px; border-bottom:1px solid var(--border); background:var(--surface-subtle);">
            <div id="validator-initial" style="color:var(--text-muted); font-size:0.86rem; display:flex; align-items:center; gap:8px;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
                Type or paste data to validate structure in real time.
            </div>

            <div id="validator-success" style="display:none; padding:8px 12px; background:var(--success-bg); border:1px solid rgba(22, 163, 74, 0.3); border-radius:var(--radius-sm); color:var(--success);">
                <div style="font-weight:700; font-size:0.92rem; display:flex; align-items:center; gap:6px;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                    Valid Syntax!
                </div>
                <div style="font-size:0.82rem; margin-top:2px; color:var(--text);">Conforms to standard specifications with 0 syntax errors.</div>
            </div>

            <div id="validator-failure" style="display:none; padding:8px 12px; background:var(--danger-bg); border:1px solid rgba(220, 38, 38, 0.3); border-radius:var(--radius-sm); color:var(--danger);">
                <div style="font-weight:700; font-size:0.92rem; display:flex; align-items:center; gap:6px;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
                    Syntax Error Detected
                </div>
                <div id="validator-error-details" style="font-size:0.84rem; font-weight:600; margin-top:4px; font-family:var(--font-mono); color:#991b1b; white-space:pre-wrap;"></div>
            </div>
        </div>

        <textarea id="validator-output" class="editor-textarea" readonly placeholder="Formatted structure will appear here after validation..." style="flex:1; height:auto; background:#ffffff;"></textarea>
    </div>
</div>

<!-- Compact Action Toolbar -->
<div class="workspace-toolbar" style="margin-top:12px; padding:10px 14px; background:var(--surface-subtle); border:1px solid var(--border); border-radius:var(--radius-md);">
    <div class="workspace-btn-group">
        <button type="button" class="btn btn-primary" onclick="runValidator()">
            {{ $tool['cta_text'] ?? 'Validate Syntax' }}
        </button>
        <button type="button" class="btn btn-ghost btn-sm" onclick="clearValidatorInput()">Clear</button>
    </div>
    <div class="workspace-hint" style="font-size:0.75rem; color:var(--text-muted);">
        <span>Keyboard: Press <kbd>Ctrl/Cmd+Enter</kbd> to validate</span>
    </div>
</div>
