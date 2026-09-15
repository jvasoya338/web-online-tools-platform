@if ($tool['slug'] === 'remove-duplicate-lines')
    {{-- Remove Duplicate Lines Workspace --}}
    <div style="display:flex; align-items:center; gap:16px; flex-wrap:wrap; margin-bottom:14px; padding:12px 16px; background:var(--surface-subtle); border:1px solid var(--border); border-radius:var(--radius-md);">
        <label style="font-size:0.88rem; display:flex; align-items:center; gap:6px; cursor:pointer; font-weight:600;">
            <input type="checkbox" id="dedup-case-sensitive" onchange="runDeduplicateLines()" style="width:16px; height:16px;"> Case Sensitive
        </label>
        <label style="font-size:0.88rem; display:flex; align-items:center; gap:6px; cursor:pointer; font-weight:600;">
            <input type="checkbox" id="dedup-trim-whitespace" checked onchange="runDeduplicateLines()" style="width:16px; height:16px;"> Trim Whitespace
        </label>
        <label style="font-size:0.88rem; display:flex; align-items:center; gap:6px; cursor:pointer; font-weight:600;">
            <input type="checkbox" id="dedup-preserve-order" checked onchange="runDeduplicateLines()" style="width:16px; height:16px;"> Preserve Order
        </label>
    </div>

    <div class="workspace-split">
        <div class="pane-card">
            <div class="pane-header">
                <span>Original Text List</span>
                <div class="pane-actions">
                    <button type="button" class="btn btn-ghost btn-sm" onclick="clearDeduplicateLines()">Clear</button>
                    <button type="button" class="btn btn-ghost btn-sm" onclick="loadDeduplicateLinesSample()">Sample</button>
                    <button type="button" class="btn btn-ghost btn-sm" onclick="pasteDeduplicateLinesClipboard()">Paste</button>
                </div>
            </div>
            <textarea id="dedup-input" class="editor-textarea" placeholder="Paste list of items (one per line) to deduplicate..." oninput="runDeduplicateLines()" spellcheck="false"></textarea>
            <div style="padding:8px 12px; background:var(--surface-subtle); border-top:1px solid var(--border); font-size:0.78rem; color:var(--text-muted); display:flex; justify-content:space-between;">
                <span id="dedup-in-stats">0 lines</span>
                <span>Original Input</span>
            </div>
        </div>

        <div class="pane-card">
            <div class="pane-header">
                <span>Deduplicated Output</span>
                <div class="pane-actions">
                    <button type="button" class="btn btn-secondary btn-sm" onclick="copyOutput('dedup-output')">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg>
                        Copy
                    </button>
                    <button type="button" class="btn btn-ghost btn-sm" onclick="downloadTextTool('dedup-output', 'unique-lines.txt')">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                        Download
                    </button>
                </div>
            </div>
            <textarea id="dedup-output" class="editor-textarea" readonly placeholder="Unique lines will appear here..." style="background:#fafafa;"></textarea>
            <div style="padding:8px 12px; background:var(--surface-subtle); border-top:1px solid var(--border); font-size:0.78rem; color:var(--text-muted); display:flex; justify-content:space-between;">
                <span id="dedup-out-stats">0 unique lines | 0 duplicates removed</span>
                <span style="color:var(--brand-dark); font-weight:600;">Deduplicated</span>
            </div>
        </div>
    </div>

    <div class="workspace-toolbar" style="margin-top:16px;">
        <div class="workspace-btn-group">
            <button type="button" class="btn btn-primary" onclick="runDeduplicateLines()">Remove Duplicates</button>
            <button type="button" class="btn btn-secondary" onclick="clearDeduplicateLines()">Clear</button>
        </div>
        <div class="workspace-hint">
            <span>Updates automatically as you type</span>
        </div>
    </div>

@elseif ($tool['slug'] === 'remove-empty-lines')
    {{-- Remove Empty Lines Workspace --}}
    <div style="display:flex; align-items:center; gap:16px; flex-wrap:wrap; margin-bottom:14px; padding:12px 16px; background:var(--surface-subtle); border:1px solid var(--border); border-radius:var(--radius-md);">
        <label style="font-size:0.88rem; display:flex; align-items:center; gap:6px; cursor:pointer; font-weight:600;">
            <input type="radio" name="empty-lines-mode" value="all" checked onchange="runRemoveEmptyLines()" style="width:16px; height:16px;"> Remove All Blank Lines
        </label>
        <label style="font-size:0.88rem; display:flex; align-items:center; gap:6px; cursor:pointer; font-weight:600;">
            <input type="radio" name="empty-lines-mode" value="collapse" onchange="runRemoveEmptyLines()" style="width:16px; height:16px;"> Collapse Multiple Blank Lines to One
        </label>
        <label style="font-size:0.88rem; display:flex; align-items:center; gap:6px; cursor:pointer; font-weight:600; margin-left:auto;">
            <input type="checkbox" id="empty-trim-whitespace" checked onchange="runRemoveEmptyLines()" style="width:16px; height:16px;"> Treat whitespace-only lines as empty
        </label>
    </div>

    <div class="workspace-split">
        <div class="pane-card">
            <div class="pane-header">
                <span>Source Text</span>
                <div class="pane-actions">
                    <button type="button" class="btn btn-ghost btn-sm" onclick="clearRemoveEmptyLines()">Clear</button>
                    <button type="button" class="btn btn-ghost btn-sm" onclick="loadRemoveEmptyLinesSample()">Sample</button>
                    <button type="button" class="btn btn-ghost btn-sm" onclick="pasteRemoveEmptyLinesClipboard()">Paste</button>
                </div>
            </div>
            <textarea id="empty-input" class="editor-textarea" placeholder="Paste text or code with blank lines to clean..." oninput="runRemoveEmptyLines()" spellcheck="false"></textarea>
            <div style="padding:8px 12px; background:var(--surface-subtle); border-top:1px solid var(--border); font-size:0.78rem; color:var(--text-muted); display:flex; justify-content:space-between;">
                <span id="empty-in-stats">0 lines</span>
                <span>Source Text</span>
            </div>
        </div>

        <div class="pane-card">
            <div class="pane-header">
                <span>Cleaned Text</span>
                <div class="pane-actions">
                    <button type="button" class="btn btn-secondary btn-sm" onclick="copyOutput('empty-output')">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg>
                        Copy
                    </button>
                    <button type="button" class="btn btn-ghost btn-sm" onclick="downloadTextTool('empty-output', 'cleaned-text.txt')">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                        Download
                    </button>
                </div>
            </div>
            <textarea id="empty-output" class="editor-textarea" readonly placeholder="Cleaned text will appear here..." style="background:#fafafa;"></textarea>
            <div style="padding:8px 12px; background:var(--surface-subtle); border-top:1px solid var(--border); font-size:0.78rem; color:var(--text-muted); display:flex; justify-content:space-between;">
                <span id="empty-out-stats">0 lines | 0 empty lines removed</span>
                <span style="color:var(--brand-dark); font-weight:600;">Cleaned</span>
            </div>
        </div>
    </div>

    <div class="workspace-toolbar" style="margin-top:16px;">
        <div class="workspace-btn-group">
            <button type="button" class="btn btn-primary" onclick="runRemoveEmptyLines()">Clean Empty Lines</button>
            <button type="button" class="btn btn-secondary" onclick="clearRemoveEmptyLines()">Clear</button>
        </div>
        <div class="workspace-hint">
            <span>Updates automatically as you type</span>
        </div>
    </div>

@elseif ($tool['slug'] === 'find-and-replace')
    {{-- Find and Replace Workspace --}}
    <div style="margin-bottom:16px; padding:16px; background:var(--surface-subtle); border:1px solid var(--border); border-radius:var(--radius-md);">
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px; margin-bottom:12px;">
            <div>
                <label for="find-query" style="display:block; font-size:0.88rem; font-weight:600; color:var(--text); margin-bottom:4px;">Find:</label>
                <input type="text" id="find-query" placeholder="Text or pattern to search for..." style="width:100%; height:38px; font-family:var(--font-mono);" oninput="runFindAndReplace()">
            </div>
            <div>
                <label for="replace-query" style="display:block; font-size:0.88rem; font-weight:600; color:var(--text); margin-bottom:4px;">Replace with:</label>
                <input type="text" id="replace-query" placeholder="Replacement string (leave empty to delete)..." style="width:100%; height:38px; font-family:var(--font-mono);" oninput="runFindAndReplace()">
            </div>
        </div>

        <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px;">
            <div style="display:flex; gap:16px; flex-wrap:wrap;">
                <label style="font-size:0.88rem; display:flex; align-items:center; gap:6px; cursor:pointer; font-weight:600;">
                    <input type="checkbox" id="find-case-sensitive" onchange="runFindAndReplace()" style="width:16px; height:16px;"> Case Sensitive
                </label>
                <label style="font-size:0.88rem; display:flex; align-items:center; gap:6px; cursor:pointer; font-weight:600;">
                    <input type="checkbox" id="find-whole-word" onchange="runFindAndReplace()" style="width:16px; height:16px;"> Whole Word
                </label>
                <label style="font-size:0.88rem; display:flex; align-items:center; gap:6px; cursor:pointer; font-weight:600;">
                    <input type="checkbox" id="find-use-regex" onchange="runFindAndReplace()" style="width:16px; height:16px;"> Regular Expression
                </label>
            </div>
            <div id="find-count-badge" style="font-size:0.88rem; font-weight:700; color:var(--brand); padding:4px 12px; background:#e0f2fe; border-radius:var(--radius-sm);">
                0 replacements
            </div>
        </div>
    </div>

    <div id="find-regex-error" style="display:none; margin-bottom:14px; padding:10px 14px; background:var(--danger-bg); border:1px solid var(--danger); border-radius:var(--radius-sm); color:var(--danger); font-size:0.88rem;">
        <strong>Invalid Regular Expression:</strong> <span id="find-regex-error-msg"></span>
    </div>

    <div class="workspace-split">
        <div class="pane-card">
            <div class="pane-header">
                <span>Source Document</span>
                <div class="pane-actions">
                    <button type="button" class="btn btn-ghost btn-sm" onclick="clearFindAndReplace()">Clear</button>
                    <button type="button" class="btn btn-ghost btn-sm" onclick="loadFindAndReplaceSample()">Sample</button>
                    <button type="button" class="btn btn-ghost btn-sm" onclick="pasteFindAndReplaceClipboard()">Paste</button>
                </div>
            </div>
            <textarea id="find-input" class="editor-textarea" placeholder="Paste source text here..." oninput="runFindAndReplace()" spellcheck="false"></textarea>
        </div>

        <div class="pane-card">
            <div class="pane-header">
                <span>Replaced Document</span>
                <div class="pane-actions">
                    <button type="button" class="btn btn-secondary btn-sm" onclick="copyOutput('find-output')">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg>
                        Copy
                    </button>
                    <button type="button" class="btn btn-ghost btn-sm" onclick="downloadTextTool('find-output', 'replaced-text.txt')">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                        Download
                    </button>
                </div>
            </div>
            <textarea id="find-output" class="editor-textarea" readonly placeholder="Output with substitutions will appear here..." style="background:#fafafa;"></textarea>
        </div>
    </div>

    <div class="workspace-toolbar" style="margin-top:16px;">
        <div class="workspace-btn-group">
            <button type="button" class="btn btn-primary" onclick="runFindAndReplace()">Replace All</button>
            <button type="button" class="btn btn-secondary" onclick="clearFindAndReplace()">Clear</button>
        </div>
    </div>

@elseif ($tool['slug'] === 'reverse-text')
    {{-- Reverse Text Workspace --}}
    <div style="display:flex; align-items:center; gap:8px; flex-wrap:wrap; margin-bottom:14px; padding:12px 16px; background:var(--surface-subtle); border:1px solid var(--border); border-radius:var(--radius-md);" id="reverse-mode-btns">
        <span style="font-size:0.88rem; font-weight:700; color:var(--text); margin-right:6px;">Reversal Mode:</span>
        <button type="button" class="btn btn-secondary btn-sm reverse-mode-btn active" onclick="setReverseMode('chars', this)">Reverse All Characters</button>
        <button type="button" class="btn btn-ghost btn-sm reverse-mode-btn" onclick="setReverseMode('words', this)">Reverse Words</button>
        <button type="button" class="btn btn-ghost btn-sm reverse-mode-btn" onclick="setReverseMode('lines', this)">Reverse Lines</button>
        <button type="button" class="btn btn-ghost btn-sm reverse-mode-btn" onclick="setReverseMode('line-chars', this)">Reverse Each Line</button>
    </div>

    <div class="workspace-split">
        <div class="pane-card">
            <div class="pane-header">
                <span>Input Text</span>
                <div class="pane-actions">
                    <button type="button" class="btn btn-ghost btn-sm" onclick="clearReverseText()">Clear</button>
                    <button type="button" class="btn btn-ghost btn-sm" onclick="loadReverseTextSample()">Sample</button>
                    <button type="button" class="btn btn-ghost btn-sm" onclick="pasteReverseTextClipboard()">Paste</button>
                </div>
            </div>
            <textarea id="reverse-input" class="editor-textarea" placeholder="Type or paste text to reverse..." oninput="runReverseText()" spellcheck="false"></textarea>
        </div>

        <div class="pane-card">
            <div class="pane-header">
                <span>Reversed Output</span>
                <div class="pane-actions">
                    <button type="button" class="btn btn-secondary btn-sm" onclick="copyOutput('reverse-output')">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg>
                        Copy
                    </button>
                    <button type="button" class="btn btn-ghost btn-sm" onclick="downloadTextTool('reverse-output', 'reversed-text.txt')">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                        Download
                    </button>
                </div>
            </div>
            <textarea id="reverse-output" class="editor-textarea" readonly placeholder="Reversed text will appear here..." style="background:#fafafa;"></textarea>
        </div>
    </div>

    <div class="workspace-toolbar" style="margin-top:16px;">
        <div class="workspace-btn-group">
            <button type="button" class="btn btn-primary" onclick="runReverseText()">Reverse Text</button>
            <button type="button" class="btn btn-secondary" onclick="clearReverseText()">Clear</button>
        </div>
    </div>

@elseif ($tool['slug'] === 'markdown-to-html')
    {{-- Markdown to HTML Workspace --}}
    <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px; margin-bottom:14px; padding:12px 16px; background:var(--surface-subtle); border:1px solid var(--border); border-radius:var(--radius-md);">
        <div style="display:flex; gap:8px;" id="md-view-tabs">
            <button type="button" class="btn btn-secondary btn-sm md-tab-btn active" onclick="switchMarkdownView('html', this)">HTML Source Code</button>
            <button type="button" class="btn btn-ghost btn-sm md-tab-btn" onclick="switchMarkdownView('preview', this)">Visual Preview</button>
        </div>
        <div style="display:flex; gap:16px; flex-wrap:wrap;">
            <label style="font-size:0.88rem; display:flex; align-items:center; gap:6px; cursor:pointer; font-weight:600;">
                <input type="checkbox" id="md-gfm" checked onchange="runMarkdownToHtml()" style="width:16px; height:16px;"> GFM Extensions (Tables/Tasks/Strikethrough)
            </label>
            <label style="font-size:0.88rem; display:flex; align-items:center; gap:6px; cursor:pointer; font-weight:600;">
                <input type="checkbox" id="md-breaks" onchange="runMarkdownToHtml()" style="width:16px; height:16px;"> Soft Line Breaks (&lt;br&gt;)
            </label>
        </div>
    </div>

    <div class="workspace-split">
        <div class="pane-card">
            <div class="pane-header">
                <span>Markdown Input</span>
                <div class="pane-actions">
                    <button type="button" class="btn btn-ghost btn-sm" onclick="clearMarkdownToHtml()">Clear</button>
                    <button type="button" class="btn btn-ghost btn-sm" onclick="loadMarkdownSample()">Sample</button>
                    <button type="button" class="btn btn-ghost btn-sm" onclick="pasteMarkdownClipboard()">Paste</button>
                </div>
            </div>
            <textarea id="md-input" class="editor-textarea" placeholder="# Enter Markdown here..." oninput="runMarkdownToHtml()" spellcheck="false"></textarea>
            <div style="padding:8px 12px; background:var(--surface-subtle); border-top:1px solid var(--border); font-size:0.78rem; color:var(--text-muted); display:flex; justify-content:space-between;">
                <span id="md-in-stats">0 characters</span>
                <span>CommonMark & GFM</span>
            </div>
        </div>

        <div class="pane-card">
            <div class="pane-header">
                <span id="md-output-title">HTML Output</span>
                <div class="pane-actions">
                    <button type="button" class="btn btn-secondary btn-sm" onclick="copyOutput('md-output')">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg>
                        Copy HTML
                    </button>
                    <button type="button" class="btn btn-ghost btn-sm" onclick="downloadTextTool('md-output', 'document.html')">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                        Download HTML
                    </button>
                </div>
            </div>

            <textarea id="md-output" class="editor-textarea" readonly placeholder="HTML code will appear here..." style="background:#fafafa; font-family:var(--font-mono); font-size:0.86rem;"></textarea>

            <div id="md-preview" style="display:none; flex:1; padding:20px; overflow-y:auto; background:#ffffff; color:var(--text); line-height:1.6;"></div>

            <div style="padding:8px 12px; background:var(--surface-subtle); border-top:1px solid var(--border); font-size:0.78rem; color:var(--text-muted); display:flex; justify-content:space-between;">
                <span id="md-out-stats">0 characters</span>
                <span style="color:var(--brand-dark); font-weight:600;">HTML5 Markup</span>
            </div>
        </div>
    </div>

    <div class="workspace-toolbar" style="margin-top:16px;">
        <div class="workspace-btn-group">
            <button type="button" class="btn btn-primary" onclick="runMarkdownToHtml()">Convert to HTML</button>
            <button type="button" class="btn btn-secondary" onclick="clearMarkdownToHtml()">Clear</button>
        </div>
        <div class="workspace-hint">
            <span>Updates live as you type</span>
        </div>
    </div>
@endif
