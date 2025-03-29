<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('exam_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exam_id')->references('exam_id')->on('exams')->onDelete('cascade');
            $table->foreignId('question_id')->references('question_id')->on('questions')->onDelete('cascade');
            $table->integer('question_order')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('exam_questions');
    }
}; 