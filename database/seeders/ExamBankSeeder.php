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
            [
                'name' => 'TOEIC Reading Practice',
                'slug' => 'toeic-reading-practice',
                'description' => 'Ngân hàng câu hỏi đọc hiểu TOEIC',
                'total_questions' => 0,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'TOEIC Listening Practice',
                'slug' => 'toeic-listening-practice',
                'description' => 'Ngân hàng câu hỏi nghe hiểu TOEIC',
                'total_questions' => 0,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'IELTS Academic Reading',
                'slug' => 'ielts-academic-reading',
                'description' => 'Ngân hàng câu hỏi đọc hiểu IELTS Academic',
                'total_questions' => 0,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'IELTS General Writing',
                'slug' => 'ielts-general-writing',
                'description' => 'Ngân hàng câu hỏi viết IELTS General',
                'total_questions' => 0,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'TOEFL Reading Comprehension',
                'slug' => 'toefl-reading-comprehension',
                'description' => 'Ngân hàng câu hỏi đọc hiểu TOEFL',
                'total_questions' => 0,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Business Communication',
                'slug' => 'business-communication',
                'description' => 'Ngân hàng câu hỏi giao tiếp trong kinh doanh',
                'total_questions' => 0,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'General Grammar',
                'slug' => 'general-grammar',
                'description' => 'Ngân hàng câu hỏi ngữ pháp tiếng Anh tổng quát',
                'total_questions' => 0,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('exam_banks')->insert($examBanks);
    }
} 