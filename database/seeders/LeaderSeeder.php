<?php

namespace Database\Seeders;

use App\Models\Leader;
use Illuminate\Database\Seeder;

/**
 * SAMPLE LEADERSHIP DATA — replace every name, role, tenure and bio with
 * the real people. `photo` uses available local images to keep the site live.
 */
class LeaderSeeder extends Seeder
{
    public function run(): void
    {
        $leaders = [
            // ---- Spiritual & advisory leadership ----
            ['name' => 'Rev. Fr. Joseph Mwale', 'role' => 'Chaplain', 'category' => 'spiritual', 'tenure' => '2024 – present', 'sort_order' => 1,
                'photo' => '/images/gallery/10YvZrv8fIpp3UXPudDo4tuAo_B9z6_OZ.jpg',
                'bio' => 'Shepherds the Catholic community at MUST, celebrating the sacraments on campus and guiding the executive committee in faith and governance.'],
            ['name' => 'Mr. Emmanuel Kachale', 'role' => 'Patron', 'category' => 'spiritual', 'tenure' => '2023 – present', 'sort_order' => 2,
                'photo' => '/images/gallery/17rtTWn0HMsfeOBuUTX0v2HmNkNdm3CwH.jpg',
                'bio' => 'A member of academic staff who mentors the executive, safeguards the constitution and represents the organization to the university.'],
            ['name' => 'Mrs. Grace Chikondi', 'role' => 'Matron', 'category' => 'spiritual', 'tenure' => '2023 – present', 'sort_order' => 3,
                'photo' => '/images/gallery/1GdyW-HK_p4pSCRPZwl8T_4_G-gI5g4Sn.jpg',
                'bio' => 'Offers pastoral care and practical support to members, especially first-year students adjusting to campus life.'],

            // ---- Current executive committee ----
            ['name' => 'Chisomo Banda', 'role' => 'Chairperson', 'category' => 'executive', 'tenure' => '2026 / 2027', 'sort_order' => 1,
                'photo' => '/images/gallery/10kA2YHDWECR9gAVRSc6ZL5m8xYeVT7mC.jpg',
                'bio' => 'Leads the executive committee, chairs general meetings and represents MUST CSO before the university and the Diocese.'],
            ['name' => 'Takondwa Phiri', 'role' => 'Vice Chairperson', 'category' => 'executive', 'tenure' => '2026 / 2027', 'sort_order' => 2,
                'photo' => '/images/gallery/13ARXsk4YZ57neLGHEKsZ4lU03-reuBbz.jpg',
                'bio' => 'Supports the chairperson and coordinates the committee heads to keep every activity on schedule.'],
            ['name' => 'Limbani Msiska', 'role' => 'Secretary', 'category' => 'executive', 'tenure' => '2026 / 2027', 'sort_order' => 3,
                'photo' => '/images/gallery/141s22hCw6_P069wuKw5gBl3t1FrgZCub.jpg',
                'bio' => 'Keeps the minutes, membership register and official correspondence of the organization.'],
            ['name' => 'Thandiwe Kaunda', 'role' => 'Vice Secretary', 'category' => 'executive', 'tenure' => '2026 / 2027', 'sort_order' => 4,
                'photo' => '/images/gallery/15CFwoH-mJ_Y-Y8-sgcDJepe2XO2LBJk9.jpg',
                'bio' => 'Assists the secretary and manages attendance records and event registration lists.'],
            ['name' => 'Mphatso Gondwe', 'role' => 'Treasurer', 'category' => 'executive', 'tenure' => '2026 / 2027', 'sort_order' => 5,
                'photo' => '/images/gallery/184Ma38wispWoO70dWh1b6Y0tqEEQbdM9.jpg',
                'bio' => 'Stewards the funds of the organization, presents monthly financial reports and keeps transparent records.'],
            ['name' => 'Alinafe Nyirenda', 'role' => 'Liturgy Coordinator', 'category' => 'executive', 'tenure' => '2026 / 2027', 'sort_order' => 6,
                'photo' => '/images/gallery/1bdmVvE8P672fSMjPOwR9Uq08nZpL2B2b.jpg',
                'bio' => 'Prepares the readings, altar servers and vessels for every Mass and liturgical celebration on campus.'],
            ['name' => 'Yamikani Chirwa', 'role' => 'Choir Director', 'category' => 'executive', 'tenure' => '2026 / 2027', 'sort_order' => 7,
                'photo' => '/images/gallery/1cZpO3y2_w0rt0QekenHkzvMzf4K5XFu6.jpg',
                'bio' => 'Leads the CSO choir in rehearsal and song, animating the liturgy and leading praise and worship nights.'],
            ['name' => 'Tawonga Mhango', 'role' => 'Publicity Secretary', 'category' => 'executive', 'tenure' => '2026 / 2027', 'sort_order' => 8,
                'photo' => '/images/gallery/1EuUpqZmd-PUNIxPV3cd6rlLKJvRZzJuv.jpg',
                'bio' => 'Runs the CSO social media, notice boards and photography archive of every activity.'],
            ['name' => 'Chimwemwe Zimba', 'role' => 'Charity & Outreach Coordinator', 'category' => 'executive', 'tenure' => '2026 / 2027', 'sort_order' => 9,
                'photo' => '/images/gallery/1nQBNUa8f5ZZasACiWddPp8eWKlC_e4RB.jpg',
                'bio' => 'Organises hospital visits, donations and community service in and around Thyolo.'],
            ['name' => 'Blessings Mvula', 'role' => 'Small Christian Communities', 'category' => 'executive', 'tenure' => '2026 / 2027', 'sort_order' => 10,
                'photo' => '/images/gallery/1oedIYxnEIYKQZX_SaZS19RYmnrty67V4.jpg',
                'bio' => 'Links hostel-based small groups for weekly sharing, prayer and mutual support.'],

            // ---- Past chairpersons ----
            ['name' => 'Kondwani Mwale', 'role' => 'Chairperson', 'category' => 'past', 'tenure' => '2025 / 2026', 'sort_order' => 1,
                'photo' => '/images/gallery/1OKngBHqfpX6ViNaLUHWJCRinZyaqW-7S.jpg',
                'bio' => 'Led the society through a year of growth in membership and the first campus Advent retreat.'],
            ['name' => 'Tiyamike Nkhoma', 'role' => 'Chairperson', 'category' => 'past', 'tenure' => '2024 / 2025', 'sort_order' => 2,
                'photo' => '/images/gallery/1olYCzka-Ku5qNHeE9I9zeE1MIOf2TAx-.jpg',
                'bio' => 'Strengthened the small Christian community structure and expanded the charity outreach calendar.'],
            ['name' => 'Chimango Kamanga', 'role' => 'Chairperson', 'category' => 'past', 'tenure' => '2023 / 2024', 'sort_order' => 3,
                'photo' => '/images/gallery/1PrOw3TbO_msEcZX7nEwq5hESWm2ohp7n.jpg',
                'bio' => 'Revived the CSO choir and established the morning devotion programme.'],
            ['name' => 'Madalitso Kambewa', 'role' => 'Chairperson', 'category' => 'past', 'tenure' => '2022 / 2023', 'sort_order' => 4,
                'photo' => '/images/gallery/1QcXlEf0ocLDrkDqpEOaywueqCkjb2qp4.jpg',
                'bio' => 'Rebuilt the executive structure after the pandemic and renewed ties with the campus chaplaincy.'],
        ];

        foreach ($leaders as $leader) {
            Leader::updateOrCreate(
                [
                    'name' => $leader['name'],
                    'category' => $leader['category'],
                    'role' => $leader['role'],
                ],
                $leader,
            );
        }
    }
}