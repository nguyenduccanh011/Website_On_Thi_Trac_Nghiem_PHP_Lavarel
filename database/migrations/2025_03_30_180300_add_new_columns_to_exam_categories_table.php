<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('exam_categories', function (Blueprint $table) {
            $table->string('slug')->unique()->after('name');
            $table->foreignId('parent_id')->nullable()->after('description')->references('category_id')->on('exam_categories');
            $table->integer('level')->default(0)->after('parent_id');
            $table->boolean('is_active')->default(true)->after('level');
        });
    }

    public function down()
    {
        Schema::table('exam_categories', function (Blueprint $table) {
            $table->dropForeign(['parent_id']);
            $table->dropColumn(['slug', 'parent_id', 'level', 'is_active']);
        });
    }
}; 