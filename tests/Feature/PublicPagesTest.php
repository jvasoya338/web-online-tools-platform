<?php

namespace Tests\Feature;

use Tests\TestCase;

class PublicPagesTest extends TestCase
{
    public function test_core_public_pages_return_successful_responses(): void
    {
        $routes = [
            '/',
            '/authors/tj-verse',
            '/about',
            '/contact',
            '/privacy-policy',
            '/terms-of-use',
            '/disclaimer',
            '/cookie-policy',
            '/categories/developer-tools',
            '/categories/text-tools',
            '/categories/image-tools',
            '/categories/security-tools',
            '/categories/pdf-tools',
            '/categories/data-tools',
            '/categories/encode-decode',
            '/categories/seo-tools',
            '/categories/web-tools',
            '/categories/color-tools',
            '/categories/calculators',
            '/categories/ai-developer-tools',
            '/sitemap.xml',
            '/robots.txt',
        ];

        foreach ($routes as $route) {
            $this->get($route)->assertOk();
        }
    }

    public function test_category_pages_render_tools_and_metadata(): void
    {
        $this->get('/categories/developer-tools')
            ->assertOk()
            ->assertSee('Developer Tools')
            ->assertSee('JSON Formatter')
            ->assertSee('CollectionPage')
            ->assertSee('ItemList');
    }

    public function test_tool_pages_render_known_catalog_content(): void
    {
        $this->get('/tools/json-formatter')
            ->assertOk()
            ->assertSee('JSON Formatter')
            ->assertSee('Format JSON')
            ->assertSee('hreflang="en-US"', false)
            ->assertSee('SoftwareApplication');

        $this->get('/tools/pdf-page-counter')
            ->assertOk()
            ->assertSee('PDF Page Counter')
            ->assertSee('Analyze PDF');
    }

    public function test_guide_pages_render_known_content(): void
    {
        $this->get('/guides/how-to-format-json-without-errors')
            ->assertOk()
            ->assertSee('How to Format JSON Without Errors')
            ->assertSee('Guide')
            ->assertSee('TJ Verse')
            ->assertSee('Before you rely on the result')
            ->assertSee('Practical Examples')
            ->assertSee('FAQPage');
    }

    public function test_sitemap_includes_search_metadata(): void
    {
        $this->get('/sitemap.xml')
            ->assertOk()
            ->assertSee('<lastmod>', false)
            ->assertSee('<changefreq>', false)
            ->assertSee('<priority>', false)
            ->assertSee('/categories/developer-tools')
            ->assertSee('/tools/json-formatter')
            ->assertSee('/guides/how-to-format-json-without-errors')
            ->assertSee('/authors/tj-verse')
            ->assertSee('/disclaimer')
            ->assertSee('/cookie-policy');
    }

    public function test_robots_and_legal_pages_content(): void
    {
        $this->get('/robots.txt')
            ->assertOk()
            ->assertSee('User-agent: *', false)
            ->assertSee('User-agent: Mediapartners-Google', false)
            ->assertSee('User-agent: Googlebot', false)
            ->assertSee('Sitemap: https://webtoolsstation.com/sitemap.xml', false);

        $this->get('/disclaimer')
            ->assertOk()
            ->assertSee('For Informational and Utility Purposes Only')
            ->assertSee('Client-Side Browser Execution and Data Privacy');

        $this->get('/cookie-policy')
            ->assertOk()
            ->assertSee('Cookie Policy')
            ->assertSee('Google AdSense');
    }

    public function test_unknown_tool_and_guide_pages_return_not_found(): void
    {
        $this->get('/tools/not-a-real-tool')
            ->assertNotFound()
            ->assertSee('find the page', false);

        $this->get('/guides/not-a-real-guide')
            ->assertNotFound()
            ->assertSee('find the page', false);

        $this->get('/non-existent-page')
            ->assertNotFound()
            ->assertSee('find the page', false);
    }

    public function test_all_tools_render_hero_and_editorial_sections(): void
    {
        $tools = require base_path('app/Data/tools.php');
        $this->assertCount(174, $tools);

        foreach ($tools as $tool) {
            $slug = $tool['slug'];
            $res = $this->get('/tools/' . $slug);
            $res->assertOk()
                ->assertSee('tool-workspace-hero', false)
                ->assertSee('Processed locally in your browser')
                ->assertSee($tool['title'])
                ->assertSee('How to use this ' . $tool['title'])
                ->assertSee('Where this tool helps most')
                ->assertSee('Practical Worked Example')
                ->assertSee('Execution architecture and standards')
                ->assertSee('When to use a different workflow')
                ->assertSee('Frequently Asked Questions');
        }
    }
}
