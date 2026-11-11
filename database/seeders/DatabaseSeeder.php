<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            LeaderSeeder::class,
            ActivitySeeder::class,
            EventSeeder::class,
            AnnouncementSeeder::class,
            ReportSeeder::class,
            GallerySeeder::class,
        ]);
    }
}
