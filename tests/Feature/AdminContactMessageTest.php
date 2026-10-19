<?php

namespace Tests\Feature;

use App\Models\ContactMessage;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminContactMessageTest extends TestCase
{
    use RefreshDatabase;

    public function test_administrator_can_review_messages(): void
    {
        $admin = User::factory()->admin()->create();

        ContactMessage::factory()->create([
            'name' => 'Grace Phiri',
            'subject' => 'Joining the choir',
        ]);

        $this->actingAs($admin)
            ->get(route('admin.messages.index'))
            ->assertOk()
            ->assertSee('Grace Phiri')
            ->assertSee('Joining the choir');
    }

    public function test_administrator_can_mark_a_message_as_read(): void
    {
        $admin = User::factory()->admin()->create();
        $message = ContactMessage::factory()->create();

        $this->assertNull($message->read_at);

        $this->actingAs($admin)
            ->patch(route('admin.messages.toggle-read', $message))
            ->assertRedirect();

        $this->assertNotNull($message->refresh()->read_at);
    }

    public function test_administrator_can_mark_a_message_as_unread_again(): void
    {
        $admin = User::factory()->admin()->create();
        $message = ContactMessage::factory()->read()->create();

        $this->actingAs($admin)
            ->patch(route('admin.messages.toggle-read', $message))
            ->assertRedirect();

        $this->assertNull($message->refresh()->read_at);
    }

    public function test_non_administrator_cannot_review_messages(): void
    {
        $student = User::factory()->create();

        $this->actingAs($student)
            ->get(route('admin.messages.index'))
            ->assertForbidden();
    }

    public function test_guest_cannot_review_messages(): void
    {
        $this->get(route('admin.messages.index'))
            ->assertRedirect(route('admin.login'));
    }
}
