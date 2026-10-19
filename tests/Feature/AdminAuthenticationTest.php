<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_are_redirected_to_the_admin_login_page(): void
    {
        $this->get(route('admin.dashboard'))
            ->assertRedirect(route('admin.login'));
    }

    public function test_admin_login_page_is_available(): void
    {
        $this->get(route('admin.login'))
            ->assertOk()
            ->assertSee('Administrator sign in');
    }

    public function test_administrator_can_sign_in(): void
    {
        $admin = User::factory()->admin()->create([
            'email' => 'admin@example.com',
        ]);

        $this->post(route('admin.login.store'), [
            'email' => 'admin@example.com',
            'password' => 'password',
        ])->assertRedirect(route('admin.dashboard'));

        $this->assertAuthenticatedAs($admin);
    }

    public function test_administrator_login_email_is_case_insensitive(): void
    {
        $admin = User::factory()->admin()->create([
            'email' => 'admin@example.com',
        ]);

        $this->post(route('admin.login.store'), [
            'email' => 'ADMIN@EXAMPLE.COM',
            'password' => 'password',
        ])->assertRedirect(route('admin.dashboard'));

        $this->assertAuthenticatedAs($admin);
    }

    public function test_administrator_can_open_the_dashboard(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('Dashboard');
    }

    public function test_administrator_can_open_event_management_pages(): void
    {
        $admin = User::factory()->admin()->create();
        $event = Event::factory()->create(['title' => 'Existing Event']);

        $this->actingAs($admin);

        $this->get(route('admin.events.index'))
            ->assertOk()
            ->assertSee('Create event')
            ->assertSee('Existing Event');

        $this->get(route('admin.events.create'))
            ->assertOk()
            ->assertSee('Create event');

        $this->get(route('admin.events.edit', $event))
            ->assertOk()
            ->assertSee('Existing Event');
    }

    public function test_non_administrator_cannot_sign_in_through_the_admin_portal(): void
    {
        User::factory()->create([
            'email' => 'student@example.com',
        ]);

        $this->post(route('admin.login.store'), [
            'email' => 'student@example.com',
            'password' => 'password',
        ])->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    public function test_non_administrator_is_forbidden_from_the_admin_area(): void
    {
        $student = User::factory()->create();

        $this->actingAs($student)
            ->get(route('admin.dashboard'))
            ->assertForbidden();
    }

    public function test_invalid_credentials_are_rejected(): void
    {
        User::factory()->admin()->create([
            'email' => 'admin@example.com',
        ]);

        $this->post(route('admin.login.store'), [
            'email' => 'admin@example.com',
            'password' => 'wrong-password',
        ])->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    public function test_login_attempts_are_rate_limited(): void
    {
        User::factory()->admin()->create([
            'email' => 'admin@example.com',
        ]);

        for ($attempt = 0; $attempt < 5; $attempt++) {
            $this->post(route('admin.login.store'), [
                'email' => 'admin@example.com',
                'password' => 'wrong-password',
            ])->assertSessionHasErrors('email');
        }

        $this->post(route('admin.login.store'), [
            'email' => 'admin@example.com',
            'password' => 'password',
        ])->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    public function test_administrator_can_sign_out(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->post(route('admin.logout'))
            ->assertRedirect(route('admin.login'));

        $this->assertGuest();
    }
}
