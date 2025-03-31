<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ExamBankSeeder extends Seeder
{
    public function run()
    {
        $examBanks = [
            [
                'bank_id' => 1,
                'name' => 'TOEIC Reading Practice',
                'slug' => 'toeic-reading-practice',
                'category_id' => 1, // TOEIC
                'description' => 'Ngân hàng câu hỏi đọc hiểu TOEIC',
                'difficulty_level' => 'medium',
                'total_questions' => 0,
                'time_limit' => 60,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'bank_id' => 2,
                'name' => 'TOEIC Listening Practice',
                'slug' => 'toeic-listening-practice',
                'category_id' => 1, // TOEIC
                'description' => 'Ngân hàng câu hỏi nghe hiểu TOEIC',
                'difficulty_level' => 'medium',
                'total_questions' => 0,
                'time_limit' => 45,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'bank_id' => 3,
                'name' => 'IELTS Academic Reading',
                'slug' => 'ielts-academic-reading',
                'category_id' => 2, // IELTS
                'description' => 'Ngân hàng câu hỏi đọc hiểu IELTS Academic',
                'difficulty_level' => 'hard',
                'total_questions' => 0,
                'time_limit' => 60,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'bank_id' => 4,
                'name' => 'IELTS General Writing',
                'slug' => 'ielts-general-writing',
                'category_id' => 2, // IELTS
                'description' => 'Ngân hàng câu hỏi viết IELTS General',
                'difficulty_level' => 'medium',
                'total_questions' => 0,
                'time_limit' => 60,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'bank_id' => 5,
                'name' => 'TOEFL Reading Comprehension',
                'slug' => 'toefl-reading-comprehension',
                'category_id' => 3, // TOEFL
                'description' => 'Ngân hàng câu hỏi đọc hiểu TOEFL',
                'difficulty_level' => 'hard',
                'total_questions' => 0,
                'time_limit' => 60,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'bank_id' => 6,
                'name' => 'Business Communication',
                'slug' => 'business-communication',
                'category_id' => 4, // Business English
                'description' => 'Ngân hàng câu hỏi giao tiếp trong kinh doanh',
                'difficulty_level' => 'medium',
                'total_questions' => 0,
                'time_limit' => 45,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'bank_id' => 7,
                'name' => 'General Grammar',
                'slug' => 'general-grammar',
                'category_id' => 5, // General English
                'description' => 'Ngân hàng câu hỏi ngữ pháp tiếng Anh tổng quát',
                'difficulty_level' => 'easy',
                'total_questions' => 0,
                'time_limit' => 30,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('exam_banks')->insert($examBanks);
    }
} 