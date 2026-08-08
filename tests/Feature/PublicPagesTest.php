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
            '/sitemap.xml',
            '/robots.txt',
        ];

        foreach ($routes as $route) {
            $this->get($route)->assertOk();
        }
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
            ->assertSee('<priority>', false);
    }

    public function test_unknown_tool_and_guide_pages_return_not_found(): void
    {
        $this->get('/tools/not-a-real-tool')->assertNotFound();
        $this->get('/guides/not-a-real-guide')->assertNotFound();
    }
}
