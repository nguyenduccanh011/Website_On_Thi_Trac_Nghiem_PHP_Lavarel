<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ExamCategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            [
                'category_id' => 1,
                'name' => 'TOEIC',
                'slug' => 'toeic',
                'description' => 'Bài thi đánh giá khả năng sử dụng tiếng Anh trong môi trường làm việc quốc tế',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 2,
                'name' => 'IELTS',
                'slug' => 'ielts',
                'description' => 'Bài thi đánh giá khả năng sử dụng tiếng Anh học thuật và giao tiếp quốc tế',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 3,
                'name' => 'TOEFL',
                'slug' => 'toefl',
                'description' => 'Bài thi đánh giá khả năng sử dụng tiếng Anh trong môi trường học thuật',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 4,
                'name' => 'Business English',
                'slug' => 'business-english',
                'description' => 'Các bài thi về tiếng Anh thương mại và kinh doanh',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 5,
                'name' => 'General English',
                'slug' => 'general-english',
                'description' => 'Các bài thi tiếng Anh tổng quát cho mọi trình độ',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('categories')->insert($categories);
    }
} 