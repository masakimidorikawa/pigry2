<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up()
{
    Schema::create('weight_logs', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('member_id');
        $table->date('date');
        $table->decimal('weight', 4, 1);
        $table->integer('calories')->nullable();
        $table->time('exercise_time')->nullable();
        $table->text('exercise_content')->nullable();
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('weight_logs');
    }
};
