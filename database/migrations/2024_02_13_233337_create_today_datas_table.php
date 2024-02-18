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
        Schema::create('today_datas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->integer('data_type');   //0:退勤(or何もしてない) 1:出勤中 2:休憩開始 3:休憩終了
            $table->timestamp('time')->nullable();
            $table->timestamps();
            //softdeleteにすべきかは要検討
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('today_datas');
    }
};
