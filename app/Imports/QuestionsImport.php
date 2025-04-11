<?php

namespace App\Imports;

use App\Models\Question;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class QuestionsImport implements ToModel, WithHeadingRow, WithValidation, WithBatchInserts, WithChunkReading
{
    private $rowCount = 0;

    public function model(array $row)
    {
        $this->rowCount++;
        
        return new Question([
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

    public function rules(): array
    {
        return [
            'question_text' => 'required|string',
            'option_a' => 'required|string',
            'option_b' => 'required|string',
            'option_c' => 'required|string',
            'option_d' => 'required|string',
            'correct_answer' => 'required|in:a,b,c,d,A,B,C,D',
            'difficulty_level' => 'required|in:easy,medium,hard,EASY,MEDIUM,HARD',
            'explanation' => 'nullable|string'
        ];
    }

    public function batchSize(): int
    {
        return 100;
    }

    public function chunkSize(): int
    {
        return 100;
    }

    public function getRowCount(): int
    {
        return $this->rowCount;
    }
} 