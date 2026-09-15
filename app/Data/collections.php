<?php

return [
    'best-developer-tools' => [
        'slug' => 'best-developer-tools',
        'title' => 'Best Online Developer Tools for Fast, Private Engineering Workflows',
        'short_title' => 'Best Developer Tools',
        'icon' => 'DV',
        'category' => 'Developer Tools',
        'seo_description' => 'Explore the best online developer tools for formatting JSON, decoding JWT tokens, testing regex patterns, minifying code, and hashing values securely in your browser.',
        'tagline' => 'Curated suite of browser utilities for API debugging, code minification, token inspection, and data conversion.',
        'overview' => 'Modern software engineering involves frequent transformations between serialized formats, token inspection during authentication debugging, and payload verification before deployment. Traditional online tools often transmit code and confidential credentials over unencrypted connections or store them on remote servers. WebToolsStation provides a unified suite of developer utilities that execute 100% locally in your client browser engine, guaranteeing complete privacy for proprietary code and sensitive API tokens.',
        'curated_tools' => [
            'json-formatter',
            'jwt-decoder',
            'base64-encode-decode',
            'regex-tester',
            'sql-formatter',
            'timestamp-converter',
            'uuid-generator',
            'hash-generator',
            'html-minifier',
            'css-minifier',
            'json-diff-checker',
            'cron-expression-helper'
        ],
        'workflows' => [
            [
                'step' => '1. Inspect and Format',
                'description' => 'Paste raw payloads into the JSON Formatter or SQL Formatter to reveal clean structural indentation and identify misplaced syntax tokens immediately.'
            ],
            [
                'step' => '2. Decode and Validate',
                'description' => 'Inspect authentication claims with the JWT Decoder or check pattern matches using the Regex Tester with real-time capture groups.'
            ],
            [
                'step' => '3. Compress for Production',
                'description' => 'Use the HTML and CSS Minifiers to strip comments and collapse whitespace, reducing bundle transfer volume before publishing assets.'
            ]
        ],
        'comparison_matrix' => [
            ['tool' => 'JSON Formatter', 'best_for' => 'REST API payloads & config formatting', 'input_type' => 'Raw JSON string', 'output' => '2-space indented or compact JSON'],
            ['tool' => 'JWT Decoder', 'best_for' => 'Auth token claims & expiration review', 'input_type' => 'Encoded JWT (header.payload.sig)', 'output' => 'Parsed header & payload claims JSON'],
            ['tool' => 'Regex Tester', 'best_for' => 'Validating regular expressions against tests', 'input_type' => 'RegEx pattern + sample string', 'output' => 'Match highlights & capture groups'],
            ['tool' => 'SQL Formatter', 'best_for' => 'Organizing complex database queries', 'input_type' => 'Raw SQL query string', 'output' => 'Indented query with uppercase keywords'],
            ['tool' => 'JSON Diff Checker', 'best_for' => 'Comparing staging vs production API responses', 'input_type' => 'Two JSON payloads', 'output' => 'Key-by-key structural difference tree'],
            ['tool' => 'Cron Expression Helper', 'best_for' => 'Interpreting crontab execution schedules', 'input_type' => '5-field cron string', 'output' => 'English schedule + next 5 run times']
        ],
        'faq' => [
            [
                'question' => 'Are my API tokens and source code safe when using these developer tools?',
                'answer' => 'Yes. All utilities in this collection execute locally in your browser JavaScript runtime. No requests containing your payload or code are transmitted across the internet.'
            ],
            [
                'question' => 'Can I use keyboard shortcuts to trigger formatting or minification?',
                'answer' => 'Yes. Pressing Ctrl+Enter (or Cmd+Enter on macOS) inside any editor immediately triggers the primary action.'
            ],
            [
                'question' => 'How do these browser tools compare to desktop IDE plugins?',
                'answer' => 'Browser tools provide instant access across any device without plugin installation or workspace configuration, while IDE plugins are best for repository-wide automated refactoring.'
            ]
        ]
    ],

    'best-json-tools' => [
        'slug' => 'best-json-tools',
        'title' => 'Best Online JSON Tools: Formatter, Validator, Diff & Converters',
        'short_title' => 'Best JSON Tools',
        'icon' => 'JS',
        'category' => 'Developer Tools',
        'seo_description' => 'A complete collection of client-side JSON utilities: format, validate, minify, compare differences, and convert JSON to XML, CSV, and YAML with zero server storage.',
        'tagline' => 'Comprehensive JSON utility toolkit for web developers, data analysts, and API engineers.',
        'overview' => 'JavaScript Object Notation (JSON) is the universal data interchange format for modern web APIs, serverless functions, and configuration files. Maintaining JSON data often requires switching between beautification, minification, semantic validation, structural comparison, and format conversion. The WebToolsStation JSON collection bundles every essential JSON operation into one fast, privacy-first interface.',
        'curated_tools' => [
            'json-formatter',
            'json-minifier',
            'json-validator',
            'json-diff-checker',
            'json-to-xml-converter',
            'xml-to-json-converter',
            'json-to-csv-converter',
            'csv-to-json-converter',
            'yaml-to-json-converter',
            'json-to-yaml-converter'
        ],
        'workflows' => [
            [
                'step' => '1. Validate Syntax',
                'description' => 'Verify RFC 8259 compliance using JSON Validator to catch missing commas, unquoted keys, or invalid single quotes before parsing.'
            ],
            [
                'step' => '2. Format and Inspect',
                'description' => 'Format the payload with standard 2-space indentation to inspect nested hierarchies, objects, and arrays clearly.'
            ],
            [
                'step' => '3. Compare or Convert',
                'description' => 'Compare two revisions with JSON Diff Checker, or convert the structured data into CSV spreadsheets or XML payloads for downstream systems.'
            ]
        ],
        'comparison_matrix' => [
            ['tool' => 'JSON Formatter', 'best_for' => 'Beautifying minified API responses', 'input_type' => 'Raw JSON string', 'output' => 'Formatted JSON with custom indent'],
            ['tool' => 'JSON Minifier', 'best_for' => 'Compressing JSON for network transmission', 'input_type' => 'Formatted JSON', 'output' => 'Single-line zero-whitespace JSON'],
            ['tool' => 'JSON Validator', 'best_for' => 'Debugging syntax and schema errors', 'input_type' => 'JSON text', 'output' => 'Diagnostic pass/fail with line/col pointer'],
            ['tool' => 'JSON Diff Checker', 'best_for' => 'Auditing differences between two objects', 'input_type' => 'Left & Right JSON', 'output' => 'Added, removed, and modified key highlights'],
            ['tool' => 'JSON to CSV Converter', 'best_for' => 'Exporting JSON records into spreadsheets', 'input_type' => 'Array of JSON objects', 'output' => 'RFC 4180 CSV table string'],
            ['tool' => 'JSON to YAML Converter', 'best_for' => 'Converting configs to Kubernetes/Docker YAML', 'input_type' => 'JSON object', 'output' => 'Clean indented YAML specification']
        ],
        'faq' => [
            [
                'question' => 'Does the JSON Formatter support comments in JSON payloads?',
                'answer' => 'Standard JSON (RFC 8259) does not support comments. The JSON Validator will flag comments as syntax errors to ensure compatibility with standard strict parsers.'
            ],
            [
                'question' => 'How large of a JSON payload can I format in the browser?',
                'answer' => 'Browser memory handles multi-megabyte JSON payloads with ease. For payloads larger than 50MB, dedicated CLI stream tools like jq are recommended.'
            ],
            [
                'question' => 'Can I convert complex nested JSON objects to CSV?',
                'answer' => 'Yes. The converter extracts top-level and primitive attributes into spreadsheet columns and stringifies nested structures to preserve data integrity.'
            ]
        ]
    ],

    'best-text-tools' => [
        'slug' => 'best-text-tools',
        'title' => 'Best Online Text Tools: Word Counter, Diff, Case Converter & Cleaners',
        'short_title' => 'Best Text Tools',
        'icon' => 'TX',
        'category' => 'Text Tools',
        'seo_description' => 'Fast, free text utilities for writers, editors, and programmers: calculate word counts, compare text diffs, sort lines, generate SEO slugs, and convert letter cases.',
        'tagline' => 'Essential text manipulation utilities for copywriting, editorial drafting, and content cleanup.',
        'overview' => 'Clear, consistent text is the backbone of engaging web content, clean source code, and professional documentation. Whether you need to measure reading time and word counts for an article, alphabetize a list of items, locate subtle character edits between two drafts, or convert headlines into URL-safe slugs, WebToolsStation Text Tools provide instantaneous client-side processing.',
        'curated_tools' => [
            'word-counter',
            'text-diff-checker',
            'line-sorter',
            'slug-generator',
            'text-case-converter',
            'lorem-ipsum-generator'
        ],
        'workflows' => [
            [
                'step' => '1. Draft and Analyze',
                'description' => 'Paste article drafts into the Word Counter to track characters, words, sentences, and estimated reading time in real time.'
            ],
            [
                'step' => '2. Clean and Standardize',
                'description' => 'Sort lists alphabetically, remove duplicate lines with Line Sorter, and format variable names or titles using Text Case Converter.'
            ],
            [
                'step' => '3. Compare Revisions',
                'description' => 'Use Text Diff Checker to spot exact character additions and deletions between drafts before publishing.'
            ]
        ],
        'comparison_matrix' => [
            ['tool' => 'Word Counter', 'best_for' => 'Article metrics and character limit tracking', 'input_type' => 'Raw text or Markdown', 'output' => 'Words, characters, reading time statistics'],
            ['tool' => 'Text Diff Checker', 'best_for' => 'Comparing two revisions of an article or code', 'input_type' => 'Original & Modified text', 'output' => 'Line-by-line colored difference view'],
            ['tool' => 'Line Sorter', 'best_for' => 'Alphabetizing lists and removing duplicates', 'input_type' => 'Multi-line text', 'output' => 'Sorted, trimmed, deduplicated list'],
            ['tool' => 'Slug Generator', 'best_for' => 'Creating clean SEO URL slugs from titles', 'input_type' => 'Article title string', 'output' => 'Kebab-case URL-safe string'],
            ['tool' => 'Text Case Converter', 'best_for' => 'Switching between camelCase, snake_case & Title', 'input_type' => 'Text string', 'output' => 'Formatted text in selected case'],
            ['tool' => 'Lorem Ipsum Generator', 'best_for' => 'Creating layout dummy text for mockups', 'input_type' => 'Paragraph count & options', 'output' => 'Standard Latin placeholder text']
        ],
        'faq' => [
            [
                'question' => 'Does the Word Counter count punctuation as characters?',
                'answer' => 'The Word Counter provides both "Characters with spaces" and "Characters without spaces" so you can match specific publisher submission guidelines.'
            ],
            [
                'question' => 'How does the Slug Generator handle accents and non-English characters?',
                'answer' => 'It normalizes Unicode diacritics (such as transforming "é" into "e") and strips non-alphanumeric punctuation to guarantee valid URL paths.'
            ],
            [
                'question' => 'Is my writing uploaded to any server when comparing text?',
                'answer' => 'Never. All text comparison, metric calculation, and sorting algorithms run completely inside your local browser memory.'
            ]
        ]
    ],

    'best-image-tools' => [
        'slug' => 'best-image-tools',
        'title' => 'Best Online Image Tools: Browser-Side Format Converters & Favicon Maker',
        'short_title' => 'Best Image Tools',
        'icon' => 'IM',
        'category' => 'Image Tools',
        'seo_description' => 'Convert image formats and generate multi-resolution favicon packages directly in your browser using HTML5 Canvas with zero cloud uploads.',
        'tagline' => 'Fast, private image utilities for web designers, frontend developers, and site owners.',
        'overview' => 'Preparing graphical assets for responsive websites requires format transformations, color depth checks, and multi-size icon generation. Unlike cloud-based converters that upload your confidential graphics and photos to remote servers, WebToolsStation Image Tools process image data locally using the browser HTML5 Canvas API, delivering instantaneous exports while keeping your media strictly confidential.',
        'curated_tools' => [
            'favicon-generator',
            'png-to-jpg-converter',
            'jpg-to-png-converter'
        ],
        'workflows' => [
            [
                'step' => '1. Select Source Image',
                'description' => 'Load your logo, icon, or photo into the client-side canvas workspace.'
            ],
            [
                'step' => '2. Configure Conversion Options',
                'description' => 'Choose JPEG quality compression levels, transparency background flattening, or target icon dimensions.'
            ],
            [
                'step' => '3. Download Optimized Assets',
                'description' => 'Export high-speed PNG, JPG, or complete multi-size favicon packages directly to your local file system.'
            ]
        ],
        'comparison_matrix' => [
            ['tool' => 'Favicon Generator', 'best_for' => 'Generating complete 6-size website icon packages', 'input_type' => 'Square image (PNG/JPG)', 'output' => '16x16 up to 512x512 PNG icons + HTML snippet'],
            ['tool' => 'PNG to JPG Converter', 'best_for' => 'Compressing transparent graphics for light web pages', 'input_type' => 'PNG image file', 'output' => 'Optimized JPG image with background fill'],
            ['tool' => 'JPG to PNG Converter', 'best_for' => 'Converting photographs into PNG format', 'input_type' => 'JPG/JPEG image file', 'output' => 'Lossless PNG image file']
        ],
        'faq' => [
            [
                'question' => 'Are my uploaded images saved on WebToolsStation servers?',
                'answer' => 'No. Images are rendered onto an HTML5 Canvas element entirely in your browser memory. No graphic data is ever transmitted across the network.'
            ],
            [
                'question' => 'What sizes does the Favicon Generator create?',
                'answer' => 'It automatically generates 16x16, 32x32, 48x48, 180x180 (Apple Touch Icon), 192x192 (Android manifest), and 512x512 dimensions alongside ready-to-paste HTML link tags.'
            ],
            [
                'question' => 'Does converting PNG to JPG support transparent backgrounds?',
                'answer' => 'JPG format does not support transparency. The converter cleanly flattens transparent alpha pixels onto a solid white background.'
            ]
        ]
    ],

    'best-pdf-tools' => [
        'slug' => 'best-pdf-tools',
        'title' => 'Best Online PDF Tools: Private In-Browser Document Inspection & Auditing',
        'short_title' => 'Best PDF Tools',
        'icon' => 'PD',
        'category' => 'PDF Tools',
        'seo_description' => 'Inspect PDF metadata, count pages, search text streams, and audit security permissions directly in your browser with zero document uploads.',
        'tagline' => 'Confidential client-side PDF inspection and security verification suite.',
        'overview' => 'Portable Document Format (PDF) files frequently contain confidential business proposals, legal contracts, tax records, and proprietary specifications. Uploading these documents to third-party conversion servers exposes sensitive corporate information to data breaches. WebToolsStation PDF Tools utilize browser-based ArrayBuffer parsing to inspect page counts, extract metadata, examine security permissions, and audit text streams entirely on your local device.',
        'curated_tools' => [
            'pdf-page-counter',
            'pdf-metadata-viewer',
            'pdf-text-finder',
            'pdf-security-checker'
        ],
        'workflows' => [
            [
                'step' => '1. Load Document',
                'description' => 'Drag and drop your PDF into the local browser reader. The file is read into client memory as a binary ArrayBuffer.'
            ],
            [
                'step' => '2. Inspect Hidden Metadata',
                'description' => 'View author names, creation dates, modifying software, and PDF specification versions with the PDF Metadata Viewer.'
            ],
            [
                'step' => '3. Audit Security & Text',
                'description' => 'Verify encryption strength, printing permissions, and copy restrictions using PDF Security Checker and PDF Text Finder.'
            ]
        ],
        'comparison_matrix' => [
            ['tool' => 'PDF Page Counter', 'best_for' => 'Fast page counting across multi-hundred page documents', 'input_type' => 'PDF file', 'output' => 'Total page count and catalog breakdown'],
            ['tool' => 'PDF Metadata Viewer', 'best_for' => 'Reviewing author, producer, title & creation dates', 'input_type' => 'PDF file', 'output' => 'Structured metadata table & raw info dictionary'],
            ['tool' => 'PDF Text Finder', 'best_for' => 'Checking if a PDF contains searchable text vs scanned bitmap', 'input_type' => 'PDF file + search keyword', 'output' => 'Text stream occurrence count & OCR readiness'],
            ['tool' => 'PDF Security Checker', 'best_for' => 'Auditing encryption, printing & extraction flags', 'input_type' => 'PDF file', 'output' => 'Security scorecard (Owner password, user permissions)']
        ],
        'faq' => [
            [
                'question' => 'Is it safe to inspect confidential legal documents on WebToolsStation?',
                'answer' => 'Yes. WebToolsStation uses the HTML5 FileReader API to parse binary byte markers locally. Your PDF file never leaves your computer.'
            ],
            [
                'question' => 'Why does PDF Text Finder report no text on some documents?',
                'answer' => 'If a document was scanned with a flatbed scanner or smartphone camera without Optical Character Recognition (OCR), the pages consist solely of bitmap images without underlying text streams.'
            ],
            [
                'question' => 'Can this tool remove password protection from PDFs?',
                'answer' => 'The PDF Security Checker audits permissions and encryption levels to ensure compliance; it does not crack or bypass cryptographically enforced passwords.'
            ]
        ]
    ],

    'best-seo-tools' => [
        'slug' => 'best-seo-tools',
        'title' => 'Best Online SEO Utilities: Content Cleanup, Slugs & Technical Meta Tools',
        'short_title' => 'Best SEO Tools',
        'icon' => 'SE',
        'category' => 'SEO Tools',
        'seo_description' => 'Essential online SEO utilities for content creators and webmasters: clean URL slugs, count keywords, minify markup, and parse query parameters.',
        'tagline' => 'Technical search engine optimization utilities for on-page tuning and content optimization.',
        'overview' => 'Achieving top rankings in Google and search engines requires precise on-page optimization, clean URL slug architecture, lightning-fast HTML transfer speeds, and correctly structured metadata. The WebToolsStation SEO suite provides creators, digital marketers, and technical SEO specialists with browser-based utilities to optimize text, craft clean URL paths, inspect query parameters, and compress page payloads.',
        'curated_tools' => [
            'slug-generator',
            'word-counter',
            'html-minifier',
            'url-parser',
            'query-string-parser',
            'favicon-generator'
        ],
        'workflows' => [
            [
                'step' => '1. Optimize URL Structure',
                'description' => 'Convert target page titles into concise, keyword-rich, URL-safe slugs using the Slug Generator.'
            ],
            [
                'step' => '2. Balance Content Metrics',
                'description' => 'Analyze word density, sentence lengths, and reading time in Word Counter to ensure comprehensive topical coverage.'
            ],
            [
                'step' => '3. Accelerate Page Performance',
                'description' => 'Minify HTML templates with HTML Minifier and audit parameter tracking with Query String Parser.'
            ]
        ],
        'comparison_matrix' => [
            ['tool' => 'Slug Generator', 'best_for' => 'Generating SEO-friendly kebab-case URL paths', 'input_type' => 'Article title string', 'output' => 'Normalized lowercase URL slug'],
            ['tool' => 'Word Counter', 'best_for' => 'Auditing word count targets and reading times', 'input_type' => 'Article content', 'output' => 'Detailed text metric breakdown'],
            ['tool' => 'HTML Minifier', 'best_for' => 'Improving Core Web Vitals and page load speed', 'input_type' => 'HTML markup', 'output' => 'Minified HTML payload with byte savings metric'],
            ['tool' => 'Query String Parser', 'best_for' => 'Auditing UTM tracking parameters and campaign tags', 'input_type' => 'Query string or URL', 'output' => 'Structured parameter table + JSON format'],
            ['tool' => 'URL Parser', 'best_for' => 'Deconstructing protocol, host, port, path and params', 'input_type' => 'Full URL', 'output' => 'Individual URL component inspection'],
            ['tool' => 'Favicon Generator', 'best_for' => 'Generating brand icons for mobile SERP displays', 'input_type' => 'Source brand icon', 'output' => 'All standard SERP icon dimensions']
        ],
        'faq' => [
            [
                'question' => 'Why are short, clean URL slugs important for SEO?',
                'answer' => 'Clean slugs improve click-through rates (CTR) in search results, help search engines understand page topic hierarchy, and prevent truncation on mobile screens.'
            ],
            [
                'question' => 'How does HTML minification directly benefit SEO?',
                'answer' => 'Minifying HTML reduces document byte size, accelerating Time to First Byte (TTFB) and improving Largest Contentful Paint (LCP), both critical Google ranking factors.'
            ],
            [
                'question' => 'What is the optimal length for an SEO article?',
                'answer' => 'There is no single magic word count; content should thoroughly answer the user search query without fluff. The Word Counter helps you track depth against competitor averages.'
            ]
        ]
    ]
];
