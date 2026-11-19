<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('activities', function (Blueprint $table) {
            $table->boolean('is_featured')->default(false)->after('is_published');
            $table->unsignedInteger('featured_order')->default(0)->after('is_featured');
            $table->string('video')->nullable()->after('image');
            $table->string('video_thumbnail')->nullable()->after('video');
        });

        Schema::table('events', function (Blueprint $table) {
            $table->unsignedInteger('featured_order')->default(0)->after('is_featured');
            $table->string('video')->nullable()->after('image');
            $table->string('video_thumbnail')->nullable()->after('video');
        });

        Schema::table('announcements', function (Blueprint $table) {
            $table->unsignedInteger('featured_order')->default(0)->after('is_featured');
        });

        Schema::table('gallery_photos', function (Blueprint $table) {
            $table->unsignedInteger('featured_order')->default(0)->after('is_featured');
        });
    }

    public function down(): void
    {
        Schema::table('activities', function (Blueprint $table) {
            $table->dropColumn(['is_featured', 'featured_order', 'video', 'video_thumbnail']);
        });

        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn(['featured_order', 'video', 'video_thumbnail']);
        });

        Schema::table('announcements', function (Blueprint $table) {
            $table->dropColumn(['featured_order']);
        });

        Schema::table('gallery_photos', function (Blueprint $table) {
            $table->dropColumn(['featured_order']);
        });
    }
};
