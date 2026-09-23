{{-- Batch 5 AI Developer Tools Workspace Partials --}}

{{-- 95. AI Token Counter --}}
@if($tool['slug'] === 'ai-token-counter')
    <div class="form-group mb-3">
        <label class="form-label" for="ai-token-input"><strong>Prompt Text / LLM Context:</strong></label>
        <textarea id="ai-token-input" class="form-control font-monospace" rows="8" placeholder="Paste your system prompt, context documents, or conversational instructions here...">You are an advanced software architect. Your task is to design a high-throughput, privacy-first web application that executes all data processing client-side in the browser using WebAssembly and Web Workers. Ensure strict separation of concerns, zero network leakage, and robust unit test coverage.</textarea>
    </div>
    <div class="d-flex flex-wrap gap-2 mb-3">
        <button type="button" class="btn btn-primary" onclick="runAiTokenCounter()">Calculate Tokens & Costs</button>
        <button type="button" class="btn btn-secondary" onclick="document.getElementById('ai-token-input').value=''; setOutput('');">Clear</button>
    </div>
@endif

{{-- 96. AI Prompt Diff Checker --}}
@if($tool['slug'] === 'ai-prompt-diff-checker')
    <div class="row g-3 mb-3">
        <div class="col-md-6">
            <label class="form-label" for="prompt-v1"><strong>Prompt Version 1 (Baseline):</strong></label>
            <textarea id="prompt-v1" class="form-control font-monospace" rows="8" placeholder="Version 1 prompt...">You are a helpful coding assistant. Answer questions clearly with code examples.</textarea>
        </div>
        <div class="col-md-6">
            <label class="form-label" for="prompt-v2"><strong>Prompt Version 2 (Iterated):</strong></label>
            <textarea id="prompt-v2" class="form-control font-monospace" rows="8" placeholder="Version 2 prompt...">You are an expert senior software engineer. Answer technical questions concisely. Always include type hints, docstrings, and comprehensive error handling in your code examples.</textarea>
        </div>
    </div>
    <div class="d-flex flex-wrap gap-2 mb-3">
        <button type="button" class="btn btn-primary" onclick="runAiPromptDiff()">Compare Prompt Iterations</button>
        <button type="button" class="btn btn-secondary" onclick="copyOutput()">Copy Diff Report</button>
    </div>
@endif

{{-- 97. Fine-Tuning JSONL Validator --}}
@if($tool['slug'] === 'fine-tuning-jsonl-validator')
    <div class="form-group mb-3">
        <label class="form-label" for="jsonl-input"><strong>Fine-Tuning Dataset Lines (JSON Lines / .jsonl format):</strong></label>
        <textarea id="jsonl-input" class="form-control font-monospace" rows="8" placeholder='{"messages": [{"role": "system", "content": "You are a math tutor."}, {"role": "user", "content": "What is 7x8?"}, {"role": "assistant", "content": "7 multiplied by 8 is 56."}]}'>{"messages": [{"role": "system", "content": "You are a code formatter specialized in JSON and YAML."}, {"role": "user", "content": "Format: {a:1}"}, {"role": "assistant", "content": "{\n  \"a\": 1\n}"}]}
{"messages": [{"role": "system", "content": "You are a helpful assistant."}, {"role": "user", "content": "Explain Base64 in one sentence."}, {"role": "assistant", "content": "Base64 is a binary-to-text encoding scheme that represents binary data in an ASCII string format."}]}</textarea>
    </div>
    <div class="d-flex flex-wrap gap-2 mb-3">
        <button type="button" class="btn btn-primary" onclick="runFineTuningJsonlValidator()">Validate Dataset Schema</button>
        <button type="button" class="btn btn-secondary" onclick="document.getElementById('jsonl-input').value=''; setOutput('');">Clear</button>
    </div>
@endif

{{-- 98. RAG Chunk Size Calculator --}}
@if($tool['slug'] === 'rag-chunk-size-calculator')
    <div class="row g-3 mb-3">
        <div class="col-md-4">
            <label class="form-label" for="rag-words"><strong>Total Document Words:</strong></label>
            <input type="number" id="rag-words" class="form-control" value="50000" oninput="runRagChunkCalculator()">
        </div>
        <div class="col-md-4">
            <label class="form-label" for="rag-chunk-size"><strong>Chunk Size (Tokens):</strong></label>
            <input type="number" id="rag-chunk-size" class="form-control" value="512" oninput="runRagChunkCalculator()">
        </div>
        <div class="col-md-4">
            <label class="form-label" for="rag-overlap-pct"><strong>Overlap Percentage (%):</strong></label>
            <input type="number" id="rag-overlap-pct" class="form-control" value="15" min="0" max="50" oninput="runRagChunkCalculator()">
        </div>
    </div>
    <div class="d-flex flex-wrap gap-2 mb-3">
        <button type="button" class="btn btn-primary" onclick="runRagChunkCalculator()">Calculate Vector Metrics</button>
        <button type="button" class="btn btn-secondary" onclick="copyOutput()">Copy Estimation</button>
    </div>
@endif

{{-- 99. AI Prompt Formatter --}}
@if($tool['slug'] === 'ai-prompt-formatter')
    <div class="row g-3 mb-3">
        <div class="col-md-6">
            <label class="form-label" for="prompt-role"><strong>Role / Persona:</strong></label>
            <input type="text" id="prompt-role" class="form-control mb-2" value="Principal Full-Stack Engineer" oninput="runAiPromptFormatter()">

            <label class="form-label" for="prompt-context"><strong>Context & Scope:</strong></label>
            <textarea id="prompt-context" class="form-control mb-2" rows="2" oninput="runAiPromptFormatter()">Refactoring a Laravel Blade frontend for high-speed client-side utility tools.</textarea>

            <label class="form-label" for="prompt-format"><strong>Output Format:</strong></label>
            <input type="text" id="prompt-format" class="form-control mb-2" value="Clean Markdown code block with inline comments." oninput="runAiPromptFormatter()">
        </div>
        <div class="col-md-6">
            <label class="form-label" for="prompt-instructions"><strong>Core Instructions:</strong></label>
            <textarea id="prompt-instructions" class="form-control mb-2" rows="3" oninput="runAiPromptFormatter()">Analyze the blade template structure, remove any redundant server overhead, and ensure 100% client-side event binding.</textarea>

            <label class="form-label" for="prompt-constraints"><strong>Constraints & Boundaries:</strong></label>
            <textarea id="prompt-constraints" class="form-control mb-2" rows="2" oninput="runAiPromptFormatter()">1. Zero server API calls.\n2. Do not introduce large external npm dependencies.</textarea>
        </div>
    </div>
    <div class="d-flex flex-wrap gap-2 mb-3">
        <button type="button" class="btn btn-primary" onclick="runAiPromptFormatter()">Format Structured Prompt</button>
        <button type="button" class="btn btn-secondary" onclick="copyOutput()">Copy XML Prompt</button>
    </div>
@endif

{{-- 100. llms.txt Generator --}}
@if($tool['slug'] === 'llms-txt-generator')
    <div class="row g-3 mb-3">
        <div class="col-md-6">
            <label class="form-label" for="llms-title"><strong>Project / Website Title:</strong></label>
            <input type="text" id="llms-title" class="form-control mb-2" value="WebToolsStation" oninput="runLlmsTxtGenerator()">

            <label class="form-label" for="llms-summary"><strong>Project Summary (Blockquote):</strong></label>
            <textarea id="llms-summary" class="form-control mb-2" rows="3" oninput="runLlmsTxtGenerator()">WebToolsStation is a free, privacy-first online utilities platform featuring 174 client-side developer, text, SEO, color, and image tools.</textarea>
        </div>
        <div class="col-md-6">
            <label class="form-label" for="llms-docs"><strong>Core Documentation Links (Title: URL per line):</strong></label>
            <textarea id="llms-docs" class="form-control font-monospace mb-2" rows="3" oninput="runLlmsTxtGenerator()">Developer Tools: https://webtoolsstation.com/categories/developer-tools
Text Tools: https://webtoolsstation.com/categories/text-tools
SEO Utilities: https://webtoolsstation.com/categories/seo-tools</textarea>

            <label class="form-label" for="llms-optional"><strong>Optional Guides (Title: URL per line):</strong></label>
            <textarea id="llms-optional" class="form-control font-monospace mb-2" rows="2" oninput="runLlmsTxtGenerator()">JSON Formatting Guide: https://webtoolsstation.com/guides/how-to-format-json-without-errors
JWT Decoding Guide: https://webtoolsstation.com/guides/best-way-to-check-a-jwt-token</textarea>
        </div>
    </div>
    <div class="d-flex flex-wrap gap-2 mb-3">
        <button type="button" class="btn btn-primary" onclick="runLlmsTxtGenerator()">Generate /llms.txt</button>
        <button type="button" class="btn btn-secondary" onclick="copyOutput()">Copy llms.txt</button>
    </div>
@endif
