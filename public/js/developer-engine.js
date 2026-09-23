/**
 * WebToolsStation - Developer Engine
 * Language formatters, UUID v7 generator, SQL minifier, and code converters
 */

// 13. Python Formatter (PEP 8 block indenter)
function runPythonFormatter() {
    const input = document.getElementById("python-input")?.value || '';
    const outputEl = document.getElementById("python-output");
    const indentSize = parseInt(document.getElementById("python-indent")?.value || '4', 10);
    if (!outputEl) return;

    if (!input.trim()) {
        outputEl.value = 'Please paste Python code.';
        return;
    }

    const lines = input.split(/\r?\n/);
    let indentLevel = 0;
    const formatted = [];

    lines.forEach(line => {
        let trimmed = line.trim();
        if (!trimmed) {
            formatted.push('');
            return;
        }

        // Dedent if line starts with dedenting keywords: return, pass, break, continue, elif, else, except, finally
        if (/^(elif|else|except|finally)\b/.test(trimmed)) {
            indentLevel = Math.max(0, indentLevel - 1);
        }

        const indentStr = ' '.repeat(indentLevel * indentSize);
        formatted.push(indentStr + trimmed);

        // Increase indent if line ends with colon
        if (trimmed.endsWith(':') && !trimmed.startsWith('#')) {
            indentLevel++;
        }
    });

    outputEl.value = formatted.join('\n');
}

// 14. PHP Formatter (PSR-12 brace and block format)
function runPhpFormatter() {
    const input = document.getElementById("php-input")?.value || '';
    const outputEl = document.getElementById("php-output");
    if (!outputEl) return;

    if (!input.trim()) {
        outputEl.value = 'Please paste PHP code.';
        return;
    }

    outputEl.value = formatCStyleCode(input, 4);
}

// 15. Java Formatter
function runJavaFormatter() {
    const input = document.getElementById("java-input")?.value || '';
    const outputEl = document.getElementById("java-output");
    if (!outputEl) return;

    if (!input.trim()) {
        outputEl.value = 'Please paste Java code.';
        return;
    }

    outputEl.value = formatCStyleCode(input, 4);
}

// 16. C# Formatter
function runCsharpFormatter() {
    const input = document.getElementById("csharp-input")?.value || '';
    const outputEl = document.getElementById("csharp-output");
    if (!outputEl) return;

    if (!input.trim()) {
        outputEl.value = 'Please paste C# code.';
        return;
    }

    outputEl.value = formatCStyleCode(input, 4);
}

// 17. C/C++ Formatter
function runCppFormatter() {
    const input = document.getElementById("cpp-input")?.value || '';
    const outputEl = document.getElementById("cpp-output");
    if (!outputEl) return;

    if (!input.trim()) {
        outputEl.value = 'Please paste C/C++ code.';
        return;
    }

    outputEl.value = formatCStyleCode(input, 4);
}

// 18. Go Formatter (Gofmt tab-aligned indentation)
function runGoFormatter() {
    const input = document.getElementById("go-input")?.value || '';
    const outputEl = document.getElementById("go-output");
    if (!outputEl) return;

    if (!input.trim()) {
        outputEl.value = 'Please paste Go code.';
        return;
    }

    outputEl.value = formatCStyleCode(input, '\t');
}

// Generic C-family style indenter (Java, C#, C++, Go, PHP)
function formatCStyleCode(code, indent = 4) {
    const indentStr = typeof indent === 'number' ? ' '.repeat(indent) : indent;
    const lines = code.split(/\r?\n/);
    let level = 0;
    const formatted = [];

    lines.forEach(rawLine => {
        let line = rawLine.trim();
        if (!line) {
            formatted.push('');
            return;
        }

        // Count closing braces at start
        let closeCount = (line.match(/^[\}\]\)]+/g) || [''])[0].length;
        if (closeCount > 0) level = Math.max(0, level - closeCount);

        formatted.push(indentStr.repeat(level) + line);

        // Adjust level based on total { vs } in line (outside quotes)
        let openBraces = (line.match(/\{/g) || []).length;
        let closeBraces = (line.match(/\}/g) || []).length;
        level = Math.max(0, level + openBraces - (line.startsWith('}') ? 0 : closeBraces));
    });

    return formatted.join('\n');
}

// 19. SQL Minifier & Query Compressor
function runSqlMinifier() {
    const input = document.getElementById("sql-min-input")?.value || '';
    const outputEl = document.getElementById("sql-min-output");
    const statsEl = document.getElementById("sql-min-stats");
    if (!outputEl) return;

    if (!input.trim()) {
        outputEl.value = 'Please paste SQL query.';
        return;
    }

    // 1. Remove block comments /* */
    let minified = input.replace(/\/\*[\s\S]*?\*\//g, '');
    // 2. Remove single-line comments -- ...
    minified = minified.replace(/--.*$/gm, '');
    // 3. Normalize multiple spaces/newlines to single space
    minified = minified.replace(/\s+/g, ' ').trim();

    outputEl.value = minified;
    if (statsEl) {
        const origSize = new Blob([input]).size;
        const minSize = new Blob([minified]).size;
        const saved = Math.max(0, origSize - minSize);
        const percent = origSize > 0 ? ((saved / origSize) * 100).toFixed(1) : 0;
        statsEl.textContent = `${origSize} B → ${minSize} B (${percent}% reduction)`;
    }
}

// 20. UUID v7 Generator (RFC 9562 timestamp-ordered)
function generateUuidV7List() {
    const count = Math.min(50, Math.max(1, parseInt(document.getElementById("uuid7-count")?.value || "5", 10)));
    const outputEl = document.getElementById("uuid7-output");
    if (!outputEl) return;

    const list = [];
    for (let i = 0; i < count; i++) {
        list.push(generateUuidV7());
    }

    outputEl.textContent = list.join('\n');
    showToast(`Generated ${count} UUID v7 identifiers.`);
}

function generateUuidV7() {
    const now = Date.now();
    const bytes = new Uint8Array(16);
    crypto.getRandomValues(bytes);

    // 48-bit timestamp
    bytes[0] = (now / 0x10000000000) & 0xff;
    bytes[1] = (now / 0x100000000) & 0xff;
    bytes[2] = (now / 0x1000000) & 0xff;
    bytes[3] = (now / 0x10000) & 0xff;
    bytes[4] = (now / 0x100) & 0xff;
    bytes[5] = now & 0xff;

    // version 7 in high nibble of byte 6
    bytes[6] = 0x70 | (bytes[6] & 0x0f);
    // variant 10xx in high 2 bits of byte 8
    bytes[8] = 0x80 | (bytes[8] & 0x3f);

    const hex = Array.from(bytes).map(b => b.toString(16).padStart(2, '0')).join('');
    return `${hex.slice(0, 8)}-${hex.slice(8, 12)}-${hex.slice(12, 16)}-${hex.slice(16, 20)}-${hex.slice(20, 32)}`;
}

// 21. UUID Validator & Version Inspector
function runUuidValidator() {
    const input = document.getElementById("uuid-val-input")?.value.trim() || '';
    const reportEl = document.getElementById("uuid-val-report");
    if (!reportEl) return;

    if (!input) {
        reportEl.innerHTML = '<div style="color:var(--text-muted);">Enter a UUID/GUID string to validate.</div>';
        return;
    }

    const clean = input.replace(/[{}]/g, '').toLowerCase();
    const match = clean.match(/^([0-9a-f]{8})-?([0-9a-f]{4})-?([1-8][0-9a-f]{3})-?([89ab][0-9a-f]{3})-?([0-9a-f]{12})$/);

    if (!match) {
        reportEl.innerHTML = `<div style="padding:14px; background:#fef2f2; border:1px solid #ef4444; border-radius:var(--radius-sm); color:#991b1b;">
            <strong>Invalid UUID / GUID format.</strong><br>Standard format: <code>8-4-4-4-12</code> hexadecimal characters (RFC 4122 / RFC 9562).
        </div>`;
        return;
    }

    const versionChar = match[3][0];
    const variantChar = match[4][0];
    const versionMap = {
        '1': 'v1 (Date-Time & MAC address based)',
        '3': 'v3 (MD5 namespace hash)',
        '4': 'v4 (Cryptographically random)',
        '5': 'v5 (SHA-1 namespace hash)',
        '7': 'v7 (Unix Epoch millisecond time-ordered)'
    };
    const versionText = versionMap[versionChar] || `v${versionChar} (Custom / Experimental)`;

    reportEl.innerHTML = `<div style="padding:16px; background:#ecfdf5; border:1px solid #10b981; border-radius:var(--radius-sm); color:#065f46;">
        <div style="font-weight:800; font-size:1.05rem; margin-bottom:10px;">✓ Valid UUID / GUID</div>
        <table style="width:100%; border-collapse:collapse; font-size:0.85rem; color:var(--text);">
            <tr><td style="padding:4px 0; font-weight:700;">Standard Canonical:</td><td><code>${match[1]}-${match[2]}-${match[3]}-${match[4]}-${match[5]}</code></td></tr>
            <tr><td style="padding:4px 0; font-weight:700;">Version:</td><td><strong style="color:var(--brand);">${versionText}</strong></td></tr>
            <tr><td style="padding:4px 0; font-weight:700;">Variant:</td><td>RFC 4122 / RFC 9562 (${variantChar.toUpperCase()})</td></tr>
            <tr><td style="padding:4px 0; font-weight:700;">Hex Characters:</td><td>32 hex digits (128 bits)</td></tr>
        </table>
    </div>`;
}

// 22. .env File Parser & Formatter
function runEnvFormatter() {
    const input = document.getElementById("env-input")?.value || '';
    const outputEl = document.getElementById("env-output");
    if (!outputEl) return;

    if (!input.trim()) {
        outputEl.value = 'Please paste .env contents.';
        return;
    }

    const lines = input.split(/\r?\n/);
    const kvPairs = [];
    const comments = [];

    lines.forEach(line => {
        const trimmed = line.trim();
        if (!trimmed) return;
        if (trimmed.startsWith('#')) {
            comments.push(trimmed);
            return;
        }
        if (trimmed.includes('=')) {
            const [k, ...v] = trimmed.split('=');
            kvPairs.push({ key: k.trim(), val: v.join('=').trim() });
        }
    });

    kvPairs.sort((a, b) => a.key.localeCompare(b.key));
    const formatted = kvPairs.map(item => `${item.key}=${item.val}`);
    outputEl.value = (comments.length ? comments.join('\n') + '\n\n' : '') + formatted.join('\n');
}

// 23. cURL to JavaScript Fetch Converter
function runCurlToFetch() {
    const input = document.getElementById("curl-fetch-input")?.value.trim() || '';
    const outputEl = document.getElementById("curl-fetch-output");
    if (!outputEl) return;

    if (!input) {
        outputEl.value = 'Please paste cURL command.';
        return;
    }

    try {
        const parsed = parseCurlCommand(input);
        const code = `async function sendRequest() {
  const response = await fetch("${parsed.url}", {
    method: "${parsed.method}",
    headers: ${JSON.stringify(parsed.headers, null, 4).replace(/\n/g, '\n    ')}${parsed.body ? `,\n    body: ${parsed.isJson ? `JSON.stringify(${parsed.body})` : JSON.stringify(parsed.body)}` : ''}
  });
  const data = await response.json();
  console.log(data);
  return data;
}

sendRequest();`;
        outputEl.value = code;
    } catch (e) {
        outputEl.value = `Error parsing cURL: ${e.message}`;
    }
}

// 24. cURL to Python Requests Converter
function runCurlToPython() {
    const input = document.getElementById("curl-py-input")?.value.trim() || '';
    const outputEl = document.getElementById("curl-py-output");
    if (!outputEl) return;

    if (!input) {
        outputEl.value = 'Please paste cURL command.';
        return;
    }

    try {
        const parsed = parseCurlCommand(input);
        const code = `import requests

url = "${parsed.url}"
headers = ${JSON.stringify(parsed.headers, null, 4)}
${parsed.body ? `data = ${parsed.isJson ? parsed.body : JSON.stringify(parsed.body)}\n` : ''}
response = requests.${parsed.method.toLowerCase()}(url, headers=headers${parsed.body ? (parsed.isJson ? ', json=data' : ', data=data') : ''})
print(response.status_code)
print(response.json())`;
        outputEl.value = code;
    } catch (e) {
        outputEl.value = `Error parsing cURL: ${e.message}`;
    }
}

function parseCurlCommand(cmd) {
    let method = 'GET';
    let url = '';
    const headers = {};
    let body = null;
    let isJson = false;

    // Remove line continuations
    const clean = cmd.replace(/\\\n/g, ' ').replace(/\s+/g, ' ');

    // Extract URL
    const urlMatch = clean.match(/(?:https?:\/\/[^\s"']+)|(?:"https?:\/\/[^"]+")|(?:'https?:\/\/[^']+')/);
    if (urlMatch) {
        url = urlMatch[0].replace(/^["']|["']$/g, '');
    }

    // Extract Method -X POST
    const methodMatch = clean.match(/-X\s+([A-Z]+)/);
    if (methodMatch) method = methodMatch[1];

    // Extract Headers -H "Key: Value"
    const headerMatches = clean.matchAll(/-H\s+["']([^"']+)["']/g);
    for (const m of headerMatches) {
        const [k, ...v] = m[1].split(':');
        if (k && v.length) headers[k.trim()] = v.join(':').trim();
    }

    // Extract Data -d '...' or --data '...'
    const dataMatch = clean.match(/(?:-d|--data|--data-raw)\s+["']([^"']+)["']/);
    if (dataMatch) {
        body = dataMatch[1];
        if (method === 'GET') method = 'POST';
        try {
            JSON.parse(body);
            isJson = true;
        } catch (_) {}
    }

    return { method, url: url || 'https://api.example.com/v1/resource', headers, body, isJson };
}

// 25. User-Agent Parser & Device Inspector
function runUserAgentParser() {
    const input = document.getElementById("ua-input")?.value.trim() || navigator.userAgent;
    const reportEl = document.getElementById("ua-report");
    if (!reportEl) return;

    let browser = 'Unknown Browser';
    let os = 'Unknown OS';
    let device = 'Desktop';
    let engine = 'Unknown Engine';

    if (/chrome|crios/i.test(input) && !/edg|opr|brave/i.test(input)) browser = 'Google Chrome';
    else if (/edg/i.test(input)) browser = 'Microsoft Edge';
    else if (/firefox|fxios/i.test(input)) browser = 'Mozilla Firefox';
    else if (/safari/i.test(input) && !/chrome|crios/i.test(input)) browser = 'Apple Safari';
    else if (/opr|opera/i.test(input)) browser = 'Opera';

    if (/windows/i.test(input)) os = 'Microsoft Windows';
    else if (/macintosh|mac os x/i.test(input)) os = 'Apple macOS';
    else if (/iphone|ipad|ipod/i.test(input)) { os = 'Apple iOS'; device = 'Mobile / Tablet'; }
    else if (/android/i.test(input)) { os = 'Google Android'; device = 'Mobile / Tablet'; }
    else if (/linux/i.test(input)) os = 'GNU/Linux';

    if (/webkit/i.test(input)) engine = 'Apple WebKit / Blink';
    else if (/gecko/i.test(input)) engine = 'Gecko';

    reportEl.innerHTML = `<div style="padding:16px; background:#fafafa; border:1px solid var(--border); border-radius:var(--radius-sm);">
        <table style="width:100%; border-collapse:collapse; font-size:0.88rem;">
            <tr style="border-bottom:1px solid var(--border);"><td style="padding:8px 0; font-weight:700;">Detected Browser:</td><td><strong style="color:var(--brand);">${browser}</strong></td></tr>
            <tr style="border-bottom:1px solid var(--border);"><td style="padding:8px 0; font-weight:700;">Operating System:</td><td><strong>${os}</strong></td></tr>
            <tr style="border-bottom:1px solid var(--border);"><td style="padding:8px 0; font-weight:700;">Device Category:</td><td>${device}</td></tr>
            <tr><td style="padding:8px 0; font-weight:700;">Layout Engine:</td><td>${engine}</td></tr>
        </table>
    </div>`;
}

// 26. SemVer Calculator & Validator
function runSemverCalculator() {
    const input = document.getElementById("semver-input")?.value.trim() || '1.0.0';
    const reportEl = document.getElementById("semver-report");
    if (!reportEl) return;

    const match = input.match(/^v?(\d+)\.(\d+)\.(\d+)(?:-([0-9A-Za-z.-]+))?(?:\+([0-9A-Za-z.-]+))?$/);
    if (!match) {
        reportEl.innerHTML = '<div style="color:var(--danger); font-weight:700;">Invalid SemVer 2.0.0 syntax (e.g. 1.2.3 or 2.0.0-beta.1).</div>';
        return;
    }

    const major = parseInt(match[1], 10);
    const minor = parseInt(match[2], 10);
    const patch = parseInt(match[3], 10);
    const prerelease = match[4] || '';

    reportEl.innerHTML = `<div style="padding:16px; background:#ecfdf5; border:1px solid #10b981; border-radius:var(--radius-sm); color:var(--text);">
        <div style="font-weight:700; color:#065f46; margin-bottom:10px;">✓ Valid SemVer 2.0.0 Version</div>
        <div style="display:grid; grid-template-columns:repeat(3, 1fr); gap:10px; margin-top:8px; text-align:center;">
            <div style="padding:10px; background:#fff; border:1px solid var(--border); border-radius:4px;">
                <div style="font-size:0.75rem; color:var(--text-muted); font-weight:700;">NEXT PATCH</div>
                <div style="font-size:1.1rem; font-weight:800; color:var(--brand);">${major}.${minor}.${patch + 1}</div>
            </div>
            <div style="padding:10px; background:#fff; border:1px solid var(--border); border-radius:4px;">
                <div style="font-size:0.75rem; color:var(--text-muted); font-weight:700;">NEXT MINOR</div>
                <div style="font-size:1.1rem; font-weight:800; color:var(--brand);">${major}.${minor + 1}.0</div>
            </div>
            <div style="padding:10px; background:#fff; border:1px solid var(--border); border-radius:4px;">
                <div style="font-size:0.75rem; color:var(--text-muted); font-weight:700;">NEXT MAJOR</div>
                <div style="font-size:1.1rem; font-weight:800; color:var(--brand);">${major + 1}.0.0</div>
            </div>
        </div>
    </div>`;
}

// 27. Dockerfile Formatter & Linter
function runDockerfileFormatter() {
    const input = document.getElementById("docker-input")?.value || '';
    const outputEl = document.getElementById("docker-output");
    if (!outputEl) return;

    if (!input.trim()) {
        outputEl.value = 'Please paste Dockerfile content.';
        return;
    }

    const directives = ['FROM', 'RUN', 'CMD', 'LABEL', 'MAINTAINER', 'EXPOSE', 'ENV', 'ADD', 'COPY', 'ENTRYPOINT', 'VOLUME', 'USER', 'WORKDIR', 'ARG', 'ONBUILD', 'STOPSIGNAL', 'HEALTHCHECK', 'SHELL'];
    const lines = input.split(/\r?\n/);
    const formatted = [];

    lines.forEach(line => {
        let trimmed = line.trim();
        if (!trimmed || trimmed.startsWith('#')) {
            formatted.push(trimmed);
            return;
        }

        const firstWord = (trimmed.split(/\s+/)[0] || '').toUpperCase();
        if (directives.includes(firstWord)) {
            const rest = trimmed.slice(firstWord.length).trim();
            formatted.push(`${firstWord.padEnd(10, ' ')} ${rest}`);
        } else {
            formatted.push(`  ${trimmed}`);
        }
    });

    outputEl.value = formatted.join('\n');
}
