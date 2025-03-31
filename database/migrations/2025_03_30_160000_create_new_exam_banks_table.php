<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('exam_banks', function (Blueprint $table) {
            $table->id('bank_id');
            $table->string('name');
            $table->string('slug')->unique();
            $table->foreignId('category_id')->constrained('exam_categories', 'category_id')->onDelete('cascade');
            $table->text('description')->nullable();
            $table->integer('total_questions')->default(0);
            $table->enum('difficulty_level', ['easy', 'medium', 'hard'])->default('medium');
            $table->integer('time_limit')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('exam_banks');
    }
}; 