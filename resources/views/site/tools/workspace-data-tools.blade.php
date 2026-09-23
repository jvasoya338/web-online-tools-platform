@if ($tool['slug'] === 'json-tree-viewer')
    {{-- JSON Tree Viewer --}}
    <div class="workspace-split">
        <div class="pane-card">
            <div class="pane-header">
                <span>JSON Input</span>
                <div class="pane-actions">
                    <button type="button" class="btn btn-ghost btn-sm" onclick="document.getElementById('json-tree-input').value = ''; renderJsonTreeViewer();">Clear</button>
                    <button type="button" class="btn btn-ghost btn-sm" onclick="document.getElementById('json-tree-input').value = JSON.stringify({app:'WebToolsStation',version:2.1,features:['local-processing','zero-uploads'],meta:{authors:['Alex','Engineering'],active:true}}, null, 2); renderJsonTreeViewer();">Sample</button>
                </div>
            </div>
            <textarea id="json-tree-input" class="editor-textarea" placeholder="Paste JSON here to render visual tree..." oninput="renderJsonTreeViewer()"></textarea>
        </div>

        <div class="pane-card">
            <div class="pane-header">
                <span>Interactive Node Tree</span>
                <div class="pane-actions">
                    <span id="json-tree-stats" style="font-size:0.8rem; font-weight:700; color:var(--brand);">0 nodes</span>
                </div>
            </div>
            <div id="json-tree-container" style="flex:1; min-height:260px; overflow-y:auto; padding:12px; background:#fafafa; border-radius:var(--radius-sm); border:1px solid var(--border);">
                <div style="color:var(--text-muted); text-align:center; padding:20px;">Paste valid JSON on the left to render interactive tree.</div>
            </div>
        </div>
    </div>

@elseif ($tool['slug'] === 'json-path-finder')
    {{-- JSONPath Evaluator --}}
    <div style="margin-bottom:12px; padding:12px 16px; background:var(--surface-subtle); border:1px solid var(--border); border-radius:var(--radius-md); display:flex; gap:10px; align-items:center;">
        <label for="jsonpath-query" style="font-size:0.88rem; font-weight:700; color:var(--text);">JSONPath:</label>
        <input type="text" id="jsonpath-query" value="$.store.book[*].title" style="flex:1; font-family:var(--font-mono); height:36px;" placeholder="e.g. $.store.book[*].author" oninput="runJsonPathFinder()">
        <button type="button" class="btn btn-primary btn-sm" onclick="runJsonPathFinder()">Query</button>
        <span id="jsonpath-match-count" style="font-size:0.82rem; font-weight:700; color:var(--brand); white-space:nowrap;">0 matches</span>
    </div>

    <div class="workspace-split">
        <div class="pane-card">
            <div class="pane-header">
                <span>Source JSON</span>
                <div class="pane-actions">
                    <button type="button" class="btn btn-ghost btn-sm" onclick="document.getElementById('jsonpath-input').value = ''; runJsonPathFinder();">Clear</button>
                    <button type="button" class="btn btn-ghost btn-sm" onclick="document.getElementById('jsonpath-input').value = JSON.stringify({store:{book:[{title:'The Pragmatic Programmer',author:'Andy Hunt',price:42},{title:'Clean Code',author:'Robert Martin',price:38}]}}, null, 2); runJsonPathFinder();">Sample</button>
                </div>
            </div>
            <textarea id="jsonpath-input" class="editor-textarea" placeholder="Paste source JSON here..." oninput="runJsonPathFinder()"></textarea>
        </div>

        <div class="pane-card">
            <div class="pane-header">
                <span>Query Result</span>
                <div class="pane-actions">
                    <button type="button" class="btn btn-secondary btn-sm" onclick="copyOutput('jsonpath-output')">Copy Result</button>
                </div>
            </div>
            <textarea id="jsonpath-output" class="editor-textarea" readonly placeholder="Matched nodes will appear here..."></textarea>
        </div>
    </div>

@elseif ($tool['slug'] === 'json-flatten-unflatten')
    {{-- JSON Flatten & Unflatten --}}
    <div style="margin-bottom:12px; display:flex; gap:10px; align-items:center; flex-wrap:wrap;">
        <label for="json-flat-delim" style="font-size:0.88rem; font-weight:600;">Key Delimiter:</label>
        <select id="json-flat-delim" style="height:34px; padding:0 8px; border:1px solid var(--border); border-radius:var(--radius-sm);" onchange="runJsonFlatten('flatten')">
            <option value="." selected>Dot ( . )</option>
            <option value="/">Slash ( / )</option>
            <option value="_">Underscore ( _ )</option>
        </select>
        <button type="button" class="btn btn-primary btn-sm" onclick="runJsonFlatten('flatten')">Flatten to Dot-Notation</button>
        <button type="button" class="btn btn-secondary btn-sm" onclick="runJsonFlatten('unflatten')">Unflatten to Hierarchy</button>
    </div>

    <div class="workspace-split">
        <div class="pane-card">
            <div class="pane-header">
                <span>Input JSON</span>
                <div class="pane-actions">
                    <button type="button" class="btn btn-ghost btn-sm" onclick="document.getElementById('json-flat-input').value = '';">Clear</button>
                    <button type="button" class="btn btn-ghost btn-sm" onclick="document.getElementById('json-flat-input').value = JSON.stringify({user:{name:'Alex',contact:{email:'alex@webtools.test',city:'San Francisco'}}}, null, 2); runJsonFlatten('flatten');">Sample</button>
                </div>
            </div>
            <textarea id="json-flat-input" class="editor-textarea" placeholder="Paste JSON here..." oninput="runJsonFlatten('flatten')"></textarea>
        </div>

        <div class="pane-card">
            <div class="pane-header">
                <span>Flattened / Unflattened Output</span>
                <div class="pane-actions">
                    <button type="button" class="btn btn-secondary btn-sm" onclick="copyOutput('json-flat-output')">Copy</button>
                </div>
            </div>
            <textarea id="json-flat-output" class="editor-textarea" readonly placeholder="Transformed JSON output..."></textarea>
        </div>
    </div>

@elseif ($tool['slug'] === 'json-key-sorter')
    {{-- JSON Key Sorter --}}
    <div style="margin-bottom:12px; display:flex; gap:10px; align-items:center;">
        <button type="button" class="btn btn-primary btn-sm" onclick="runJsonKeySorter('asc')">Sort Keys A → Z</button>
        <button type="button" class="btn btn-secondary btn-sm" onclick="runJsonKeySorter('desc')">Sort Keys Z → A</button>
    </div>

    <div class="workspace-split">
        <div class="pane-card">
            <div class="pane-header">
                <span>Input JSON</span>
                <div class="pane-actions">
                    <button type="button" class="btn btn-ghost btn-sm" onclick="document.getElementById('json-sort-input').value = '';">Clear</button>
                    <button type="button" class="btn btn-ghost btn-sm" onclick="document.getElementById('json-sort-input').value = JSON.stringify({zebra:1,apple:2,mango:{color:'yellow',taste:'sweet',origin:'India'},banana:3}, null, 2); runJsonKeySorter('asc');">Sample</button>
                </div>
            </div>
            <textarea id="json-sort-input" class="editor-textarea" placeholder="Paste JSON here..." oninput="runJsonKeySorter('asc')"></textarea>
        </div>

        <div class="pane-card">
            <div class="pane-header">
                <span>Sorted JSON Output</span>
                <div class="pane-actions">
                    <button type="button" class="btn btn-secondary btn-sm" onclick="copyOutput('json-sort-output')">Copy</button>
                </div>
            </div>
            <textarea id="json-sort-output" class="editor-textarea" readonly placeholder="Alphabetized JSON output..."></textarea>
        </div>
    </div>

@elseif ($tool['slug'] === 'json-schema-generator')
    {{-- JSON Schema Generator --}}
    <div class="workspace-split">
        <div class="pane-card">
            <div class="pane-header">
                <span>Sample JSON Input</span>
                <div class="pane-actions">
                    <button type="button" class="btn btn-ghost btn-sm" onclick="document.getElementById('schema-gen-input').value = '';">Clear</button>
                    <button type="button" class="btn btn-ghost btn-sm" onclick="document.getElementById('schema-gen-input').value = JSON.stringify({id:101,name:'Jane Doe',email:'jane@example.com',isActive:true,tags:['developer','admin']}, null, 2); runJsonSchemaGenerator();">Sample</button>
                </div>
            </div>
            <textarea id="schema-gen-input" class="editor-textarea" placeholder="Paste sample JSON payload..." oninput="runJsonSchemaGenerator()"></textarea>
        </div>

        <div class="pane-card">
            <div class="pane-header">
                <span>Generated JSON Schema (Draft-07)</span>
                <div class="pane-actions">
                    <button type="button" class="btn btn-secondary btn-sm" onclick="copyOutput('schema-gen-output')">Copy Schema</button>
                </div>
            </div>
            <textarea id="schema-gen-output" class="editor-textarea" readonly placeholder="Inferred JSON Schema..."></textarea>
        </div>
    </div>

@elseif ($tool['slug'] === 'json-schema-validator')
    {{-- JSON Schema Validator --}}
    <div class="workspace-split">
        <div class="pane-card">
            <div class="pane-header"><span>JSON Payload</span></div>
            <textarea id="schema-val-json" class="editor-textarea" style="height:140px;" placeholder="Paste JSON instance..." oninput="runJsonSchemaValidator()"></textarea>
            <div class="pane-header" style="border-top:1px solid var(--border); margin-top:8px;"><span>JSON Schema Definition</span></div>
            <textarea id="schema-val-schema" class="editor-textarea" style="height:140px;" placeholder="Paste JSON Schema specification..." oninput="runJsonSchemaValidator()"></textarea>
        </div>

        <div class="pane-card">
            <div class="pane-header">
                <span>Validation Diagnostics</span>
                <button type="button" class="btn btn-primary btn-sm" onclick="runJsonSchemaValidator()">Validate</button>
            </div>
            <div id="schema-val-status" style="padding:16px; flex:1; background:#fafafa; border-radius:var(--radius-sm); border:1px solid var(--border);">
                <div style="color:var(--text-muted);">Paste JSON and Schema on the left to run validation.</div>
            </div>
        </div>
    </div>

@elseif ($tool['slug'] === 'jsonlines-validator-formatter')
    {{-- JSONL / NDJSON Validator --}}
    <div style="margin-bottom:12px; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px;">
        <div style="display:flex; gap:8px;">
            <button type="button" class="btn btn-primary btn-sm" onclick="runJsonLinesTool('validate')">Validate & Format</button>
            <button type="button" class="btn btn-secondary btn-sm" onclick="runJsonLinesTool('minify')">Compact Minify</button>
        </div>
        <div id="jsonl-stats" style="font-size:0.85rem;"></div>
    </div>

    <div class="workspace-split">
        <div class="pane-card">
            <div class="pane-header">
                <span>JSONL / NDJSON Input</span>
                <div class="pane-actions">
                    <button type="button" class="btn btn-ghost btn-sm" onclick="document.getElementById('jsonl-input').value = '';">Clear</button>
                    <button type="button" class="btn btn-ghost btn-sm" onclick="document.getElementById('jsonl-input').value = '{\"id\":1,\"event\":\"login\",\"user\":\"alex\"}\n{\"id\":2,\"event\":\"click\",\"btn\":\"cta\"}\n{\"id\":3,\"event\":\"logout\"}'; runJsonLinesTool('validate');">Sample</button>
                </div>
            </div>
            <textarea id="jsonl-input" class="editor-textarea" placeholder="Paste newline-delimited JSON..." oninput="runJsonLinesTool('validate')"></textarea>
        </div>

        <div class="pane-card">
            <div class="pane-header">
                <span>Formatted Output</span>
                <div class="pane-actions">
                    <button type="button" class="btn btn-secondary btn-sm" onclick="copyOutput('jsonl-output')">Copy</button>
                </div>
            </div>
            <textarea id="jsonl-output" class="editor-textarea" readonly placeholder="Output will appear here..."></textarea>
        </div>
    </div>

@elseif ($tool['slug'] === 'csv-validator')
    {{-- CSV Validator --}}
    <div class="workspace-split">
        <div class="pane-card">
            <div class="pane-header">
                <span>CSV Input</span>
                <div class="pane-actions">
                    <button type="button" class="btn btn-ghost btn-sm" onclick="document.getElementById('csv-val-input').value = '';">Clear</button>
                    <button type="button" class="btn btn-ghost btn-sm" onclick="document.getElementById('csv-val-input').value = 'name,role,department\nAlex Rivera,Engineering,Tech Lead\nTaylor Chen,Design,Product\nJordan Smith,Data,Analyst'; runCsvValidator();">Sample</button>
                </div>
            </div>
            <textarea id="csv-val-input" class="editor-textarea" placeholder="Paste CSV dataset..." oninput="runCsvValidator()"></textarea>
        </div>

        <div class="pane-card">
            <div class="pane-header">
                <span>RFC 4180 Compliance Report</span>
                <button type="button" class="btn btn-primary btn-sm" onclick="runCsvValidator()">Run Audit</button>
            </div>
            <div id="csv-val-report" style="padding:16px; flex:1; background:#fafafa; border-radius:var(--radius-sm); border:1px solid var(--border);">
                <div style="color:var(--text-muted);">Paste CSV to audit RFC 4180 conformity.</div>
            </div>
        </div>
    </div>

@elseif ($tool['slug'] === 'csv-column-extractor')
    {{-- CSV Column Extractor --}}
    <div style="margin-bottom:12px; display:flex; gap:10px; align-items:center; flex-wrap:wrap;">
        <label for="csv-extract-cols" style="font-size:0.88rem; font-weight:600;">Columns to Extract (1-based indices, comma-separated):</label>
        <input type="text" id="csv-extract-cols" value="1, 3" style="width:120px; height:34px; font-family:var(--font-mono);" oninput="runCsvColumnExtractor()">
        <button type="button" class="btn btn-primary btn-sm" onclick="runCsvColumnExtractor()">Extract</button>
    </div>

    <div class="workspace-split">
        <div class="pane-card">
            <div class="pane-header">
                <span>Full CSV Input</span>
                <div class="pane-actions">
                    <button type="button" class="btn btn-ghost btn-sm" onclick="document.getElementById('csv-extract-input').value = '';">Clear</button>
                    <button type="button" class="btn btn-ghost btn-sm" onclick="document.getElementById('csv-extract-input').value = 'id,first_name,last_name,email,role\n1,Alex,Rivera,alex@test.com,Admin\n2,Taylor,Chen,taylor@test.com,Editor\n3,Jordan,Smith,jordan@test.com,Viewer'; runCsvColumnExtractor();">Sample</button>
                </div>
            </div>
            <textarea id="csv-extract-input" class="editor-textarea" placeholder="Paste CSV..." oninput="runCsvColumnExtractor()"></textarea>
        </div>

        <div class="pane-card">
            <div class="pane-header">
                <span>Extracted Columns</span>
                <div class="pane-actions">
                    <button type="button" class="btn btn-secondary btn-sm" onclick="copyOutput('csv-extract-output')">Copy</button>
                </div>
            </div>
            <textarea id="csv-extract-output" class="editor-textarea" readonly placeholder="Extracted CSV columns..."></textarea>
        </div>
    </div>

@elseif ($tool['slug'] === 'csv-to-sql-converter')
    {{-- CSV to SQL Insert Converter --}}
    <div style="margin-bottom:12px; display:flex; gap:10px; align-items:center; flex-wrap:wrap;">
        <label for="csv-sql-table" style="font-size:0.88rem; font-weight:600;">Target Table Name:</label>
        <input type="text" id="csv-sql-table" value="users" style="width:180px; height:34px;" oninput="runCsvToSqlConverter()">
        <button type="button" class="btn btn-primary btn-sm" onclick="runCsvToSqlConverter()">Generate SQL</button>
    </div>

    <div class="workspace-split">
        <div class="pane-card">
            <div class="pane-header">
                <span>CSV Input (Header + Rows)</span>
                <div class="pane-actions">
                    <button type="button" class="btn btn-ghost btn-sm" onclick="document.getElementById('csv-sql-input').value = '';">Clear</button>
                    <button type="button" class="btn btn-ghost btn-sm" onclick="document.getElementById('csv-sql-input').value = 'name,email,role\nAlex Rivera,alex@example.com,developer\nTaylor Chen,taylor@example.com,designer'; runCsvToSqlConverter();">Sample</button>
                </div>
            </div>
            <textarea id="csv-sql-input" class="editor-textarea" placeholder="Paste CSV..." oninput="runCsvToSqlConverter()"></textarea>
        </div>

        <div class="pane-card">
            <div class="pane-header">
                <span>SQL Statements</span>
                <div class="pane-actions">
                    <button type="button" class="btn btn-secondary btn-sm" onclick="copyOutput('csv-sql-output')">Copy SQL</button>
                </div>
            </div>
            <textarea id="csv-sql-output" class="editor-textarea" readonly placeholder="SQL CREATE and INSERT queries..."></textarea>
        </div>
    </div>

@elseif ($tool['slug'] === 'toml-formatter-validator')
    {{-- TOML Formatter & Validator --}}
    <div style="margin-bottom:12px; display:flex; justify-content:space-between; align-items:center;">
        <button type="button" class="btn btn-primary btn-sm" onclick="runTomlFormatterValidator()">Format & Validate TOML</button>
        <div id="toml-status" style="font-size:0.85rem;"></div>
    </div>

    <div class="workspace-split">
        <div class="pane-card">
            <div class="pane-header">
                <span>TOML Input</span>
                <div class="pane-actions">
                    <button type="button" class="btn btn-ghost btn-sm" onclick="document.getElementById('toml-input').value = '';">Clear</button>
                    <button type="button" class="btn btn-ghost btn-sm" onclick="document.getElementById('toml-input').value = '[package]\nname = \"webtools\"\nversion = \"2.1.0\"\nauthors = [\"Alex\"]\n\n[dependencies]\nserde = \"1.0\"'; runTomlFormatterValidator();">Sample</button>
                </div>
            </div>
            <textarea id="toml-input" class="editor-textarea" placeholder="Paste TOML markup..." oninput="runTomlFormatterValidator()"></textarea>
        </div>

        <div class="pane-card">
            <div class="pane-header">
                <span>Formatted TOML Output</span>
                <div class="pane-actions">
                    <button type="button" class="btn btn-secondary btn-sm" onclick="copyOutput('toml-output')">Copy</button>
                </div>
            </div>
            <textarea id="toml-output" class="editor-textarea" readonly placeholder="Formatted TOML..."></textarea>
        </div>
    </div>

@elseif ($tool['slug'] === 'toml-to-json-converter')
    {{-- TOML to JSON Converter --}}
    <div style="margin-bottom:12px;">
        <button type="button" class="btn btn-primary btn-sm" onclick="runTomlToJsonConverter()">Convert TOML to JSON</button>
    </div>

    <div class="workspace-split">
        <div class="pane-card">
            <div class="pane-header">
                <span>TOML Input</span>
                <div class="pane-actions">
                    <button type="button" class="btn btn-ghost btn-sm" onclick="document.getElementById('toml-json-input').value = '';">Clear</button>
                    <button type="button" class="btn btn-ghost btn-sm" onclick="document.getElementById('toml-json-input').value = '[server]\nhost = \"127.0.0.1\"\nport = 8080\nenabled = true\n\n[database]\nname = \"webtools\"\npool = 10'; runTomlToJsonConverter();">Sample</button>
                </div>
            </div>
            <textarea id="toml-json-input" class="editor-textarea" placeholder="Paste TOML..." oninput="runTomlToJsonConverter()"></textarea>
        </div>

        <div class="pane-card">
            <div class="pane-header">
                <span>JSON Output</span>
                <div class="pane-actions">
                    <button type="button" class="btn btn-secondary btn-sm" onclick="copyOutput('toml-json-output')">Copy JSON</button>
                </div>
            </div>
            <textarea id="toml-json-output" class="editor-textarea" readonly placeholder="Converted JSON..."></textarea>
        </div>
    </div>
@endif
