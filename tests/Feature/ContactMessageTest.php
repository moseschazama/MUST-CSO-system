<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactMessageTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return array<string, string>
     */
    private function validPayload(array $overrides = []): array
    {
        return array_merge([
            'name' => 'A Student',
            'email' => 'student@example.com',
            'subject' => 'Joining the CSO',
            'message' => 'I would like to know more about the Catholic community on campus.',
        ], $overrides);
    }

    public function test_contact_form_stores_a_message(): void
    {
        $response = $this->post(route('contact.store'), $this->validPayload());

        $response->assertRedirect(route('contact'));
        $response->assertSessionHas('status');

        $this->assertDatabaseHas('contact_messages', [
            'name' => 'A Student',
            'email' => 'student@example.com',
            'subject' => 'Joining the CSO',
        ]);
    }

    public function test_contact_form_validates_required_fields(): void
    {
        $this->post(route('contact.store'), [])
            ->assertSessionHasErrors(['name', 'email', 'message']);
    }

    public function test_contact_form_rejects_an_invalid_email(): void
    {
        $this->post(route('contact.store'), $this->validPayload([
            'email' => 'not-an-email',
        ]))->assertSessionHasErrors('email');
    }

    public function test_contact_form_is_rate_limited(): void
    {
        for ($attempt = 0; $attempt < 6; $attempt++) {
            $this->post(route('contact.store'), $this->validPayload([
                'email' => "student{$attempt}@example.com",
            ]))->assertRedirect(route('contact'));
        }

        $this->post(route('contact.store'), $this->validPayload([
            'email' => 'student-final@example.com',
        ]))->assertStatus(429);
    }
}
