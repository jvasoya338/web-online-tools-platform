{{-- Batch 4 SEO Tools Workspace Partials --}}

{{-- 61. Meta Tag Analyzer --}}
@if($tool['slug'] === 'meta-tag-analyzer')
    <div class="form-group mb-3">
        <label class="form-label" for="meta-analyzer-input"><strong>HTML Source Code / &lt;head&gt; Section:</strong></label>
        <textarea id="meta-analyzer-input" class="form-control font-monospace" rows="8" placeholder="Paste HTML head markup with title, meta tags, Open Graph, etc..."><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WebToolsStation – Fast, Privacy-First Online Utilities</title>
    <meta name="description" content="Access over 100+ free client-side developer, text, SEO, and conversion tools designed for speed, privacy, and productivity.">
    <link rel="canonical" href="https://webtoolsstation.com/">
    <meta name="robots" content="index, follow">
    <meta property="og:title" content="WebToolsStation Online Utilities">
    <meta property="og:description" content="100% browser-based utility tools.">
    <meta property="og:type" content="website">
    <meta name="twitter:card" content="summary_large_image">
</head>
<body></body>
</html></textarea>
    </div>
    <div class="d-flex flex-wrap gap-2 mb-3">
        <button type="button" class="btn btn-primary" onclick="runMetaTagAnalyzer()">Analyze Meta Tags</button>
        <button type="button" class="btn btn-secondary" onclick="document.getElementById('meta-analyzer-input').value=''; setOutput('');">Clear</button>
    </div>
@endif

{{-- 62. SERP Snippet Preview --}}
@if($tool['slug'] === 'serp-snippet-preview')
    <div class="row g-3 mb-3">
        <div class="col-md-6">
            <label class="form-label" for="serp-title"><strong>Page SEO Title:</strong></label>
            <input type="text" id="serp-title" class="form-control mb-1" value="WebToolsStation – Fast, Privacy-First Online Developer Utilities" oninput="runSerpPreview()">
            <div class="d-flex justify-content-between text-muted small mb-2">
                <span>Recommended: 50–60 chars</span>
                <span id="serp-title-count">65 / 60 chars</span>
            </div>

            <label class="form-label" for="serp-url"><strong>Canonical URL:</strong></label>
            <input type="text" id="serp-url" class="form-control mb-2" value="https://webtoolsstation.com/tools/json-formatter" oninput="runSerpPreview()">

            <label class="form-label" for="serp-desc"><strong>Meta Description:</strong></label>
            <textarea id="serp-desc" class="form-control mb-1" rows="3" oninput="runSerpPreview()">Format, validate, and beautify your JSON data instantly in your browser with zero server uploads and complete client-side data privacy.</textarea>
            <div class="d-flex justify-content-between text-muted small">
                <span>Recommended: 120–160 chars</span>
                <span id="serp-desc-count">141 / 160 chars</span>
            </div>
        </div>
        <div class="col-md-6">
            <label class="form-label"><strong>Live Google SERP Desktop Simulation:</strong></label>
            <div class="p-3 border rounded bg-white" style="font-family: Arial, sans-serif; max-width: 600px;">
                <div class="text-muted small" style="font-size: 12px;" id="serp-preview-desktop-url">https://webtoolsstation.com/tools/json-formatter</div>
                <div class="fw-semibold text-primary" style="font-size: 18px; color: #1a0dab !important; line-height: 1.3; cursor: pointer; text-decoration: underline;" id="serp-preview-desktop-title">WebToolsStation – Fast, Privacy-First Online Developer Utilities</div>
                <div class="text-secondary mt-1" style="font-size: 14px; color: #4d5156 !important; line-height: 1.4;" id="serp-preview-desktop-desc">Format, validate, and beautify your JSON data instantly in your browser with zero server uploads and complete client-side data privacy.</div>
            </div>
        </div>
    </div>
    <div class="d-flex flex-wrap gap-2 mb-3">
        <button type="button" class="btn btn-primary" onclick="runSerpPreview()">Refresh Metrics & Code</button>
    </div>
@endif

{{-- 63. Open Graph Generator --}}
@if($tool['slug'] === 'open-graph-generator')
    <div class="row g-3 mb-3">
        <div class="col-md-6">
            <label class="form-label" for="og-title"><strong>og:title:</strong></label>
            <input type="text" id="og-title" class="form-control mb-2" value="WebToolsStation – Free Online Developer Tools" oninput="runOpenGraphGenerator()">

            <label class="form-label" for="og-desc"><strong>og:description:</strong></label>
            <textarea id="og-desc" class="form-control mb-2" rows="2" oninput="runOpenGraphGenerator()">Explore 100+ private, fast browser utilities for developers, SEO specialists, and content creators.</textarea>

            <label class="form-label" for="og-url"><strong>og:url:</strong></label>
            <input type="text" id="og-url" class="form-control mb-2" value="https://webtoolsstation.com/" oninput="runOpenGraphGenerator()">
        </div>
        <div class="col-md-6">
            <label class="form-label" for="og-image"><strong>og:image URL:</strong></label>
            <input type="text" id="og-image" class="form-control mb-2" value="https://webtoolsstation.com/images/og-banner.png" oninput="runOpenGraphGenerator()">

            <label class="form-label" for="og-type"><strong>og:type:</strong></label>
            <select id="og-type" class="form-select mb-2" onchange="runOpenGraphGenerator()">
                <option value="website" selected>website</option>
                <option value="article">article</option>
                <option value="product">product</option>
                <option value="profile">profile</option>
            </select>

            <label class="form-label" for="og-sitename"><strong>og:site_name:</strong></label>
            <input type="text" id="og-sitename" class="form-control mb-2" value="WebToolsStation" oninput="runOpenGraphGenerator()">
        </div>
    </div>
    <div class="d-flex flex-wrap gap-2 mb-3">
        <button type="button" class="btn btn-primary" onclick="runOpenGraphGenerator()">Generate Open Graph Tags</button>
        <button type="button" class="btn btn-secondary" onclick="copyOutput()">Copy Meta Tags</button>
    </div>
@endif

{{-- 64. Twitter Card Generator --}}
@if($tool['slug'] === 'twitter-card-generator')
    <div class="row g-3 mb-3">
        <div class="col-md-6">
            <label class="form-label" for="tw-card-type"><strong>twitter:card Type:</strong></label>
            <select id="tw-card-type" class="form-select mb-2" onchange="runTwitterCardGenerator()">
                <option value="summary_large_image" selected>summary_large_image (Large banner card)</option>
                <option value="summary">summary (Small thumbnail card)</option>
                <option value="app">app</option>
                <option value="player">player</option>
            </select>

            <label class="form-label" for="tw-title"><strong>twitter:title:</strong></label>
            <input type="text" id="tw-title" class="form-control mb-2" value="Mastering Client-Side SEO & Developer Tooling" oninput="runTwitterCardGenerator()">

            <label class="form-label" for="tw-desc"><strong>twitter:description:</strong></label>
            <textarea id="tw-desc" class="form-control mb-2" rows="2" oninput="runTwitterCardGenerator()">Comprehensive guide to browser-based utilities with zero server data storage.</textarea>
        </div>
        <div class="col-md-6">
            <label class="form-label" for="tw-image"><strong>twitter:image URL:</strong></label>
            <input type="text" id="tw-image" class="form-control mb-2" value="https://webtoolsstation.com/images/twitter-card.png" oninput="runTwitterCardGenerator()">

            <label class="form-label" for="tw-site"><strong>twitter:site (@handle):</strong></label>
            <input type="text" id="tw-site" class="form-control mb-2" value="@webtoolsstation" oninput="runTwitterCardGenerator()">

            <label class="form-label" for="tw-creator"><strong>twitter:creator (@handle):</strong></label>
            <input type="text" id="tw-creator" class="form-control mb-2" value="@tjverse" oninput="runTwitterCardGenerator()">
        </div>
    </div>
    <div class="d-flex flex-wrap gap-2 mb-3">
        <button type="button" class="btn btn-primary" onclick="runTwitterCardGenerator()">Generate Twitter Cards</button>
        <button type="button" class="btn btn-secondary" onclick="copyOutput()">Copy Tags</button>
    </div>
@endif

{{-- 65. Robots.txt Generator --}}
@if($tool['slug'] === 'robots-txt-generator')
    <div class="row g-3 mb-3">
        <div class="col-md-6">
            <label class="form-label" for="robots-ua"><strong>User-agent:</strong></label>
            <select id="robots-ua" class="form-select mb-2" onchange="runRobotsTxtGenerator()">
                <option value="*" selected>* (All Web Crawlers)</option>
                <option value="Googlebot">Googlebot</option>
                <option value="Bingbot">Bingbot</option>
                <option value="GPTBot">GPTBot (OpenAI)</option>
                <option value="ClaudeBot">ClaudeBot (Anthropic)</option>
            </select>

            <label class="form-label" for="robots-allow"><strong>Allow Paths (one per line):</strong></label>
            <textarea id="robots-allow" class="form-control font-monospace mb-2" rows="2" oninput="runRobotsTxtGenerator()">/
/categories/
/tools/</textarea>

            <label class="form-label" for="robots-disallow"><strong>Disallow Paths (one per line):</strong></label>
            <textarea id="robots-disallow" class="form-control font-monospace mb-2" rows="3" oninput="runRobotsTxtGenerator()">/admin/
/api/internal/
/temp/</textarea>
        </div>
        <div class="col-md-6">
            <label class="form-label" for="robots-sitemap"><strong>Sitemap URL:</strong></label>
            <input type="text" id="robots-sitemap" class="form-control mb-2" value="https://webtoolsstation.com/sitemap.xml" oninput="runRobotsTxtGenerator()">

            <label class="form-label" for="robots-crawldelay"><strong>Crawl-delay (seconds, optional):</strong></label>
            <input type="number" id="robots-crawldelay" class="form-control mb-2" placeholder="e.g. 5" oninput="runRobotsTxtGenerator()">
        </div>
    </div>
    <div class="d-flex flex-wrap gap-2 mb-3">
        <button type="button" class="btn btn-primary" onclick="runRobotsTxtGenerator()">Generate robots.txt</button>
        <button type="button" class="btn btn-secondary" onclick="copyOutput()">Copy robots.txt</button>
    </div>
@endif

{{-- 66. Robots.txt Validator --}}
@if($tool['slug'] === 'robots-txt-validator')
    <div class="row g-3 mb-3">
        <div class="col-md-8">
            <label class="form-label" for="robots-val-input"><strong>Paste robots.txt Content:</strong></label>
            <textarea id="robots-val-input" class="form-control font-monospace" rows="7" placeholder="User-agent: *&#10;Disallow: /admin/">User-agent: *
Disallow: /admin/
Disallow: /private/
Allow: /public/

User-agent: Googlebot
Allow: /

Sitemap: https://webtoolsstation.com/sitemap.xml</textarea>
        </div>
        <div class="col-md-4">
            <label class="form-label" for="robots-test-path"><strong>Test URL Path to Check:</strong></label>
            <input type="text" id="robots-test-path" class="form-control mb-3" value="/admin/dashboard" oninput="runRobotsTxtValidator()">
            <div class="small text-muted">Test whether any path is permitted or blocked by the crawler directives.</div>
        </div>
    </div>
    <div class="d-flex flex-wrap gap-2 mb-3">
        <button type="button" class="btn btn-primary" onclick="runRobotsTxtValidator()">Validate & Test Rules</button>
    </div>
@endif

{{-- 67. XML Sitemap Validator --}}
@if($tool['slug'] === 'xml-sitemap-validator')
    <div class="form-group mb-3">
        <label class="form-label" for="sitemap-xml-input"><strong>XML Sitemap Content:</strong></label>
        <textarea id="sitemap-xml-input" class="form-control font-monospace" rows="8" placeholder="Paste <?xml version='1.0' encoding='UTF-8'?> <urlset>...</urlset>"><?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
  <url>
    <loc>https://webtoolsstation.com/</loc>
    <lastmod>2026-09-23</lastmod>
    <changefreq>daily</changefreq>
    <priority>1.0</priority>
  </url>
  <url>
    <loc>https://webtoolsstation.com/tools/json-formatter</loc>
    <lastmod>2026-09-23</lastmod>
    <changefreq>weekly</changefreq>
    <priority>0.9</priority>
  </url>
</urlset></textarea>
    </div>
    <div class="d-flex flex-wrap gap-2 mb-3">
        <button type="button" class="btn btn-primary" onclick="runXmlSitemapValidator()">Validate XML Sitemap</button>
        <button type="button" class="btn btn-secondary" onclick="document.getElementById('sitemap-xml-input').value=''; setOutput('');">Clear</button>
    </div>
@endif

{{-- 68. Schema Breadcrumb Generator --}}
@if($tool['slug'] === 'schema-breadcrumb-generator')
    <div class="form-group mb-3">
        <label class="form-label" for="breadcrumb-items"><strong>Breadcrumb Trail (Format: Name | URL per line):</strong></label>
        <textarea id="breadcrumb-items" class="form-control font-monospace" rows="6" oninput="runSchemaBreadcrumbGenerator()">Home | https://webtoolsstation.com
Categories | https://webtoolsstation.com/categories
Developer Tools | https://webtoolsstation.com/categories/developer-tools
JSON Formatter | https://webtoolsstation.com/tools/json-formatter</textarea>
    </div>
    <div class="d-flex flex-wrap gap-2 mb-3">
        <button type="button" class="btn btn-primary" onclick="runSchemaBreadcrumbGenerator()">Generate JSON-LD Schema</button>
        <button type="button" class="btn btn-secondary" onclick="copyOutput()">Copy Schema</button>
    </div>
@endif

{{-- 69. Schema FAQ Generator --}}
@if($tool['slug'] === 'schema-faq-generator')
    <div class="form-group mb-3">
        <label class="form-label" for="faq-items"><strong>FAQ Questions & Answers (Format: Question | Answer per line):</strong></label>
        <textarea id="faq-items" class="form-control font-monospace" rows="6" oninput="runSchemaFaqGenerator()">Is WebToolsStation free to use? | Yes, all 100+ utilities on WebToolsStation are 100% free with unlimited usage.
Are my files or inputs stored on your servers? | No, everything is processed directly inside your browser memory with zero server uploads.</textarea>
    </div>
    <div class="d-flex flex-wrap gap-2 mb-3">
        <button type="button" class="btn btn-primary" onclick="runSchemaFaqGenerator()">Generate FAQPage Schema</button>
        <button type="button" class="btn btn-secondary" onclick="copyOutput()">Copy Schema</button>
    </div>
@endif

{{-- 70. Keyword Density Analyzer --}}
@if($tool['slug'] === 'keyword-density-analyzer')
    <div class="form-group mb-3">
        <label class="form-label" for="keyword-text"><strong>Article or Webpage Content:</strong></label>
        <textarea id="keyword-text" class="form-control font-monospace" rows="7" placeholder="Paste your article or webpage copy here to analyze keyword frequency and density...">Search engine optimization requires understanding user intent, keyword research, and on-page optimization. High quality content addresses search query intent directly. By optimizing keyword density and ensuring comprehensive topic coverage, your web pages rank higher on search engines.</textarea>
    </div>
    <div class="form-check form-switch mb-3">
        <input class="form-check-input" type="checkbox" id="keyword-stopwords" checked onchange="runKeywordDensityAnalyzer()">
        <label class="form-check-label" for="keyword-stopwords">Exclude common English stopwords (the, is, and, or, in, of, etc.)</label>
    </div>
    <div class="d-flex flex-wrap gap-2 mb-3">
        <button type="button" class="btn btn-primary" onclick="runKeywordDensityAnalyzer()">Analyze Keyword Density</button>
        <button type="button" class="btn btn-secondary" onclick="document.getElementById('keyword-text').value=''; setOutput('');">Clear</button>
    </div>
@endif
