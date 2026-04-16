<?php

return [
    'json-formatter' => [
        'common_mistakes' => [
            'Pasting JavaScript object syntax with single quotes or trailing commas and expecting strict JSON parsing to accept it.',
            'Formatting only one nested fragment when the real problem is a missing brace earlier in the payload.',
            'Assuming a payload is correct because it looks indented nicely even though a property value is still wrong for the API.',
        ],
        'better_alternative' => [
            'Use a schema validator or API contract test when you need to confirm the meaning of fields, not just the syntax.',
            'Move into a full editor or test client when you are reviewing very large payloads with many nested objects.',
            'If the data contains production secrets or regulated information, review it inside your approved internal tooling.',
        ],
        'output_notes' => [
            'Beautified output helps you review structure quickly, while minified output is better for compact transport and embedding.',
            'A parse error means the JSON is syntactically invalid, not necessarily that the surrounding business logic is wrong.',
            'If formatting succeeds, the output is valid JSON syntax and can usually be copied directly into documentation, fixtures, or requests.',
        ],
    ],
    'jwt-decoder' => [
        'common_mistakes' => [
            'Treating a decoded token as verified when the tool only reveals the visible header and payload.',
            'Reading the expiry value without converting the timestamp carefully into the correct time zone.',
            'Ignoring audience and issuer claims and focusing only on the user ID or role fields.',
        ],
        'better_alternative' => [
            'Use your backend verification flow when you need to prove the signature, key, or issuer is trusted.',
            'Inspect auth middleware or identity-provider logs when the payload looks right but access still fails.',
            'Use a full security review process for sensitive production tokens instead of relying on a browser decode alone.',
        ],
        'output_notes' => [
            'The decoded header helps you see the algorithm and token type, while the payload reveals human-readable claims.',
            'If the tool cannot parse the token, the string is usually malformed or incomplete rather than merely expired.',
            'A readable payload is useful for debugging, but the final trust decision must still come from real verification.',
        ],
    ],
    'timestamp-converter' => [
        'common_mistakes' => [
            'Using a milliseconds value where the source system expects seconds, which shifts the date dramatically.',
            'Comparing browser-local time to a server log timestamp without also checking UTC.',
            'Assuming every system stores Unix time the same way without reading the integration docs.',
        ],
        'better_alternative' => [
            'Use your application logs or framework helpers when the issue involves scheduled jobs, daylight-saving rules, or locale-specific formatting.',
            'Reach for a date library or spreadsheet when you need batch conversion instead of one-off checks.',
            'Use database queries directly if you need to compare large sets of stored timestamps at once.',
        ],
        'output_notes' => [
            'The tool shows both local and UTC interpretations so you can compare them before making a support or debugging decision.',
            'A valid numeric conversion does not tell you whether the original event timing was recorded correctly by the source system.',
            'If the output looks far in the past or future, the first thing to question is usually the seconds-vs-milliseconds assumption.',
        ],
    ],
    'regex-tester' => [
        'common_mistakes' => [
            'Testing only one perfect example and missing the messy real inputs that appear in production.',
            'Forgetting a flag such as `i` or `m`, then assuming the pattern itself is broken.',
            'Writing a pattern that matches too broadly and only noticing after reviewing the full match list.',
        ],
        'better_alternative' => [
            'Use unit tests in your codebase when a pattern affects authentication, validation, or data cleanup in production.',
            'Reach for parser logic instead of regex when the input has real nested structure such as HTML, JSON, or XML.',
            'Use a debugger or profiling approach when the issue is regex performance rather than correctness.',
        ],
        'output_notes' => [
            'The match count gives you a quick high-level check, but the individual match list is what reveals overmatching or missed cases.',
            'If a pattern compiles but produces no matches, check both the flags and the test text before rewriting everything.',
            'A working result here is a strong first-pass signal, not a substitute for real-world validation across varied input.',
        ],
    ],
    'color-converter' => [
        'common_mistakes' => [
            'Mixing shorthand and full HEX values without checking whether the final shade is still the one you intended.',
            'Confusing conversion accuracy with accessibility quality, contrast, or branding approval.',
            'Using one color format in a tool that expects another, then assuming the design token itself is wrong.',
        ],
        'better_alternative' => [
            'Use a full contrast checker when the real question is readability or accessibility compliance.',
            'Use your design system source of truth when you need official brand values rather than quick conversion.',
            'Move into a design app or browser inspector when you need visual comparison across many colors at once.',
        ],
        'output_notes' => [
            'Matching HEX, RGB, and HSL values confirm that the representation changed, not the underlying color itself.',
            'The preview gives you a quick visual sanity check, especially when the input came from a copied code snippet or design note.',
            'If a downstream tool still renders the color differently, the issue is often opacity, color management, or another style layer.',
        ],
    ],
    'word-counter' => [
        'common_mistakes' => [
            'Assuming word count alone measures readability, clarity, or whether the text is ready to publish.',
            'Pasting text with hidden line breaks or unusual spacing and treating the character total as final without review.',
            'Comparing counts across tools that define sentences and line breaks slightly differently.',
        ],
        'better_alternative' => [
            'Use your CMS preview or editorial workflow when the issue is how the copy actually looks in the final layout.',
            'Use grammar or readability tools when you need writing quality feedback rather than simple totals.',
            'Move to a spreadsheet or script if you need to count many entries in bulk instead of one article or field at a time.',
        ],
        'output_notes' => [
            'Word, character, and line totals are most useful as planning and limit-checking signals rather than quality judgments.',
            'Sentence counts are approximate, so they help with quick review but may differ from a formal editorial system.',
            'The output is strongest when you pair it with a manual read of the text you are about to publish or submit.',
        ],
    ],
    'password-generator' => [
        'common_mistakes' => [
            'Generating a strong password and then storing it in an unsafe note, screenshot, or chat message.',
            'Using symbols in a system that silently rejects them and then blaming the generator for a login failure.',
            'Treating one generated password as reusable across many unrelated accounts.',
        ],
        'better_alternative' => [
            'Use a password manager workflow when the real challenge is storage, sharing, and rotation rather than generation.',
            'Use organization-approved access tooling when credentials must be rotated, shared, or audited by a team.',
            'Use passphrases or policy-specific enterprise tooling when your environment has strict password-format rules.',
        ],
        'output_notes' => [
            'A generated password is valuable only if it is unique to one account and stored safely right away.',
            'Longer output usually improves security more than cosmetic complexity alone, assuming the target system supports it.',
            'If login fails after using the generated value, check copy accuracy and allowed symbol rules before regenerating.',
        ],
    ],
    'slug-generator' => [
        'common_mistakes' => [
            'Keeping every word from a long title and ending up with a slug that is technically valid but hard to scan.',
            'Assuming automatic cleanup should replace human editorial judgment for important public URLs.',
            'Using one slug style on the site while another tool or CMS uses different normalization rules.',
        ],
        'better_alternative' => [
            'Use your CMS slug preview if it automatically applies routing, uniqueness, or transliteration rules after saving.',
            'Edit the final slug manually when the page is important enough that wording and search intent need a human pass.',
            'Use a spreadsheet or content-ops workflow if you need to normalize many slugs at once across a large site.',
        ],
        'output_notes' => [
            'The generated slug is a clean first draft designed to remove clutter, not necessarily the final editorial choice.',
            'If accents or punctuation disappear, that is usually normal normalization rather than data loss.',
            'The best output is short, readable, and closely aligned with what the page is genuinely about.',
        ],
    ],
    'csv-to-json-converter' => [
        'common_mistakes' => [
            'Converting a messy CSV export without checking headers, empty values, or inconsistent rows first.',
            'Treating the first output as production-ready JSON when the source spreadsheet still needs cleanup.',
            'Ignoring quoted fields and assuming every comma always marks a new column.',
        ],
        'better_alternative' => [
            'Use a spreadsheet, script, or ETL workflow when the file is large, messy, or part of a repeatable import process.',
            'Validate the resulting schema in your codebase if the JSON will feed an API or stored fixture set.',
            'Use dedicated data tooling when you need transforms, deduplication, or field mapping beyond a quick conversion.',
        ],
        'output_notes' => [
            'The output is most useful as a quick structure check to see whether headers and rows become the JSON shape you expected.',
            'If one record looks off, inspect the source CSV row before assuming the converter is wrong.',
            'JSON output can be copied into mocks or docs quickly, but production data usually benefits from a second validation step.',
        ],
    ],
    'url-parser' => [
        'common_mistakes' => [
            'Pasting a partial path without a protocol and expecting the browser URL parser to infer the rest safely.',
            'Looking only at the full `href` and missing that the real bug lives in a query parameter or fragment.',
            'Assuming a parsed URL is valid for business logic simply because the browser can read its parts.',
        ],
        'better_alternative' => [
            'Use application routing logs or network inspection when the problem involves redirects, rewrites, or server-side handling.',
            'Use code-level URL helpers when you need to generate or compare many URLs programmatically.',
            'Reach for a security review process when the question is whether a URL is safe, allowed, or trustworthy rather than structurally correct.',
        ],
        'output_notes' => [
            'The parsed output helps separate origin, path, query, and fragment so you can debug one layer at a time.',
            'If the query object looks correct but the link still breaks, the issue is usually in downstream logic rather than syntax.',
            'A clean parse result is strongest as a debugging aid, not as a complete validation of the destination.',
        ],
    ],
    'pdf-metadata-viewer' => [
        'common_mistakes' => [
            'Treating missing metadata as proof that a file is harmless or unimportant.',
            'Assuming the title or author fields are always trustworthy when many PDFs are exported with incomplete values.',
            'Confusing document properties with a full audit of the file contents.',
        ],
        'better_alternative' => [
            'Open the document in a full PDF workflow when you need deeper inspection, redaction review, or archival verification.',
            'Use organization-approved document handling tools when a file involves legal, financial, or regulated material.',
            'Move into security review tooling if the concern is active content or full document safety rather than metadata only.',
        ],
        'output_notes' => [
            'Metadata fields provide useful clues about origin, export tooling, and context, but they are not guaranteed facts.',
            'A blank or partial metadata result usually means the document was exported minimally, not necessarily that parsing failed.',
            'The output is best used as a first-pass signal before deeper manual or organizational review.',
        ],
    ],
    'pdf-text-finder' => [
        'common_mistakes' => [
            'Expecting scanned-image PDFs to behave like text-based PDFs without OCR.',
            'Treating one missing keyword as proof the file does not contain the concept anywhere on the page visually.',
            'Ignoring that extracted text can differ from how the PDF looks when rendered to the eye.',
        ],
        'better_alternative' => [
            'Use OCR or a full PDF editor when the file is primarily image-based and you need reliable search.',
            'Open the document manually when context matters more than raw match count.',
            'Use enterprise document search tooling when the task involves many PDFs or compliance-sensitive review.',
        ],
        'output_notes' => [
            'A positive match is useful for quick confirmation that the extracted text contains the phrase somewhere in the document.',
            'A zero-match result can still happen on real PDFs if the text layer is missing, fragmented, or encoded oddly.',
            'The output works best as a fast screening step before a human review of important documents.',
        ],
    ],
];
