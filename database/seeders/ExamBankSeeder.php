<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ExamBankSeeder extends Seeder
{
    public function run()
    {
        // Tắt kiểm tra khóa ngoại tạm thời
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // Xóa tất cả dữ liệu cũ trong bảng
        DB::table('exam_banks')->truncate();
        
        // Bật lại kiểm tra khóa ngoại
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $examBanks = [
            // TOEIC Banks
            [
                'name' => 'TOEIC Reading Part 5 & 6',
                'slug' => 'toeic-reading-part-5-6',
                'description' => 'Ngân hàng câu hỏi TOEIC Reading Part 5 & 6 - Incomplete Sentences & Text Completion',
                'total_questions' => 0,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'TOEIC Reading Part 7',
                'slug' => 'toeic-reading-part-7',
                'description' => 'Ngân hàng câu hỏi TOEIC Reading Part 7 - Reading Comprehension',
                'total_questions' => 0,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'TOEIC Listening Part 1 & 2',
                'slug' => 'toeic-listening-part-1-2',
                'description' => 'Ngân hàng câu hỏi TOEIC Listening Part 1 & 2 - Photographs & Question-Response',
                'total_questions' => 0,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'TOEIC Listening Part 3 & 4',
                'slug' => 'toeic-listening-part-3-4',
                'description' => 'Ngân hàng câu hỏi TOEIC Listening Part 3 & 4 - Conversations & Talks',
                'total_questions' => 0,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // IELTS Banks
            [
                'name' => 'IELTS Academic Reading',
                'slug' => 'ielts-academic-reading',
                'description' => 'Ngân hàng câu hỏi IELTS Academic Reading - Academic Texts',
                'total_questions' => 0,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'IELTS General Reading',
                'slug' => 'ielts-general-reading',
                'description' => 'Ngân hàng câu hỏi IELTS General Reading - Everyday Texts',
                'total_questions' => 0,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'IELTS Writing Task 1',
                'slug' => 'ielts-writing-task-1',
                'description' => 'Ngân hàng đề bài IELTS Writing Task 1 - Data Description',
                'total_questions' => 0,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'IELTS Writing Task 2',
                'slug' => 'ielts-writing-task-2',
                'description' => 'Ngân hàng đề bài IELTS Writing Task 2 - Essay Writing',
                'total_questions' => 0,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // TOEFL Banks
            [
                'name' => 'TOEFL Reading',
                'slug' => 'toefl-reading',
                'description' => 'Ngân hàng câu hỏi TOEFL Reading - Academic Passages',
                'total_questions' => 0,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'TOEFL Listening',
                'slug' => 'toefl-listening',
                'description' => 'Ngân hàng câu hỏi TOEFL Listening - Lectures & Conversations',
                'total_questions' => 0,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Business English Banks
            [
                'name' => 'Business Communication',
                'slug' => 'business-communication',
                'description' => 'Ngân hàng câu hỏi về giao tiếp trong kinh doanh',
                'total_questions' => 0,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Business Writing',
                'slug' => 'business-writing',
                'description' => 'Ngân hàng câu hỏi về viết thư tín thương mại',
                'total_questions' => 0,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // General English Banks
            [
                'name' => 'Grammar Practice',
                'slug' => 'grammar-practice',
                'description' => 'Ngân hàng câu hỏi ngữ pháp tiếng Anh tổng quát',
                'total_questions' => 0,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Vocabulary Builder',
                'slug' => 'vocabulary-builder',
                'description' => 'Ngân hàng câu hỏi từ vựng tiếng Anh',
                'total_questions' => 0,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('exam_banks')->insert($examBanks);
    }
} 