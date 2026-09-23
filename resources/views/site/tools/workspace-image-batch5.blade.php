{{-- Batch 5 Image Tools Workspace Partials --}}

{{-- 85. Image Resizer --}}
@if($tool['slug'] === 'image-resizer')
    <div class="form-group mb-3">
        <label class="form-label"><strong>Select Source Image File (PNG, JPG, WebP):</strong></label>
        <input type="file" class="form-control mb-2" accept="image/*" onchange="handleBatch5ImageUpload(this)">
        <div id="b5-image-info" class="small text-muted mb-3">No file selected. Please choose an image to scale.</div>

        <div class="row g-3 mb-3">
            <div class="col-md-4">
                <label class="form-label" for="resize-width"><strong>Target Width (px):</strong></label>
                <input type="number" id="resize-width" class="form-control" placeholder="Width in px">
            </div>
            <div class="col-md-4">
                <label class="form-label" for="resize-height"><strong>Target Height (px):</strong></label>
                <input type="number" id="resize-height" class="form-control" placeholder="Height in px">
            </div>
            <div class="col-md-4">
                <label class="form-label" for="resize-format"><strong>Output Format:</strong></label>
                <select id="resize-format" class="form-select">
                    <option value="image/png">PNG (.png)</option>
                    <option value="image/jpeg">JPEG (.jpg)</option>
                    <option value="image/webp">WebP (.webp)</option>
                </select>
            </div>
        </div>
    </div>
    <div class="d-flex flex-wrap gap-2 mb-3">
        <button type="button" class="btn btn-primary" onclick="runImageResizer()">Resize Image</button>
        <a id="b5-download-btn" class="btn btn-success" style="display:none;" download="resized.png">Download Resized Image</a>
    </div>
@endif

{{-- 86. Image Cropper --}}
@if($tool['slug'] === 'image-cropper')
    <div class="form-group mb-3">
        <label class="form-label"><strong>Select Source Image to Crop:</strong></label>
        <input type="file" class="form-control mb-2" accept="image/*" onchange="handleBatch5ImageUpload(this)">
        <div id="b5-image-info" class="small text-muted mb-3">Upload an image to crop with aspect ratio presets.</div>

        <div class="col-md-6 mb-3">
            <label class="form-label" for="crop-mode"><strong>Target Aspect Ratio Crop:</strong></label>
            <select id="crop-mode" class="form-select">
                <option value="1:1" selected>1:1 Square (Profile / Avatar / Instagram)</option>
                <option value="16:9">16:9 Widescreen (Landscape / YouTube Thumbnail)</option>
                <option value="4:3">4:3 Standard Photo</option>
            </select>
        </div>
    </div>
    <div class="d-flex flex-wrap gap-2 mb-3">
        <button type="button" class="btn btn-primary" onclick="runImageCropper()">Crop Image</button>
        <a id="b5-crop-download-btn" class="btn btn-success" style="display:none;" download="cropped.png">Download Cropped Image</a>
    </div>
@endif

{{-- 87. Image to Base64 Converter --}}
@if($tool['slug'] === 'image-to-base64-converter')
    <div class="form-group mb-3">
        <label class="form-label" for="img-to-b64-file"><strong>Select Image File (PNG, JPG, SVG, WebP, GIF):</strong></label>
        <input type="file" id="img-to-b64-file" class="form-control" accept="image/*" onchange="runImageToBase64()">
        <div class="small text-muted mt-1">Converts image binary into Base64 Data URI strings for inline HTML &lt;img&gt; or CSS background-image.</div>
    </div>
    <div class="d-flex flex-wrap gap-2 mb-3">
        <button type="button" class="btn btn-primary" onclick="runImageToBase64()">Convert to Base64 Data URI</button>
        <button type="button" class="btn btn-secondary" onclick="copyOutput()">Copy Base64</button>
    </div>
@endif

{{-- 88. Base64 to Image Converter --}}
@if($tool['slug'] === 'base64-to-image-converter')
    <div class="form-group mb-3">
        <label class="form-label" for="b64-to-img-input"><strong>Paste Base64 Image String or Data URI:</strong></label>
        <textarea id="b64-to-img-input" class="form-control font-monospace mb-2" rows="6" placeholder="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNk+M9QDwADhgGAWjR9awAAAABJRU5ErkJggg==">data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAoAAAAKCAYAAACNMs+9AAAAFUlEQVR42mNk+M9QzwAEjDAGYzAAAO48Ag0c+7sMAAAAAElFTkSuQmCC</textarea>
        <div class="d-flex align-items-center gap-3 mt-2">
            <img id="b64-img-preview" class="border rounded p-1 bg-light" style="max-height: 80px; max-width: 80px; display:none;" alt="Preview">
            <a id="b64-img-download-btn" class="btn btn-success btn-sm" style="display:none;" download="decoded.png">Download Image</a>
        </div>
    </div>
    <div class="d-flex flex-wrap gap-2 mb-3">
        <button type="button" class="btn btn-primary" onclick="runBase64ToImage()">Decode & View Image</button>
        <button type="button" class="btn btn-secondary" onclick="document.getElementById('b64-to-img-input').value=''; setOutput('');">Clear</button>
    </div>
@endif

{{-- 89. SVG Placeholder Generator --}}
@if($tool['slug'] === 'svg-placeholder-generator')
    <div class="row g-3 mb-3">
        <div class="col-md-6">
            <div class="row g-2 mb-2">
                <div class="col-6">
                    <label class="form-label" for="svg-w"><strong>Width (px):</strong></label>
                    <input type="number" id="svg-w" class="form-control" value="600" oninput="runSvgPlaceholderGenerator()">
                </div>
                <div class="col-6">
                    <label class="form-label" for="svg-h"><strong>Height (px):</strong></label>
                    <input type="number" id="svg-h" class="form-control" value="400" oninput="runSvgPlaceholderGenerator()">
                </div>
            </div>

            <label class="form-label" for="svg-text"><strong>Custom Label Text:</strong></label>
            <input type="text" id="svg-text" class="form-control mb-2" value="600 × 400 Placeholder" oninput="runSvgPlaceholderGenerator()">

            <div class="row g-2 mb-2">
                <div class="col-6">
                    <label class="form-label" for="svg-bg"><strong>Background Color:</strong></label>
                    <input type="color" id="svg-bg" class="form-control form-control-color w-100" value="#e2e8f0" oninput="runSvgPlaceholderGenerator()">
                </div>
                <div class="col-6">
                    <label class="form-label" for="svg-fg"><strong>Text Color:</strong></label>
                    <input type="color" id="svg-fg" class="form-control form-control-color w-100" value="#475569" oninput="runSvgPlaceholderGenerator()">
                </div>
            </div>
        </div>
        <div class="col-md-6 text-center">
            <label class="form-label d-block"><strong>Live Preview:</strong></label>
            <img id="svg-preview-img" class="border rounded img-fluid shadow-sm" style="max-height: 180px;" alt="SVG Preview">
        </div>
    </div>
    <div class="d-flex flex-wrap gap-2 mb-3">
        <button type="button" class="btn btn-primary" onclick="runSvgPlaceholderGenerator()">Generate SVG Code</button>
        <button type="button" class="btn btn-secondary" onclick="copyOutput()">Copy SVG</button>
        <a id="svg-download-btn" class="btn btn-outline-success" download="placeholder.svg">Download SVG File</a>
    </div>
@endif
