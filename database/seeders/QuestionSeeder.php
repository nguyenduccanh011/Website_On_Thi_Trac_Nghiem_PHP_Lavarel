<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuestionSeeder extends Seeder
{
    public function run()
    {
        $questions = [
            // TOEIC Practice Test 1
            [
                'question_id' => 1,
                'exam_id' => 1,
                'question_text' => 'The marketing department _____ the new advertising campaign next week.',
                'option_a' => 'launch',
                'option_b' => 'launches',
                'option_c' => 'will launch',
                'option_d' => 'launching',
                'correct_answer' => 'C',
                'marks' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'question_id' => 2,
                'exam_id' => 1,
                'question_text' => 'Please submit your expense reports _____ the end of each month.',
                'option_a' => 'by',
                'option_b' => 'until',
                'option_c' => 'for',
                'option_d' => 'since',
                'correct_answer' => 'A',
                'marks' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // IELTS Reading Practice
            [
                'question_id' => 3,
                'exam_id' => 2,
                'question_text' => 'According to the passage, what is the main cause of global warming?',
                'option_a' => 'Deforestation',
                'option_b' => 'Greenhouse gas emissions',
                'option_c' => 'Industrial pollution',
                'option_d' => 'Ocean acidification',
                'correct_answer' => 'B',
                'marks' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // TOEFL iBT Reading Test
            [
                'question_id' => 4,
                'exam_id' => 3,
                'question_text' => 'What can be inferred from the passage about the author\'s view on renewable energy?',
                'option_a' => 'It is too expensive to implement',
                'option_b' => 'It is the only solution to climate change',
                'option_c' => 'It requires more research and development',
                'option_d' => 'It is not effective in reducing carbon emissions',
                'correct_answer' => 'C',
                'marks' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Business Communication Test
            [
                'question_id' => 5,
                'exam_id' => 4,
                'question_text' => 'Which of the following is the most appropriate way to begin a formal business email?',
                'option_a' => 'Hey there,',
                'option_b' => 'Dear Sir/Madam,',
                'option_c' => 'Hi everyone,',
                'option_d' => 'What\'s up?',
                'correct_answer' => 'B',
                'marks' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('questions')->insert($questions);
    }
} 