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
        Schema::create('records', function (Blueprint $table) {
            $table->id();

            // 追加するカラム
            $table->unsignedBigInteger('member_id');
            $table->date('date');
            $table->decimal('weight', 5, 1); // 例: 46.5
            $table->integer('calories');     // 例: 1200
            $table->string('exercise_time'); // 例: 00:15

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('records');
    }
};
