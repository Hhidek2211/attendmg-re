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
        Schema::create('exceptional_days', function (Blueprint $table) {
            $table->id();
            $table->date('day');
            $table->boolean("isleave");
            $table->time("work_start_time");
            $table->time("work_end_time");
            $table->time("break_time");
            $table->time('work_hour');
            $table->time('over_time');
            $table->foreignId('user_id')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exceptional_days');
    }
};
