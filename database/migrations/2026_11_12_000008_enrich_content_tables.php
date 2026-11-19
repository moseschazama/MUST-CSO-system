<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('activities', function (Blueprint $table) {
            $table->string('slug')->nullable()->unique()->after('title');
            $table->string('summary')->nullable()->after('description');
            $table->string('image')->nullable()->after('icon');
            $table->string('album')->nullable()->after('image');
        });

        Schema::table('events', function (Blueprint $table) {
            // ordinary | religious | social | workshop | election | other
            $table->string('event_type')->default('ordinary')->index()->after('slug');
            $table->dateTime('ends_at')->nullable()->after('starts_at');
            $table->boolean('registration_enabled')->default(false)->after('description');
            $table->unsignedInteger('capacity')->nullable()->after('registration_enabled');
            $table->string('map_query')->nullable()->after('venue');
            $table->string('album')->nullable()->after('image');
        });

        Schema::table('announcements', function (Blueprint $table) {
            $table->string('slug')->nullable()->unique()->after('title');
            $table->string('excerpt')->nullable()->after('body');
            $table->string('image')->nullable()->after('excerpt');
            $table->string('category')->default('news')->index()->after('level');
            $table->boolean('is_featured')->default(false)->after('category');
        });

        Schema::table('members', function (Blueprint $table) {
            $table->string('department')->nullable()->after('programme');
            $table->json('interests')->nullable()->after('department');
            $table->json('preferred_activities')->nullable()->after('interests');
            $table->string('requested_group')->nullable()->after('mphakati');
            $table->string('allocation_status')->default('unallocated')->after('requested_group');
            $table->text('allocation_note')->nullable()->after('allocation_status');
            $table->text('additional_info')->nullable()->after('motivation');
        });

        Schema::table('gallery_photos', function (Blueprint $table) {
            $table->string('image_path')->nullable()->after('drive_file_id');
            $table->string('caption')->nullable()->after('alt');
            $table->text('album_description')->nullable()->after('caption');
            $table->date('taken_on')->nullable()->after('album_description');
            $table->boolean('is_featured')->default(false)->after('sort_order');
        });

        Schema::table('leaders', function (Blueprint $table) {
            $table->foreignId('election_position_id')->nullable()->after('id')->constrained('election_positions')->nullOnDelete();
            $table->date('term_start')->nullable()->after('tenure');
            $table->date('term_end')->nullable()->after('term_start');
        });
    }

    public function down(): void
    {
        Schema::table('leaders', function (Blueprint $table) {
            $table->dropConstrainedForeignId('election_position_id');
            $table->dropColumn(['term_start', 'term_end']);
        });

        Schema::table('gallery_photos', function (Blueprint $table) {
            $table->dropColumn(['image_path', 'caption', 'album_description', 'taken_on', 'is_featured']);
        });

        Schema::table('members', function (Blueprint $table) {
            $table->dropColumn(['department', 'interests', 'preferred_activities', 'requested_group', 'allocation_status', 'allocation_note', 'additional_info']);
        });

        Schema::table('announcements', function (Blueprint $table) {
            $table->dropColumn(['slug', 'excerpt', 'image', 'category', 'is_featured']);
        });

        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn(['event_type', 'ends_at', 'registration_enabled', 'capacity', 'map_query', 'album']);
        });

        Schema::table('activities', function (Blueprint $table) {
            $table->dropColumn(['slug', 'summary', 'image', 'album']);
        });
    }
};
