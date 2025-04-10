<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ExamCategorySeeder extends Seeder
{
    public function run()
    {
        DB::table('exam_categories')->insert([
            [
                'name' => 'TOEIC',
                'slug' => Str::slug('TOEIC'),
                'description' => 'Đề thi TOEIC',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'IELTS',
                'slug' => Str::slug('IELTS'),
                'description' => 'Đề thi IELTS',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'TOEFL',
                'slug' => Str::slug('TOEFL'),
                'description' => 'Đề thi TOEFL',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
} 