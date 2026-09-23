<?php

return array (
  'developer-tools' =>
  array (
    'slug' => 'developer-tools',
    'name' => 'Developer Tools',
    'category_key' => 'Developer Tools',
    'icon' => 'DV',
    'tagline' => 'Fast browser-based data formatting, string encoding, token decoding, and syntax verification.',
    'description' => 'Modern software engineering involves constant inspection and transformation of data payloads, tokens, timestamps, hashes, and configuration structures. The WebToolsStation Developer Tools suite provides client-side utilities that execute entirely inside your local browser runtime, ensuring that your sensitive payload data, API tokens, and development values are never transmitted across the network to an external server.',
    'extended_description' => 'Whether you are debugging a failed API response, converting Unix timestamps during log analysis, testing regular expressions against edge cases, or decoding JWT headers to verify expiration claims, these tools give you immediate feedback without the overhead of heavy desktop applications.',
    'key_workflows' =>
    array (
      0 => 'Validating, pretty-printing, and minifying JSON payloads for API testing and log analysis.',
      1 => 'Decoding JSON Web Tokens (JWT) to inspect header algorithms and payload claims without verifying keys.',
      2 => 'Converting Unix timestamps to UTC and local times during server log debugging.',
      3 => 'Generating cryptographically random UUID v4 identifiers and computing SHA-256 digests.',
      4 => 'Testing regular expressions against sample inputs with live match breakdowns and capture groups.',
      5 => 'Encoding and decoding URL components and HTML entities for web forms and query parameters.',
    ),
    'limitations' => 'Browser-based developer tools operate on the text provided in memory. Large multi-megabyte payloads may experience browser memory limits, and token decoding does not replace cryptographic signature verification performed by your backend authentication service.',
  ),
  'text-tools' =>
  array (
    'slug' => 'text-tools',
    'name' => 'Text & Content Tools',
    'category_key' => 'Text Tools',
    'icon' => 'TX',
    'tagline' => 'Text case conversion, line sorting, word metrics, difference checking, and slug generation.',
    'description' => 'Clean, consistent text is essential for copywriting, SEO URL formatting, data preparation, documentation, and interface styling. Our Text Tools suite helps writers, editors, and engineers clean and compare text fragments without installing heavy text processing software.',
    'extended_description' => 'From converting prose into URL-safe slugs with diacritic normalization to comparing two versions of a document to locate the exact character and line where changes occur, these utilities streamline routine content workflows.',
    'key_workflows' =>
    array (
      0 => 'Transforming variable names and prose across camelCase, snake_case, kebab-case, and Title Case.',
      1 => 'Analyzing word, character, line, and sentence metrics for articles, social posts, and editorial drafts.',
      2 => 'Comparing two text fragments to locate the exact character and line where differences first occur.',
      3 => 'Alphabetizing and deduplicating list items, log lines, and CSV values.',
      4 => 'Converting article titles into clean, URL-safe SEO slugs with diacritic normalization.',
      5 => 'Generating standard Lorem Ipsum placeholder paragraphs for design mockups and wireframes.',
    ),
    'limitations' => 'Text tools execute locally in JavaScript. Very large documents exceeding hundreds of thousands of lines should be processed using dedicated terminal or stream-processing tools.',
  ),
  'image-tools' =>
  array (
    'slug' => 'image-tools',
    'name' => 'Image Tools',
    'category_key' => 'Image Tools',
    'icon' => 'IM',
    'tagline' => 'Lossless format conversion and multi-size favicon package generation in the browser.',
    'description' => 'Preparing graphical assets for websites and web applications requires fast format shifts and icon sizing. The Image Tools collection utilizes the HTML5 Canvas API in your browser to transform formats and generate multi-resolution icon assets instantly, without uploading your original media to remote cloud services.',
    'extended_description' => 'Convert PNG graphics to lighter JPGs with custom background flattening, switch JPGs to PNG format, or upload a square brand icon to generate all 6 standard favicon dimensions (16x16 up to 512x512) for web and mobile manifests.',
    'key_workflows' =>
    array (
      0 => 'Converting PNG graphics to lightweight JPG formats with automatic white background flattening.',
      1 => 'Converting JPG images into transparent-friendly PNG format directly in the browser.',
      2 => 'Generating standard 16x16, 32x32, 48x48, 180x180, 192x192, and 512x512 favicon PNGs from a single source icon.',
    ),
    'limitations' => 'Browser canvas processing depends on device memory. Extremely high-resolution image files (e.g. 50+ megapixels) may be constrained by client browser canvas limits.',
  ),
  'security-tools' =>
  array (
    'slug' => 'security-tools',
    'name' => 'Security & Cryptography Tools',
    'category_key' => 'Security Tools',
    'icon' => 'SC',
    'tagline' => 'High-entropy random password generation and cryptographic text hashing.',
    'description' => 'Protecting accounts and validating data integrity starts with strong entropy and deterministic hashing. WebToolsStation Security Tools leverage the browser native Web Cryptography API (CSPRNG) to generate cryptographically random passwords and calculate SHA-256 cryptographic message digests locally.',
    'extended_description' => 'Generate strong credentials with customizable lengths and character sets, or compute cryptographic SHA-256 digests to verify checksums and integrity fingerprints without exposing raw plaintext to network transmission.',
    'key_workflows' =>
    array (
      0 => 'Generating high-entropy passwords with custom length constraints and optional special characters.',
      1 => 'Calculating SHA-256 cryptographic hashes for file verification, database keys, and lookup indexes.',
      2 => 'Evaluating password strength factors including character diversity, length, and predictability.',
    ),
    'limitations' => 'Browser-generated passwords and hashes run on the local machine. WebToolsStation never stores, transmits, or logs generated credentials. For enterprise secrets management, always store generated passwords in an encrypted password manager.',
  ),
  'pdf-tools' =>
  array (
    'slug' => 'pdf-tools',
    'name' => 'PDF Inspection Tools',
    'category_key' => 'PDF Tools',
    'icon' => 'PD',
    'tagline' => 'Browser-side PDF page counting, metadata inspection, keyword searching, and security auditing.',
    'description' => 'PDF documents often contain unseen document metadata, embedded form fields, JavaScript actions, or encryption markers that need inspection before sharing. Our PDF utilities use the Mozilla PDF.js engine running locally in your browser to inspect document properties, count pages, and search text layers without transmitting confidential documents across the internet.',
    'extended_description' => 'Inspect title, author, producer, and creation date metadata; verify whether a document has interactive forms or XFA layers; audit permissions; and perform fast keyword scans across the raw text stream of PDF files.',
    'key_workflows' =>
    array (
      0 => 'Counting total page volume and evaluating file byte size prior to email or portal transmission.',
      1 => 'Inspecting PDF Creator, Producer, Author, and Subject metadata fields.',
      2 => 'Auditing document permissions, interactive forms, XFA data, and embedded JavaScript actions.',
      3 => 'Searching visible raw text layers to verify document searchability.',
    ),
    'limitations' => 'PDF text search and page analysis operate on digital text layers. Scanned bitmap PDFs without OCR layers cannot be text-searched without prior optical character recognition processing.',
  ),
  'data-tools' =>
  array (
    'slug' => 'data-tools',
    'name' => 'Data Tools',
    'category_key' => 'Data Tools',
    'icon' => 'DT',
    'tagline' => 'Inspect, query, flatten, validate, and convert structured data formats directly in the browser.',
    'description' => 'Modern development involves handling nested JSON, CSV datasets, TOML configuration files, and line-delimited NDJSON logs. The Data Tools suite provides client-side parsers and visualizers that process multi-kilobyte data streams entirely inside your browser.',
    'extended_description' => 'Explore deep JSON hierarchies with interactive collapsible tree views, test JSONPath queries against complex objects, validate CSV RFC 4180 compliance, or convert between TOML, SQL, and JSON with zero server latency.',
    'key_workflows' =>
    array (
      0 => 'Inspecting and expanding deeply nested JSON payloads in an interactive visual tree.',
      1 => 'Querying and extracting node arrays using JSONPath expressions.',
      2 => 'Flattening nested objects into dot-notation keys for spreadsheet and database ingestion.',
      3 => 'Auditing CSV files for unclosed quotes, irregular column counts, and syntax errors.',
      4 => 'Generating SQL CREATE TABLE and batch INSERT statements from CSV data.',
      5 => 'Formatting and validating TOML and JSONL / NDJSON streams.',
    ),
    'limitations' => 'All operations run in client memory. Files exceeding tens of megabytes may be limited by available browser RAM.',
  ),
  'encode-decode' =>
  array (
    'slug' => 'encode-decode',
    'name' => 'Encode & Decode Tools',
    'category_key' => 'Encode & Decode',
    'icon' => 'ED',
    'tagline' => 'Transform strings across Base32, Base58, Base85, Hex, ASCII, ROT13, Morse code, and Data URIs.',
    'description' => 'Encoding utilities are essential for translating binary data into transmission-safe text formats and decoding protocol tokens.',
    'extended_description' => 'Convert text across cryptographic Base58, 2FA Base32, Ascii85, hexadecimal byte streams, Morse code, and Data URIs entirely inside your browser.',
    'key_workflows' =>
    array (
      0 => 'Encoding and decoding Base32 tokens for two-factor authentication (TOTP/HOTP).',
      1 => 'Converting crypto addresses and IPFS hashes with Base58.',
      2 => 'Translating strings to hexadecimal byte representations and ASCII tables.',
      3 => 'Generating inline Data URIs for embedding assets in CSS and HTML.',
    ),
    'limitations' => 'Client-side encoding handles standard UTF-8 and binary strings in memory.',
  ),
  'seo-tools' =>
  array (
    'slug' => 'seo-tools',
    'name' => 'SEO Tools',
    'category_key' => 'SEO Tools',
    'icon' => 'SO',
    'tagline' => 'Generate meta tags, Open Graph cards, robots.txt directives, and Google rich-snippet JSON-LD schemas.',
    'description' => 'Search engine optimization starts with clean metadata, valid structured markup, and crawl directive files. Our SEO Tools help webmasters, developers, and marketers build and validate technical SEO assets locally.',
    'extended_description' => 'Simulate Google desktop and mobile search snippets in real time, generate BreadcrumbList and FAQPage schemas, build robots.txt rules, and audit meta descriptions.',
    'key_workflows' =>
    array (
      0 => 'Generating complete Open Graph and Twitter Card social preview tags.',
      1 => 'Simulating SERP snippets with pixel-width truncation rules.',
      2 => 'Building and testing robots.txt crawl directives against URL paths.',
      3 => 'Creating Google-compliant JSON-LD structured data for rich search results.',
    ),
    'limitations' => 'Tools generate standard W3C and Schema.org markup. Live search engine ranking performance depends on broader domain authority and search algorithms.',
  ),
  'web-tools' =>
  array (
    'slug' => 'web-tools',
    'name' => 'Web Tools',
    'category_key' => 'Web Tools',
    'icon' => 'WB',
    'tagline' => 'Build UTM campaigns, clean URLs, parse cookies, audit HTTP status codes, and configure CORS headers.',
    'description' => 'Web developers and digital marketers frequently work with HTTP headers, tracking parameters, and browser runtime properties. These browser utilities streamline web protocol workflows without third-party tracking.',
    'extended_description' => 'Construct UTM tracking links, normalize dirty URLs, parse Set-Cookie directives, and look up authoritative RFC HTTP status definitions.',
    'key_workflows' =>
    array (
      0 => 'Generating clean marketing URLs with standard UTM parameter tags.',
      1 => 'Auditing and extracting attributes from complex Set-Cookie response headers.',
      2 => 'Looking up HTTP 1xx-5xx status codes, specs, and browser behaviors.',
      3 => 'Creating Cross-Origin Resource Sharing (CORS) server header configs.',
    ),
    'limitations' => 'Client-side web utilities operate on provided header strings and URLs without making unauthenticated outbound network requests.',
  ),
  'color-tools' =>
  array (
    'slug' => 'color-tools',
    'name' => 'Color & Palette Tools',
    'category_key' => 'Color Tools',
    'icon' => 'CL',
    'tagline' => 'Convert color formats, generate harmonic palettes, test WCAG accessibility contrast, and create CSS gradients.',
    'description' => 'Designers and frontend engineers require precision color transformation and accessibility validation. Our Color Tools suite calculates exact color conversions and WCAG 2.1 compliance ratios.',
    'extended_description' => 'Translate colors across HEX, RGB, and HSL; generate complementary and triadic harmonies; check contrast ratios against AA/AAA standards; and design multi-stop CSS gradients.',
    'key_workflows' =>
    array (
      0 => 'Calculating WCAG 2.1 contrast ratios for text and background color combinations.',
      1 => 'Converting color codes between HEX, RGB, and HSL spaces.',
      2 => 'Generating harmonic color palettes and 10-step shade/tint variations.',
      3 => 'Building cross-browser CSS linear and radial gradient rules.',
    ),
    'limitations' => 'Color conversions use standard sRGB color space mathematics.',
  ),
  'calculators' =>
  array (
    'slug' => 'calculators',
    'name' => 'Calculators & Units',
    'category_key' => 'Calculators',
    'icon' => 'CC',
    'tagline' => 'Compute percentages, aspect ratios, date differences, file transfer speeds, and storage units.',
    'description' => 'Everyday mathematical and engineering conversions require instant, accurate results. Our calculators operate entirely in browser memory with zero ads or tracking scripts.',
    'extended_description' => 'Calculate percentage increases and margins, scale 16:9 and 4:3 screen resolutions, find elapsed business days between dates, and convert data storage units.',
    'key_workflows' =>
    array (
      0 => 'Calculating percentages, discounts, and percentage changes.',
      1 => 'Computing dimensions and scaling coordinates across standard aspect ratios.',
      2 => 'Calculating exact calendar and business days between two dates.',
      3 => 'Converting data storage units across decimal (1000) and binary (1024) bases.',
    ),
    'limitations' => 'Calculations use standard IEEE 754 floating-point arithmetic.',
  ),
  'ai-developer-tools' =>
  array (
    'slug' => 'ai-developer-tools',
    'name' => 'AI Developer Utilities',
    'category_key' => 'AI Developer Tools',
    'icon' => 'AI',
    'tagline' => 'Estimate BPE token counts, validate fine-tuning JSONL datasets, diff prompts, and generate llms.txt files.',
    'description' => 'Building LLM applications requires deterministic client-side utilities for prompt engineering, token budgeting, dataset validation, and RAG chunk optimization.',
    'extended_description' => 'Estimate token counts for GPT-4, Claude, and Llama; validate OpenAI-format fine-tuning JSONL files; compare prompt versions; and build standard /llms.txt files.',
    'key_workflows' =>
    array (
      0 => 'Estimating BPE token usage for prompts and system instructions.',
      1 => 'Validating chat completion JSONL datasets prior to fine-tuning jobs.',
      2 => 'Comparing two prompt drafts with side-by-side token difference highlights.',
      3 => 'Computing chunk sizes and vector storage footprints for RAG pipelines.',
    ),
    'limitations' => 'Token counts are computed using client-side BPE tokenizer heuristics. Exact provider token billing is determined by upstream model APIs.',
  ),
);
