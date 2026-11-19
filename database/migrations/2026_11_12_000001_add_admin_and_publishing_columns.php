<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_admin')->default(false)->after('password')->index();
            $table->string('phone')->nullable()->after('email');
        });

        foreach (['activities', 'events', 'gallery_photos', 'leaders', 'reports', 'announcements'] as $tableName) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->boolean('is_published')->default(true)->index();
            });
        }
    }

    public function down(): void
    {
        foreach (['activities', 'events', 'gallery_photos', 'leaders', 'reports', 'announcements'] as $tableName) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->dropColumn('is_published');
            });
        }

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['is_admin', 'phone']);
        });
    }
};
