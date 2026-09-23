@if ($tool['slug'] === 'markdown-table-generator')
    {{-- Markdown Table Generator --}}
    <div style="margin-bottom:12px; display:flex; gap:10px; align-items:center; flex-wrap:wrap;">
        <label for="md-table-rows" style="font-size:0.88rem; font-weight:600;">Rows:</label>
        <input type="number" id="md-table-rows" value="4" min="1" max="50" style="width:70px; height:34px;" oninput="runMarkdownTableGenerator()">
        <label for="md-table-cols" style="font-size:0.88rem; font-weight:600;">Columns:</label>
        <input type="number" id="md-table-cols" value="3" min="1" max="20" style="width:70px; height:34px;" oninput="runMarkdownTableGenerator()">
        <button type="button" class="btn btn-primary btn-sm" onclick="runMarkdownTableGenerator()">Generate GFM Table</button>
    </div>

    <div class="workspace-split">
        <div class="pane-card">
            <div class="pane-header">
                <span>Generated Markdown Table Syntax</span>
                <div class="pane-actions">
                    <button type="button" class="btn btn-secondary btn-sm" onclick="copyOutput('md-table-output')">Copy Markdown</button>
                </div>
            </div>
            <textarea id="md-table-output" class="editor-textarea" style="height:320px;" placeholder="Markdown table syntax will generate here..."></textarea>
        </div>
    </div>

@elseif (in_array($tool['slug'], ['base32-encode-decode', 'base58-encode-decode', 'base85-encode-decode', 'hex-string-encode-decode', 'octal-to-text-converter', 'punycode-converter']))
    @php
        $encConf = [
            'base32-encode-decode' => ['id' => 'b32', 'name' => 'Base32', 'fn' => 'runBase32', 'sample' => 'WebToolsStation 2026'],
            'base58-encode-decode' => ['id' => 'b58', 'name' => 'Base58', 'fn' => 'runBase58', 'sample' => '1A1zP1eP5QGefi2DMPTfTL5SLmv7DivfNa'],
            'base85-encode-decode' => ['id' => 'b85', 'name' => 'Base85', 'fn' => 'runBase85', 'sample' => 'WebToolsStation high-performance online utilities.'],
            'hex-string-encode-decode' => ['id' => 'hex-str', 'name' => 'Hex Bytes', 'fn' => 'runHexString', 'sample' => 'Hello World!'],
            'octal-to-text-converter' => ['id' => 'octal', 'name' => 'Octal', 'fn' => 'runOctalText', 'sample' => 'WebTools'],
            'punycode-converter' => ['id' => 'punycode', 'name' => 'Punycode', 'fn' => 'runPunycode', 'sample' => 'münchen.de'],
        ][$tool['slug']];
    @endphp

    <div style="margin-bottom:12px; display:flex; gap:10px; align-items:center;">
        <button type="button" class="btn btn-primary btn-sm" onclick="{{ $encConf['fn'] }}('encode')">Encode to {{ $encConf['name'] }}</button>
        <button type="button" class="btn btn-secondary btn-sm" onclick="{{ $encConf['fn'] }}('decode')">Decode {{ $encConf['name'] }}</button>
    </div>

    <div class="workspace-split">
        <div class="pane-card">
            <div class="pane-header">
                <span>Input Data</span>
                <div class="pane-actions">
                    <button type="button" class="btn btn-ghost btn-sm" onclick="document.getElementById('{{ $encConf['id'] }}-input').value = '';">Clear</button>
                    <button type="button" class="btn btn-ghost btn-sm" onclick="document.getElementById('{{ $encConf['id'] }}-input').value = {{ json_encode($encConf['sample']) }}; {{ $encConf['fn'] }}('encode');">Sample</button>
                </div>
            </div>
            <textarea id="{{ $encConf['id'] }}-input" class="editor-textarea" placeholder="Enter string to encode or decode..." oninput="{{ $encConf['fn'] }}('encode')"></textarea>
        </div>

        <div class="pane-card">
            <div class="pane-header">
                <span>{{ $encConf['name'] }} Output</span>
                <div class="pane-actions">
                    <button type="button" class="btn btn-secondary btn-sm" onclick="copyOutput('{{ $encConf['id'] }}-output')">Copy</button>
                </div>
            </div>
            <textarea id="{{ $encConf['id'] }}-output" class="editor-textarea" readonly placeholder="Result..."></textarea>
        </div>
    </div>

@elseif ($tool['slug'] === 'ascii-to-decimal-converter')
    {{-- ASCII to Decimal --}}
    <div class="workspace-split">
        <div class="pane-card">
            <div class="pane-header">
                <span>Text String</span>
                <div class="pane-actions">
                    <button type="button" class="btn btn-ghost btn-sm" onclick="document.getElementById('ascii-dec-input').value = ''; runAsciiDecimal();">Clear</button>
                    <button type="button" class="btn btn-ghost btn-sm" onclick="document.getElementById('ascii-dec-input').value = 'WebTools'; runAsciiDecimal();">Sample</button>
                </div>
            </div>
            <textarea id="ascii-dec-input" class="editor-textarea" placeholder="Type text to inspect decimal ASCII codes..." oninput="runAsciiDecimal()"></textarea>
        </div>

        <div class="pane-card">
            <div class="pane-header"><span>ASCII Decimal Lookup Table</span></div>
            <div style="flex:1; overflow-y:auto; max-height:260px; border:1px solid var(--border); border-radius:var(--radius-sm);">
                <table style="width:100%; border-collapse:collapse; font-size:0.85rem;">
                    <thead style="position:sticky; top:0; background:var(--surface-subtle);">
                        <tr style="border-bottom:2px solid var(--border); text-align:left;">
                            <th style="padding:8px 12px;">Char</th>
                            <th style="padding:8px 12px;">Decimal</th>
                            <th style="padding:8px 12px;">Hex</th>
                            <th style="padding:8px 12px;">Binary</th>
                        </tr>
                    </thead>
                    <tbody id="ascii-dec-table">
                        <tr><td colspan="4" style="text-align:center; padding:16px; color:var(--text-muted);">Enter text on the left to inspect ASCII codes.</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@elseif ($tool['slug'] === 'rot13-encoder-decoder')
    {{-- ROT13 / Caesar Cipher --}}
    <div style="margin-bottom:12px; display:flex; gap:10px; align-items:center;">
        <label for="rot13-shift" style="font-size:0.88rem; font-weight:600;">Shift Rotation (1-25):</label>
        <input type="number" id="rot13-shift" value="13" min="1" max="25" style="width:70px; height:32px;" oninput="runRot13()">
        <button type="button" class="btn btn-primary btn-sm" onclick="runRot13()">Apply Cipher</button>
    </div>

    <div class="workspace-split">
        <div class="pane-card">
            <div class="pane-header">
                <span>Input Text</span>
                <div class="pane-actions">
                    <button type="button" class="btn btn-ghost btn-sm" onclick="document.getElementById('rot13-input').value = '';">Clear</button>
                    <button type="button" class="btn btn-ghost btn-sm" onclick="document.getElementById('rot13-input').value = 'Why did the developer cross the road? To get to the other IDE!'; runRot13();">Sample</button>
                </div>
            </div>
            <textarea id="rot13-input" class="editor-textarea" placeholder="Paste text..." oninput="runRot13()"></textarea>
        </div>

        <div class="pane-card">
            <div class="pane-header">
                <span>Cipher Output</span>
                <div class="pane-actions">
                    <button type="button" class="btn btn-secondary btn-sm" onclick="copyOutput('rot13-output')">Copy</button>
                </div>
            </div>
            <textarea id="rot13-output" class="editor-textarea" readonly placeholder="Cipher output..."></textarea>
        </div>
    </div>

@elseif ($tool['slug'] === 'morse-code-translator')
    {{-- Morse Code Translator --}}
    <div style="margin-bottom:12px; display:flex; gap:10px; align-items:center;">
        <button type="button" class="btn btn-primary btn-sm" onclick="runMorseCode('encode')">Text → Morse</button>
        <button type="button" class="btn btn-secondary btn-sm" onclick="runMorseCode('decode')">Morse → Text</button>
    </div>

    <div class="workspace-split">
        <div class="pane-card">
            <div class="pane-header">
                <span>Source Input</span>
                <div class="pane-actions">
                    <button type="button" class="btn btn-ghost btn-sm" onclick="document.getElementById('morse-input').value = '';">Clear</button>
                    <button type="button" class="btn btn-ghost btn-sm" onclick="document.getElementById('morse-input').value = 'SOS WEB TOOLS'; runMorseCode('encode');">Sample</button>
                </div>
            </div>
            <textarea id="morse-input" class="editor-textarea" placeholder="Enter text (e.g. SOS) or Morse dots/dashes (e.g. ... --- ...)..." oninput="runMorseCode('encode')"></textarea>
        </div>

        <div class="pane-card">
            <div class="pane-header">
                <span>Morse Output</span>
                <div class="pane-actions">
                    <button type="button" class="btn btn-secondary btn-sm" onclick="copyOutput('morse-output')">Copy</button>
                </div>
            </div>
            <textarea id="morse-output" class="editor-textarea" readonly placeholder="Translated Morse code..."></textarea>
        </div>
    </div>

@elseif ($tool['slug'] === 'data-uri-generator')
    {{-- Data URI Generator --}}
    <div style="margin-bottom:12px; display:flex; gap:10px; align-items:center;">
        <label for="datauri-mime" style="font-size:0.88rem; font-weight:600;">MIME Type:</label>
        <select id="datauri-mime" style="height:32px;" onchange="runDataUri()">
            <option value="text/plain" selected>text/plain</option>
            <option value="text/html">text/html</option>
            <option value="text/css">text/css</option>
            <option value="application/json">application/json</option>
            <option value="image/svg+xml">image/svg+xml</option>
        </select>
        <button type="button" class="btn btn-primary btn-sm" onclick="runDataUri()">Generate Data URI</button>
    </div>

    <div class="workspace-split">
        <div class="pane-card">
            <div class="pane-header">
                <span>Payload Content</span>
                <div class="pane-actions">
                    <button type="button" class="btn btn-ghost btn-sm" onclick="document.getElementById('datauri-input').value = '';">Clear</button>
                    <button type="button" class="btn btn-ghost btn-sm" onclick="document.getElementById('datauri-input').value = '<h1>Hello WebToolsStation</h1>'; runDataUri();">Sample</button>
                </div>
            </div>
            <textarea id="datauri-input" class="editor-textarea" placeholder="Paste HTML, CSS, SVG, or plain text..." oninput="runDataUri()"></textarea>
        </div>

        <div class="pane-card">
            <div class="pane-header">
                <span>Data URI Output</span>
                <div class="pane-actions">
                    <button type="button" class="btn btn-secondary btn-sm" onclick="copyOutput('datauri-output')">Copy Data URI</button>
                </div>
            </div>
            <textarea id="datauri-output" class="editor-textarea" readonly placeholder="data:text/html;charset=utf-8;base64,..."></textarea>
        </div>
    </div>
@endif
