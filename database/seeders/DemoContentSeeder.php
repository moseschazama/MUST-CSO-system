<?php

namespace Database\Seeders;

use App\Models\Event;
use Illuminate\Database\Seeder;

class DemoContentSeeder extends Seeder
{
    /**
     * Seed sample events for local preview only.
     *
     * Every event is marked with is_demo=true so the interface can identify
     * it as demonstration content. These are not official CSO events.
     */
    public function run(): void
    {
        $events = [
            [
                'title' => 'Community Welcome Evening',
                'slug' => 'demo-community-welcome-evening',
                'excerpt' => 'Demonstration event: a sample gathering for students who are new to the CSO community.',
                'description' => 'Demonstration content. This sample event exists to preview the events feature. It is not an official CSO event. The date, venue, and details shown here are illustrative only and will be replaced with confirmed information.',
                'location' => 'MUST campus',
                'starts_at' => now()->addDays(12)->setTime(18, 0),
                'ends_at' => now()->addDays(12)->setTime(20, 0),
            ],
            [
                'title' => 'Student Choir Rehearsal',
                'slug' => 'demo-student-choir-rehearsal',
                'excerpt' => 'Demonstration event: a sample choir rehearsal entry used to preview the events calendar.',
                'description' => 'Demonstration content. This sample event exists to preview the events feature. It is not an official CSO event. The date, venue, and details shown here are illustrative only and will be replaced with confirmed information.',
                'location' => 'MUST campus',
                'starts_at' => now()->addDays(19)->setTime(16, 30),
                'ends_at' => now()->addDays(19)->setTime(18, 0),
            ],
            [
                'title' => 'Faith and Fellowship Evening',
                'slug' => 'demo-faith-and-fellowship-evening',
                'excerpt' => 'Demonstration event: a sample evening of reflection and community for the events preview.',
                'description' => 'Demonstration content. This sample event exists to preview the events feature. It is not an official CSO event. The date, venue, and details shown here are illustrative only and will be replaced with confirmed information.',
                'location' => 'MUST campus',
                'starts_at' => now()->addDays(26)->setTime(18, 30),
                'ends_at' => now()->addDays(26)->setTime(20, 0),
            ],
        ];

        foreach ($events as $event) {
            Event::query()->updateOrCreate(
                ['slug' => $event['slug']],
                array_merge($event, [
                    'is_published' => true,
                    'is_demo' => true,
                ]),
            );
        }
    }
}
