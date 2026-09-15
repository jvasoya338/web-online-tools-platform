@if ($tool['slug'] === 'html-to-markdown')
    {{-- HTML to Markdown Workspace --}}
    <div class="workspace-split">
        <div class="pane-card">
            <div class="pane-header">
                <span>HTML Source Input</span>
                <div class="pane-actions">
                    <button type="button" class="btn btn-ghost btn-sm" onclick="clearHtmlToMarkdown()">Clear</button>
                    <button type="button" class="btn btn-ghost btn-sm" onclick="loadHtmlToMarkdownSample()">Sample</button>
                    <button type="button" class="btn btn-ghost btn-sm" onclick="pasteHtmlToMarkdownClipboard()">Paste</button>
                </div>
            </div>
            <textarea id="html-to-md-input" class="editor-textarea" placeholder="Paste HTML markup here (e.g. &lt;h2&gt;Title&lt;/h2&gt;&lt;p&gt;Content...&lt;/p&gt;)..." oninput="runHtmlToMarkdown()" spellcheck="false"></textarea>
            <div style="padding:8px 12px; background:var(--surface-subtle); border-top:1px solid var(--border); font-size:0.78rem; color:var(--text-muted); display:flex; justify-content:space-between;">
                <span id="html-to-md-in-stats">0 characters</span>
                <span>HTML5 Source</span>
            </div>
        </div>

        <div class="pane-card">
            <div class="pane-header">
                <span>Markdown Output</span>
                <div class="pane-actions">
                    <button type="button" class="btn btn-secondary btn-sm" onclick="copyOutput('html-to-md-output')">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg>
                        Copy Markdown
                    </button>
                    <button type="button" class="btn btn-ghost btn-sm" onclick="downloadTextTool('html-to-md-output', 'converted.md')">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                        Download .md
                    </button>
                </div>
            </div>
            <textarea id="html-to-md-output" class="editor-textarea" readonly placeholder="Converted Markdown will appear here..." style="background:#fafafa; font-family:var(--font-mono); font-size:0.86rem;"></textarea>
            <div style="padding:8px 12px; background:var(--surface-subtle); border-top:1px solid var(--border); font-size:0.78rem; color:var(--text-muted); display:flex; justify-content:space-between;">
                <span id="html-to-md-out-stats">0 characters</span>
                <span style="color:var(--brand-dark); font-weight:600;">GitHub Flavored Markdown</span>
            </div>
        </div>
    </div>

    <div class="workspace-toolbar" style="margin-top:16px;">
        <div class="workspace-btn-group">
            <button type="button" class="btn btn-primary" onclick="runHtmlToMarkdown()">Convert to Markdown</button>
            <button type="button" class="btn btn-secondary" onclick="clearHtmlToMarkdown()">Clear</button>
        </div>
        <div class="workspace-hint">
            <span>Updates live as you type</span>
        </div>
    </div>

@elseif ($tool['slug'] === 'unicode-inspector')
    {{-- Unicode Inspector Workspace --}}
    <div>
        <div class="pane-card" style="padding:20px; margin-bottom:16px;">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:10px; flex-wrap:wrap; gap:8px;">
                <h3 style="margin:0; font-size:1.05rem; color:var(--text);">Enter Text or Emojis to Inspect</h3>
                <div style="display:flex; gap:8px;">
                    <button type="button" class="btn btn-ghost btn-sm" onclick="clearUnicodeInspector()">Clear</button>
                    <button type="button" class="btn btn-ghost btn-sm" onclick="loadUnicodeInspectorSample()">Sample</button>
                </div>
            </div>
            <textarea id="unicode-input" class="editor-textarea" style="height:100px; font-size:1.05rem;" placeholder="Type or paste any text, emoji (e.g. 🚀, 👨‍👩‍👧‍👦), or international symbols here..." oninput="runUnicodeInspector()"></textarea>
            <div style="display:flex; gap:16px; margin-top:12px; font-size:0.85rem; color:var(--text-muted); flex-wrap:wrap;">
                <span id="unicode-stat-chars">0 characters</span>
                <span>•</span>
                <span id="unicode-stat-graphemes">0 grapheme clusters</span>
                <span>•</span>
                <span id="unicode-stat-bytes">0 UTF-8 bytes</span>
            </div>
        </div>

        <div class="pane-card" style="padding:16px;">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px; flex-wrap:wrap; gap:8px;">
                <span id="unicode-table-count" style="font-size:0.88rem; font-weight:700; color:var(--text);">Character Breakdown (0 items)</span>
            </div>
            <div style="overflow-x:auto; max-height:420px; overflow-y:auto;">
                <table style="width:100%; border-collapse:collapse; font-size:0.85rem;">
                    <thead style="position:sticky; top:0; z-index:1;">
                        <tr style="background:var(--surface-subtle); border-bottom:2px solid var(--border); text-align:left;">
                            <th style="padding:8px 12px; width:70px;">Char</th>
                            <th style="padding:8px 12px;">Code Point</th>
                            <th style="padding:8px 12px;">Decimal</th>
                            <th style="padding:8px 12px;">UTF-8 Bytes</th>
                            <th style="padding:8px 12px;">Category</th>
                            <th style="padding:8px 12px; width:120px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="unicode-table-body">
                        <tr><td colspan="6" style="padding:20px; text-align:center; color:var(--text-muted);">Enter text above to inspect Unicode code points and bytes.</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@elseif ($tool['slug'] === 'text-escape-unescape')
    {{-- Text Escape / Unescape Workspace --}}
    <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px; margin-bottom:14px; padding:12px 16px; background:var(--surface-subtle); border:1px solid var(--border); border-radius:var(--radius-md);">
        <div style="display:flex; gap:8px; flex-wrap:wrap;" id="escape-format-btns">
            <button type="button" class="btn btn-secondary btn-sm escape-fmt-btn active" onclick="setEscapeFormat('json', this)">JSON String</button>
            <button type="button" class="btn btn-ghost btn-sm escape-fmt-btn" onclick="setEscapeFormat('js', this)">JavaScript / C-Style</button>
            <button type="button" class="btn btn-ghost btn-sm escape-fmt-btn" onclick="setEscapeFormat('html', this)">HTML Entities</button>
            <button type="button" class="btn btn-ghost btn-sm escape-fmt-btn" onclick="setEscapeFormat('csv', this)">CSV Field</button>
        </div>
        <div style="display:flex; gap:8px;" id="escape-direction-btns">
            <button type="button" class="btn btn-secondary btn-sm escape-dir-btn active" onclick="setEscapeDirection('escape', this)">Escape</button>
            <button type="button" class="btn btn-ghost btn-sm escape-dir-btn" onclick="setEscapeDirection('unescape', this)">Unescape</button>
        </div>
    </div>

    <div class="workspace-split">
        <div class="pane-card">
            <div class="pane-header">
                <span id="escape-input-label">Source Text</span>
                <div class="pane-actions">
                    <button type="button" class="btn btn-ghost btn-sm" onclick="clearTextEscape()">Clear</button>
                    <button type="button" class="btn btn-ghost btn-sm" onclick="loadTextEscapeSample()">Sample</button>
                    <button type="button" class="btn btn-ghost btn-sm" onclick="pasteTextEscapeClipboard()">Paste</button>
                </div>
            </div>
            <textarea id="escape-input" class="editor-textarea" placeholder="Enter text to escape or unescape..." oninput="runTextEscape()" spellcheck="false"></textarea>
        </div>

        <div class="pane-card">
            <div class="pane-header">
                <span id="escape-output-label">Escaped Output</span>
                <div class="pane-actions">
                    <button type="button" class="btn btn-secondary btn-sm" onclick="copyOutput('escape-output')">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg>
                        Copy
                    </button>
                    <button type="button" class="btn btn-ghost btn-sm" onclick="downloadTextTool('escape-output', 'escaped-text.txt')">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                        Download
                    </button>
                </div>
            </div>
            <textarea id="escape-output" class="editor-textarea" readonly placeholder="Result will appear here..." style="background:#fafafa; font-family:var(--font-mono); font-size:0.86rem;"></textarea>
        </div>
    </div>

    <div class="workspace-toolbar" style="margin-top:16px;">
        <div class="workspace-btn-group">
            <button type="button" class="btn btn-primary" onclick="runTextEscape()">Transform</button>
            <button type="button" class="btn btn-secondary" onclick="clearTextEscape()">Clear</button>
        </div>
    </div>

@elseif ($tool['slug'] === 'csv-viewer')
    {{-- CSV Viewer Workspace --}}
    <div>
        <div class="pane-card" style="padding:16px; margin-bottom:16px;">
            <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px;">
                <div style="display:flex; align-items:center; gap:12px; flex-wrap:wrap;">
                    <label for="csv-view-delimiter" style="font-size:0.88rem; font-weight:600; color:var(--text);">Delimiter:</label>
                    <select id="csv-view-delimiter" style="height:36px; padding:0 8px; border-radius:var(--radius-sm); border:1px solid var(--border);" onchange="runCsvViewer()">
                        <option value="auto" selected>Auto-Detect</option>
                        <option value=",">Comma (,)</option>
                        <option value=";">Semicolon (;)</option>
                        <option value="&#9;">Tab (\t)</option>
                        <option value="|">Pipe (|)</option>
                    </select>

                    <label style="font-size:0.88rem; display:flex; align-items:center; gap:6px; cursor:pointer; font-weight:600;">
                        <input type="checkbox" id="csv-view-has-header" checked onchange="runCsvViewer()" style="width:16px; height:16px;"> First row is header
                    </label>
                </div>

                <div style="display:flex; gap:8px;">
                    <button type="button" class="btn btn-ghost btn-sm" onclick="clearCsvViewer()">Clear</button>
                    <button type="button" class="btn btn-ghost btn-sm" onclick="loadCsvViewerSample()">Sample</button>
                    <button type="button" class="btn btn-secondary btn-sm" onclick="toggleCsvRawEditor()">Toggle Raw Input</button>
                </div>
            </div>

            <div id="csv-raw-container" style="margin-top:12px;">
                <textarea id="csv-view-input" class="editor-textarea" style="height:120px;" placeholder="Paste CSV data here..." oninput="runCsvViewer()" spellcheck="false"></textarea>
            </div>
        </div>

        <div class="pane-card" style="padding:16px;">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px; flex-wrap:wrap; gap:10px;">
                <input type="text" id="csv-filter-query" placeholder="Filter rows in table..." style="max-width:280px; height:36px; font-size:0.86rem;" oninput="filterCsvTable()">
                <div id="csv-view-stats" style="font-size:0.85rem; font-weight:700; color:var(--brand);">0 rows | 0 columns</div>
            </div>

            <div style="overflow-x:auto; max-height:460px; overflow-y:auto; border:1px solid var(--border); border-radius:var(--radius-sm);">
                <table style="width:100%; border-collapse:collapse; font-size:0.85rem;" id="csv-rendered-table">
                    <thead id="csv-table-head" style="position:sticky; top:0; z-index:1; background:var(--surface-subtle);">
                        <tr><th style="padding:10px 14px; text-align:left; color:var(--text-muted);">Paste CSV data above to render table.</th></tr>
                    </thead>
                    <tbody id="csv-table-body">
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@elseif ($tool['slug'] === 'tsv-to-csv-converter')
    {{-- TSV to CSV Converter Workspace --}}
    <div class="workspace-split">
        <div class="pane-card">
            <div class="pane-header">
                <span>TSV (Tab-Separated) Input</span>
                <div class="pane-actions">
                    <button type="button" class="btn btn-ghost btn-sm" onclick="clearTsvToCsv()">Clear</button>
                    <button type="button" class="btn btn-ghost btn-sm" onclick="loadTsvToCsvSample()">Sample</button>
                    <button type="button" class="btn btn-ghost btn-sm" onclick="pasteTsvToCsvClipboard()">Paste</button>
                </div>
            </div>
            <textarea id="tsv-input" class="editor-textarea" placeholder="Paste Tab-Separated Values (TSV) here..." oninput="runTsvToCsv()" spellcheck="false"></textarea>
            <div style="padding:8px 12px; background:var(--surface-subtle); border-top:1px solid var(--border); font-size:0.78rem; color:var(--text-muted); display:flex; justify-content:space-between;">
                <span id="tsv-in-stats">0 lines</span>
                <span>TSV Format</span>
            </div>
        </div>

        <div class="pane-card">
            <div class="pane-header">
                <span>RFC 4180 CSV Output</span>
                <div class="pane-actions">
                    <button type="button" class="btn btn-secondary btn-sm" onclick="copyOutput('tsv-output')">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg>
                        Copy CSV
                    </button>
                    <button type="button" class="btn btn-ghost btn-sm" onclick="downloadTextTool('tsv-output', 'export.csv')">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                        Download CSV
                    </button>
                </div>
            </div>
            <textarea id="tsv-output" class="editor-textarea" readonly placeholder="Converted RFC 4180 CSV will appear here..." style="background:#fafafa; font-family:var(--font-mono); font-size:0.86rem;"></textarea>
            <div style="padding:8px 12px; background:var(--surface-subtle); border-top:1px solid var(--border); font-size:0.78rem; color:var(--text-muted); display:flex; justify-content:space-between;">
                <span id="tsv-out-stats">0 lines</span>
                <span style="color:var(--brand-dark); font-weight:600;">RFC 4180 Standard</span>
            </div>
        </div>
    </div>

    <div class="workspace-toolbar" style="margin-top:16px;">
        <div class="workspace-btn-group">
            <button type="button" class="btn btn-primary" onclick="runTsvToCsv()">Convert to CSV</button>
            <button type="button" class="btn btn-secondary" onclick="clearTsvToCsv()">Clear</button>
        </div>
        <div class="workspace-hint">
            <span>Updates live as you type</span>
        </div>
    </div>
@endif
