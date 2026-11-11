<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('gallery_photos', function (Blueprint $table) {
            $table->id();
            $table->string('album');
            $table->string('title');
            // Holy Mass | CSO Meetings & Fellowship | Morning Devotion | Other CSO Activities
            $table->string('category')->index();
            // Google Drive file ID used for the thumbnail and the full-size link.
            $table->string('drive_file_id');
            $table->string('alt')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gallery_photos');
    }
};
