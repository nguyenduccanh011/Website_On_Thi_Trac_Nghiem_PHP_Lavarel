<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ExamSeeder extends Seeder
{
    public function run()
    {
        $exams = [
            [
                'exam_id' => 1,
                'title' => 'TOEIC Practice Test 1',
                'description' => 'Bài thi TOEIC thực hành với 200 câu hỏi theo format chuẩn',
                'category_id' => 1, // TOEIC
                'duration' => 120,
                'total_marks' => 990,
                'passing_marks' => 450,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'exam_id' => 2,
                'title' => 'IELTS Reading Practice',
                'description' => 'Bài thi thực hành IELTS Reading với 3 passages và 40 câu hỏi',
                'category_id' => 2, // IELTS
                'duration' => 60,
                'total_marks' => 40,
                'passing_marks' => 20,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'exam_id' => 3,
                'title' => 'TOEFL iBT Reading Test',
                'description' => 'Bài thi thực hành TOEFL iBT Reading với các passages học thuật',
                'category_id' => 3, // TOEFL
                'duration' => 54,
                'total_marks' => 30,
                'passing_marks' => 15,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'exam_id' => 4,
                'title' => 'Business Communication Test',
                'description' => 'Kiểm tra kỹ năng giao tiếp trong môi trường kinh doanh',
                'category_id' => 4, // Business English
                'duration' => 45,
                'total_marks' => 50,
                'passing_marks' => 30,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'exam_id' => 5,
                'title' => 'English Grammar Test - Intermediate',
                'description' => 'Bài kiểm tra ngữ pháp tiếng Anh trình độ trung cấp',
                'category_id' => 5, // General English
                'duration' => 30,
                'total_marks' => 40,
                'passing_marks' => 24,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('exams')->insert($exams);
    }
} 