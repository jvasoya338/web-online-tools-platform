/**
 * WebToolsStation - Text Engine
 * Text manipulation, extractors, frequency counters, and line formatters
 */

// 28. Whitespace Cleaner & Normalizer
function runWhitespaceCleaner() {
    const input = document.getElementById("ws-clean-input")?.value || '';
    const outputEl = document.getElementById("ws-clean-output");
    if (!outputEl) return;

    // 1. Replace non-breaking spaces
    let clean = input.replace(/\u00A0/g, ' ');
    // 2. Collapse multiple spaces to single space on each line
    clean = clean.split('\n').map(line => line.replace(/[ \t]+/g, ' ').trim()).join('\n');
    // 3. Remove multiple blank lines
    clean = clean.replace(/\n{3,}/g, '\n\n');

    outputEl.value = clean.trim();
}

// 29. Shuffle Lines
function runShuffleLines() {
    const input = document.getElementById("shuffle-input")?.value || '';
    const outputEl = document.getElementById("shuffle-output");
    if (!outputEl) return;

    if (!input.trim()) {
        outputEl.value = '';
        return;
    }

    const lines = input.split('\n');
    // Fisher-Yates shuffle
    for (let i = lines.length - 1; i > 0; i--) {
        const randBytes = new Uint32Array(1);
        crypto.getRandomValues(randBytes);
        const j = randBytes[0] % (i + 1);
        [lines[i], lines[j]] = [lines[j], lines[i]];
    }

    outputEl.value = lines.join('\n');
    showToast('Lines shuffled randomly.');
}

// 30. Line Numbering Tool
function runNumberLines(action = 'add') {
    const input = document.getElementById("num-lines-input")?.value || '';
    const outputEl = document.getElementById("num-lines-output");
    const pad = document.getElementById("num-lines-pad")?.checked || false;
    const delim = document.getElementById("num-lines-delim")?.value || ". ";
    if (!outputEl) return;

    if (!input.trim()) {
        outputEl.value = '';
        return;
    }

    const lines = input.split('\n');
    if (action === 'strip') {
        const stripped = lines.map(line => line.replace(/^[\s]*\d+[\.\:\)\-\s]+/g, ''));
        outputEl.value = stripped.join('\n');
    } else {
        const totalLen = String(lines.length).length;
        const numbered = lines.map((line, idx) => {
            const numStr = pad ? String(idx + 1).padStart(totalLen, '0') : String(idx + 1);
            return `${numStr}${delim}${line}`;
        });
        outputEl.value = numbered.join('\n');
    }
}

// 31. Prefix & Suffix Lines
function runPrefixSuffixLines() {
    const input = document.getElementById("ps-input")?.value || '';
    const prefix = document.getElementById("ps-prefix")?.value || '';
    const suffix = document.getElementById("ps-suffix")?.value || '';
    const skipEmpty = document.getElementById("ps-skip-empty")?.checked || false;
    const outputEl = document.getElementById("ps-output");
    if (!outputEl) return;

    const lines = input.split('\n');
    const result = lines.map(line => {
        if (skipEmpty && !line.trim()) return line;
        return `${prefix}${line}${suffix}`;
    });

    outputEl.value = result.join('\n');
}

// 32. Text Splitter
function runTextSplitter() {
    const input = document.getElementById("split-input")?.value || '';
    const mode = document.getElementById("split-mode")?.value || 'chars';
    const size = parseInt(document.getElementById("split-size")?.value || '500', 10);
    const outputEl = document.getElementById("split-output");
    const statsEl = document.getElementById("split-stats");
    if (!outputEl) return;

    if (!input.trim()) {
        outputEl.value = '';
        if (statsEl) statsEl.textContent = '0 chunks';
        return;
    }

    let chunks = [];
    if (mode === 'chars') {
        for (let i = 0; i < input.length; i += size) {
            chunks.push(input.slice(i, i + size));
        }
    } else if (mode === 'words') {
        const words = input.split(/\s+/);
        for (let i = 0; i < words.length; i += size) {
            chunks.push(words.slice(i, i + size).join(' '));
        }
    } else {
        chunks = input.split('\n\n');
    }

    outputEl.value = chunks.map((c, idx) => `--- Chunk ${idx + 1} (${c.length} chars) ---\n${c}`).join('\n\n');
    if (statsEl) statsEl.textContent = `${chunks.length} chunk(s)`;
}

// 33. Text Joiner & Line Merger
function runTextMerger() {
    const input = document.getElementById("merge-input")?.value || '';
    const delim = document.getElementById("merge-delim")?.value || ', ';
    const wrapQuotes = document.getElementById("merge-quotes")?.checked || false;
    const outputEl = document.getElementById("merge-output");
    if (!outputEl) return;

    const lines = input.split('\n').map(l => l.trim()).filter(Boolean);
    const formatted = wrapQuotes ? lines.map(l => `'${l.replace(/'/g, "\\'")}'`) : lines;
    outputEl.value = formatted.join(delim);
}

// 34. Email Address Extractor
function runExtractEmails() {
    const input = document.getElementById("extract-email-input")?.value || '';
    const outputEl = document.getElementById("extract-email-output");
    const countEl = document.getElementById("extract-email-count");
    if (!outputEl) return;

    const regex = /[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}/g;
    const matches = input.match(regex) || [];
    const unique = Array.from(new Set(matches.map(m => m.toLowerCase()))).sort();

    outputEl.value = unique.join('\n');
    if (countEl) countEl.textContent = `${unique.length} unique email(s)`;
}

// 35. URL & Web Link Extractor
function runExtractUrls() {
    const input = document.getElementById("extract-url-input")?.value || '';
    const outputEl = document.getElementById("extract-url-output");
    const countEl = document.getElementById("extract-url-count");
    if (!outputEl) return;

    const regex = /https?:\/\/[^\s<>"'{}|\\^`\[\]]+/g;
    const matches = input.match(regex) || [];
    const unique = Array.from(new Set(matches)).sort();

    outputEl.value = unique.join('\n');
    if (countEl) countEl.textContent = `${unique.length} unique URL(s)`;
}

// 36. IP Address Extractor
function runExtractIpAddresses() {
    const input = document.getElementById("extract-ip-input")?.value || '';
    const outputEl = document.getElementById("extract-ip-output");
    const countEl = document.getElementById("extract-ip-count");
    if (!outputEl) return;

    // IPv4 & IPv6 regex
    const ipv4Regex = /\b(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\b/g;
    const ipv6Regex = /\b(?:[0-9a-fA-F]{1,4}:){7}[0-9a-fA-F]{1,4}\b/g;

    const v4 = input.match(ipv4Regex) || [];
    const v6 = input.match(ipv6Regex) || [];
    const combined = Array.from(new Set([...v4, ...v6])).sort();

    outputEl.value = combined.join('\n');
    if (countEl) countEl.textContent = `${combined.length} unique IP(s) (${v4.length} IPv4, ${v6.length} IPv6)`;
}

// 37. Number & Digit Extractor
function runExtractNumbers() {
    const input = document.getElementById("extract-num-input")?.value || '';
    const outputEl = document.getElementById("extract-num-output");
    const metricsEl = document.getElementById("extract-num-metrics");
    if (!outputEl) return;

    const regex = /-?\b\d+(?:\.\d+)?\b/g;
    const matches = (input.match(regex) || []).map(Number);

    outputEl.value = matches.join(', ');
    if (metricsEl) {
        if (matches.length > 0) {
            const sum = matches.reduce((a, b) => a + b, 0);
            const avg = (sum / matches.length).toFixed(2);
            const min = Math.min(...matches);
            const max = Math.max(...matches);
            metricsEl.innerHTML = `<strong>Count:</strong> ${matches.length} | <strong>Sum:</strong> ${sum.toLocaleString()} | <strong>Avg:</strong> ${avg} | <strong>Min:</strong> ${min} | <strong>Max:</strong> ${max}`;
        } else {
            metricsEl.textContent = '0 numbers found';
        }
    }
}

// 38. Word Frequency Counter
function runWordFrequencyCounter() {
    const input = document.getElementById("wf-input")?.value || '';
    const tableBody = document.getElementById("wf-table-body");
    const statsEl = document.getElementById("wf-stats");
    if (!tableBody) return;

    if (!input.trim()) {
        tableBody.innerHTML = '<tr><td colspan="4" style="text-align:center; padding:16px; color:var(--text-muted);">Paste text to analyze frequency.</td></tr>';
        if (statsEl) statsEl.textContent = '0 words';
        return;
    }

    const words = input.toLowerCase().match(/\b[a-z0-9'-]+\b/g) || [];
    const totalWords = words.length;
    const freq = {};

    words.forEach(w => freq[w] = (freq[w] || 0) + 1);

    const sorted = Object.keys(freq).map(w => ({ word: w, count: freq[w], pct: ((freq[w] / totalWords) * 100).toFixed(2) }))
        .sort((a, b) => b.count - a.count);

    tableBody.innerHTML = sorted.slice(0, 100).map((item, idx) => `
        <tr style="border-bottom:1px solid var(--border);">
            <td style="padding:6px 12px; font-weight:700;">#${idx + 1}</td>
            <td style="padding:6px 12px; font-family:var(--font-mono); color:var(--brand);">${item.word}</td>
            <td style="padding:6px 12px; font-weight:700;">${item.count}</td>
            <td style="padding:6px 12px; color:var(--text-muted);">${item.pct}%</td>
        </tr>
    `).join('');

    if (statsEl) statsEl.textContent = `${totalWords} total words (${sorted.length} unique)`;
}

// 39. Text Repeater
function runTextRepeater() {
    const input = document.getElementById("repeat-input")?.value || '';
    const count = Math.min(5000, Math.max(1, parseInt(document.getElementById("repeat-count")?.value || '5', 10)));
    const sep = document.getElementById("repeat-sep")?.value || '\n';
    const outputEl = document.getElementById("repeat-output");
    if (!outputEl) return;

    const list = new Array(count).fill(input);
    outputEl.value = list.join(sep === '\\n' ? '\n' : sep);
}

// 40. Tabs to Spaces Converter
function runTabsToSpaces(mode = 'tabs-to-spaces') {
    const input = document.getElementById("tab-space-input")?.value || '';
    const size = parseInt(document.getElementById("tab-space-size")?.value || '4', 10);
    const outputEl = document.getElementById("tab-space-output");
    if (!outputEl) return;

    if (mode === 'tabs-to-spaces') {
        const spaceStr = ' '.repeat(size);
        outputEl.value = input.replace(/\t/g, spaceStr);
    } else {
        const spaceRegex = new RegExp(' '.repeat(size), 'g');
        outputEl.value = input.replace(spaceRegex, '\t');
    }
}

// 41. Markdown Table Generator
function runMarkdownTableGenerator() {
    const rows = parseInt(document.getElementById("md-table-rows")?.value || '3', 10);
    const cols = parseInt(document.getElementById("md-table-cols")?.value || '3', 10);
    const outputEl = document.getElementById("md-table-output");
    if (!outputEl) return;

    let headers = [];
    let dividers = [];
    for (let c = 1; c <= cols; c++) {
        headers.push(`Header ${c}`);
        dividers.push('---');
    }

    let table = `| ${headers.join(' | ')} |\n| ${dividers.join(' | ')} |\n`;
    for (let r = 1; r <= rows; r++) {
        let rowData = [];
        for (let c = 1; c <= cols; c++) {
            rowData.push(`Data ${r}.${c}`);
        }
        table += `| ${rowData.join(' | ')} |\n`;
    }

    outputEl.value = table;
}
