{{-- Batch 5 Calculator Tools Workspace Partials --}}

{{-- 90. Percentage Calculator --}}
@if($tool['slug'] === 'percentage-calculator')
    <div class="row g-3 mb-3">
        <div class="col-md-4">
            <label class="form-label" for="pct-mode"><strong>Calculation Mode:</strong></label>
            <select id="pct-mode" class="form-select" onchange="runPercentageCalculator()">
                <option value="what_is" selected>What is X% of Y?</option>
                <option value="is_what_pct">X is what % of Y?</option>
                <option value="pct_change">Percentage change from X to Y</option>
            </select>
        </div>
        <div class="col-md-4">
            <label class="form-label" for="pct-x"><strong>Value X:</strong></label>
            <input type="number" id="pct-x" class="form-control" value="15" step="any" oninput="runPercentageCalculator()">
        </div>
        <div class="col-md-4">
            <label class="form-label" for="pct-y"><strong>Value Y:</strong></label>
            <input type="number" id="pct-y" class="form-control" value="200" step="any" oninput="runPercentageCalculator()">
        </div>
    </div>
    <div class="d-flex flex-wrap gap-2 mb-3">
        <button type="button" class="btn btn-primary" onclick="runPercentageCalculator()">Calculate Percentage</button>
        <button type="button" class="btn btn-secondary" onclick="copyOutput()">Copy Result</button>
    </div>
@endif

{{-- 91. Aspect Ratio Calculator --}}
@if($tool['slug'] === 'aspect-ratio-calculator')
    <div class="row g-3 mb-3">
        <div class="col-md-6">
            <label class="form-label" for="ar-w"><strong>Width (Pixels):</strong></label>
            <input type="number" id="ar-w" class="form-control" value="1920" oninput="runAspectRatioCalculator()">
        </div>
        <div class="col-md-6">
            <label class="form-label" for="ar-h"><strong>Height (Pixels):</strong></label>
            <input type="number" id="ar-h" class="form-control" value="1080" oninput="runAspectRatioCalculator()">
        </div>
    </div>
    <div class="d-flex flex-wrap gap-2 mb-3">
        <button type="button" class="btn btn-primary" onclick="runAspectRatioCalculator()">Calculate Ratio & Scales</button>
        <button type="button" class="btn btn-secondary" onclick="copyOutput()">Copy Ratio</button>
    </div>
@endif

{{-- 92. Date Difference Calculator --}}
@if($tool['slug'] === 'date-difference-calculator')
    <div class="row g-3 mb-3">
        <div class="col-md-6">
            <label class="form-label" for="date-start"><strong>Start Date:</strong></label>
            <input type="date" id="date-start" class="form-control" value="2026-01-01" onchange="runDateDifferenceCalculator()">
        </div>
        <div class="col-md-6">
            <label class="form-label" for="date-end"><strong>End Date:</strong></label>
            <input type="date" id="date-end" class="form-control" value="2026-09-23" onchange="runDateDifferenceCalculator()">
        </div>
    </div>
    <div class="d-flex flex-wrap gap-2 mb-3">
        <button type="button" class="btn btn-primary" onclick="runDateDifferenceCalculator()">Calculate Duration</button>
        <button type="button" class="btn btn-secondary" onclick="copyOutput()">Copy Breakdown</button>
    </div>
@endif

{{-- 93. Data Storage Converter --}}
@if($tool['slug'] === 'data-storage-converter')
    <div class="row g-3 mb-3">
        <div class="col-md-6">
            <label class="form-label" for="storage-val"><strong>Amount:</strong></label>
            <input type="number" id="storage-val" class="form-control" value="100" min="0" step="any" oninput="runDataStorageConverter()">
        </div>
        <div class="col-md-6">
            <label class="form-label" for="storage-unit"><strong>Unit:</strong></label>
            <select id="storage-unit" class="form-select" onchange="runDataStorageConverter()">
                <option value="B">Bytes (B)</option>
                <option value="KB">Kilobytes (KB - 1,000 B)</option>
                <option value="MB">Megabytes (MB - 1,000 KB)</option>
                <option value="GB" selected>Gigabytes (GB - 1,000 MB)</option>
                <option value="TB">Terabytes (TB - 1,000 GB)</option>
                <option value="KiB">Kibibytes (KiB - 1,024 B)</option>
                <option value="MiB">Mebibytes (MiB - 1,024 KiB)</option>
                <option value="GiB">Gibibytes (GiB - 1,024 MiB)</option>
                <option value="TiB">Tebibytes (TiB - 1,024 GiB)</option>
            </select>
        </div>
    </div>
    <div class="d-flex flex-wrap gap-2 mb-3">
        <button type="button" class="btn btn-primary" onclick="runDataStorageConverter()">Convert Storage Units</button>
        <button type="button" class="btn btn-secondary" onclick="copyOutput()">Copy Matrix</button>
    </div>
@endif

{{-- 94. Download Time Calculator --}}
@if($tool['slug'] === 'download-time-calculator')
    <div class="row g-3 mb-3">
        <div class="col-md-6">
            <label class="form-label" for="dl-size"><strong>File Size:</strong></label>
            <div class="input-group">
                <input type="number" id="dl-size" class="form-control" value="5" min="0" step="any" oninput="runDownloadTimeCalculator()">
                <select id="dl-size-unit" class="form-select" style="max-width: 110px;" onchange="runDownloadTimeCalculator()">
                    <option value="MB">MB</option>
                    <option value="GB" selected>GB</option>
                    <option value="TB">TB</option>
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <label class="form-label" for="dl-speed"><strong>Internet Speed:</strong></label>
            <div class="input-group">
                <input type="number" id="dl-speed" class="form-control" value="100" min="0" step="any" oninput="runDownloadTimeCalculator()">
                <select id="dl-speed-unit" class="form-select" style="max-width: 110px;" onchange="runDownloadTimeCalculator()">
                    <option value="Kbps">Kbps</option>
                    <option value="Mbps" selected>Mbps</option>
                    <option value="Gbps">Gbps</option>
                </select>
            </div>
        </div>
    </div>
    <div class="d-flex flex-wrap gap-2 mb-3">
        <button type="button" class="btn btn-primary" onclick="runDownloadTimeCalculator()">Estimate Download Duration</button>
        <button type="button" class="btn btn-secondary" onclick="copyOutput()">Copy Breakdown</button>
    </div>
@endif
