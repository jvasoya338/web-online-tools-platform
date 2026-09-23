@if (in_array($tool['slug'], ['python-formatter', 'php-formatter', 'java-formatter', 'csharp-formatter', 'cpp-formatter', 'go-formatter']))
    @php
        $langMap = [
            'python-formatter' => ['id' => 'python', 'name' => 'Python', 'fn' => 'runPythonFormatter', 'sample' => "def calculate_summary(items):\n total = 0\n for x in items:\n  if x > 0:\n   total += x\n return total"],
            'php-formatter' => ['id' => 'php', 'name' => 'PHP', 'fn' => 'runPhpFormatter', 'sample' => "<?php\nclass UserRepo {\npublic function find(\$id) {\nif (\$id <= 0) {\nreturn null;\n}\nreturn ['id' => \$id];\n}\n}"],
            'java-formatter' => ['id' => 'java', 'name' => 'Java', 'fn' => 'runJavaFormatter', 'sample' => "public class Main {\npublic static void main(String[] args) {\nfor (int i = 0; i < 5; i++) {\nSystem.out.println(i);\n}\n}\n}"],
            'csharp-formatter' => ['id' => 'csharp', 'name' => 'C#', 'fn' => 'runCsharpFormatter', 'sample' => "namespace WebTools {\npublic class AppService {\npublic void Start() {\nConsole.WriteLine(\"Running\");\n}\n}\n}"],
            'cpp-formatter' => ['id' => 'cpp', 'name' => 'C/C++', 'fn' => 'runCppFormatter', 'sample' => "#include <iostream>\nint main() {\nint val = 42;\nif (val > 0) {\nstd::cout << val << std::endl;\n}\nreturn 0;\n}"],
            'go-formatter' => ['id' => 'go', 'name' => 'Go', 'fn' => 'runGoFormatter', 'sample' => "package main\nimport \"fmt\"\nfunc main() {\nfmt.Println(\"Hello World\")\n}"],
        ];
        $conf = $langMap[$tool['slug']];
    @endphp

    <div style="margin-bottom:12px; display:flex; gap:10px; align-items:center;">
        <button type="button" class="btn btn-primary btn-sm" onclick="{{ $conf['fn'] }}()">Beautify {{ $conf['name'] }} Code</button>
    </div>

    <div class="workspace-split">
        <div class="pane-card">
            <div class="pane-header">
                <span>{{ $conf['name'] }} Source Input</span>
                <div class="pane-actions">
                    <button type="button" class="btn btn-ghost btn-sm" onclick="document.getElementById('{{ $conf['id'] }}-input').value = '';">Clear</button>
                    <button type="button" class="btn btn-ghost btn-sm" onclick="document.getElementById('{{ $conf['id'] }}-input').value = {{ json_encode($conf['sample']) }}; {{ $conf['fn'] }}();">Sample</button>
                </div>
            </div>
            <textarea id="{{ $conf['id'] }}-input" class="editor-textarea" placeholder="Paste {{ $conf['name'] }} code here..." oninput="{{ $conf['fn'] }}()"></textarea>
        </div>

        <div class="pane-card">
            <div class="pane-header">
                <span>Formatted {{ $conf['name'] }} Output</span>
                <div class="pane-actions">
                    <button type="button" class="btn btn-secondary btn-sm" onclick="copyOutput('{{ $conf['id'] }}-output')">Copy</button>
                </div>
            </div>
            <textarea id="{{ $conf['id'] }}-output" class="editor-textarea" readonly placeholder="Beautified {{ $conf['name'] }} code..."></textarea>
        </div>
    </div>

@elseif ($tool['slug'] === 'sql-minifier')
    {{-- SQL Minifier --}}
    <div style="margin-bottom:12px; display:flex; justify-content:space-between; align-items:center;">
        <button type="button" class="btn btn-primary btn-sm" onclick="runSqlMinifier()">Minify SQL Query</button>
        <div id="sql-min-stats" style="font-size:0.85rem; font-weight:700; color:var(--brand);">0 B → 0 B (0% reduction)</div>
    </div>

    <div class="workspace-split">
        <div class="pane-card">
            <div class="pane-header">
                <span>SQL Source Input</span>
                <div class="pane-actions">
                    <button type="button" class="btn btn-ghost btn-sm" onclick="document.getElementById('sql-min-input').value = '';">Clear</button>
                    <button type="button" class="btn btn-ghost btn-sm" onclick="document.getElementById('sql-min-input').value = '-- Get active users\nSELECT id, name, email\nFROM users\nWHERE status = \'active\'\n  AND created_at >= \'2026-01-01\'\nORDER BY id DESC;'; runSqlMinifier();">Sample</button>
                </div>
            </div>
            <textarea id="sql-min-input" class="editor-textarea" placeholder="Paste SQL query here..." oninput="runSqlMinifier()"></textarea>
        </div>

        <div class="pane-card">
            <div class="pane-header">
                <span>Minified SQL Query</span>
                <div class="pane-actions">
                    <button type="button" class="btn btn-secondary btn-sm" onclick="copyOutput('sql-min-output')">Copy SQL</button>
                </div>
            </div>
            <textarea id="sql-min-output" class="editor-textarea" readonly placeholder="Minified single-line SQL..."></textarea>
        </div>
    </div>

@elseif ($tool['slug'] === 'uuid-v7-generator')
    {{-- UUID v7 Generator --}}
    <div class="workspace-split">
        <div class="pane-card" style="padding:20px; gap:16px;">
            <div style="font-weight:700; font-size:0.92rem; color:var(--text); text-transform:uppercase; letter-spacing:0.04em; border-bottom:1px solid var(--border); padding-bottom:10px;">
                Generator Settings
            </div>

            <div>
                <label for="uuid7-count" style="display:block; font-size:0.88rem; font-weight:600; margin-bottom:6px;">Number of UUID v7 identifiers to generate (1 - 50):</label>
                <input id="uuid7-count" type="number" min="1" max="50" value="5" style="width:100%; height:40px; font-size:1rem;">
            </div>

            <div style="font-size:0.82rem; color:var(--text-muted); line-height:1.5;">
                UUID v7 (RFC 9562) embeds a 48-bit Unix millisecond timestamp at the front followed by CSPRNG randomness, creating naturally sortable IDs optimal for database indexing.
            </div>

            <button class="btn btn-primary btn-lg" style="margin-top:8px;" onclick="generateUuidV7List()">Generate UUID v7 List</button>
        </div>

        <div class="pane-card">
            <div class="pane-header">
                <span>Generated UUID v7 List</span>
                <div class="pane-actions">
                    <button type="button" class="btn btn-secondary btn-sm" onclick="copyOutput('uuid7-output')">Copy List</button>
                </div>
            </div>
            <pre id="uuid7-output" class="output-pre" style="flex:1; min-height:260px;" aria-label="Generated UUID v7 output"></pre>
        </div>
    </div>
@endif
