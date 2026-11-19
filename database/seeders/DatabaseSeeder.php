<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            AdminUserSeeder::class,
            LeaderSeeder::class,
            ActivitySeeder::class,
            EventSeeder::class,
            AnnouncementSeeder::class,
            ReportSeeder::class,
            GallerySeeder::class,
        ]);

        foreach (App\Models\SiteSetting::defaults() as $key => $value) {
            SiteSetting::updateOrCreate(['key' => $key], ['value' => $value, 'group' => 'content']);
        }
    }
}
