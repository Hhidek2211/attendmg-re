<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('basic_worktimes', function (Blueprint $table) {
            $table->id();
            $table->integer("week_of_day");
            $table->boolean("isleave");
            $table->time("work_start_time");
            $table->time("work_end_time");
            $table->time("break_time");
            $table->foreignId('user_id')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('basic_worktimes');
    }
};
