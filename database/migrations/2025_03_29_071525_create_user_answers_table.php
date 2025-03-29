<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('user_id')->on('users')->onDelete('cascade');
            $table->foreignId('attempt_id')->references('id')->on('exam_attempts')->onDelete('cascade');
            $table->foreignId('question_id')->references('question_id')->on('questions')->onDelete('cascade');
            $table->enum('selected_answer', ['A', 'B', 'C', 'D']);
            $table->boolean('is_correct')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_answers');
    }
};
