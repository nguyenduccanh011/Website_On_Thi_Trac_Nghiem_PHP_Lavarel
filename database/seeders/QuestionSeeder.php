<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Question;
use App\Models\ExamBank;
use App\Models\Category;

class QuestionSeeder extends Seeder
{
    public function run()
    {
        $examBanks = ExamBank::all();
        $categories = Category::all();

        foreach ($examBanks as $examBank) {
            // Tạo 5 câu hỏi cho mỗi ngân hàng
            for ($i = 0; $i < 5; $i++) {
                Question::create([
                    'question_text' => "Câu hỏi mẫu {$i + 1} cho {$examBank->bank_name}",
                    'option_a' => "Lựa chọn A cho câu {$i + 1}",
                    'option_b' => "Lựa chọn B cho câu {$i + 1}",
                    'option_c' => "Lựa chọn C cho câu {$i + 1}",
                    'option_d' => "Lựa chọn D cho câu {$i + 1}",
                    'correct_answer' => ['A', 'B', 'C', 'D'][rand(0, 3)],
                    'explanation' => "Giải thích cho câu trả lời {$i + 1}",
                    'exam_bank_id' => $examBank->id,
                    'category_id' => $examBank->category_id,
                    'difficulty_level' => $examBank->difficulty_level
                ]);
            }

            // Cập nhật tổng số câu hỏi cho ngân hàng
            $examBank->update(['total_questions' => 5]);
        }
    }
} 