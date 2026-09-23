{{-- Batch 5 Color Tools Workspace Partials --}}

{{-- 81. CSS Gradient Generator --}}
@if($tool['slug'] === 'css-gradient-generator')
    <div class="row g-3 mb-3">
        <div class="col-md-6">
            <label class="form-label" for="grad-type"><strong>Gradient Type:</strong></label>
            <select id="grad-type" class="form-select mb-2" onchange="runCssGradientGenerator()">
                <option value="linear" selected>Linear Gradient</option>
                <option value="radial">Radial Gradient</option>
                <option value="conic">Conic Gradient</option>
            </select>

            <label class="form-label" for="grad-angle"><strong>Angle (Degrees, 0 to 360):</strong></label>
            <input type="number" id="grad-angle" class="form-control mb-2" value="90" min="0" max="360" oninput="runCssGradientGenerator()">

            <div class="row g-2">
                <div class="col-6">
                    <label class="form-label" for="grad-color1"><strong>Color Stop 1:</strong></label>
                    <input type="color" id="grad-color1" class="form-control form-control-color w-100" value="#3b82f6" oninput="runCssGradientGenerator()">
                </div>
                <div class="col-6">
                    <label class="form-label" for="grad-color2"><strong>Color Stop 2:</strong></label>
                    <input type="color" id="grad-color2" class="form-control form-control-color w-100" value="#9333ea" oninput="runCssGradientGenerator()">
                </div>
            </div>
            <div class="mt-2">
                <label class="form-label" for="grad-color3"><strong>Optional Color Stop 3:</strong></label>
                <input type="text" id="grad-color3" class="form-control" placeholder="#f43f5e or leave empty" oninput="runCssGradientGenerator()">
            </div>
        </div>
        <div class="col-md-6 text-center">
            <label class="form-label d-block"><strong>Live Preview:</strong></label>
            <div id="gradient-preview" class="border rounded shadow-sm mx-auto" style="width: 100%; height: 180px; background: linear-gradient(90deg, #3b82f6, #9333ea);"></div>
        </div>
    </div>
    <div class="d-flex flex-wrap gap-2 mb-3">
        <button type="button" class="btn btn-primary" onclick="runCssGradientGenerator()">Generate CSS Gradient</button>
        <button type="button" class="btn btn-secondary" onclick="copyOutput()">Copy CSS</button>
    </div>
@endif

{{-- 82. WCAG Contrast Checker --}}
@if($tool['slug'] === 'wcag-contrast-checker')
    <div class="row g-3 mb-3">
        <div class="col-md-6">
            <label class="form-label" for="wcag-fg"><strong>Foreground / Text Color:</strong></label>
            <div class="input-group mb-2">
                <input type="text" id="wcag-fg" class="form-control font-monospace" value="#1e293b" oninput="runWcagContrastChecker()">
                <input type="color" class="form-control form-control-color" value="#1e293b" oninput="document.getElementById('wcag-fg').value=this.value; runWcagContrastChecker();">
            </div>

            <label class="form-label" for="wcag-bg"><strong>Background Color:</strong></label>
            <div class="input-group mb-2">
                <input type="text" id="wcag-bg" class="form-control font-monospace" value="#ffffff" oninput="runWcagContrastChecker()">
                <input type="color" class="form-control form-control-color" value="#ffffff" oninput="document.getElementById('wcag-bg').value=this.value; runWcagContrastChecker();">
            </div>
        </div>
        <div class="col-md-6">
            <label class="form-label d-block"><strong>Visual Contrast Simulation:</strong></label>
            <div id="wcag-preview" class="border rounded p-3 text-center shadow-sm" style="color: #1e293b; background-color: #ffffff;">
                <h4 class="mb-1" style="font-size: 1.25rem;">Large Text Heading Sample</h4>
                <p class="mb-0" style="font-size: 0.95rem;">This is normal body text (14-16px) demonstrating contrast readability against the selected background color.</p>
            </div>
        </div>
    </div>
    <div class="d-flex flex-wrap gap-2 mb-3">
        <button type="button" class="btn btn-primary" onclick="runWcagContrastChecker()">Evaluate Contrast Ratio</button>
        <button type="button" class="btn btn-secondary" onclick="copyOutput()">Copy Report</button>
    </div>
@endif

{{-- 83. Color Shades & Tints Generator --}}
@if($tool['slug'] === 'color-shades-tints-generator')
    <div class="row g-3 align-items-center mb-3">
        <div class="col-md-6">
            <label class="form-label" for="shades-base"><strong>Base HEX Color:</strong></label>
            <div class="input-group">
                <input type="text" id="shades-base" class="form-control font-monospace" value="#3b82f6" oninput="runColorShadesTints()">
                <input type="color" class="form-control form-control-color" value="#3b82f6" oninput="document.getElementById('shades-base').value=this.value; runColorShadesTints();">
            </div>
        </div>
        <div class="col-md-6">
            <div class="small text-muted">Generates 10 lighter tints (mixed toward white) and 10 darker shades (mixed toward black).</div>
        </div>
    </div>
    <div class="d-flex flex-wrap gap-2 mb-3">
        <button type="button" class="btn btn-primary" onclick="runColorShadesTints()">Generate Steps</button>
        <button type="button" class="btn btn-secondary" onclick="copyOutput()">Copy All HEX Codes</button>
    </div>
@endif

{{-- 84. CSS Variable Color Generator --}}
@if($tool['slug'] === 'css-variable-color-generator')
    <div class="row g-3 mb-3">
        <div class="col-md-4">
            <label class="form-label" for="theme-primary"><strong>Primary Brand:</strong></label>
            <input type="color" id="theme-primary" class="form-control form-control-color w-100 mb-2" value="#3b82f6" oninput="runCssVariableGenerator()">

            <label class="form-label" for="theme-secondary"><strong>Secondary Color:</strong></label>
            <input type="color" id="theme-secondary" class="form-control form-control-color w-100 mb-2" value="#64748b" oninput="runCssVariableGenerator()">

            <label class="form-label" for="theme-accent"><strong>Accent Color:</strong></label>
            <input type="color" id="theme-accent" class="form-control form-control-color w-100 mb-2" value="#f59e0b" oninput="runCssVariableGenerator()">
        </div>
        <div class="col-md-4">
            <label class="form-label" for="theme-bg-light"><strong>Light Background:</strong></label>
            <input type="color" id="theme-bg-light" class="form-control form-control-color w-100 mb-2" value="#ffffff" oninput="runCssVariableGenerator()">

            <label class="form-label" for="theme-surface-light"><strong>Light Surface Card:</strong></label>
            <input type="color" id="theme-surface-light" class="form-control form-control-color w-100 mb-2" value="#f8fafc" oninput="runCssVariableGenerator()">

            <label class="form-label" for="theme-text-light"><strong>Light Text:</strong></label>
            <input type="color" id="theme-text-light" class="form-control form-control-color w-100 mb-2" value="#0f172a" oninput="runCssVariableGenerator()">
        </div>
        <div class="col-md-4">
            <label class="form-label" for="theme-bg-dark"><strong>Dark Background:</strong></label>
            <input type="color" id="theme-bg-dark" class="form-control form-control-color w-100 mb-2" value="#090d16" oninput="runCssVariableGenerator()">

            <label class="form-label" for="theme-surface-dark"><strong>Dark Surface Card:</strong></label>
            <input type="color" id="theme-surface-dark" class="form-control form-control-color w-100 mb-2" value="#131c2e" oninput="runCssVariableGenerator()">

            <label class="form-label" for="theme-text-dark"><strong>Dark Text:</strong></label>
            <input type="color" id="theme-text-dark" class="form-control form-control-color w-100 mb-2" value="#f8fafc" oninput="runCssVariableGenerator()">
        </div>
    </div>
    <div class="d-flex flex-wrap gap-2 mb-3">
        <button type="button" class="btn btn-primary" onclick="runCssVariableGenerator()">Generate :root CSS Tokens</button>
        <button type="button" class="btn btn-secondary" onclick="copyOutput()">Copy CSS</button>
    </div>
@endif
