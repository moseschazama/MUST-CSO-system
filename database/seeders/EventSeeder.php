<?php

namespace Database\Seeders;

use App\Models\Event;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

/**
 * SAMPLE EVENTS — replace with confirmed dates, times and venues.
 */
class EventSeeder extends Seeder
{
    public function run(): void
    {
        $events = [
            [
                'title' => 'CSO Annual General Meeting',
                'starts_at' => '2026-11-20 17:00:00',
                'time_label' => '5:00 PM — 7:30 PM',
                'venue' => 'Main Lecture Hall, MUST',
                'description' => 'Presentation of the annual report and financial statement, plus elections for the incoming executive committee. All registered members are expected to attend.',
                'is_featured' => true,
            ],
            [
                'title' => 'Advent Retreat',
                'starts_at' => '2026-11-28 08:00:00',
                'time_label' => '8:00 AM — 4:00 PM',
                'venue' => 'MUST Campus Chapel',
                'description' => 'A day of recollection to begin Advent: talks, confession, adoration and Holy Mass with the campus chaplain.',
            ],
            [
                'title' => 'CSO Carols Night',
                'starts_at' => '2026-12-11 18:30:00',
                'time_label' => '6:30 PM — 9:00 PM',
                'venue' => 'MUST Amphitheatre',
                'description' => 'An evening of Christmas carols from the CSO choir, drama and fellowship to close the academic year.',
            ],
            [
                'title' => 'Christmas Charity Visit',
                'starts_at' => '2026-12-19 09:00:00',
                'time_label' => '9:00 AM — 1:00 PM',
                'venue' => 'Thyolo District Hospital',
                'description' => 'Bringing Christmas gifts, food items and prayer to patients and surrounding households. Donations welcome.',
            ],
            [
                'title' => 'Leadership Handover Ceremony',
                'starts_at' => '2027-01-16 16:00:00',
                'time_label' => '4:00 PM — 6:00 PM',
                'venue' => 'Main Lecture Hall, MUST',
                'description' => 'Official handover from the outgoing to the incoming executive committee, with Holy Mass and a blessing of the new leadership.',
            ],
        ];

        foreach ($events as $event) {
            Event::create($event + [
                'slug' => Str::slug($event['title']),
                'rsvp_url' => null,
            ]);
        }
    }
}
