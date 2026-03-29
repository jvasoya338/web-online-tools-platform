<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class ContactFormTest extends TestCase
{
    public function test_contact_form_submission_redirects_with_success_message(): void
    {
        Mail::fake();

        $response = $this->post('/contact', [
            'name' => 'TJ Verse',
            'email' => 'tj@example.com',
            'topic' => 'Tool suggestions and feature ideas',
            'subject' => 'New utility idea',
            'message' => 'Please add another browser-side utility for quick developer workflows.',
            'website' => '',
        ]);

        $response
            ->assertRedirect('/contact')
            ->assertSessionHas('status');

    }

    public function test_contact_form_validates_required_fields(): void
    {
        $response = $this->from('/contact')->post('/contact', [
            'name' => '',
            'email' => 'not-an-email',
            'topic' => '',
            'subject' => '',
            'message' => 'short',
            'website' => 'bot-filled',
        ]);

        $response
            ->assertRedirect('/contact')
            ->assertSessionHasErrors([
                'name',
                'email',
                'topic',
                'subject',
                'message',
                'website',
            ]);
    }
}
