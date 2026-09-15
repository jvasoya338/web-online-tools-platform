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
);
