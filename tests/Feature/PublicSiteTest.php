<?php

namespace Tests\Feature;

use App\Models\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicSiteTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_page_renders_the_cso_identity(): void
    {
        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee('MUST Catholic Students Organisation');
        $response->assertSee('Faith. Fellowship. Service.');
        $response->assertSee('Upcoming events');
    }

    public function test_about_page_is_available(): void
    {
        $this->get(route('about'))
            ->assertOk()
            ->assertSee('A Catholic student community shaped by faith, fellowship, and service.');
    }

    public function test_contact_page_is_available(): void
    {
        $this->get(route('contact'))
            ->assertOk()
            ->assertSee('We would love to hear from you.');
    }

    public function test_health_endpoint_reports_ok(): void
    {
        $this->getJson(route('health'))
            ->assertOk()
            ->assertJsonPath('status', 'ok');
    }

    public function test_home_page_lists_published_upcoming_events(): void
    {
        Event::factory()->create(['title' => 'Confirmed Welcome Gathering']);

        $this->get('/')
            ->assertOk()
            ->assertSee('Confirmed Welcome Gathering');
    }

    public function test_unpublished_events_are_hidden_from_the_public_site(): void
    {
        $draft = Event::factory()->unpublished()->create(['title' => 'Secret Draft Event']);

        $this->get(route('events.index'))
            ->assertOk()
            ->assertDontSee('Secret Draft Event');

        $this->get(route('events.show', $draft))
            ->assertNotFound();
    }

    public function test_past_events_are_shown_in_the_public_archive(): void
    {
        Event::factory()->past()->create(['title' => 'Past Gathering']);

        $this->get(route('events.index'))
            ->assertOk()
            ->assertSee('Past Gathering');
    }

    public function test_demonstration_events_are_clearly_labelled(): void
    {
        Event::factory()->demonstration()->create(['title' => 'Preview Event']);

        $this->get('/')
            ->assertOk()
            ->assertSee('Demonstration content')
            ->assertSee('Preview Event');
    }
}
