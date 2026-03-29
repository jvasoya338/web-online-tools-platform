<?php

return [
    'json-formatter' => [
        'use_steps' => [
            'Paste the full JSON payload exactly as you received it so the parser can validate the structure.',
            'Use the format action when you need readable indentation, or minify when you need compact output for transport.',
            'If the parser fails, fix the line with missing commas, quotes, or braces before copying the result elsewhere.',
        ],
        'use_cases' => [
            'Checking API request and response bodies before adding them to docs or test fixtures.',
            'Cleaning copied configuration blocks so nested keys and arrays are easier to review.',
            'Minifying valid payloads before sending them through systems that expect compressed JSON text.',
        ],
        'watch_out_for' => [
            'Single quotes, trailing commas, and half-copied payloads are the most common reasons formatting fails.',
            'Formatting improves readability, but it does not tell you whether the business data itself is correct.',
            'If the JSON contains secrets, tokens, or personal information, review it locally and avoid sharing screenshots.',
        ],
        'example_title' => 'Example workflow',
        'example_body' => 'A developer can paste a failed API response, format it, spot that a nested array is missing a comma, correct the payload, and then resend the request with much less guesswork.',
        'privacy_note' => 'JSON formatting runs in the browser, so the payload stays on your device unless you choose to copy or share it.',
    ],
    'base64-encode-decode' => [
        'use_steps' => [
            'Paste the plain text or Base64 value you want to inspect into the input field.',
            'Choose encode when you need a text-safe representation, or decode when you need to read the original content.',
            'Review the output carefully before using it in an API, email template, token sample, or embedded data URI.',
        ],
        'use_cases' => [
            'Inspecting encoded strings in API payloads, email headers, or browser storage values.',
            'Encoding short text values that need to move through systems expecting plain text characters only.',
            'Quickly checking whether an unfamiliar string is simple Base64 or something more complex.',
        ],
        'watch_out_for' => [
            'Base64 is not encryption, so decoded content should never be treated as secure by default.',
            'Broken or partially copied values often decode into unreadable output or error messages.',
            'Large binary files are not the best fit for a lightweight browser text tool like this.',
        ],
        'example_title' => 'Example workflow',
        'example_body' => 'If an API response contains a Base64-looking string, you can decode it immediately to confirm whether it is plain text, JSON, or an expected data fragment before debugging deeper.',
        'privacy_note' => 'Encoding and decoding happen in the browser, which is useful when you want to inspect small values without sending them to a server.',
    ],
    'url-encode-decode' => [
        'use_steps' => [
            'Paste the raw text or encoded fragment you need to work with, including spaces or symbols if relevant.',
            'Use encode when preparing query parameters or form values, and decode when reading already-escaped text.',
            'Copy the output only after checking that reserved characters changed the way you expected.',
        ],
        'use_cases' => [
            'Preparing search queries, redirect URLs, and callback parameters for frontend or backend work.',
            'Reading incoming query strings during debugging when values arrive percent-encoded.',
            'Checking whether a copied marketing link or redirect path was encoded correctly before publishing.',
        ],
        'watch_out_for' => [
            'Encoding the full URL and encoding only one parameter are different tasks, so make sure you choose the right input scope.',
            'Double-encoding can create broken links that look valid at first glance.',
            'Decoding malformed input will fail, which usually means the source string was copied incorrectly.',
        ],
        'example_title' => 'Example workflow',
        'example_body' => 'A marketer can encode a campaign value with spaces and symbols before adding it to a tracking link, then decode the final URL later to verify nothing was mangled.',
        'privacy_note' => 'URL encoding is handled client-side, which makes it convenient for checking sensitive callback parameters locally.',
    ],
    'jwt-decoder' => [
        'use_steps' => [
            'Paste the full token with its dot-separated parts so the header and payload can be read together.',
            'Review claims like issuer, audience, subject, and expiry to see whether the token matches the expected flow.',
            'Use the decoded output for debugging only, then move to proper signature verification in your backend or auth layer.',
        ],
        'use_cases' => [
            'Checking why a user session expired unexpectedly during login or API testing.',
            'Reviewing issued claims during SSO, OAuth, or custom authentication integration work.',
            'Comparing two tokens to confirm whether roles, scopes, or tenant values changed between environments.',
        ],
        'watch_out_for' => [
            'Decoding is not the same as verifying, so a readable token is not automatically trustworthy.',
            'JWT payloads sometimes contain user identifiers or internal claims that should not be shared broadly.',
            'Clock drift, wrong audience values, or missing scopes are common causes of auth confusion even when the token structure is valid.',
        ],
        'example_title' => 'Example workflow',
        'example_body' => 'When an API keeps returning unauthorized, a developer can decode the JWT, see that the `aud` claim points to the wrong service, and fix the token issuer configuration instead of guessing.',
        'privacy_note' => 'The decoder reads the token in your browser so you can inspect claims quickly without sending them to another service.',
    ],
    'timestamp-converter' => [
        'use_steps' => [
            'Enter either a Unix timestamp or a human-readable date depending on the direction you need.',
            'Use the conversion that matches your workflow, then compare the local and UTC outputs before relying on the result.',
            'If the time looks wrong, double-check whether the source system uses seconds or milliseconds.',
        ],
        'use_cases' => [
            'Reading timestamps in logs, API responses, and analytics exports.',
            'Preparing test data for scheduled jobs, expiry values, or signed URLs.',
            'Checking how one moment appears in both local time and UTC during debugging.',
        ],
        'watch_out_for' => [
            'Milliseconds and seconds are easy to confuse, and that creates huge date offsets.',
            'Displayed local time depends on the current browser time zone, so compare with UTC when accuracy matters.',
            'The tool helps with conversion, but not with daylight-saving or business-rule decisions made by your application.',
        ],
        'example_title' => 'Example workflow',
        'example_body' => 'A backend developer can paste `1711766400`, confirm it matches the expected UTC date, and then compare the browser-local display to explain why a support screenshot looked different.',
        'privacy_note' => 'Timestamp conversion is browser-side and does not need to send your dates or log values anywhere else.',
    ],
    'uuid-generator' => [
        'use_steps' => [
            'Choose how many UUIDs you need for the current task, then generate the list in one click.',
            'Review the output count before copying if you are creating seed data, fixtures, or test records in bulk.',
            'Paste the generated values directly into your scripts, spreadsheets, or admin tools as needed.',
        ],
        'use_cases' => [
            'Creating IDs for seed scripts, test fixtures, and local database records.',
            'Generating placeholder identifiers for API examples and documentation.',
            'Preparing unique values for spreadsheet imports or temporary support workflows.',
        ],
        'watch_out_for' => [
            'Generated UUIDs are random identifiers, not meaningful business keys.',
            'If a system requires a specific UUID version or format, verify that it accepts UUID v4.',
            'Bulk generation is convenient, but you should still avoid pasting test IDs into live production records by mistake.',
        ],
        'example_title' => 'Example workflow',
        'example_body' => 'During QA, a tester can generate five UUIDs for a CSV import template instead of inventing fake identifiers by hand and risking duplicates.',
        'privacy_note' => 'UUID generation happens locally in the browser using the Web Crypto API.',
    ],
    'sha256-hash-generator' => [
        'use_steps' => [
            'Paste the exact text you want to hash, keeping spaces and line breaks if they matter for the comparison.',
            'Generate the hash once, then compare the hexadecimal output with the expected value from your system.',
            'Repeat the same input carefully if you are troubleshooting mismatches, because tiny text changes create completely different hashes.',
        ],
        'use_cases' => [
            'Checking whether two strings produce the same digest during development.',
            'Creating quick hash examples for docs, scripts, or classroom demonstrations.',
            'Verifying that a copied value was preserved exactly before a later signature or checksum step.',
        ],
        'watch_out_for' => [
            'Hashing is one-way, so this tool cannot recover the original text from a digest.',
            'Whitespace, newline style, and hidden characters can change the result dramatically.',
            'A SHA-256 hash alone is not a password-storage strategy unless it is part of a proper security design.',
        ],
        'example_title' => 'Example workflow',
        'example_body' => 'If two systems disagree on a checksum, you can hash the same text in both places and confirm whether the mismatch is caused by hidden whitespace or a real content change.',
        'privacy_note' => 'Hash generation runs inside the browser, which helps when you want to inspect short values without uploading them.',
    ],
    'regex-tester' => [
        'use_steps' => [
            'Enter the pattern you want to test, then add flags such as `g`, `i`, or `m` if the search needs them.',
            'Paste realistic sample text rather than only the perfect example, so the matches reflect real input.',
            'Review both the match count and the individual results before trusting the expression in code or content cleanup work.',
        ],
        'use_cases' => [
            'Testing validation patterns for emails, IDs, slugs, or log messages.',
            'Trying cleanup expressions before using them in scripts, editors, or CMS tools.',
            'Teaching teammates or clients why a pattern is matching too much or too little.',
        ],
        'watch_out_for' => [
            'A regex that works on one sample may still fail on realistic edge cases, so test more than one input.',
            'Flags change behavior significantly, especially for case sensitivity and global matching.',
            'Very broad expressions can produce false positives that look correct until you inspect the match list.',
        ],
        'example_title' => 'Example workflow',
        'example_body' => 'Before adding a validation pattern to a signup form, a developer can test it against valid and invalid addresses here and see exactly which examples are overmatching.',
        'privacy_note' => 'Pattern testing stays in the browser, which is useful when your sample text includes internal docs or copied logs.',
    ],
    'text-case-converter' => [
        'use_steps' => [
            'Paste the source text exactly as you have it, whether it comes from content, code naming, or spreadsheet labels.',
            'Choose the naming style you need, such as title case for headings or snake_case for variables.',
            'Review the converted result before copying if acronyms, brand names, or mixed punctuation matter in the final output.',
        ],
        'use_cases' => [
            'Renaming headings, labels, or variable names during content and development work.',
            'Turning human-readable phrases into camelCase, snake_case, or kebab-case quickly.',
            'Cleaning imported lists that need consistent capitalization before publishing.',
        ],
        'watch_out_for' => [
            'Automatic case conversion is helpful, but brand names and acronyms may still need manual cleanup.',
            'Messy input with unusual separators can create output that needs a final review.',
            'Title case rules vary by style guide, so editorial teams may still want a human pass.',
        ],
        'example_title' => 'Example workflow',
        'example_body' => 'A content editor can paste a page title, generate a slug-safe kebab case version, and also create a title-cased heading without rewriting the same phrase multiple times.',
        'privacy_note' => 'Text case conversion is local to the browser and works well for quick cleanup tasks without a server round trip.',
    ],
    'color-converter' => [
        'use_steps' => [
            'Paste a valid CSS color value such as HEX, RGB, or a named color into the field.',
            'Run the converter to inspect the equivalent HEX, RGB, and HSL values together with the visual preview.',
            'Use the output format your target tool expects, then copy only the value you need into CSS, design notes, or documentation.',
        ],
        'use_cases' => [
            'Switching between design handoff values and frontend implementation formats.',
            'Verifying whether two differently written colors are actually the same shade.',
            'Checking a quick HSL or RGB representation before adjusting a component style.',
        ],
        'watch_out_for' => [
            'The converter helps with representation, but not with accessibility contrast or full design validation.',
            'Named colors may resolve differently than expected if you meant a brand-specific custom value.',
            'When exact brand consistency matters, compare against the source design system after conversion.',
        ],
        'example_title' => 'Example workflow',
        'example_body' => 'If a design file gives you `rgb(194,65,12)` but your stylesheet prefers HEX, you can convert it instantly and check the swatch before updating the component token.',
        'privacy_note' => 'Color conversion is entirely client-side and is well suited to fast frontend or design checks.',
    ],
    'hex-to-rgb-converter' => [
        'use_steps' => [
            'Paste a three-digit or six-digit HEX color into the input field.',
            'Run the conversion to get the matching RGB value that browsers and design tools can read numerically.',
            'Copy the RGB output into your CSS, JS, or design settings once you have confirmed the source HEX was correct.',
        ],
        'use_cases' => [
            'Turning design-system HEX tokens into RGB values for CSS filters or canvas work.',
            'Checking a brand color received from a style guide before using it in another format.',
            'Helping non-developers understand the numeric channels behind a chosen color.',
        ],
        'watch_out_for' => [
            'Invalid HEX length or stray characters are a common cause of failed conversions.',
            'RGB output is exact, but it still needs the right context if your final target expects alpha or HSL.',
            'Shorthand HEX should be reviewed carefully if precision matters across multiple tools.',
        ],
        'example_title' => 'Example workflow',
        'example_body' => 'A teammate can paste `#ff7a18`, convert it to RGB, and use the numeric channels in a charting library that does not accept HEX directly.',
        'privacy_note' => 'This conversion happens in the browser and is meant for quick design or frontend reference work.',
    ],
    'rgb-to-hex-converter' => [
        'use_steps' => [
            'Enter red, green, and blue values between 0 and 255 in the three number fields.',
            'Generate the HEX value once the channel values match the color you want to use.',
            'Copy the HEX output into CSS variables, design specs, or style tokens after checking that each channel was entered correctly.',
        ],
        'use_cases' => [
            'Converting browser-inspector RGB readings into HEX for a stylesheet or design token file.',
            'Turning programmatic color values into a format that is easier to share in docs and handoff.',
            'Recreating a color from chart or canvas code in a more familiar CSS shorthand.',
        ],
        'watch_out_for' => [
            'Values outside 0 to 255 are not valid RGB channels and will create incorrect output.',
            'This tool converts only opaque RGB values, not RGBA with transparency.',
            'If two tools render colors differently, check profiles or opacity settings rather than only the HEX result.',
        ],
        'example_title' => 'Example workflow',
        'example_body' => 'A frontend developer can inspect a UI element, note the RGB channels from DevTools, and convert them into a clean HEX token for the shared design system.',
        'privacy_note' => 'RGB to HEX conversion is local and fast, making it useful for everyday interface cleanup.',
    ],
    'favicon-generator' => [
        'use_steps' => [
            'Upload a square source image with enough resolution to look sharp at small icon sizes.',
            'Generate the favicon set, then download the exact sizes your website or app needs.',
            'Preview the files in context before publishing so the icon remains recognizable at 16px and 32px.',
        ],
        'use_cases' => [
            'Preparing browser tab icons from a startup or product logo.',
            'Creating a quick favicon set for a landing page, side project, or internal tool.',
            'Checking whether one master icon works across common website and app icon sizes.',
        ],
        'watch_out_for' => [
            'Detailed logos often become unreadable at very small sizes, so simple shapes work better.',
            'A non-square upload can crop awkwardly or feel off-center in the final outputs.',
            'This generator creates PNG sizes, but you may still want a separate `.ico` asset for some deployments.',
        ],
        'example_title' => 'Example workflow',
        'example_body' => 'A founder can upload one clean square mark, export the standard PNG favicon sizes, and then wire them into a site without opening a design app for every dimension.',
        'privacy_note' => 'Image resizing happens in the browser and the uploaded logo is not sent through a backend conversion service.',
    ],
    'word-counter' => [
        'use_steps' => [
            'Paste the full text block you want to measure, including line breaks if they matter for the task.',
            'Run the count to review words, characters, lines, and sentences together.',
            'Use the numbers to guide editing, estimate reading size, or compare version changes before publishing.',
        ],
        'use_cases' => [
            'Checking article drafts, assignment responses, and product descriptions against limits.',
            'Measuring short-form text before sending it into forms, CMS fields, or ad systems.',
            'Comparing edited copy versions to see whether a revision actually shortened the text.',
        ],
        'watch_out_for' => [
            'Sentence counts are heuristic and may not match formal linguistic rules in every case.',
            'Pasted rich text from other apps can include hidden spacing that affects character totals.',
            'Word count is useful for planning, but it does not measure clarity or quality by itself.',
        ],
        'example_title' => 'Example workflow',
        'example_body' => 'An editor can paste a draft intro, confirm it fits a 150-word briefing target, and then trim characters further for a field with a strict limit.',
        'privacy_note' => 'Text counting runs locally in the browser, which is convenient when you are checking draft copy before publication.',
    ],
    'password-generator' => [
        'use_steps' => [
            'Choose the password length and decide whether the target system allows symbols.',
            'Generate the password, then copy it directly into your password manager or account setup form.',
            'Store the final value safely instead of trying to memorize a one-off complex string.',
        ],
        'use_cases' => [
            'Creating stronger credentials for new accounts, admin tools, and team access points.',
            'Replacing reused passwords with unique values during a security cleanup pass.',
            'Generating temporary passwords for internal environments before handing them off securely.',
        ],
        'watch_out_for' => [
            'A strong password still needs safe storage, so pair this with a reliable password manager when possible.',
            'Some systems reject certain symbols, which means you may need to regenerate with a simpler character set.',
            'Avoid pasting generated passwords into documents, chats, or screenshots that linger after the setup step.',
        ],
        'example_title' => 'Example workflow',
        'example_body' => 'During account setup, a user can generate a 20-character password with symbols, save it immediately to a password manager, and avoid the usual temptation to reuse an older weak password.',
        'privacy_note' => 'Password generation uses browser crypto locally so the created value is not posted to the server by this tool.',
    ],
    'slug-generator' => [
        'use_steps' => [
            'Paste the page title, article heading, or phrase you want to turn into a clean URL slug.',
            'Generate the slug and review the output for clarity, length, and any words you would remove manually.',
            'Use the result as a starting point for your URL, route name, or content-management field.',
        ],
        'use_cases' => [
            'Creating cleaner blog post and product URLs without hand-editing punctuation.',
            'Standardizing slugs across a team so published links stay readable and consistent.',
            'Quickly checking how accents and separators will normalize before a page goes live.',
        ],
        'watch_out_for' => [
            'Automatic slug cleanup removes clutter, but editorial judgment still matters for final wording.',
            'Very long titles may create slugs that are technically valid but harder to scan.',
            'If your CMS has its own slug rules, compare the output before publishing at scale.',
        ],
        'example_title' => 'Example workflow',
        'example_body' => 'A content manager can paste a long article title, generate a clean slug, shorten one or two extra words, and publish a more readable URL in seconds.',
        'privacy_note' => 'Slug generation is browser-side and useful for quick publishing tasks without server processing.',
    ],
    'html-entity-encode-decode' => [
        'use_steps' => [
            'Paste the text or HTML entities you want to convert into the main input area.',
            'Choose encode when you need safe HTML character output, or decode when you need readable plain text.',
            'Review the result in context before publishing it into templates, CMS fields, or documentation.',
        ],
        'use_cases' => [
            'Escaping special characters before adding snippets to HTML or documentation.',
            'Reading copied entity-heavy strings from CMS output or old content exports.',
            'Checking whether a text fragment was double-escaped during content processing.',
        ],
        'watch_out_for' => [
            'Encoding characters does not sanitize unsafe HTML in a full security sense.',
            'Double encoding and double decoding can create confusing output if the source was already transformed.',
            'Template engines may apply their own escaping rules, so verify what your final system already does.',
        ],
        'example_title' => 'Example workflow',
        'example_body' => 'If a CMS export shows `&amp;` everywhere, you can decode the text, confirm the original copy is still intact, and then decide whether the issue is in export formatting or storage.',
        'privacy_note' => 'Entity conversion runs in the browser and is appropriate for quick text cleanup tasks.',
    ],
    'text-to-binary-converter' => [
        'use_steps' => [
            'Paste the text you want to translate into binary form, including non-ASCII characters if needed.',
            'Run the converter to generate the UTF-8 byte sequence as 8-bit groups.',
            'Copy the binary output for learning, demonstrations, or technical checks where the byte view matters.',
        ],
        'use_cases' => [
            'Teaching how text becomes bytes in simple encoding examples.',
            'Checking the binary representation of short strings during debugging or classroom demos.',
            'Comparing how punctuation, spaces, and Unicode characters expand into byte sequences.',
        ],
        'watch_out_for' => [
            'The output reflects UTF-8 bytes, so non-ASCII characters may use multiple 8-bit groups.',
            'This tool is useful for short text checks, not large file or protocol analysis.',
            'Binary output is easy to misread when spacing is removed, so keep the byte groups intact when copying.',
        ],
        'example_title' => 'Example workflow',
        'example_body' => 'A student can enter `Hi!` and immediately see how each character becomes bytes, then compare that with a non-English word to understand multi-byte UTF-8 behavior.',
        'privacy_note' => 'The conversion happens locally and is suitable for small text experiments or debugging.',
    ],
    'binary-to-text-converter' => [
        'use_steps' => [
            'Paste space-separated 8-bit binary values into the input area.',
            'Run the conversion to decode those bytes back into readable UTF-8 text.',
            'Check the result for unexpected symbols, which usually signal that a byte group was missing or copied incorrectly.',
        ],
        'use_cases' => [
            'Decoding classroom examples and simple byte-based exercises.',
            'Checking whether a binary string maps cleanly to a short text message.',
            'Reversing output produced by the companion text-to-binary tool for quick round-trip checks.',
        ],
        'watch_out_for' => [
            'Every byte must be eight bits long, or the decoder will reject the input.',
            'Random binary from protocols or files may not represent clean UTF-8 text at all.',
            'If the source used another encoding, the decoded characters may not match what you expected.',
        ],
        'example_title' => 'Example workflow',
        'example_body' => 'A learner can paste `01001000 01101001`, decode it to `Hi`, and then test longer byte sequences to understand how text is reconstructed from bytes.',
        'privacy_note' => 'Binary decoding is handled in the browser, making it convenient for small technical examples without uploads.',
    ],
    'jpg-to-png-converter' => [
        'use_steps' => [
            'Upload the JPG image you want to convert while keeping an eye on the original dimensions.',
            'Run the conversion, then use the generated download button to save the PNG version locally.',
            'Open the output afterward if transparency or sharp edges matter for the final design use.',
        ],
        'use_cases' => [
            'Turning a compressed JPG into a PNG for editing, annotations, or transparent-friendly workflows.',
            'Preparing assets for websites or presentations that prefer PNG output.',
            'Quickly converting small images without opening desktop editing software.',
        ],
        'watch_out_for' => [
            'Converting JPG to PNG does not restore detail lost by the original JPG compression.',
            'Large images may take longer to process in the browser depending on device memory.',
            'If you need advanced editing or background removal, this tool is only the conversion step.',
        ],
        'example_title' => 'Example workflow',
        'example_body' => 'A user can upload a quick product JPG, convert it to PNG for a mockup workflow, and move on without opening a heavier graphics tool.',
        'privacy_note' => 'The conversion happens inside the browser, which is useful when you want a quick offline-feeling image workflow.',
    ],
    'png-to-jpg-converter' => [
        'use_steps' => [
            'Upload the PNG file you want to flatten into JPG format.',
            'Convert the image and then download the JPG version created with a white background.',
            'Check the final file visually if the original PNG contained transparency that could affect the result.',
        ],
        'use_cases' => [
            'Reducing image size for simpler sharing in email, forms, or lightweight web workflows.',
            'Flattening transparent PNG assets onto white when a target system prefers JPG.',
            'Preparing screenshots or mockups for platforms that do not require alpha transparency.',
        ],
        'watch_out_for' => [
            'Transparent areas become white in the JPG output, so review the image before publishing.',
            'JPG is lossy, which means repeated conversions can degrade image quality.',
            'If transparency is important, keep the PNG version instead of converting just for convenience.',
        ],
        'example_title' => 'Example workflow',
        'example_body' => 'A support team member can turn a transparent PNG screenshot into a lighter JPG for email delivery when the background does not matter.',
        'privacy_note' => 'Image conversion runs client-side, so small assets can be processed without uploading them to a remote editor.',
    ],
    'csv-to-json-converter' => [
        'use_steps' => [
            'Paste the CSV content with a clear header row at the top so each column becomes a JSON property.',
            'Convert the data and inspect a few rows to confirm the headers and quoted values were interpreted correctly.',
            'Use the JSON output in development, testing, or cleanup work once the structure looks trustworthy.',
        ],
        'use_cases' => [
            'Turning spreadsheet exports into JSON samples for APIs and fixtures.',
            'Quickly inspecting whether CSV headers will become clean property names.',
            'Testing small data transformations before moving into a larger ETL workflow.',
        ],
        'watch_out_for' => [
            'Messy CSV files with inconsistent rows still need cleanup before the output becomes reliable.',
            'Quoted commas are supported, but highly complex multi-line CSV exports deserve a heavier data tool.',
            'Header wording matters because those values become your JSON keys directly.',
        ],
        'example_title' => 'Example workflow',
        'example_body' => 'A developer can paste a small spreadsheet export, confirm that the header row becomes the expected JSON keys, and then reuse the converted output for an API mock response.',
        'privacy_note' => 'CSV transformation happens in the browser, making it practical for quick data prep without a server-side upload step.',
    ],
    'url-parser' => [
        'use_steps' => [
            'Paste the full URL including the protocol so the parser can break it into meaningful parts.',
            'Run the parser and inspect the origin, path, query values, and hash separately.',
            'Use the structured result to debug link generation, redirect behavior, or parameter handling.',
        ],
        'use_cases' => [
            'Breaking down long marketing links or API callback URLs during debugging.',
            'Checking whether a malformed link issue comes from the path, query string, or fragment.',
            'Showing teammates exactly what part of a URL is changing between environments.',
        ],
        'watch_out_for' => [
            'A full protocol such as `https://` is required, or the browser cannot parse the value reliably.',
            'The parser explains the URL structure but does not tell you whether the destination is safe or valid on the web.',
            'Duplicate query keys may need deeper handling in your application even if the parsed summary looks clean.',
        ],
        'example_title' => 'Example workflow',
        'example_body' => 'If a redirect link is behaving strangely, you can paste it here, confirm the exact query parameters, and spot whether a missing slash or fragment caused the issue.',
        'privacy_note' => 'URL parsing is done in the browser, which makes it handy for quick debugging of internal links and callback values.',
    ],
    'lorem-ipsum-generator' => [
        'use_steps' => [
            'Choose how many placeholder paragraphs you need for the design or draft you are building.',
            'Generate the text and copy only the amount that fits your wireframe, prototype, or content test.',
            'Replace placeholder text with real copy before publishing so staging material never reaches production accidentally.',
        ],
        'use_cases' => [
            'Filling wireframes, landing page mockups, and CMS templates during design work.',
            'Testing spacing and layout behavior before real content is ready.',
            'Providing placeholder copy in demos, client previews, or training examples.',
        ],
        'watch_out_for' => [
            'Lorem ipsum is useful for layout checks, but it should never replace real editorial planning.',
            'Placeholder paragraphs can hide real content issues such as heading length or CTA clarity.',
            'Always do a final pass before launch to make sure no dummy text is left behind.',
        ],
        'example_title' => 'Example workflow',
        'example_body' => 'A designer can generate three paragraphs to test card spacing and section rhythm, then swap in real product copy later once the structure feels right.',
        'privacy_note' => 'Placeholder generation is local and instant, which suits early-stage layout and mockup work.',
    ],
    'line-sorter' => [
        'use_steps' => [
            'Paste one item per line so the sorter can treat each row as a separate value.',
            'Choose ascending or descending order depending on whether you want A-Z or Z-A cleanup.',
            'Copy the sorted list once you have checked that empty rows or duplicates were handled the way you expected.',
        ],
        'use_cases' => [
            'Cleaning tag lists, names, URLs, or quick export snippets before reuse.',
            'Alphabetizing small datasets without opening a spreadsheet.',
            'Making repeated values or missing entries easier to spot during manual review.',
        ],
        'watch_out_for' => [
            'Sorting changes order, so do not use it on lists where the original sequence carries meaning.',
            'Whitespace differences can affect how a line compares before you clean the source.',
            'This is a lightweight sorter for quick text lists, not a full deduplication or spreadsheet tool.',
        ],
        'example_title' => 'Example workflow',
        'example_body' => 'An editor can paste a messy keyword list, sort it alphabetically, and immediately see duplicates or out-of-place entries that were hard to notice before.',
        'privacy_note' => 'Line sorting runs locally in the browser and works well for small cleanup tasks.',
    ],
    'text-diff-checker' => [
        'use_steps' => [
            'Paste the original text on one side and the revised text on the other.',
            'Run the comparison to see whether the blocks match exactly or where the first difference appears.',
            'Use the reported character and line difference as the starting point for a more detailed manual review.',
        ],
        'use_cases' => [
            'Checking whether two policy versions or CMS entries are still identical.',
            'Spotting the first change in short config snippets, labels, or support messages.',
            'Doing a fast first-pass comparison before using a heavier diff application.',
        ],
        'watch_out_for' => [
            'This tool is intentionally simple, so it highlights the first change rather than rendering a full side-by-side diff.',
            'Whitespace and line-ending changes can trigger a difference even when the wording looks similar.',
            'For long documents with many edits, treat this as the first check rather than the whole review process.',
        ],
        'example_title' => 'Example workflow',
        'example_body' => 'A QA reviewer can compare two short release notes, confirm they are not identical, and jump straight to the first changed line instead of rereading everything from the top.',
        'privacy_note' => 'Text comparison stays in the browser, which is helpful for internal copy checks and quick reviews.',
    ],
    'pdf-page-counter' => [
        'use_steps' => [
            'Upload the PDF you want to inspect and wait for the document parser to read the file.',
            'Review the detected page count and file size before sending the document onward or logging it elsewhere.',
            'If the file is protected or unreadable, confirm that the source PDF itself is valid and not password restricted.',
        ],
        'use_cases' => [
            'Checking document length before emailing, printing, or archiving a PDF.',
            'Verifying that a generated report exported with the expected number of pages.',
            'Doing a quick intake check on files that arrive from multiple external sources.',
        ],
        'watch_out_for' => [
            'Password-protected PDFs may not be analyzable in a lightweight browser workflow.',
            'Page count is useful for review, but it does not tell you whether the content of each page is correct.',
            'Very large PDFs can take longer to open depending on the device and browser resources.',
        ],
        'example_title' => 'Example workflow',
        'example_body' => 'Before sending a contract bundle, an operations user can confirm the export actually contains all expected pages instead of discovering a missing section after delivery.',
        'privacy_note' => 'PDF inspection is handled in the browser through client-side parsing so the file is not posted to your application backend.',
    ],
    'pdf-metadata-viewer' => [
        'use_steps' => [
            'Upload the PDF and let the browser parse the document properties and available metadata fields.',
            'Review details such as title, author, subject, producer, and page count to understand the file better.',
            'Use the output as a quick first inspection before deeper document review or archiving.',
        ],
        'use_cases' => [
            'Checking where a PDF came from before passing it into a business workflow.',
            'Reviewing document properties during archive cleanup or intake audits.',
            'Comparing two similar PDFs to see whether their metadata suggests different sources or export tools.',
        ],
        'watch_out_for' => [
            'Metadata can be missing or inaccurate, so treat it as a clue rather than a legal truth.',
            'Some PDFs expose only a few fields even when the visual document looks complete.',
            'If the file is protected or malformed, the viewer may not be able to read all properties.',
        ],
        'example_title' => 'Example workflow',
        'example_body' => 'An admin team can inspect a submitted PDF, notice the producer and author fields are blank, and decide whether the file needs a closer manual review before archiving.',
        'privacy_note' => 'The metadata check stays in the browser so the uploaded PDF is analyzed locally during the session.',
    ],
    'pdf-text-finder' => [
        'use_steps' => [
            'Upload the PDF and enter the word or phrase you want to search for in the document text.',
            'Run the search to scan extracted page text and count how many matches were found.',
            'Use the result as a quick indicator, then open the full document manually if the wording is important or legally sensitive.',
        ],
        'use_cases' => [
            'Checking whether a contract, invoice, or exported report contains a required phrase.',
            'Scanning a long PDF for one keyword before deciding whether to review the full file.',
            'Doing a quick text presence check on PDFs received from clients or internal systems.',
        ],
        'watch_out_for' => [
            'Scanned-image PDFs or poorly encoded documents may not expose searchable text at all.',
            'A match count is helpful, but it does not replace reviewing the surrounding context on the page.',
            'If the file contains sensitive business data, keep the inspection local and avoid casual sharing.',
        ],
        'example_title' => 'Example workflow',
        'example_body' => 'A support agent can search a PDF for a customer ID, confirm that the ID appears in the extracted text, and then jump into a more focused manual review only when needed.',
        'privacy_note' => 'Text search is handled in the browser using client-side PDF parsing, which helps keep the uploaded file local to the session.',
    ],
    'pdf-security-checker' => [
        'use_steps' => [
            'Upload the PDF and let the parser inspect permissions, forms, and script-related document signals.',
            'Review the reported restrictions or interactive features before sharing or opening the file in a heavier workflow.',
            'Treat the output as a first-pass safety check, then escalate unusual files for deeper review if needed.',
        ],
        'use_cases' => [
            'Checking whether an incoming PDF appears to contain forms, scripts, or restrictions.',
            'Running a quick intake review on files from unknown or mixed sources.',
            'Helping non-technical teammates identify PDFs that deserve closer inspection before distribution.',
        ],
        'watch_out_for' => [
            'This is a lightweight browser-side signal check, not a full malware or forensic analysis.',
            'A clean result does not guarantee a file is harmless in every environment.',
            'Password-protected or damaged PDFs may block a full read of the document signals.',
        ],
        'example_title' => 'Example workflow',
        'example_body' => 'Before forwarding an externally received PDF, an operations user can run this check, see that interactive form fields are present, and decide to review the file more carefully first.',
        'privacy_note' => 'The security signal check uses local PDF parsing in the browser and does not require the file to be uploaded to your Laravel app.',
    ],
];
