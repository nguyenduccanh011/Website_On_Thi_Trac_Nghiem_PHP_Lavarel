<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ExamSeeder extends Seeder
{
    public function run()
    {
        $now = Carbon::now();
        
        DB::table('exams')->insert([
            // TOEIC Exams
            [
                'title' => 'TOEIC Full Practice Test 1',
                'description' => 'Bài thi TOEIC đầy đủ với 200 câu hỏi theo format chuẩn (100 Listening, 100 Reading)',
                'category_id' => 1,
                'duration' => 120,
                'total_marks' => 990,
                'passing_marks' => 450,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'TOEIC Reading Practice Test 1',
                'description' => 'Bài thi TOEIC Reading với 100 câu hỏi (Part 5, 6, 7)',
                'category_id' => 1,
                'duration' => 75,
                'total_marks' => 495,
                'passing_marks' => 225,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'TOEIC Listening Practice Test 1',
                'description' => 'Bài thi TOEIC Listening với 100 câu hỏi (Part 1, 2, 3, 4)',
                'category_id' => 1,
                'duration' => 45,
                'total_marks' => 495,
                'passing_marks' => 225,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            // IELTS Exams
            [
                'title' => 'IELTS Academic Reading Test 1',
                'description' => 'Bài thi IELTS Academic Reading với 3 passages và 40 câu hỏi',
                'category_id' => 2,
                'duration' => 60,
                'total_marks' => 40,
                'passing_marks' => 20,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'IELTS General Reading Test 1',
                'description' => 'Bài thi IELTS General Reading với 3 sections và 40 câu hỏi',
                'category_id' => 2,
                'duration' => 60,
                'total_marks' => 40,
                'passing_marks' => 20,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'IELTS Writing Practice Task 1',
                'description' => 'Bài tập IELTS Writing Task 1 với các dạng biểu đồ và bảng',
                'category_id' => 2,
                'duration' => 20,
                'total_marks' => 9,
                'passing_marks' => 5,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'IELTS Writing Practice Task 2',
                'description' => 'Bài tập IELTS Writing Task 2 với các chủ đề essay',
                'category_id' => 2,
                'duration' => 40,
                'total_marks' => 9,
                'passing_marks' => 5,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            // TOEFL Exams
            [
                'title' => 'TOEFL Reading Practice Test 1',
                'description' => 'Bài thi TOEFL Reading với 3-4 passages và 30-40 câu hỏi',
                'category_id' => 3,
                'duration' => 54,
                'total_marks' => 30,
                'passing_marks' => 15,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'TOEFL Listening Practice Test 1',
                'description' => 'Bài thi TOEFL Listening với 28-39 câu hỏi (Lectures & Conversations)',
                'category_id' => 3,
                'duration' => 41,
                'total_marks' => 30,
                'passing_marks' => 15,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            // Business English Exams
            [
                'title' => 'Business Communication Test 1',
                'description' => 'Kiểm tra kỹ năng giao tiếp trong môi trường kinh doanh',
                'category_id' => 4,
                'duration' => 45,
                'total_marks' => 50,
                'passing_marks' => 30,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'Business Writing Test 1',
                'description' => 'Kiểm tra kỹ năng viết thư tín thương mại',
                'category_id' => 4,
                'duration' => 45,
                'total_marks' => 50,
                'passing_marks' => 30,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            // General English Exams
            [
                'title' => 'Grammar Test - Intermediate',
                'description' => 'Bài kiểm tra ngữ pháp tiếng Anh trình độ trung cấp',
                'category_id' => 5,
                'duration' => 30,
                'total_marks' => 40,
                'passing_marks' => 24,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'Vocabulary Test - Advanced',
                'description' => 'Bài kiểm tra từ vựng tiếng Anh trình độ nâng cao',
                'category_id' => 5,
                'duration' => 30,
                'total_marks' => 40,
                'passing_marks' => 24,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
} 