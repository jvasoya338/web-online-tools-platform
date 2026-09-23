<div class="workspace-split">
    <!-- Source Pane -->
    <div class="pane-card">
        <div class="pane-header">
            <span>
                @if ($tool['slug'] === 'json-to-xml-converter')
                    JSON Source Input
                @elseif ($tool['slug'] === 'xml-to-json-converter')
                    XML Source Input
                @elseif ($tool['slug'] === 'json-to-csv-converter')
                    JSON Array Input
                @elseif ($tool['slug'] === 'yaml-to-json-converter')
                    YAML Source Input
                @elseif ($tool['slug'] === 'json-to-yaml-converter')
                    JSON Source Input
                @else
                    Source Input
                @endif
            </span>
            <div class="pane-actions">
                <button type="button" class="btn btn-ghost btn-sm" onclick="clearConverterInput()" title="Clear input">Clear</button>
                <button type="button" class="btn btn-ghost btn-sm" onclick="loadConverterSample()" title="Load sample">Sample</button>
                <button type="button" class="btn btn-ghost btn-sm" onclick="pasteConverterClipboard()" title="Paste from clipboard">Paste</button>
            </div>
        </div>
        <textarea id="converter-input" class="editor-textarea" placeholder="Paste source payload to convert automatically..." spellcheck="false"></textarea>
        <div style="padding:6px 12px; background:var(--surface-subtle); border-top:1px solid var(--border); font-size:0.75rem; color:var(--text-muted); display:flex; justify-content:space-between;">
            <span>Source Ready</span>
            <span>⚡ Live Auto-Convert</span>
        </div>
    </div>

    <!-- Target Output Pane -->
    <div class="pane-card">
        <div class="pane-header">
            <span>
                @if ($tool['slug'] === 'json-to-xml-converter')
                    Converted XML Output
                @elseif ($tool['slug'] === 'xml-to-json-converter')
                    Converted JSON Output
                @elseif ($tool['slug'] === 'json-to-csv-converter')
                    Converted CSV Output
                @elseif ($tool['slug'] === 'yaml-to-json-converter')
                    Converted JSON Output
                @elseif ($tool['slug'] === 'json-to-yaml-converter')
                    Converted YAML Output
                @else
                    Converted Output
                @endif
            </span>
            <div class="pane-actions">
                <button type="button" class="btn btn-secondary btn-sm" onclick="copyOutput('converter-output')">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg>
                    Copy
                </button>
                <button type="button" class="btn btn-ghost btn-sm" onclick="downloadConvertedOutput()" title="Download converted file">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                    Download
                </button>
            </div>
        </div>
        <textarea id="converter-output" class="editor-textarea" readonly placeholder="Converted data will appear here..." style="background:#fafafa;"></textarea>
        <div style="padding:6px 12px; background:var(--surface-subtle); border-top:1px solid var(--border); font-size:0.75rem; color:var(--text-muted); display:flex; justify-content:space-between;">
            <span>Target Output</span>
            <span style="color:var(--brand-dark); font-weight:600;">Client-Side</span>
        </div>
    </div>
</div>

<!-- Compact Action & Options Toolbar -->
<div class="workspace-toolbar" style="margin-top:12px; padding:10px 14px; background:var(--surface-subtle); border:1px solid var(--border); border-radius:var(--radius-md);">
    <div style="display:flex; align-items:center; gap:12px; flex-wrap:wrap;">
        @if ($tool['slug'] === 'json-to-xml-converter')
            <div style="display:flex; align-items:center; gap:6px;">
                <label for="xml-root-name" style="font-size:0.82rem; font-weight:600; color:var(--text);">Root Tag:</label>
                <input type="text" id="xml-root-name" value="root" oninput="runConverter()" style="height:32px; width:100px; font-family:var(--font-mono); font-size:0.84rem; font-weight:600; padding:0 8px; border-radius:var(--radius-sm); border:1px solid var(--border);">
            </div>
        @endif
    </div>

    <div class="workspace-btn-group">
        <button type="button" class="btn btn-primary" onclick="runConverter()">
            {{ $tool['cta_text'] ?? 'Convert Data' }}
        </button>
        <button type="button" class="btn btn-ghost btn-sm" onclick="clearConverterInput()">Clear</button>
        <span style="font-size:0.75rem; color:var(--text-muted); margin-left:4px;">Ctrl+Enter</span>
    </div>
</div>

<!-- Error Notice -->
<div id="converter-error" style="display:none; margin-top:10px; padding:10px 14px; background:var(--danger-bg); border:1px solid var(--danger); border-radius:var(--radius-sm); color:var(--danger); font-size:0.88rem;">
    <strong>Conversion Error:</strong> <span id="converter-error-msg"></span>
</div>
