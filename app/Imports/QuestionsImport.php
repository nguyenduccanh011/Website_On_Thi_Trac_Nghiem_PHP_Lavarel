<?php

namespace App\Imports;

use App\Models\Question;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class QuestionsImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            Question::create([
                'question_text' => $row['question_text'],
                'option_a' => $row['option_a'],
                'option_b' => $row['option_b'],
                'option_c' => $row['option_c'],
                'option_d' => $row['option_d'],
                'correct_answer' => strtoupper($row['correct_answer']),
                'difficulty_level' => strtolower($row['difficulty_level']),
                'explanation' => $row['explanation'] ?? null,
            ]);
        }
    }
} 