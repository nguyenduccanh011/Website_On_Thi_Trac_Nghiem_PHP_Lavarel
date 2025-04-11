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
            ExamSeeder::class,
            QuestionSeeder::class,
            CategoriesTableSeeder::class,
            ExamsTableSeeder::class,
            ExamQuestionSeeder::class,
        ]);
    }
} 