{{-- Batch 4 Color Tools Workspace Partials --}}

{{-- 79. HEX to HSL Converter --}}
@if($tool['slug'] === 'hex-to-hsl-converter')
    <div class="row g-3 align-items-center mb-3">
        <div class="col-md-6">
            <label class="form-label" for="hex-hsl-input"><strong>HEX Color Code:</strong></label>
            <div class="input-group">
                <input type="text" id="hex-hsl-input" class="form-control font-monospace" value="#3b82f6" placeholder="#3b82f6" oninput="runHexToHsl()">
                <input type="color" class="form-control form-control-color" value="#3b82f6" oninput="document.getElementById('hex-hsl-input').value=this.value; runHexToHsl();">
            </div>
        </div>
        <div class="col-md-6 text-center">
            <label class="form-label d-block"><strong>Color Preview:</strong></label>
            <div id="hex-hsl-preview" class="border rounded mx-auto" style="width: 100%; height: 50px; background-color: #3b82f6; transition: background-color 0.2s;"></div>
        </div>
    </div>
    <div class="d-flex flex-wrap gap-2 mb-3">
        <button type="button" class="btn btn-primary" onclick="runHexToHsl()">Convert to HSL</button>
        <button type="button" class="btn btn-secondary" onclick="copyOutput()">Copy CSS</button>
    </div>
@endif

{{-- 80. Color Palette Generator --}}
@if($tool['slug'] === 'color-palette-generator')
    <div class="row g-3 align-items-center mb-3">
        <div class="col-md-6">
            <label class="form-label" for="palette-base-color"><strong>Base HEX Color:</strong></label>
            <div class="input-group">
                <input type="text" id="palette-base-color" class="form-control font-monospace" value="#3b82f6" placeholder="#3b82f6" oninput="runColorPaletteGenerator()">
                <input type="color" class="form-control form-control-color" value="#3b82f6" oninput="document.getElementById('palette-base-color').value=this.value; runColorPaletteGenerator();">
            </div>
        </div>
        <div class="col-md-6">
            <div class="small text-muted">Generates complementary, analogous, triadic, split-complementary, and monochromatic harmonic palettes.</div>
        </div>
    </div>
    <div class="d-flex flex-wrap gap-2 mb-3">
        <button type="button" class="btn btn-primary" onclick="runColorPaletteGenerator()">Generate Harmonies</button>
        <button type="button" class="btn btn-secondary" onclick="copyOutput()">Copy Palette Codes</button>
    </div>
@endif
