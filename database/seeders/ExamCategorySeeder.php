<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ExamCategorySeeder extends Seeder
{
    public function run()
    {
        // Tắt kiểm tra khóa ngoại tạm thời
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // Xóa tất cả dữ liệu cũ trong bảng
        DB::table('categories')->truncate();
        
        // Bật lại kiểm tra khóa ngoại
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        DB::table('categories')->insert([
            [
                'category_id' => 1,
                'name' => 'TOEIC',
                'slug' => Str::slug('TOEIC'),
                'description' => 'Đề thi TOEIC',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 2,
                'name' => 'IELTS',
                'slug' => Str::slug('IELTS'),
                'description' => 'Đề thi IELTS',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 3,
                'name' => 'TOEFL',
                'slug' => Str::slug('TOEFL'),
                'description' => 'Đề thi TOEFL',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 4,
                'name' => 'Business English',
                'slug' => Str::slug('Business English'),
                'description' => 'Tiếng Anh thương mại',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 5,
                'name' => 'General English',
                'slug' => Str::slug('General English'),
                'description' => 'Tiếng Anh tổng quát',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
} 