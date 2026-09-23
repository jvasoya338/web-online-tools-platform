/**
 * WebToolsStation - AI Developer Tools Batch 5 Engine
 * 100% Client-Side Token Estimation, JSONL Validation, RAG Chunking, and llms.txt Generation
 */

// 95. AI Token Counter
function runAiTokenCounter() {
    const text = document.getElementById('ai-token-input')?.value || '';
    if (!text.trim()) {
        setOutput('Please enter or paste prompt text to calculate token counts.', true);
        return;
    }

    const charCount = text.length;
    const wordCount = text.trim().split(/\s+/).filter(Boolean).length;

    // Standard subword BPE token estimation rule: ~4 chars per token in English, ~0.75 words per token
    const estimatedTokens = Math.ceil(charCount / 3.8);

    // Pricing rates per 1M tokens (2026 industry benchmarks)
    const models = [
        { name: 'GPT-4o (OpenAI)', inPerM: 2.50, outPerM: 10.00 },
        { name: 'GPT-4o-mini (OpenAI)', inPerM: 0.15, outPerM: 0.60 },
        { name: 'Claude 3.5 Sonnet (Anthropic)', inPerM: 3.00, outPerM: 15.00 },
        { name: 'Claude 3.5 Haiku (Anthropic)', inPerM: 0.80, outPerM: 4.00 },
        { name: 'Gemini 1.5 Flash (Google)', inPerM: 0.075, outPerM: 0.30 },
        { name: 'Gemini 1.5 Pro (Google)', inPerM: 1.25, outPerM: 5.00 },
        { name: 'Llama 3.3 70B (Groq/Together)', inPerM: 0.59, outPerM: 0.79 }
    ];

    const report = [
        '=== AI TOKEN & COST ESTIMATE ===',
        `Characters:       ${charCount.toLocaleString()} chars`,
        `Words:            ${wordCount.toLocaleString()} words`,
        `Estimated Tokens: ~${estimatedTokens.toLocaleString()} tokens (BPE approximation)`,
        '',
        '--- ESTIMATED API PROMPT COSTS ---',
        models.map(m => {
            const inCost = (estimatedTokens / 1000000) * m.inPerM;
            return `  • ${m.name}:\n    Input Cost: $${inCost.toFixed(6)} ($${m.inPerM}/1M)`;
        }).join('\n\n')
    ].join('\n');

    setOutput(report);
}

// 96. AI Prompt Diff Checker
function runAiPromptDiff() {
    const p1 = document.getElementById('prompt-v1')?.value || '';
    const p2 = document.getElementById('prompt-v2')?.value || '';

    if (!p1 && !p2) {
        setOutput('Please enter prompt text in both Version 1 and Version 2 fields.', true);
        return;
    }

    const t1 = Math.ceil(p1.length / 3.8);
    const t2 = Math.ceil(p2.length / 3.8);
    const deltaTokens = t2 - t1;

    const lines1 = p1.split(/\r?\n/);
    const lines2 = p2.split(/\r?\n/);

    const changes = [];
    const maxLines = Math.max(lines1.length, lines2.length);

    for (let i = 0; i < maxLines; i++) {
        const l1 = lines1[i] ?? '(End of V1)';
        const l2 = lines2[i] ?? '(End of V2)';
        if (l1 !== l2) {
            changes.push(`Line ${i + 1}:\n  - V1: "${l1}"\n  + V2: "${l2}"`);
        }
    }

    const report = [
        '=== AI PROMPT ITERATION DIFF ===',
        `Version 1 Tokens: ~${t1} tokens (${p1.length} chars, ${p1.split(/\s+/).filter(Boolean).length} words)`,
        `Version 2 Tokens: ~${t2} tokens (${p2.length} chars, ${p2.split(/\s+/).filter(Boolean).length} words)`,
        `Token Variance:   ${deltaTokens >= 0 ? '+' : ''}${deltaTokens} tokens (${deltaTokens >= 0 ? 'Expansion' : 'Reduction'})`,
        '',
        `Total Modified Lines: ${changes.length}`,
        '',
        changes.length ? '--- LINE CHANGES ---\n' + changes.join('\n\n') : '✅ Both prompt versions are identical.'
    ].join('\n');

    setOutput(report);
}

// 97. Fine-Tuning JSONL Validator
function runFineTuningJsonlValidator() {
    const raw = document.getElementById('jsonl-input')?.value || '';
    if (!raw.trim()) {
        setOutput('Paste JSONL training dataset lines to validate.', true);
        return;
    }

    const lines = raw.split(/\r?\n/).filter(l => l.trim().length > 0);
    const errors = [];
    let totalMessages = 0;
    let totalChars = 0;

    lines.forEach((line, idx) => {
        const lineNum = idx + 1;
        try {
            const obj = JSON.parse(line);
            if (!obj.messages || !Array.isArray(obj.messages)) {
                errors.push(`Line ${lineNum}: Missing required "messages" array property.`);
                return;
            }

            if (obj.messages.length < 2) {
                errors.push(`Line ${lineNum}: "messages" must contain at least 2 conversational turns.`);
            }

            obj.messages.forEach((msg, mIdx) => {
                totalMessages++;
                if (!['system', 'user', 'assistant', 'tool'].includes(msg.role)) {
                    errors.push(`Line ${lineNum}, message #${mIdx + 1}: Invalid role "${msg.role}". Allowed: system, user, assistant, tool.`);
                }
                if (typeof msg.content !== 'string' || msg.content.trim().length === 0) {
                    errors.push(`Line ${lineNum}, message #${mIdx + 1}: "content" must be a non-empty string.`);
                } else {
                    totalChars += msg.content.length;
                }
            });
        } catch (e) {
            errors.push(`Line ${lineNum}: Invalid JSON syntax — ${e.message}`);
        }
    });

    const report = [
        '=== FINE-TUNING JSONL DATASET AUDIT ===',
        `Validation Status: ${errors.length === 0 ? '✅ VALID SCHEMA (0 Errors)' : '❌ ISSUES DETECTED (' + errors.length + ' errors)'}`,
        `Total JSONL Records (Samples): ${lines.length}`,
        `Total Conversational Messages: ${totalMessages}`,
        `Estimated Dataset Tokens:      ~${Math.ceil(totalChars / 3.8).toLocaleString()} tokens`,
        '',
        errors.length ? 'Validation Errors:\n' + errors.map(e => '  ❌ ' + e).join('\n') : '✅ Dataset is fully compliant with OpenAI and Anthropic JSONL fine-tuning format.'
    ].join('\n');

    setOutput(report);
}

// 98. RAG Chunk Size Calculator
function runRagChunkCalculator() {
    const docWords = parseInt(document.getElementById('rag-words')?.value || '50000', 10);
    const chunkSize = parseInt(document.getElementById('rag-chunk-size')?.value || '512', 10);
    const overlapPct = parseInt(document.getElementById('rag-overlap-pct')?.value || '15', 10);

    if (isNaN(docWords) || isNaN(chunkSize) || docWords <= 0 || chunkSize <= 0) {
        setOutput('Please enter positive numbers for document word count and chunk size.', true);
        return;
    }

    const totalDocTokens = Math.ceil(docWords * 1.33); // ~1.33 tokens per word in English
    const overlapTokens = Math.round(chunkSize * (overlapPct / 100));
    const effectiveStep = chunkSize - overlapTokens;

    const totalChunks = Math.ceil((totalDocTokens - overlapTokens) / effectiveStep);
    const totalStoredTokens = totalChunks * chunkSize;

    // OpenAI text-embedding-3-small pricing: $0.02 / 1M tokens
    const embeddingCostSmall = (totalStoredTokens / 1000000) * 0.02;
    // OpenAI text-embedding-3-large pricing: $0.13 / 1M tokens
    const embeddingCostLarge = (totalStoredTokens / 1000000) * 0.13;

    const report = [
        '=== RAG CHUNKING & EMBEDDING ESTIMATOR ===',
        `Document Words:        ${docWords.toLocaleString()} words`,
        `Estimated Base Tokens: ${totalDocTokens.toLocaleString()} tokens`,
        `Chunk Size:            ${chunkSize} tokens`,
        `Chunk Overlap:         ${overlapTokens} tokens (${overlapPct}%)`,
        `Effective Stride:      ${effectiveStep} tokens per step`,
        '',
        '--- VECTOR DATABASE METRICS ---',
        `Total Vector Chunks:   ${totalChunks.toLocaleString()} chunks`,
        `Total Embedded Tokens: ${totalStoredTokens.toLocaleString()} tokens (with overlap)`,
        `Estimated DB Index:    ~${((totalChunks * 1536 * 4) / 1024 / 1024).toFixed(2)} MB (at 1536 dimensions, float32)`,
        '',
        '--- EMBEDDING API COSTS ---',
        `  • text-embedding-3-small ($0.02/1M): $${embeddingCostSmall.toFixed(6)}`,
        `  • text-embedding-3-large ($0.13/1M): $${embeddingCostLarge.toFixed(6)}`
    ].join('\n');

    setOutput(report);
}

// 99. AI Prompt Formatter
function runAiPromptFormatter() {
    const role = document.getElementById('prompt-role')?.value || 'Expert Software Engineer & Security Auditor';
    const context = document.getElementById('prompt-context')?.value || 'Reviewing client-side JavaScript source code for cryptographic safety.';
    const instructions = document.getElementById('prompt-instructions')?.value || 'Inspect the provided JavaScript code and identify any unescaped inputs or timing side-channels.';
    const constraints = document.getElementById('prompt-constraints')?.value || '1. Prioritize strict zero-trust standards.\n2. Do not recommend paid third-party APIs.\n3. Keep recommendations actionable.';
    const outputFormat = document.getElementById('prompt-format')?.value || 'Markdown table containing Severity, Vulnerability, and Remediation Code snippet.';

    const formatted = [
        '<system_instructions>',
        `You are a ${role}.`,
        '',
        '<context>',
        context,
        '</context>',
        '',
        '<instructions>',
        instructions,
        '</instructions>',
        '',
        '<constraints>',
        constraints,
        '</constraints>',
        '',
        '<output_format>',
        outputFormat,
        '</output_format>',
        '</system_instructions>'
    ].join('\n');

    setOutput(formatted);
}

// 100. llms.txt Generator
function runLlmsTxtGenerator() {
    const title = document.getElementById('llms-title')?.value || 'WebToolsStation';
    const summary = document.getElementById('llms-summary')?.value || 'WebToolsStation is an engineering-first, privacy-focused online utility platform with 100% browser-based execution and zero server data tracking.';
    const docs = (document.getElementById('llms-docs')?.value || 'Developer Tools: https://webtoolsstation.com/categories/developer-tools\nText Utilities: https://webtoolsstation.com/categories/text-tools\nFull Sitemap: https://webtoolsstation.com/sitemap.xml').split(/\r?\n/).map(l => l.trim()).filter(Boolean);
    const optional = (document.getElementById('llms-optional')?.value || 'JSON Formatting Guide: https://webtoolsstation.com/guides/how-to-format-json-without-errors\nJWT Inspection Guide: https://webtoolsstation.com/guides/best-way-to-check-a-jwt-token').split(/\r?\n/).map(l => l.trim()).filter(Boolean);

    const lines = [
        `# ${title}`,
        '',
        `> ${summary}`,
        '',
        '## Core Documentation',
        ''
    ];

    docs.forEach(doc => {
        const parts = doc.split(':');
        const name = parts[0].trim();
        const url = parts.slice(1).join(':').trim();
        lines.push(`- [${name}](${url || name})`);
    });

    if (optional.length) {
        lines.push('');
        lines.push('## Optional & Editorial Guides');
        lines.push('');
        optional.forEach(opt => {
            const parts = opt.split(':');
            const name = parts[0].trim();
            const url = parts.slice(1).join(':').trim();
            lines.push(`- [${name}](${url || name})`);
        });
    }

    setOutput(lines.join('\n'));
}
