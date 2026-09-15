<div class="workspace-split">
    <!-- Left: PDF Dropzone & Upload -->
    <div class="pane-card" style="padding:24px;">
        <div style="font-weight:700; font-size:0.92rem; color:var(--text); text-transform:uppercase; letter-spacing:0.04em; margin-bottom:14px;">
            Document Upload
        </div>

        <div id="pdf-dropzone" style="border:2px dashed var(--border-hover); border-radius:var(--radius-md); padding:36px 20px; text-align:center; background:var(--surface-subtle); cursor:pointer; transition:border-color 0.15s, background-color 0.15s;" onclick="document.getElementById('pdf-file').click()">
            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" style="color:var(--brand); margin-bottom:12px;"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
            <div style="font-weight:700; font-size:1.05rem; color:var(--text); margin-bottom:6px;">Drop PDF document here, or browse</div>
            <div style="font-size:0.82rem; color:var(--text-muted);">Client-side inspection powered by Mozilla PDF.js</div>
            <button type="button" class="btn btn-secondary btn-sm" style="margin-top:14px;">Choose PDF File</button>
        </div>

        <input id="pdf-file" type="file" accept="application/pdf" style="display:none;" onchange="handlePdfSelected(this)">

        @if ($tool['slug'] === 'pdf-text-finder')
            <div style="margin-top:16px;">
                <label for="pdf-search" style="display:block; font-size:0.85rem; font-weight:600; margin-bottom:6px;">Keyword or phrase to search:</label>
                <div style="display:flex; gap:8px;">
                    <input id="pdf-search" type="text" placeholder="e.g. invoice, total, contract..." style="flex:1;">
                    <button class="btn btn-primary" onclick="pdfTextFinder()">Search Text</button>
                </div>
            </div>
        @endif

        <div id="pdf-info-card" style="display:none; margin-top:14px; padding:14px; border-radius:var(--radius-sm); background:var(--surface-subtle); border:1px solid var(--border); font-size:0.85rem;">
            <div style="display:flex; justify-content:space-between; margin-bottom:6px;">
                <strong id="pdf-filename" style="color:var(--text);"></strong>
                <span id="pdf-filesize" style="color:var(--text-muted); font-family:var(--font-mono);"></span>
            </div>
            <div style="color:var(--success); font-weight:600; font-size:0.8rem; display:flex; align-items:center; gap:5px;">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                Loaded locally into browser memory
            </div>
        </div>
    </div>

    <!-- Right: Document Analysis Results -->
    <div class="pane-card" style="padding:20px; gap:16px;">
        <div style="display:flex; justify-content:space-between; align-items:center; border-bottom:1px solid var(--border); padding-bottom:10px;">
            <span style="font-weight:700; font-size:0.92rem; color:var(--text); text-transform:uppercase; letter-spacing:0.04em;">Analysis Results</span>
            <button class="btn btn-secondary btn-sm" onclick="copyOutput('tool-output')">Copy Report</button>
        </div>

        <div style="display:flex; gap:10px; flex-wrap:wrap;">
            @if ($tool['slug'] === 'pdf-page-counter')
                <button class="btn btn-primary btn-lg" onclick="pdfPageCounter()">Analyze PDF</button>
            @elseif ($tool['slug'] === 'pdf-metadata-viewer')
                <button class="btn btn-primary btn-lg" onclick="pdfMetadataViewer()">View Metadata Signals</button>
            @elseif ($tool['slug'] === 'pdf-security-checker')
                <button class="btn btn-primary btn-lg" onclick="pdfSecurityChecker()">Check Security Signals</button>
            @endif
        </div>

        <pre id="tool-output" class="output-pre" style="flex:1; min-height:280px;" aria-label="PDF inspection results"></pre>
    </div>
</div>