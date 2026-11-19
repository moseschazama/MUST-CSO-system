<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('election_positions', function (Blueprint $table) {
            $table->foreignId('winner_candidate_id')->nullable()->after('sort_order')->constrained('candidates')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('election_positions', function (Blueprint $table) {
            $table->dropForeign(['winner_candidate_id']);
            $table->dropColumn('winner_candidate_id');
        });
    }
};
