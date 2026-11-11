<?php

namespace Database\Seeders;

use App\Models\Report;
use Illuminate\Database\Seeder;

/**
 * SAMPLE REPORTS — the three October reports point at your real Drive
 * albums; edit the summaries and add reports as the year goes on.
 */
class ReportSeeder extends Seeder
{
    public function run(): void
    {
        $reports = [
            [
                'title' => 'M’Phakati Fellowship',
                'activity_date' => '2026-10-31',
                'summary' => 'Members spent the evening in fellowship at M’Phakati: praise and worship, a reflection on walking together in faith, and a shared meal after the gathering.',
                'highlights' => [
                    'Evening praise and worship led by the choir',
                    'Reflection on community and accompaniment',
                    'Shared meal and testimonies from first-year members',
                ],
                'cover_image' => '10kA2YHDWECR9gAVRSc6ZL5m8xYeVT7mC',
                'drive_url' => 'https://drive.google.com/drive/folders/1RQ5vw-luivmfep2m0wKpS3H3nXPce5lj',
            ],
            [
                'title' => 'CSO Gathering & Teaching Session',
                'activity_date' => '2026-10-22',
                'summary' => 'A full-hall gathering with catechesis, the rosary and group discussion. New members were welcomed and introduced to the small Christian communities.',
                'highlights' => [
                    'Teaching session on the sacraments',
                    'Rosary prayed together before the session',
                    'Small group introductions for new members',
                ],
                'cover_image' => '10YvZrv8fIpp3UXPudDo4tuAo_B9z6_OZ',
                'drive_url' => 'https://drive.google.com/drive/folders/1jluYdy9KPDybCkjWyaknATGMnS5qFR7J',
            ],
            [
                'title' => 'Sunday Mass & Community Fellowship',
                'activity_date' => '2026-10-18',
                'summary' => 'Sunday Mass with the CSO choir, followed by fellowship and photographs on campus. Attendance continues to grow each week.',
                'highlights' => [
                    'Holy Mass animated by the CSO choir',
                    'Fellowship after Mass',
                    'Photographs archived in the gallery',
                ],
                'cover_image' => '12usmszhcdLinTYwV3RjQD3rObfSgeLQL',
                'drive_url' => 'https://drive.google.com/drive/folders/1phAOlkqLbPoMqkt0xaXiQJ8KEottV8GG',
            ],
            [
                'title' => 'Monthly Charity Visit',
                'activity_date' => '2026-09-26',
                'summary' => 'Members visited patients at Thyolo District Hospital, donated basic necessities and prayed with families. A short report is available in the Reports & Documents folder.',
                'highlights' => [
                    'Donation of soap, sugar and maize flour',
                    'Prayer with patients and guardians',
                    'Follow-up visit planned for December',
                ],
                'cover_image' => null,
                'drive_url' => null,
            ],
        ];

        foreach ($reports as $report) {
            Report::create($report);
        }
    }
}
