<?php

namespace Database\Seeders;

use App\Models\Announcement;
use Illuminate\Database\Seeder;

/**
 * SAMPLE ANNOUNCEMENTS — replace with current notices.
 * level: info | notice | urgent
 */
class AnnouncementSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            [
                'title' => 'Friday meeting moves to Lecture Theatre 2',
                'body' => 'This week the general meeting will be held in Lecture Theatre 2 instead of the Main Lecture Hall, because of examinations. Same time: 6:00 PM.',
                'level' => 'urgent',
                'published_at' => '2026-11-10 10:00:00',
            ],
            [
                'title' => 'Advent retreat registration closes 22 November',
                'body' => 'Register with the secretary after any Mass or during the Friday meeting. Contribution is MK 5,000 for transport and meals; sponsored places are available for members who need assistance.',
                'level' => 'notice',
                'published_at' => '2026-11-06 09:00:00',
            ],
            [
                'title' => 'Choir auditions are open',
                'body' => 'The CSO choir is welcoming new voices for the carols night. No experience required — come to any Wednesday rehearsal at 6:00 PM in Lecture Room B.',
                'level' => 'info',
                'published_at' => '2026-10-30 14:00:00',
            ],
        ];

        foreach ($items as $item) {
            Announcement::create($item);
        }
    }
}
