<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ExamBankQuestionSeeder extends Seeder
{
    public function run()
    {
        $now = Carbon::now();
        
        // Lấy tất cả các câu hỏi
        $questions = DB::table('questions')->get();
        
        // Lấy tất cả các ngân hàng đề thi
        $examBanks = DB::table('exam_banks')->get();
        
        // Liên kết câu hỏi với ngân hàng đề thi
        foreach ($examBanks as $bank) {
            // Lấy ngẫu nhiên 5-10 câu hỏi cho mỗi ngân hàng đề thi
            $randomQuestions = $questions->random(rand(5, 10));
            
            foreach ($randomQuestions as $question) {
                DB::table('exam_bank_questions')->insert([
                    'bank_id' => $bank->bank_id,
                    'question_id' => $question->id,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }
            
            // Cập nhật tổng số câu hỏi trong ngân hàng đề thi
            DB::table('exam_banks')
                ->where('bank_id', $bank->bank_id)
                ->update(['total_questions' => DB::table('exam_bank_questions')
                    ->where('bank_id', $bank->bank_id)
                    ->count()]);
        }
    }
} 