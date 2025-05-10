<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            UserSeeder::class,
            ExamCategorySeeder::class,
            ExamBankSeeder::class,
            QuestionSeeder::class,
            ExamBankQuestionSeeder::class,
            ExamSeeder::class,
            ExamQuestionSeeder::class,
        ]);
    }
} 