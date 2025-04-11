<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ExamQuestionSeeder extends Seeder
{
    public function run()
    {
        $now = Carbon::now();
        
        // Lấy tất cả các câu hỏi
        $questions = DB::table('questions')->get();
        
        // Lấy tất cả các đề thi
        $exams = DB::table('exams')->get();
        
        // Liên kết câu hỏi với đề thi
        foreach ($exams as $exam) {
            // Lấy ngẫu nhiên 3-5 câu hỏi cho mỗi đề thi
            $randomQuestions = $questions->random(rand(3, 5));
            
            $order = 1;
            foreach ($randomQuestions as $question) {
                DB::table('exam_questions')->insert([
                    'exam_id' => $exam->id,
                    'question_id' => $question->id,
                    'order_index' => $order++,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }
        }
    }
} 