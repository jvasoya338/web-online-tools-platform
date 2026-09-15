<div class="workspace-split">
    <!-- Left: Drag-and-drop file upload zone -->
    <div class="pane-card" style="padding:24px;">
        <div style="font-weight:700; font-size:0.92rem; color:var(--text); text-transform:uppercase; letter-spacing:0.04em; margin-bottom:14px;">
            Image Source
        </div>

        <div id="image-dropzone" style="border:2px dashed var(--border-hover); border-radius:var(--radius-md); padding:36px 20px; text-align:center; background:var(--surface-subtle); cursor:pointer; transition:border-color 0.15s, background-color 0.15s;" onclick="triggerFileInput()">
            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" style="color:var(--brand); margin-bottom:12px;"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>
            <div style="font-weight:700; font-size:1.05rem; color:var(--text); margin-bottom:6px;">Drop image here, or browse</div>
            <div style="font-size:0.82rem; color:var(--text-muted);">Supported formats: PNG, JPG, JPEG, WebP, SVG</div>
            <button type="button" class="btn btn-secondary btn-sm" style="margin-top:14px;">Select Image File</button>
        </div>

        @if ($tool['slug'] === 'jpg-to-png-converter')
            <input id="jpg-file" type="file" accept="image/jpeg,image/jpg" style="display:none;" onchange="handleImageFile(this)">
        @elseif ($tool['slug'] === 'png-to-jpg-converter')
            <input id="png-file" type="file" accept="image/png" style="display:none;" onchange="handleImageFile(this)">
        @elseif ($tool['slug'] === 'favicon-generator')
            <input id="favicon-file" type="file" accept="image/png,image/jpeg,image/webp,image/svg+xml" style="display:none;" onchange="handleImageFile(this)">
        @endif

        <div id="file-info-bar" style="display:none; margin-top:14px; padding:12px; border-radius:var(--radius-sm); background:var(--surface-subtle); border:1px solid var(--border); font-size:0.85rem;">
            <div style="display:flex; justify-content:space-between;">
                <strong id="file-name-display" style="color:var(--text);"></strong>
                <span id="file-size-display" style="color:var(--text-muted); font-family:var(--font-mono);"></span>
            </div>
        </div>
    </div>

    <!-- Right: Conversion Result & Actions -->
    <div class="pane-card" style="padding:20px; gap:16px;">
        <div style="font-weight:700; font-size:0.92rem; color:var(--text); text-transform:uppercase; letter-spacing:0.04em; border-bottom:1px solid var(--border); padding-bottom:10px;">
            Export & Downloads
        </div>

        <div style="display:flex; gap:10px; flex-wrap:wrap;">
            @if ($tool['slug'] === 'jpg-to-png-converter')
                <button class="btn btn-primary btn-lg" onclick="convertImageFile('jpg-file', 'image/png', 'png')">Convert to PNG</button>
            @elseif ($tool['slug'] === 'png-to-jpg-converter')
                <button class="btn btn-primary btn-lg" onclick="convertImageFile('png-file', 'image/jpeg', 'jpg', '#ffffff')">Convert to JPG</button>
            @elseif ($tool['slug'] === 'favicon-generator')
                <button class="btn btn-primary btn-lg" onclick="generateFavicons()">Generate Favicon Pack</button>
            @endif

            <a id="image-download-link" class="btn btn-secondary btn-lg" href="#" style="display:none;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                Download Converted Image
            </a>
        </div>

        @if ($tool['slug'] === 'favicon-generator')
            <div id="favicon-downloads" style="display:grid; grid-template-columns:repeat(auto-fit, minmax(130px, 1fr)); gap:8px; margin-top:8px;"></div>
        @endif

        <pre id="tool-output" class="output-pre" style="height:200px;" aria-label="Image processing notes"></pre>
    </div>
</div>