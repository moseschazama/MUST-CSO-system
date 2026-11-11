<?php

namespace Database\Seeders;

use App\Models\GalleryPhoto;
use Illuminate\Database\Seeder;

/**
 * Builds the gallery from the albums in config/cso.php.
 */
class GallerySeeder extends Seeder
{
    public function run(): void
    {
        $order = 0;

        foreach (config('cso.drive.albums', []) as $album) {
            foreach ($album['files'] ?? [] as $index => $fileId) {
                GalleryPhoto::create([
                    'album' => $album['label'],
                    'title' => $album['label'].' — Photo '.($index + 1),
                    'category' => $album['category'],
                    'drive_file_id' => $fileId,
                    'alt' => $album['label'].' photo '.($index + 1).' — MUST Catholic Students Organization',
                    'sort_order' => ++$order,
                ]);
            }
        }
    }
}
