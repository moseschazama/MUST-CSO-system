<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('prayer_intentions', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->text('intention');
            $table->boolean('is_anonymous')->default(true);
            $table->date('mass_date')->nullable();
            $table->string('status')->default('pending')->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prayer_intentions');
    }
};
