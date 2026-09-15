/**
 * WebToolsStation - Dedicated Text Tools Suite Runtime
 * Pure Client-Side JavaScript Engine. Zero Server Uploads. Zero Telemetry.
 */

// =============================================================
// SHARED UTILITIES
// =============================================================
function downloadTextTool(elementId, filename) {
    const el = document.getElementById(elementId);
    if (!el || !el.value.trim()) {
        if (typeof showToast === 'function') showToast('Nothing to download yet.', true);
        return;
    }
    const blob = new Blob([el.value], { type: 'text/plain;charset=utf-8' });
    const a = document.createElement('a');
    a.href = URL.createObjectURL(blob);
    a.download = filename || 'output.txt';
    a.click();
    URL.revokeObjectURL(a.href);
}

// =============================================================
// 1. REMOVE DUPLICATE LINES
// =============================================================
function runDeduplicateLines() {
    const inputEl = document.getElementById('dedup-input');
    const outputEl = document.getElementById('dedup-output');
    const inStats = document.getElementById('dedup-in-stats');
    const outStats = document.getElementById('dedup-out-stats');
    if (!inputEl || !outputEl) return;

    const raw = inputEl.value;
    if (!raw.length) {
        outputEl.value = '';
        if (inStats) inStats.textContent = '0 lines';
        if (outStats) outStats.textContent = '0 unique lines | 0 duplicates removed';
        return;
    }

    const isCaseSensitive = document.getElementById('dedup-case-sensitive')?.checked ?? false;
    const isTrim = document.getElementById('dedup-trim-whitespace')?.checked ?? true;
    const isPreserveOrder = document.getElementById('dedup-preserve-order')?.checked ?? true;

    const lines = raw.split(/\r?\n/);
    const seen = new Set();
    const uniqueLines = [];

    for (let i = 0; i < lines.length; i++) {
        let line = lines[i];
        let lookupKey = isTrim ? line.trim() : line;
        if (!isCaseSensitive) {
            lookupKey = lookupKey.toLowerCase();
        }

        if (!seen.has(lookupKey)) {
            seen.add(lookupKey);
            uniqueLines.push(isTrim ? line.trim() : line);
        }
    }

    const removedCount = lines.length - uniqueLines.length;
    outputEl.value = uniqueLines.join('\n');

    if (inStats) inStats.textContent = `${lines.length.toLocaleString()} line${lines.length !== 1 ? 's' : ''}`;
    if (outStats) outStats.textContent = `${uniqueLines.length.toLocaleString()} unique line${uniqueLines.length !== 1 ? 's' : ''} | ${removedCount.toLocaleString()} duplicate${removedCount !== 1 ? 's' : ''} removed`;
}

function clearDeduplicateLines() {
    const el = document.getElementById('dedup-input');
    const out = document.getElementById('dedup-output');
    if (el) el.value = '';
    if (out) out.value = '';
    runDeduplicateLines();
}

function loadDeduplicateLinesSample() {
    const el = document.getElementById('dedup-input');
    if (el) {
        el.value = "apple\nbanana\napple\norange\nBanana\napple\ngrapes\norange\nwatermelon";
        runDeduplicateLines();
    }
}

async function pasteDeduplicateLinesClipboard() {
    try {
        const text = await navigator.clipboard.readText();
        const el = document.getElementById('dedup-input');
        if (el) { el.value = text; runDeduplicateLines(); }
    } catch(e) { if (typeof showToast === 'function') showToast('Clipboard read failed — paste manually.', true); }
}

// =============================================================
// 2. REMOVE EMPTY LINES
// =============================================================
function runRemoveEmptyLines() {
    const inputEl = document.getElementById('empty-input');
    const outputEl = document.getElementById('empty-output');
    const inStats = document.getElementById('empty-in-stats');
    const outStats = document.getElementById('empty-out-stats');
    if (!inputEl || !outputEl) return;

    const raw = inputEl.value;
    if (!raw.length) {
        outputEl.value = '';
        if (inStats) inStats.textContent = '0 lines';
        if (outStats) outStats.textContent = '0 lines | 0 empty lines removed';
        return;
    }

    const mode = document.querySelector('input[name="empty-lines-mode"]:checked')?.value || 'all';
    const isTrim = document.getElementById('empty-trim-whitespace')?.checked ?? true;

    const lines = raw.split(/\r?\n/);
    const result = [];
    let removedCount = 0;
    let lastWasEmpty = false;

    for (let i = 0; i < lines.length; i++) {
        const line = lines[i];
        const isEmpty = isTrim ? line.trim() === '' : line === '';

        if (mode === 'all') {
            if (isEmpty) {
                removedCount++;
            } else {
                result.push(line);
            }
        } else if (mode === 'collapse') {
            if (isEmpty) {
                if (!lastWasEmpty) {
                    result.push('');
                    lastWasEmpty = true;
                } else {
                    removedCount++;
                }
            } else {
                result.push(line);
                lastWasEmpty = false;
            }
        }
    }

    outputEl.value = result.join('\n');

    if (inStats) inStats.textContent = `${lines.length.toLocaleString()} line${lines.length !== 1 ? 's' : ''}`;
    if (outStats) outStats.textContent = `${result.length.toLocaleString()} line${result.length !== 1 ? 's' : ''} | ${removedCount.toLocaleString()} empty line${removedCount !== 1 ? 's' : ''} removed`;
}

function clearRemoveEmptyLines() {
    const el = document.getElementById('empty-input');
    const out = document.getElementById('empty-output');
    if (el) el.value = '';
    if (out) out.value = '';
    runRemoveEmptyLines();
}

function loadRemoveEmptyLinesSample() {
    const el = document.getElementById('empty-input');
    if (el) {
        el.value = "WebToolsStation Text Tools\n\n\nFast and private browser utilities.\n   \n\n\nClean documents effortlessly.\n\nAll tools run 100% client-side.";
        runRemoveEmptyLines();
    }
}

async function pasteRemoveEmptyLinesClipboard() {
    try {
        const text = await navigator.clipboard.readText();
        const el = document.getElementById('empty-input');
        if (el) { el.value = text; runRemoveEmptyLines(); }
    } catch(e) { if (typeof showToast === 'function') showToast('Clipboard read failed — paste manually.', true); }
}

// =============================================================
// 3. FIND AND REPLACE
// =============================================================
function runFindAndReplace() {
    const inputEl = document.getElementById('find-input');
    const outputEl = document.getElementById('find-output');
    const findQuery = document.getElementById('find-query')?.value || '';
    const replaceQuery = document.getElementById('replace-query')?.value || '';
    const isCase = document.getElementById('find-case-sensitive')?.checked ?? false;
    const isWholeWord = document.getElementById('find-whole-word')?.checked ?? false;
    const isRegex = document.getElementById('find-use-regex')?.checked ?? false;
    const countBadge = document.getElementById('find-count-badge');
    const errorBox = document.getElementById('find-regex-error');
    const errorMsg = document.getElementById('find-regex-error-msg');

    if (!inputEl || !outputEl) return;
    if (errorBox) errorBox.style.display = 'none';

    const text = inputEl.value;
    if (!text || !findQuery) {
        outputEl.value = text;
        if (countBadge) countBadge.textContent = '0 replacements';
        return;
    }

    try {
        let regex;
        let flags = isCase ? 'g' : 'gi';

        if (isRegex) {
            regex = new RegExp(findQuery, flags);
        } else {
            // Escape literal string for regex
            const escaped = findQuery.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
            const pattern = isWholeWord ? `\\b${escaped}\\b` : escaped;
            regex = new RegExp(pattern, flags);
        }

        let count = 0;
        const replaced = text.replace(regex, (match, ...args) => {
            count++;
            if (isRegex && replaceQuery.includes('$')) {
                // Support capture groups $1, $2 etc.
                let result = replaceQuery;
                for (let i = 1; i <= 9; i++) {
                    if (args[i - 1] !== undefined) {
                        result = result.replace(new RegExp(`\\$${i}`, 'g'), args[i - 1]);
                    }
                }
                return result.replace(/\$&/g, match);
            }
            return replaceQuery;
        });

        outputEl.value = replaced;
        if (countBadge) {
            countBadge.textContent = `${count.toLocaleString()} replacement${count !== 1 ? 's' : ''}`;
        }
    } catch (err) {
        if (errorBox && errorMsg) {
            errorMsg.textContent = err.message;
            errorBox.style.display = 'block';
        }
        outputEl.value = text;
    }
}

function clearFindAndReplace() {
    const el = document.getElementById('find-input');
    const out = document.getElementById('find-output');
    const f = document.getElementById('find-query');
    const r = document.getElementById('replace-query');
    if (el) el.value = '';
    if (out) out.value = '';
    if (f) f.value = '';
    if (r) r.value = '';
    const err = document.getElementById('find-regex-error');
    if (err) err.style.display = 'none';
    const countBadge = document.getElementById('find-count-badge');
    if (countBadge) countBadge.textContent = '0 replacements';
}

function loadFindAndReplaceSample() {
    const el = document.getElementById('find-input');
    const f = document.getElementById('find-query');
    const r = document.getElementById('replace-query');
    if (el && f && r) {
        el.value = "DATABASE_HOST=staging-db.internal\nCACHE_HOST=staging-cache.internal\nLOG_PREFIX=staging_app\nAPP_ENV=staging";
        f.value = "staging";
        r.value = "production";
        runFindAndReplace();
    }
}

async function pasteFindAndReplaceClipboard() {
    try {
        const text = await navigator.clipboard.readText();
        const el = document.getElementById('find-input');
        if (el) { el.value = text; runFindAndReplace(); }
    } catch(e) { if (typeof showToast === 'function') showToast('Clipboard read failed — paste manually.', true); }
}

// =============================================================
// 4. REVERSE TEXT
// =============================================================
let activeReverseMode = 'chars';

function setReverseMode(mode, btn) {
    activeReverseMode = mode;
    document.querySelectorAll('.reverse-mode-btn').forEach(b => {
        b.classList.toggle('btn-secondary', b === btn);
        b.classList.toggle('active', b === btn);
        b.classList.toggle('btn-ghost', b !== btn);
    });
    runReverseText();
}

function reverseGraphemeString(str) {
    if (typeof Intl !== 'undefined' && Intl.Segmenter) {
        try {
            const segmenter = new Intl.Segmenter(undefined, { granularity: 'grapheme' });
            const segments = Array.from(segmenter.segment(str), s => s.segment);
            return segments.reverse().join('');
        } catch (e) {
            // fallback if Intl.Segmenter fails
        }
    }
    return Array.from(str).reverse().join('');
}

function runReverseText() {
    const inputEl = document.getElementById('reverse-input');
    const outputEl = document.getElementById('reverse-output');
    if (!inputEl || !outputEl) return;

    const text = inputEl.value;
    if (!text) {
        outputEl.value = '';
        return;
    }

    let result = '';

    if (activeReverseMode === 'chars') {
        // Grapheme-aware character reversal (preserves complex emojis, flags, and Indian script clusters)
        result = reverseGraphemeString(text);
    } else if (activeReverseMode === 'words') {
        // Word sequence inversion across lines
        const lines = text.split(/\r?\n/);
        result = lines.map(line => {
            const words = line.split(/(\s+)/);
            return words.reverse().join('');
        }).join('\n');
    } else if (activeReverseMode === 'lines') {
        // Invert line order
        result = text.split(/\r?\n/).reverse().join('\n');
    } else if (activeReverseMode === 'line-chars') {
        // Reverse characters per line using grapheme segments
        const lines = text.split(/\r?\n/);
        result = lines.map(line => reverseGraphemeString(line)).join('\n');
    }

    outputEl.value = result;
}

function clearReverseText() {
    const el = document.getElementById('reverse-input');
    const out = document.getElementById('reverse-output');
    if (el) el.value = '';
    if (out) out.value = '';
}

function loadReverseTextSample() {
    const el = document.getElementById('reverse-input');
    if (el) {
        el.value = "1. First Step: Download resources\n2. Second Step: Extract files\n3. Third Step: Run installation\n4. Final Step: Verification complete";
        runReverseText();
    }
}

async function pasteReverseTextClipboard() {
    try {
        const text = await navigator.clipboard.readText();
        const el = document.getElementById('reverse-input');
        if (el) { el.value = text; runReverseText(); }
    } catch(e) { if (typeof showToast === 'function') showToast('Clipboard read failed — paste manually.', true); }
}

// =============================================================
// 5. MARKDOWN TO HTML
// =============================================================
let activeMarkdownView = 'html';

function switchMarkdownView(view, btn) {
    activeMarkdownView = view;
    document.querySelectorAll('.md-tab-btn').forEach(b => {
        b.classList.toggle('btn-secondary', b === btn);
        b.classList.toggle('active', b === btn);
        b.classList.toggle('btn-ghost', b !== btn);
    });

    const outText = document.getElementById('md-output');
    const preview = document.getElementById('md-preview');
    const title = document.getElementById('md-output-title');

    if (view === 'preview') {
        if (outText) outText.style.display = 'none';
        if (preview) {
            preview.style.display = 'block';
            preview.innerHTML = sanitizeHtmlForPreview(outText ? outText.value : '');
        }
        if (title) title.textContent = 'Rendered Visual Preview';
    } else {
        if (preview) preview.style.display = 'none';
        if (outText) outText.style.display = 'block';
        if (title) title.textContent = 'HTML Output';
    }
}

function runMarkdownToHtml() {
    const inputEl = document.getElementById('md-input');
    const outputEl = document.getElementById('md-output');
    const previewEl = document.getElementById('md-preview');
    const inStats = document.getElementById('md-in-stats');
    const outStats = document.getElementById('md-out-stats');
    if (!inputEl || !outputEl) return;

    const md = inputEl.value;
    if (!md.trim()) {
        outputEl.value = '';
        if (previewEl) previewEl.innerHTML = '';
        if (inStats) inStats.textContent = '0 characters';
        if (outStats) outStats.textContent = '0 characters';
        return;
    }

    const isGfm = document.getElementById('md-gfm')?.checked ?? true;
    const isBreaks = document.getElementById('md-breaks')?.checked ?? false;

    const html = convertMarkdownToHtml(md, { gfm: isGfm, breaks: isBreaks });
    outputEl.value = html;
    if (previewEl && activeMarkdownView === 'preview') {
        previewEl.innerHTML = sanitizeHtmlForPreview(html);
    }

    if (inStats) inStats.textContent = `${md.length.toLocaleString()} characters | ${md.split('\n').length} lines`;
    if (outStats) outStats.textContent = `${html.length.toLocaleString()} characters`;
}

function sanitizeHtmlForPreview(html) {
    if (typeof DOMParser === 'undefined') return html;
    try {
        const parser = new DOMParser();
        const doc = parser.parseFromString(html, 'text/html');
        
        // Remove dangerous executable or embedding tags
        const dangerousTags = ['script', 'iframe', 'object', 'embed', 'style', 'link', 'meta', 'applet', 'form'];
        dangerousTags.forEach(tag => {
            const elements = doc.querySelectorAll(tag);
            elements.forEach(el => el.remove());
        });
        
        // Strip event handlers (onclick, onerror, etc.) and dangerous protocols
        const allElements = doc.querySelectorAll('*');
        allElements.forEach(el => {
            Array.from(el.attributes).forEach(attr => {
                if (attr.name.toLowerCase().startsWith('on')) {
                    el.removeAttribute(attr.name);
                }
            });
            if (el.hasAttribute('href')) {
                const href = el.getAttribute('href') || '';
                if (/^(?:javascript|vbscript|data):/i.test(href.trim())) {
                    el.setAttribute('href', '#');
                }
            }
            if (el.hasAttribute('src')) {
                const src = el.getAttribute('src') || '';
                if (/^(?:javascript|vbscript):/i.test(src.trim())) {
                    el.removeAttribute('src');
                }
            }
        });
        
        return doc.body.innerHTML;
    } catch (e) {
        return escapeHtmlForMarkdown(html);
    }
}

function convertMarkdownToHtml(md, options = {}) {
    const { gfm = true, breaks = false } = options;
    const lines = md.split(/\r?\n/);
    const htmlLines = [];

    let inCodeBlock = false;
    let codeLanguage = '';
    let codeBlockContent = [];
    let inList = null; // 'ul' or 'ol'
    let inTable = false;
    let inBlockquote = false;

    for (let i = 0; i < lines.length; i++) {
        let line = lines[i];

        // 1. Fenced Code Blocks (```)
        const codeFenceMatch = line.match(/^```(\w*)/);
        if (codeFenceMatch) {
            if (inCodeBlock) {
                // Close code block
                const rawCode = codeBlockContent.join('\n');
                const safeCode = escapeHtmlForMarkdown(rawCode);
                const classAttr = codeLanguage ? ` class="language-${codeLanguage}"` : '';
                htmlLines.push(`<pre><code${classAttr}>${safeCode}</code></pre>`);
                inCodeBlock = false;
                codeBlockContent = [];
                codeLanguage = '';
            } else {
                // Close any open lists
                if (inList) { htmlLines.push(`</${inList}>`); inList = null; }
                inCodeBlock = true;
                codeLanguage = codeFenceMatch[1] || '';
                codeBlockContent = [];
            }
            continue;
        }

        if (inCodeBlock) {
            codeBlockContent.push(line);
            continue;
        }

        // Close lists or tables if blank line
        if (line.trim() === '') {
            if (inList) { htmlLines.push(`</${inList}>`); inList = null; }
            if (inTable) { htmlLines.push('</tbody></table>'); inTable = false; }
            if (inBlockquote) { htmlLines.push('</blockquote>'); inBlockquote = false; }
            continue;
        }

        // 2. GFM Tables (| Col 1 | Col 2 |)
        if (gfm && line.trim().startsWith('|') && line.trim().endsWith('|')) {
            const cells = line.trim().slice(1, -1).split('|').map(c => c.trim());
            // Check if next line is separator |---|---|
            const nextLine = lines[i + 1] || '';
            const isHeader = !inTable && nextLine.trim().startsWith('|') && nextLine.includes('---');

            if (isHeader) {
                if (inList) { htmlLines.push(`</${inList}>`); inList = null; }
                htmlLines.push('<table style="width:100%; border-collapse:collapse; margin:16px 0;"><thead><tr style="border-bottom:2px solid var(--border); background:var(--surface-subtle); text-align:left;">');
                cells.forEach(c => htmlLines.push(`<th style="padding:8px 12px; border:1px solid var(--border);">${parseInlineMarkdown(c)}</th>`));
                htmlLines.push('</tr></thead><tbody>');
                inTable = true;
                i++; // skip separator line
                continue;
            } else if (inTable) {
                htmlLines.push('<tr style="border-bottom:1px solid var(--border);">');
                cells.forEach(c => htmlLines.push(`<td style="padding:8px 12px; border:1px solid var(--border);">${parseInlineMarkdown(c)}</td>`));
                htmlLines.push('</tr>');
                continue;
            }
        } else if (inTable) {
            htmlLines.push('</tbody></table>');
            inTable = false;
        }

        // 3. Headings (# H1 - ###### H6)
        const headingMatch = line.match(/^(#{1,6})\s+(.*)$/);
        if (headingMatch) {
            if (inList) { htmlLines.push(`</${inList}>`); inList = null; }
            const level = headingMatch[1].length;
            const text = parseInlineMarkdown(headingMatch[2]);
            htmlLines.push(`<h${level}>${text}</h${level}>`);
            continue;
        }

        // 4. Horizontal Rule (---, ***, ___)
        if (/^(\*{3,}|-{3,}|_{3,})$/.test(line.trim())) {
            if (inList) { htmlLines.push(`</${inList}>`); inList = null; }
            htmlLines.push('<hr>');
            continue;
        }

        // 5. Blockquotes (> quote)
        if (line.startsWith('>')) {
            if (inList) { htmlLines.push(`</${inList}>`); inList = null; }
            const quoteContent = parseInlineMarkdown(line.replace(/^>\s?/, ''));
            if (!inBlockquote) {
                htmlLines.push('<blockquote>');
                inBlockquote = true;
            }
            htmlLines.push(`<p>${quoteContent}</p>`);
            continue;
        } else if (inBlockquote) {
            htmlLines.push('</blockquote>');
            inBlockquote = false;
        }

        // 6. Task Lists & Unordered Lists (- [ ], * item, - item)
        const taskMatch = gfm ? line.match(/^[-*]\s+\[([ xX])\]\s+(.*)$/) : null;
        const ulMatch = line.match(/^[-*+]\s+(.*)$/);
        const olMatch = line.match(/^(\d+)\.\s+(.*)$/);

        if (taskMatch) {
            if (inList !== 'ul') {
                if (inList) htmlLines.push(`</${inList}>`);
                htmlLines.push('<ul style="list-style:none; padding-left:0;">');
                inList = 'ul';
            }
            const checked = taskMatch[1].toLowerCase() === 'x' ? ' checked disabled' : ' disabled';
            htmlLines.push(`<li><input type="checkbox"${checked}> ${parseInlineMarkdown(taskMatch[2])}</li>`);
            continue;
        } else if (ulMatch) {
            if (inList !== 'ul') {
                if (inList) htmlLines.push(`</${inList}>`);
                htmlLines.push('<ul>');
                inList = 'ul';
            }
            htmlLines.push(`<li>${parseInlineMarkdown(ulMatch[1])}</li>`);
            continue;
        } else if (olMatch) {
            if (inList !== 'ol') {
                if (inList) htmlLines.push(`</${inList}>`);
                htmlLines.push('<ol>');
                inList = 'ol';
            }
            htmlLines.push(`<li>${parseInlineMarkdown(olMatch[2])}</li>`);
            continue;
        } else if (inList) {
            htmlLines.push(`</${inList}>`);
            inList = null;
        }

        // 7. Regular Paragraphs
        const parsedParagraph = parseInlineMarkdown(line);
        if (breaks && i < lines.length - 1 && lines[i + 1].trim() !== '') {
            htmlLines.push(`<p>${parsedParagraph}<br></p>`);
        } else {
            htmlLines.push(`<p>${parsedParagraph}</p>`);
        }
    }

    if (inCodeBlock) {
        htmlLines.push(`<pre><code>${escapeHtmlForMarkdown(codeBlockContent.join('\n'))}</code></pre>`);
    }
    if (inList) htmlLines.push(`</${inList}>`);
    if (inTable) htmlLines.push('</tbody></table>');
    if (inBlockquote) htmlLines.push('</blockquote>');

    return htmlLines.join('\n');
}

function parseInlineMarkdown(str) {
    let s = str;
    // 1. Inline code (`code`)
    s = s.replace(/`([^`]+)`/g, (m, code) => `<code>${escapeHtmlForMarkdown(code)}</code>`);
    // 2. Images (![alt](url))
    s = s.replace(/!\[([^\]]*)\]\(([^)]+)\)/g, (m, alt, url) => {
        const cleanUrl = url.trim();
        if (/^(?:javascript|vbscript):/i.test(cleanUrl)) return '';
        return `<img src="${escapeHtmlForMarkdown(cleanUrl)}" alt="${escapeHtmlForMarkdown(alt)}">`;
    });
    // 3. Links ([text](url))
    s = s.replace(/\[([^\]]+)\]\(([^)]+)\)/g, (m, text, url) => {
        const cleanUrl = url.trim();
        const safeHref = /^(?:javascript|vbscript|data):/i.test(cleanUrl) ? '#' : escapeHtmlForMarkdown(cleanUrl);
        return `<a href="${safeHref}" target="_blank" rel="noopener noreferrer">${parseInlineMarkdown(text)}</a>`;
    });
    // 4. Bold + Italic (***text*** or ___text___)
    s = s.replace(/(\*\*\*|___)(.*?)\1/g, '<strong><em>$2</em></strong>');
    // 5. Bold (**text** or __text__)
    s = s.replace(/(\*\*|__)(.*?)\1/g, '<strong>$2</strong>');
    // 6. Italic (*text* or _text_)
    s = s.replace(/(\*|_)(.*?)\1/g, '<em>$2</em>');
    // 7. GFM Strikethrough (~~text~~)
    s = s.replace(/~~(.*?)~~/g, '<del>$1</del>');
    return s;
}

function escapeHtmlForMarkdown(text) {
    return String(text)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;');
}

function clearMarkdownToHtml() {
    const el = document.getElementById('md-input');
    const out = document.getElementById('md-output');
    const p = document.getElementById('md-preview');
    if (el) el.value = '';
    if (out) out.value = '';
    if (p) p.innerHTML = '';
    runMarkdownToHtml();
}

function loadMarkdownSample() {
    const el = document.getElementById('md-input');
    if (el) {
        el.value = `# WebToolsStation Documentation

WebToolsStation is a **fast, secure, browser-based** utilities platform.

## Key Features

- [x] 100% Client-side processing
- [x] Zero server payload storage
- [ ] Offline PWA support (coming soon)

### Supported Data Formats

| Format | Extension | Parser Support |
|---|---|---|
| JSON | .json | Native RFC 8259 |
| YAML | .yaml | CommonMark & Blocks |
| Markdown | .md | GFM & HTML5 |

> Privacy Note: All document conversions execute locally within your browser sandbox.

Visit [WebToolsStation](https://webtoolsstation.com) for more tools.`;
        runMarkdownToHtml();
    }
}

async function pasteMarkdownClipboard() {
    try {
        const text = await navigator.clipboard.readText();
        const el = document.getElementById('md-input');
        if (el) { el.value = text; runMarkdownToHtml(); }
    } catch(e) { if (typeof showToast === 'function') showToast('Clipboard read failed — paste manually.', true); }
}

// =============================================================
// BATCH 2B TEXT & DATA TOOLS
// =============================================================

// =============================================================
// 6. HTML TO MARKDOWN
// =============================================================
function runHtmlToMarkdown() {
    const inputEl = document.getElementById('html-to-md-input');
    const outputEl = document.getElementById('html-to-md-output');
    const inStats = document.getElementById('html-to-md-in-stats');
    const outStats = document.getElementById('html-to-md-out-stats');
    if (!inputEl || !outputEl) return;

    const html = inputEl.value;
    if (!html.trim()) {
        outputEl.value = '';
        if (inStats) inStats.textContent = '0 characters';
        if (outStats) outStats.textContent = '0 characters';
        return;
    }

    try {
        const parser = new DOMParser();
        const doc = parser.parseFromString(html, 'text/html');
        const md = domNodeToMarkdown(doc.body).trim();
        outputEl.value = md;

        if (inStats) inStats.textContent = `${html.length.toLocaleString()} characters`;
        if (outStats) outStats.textContent = `${md.length.toLocaleString()} characters | ${md.split('\n').length} lines`;
    } catch (err) {
        outputEl.value = 'Conversion error: ' + err.message;
    }
}

function domNodeToMarkdown(node) {
    if (!node) return '';
    if (node.nodeType === 3) { // Text Node
        return node.textContent.replace(/\s+/g, ' ');
    }
    if (node.nodeType !== 1) return ''; // Only element nodes

    const tag = node.tagName.toLowerCase();
    const children = Array.from(node.childNodes).map(domNodeToMarkdown).join('');

    switch (tag) {
        case 'h1': return `\n\n# ${children.trim()}\n\n`;
        case 'h2': return `\n\n## ${children.trim()}\n\n`;
        case 'h3': return `\n\n### ${children.trim()}\n\n`;
        case 'h4': return `\n\n#### ${children.trim()}\n\n`;
        case 'h5': return `\n\n##### ${children.trim()}\n\n`;
        case 'h6': return `\n\n###### ${children.trim()}\n\n`;
        case 'p': return `\n\n${children.trim()}\n\n`;
        case 'strong':
        case 'b': return `**${children.trim()}**`;
        case 'em':
        case 'i': return `*${children.trim()}*`;
        case 'del':
        case 's':
        case 'strike': return `~~${children.trim()}~~`;
        case 'code':
            if (node.parentNode && node.parentNode.tagName.toLowerCase() === 'pre') {
                return children;
            }
            return `\`${children.trim()}\``;
        case 'pre':
            const codeEl = node.querySelector('code');
            const lang = codeEl ? (codeEl.className.match(/language-(\w+)/) || [])[1] || '' : '';
            const codeContent = codeEl ? codeEl.textContent : node.textContent;
            return `\n\n\`\`\`${lang}\n${codeContent.trim()}\n\`\`\`\n\n`;
        case 'blockquote': return `\n\n> ${children.trim().replace(/\n/g, '\n> ')}\n\n`;
        case 'ul': return `\n\n${Array.from(node.children).map(li => `- ${domNodeToMarkdown(li).trim()}`).join('\n')}\n\n`;
        case 'ol': return `\n\n${Array.from(node.children).map((li, idx) => `${idx + 1}. ${domNodeToMarkdown(li).trim()}`).join('\n')}\n\n`;
        case 'li': return children.trim();
        case 'hr': return '\n\n---\n\n';
        case 'br': return '  \n';
        case 'a':
            const href = node.getAttribute('href') || '#';
            return `[${children.trim()}](${href})`;
        case 'img':
            const src = node.getAttribute('src') || '';
            const alt = node.getAttribute('alt') || '';
            return `![${alt}](${src})`;
        case 'table':
            return convertHtmlTableToMarkdown(node);
        default:
            return children;
    }
}

function convertHtmlTableToMarkdown(tableEl) {
    const rows = Array.from(tableEl.querySelectorAll('tr'));
    if (!rows.length) return '';

    const matrix = rows.map(r => Array.from(r.querySelectorAll('th, td')).map(c => domNodeToMarkdown(c).trim().replace(/\|/g, '\\|')));
    if (!matrix.length) return '';

    const header = matrix[0];
    const dataRows = matrix.slice(1);
    let md = '\n\n| ' + header.join(' | ') + ' |\n';
    md += '| ' + header.map(() => '---').join(' | ') + ' |\n';
    dataRows.forEach(row => {
        // Pad row if needed
        while (row.length < header.length) row.push('');
        md += '| ' + row.join(' | ') + ' |\n';
    });
    return md + '\n';
}

function clearHtmlToMarkdown() {
    const el = document.getElementById('html-to-md-input');
    const out = document.getElementById('html-to-md-output');
    if (el) el.value = '';
    if (out) out.value = '';
    runHtmlToMarkdown();
}

function loadHtmlToMarkdownSample() {
    const el = document.getElementById('html-to-md-input');
    if (el) {
        el.value = `<h2>Product Overview</h2>\n<p>WebToolsStation is a <strong>fast, browser-based</strong> tools platform.</p>\n<ul>\n  <li>100% Client-Side</li>\n  <li>Zero Server Uploads</li>\n</ul>\n<p>Visit <a href="https://webtoolsstation.com">WebToolsStation</a> to explore all tools.</p>`;
        runHtmlToMarkdown();
    }
}

async function pasteHtmlToMarkdownClipboard() {
    try {
        const text = await navigator.clipboard.readText();
        const el = document.getElementById('html-to-md-input');
        if (el) { el.value = text; runHtmlToMarkdown(); }
    } catch(e) { if (typeof showToast === 'function') showToast('Clipboard read failed — paste manually.', true); }
}

// =============================================================
// 7. UNICODE INSPECTOR
// =============================================================
function runUnicodeInspector() {
    const inputEl = document.getElementById('unicode-input');
    const tbody = document.getElementById('unicode-table-body');
    const statChars = document.getElementById('unicode-stat-chars');
    const statGraphemes = document.getElementById('unicode-stat-graphemes');
    const statBytes = document.getElementById('unicode-stat-bytes');
    const tableCount = document.getElementById('unicode-table-count');
    if (!inputEl || !tbody) return;

    const text = inputEl.value;
    if (!text) {
        tbody.innerHTML = '<tr><td colspan="6" style="padding:20px; text-align:center; color:var(--text-muted);">Enter text above to inspect Unicode code points and bytes.</td></tr>';
        if (statChars) statChars.textContent = '0 characters';
        if (statGraphemes) statGraphemes.textContent = '0 grapheme clusters';
        if (statBytes) statBytes.textContent = '0 UTF-8 bytes';
        if (tableCount) tableCount.textContent = 'Character Breakdown (0 items)';
        return;
    }

    // Measure grapheme clusters
    let graphemeCount = 0;
    if (typeof Intl !== 'undefined' && Intl.Segmenter) {
        try {
            const seg = new Intl.Segmenter(undefined, { granularity: 'grapheme' });
            graphemeCount = Array.from(seg.segment(text)).length;
        } catch(e) { graphemeCount = Array.from(text).length; }
    } else {
        graphemeCount = Array.from(text).length;
    }

    const utf8Bytes = new TextEncoder().encode(text);
    if (statChars) statChars.textContent = `${text.length.toLocaleString()} UTF-16 code units`;
    if (statGraphemes) statGraphemes.textContent = `${graphemeCount.toLocaleString()} grapheme cluster${graphemeCount !== 1 ? 's' : ''}`;
    if (statBytes) statBytes.textContent = `${utf8Bytes.length.toLocaleString()} UTF-8 byte${utf8Bytes.length !== 1 ? 's' : ''}`;

    // Iterate by Code Points
    const codePoints = Array.from(text);
    if (tableCount) tableCount.textContent = `Character Breakdown (${codePoints.length} code point${codePoints.length !== 1 ? 's' : ''})`;

    const rows = codePoints.map((char, index) => {
        const cp = char.codePointAt(0);
        const hex = 'U+' + cp.toString(16).toUpperCase().padStart(4, '0');
        const dec = cp.toString();
        const charBytes = new TextEncoder().encode(char);
        const bytesHex = Array.from(charBytes).map(b => '0x' + b.toString(16).toUpperCase().padStart(2, '0')).join(' ');
        const category = getUnicodeCategory(cp);
        const displayChar = cp === 32 ? '␣ (space)' : cp === 9 ? '⇥ (tab)' : cp === 10 ? '↵ (newline)' : (cp < 32 || (cp >= 127 && cp <= 159)) ? ' (ctrl)' : char;

        return `<tr style="border-bottom:1px solid var(--border);">
            <td style="padding:8px 12px; font-size:1.2rem; font-weight:700; font-family:var(--font-mono); text-align:center;">${escapeHtmlForMarkdown(displayChar)}</td>
            <td style="padding:8px 12px; font-family:var(--font-mono); font-weight:700; color:var(--brand);">${hex}</td>
            <td style="padding:8px 12px; font-family:var(--font-mono);">${dec}</td>
            <td style="padding:8px 12px; font-family:var(--font-mono); font-size:0.8rem; color:var(--text-muted);">${bytesHex}</td>
            <td style="padding:8px 12px; font-size:0.8rem;"><span style="padding:2px 6px; background:var(--surface-subtle); border-radius:4px;">${category}</span></td>
            <td style="padding:8px 12px;">
                <button type="button" class="btn btn-ghost btn-sm" style="padding:2px 8px; font-size:0.75rem;" onclick="navigator.clipboard.writeText('${hex}'); if (typeof showToast === 'function') showToast('${hex} copied!');">Copy</button>
            </td>
        </tr>`;
    });

    tbody.innerHTML = rows.join('');
}

function getUnicodeCategory(cp) {
    if (cp >= 0x0041 && cp <= 0x005A) return 'Uppercase Letter (ASCII)';
    if (cp >= 0x0061 && cp <= 0x007A) return 'Lowercase Letter (ASCII)';
    if (cp >= 0x0030 && cp <= 0x0039) return 'Decimal Number (ASCII)';
    if (cp === 0x0020) return 'Space Separator';
    if (cp < 0x0020 || (cp >= 0x007F && cp <= 0x009F)) return 'Control Code';
    if (cp >= 0x1F600 && cp <= 0x1F64F) return 'Emoticon Emoji';
    if (cp >= 0x1F300 && cp <= 0x1F5FF) return 'Misc Symbol / Emoji';
    if (cp >= 0x1F680 && cp <= 0x1F6FF) return 'Transport / Map Symbol';
    if (cp >= 0x2600 && cp <= 0x26FF) return 'Misc Symbol';
    if (cp >= 0x2700 && cp <= 0x27BF) return 'Dingbat';
    if (cp >= 0x0370 && cp <= 0x03FF) return 'Greek / Coptic';
    if (cp >= 0x0400 && cp <= 0x04FF) return 'Cyrillic';
    if (cp >= 0x0900 && cp <= 0x097F) return 'Devanagari (Hindi)';
    if (cp >= 0x0A80 && cp <= 0x0AFF) return 'Gujarati';
    if (cp >= 0x4E00 && cp <= 0x9FFF) return 'CJK Unified Ideograph (Chinese)';
    return 'Unicode Symbol / Letter';
}

function clearUnicodeInspector() {
    const el = document.getElementById('unicode-input');
    if (el) el.value = '';
    runUnicodeInspector();
}

function loadUnicodeInspectorSample() {
    const el = document.getElementById('unicode-input');
    if (el) {
        el.value = "WebTools 🚀 Café नमस्ते";
        runUnicodeInspector();
    }
}

// =============================================================
// 8. TEXT ESCAPE / UNESCAPE
// =============================================================
let activeEscapeFormat = 'json';
let activeEscapeDirection = 'escape';

function setEscapeFormat(fmt, btn) {
    activeEscapeFormat = fmt;
    document.querySelectorAll('.escape-fmt-btn').forEach(b => {
        b.classList.toggle('btn-secondary', b === btn);
        b.classList.toggle('active', b === btn);
        b.classList.toggle('btn-ghost', b !== btn);
    });
    runTextEscape();
}

function setEscapeDirection(dir, btn) {
    activeEscapeDirection = dir;
    document.querySelectorAll('.escape-dir-btn').forEach(b => {
        b.classList.toggle('btn-secondary', b === btn);
        b.classList.toggle('active', b === btn);
        b.classList.toggle('btn-ghost', b !== btn);
    });
    const inLbl = document.getElementById('escape-input-label');
    const outLbl = document.getElementById('escape-output-label');
    if (inLbl) inLbl.textContent = dir === 'escape' ? 'Source Text (Unescaped)' : 'Escaped Text Input';
    if (outLbl) outLbl.textContent = dir === 'escape' ? 'Escaped Output' : 'Unescaped Output';
    runTextEscape();
}

function runTextEscape() {
    const inputEl = document.getElementById('escape-input');
    const outputEl = document.getElementById('escape-output');
    if (!inputEl || !outputEl) return;

    const text = inputEl.value;
    if (!text) {
        outputEl.value = '';
        return;
    }

    try {
        let result = '';
        if (activeEscapeFormat === 'json') {
            if (activeEscapeDirection === 'escape') {
                result = JSON.stringify(text);
            } else {
                result = JSON.parse(text.startsWith('"') ? text : `"${text}"`);
            }
        } else if (activeEscapeFormat === 'js') {
            if (activeEscapeDirection === 'escape') {
                result = text
                    .replace(/\\/g, '\\\\')
                    .replace(/'/g, "\\'")
                    .replace(/"/g, '\\"')
                    .replace(/\n/g, '\\n')
                    .replace(/\r/g, '\\r')
                    .replace(/\t/g, '\\t');
            } else {
                result = text
                    .replace(/\\n/g, '\n')
                    .replace(/\\r/g, '\r')
                    .replace(/\\t/g, '\t')
                    .replace(/\\"/g, '"')
                    .replace(/\\'/g, "'")
                    .replace(/\\\\/g, '\\');
            }
        } else if (activeEscapeFormat === 'html') {
            if (activeEscapeDirection === 'escape') {
                result = text
                    .replace(/&/g, '&amp;')
                    .replace(/</g, '&lt;')
                    .replace(/>/g, '&gt;')
                    .replace(/"/g, '&quot;')
                    .replace(/'/g, '&#39;');
            } else {
                result = text
                    .replace(/&amp;/g, '&')
                    .replace(/&lt;/g, '<')
                    .replace(/&gt;/g, '>')
                    .replace(/&quot;/g, '"')
                    .replace(/&#39;/g, "'")
                    .replace(/&#x27;/g, "'");
            }
        } else if (activeEscapeFormat === 'csv') {
            if (activeEscapeDirection === 'escape') {
                if (text.includes(',') || text.includes('"') || text.includes('\n') || text.includes('\r')) {
                    result = `"${text.replace(/"/g, '""')}"`;
                } else {
                    result = text;
                }
            } else {
                if (text.startsWith('"') && text.endsWith('"')) {
                    result = text.slice(1, -1).replace(/""/g, '"');
                } else {
                    result = text;
                }
            }
        }
        outputEl.value = result;
    } catch (err) {
        outputEl.value = 'Error: ' + err.message;
    }
}

function clearTextEscape() {
    const el = document.getElementById('escape-input');
    const out = document.getElementById('escape-output');
    if (el) el.value = '';
    if (out) out.value = '';
}

function loadTextEscapeSample() {
    const el = document.getElementById('escape-input');
    if (el) {
        el.value = `Hello "World"!\nLine 2 with special characters: <div class="item">&</div>\tTab spacing.`;
        runTextEscape();
    }
}

async function pasteTextEscapeClipboard() {
    try {
        const text = await navigator.clipboard.readText();
        const el = document.getElementById('escape-input');
        if (el) { el.value = text; runTextEscape(); }
    } catch(e) { if (typeof showToast === 'function') showToast('Clipboard read failed — paste manually.', true); }
}

// =============================================================
// 9. CSV VIEWER
// =============================================================
let parsedCsvDataset = [];

function toggleCsvRawEditor() {
    const raw = document.getElementById('csv-raw-container');
    if (raw) {
        raw.style.display = raw.style.display === 'none' ? 'block' : 'none';
    }
}

function runCsvViewer() {
    const inputEl = document.getElementById('csv-view-input');
    const thead = document.getElementById('csv-table-head');
    const tbody = document.getElementById('csv-table-body');
    const stats = document.getElementById('csv-view-stats');
    if (!inputEl || !thead || !tbody) return;

    const raw = inputEl.value;
    if (!raw.trim()) {
        thead.innerHTML = '<tr><th style="padding:10px 14px; text-align:left; color:var(--text-muted);">Paste CSV data above to render table.</th></tr>';
        tbody.innerHTML = '';
        if (stats) stats.textContent = '0 rows | 0 columns';
        parsedCsvDataset = [];
        return;
    }

    const delimSelect = document.getElementById('csv-view-delimiter')?.value || 'auto';
    const hasHeader = document.getElementById('csv-view-has-header')?.checked ?? true;

    // Detect delimiter
    let delim = delimSelect;
    if (delim === 'auto') {
        const firstLine = raw.split(/\r?\n/)[0] || '';
        const counts = {
            ',': (firstLine.match(/,/g) || []).length,
            ';': (firstLine.match(/;/g) || []).length,
            '\t': (firstLine.match(/\t/g) || []).length,
            '|': (firstLine.match(/\|/g) || []).length
        };
        delim = Object.entries(counts).sort((a, b) => b[1] - a[1])[0][0] || ',';
        if (counts[delim] === 0) delim = ',';
    }

    const rows = parseRfc4180Csv(raw, delim);
    if (!rows.length) {
        thead.innerHTML = '<tr><th style="padding:10px 14px; text-align:left;">Empty dataset.</th></tr>';
        tbody.innerHTML = '';
        return;
    }

    parsedCsvDataset = rows;
    renderCsvTable(rows, hasHeader);
}

function parseRfc4180Csv(text, delimiter = ',') {
    const rows = [];
    let currentRow = [];
    let currentCell = '';
    let inQuotes = false;

    for (let i = 0; i < text.length; i++) {
        const char = text[i];
        const nextChar = text[i + 1];

        if (char === '"') {
            if (inQuotes && nextChar === '"') {
                currentCell += '"';
                i++; // Skip escaped quote
            } else {
                inQuotes = !inQuotes;
            }
        } else if (char === delimiter && !inQuotes) {
            currentRow.push(currentCell.trim());
            currentCell = '';
        } else if ((char === '\r' || char === '\n') && !inQuotes) {
            if (char === '\r' && nextChar === '\n') i++;
            currentRow.push(currentCell.trim());
            rows.push(currentRow);
            currentRow = [];
            currentCell = '';
        } else {
            currentCell += char;
        }
    }

    if (currentCell || currentRow.length) {
        currentRow.push(currentCell.trim());
        rows.push(currentRow);
    }

    return rows.filter(r => r.some(c => c.length > 0));
}

function renderCsvTable(rows, hasHeader = true) {
    const thead = document.getElementById('csv-table-head');
    const tbody = document.getElementById('csv-table-body');
    const stats = document.getElementById('csv-view-stats');
    if (!thead || !tbody) return;

    if (!rows.length) {
        thead.innerHTML = '<tr><th style="padding:10px 14px;">No matching rows.</th></tr>';
        tbody.innerHTML = '';
        return;
    }

    let headers = [];
    let dataRows = [];

    if (hasHeader) {
        headers = rows[0];
        dataRows = rows.slice(1);
    } else {
        const maxCols = Math.max(...rows.map(r => r.length));
        headers = Array.from({ length: maxCols }, (_, i) => `Col ${i + 1}`);
        dataRows = rows;
    }

    if (stats) {
        stats.textContent = `${dataRows.length.toLocaleString()} row${dataRows.length !== 1 ? 's' : ''} | ${headers.length.toLocaleString()} column${headers.length !== 1 ? 's' : ''}`;
    }

    thead.innerHTML = `<tr style="border-bottom:2px solid var(--border); background:var(--surface-subtle);">${
        headers.map(h => `<th style="padding:10px 14px; text-align:left; font-weight:700; border-right:1px solid var(--border);">${escapeHtmlForMarkdown(h)}</th>`).join('')
    }</tr>`;

    tbody.innerHTML = dataRows.map((row, rIdx) => {
        const bg = rIdx % 2 === 0 ? 'background:#ffffff;' : 'background:var(--surface-subtle);';
        return `<tr style="${bg} border-bottom:1px solid var(--border);">${
            headers.map((_, cIdx) => `<td style="padding:8px 14px; border-right:1px solid var(--border); font-family:var(--font-mono); font-size:0.83rem;">${escapeHtmlForMarkdown(row[cIdx] || '')}</td>`).join('')
        }</tr>`;
    }).join('');
}

function filterCsvTable() {
    const query = (document.getElementById('csv-filter-query')?.value || '').toLowerCase().trim();
    const hasHeader = document.getElementById('csv-view-has-header')?.checked ?? true;

    if (!parsedCsvDataset.length) return;

    if (!query) {
        renderCsvTable(parsedCsvDataset, hasHeader);
        return;
    }

    const headers = hasHeader ? parsedCsvDataset[0] : null;
    const dataRows = hasHeader ? parsedCsvDataset.slice(1) : parsedCsvDataset;

    const filtered = dataRows.filter(row => row.some(cell => cell.toLowerCase().includes(query)));
    const finalSet = headers ? [headers, ...filtered] : filtered;
    renderCsvTable(finalSet, hasHeader);
}

function clearCsvViewer() {
    const el = document.getElementById('csv-view-input');
    if (el) el.value = '';
    const f = document.getElementById('csv-filter-query');
    if (f) f.value = '';
    runCsvViewer();
}

function loadCsvViewerSample() {
    const el = document.getElementById('csv-view-input');
    if (el) {
        el.value = `ID,Name,Email,Role,Location,Status\n101,Jane Doe,jane@example.com,Lead Architect,"San Francisco, USA",Active\n102,Alex Chen,alex@example.com,Security Engineer,"London, UK",Active\n103,Maria Garcia,maria@example.com,Frontend Developer,"Madrid, Spain",On Leave\n104,Devon Smith,devon@example.com,DevOps Specialist,"Berlin, Germany",Active`;
        runCsvViewer();
    }
}

// =============================================================
// 10. TSV TO CSV CONVERTER
// =============================================================
function runTsvToCsv() {
    const inputEl = document.getElementById('tsv-input');
    const outputEl = document.getElementById('tsv-output');
    const inStats = document.getElementById('tsv-in-stats');
    const outStats = document.getElementById('tsv-out-stats');
    if (!inputEl || !outputEl) return;

    const tsv = inputEl.value;
    if (!tsv.trim()) {
        outputEl.value = '';
        if (inStats) inStats.textContent = '0 lines';
        if (outStats) outStats.textContent = '0 lines';
        return;
    }

    const lines = tsv.split(/\r?\n/);
    const csvRows = lines.map(line => {
        const cols = line.split('\t');
        return cols.map(col => {
            const trimmed = col.trim();
            if (trimmed.includes(',') || trimmed.includes('"') || trimmed.includes('\n') || trimmed.includes('\r')) {
                return `"${trimmed.replace(/"/g, '""')}"`;
            }
            return trimmed;
        }).join(',');
    });

    const csvOutput = csvRows.join('\n');
    outputEl.value = csvOutput;

    if (inStats) inStats.textContent = `${lines.length.toLocaleString()} line${lines.length !== 1 ? 's' : ''}`;
    if (outStats) outStats.textContent = `${csvRows.length.toLocaleString()} line${csvRows.length !== 1 ? 's' : ''}`;
}

function clearTsvToCsv() {
    const el = document.getElementById('tsv-input');
    const out = document.getElementById('tsv-output');
    if (el) el.value = '';
    if (out) out.value = '';
    runTsvToCsv();
}

function loadTsvToCsvSample() {
    const el = document.getElementById('tsv-input');
    if (el) {
        el.value = "ID\tProduct Name\tCategory\tPrice\tStock\n1\tMechanical Keyboard, RGB\tPeripherals\t89.99\t15\n2\tWireless Mouse\tPeripherals\t49.50\t42\n3\tUltra-Wide Monitor\tDisplays\t399.00\t8";
        runTsvToCsv();
    }
}

async function pasteTsvToCsvClipboard() {
    try {
        const text = await navigator.clipboard.readText();
        const el = document.getElementById('tsv-input');
        if (el) { el.value = text; runTsvToCsv(); }
    } catch(e) { if (typeof showToast === 'function') showToast('Clipboard read failed — paste manually.', true); }
}
