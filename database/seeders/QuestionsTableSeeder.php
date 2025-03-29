<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuestionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Câu hỏi cho bài thi Toán học
        $questions = [
            [
                'exam_id' => 1,
                'question_text' => '5 + 7 = ?',
                'marks' => 10,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'exam_id' => 1,
                'question_text' => '12 - 8 = ?',
                'marks' => 10,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'exam_id' => 2,
                'question_text' => 'Đơn vị đo lực là gì?',
                'marks' => 10,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'exam_id' => 2,
                'question_text' => 'Công thức tính vận tốc là gì?',
                'marks' => 10,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'exam_id' => 3,
                'question_text' => 'Công thức hóa học của nước là gì?',
                'marks' => 10,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];

        foreach ($questions as $question) {
            $questionId = DB::table('questions')->insertGetId($question);

            // Thêm câu trả lời cho từng câu hỏi
            switch ($questionId) {
                case 1:
                    $answers = [
                        ['question_id' => $questionId, 'answer_text' => '10', 'is_correct' => false],
                        ['question_id' => $questionId, 'answer_text' => '11', 'is_correct' => false],
                        ['question_id' => $questionId, 'answer_text' => '12', 'is_correct' => true],
                        ['question_id' => $questionId, 'answer_text' => '13', 'is_correct' => false]
                    ];
                    break;
                case 2:
                    $answers = [
                        ['question_id' => $questionId, 'answer_text' => '2', 'is_correct' => false],
                        ['question_id' => $questionId, 'answer_text' => '3', 'is_correct' => false],
                        ['question_id' => $questionId, 'answer_text' => '4', 'is_correct' => true],
                        ['question_id' => $questionId, 'answer_text' => '5', 'is_correct' => false]
                    ];
                    break;
                case 3:
                    $answers = [
                        ['question_id' => $questionId, 'answer_text' => 'Newton (N)', 'is_correct' => true],
                        ['question_id' => $questionId, 'answer_text' => 'Joule (J)', 'is_correct' => false],
                        ['question_id' => $questionId, 'answer_text' => 'Watt (W)', 'is_correct' => false],
                        ['question_id' => $questionId, 'answer_text' => 'Pascal (Pa)', 'is_correct' => false]
                    ];
                    break;
                case 4:
                    $answers = [
                        ['question_id' => $questionId, 'answer_text' => 'v = s/t', 'is_correct' => true],
                        ['question_id' => $questionId, 'answer_text' => 'v = t/s', 'is_correct' => false],
                        ['question_id' => $questionId, 'answer_text' => 'v = s*t', 'is_correct' => false],
                        ['question_id' => $questionId, 'answer_text' => 'v = s+t', 'is_correct' => false]
                    ];
                    break;
                case 5:
                    $answers = [
                        ['question_id' => $questionId, 'answer_text' => 'H2O', 'is_correct' => true],
                        ['question_id' => $questionId, 'answer_text' => 'CO2', 'is_correct' => false],
                        ['question_id' => $questionId, 'answer_text' => 'O2', 'is_correct' => false],
                        ['question_id' => $questionId, 'answer_text' => 'H2', 'is_correct' => false]
                    ];
                    break;
            }

            foreach ($answers as $answer) {
                $answer['created_at'] = now();
                $answer['updated_at'] = now();
                DB::table('answers')->insert($answer);
            }
        }
    }
}
