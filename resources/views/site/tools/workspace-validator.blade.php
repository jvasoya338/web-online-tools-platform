<div class="workspace-split">
    <!-- Input Pane -->
    <div class="pane-card">
        <div class="pane-header">
            <span>{{ str_replace(' Validator', '', $tool['title']) }} Input</span>
            <div class="pane-actions">
                <button type="button" class="btn btn-ghost btn-sm" onclick="clearValidatorInput()" title="Clear input">Clear</button>
                <button type="button" class="btn btn-ghost btn-sm" onclick="loadValidatorSample()" title="Load sample">Sample</button>
                <button type="button" class="btn btn-ghost btn-sm" onclick="pasteValidatorClipboard()" title="Paste from clipboard">Paste</button>
            </div>
        </div>
        <textarea id="validator-input" class="editor-textarea" placeholder="Paste {{ str_replace(' Validator', '', $tool['title']) }} here to validate syntax..." spellcheck="false"></textarea>
    </div>

    <!-- Output / Status Pane -->
    <div class="pane-card">
        <div class="pane-header">
            <span>Validation Diagnostic</span>
            <div class="pane-actions">
                <button type="button" class="btn btn-secondary btn-sm" onclick="copyOutput('validator-output')">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg>
                    Copy Formatted
                </button>
            </div>
        </div>

        <!-- Validation Status Card -->
        <div id="validator-status-box" style="padding:16px; border-bottom:1px solid var(--border); background:var(--surface-subtle);">
            <div id="validator-initial" style="color:var(--text-muted); font-size:0.92rem; display:flex; align-items:center; gap:8px;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
                Enter {{ str_replace(' Validator', '', $tool['title']) }} and click "Validate Syntax" to inspect for errors.
            </div>

            <div id="validator-success" style="display:none; padding:12px 16px; background:var(--success-bg); border:1px solid rgba(22, 163, 74, 0.3); border-radius:var(--radius-sm); color:var(--success);">
                <div style="font-weight:700; font-size:1rem; display:flex; align-items:center; gap:8px;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                    Valid {{ str_replace(' Validator', '', $tool['title']) }}!
                </div>
                <div style="font-size:0.86rem; margin-top:4px; color:var(--text);">Document conforms to standard specifications with 0 syntax errors.</div>
            </div>

            <div id="validator-failure" style="display:none; padding:12px 16px; background:var(--danger-bg); border:1px solid rgba(220, 38, 38, 0.3); border-radius:var(--radius-sm); color:var(--danger);">
                <div style="font-weight:700; font-size:1rem; display:flex; align-items:center; gap:8px;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
                    Invalid {{ str_replace(' Validator', '', $tool['title']) }} Syntax
                </div>
                <div id="validator-error-details" style="font-size:0.88rem; font-weight:600; margin-top:6px; font-family:var(--font-mono); color:#991b1b; white-space:pre-wrap;"></div>
            </div>
        </div>

        <textarea id="validator-output" class="editor-textarea" readonly placeholder="Formatted structure will appear here after validation..." style="flex:1; background:#ffffff;"></textarea>
    </div>
</div>

<!-- Bottom Action Toolbar -->
<div class="workspace-toolbar" style="margin-top:16px;">
    <div class="workspace-btn-group">
        <button type="button" class="btn btn-primary" onclick="runValidator()">
            Validate {{ str_replace(' Validator', '', $tool['title']) }}
        </button>
        <button type="button" class="btn btn-secondary" onclick="clearValidatorInput()">Clear</button>
    </div>
    <div class="workspace-hint">
        <span>Keyboard: Press <kbd>Ctrl/Cmd+Enter</kbd> to validate</span>
    </div>
</div>
