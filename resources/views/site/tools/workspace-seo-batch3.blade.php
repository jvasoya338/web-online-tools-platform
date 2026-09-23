@if ($tool['slug'] === 'meta-tag-generator')
    {{-- Meta Tag Generator --}}
    <div class="workspace-split">
        <div class="pane-card" style="padding:16px; gap:10px;">
            <div>
                <label for="meta-title" style="font-size:0.85rem; font-weight:700;">Page Title:</label>
                <input type="text" id="meta-title" value="WebToolsStation - Fast Free Browser Utilities" style="width:100%; height:32px;" oninput="runMetaTagGenerator()">
            </div>
            <div>
                <label for="meta-desc" style="font-size:0.85rem; font-weight:700;">Meta Description:</label>
                <textarea id="meta-desc" class="editor-textarea" style="height:60px;" oninput="runMetaTagGenerator()">High-performance online developer tools with client-side execution and zero data uploads.</textarea>
            </div>
            <div>
                <label for="meta-canonical" style="font-size:0.85rem; font-weight:700;">Canonical URL:</label>
                <input type="text" id="meta-canonical" value="https://webtoolsstation.com/" style="width:100%; height:32px;" oninput="runMetaTagGenerator()">
            </div>
            <div>
                <label for="meta-robots" style="font-size:0.85rem; font-weight:700;">Robots Directive:</label>
                <select id="meta-robots" style="width:100%; height:32px;" onchange="runMetaTagGenerator()">
                    <option value="index, follow" selected>index, follow (Standard)</option>
                    <option value="noindex, follow">noindex, follow</option>
                    <option value="noindex, nofollow">noindex, nofollow</option>
                </select>
            </div>
            <button type="button" class="btn btn-primary" onclick="runMetaTagGenerator()">Generate Meta Tags</button>
        </div>

        <div class="pane-card">
            <div class="pane-header">
                <span>HTML Head Meta Tags</span>
                <div class="pane-actions">
                    <button type="button" class="btn btn-secondary btn-sm" onclick="copyOutput('meta-output')">Copy HTML</button>
                </div>
            </div>
            <textarea id="meta-output" class="editor-textarea" readonly placeholder="HTML meta tags..."></textarea>
        </div>
    </div>
@endif
