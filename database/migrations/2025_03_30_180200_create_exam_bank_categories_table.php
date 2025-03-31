<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('exam_bank_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bank_id')->references('bank_id')->on('exam_banks')->onDelete('cascade');
            $table->foreignId('category_id')->references('category_id')->on('exam_categories')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('exam_bank_categories');
    }
}; 