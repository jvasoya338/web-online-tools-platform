@if ($tool['slug'] === 'remove-duplicate-lines')
    {{-- Remove Duplicate Lines Workspace --}}
    <div style="display:flex; align-items:center; gap:14px; flex-wrap:wrap; margin-bottom:10px; padding:8px 12px; background:var(--surface-subtle); border:1px solid var(--border); border-radius:var(--radius-md);">
        <label style="font-size:0.82rem; display:flex; align-items:center; gap:5px; cursor:pointer; font-weight:600;">
            <input type="checkbox" id="dedup-case-sensitive" onchange="runDeduplicateLines()" style="width:15px; height:15px;"> Case Sensitive
        </label>
        <label style="font-size:0.82rem; display:flex; align-items:center; gap:5px; cursor:pointer; font-weight:600;">
            <input type="checkbox" id="dedup-trim-whitespace" checked onchange="runDeduplicateLines()" style="width:15px; height:15px;"> Trim Whitespace
        </label>
        <label style="font-size:0.82rem; display:flex; align-items:center; gap:5px; cursor:pointer; font-weight:600;">
            <input type="checkbox" id="dedup-preserve-order" checked onchange="runDeduplicateLines()" style="width:15px; height:15px;"> Preserve Order
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
            <textarea id="dedup-input" class="editor-textarea" placeholder="Paste list of items (one per line) to deduplicate automatically..." oninput="runDeduplicateLines()" spellcheck="false"></textarea>
            <div style="padding:6px 12px; background:var(--surface-subtle); border-top:1px solid var(--border); font-size:0.75rem; color:var(--text-muted); display:flex; justify-content:space-between;">
                <span id="dedup-in-stats">0 lines</span>
                <span>⚡ Live Deduplication</span>
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
            <div style="padding:6px 12px; background:var(--surface-subtle); border-top:1px solid var(--border); font-size:0.75rem; color:var(--text-muted); display:flex; justify-content:space-between;">
                <span id="dedup-out-stats">0 unique lines | 0 duplicates removed</span>
                <span style="color:var(--brand-dark); font-weight:600;">Deduplicated</span>
            </div>
        </div>
    </div>

    <div class="workspace-toolbar" style="margin-top:12px; padding:10px 14px; background:var(--surface-subtle); border:1px solid var(--border); border-radius:var(--radius-md);">
        <div class="workspace-btn-group">
            <button type="button" class="btn btn-primary" onclick="runDeduplicateLines()">{{ $tool['cta_text'] ?? 'Remove Duplicates' }}</button>
            <button type="button" class="btn btn-ghost btn-sm" onclick="clearDeduplicateLines()">Clear</button>
        </div>
        <div class="workspace-hint" style="font-size:0.75rem; color:var(--text-muted);">
            <span>⚡ Updates live as you type</span>
        </div>
    </div>

@elseif ($tool['slug'] === 'remove-empty-lines')
    {{-- Remove Empty Lines Workspace --}}
    <div style="display:flex; align-items:center; gap:14px; flex-wrap:wrap; margin-bottom:10px; padding:8px 12px; background:var(--surface-subtle); border:1px solid var(--border); border-radius:var(--radius-md);">
        <label style="font-size:0.82rem; display:flex; align-items:center; gap:5px; cursor:pointer; font-weight:600;">
            <input type="radio" name="empty-lines-mode" value="all" checked onchange="runRemoveEmptyLines()" style="width:15px; height:15px;"> Remove All Blank Lines
        </label>
        <label style="font-size:0.82rem; display:flex; align-items:center; gap:5px; cursor:pointer; font-weight:600;">
            <input type="radio" name="empty-lines-mode" value="collapse" onchange="runRemoveEmptyLines()" style="width:15px; height:15px;"> Collapse Multiple to One
        </label>
        <label style="font-size:0.82rem; display:flex; align-items:center; gap:5px; cursor:pointer; font-weight:600; margin-left:auto;">
            <input type="checkbox" id="empty-trim-whitespace" checked onchange="runRemoveEmptyLines()" style="width:15px; height:15px;"> Whitespace lines are empty
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
            <textarea id="empty-input" class="editor-textarea" placeholder="Paste text or code with blank lines to clean automatically..." oninput="runRemoveEmptyLines()" spellcheck="false"></textarea>
            <div style="padding:6px 12px; background:var(--surface-subtle); border-top:1px solid var(--border); font-size:0.75rem; color:var(--text-muted); display:flex; justify-content:space-between;">
                <span id="empty-in-stats">0 lines</span>
                <span>⚡ Live Cleaning</span>
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
            <div style="padding:6px 12px; background:var(--surface-subtle); border-top:1px solid var(--border); font-size:0.75rem; color:var(--text-muted); display:flex; justify-content:space-between;">
                <span id="empty-out-stats">0 lines | 0 empty lines removed</span>
                <span style="color:var(--brand-dark); font-weight:600;">Cleaned</span>
            </div>
        </div>
    </div>

    <div class="workspace-toolbar" style="margin-top:12px; padding:10px 14px; background:var(--surface-subtle); border:1px solid var(--border); border-radius:var(--radius-md);">
        <div class="workspace-btn-group">
            <button type="button" class="btn btn-primary" onclick="runRemoveEmptyLines()">{{ $tool['cta_text'] ?? 'Remove Empty Lines' }}</button>
            <button type="button" class="btn btn-ghost btn-sm" onclick="clearRemoveEmptyLines()">Clear</button>
        </div>
        <div class="workspace-hint" style="font-size:0.75rem; color:var(--text-muted);">
            <span>⚡ Updates live as you type</span>
        </div>
    </div>

@elseif ($tool['slug'] === 'find-and-replace')
    {{-- Find and Replace Workspace --}}
    <div style="margin-bottom:12px; padding:10px 14px; background:var(--surface-subtle); border:1px solid var(--border); border-radius:var(--radius-md);">
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:10px; margin-bottom:8px;">
            <div>
                <label for="find-query" style="display:block; font-size:0.82rem; font-weight:600; color:var(--text); margin-bottom:3px;">Find:</label>
                <input type="text" id="find-query" placeholder="Search string or pattern..." style="width:100%; height:34px; font-size:0.86rem; font-family:var(--font-mono);" oninput="runFindAndReplace()">
            </div>
            <div>
                <label for="replace-query" style="display:block; font-size:0.82rem; font-weight:600; color:var(--text); margin-bottom:3px;">Replace with:</label>
                <input type="text" id="replace-query" placeholder="Replacement text (leave blank to delete)..." style="width:100%; height:34px; font-size:0.86rem; font-family:var(--font-mono);" oninput="runFindAndReplace()">
            </div>
        </div>

        <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px;">
            <div style="display:flex; gap:12px; flex-wrap:wrap;">
                <label style="font-size:0.82rem; display:flex; align-items:center; gap:5px; cursor:pointer; font-weight:600;">
                    <input type="checkbox" id="find-case-sensitive" onchange="runFindAndReplace()" style="width:15px; height:15px;"> Case Sensitive
                </label>
                <label style="font-size:0.82rem; display:flex; align-items:center; gap:5px; cursor:pointer; font-weight:600;">
                    <input type="checkbox" id="find-whole-word" onchange="runFindAndReplace()" style="width:15px; height:15px;"> Whole Word
                </label>
                <label style="font-size:0.82rem; display:flex; align-items:center; gap:5px; cursor:pointer; font-weight:600;">
                    <input type="checkbox" id="find-use-regex" onchange="runFindAndReplace()" style="width:15px; height:15px;"> Regular Expression
                </label>
            </div>
            <div id="find-count-badge" style="font-size:0.82rem; font-weight:700; color:var(--brand); padding:2px 10px; background:#e0f2fe; border-radius:var(--radius-sm);">
                0 replacements
            </div>
        </div>
    </div>

    <div id="find-regex-error" style="display:none; margin-bottom:10px; padding:8px 12px; background:var(--danger-bg); border:1px solid var(--danger); border-radius:var(--radius-sm); color:var(--danger); font-size:0.84rem;">
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
            <textarea id="find-input" class="editor-textarea" placeholder="Paste source text here to replace live..." oninput="runFindAndReplace()" spellcheck="false"></textarea>
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

    <div class="workspace-toolbar" style="margin-top:12px; padding:10px 14px; background:var(--surface-subtle); border:1px solid var(--border); border-radius:var(--radius-md);">
        <div class="workspace-btn-group">
            <button type="button" class="btn btn-primary" onclick="runFindAndReplace()">{{ $tool['cta_text'] ?? 'Find & Replace' }}</button>
            <button type="button" class="btn btn-ghost btn-sm" onclick="clearFindAndReplace()">Clear</button>
        </div>
        <div class="workspace-hint" style="font-size:0.75rem; color:var(--text-muted);">
            <span>⚡ Live updates on input</span>
        </div>
    </div>

@elseif ($tool['slug'] === 'reverse-text')
    {{-- Reverse Text Workspace --}}
    <div style="display:flex; align-items:center; gap:6px; flex-wrap:wrap; margin-bottom:10px; padding:8px 12px; background:var(--surface-subtle); border:1px solid var(--border); border-radius:var(--radius-md);" id="reverse-mode-btns">
        <span style="font-size:0.82rem; font-weight:700; color:var(--text); margin-right:4px;">Mode:</span>
        <button type="button" class="btn btn-secondary btn-sm reverse-mode-btn active" onclick="setReverseMode('chars', this)">All Characters</button>
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
            <textarea id="reverse-input" class="editor-textarea" placeholder="Type or paste text to reverse automatically..." oninput="runReverseText()" spellcheck="false"></textarea>
            <div style="padding:6px 12px; background:var(--surface-subtle); border-top:1px solid var(--border); font-size:0.75rem; color:var(--text-muted); display:flex; justify-content:space-between;">
                <span>Input Ready</span>
                <span>⚡ Live Reversal</span>
            </div>
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
            <div style="padding:6px 12px; background:var(--surface-subtle); border-top:1px solid var(--border); font-size:0.75rem; color:var(--text-muted); display:flex; justify-content:space-between;">
                <span>Output Result</span>
                <span style="color:var(--brand-dark); font-weight:600;">Reversed</span>
            </div>
        </div>
    </div>

    <div class="workspace-toolbar" style="margin-top:12px; padding:10px 14px; background:var(--surface-subtle); border:1px solid var(--border); border-radius:var(--radius-md);">
        <div class="workspace-btn-group">
            <button type="button" class="btn btn-primary" onclick="runReverseText()">{{ $tool['cta_text'] ?? 'Reverse Text' }}</button>
            <button type="button" class="btn btn-ghost btn-sm" onclick="clearReverseText()">Clear</button>
        </div>
        <div class="workspace-hint" style="font-size:0.75rem; color:var(--text-muted);">
            <span>⚡ Updates live as you type</span>
        </div>
    </div>

@elseif ($tool['slug'] === 'markdown-to-html')
    {{-- Markdown to HTML Workspace --}}
    <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px; margin-bottom:10px; padding:8px 12px; background:var(--surface-subtle); border:1px solid var(--border); border-radius:var(--radius-md);">
        <div style="display:flex; gap:6px;" id="md-view-tabs">
            <button type="button" class="btn btn-secondary btn-sm md-tab-btn active" onclick="switchMarkdownView('html', this)">HTML Source</button>
            <button type="button" class="btn btn-ghost btn-sm md-tab-btn" onclick="switchMarkdownView('preview', this)">Visual Preview</button>
        </div>
        <div style="display:flex; gap:12px; flex-wrap:wrap;">
            <label style="font-size:0.82rem; display:flex; align-items:center; gap:5px; cursor:pointer; font-weight:600;">
                <input type="checkbox" id="md-gfm" checked onchange="runMarkdownToHtml()" style="width:15px; height:15px;"> GFM Extensions
            </label>
            <label style="font-size:0.82rem; display:flex; align-items:center; gap:5px; cursor:pointer; font-weight:600;">
                <input type="checkbox" id="md-breaks" onchange="runMarkdownToHtml()" style="width:15px; height:15px;"> Soft Breaks (&lt;br&gt;)
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
            <textarea id="md-input" class="editor-textarea" placeholder="# Enter Markdown here to convert to HTML live..." oninput="runMarkdownToHtml()" spellcheck="false"></textarea>
            <div style="padding:6px 12px; background:var(--surface-subtle); border-top:1px solid var(--border); font-size:0.75rem; color:var(--text-muted); display:flex; justify-content:space-between;">
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
                        Download
                    </button>
                </div>
            </div>

            <textarea id="md-output" class="editor-textarea" readonly placeholder="HTML code will appear here..." style="background:#fafafa; font-family:var(--font-mono); font-size:0.86rem;"></textarea>
            <div id="md-preview" style="display:none; flex:1; padding:16px; overflow-y:auto; background:#ffffff; color:var(--text); line-height:1.6;"></div>

            <div style="padding:6px 12px; background:var(--surface-subtle); border-top:1px solid var(--border); font-size:0.75rem; color:var(--text-muted); display:flex; justify-content:space-between;">
                <span id="md-out-stats">0 characters</span>
                <span style="color:var(--brand-dark); font-weight:600;">HTML5 Output</span>
            </div>
        </div>
    </div>

    <div class="workspace-toolbar" style="margin-top:12px; padding:10px 14px; background:var(--surface-subtle); border:1px solid var(--border); border-radius:var(--radius-md);">
        <div class="workspace-btn-group">
            <button type="button" class="btn btn-primary" onclick="runMarkdownToHtml()">{{ $tool['cta_text'] ?? 'Convert Markdown' }}</button>
            <button type="button" class="btn btn-ghost btn-sm" onclick="clearMarkdownToHtml()">Clear</button>
        </div>
        <div class="workspace-hint" style="font-size:0.75rem; color:var(--text-muted);">
            <span>⚡ Live preview as you type</span>
        </div>
    </div>
@endif
