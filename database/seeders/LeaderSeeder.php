<?php

namespace Database\Seeders;

use App\Models\Leader;
use Illuminate\Database\Seeder;

/**
 * SAMPLE LEADERSHIP DATA — replace every name, role, tenure and bio with
 * the real people. Set `photo` to a path (e.g. '/images/leaders/name.jpg')
 * or leave it null to show a coloured initials avatar.
 */
class LeaderSeeder extends Seeder
{
    public function run(): void
    {
        $leaders = [
            // ---- Spiritual & advisory leadership ----
            ['name' => 'Rev. Fr. Joseph Mwale', 'role' => 'Chaplain', 'category' => 'spiritual', 'tenure' => '2024 — present', 'sort_order' => 1,
                'bio' => 'Shepherds the Catholic community at MUST, celebrating the sacraments on campus and guiding the executive committee in faith and governance.'],
            ['name' => 'Mr. Emmanuel Kachale', 'role' => 'Patron', 'category' => 'spiritual', 'tenure' => '2023 — present', 'sort_order' => 2,
                'bio' => 'A member of academic staff who mentors the executive, safeguards the constitution and represents the organization to the university.'],
            ['name' => 'Mrs. Grace Chikondi', 'role' => 'Matron', 'category' => 'spiritual', 'tenure' => '2023 — present', 'sort_order' => 3,
                'bio' => 'Offers pastoral care and practical support to members, especially first-year students adjusting to campus life.'],

            // ---- Current executive committee ----
            ['name' => 'Chisomo Banda', 'role' => 'Chairperson', 'category' => 'executive', 'tenure' => '2026 / 2027', 'sort_order' => 1,
                'bio' => 'Leads the executive committee, chairs general meetings and represents MUST CSO before the university and the Diocese.'],
            ['name' => 'Takondwa Phiri', 'role' => 'Vice Chairperson', 'category' => 'executive', 'tenure' => '2026 / 2027', 'sort_order' => 2,
                'bio' => 'Supports the chairperson and coordinates the committee heads to keep every activity on schedule.'],
            ['name' => 'Limbani Msiska', 'role' => 'Secretary', 'category' => 'executive', 'tenure' => '2026 / 2027', 'sort_order' => 3,
                'bio' => 'Keeps the minutes, membership register and official correspondence of the organization.'],
            ['name' => 'Thandiwe Kaunda', 'role' => 'Vice Secretary', 'category' => 'executive', 'tenure' => '2026 / 2027', 'sort_order' => 4,
                'bio' => 'Assists the secretary and manages attendance records and event registration lists.'],
            ['name' => 'Mphatso Gondwe', 'role' => 'Treasurer', 'category' => 'executive', 'tenure' => '2026 / 2027', 'sort_order' => 5,
                'bio' => 'Stewards the funds of the organization, presents monthly financial reports and keeps transparent records.'],
            ['name' => 'Alinafe Nyirenda', 'role' => 'Liturgy Coordinator', 'category' => 'executive', 'tenure' => '2026 / 2027', 'sort_order' => 6,
                'bio' => 'Prepares the readings, altar servers and vessels for every Mass and liturgical celebration on campus.'],
            ['name' => 'Yamikani Chirwa', 'role' => 'Choir Director', 'category' => 'executive', 'tenure' => '2026 / 2027', 'sort_order' => 7,
                'bio' => 'Leads the CSO choir in rehearsal and song, animating the liturgy and leading praise and worship nights.'],
            ['name' => 'Tawonga Mhango', 'role' => 'Publicity Secretary', 'category' => 'executive', 'tenure' => '2026 / 2027', 'sort_order' => 8,
                'bio' => 'Runs the CSO social media, notice boards and photography archive of every activity.'],
            ['name' => 'Chimwemwe Zimba', 'role' => 'Charity & Outreach Coordinator', 'category' => 'executive', 'tenure' => '2026 / 2027', 'sort_order' => 9,
                'bio' => 'Organises hospital visits, donations and community service in and around Thyolo.'],
            ['name' => 'Blessings Mvula', 'role' => 'Small Christian Communities', 'category' => 'executive', 'tenure' => '2026 / 2027', 'sort_order' => 10,
                'bio' => 'Links hostel-based small groups for weekly sharing, prayer and mutual support.'],

            // ---- Past chairpersons ----
            ['name' => 'Kondwani Mwale', 'role' => 'Chairperson', 'category' => 'past', 'tenure' => '2025 / 2026', 'sort_order' => 1,
                'bio' => 'Led the society through a year of growth in membership and the first campus Advent retreat.'],
            ['name' => 'Tiyamike Nkhoma', 'role' => 'Chairperson', 'category' => 'past', 'tenure' => '2024 / 2025', 'sort_order' => 2,
                'bio' => 'Strengthened the small Christian community structure and expanded the charity outreach calendar.'],
            ['name' => 'Chimango Kamanga', 'role' => 'Chairperson', 'category' => 'past', 'tenure' => '2023 / 2024', 'sort_order' => 3,
                'bio' => 'Revived the CSO choir and established the morning devotion programme.'],
            ['name' => 'Madalitso Kambewa', 'role' => 'Chairperson', 'category' => 'past', 'tenure' => '2022 / 2023', 'sort_order' => 4,
                'bio' => 'Rebuilt the executive structure after the pandemic and renewed ties with the campus chaplaincy.'],
        ];

        foreach ($leaders as $leader) {
            Leader::create($leader + ['photo' => null]);
        }
    }
}
