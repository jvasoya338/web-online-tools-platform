/**
 * WebToolsStation - Data Engine
 * High-performance client-side data parsing, validation, and conversion
 */

// 1. JSON Tree Viewer
function renderJsonTreeViewer() {
    const input = document.getElementById("json-tree-input")?.value.trim();
    const container = document.getElementById("json-tree-container");
    const statsEl = document.getElementById("json-tree-stats");
    if (!container) return;

    if (!input) {
        container.innerHTML = '<div style="color:var(--text-muted); padding:16px; text-align:center;">Paste valid JSON above to render tree.</div>';
        if (statsEl) statsEl.textContent = '0 nodes';
        return;
    }

    try {
        const parsed = JSON.parse(input);
        let nodeCount = 0;

        function buildNode(key, value, isRoot = false) {
            nodeCount++;
            const type = value === null ? 'null' : (Array.isArray(value) ? 'array' : typeof value);
            const wrapper = document.createElement('div');
            wrapper.className = 'tree-node';
            wrapper.style.margin = '2px 0 2px 14px';
            wrapper.style.fontFamily = 'var(--font-mono)';
            wrapper.style.fontSize = '0.85rem';

            if (type === 'object' || type === 'array') {
                const isArr = type === 'array';
                const keys = isArr ? value : Object.keys(value);
                const count = isArr ? value.length : keys.length;

                const header = document.createElement('div');
                header.style.cursor = 'pointer';
                header.style.display = 'flex';
                header.style.alignItems = 'center';
                header.style.gap = '6px';
                header.style.userSelect = 'none';

                const toggle = document.createElement('span');
                toggle.textContent = '▼';
                toggle.style.fontSize = '0.7rem';
                toggle.style.color = 'var(--brand)';
                toggle.style.transition = 'transform 0.15s';

                const label = document.createElement('span');
                label.innerHTML = (key !== null ? `<strong style="color:var(--text);">${key}:</strong> ` : '') +
                    `<span style="color:var(--text-muted); font-size:0.78rem;">${isArr ? `Array[${count}]` : `Object{${count}}`}</span>`;

                header.appendChild(toggle);
                header.appendChild(label);

                const children = document.createElement('div');
                children.style.paddingLeft = '8px';
                children.style.borderLeft = '1px dashed var(--border)';

                if (isArr) {
                    value.forEach((v, idx) => children.appendChild(buildNode(`[${idx}]`, v)));
                } else {
                    Object.keys(value).forEach(k => children.appendChild(buildNode(k, value[k])));
                }

                header.addEventListener('click', () => {
                    const isHidden = children.style.display === 'none';
                    children.style.display = isHidden ? 'block' : 'none';
                    toggle.textContent = isHidden ? '▼' : '▶';
                });

                wrapper.appendChild(header);
                wrapper.appendChild(children);
            } else {
                const item = document.createElement('div');
                item.style.padding = '1px 0';
                let valHtml = '';
                if (type === 'string') valHtml = `<span style="color:#047857;">"${escapeHtmlString(value)}"</span>`;
                else if (type === 'number') valHtml = `<span style="color:#b45309;">${value}</span>`;
                else if (type === 'boolean') valHtml = `<span style="color:#6d28d9; font-weight:600;">${value}</span>`;
                else valHtml = `<span style="color:#9ca3af; font-style:italic;">null</span>`;

                item.innerHTML = (key !== null ? `<strong style="color:var(--text);">${key}:</strong> ` : '') + valHtml +
                    ` <span class="badge" style="font-size:0.68rem; padding:0 4px; background:var(--surface-subtle); color:var(--text-muted);">${type}</span>`;
                wrapper.appendChild(item);
            }
            return wrapper;
        }

        container.innerHTML = '';
        container.appendChild(buildNode(null, parsed, true));
        if (statsEl) statsEl.textContent = `${nodeCount} nodes`;
        showToast('JSON Tree rendered.');
    } catch (e) {
        container.innerHTML = `<div style="color:var(--danger); padding:16px;"><strong>JSON Syntax Error:</strong> ${e.message}</div>`;
        if (statsEl) statsEl.textContent = 'Invalid JSON';
    }
}

function escapeHtmlString(str) {
    return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
}

// 2. JSONPath Evaluator
function runJsonPathFinder() {
    const jsonStr = document.getElementById("jsonpath-input")?.value.trim();
    const query = document.getElementById("jsonpath-query")?.value.trim() || "$";
    const outputEl = document.getElementById("jsonpath-output");
    const countEl = document.getElementById("jsonpath-match-count");
    if (!outputEl) return;

    if (!jsonStr) {
        outputEl.value = 'Please provide JSON input.';
        return;
    }

    try {
        const obj = JSON.parse(jsonStr);
        const matches = simpleJsonPathQuery(obj, query);
        outputEl.value = JSON.stringify(matches, null, 2);
        if (countEl) countEl.textContent = Array.isArray(matches) ? `${matches.length} match(es)` : '1 match';
    } catch (e) {
        outputEl.value = `Error: ${e.message}`;
        if (countEl) countEl.textContent = 'Error';
    }
}

function simpleJsonPathQuery(obj, path) {
    if (!path || path === '$') return obj;
    // Normalize path tokens: $.store.book[*].author or $..price or $.store.book[0]
    const cleanPath = path.replace(/^\$\.?/, '');
    const tokens = cleanPath.split('.').filter(Boolean);

    function evaluate(curr, idx) {
        if (idx >= tokens.length) return [curr];
        const token = tokens[idx];

        // Array index or wildcard e.g. book[0] or book[*] or [*]
        const arrMatch = token.match(/^([a-zA-Z0-9_-]+)?\[(\*|[0-9]+)\]$/);
        if (arrMatch) {
            const prop = arrMatch[1];
            const arrIndex = arrMatch[2];
            const target = prop ? (curr && typeof curr === 'object' ? curr[prop] : null) : curr;
            if (!Array.isArray(target)) return [];
            if (arrIndex === '*') {
                let res = [];
                for (const item of target) {
                    res = res.concat(evaluate(item, idx + 1));
                }
                return res;
            } else {
                const i = parseInt(arrIndex, 10);
                return target[i] !== undefined ? evaluate(target[i], idx + 1) : [];
            }
        }

        if (curr && typeof curr === 'object' && token in curr) {
            return evaluate(curr[token], idx + 1);
        }
        return [];
    }

    const results = evaluate(obj, 0);
    return results.length === 1 ? results[0] : results;
}

// 3. JSON Flatten & Unflatten
function runJsonFlatten(mode = 'flatten') {
    const input = document.getElementById("json-flat-input")?.value.trim();
    const outputEl = document.getElementById("json-flat-output");
    const delimiter = document.getElementById("json-flat-delim")?.value || ".";
    if (!outputEl) return;

    if (!input) {
        outputEl.value = 'Please provide JSON input.';
        return;
    }

    try {
        const parsed = JSON.parse(input);
        let result;
        if (mode === 'flatten') {
            result = flattenObject(parsed, delimiter);
        } else {
            result = unflattenObject(parsed, delimiter);
        }
        outputEl.value = JSON.stringify(result, null, 2);
    } catch (e) {
        outputEl.value = `Error: ${e.message}`;
    }
}

function flattenObject(ob, delimiter = '.') {
    const toReturn = {};
    for (const i in ob) {
        if (!ob.hasOwnProperty(i)) continue;
        if ((typeof ob[i]) === 'object' && ob[i] !== null) {
            const flatObject = flattenObject(ob[i], delimiter);
            for (const x in flatObject) {
                if (!flatObject.hasOwnProperty(x)) continue;
                toReturn[i + delimiter + x] = flatObject[x];
            }
        } else {
            toReturn[i] = ob[i];
        }
    }
    return toReturn;
}

function unflattenObject(data, delimiter = '.') {
    if (Object(data) !== data || Array.isArray(data)) return data;
    const regex = new RegExp(`\\${delimiter}`);
    const result = {};
    for (const p in data) {
        let cur = result;
        let prop = '';
        let m;
        let idx = 0;
        let curPart = '';
        const parts = p.split(delimiter);
        for (let i = 0; i < parts.length; i++) {
            curPart = parts[i];
            if (i === parts.length - 1) {
                cur[curPart] = data[p];
            } else {
                cur[curPart] = cur[curPart] || (isNaN(Number(parts[i + 1])) ? {} : []);
                cur = cur[curPart];
            }
        }
    }
    return result;
}

// 4. JSON Key Sorter
function runJsonKeySorter(order = 'asc') {
    const input = document.getElementById("json-sort-input")?.value.trim();
    const outputEl = document.getElementById("json-sort-output");
    if (!outputEl) return;

    if (!input) {
        outputEl.value = 'Please provide JSON input.';
        return;
    }

    try {
        const parsed = JSON.parse(input);
        function sortKeys(obj) {
            if (Array.isArray(obj)) return obj.map(sortKeys);
            if (obj !== null && typeof obj === 'object') {
                const keys = Object.keys(obj).sort((a, b) => order === 'desc' ? b.localeCompare(a) : a.localeCompare(b));
                const sorted = {};
                for (const k of keys) sorted[k] = sortKeys(obj[k]);
                return sorted;
            }
            return obj;
        }
        const result = sortKeys(parsed);
        outputEl.value = JSON.stringify(result, null, 2);
    } catch (e) {
        outputEl.value = `Error: ${e.message}`;
    }
}

// 5. JSON Schema Generator
function runJsonSchemaGenerator() {
    const input = document.getElementById("schema-gen-input")?.value.trim();
    const outputEl = document.getElementById("schema-gen-output");
    if (!outputEl) return;

    if (!input) {
        outputEl.value = 'Please provide sample JSON.';
        return;
    }

    try {
        const parsed = JSON.parse(input);
        function inferSchema(val) {
            if (val === null) return { type: "null" };
            if (Array.isArray(val)) {
                return {
                    type: "array",
                    items: val.length > 0 ? inferSchema(val[0]) : {}
                };
            }
            if (typeof val === 'object') {
                const properties = {};
                const required = [];
                for (const k of Object.keys(val)) {
                    properties[k] = inferSchema(val[k]);
                    required.push(k);
                }
                return {
                    type: "object",
                    properties: properties,
                    required: required
                };
            }
            if (typeof val === 'string') {
                const res = { type: "string" };
                if (/^\d{4}-\d{2}-\d{2}T\d{2}:\d{2}:\d{2}/.test(val)) res.format = "date-time";
                else if (/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/.test(val)) res.format = "email";
                else if (/^https?:\/\//.test(val)) res.format = "uri";
                return res;
            }
            if (typeof val === 'number') return { type: Number.isInteger(val) ? "integer" : "number" };
            if (typeof val === 'boolean') return { type: "boolean" };
            return {};
        }

        const schema = {
            "$schema": "http://json-schema.org/draft-07/schema#",
            "title": "GeneratedSchema",
            "type": Array.isArray(parsed) ? "array" : "object",
            ...inferSchema(parsed)
        };

        outputEl.value = JSON.stringify(schema, null, 2);
    } catch (e) {
        outputEl.value = `Error: ${e.message}`;
    }
}

// 6. JSON Schema Validator
function runJsonSchemaValidator() {
    const jsonStr = document.getElementById("schema-val-json")?.value.trim();
    const schemaStr = document.getElementById("schema-val-schema")?.value.trim();
    const statusEl = document.getElementById("schema-val-status");
    if (!statusEl) return;

    if (!jsonStr || !schemaStr) {
        statusEl.innerHTML = '<div style="color:var(--text-muted);">Provide both JSON instance and JSON Schema.</div>';
        return;
    }

    try {
        const json = JSON.parse(jsonStr);
        const schema = JSON.parse(schemaStr);
        const errors = [];

        function validate(data, sch, path = '$') {
            if (!sch || typeof sch !== 'object') return;
            if (sch.type) {
                const actualType = data === null ? 'null' : (Array.isArray(data) ? 'array' : typeof data);
                if (sch.type === 'integer' && typeof data === 'number' && !Number.isInteger(data)) {
                    errors.push(`${path}: expected integer, got float`);
                } else if (sch.type !== 'integer' && actualType !== sch.type && !(sch.type === 'number' && typeof data === 'number')) {
                    errors.push(`${path}: expected ${sch.type}, got ${actualType}`);
                }
            }
            if (sch.required && Array.isArray(sch.required) && typeof data === 'object' && data !== null) {
                for (const req of sch.required) {
                    if (!(req in data)) errors.push(`${path}: missing required property "${req}"`);
                }
            }
            if (sch.properties && typeof data === 'object' && data !== null) {
                for (const k of Object.keys(sch.properties)) {
                    if (k in data) validate(data[k], sch.properties[k], `${path}.${k}`);
                }
            }
            if (sch.items && Array.isArray(data)) {
                data.forEach((item, i) => validate(item, sch.items, `${path}[${i}]`));
            }
        }

        validate(json, schema);

        if (errors.length === 0) {
            statusEl.innerHTML = '<div style="padding:14px; background:#ecfdf5; border:1px solid #10b981; border-radius:var(--radius-sm); color:#065f46; font-weight:700;">✓ JSON instance is 100% valid against the Schema.</div>';
        } else {
            statusEl.innerHTML = `<div style="padding:14px; background:#fef2f2; border:1px solid #ef4444; border-radius:var(--radius-sm); color:#991b1b;"><strong>Validation Failed (${errors.length} issue(s)):</strong><ul style="margin:8px 0 0 16px;">${errors.map(e => `<li>${escapeHtmlString(e)}</li>`).join('')}</ul></div>`;
        }
    } catch (e) {
        statusEl.innerHTML = `<div style="padding:14px; background:#fef2f2; border:1px solid #ef4444; border-radius:var(--radius-sm); color:#991b1b;"><strong>Parse Error:</strong> ${e.message}</div>`;
    }
}

// 7. JSONL / NDJSON Validator & Formatter
function runJsonLinesTool(action = 'validate') {
    const input = document.getElementById("jsonl-input")?.value || '';
    const outputEl = document.getElementById("jsonl-output");
    const statsEl = document.getElementById("jsonl-stats");
    if (!outputEl) return;

    if (!input.trim()) {
        outputEl.value = 'Please provide JSONL input.';
        return;
    }

    const lines = input.split('\n');
    const validLines = [];
    const errors = [];
    let validCount = 0;

    lines.forEach((line, idx) => {
        const trimmed = line.trim();
        if (!trimmed) return;
        try {
            const parsed = JSON.parse(trimmed);
            validCount++;
            if (action === 'minify') validLines.push(JSON.stringify(parsed));
            else validLines.push(JSON.stringify(parsed, null, 2));
        } catch (e) {
            errors.push(`Line ${idx + 1}: ${e.message}`);
        }
    });

    if (errors.length === 0) {
        outputEl.value = action === 'minify' ? validLines.join('\n') : validLines.join('\n\n');
        if (statsEl) statsEl.innerHTML = `<span style="color:var(--success); font-weight:700;">✓ ${validCount} valid JSON lines (0 errors)</span>`;
    } else {
        outputEl.value = `Syntax Errors Detected:\n\n` + errors.join('\n');
        if (statsEl) statsEl.innerHTML = `<span style="color:var(--danger); font-weight:700;">✗ ${errors.length} syntax error(s) found in ${lines.length} lines</span>`;
    }
}

// 8. CSV Validator & RFC 4180 Linter
function runCsvValidator() {
    const input = document.getElementById("csv-val-input")?.value || '';
    const reportEl = document.getElementById("csv-val-report");
    if (!reportEl) return;

    if (!input.trim()) {
        reportEl.innerHTML = '<div style="color:var(--text-muted);">Paste CSV data to audit RFC 4180 compliance.</div>';
        return;
    }

    const rows = input.split(/\r?\n/).filter(r => r.trim());
    if (rows.length === 0) {
        reportEl.innerHTML = '<div style="color:var(--danger);">Empty CSV dataset.</div>';
        return;
    }

    const issues = [];
    const firstCols = parseCsvLine(rows[0]).length;
    let totalCells = 0;

    rows.forEach((row, idx) => {
        const cols = parseCsvLine(row);
        totalCells += cols.length;
        if (cols.length !== firstCols) {
            issues.push(`Row ${idx + 1}: Ragged column count (${cols.length} cols vs header ${firstCols} cols)`);
        }
        // Check quotes
        const quoteCount = (row.match(/"/g) || []).length;
        if (quoteCount % 2 !== 0) {
            issues.push(`Row ${idx + 1}: Unclosed quotation mark detected`);
        }
    });

    if (issues.length === 0) {
        reportEl.innerHTML = `<div style="padding:16px; background:#ecfdf5; border:1px solid #10b981; border-radius:var(--radius-sm); color:#065f46;">
            <strong>✓ RFC 4180 Compliant:</strong> ${rows.length} rows, ${firstCols} uniform columns (${totalCells} cells total). Clean formatting.
        </div>`;
    } else {
        reportEl.innerHTML = `<div style="padding:16px; background:#fef2f2; border:1px solid #ef4444; border-radius:var(--radius-sm); color:#991b1b;">
            <strong>CSV Compliance Errors (${issues.length} issue(s)):</strong>
            <ul style="margin:8px 0 0 16px;">${issues.map(i => `<li>${escapeHtmlString(i)}</li>`).join('')}</ul>
        </div>`;
    }
}

function parseCsvLine(line, delimiter = ',') {
    const result = [];
    let cur = '';
    let inQuotes = false;
    for (let i = 0; i < line.length; i++) {
        const c = line[i];
        if (c === '"') {
            inQuotes = !inQuotes;
        } else if (c === delimiter && !inQuotes) {
            result.push(cur.trim());
            cur = '';
        } else {
            cur += c;
        }
    }
    result.push(cur.trim());
    return result;
}

// 9. CSV Column Extractor
function runCsvColumnExtractor() {
    const input = document.getElementById("csv-extract-input")?.value || '';
    const colIndices = document.getElementById("csv-extract-cols")?.value.trim() || "1";
    const outputEl = document.getElementById("csv-extract-output");
    if (!outputEl) return;

    if (!input.trim()) {
        outputEl.value = 'Please provide CSV input.';
        return;
    }

    const rows = input.split(/\r?\n/).filter(r => r.trim());
    const indices = colIndices.split(',').map(s => parseInt(s.trim(), 10) - 1).filter(n => !isNaN(n));
    const extractedRows = [];

    rows.forEach(r => {
        const cols = parseCsvLine(r);
        const selected = indices.map(idx => cols[idx] !== undefined ? cols[idx] : '');
        extractedRows.push(selected.join(','));
    });

    outputEl.value = extractedRows.join('\n');
}

// 10. CSV to SQL Insert Converter
function runCsvToSqlConverter() {
    const input = document.getElementById("csv-sql-input")?.value || '';
    const tableName = document.getElementById("csv-sql-table")?.value.trim() || "my_table";
    const outputEl = document.getElementById("csv-sql-output");
    if (!outputEl) return;

    if (!input.trim()) {
        outputEl.value = 'Please provide CSV input.';
        return;
    }

    const rows = input.split(/\r?\n/).filter(r => r.trim());
    if (rows.length < 2) {
        outputEl.value = 'CSV requires at least 1 header row and 1 data row.';
        return;
    }

    const headers = parseCsvLine(rows[0]).map(h => h.replace(/[^a-zA-Z0-9_]/g, '_').toLowerCase() || 'col');
    const createTable = `CREATE TABLE \`${tableName}\` (\n  id INT AUTO_INCREMENT PRIMARY KEY,\n` +
        headers.map(h => `  \`${h}\` VARCHAR(255)`).join(',\n') + `\n);\n\n`;

    const inserts = [];
    for (let i = 1; i < rows.length; i++) {
        const cols = parseCsvLine(rows[i]);
        const values = cols.map(v => `'${v.replace(/'/g, "''")}'`);
        inserts.push(`INSERT INTO \`${tableName}\` (\`${headers.join('`, `')}\`) VALUES (${values.join(', ')});`);
    }

    outputEl.value = createTable + inserts.join('\n');
}

// 11. TOML Formatter & Validator
function runTomlFormatterValidator() {
    const input = document.getElementById("toml-input")?.value || '';
    const outputEl = document.getElementById("toml-output");
    const statusEl = document.getElementById("toml-status");
    if (!outputEl) return;

    if (!input.trim()) {
        outputEl.value = 'Please provide TOML input.';
        return;
    }

    try {
        const lines = input.split(/\r?\n/);
        const formatted = [];
        let sectionCount = 0;
        let kvCount = 0;

        lines.forEach(line => {
            const trimmed = line.trim();
            if (!trimmed || trimmed.startsWith('#')) {
                formatted.push(trimmed);
                return;
            }
            if (/^\[.+\]$/.test(trimmed)) {
                sectionCount++;
                formatted.push('\n' + trimmed);
            } else if (trimmed.includes('=')) {
                kvCount++;
                const [key, ...valParts] = trimmed.split('=');
                formatted.push(`${key.trim()} = ${valParts.join('=').trim()}`);
            } else {
                formatted.push(trimmed);
            }
        });

        outputEl.value = formatted.join('\n').trim();
        if (statusEl) statusEl.innerHTML = `<span style="color:var(--success); font-weight:700;">✓ Valid TOML structure (${sectionCount} sections, ${kvCount} keys)</span>`;
    } catch (e) {
        outputEl.value = `TOML Error: ${e.message}`;
        if (statusEl) statusEl.innerHTML = `<span style="color:var(--danger); font-weight:700;">✗ ${e.message}</span>`;
    }
}

// 12. TOML to JSON Converter
function runTomlToJsonConverter() {
    const input = document.getElementById("toml-json-input")?.value || '';
    const outputEl = document.getElementById("toml-json-output");
    if (!outputEl) return;

    if (!input.trim()) {
        outputEl.value = 'Please provide TOML input.';
        return;
    }

    try {
        const lines = input.split(/\r?\n/);
        const result = {};
        let curSection = result;

        lines.forEach(line => {
            const trimmed = line.trim();
            if (!trimmed || trimmed.startsWith('#')) return;
            const secMatch = trimmed.match(/^\[([a-zA-Z0-9_.]+)\]$/);
            if (secMatch) {
                const secName = secMatch[1];
                result[secName] = result[secName] || {};
                curSection = result[secName];
            } else if (trimmed.includes('=')) {
                const [k, ...vParts] = trimmed.split('=');
                const key = k.trim();
                let rawVal = vParts.join('=').trim();
                let val = rawVal;
                if (rawVal === 'true') val = true;
                else if (rawVal === 'false') val = false;
                else if (/^-?\d+$/.test(rawVal)) val = parseInt(rawVal, 10);
                else if (/^-?\d+\.\d+$/.test(rawVal)) val = parseFloat(rawVal);
                else if (rawVal.startsWith('"') && rawVal.endsWith('"')) val = rawVal.slice(1, -1);
                curSection[key] = val;
            }
        });

        outputEl.value = JSON.stringify(result, null, 2);
    } catch (e) {
        outputEl.value = `Conversion Error: ${e.message}`;
    }
}
