<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminEventManagementTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return array<string, string>
     */
    private function validPayload(array $overrides = []): array
    {
        return array_merge([
            'title' => 'Community Welcome Evening',
            'slug' => '',
            'excerpt' => 'A short summary of the event.',
            'description' => 'A longer description of the event, written for the test suite.',
            'location' => 'MUST campus',
            'starts_at' => now()->addWeek()->format('Y-m-d\TH:i'),
            'ends_at' => now()->addWeek()->addHours(2)->format('Y-m-d\TH:i'),
            'is_published' => '1',
        ], $overrides);
    }

    public function test_administrator_can_create_an_event(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->post(route('admin.events.store'), $this->validPayload())
            ->assertRedirect(route('admin.events.index'));

        $this->assertDatabaseHas('events', [
            'title' => 'Community Welcome Evening',
            'slug' => 'community-welcome-evening',
            'is_published' => true,
            'created_by_id' => $admin->id,
        ]);
    }

    public function test_event_creation_validates_required_fields(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->post(route('admin.events.store'), [])
            ->assertSessionHasErrors(['title', 'description', 'starts_at']);
    }

    public function test_event_end_time_must_not_be_before_the_start_time(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->post(route('admin.events.store'), $this->validPayload([
                'ends_at' => now()->addWeek()->subHour()->format('Y-m-d\TH:i'),
            ]))
            ->assertSessionHasErrors('ends_at');
    }

    public function test_slug_generation_avoids_duplicates(): void
    {
        $admin = User::factory()->admin()->create();

        Event::factory()->create([
            'title' => 'Duplicate Title Event',
            'slug' => 'duplicate-title-event',
        ]);

        $this->actingAs($admin)
            ->post(route('admin.events.store'), $this->validPayload([
                'title' => 'Duplicate Title Event',
            ]))
            ->assertRedirect(route('admin.events.index'));

        $this->assertDatabaseHas('events', [
            'slug' => 'duplicate-title-event-2',
        ]);
    }

    public function test_administrator_can_update_an_event(): void
    {
        $admin = User::factory()->admin()->create();
        $event = Event::factory()->unpublished()->create([
            'title' => 'Old Title',
            'slug' => 'old-title',
        ]);

        $this->actingAs($admin)
            ->put(route('admin.events.update', $event), $this->validPayload([
                'title' => 'New Title',
                'slug' => 'new-title',
            ]))
            ->assertRedirect(route('admin.events.index'));

        $this->assertDatabaseHas('events', [
            'id' => $event->id,
            'title' => 'New Title',
            'slug' => 'new-title',
            'is_published' => true,
        ]);
    }

    public function test_administrator_can_delete_an_event(): void
    {
        $admin = User::factory()->admin()->create();
        $event = Event::factory()->create();

        $this->actingAs($admin)
            ->delete(route('admin.events.destroy', $event))
            ->assertRedirect(route('admin.events.index'));

        $this->assertDatabaseMissing('events', [
            'id' => $event->id,
        ]);
    }

    public function test_non_administrator_cannot_manage_events(): void
    {
        $student = User::factory()->create();

        $this->actingAs($student)
            ->post(route('admin.events.store'), $this->validPayload())
            ->assertForbidden();

        $this->assertDatabaseMissing('events', [
            'title' => 'Community Welcome Evening',
        ]);
    }

    public function test_guest_cannot_manage_events(): void
    {
        $this->get(route('admin.events.create'))
            ->assertRedirect(route('admin.login'));
    }
}
