/**
 * WebToolsStation - Web & API Batch 4 Engine
 * 100% Client-Side Web Utilities, Parsers, and Diagnostic Inspectors
 */

// 71. UTM URL Builder
function runUtmUrlBuilder() {
    const baseUrl = document.getElementById('utm-base-url')?.value.trim() || 'https://example.com/landing-page';
    const source = document.getElementById('utm-source')?.value.trim() || '';
    const medium = document.getElementById('utm-medium')?.value.trim() || '';
    const campaign = document.getElementById('utm-campaign')?.value.trim() || '';
    const term = document.getElementById('utm-term')?.value.trim() || '';
    const content = document.getElementById('utm-content')?.value.trim() || '';

    try {
        const urlObj = new URL(baseUrl);
        if (source) urlObj.searchParams.set('utm_source', source);
        if (medium) urlObj.searchParams.set('utm_medium', medium);
        if (campaign) urlObj.searchParams.set('utm_campaign', campaign);
        if (term) urlObj.searchParams.set('utm_term', term);
        if (content) urlObj.searchParams.set('utm_content', content);

        setOutput(urlObj.toString());
    } catch (e) {
        setOutput('Invalid Base URL format. Please include http:// or https:// (e.g. https://example.com)', true);
    }
}

// 72. URL Normalizer
function runUrlNormalizer() {
    const raw = document.getElementById('url-normalizer-input')?.value.trim() || '';
    if (!raw) {
        setOutput('Paste a URL to normalize.', true);
        return;
    }

    try {
        const parsed = new URL(raw);
        // Lowercase protocol and host
        parsed.protocol = parsed.protocol.toLowerCase();
        parsed.hostname = parsed.hostname.toLowerCase();

        // Remove default ports
        if ((parsed.protocol === 'http:' && parsed.port === '80') || (parsed.protocol === 'https:' && parsed.port === '443')) {
            parsed.port = '';
        }

        // Sort query parameters
        const params = Array.from(parsed.searchParams.entries()).sort((a, b) => a[0].localeCompare(b[0]));
        parsed.search = '';
        params.forEach(([k, v]) => parsed.searchParams.append(k, v));

        // Strip trailing slash if root or empty path
        let normalized = parsed.toString();
        if (normalized.endsWith('/') && parsed.pathname === '/') {
            // Standard root URL keeps slash, but path can be cleaned
        }

        const report = [
            '=== NORMALIZED CANONICAL URL ===',
            normalized,
            '',
            'Component Breakdown:',
            `Protocol: ${parsed.protocol}`,
            `Hostname: ${parsed.hostname}`,
            `Port: ${parsed.port || '(standard default)'}`,
            `Path: ${parsed.pathname}`,
            `Sorted Query String: ${parsed.search || '(none)'}`,
            `Hash Fragment: ${parsed.hash || '(none)'}`
        ].join('\n');

        setOutput(report);
    } catch (e) {
        setOutput('URL Normalization Error: ' + e.message, true);
    }
}

// 73. URL Validator
function runUrlValidator() {
    const raw = document.getElementById('url-val-input')?.value.trim() || '';
    if (!raw) {
        setOutput('Paste a URL to validate.', true);
        return;
    }

    const checks = [];
    let isValid = true;

    try {
        const parsed = new URL(raw);

        // Protocol check
        if (!['http:', 'https:', 'ftp:', 'ftps:', 'mailto:', 'ws:', 'wss:'].includes(parsed.protocol)) {
            checks.push(`❌ Protocol "${parsed.protocol}" is non-standard or unsupported.`);
            isValid = false;
        } else {
            checks.push(`✅ Protocol: ${parsed.protocol}`);
        }

        // Host check
        if (!parsed.hostname) {
            checks.push(`❌ Missing valid hostname.`);
            isValid = false;
        } else {
            checks.push(`✅ Hostname: ${parsed.hostname}`);
        }

        // Port check
        if (parsed.port) {
            const p = parseInt(parsed.port, 10);
            if (p < 1 || p > 65535) {
                checks.push(`❌ Invalid port number: ${parsed.port}`);
                isValid = false;
            } else {
                checks.push(`✅ Port: ${parsed.port}`);
            }
        }

        // Path check
        checks.push(`✅ Path: ${parsed.pathname}`);

        // Query check
        if (parsed.search) {
            checks.push(`✅ Query Parameters: ${parsed.searchParams.toString()}`);
        }

        // RFC 3986 illegal characters check
        if (/[\s<>"`{}|\\^]/.test(raw)) {
            checks.push(`⚠️ Contains unsafe / unencoded characters according to RFC 3986.`);
        }

        const report = [
            '=== URL VALIDATION REPORT ===',
            `Status: ${isValid ? 'VALID RFC 3986 URL' : 'INVALID URL'}`,
            `Input: ${raw}`,
            '',
            'Validation Details:',
            checks.map(c => '  ' + c).join('\n'),
            '',
            'Parsed Components:',
            `  • Origin: ${parsed.origin}`,
            `  • Pathname: ${parsed.pathname}`,
            `  • Search Params: ${parsed.search || '(none)'}`,
            `  • Hash / Anchor: ${parsed.hash || '(none)'}`
        ].join('\n');

        setOutput(report);
    } catch (e) {
        setOutput(`=== URL VALIDATION FAILED ===\nStatus: INVALID URL\nError: ${e.message}\nInput: ${raw}`, true);
    }
}

// 74. HTTP Status Code Lookup
const HTTP_STATUS_CODES = {
    100: { name: 'Continue', desc: 'Initial part of request received, client should continue.' },
    101: { name: 'Switching Protocols', desc: 'Server is switching protocols according to Upgrade header.' },
    200: { name: 'OK', desc: 'Standard successful HTTP request response.' },
    201: { name: 'Created', desc: 'Request fulfilled, new resource created.' },
    202: { name: 'Accepted', desc: 'Request accepted for processing, but processing not completed.' },
    204: { name: 'No Content', desc: 'Request processed successfully, returning no response body.' },
    206: { name: 'Partial Content', desc: 'Serving partial content due to Range header (video/large downloads).' },
    301: { name: 'Moved Permanently', desc: 'Resource permanently moved to a new URI; passes SEO link equity.' },
    302: { name: 'Found (Temporary Redirect)', desc: 'Resource temporarily resides at a different URI.' },
    304: { name: 'Not Modified', desc: 'Resource has not been modified since specified version (cached).' },
    307: { name: 'Temporary Redirect', desc: 'Temporary redirect with guarantee that HTTP method will not change.' },
    308: { name: 'Permanent Redirect', desc: 'Permanent redirect with guarantee that HTTP method will not change.' },
    400: { name: 'Bad Request', desc: 'Malformed syntax, invalid parameters, or bad request framing.' },
    401: { name: 'Unauthorized', desc: 'Authentication required or invalid authorization credentials.' },
    403: { name: 'Forbidden', desc: 'Server understands request but refuses to authorize access.' },
    404: { name: 'Not Found', desc: 'Requested resource could not be found on the server.' },
    405: { name: 'Method Not Allowed', desc: 'HTTP method not supported for target resource.' },
    408: { name: 'Request Timeout', desc: 'Server timed out waiting for client request.' },
    409: { name: 'Conflict', desc: 'Request conflicts with current state of resource (e.g. edit conflicts).' },
    410: { name: 'Gone', desc: 'Target resource is permanently deleted and will not be available again.' },
    413: { name: 'Payload Too Large', desc: 'Request body exceeds limits defined by the server.' },
    415: { name: 'Unsupported Media Type', desc: 'Request payload format/Content-Type not supported.' },
    422: { name: 'Unprocessable Entity', desc: 'Syntax is valid but server unable to process instructions/validation.' },
    429: { name: 'Too Many Requests', desc: 'User has sent too many requests in a given amount of time (rate limited).' },
    500: { name: 'Internal Server Error', desc: 'Generic error message when an unexpected condition occurred.' },
    502: { name: 'Bad Gateway', desc: 'Server acting as gateway/proxy received invalid upstream response.' },
    503: { name: 'Service Unavailable', desc: 'Server temporarily overloaded or down for maintenance.' },
    504: { name: 'Gateway Timeout', desc: 'Server acting as gateway/proxy did not receive timely response from upstream.' }
};

function runHttpStatusLookup() {
    const query = (document.getElementById('http-status-query')?.value || '').trim().toLowerCase();

    const matches = Object.entries(HTTP_STATUS_CODES).filter(([code, data]) => {
        return code.includes(query) || data.name.toLowerCase().includes(query) || data.desc.toLowerCase().includes(query);
    });

    if (!matches.length) {
        setOutput(`No matching HTTP status codes found for "${query}".`, true);
        return;
    }

    const report = [
        `=== HTTP STATUS CODE DIRECTORY (${matches.length} Results) ===`,
        '',
        matches.map(([code, data]) => {
            const category = code.startsWith('1') ? 'Informational (1xx)' :
                             code.startsWith('2') ? 'Success (2xx)' :
                             code.startsWith('3') ? 'Redirection (3xx)' :
                             code.startsWith('4') ? 'Client Error (4xx)' : 'Server Error (5xx)';
            return `[${code} ${data.name}] — ${category}\n  Definition: ${data.desc}\n`;
        }).join('\n')
    ].join('\n');

    setOutput(report);
}

// 75. Cookie Parser
function runCookieParser() {
    const raw = document.getElementById('cookie-parser-input')?.value || '';
    if (!raw.trim()) {
        setOutput('Paste Cookie: or Set-Cookie: header string to parse.', true);
        return;
    }

    const lines = raw.split(/\r?\n/).filter(Boolean);
    const parsedCookies = [];

    lines.forEach(line => {
        const clean = line.replace(/^(Cookie:|Set-Cookie:)/i, '').trim();
        const parts = clean.split(';').map(p => p.trim());
        if (!parts.length || !parts[0]) return;

        const [mainKeyVal, ...flags] = parts;
        const eqIdx = mainKeyVal.indexOf('=');
        const name = eqIdx > -1 ? mainKeyVal.slice(0, eqIdx).trim() : mainKeyVal;
        const value = eqIdx > -1 ? decodeURIComponent(mainKeyVal.slice(eqIdx + 1).trim()) : '';

        const flagDetails = {};
        flags.forEach(f => {
            const fEq = f.indexOf('=');
            if (fEq > -1) {
                flagDetails[f.slice(0, fEq).trim().toLowerCase()] = f.slice(fEq + 1).trim();
            } else {
                flagDetails[f.toLowerCase()] = true;
            }
        });

        parsedCookies.push({ name, value, flags: flagDetails });
    });

    const report = [
        `=== HTTP COOKIE PARSE RESULTS (${parsedCookies.length} Cookies) ===`,
        '',
        parsedCookies.map((c, idx) => {
            const flagKeys = Object.keys(c.flags);
            return [
                `Cookie #${idx + 1}: [${c.name}]`,
                `  Value: "${c.value}"`,
                `  Attributes / Flags: ${flagKeys.length ? flagKeys.map(k => `${k}=${c.flags[k]}`).join(', ') : '(None)'}`
            ].join('\n');
        }).join('\n\n'),
        '',
        'JSON Representation:',
        JSON.stringify(parsedCookies, null, 2)
    ].join('\n');

    setOutput(report);
}

// 76. HTTP Request Builder
function runHttpRequestBuilder() {
    const method = document.getElementById('req-method')?.value || 'GET';
    const path = document.getElementById('req-path')?.value || '/api/v1/users';
    const host = document.getElementById('req-host')?.value || 'api.example.com';
    const headersRaw = document.getElementById('req-headers')?.value || 'Accept: application/json\nAuthorization: Bearer sample_token_123';
    const body = document.getElementById('req-body')?.value || '';

    const lines = [
        `${method} ${path} HTTP/1.1`,
        `Host: ${host}`,
        `User-Agent: WebToolsStation/1.0`,
        `Connection: close`
    ];

    if (headersRaw.trim()) {
        lines.push(headersRaw.trim());
    }

    if (body.trim() && ['POST', 'PUT', 'PATCH'].includes(method)) {
        lines.push(`Content-Length: ${new TextEncoder().encode(body).length}`);
        if (!headersRaw.toLowerCase().includes('content-type')) {
            lines.push(`Content-Type: application/json`);
        }
    }

    lines.push('');
    if (body.trim() && ['POST', 'PUT', 'PATCH'].includes(method)) {
        lines.push(body.trim());
    }

    setOutput(lines.join('\r\n'));
}

// 77. CORS Header Generator
function runCorsHeaderGenerator() {
    const origin = document.getElementById('cors-origin')?.value || '*';
    const methods = document.getElementById('cors-methods')?.value || 'GET, POST, PUT, DELETE, OPTIONS';
    const headers = document.getElementById('cors-headers')?.value || 'Content-Type, Authorization, X-Requested-With';
    const credentials = document.getElementById('cors-creds')?.value || 'false';
    const maxAge = document.getElementById('cors-maxage')?.value || '86400';

    const rawHeaders = [
        `Access-Control-Allow-Origin: ${origin}`,
        `Access-Control-Allow-Methods: ${methods}`,
        `Access-Control-Allow-Headers: ${headers}`,
        credentials === 'true' ? `Access-Control-Allow-Credentials: true` : '',
        maxAge ? `Access-Control-Max-Age: ${maxAge}` : ''
    ].filter(Boolean).join('\n');

    const nginxConfig = [
        `# Nginx Configuration Snippet`,
        `add_header 'Access-Control-Allow-Origin' '${origin}' always;`,
        `add_header 'Access-Control-Allow-Methods' '${methods}' always;`,
        `add_header 'Access-Control-Allow-Headers' '${headers}' always;`,
        credentials === 'true' ? `add_header 'Access-Control-Allow-Credentials' 'true' always;` : '',
        `add_header 'Access-Control-Max-Age' '${maxAge}' always;`,
        `if ($request_method = 'OPTIONS') {`,
        `    return 204;`,
        `}`
    ].filter(Boolean).join('\n');

    const expressConfig = [
        `// Node.js Express Middleware`,
        `app.use((req, res, next) => {`,
        `  res.header('Access-Control-Allow-Origin', '${origin}');`,
        `  res.header('Access-Control-Allow-Methods', '${methods}');`,
        `  res.header('Access-Control-Allow-Headers', '${headers}');`,
        credentials === 'true' ? `  res.header('Access-Control-Allow-Credentials', 'true');` : '',
        `  if (req.method === 'OPTIONS') return res.sendStatus(204);`,
        `  next();`,
        `});`
    ].filter(Boolean).join('\n');

    setOutput([
        '=== RAW HTTP CORS HEADERS ===',
        rawHeaders,
        '',
        '=== NGINX CONFIGURATION ===',
        nginxConfig,
        '',
        '=== EXPRESS.JS MIDDLEWARE ===',
        expressConfig
    ].join('\n'));
}

// 78. Browser Info Detector
function runBrowserInfoDetector() {
    const nav = window.navigator;
    const scr = window.screen;

    const glSupport = (() => {
        try {
            const canvas = document.createElement('canvas');
            return !!(window.WebGLRenderingContext && (canvas.getContext('webgl') || canvas.getContext('experimental-webgl')));
        } catch { return false; }
    })();

    const lsSupport = (() => {
        try {
            localStorage.setItem('__test', '1');
            localStorage.removeItem('__test');
            return true;
        } catch { return false; }
    })();

    const info = [
        '=== CLIENT ENVIRONMENT DIAGNOSTIC ===',
        `User Agent: ${nav.userAgent}`,
        `Platform / OS: ${nav.platform}`,
        `Browser Language: ${nav.language} (All: ${(nav.languages || []).join(', ')})`,
        `Online Status: ${nav.onLine ? 'Connected (Online)' : 'Offline'}`,
        `Cookies Enabled: ${nav.cookieEnabled ? 'Yes' : 'No'}`,
        `Do Not Track (DNT): ${nav.doNotTrack || 'Not specified'}`,
        `Timezone: ${Intl.DateTimeFormat().resolvedOptions().timeZone} (UTC Offset: ${-(new Date().getTimezoneOffset() / 60)}h)`,
        '',
        '=== SCREEN & DISPLAY ===',
        `Screen Resolution: ${scr.width} × ${scr.height} px`,
        `Available Dimensions: ${scr.availWidth} × ${scr.availHeight} px`,
        `Viewport Dimensions: ${window.innerWidth} × ${window.innerHeight} px`,
        `Color Depth: ${scr.colorDepth}-bit`,
        `Device Pixel Ratio (DPR): ${window.devicePixelRatio || 1}x`,
        '',
        '=== HARDWARE & CAPABILITIES ===',
        `Logical CPU Cores: ${nav.hardwareConcurrency || 'Unknown'}`,
        `Device Memory (RAM): ${nav.deviceMemory ? nav.deviceMemory + ' GB approx' : 'Not exposed'}`,
        `Touch Points: ${nav.maxTouchPoints || 0}`,
        `WebGL Acceleration: ${glSupport ? 'Supported' : 'Not available'}`,
        `LocalStorage Support: ${lsSupport ? 'Enabled' : 'Disabled / Restricted'}`
    ].join('\n');

    setOutput(info);
}
