@if ($tool['slug'] === 'whitespace-cleaner')
    {{-- Whitespace Cleaner --}}
    <div style="margin-bottom:12px;">
        <button type="button" class="btn btn-primary btn-sm" onclick="runWhitespaceCleaner()">Normalize & Clean Whitespace</button>
    </div>

    <div class="workspace-split">
        <div class="pane-card">
            <div class="pane-header">
                <span>Input Text</span>
                <div class="pane-actions">
                    <button type="button" class="btn btn-ghost btn-sm" onclick="document.getElementById('ws-clean-input').value = '';">Clear</button>
                    <button type="button" class="btn btn-ghost btn-sm" onclick="document.getElementById('ws-clean-input').value = '   This   line   has    excessive    spaces.   \n\n\n   Another   line   with   tabs\t\tand   spaces.   '; runWhitespaceCleaner();">Sample</button>
                </div>
            </div>
            <textarea id="ws-clean-input" class="editor-textarea" placeholder="Paste text with excessive spaces or tabs..." oninput="runWhitespaceCleaner()"></textarea>
        </div>

        <div class="pane-card">
            <div class="pane-header">
                <span>Cleaned Text</span>
                <div class="pane-actions">
                    <button type="button" class="btn btn-secondary btn-sm" onclick="copyOutput('ws-clean-output')">Copy</button>
                </div>
            </div>
            <textarea id="ws-clean-output" class="editor-textarea" readonly placeholder="Cleaned text..."></textarea>
        </div>
    </div>

@elseif ($tool['slug'] === 'shuffle-lines')
    {{-- Shuffle Lines --}}
    <div style="margin-bottom:12px;">
        <button type="button" class="btn btn-primary btn-sm" onclick="runShuffleLines()">Shuffle Lines (Fisher-Yates)</button>
    </div>

    <div class="workspace-split">
        <div class="pane-card">
            <div class="pane-header">
                <span>Original Lines</span>
                <div class="pane-actions">
                    <button type="button" class="btn btn-ghost btn-sm" onclick="document.getElementById('shuffle-input').value = '';">Clear</button>
                    <button type="button" class="btn btn-ghost btn-sm" onclick="document.getElementById('shuffle-input').value = '1. Apple\n2. Banana\n3. Cherry\n4. Dragonfruit\n5. Elderberry\n6. Fig\n7. Grape'; runShuffleLines();">Sample</button>
                </div>
            </div>
            <textarea id="shuffle-input" class="editor-textarea" placeholder="Paste list of items to randomize..." oninput="runShuffleLines()"></textarea>
        </div>

        <div class="pane-card">
            <div class="pane-header">
                <span>Randomized Lines</span>
                <div class="pane-actions">
                    <button type="button" class="btn btn-secondary btn-sm" onclick="copyOutput('shuffle-output')">Copy</button>
                </div>
            </div>
            <textarea id="shuffle-output" class="editor-textarea" readonly placeholder="Shuffled order..."></textarea>
        </div>
    </div>

@elseif ($tool['slug'] === 'number-lines')
    {{-- Number Lines --}}
    <div style="margin-bottom:12px; display:flex; gap:12px; align-items:center; flex-wrap:wrap;">
        <label style="display:flex; align-items:center; gap:6px; cursor:pointer; font-size:0.88rem; font-weight:600;">
            <input type="checkbox" id="num-lines-pad" onchange="runNumberLines('add')"> Zero-Pad Numbers
        </label>
        <label for="num-lines-delim" style="font-size:0.88rem; font-weight:600;">Separator:</label>
        <select id="num-lines-delim" style="height:32px;" onchange="runNumberLines('add')">
            <option value=". " selected>. (1. item)</option>
            <option value=") ">) (1) item)</option>
            <option value=": ">: (1: item)</option>
            <option value=" - "> - (1 - item)</option>
        </select>
        <button type="button" class="btn btn-primary btn-sm" onclick="runNumberLines('add')">Add Numbers</button>
        <button type="button" class="btn btn-secondary btn-sm" onclick="runNumberLines('strip')">Strip Numbers</button>
    </div>

    <div class="workspace-split">
        <div class="pane-card">
            <div class="pane-header">
                <span>Input Lines</span>
                <div class="pane-actions">
                    <button type="button" class="btn btn-ghost btn-sm" onclick="document.getElementById('num-lines-input').value = '';">Clear</button>
                    <button type="button" class="btn btn-ghost btn-sm" onclick="document.getElementById('num-lines-input').value = 'Alpha\nBeta\nGamma\nDelta\nEpsilon'; runNumberLines('add');">Sample</button>
                </div>
            </div>
            <textarea id="num-lines-input" class="editor-textarea" placeholder="Paste lines of text..." oninput="runNumberLines('add')"></textarea>
        </div>

        <div class="pane-card">
            <div class="pane-header">
                <span>Numbered Output</span>
                <div class="pane-actions">
                    <button type="button" class="btn btn-secondary btn-sm" onclick="copyOutput('num-lines-output')">Copy</button>
                </div>
            </div>
            <textarea id="num-lines-output" class="editor-textarea" readonly placeholder="Numbered lines..."></textarea>
        </div>
    </div>

@elseif ($tool['slug'] === 'prefix-suffix-lines')
    {{-- Prefix & Suffix Lines --}}
    <div style="margin-bottom:12px; display:flex; gap:10px; align-items:center; flex-wrap:wrap;">
        <label for="ps-prefix" style="font-size:0.88rem; font-weight:600;">Prefix:</label>
        <input type="text" id="ps-prefix" value="&quot;" style="width:100px; height:32px;" oninput="runPrefixSuffixLines()">
        <label for="ps-suffix" style="font-size:0.88rem; font-weight:600;">Suffix:</label>
        <input type="text" id="ps-suffix" value="&quot;," style="width:100px; height:32px;" oninput="runPrefixSuffixLines()">
        <label style="display:flex; align-items:center; gap:6px; cursor:pointer; font-size:0.88rem;">
            <input type="checkbox" id="ps-skip-empty" checked onchange="runPrefixSuffixLines()"> Skip empty lines
        </label>
        <button type="button" class="btn btn-primary btn-sm" onclick="runPrefixSuffixLines()">Apply</button>
    </div>

    <div class="workspace-split">
        <div class="pane-card">
            <div class="pane-header">
                <span>Source Lines</span>
                <div class="pane-actions">
                    <button type="button" class="btn btn-ghost btn-sm" onclick="document.getElementById('ps-input').value = '';">Clear</button>
                    <button type="button" class="btn btn-ghost btn-sm" onclick="document.getElementById('ps-input').value = 'red\ngreen\nblue\nyellow'; runPrefixSuffixLines();">Sample</button>
                </div>
            </div>
            <textarea id="ps-input" class="editor-textarea" placeholder="Paste lines..." oninput="runPrefixSuffixLines()"></textarea>
        </div>

        <div class="pane-card">
            <div class="pane-header">
                <span>Transformed Output</span>
                <div class="pane-actions">
                    <button type="button" class="btn btn-secondary btn-sm" onclick="copyOutput('ps-output')">Copy</button>
                </div>
            </div>
            <textarea id="ps-output" class="editor-textarea" readonly placeholder="Output..."></textarea>
        </div>
    </div>

@elseif ($tool['slug'] === 'text-splitter')
    {{-- Text Splitter --}}
    <div style="margin-bottom:12px; display:flex; gap:10px; align-items:center; flex-wrap:wrap;">
        <label for="split-mode" style="font-size:0.88rem; font-weight:600;">Split by:</label>
        <select id="split-mode" style="height:32px;" onchange="runTextSplitter()">
            <option value="chars" selected>Character Count</option>
            <option value="words">Word Count</option>
            <option value="paragraphs">Paragraphs (Double newline)</option>
        </select>
        <label for="split-size" style="font-size:0.88rem; font-weight:600;">Chunk Size:</label>
        <input type="number" id="split-size" value="100" min="10" style="width:80px; height:32px;" oninput="runTextSplitter()">
        <span id="split-stats" style="font-size:0.85rem; font-weight:700; color:var(--brand);">0 chunks</span>
    </div>

    <div class="workspace-split">
        <div class="pane-card">
            <div class="pane-header">
                <span>Full Text Input</span>
                <div class="pane-actions">
                    <button type="button" class="btn btn-ghost btn-sm" onclick="document.getElementById('split-input').value = '';">Clear</button>
                    <button type="button" class="btn btn-ghost btn-sm" onclick="document.getElementById('split-input').value = 'WebToolsStation is a modern suite of developer tools built for speed, privacy, and simplicity. All data transformations happen locally in your web browser with zero server latency or file uploads.'; runTextSplitter();">Sample</button>
                </div>
            </div>
            <textarea id="split-input" class="editor-textarea" placeholder="Paste long text to split into chunks..." oninput="runTextSplitter()"></textarea>
        </div>

        <div class="pane-card">
            <div class="pane-header">
                <span>Discrete Chunks</span>
                <div class="pane-actions">
                    <button type="button" class="btn btn-secondary btn-sm" onclick="copyOutput('split-output')">Copy All Chunks</button>
                </div>
            </div>
            <textarea id="split-output" class="editor-textarea" readonly placeholder="Chunks..."></textarea>
        </div>
    </div>

@elseif ($tool['slug'] === 'text-merger')
    {{-- Text Joiner --}}
    <div style="margin-bottom:12px; display:flex; gap:10px; align-items:center; flex-wrap:wrap;">
        <label for="merge-delim" style="font-size:0.88rem; font-weight:600;">Delimiter:</label>
        <input type="text" id="merge-delim" value=", " style="width:80px; height:32px;" oninput="runTextMerger()">
        <label style="display:flex; align-items:center; gap:6px; cursor:pointer; font-size:0.88rem;">
            <input type="checkbox" id="merge-quotes" onchange="runTextMerger()"> Wrap items in quotes ('item')
        </label>
        <button type="button" class="btn btn-primary btn-sm" onclick="runTextMerger()">Join Lines</button>
    </div>

    <div class="workspace-split">
        <div class="pane-card">
            <div class="pane-header">
                <span>Lines to Join</span>
                <div class="pane-actions">
                    <button type="button" class="btn btn-ghost btn-sm" onclick="document.getElementById('merge-input').value = '';">Clear</button>
                    <button type="button" class="btn btn-ghost btn-sm" onclick="document.getElementById('merge-input').value = 'user_id\nemail\nrole\nstatus'; runTextMerger();">Sample</button>
                </div>
            </div>
            <textarea id="merge-input" class="editor-textarea" placeholder="Paste lines to join into a single delimited string..." oninput="runTextMerger()"></textarea>
        </div>

        <div class="pane-card">
            <div class="pane-header">
                <span>Joined String</span>
                <div class="pane-actions">
                    <button type="button" class="btn btn-secondary btn-sm" onclick="copyOutput('merge-output')">Copy</button>
                </div>
            </div>
            <textarea id="merge-output" class="editor-textarea" readonly placeholder="Joined string output..."></textarea>
        </div>
    </div>

@elseif (in_array($tool['slug'], ['extract-emails', 'extract-urls', 'extract-ip-addresses', 'extract-numbers']))
    @php
        $extConf = [
            'extract-emails' => ['id' => 'extract-email', 'name' => 'Email Addresses', 'fn' => 'runExtractEmails', 'sample' => "Contact us at support@webtools.test or security-alerts@example.org. CC: dev.team+filter@internal.co.uk"],
            'extract-urls' => ['id' => 'extract-url', 'name' => 'Web URLs', 'fn' => 'runExtractUrls', 'sample' => "Check https://webtoolsstation.com/tools/json-formatter and https://github.com/torvalds/linux or http://localhost:8080/api"],
            'extract-ip-addresses' => ['id' => 'extract-ip', 'name' => 'IP Addresses', 'fn' => 'runExtractIpAddresses', 'sample' => "Server 192.168.1.1 accessed by 10.0.0.42 and 2001:0db8:85a3:0000:0000:8a2e:0370:7334 at 12:00 UTC."],
            'extract-numbers' => ['id' => 'extract-num', 'name' => 'Numbers & Digits', 'fn' => 'runExtractNumbers', 'sample' => "Item 1 costs $45.99, item 2 costs 12.50 EUR, total discount was -5.00 for 3 customers."],
        ][$tool['slug']];
    @endphp

    <div style="margin-bottom:12px; display:flex; justify-content:space-between; align-items:center;">
        <button type="button" class="btn btn-primary btn-sm" onclick="{{ $extConf['fn'] }}()">Extract {{ $extConf['name'] }}</button>
        <span id="{{ $extConf['id'] }}-count" style="font-size:0.85rem; font-weight:700; color:var(--brand);">0 matches</span>
    </div>

    @if ($tool['slug'] === 'extract-numbers')
        <div id="extract-num-metrics" style="padding:8px 12px; background:var(--surface-subtle); border:1px solid var(--border); border-radius:var(--radius-sm); font-size:0.85rem; margin-bottom:12px;"></div>
    @endif

    <div class="workspace-split">
        <div class="pane-card">
            <div class="pane-header">
                <span>Source Text Input</span>
                <div class="pane-actions">
                    <button type="button" class="btn btn-ghost btn-sm" onclick="document.getElementById('{{ $extConf['id'] }}-input').value = '';">Clear</button>
                    <button type="button" class="btn btn-ghost btn-sm" onclick="document.getElementById('{{ $extConf['id'] }}-input').value = {{ json_encode($extConf['sample']) }}; {{ $extConf['fn'] }}();">Sample</button>
                </div>
            </div>
            <textarea id="{{ $extConf['id'] }}-input" class="editor-textarea" placeholder="Paste unformatted text or log content..." oninput="{{ $extConf['fn'] }}()"></textarea>
        </div>

        <div class="pane-card">
            <div class="pane-header">
                <span>Extracted Unique {{ $extConf['name'] }}</span>
                <div class="pane-actions">
                    <button type="button" class="btn btn-secondary btn-sm" onclick="copyOutput('{{ $extConf['id'] }}-output')">Copy</button>
                </div>
            </div>
            <textarea id="{{ $extConf['id'] }}-output" class="editor-textarea" readonly placeholder="Extracted list..."></textarea>
        </div>
    </div>

@elseif ($tool['slug'] === 'word-frequency-counter')
    {{-- Word Frequency Counter --}}
    <div class="workspace-split">
        <div class="pane-card">
            <div class="pane-header">
                <span>Text Passage</span>
                <div class="pane-actions">
                    <button type="button" class="btn btn-ghost btn-sm" onclick="document.getElementById('wf-input').value = ''; runWordFrequencyCounter();">Clear</button>
                    <button type="button" class="btn btn-ghost btn-sm" onclick="document.getElementById('wf-input').value = 'Web development requires high performance tools. Web tools make development faster and clean development practices improve web security.'; runWordFrequencyCounter();">Sample</button>
                </div>
            </div>
            <textarea id="wf-input" class="editor-textarea" placeholder="Paste article or text to calculate word frequency ranking..." oninput="runWordFrequencyCounter()"></textarea>
        </div>

        <div class="pane-card">
            <div class="pane-header">
                <span>Frequency Breakdown</span>
                <span id="wf-stats" style="font-size:0.82rem; font-weight:700; color:var(--brand);">0 words</span>
            </div>
            <div style="flex:1; overflow-y:auto; max-height:260px; border:1px solid var(--border); border-radius:var(--radius-sm);">
                <table style="width:100%; border-collapse:collapse; font-size:0.85rem;">
                    <thead style="position:sticky; top:0; background:var(--surface-subtle);">
                        <tr style="border-bottom:2px solid var(--border); text-align:left;">
                            <th style="padding:8px 12px;">Rank</th>
                            <th style="padding:8px 12px;">Word</th>
                            <th style="padding:8px 12px;">Count</th>
                            <th style="padding:8px 12px;">Density</th>
                        </tr>
                    </thead>
                    <tbody id="wf-table-body">
                        <tr><td colspan="4" style="text-align:center; padding:16px; color:var(--text-muted);">Paste text on the left to analyze frequency.</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@elseif ($tool['slug'] === 'text-repeater')
    {{-- Text Repeater --}}
    <div style="margin-bottom:12px; display:flex; gap:10px; align-items:center; flex-wrap:wrap;">
        <label for="repeat-count" style="font-size:0.88rem; font-weight:600;">Repeat Count (1 - 5000):</label>
        <input type="number" id="repeat-count" value="10" min="1" max="5000" style="width:80px; height:34px;" oninput="runTextRepeater()">
        <label for="repeat-sep" style="font-size:0.88rem; font-weight:600;">Separator:</label>
        <select id="repeat-sep" style="height:34px;" onchange="runTextRepeater()">
            <option value="\n" selected>Newline (\n)</option>
            <option value=" ">Space</option>
            <option value=", ">Comma & Space (, )</option>
            <option value=" - ">Hyphen ( - )</option>
        </select>
        <button type="button" class="btn btn-primary btn-sm" onclick="runTextRepeater()">Repeat</button>
    </div>

    <div class="workspace-split">
        <div class="pane-card">
            <div class="pane-header">
                <span>String to Repeat</span>
                <div class="pane-actions">
                    <button type="button" class="btn btn-ghost btn-sm" onclick="document.getElementById('repeat-input').value = '';">Clear</button>
                    <button type="button" class="btn btn-ghost btn-sm" onclick="document.getElementById('repeat-input').value = '🚀 WebToolsStation 2026'; runTextRepeater();">Sample</button>
                </div>
            </div>
            <textarea id="repeat-input" class="editor-textarea" placeholder="Enter string or pattern to multiply..." oninput="runTextRepeater()"></textarea>
        </div>

        <div class="pane-card">
            <div class="pane-header">
                <span>Multiplied Result</span>
                <div class="pane-actions">
                    <button type="button" class="btn btn-secondary btn-sm" onclick="copyOutput('repeat-output')">Copy</button>
                </div>
            </div>
            <textarea id="repeat-output" class="editor-textarea" readonly placeholder="Repeated text output..."></textarea>
        </div>
    </div>

@elseif ($tool['slug'] === 'tabs-to-spaces-converter')
    {{-- Tabs to Spaces --}}
    <div style="margin-bottom:12px; display:flex; gap:10px; align-items:center; flex-wrap:wrap;">
        <label for="tab-space-size" style="font-size:0.88rem; font-weight:600;">Tab Width:</label>
        <select id="tab-space-size" style="height:34px;" onchange="runTabsToSpaces('tabs-to-spaces')">
            <option value="2">2 Spaces</option>
            <option value="4" selected>4 Spaces</option>
            <option value="8">8 Spaces</option>
        </select>
        <button type="button" class="btn btn-primary btn-sm" onclick="runTabsToSpaces('tabs-to-spaces')">Tabs → Spaces</button>
        <button type="button" class="btn btn-secondary btn-sm" onclick="runTabsToSpaces('spaces-to-tabs')">Spaces → Tabs</button>
    </div>

    <div class="workspace-split">
        <div class="pane-card">
            <div class="pane-header">
                <span>Input Source</span>
                <div class="pane-actions">
                    <button type="button" class="btn btn-ghost btn-sm" onclick="document.getElementById('tab-space-input').value = '';">Clear</button>
                    <button type="button" class="btn btn-ghost btn-sm" onclick="document.getElementById('tab-space-input').value = '\tdef hello():\n\t\tprint(\"World\")'; runTabsToSpaces('tabs-to-spaces');">Sample</button>
                </div>
            </div>
            <textarea id="tab-space-input" class="editor-textarea" placeholder="Paste text or code with tabs or spaces..." oninput="runTabsToSpaces('tabs-to-spaces')"></textarea>
        </div>

        <div class="pane-card">
            <div class="pane-header">
                <span>Converted Output</span>
                <div class="pane-actions">
                    <button type="button" class="btn btn-secondary btn-sm" onclick="copyOutput('tab-space-output')">Copy</button>
                </div>
            </div>
            <textarea id="tab-space-output" class="editor-textarea" readonly placeholder="Converted indentation output..."></textarea>
        </div>
    </div>
@endif
