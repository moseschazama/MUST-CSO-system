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
                'image' => '/images/gallery/1WS1K0jiEOHhCE-uwy2xagCFEUzHwRVn3.jpg',
                'description' => 'The main celebration of the week for the whole Catholic community, with the CSO choir animating the liturgy.'],
            ['category' => 'mass', 'icon' => 'church', 'title' => 'Weekday Mass', 'day' => 'Tuesday & Thursday', 'time' => '6:30 AM', 'venue' => 'Campus Chapel', 'sort_order' => 2,
                'image' => '/images/gallery/12usmszhcdLinTYwV3RjQD3rObfSgeLQL.jpg',
                'description' => 'A quiet morning Mass before lectures — an offering of the academic day.'],
            ['category' => 'mass', 'icon' => 'book-open', 'title' => 'Bible Study', 'day' => 'Every Tuesday', 'time' => '7:00 PM', 'venue' => 'Lecture Room B', 'sort_order' => 3,
                'image' => '/images/gallery/1k8aGaxFpEos25SoIy1-qMCdLGCRcqJNa.jpg',
                'description' => 'Lectio divina and group discussion of the Sunday readings and the Catechism.'],

            // ---- Devotions & prayer ----
            ['category' => 'devotion', 'icon' => 'sunrise', 'title' => 'Morning Devotion', 'day' => 'Monday – Friday', 'time' => '5:30 AM', 'venue' => 'Campus Chapel / Prayer Room', 'sort_order' => 4,
                'image' => '/images/gallery/1AQnCkSpWjKVa_sSN2RW_sF625p2Di2B_.jpg',
                'description' => 'Scripture, a short reflection and intercession to begin the day with God.'],
            ['category' => 'devotion', 'icon' => 'flower-2', 'title' => 'Holy Rosary', 'day' => 'Monday – Friday', 'time' => '8:00 PM', 'venue' => 'Hostel Common Room', 'sort_order' => 5,
                'image' => '/images/gallery/1FdTqJgGwXmLgi6gjH8oeqcUSCb-AkA7A.jpg',
                'description' => 'The rosary prayed together each evening, followed by quiet personal prayer.'],
            ['category' => 'devotion', 'icon' => 'sparkles', 'title' => 'Eucharistic Adoration', 'day' => 'First Friday of the month', 'time' => '7:00 PM', 'venue' => 'Campus Chapel', 'sort_order' => 6,
                'image' => '/images/gallery/1F7Dw1rIsWVYdvdldDkCO3cxPvtqequdp.jpg',
                'description' => 'An hour of adoration, confession and praise before the Blessed Sacrament.'],
            ['category' => 'devotion', 'icon' => 'music', 'title' => 'Choir Rehearsal', 'day' => 'Wednesday & Saturday', 'time' => '6:00 PM', 'venue' => 'Lecture Room B', 'sort_order' => 7,
                'image' => '/images/gallery/1lWPDRgmyE-2KFHmsbcwIBKuXIcT6ACOX.jpg',
                'description' => 'Rehearsals for Sunday Mass and campus events. New voices are always welcome.'],

            // ---- Meetings & fellowship ----
            ['category' => 'meeting', 'icon' => 'users', 'title' => 'Friday General Meeting', 'day' => 'Every Friday', 'time' => '6:00 PM', 'venue' => 'Main Lecture Hall', 'sort_order' => 8,
                'image' => '/images/gallery/1bDNtvQX5n-bYq6HtbfHPQJovK0eXNW2j.jpg',
                'description' => 'The whole community gathers for prayer, updates, planning and fellowship.'],
            ['category' => 'meeting', 'icon' => 'home', 'title' => 'Small Christian Communities', 'day' => 'Every Wednesday', 'time' => '7:00 PM', 'venue' => 'Respective hostels', 'sort_order' => 9,
                'image' => '/images/gallery/1rBk8IZ4ulUm5InS8bCdbEpKa2mMmpx3Y.jpg',
                'description' => 'Small groups for sharing, Scripture and mutual support during the week.'],
            ['category' => 'meeting', 'icon' => 'clipboard-list', 'title' => 'Executive Committee Meeting', 'day' => 'Every Monday', 'time' => '5:00 PM', 'venue' => 'CSO Office', 'sort_order' => 10,
                'image' => '/images/gallery/1C-ceBNwYWgNg8S--wDqB2u_HPdCpObPP.jpg',
                'description' => 'Committee heads plan activities and review progress. Members may attend as observers.'],

            // ---- Charity & outreach ----
            ['category' => 'outreach', 'icon' => 'heart-handshake', 'title' => 'Charity Visit', 'day' => 'Last Saturday of the month', 'time' => '9:00 AM', 'venue' => 'Thyolo District Hospital & surrounding villages', 'sort_order' => 11,
                'image' => '/images/gallery/1HwaaaeG7vkZBJTMW4tLkPRgazSqq5A3g.jpg',
                'description' => 'Visiting the sick, donating basic necessities and sharing prayer with families.'],
            ['category' => 'outreach', 'icon' => 'hand-heart', 'title' => 'Campus Service Day', 'day' => 'Once a semester', 'time' => '8:00 AM', 'venue' => 'MUST Campus', 'sort_order' => 12,
                'image' => '/images/gallery/1SZnaezxwFMqrjDtHFwt6vpEBdes0VYET.jpg',
                'description' => 'Cleaning, tree planting and small repairs around campus as service to the university community.'],
        ];

        foreach ($activities as $activity) {
            Activity::updateOrCreate(['title' => $activity['title']], $activity);
        }
    }
}