<?php

namespace Database\Seeders;

use App\Models\Activity;
use Illuminate\Database\Seeder;

/**
 * SAMPLE SCHEDULE — confirm the Mass times and meeting venues with the
 * chaplaincy before publishing.
 */
class ActivitySeeder extends Seeder
{
    public function run(): void
    {
        $activities = [
            // ---- Holy Mass & liturgy ----
            ['category' => 'mass', 'icon' => 'church', 'title' => 'Sunday Holy Mass', 'day' => 'Every Sunday', 'time' => '9:00 AM', 'venue' => 'MUST Campus Chapel', 'sort_order' => 1,
                'description' => 'The main celebration of the week for the whole Catholic community, with the CSO choir animating the liturgy.'],
            ['category' => 'mass', 'icon' => 'church', 'title' => 'Weekday Mass', 'day' => 'Tuesday & Thursday', 'time' => '6:30 AM', 'venue' => 'Campus Chapel', 'sort_order' => 2,
                'description' => 'A quiet morning Mass before lectures — an offering of the academic day.'],
            ['category' => 'mass', 'icon' => 'book-open', 'title' => 'Bible Study', 'day' => 'Every Tuesday', 'time' => '7:00 PM', 'venue' => 'Lecture Room B', 'sort_order' => 3,
                'description' => 'Lectio divina and group discussion of the Sunday readings and the Catechism.'],

            // ---- Devotions & prayer ----
            ['category' => 'devotion', 'icon' => 'sunrise', 'title' => 'Morning Devotion', 'day' => 'Monday — Friday', 'time' => '5:30 AM', 'venue' => 'Campus Chapel / Prayer Room', 'sort_order' => 4,
                'description' => 'Scripture, a short reflection and intercession to begin the day with God.'],
            ['category' => 'devotion', 'icon' => 'flower-2', 'title' => 'Holy Rosary', 'day' => 'Monday — Friday', 'time' => '8:00 PM', 'venue' => 'Hostel Common Room', 'sort_order' => 5,
                'description' => 'The rosary prayed together each evening, followed by quiet personal prayer.'],
            ['category' => 'devotion', 'icon' => 'sparkles', 'title' => 'Eucharistic Adoration', 'day' => 'First Friday of the month', 'time' => '7:00 PM', 'venue' => 'Campus Chapel', 'sort_order' => 6,
                'description' => 'An hour of adoration, confession and praise before the Blessed Sacrament.'],
            ['category' => 'devotion', 'icon' => 'music', 'title' => 'Choir Rehearsal', 'day' => 'Wednesday & Saturday', 'time' => '6:00 PM', 'venue' => 'Lecture Room B', 'sort_order' => 7,
                'description' => 'Rehearsals for Sunday Mass and campus events. New voices are always welcome.'],

            // ---- Meetings & fellowship ----
            ['category' => 'meeting', 'icon' => 'users', 'title' => 'Friday General Meeting', 'day' => 'Every Friday', 'time' => '6:00 PM', 'venue' => 'Main Lecture Hall', 'sort_order' => 8,
                'description' => 'The whole community gathers for prayer, updates, planning and fellowship.'],
            ['category' => 'meeting', 'icon' => 'home', 'title' => 'Small Christian Communities', 'day' => 'Every Wednesday', 'time' => '7:00 PM', 'venue' => 'Respective hostels', 'sort_order' => 9,
                'description' => 'Small groups for sharing, Scripture and mutual support during the week.'],
            ['category' => 'meeting', 'icon' => 'clipboard-list', 'title' => 'Executive Committee Meeting', 'day' => 'Every Monday', 'time' => '5:00 PM', 'venue' => 'CSO Office', 'sort_order' => 10,
                'description' => 'Committee heads plan activities and review progress. Members may attend as observers.'],

            // ---- Charity & outreach ----
            ['category' => 'outreach', 'icon' => 'heart-handshake', 'title' => 'Charity Visit', 'day' => 'Last Saturday of the month', 'time' => '9:00 AM', 'venue' => 'Thyolo District Hospital & surrounding villages', 'sort_order' => 11,
                'description' => 'Visiting the sick, donating basic necessities and sharing prayer with families.'],
            ['category' => 'outreach', 'icon' => 'hand-heart', 'title' => 'Campus Service Day', 'day' => 'Once a semester', 'time' => '8:00 AM', 'venue' => 'MUST Campus', 'sort_order' => 12,
                'description' => 'Cleaning, tree planting and small repairs around campus as service to the university community.'],
        ];

        foreach ($activities as $activity) {
            Activity::create($activity);
        }
    }
}
