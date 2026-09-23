/**
 * WebToolsStation - Security Engine
 * Password entropy, SRI hashes, CSP generator/validator, File checksums, Sensitive data redactor
 */

// 52. Password Strength Analyzer
function runPasswordStrengthAnalyzer() {
    const input = document.getElementById("pw-strength-input")?.value || '';
    const reportEl = document.getElementById("pw-strength-report");
    if (!reportEl) return;

    if (!input) {
        reportEl.innerHTML = '<div style="color:var(--text-muted);">Enter password to analyze entropy and crack resilience.</div>';
        return;
    }

    let pool = 0;
    if (/[a-z]/.test(input)) pool += 26;
    if (/[A-Z]/.test(input)) pool += 26;
    if (/[0-9]/.test(input)) pool += 10;
    if (/[^a-zA-Z0-9]/.test(input)) pool += 33;

    const entropy = (input.length * Math.log2(pool || 1)).toFixed(1);
    let rating = 'Very Weak';
    let color = '#ef4444';

    if (entropy >= 80) { rating = 'Very Strong'; color = '#059669'; }
    else if (entropy >= 60) { rating = 'Strong'; color = '#10b981'; }
    else if (entropy >= 40) { rating = 'Moderate'; color = '#f59e0b'; }
    else if (entropy >= 25) { rating = 'Weak'; color = '#f97316'; }

    reportEl.innerHTML = `<div style="padding:16px; background:#fafafa; border:1px solid var(--border); border-radius:var(--radius-sm);">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px;">
            <span style="font-weight:700; font-size:1.05rem;">Security Rating:</span>
            <span class="badge" style="background:${color}; color:#fff; font-size:0.9rem; font-weight:800; padding:4px 12px; border-radius:4px;">${rating} (${entropy} bits)</span>
        </div>
        <div style="font-size:0.88rem; line-height:1.6; color:var(--text);">
            <div><strong>Length:</strong> ${input.length} characters</div>
            <div><strong>Character Pool Size:</strong> ${pool} possible glyphs</div>
            <div><strong>Estimated Offline Cracking Time:</strong> ${entropy >= 60 ? 'Centuries (Resistant to GPU cluster)' : 'Seconds / Minutes (Vulnerable)'}</div>
        </div>
    </div>`;
}

// 53. Hash Comparator
function runHashComparator() {
    const hash1 = document.getElementById("hash-cmp-1")?.value.trim().toLowerCase() || '';
    const hash2 = document.getElementById("hash-cmp-2")?.value.trim().toLowerCase() || '';
    const statusEl = document.getElementById("hash-cmp-status");
    if (!statusEl) return;

    if (!hash1 || !hash2) {
        statusEl.innerHTML = '<div style="color:var(--text-muted);">Paste two hashes to compare.</div>';
        return;
    }

    if (hash1 === hash2) {
        statusEl.innerHTML = '<div style="padding:14px; background:#ecfdf5; border:1px solid #10b981; border-radius:var(--radius-sm); color:#065f46; font-weight:700;">✓ EXACT MATCH (Checksums are identical)</div>';
    } else {
        statusEl.innerHTML = '<div style="padding:14px; background:#fef2f2; border:1px solid #ef4444; border-radius:var(--radius-sm); color:#991b1b; font-weight:700;">✗ MISMATCH (Hashes do not match)</div>';
    }
}

// 54. API Key & Bearer Token Generator
function runApiKeyGenerator() {
    const prefix = document.getElementById("apikey-prefix")?.value.trim() || 'sk_live_';
    const length = parseInt(document.getElementById("apikey-length")?.value || '32', 10);
    const count = parseInt(document.getElementById("apikey-count")?.value || '5', 10);
    const outputEl = document.getElementById("apikey-output");
    if (!outputEl) return;

    const charset = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    const keys = [];

    for (let c = 0; c < count; c++) {
        const randBytes = new Uint8Array(length);
        crypto.getRandomValues(randBytes);
        let token = '';
        for (let i = 0; i < length; i++) {
            token += charset[randBytes[i] % charset.length];
        }
        keys.push(`${prefix}${token}`);
    }

    outputEl.textContent = keys.join('\n');
    showToast(`Generated ${count} API keys.`);
}

// 55. SRI Hash Generator
async function runSriHashGenerator() {
    const input = document.getElementById("sri-input")?.value || '';
    const url = document.getElementById("sri-url")?.value.trim() || 'https://cdn.example.com/library.js';
    const outputEl = document.getElementById("sri-output");
    if (!outputEl) return;

    if (!input.trim()) {
        outputEl.value = 'Please paste script or stylesheet content.';
        return;
    }

    const data = new TextEncoder().encode(input);
    const hash384 = await crypto.subtle.digest('SHA-384', data);
    const hash512 = await crypto.subtle.digest('SHA-512', data);

    const b64_384 = btoa(String.fromCharCode(...new Uint8Array(hash384)));
    const b64_512 = btoa(String.fromCharCode(...new Uint8Array(hash512)));

    const tag = url.endsWith('.css')
        ? `<link rel="stylesheet" href="${url}" integrity="sha384-${b64_384}" crossorigin="anonymous">`
        : `<script src="${url}" integrity="sha384-${b64_384}" crossorigin="anonymous"></script>`;

    outputEl.value = `<!-- HTML Tag with SRI -->\n${tag}\n\n<!-- SHA-384 Hash -->\nsha384-${b64_384}\n\n<!-- SHA-512 Hash -->\nsha512-${b64_512}`;
}

// 56. CSP Generator
function runCspGenerator() {
    const defaultSrc = document.getElementById("csp-default")?.value || "'self'";
    const scriptSrc = document.getElementById("csp-script")?.value || "'self'";
    const styleSrc = document.getElementById("csp-style")?.value || "'self' 'unsafe-inline'";
    const imgSrc = document.getElementById("csp-img")?.value || "'self' data: https:";
    const outputEl = document.getElementById("csp-output");
    if (!outputEl) return;

    const policy = `default-src ${defaultSrc}; script-src ${scriptSrc}; style-src ${styleSrc}; img-src ${imgSrc}; object-src 'none'; base-uri 'self';`;
    outputEl.value = `<!-- HTTP Header -->\nContent-Security-Policy: ${policy}\n\n<!-- HTML Meta Tag -->\n<meta http-equiv="Content-Security-Policy" content="${policy}">`;
}

// 57. CSP Validator
function runCspValidator() {
    const input = document.getElementById("csp-val-input")?.value.trim() || '';
    const reportEl = document.getElementById("csp-val-report");
    if (!reportEl) return;

    if (!input) {
        reportEl.innerHTML = '<div style="color:var(--text-muted);">Paste CSP header string to audit.</div>';
        return;
    }

    const clean = input.replace(/^Content-Security-Policy:\s*/i, '');
    const directives = clean.split(';').map(d => d.trim()).filter(Boolean);
    const warnings = [];

    if (!directives.some(d => d.startsWith('default-src'))) warnings.push('Missing fallback "default-src" directive.');
    if (clean.includes("'unsafe-inline'")) warnings.push('"unsafe-inline" detected: allows inline script execution, elevating XSS risk.');
    if (clean.includes("'unsafe-eval'")) warnings.push('"unsafe-eval" detected: permits eval() string execution.');
    if (clean.includes("*")) warnings.push('Wildcard (*) source detected: allows resources from any origin.');

    if (warnings.length === 0) {
        reportEl.innerHTML = '<div style="padding:14px; background:#ecfdf5; border:1px solid #10b981; border-radius:var(--radius-sm); color:#065f46; font-weight:700;">✓ Robust CSP Policy (0 security warnings)</div>';
    } else {
        reportEl.innerHTML = `<div style="padding:14px; background:#fef2f2; border:1px solid #ef4444; border-radius:var(--radius-sm); color:#991b1b;">
            <strong>Security Warnings (${warnings.length}):</strong>
            <ul style="margin:8px 0 0 16px;">${warnings.map(w => `<li>${escapeHtmlString(w)}</li>`).join('')}</ul>
        </div>`;
    }
}

// 58. File Hash Calculator (Client-side FileReader + Crypto)
async function runFileHashCalculator(fileInput) {
    const file = fileInput.files[0];
    const outputEl = document.getElementById("file-hash-output");
    if (!file || !outputEl) return;

    outputEl.textContent = `Reading ${file.name} (${(file.size / 1024).toFixed(1)} KB)...`;
    const buffer = await file.arrayBuffer();

    const hash256 = await crypto.subtle.digest('SHA-256', buffer);
    const hash1 = await crypto.subtle.digest('SHA-1', buffer);

    const hex256 = Array.from(new Uint8Array(hash256)).map(b => b.toString(16).padStart(2, '0')).join('');
    const hex1 = Array.from(new Uint8Array(hash1)).map(b => b.toString(16).padStart(2, '0')).join('');

    outputEl.textContent = `File: ${file.name} (${file.size.toLocaleString()} bytes)\n\nSHA-256 Checksum:\n${hex256}\n\nSHA-1 Checksum:\n${hex1}`;
}

// 59. Sensitive Data Redactor
function runSensitiveDataRedactor() {
    const input = document.getElementById("redact-input")?.value || '';
    const mask = document.getElementById("redact-mask")?.value || '[REDACTED]';
    const outputEl = document.getElementById("redact-output");
    if (!outputEl) return;

    let text = input;
    // Credit cards (13-19 digits)
    text = text.replace(/\b(?:\d[ -]*?){13,19}\b/g, mask);
    // Emails
    text = text.replace(/[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}/g, mask);
    // IPv4
    text = text.replace(/\b(?:\d{1,3}\.){3}\d{1,3}\b/g, mask);
    // Bearer tokens & API keys
    text = text.replace(/(?:Bearer\s+|api[_-]?key[:=]\s*)[a-zA-Z0-9_\-\.]{16,}/gi, mask);

    outputEl.value = text;
}
