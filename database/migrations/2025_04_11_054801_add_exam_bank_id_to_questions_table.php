<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('questions', function (Blueprint $table) {
            $table->foreignId('exam_bank_id')->nullable()->after('id')
                  ->constrained('exam_banks', 'bank_id')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('questions', function (Blueprint $table) {
            $table->dropForeign(['exam_bank_id']);
            $table->dropColumn('exam_bank_id');
        });
    }
}; 