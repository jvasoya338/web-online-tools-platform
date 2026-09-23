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
        $categories = $this->categories();

        return view('site.home', [
            'tools' => $tools,
            'categories' => $categories,
            'featuredTools' => array_slice($tools, 0, 6),
            'latestGuides' => array_slice($guides, -6),
            'toolCount' => count($tools),
            'pdfCount' => count(array_filter($tools, fn (array $tool): bool => $tool['category'] === 'PDF Tools')),
            'seo' => [
                'title' => 'Free Online Browser Tools for Developers, PDFs and Text | WebToolsStation',
                'description' => 'Use free online browser tools for JSON, JWT, Base64, regex, timestamps, UUIDs, text cleanup, colors, images and PDF checks. Built for users in the US, UK, Europe and worldwide.',
                'keywords' => 'free online tools, browser tools, developer tools online, pdf tools online, json formatter, jwt decoder, regex tester, uuid generator, pdf page counter, webtoolsstation',
                'canonical' => url('/'),
                'type' => 'website',
                'image' => url('/images/logo/webtoolsstation-logo.png'),
            ],
            'schema' => [
                '@context' => 'https://schema.org',
                '@graph' => [
                    $this->organizationSchema(),
                    [
                        '@type' => 'WebSite',
                        '@id' => url('/#website'),
                        'name' => 'WebToolsStation',
                        'url' => url('/'),
                        'description' => 'Free online browser tools for developer, PDF, text, image, color, and data cleanup workflows.',
                        'inLanguage' => 'en',
                        'isAccessibleForFree' => true,
                        'publisher' => [
                            '@id' => url('/#organization'),
                        ],
                        'audience' => [
                            '@type' => 'Audience',
                            'audienceType' => 'Developers, students, creators, editors, and business users in the US, UK, Europe, and worldwide',
                        ],
                    ],
                    [
                        '@type' => 'ItemList',
                        '@id' => url('/#tools'),
                        'name' => 'Free online tools on WebToolsStation',
                        'itemListElement' => array_map(fn (array $tool, int $index): array => [
                            '@type' => 'ListItem',
                            'position' => $index + 1,
                            'name' => $tool['title'],
                            'url' => url('/tools/' . $tool['slug']),
                        ], $tools, array_keys($tools)),
                    ],
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
                'title' => $this->toolSeoTitle($tool),
                'description' => $this->toolSeoDescription($tool),
                'keywords' => implode(', ', $tool['keywords']),
                'canonical' => url('/tools/' . $tool['slug']),
                'type' => 'website',
                'image' => url('/images/logo/webtoolsstation-logo.png'),
            ],
            'schema' => [
                '@context' => 'https://schema.org',
                '@graph' => [
                    $this->organizationSchema(),
                    [
                        '@type' => 'WebPage',
                        '@id' => url('/tools/' . $tool['slug'] . '#webpage'),
                        'name' => $this->toolSeoTitle($tool),
                        'url' => url('/tools/' . $tool['slug']),
                        'description' => $this->toolSeoDescription($tool),
                        'inLanguage' => 'en',
                        'dateModified' => $tool['updated_at'],
                        'isPartOf' => [
                            '@id' => url('/#website'),
                        ],
                    ],
                    [
                        '@type' => 'SoftwareApplication',
                        '@id' => url('/tools/' . $tool['slug'] . '#software'),
                        'name' => $tool['title'],
                        'applicationCategory' => $tool['category'],
                        'operatingSystem' => 'Any',
                        'description' => $this->toolSeoDescription($tool),
                        'url' => url('/tools/' . $tool['slug']),
                        'image' => url('/images/logo/webtoolsstation-logo.png'),
                        'softwareVersion' => 'Browser-based web tool',
                        'inLanguage' => 'en',
                        'isAccessibleForFree' => true,
                        'dateModified' => $tool['updated_at'],
                        'featureList' => array_values(array_merge($tool['details'], $tool['use_steps'])),
                        'offers' => [
                            '@type' => 'Offer',
                            'price' => '0',
                            'priceCurrency' => 'USD',
                        ],
                        'publisher' => [
                            '@id' => url('/#organization'),
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
                                'name' => $tool['category'],
                                'item' => url('/categories/' . $tool['category_slug']),
                            ],
                            [
                                '@type' => 'ListItem',
                                'position' => 3,
                                'name' => $tool['title'],
                                'item' => url('/tools/' . $tool['slug']),
                            ],
                        ],
                    ],
                ],
            ],
        ]);
    }


    public function category(string $slug): View
    {
        $categories = $this->categories();
        $category = $categories[$slug] ?? null;

        abort_if(!$category, 404);

        $tools = collect($this->tools())
            ->filter(fn (array $tool): bool => $tool['category'] === $category['category_key'])
            ->map(fn (array $tool): array => $this->prepareTool($tool))
            ->values()
            ->all();

        $toolSlugs = array_column($tools, 'slug');
        $guideMap = $this->toolGuideMap();
        $relatedGuideSlugs = [];
        foreach ($toolSlugs as $tSlug) {
            if (!empty($guideMap[$tSlug])) {
                $relatedGuideSlugs = array_merge($relatedGuideSlugs, $guideMap[$tSlug]);
            }
        }
        $relatedGuideSlugs = array_unique($relatedGuideSlugs);

        $relatedGuides = collect($this->guides())
            ->whereIn('slug', $relatedGuideSlugs)
            ->take(6)
            ->values()
            ->all();

        return view('site.category', [
            'category' => $category,
            'tools' => $tools,
            'relatedGuides' => $relatedGuides,
            'toolCount' => count($tools),
            'seo' => [
                'title' => $category['name'] . ' - Free Online Browser Utilities | WebToolsStation',
                'description' => $category['description'],
                'keywords' => strtolower($category['name']) . ', free online tools, browser tools, webtoolsstation',
                'canonical' => url('/categories/' . $category['slug']),
                'type' => 'website',
                'image' => url('/images/logo/webtoolsstation-logo.png'),
            ],
            'schema' => [
                '@context' => 'https://schema.org',
                '@graph' => [
                    $this->organizationSchema(),
                    [
                        '@type' => 'CollectionPage',
                        '@id' => url('/categories/' . $category['slug'] . '#collection'),
                        'name' => $category['name'],
                        'url' => url('/categories/' . $category['slug']),
                        'description' => $category['description'],
                        'inLanguage' => 'en',
                        'isPartOf' => [
                            '@id' => url('/#website'),
                        ],
                    ],
                    [
                        '@type' => 'ItemList',
                        '@id' => url('/categories/' . $category['slug'] . '#tools'),
                        'name' => $category['name'] . ' on WebToolsStation',
                        'itemListElement' => array_map(fn (array $t, int $i): array => [
                            '@type' => 'ListItem',
                            'position' => $i + 1,
                            'name' => $t['title'],
                            'url' => url('/tools/' . $t['slug']),
                        ], $tools, array_keys($tools)),
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
                                'name' => $category['name'],
                                'item' => url('/categories/' . $category['slug']),
                            ],
                        ],
                    ],
                ],
            ],
        ]);
    }

    public function collection(string $slug): View
    {
        $collections = $this->collections();
        $collection = $collections[$slug] ?? null;

        abort_if(!$collection, 404);

        $curatedSlugs = $collection['curated_tools'] ?? [];
        $tools = collect($this->tools())
            ->filter(fn (array $tool): bool => in_array($tool['slug'], $curatedSlugs))
            ->map(fn (array $tool): array => $this->prepareTool($tool))
            ->values()
            ->all();

        return view('site.collection', [
            'collection' => $collection,
            'tools' => $tools,
            'seo' => [
                'title' => $collection['title'] . ' | WebToolsStation',
                'description' => $collection['seo_description'],
                'keywords' => strtolower($collection['short_title']) . ', developer tools online, browser utilities, webtoolsstation',
                'canonical' => url('/collections/' . $collection['slug']),
                'type' => 'website',
                'image' => url('/images/logo/webtoolsstation-logo.png'),
            ],
            'schema' => [
                '@context' => 'https://schema.org',
                '@graph' => [
                    $this->organizationSchema(),
                    [
                        '@type' => 'CollectionPage',
                        '@id' => url('/collections/' . $collection['slug'] . '#collection'),
                        'name' => $collection['title'],
                        'url' => url('/collections/' . $collection['slug']),
                        'description' => $collection['seo_description'],
                        'inLanguage' => 'en',
                        'isAccessibleForFree' => true,
                        'mainEntity' => [
                            '@type' => 'ItemList',
                            'itemListElement' => array_map(fn (array $tool, int $index): array => [
                                '@type' => 'ListItem',
                                'position' => $index + 1,
                                'url' => url('/tools/' . $tool['slug']),
                                'name' => $tool['title'],
                            ], $tools, array_keys($tools)),
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
                        ], $collection['faq']),
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
                                'name' => 'Collections',
                                'item' => url('/collections/' . $collection['slug']),
                            ],
                            [
                                '@type' => 'ListItem',
                                'position' => 3,
                                'name' => $collection['short_title'],
                                'item' => url('/collections/' . $collection['slug']),
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
            'intro' => 'WebToolsStation is a product from TJ Verse. We created it with a very simple idea in mind: useful online tools should feel trustworthy, fast, and easy to understand from the first click. Too many utility websites feel crowded, confusing, or overloaded with unnecessary noise. We wanted to build something cleaner. Our goal is to give people practical tools they can use in seconds while also giving the platform enough depth, structure, and clarity to grow into a reliable destination over time.',
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
                        'WebToolsStation is operated by TJ Verse. The site is maintained as a focused tools and publishing project rather than an anonymous script directory. That means we review how pages read, how tools behave in the browser, and whether the surrounding explanations are clear enough for normal users to trust what they are seeing.',
                        'The goal is not to publish as many pages as possible. The goal is to publish tools and supporting guides that solve practical problems in a way that feels understandable, maintained, and honest about limitations. When a page needs more explanation, examples, or review notes, we would rather improve it than pretend a thin page is finished.',
                    ],
                ],
                [
                    'heading' => 'How we think about quality',
                    'paragraphs' => [
                        'At TJ Verse, we care about the difference between having a page and having a useful page. A useful page answers questions, solves tasks, and reduces friction. We review our tools with that mindset. If a tool feels vague, visually messy, or hard to trust, it needs more work. If content feels thin, it needs more substance. If a page creates confusion, it needs simplification.',
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
                        'The long-term vision for WebToolsStation is a carefully built platform with strong utility pages, strong content, and a professional public presence. We want the site to feel good enough for regular visitors, clear enough for search engines to understand, and dependable enough for everyday use by developers, creators, and business users worldwide. That means continuing to improve page quality, clarity, accuracy, and visual consistency.',
                        'As the platform grows, we will keep refining the tool set, page structure, and content quality. We want visitors to feel that the website has direction and care behind it. WebToolsStation is not meant to be a random collection of scripts. It is meant to become a stable and attractive online destination for practical work. That is the standard TJ Verse wants to build toward.',
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
                ['title' => 'Company', 'value' => 'TJ Verse'],
                ['title' => 'Platform', 'value' => 'WebToolsStation'],
                ['title' => 'Operator', 'value' => 'TJ Verse editorial and product team'],
                ['title' => 'Focus', 'value' => 'Useful online tools with clear design and practical guidance'],
                ['title' => 'Contact', 'value' => 'webtoolsstation@gmail.com'],
            ],
            'schema' => [
                '@context' => 'https://schema.org',
                '@type' => 'AboutPage',
                'name' => 'About WebToolsStation',
                'url' => url('/about'),
                'description' => 'Learn about WebToolsStation, what it publishes, and how TJ Verse approaches tool quality and trust.',
                'image' => url('/images/logo/webtoolsstation-logo.png'),
                'publisher' => [
                    '@type' => 'Organization',
                    'name' => 'TJ Verse',
                    'url' => url('/'),
                ],
                'mainEntity' => [
                    '@type' => 'Organization',
                    'name' => 'TJ Verse',
                    'url' => url('/'),
                    'email' => 'webtoolsstation@gmail.com',
                ],
            ],
        ], [
            'title' => 'About WebToolsStation - Free Online Tools by TJ Verse',
            'description' => 'Learn how WebToolsStation by TJ Verse builds free browser tools, practical guides, privacy-aware workflows, and trusted utility pages for global users.',
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
                'title' => 'Practical Web Tool Guides with Examples | WebToolsStation',
                'description' => 'Browse practical guides for JSON, JWT, Base64, regex, passwords, timestamps, PDFs, color conversion, slugs, and browser-based web workflows.',
                'keywords' => 'web tool guides, developer tool guides, pdf tool guides, json jwt base64 articles, browser workflow guides',
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
                    'name' => 'TJ Verse',
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
                'title' => $author['name'] . ' - Founder and Editor of WebToolsStation',
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
                    'name' => 'TJ Verse',
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
                'title' => 'Contact WebToolsStation Support and Editorial Team',
                'description' => 'Contact WebToolsStation for support, tool suggestions, content corrections, partnerships, advertising questions, and platform feedback.',
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
                'company' => 'TJ Verse',
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
                'title' => $this->guideSeoTitle($guide),
                'description' => $this->guideSeoDescription($guide),
                'keywords' => implode(', ', $guide['keywords']),
                'canonical' => url('/guides/' . $guide['slug']),
                'type' => 'article',
                'image' => $guide['image'],
                'author' => $guide['author']['name'] . ', WebToolsStation',
            ],
            'schema' => [
                '@context' => 'https://schema.org',
                '@graph' => [
                    $this->organizationSchema(),
                    [
                        '@type' => 'Article',
                        '@id' => url('/guides/' . $guide['slug'] . '#article'),
                        'headline' => $guide['title'],
                        'description' => $this->guideSeoDescription($guide),
                        'image' => [$guide['image']],
                        'inLanguage' => 'en',
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
                        'articleSection' => 'Web tools and browser workflow guides',
                        'keywords' => $guide['keywords'],
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
            'intro' => 'This Privacy Policy explains how TJ Verse operates WebToolsStation and describes the types of information that may be handled when you use the website. We believe a privacy page should be clear enough for normal users to understand, while still being complete enough to explain the essential responsibilities of the platform. The purpose of this policy is to show how the website works, what kinds of data may be collected, and how communication and technical activity may be managed.',
            'sections' => [
                [
                    'heading' => 'Who operates this platform',
                    'paragraphs' => [
                        'WebToolsStation is operated by TJ Verse. Throughout this policy, references to “we,” “our,” or “us” refer to TJ Verse and the WebToolsStation platform. References to “you” refer to visitors, users, and anyone who accesses the website or contacts us through the available public channels.',
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
                        'Because websites change, this Privacy Policy may also change. When the platform grows or our practices become more detailed, we may revise the text to better explain those changes. If you have questions about this policy, you can contact TJ Verse at webtoolsstation@gmail.com.',
                    ],
                ],
            ],
            'cards' => [
                ['title' => 'Operator', 'value' => 'TJ Verse'],
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
                    'name' => 'TJ Verse',
                    'url' => url('/'),
                ],
            ],
        ], [
            'title' => 'Privacy Policy - WebToolsStation',
            'description' => 'Read the Privacy Policy for WebToolsStation by TJ Verse, including how browser-based tools, cookies, technical information, and contact messages are handled.',
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
                        'WebToolsStation is owned and operated by TJ Verse. By accessing the platform, viewing its pages, or using its tools, you agree to follow these Terms of Use. If you do not agree with these terms, you should stop using the website.',
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
                        'The WebToolsStation brand, design, written content, page structure, and platform presentation are part of the TJ Verse website offering unless otherwise stated. You should not copy, republish, or misuse original platform content in a way that infringes our rights or misrepresents the source.',
                        'Normal use of the public website is permitted, but that does not grant ownership of the platform, its identity, or its original materials. If you want to discuss collaboration, licensing, or business use beyond normal browsing, please contact us directly.',
                    ],
                ],
                [
                    'heading' => 'Limitation and contact',
                    'paragraphs' => [
                        'To the extent permitted by applicable law, WebToolsStation and TJ Verse provide the website on an as available and as is basis. We do not make broad warranties that the platform will always meet every expectation or every use case. We aim for quality and usefulness, but users should still evaluate results in context.',
                        'If you have questions about these Terms of Use, you can contact TJ Verse at webtoolsstation@gmail.com. Continued use of the website after updates to these terms may be treated as acceptance of the revised version.',
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
                ['title' => 'Owner', 'value' => 'TJ Verse'],
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
                    'name' => 'TJ Verse',
                    'url' => url('/'),
                ],
            ],
        ], [
            'title' => 'Terms of Use - WebToolsStation',
            'description' => 'Read the Terms of Use for WebToolsStation by TJ Verse, including acceptable use, platform limits, output responsibility, and website rules.',
            'keywords' => 'terms of use webtoolsstation, tjverce terms of use, website use policy',
            'canonical' => url('/terms-of-use'),
            'type' => 'article',
        ]);
    }


    public function disclaimer(): View
    {
        return $this->pageView([
            'label' => 'Legal Disclaimer',
            'title' => 'Disclaimer of Warranties, Tool Use, and Output Verification',
            'intro' => 'This Disclaimer outlines the operational scope, technical boundaries, and usage expectations for WebToolsStation by TJ Verse. By accessing or using the browser-based tools, calculators, converters, and guides provided on this platform, you acknowledge and agree to the terms described below.',
            'sections' => [
                [
                    'heading' => 'For Informational and Utility Purposes Only',
                    'paragraphs' => [
                        'WebToolsStation provides online tools, utilities, formatting functions, data converters, and educational guides for general informational, educational, and workflow convenience purposes only. Nothing on this website constitutes legal advice, financial advice, cybersecurity certification, cryptographic compliance, or professional engineering consultation.',
                        'While we strive to ensure that formatting algorithms, converters, and calculations operate accurately according to standard specifications (such as RFC 8259 for JSON, RFC 7519 for JWT, or RFC 4648 for Base64), software anomalies, browser-specific execution variations, and input idiosyncrasies can occur. Users must independently evaluate and verify all outputs before deploying them in production systems, legal contracts, or critical business operations.',
                    ],
                ],
                [
                    'heading' => 'No Guarantee of Accuracy or Fitness for a Particular Purpose',
                    'paragraphs' => [
                        'All tools and content on WebToolsStation are provided on an "as is" and "as available" basis without warranties of any kind, whether express, implied, statutory, or otherwise. TJ Verse expressly disclaims all implied warranties of merchantability, fitness for a particular purpose, non-infringement, and title.',
                        'We do not warrant that tool functions will be uninterrupted, error-free, compatible with all devices and file versions, or that defects will be immediately corrected. You assume total responsibility and risk for your use of the website and any actions taken based on tool results.',
                    ],
                ],
                [
                    'heading' => 'Client-Side Browser Execution and Data Privacy',
                    'paragraphs' => [
                        'Many utilities on WebToolsStation (including text formatting, color conversion, hash computation, and PDF inspection) are engineered to process data client-side within your browser runtime using standard Web APIs (such as the Web Cryptography API, Canvas API, and WebAssembly). This design reduces latency and avoids sending your data to external servers for standard operations.',
                        'However, users are solely responsible for ensuring that they do not input confidential corporate trade secrets, unprotected personally identifiable information (PII), or regulated data into any browser environment on an untrusted or insecure device. We strongly recommend testing workflows with sanitized sample data before processing sensitive production values.',
                    ],
                ],
                [
                    'heading' => 'Token Decoding and Cryptographic Verification Boundaries',
                    'paragraphs' => [
                        'Tools such as the JWT Decoder are designed exclusively for inspecting readable header and payload claims during local development and debugging. Decoding a token does not verify its cryptographic signature, validate that the signing key is authentic, or confirm that the issuing authority has not revoked the credential. Cryptographic verification must always be enforced within your secure application backend using trusted public keys or secrets.',
                        'Similarly, cryptographic hash generators (such as SHA-256) generate deterministic message digests based on provided text. They cannot decrypt, reverse, or validate the authenticity or safety of underlying data without authorized external verification mechanisms.',
                    ],
                ],
                [
                    'heading' => 'Third-Party Links and External Services',
                    'paragraphs' => [
                        'WebToolsStation may contain links to external websites, documentation repositories, RFC specifications, or third-party resources for convenience and reference. TJ Verse exercises no control over, and assumes no responsibility for, the content, privacy policies, practices, or availability of any third-party websites or services. Inclusion of a link does not imply endorsement.',
                    ],
                ],
                [
                    'heading' => 'Limitation of Liability',
                    'paragraphs' => [
                        'To the maximum extent permitted by applicable law, in no event shall TJ Verse, WebToolsStation, its operators, contributors, or affiliates be liable for any direct, indirect, incidental, consequential, special, punitive, or exemplary damages—including but not limited to loss of profits, lost data, business interruption, production downtime, system errors, or security breaches—arising out of or in connection with your access to, use of, or inability to use the platform or its tools.',
                        'If you have questions regarding this Disclaimer or wish to report an unexpected calculation or tool behavior, please contact us at webtoolsstation@gmail.com.',
                    ],
                ],
            ],
            'cards' => [
                ['title' => 'Platform', 'value' => 'WebToolsStation'],
                ['title' => 'Operator', 'value' => 'TJ Verse'],
                ['title' => 'Warranty Status', 'value' => 'Provided "As-Is" Without Warranties'],
                ['title' => 'Inquiries', 'value' => 'webtoolsstation@gmail.com'],
            ],
            'schema' => [
                '@context' => 'https://schema.org',
                '@type' => 'WebPage',
                'name' => 'Legal Disclaimer - WebToolsStation',
                'url' => url('/disclaimer'),
                'description' => 'Legal disclaimer for WebToolsStation covering tool accuracy, browser execution, liability limits, and output verification.',
                'image' => url('/images/logo/webtoolsstation-logo.png'),
                'publisher' => [
                    '@type' => 'Organization',
                    'name' => 'TJ Verse',
                    'url' => url('/'),
                ],
            ],
        ], [
            'title' => 'Disclaimer - WebToolsStation',
            'description' => 'Read the Legal Disclaimer for WebToolsStation covering browser tool accuracy, client-side processing, limitation of liability, and output verification.',
            'keywords' => 'disclaimer webtoolsstation, tools disclaimer, liability limits, output verification',
            'canonical' => url('/disclaimer'),
            'type' => 'article',
        ]);
    }

    public function cookiePolicy(): View
    {
        return $this->pageView([
            'label' => 'Cookie Policy',
            'title' => 'How WebToolsStation Uses Cookies, Local Storage, and Analytics',
            'intro' => 'This Cookie Policy explains how WebToolsStation by TJ Verse uses cookies, local browser storage, and related web technologies when you browse our tools, read our guides, and interact with the platform. We believe in clear, transparent disclosure so visitors understand exactly what data is stored on their devices and how to control it.',
            'sections' => [
                [
                    'heading' => 'What Are Cookies and Local Storage?',
                    'paragraphs' => [
                        'Cookies are small text files that websites place on your computer or mobile device through your web browser. They allow websites to recognize your device, remember preferences, maintain sessions, and understand how pages are navigated.',
                        'Local Storage (HTML5 Web Storage) is a related browser technology that allows web applications to store key-value data directly on your device with no expiration date unless cleared. WebToolsStation utilizes local storage for user interface preferences, such as remembering your consent choice on the cookie notification banner (cookie_ok).',
                    ],
                ],
                [
                    'heading' => 'Categories of Cookies and Storage We Use',
                    'paragraphs' => [
                        'Strictly Essential Storage: These items are necessary for the website to function properly. For example, local storage key "cookie_ok" stores your acknowledgment of our cookie disclosure so you are not repeatedly prompted with the banner on every page visit.',
                        'Measurement and Analytics: We use Google Analytics (measurement ID G-R5ZD94KR5T) to gather aggregated, non-personally identifiable statistics about website traffic, popular tools, referring domains, browser types, and general geographical regions. These measurement cookies (such as _ga and _ga_*) help us understand platform reliability and identify which tools need performance improvements.',
                        'Advertising Technologies: When advertising services such as Google AdSense are active on the website, Google and third-party advertising partners may use cookies (such as the DoubleClick cookie) to serve ads based on prior visits to this or other websites. These technologies help deliver relevant advertising to support the free operation of the platform.',
                    ],
                ],
                [
                    'heading' => 'Browser-Based Tools Do Not Transmit Input to Cookies',
                    'paragraphs' => [
                        'It is important to understand that the text, files, tokens, or codes you enter into our interactive browser utilities (such as the JSON Formatter, Base64 Converter, or PDF Viewer) are never stored in cookies or transmitted to analytics cookies. Interactive tool state is processed in volatile browser memory during your active tab session and discarded when you close or refresh the page.',
                    ],
                ],
                [
                    'heading' => 'How to Control and Manage Cookies',
                    'paragraphs' => [
                        'You have the right to accept, reject, or delete cookies at any time. Most modern browsers allow you to control cookies through their settings preferences. You can configure your browser to block third-party cookies, clear cookies when closing the browser, or alert you before a cookie is set.',
                        'You can also opt out of Google Analytics tracking across all websites by installing the official Google Analytics Opt-out Browser Add-on provided by Google. To learn more about how Google uses data in advertising, you can visit Google Advertising Privacy and Terms page.',
                    ],
                ],
                [
                    'heading' => 'Updates to This Cookie Policy',
                    'paragraphs' => [
                        'We may update this Cookie Policy from time to time to reflect changes in our technical practices, new tool features, or evolving regulatory guidelines. When updates occur, the revision date at the top of this page will be updated accordingly.',
                        'If you have questions about our use of cookies or browser storage technologies, you can contact TJ Verse at webtoolsstation@gmail.com.',
                    ],
                ],
            ],
            'cards' => [
                ['title' => 'Platform', 'value' => 'WebToolsStation'],
                ['title' => 'Operator', 'value' => 'TJ Verse'],
                ['title' => 'Analytics Partner', 'value' => 'Google Analytics (G-R5ZD94KR5T)'],
                ['title' => 'Questions', 'value' => 'webtoolsstation@gmail.com'],
            ],
            'schema' => [
                '@context' => 'https://schema.org',
                '@type' => 'WebPage',
                'name' => 'Cookie Policy - WebToolsStation',
                'url' => url('/cookie-policy'),
                'description' => 'Cookie Policy for WebToolsStation covering cookies, local storage, analytics, and user preference controls.',
                'image' => url('/images/logo/webtoolsstation-logo.png'),
                'publisher' => [
                    '@type' => 'Organization',
                    'name' => 'TJ Verse',
                    'url' => url('/'),
                ],
            ],
        ], [
            'title' => 'Cookie Policy - WebToolsStation',
            'description' => 'Read the Cookie Policy for WebToolsStation explaining how cookies, local storage, Google Analytics, and advertising technologies are used.',
            'keywords' => 'cookie policy webtoolsstation, website cookies, local storage, analytics policy',
            'canonical' => url('/cookie-policy'),
            'type' => 'article',
        ]);
    }

    public function sitemap(): Response
    {
        $today = now()->toDateString();

        $urls = [
            ['loc' => url('/'), 'lastmod' => $today, 'changefreq' => 'daily', 'priority' => '1.0'],
            ['loc' => url('/guides'), 'lastmod' => $today, 'changefreq' => 'weekly', 'priority' => '0.9'],
            ['loc' => url('/authors/tj-verse'), 'lastmod' => '2026-08-07', 'changefreq' => 'monthly', 'priority' => '0.8'],
            ['loc' => url('/about'), 'lastmod' => '2026-08-07', 'changefreq' => 'monthly', 'priority' => '0.7'],
            ['loc' => url('/contact'), 'lastmod' => '2026-08-07', 'changefreq' => 'monthly', 'priority' => '0.7'],
            ['loc' => url('/privacy-policy'), 'lastmod' => '2026-08-07', 'changefreq' => 'monthly', 'priority' => '0.6'],
            ['loc' => url('/terms-of-use'), 'lastmod' => '2026-08-07', 'changefreq' => 'monthly', 'priority' => '0.6'],
            ['loc' => url('/disclaimer'), 'lastmod' => $today, 'changefreq' => 'monthly', 'priority' => '0.6'],
            ['loc' => url('/cookie-policy'), 'lastmod' => $today, 'changefreq' => 'monthly', 'priority' => '0.6'],
            ...array_map(fn (array $category): array => [
                'loc' => url('/categories/' . $category['slug']),
                'lastmod' => $today,
                'changefreq' => 'weekly',
                'priority' => '0.9',
            ], $this->categories()),
            ...array_map(fn (array $collection): array => [
                'loc' => url('/collections/' . $collection['slug']),
                'lastmod' => $today,
                'changefreq' => 'weekly',
                'priority' => '0.85',
            ], $this->collections()),
            ...array_map(fn (array $guide): array => [
                'loc' => url('/guides/' . $guide['slug']),
                'lastmod' => $guide['updated_at'],
                'changefreq' => 'monthly',
                'priority' => '0.8',
            ], $this->guides()),
            ...array_map(fn (array $tool): array => [
                'loc' => url('/tools/' . $tool['slug']),
                'lastmod' => '2026-08-07',
                'changefreq' => 'monthly',
                'priority' => '0.8',
            ], $this->tools()),
        ];

        $xml = view('site.sitemap', ['urls' => $urls])->render();

        return response($xml, 200)->header('Content-Type', 'application/xml');
    }

    public function robots(): Response
    {
        $content = "User-agent: *\nAllow: /\n\nUser-agent: Mediapartners-Google\nAllow: /\n\nUser-agent: Googlebot\nAllow: /\n\nSitemap: https://webtoolsstation.com/sitemap.xml\n";

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
                    'name' => 'TJ Verse',
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

        $categoryMap = [
            'Developer Tools' => 'developer-tools',
            'Text Tools' => 'text-tools',
            'Image Tools' => 'image-tools',
            'Security Tools' => 'security-tools',
            'PDF Tools' => 'pdf-tools',
            'SEO Tools' => 'seo-tools',
            'Web Tools' => 'web-tools',
            'Color Tools' => 'color-tools',
            'Calculators' => 'calculators',
            'AI Developer Tools' => 'ai-developer-tools',
        ];
        $tool['category_slug'] = $categoryMap[$tool['category']] ?? 'developer-tools';

        $tool['summary'] = $tool['summary'] ?? ($tool['meta_description'] ?? $tool['description'] ?? $tool['title']);
        $tool['description'] = $tool['description'] ?? $tool['summary'];
        $tool['seo_description'] = $tool['seo_description'] ?? ($tool['meta_description'] ?? $tool['summary']);
        $tool['keywords'] = $tool['keywords'] ?? [strtolower($tool['title']), 'online tool', 'free utility', 'browser tool'];
        $tool['details'] = $tool['details'] ?? [
            '100% browser-based execution',
            'Zero server upload or logging',
            'Immediate real-time results'
        ];
        $tool['cta_text'] = $tool['cta_text'] ?? ('Run ' . $tool['title']);

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

        $tool['example_title'] = $editorial['example_title'] ?? 'Practical Workflow Example';
        $tool['example_body'] = $editorial['example_body'] ?? 'This tool is most useful when you need a focused answer quickly and want to keep the workflow simple.';
        $tool['privacy_note'] = $editorial['privacy_note'] ?? 'This tool is designed to keep the workflow lightweight and browser-first.';
        $tool['technical_notes'] = $editorial['technical_notes'] ?? null;
        $tool['worked_example'] = $editorial['worked_example'] ?? null;
        $tool['common_mistakes'] = $depth['common_mistakes'] ?? [];
        $tool['better_alternative'] = $depth['better_alternative'] ?? [];
        $tool['output_notes'] = $depth['output_notes'] ?? [];
        $tool['updated_at'] = '2026-08-07';
        $tool['seo_title'] = $this->toolSeoTitle($tool);
        $tool['seo_description_full'] = $this->toolSeoDescription($tool);
        $tool['faq'] = $editorial['faq'] ?? [
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

    private function toolSeoTitle(array $tool): string
    {
        return $tool['title'] . ' Online - Free, Fast Browser Tool | WebToolsStation';
    }

    private function toolSeoDescription(array $tool): string
    {
        $desc = $tool['seo_description'] ?? $tool['meta_description'] ?? $tool['description'] ?? $tool['summary'] ?? $tool['title'];
        return rtrim($desc, '.') . '. Free browser tool with no sign-up, clear examples, and practical workflow notes.';
    }

    private function guideSeoTitle(array $guide): string
    {
        return $guide['title'] . ' - Practical Examples | WebToolsStation';
    }

    private function guideSeoDescription(array $guide): string
    {
        return $guide['seo_description'] . ' Includes examples, common mistakes, limitations, and practical browser workflow tips.';
    }

    private function organizationSchema(): array
    {
        return [
            '@type' => 'Organization',
            '@id' => url('/#organization'),
            'name' => 'WebToolsStation',
            'alternateName' => 'TJ Verse WebToolsStation',
            'url' => url('/'),
            'email' => 'webtoolsstation@gmail.com',
            'logo' => [
                '@type' => 'ImageObject',
                'url' => url('/images/logo/webtoolsstation-logo.png'),
            ],
            'sameAs' => [
                'https://tjverse.group/',
            ],
            'areaServed' => [
                ['@type' => 'Country', 'name' => 'United States'],
                ['@type' => 'Country', 'name' => 'United Kingdom'],
                ['@type' => 'Place', 'name' => 'Europe'],
                ['@type' => 'Place', 'name' => 'Worldwide'],
            ],
            'knowsAbout' => [
                'Developer tools',
                'PDF tools',
                'JSON formatting',
                'JWT decoding',
                'Regular expressions',
                'Text conversion',
                'Browser-based utilities',
            ],
        ];
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
    private function categories(): array
    {
        return app(WebToolsStationCatalog::class)->categories();
    }

    private function collections(): array
    {
        return app(WebToolsStationCatalog::class)->collections();
    }
}
