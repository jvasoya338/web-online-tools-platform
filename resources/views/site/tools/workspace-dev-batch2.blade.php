@if ($tool['slug'] === 'uuid-validator')
    {{-- UUID Validator --}}
    <div class="workspace-split">
        <div class="pane-card">
            <div class="pane-header">
                <span>UUID / GUID Input</span>
                <div class="pane-actions">
                    <button type="button" class="btn btn-ghost btn-sm" onclick="document.getElementById('uuid-val-input').value = '';">Clear</button>
                    <button type="button" class="btn btn-ghost btn-sm" onclick="document.getElementById('uuid-val-input').value = '550e8400-e29b-41d4-a716-446655440000'; runUuidValidator();">Sample</button>
                </div>
            </div>
            <textarea id="uuid-val-input" class="editor-textarea" placeholder="Paste UUID / GUID string (e.g. 550e8400-e29b-41d4-a716-446655440000)..." oninput="runUuidValidator()"></textarea>
        </div>

        <div class="pane-card">
            <div class="pane-header">
                <span>Version & Variant Diagnostics</span>
                <button type="button" class="btn btn-primary btn-sm" onclick="runUuidValidator()">Validate</button>
            </div>
            <div id="uuid-val-report" style="flex:1; padding:16px; background:#fafafa; border-radius:var(--radius-sm); border:1px solid var(--border);">
                <div style="color:var(--text-muted);">Paste UUID to inspect version, variant, and format validity.</div>
            </div>
        </div>
    </div>

@elseif ($tool['slug'] === 'env-file-parser-formatter')
    {{-- .env Formatter --}}
    <div style="margin-bottom:12px;">
        <button type="button" class="btn btn-primary btn-sm" onclick="runEnvFormatter()">Format & Sort .env Keys</button>
    </div>

    <div class="workspace-split">
        <div class="pane-card">
            <div class="pane-header">
                <span>.env File Input</span>
                <div class="pane-actions">
                    <button type="button" class="btn btn-ghost btn-sm" onclick="document.getElementById('env-input').value = '';">Clear</button>
                    <button type="button" class="btn btn-ghost btn-sm" onclick="document.getElementById('env-input').value = '# App Config\nAPP_NAME=WebToolsStation\nAPP_ENV=production\nDB_HOST=127.0.0.1\nAPP_PORT=8000\nCACHE_DRIVER=redis'; runEnvFormatter();">Sample</button>
                </div>
            </div>
            <textarea id="env-input" class="editor-textarea" placeholder="Paste .env content..." oninput="runEnvFormatter()"></textarea>
        </div>

        <div class="pane-card">
            <div class="pane-header">
                <span>Alphabetized & Formatted .env</span>
                <div class="pane-actions">
                    <button type="button" class="btn btn-secondary btn-sm" onclick="copyOutput('env-output')">Copy</button>
                </div>
            </div>
            <textarea id="env-output" class="editor-textarea" readonly placeholder="Sorted .env output..."></textarea>
        </div>
    </div>

@elseif ($tool['slug'] === 'curl-to-fetch-converter')
    {{-- cURL to Fetch --}}
    <div style="margin-bottom:12px;">
        <button type="button" class="btn btn-primary btn-sm" onclick="runCurlToFetch()">Convert cURL to JavaScript fetch()</button>
    </div>

    <div class="workspace-split">
        <div class="pane-card">
            <div class="pane-header">
                <span>cURL Command Input</span>
                <div class="pane-actions">
                    <button type="button" class="btn btn-ghost btn-sm" onclick="document.getElementById('curl-fetch-input').value = '';">Clear</button>
                    <button type="button" class="btn btn-ghost btn-sm" onclick="document.getElementById('curl-fetch-input').value = 'curl -X POST https://api.example.com/v1/users \\\n  -H \"Content-Type: application/json\" \\\n  -H \"Authorization: Bearer token_xyz\" \\\n  -d \'{\"name\":\"Alex Rivera\",\"role\":\"admin\"}\''; runCurlToFetch();">Sample</button>
                </div>
            </div>
            <textarea id="curl-fetch-input" class="editor-textarea" placeholder="Paste cURL command..." oninput="runCurlToFetch()"></textarea>
        </div>

        <div class="pane-card">
            <div class="pane-header">
                <span>JavaScript fetch() Code</span>
                <div class="pane-actions">
                    <button type="button" class="btn btn-secondary btn-sm" onclick="copyOutput('curl-fetch-output')">Copy JS</button>
                </div>
            </div>
            <textarea id="curl-fetch-output" class="editor-textarea" readonly placeholder="fetch() async/await snippet..."></textarea>
        </div>
    </div>

@elseif ($tool['slug'] === 'curl-to-python-converter')
    {{-- cURL to Python --}}
    <div style="margin-bottom:12px;">
        <button type="button" class="btn btn-primary btn-sm" onclick="runCurlToPython()">Convert cURL to Python Requests</button>
    </div>

    <div class="workspace-split">
        <div class="pane-card">
            <div class="pane-header">
                <span>cURL Command Input</span>
                <div class="pane-actions">
                    <button type="button" class="btn btn-ghost btn-sm" onclick="document.getElementById('curl-py-input').value = '';">Clear</button>
                    <button type="button" class="btn btn-ghost btn-sm" onclick="document.getElementById('curl-py-input').value = 'curl -X POST https://api.example.com/v1/auth \\\n  -H \"Content-Type: application/json\" \\\n  -d \'{\"email\":\"alex@test.com\",\"password\":\"secret\"}\''; runCurlToPython();">Sample</button>
                </div>
            </div>
            <textarea id="curl-py-input" class="editor-textarea" placeholder="Paste cURL command..." oninput="runCurlToPython()"></textarea>
        </div>

        <div class="pane-card">
            <div class="pane-header">
                <span>Python Requests Code</span>
                <div class="pane-actions">
                    <button type="button" class="btn btn-secondary btn-sm" onclick="copyOutput('curl-py-output')">Copy Python</button>
                </div>
            </div>
            <textarea id="curl-py-output" class="editor-textarea" readonly placeholder="Python requests snippet..."></textarea>
        </div>
    </div>

@elseif ($tool['slug'] === 'user-agent-parser')
    {{-- User-Agent Parser --}}
    <div class="workspace-split">
        <div class="pane-card">
            <div class="pane-header">
                <span>User-Agent String</span>
                <div class="pane-actions">
                    <button type="button" class="btn btn-secondary btn-sm" onclick="document.getElementById('ua-input').value = navigator.userAgent; runUserAgentParser();">Use Current Browser UA</button>
                </div>
            </div>
            <textarea id="ua-input" class="editor-textarea" placeholder="Paste User-Agent header string..." oninput="runUserAgentParser()"></textarea>
        </div>

        <div class="pane-card">
            <div class="pane-header">
                <span>Browser, OS & Device Breakdown</span>
                <button type="button" class="btn btn-primary btn-sm" onclick="runUserAgentParser()">Parse</button>
            </div>
            <div id="ua-report" style="flex:1; padding:16px; background:#fafafa; border-radius:var(--radius-sm); border:1px solid var(--border);">
                <div style="color:var(--text-muted);">Paste User-Agent string to inspect client parameters.</div>
            </div>
        </div>
    </div>

@elseif ($tool['slug'] === 'semver-validator-calculator')
    {{-- SemVer Calculator --}}
    <div class="workspace-split">
        <div class="pane-card" style="padding:20px; gap:14px;">
            <label for="semver-input" style="font-weight:700; font-size:0.92rem;">Current Semantic Version (SemVer 2.0.0):</label>
            <input type="text" id="semver-input" value="1.4.2-beta.1" style="font-family:var(--font-mono); font-size:1.1rem; height:42px;" oninput="runSemverCalculator()">
            <button type="button" class="btn btn-primary" onclick="runSemverCalculator()">Validate & Calculate Next Bumps</button>
        </div>

        <div class="pane-card">
            <div class="pane-header"><span>Release Increments</span></div>
            <div id="semver-report" style="flex:1; padding:16px; background:#fafafa; border-radius:var(--radius-sm); border:1px solid var(--border);"></div>
        </div>
    </div>

@elseif ($tool['slug'] === 'dockerfile-formatter')
    {{-- Dockerfile Formatter --}}
    <div style="margin-bottom:12px;">
        <button type="button" class="btn btn-primary btn-sm" onclick="runDockerfileFormatter()">Format Dockerfile</button>
    </div>

    <div class="workspace-split">
        <div class="pane-card">
            <div class="pane-header">
                <span>Dockerfile Source</span>
                <div class="pane-actions">
                    <button type="button" class="btn btn-ghost btn-sm" onclick="document.getElementById('docker-input').value = '';">Clear</button>
                    <button type="button" class="btn btn-ghost btn-sm" onclick="document.getElementById('docker-input').value = 'from node:20-alpine\nworkdir /app\ncopy package*.json ./\nrun npm install\ncopy . .\nexpose 3000\ncmd [\"npm\", \"start\"]'; runDockerfileFormatter();">Sample</button>
                </div>
            </div>
            <textarea id="docker-input" class="editor-textarea" placeholder="Paste Dockerfile..." oninput="runDockerfileFormatter()"></textarea>
        </div>

        <div class="pane-card">
            <div class="pane-header">
                <span>Formatted Dockerfile</span>
                <div class="pane-actions">
                    <button type="button" class="btn btn-secondary btn-sm" onclick="copyOutput('docker-output')">Copy</button>
                </div>
            </div>
            <textarea id="docker-output" class="editor-textarea" readonly placeholder="Formatted Dockerfile..."></textarea>
        </div>
    </div>
@endif
