<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ExamBank;
use App\Models\Category;

class ExamBankSeeder extends Seeder
{
    public function run()
    {
        $categories = Category::all();
        
        foreach ($categories as $category) {
            $difficultyLevels = ['easy', 'medium', 'hard'];
            
            foreach ($difficultyLevels as $level) {
                ExamBank::create([
                    'bank_name' => "Ngân hàng {$category->name} {$level}",
                    'category_id' => $category->id,
                    'description' => "Tập hợp các câu hỏi {$category->name} mức độ {$level}",
                    'difficulty_level' => $level,
                    'total_questions' => 0
                ]);
            }
        }
    }
} 