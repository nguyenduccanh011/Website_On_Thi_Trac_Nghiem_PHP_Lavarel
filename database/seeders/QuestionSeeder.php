<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class QuestionSeeder extends Seeder
{
    public function run()
    {
        $now = Carbon::now();
        $questions = [
            // TOEIC Practice Test 1
            [
                'question_text' => 'The marketing department _____ the new advertising campaign next week.',
                'option_a' => 'launch',
                'option_b' => 'launches',
                'option_c' => 'will launch',
                'option_d' => 'launching',
                'correct_answer' => 'C',
                'explanation' => 'Future tense is needed to describe a planned future action.',
                'difficulty_level' => 'medium',
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'question_text' => 'Please submit your expense reports _____ the end of each month.',
                'option_a' => 'by',
                'option_b' => 'until',
                'option_c' => 'for',
                'option_d' => 'since',
                'correct_answer' => 'A',
                'explanation' => 'The preposition "by" is used to indicate a deadline.',
                'difficulty_level' => 'easy',
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            // IELTS Reading Practice
            [
                'question_text' => 'According to the passage, what is the main cause of global warming?',
                'option_a' => 'Deforestation',
                'option_b' => 'Greenhouse gas emissions',
                'option_c' => 'Industrial pollution',
                'option_d' => 'Ocean acidification',
                'correct_answer' => 'B',
                'explanation' => 'The passage identifies greenhouse gas emissions as the primary contributor to global warming.',
                'difficulty_level' => 'medium',
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            // TOEFL iBT Reading Test
            [
                'question_text' => 'What can be inferred from the passage about the author\'s view on renewable energy?',
                'option_a' => 'It is too expensive to implement',
                'option_b' => 'It is the only solution to climate change',
                'option_c' => 'It requires more research and development',
                'option_d' => 'It is not effective in reducing carbon emissions',
                'correct_answer' => 'C',
                'explanation' => 'The author suggests that while renewable energy is promising, more research and development is needed.',
                'difficulty_level' => 'hard',
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            // Business Communication Test
            [
                'question_text' => 'Which of the following is the most appropriate way to begin a formal business email?',
                'option_a' => 'Hey there,',
                'option_b' => 'Dear Sir/Madam,',
                'option_c' => 'Hi everyone,',
                'option_d' => 'What\'s up?',
                'correct_answer' => 'B',
                'explanation' => 'In formal business communication, "Dear Sir/Madam," is the most appropriate salutation.',
                'difficulty_level' => 'easy',
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        DB::table('questions')->insert($questions);
    }
} 