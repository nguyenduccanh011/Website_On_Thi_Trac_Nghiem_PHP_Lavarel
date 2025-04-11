<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class CreateExcelTemplate extends Command
{
    protected $signature = 'template:create';
    protected $description = 'Create Excel template for importing questions';

    public function handle()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set headers
        $headers = [
            'question_text',
            'option_a',
            'option_b',
            'option_c',
            'option_d',
            'correct_answer',
            'difficulty_level',
            'explanation'
        ];

        $sheet->fromArray($headers, null, 'A1');

        // Add example data
        $example = [
            'What is PHP?',
            'Hypertext Preprocessor',
            'Personal Home Page',
            'Programming Home Protocol',
            'None of these',
            'A',
            'easy',
            'PHP is a server-side scripting language'
        ];

        $sheet->fromArray($example, null, 'A2');

        // Save file
        $writer = new Xlsx($spreadsheet);
        $writer->save(storage_path('app/templates/exam-bank-template.xlsx'));

        $this->info('Excel template created successfully at: ' . storage_path('app/templates/exam-bank-template.xlsx'));
    }
} 