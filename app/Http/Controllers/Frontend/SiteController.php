<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Support\WebToolsStationCatalog;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class SiteController extends Controller
{
    public function home(): View
    {
        $tools = array_map(fn (array $tool): array => $this->prepareTool($tool), $this->tools());
        $guides = $this->guides();

        return view('site.home', [
            'tools' => $tools,
            'featuredTools' => array_slice($tools, 0, 6),
            'latestGuides' => array_slice($guides, -6),
            'toolCount' => count($tools),
            'pdfCount' => count(array_filter($tools, fn (array $tool): bool => $tool['category'] === 'PDF Tools')),
            'seo' => [
                'title' => 'WebToolsStation - Free Developer and PDF Tools Online',
                'description' => 'Use WebToolsStation by TJVerce for fast online developer tools and PDF utilities. Format JSON, decode JWT, test regex, convert text, inspect PDFs, and more.',
                'keywords' => 'developer tools online, pdf tools online, json formatter, jwt decoder, regex tester, uuid generator, pdf page counter, pdf metadata viewer, webtoolsstation',
                'canonical' => url('/'),
                'type' => 'website',
                'image' => url('/images/logo/webtoolsstation-logo.png'),
            ],
            'schema' => [
                '@context' => 'https://schema.org',
                '@type' => 'WebSite',
                'name' => 'WebToolsStation',
                'url' => url('/'),
                'description' => 'A tool platform by TJVerce with developer utilities and PDF tools.',
                'image' => url('/images/logo/webtoolsstation-logo.png'),
                'publisher' => [
                    '@type' => 'Organization',
                    'name' => 'TJVerce',
                    'email' => 'webtoolsstation@gmail.com',
                ],
            ],
        ]);
    }

    public function tool(string $slug): View
    {
        $tool = collect($this->tools())->firstWhere('slug', $slug);

        abort_if(!$tool, 404);

        $tool = $this->prepareTool($tool);

        return view('site.tool', [
            'tool' => $tool,
            'tools' => array_map(fn (array $item): array => $this->prepareTool($item), $this->tools()),
            'seo' => [
                'title' => $tool['title'] . ' Online - Free Browser Tool | WebToolsStation',
                'description' => $tool['seo_description'],
                'keywords' => implode(', ', $tool['keywords']),
                'canonical' => url('/tools/' . $tool['slug']),
                'type' => 'website',
                'image' => url('/images/logo/webtoolsstation-logo.png'),
            ],
            'schema' => [
                '@context' => 'https://schema.org',
                '@graph' => [
                    [
                        '@type' => 'SoftwareApplication',
                        'name' => $tool['title'],
                        'applicationCategory' => $tool['category'],
                        'operatingSystem' => 'Any',
                        'description' => $tool['seo_description'],
                        'url' => url('/tools/' . $tool['slug']),
                        'image' => url('/images/logo/webtoolsstation-logo.png'),
                        'offers' => [
                            '@type' => 'Offer',
                            'price' => '0',
                            'priceCurrency' => 'USD',
                        ],
                        'publisher' => [
                            '@type' => 'Organization',
                            'name' => 'WebToolsStation',
                            'url' => url('/'),
                        ],
                    ],
                    [
                        '@type' => 'FAQPage',
                        'mainEntity' => array_map(fn (array $item): array => [
                            '@type' => 'Question',
                            'name' => $item['question'],
                            'acceptedAnswer' => [
                                '@type' => 'Answer',
                                'text' => $item['answer'],
                            ],
                        ], $tool['faq']),
                    ],
                    [
                        '@type' => 'BreadcrumbList',
                        'itemListElement' => [
                            [
                                '@type' => 'ListItem',
                                'position' => 1,
                                'name' => 'Home',
                                'item' => url('/'),
                            ],
                            [
                                '@type' => 'ListItem',
                                'position' => 2,
                                'name' => $tool['title'],
                                'item' => url('/tools/' . $tool['slug']),
                            ],
                        ],
                    ],
                ],
            ],
        ]);
    }

    public function about(): View
    {
        return $this->pageView([
            'label' => 'About Us',
            'title' => 'A calm, useful platform built for everyday digital work.',
            'intro' => 'WebToolsStation is a product from TJVerce. We created it with a very simple idea in mind: useful online tools should feel trustworthy, fast, and easy to understand from the first click. Too many utility websites feel crowded, confusing, or overloaded with unnecessary noise. We wanted to build something cleaner. Our goal is to give people practical tools they can use in seconds while also giving the platform enough depth, structure, and clarity to grow into a reliable destination over time.',
            'sections' => [
                [
                    'heading' => 'Why WebToolsStation exists',
                    'paragraphs' => [
                        'We noticed that many users do not want a complicated software account just to complete a small task. Sometimes a developer only wants to format JSON, decode a token, generate a UUID, convert color values, or check a PDF quickly before moving back to work. In those moments, speed matters. Clarity matters. Confidence matters. WebToolsStation is designed around those small but important moments.',
                        'Instead of pushing visitors through unnecessary steps, we try to keep the experience direct. A person should arrive, understand the page immediately, use the tool, and leave satisfied. That product philosophy shapes both our interface decisions and our content decisions. We prefer simplicity over clutter, clarity over noise, and usefulness over gimmicks.',
                    ],
                ],
                [
                    'heading' => 'What we are building',
                    'paragraphs' => [
                        'WebToolsStation is being developed as a focused collection of browser-based utilities for developers, teams, creators, students, and business users. Some people come for code-oriented tools such as regex testing, timestamp conversion, hashing, encoding, and formatting. Others come for document tasks, especially around PDF inspection and lightweight checks. Over time, the platform will continue to expand in a way that stays organized instead of becoming chaotic.',
                        'Every tool on the platform is expected to earn its place. We do not want hundreds of empty pages that exist only for traffic. We want solid tools with understandable inputs, clear outputs, and helpful descriptions. That means each page should explain what the tool does, why someone might need it, and how it can fit into real work. We believe a strong tools website should respect the visitor’s time and attention.',
                    ],
                ],
                [
                    'heading' => 'Our design approach',
                    'paragraphs' => [
                        'Design matters even on a utility website. When a page looks rushed or unstable, users naturally hesitate. That is why we put effort into making WebToolsStation feel steady, polished, and easy on the eyes. We prefer layouts that breathe, readable typography, balanced spacing, and sections that guide the visitor naturally. A tool page should feel helpful, not stressful.',
                        'We also believe design should support trust. Legal pages should be clear. Contact details should be visible. Navigation should be simple. Important pages such as About, Privacy Policy, Contact, and Terms of Use should not look like forgotten filler. They should feel like real parts of the platform because they are part of the user’s confidence in the brand.',
                    ],
                ],
                [
                    'heading' => 'Who runs this website',
                    'paragraphs' => [
                        'WebToolsStation is operated by TJVerce. The site is maintained as a focused tools and publishing project rather than an anonymous script directory. That means we review how pages read, how tools behave in the browser, and whether the surrounding explanations are clear enough for normal users to trust what they are seeing.',
                        'The goal is not to publish as many pages as possible. The goal is to publish tools and supporting guides that solve practical problems in a way that feels understandable, maintained, and honest about limitations. When a page needs more explanation, examples, or review notes, we would rather improve it than pretend a thin page is finished.',
                    ],
                ],
                [
                    'heading' => 'How we think about quality',
                    'paragraphs' => [
                        'At TJVerce, we care about the difference between having a page and having a useful page. A useful page answers questions, solves tasks, and reduces friction. We review our tools with that mindset. If a tool feels vague, visually messy, or hard to trust, it needs more work. If content feels thin, it needs more substance. If a page creates confusion, it needs simplification.',
                        'That same approach shapes how we want the platform to grow. We are not trying to become loud for the sake of being noticed. We want to become dependable. We want people to bookmark the site because it works. We want visitors to return because the experience stays clean and consistent. We want search traffic to grow because the pages are genuinely useful, not because they are overloaded with empty promises.',
                    ],
                ],
                [
                    'heading' => 'Who we serve',
                    'paragraphs' => [
                        'WebToolsStation is for anyone who needs quick digital help in the browser. Developers can use it during debugging, frontend work, backend work, or API testing. Students can use it to understand data formats and document structure. Business users can use the PDF pages to inspect files quickly without installing a complicated desktop program. Content teams can use conversion tools to prepare text and structured data.',
                        'What connects all of these audiences is the desire for simplicity. People do not always want a heavyweight application. Sometimes they just need a reliable page that solves a single problem well. That is the experience we are trying to deliver again and again.',
                    ],
                ],
                [
                    'heading' => 'Our long-term direction',
                    'paragraphs' => [
                        'The long-term vision for WebToolsStation is a carefully built platform with strong utility pages, strong content, and a professional public presence. We want the site to feel good enough for regular visitors, clear enough for search engines to understand, and trustworthy enough for advertising and partner review standards. That means continuing to improve page quality, clarity, accuracy, and visual consistency.',
                        'As the platform grows, we will keep refining the tool set, page structure, and content quality. We want visitors to feel that the website has direction and care behind it. WebToolsStation is not meant to be a random collection of scripts. It is meant to become a stable and attractive online destination for practical work. That is the standard TJVerce wants to build toward.',
                    ],
                ],
                [
                    'heading' => 'How pages are reviewed',
                    'paragraphs' => [
                        'Before a page earns a stable place on the site, we look at more than whether the button works. We ask whether the purpose is clear, whether the page gives enough context for real use, whether examples and limitations are explained honestly, and whether the visitor can understand what to double-check before relying on the result.',
                        'That review approach matters because many utility websites stop at the widget. WebToolsStation is being built to go further than that by pairing tools with practical guidance, connected articles, visible policy pages, and a clearer sense of ownership than low-effort tool directories usually provide.',
                    ],
                ],
            ],
            'cards' => [
                ['title' => 'Company', 'value' => 'TJVerce'],
                ['title' => 'Platform', 'value' => 'WebToolsStation'],
                ['title' => 'Operator', 'value' => 'TJVerce editorial and product team'],
                ['title' => 'Focus', 'value' => 'Useful online tools with clear design and practical guidance'],
                ['title' => 'Contact', 'value' => 'webtoolsstation@gmail.com'],
            ],
            'schema' => [
                '@context' => 'https://schema.org',
                '@type' => 'AboutPage',
                'name' => 'About WebToolsStation',
                'url' => url('/about'),
                'description' => 'Learn about WebToolsStation, what it publishes, and how TJVerce approaches tool quality and trust.',
                'image' => url('/images/logo/webtoolsstation-logo.png'),
                'publisher' => [
                    '@type' => 'Organization',
                    'name' => 'TJVerce',
                    'url' => url('/'),
                ],
                'mainEntity' => [
                    '@type' => 'Organization',
                    'name' => 'TJVerce',
                    'url' => url('/'),
                    'email' => 'webtoolsstation@gmail.com',
                ],
            ],
        ], [
            'title' => 'About WebToolsStation - TJVerce',
            'description' => 'Learn about WebToolsStation by TJVerce, including our mission, design approach, platform direction, and how we build useful online tools.',
            'keywords' => 'about webtoolsstation, about tjverce, online tools platform, developer and pdf tools',
            'canonical' => url('/about'),
            'type' => 'article',
        ]);
    }

    public function guidesIndex(): View
    {
        $guides = $this->guides();

        return view('site.guides', [
            'guides' => $guides,
            'featuredGuides' => array_slice($guides, -8),
            'guideCount' => count($guides),
            'seo' => [
                'title' => 'Guides and Articles - WebToolsStation',
                'description' => 'Browse WebToolsStation guides covering JSON, JWT, Base64, passwords, timestamps, PDF checks, color conversion, slugs, and other practical web workflows.',
                'keywords' => 'webtoolsstation guides, developer tool guides, pdf tool guides, json jwt base64 articles',
                'canonical' => url('/guides'),
                'type' => 'website',
                'image' => url('/images/logo/webtoolsstation-logo.png'),
            ],
            'schema' => [
                '@context' => 'https://schema.org',
                '@type' => 'CollectionPage',
                'name' => 'WebToolsStation Guides',
                'url' => url('/guides'),
                'description' => 'A collection of practical guides and articles that support WebToolsStation tools and browser-based workflows.',
                'image' => url('/images/logo/webtoolsstation-logo.png'),
                'publisher' => [
                    '@type' => 'Organization',
                    'name' => 'TJVerce',
                    'url' => url('/'),
                ],
            ],
        ]);
    }

    public function author(string $slug): View
    {
        $author = $this->authors()[$slug] ?? null;

        abort_if(!$author, 404);

        $guides = collect($this->guides())
            ->filter(fn (array $guide): bool => ($guide['author']['slug'] ?? null) === $slug)
            ->values()
            ->all();

        return view('site.author', [
            'author' => $author,
            'guides' => $guides,
            'seo' => [
                'title' => $author['name'] . ' - WebToolsStation Author',
                'description' => $author['bio'],
                'keywords' => 'webtoolsstation author, tj verse, tjverce editor, tool guides author',
                'canonical' => $author['url'],
                'type' => 'profile',
                'image' => url('/images/logo/webtoolsstation-logo.png'),
            ],
            'schema' => [
                '@context' => 'https://schema.org',
                '@type' => 'Person',
                'name' => $author['name'],
                'jobTitle' => $author['role'],
                'url' => $author['url'],
                'email' => $author['email'],
                'worksFor' => [
                    '@type' => 'Organization',
                    'name' => 'TJVerce',
                    'url' => url('/'),
                ],
                'sameAs' => $author['same_as'],
                'description' => $author['bio'],
            ],
        ]);
    }

    public function contact(): View
    {
        return view('site.contact', [
            'seo' => [
                'title' => 'Contact WebToolsStation - TJVerce',
                'description' => 'Contact WebToolsStation by TJVerce at webtoolsstation@gmail.com for support, partnerships, suggestions, and platform feedback.',
                'keywords' => 'contact webtoolsstation, contact tjverce, webtoolsstation support email',
                'canonical' => url('/contact'),
                'type' => 'article',
                'image' => url('/images/logo/webtoolsstation-logo.png'),
            ],
            'schema' => [
                '@context' => 'https://schema.org',
                '@type' => 'ContactPage',
                'name' => 'Contact WebToolsStation',
                'url' => url('/contact'),
                'image' => url('/images/logo/webtoolsstation-logo.png'),
            ],
            'contact' => [
                'company' => 'TJVerce',
                'platform' => 'WebToolsStation',
                'email' => 'webtoolsstation@gmail.com',
                'location' => 'India',
                'topics' => [
                    'Bug reports and support questions',
                    'Tool suggestions and feature ideas',
                    'Partnership, content, and business requests',
                ],
            ],
        ]);
    }

    public function contactSubmit(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:160'],
            'topic' => ['required', 'string', 'max:120'],
            'subject' => ['required', 'string', 'max:160'],
            'message' => ['required', 'string', 'min:20', 'max:4000'],
            'website' => ['nullable', 'max:0'],
        ]);

        Mail::raw(implode("\n", [
            'WebToolsStation contact form submission',
            '',
            'Name: ' . $validated['name'],
            'Email: ' . $validated['email'],
            'Topic: ' . $validated['topic'],
            'Subject: ' . $validated['subject'],
            '',
            'Message:',
            $validated['message'],
        ]), function ($message) use ($validated) {
            $message->to('webtoolsstation@gmail.com')
                ->replyTo($validated['email'], $validated['name'])
                ->subject('[WebToolsStation] ' . $validated['subject']);
        });

        return redirect()
            ->route('contact')
            ->with('status', 'Your message has been sent to WebToolsStation. We will review it and reply when needed.');
    }

    public function guide(string $slug): View
    {
        $guide = collect($this->guides())->firstWhere('slug', $slug);

        abort_if(!$guide, 404);

        $guide = $this->prepareGuide($guide);

        return view('site.article', [
            'article' => $guide,
            'guides' => $this->guides(),
            'relatedTools' => $this->relatedToolsForGuide($guide['slug']),
            'seo' => [
                'title' => $guide['seo_title'],
                'description' => $guide['seo_description'],
                'keywords' => implode(', ', $guide['keywords']),
                'canonical' => url('/guides/' . $guide['slug']),
                'type' => 'article',
                'image' => $guide['image'],
                'author' => $guide['author']['name'] . ', WebToolsStation',
            ],
            'schema' => [
                '@context' => 'https://schema.org',
                '@graph' => [
                    [
                        '@type' => 'Article',
                        'headline' => $guide['title'],
                        'description' => $guide['seo_description'],
                        'image' => [$guide['image']],
                        'author' => [
                            '@type' => 'Person',
                            'name' => $guide['author']['name'],
                            'url' => $guide['author']['url'],
                        ],
                        'publisher' => [
                            '@type' => 'Organization',
                            'name' => 'WebToolsStation',
                            'url' => url('/'),
                            'logo' => [
                                '@type' => 'ImageObject',
                                'url' => url('/images/logo/webtoolsstation-logo.png'),
                            ],
                        ],
                        'mainEntityOfPage' => url('/guides/' . $guide['slug']),
                        'datePublished' => $guide['published_at'],
                        'dateModified' => $guide['updated_at'],
                    ],
                    [
                        '@type' => 'FAQPage',
                        'mainEntity' => array_map(fn (array $item): array => [
                            '@type' => 'Question',
                            'name' => $item['question'],
                            'acceptedAnswer' => [
                                '@type' => 'Answer',
                                'text' => $item['answer'],
                            ],
                        ], $guide['faq']),
                    ],
                    [
                        '@type' => 'BreadcrumbList',
                        'itemListElement' => [
                            [
                                '@type' => 'ListItem',
                                'position' => 1,
                                'name' => 'Home',
                                'item' => url('/'),
                            ],
                            [
                                '@type' => 'ListItem',
                                'position' => 2,
                                'name' => 'Guides',
                                'item' => url('/guides'),
                            ],
                            [
                                '@type' => 'ListItem',
                                'position' => 3,
                                'name' => $guide['title'],
                                'item' => url('/guides/' . $guide['slug']),
                            ],
                        ],
                    ],
                ],
            ],
        ]);
    }

    public function privacy(): View
    {
        return $this->pageView([
            'label' => 'Privacy Policy',
            'title' => 'How WebToolsStation handles information, browser activity, and communication.',
            'intro' => 'This Privacy Policy explains how TJVerce operates WebToolsStation and describes the types of information that may be handled when you use the website. We believe a privacy page should be clear enough for normal users to understand, while still being complete enough to explain the essential responsibilities of the platform. The purpose of this policy is to show how the website works, what kinds of data may be collected, and how communication and technical activity may be managed.',
            'sections' => [
                [
                    'heading' => 'Who operates this platform',
                    'paragraphs' => [
                        'WebToolsStation is operated by TJVerce. Throughout this policy, references to “we,” “our,” or “us” refer to TJVerce and the WebToolsStation platform. References to “you” refer to visitors, users, and anyone who accesses the website or contacts us through the available public channels.',
                        'We maintain this website to provide practical online tools and supporting public information. Because the platform includes public pages, browser-based tools, and communication options, some technical and contact-related information may be handled in the normal course of operating the website.',
                    ],
                ],
                [
                    'heading' => 'Browser-based tool usage',
                    'paragraphs' => [
                        'Many tools on WebToolsStation are designed to run in the browser. That means the content you enter into those tools may be processed locally on your own device rather than being sent to a remote service. This approach helps reduce friction and can improve privacy for tasks such as formatting, decoding, converting, and checking small pieces of information.',
                        'However, users should always exercise judgment when handling sensitive personal, legal, financial, medical, or business-critical information on any website. Even when a tool is browser-oriented, it is still good practice to avoid sharing highly sensitive content unless you fully understand the environment and your own security requirements.',
                    ],
                ],
                [
                    'heading' => 'Information we may collect',
                    'paragraphs' => [
                        'Like many websites, we may collect limited technical information connected to normal website operation. This can include browser type, device type, operating system details, language preferences, approximate geographic region, referring pages, interaction timing, and general page visit activity. This information helps us understand performance, user experience, technical issues, and broad usage patterns.',
                        'If you contact us directly by email, we may receive your email address, the contents of your message, and any other information you choose to include. We may keep that communication so we can reply, track support history, improve our service, and maintain business records where appropriate.',
                    ],
                ],
                [
                    'heading' => 'Cookies and essential website functions',
                    'paragraphs' => [
                        'WebToolsStation may use cookies or similar technologies for essential website functions, preference handling, and basic measurement of website behavior. Some cookies help the site operate properly, remember interface choices, or present consent-related controls correctly. We want the website to remain usable and understandable, and in some cases that requires small pieces of browser-side storage.',
                        'Where optional measurement or preference features exist, we aim to present them in a way that is visible and manageable. Exact cookie behavior may change over time as the platform evolves, but our intention is to keep the website understandable rather than opaque.',
                    ],
                ],
                [
                    'heading' => 'How information may be used',
                    'paragraphs' => [
                        'Information handled by the website may be used for several basic reasons: operating and maintaining the platform, understanding performance and reliability, answering user messages, reviewing abuse or misuse, improving design and content, and planning future tools or sections. We may also use technical information to help diagnose errors, evaluate stability, and understand which areas of the website are most helpful to visitors.',
                        'We do not describe this platform as a service built around selling personal information. Our goal is to operate a useful website, communicate responsibly, and improve the product over time. If platform capabilities change in a meaningful way, this policy may be updated to reflect those changes.',
                    ],
                ],
                [
                    'heading' => 'Data sharing and external services',
                    'paragraphs' => [
                        'We may rely on standard infrastructure and website services that support hosting, email, analytics, security, or content delivery. In normal website operation, those services may process limited technical information on our behalf. We aim to use reasonable services appropriate to running a public web platform.',
                        'We may also disclose information where reasonably necessary to comply with law, respond to legal requests, protect the platform, investigate abuse, or defend rights and security. Beyond those ordinary circumstances, we do not present WebToolsStation as a marketplace for personal data.',
                    ],
                ],
                [
                    'heading' => 'Retention, updates, and contact',
                    'paragraphs' => [
                        'We may keep records for as long as reasonably necessary to operate the website, respond to inquiries, maintain internal history, meet legal obligations, or address security concerns. The length of time may vary depending on the type of information involved and the reason it was collected.',
                        'Because websites change, this Privacy Policy may also change. When the platform grows or our practices become more detailed, we may revise the text to better explain those changes. If you have questions about this policy, you can contact TJVerce at webtoolsstation@gmail.com.',
                    ],
                ],
            ],
            'cards' => [
                ['title' => 'Operator', 'value' => 'TJVerce'],
                ['title' => 'Website', 'value' => 'WebToolsStation'],
                ['title' => 'Primary Contact', 'value' => 'webtoolsstation@gmail.com'],
                ['title' => 'Policy Scope', 'value' => 'Website usage, browser tools, and communication'],
            ],
            'schema' => [
                '@context' => 'https://schema.org',
                '@type' => 'WebPage',
                'name' => 'Privacy Policy',
                'url' => url('/privacy-policy'),
                'description' => 'Privacy policy for WebToolsStation covering browser-based tools, contact communication, and website usage.',
                'image' => url('/images/logo/webtoolsstation-logo.png'),
                'publisher' => [
                    '@type' => 'Organization',
                    'name' => 'TJVerce',
                    'url' => url('/'),
                ],
            ],
        ], [
            'title' => 'Privacy Policy - WebToolsStation',
            'description' => 'Read the Privacy Policy for WebToolsStation by TJVerce, including how browser-based tools, cookies, technical information, and contact messages are handled.',
            'keywords' => 'privacy policy webtoolsstation, tjverce privacy, website data handling policy',
            'canonical' => url('/privacy-policy'),
            'type' => 'article',
        ]);
    }

    public function terms(): View
    {
        return $this->pageView([
            'label' => 'Terms of Use',
            'title' => 'Basic rules for using WebToolsStation in a fair and lawful way.',
            'intro' => 'These Terms of Use explain the general conditions for accessing and using WebToolsStation. We want this page to be readable, practical, and clear. The website is designed to be simple, but using a simple website still involves basic expectations around lawful use, acceptable behavior, responsibility, and platform limits. By using WebToolsStation, you agree to these general terms.',
            'sections' => [
                [
                    'heading' => 'Ownership and acceptance',
                    'paragraphs' => [
                        'WebToolsStation is owned and operated by TJVerce. By accessing the platform, viewing its pages, or using its tools, you agree to follow these Terms of Use. If you do not agree with these terms, you should stop using the website.',
                        'These terms may be updated as the platform changes. When new features, new tools, or new content types are introduced, the language on this page may be revised so that it stays relevant to the actual operation of the website.',
                    ],
                ],
                [
                    'heading' => 'Permitted use',
                    'paragraphs' => [
                        'You may use WebToolsStation for lawful personal, educational, professional, or business-related purposes. The platform is intended to help users complete practical tasks such as formatting, converting, checking, inspecting, or generating information in a lightweight web environment.',
                        'We expect users to interact with the website in good faith. That includes using the tools in a way that respects the law, respects intellectual property rights, and does not attempt to damage, overload, exploit, or misuse the platform.',
                    ],
                ],
                [
                    'heading' => 'Prohibited conduct',
                    'paragraphs' => [
                        'You must not use WebToolsStation in connection with illegal activity, abusive conduct, fraud, malware, unauthorized access, infringement, harassment, or the distribution of harmful content. You must not attempt to interfere with the security, availability, or technical integrity of the website.',
                        'You also must not use the platform to process or distribute content in a way that violates applicable law or the rights of others. If we believe the website is being used in a harmful or abusive way, we may restrict access, block activity, or take other protective action as appropriate.',
                    ],
                ],
                [
                    'heading' => 'No guarantee of uninterrupted service',
                    'paragraphs' => [
                        'We work to keep WebToolsStation available and useful, but we do not guarantee uninterrupted availability, perfect uptime, or error-free performance. Like any web platform, the site may be updated, changed, paused, or interrupted for maintenance, design changes, technical limitations, or unforeseen issues.',
                        'We also do not guarantee that every tool will fit every workflow or every type of file or input. Some tools are lightweight by design and intended for quick checks rather than complex enterprise processing. Users should apply appropriate judgment when relying on any result for important work.',
                    ],
                ],
                [
                    'heading' => 'Content and output responsibility',
                    'paragraphs' => [
                        'You remain responsible for the content you choose to enter into tools or share with us by email. You should review important outputs before relying on them in any legal, financial, technical, or operational context. While we aim to make the website useful, the final responsibility for how you use tool outputs belongs to you.',
                        'Where a page provides guidance, descriptions, or explanations, that information is offered for general convenience and platform understanding. It is not a substitute for professional advice tailored to a specific legal, technical, or business situation.',
                    ],
                ],
                [
                    'heading' => 'Intellectual property and platform rights',
                    'paragraphs' => [
                        'The WebToolsStation brand, design, written content, page structure, and platform presentation are part of the TJVerce website offering unless otherwise stated. You should not copy, republish, or misuse original platform content in a way that infringes our rights or misrepresents the source.',
                        'Normal use of the public website is permitted, but that does not grant ownership of the platform, its identity, or its original materials. If you want to discuss collaboration, licensing, or business use beyond normal browsing, please contact us directly.',
                    ],
                ],
                [
                    'heading' => 'Limitation and contact',
                    'paragraphs' => [
                        'To the extent permitted by applicable law, WebToolsStation and TJVerce provide the website on an as available and as is basis. We do not make broad warranties that the platform will always meet every expectation or every use case. We aim for quality and usefulness, but users should still evaluate results in context.',
                        'If you have questions about these Terms of Use, you can contact TJVerce at webtoolsstation@gmail.com. Continued use of the website after updates to these terms may be treated as acceptance of the revised version.',
                    ],
                ],
                [
                    'heading' => 'Browser tool expectations',
                    'paragraphs' => [
                        'Many pages on WebToolsStation are lightweight utilities intended for fast formatting, conversion, inspection, and generation tasks. They are useful for everyday checks, but they are not designed to replace full professional software, production testing, legal review, security verification, or document forensics. Users should treat the output as one step in a workflow, not as an automatic final decision.',
                        'If a task involves sensitive information, regulated data, private documents, account credentials, or business-critical results, use additional review processes appropriate to that context. WebToolsStation tries to explain limitations on tool and guide pages so visitors can understand when a browser check is enough and when a deeper workflow is more responsible.',
                    ],
                ],
            ],
            'cards' => [
                ['title' => 'Owner', 'value' => 'TJVerce'],
                ['title' => 'Applies To', 'value' => 'All visitors and users of WebToolsStation'],
                ['title' => 'Use Standard', 'value' => 'Lawful, respectful, non-abusive use only'],
                ['title' => 'Questions', 'value' => 'webtoolsstation@gmail.com'],
            ],
            'schema' => [
                '@context' => 'https://schema.org',
                '@type' => 'WebPage',
                'name' => 'Terms of Use',
                'url' => url('/terms-of-use'),
                'description' => 'Terms of Use for WebToolsStation covering acceptable use, website limits, and user responsibilities.',
                'image' => url('/images/logo/webtoolsstation-logo.png'),
                'publisher' => [
                    '@type' => 'Organization',
                    'name' => 'TJVerce',
                    'url' => url('/'),
                ],
            ],
        ], [
            'title' => 'Terms of Use - WebToolsStation',
            'description' => 'Read the Terms of Use for WebToolsStation by TJVerce, including acceptable use, platform limits, output responsibility, and website rules.',
            'keywords' => 'terms of use webtoolsstation, tjverce terms of use, website use policy',
            'canonical' => url('/terms-of-use'),
            'type' => 'article',
        ]);
    }

    public function sitemap(): Response
    {
        $urls = [
            url('/'),
            url('/about'),
            url('/author.html'),
            url('/contact'),
            url('/privacy-policy'),
            url('/terms-of-use'),
            ...array_map(fn (array $guide): string => url('/guides/' . $guide['slug']), $this->guides()),
            ...array_map(fn (array $tool): string => url('/tools/' . $tool['slug']), $this->tools()),
        ];

        $xml = view('site.sitemap', ['urls' => $urls])->render();

        return response($xml, 200)->header('Content-Type', 'application/xml');
    }

    public function robots(): Response
    {
        $content = "User-agent: *\nAllow: /\n\nSitemap: https://www.webtoolsstation.com/sitemap.xml\n";

        return response($content, 200)->header('Content-Type', 'text/plain');
    }

    private function pageView(array $page, array $seo): View
    {
        return view('site.page', [
            'page' => $page,
            'seo' => array_merge([
                'image' => url('/images/logo/webtoolsstation-logo.png'),
            ], $seo),
            'schema' => $page['schema'] ?? [
                '@context' => 'https://schema.org',
                '@type' => 'WebPage',
                'name' => $seo['title'],
                'url' => $seo['canonical'],
                'description' => $seo['description'],
                'image' => url('/images/logo/webtoolsstation-logo.png'),
                'publisher' => [
                    '@type' => 'Organization',
                    'name' => 'TJVerce',
                    'url' => url('/'),
                    'email' => 'webtoolsstation@gmail.com',
                ],
            ],
        ]);
    }

    private function prepareGuide(array $guide): array
    {
        $metadata = $this->guideMetadata();
        $guideMeta = $metadata['guides'][$guide['slug']] ?? [];
        $guideDepth = $this->guideDepth()[$guide['slug']] ?? [];
        $author = $this->authors()['tj-verse'];

        $guide['author'] = $author;
        $guide['reviewer'] = $metadata['default_reviewer'];
        $guide['published_at'] = $guideMeta['published_at'] ?? now()->toDateString();
        $guide['updated_at'] = $guideMeta['updated_at'] ?? $guide['published_at'];
        $guide['reading_time'] = $guideMeta['reading_time'] ?? '4 min read';
        $guide['image'] = $metadata['image'];
        $guide['field_note'] = $guideDepth['field_note'] ?? null;
        $guide['example'] = $guideDepth['example'] ?? null;
        $guide['checklist'] = $guideDepth['checklist'] ?? [];
        $guide['mistakes'] = $guideDepth['mistakes'] ?? [];
        $guide['limits'] = $guideDepth['limits'] ?? null;
        $guide['code_examples'] = $this->guideCodeExamples($guide['slug']);
        $guide['faq'] = [
            [
                'question' => 'Who should read this guide?',
                'answer' => 'This guide is for visitors who want a practical browser-based workflow for ' . $guide['title'] . ' and want to understand what to check before relying on the result.',
            ],
            [
                'question' => 'Does this replace a full professional workflow?',
                'answer' => 'No. WebToolsStation guides explain quick browser checks, but important legal, security, financial, business, or production work should still be reviewed with the right professional tools and judgment.',
            ],
            [
                'question' => 'Why does this guide include limitations?',
                'answer' => 'Limitations help visitors understand where a lightweight online tool is useful and where a deeper review, backend verification, OCR, testing, or specialist workflow may be needed.',
            ],
        ];

        return $guide;
    }

    private function prepareTool(array $tool): array
    {
        $editorial = $this->toolEditorial()[$tool['slug']] ?? [];
        $depth = $this->toolDepth()[$tool['slug']] ?? [];

        $tool['use_steps'] = $editorial['use_steps'] ?? [
            'Review the description so you know what the tool is meant to do before entering data.',
            'Paste, type, or upload the required input and run the tool once the source looks complete.',
            'Check the result carefully before copying it into another system or workflow.',
        ];

        $tool['use_cases'] = $editorial['use_cases'] ?? [
            'Quick browser-based checks when you need an answer faster than opening a larger application.',
            'Daily work that benefits from one focused page instead of a crowded multi-feature interface.',
            'Short utility tasks where speed and clarity matter more than deep enterprise automation.',
        ];

        $tool['watch_out_for'] = $editorial['watch_out_for'] ?? [
            'Review the output in context, especially when the source data comes from another system.',
            'Lightweight browser tools are helpful for fast checks, but they do not replace full professional workflows in every case.',
            'If the input contains sensitive information, handle the result carefully even when the tool runs locally.',
        ];

        $tool['example_title'] = $editorial['example_title'] ?? 'Practical example';
        $tool['example_body'] = $editorial['example_body'] ?? 'This tool is most useful when you need a focused answer quickly and want to keep the workflow simple.';
        $tool['privacy_note'] = $editorial['privacy_note'] ?? 'This tool is designed to keep the workflow lightweight and browser-first.';
        $tool['common_mistakes'] = $depth['common_mistakes'] ?? [];
        $tool['better_alternative'] = $depth['better_alternative'] ?? [];
        $tool['output_notes'] = $depth['output_notes'] ?? [];
        $tool['updated_at'] = '2026-05-25';
        $tool['faq'] = [
            [
                'question' => 'Is this ' . $tool['title'] . ' free to use?',
                'answer' => 'Yes. This WebToolsStation tool is free to use in your browser and does not require an account.',
            ],
            [
                'question' => 'Does this tool send my input to a server?',
                'answer' => 'The tool is designed as a browser-first utility, so the core action runs on your device instead of requiring a server-side upload for normal use.',
            ],
            [
                'question' => 'When should I double-check the output?',
                'answer' => 'Double-check the output before using it in production systems, sensitive documents, legal work, security decisions, or any workflow where an incorrect result could cause problems.',
            ],
        ];

        $tool['related'] = collect($this->tools())
            ->reject(fn (array $item): bool => $item['slug'] === $tool['slug'])
            ->filter(fn (array $item): bool => $item['category'] === $tool['category'])
            ->take(3)
            ->values()
            ->all();

        $tool['related_guides'] = collect($this->guides())
            ->whereIn('slug', $this->toolGuideMap()[$tool['slug']] ?? [])
            ->values()
            ->all();

        return $tool;
    }
    private function toolGuideMap(): array
    {
        return app(WebToolsStationCatalog::class)->toolGuideMap();
    }

    private function relatedToolsForGuide(string $slug): array
    {
        $toolSlugs = collect($this->toolGuideMap())
            ->filter(fn (array $guideSlugs): bool => in_array($slug, $guideSlugs, true))
            ->keys()
            ->all();

        return collect($this->tools())
            ->whereIn('slug', $toolSlugs)
            ->map(fn (array $tool): array => $this->prepareTool($tool))
            ->take(4)
            ->values()
            ->all();
    }

    private function tools(): array
    {
        return app(WebToolsStationCatalog::class)->tools();
    }

    private function toolEditorial(): array
    {
        return app(WebToolsStationCatalog::class)->toolEditorial();
    }

    private function guideMetadata(): array
    {
        return app(WebToolsStationCatalog::class)->guideMetadata();
    }

    private function guideDepth(): array
    {
        return app(WebToolsStationCatalog::class)->guideDepth();
    }

    private function authors(): array
    {
        return app(WebToolsStationCatalog::class)->authors();
    }

    private function toolDepth(): array
    {
        return app(WebToolsStationCatalog::class)->toolDepth();
    }

    private function guides(): array
    {
        return array_map(fn (array $guide): array => $this->prepareGuide($guide), app(WebToolsStationCatalog::class)->guides());
    }

    private function guideCodeExamples(string $slug): array
    {
        return match ($slug) {
            'how-to-format-json-without-errors' => [
                [
                    'label' => 'Invalid JSON with single quotes and trailing comma',
                    'code' => "{\n  'platform': 'WebToolsStation',\n  'tools': ['json', 'jwt'],\n}",
                ],
                [
                    'label' => 'Valid JSON after cleanup',
                    'code' => "{\n  \"platform\": \"WebToolsStation\",\n  \"tools\": [\"json\", \"jwt\"]\n}",
                ],
            ],
            'common-regex-mistakes-beginners-make' => [
                [
                    'label' => 'Too broad',
                    'code' => '/.+@.+/g',
                ],
                [
                    'label' => 'More careful email-like test',
                    'code' => '/^[^\\s@]+@[^\\s@]+\\.[^\\s@]+$/',
                ],
            ],
            'best-way-to-clean-csv-before-converting-to-json' => [
                [
                    'label' => 'CSV input',
                    'code' => "name,email,role\nAlex,alex@example.com,editor\nSam,sam@example.com,developer",
                ],
                [
                    'label' => 'JSON output',
                    'code' => "[\n  {\"name\":\"Alex\",\"email\":\"alex@example.com\",\"role\":\"editor\"},\n  {\"name\":\"Sam\",\"email\":\"sam@example.com\",\"role\":\"developer\"}\n]",
                ],
            ],
            'best-way-to-check-a-jwt-token', 'why-decoding-a-jwt-is-not-the-same-as-verifying-it' => [
                [
                    'label' => 'JWT sections to inspect',
                    'code' => "header.payload.signature\n\nCheck payload claims such as:\n{\n  \"iss\": \"https://example.com\",\n  \"aud\": \"web-app\",\n  \"exp\": 1770000000\n}",
                ],
            ],
            'how-to-read-unix-timestamps-in-real-logs' => [
                [
                    'label' => 'Log timestamp examples',
                    'code' => "Seconds:      1770000000\nMilliseconds: 1770000000000\nUTC output:   2026-02-02 16:00:00 UTC",
                ],
            ],
            'when-to-use-url-encoding-in-api-and-form-work' => [
                [
                    'label' => 'Query value before and after encoding',
                    'code' => "Raw value: PDF tools & JSON formatter\nEncoded:   PDF%20tools%20%26%20JSON%20formatter",
                ],
            ],
            'when-to-use-base64-encoding-and-decoding' => [
                [
                    'label' => 'Base64 example',
                    'code' => "Text: WebToolsStation\nBase64: V2ViVG9vbHNTdGF0aW9u",
                ],
            ],
            'how-to-use-hex-and-rgb-colors-correctly', 'how-to-tell-if-color-conversion-results-are-correct' => [
                [
                    'label' => 'CSS color equivalents',
                    'code' => "HEX: #006DBF\nRGB: rgb(0, 109, 191)\nHSL: hsl(206, 100%, 37%)",
                ],
            ],
            'how-to-clean-text-for-urls-and-slugs', 'what-makes-a-url-slug-good-for-users-and-seo' => [
                [
                    'label' => 'Slug cleanup example',
                    'code' => "Title: How to Format JSON Without Errors\nSlug:  how-to-format-json-without-errors",
                ],
            ],
            'how-to-compare-text-differences-quickly' => [
                [
                    'label' => 'Two text versions',
                    'code' => "Old: Upload a PDF and inspect metadata.\nNew: Upload a PDF and inspect document metadata.",
                ],
            ],
            'how-line-sorting-helps-clean-messy-lists-fast' => [
                [
                    'label' => 'Before and after sorting',
                    'code' => "Before:\nzebra\nApple\nbanana\n\nAfter:\nApple\nbanana\nzebra",
                ],
            ],
            'how-to-use-a-word-counter-for-real-editing-work' => [
                [
                    'label' => 'Editing measurement example',
                    'code' => "Draft intro: 184 words\nFinal intro: 96 words\nReason: removed repeated setup before the practical steps",
                ],
            ],
            'how-to-use-a-password-generator-well', 'how-to-check-if-a-password-is-actually-strong' => [
                [
                    'label' => 'Password habit comparison',
                    'code' => "Weak pattern: Summer2026!\nBetter habit: unique generated password + password manager + MFA",
                ],
            ],
            'what-pdf-metadata-can-tell-you', 'how-to-review-pdf-metadata-before-sharing-a-file', 'why-pdf-text-search-fails-on-some-files' => [
                [
                    'label' => 'PDF review signals',
                    'code' => "File: contract-draft.pdf\nPages: 12\nAuthor: Internal User\nCreator: Office Export\nText layer: selectable or scanned image",
                ],
            ],
            default => [
                [
                    'label' => 'Practical input and output check',
                    'code' => "Input: paste the source value into the related WebToolsStation tool\nOutput: review the result, compare it with the original task, and double-check before production use",
                ],
            ],
        };
    }
}
