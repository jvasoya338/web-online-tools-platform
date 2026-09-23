/**
 * WebToolsStation - SEO Batch 4 Engine
 * 100% Client-Side SEO Analyzers, Generators, and Validators
 */

// 61. Meta Tag Analyzer
function runMetaTagAnalyzer() {
    const input = document.getElementById('meta-analyzer-input')?.value || '';
    if (!input.trim()) {
        setOutput('Please paste HTML source code or head section to analyze.', true);
        return;
    }

    try {
        const parser = new DOMParser();
        const doc = parser.parseFromString(input, 'text/html');

        const title = doc.querySelector('title')?.innerText || '(No title found)';
        const titleLength = title === '(No title found)' ? 0 : title.length;
        const description = doc.querySelector('meta[name="description"]')?.getAttribute('content') || '(No meta description)';
        const descLength = description === '(No meta description)' ? 0 : description.length;
        const canonical = doc.querySelector('link[rel="canonical"]')?.getAttribute('href') || '(No canonical URL)';
        const robots = doc.querySelector('meta[name="robots"]')?.getAttribute('content') || '(No robots meta tag - default index, follow)';
        const viewport = doc.querySelector('meta[name="viewport"]')?.getAttribute('content') || '(No viewport meta tag)';
        const charset = doc.querySelector('meta[charset]')?.getAttribute('charset') || doc.querySelector('meta[http-equiv="Content-Type"]')?.getAttribute('content') || '(Not specified)';

        // Open Graph tags
        const ogTags = [];
        doc.querySelectorAll('meta[property^="og:"]').forEach(m => {
            ogTags.push(`  • ${m.getAttribute('property')}: "${m.getAttribute('content')}"`);
        });

        // Twitter Card tags
        const twitterTags = [];
        doc.querySelectorAll('meta[name^="twitter:"]').forEach(m => {
            twitterTags.push(`  • ${m.getAttribute('name')}: "${m.getAttribute('content')}"`);
        });

        // Title score
        let titleStatus = 'Optimal (50-60 chars)';
        if (titleLength === 0) titleStatus = 'CRITICAL: Missing title tag';
        else if (titleLength < 30) titleStatus = 'Warning: Too short (< 30 chars)';
        else if (titleLength > 60) titleStatus = 'Warning: Too long (> 60 chars, may truncate in SERP)';

        // Description score
        let descStatus = 'Optimal (120-160 chars)';
        if (descLength === 0) descStatus = 'Warning: Missing meta description';
        else if (descLength < 50) descStatus = 'Warning: Too short (< 50 chars)';
        else if (descLength > 160) descStatus = 'Warning: Too long (> 160 chars, may truncate in SERP)';

        const report = [
            '=== META TAG AUDIT REPORT ===',
            '',
            `[PAGE TITLE] (${titleLength} characters) - ${titleStatus}`,
            `"${title}"`,
            '',
            `[META DESCRIPTION] (${descLength} characters) - ${descStatus}`,
            `"${description}"`,
            '',
            `[CANONICAL URL]`,
            `${canonical}`,
            '',
            `[INDEXING & DIRECTIVES]`,
            `Robots: ${robots}`,
            `Viewport: ${viewport}`,
            `Charset: ${charset}`,
            '',
            `[OPEN GRAPH META TAGS] (${ogTags.length} detected)`,
            ogTags.length ? ogTags.join('\n') : '  (None detected)',
            '',
            `[TWITTER CARDS] (${twitterTags.length} detected)`,
            twitterTags.length ? twitterTags.join('\n') : '  (None detected)'
        ].join('\n');

        setOutput(report);
    } catch (e) {
        setOutput('Error parsing HTML: ' + e.message, true);
    }
}

// 62. SERP Snippet Preview
function runSerpPreview() {
    const title = document.getElementById('serp-title')?.value || 'Example Page Title - Brand Name';
    const url = document.getElementById('serp-url')?.value || 'https://example.com/category/sample-page';
    const desc = document.getElementById('serp-desc')?.value || 'This is an example meta description that highlights the primary value proposition, features, and call to action of the webpage.';

    // Update preview widgets
    const desktopTitle = document.getElementById('serp-preview-desktop-title');
    const desktopUrl = document.getElementById('serp-preview-desktop-url');
    const desktopDesc = document.getElementById('serp-preview-desktop-desc');

    if (desktopTitle) desktopTitle.textContent = title;
    if (desktopUrl) desktopUrl.textContent = url;
    if (desktopDesc) desktopDesc.textContent = desc;

    const countTitle = document.getElementById('serp-title-count');
    const countDesc = document.getElementById('serp-desc-count');
    if (countTitle) countTitle.textContent = `${title.length} / 60 chars (${Math.round(title.length * 9.5)}px / 600px)`;
    if (countDesc) countDesc.textContent = `${desc.length} / 160 chars (${Math.round(desc.length * 6.0)}px / 960px)`;

    const output = [
        '=== GOOGLE SERP PREVIEW METRICS ===',
        `Title: ${title.length} characters (${title.length > 60 ? 'TRUNCATION RISK' : 'OK'})`,
        `Description: ${desc.length} characters (${desc.length > 160 ? 'TRUNCATION RISK' : 'OK'})`,
        `URL: ${url}`,
        '',
        'Rendered HTML Snippet:',
        `<title>${escapeHtml(title)}</title>`,
        `<meta name="description" content="${escapeHtml(desc)}">`,
        `<link rel="canonical" href="${escapeHtml(url)}">`
    ].join('\n');

    setOutput(output);
}

// 63. Open Graph Generator
function runOpenGraphGenerator() {
    const title = document.getElementById('og-title')?.value || 'My Website Title';
    const desc = document.getElementById('og-desc')?.value || 'Engaging description for social media shares.';
    const url = document.getElementById('og-url')?.value || 'https://example.com/page';
    const image = document.getElementById('og-image')?.value || 'https://example.com/og-image.jpg';
    const type = document.getElementById('og-type')?.value || 'website';
    const siteName = document.getElementById('og-sitename')?.value || 'MyBrand';

    const tags = [
        `<!-- Open Graph / Facebook / LinkedIn Meta Tags -->`,
        `<meta property="og:type" content="${escapeHtml(type)}">`,
        `<meta property="og:url" content="${escapeHtml(url)}">`,
        `<meta property="og:title" content="${escapeHtml(title)}">`,
        `<meta property="og:description" content="${escapeHtml(desc)}">`,
        `<meta property="og:image" content="${escapeHtml(image)}">`,
        siteName ? `<meta property="og:site_name" content="${escapeHtml(siteName)}">` : ''
    ].filter(Boolean).join('\n');

    setOutput(tags);
}

// 64. Twitter Card Generator
function runTwitterCardGenerator() {
    const cardType = document.getElementById('tw-card-type')?.value || 'summary_large_image';
    const site = document.getElementById('tw-site')?.value || '@brand';
    const creator = document.getElementById('tw-creator')?.value || '@author';
    const title = document.getElementById('tw-title')?.value || 'My Article Title';
    const desc = document.getElementById('tw-desc')?.value || 'Summary of the article for Twitter cards.';
    const image = document.getElementById('tw-image')?.value || 'https://example.com/twitter-card.jpg';

    const tags = [
        `<!-- Twitter / X Card Meta Tags -->`,
        `<meta name="twitter:card" content="${escapeHtml(cardType)}">`,
        site ? `<meta name="twitter:site" content="${escapeHtml(site)}">` : '',
        creator ? `<meta name="twitter:creator" content="${escapeHtml(creator)}">` : '',
        `<meta name="twitter:title" content="${escapeHtml(title)}">`,
        `<meta name="twitter:description" content="${escapeHtml(desc)}">`,
        `<meta name="twitter:image" content="${escapeHtml(image)}">`
    ].filter(Boolean).join('\n');

    setOutput(tags);
}

// 65. Robots.txt Generator
function runRobotsTxtGenerator() {
    const userAgent = document.getElementById('robots-ua')?.value || '*';
    const allowPaths = (document.getElementById('robots-allow')?.value || '/').split('\n').map(s => s.trim()).filter(Boolean);
    const disallowPaths = (document.getElementById('robots-disallow')?.value || '/admin/\n/private/').split('\n').map(s => s.trim()).filter(Boolean);
    const crawlDelay = document.getElementById('robots-crawldelay')?.value || '';
    const sitemap = document.getElementById('robots-sitemap')?.value || 'https://example.com/sitemap.xml';

    const lines = [
        `# robots.txt generated by WebToolsStation`,
        `User-agent: ${userAgent}`
    ];

    allowPaths.forEach(p => lines.push(`Allow: ${p}`));
    disallowPaths.forEach(p => lines.push(`Disallow: ${p}`));
    if (crawlDelay) lines.push(`Crawl-delay: ${crawlDelay}`);
    if (sitemap) {
        lines.push('');
        lines.push(`Sitemap: ${sitemap}`);
    }

    setOutput(lines.join('\n'));
}

// 66. Robots.txt Validator
function runRobotsTxtValidator() {
    const input = document.getElementById('robots-val-input')?.value || '';
    const testPath = document.getElementById('robots-test-path')?.value || '/admin/login';

    if (!input.trim()) {
        setOutput('Paste your robots.txt contents to validate.', true);
        return;
    }

    const lines = input.split(/\r?\n/);
    const errors = [];
    const directives = [];
    let currentUserAgent = null;
    let isAllowed = true;
    let matchingRule = null;

    lines.forEach((rawLine, idx) => {
        const lineNum = idx + 1;
        const line = rawLine.split('#')[0].trim();
        if (!line) return;

        const colonIdx = line.indexOf(':');
        if (colonIdx === -1) {
            errors.push(`Line ${lineNum}: Missing colon delimiter in directive "${rawLine}"`);
            return;
        }

        const key = line.slice(0, colonIdx).trim().toLowerCase();
        const value = line.slice(colonIdx + 1).trim();

        if (key === 'user-agent') {
            currentUserAgent = value;
            directives.push({ lineNum, type: 'User-agent', value });
        } else if (['allow', 'disallow', 'crawl-delay', 'sitemap', 'host'].includes(key)) {
            directives.push({ lineNum, userAgent: currentUserAgent, type: key, value });

            // Evaluate test path against * or Googlebot
            if ((currentUserAgent === '*' || currentUserAgent === 'googlebot') && testPath) {
                if (key === 'disallow' && value && testPath.startsWith(value)) {
                    isAllowed = false;
                    matchingRule = `Line ${lineNum}: Disallow ${value}`;
                } else if (key === 'allow' && value && testPath.startsWith(value)) {
                    isAllowed = true;
                    matchingRule = `Line ${lineNum}: Allow ${value}`;
                }
            }
        } else {
            errors.push(`Line ${lineNum}: Unknown or non-standard directive "${key}"`);
        }
    });

    const report = [
        '=== ROBOTS.TXT SYNTAX VALIDATION ===',
        `Status: ${errors.length === 0 ? 'VALID SYNTAX (0 Errors)' : 'SYNTAX ISSUES DETECTED (' + errors.length + ' warnings)'}`,
        `Total Directives Parsed: ${directives.length}`,
        '',
        errors.length ? 'Errors / Warnings:\n' + errors.map(e => '  ❌ ' + e).join('\n') + '\n' : '✅ All directives use recognized standard syntax.\n',
        '=== URL ACCESS SIMULATION ===',
        `Test Path: ${testPath}`,
        `Simulated Access: ${isAllowed ? 'ALLOWED (Crawlable)' : 'BLOCKED (Disallowed)'}`,
        matchingRule ? `Matched Rule: ${matchingRule}` : 'Matched Rule: Default allow (no explicit disallow match)'
    ].join('\n');

    setOutput(report);
}

// 67. XML Sitemap Validator
function runXmlSitemapValidator() {
    const input = document.getElementById('sitemap-xml-input')?.value || '';
    if (!input.trim()) {
        setOutput('Paste XML Sitemap contents to validate.', true);
        return;
    }

    try {
        const parser = new DOMParser();
        const doc = parser.parseFromString(input, 'text/xml');
        const parserError = doc.querySelector('parsererror');
        if (parserError) {
            setOutput('XML Syntax Error:\n' + parserError.textContent, true);
            return;
        }

        const isUrlSet = doc.documentElement.nodeName === 'urlset';
        const isSitemapIndex = doc.documentElement.nodeName === 'sitemapindex';

        if (!isUrlSet && !isSitemapIndex) {
            setOutput('Error: Root element must be <urlset> for a sitemap or <sitemapindex> for an index file. Found: <' + doc.documentElement.nodeName + '>', true);
            return;
        }

        const items = isUrlSet ? doc.querySelectorAll('url') : doc.querySelectorAll('sitemap');
        const warnings = [];
        const validUrls = [];

        items.forEach((item, idx) => {
            const loc = item.querySelector('loc')?.textContent?.trim();
            const lastmod = item.querySelector('lastmod')?.textContent?.trim();
            const changefreq = item.querySelector('changefreq')?.textContent?.trim();
            const priority = item.querySelector('priority')?.textContent?.trim();

            if (!loc) {
                warnings.push(`Item #${idx + 1}: Missing required <loc> tag.`);
            } else {
                try {
                    new URL(loc);
                    validUrls.push(loc);
                } catch {
                    warnings.push(`Item #${idx + 1}: Invalid URL in <loc>: "${loc}"`);
                }
            }

            if (lastmod && isNaN(Date.parse(lastmod))) {
                warnings.push(`Item #${idx + 1} (${loc || 'unknown'}): Invalid W3C date format in <lastmod>: "${lastmod}"`);
            }

            if (changefreq && !['always', 'hourly', 'daily', 'weekly', 'monthly', 'yearly', 'never'].includes(changefreq.toLowerCase())) {
                warnings.push(`Item #${idx + 1}: Invalid <changefreq> value: "${changefreq}"`);
            }

            if (priority) {
                const pVal = parseFloat(priority);
                if (isNaN(pVal) || pVal < 0.0 || pVal > 1.0) {
                    warnings.push(`Item #${idx + 1}: <priority> must be between 0.0 and 1.0. Found: "${priority}"`);
                }
            }
        });

        const report = [
            '=== XML SITEMAP AUDIT RESULT ===',
            `Document Type: <${doc.documentElement.nodeName}>`,
            `Total Entries: ${items.length}`,
            `Valid URLs: ${validUrls.length}`,
            `Format Errors / Warnings: ${warnings.length}`,
            '',
            warnings.length ? 'Issues Detected:\n' + warnings.map(w => '  ⚠️ ' + w).join('\n') + '\n' : '✅ Sitemap adheres to standard sitemaps.org 0.9 schema.\n',
            'Sample Entries Parsed:',
            validUrls.slice(0, 5).map((u, i) => `  ${i + 1}. ${u}`).join('\n') + (validUrls.length > 5 ? `\n  ... and ${validUrls.length - 5} more URLs` : '')
        ].join('\n');

        setOutput(report);
    } catch (e) {
        setOutput('Validation error: ' + e.message, true);
    }
}

// 68. Schema Breadcrumb Generator
function runSchemaBreadcrumbGenerator() {
    const raw = document.getElementById('breadcrumb-items')?.value || 'Home | https://example.com\nCategories | https://example.com/categories\nDeveloper Tools | https://example.com/categories/developer-tools\nJSON Formatter | https://example.com/tools/json-formatter';
    const lines = raw.split(/\r?\n/).map(l => l.trim()).filter(Boolean);

    const itemListElement = [];
    lines.forEach((line, idx) => {
        const parts = line.split('|').map(s => s.trim());
        const name = parts[0] || `Item ${idx + 1}`;
        const itemUrl = parts[1] || 'https://example.com';

        itemListElement.push({
            "@type": "ListItem",
            "position": idx + 1,
            "name": name,
            "item": itemUrl
        });
    });

    const schema = {
        "@context": "https://schema.org",
        "@type": "BreadcrumbList",
        "itemListElement": itemListElement
    };

    setOutput(`<script type="application/ld+json">\n${JSON.stringify(schema, null, 2)}\n</script>`);
}

// 69. Schema FAQ Generator
function runSchemaFaqGenerator() {
    const raw = document.getElementById('faq-items')?.value || 'What is WebToolsStation? | WebToolsStation is a free, privacy-first browser utility suite.\nDoes it send data to servers? | No, all utilities run 100% locally in your browser memory.';
    const lines = raw.split(/\r?\n/).map(l => l.trim()).filter(Boolean);

    const mainEntity = [];
    lines.forEach(line => {
        const parts = line.split('|').map(s => s.trim());
        if (parts.length >= 2) {
            mainEntity.push({
                "@type": "Question",
                "name": parts[0],
                "acceptedAnswer": {
                    "@type": "Answer",
                    "text": parts[1]
                }
            });
        }
    });

    const schema = {
        "@context": "https://schema.org",
        "@type": "FAQPage",
        "mainEntity": mainEntity
    };

    setOutput(`<script type="application/ld+json">\n${JSON.stringify(schema, null, 2)}\n</script>`);
}

// 70. Keyword Density Analyzer
function runKeywordDensityAnalyzer() {
    const text = document.getElementById('keyword-text')?.value || '';
    const ignoreStopwords = document.getElementById('keyword-stopwords')?.checked ?? true;

    if (!text.trim()) {
        setOutput('Enter or paste text to analyze keyword density.', true);
        return;
    }

    const stopwords = new Set([
        'a', 'about', 'above', 'after', 'again', 'against', 'all', 'am', 'an', 'and', 'any', 'are', 'aren\'t', 'as', 'at',
        'be', 'because', 'been', 'before', 'being', 'below', 'between', 'both', 'but', 'by', 'can', 'can\'t', 'cannot',
        'could', 'did', 'do', 'does', 'doing', 'don\'t', 'down', 'during', 'each', 'few', 'for', 'from', 'further',
        'had', 'has', 'have', 'having', 'he', 'her', 'here', 'hers', 'herself', 'him', 'himself', 'his', 'how',
        'i', 'if', 'in', 'into', 'is', 'it', 'its', 'itself', 'let\'s', 'me', 'more', 'most', 'my', 'myself',
        'no', 'nor', 'not', 'of', 'off', 'on', 'once', 'only', 'or', 'other', 'ought', 'our', 'ours', 'ourselves',
        'out', 'over', 'own', 'same', 'she', 'should', 'so', 'some', 'such', 'than', 'that', 'the', 'their', 'theirs',
        'them', 'themselves', 'then', 'there', 'these', 'they', 'this', 'those', 'through', 'to', 'too', 'under',
        'until', 'up', 'very', 'was', 'we', 'were', 'what', 'when', 'where', 'which', 'while', 'who', 'whom', 'why',
        'with', 'won\'t', 'would', 'you', 'your', 'yours', 'yourself', 'yourselves'
    ]);

    const words = text.toLowerCase()
        .replace(/[^a-z0-9\s'-]/g, ' ')
        .split(/\s+/)
        .filter(w => w.length > 1);

    const totalWords = words.length;
    if (totalWords === 0) {
        setOutput('No valid words found in input text.', true);
        return;
    }

    const filteredWords = ignoreStopwords ? words.filter(w => !stopwords.has(w)) : words;

    // Unigrams (1-word)
    const unigrams = {};
    filteredWords.forEach(w => { unigrams[w] = (unigrams[w] || 0) + 1; });

    // Bigrams (2-word)
    const bigrams = {};
    for (let i = 0; i < words.length - 1; i++) {
        const w1 = words[i], w2 = words[i + 1];
        if (ignoreStopwords && (stopwords.has(w1) && stopwords.has(w2))) continue;
        const phrase = `${w1} ${w2}`;
        bigrams[phrase] = (bigrams[phrase] || 0) + 1;
    }

    // Trigrams (3-word)
    const trigrams = {};
    for (let i = 0; i < words.length - 2; i++) {
        const phrase = `${words[i]} ${words[i + 1]} ${words[i + 2]}`;
        trigrams[phrase] = (trigrams[phrase] || 0) + 1;
    }

    function sortFreq(map) {
        return Object.entries(map).sort((a, b) => b[1] - a[1]).slice(0, 10);
    }

    const topUni = sortFreq(unigrams);
    const topBi = sortFreq(bigrams).filter(e => e[1] > 1);
    const topTri = sortFreq(trigrams).filter(e => e[1] > 1);

    const report = [
        '=== KEYWORD DENSITY ANALYSIS ===',
        `Total Words: ${totalWords.toLocaleString()}`,
        `Analyzed Words (Filtered): ${filteredWords.length.toLocaleString()}`,
        `Stopwords Excluded: ${ignoreStopwords ? 'Yes' : 'No'}`,
        '',
        '--- TOP 1-WORD KEYWORDS ---',
        topUni.map(([w, c]) => `  • "${w}": ${c}x (${((c / totalWords) * 100).toFixed(2)}%)`).join('\n') || '  (None)',
        '',
        '--- TOP 2-WORD PHRASES ---',
        topBi.length ? topBi.map(([w, c]) => `  • "${w}": ${c}x (${((c / totalWords) * 100).toFixed(2)}%)`).join('\n') : '  (No repeated 2-word phrases)',
        '',
        '--- TOP 3-WORD PHRASES ---',
        topTri.length ? topTri.map(([w, c]) => `  • "${w}": ${c}x (${((c / totalWords) * 100).toFixed(2)}%)`).join('\n') : '  (No repeated 3-word phrases)'
    ].join('\n');

    setOutput(report);
}

function escapeHtml(str) {
    return (str || '').replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
}
