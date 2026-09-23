{{-- Batch 4 Web & API Tools Workspace Partials --}}

{{-- 71. UTM URL Builder --}}
@if($tool['slug'] === 'url-builder-utm')
    <div class="row g-3 mb-3">
        <div class="col-md-6">
            <label class="form-label" for="utm-base-url"><strong>Website URL (Required):</strong></label>
            <input type="text" id="utm-base-url" class="form-control mb-2" value="https://webtoolsstation.com/tools/json-formatter" oninput="runUtmUrlBuilder()">

            <label class="form-label" for="utm-source"><strong>Campaign Source (utm_source, e.g. google, newsletter):</strong></label>
            <input type="text" id="utm-source" class="form-control mb-2" value="newsletter" oninput="runUtmUrlBuilder()">

            <label class="form-label" for="utm-medium"><strong>Campaign Medium (utm_medium, e.g. cpc, email):</strong></label>
            <input type="text" id="utm-medium" class="form-control mb-2" value="email" oninput="runUtmUrlBuilder()">
        </div>
        <div class="col-md-6">
            <label class="form-label" for="utm-campaign"><strong>Campaign Name (utm_campaign, e.g. spring_sale):</strong></label>
            <input type="text" id="utm-campaign" class="form-control mb-2" value="developer_weekly_launch" oninput="runUtmUrlBuilder()">

            <label class="form-label" for="utm-term"><strong>Campaign Term (utm_term, optional paid keyword):</strong></label>
            <input type="text" id="utm-term" class="form-control mb-2" placeholder="e.g. online json formatter" oninput="runUtmUrlBuilder()">

            <label class="form-label" for="utm-content"><strong>Campaign Content (utm_content, optional A/B test id):</strong></label>
            <input type="text" id="utm-content" class="form-control mb-2" placeholder="e.g. hero_cta_button" oninput="runUtmUrlBuilder()">
        </div>
    </div>
    <div class="d-flex flex-wrap gap-2 mb-3">
        <button type="button" class="btn btn-primary" onclick="runUtmUrlBuilder()">Generate Campaign URL</button>
        <button type="button" class="btn btn-secondary" onclick="copyOutput()">Copy URL</button>
    </div>
@endif

{{-- 72. URL Normalizer --}}
@if($tool['slug'] === 'url-normalizer')
    <div class="form-group mb-3">
        <label class="form-label" for="url-normalizer-input"><strong>Raw URL to Normalize & Canonicalize:</strong></label>
        <input type="text" id="url-normalizer-input" class="form-control font-monospace" value="HTTP://WebToolsStation.COM:80/tools/json-formatter?utm_source=test&b=2&a=1#section1" placeholder="Enter URL to normalize...">
    </div>
    <div class="d-flex flex-wrap gap-2 mb-3">
        <button type="button" class="btn btn-primary" onclick="runUrlNormalizer()">Normalize URL</button>
        <button type="button" class="btn btn-secondary" onclick="copyOutput()">Copy Normalized URL</button>
    </div>
@endif

{{-- 73. URL Validator --}}
@if($tool['slug'] === 'url-validator')
    <div class="form-group mb-3">
        <label class="form-label" for="url-val-input"><strong>URL to Validate against RFC 3986:</strong></label>
        <input type="text" id="url-val-input" class="form-control font-monospace" value="https://webtoolsstation.com/tools/json-formatter?indent=2" placeholder="Paste full URL...">
    </div>
    <div class="d-flex flex-wrap gap-2 mb-3">
        <button type="button" class="btn btn-primary" onclick="runUrlValidator()">Validate URL</button>
    </div>
@endif

{{-- 74. HTTP Status Code Lookup --}}
@if($tool['slug'] === 'http-status-code-lookup')
    <div class="form-group mb-3">
        <label class="form-label" for="http-status-query"><strong>Search by Status Code or Keyword (e.g., 200, 404, redirect, timeout, unauthorized):</strong></label>
        <input type="text" id="http-status-query" class="form-control" value="404" placeholder="Type code (404, 500) or keyword..." oninput="runHttpStatusLookup()">
    </div>
    <div class="d-flex flex-wrap gap-2 mb-3">
        <button type="button" class="btn btn-primary" onclick="runHttpStatusLookup()">Lookup Status Details</button>
        <button type="button" class="btn btn-outline-secondary" onclick="document.getElementById('http-status-query').value=''; runHttpStatusLookup();">Show All Codes</button>
    </div>
@endif

{{-- 75. Cookie Parser --}}
@if($tool['slug'] === 'cookie-parser')
    <div class="form-group mb-3">
        <label class="form-label" for="cookie-parser-input"><strong>Cookie / Set-Cookie Header String:</strong></label>
        <textarea id="cookie-parser-input" class="form-control font-monospace" rows="5" placeholder="sessionId=abc12345; Path=/; Secure; HttpOnly; SameSite=Strict">sessionId=3a8f90c12b; theme=dark; user_prefs=%7B%22fontSize%22%3A14%7D; Path=/; Domain=.example.com; Secure; HttpOnly; SameSite=Lax</textarea>
    </div>
    <div class="d-flex flex-wrap gap-2 mb-3">
        <button type="button" class="btn btn-primary" onclick="runCookieParser()">Parse Cookies</button>
        <button type="button" class="btn btn-secondary" onclick="document.getElementById('cookie-parser-input').value=''; setOutput('');">Clear</button>
    </div>
@endif

{{-- 76. HTTP Request Builder --}}
@if($tool['slug'] === 'http-request-builder')
    <div class="row g-3 mb-3">
        <div class="col-md-3">
            <label class="form-label" for="req-method"><strong>Method:</strong></label>
            <select id="req-method" class="form-select" onchange="runHttpRequestBuilder()">
                <option value="GET">GET</option>
                <option value="POST" selected>POST</option>
                <option value="PUT">PUT</option>
                <option value="DELETE">DELETE</option>
                <option value="PATCH">PATCH</option>
                <option value="HEAD">HEAD</option>
                <option value="OPTIONS">OPTIONS</option>
            </select>
        </div>
        <div class="col-md-5">
            <label class="form-label" for="req-host"><strong>Host:</strong></label>
            <input type="text" id="req-host" class="form-control" value="api.webtoolsstation.com" oninput="runHttpRequestBuilder()">
        </div>
        <div class="col-md-4">
            <label class="form-label" for="req-path"><strong>Request Path:</strong></label>
            <input type="text" id="req-path" class="form-control" value="/v1/tools/validate" oninput="runHttpRequestBuilder()">
        </div>
    </div>
    <div class="form-group mb-3">
        <label class="form-label" for="req-headers"><strong>Headers (Key: Value per line):</strong></label>
        <textarea id="req-headers" class="form-control font-monospace" rows="3" oninput="runHttpRequestBuilder()">Accept: application/json
Content-Type: application/json
Authorization: Bearer token_sample_abc123</textarea>
    </div>
    <div class="form-group mb-3">
        <label class="form-label" for="req-body"><strong>Request Payload / Body (JSON / Text):</strong></label>
        <textarea id="req-body" class="form-control font-monospace" rows="4" oninput="runHttpRequestBuilder()">{\n  "action": "test",\n  "status": "active"\n}</textarea>
    </div>
    <div class="d-flex flex-wrap gap-2 mb-3">
        <button type="button" class="btn btn-primary" onclick="runHttpRequestBuilder()">Build Raw HTTP Wire Payload</button>
        <button type="button" class="btn btn-secondary" onclick="copyOutput()">Copy Payload</button>
    </div>
@endif

{{-- 77. CORS Header Generator --}}
@if($tool['slug'] === 'cors-header-generator')
    <div class="row g-3 mb-3">
        <div class="col-md-6">
            <label class="form-label" for="cors-origin"><strong>Allowed Origin (Access-Control-Allow-Origin):</strong></label>
            <input type="text" id="cors-origin" class="form-control mb-2" value="https://webtoolsstation.com" oninput="runCorsHeaderGenerator()">

            <label class="form-label" for="cors-methods"><strong>Allowed Methods:</strong></label>
            <input type="text" id="cors-methods" class="form-control mb-2" value="GET, POST, PUT, DELETE, OPTIONS" oninput="runCorsHeaderGenerator()">
        </div>
        <div class="col-md-6">
            <label class="form-label" for="cors-headers"><strong>Allowed Headers:</strong></label>
            <input type="text" id="cors-headers" class="form-control mb-2" value="Content-Type, Authorization, X-Requested-With" oninput="runCorsHeaderGenerator()">

            <div class="row g-2">
                <div class="col-6">
                    <label class="form-label" for="cors-creds"><strong>Allow Credentials:</strong></label>
                    <select id="cors-creds" class="form-select" onchange="runCorsHeaderGenerator()">
                        <option value="false" selected>false</option>
                        <option value="true">true</option>
                    </select>
                </div>
                <div class="col-6">
                    <label class="form-label" for="cors-maxage"><strong>Max-Age (seconds):</strong></label>
                    <input type="number" id="cors-maxage" class="form-control" value="86400" oninput="runCorsHeaderGenerator()">
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex flex-wrap gap-2 mb-3">
        <button type="button" class="btn btn-primary" onclick="runCorsHeaderGenerator()">Generate CORS Configuration</button>
        <button type="button" class="btn btn-secondary" onclick="copyOutput()">Copy Snippet</button>
    </div>
@endif

{{-- 78. Browser Info Detector --}}
@if($tool['slug'] === 'browser-info-detector')
    <div class="alert alert-info py-2 mb-3 small">
        All environment details below are extracted locally from your active browser session using standard Navigator, Screen, and DOM Web APIs.
    </div>
    <div class="d-flex flex-wrap gap-2 mb-3">
        <button type="button" class="btn btn-primary" onclick="runBrowserInfoDetector()">Inspect My Browser Environment</button>
        <button type="button" class="btn btn-secondary" onclick="copyOutput()">Copy Diagnostic Report</button>
    </div>
@endif
