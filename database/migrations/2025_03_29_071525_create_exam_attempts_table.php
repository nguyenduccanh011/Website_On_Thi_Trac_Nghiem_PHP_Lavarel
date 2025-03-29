<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('exam_attempts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('user_id')->on('users')->onDelete('cascade');
            $table->foreignId('exam_id')->references('exam_id')->on('exams')->onDelete('cascade');
            $table->timestamp('start_time');
            $table->timestamp('end_time')->nullable();
            $table->integer('score')->nullable();
            $table->integer('total_questions')->default(0);
            $table->integer('correct_answers')->default(0);
            $table->integer('incorrect_answers')->default(0);
            $table->enum('status', ['pending', 'completed', 'failed'])->default('pending');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('exam_attempts');
    }
}; 