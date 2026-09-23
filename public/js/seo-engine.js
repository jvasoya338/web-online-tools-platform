/**
 * WebToolsStation - SEO Engine
 * Meta Tag Generator, Open Graph, Twitter Cards, robots.txt validator, schema generators
 */

// 60. Meta Tag Generator
function runMetaTagGenerator() {
    const title = document.getElementById("meta-title")?.value.trim() || 'My Website - High Performance Tools';
    const desc = document.getElementById("meta-desc")?.value.trim() || 'Fast and secure client-side developer utilities.';
    const canonical = document.getElementById("meta-canonical")?.value.trim() || 'https://example.com/';
    const robots = document.getElementById("meta-robots")?.value || 'index, follow';
    const author = document.getElementById("meta-author")?.value.trim() || 'Author Name';
    const outputEl = document.getElementById("meta-output");
    if (!outputEl) return;

    const tags = `<!-- Primary Meta Tags -->
<title>${title}</title>
<meta name="title" content="${title}">
<meta name="description" content="${desc}">
<meta name="robots" content="${robots}">
<meta name="author" content="${author}">
<link rel="canonical" href="${canonical}">

<!-- Mobile Viewport & Charset -->
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">`;

    outputEl.value = tags;
}
