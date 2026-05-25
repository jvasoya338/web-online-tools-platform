<?php

return [
    'how-to-format-json-without-errors' => [
        'field_note' => 'This guide is based on the JSON mistakes that show up during API debugging: copied partial responses, JavaScript object syntax pasted as JSON, trailing commas, and payloads that are valid structurally but still wrong for the API contract.',
        'example' => [
            'title' => 'Example: copied API response that will not parse',
            'body' => 'A common failure is copying a response body without the final closing brace or copying a JavaScript object that uses single quotes. Before blaming the API, paste the value into the formatter, fix the first parser error, then compare the formatted nesting against the endpoint documentation.',
        ],
        'checklist' => ['Confirm every object key uses double quotes.', 'Check for a missing comma between sibling properties.', 'Remove trailing commas before closing braces or brackets.', 'Confirm the payload starts and ends with the expected top-level object or array.', 'Minify only after the readable version parses cleanly.'],
        'mistakes' => ['Treating a JavaScript object literal as strict JSON.', 'Fixing indentation but ignoring a wrong data type such as a string where the API expects a number.', 'Copying logs that include timestamps or prefixes before the JSON body.'],
        'limits' => 'A formatter proves the JSON syntax can be parsed. It does not prove the payload is semantically valid for a database schema, API endpoint, or business rule.',
    ],
    'best-way-to-check-a-jwt-token' => [
        'field_note' => 'JWT inspection is useful during login debugging, but it is also easy to overtrust. The visible payload is only one part of the authentication story.',
        'example' => [
            'title' => 'Example: user is logged out too early',
            'body' => 'Decode the token and inspect claims such as exp, iat, iss, aud, and the user identifier. If exp is already in the past or the audience does not match the app you are testing, the decoded payload gives you a starting point before backend verification.',
        ],
        'checklist' => ['Confirm the token has three dot-separated parts.', 'Read expiry values in the correct timezone.', 'Compare issuer and audience with the environment you are testing.', 'Avoid pasting production secrets or private tokens into tools you do not control.', 'Verify the signature in backend code before trusting the token.'],
        'mistakes' => ['Assuming decoded means verified.', 'Sharing a live token in screenshots or support messages.', 'Ignoring environment mismatch between staging and production issuers.'],
        'limits' => 'A browser decoder is a visibility tool. It cannot confirm that the signing key, algorithm, issuer, or audience is accepted by your backend.',
    ],
    'how-to-use-a-password-generator-well' => [
        'field_note' => 'Password quality is less about clever human patterns and more about length, uniqueness, and storage habits that people can actually maintain.',
        'example' => [
            'title' => 'Example: replacing a reused team password',
            'body' => 'Generate a long unique password, store it in a password manager, and replace the reused value everywhere it appears. The important improvement is not only stronger characters; it is breaking the reuse chain.',
        ],
        'checklist' => ['Use a unique password for every account.', 'Prefer longer passwords when the service allows them.', 'Include symbols only if the destination accepts them reliably.', 'Store generated passwords in a password manager.', 'Change shared credentials when team membership changes.'],
        'mistakes' => ['Generating a strong password and then saving it in an unsecured note.', 'Reusing one generated password across multiple sites.', 'Choosing a short password because it looks visually complex.'],
        'limits' => 'A password generator does not protect an account by itself. Multi-factor authentication, breach monitoring, and safe storage still matter.',
    ],
    'what-pdf-metadata-can-tell-you' => [
        'field_note' => 'PDF metadata is most useful as an intake signal. It can reveal creation tools, document titles, author fields, and compatibility clues before a deeper document review.',
        'example' => [
            'title' => 'Example: checking a vendor PDF before sharing it',
            'body' => 'Open the metadata viewer and check title, author, creator, producer, and page count. If the author field contains a personal name or the creator field reveals internal software details, decide whether the PDF should be sanitized before forwarding.',
        ],
        'checklist' => ['Check title and author fields for accidental private information.', 'Compare page count with what the sender promised.', 'Look at creator and producer fields for source clues.', 'Treat missing metadata as normal, not automatically suspicious.', 'Use a full PDF editor for redaction or sanitization.'],
        'mistakes' => ['Assuming metadata is always accurate.', 'Treating absent metadata as proof that the document is clean.', 'Forgetting that visible page content can still reveal more than metadata.'],
        'limits' => 'Metadata is only one signal. It does not replace malware scanning, redaction review, accessibility checks, or legal document review.',
    ],
    'how-to-clean-text-for-urls-and-slugs' => [
        'field_note' => 'Slug cleanup is a publishing workflow, not just a formatting trick. The final slug should help humans understand the page before they click.',
        'example' => [
            'title' => 'Example: turning a messy title into a readable URL',
            'body' => 'A title like “Top 10 JSON Mistakes: What Breaks API Payloads?” can become “json-mistakes-api-payloads”. That is shorter, readable, and easier to share than a literal copy of every word.',
        ],
        'checklist' => ['Keep the slug lowercase.', 'Use hyphens between meaningful words.', 'Remove filler words when the slug becomes too long.', 'Avoid changing slugs after publishing unless you add redirects.', 'Keep product, guide, and category slug patterns consistent.'],
        'mistakes' => ['Stuffing every keyword into the URL.', 'Leaving punctuation or special characters in copied slugs.', 'Changing a live slug without planning redirects.'],
        'limits' => 'A cleaner slug helps usability and organization, but it does not make weak content rank by itself.',
    ],
    'how-to-use-hex-and-rgb-colors-correctly' => [
        'field_note' => 'Color conversion matters when design handoff, CSS implementation, and browser rendering all need to agree on the same shade.',
        'example' => [
            'title' => 'Example: matching a brand color in CSS',
            'body' => 'If a brand guide gives #006DBF but a component needs rgb() or hsl(), convert the value and compare the preview. Store the canonical brand value so future conversions start from the same source.',
        ],
        'checklist' => ['Confirm whether the source color is HEX, RGB, HSL, or a named CSS color.', 'Keep alpha/transparency values separate when needed.', 'Compare the preview visually after conversion.', 'Use uppercase or lowercase HEX consistently in a codebase.', 'Check contrast before using converted colors for text.'],
        'mistakes' => ['Entering RGB values outside 0 to 255.', 'Confusing #fff shorthand with a six-digit value.', 'Ignoring transparency when moving from RGBA to HEX.'],
        'limits' => 'Color conversion preserves numeric color representation. It does not guarantee accessibility, brand approval, or identical appearance across every display.',
    ],
    'when-to-use-base64-encoding-and-decoding' => [
        'field_note' => 'Base64 is useful in API and browser work because it moves data through text-only channels. The biggest safety issue is remembering that it is not encryption.',
        'example' => [
            'title' => 'Example: checking an encoded config value',
            'body' => 'If a sample payload includes a Base64-looking string, decode it to understand whether it is plain text, JSON, or binary-like content. If it reveals sensitive data, treat the source system as exposing that data to anyone who can read the string.',
        ],
        'checklist' => ['Use Base64 for representation, not secrecy.', 'Decode suspicious sample values before documenting them.', 'Avoid sharing decoded sensitive values in screenshots.', 'Check whether padding characters are missing.', 'Use proper encryption when confidentiality matters.'],
        'mistakes' => ['Calling Base64 encrypted.', 'Storing secrets as Base64 and assuming they are protected.', 'Forgetting that decoded output may contain private information.'],
        'limits' => 'Encoding changes the format of data. It does not authenticate, authorize, encrypt, or sanitize the underlying content.',
    ],
    'common-regex-mistakes-beginners-make' => [
        'field_note' => 'Regex mistakes usually come from patterns that succeed on one sample but fail against real messy input.',
        'example' => [
            'title' => 'Example: matching dots in filenames',
            'body' => 'A pattern like .+\.pdf is different from .+.pdf. The escaped dot matches a literal period; the unescaped dot can match almost any character. Testing both against realistic filenames makes the problem obvious.',
        ],
        'checklist' => ['Escape characters that should be literal.', 'Test matching and non-matching examples.', 'Review flags such as g, i, and m.', 'Avoid overly broad dot-star patterns when possible.', 'Document what the regex is expected to match.'],
        'mistakes' => ['Testing only the happy path.', 'Using greedy matching where a narrow group would be safer.', 'Forgetting that regex behavior can differ between engines.'],
        'limits' => 'A browser tester helps you reason about patterns. Production regex should still be tested in the same language or engine that will run it.',
    ],
    'how-to-compare-text-differences-quickly' => [
        'field_note' => 'Text diff checks are useful when two values look similar but a tiny change could affect publishing, configuration, or QA.',
        'example' => [
            'title' => 'Example: checking a revised policy paragraph',
            'body' => 'Paste the old paragraph and the revised paragraph side by side. If the first different line points to a sentence you did not intend to edit, review the change before publishing.',
        ],
        'checklist' => ['Compare exact text before scanning manually.', 'Check line-level changes first.', 'Look for missing spaces, punctuation, and reordered lines.', 'Use a stronger diff tool for large files or code reviews.', 'Keep the original text available until review is complete.'],
        'mistakes' => ['Relying only on visual scanning.', 'Comparing formatted text where hidden whitespace matters.', 'Using a quick diff as a replacement for legal or editorial review.'],
        'limits' => 'A simple text diff identifies where text changes begin. It is not a full version-control system or semantic review tool.',
    ],
    'best-way-to-clean-csv-before-converting-to-json' => [
        'field_note' => 'CSV conversion works best when the source table has clear headers, consistent rows, and an agreed meaning for blanks.',
        'example' => [
            'title' => 'Example: preparing an export for API testing',
            'body' => 'Rename vague headers like “Column 1” before conversion, remove empty spacer rows, and check quoted values containing commas. The JSON output becomes easier to read and safer to reuse in fixtures.',
        ],
        'checklist' => ['Make headers unique and descriptive.', 'Remove blank rows before converting.', 'Check quoted cells that contain commas.', 'Decide whether empty values should stay empty strings.', 'Validate the JSON output before sending it to an API.'],
        'mistakes' => ['Leaving duplicate headers in the first row.', 'Ignoring commas inside quoted values.', 'Assuming spreadsheet formatting will survive conversion.'],
        'limits' => 'CSV-to-JSON conversion does not clean the meaning of the data. It only reshapes rows into objects.',
    ],
    'how-to-read-unix-timestamps-in-real-logs' => [
        'field_note' => 'Timestamp confusion often comes from mixing seconds, milliseconds, local time, and UTC in the same debugging session.',
        'example' => [
            'title' => 'Example: investigating a failed scheduled job',
            'body' => 'Convert the log timestamp to UTC and local time, then compare it with the server timezone and job schedule. If the value has 13 digits, treat it as milliseconds before assuming the date is wrong.',
        ],
        'checklist' => ['Count digits before converting.', 'Compare UTC and local output.', 'Check server timezone settings.', 'Keep original log lines for context.', 'Document whether an API expects seconds or milliseconds.'],
        'mistakes' => ['Treating milliseconds as seconds.', 'Debugging in local time while the server logs UTC.', 'Ignoring daylight saving changes in historical logs.'],
        'limits' => 'A converter explains a timestamp value. It does not prove which system created it or whether the application clock was correct.',
    ],
    'why-decoding-a-jwt-is-not-the-same-as-verifying-it' => [
        'field_note' => 'This distinction matters because anyone can read many JWT payloads, but only the verifier can decide whether the token should be trusted.',
        'example' => [
            'title' => 'Example: a modified payload still decodes',
            'body' => 'If someone changes the role claim in a token, the token may still decode into readable JSON. Verification should reject it because the signature no longer matches the signed content.',
        ],
        'checklist' => ['Decode only to inspect visible claims.', 'Verify signatures on the backend.', 'Reject unexpected algorithms.', 'Validate issuer, audience, and expiry.', 'Rotate keys according to your authentication design.'],
        'mistakes' => ['Using a decoder result as an access-control decision.', 'Ignoring alg header risks.', 'Testing token changes without checking signature failure.'],
        'limits' => 'Only a trusted verification process with the correct key material can establish token integrity.',
    ],
    'how-to-check-if-a-password-is-actually-strong' => [
        'field_note' => 'Password strength depends on uniqueness, length, randomness, and the risk environment around the account.',
        'example' => [
            'title' => 'Example: comparing two password choices',
            'body' => '“Summer2026!” looks complex but follows a predictable pattern. A longer generated value stored in a password manager is usually stronger because it is less guessable and not reused.',
        ],
        'checklist' => ['Check length first.', 'Avoid personal words and dates.', 'Do not reuse passwords.', 'Use a manager for generated values.', 'Enable multi-factor authentication on important accounts.'],
        'mistakes' => ['Equating symbols with strength.', 'Reusing a strong password.', 'Saving backup codes next to the password.'],
        'limits' => 'No quick checklist can guarantee account safety. Breach exposure, phishing, recovery settings, and MFA all affect real-world security.',
    ],
    'what-makes-a-url-slug-good-for-users-and-seo' => [
        'field_note' => 'A good slug supports clarity. It should describe the page without trying to carry the entire SEO strategy.',
        'example' => [
            'title' => 'Example: shortening a guide URL',
            'body' => 'Instead of “the-best-complete-ultimate-guide-to-clean-url-slugs-for-seo”, use “clean-url-slugs”. The shorter version is easier to read, share, and maintain.',
        ],
        'checklist' => ['Make the slug readable out of context.', 'Keep it stable after publishing.', 'Use hyphens as separators.', 'Avoid dates unless the date is essential.', 'Redirect old slugs when changing URLs.'],
        'mistakes' => ['Keyword stuffing in the path.', 'Publishing duplicate pages with near-identical slugs.', 'Forgetting internal links after a slug change.'],
        'limits' => 'Slug quality is a supporting signal for users and organization. The page still needs useful content, clear navigation, and a reason to exist.',
    ],
    'how-to-tell-if-color-conversion-results-are-correct' => [
        'field_note' => 'Color conversion should be checked both numerically and visually, especially when the color moves between design tools and CSS.',
        'example' => [
            'title' => 'Example: validating a converted brand shade',
            'body' => 'Convert the HEX value to RGB, apply it to a preview, and compare it with the original brand swatch. If a teammate supplied an RGBA value, account for transparency before judging the match.',
        ],
        'checklist' => ['Validate input format before converting.', 'Compare the converted preview.', 'Track alpha values separately.', 'Check contrast for text use.', 'Keep one canonical source color in documentation.'],
        'mistakes' => ['Dropping alpha from RGBA without noticing.', 'Rounding HSL values too aggressively.', 'Comparing colors on an uncalibrated display only by eye.'],
        'limits' => 'Conversion can be mathematically correct while still failing accessibility, brand, or contrast requirements.',
    ],
    'why-pdf-text-search-fails-on-some-files' => [
        'field_note' => 'PDF text search depends on whether the file contains extractable text. Scanned pages and unusual encodings often behave differently.',
        'example' => [
            'title' => 'Example: search finds nothing in a scanned invoice',
            'body' => 'If the PDF page is really an image, a text finder may return zero matches even though the word is visible. Run OCR in a PDF application before expecting normal search behavior.',
        ],
        'checklist' => ['Check whether text can be selected in a PDF reader.', 'Try a simple word that is visibly present.', 'Consider OCR for scanned files.', 'Watch for ligatures and unusual character encoding.', 'Use full PDF software for legal or archival review.'],
        'mistakes' => ['Assuming visible text is extractable text.', 'Searching with different punctuation than the PDF stores.', 'Treating zero matches as proof the content is absent.'],
        'limits' => 'Browser-side text extraction is a quick check. It is not a substitute for OCR, accessibility remediation, or forensic document analysis.',
    ],
    'how-to-review-pdf-metadata-before-sharing-a-file' => [
        'field_note' => 'Metadata review is a practical habit before sharing documents externally, especially files created from office tools, design tools, or scanned workflows.',
        'example' => [
            'title' => 'Example: removing internal author clues',
            'body' => 'If the author field contains an employee name and the file will be posted publicly, export a clean copy or remove metadata with a trusted PDF editor before sharing.',
        ],
        'checklist' => ['Check author, title, subject, creator, and producer fields.', 'Confirm the visible filename matches the document purpose.', 'Review comments and form fields in a full PDF editor.', 'Remove sensitive metadata before public sharing.', 'Keep an original copy before sanitizing.'],
        'mistakes' => ['Only checking the filename.', 'Assuming print-to-PDF removes every hidden detail.', 'Forgetting embedded form fields or comments.'],
        'limits' => 'A metadata viewer helps you spot common fields. It does not guarantee that every hidden object or embedded item has been removed.',
    ],
    'how-to-use-a-word-counter-for-real-editing-work' => [
        'field_note' => 'Word counts are useful when they help editing decisions: trimming intros, checking requirements, and comparing drafts.',
        'example' => [
            'title' => 'Example: cutting a long guide introduction',
            'body' => 'Paste only the introduction, check word count, then revise until the section is concise enough to lead into the practical steps. Count again after editing so the measurement reflects the final draft.',
        ],
        'checklist' => ['Count the exact section you are editing.', 'Track words and characters separately.', 'Check sentence count when readability matters.', 'Recount after final edits.', 'Use editorial judgment instead of chasing a number blindly.'],
        'mistakes' => ['Counting draft notes with the final article.', 'Assuming shorter is always better.', 'Ignoring readability while meeting a character limit.'],
        'limits' => 'A word counter measures text volume. It cannot judge clarity, originality, accuracy, or usefulness by itself.',
    ],
    'how-line-sorting-helps-clean-messy-lists-fast' => [
        'field_note' => 'Line sorting is a small but useful cleanup step for lists of domains, keywords, IDs, names, or repeated operational notes.',
        'example' => [
            'title' => 'Example: organizing a messy allowlist',
            'body' => 'Paste one domain per line, sort A-Z, then scan for duplicates, misspellings, and entries that no longer belong. The sorted order makes irregular items easier to spot.',
        ],
        'checklist' => ['Put one item on each line.', 'Trim blank lines before sorting.', 'Choose ascending or descending order intentionally.', 'Check for duplicates after sorting.', 'Keep the unsorted source if original order has meaning.'],
        'mistakes' => ['Sorting a list where order carries priority.', 'Mixing labels and values on the same line.', 'Assuming sorting also validates each item.'],
        'limits' => 'Sorting improves scanability. It does not verify whether the entries are correct, active, safe, or complete.',
    ],
    'when-to-use-url-encoding-in-api-and-form-work' => [
        'field_note' => 'URL encoding becomes important whenever text moves into query strings, form bodies, redirects, or callback URLs.',
        'example' => [
            'title' => 'Example: passing a search phrase in a query string',
            'body' => 'A value like “PDF tools & JSON formatter” should be encoded before it becomes a query parameter. Otherwise spaces and ampersands can change how the URL is parsed.',
        ],
        'checklist' => ['Encode parameter values, not the entire URL blindly.', 'Decode values before presenting them to users.', 'Watch reserved characters such as &, ?, =, and #.', 'Use framework helpers in production code.', 'Test callback URLs with realistic values.'],
        'mistakes' => ['Double-encoding a value.', 'Encoding an entire URL when only one parameter value needed it.', 'Forgetting that plus signs and spaces may be treated differently by form encoders.'],
        'limits' => 'URL encoding makes values transport-safe. It does not validate the destination, authorize the request, or protect sensitive data.',
    ],
];
