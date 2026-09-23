/**
 * WebToolsStation - Professional Developer Tools Suite
 * Pure Client-Side JavaScript Runtime. Zero Telemetry. Zero Remote Server Calls.
 */

const DOM_ELEMENT_NODE = 1;
const DOM_TEXT_NODE = 3;
const DOM_COMMENT_NODE = 8;

// ==========================================
// 1. CODE MINIFIERS
// ==========================================

function updateMinifierMetrics(origText, miniText) {
    const origBlob = new Blob([origText]);
    const miniBlob = new Blob([miniText]);
    const origBytes = origBlob.size;
    const miniBytes = miniBlob.size;
    const origChars = origText.length;
    const miniChars = miniText.length;
    const savedBytes = Math.max(0, origBytes - miniBytes);
    const reduction = origBytes > 0 ? ((savedBytes / origBytes) * 100).toFixed(1) : 0;

    const inputStats = document.getElementById('input-stats');
    if (inputStats) inputStats.textContent = `${origChars.toLocaleString()} characters | ${formatBytes(origBytes)}`;

    const outputStats = document.getElementById('output-stats');
    if (outputStats) outputStats.textContent = `${miniChars.toLocaleString()} characters | ${formatBytes(miniBytes)}`;

    const compStats = document.getElementById('compression-stats');
    if (compStats) compStats.textContent = `${reduction}% reduction`;

    const sOrig = document.getElementById('stat-orig-size');
    if (sOrig) sOrig.textContent = formatBytes(origBytes);

    const sMini = document.getElementById('stat-mini-size');
    if (sMini) sMini.textContent = formatBytes(miniBytes);

    const sSaved = document.getElementById('stat-saved-bytes');
    if (sSaved) sSaved.textContent = formatBytes(savedBytes) + ' saved';

    const sRed = document.getElementById('stat-reduction-pct');
    if (sRed) sRed.textContent = `${reduction}%`;
}

function formatBytes(bytes) {
    if (bytes === 0) return '0 B';
    const k = 1024;
    const sizes = ['B', 'KB', 'MB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + (sizes[i] || 'B');
}

function showMinifierError(msg) {
    const errBox = document.getElementById('minifier-error');
    const errMsg = document.getElementById('minifier-error-msg');
    if (errBox && errMsg) {
        if (msg) {
            errMsg.textContent = msg;
            errBox.style.display = 'block';
        } else {
            errBox.style.display = 'none';
        }
    }
}

function runMinifier() {
    showMinifierError(null);
    const inputEl = document.getElementById('minifier-input');
    const outputEl = document.getElementById('minifier-output');
    if (!inputEl || !outputEl) return;

    const input = inputEl.value;
    if (!input.trim()) {
        showToast("Please enter or paste code to minify.", true);
        outputEl.value = '';
        updateMinifierMetrics('', '');
        return;
    }

    try {
        let minified = '';
        if (currentToolSlug === 'html-minifier') {
            minified = minifyHtml(input);
        } else if (currentToolSlug === 'css-minifier') {
            minified = minifyCss(input);
        } else if (currentToolSlug === 'javascript-minifier') {
            minified = minifyJs(input);
        } else if (currentToolSlug === 'json-minifier') {
            minified = minifyJsonStrict(input);
        } else if (currentToolSlug === 'xml-minifier') {
            minified = minifyXml(input);
        }

        outputEl.value = minified;
        updateMinifierMetrics(input, minified);
        showToast("Code minified successfully!");
    } catch (err) {
        showMinifierError(err.message || "Failed to minify code. Please check your syntax.");
        showToast("Minification failed.", true);
    }
}

function minifyHtml(html) {
    // 1. Remove comments (preserve conditional comments)
    let res = html.replace(/<!--(?!\s*\[if)[\s\S]*?-->/g, '');
    // 2. Collapse whitespace outside tags and between tags
    res = res.replace(/>\s+</g, '><');
    // 3. Collapse multiple spaces inside tags
    res = res.replace(/\s{2,}/g, ' ');
    // 4. Remove space around equals sign in attributes
    res = res.replace(/\s*=\s*/g, '=');
    // 5. Trim leading/trailing whitespace
    return res.trim();
}

function minifyCss(css) {
    // 1. Strip comments
    let res = css.replace(/\/\*[\s\S]*?\*\//g, '');
    // 2. Collapse whitespace
    res = res.replace(/\s+/g, ' ');
    // 3. Remove space around symbols
    res = res.replace(/\s*([{}:;,>+~])\s*/g, '$1');
    // 4. Remove trailing semicolons before closing brace
    res = res.replace(/;}/g, '}');
    // 5. Strip units on 0
    res = res.replace(/(?<=[:\s])0(px|em|rem|%|in|cm|mm|pt|pc)/gi, '0');
    // 6. Strip leading zeros on decimals: 0.5 -> .5
    res = res.replace(/(?<=[:\s])0(\.\d+)/g, '$1');
    return res.trim();
}

function minifyJs(js) {
    // Safe JS minifier preserving string literals and regex literals
    let output = '';
    let inString = false;
    let stringChar = '';
    let inRegex = false;
    let inSingleComment = false;
    let inMultiComment = false;

    for (let i = 0; i < js.length; i++) {
        const char = js[i];
        const next = js[i + 1] || '';
        const prev = js[i - 1] || '';

        if (inSingleComment) {
            if (char === '\n' || char === '\r') {
                inSingleComment = false;
                output += '\n';
            }
            continue;
        }

        if (inMultiComment) {
            if (char === '*' && next === '/') {
                inMultiComment = false;
                i++;
            }
            continue;
        }

        if (inString) {
            output += char;
            if (char === stringChar && prev !== '\\') {
                inString = false;
            }
            continue;
        }

        if (inRegex) {
            output += char;
            if (char === '/' && prev !== '\\') {
                inRegex = false;
            }
            continue;
        }

        // Check for comment starts
        if (char === '/' && next === '/') {
            inSingleComment = true;
            i++;
            continue;
        }

        if (char === '/' && next === '*') {
            inMultiComment = true;
            i++;
            continue;
        }

        // Check for string starts
        if (char === '"' || char === "'" || char === '`') {
            inString = true;
            stringChar = char;
            output += char;
            continue;
        }

        // Check for regex literal start (heuristic after operator or return)
        if (char === '/' && /[(,=:[!&|?{};\n\r]\s*$/.test(output)) {
            inRegex = true;
            output += char;
            continue;
        }

        output += char;
    }

    // Collapse multiple empty lines and excessive spaces
    let lines = output.split('\n')
        .map(l => l.trim())
        .filter(l => l.length > 0);

    return lines.join('\n')
        .replace(/\s*([=+\-*\/%&|^!<>?:;{},()[\]])\s*/g, '$1')
        .replace(/;}/g, '}');
}

function minifyJsonStrict(json) {
    const parsed = JSON.parse(json);
    return JSON.stringify(parsed);
}

function minifyXml(xml) {
    const parser = new DOMParser();
    const doc = parser.parseFromString(xml, 'application/xml');
    const parserError = doc.querySelector('parsererror');
    if (parserError) {
        throw new Error("Invalid XML: " + parserError.textContent.split('\n')[0]);
    }
    // Remove comments and collapse whitespace between tags
    return xml.replace(/<!--[\s\S]*?-->/g, '')
              .replace(/>\s+</g, '><')
              .replace(/\s{2,}/g, ' ')
              .trim();
}

function clearMinifierInput() {
    const inEl = document.getElementById('minifier-input');
    const outEl = document.getElementById('minifier-output');
    if (inEl) inEl.value = '';
    if (outEl) outEl.value = '';
    showMinifierError(null);
    updateMinifierMetrics('', '');
    showToast("Inputs cleared.");
}

async function pasteMinifierClipboard() {
    try {
        const text = await navigator.clipboard.readText();
        const inEl = document.getElementById('minifier-input');
        if (inEl) {
            inEl.value = text;
            updateMinifierMetrics(text, '');
            showToast("Pasted from clipboard!");
        }
    } catch (e) {
        showToast("Clipboard read permission denied.", true);
    }
}

function loadMinifierSample() {
    const samples = {
        'html-minifier': `<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Page Header and Meta Tags -->
    <meta charset="UTF-8">
    <title>WebToolsStation Sample Document</title>
    <style>
        .card { padding: 16px; margin: 10px; }
    </style>
</head>
<body>
    <!-- Main Content Container -->
    <div class="container">
        <h1>High Performance Client-Side Utilities</h1>
        <p>This markup contains redundant spaces and developer comments.</p>
    </div>
</body>
</html>`,
        'css-minifier': `/* Global Stylesheet for Web Application */
:root {
    --primary-color: #0284c7;
    --border-radius: 8px;
}

.button-primary {
    display: inline-flex;
    padding: 10px 16px;
    border-radius: var(--border-radius);
    background-color: var(--primary-color);
    color: #ffffff;
    margin: 0px 0px 12px 0px;
    font-size: 0.95rem;
}

.button-primary:hover {
    background-color: #0369a1;
    opacity: 0.90;
}`,
        'javascript-minifier': `// Client-side authentication helper
function calculateSessionStatus(token, expiresAt) {
    /* Multi-line explanation:
       Check if current timestamp exceeds expiration */
    const now = Math.floor(Date.now() / 1000);
    const isValid = Boolean(token) && expiresAt > now;

    if (isValid) {
        return { active: true, remaining: expiresAt - now };
    } else {
        return { active: false, remaining: 0 };
    }
}`,
        'json-minifier': `{\n  "platform": "WebToolsStation",\n  "version": 2,\n  "status": "production",\n  "tools": [\n    "html-minifier",\n    "css-minifier",\n    "javascript-minifier"\n  ]\n}`,
        'xml-minifier': `<?xml version="1.0" encoding="UTF-8"?>
<!-- Catalog of Developer Utilities -->
<catalog version="2.0">
    <utility id="u1">
        <name>HTML Minifier</name>
        <category>Developer Tools</category>
    </utility>
    <utility id="u2">
        <name>CSS Minifier</name>
        <category>Developer Tools</category>
    </utility>
</catalog>`
    };

    const s = samples[currentToolSlug];
    if (s) {
        const inEl = document.getElementById('minifier-input');
        if (inEl) {
            inEl.value = s;
            updateMinifierMetrics(s, '');
            showToast("Sample loaded.");
            runMinifier();
        }
    }
}

function downloadMinifiedOutput() {
    const outEl = document.getElementById('minifier-output');
    const text = outEl?.value || '';
    if (!text.trim()) {
        showToast("No minified code to download.", true);
        return;
    }
    const extMap = {
        'html-minifier': 'index.min.html',
        'css-minifier': 'styles.min.css',
        'javascript-minifier': 'script.min.js',
        'json-minifier': 'data.min.json',
        'xml-minifier': 'document.min.xml'
    };
    const filename = extMap[currentToolSlug] || 'minified.txt';
    const blob = new Blob([text], { type: 'text/plain;charset=utf-8' });
    const url = URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = filename;
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    URL.revokeObjectURL(url);
    showToast("Downloaded " + filename);
}

// ==========================================
// 2. CODE BEAUTIFIERS / FORMATTERS
// ==========================================

function getIndentString() {
    const sel = document.getElementById('indent-size');
    const val = sel ? sel.value : '4';
    if (val === '2') return '  ';
    if (val === 'tab') return '\t';
    return '    '; // default 4 spaces
}

function showFormatterError(msg) {
    const errBox = document.getElementById('formatter-error');
    const errMsg = document.getElementById('formatter-error-msg');
    if (errBox && errMsg) {
        if (msg) {
            errMsg.textContent = msg;
            errBox.style.display = 'block';
        } else {
            errBox.style.display = 'none';
        }
    }
}

function runFormatter() {
    showFormatterError(null);
    const inputEl = document.getElementById('formatter-input');
    const outputEl = document.getElementById('formatter-output');
    if (!inputEl || !outputEl) return;

    const input = inputEl.value;
    if (!input.trim()) {
        showToast("Please enter or paste code to format.", true);
        outputEl.value = '';
        return;
    }

    const indent = getIndentString();

    try {
        let formatted = '';
        if (currentToolSlug === 'html-formatter') {
            formatted = formatHtmlCode(input, indent);
        } else if (currentToolSlug === 'css-formatter') {
            formatted = formatCssCode(input, indent);
        } else if (currentToolSlug === 'javascript-formatter') {
            formatted = formatJsCode(input, indent);
        } else if (currentToolSlug === 'xml-formatter') {
            formatted = formatXmlCode(input, indent);
        } else if (currentToolSlug === 'sql-formatter') {
            const uppercase = document.getElementById('sql-uppercase-kw')?.checked ?? true;
            formatted = formatSqlCode(input, indent, uppercase);
        }

        outputEl.value = formatted;
        updateFormatterStats(input, formatted);
        showToast("Formatted successfully!");
    } catch (err) {
        showFormatterError(err.message || "Formatting error. Please check your syntax.");
        showToast("Formatting failed.", true);
    }
}

function updateFormatterStats(inText, outText) {
    const inStats = document.getElementById('formatter-input-stats');
    if (inStats) {
        const lines = inText ? inText.split('\n').length : 0;
        inStats.textContent = `${lines} lines | ${inText.length} characters`;
    }
    const outStats = document.getElementById('formatter-output-stats');
    if (outStats) {
        const lines = outText ? outText.split('\n').length : 0;
        outStats.textContent = `${lines} lines | ${outText.length} characters`;
    }
}

function formatHtmlCode(html, indentStr) {
    const voidTags = new Set([
        'area', 'base', 'br', 'col', 'embed', 'hr', 'img', 'input', 'link', 'meta', 'param', 'source', 'track', 'wbr'
    ]);

    // Tokenize tags and text
    const tokens = html.replace(/>\s*</g, '><').replace(/</g, '~#~<').replace(/>/g, '>~#~').split('~#~').filter(t => t.trim().length > 0);

    let depth = 0;
    let lines = [];

    for (let token of tokens) {
        token = token.trim();
        if (!token) continue;

        if (token.startsWith('</')) {
            // Closing tag
            depth = Math.max(0, depth - 1);
            lines.push(indentStr.repeat(depth) + token);
        } else if (token.startsWith('<') && !token.startsWith('<!')) {
            // Opening tag or void tag
            const tagMatch = token.match(/<([a-zA-Z0-9\-]+)/);
            const tagName = tagMatch ? tagMatch[1].toLowerCase() : '';
            const isSelfClosing = token.endsWith('/>') || voidTags.has(tagName);

            lines.push(indentStr.repeat(depth) + token);
            if (!isSelfClosing) {
                depth++;
            }
        } else {
            // Text or comment or doctype
            lines.push(indentStr.repeat(depth) + token);
        }
    }

    return lines.join('\n');
}

function formatCssCode(css, indentStr) {
    // Strip comments, normalize braces and semicolons
    let clean = css.replace(/\/\*[\s\S]*?\*\//g, (match) => match.trim());
    clean = clean.replace(/\s+/g, ' ');
    clean = clean.replace(/\s*{\s*/g, ' {\n');
    clean = clean.replace(/;\s*/g, ';\n');
    clean = clean.replace(/\s*}\s*/g, '\n}\n\n');

    let lines = clean.split('\n');
    let depth = 0;
    let formattedLines = [];

    for (let rawLine of lines) {
        let line = rawLine.trim();
        if (!line) continue;

        if (line.endsWith('}')) {
            depth = Math.max(0, depth - 1);
            formattedLines.push(indentStr.repeat(depth) + line);
        } else if (line.endsWith('{')) {
            formattedLines.push(indentStr.repeat(depth) + line);
            depth++;
        } else {
            // Property declaration: ensure space after colon
            line = line.replace(/:\s*/, ': ');
            formattedLines.push(indentStr.repeat(depth) + line);
        }
    }

    return formattedLines.join('\n').trim();
}

function formatJsCode(js, indentStr) {
    let clean = js.trim();
    let depth = 0;
    let formatted = '';
    let inString = false;
    let strChar = '';

    for (let i = 0; i < clean.length; i++) {
        const char = clean[i];
        const next = clean[i + 1] || '';
        const prev = clean[i - 1] || '';

        if (inString) {
            formatted += char;
            if (char === strChar && prev !== '\\') inString = false;
            continue;
        }

        if (char === '"' || char === "'" || char === '`') {
            inString = true;
            strChar = char;
            formatted += char;
            continue;
        }

        if (char === '{') {
            depth++;
            formatted += ' {\n' + indentStr.repeat(depth);
            while (clean[i + 1] === ' ') i++;
        } else if (char === '}') {
            depth = Math.max(0, depth - 1);
            formatted = formatted.trimEnd() + '\n' + indentStr.repeat(depth) + '}\n' + indentStr.repeat(depth);
        } else if (char === ';') {
            formatted += ';\n' + indentStr.repeat(depth);
            while (clean[i + 1] === ' ') i++;
        } else {
            formatted += char;
        }
    }

    return formatted.replace(/\n\s*\n\s*\n/g, '\n\n').trim();
}

function formatXmlCode(xml, indentStr) {
    const parser = new DOMParser();
    const doc = parser.parseFromString(xml, 'application/xml');
    const parserError = doc.querySelector('parsererror');
    if (parserError) {
        throw new Error("XML syntax error: " + parserError.textContent.split('\n')[0]);
    }

    function serializeNode(node, currentDepth) {
        if (!node) return '';
        if (node.nodeType === DOM_TEXT_NODE) {
            const text = (node.textContent || '').trim();
            return text ? indentStr.repeat(currentDepth) + text + '\n' : '';
        }
        if (node.nodeType === DOM_COMMENT_NODE) {
            return indentStr.repeat(currentDepth) + `<!--${node.textContent}-->\n`;
        }
        if (node.nodeType === DOM_ELEMENT_NODE) {
            const tag = node.tagName;
            let attrs = '';
            const nodeAttrs = node.attributes || [];
            for (let i = 0; i < nodeAttrs.length; i++) {
                const a = nodeAttrs[i];
                attrs += ` ${a.name}="${a.value}"`;
            }

            const children = node.childNodes || [];
            if (!children.length) {
                return indentStr.repeat(currentDepth) + `<${tag}${attrs}/>\n`;
            }

            if (children.length === 1 && children[0].nodeType === DOM_TEXT_NODE) {
                const text = (children[0].textContent || '').trim();
                return indentStr.repeat(currentDepth) + `<${tag}${attrs}>${text}</${tag}>\n`;
            }

            let result = indentStr.repeat(currentDepth) + `<${tag}${attrs}>\n`;
            for (let i = 0; i < children.length; i++) {
                result += serializeNode(node.childNodes[i], currentDepth + 1);
            }
            result += indentStr.repeat(currentDepth) + `</${tag}>\n`;
            return result;
        }
        return '';
    }

    let out = '<?xml version="1.0" encoding="UTF-8"?>\n';
    out += serializeNode(doc.documentElement, 0);
    return out.trim();
}

function formatSqlCode(sql, indentStr, uppercaseKw = true) {
    const keywords = [
        'SELECT', 'DISTINCT', 'FROM', 'WHERE', 'AND', 'OR', 'NOT',
        'INSERT INTO', 'VALUES', 'UPDATE', 'SET', 'DELETE FROM', 'DELETE',
        'JOIN', 'INNER JOIN', 'LEFT JOIN', 'RIGHT JOIN', 'FULL JOIN', 'CROSS JOIN', 'ON',
        'GROUP BY', 'HAVING', 'ORDER BY', 'ASC', 'DESC', 'LIMIT', 'OFFSET',
        'UNION ALL', 'UNION', 'EXCEPT', 'INTERSECT',
        'CREATE TABLE', 'ALTER TABLE', 'DROP TABLE',
        'CASE', 'WHEN', 'THEN', 'ELSE', 'END', 'AS', 'IN', 'IS NULL', 'IS NOT NULL', 'BETWEEN', 'LIKE'
    ];

    let result = sql.replace(/\s+/g, ' ').trim();

    if (uppercaseKw) {
        keywords.forEach(kw => {
            const regex = new RegExp('\\b' + kw.replace(/\s+/g, '\\s+') + '\\b', 'gi');
            result = result.replace(regex, kw);
        });
    }

    // Newlines before major clauses
    const majorClauses = [
        'SELECT', 'FROM', 'WHERE', 'GROUP BY', 'HAVING', 'ORDER BY', 'LIMIT',
        'JOIN', 'INNER JOIN', 'LEFT JOIN', 'RIGHT JOIN', 'INSERT INTO', 'VALUES', 'UPDATE', 'SET', 'DELETE'
    ];

    majorClauses.forEach(clause => {
        const regex = new RegExp('(\\s+)(' + clause + ')(\\s+)', 'gi');
        result = result.replace(regex, '\n$2$3');
    });

    // Indent lines that don't start with major clauses
    let lines = result.split('\n').map(l => l.trim()).filter(Boolean);
    let formatted = [];

    for (let line of lines) {
        const isMajor = majorClauses.some(mc => line.toUpperCase().startsWith(mc));
        if (isMajor) {
            formatted.push(line);
        } else {
            formatted.push(indentStr + line);
        }
    }

    return formatted.join('\n');
}

function clearFormatterInput() {
    const inEl = document.getElementById('formatter-input');
    const outEl = document.getElementById('formatter-output');
    if (inEl) inEl.value = '';
    if (outEl) outEl.value = '';
    showFormatterError(null);
    updateFormatterStats('', '');
    showToast("Inputs cleared.");
}

async function pasteFormatterClipboard() {
    try {
        const text = await navigator.clipboard.readText();
        const inEl = document.getElementById('formatter-input');
        if (inEl) {
            inEl.value = text;
            updateFormatterStats(text, '');
            showToast("Pasted from clipboard!");
        }
    } catch (e) {
        showToast("Clipboard read permission denied.", true);
    }
}

function loadFormatterSample() {
    const samples = {
        'html-formatter': '<div class="profile-card"><header><h3>Jane Doe</h3><span class="badge">Admin</span></header><p>Lead Frontend Engineer at WebToolsStation.</p><ul><li>Architecture</li><li>Performance</li><li>Security</li></ul></div>',
        'css-formatter': '.hero-card{display:flex;align-items:center;padding:24px;background:#ffffff;border:1px solid #e2e8f0;border-radius:12px;}.hero-card h1{font-size:1.75rem;margin:0 0 8px 0;color:#0f172a;}',
        'javascript-formatter': 'function authenticateUser(credentials){if(!credentials.username||!credentials.password){throw new Error("Missing username or password");}const token=generateSessionToken(credentials.username);return{authenticated:true,token:token};}',
        'xml-formatter': '<server status="running"><host name="api.webtoolsstation.test" port="443"><service protocol="https" enabled="true"><limits maxConnections="5000" timeoutSeconds="30"/></service></host></server>',
        'sql-formatter': 'select u.id, u.name, u.email, count(o.id) as total_orders from users u left join orders o on u.id = o.user_id where u.active = 1 and u.created_at >= "2026-01-01" group by u.id, u.name, u.email having count(o.id) > 3 order by total_orders desc limit 50;'
    };

    const s = samples[currentToolSlug];
    if (s) {
        const inEl = document.getElementById('formatter-input');
        if (inEl) {
            inEl.value = s;
            updateFormatterStats(s, '');
            showToast("Sample loaded.");
            runFormatter();
        }
    }
}

function downloadFormattedOutput() {
    const outEl = document.getElementById('formatter-output');
    const text = outEl?.value || '';
    if (!text.trim()) {
        showToast("No formatted code to download.", true);
        return;
    }
    const extMap = {
        'html-formatter': 'formatted.html',
        'css-formatter': 'formatted.css',
        'javascript-formatter': 'formatted.js',
        'xml-formatter': 'formatted.xml',
        'sql-formatter': 'query.sql'
    };
    const filename = extMap[currentToolSlug] || 'formatted.txt';
    const blob = new Blob([text], { type: 'text/plain;charset=utf-8' });
    const url = URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = filename;
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    URL.revokeObjectURL(url);
    showToast("Downloaded " + filename);
}

// ==========================================
// 3. SYNTAX VALIDATORS
// ==========================================

function runValidator() {
    const inEl = document.getElementById('validator-input');
    const outEl = document.getElementById('validator-output');
    const initBox = document.getElementById('validator-initial');
    const succBox = document.getElementById('validator-success');
    const failBox = document.getElementById('validator-failure');
    const errDetails = document.getElementById('validator-error-details');

    if (!inEl) return;
    const input = inEl.value.trim();

    if (!input) {
        showToast("Please enter input to validate.", true);
        if (initBox) initBox.style.display = 'flex';
        if (succBox) succBox.style.display = 'none';
        if (failBox) failBox.style.display = 'none';
        if (outEl) outEl.value = '';
        return;
    }

    if (initBox) initBox.style.display = 'none';

    if (currentToolSlug === 'json-validator') {
        try {
            const parsed = JSON.parse(input);
            if (succBox) succBox.style.display = 'block';
            if (failBox) failBox.style.display = 'none';
            if (outEl) outEl.value = JSON.stringify(parsed, null, 2);
            showToast("JSON is valid!");
        } catch (err) {
            if (succBox) succBox.style.display = 'none';
            if (failBox) failBox.style.display = 'block';

            // Extract line/column from error
            let errorMsg = err.message;
            let lineNum = 1;
            let colNum = 1;
            const match = errorMsg.match(/at position (\d+)/);
            if (match) {
                const pos = parseInt(match[1], 10);
                const prefix = input.substring(0, pos);
                const lines = prefix.split('\n');
                lineNum = lines.length;
                colNum = lines[lines.length - 1].length + 1;
                errorMsg += `\n→ Syntax issue at Line ${lineNum}, Column ${colNum}`;
            }

            if (errDetails) errDetails.textContent = errorMsg;
            if (outEl) outEl.value = input;
            showToast("Invalid JSON syntax.", true);
        }
    } else if (currentToolSlug === 'xml-validator') {
        const parser = new DOMParser();
        const doc = parser.parseFromString(input, 'application/xml');
        const parserError = doc.querySelector('parsererror');

        if (!parserError) {
            if (succBox) succBox.style.display = 'block';
            if (failBox) failBox.style.display = 'none';
            if (outEl) outEl.value = formatXmlCode(input, '  ');
            showToast("XML is well-formed!");
        } else {
            if (succBox) succBox.style.display = 'none';
            if (failBox) failBox.style.display = 'block';
            const errorText = parserError.textContent.trim();
            if (errDetails) errDetails.textContent = errorText;
            if (outEl) outEl.value = input;
            showToast("Invalid XML syntax.", true);
        }
    }
}

function clearValidatorInput() {
    const inEl = document.getElementById('validator-input');
    const outEl = document.getElementById('validator-output');
    if (inEl) inEl.value = '';
    if (outEl) outEl.value = '';
    const initBox = document.getElementById('validator-initial');
    const succBox = document.getElementById('validator-success');
    const failBox = document.getElementById('validator-failure');
    if (initBox) initBox.style.display = 'flex';
    if (succBox) succBox.style.display = 'none';
    if (failBox) failBox.style.display = 'none';
    showToast("Inputs cleared.");
}

async function pasteValidatorClipboard() {
    try {
        const text = await navigator.clipboard.readText();
        const inEl = document.getElementById('validator-input');
        if (inEl) {
            inEl.value = text;
            showToast("Pasted from clipboard!");
        }
    } catch (e) {
        showToast("Clipboard read permission denied.", true);
    }
}

function loadValidatorSample() {
    const samples = {
        'json-validator': '{\n  "service": "WebToolsStation",\n  "verified": true,\n  "endpoints": [\n    {"path": "/api/validate", "method": "POST"}\n  ]\n}',
        'xml-validator': '<?xml version="1.0" encoding="UTF-8"?>\n<configuration>\n    <database host="localhost" port="5432" ssl="true">\n        <pool min="5" max="20"/>\n    </database>\n</configuration>'
    };
    const s = samples[currentToolSlug];
    if (s) {
        const inEl = document.getElementById('validator-input');
        if (inEl) {
            inEl.value = s;
            showToast("Sample loaded.");
            runValidator();
        }
    }
}

// ==========================================
// 4. DATA CONVERTERS
// ==========================================

function showConverterError(msg) {
    const errBox = document.getElementById('converter-error');
    const errMsg = document.getElementById('converter-error-msg');
    if (errBox && errMsg) {
        if (msg) {
            errMsg.textContent = msg;
            errBox.style.display = 'block';
        } else {
            errBox.style.display = 'none';
        }
    }
}

function runConverter() {
    showConverterError(null);
    const inEl = document.getElementById('converter-input');
    const outEl = document.getElementById('converter-output');
    if (!inEl || !outEl) return;

    const input = inEl.value.trim();
    if (!input) {
        showToast("Please enter input data to convert.", true);
        outEl.value = '';
        return;
    }

    try {
        let result = '';
        if (currentToolSlug === 'json-to-xml-converter') {
            const rootName = document.getElementById('xml-root-name')?.value.trim() || 'root';
            const parsed = JSON.parse(input);
            result = jsonToXmlString(parsed, rootName);
        } else if (currentToolSlug === 'xml-to-json-converter') {
            result = xmlToJsonString(input);
        } else if (currentToolSlug === 'json-to-csv-converter') {
            const parsed = JSON.parse(input);
            result = jsonToCsvString(parsed);
        } else if (currentToolSlug === 'yaml-to-json-converter') {
            result = yamlToJsonString(input);
        } else if (currentToolSlug === 'json-to-yaml-converter') {
            const parsed = JSON.parse(input);
            result = jsonToYamlString(parsed);
        }

        outEl.value = result;
        showToast("Converted successfully!");
    } catch (err) {
        showConverterError(err.message || "Failed to convert data. Please verify your source format.");
        showToast("Conversion failed.", true);
    }
}

function jsonToXmlString(obj, rootName = 'root') {
    function buildXml(data, nodeName) {
        if (data === null || data === undefined) {
            return `<${nodeName}/>`;
        }
        if (Array.isArray(data)) {
            return data.map(item => buildXml(item, 'item')).join('\n');
        }
        if (typeof data === 'object') {
            let inner = '';
            for (const key of Object.keys(data)) {
                // Ensure valid XML tag name
                const safeKey = key.replace(/[^a-zA-Z0-9_\-]/g, '_');
                inner += buildXml(data[key], safeKey) + '\n';
            }
            return `<${nodeName}>\n${inner.trim()}\n</${nodeName}>`;
        }
        // Escaped text
        const safeText = String(data)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;');
        return `<${nodeName}>${safeText}</${nodeName}>`;
    }

    let xml = `<?xml version="1.0" encoding="UTF-8"?>\n`;
    xml += buildXml(obj, rootName);
    try {
        return formatXmlCode(xml, '  ');
    } catch (e) {
        return xml;
    }
}

function xmlToJsonString(xml) {
    const parser = new DOMParser();
    const doc = parser.parseFromString(xml, 'application/xml');
    const parserError = doc.querySelector('parsererror');
    if (parserError) {
        throw new Error("Invalid XML input: " + parserError.textContent.split('\n')[0]);
    }

    function xmlNodeToObj(node) {
        if (!node) return null;
        if (node.nodeType === DOM_TEXT_NODE) {
            return (node.textContent || '').trim();
        }

        const obj = {};
        if (node.attributes && node.attributes.length > 0) {
            obj['@attributes'] = {};
            for (let i = 0; i < node.attributes.length; i++) {
                const attr = node.attributes[i];
                obj['@attributes'][attr.name] = attr.value;
            }
        }

        if (node.childNodes && node.childNodes.length > 0) {
            let textOnly = true;
            for (let i = 0; i < node.childNodes.length; i++) {
                if (node.childNodes[i].nodeType === DOM_ELEMENT_NODE) {
                    textOnly = false;
                    break;
                }
            }

            if (textOnly) {
                const text = (node.textContent || '').trim();
                if (Object.keys(obj).length === 0) return text;
                obj['#text'] = text;
                return obj;
            }

            for (let i = 0; i < node.childNodes.length; i++) {
                const child = node.childNodes[i];
                if (child.nodeType === DOM_ELEMENT_NODE) {
                    const childName = child.tagName;
                    const childVal = xmlNodeToObj(child);

                    if (!obj[childName]) {
                        obj[childName] = childVal;
                    } else if (Array.isArray(obj[childName])) {
                        obj[childName].push(childVal);
                    } else {
                        obj[childName] = [obj[childName], childVal];
                    }
                }
            }
        }
        return obj;
    }

    const rootObj = {};
    rootObj[doc.documentElement.tagName] = xmlNodeToObj(doc.documentElement);
    return JSON.stringify(rootObj, null, 2);
}

function jsonToCsvString(data) {
    if (!Array.isArray(data)) {
        if (typeof data === 'object' && data !== null) {
            data = [data];
        } else {
            throw new Error("Input must be a JSON array of objects to convert to CSV.");
        }
    }

    if (data.length === 0) return '';

    // Collect all unique keys
    const headers = [];
    data.forEach(item => {
        if (typeof item === 'object' && item !== null) {
            Object.keys(item).forEach(key => {
                if (!headers.includes(key)) headers.push(key);
            });
        }
    });

    function escapeCsv(val) {
        if (val === null || val === undefined) return '';
        let str = typeof val === 'object' ? JSON.stringify(val) : String(val);
        if (str.includes(',') || str.includes('"') || str.includes('\n')) {
            str = '"' + str.replace(/"/g, '""') + '"';
        }
        return str;
    }

    const rows = [headers.map(escapeCsv).join(',')];
    data.forEach(item => {
        const row = headers.map(header => escapeCsv(item ? item[header] : ''));
        rows.push(row.join(','));
    });

    return rows.join('\n');
}

function parseYamlBlock(lines, currentIndent) {
    while (lines.length > 0 && (!lines[0].trim() || lines[0].trim().startsWith('#'))) {
        lines.shift();
    }
    if (lines.length === 0) return null;

    const firstLine = lines[0];
    const firstIndent = firstLine.search(/\S/);
    if (firstIndent < currentIndent) return null;

    const trimmed = firstLine.trim();
    if (trimmed.startsWith('- ')) {
        const list = [];
        while (lines.length > 0) {
            const l = lines[0];
            if (!l.trim() || l.trim().startsWith('#')) {
                lines.shift();
                continue;
            }
            const ind = l.search(/\S/);
            if (ind < firstIndent) break;
            const t = l.trim();
            if (!t.startsWith('- ') && ind === firstIndent) break;

            if (t.startsWith('- ')) {
                lines.shift();
                const itemContent = t.substring(2).trim();
                if (itemContent === '') {
                    list.push(parseYamlBlock(lines, ind + 2));
                } else if (itemContent.includes(':') && !itemContent.startsWith('http:') && !itemContent.startsWith('https:')) {
                    const colonIdx = itemContent.indexOf(':');
                    const k = itemContent.substring(0, colonIdx).trim();
                    const vStr = itemContent.substring(colonIdx + 1).trim();
                    const obj = {};
                    if (!vStr) {
                        obj[k] = parseYamlBlock(lines, ind + 2);
                    } else {
                        obj[k] = parseYamlScalar(vStr);
                    }
                    while (lines.length > 0) {
                        const nextL = lines[0];
                        if (!nextL.trim() || nextL.trim().startsWith('#')) {
                            lines.shift();
                            continue;
                        }
                        const nextInd = nextL.search(/\S/);
                        const nextT = nextL.trim();
                        if (nextInd > ind && !nextT.startsWith('- ') && nextT.includes(':')) {
                            lines.shift();
                            const cIdx = nextT.indexOf(':');
                            const subK = nextT.substring(0, cIdx).trim();
                            const subV = nextT.substring(cIdx + 1).trim();
                            if (!subV) {
                                obj[subK] = parseYamlBlock(lines, nextInd + 1);
                            } else {
                                obj[subK] = parseYamlScalar(subV);
                            }
                        } else {
                            break;
                        }
                    }
                    list.push(obj);
                } else {
                    list.push(parseYamlScalar(itemContent));
                }
            } else {
                break;
            }
        }
        return list;
    } else {
        const obj = {};
        while (lines.length > 0) {
            const l = lines[0];
            if (!l.trim() || l.trim().startsWith('#')) {
                lines.shift();
                continue;
            }
            const ind = l.search(/\S/);
            if (ind < firstIndent) break;
            const t = l.trim();
            if (!t.includes(':')) {
                lines.shift();
                continue;
            }

            const colonIdx = t.indexOf(':');
            const k = t.substring(0, colonIdx).trim();
            const vStr = t.substring(colonIdx + 1).trim();
            lines.shift();

            if (!vStr) {
                obj[k] = parseYamlBlock(lines, ind + 1);
            } else {
                obj[k] = parseYamlScalar(vStr);
            }
        }
        return obj;
    }
}

function yamlToJsonString(yaml) {
    const lines = yaml.split(/\r?\n/);
    const parsed = parseYamlBlock(lines, 0) || {};
    return JSON.stringify(parsed, null, 2);
}

function parseYamlScalar(val) {
    if (val === 'true') return true;
    if (val === 'false') return false;
    if (val === 'null' || val === '~') return null;
    if (!isNaN(val) && val !== '') return Number(val);
    if ((val.startsWith('"') && val.endsWith('"')) || (val.startsWith("'") && val.endsWith("'"))) {
        return val.substring(1, val.length - 1);
    }
    return val;
}

function jsonToYamlString(obj, indent = 0) {
    const space = '  '.repeat(indent);
    if (obj === null) return 'null';
    if (typeof obj !== 'object') {
        if (typeof obj === 'string' && (obj.includes(':') || obj.includes('\n') || obj.includes('#'))) {
            return `"${obj.replace(/"/g, '\\"')}"`;
        }
        return String(obj);
    }

    if (Array.isArray(obj)) {
        if (obj.length === 0) return '[]';
        return obj.map(item => `${space}- ${jsonToYamlString(item, indent + 1).trimStart()}`).join('\n');
    }

    const keys = Object.keys(obj);
    if (keys.length === 0) return '{}';

    return keys.map(key => {
        const val = obj[key];
        if (typeof val === 'object' && val !== null && (Array.isArray(val) ? val.length > 0 : Object.keys(val).length > 0)) {
            return `${space}${key}:\n${jsonToYamlString(val, indent + 1)}`;
        }
        return `${space}${key}: ${jsonToYamlString(val, indent + 1)}`;
    }).join('\n');
}

function clearConverterInput() {
    const inEl = document.getElementById('converter-input');
    const outEl = document.getElementById('converter-output');
    if (inEl) inEl.value = '';
    if (outEl) outEl.value = '';
    showConverterError(null);
    showToast("Inputs cleared.");
}

async function pasteConverterClipboard() {
    try {
        const text = await navigator.clipboard.readText();
        const inEl = document.getElementById('converter-input');
        if (inEl) {
            inEl.value = text;
            showToast("Pasted from clipboard!");
        }
    } catch (e) {
        showToast("Clipboard read permission denied.", true);
    }
}

function loadConverterSample() {
    const samples = {
        'json-to-xml-converter': '{\n  "platform": "WebToolsStation",\n  "active": true,\n  "version": 2,\n  "tools": [\n    {"name": "JSON to XML", "type": "converter"},\n    {"name": "XML to JSON", "type": "converter"}\n  ]\n}',
        'xml-to-json-converter': '<?xml version="1.0" encoding="UTF-8"?>\n<catalog brand="WebToolsStation">\n    <tool id="101">\n        <name>XML to JSON</name>\n        <status>active</status>\n    </tool>\n    <tool id="102">\n        <name>JSON to XML</name>\n        <status>active</status>\n    </tool>\n</catalog>',
        'json-to-csv-converter': '[\n  {"id": 1, "name": "Alex Rivera", "department": "Engineering", "role": "Tech Lead"},\n  {"id": 2, "name": "Taylor Chen", "department": "Product", "role": "Product Manager"},\n  {"id": 3, "name": "Jordan Smith", "department": "Security", "role": "SecOps Analyst"}\n]',
        'yaml-to-json-converter': 'app:\n  name: WebToolsStation\n  environment: production\n  server:\n    port: 8000\n    host: 127.0.0.1\n  features:\n    client_side: true\n    zero_telemetry: true',
        'json-to-yaml-converter': '{\n  "service": "WebToolsStation",\n  "build": 2026,\n  "config": {\n    "runtime": "browser",\n    "encryption": "WebCrypto",\n    "categories": ["Developer", "Text", "Security"]\n  }\n}'
    };

    const s = samples[currentToolSlug];
    if (s) {
        const inEl = document.getElementById('converter-input');
        if (inEl) {
            inEl.value = s;
            showToast("Sample loaded.");
            runConverter();
        }
    }
}

function downloadConvertedOutput() {
    const outEl = document.getElementById('converter-output');
    const text = outEl?.value || '';
    if (!text.trim()) {
        showToast("No data to download.", true);
        return;
    }
    const extMap = {
        'json-to-xml-converter': 'converted.xml',
        'xml-to-json-converter': 'converted.json',
        'json-to-csv-converter': 'data.csv',
        'yaml-to-json-converter': 'converted.json',
        'json-to-yaml-converter': 'converted.yaml'
    };
    const filename = extMap[currentToolSlug] || 'output.txt';
    const blob = new Blob([text], { type: 'text/plain;charset=utf-8' });
    const url = URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = filename;
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    URL.revokeObjectURL(url);
    showToast("Downloaded " + filename);
}

// ==========================================
// 5. GENERATORS & DEVELOPER HELPERS
// ==========================================

// ULID Generator
const CROCKFORD_BASE32 = "0123456789ABCDEFGHJKMNPQRSTVWXYZ";

function generateSingleUlid() {
    const now = Date.now();
    let timeStr = "";
    let timeVal = now;
    for (let i = 9; i >= 0; i--) {
        const mod = timeVal % 32;
        timeStr = CROCKFORD_BASE32[mod] + timeStr;
        timeVal = Math.floor(timeVal / 32);
    }

    const randomBytes = new Uint8Array(10);
    window.crypto.getRandomValues(randomBytes);
    let randStr = "";
    for (let i = 0; i < 16; i++) {
        const r = randomBytes[i % 10] % 32;
        randStr += CROCKFORD_BASE32[r];
    }

    return timeStr + randStr;
}

function generateUlids() {
    const qtyInput = document.getElementById('ulid-quantity');
    const outEl = document.getElementById('ulid-output');
    if (!qtyInput || !outEl) return;

    const count = Math.min(50, Math.max(1, parseInt(qtyInput.value, 10) || 5));
    const list = [];
    for (let i = 0; i < count; i++) {
        list.push(generateSingleUlid());
    }
    outEl.value = list.join('\n');
    showToast(`Generated ${count} ULID(s)!`);
}

// Random String Generator
function generateRandomStrings() {
    const lengthInput = document.getElementById('rand-length');
    const countInput = document.getElementById('rand-count');
    const outEl = document.getElementById('rand-output');

    const len = Math.min(256, Math.max(4, parseInt(lengthInput?.value, 10) || 32));
    const count = Math.min(50, Math.max(1, parseInt(countInput?.value, 10) || 5));

    let charset = '';
    if (document.getElementById('rand-upper')?.checked) charset += 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    if (document.getElementById('rand-lower')?.checked) charset += 'abcdefghijklmnopqrstuvwxyz';
    if (document.getElementById('rand-digits')?.checked) charset += '0123456789';
    if (document.getElementById('rand-symbols')?.checked) charset += '!@#$%^&*()_+-=[]{}|;:,.<>?';

    if (document.getElementById('rand-no-ambiguous')?.checked) {
        charset = charset.replace(/[0Ol1I]/g, '');
    }

    if (!charset) {
        showToast("Please select at least one character set.", true);
        return;
    }

    const results = [];
    const randomBuffer = new Uint32Array(len);

    for (let c = 0; c < count; c++) {
        window.crypto.getRandomValues(randomBuffer);
        let str = '';
        for (let i = 0; i < len; i++) {
            str += charset[randomBuffer[i] % charset.length];
        }
        results.push(str);
    }

    if (outEl) {
        outEl.value = results.join('\n');
        showToast(`Generated ${count} random string(s)!`);
    }
}

// Multi-Algorithm Hash Generator
async function computeAllHashes() {
    const inputEl = document.getElementById('hash-text-input');
    const text = inputEl ? inputEl.value : '';

    const algos = [
        { key: 'sha1', name: 'SHA-1' },
        { key: 'sha256', name: 'SHA-256' },
        { key: 'sha384', name: 'SHA-384' },
        { key: 'sha512', name: 'SHA-512' }
    ];

    if (!text) {
        document.getElementById('hash-val-md5').textContent = '—';
        algos.forEach(a => {
            const el = document.getElementById(`hash-val-${a.key}`);
            if (el) el.textContent = '—';
        });
        return;
    }

    // MD5 computation
    const md5Val = computeMd5(text);
    const md5El = document.getElementById('hash-val-md5');
    if (md5El) md5El.textContent = md5Val;

    // Web Crypto SHA digests
    const enc = new TextEncoder();
    const data = enc.encode(text);

    for (const a of algos) {
        try {
            const hashBuf = await window.crypto.subtle.digest(a.name, data);
            const hashArr = Array.from(new Uint8Array(hashBuf));
            const hex = hashArr.map(b => b.toString(16).padStart(2, '0')).join('');
            const el = document.getElementById(`hash-val-${a.key}`);
            if (el) el.textContent = hex;
        } catch (e) {
            const el = document.getElementById(`hash-val-${a.key}`);
            if (el) el.textContent = 'Error computing hash';
        }
    }
}

function copyDigest(id) {
    const el = document.getElementById(id);
    const text = el?.textContent || '';
    if (!text || text === '—') {
        showToast("No hash to copy.", true);
        return;
    }
    navigator.clipboard.writeText(text);
    showToast("Hash copied to clipboard!");
}

// MD5 implementation
function computeMd5(string) {
    function rotateLeft(lValue, iShiftBits) {
        return (lValue << iShiftBits) | (lValue >>> (32 - iShiftBits));
    }
    function addUnsigned(lX, lY) {
        const lX8 = (lX & 0x80000000);
        const lY8 = (lY & 0x80000000);
        const lX4 = (lX & 0x40000000);
        const lY4 = (lY & 0x40000000);
        const lResult = (lX & 0x3FFFFFFF) + (lY & 0x3FFFFFFF);
        if (lX4 & lY4) return (lResult ^ 0x80000000 ^ lX8 ^ lY8);
        if (lX4 | lY4) {
            if (lResult & 0x40000000) return (lResult ^ 0xC0000000 ^ lX8 ^ lY8);
            return (lResult ^ 0x40000000 ^ lX8 ^ lY8);
        }
        return (lResult ^ lX8 ^ lY8);
    }
    function F(x, y, z) { return (x & y) | ((~x) & z); }
    function G(x, y, z) { return (x & z) | (y & (~z)); }
    function H(x, y, z) { return (x ^ y ^ z); }
    function I(x, y, z) { return (y ^ (x | (~z))); }
    function FF(a, b, c, d, x, s, ac) {
        a = addUnsigned(a, addUnsigned(addUnsigned(F(b, c, d), x), ac));
        return addUnsigned(rotateLeft(a, s), b);
    }
    function GG(a, b, c, d, x, s, ac) {
        a = addUnsigned(a, addUnsigned(addUnsigned(G(b, c, d), x), ac));
        return addUnsigned(rotateLeft(a, s), b);
    }
    function HH(a, b, c, d, x, s, ac) {
        a = addUnsigned(a, addUnsigned(addUnsigned(H(b, c, d), x), ac));
        return addUnsigned(rotateLeft(a, s), b);
    }
    function II(a, b, c, d, x, s, ac) {
        a = addUnsigned(a, addUnsigned(addUnsigned(I(b, c, d), x), ac));
        return addUnsigned(rotateLeft(a, s), b);
    }

    let x = [];
    let k, AA, BB, CC, DD, a, b, c, d;
    const S11 = 7, S12 = 12, S13 = 17, S14 = 22;
    const S21 = 5, S22 = 9, S23 = 14, S24 = 20;
    const S31 = 4, S32 = 11, S33 = 16, S34 = 23;
    const S41 = 6, S42 = 10, S43 = 15, S44 = 21;

    const utf8 = unescape(encodeURIComponent(string));
    const nwords = ((utf8.length + 8) >> 6) + 1;
    for (let i = 0; i < nwords * 16; i++) x[i] = 0;
    for (let i = 0; i < utf8.length; i++) x[i >> 2] |= (utf8.charCodeAt(i) & 0xFF) << ((i % 4) * 8);
    x[utf8.length >> 2] |= 0x80 << ((utf8.length % 4) * 8);
    x[nwords * 16 - 2] = utf8.length * 8;

    a = 0x67452301; b = 0xEFCDAB89; c = 0x98BADCFE; d = 0x10325476;
    for (k = 0; k < x.length; k += 16) {
        AA = a; BB = b; CC = c; DD = d;
        a = FF(a, b, c, d, x[k + 0], S11, 0xD76AA478); d = FF(d, a, b, c, x[k + 1], S12, 0xE8C7B756);
        c = FF(c, d, a, b, x[k + 2], S13, 0x242070DB); b = FF(b, c, d, a, x[k + 3], S14, 0xC1BDCEEE);
        a = FF(a, b, c, d, x[k + 4], S11, 0xF57C0FAF); d = FF(d, a, b, c, x[k + 5], S12, 0x4787C62A);
        c = FF(c, d, a, b, x[k + 6], S13, 0xA8304613); b = FF(b, c, d, a, x[k + 7], S14, 0xFD469501);
        a = FF(a, b, c, d, x[k + 8], S11, 0x698098D8); d = FF(d, a, b, c, x[k + 9], S12, 0x8B44F7AF);
        c = FF(c, d, a, b, x[k + 10], S13, 0xFFFF5BB1); b = FF(b, c, d, a, x[k + 11], S14, 0x895CD7BE);
        a = FF(a, b, c, d, x[k + 12], S11, 0x6B901122); d = FF(d, a, b, c, x[k + 13], S12, 0xFD987193);
        c = FF(c, d, a, b, x[k + 14], S13, 0xA679438E); b = FF(b, c, d, a, x[k + 15], S14, 0x49B40821);
        a = GG(a, b, c, d, x[k + 1], S21, 0xF61E2562); d = GG(d, a, b, c, x[k + 6], S22, 0xC040B340);
        c = GG(c, d, a, b, x[k + 11], S23, 0x265E5A51); b = GG(b, c, d, a, x[k + 0], S24, 0xE9B6C7AA);
        a = GG(a, b, c, d, x[k + 5], S21, 0xD62F105D); d = GG(d, a, b, c, x[k + 10], S22, 0x2441453);
        c = GG(c, d, a, b, x[k + 15], S23, 0xD8A1E681); b = GG(b, c, d, a, x[k + 4], S24, 0xE7D3FBC8);
        a = GG(a, b, c, d, x[k + 9], S21, 0x21E1CDE6); d = GG(d, a, b, c, x[k + 14], S22, 0xC33707D6);
        c = GG(c, d, a, b, x[k + 3], S23, 0xF4D50D87); b = GG(b, c, d, a, x[k + 8], S24, 0x455A14ED);
        a = GG(a, b, c, d, x[k + 13], S21, 0xA9E3E905); d = GG(d, a, b, c, x[k + 2], S22, 0xFCEFA3F8);
        c = GG(c, d, a, b, x[k + 7], S23, 0x676F02D9); b = GG(b, c, d, a, x[k + 12], S24, 0x8D2A4C8A);
        a = HH(a, b, c, d, x[k + 5], S31, 0xFFFA3942); d = HH(d, a, b, c, x[k + 8], S32, 0x8771F681);
        c = HH(c, d, a, b, x[k + 11], S33, 0x6D9D6122); b = HH(b, c, d, a, x[k + 14], S34, 0xFDE5380C);
        a = HH(a, b, c, d, x[k + 1], S31, 0xA4BEEA44); d = HH(d, a, b, c, x[k + 4], S32, 0x4BDECFA9);
        c = HH(c, d, a, b, x[k + 7], S33, 0xF6BB4B60); b = HH(b, c, d, a, x[k + 10], S34, 0xBEBFBC70);
        a = HH(a, b, c, d, x[k + 13], S31, 0x289B7EC6); d = HH(d, a, b, c, x[k + 0], S32, 0xEAA127FA);
        c = HH(c, d, a, b, x[k + 3], S33, 0xD4EF3085); b = HH(b, c, d, a, x[k + 6], S34, 0x4881D05);
        a = HH(a, b, c, d, x[k + 9], S31, 0xD9D4D039); d = HH(d, a, b, c, x[k + 12], S32, 0xE6DB99E5);
        c = HH(c, d, a, b, x[k + 15], S33, 0x1FA27CF8); b = HH(b, c, d, a, x[k + 2], S34, 0xC4AC5665);
        a = II(a, b, c, d, x[k + 0], S41, 0xF4292244); d = II(d, a, b, c, x[k + 7], S42, 0x432AFF97);
        c = II(c, d, a, b, x[k + 14], S43, 0xAB9423A7); b = II(b, c, d, a, x[k + 5], S44, 0xFC93A039);
        a = II(a, b, c, d, x[k + 12], S41, 0x655B59C3); d = II(d, a, b, c, x[k + 3], S42, 0x8F0CCC92);
        c = II(c, d, a, b, x[k + 10], S43, 0xFFEFF47D); b = II(b, c, d, a, x[k + 1], S44, 0x85845DD1);
        a = II(a, b, c, d, x[k + 8], S41, 0x6FA87E4F); d = II(d, a, b, c, x[k + 15], S42, 0xFE2CE6E0);
        c = II(c, d, a, b, x[k + 6], S43, 0xA3014314); b = II(b, c, d, a, x[k + 13], S44, 0x4E0811A1);
        a = II(a, b, c, d, x[k + 4], S41, 0xF7537E82); d = II(d, a, b, c, x[k + 11], S42, 0xBD3AF235);
        c = II(c, d, a, b, x[k + 2], S43, 0x2AD7D2BB); b = II(b, c, d, a, x[k + 9], S44, 0xEB86D391);
        a = addUnsigned(a, AA); b = addUnsigned(b, BB); c = addUnsigned(c, CC); d = addUnsigned(d, DD);
    }
    function wordToHex(lValue) {
        let WordToHexValue = "", WordToHexValue_temp = "", lByte, lCount;
        for (lCount = 0; lCount <= 3; lCount++) {
            lByte = (lValue >>> (lCount * 8)) & 255;
            WordToHexValue_temp = "0" + lByte.toString(16);
            WordToHexValue = WordToHexValue + WordToHexValue_temp.substr(WordToHexValue_temp.length - 2, 2);
        }
        return WordToHexValue;
    }
    return (wordToHex(a) + wordToHex(b) + wordToHex(c) + wordToHex(d)).toLowerCase();
}

// HMAC Generator
async function computeHmac() {
    const msg = document.getElementById('hmac-msg')?.value || '';
    const key = document.getElementById('hmac-key')?.value || '';
    const algo = document.getElementById('hmac-algo')?.value || 'SHA-256';
    const format = document.getElementById('hmac-format')?.value || 'hex';
    const outEl = document.getElementById('hmac-output');

    if (!key) {
        showToast("Please provide a secret key.", true);
        return;
    }

    try {
        const enc = new TextEncoder();
        const keyData = enc.encode(key);
        const msgData = enc.encode(msg);

        const cryptoKey = await window.crypto.subtle.importKey(
            'raw',
            keyData,
            { name: 'HMAC', hash: { name: algo } },
            false,
            ['sign']
        );

        const signature = await window.crypto.subtle.sign('HMAC', cryptoKey, msgData);
        const sigBytes = new Uint8Array(signature);

        let result = '';
        if (format === 'hex') {
            result = Array.from(sigBytes).map(b => b.toString(16).padStart(2, '0')).join('');
        } else {
            result = btoa(String.fromCharCode(...sigBytes));
        }

        if (outEl) outEl.value = result;
        showToast("HMAC generated successfully!");
    } catch (err) {
        showToast("HMAC error: " + err.message, true);
    }
}

// JSON Diff Checker
function runJsonDiff() {
    const leftText = document.getElementById('diff-json-left')?.value.trim() || '';
    const rightText = document.getElementById('diff-json-right')?.value.trim() || '';
    const reportBox = document.getElementById('json-diff-report');
    const summaryBox = document.getElementById('json-diff-summary');
    const resultsBox = document.getElementById('json-diff-results');

    if (!leftText || !rightText) {
        showToast("Please provide two JSON payloads to compare.", true);
        return;
    }

    try {
        const leftObj = JSON.parse(leftText);
        const rightObj = JSON.parse(rightText);

        const diffs = [];
        compareObjects(leftObj, rightObj, '', diffs);

        if (reportBox) reportBox.style.display = 'block';

        const added = diffs.filter(d => d.type === 'added').length;
        const removed = diffs.filter(d => d.type === 'removed').length;
        const modified = diffs.filter(d => d.type === 'modified').length;

        if (summaryBox) {
            if (diffs.length === 0) {
                summaryBox.innerHTML = '<span style="color:var(--success);">✓ Both JSON payloads are identical!</span>';
            } else {
                summaryBox.innerHTML = `Found ${diffs.length} differences: <span style="color:var(--success); font-weight:700;">+${added} added</span>, <span style="color:var(--danger); font-weight:700;">-${removed} removed</span>, <span style="color:var(--brand); font-weight:700;">~${modified} modified</span>`;
            }
        }

        if (resultsBox) {
            let html = '';
            diffs.forEach(d => {
                if (d.type === 'added') {
                    html += `<div style="padding:6px 10px; background:#dcfce7; color:#15803d; border-radius:4px; margin-bottom:4px;"><strong>+ ADDED:</strong> <code>${d.path}</code> = ${JSON.stringify(d.val)}</div>`;
                } else if (d.type === 'removed') {
                    html += `<div style="padding:6px 10px; background:#fee2e2; color:#b91c1c; border-radius:4px; margin-bottom:4px;"><strong>- REMOVED:</strong> <code>${d.path}</code> (was ${JSON.stringify(d.val)})</div>`;
                } else if (d.type === 'modified') {
                    html += `<div style="padding:6px 10px; background:#e0f2fe; color:#0369a1; border-radius:4px; margin-bottom:4px;"><strong>~ MODIFIED:</strong> <code>${d.path}</code>: <span style="text-decoration:line-through; color:#b91c1c;">${JSON.stringify(d.oldVal)}</span> → <span style="color:#15803d; font-weight:700;">${JSON.stringify(d.newVal)}</span></div>`;
                }
            });
            resultsBox.innerHTML = html || '<div style="color:var(--text-muted);">No structural differences detected.</div>';
        }
        showToast("JSON comparison completed.");
    } catch (err) {
        showToast("Invalid JSON: " + err.message, true);
    }
}

function compareObjects(left, right, path, diffs) {
    if (typeof left !== typeof right) {
        diffs.push({ type: 'modified', path: path || '/', oldVal: left, newVal: right });
        return;
    }

    if (typeof left !== 'object' || left === null || right === null) {
        if (left !== right) {
            diffs.push({ type: 'modified', path: path || '/', oldVal: left, newVal: right });
        }
        return;
    }

    const leftKeys = Object.keys(left);
    const rightKeys = Object.keys(right);

    // Removed keys
    leftKeys.forEach(k => {
        const subPath = path ? `${path}.${k}` : k;
        if (!(k in right)) {
            diffs.push({ type: 'removed', path: subPath, val: left[k] });
        }
    });

    // Added and modified keys
    rightKeys.forEach(k => {
        const subPath = path ? `${path}.${k}` : k;
        if (!(k in left)) {
            diffs.push({ type: 'added', path: subPath, val: right[k] });
        } else {
            compareObjects(left[k], right[k], subPath, diffs);
        }
    });
}

function loadJsonDiffSample() {
    const left = {
        id: 1042,
        name: "WebToolsStation",
        version: "1.0",
        active: true,
        settings: { timeout: 30, retries: 3 }
    };
    const right = {
        id: 1042,
        name: "WebToolsStation Platform",
        version: "2.0",
        active: true,
        settings: { timeout: 45, retries: 3, debug: false },
        newFeature: "Diff Checker"
    };

    document.getElementById('diff-json-left').value = JSON.stringify(left, null, 2);
    document.getElementById('diff-json-right').value = JSON.stringify(right, null, 2);
    runJsonDiff();
}

// Query String Parser
function parseQueryString() {
    const input = document.getElementById('query-string-input')?.value.trim() || '';
    const tableBody = document.getElementById('query-table-body');
    if (!input || !tableBody) return;

    let searchStr = input;
    if (input.includes('?')) {
        searchStr = input.substring(input.indexOf('?') + 1);
    }
    if (searchStr.includes('#')) {
        searchStr = searchStr.substring(0, searchStr.indexOf('#'));
    }

    const params = new URLSearchParams(searchStr);
    let html = '';
    let count = 0;
    const queryObj = {};

    params.forEach((val, key) => {
        count++;
        let decoded = val;
        try { decoded = decodeURIComponent(val); } catch(e) {}

        if (!queryObj[key]) {
            queryObj[key] = decoded;
        } else if (Array.isArray(queryObj[key])) {
            queryObj[key].push(decoded);
        } else {
            queryObj[key] = [queryObj[key], decoded];
        }

        html += `<tr style="border-bottom:1px solid var(--border);">
            <td style="padding:10px 12px; font-weight:700; color:var(--brand-dark);">${escapeHtml(key)}</td>
            <td style="padding:10px 12px; color:var(--text);">${escapeHtml(decoded)}</td>
            <td style="padding:10px 12px; color:var(--text-muted);">${escapeHtml(val)}</td>
        </tr>`;
    });

    window.lastQueryJson = queryObj;

    if (count === 0) {
        tableBody.innerHTML = '<tr><td colspan="3" style="padding:20px; text-align:center; color:var(--text-muted);">No query parameters found in the input string.</td></tr>';
    } else {
        tableBody.innerHTML = html;
        showToast(`Parsed ${count} parameter(s)!`);
    }
}

function escapeHtml(str) {
    return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
}

function copyQueryJson() {
    if (!window.lastQueryJson || Object.keys(window.lastQueryJson).length === 0) {
        showToast("Please parse a query string first.", true);
        return;
    }
    navigator.clipboard.writeText(JSON.stringify(window.lastQueryJson, null, 2));
    showToast("Query JSON copied to clipboard!");
}

function loadQuerySample() {
    const input = document.getElementById('query-string-input');
    if (input) {
        input.value = "https://webtoolsstation.test/search?q=developer+tools&category=dev&sort=rating&tags=json&tags=regex&active=true&page=1";
        parseQueryString();
    }
}

// Cron Expression Helper
function setCron(expr) {
    const input = document.getElementById('cron-input');
    if (input) {
        input.value = expr;
        evaluateCron();
    }
}

function evaluateCron() {
    const input = document.getElementById('cron-input')?.value.trim() || '';
    if (!input) return;

    const parts = input.split(/\s+/);
    if (parts.length < 5) {
        document.getElementById('cron-human-desc').textContent = "Incomplete cron expression (requires 5 fields: minute hour day-of-month month day-of-week).";
        return;
    }

    const [min, hour, dom, mon, dow] = parts;

    document.getElementById('cron-f-min').textContent = min;
    document.getElementById('cron-f-hour').textContent = hour;
    document.getElementById('cron-f-dom').textContent = dom;
    document.getElementById('cron-f-mon').textContent = mon;
    document.getElementById('cron-f-dow').textContent = dow;

    // Human description synthesis
    let desc = describeCron(min, hour, dom, mon, dow);
    document.getElementById('cron-human-desc').textContent = desc;

    // Next 5 runs calculation
    computeNextCronRuns(min, hour, dom, mon, dow);
}

function describeCron(min, hour, dom, mon, dow) {
    let mDesc = min === '*' ? 'every minute' : (min.startsWith('*/') ? `every ${min.replace('*/', '')} minutes` : `at minute ${min}`);
    let hDesc = hour === '*' ? 'of every hour' : (hour.startsWith('*/') ? `every ${hour.replace('*/', '')} hours` : `at hour ${hour}:00`);

    let dowMap = { '0': 'Sunday', '1': 'Monday', '2': 'Tuesday', '3': 'Wednesday', '4': 'Thursday', '5': 'Friday', '6': 'Saturday', '7': 'Sunday' };
    let dDesc = '';
    if (dow === '1-5') dDesc = 'Monday through Friday';
    else if (dow === '0,6' || dow === '6,0') dDesc = 'on weekends';
    else if (dow !== '*') dDesc = `on ${dow.split(',').map(d => dowMap[d] || d).join(', ')}`;

    if (min === '0' && hour === '0' && dom === '*' && mon === '*' && dow === '*') return 'Every day at midnight (00:00)';
    if (min === '0' && hour === '9' && dow === '1-5') return 'At 09:00 AM, Monday through Friday';
    if (min.startsWith('*/')) return `Every ${min.replace('*/', '')} minutes, past every hour`;

    let out = `${mDesc} ${hDesc}`;
    if (dDesc) out += `, ${dDesc}`;
    return out.charAt(0).toUpperCase() + out.slice(1);
}

function computeNextCronRuns(min, hour, dom, mon, dow) {
    const list = document.getElementById('cron-next-runs');
    if (!list) return;

    const runs = [];
    let date = new Date();
    date.setSeconds(0, 0);

    // Look forward up to 5 occurrences
    for (let i = 0; i < 5000 && runs.length < 5; i++) {
        date = new Date(date.getTime() + 60000); // add 1 minute
        if (matchesCronField(date.getMinutes(), min) &&
            matchesCronField(date.getHours(), hour) &&
            matchesCronField(date.getDate(), dom) &&
            matchesCronField(date.getMonth() + 1, mon) &&
            matchesCronField(date.getDay(), dow)) {
            runs.push(new Date(date));
        }
    }

    if (runs.length === 0) {
        list.innerHTML = '<li>Unable to calculate schedule within the next 30 days.</li>';
    } else {
        list.innerHTML = runs.map((r, i) => `<li><strong>#${i + 1}:</strong> ${r.toLocaleString(undefined, { weekday: 'short', year: 'numeric', month: 'short', day: 'numeric', hour: '2-digit', minute: '2-digit' })}</li>`).join('');
    }
}

function matchesCronField(val, expr) {
    if (expr === '*') return true;
    if (expr.startsWith('*/')) {
        const step = parseInt(expr.replace('*/', ''), 10);
        return val % step === 0;
    }
    if (expr.includes(',')) {
        return expr.split(',').map(Number).includes(val);
    }
    if (expr.includes('-')) {
        const [start, end] = expr.split('-').map(Number);
        return val >= start && val <= end;
    }
    return Number(expr) === val;
}

// =============================================================
// BATCH 1 DEVELOPER TOOLS — NEW IMPLEMENTATIONS
// =============================================================

// ==========================================
// YAML FORMATTER
// ==========================================
function runYamlFormatter() {
    const inputEl = document.getElementById('yaml-fmt-input');
    const outputEl = document.getElementById('yaml-fmt-output');
    const errBox = document.getElementById('yaml-fmt-error');
    const errMsg = document.getElementById('yaml-fmt-error-msg');
    if (!inputEl || !outputEl) return;

    const input = inputEl.value;
    if (!input.trim()) {
        showToast('Please paste YAML content to format.', true);
        return;
    }

    // Hide previous errors
    if (errBox) errBox.style.display = 'none';

    try {
        const indentSize = parseInt(document.getElementById('yaml-indent-size')?.value || '2', 10);
        const formatted = formatYamlCode(input, indentSize);
        outputEl.value = formatted;

        const inStats = document.getElementById('yaml-fmt-input-stats');
        const outStats = document.getElementById('yaml-fmt-output-stats');
        if (inStats) inStats.textContent = `${input.split('\n').length} lines | ${input.length} characters`;
        if (outStats) outStats.textContent = `${formatted.split('\n').length} lines | ${formatted.length} characters`;

        showToast('YAML formatted successfully!');
    } catch (err) {
        if (errBox && errMsg) {
            errMsg.textContent = err.message;
            errBox.style.display = 'block';
        }
        showToast('YAML syntax error.', true);
    }
}

function formatYamlCode(yamlText, indentSize) {
    // Validate: no tabs allowed
    if (/\t/.test(yamlText)) {
        throw new Error('YAML prohibits tab characters. Replace all tabs with spaces.');
    }
    // Re-parse and re-serialize to normalize indentation
    const lines = yamlText.split(/\r?\n/);
    const result = [];
    const space = ' '.repeat(indentSize);

    let inBlockScalar = false;
    let blockScalarIndent = -1;

    for (let i = 0; i < lines.length; i++) {
        const raw = lines[i];
        const trimmed = raw.trim();

        // Skip empty lines cleanly
        if (trimmed === '') {
            result.push('');
            inBlockScalar = false;
            continue;
        }

        // Preserve comments as-is (aligned to their indent level)
        if (trimmed.startsWith('#')) {
            const currentIndent = raw.search(/\S/);
            const normalizedIndent = Math.round(currentIndent / indentSize) * indentSize;
            result.push(' '.repeat(normalizedIndent) + trimmed);
            continue;
        }

        // Handle block scalars (| and >)
        if (inBlockScalar) {
            const currentIndent = raw.search(/\S/);
            if (currentIndent > blockScalarIndent) {
                result.push(raw); // preserve literal block content
                continue;
            } else {
                inBlockScalar = false;
            }
        }

        const currentIndent = raw.search(/\S/);
        const normalizedIndent = Math.round(currentIndent / indentSize) * indentSize;

        // Detect block scalars
        if (trimmed.endsWith('|') || trimmed.endsWith('>') || trimmed.endsWith('|-') || trimmed.endsWith('>-')) {
            inBlockScalar = true;
            blockScalarIndent = currentIndent;
        }

        // Normalize list items
        if (trimmed.startsWith('- ') || trimmed === '-') {
            result.push(' '.repeat(normalizedIndent) + trimmed);
            continue;
        }

        // Check key: value pairs — ensure space after colon
        const colonIdx = trimmed.indexOf(':');
        if (colonIdx > 0) {
            const afterColon = trimmed.substring(colonIdx + 1);
            if (afterColon !== '' && !afterColon.startsWith(' ') && !afterColon.startsWith('\t')) {
                result.push(' '.repeat(normalizedIndent) + trimmed.substring(0, colonIdx) + ': ' + afterColon.trim());
                continue;
            }
        }

        result.push(' '.repeat(normalizedIndent) + trimmed);
    }

    return result.join('\n').replace(/\n{3,}/g, '\n\n').trim();
}

function clearYamlFormatter() {
    const el = document.getElementById('yaml-fmt-input');
    const out = document.getElementById('yaml-fmt-output');
    if (el) el.value = '';
    if (out) out.value = '';
    const errBox = document.getElementById('yaml-fmt-error');
    if (errBox) errBox.style.display = 'none';
}

function loadYamlFormatterSample() {
    const el = document.getElementById('yaml-fmt-input');
    if (el) {
        el.value = `services:\n  web:\n    image: nginx:alpine\n    ports:\n    - "80:80"\n    environment:\n      NODE_ENV: production\n      API_URL: https://api.example.com\n  db:\n    image: postgres:15\n    environment:\n      POSTGRES_DB: appdb\n      POSTGRES_USER: admin`;
        runYamlFormatter();
    }
}

async function pasteYamlFormatterClipboard() {
    try {
        const text = await navigator.clipboard.readText();
        const el = document.getElementById('yaml-fmt-input');
        if (el) { el.value = text; runYamlFormatter(); }
    } catch(e) { showToast('Clipboard read failed — paste manually.', true); }
}

function downloadYamlFormatted() {
    const out = document.getElementById('yaml-fmt-output');
    if (!out || !out.value.trim()) { showToast('Nothing to download yet.', true); return; }
    const blob = new Blob([out.value], { type: 'text/yaml' });
    const a = document.createElement('a');
    a.href = URL.createObjectURL(blob);
    a.download = 'formatted.yaml';
    a.click();
    URL.revokeObjectURL(a.href);
}

// ==========================================
// YAML VALIDATOR
// ==========================================
function runYamlValidator() {
    const inputEl = document.getElementById('yaml-val-input');
    const outputEl = document.getElementById('yaml-val-output');
    const initBox = document.getElementById('yaml-val-initial');
    const successBox = document.getElementById('yaml-val-success');
    const failureBox = document.getElementById('yaml-val-failure');
    const errorDetails = document.getElementById('yaml-val-error-details');

    if (!inputEl) return;
    const input = inputEl.value;
    if (!input.trim()) { showToast('Please paste YAML to validate.', true); return; }

    if (initBox) initBox.style.display = 'none';

    try {
        // Check for tabs
        const lines = input.split('\n');
        for (let i = 0; i < lines.length; i++) {
            if (/\t/.test(lines[i])) {
                throw new Error(`Line ${i + 1}: Tab character detected. YAML requires spaces for indentation.`);
            }
        }

        // Try parse
        const parsed = parseYamlBlock(input.split(/\r?\n/), 0);
        if (parsed === null && input.trim()) {
            throw new Error('Could not parse YAML document structure. Check mapping keys and list items.');
        }

        if (successBox) { successBox.style.display = 'block'; }
        if (failureBox) { failureBox.style.display = 'none'; }
        if (outputEl) outputEl.value = JSON.stringify(parsed, null, 2);
        showToast('YAML is valid!');
    } catch (err) {
        if (successBox) { successBox.style.display = 'none'; }
        if (failureBox) { failureBox.style.display = 'block'; }
        if (errorDetails) errorDetails.textContent = err.message;
        if (outputEl) outputEl.value = '';
        showToast('YAML validation failed.', true);
    }
}

function clearYamlValidator() {
    const el = document.getElementById('yaml-val-input');
    if (el) el.value = '';
    const out = document.getElementById('yaml-val-output');
    if (out) out.value = '';
    const init = document.getElementById('yaml-val-initial');
    if (init) init.style.display = 'flex';
    const s = document.getElementById('yaml-val-success');
    if (s) s.style.display = 'none';
    const f = document.getElementById('yaml-val-failure');
    if (f) f.style.display = 'none';
}

function loadYamlValidatorSample() {
    const el = document.getElementById('yaml-val-input');
    if (el) {
        el.value = `name: webtools-app\nhosts: all\ntasks:\n  - name: Install Nginx\n    apt:\n      name: nginx\n      state: present\n  - name: Start Nginx\n    service:\n      name: nginx\n      state: started\n      enabled: yes`;
        runYamlValidator();
    }
}

async function pasteYamlValidatorClipboard() {
    try {
        const text = await navigator.clipboard.readText();
        const el = document.getElementById('yaml-val-input');
        if (el) { el.value = text; }
    } catch(e) { showToast('Clipboard read failed — paste manually.', true); }
}

// ==========================================
// JWT GENERATOR
// ==========================================
function base64UrlEncode(str) {
    const bytes = new TextEncoder().encode(str);
    let binary = '';
    for (let i = 0; i < bytes.length; i++) {
        binary += String.fromCharCode(bytes[i]);
    }
    return btoa(binary).replace(/\+/g, '-').replace(/\//g, '_').replace(/=/g, '');
}

function setJwtExpiry(seconds) {
    const nowSec = Math.floor(Date.now() / 1000);
    const payloadEl = document.getElementById('jwt-gen-payload');
    if (!payloadEl) return;
    try {
        let payload = JSON.parse(payloadEl.value || '{}');
        payload.iat = nowSec;
        payload.exp = nowSec + seconds;
        payloadEl.value = JSON.stringify(payload, null, 2);
    } catch(e) {
        const payload = { sub: 'user123', iat: nowSec, exp: nowSec + seconds };
        payloadEl.value = JSON.stringify(payload, null, 2);
    }
}

function loadJwtGenSample() {
    const payloadEl = document.getElementById('jwt-gen-payload');
    const secretEl = document.getElementById('jwt-gen-secret');
    if (payloadEl) {
        const nowSec = Math.floor(Date.now() / 1000);
        payloadEl.value = JSON.stringify({
            sub: 'user_12345',
            name: 'Jane Developer',
            email: 'jane@example.com',
            role: 'admin',
            iat: nowSec,
            exp: nowSec + 3600
        }, null, 2);
    }
    if (secretEl && !secretEl.value) secretEl.value = 'my-super-secret-key-change-in-production';
}

async function generateJwtToken() {
    const algoEl = document.getElementById('jwt-gen-algo');
    const secretEl = document.getElementById('jwt-gen-secret');
    const payloadEl = document.getElementById('jwt-gen-payload');
    const outputEl = document.getElementById('jwt-gen-output');

    const algo = algoEl?.value || 'HS256';
    const secret = secretEl?.value || '';
    const payloadText = payloadEl?.value.trim() || '{}';

    if (!secret) { showToast('Please enter a secret key.', true); return; }

    let payloadObj;
    try {
        payloadObj = JSON.parse(payloadText);
    } catch (e) {
        showToast('Invalid JSON payload — fix the syntax.', true);
        return;
    }

    const hashAlgoMap = { 'HS256': 'SHA-256', 'HS384': 'SHA-384', 'HS512': 'SHA-512' };
    const hashAlgo = hashAlgoMap[algo] || 'SHA-256';

    const header = { alg: algo, typ: 'JWT' };
    const headerB64 = base64UrlEncode(JSON.stringify(header));
    const payloadB64 = base64UrlEncode(JSON.stringify(payloadObj));
    const signingInput = `${headerB64}.${payloadB64}`;

    try {
        const enc = new TextEncoder();
        const keyData = enc.encode(secret);
        const msgData = enc.encode(signingInput);

        const cryptoKey = await window.crypto.subtle.importKey(
            'raw', keyData,
            { name: 'HMAC', hash: { name: hashAlgo } },
            false, ['sign']
        );

        const signature = await window.crypto.subtle.sign('HMAC', cryptoKey, msgData);
        const sigBytes = new Uint8Array(signature);
        const sigB64 = btoa(String.fromCharCode(...sigBytes))
            .replace(/\+/g, '-').replace(/\//g, '_').replace(/=/g, '');

        const token = `${signingInput}.${sigB64}`;
        if (outputEl) outputEl.value = token;

        // Color preview
        const previewEl = document.getElementById('jwt-gen-decoded-preview');
        if (previewEl) {
            document.getElementById('jwt-part-header').textContent = headerB64;
            document.getElementById('jwt-part-payload').textContent = payloadB64;
            document.getElementById('jwt-part-sig').textContent = sigB64;
            previewEl.style.display = 'block';
        }

        showToast('JWT generated successfully!');
    } catch (err) {
        showToast('JWT generation failed: ' + err.message, true);
    }
}

// ==========================================
// NANOID GENERATOR
// ==========================================
const NANOID_ALPHABETS = {
    url: 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789_-',
    numbers: '0123456789',
    hex: '0123456789abcdef',
    lower: 'abcdefghijklmnopqrstuvwxyz0123456789'
};

let currentNanoIdAlphabet = NANOID_ALPHABETS.url;

function setNanoIdAlphabet(preset, btn) {
    currentNanoIdAlphabet = NANOID_ALPHABETS[preset] || NANOID_ALPHABETS.url;
    document.getElementById('nanoid-custom-alpha').value = '';
    document.querySelectorAll('.nanoid-preset').forEach(b => {
        b.classList.toggle('btn-secondary', b === btn);
        b.classList.toggle('active', b === btn);
        b.classList.toggle('btn-ghost', b !== btn);
    });
    updateNanoIdEntropyNote();
}

function nanoidCustomAlphaChange() {
    const val = document.getElementById('nanoid-custom-alpha')?.value || '';
    if (val.length >= 2) {
        currentNanoIdAlphabet = val;
        document.querySelectorAll('.nanoid-preset').forEach(b => {
            b.classList.remove('btn-secondary', 'active');
            b.classList.add('btn-ghost');
        });
    } else if (!val) {
        currentNanoIdAlphabet = NANOID_ALPHABETS.url;
    }
    updateNanoIdEntropyNote();
}

function updateNanoIdEntropyNote() {
    const noteEl = document.getElementById('nanoid-entropy-note');
    if (!noteEl) return;
    const len = parseInt(document.getElementById('nanoid-length')?.value || '21', 10);
    const alphabetLen = currentNanoIdAlphabet.length;
    const bitsPerChar = Math.log2(alphabetLen);
    const totalBits = Math.floor(len * bitsPerChar);
    noteEl.textContent = `${len} chars × ${alphabetLen}-char alphabet = ~${totalBits} bits of entropy per ID`;
}

function generateNanoId(length, alphabet) {
    const mask = (2 << (31 - Math.clz32((alphabet.length - 1) | 1))) - 1;
    const step = Math.ceil((1.6 * mask * length) / alphabet.length);
    let id = '';
    while (true) {
        const bytes = new Uint8Array(step);
        window.crypto.getRandomValues(bytes);
        for (let i = 0; i < step; i++) {
            const byte = bytes[i] & mask;
            if (byte < alphabet.length) {
                id += alphabet[byte];
                if (id.length === length) return id;
            }
        }
    }
}

function generateNanoIds() {
    const length = parseInt(document.getElementById('nanoid-length')?.value || '21', 10);
    const count = Math.min(50, Math.max(1, parseInt(document.getElementById('nanoid-count')?.value || '5', 10)));
    const alphabet = currentNanoIdAlphabet;

    if (alphabet.length < 2) { showToast('Alphabet must have at least 2 characters.', true); return; }

    const ids = [];
    for (let i = 0; i < count; i++) {
        ids.push(generateNanoId(length, alphabet));
    }

    const out = document.getElementById('nanoid-output');
    if (out) out.value = ids.join('\n');
    updateNanoIdEntropyNote();
    showToast(`Generated ${count} NanoID${count > 1 ? 's' : ''}!`);
}

// ==========================================
// DEDICATED HASH GENERATORS (SHA-1, SHA-512, MD5)
// ==========================================
let dedicatedHashCurrentFormat = 'lower';
let dedicatedHashLastHex = '';

async function computeDedicatedHash() {
    const inputEl = document.getElementById('dedicated-hash-input');
    const algoEl = document.getElementById('dedicated-hash-algo');
    const valEl = document.getElementById('dedicated-hash-val');
    const statusEl = document.getElementById('dedicated-hash-status');

    if (!inputEl || !algoEl || !valEl) return;

    const text = inputEl.value;
    const algo = algoEl.value; // 'SHA-1', 'SHA-512', 'MD5'

    if (!text) {
        valEl.textContent = '—';
        dedicatedHashLastHex = '';
        if (statusEl) statusEl.textContent = 'Enter text above to compute the hash.';
        return;
    }

    try {
        let hexDigest = '';

        if (algo === 'MD5') {
            hexDigest = computeMD5(text);
        } else {
            const enc = new TextEncoder();
            const data = enc.encode(text);
            const hashBuf = await window.crypto.subtle.digest(algo, data);
            const hashArr = new Uint8Array(hashBuf);
            hexDigest = Array.from(hashArr).map(b => b.toString(16).padStart(2, '0')).join('');
        }

        dedicatedHashLastHex = hexDigest;
        renderDedicatedHash();

        if (statusEl) {
            const byteCount = new TextEncoder().encode(text).length;
            statusEl.textContent = `Input: ${text.length} character${text.length !== 1 ? 's' : ''} (${byteCount} bytes)`;
        }
    } catch (err) {
        valEl.textContent = 'Error: ' + err.message;
    }
}

function renderDedicatedHash() {
    const valEl = document.getElementById('dedicated-hash-val');
    if (!valEl || !dedicatedHashLastHex) return;

    let display = dedicatedHashLastHex;
    if (dedicatedHashCurrentFormat === 'upper') display = dedicatedHashLastHex.toUpperCase();
    else if (dedicatedHashCurrentFormat === 'base64') {
        const bytes = dedicatedHashLastHex.match(/.{2}/g).map(h => parseInt(h, 16));
        display = btoa(String.fromCharCode(...bytes));
    }
    valEl.textContent = display;
}

function switchHashFormat(fmt, btn) {
    dedicatedHashCurrentFormat = fmt;
    document.querySelectorAll('.dedicated-hash-fmt').forEach(b => {
        b.classList.toggle('btn-secondary', b === btn);
        b.classList.toggle('active', b === btn);
        b.classList.toggle('btn-ghost', b !== btn);
    });
    renderDedicatedHash();
}

function copyDedicatedHash() {
    const valEl = document.getElementById('dedicated-hash-val');
    if (!valEl || valEl.textContent === '—') {
        showToast('No hash to copy yet.', true);
        return;
    }
    navigator.clipboard.writeText(valEl.textContent);
    showToast('Hash copied to clipboard!');
}

// ==========================================
// CURL COMMAND GENERATOR
// ==========================================
let curlAuthMode = 'none';

function setCurlAuth(mode, btn) {
    curlAuthMode = mode;
    document.querySelectorAll('.curl-auth-btn').forEach(b => {
        b.classList.toggle('active', b === btn);
        b.classList.toggle('btn-secondary', b === btn);
        b.classList.toggle('btn-ghost', b !== btn);
    });
    const bearerDiv = document.getElementById('curl-auth-bearer');
    const basicDiv = document.getElementById('curl-auth-basic');
    if (bearerDiv) bearerDiv.style.display = mode === 'bearer' ? 'block' : 'none';
    if (basicDiv) basicDiv.style.display = mode === 'basic' ? 'grid' : 'none';
    buildCurlCommand();
}

function buildCurlCommand() {
    const method = document.getElementById('curl-method')?.value || 'GET';
    const url = document.getElementById('curl-url')?.value.trim() || '';
    const headersRaw = document.getElementById('curl-headers')?.value || '';
    const body = document.getElementById('curl-body')?.value.trim() || '';
    const flagL = document.getElementById('curl-flag-L')?.checked;
    const flagS = document.getElementById('curl-flag-s')?.checked;
    const flagK = document.getElementById('curl-flag-k')?.checked;
    const flagI = document.getElementById('curl-flag-i')?.checked;
    const outputEl = document.getElementById('curl-output');

    if (!url) {
        if (outputEl) outputEl.value = '# Enter a URL above to generate the cURL command';
        return;
    }

    const parts = ['curl'];

    // Flags
    let flags = `-X ${method}`;
    if (flagL) flags += ' -L';
    if (flagS) flags += ' -s';
    if (flagK) flags += ' -k';
    if (flagI) flags += ' -i';
    parts.push(flags);

    // URL
    parts.push(`"${url}"`);

    // Auth header
    if (curlAuthMode === 'bearer') {
        const token = document.getElementById('curl-bearer-token')?.value.trim() || '';
        if (token) parts.push(`  -H "Authorization: Bearer ${token}"`);
    } else if (curlAuthMode === 'basic') {
        const user = document.getElementById('curl-basic-user')?.value.trim() || '';
        const pass = document.getElementById('curl-basic-pass')?.value.trim() || '';
        if (user || pass) parts.push(`  -u "${user}:${pass}"`);
    }

    // Custom headers
    if (headersRaw.trim()) {
        const headerLines = headersRaw.trim().split('\n');
        headerLines.forEach(line => {
            const trimLine = line.trim();
            if (trimLine && trimLine.includes(':')) {
                parts.push(`  -H "${trimLine.replace(/"/g, '\\"')}"`);
            }
        });
    }

    // Body
    if (body && !['GET', 'HEAD', 'OPTIONS'].includes(method)) {
        // Auto-add Content-Type if not already in headers
        if (!headersRaw.toLowerCase().includes('content-type')) {
            parts.push(`  -H "Content-Type: application/json"`);
        }
        // Escape single quotes in body for shell
        const escapedBody = body.replace(/'/g, "'\"'\"'");
        parts.push(`  -d '${escapedBody}'`);
    }

    if (outputEl) outputEl.value = parts.join(' \\\n');
}

function loadCurlSample() {
    const methodEl = document.getElementById('curl-method');
    const urlEl = document.getElementById('curl-url');
    const headersEl = document.getElementById('curl-headers');
    const bodyEl = document.getElementById('curl-body');
    const tokenEl = document.getElementById('curl-bearer-token');

    if (methodEl) methodEl.value = 'POST';
    if (urlEl) urlEl.value = 'https://api.example.com/v1/users';
    if (headersEl) headersEl.value = 'Accept: application/json';
    if (bodyEl) bodyEl.value = JSON.stringify({ name: 'Jane Developer', email: 'jane@example.com', role: 'admin' }, null, 2);
    if (tokenEl) tokenEl.value = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.sample';

    // Activate bearer auth
    const bearerBtn = document.querySelector('.curl-auth-btn[onclick*="bearer"]');
    if (bearerBtn) setCurlAuth('bearer', bearerBtn);

    buildCurlCommand();
}

// ==========================================
// HTTP HEADER ANALYZER
// ==========================================
function clearHttpHeadersReport() {
    const report = document.getElementById('http-headers-report');
    if (report) report.style.display = 'none';
}

function loadHttpHeadersSample() {
    const el = document.getElementById('http-headers-input');
    if (el) {
        el.value = `HTTP/2 200 OK\ncontent-type: text/html; charset=utf-8\nstrict-transport-security: max-age=31536000; includeSubDomains; preload\ncontent-security-policy: default-src 'self'; script-src 'self' 'nonce-abc123'\nx-frame-options: DENY\nx-content-type-options: nosniff\nreferrer-policy: strict-origin-when-cross-origin\ncache-control: no-store, max-age=0\nx-powered-by: Express\nserver: cloudflare`;
        analyzeHttpHeaders();
    }
}

function analyzeHttpHeaders() {
    const inputEl = document.getElementById('http-headers-input');
    const reportEl = document.getElementById('http-headers-report');
    const tableBody = document.getElementById('http-headers-table-body');
    const scoreGrid = document.getElementById('http-score-grid');
    const scoreBadge = document.getElementById('http-score-badge');

    if (!inputEl || !inputEl.value.trim()) {
        showToast('Please paste HTTP response headers first.', true);
        return;
    }

    const raw = inputEl.value.trim();
    const lines = raw.split(/\r?\n/);

    // Parse headers
    const headers = {};
    let statusLine = '';

    for (const line of lines) {
        if (line.startsWith('HTTP/')) {
            statusLine = line;
            continue;
        }
        const colonIdx = line.indexOf(':');
        if (colonIdx > 0) {
            const name = line.substring(0, colonIdx).trim().toLowerCase();
            const value = line.substring(colonIdx + 1).trim();
            headers[name] = value;
        }
    }

    // Build parsed table
    if (tableBody) {
        const rows = Object.entries(headers).map(([name, value]) => {
            return `<tr style="border-bottom:1px solid var(--border);">
                <td style="padding:8px 12px; font-family:var(--font-mono); font-weight:600; color:var(--brand-dark);">${escapeHtml(name)}</td>
                <td style="padding:8px 12px; font-family:var(--font-mono); word-break:break-all;">${escapeHtml(value)}</td>
            </tr>`;
        });
        tableBody.innerHTML = rows.join('') || '<tr><td colspan="2" style="padding:20px; text-align:center;">No headers parsed.</td></tr>';
    }

    // Security scorecard
    const securityChecks = [
        {
            name: 'HSTS',
            key: 'strict-transport-security',
            check: (v) => v && v.includes('max-age='),
            good: 'HSTS enabled',
            bad: 'Missing HSTS header',
            tip: 'Add: Strict-Transport-Security: max-age=31536000; includeSubDomains'
        },
        {
            name: 'CSP',
            key: 'content-security-policy',
            check: (v) => !!v,
            good: 'CSP defined',
            bad: 'Missing Content-Security-Policy',
            tip: "Add: Content-Security-Policy: default-src 'self'"
        },
        {
            name: 'X-Frame-Options',
            key: 'x-frame-options',
            check: (v) => v && (v.toUpperCase() === 'DENY' || v.toUpperCase() === 'SAMEORIGIN'),
            good: 'Clickjacking protection enabled',
            bad: 'Missing X-Frame-Options',
            tip: 'Add: X-Frame-Options: DENY'
        },
        {
            name: 'X-Content-Type-Options',
            key: 'x-content-type-options',
            check: (v) => v && v.toLowerCase().includes('nosniff'),
            good: 'MIME sniffing disabled',
            bad: 'Missing X-Content-Type-Options',
            tip: 'Add: X-Content-Type-Options: nosniff'
        },
        {
            name: 'Referrer-Policy',
            key: 'referrer-policy',
            check: (v) => !!v,
            good: 'Referrer policy set',
            bad: 'Missing Referrer-Policy',
            tip: 'Add: Referrer-Policy: strict-origin-when-cross-origin'
        }
    ];

    let score = 0;
    const gridItems = securityChecks.map(check => {
        const headerValue = headers[check.key];
        const passed = check.check(headerValue);
        if (passed) score += 20;

        const color = passed ? 'var(--success)' : 'var(--danger)';
        const bg = passed ? 'var(--success-bg)' : 'var(--danger-bg)';
        const icon = passed
            ? '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>'
            : '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>';

        const tooltip = passed ? check.good : `${check.bad}. ${check.tip}`;

        return `<div style="padding:10px; background:${bg}; border:1px solid ${color}30; border-radius:var(--radius-sm); color:${color};" title="${escapeHtml(tooltip)}">
            <div style="display:flex; align-items:center; gap:6px; font-weight:700; font-size:0.82rem;">${icon} ${check.name}</div>
            <div style="font-size:0.75rem; margin-top:4px; opacity:0.85;">${passed ? check.good : check.bad}</div>
        </div>`;
    });

    if (scoreGrid) scoreGrid.innerHTML = gridItems.join('');

    // Grade
    let grade = 'F';
    if (score === 100) grade = 'A+';
    else if (score >= 80) grade = 'A';
    else if (score >= 60) grade = 'B';
    else if (score >= 40) grade = 'C';
    else if (score >= 20) grade = 'D';

    const gradeColor = score >= 80 ? 'var(--success)' : score >= 40 ? '#f59e0b' : 'var(--danger)';
    if (scoreBadge) {
        scoreBadge.style.color = gradeColor;
        scoreBadge.textContent = `${grade} (${score}/100)`;
    }

    if (reportEl) reportEl.style.display = 'block';
    showToast(`Headers analyzed — Security Score: ${score}/100 (${grade})`);
}

function escapeHtml(str) {
    return String(str)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;');
}

// ==========================================
// MIME TYPE LOOKUP
// ==========================================
const MIME_DATABASE = [
    // Application
    {ext:'.json',mime:'application/json',cat:'application'},
    {ext:'.jsonld',mime:'application/ld+json',cat:'application'},
    {ext:'.pdf',mime:'application/pdf',cat:'application'},
    {ext:'.zip',mime:'application/zip',cat:'application'},
    {ext:'.gz',mime:'application/gzip',cat:'application'},
    {ext:'.tar',mime:'application/x-tar',cat:'application'},
    {ext:'.rar',mime:'application/vnd.rar',cat:'application'},
    {ext:'.7z',mime:'application/x-7z-compressed',cat:'application'},
    {ext:'.xml',mime:'application/xml',cat:'application'},
    {ext:'.wasm',mime:'application/wasm',cat:'application'},
    {ext:'.js',mime:'text/javascript',cat:'text'},
    {ext:'.mjs',mime:'text/javascript',cat:'text'},
    {ext:'.bin',mime:'application/octet-stream',cat:'application'},
    {ext:'.bz2',mime:'application/x-bzip2',cat:'application'},
    {ext:'.epub',mime:'application/epub+zip',cat:'application'},
    {ext:'.jar',mime:'application/java-archive',cat:'application'},
    {ext:'.doc',mime:'application/msword',cat:'application'},
    {ext:'.docx',mime:'application/vnd.openxmlformats-officedocument.wordprocessingml.document',cat:'application'},
    {ext:'.xls',mime:'application/vnd.ms-excel',cat:'application'},
    {ext:'.xlsx',mime:'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',cat:'application'},
    {ext:'.ppt',mime:'application/vnd.ms-powerpoint',cat:'application'},
    {ext:'.pptx',mime:'application/vnd.openxmlformats-officedocument.presentationml.presentation',cat:'application'},
    {ext:'.odt',mime:'application/vnd.oasis.opendocument.text',cat:'application'},
    {ext:'.ods',mime:'application/vnd.oasis.opendocument.spreadsheet',cat:'application'},
    {ext:'.odp',mime:'application/vnd.oasis.opendocument.presentation',cat:'application'},
    {ext:'.sh',mime:'application/x-sh',cat:'application'},
    {ext:'.swf',mime:'application/x-shockwave-flash',cat:'application'},
    {ext:'.php',mime:'application/x-httpd-php',cat:'application'},
    {ext:'.xhtml',mime:'application/xhtml+xml',cat:'application'},
    {ext:'.atom',mime:'application/atom+xml',cat:'application'},
    {ext:'.rss',mime:'application/rss+xml',cat:'application'},
    {ext:'.yaml',mime:'application/yaml',cat:'application'},
    {ext:'.yml',mime:'application/yaml',cat:'application'},
    {ext:'.toml',mime:'application/toml',cat:'application'},
    {ext:'.ndjson',mime:'application/x-ndjson',cat:'application'},
    {ext:'.geojson',mime:'application/geo+json',cat:'application'},
    {ext:'.sqlite',mime:'application/vnd.sqlite3',cat:'application'},
    {ext:'.sql',mime:'application/sql',cat:'application'},
    // Image
    {ext:'.apng',mime:'image/apng',cat:'image'},
    {ext:'.avif',mime:'image/avif',cat:'image'},
    {ext:'.bmp',mime:'image/bmp',cat:'image'},
    {ext:'.gif',mime:'image/gif',cat:'image'},
    {ext:'.ico',mime:'image/x-icon',cat:'image'},
    {ext:'.jpeg',mime:'image/jpeg',cat:'image'},
    {ext:'.jpg',mime:'image/jpeg',cat:'image'},
    {ext:'.png',mime:'image/png',cat:'image'},
    {ext:'.svg',mime:'image/svg+xml',cat:'image'},
    {ext:'.tif',mime:'image/tiff',cat:'image'},
    {ext:'.tiff',mime:'image/tiff',cat:'image'},
    {ext:'.webp',mime:'image/webp',cat:'image'},
    {ext:'.heic',mime:'image/heic',cat:'image'},
    {ext:'.heif',mime:'image/heif',cat:'image'},
    {ext:'.jxl',mime:'image/jxl',cat:'image'},
    {ext:'.psd',mime:'image/vnd.adobe.photoshop',cat:'image'},
    // Audio
    {ext:'.aac',mime:'audio/aac',cat:'audio'},
    {ext:'.flac',mime:'audio/flac',cat:'audio'},
    {ext:'.m4a',mime:'audio/mp4',cat:'audio'},
    {ext:'.mid',mime:'audio/midi',cat:'audio'},
    {ext:'.midi',mime:'audio/midi',cat:'audio'},
    {ext:'.mp3',mime:'audio/mpeg',cat:'audio'},
    {ext:'.oga',mime:'audio/ogg',cat:'audio'},
    {ext:'.ogg',mime:'audio/ogg',cat:'audio'},
    {ext:'.opus',mime:'audio/opus',cat:'audio'},
    {ext:'.wav',mime:'audio/wav',cat:'audio'},
    {ext:'.weba',mime:'audio/webm',cat:'audio'},
    // Video
    {ext:'.avi',mime:'video/x-msvideo',cat:'video'},
    {ext:'.mp4',mime:'video/mp4',cat:'video'},
    {ext:'.mpeg',mime:'video/mpeg',cat:'video'},
    {ext:'.ogv',mime:'video/ogg',cat:'video'},
    {ext:'.ts',mime:'video/mp2t',cat:'video'},
    {ext:'.webm',mime:'video/webm',cat:'video'},
    {ext:'.3gp',mime:'video/3gpp',cat:'video'},
    {ext:'.3g2',mime:'video/3gpp2',cat:'video'},
    {ext:'.mkv',mime:'video/x-matroska',cat:'video'},
    {ext:'.mov',mime:'video/quicktime',cat:'video'},
    {ext:'.wmv',mime:'video/x-ms-wmv',cat:'video'},
    {ext:'.flv',mime:'video/x-flv',cat:'video'},
    // Text
    {ext:'.css',mime:'text/css',cat:'text'},
    {ext:'.csv',mime:'text/csv',cat:'text'},
    {ext:'.htm',mime:'text/html',cat:'text'},
    {ext:'.html',mime:'text/html',cat:'text'},
    {ext:'.ics',mime:'text/calendar',cat:'text'},
    {ext:'.md',mime:'text/markdown',cat:'text'},
    {ext:'.txt',mime:'text/plain',cat:'text'},
    {ext:'.rtf',mime:'text/rtf',cat:'text'},
    {ext:'.tsv',mime:'text/tab-separated-values',cat:'text'},
    {ext:'.vcf',mime:'text/vcard',cat:'text'},
    // Font
    {ext:'.eot',mime:'application/vnd.ms-fontobject',cat:'font'},
    {ext:'.otf',mime:'font/otf',cat:'font'},
    {ext:'.ttf',mime:'font/ttf',cat:'font'},
    {ext:'.woff',mime:'font/woff',cat:'font'},
    {ext:'.woff2',mime:'font/woff2',cat:'font'},
];

let mimeActiveCategory = 'all';

function initMimeDatabase() {
    renderMimeTable(MIME_DATABASE);
}

function searchMimeTypes() {
    const query = (document.getElementById('mime-search')?.value || '').toLowerCase().trim();
    let results = MIME_DATABASE;

    if (mimeActiveCategory !== 'all') {
        results = results.filter(r => r.cat === mimeActiveCategory);
    }
    if (query) {
        results = results.filter(r => r.ext.includes(query) || r.mime.includes(query) || r.cat.includes(query));
    }
    renderMimeTable(results);
}

function filterMimeCategory(cat, btn) {
    mimeActiveCategory = cat;
    document.querySelectorAll('.mime-cat-btn').forEach(b => {
        b.classList.toggle('active', b === btn);
        b.classList.toggle('btn-secondary', b === btn);
        b.classList.toggle('btn-ghost', b !== btn);
    });
    searchMimeTypes();
}

function renderMimeTable(results) {
    const tbody = document.getElementById('mime-table-body');
    const countEl = document.getElementById('mime-results-count');
    if (!tbody) return;

    if (countEl) countEl.textContent = `Showing ${results.length} MIME type${results.length !== 1 ? 's' : ''}`;

    if (!results.length) {
        tbody.innerHTML = '<tr><td colspan="4" style="padding:20px; text-align:center; color:var(--text-muted);">No matching MIME types found.</td></tr>';
        return;
    }

    const catColors = { application: '#3b82f6', image: '#10b981', audio: '#f59e0b', video: '#ef4444', text: '#8b5cf6', font: '#ec4899' };

    tbody.innerHTML = results.map(r => {
        const color = catColors[r.cat] || '#6b7280';
        return `<tr style="border-bottom:1px solid var(--border);">
            <td style="padding:8px 12px; font-family:var(--font-mono); font-weight:700; color:var(--text);">${escapeHtml(r.ext)}</td>
            <td style="padding:8px 12px; font-family:var(--font-mono); font-size:0.83rem; color:var(--text);">${escapeHtml(r.mime)}</td>
            <td style="padding:8px 12px;">
                <span style="padding:2px 8px; border-radius:4px; font-size:0.75rem; font-weight:700; background:${color}20; color:${color}; text-transform:uppercase; letter-spacing:0.05em;">${r.cat}</span>
            </td>
            <td style="padding:8px 12px; white-space:nowrap;">
                <button class="btn btn-ghost btn-sm" onclick="navigator.clipboard.writeText('${escapeHtml(r.mime)}'); showToast('MIME type copied!');" style="height:26px; padding:0 8px; font-size:0.75rem; margin-right:4px;">Copy MIME</button>
                <button class="btn btn-ghost btn-sm" onclick="navigator.clipboard.writeText('Content-Type: ${escapeHtml(r.mime)}'); showToast('Header copied!');" style="height:26px; padding:0 8px; font-size:0.75rem;">Copy Header</button>
            </td>
        </tr>`;
    }).join('');
}
