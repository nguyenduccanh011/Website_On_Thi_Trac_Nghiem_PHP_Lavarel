<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ExamCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            [
                'name' => 'Toán học',
                'description' => 'Các bài thi về Toán học',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Vật lý',
                'description' => 'Các bài thi về Vật lý',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Hóa học',
                'description' => 'Các bài thi về Hóa học',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Sinh học',
                'description' => 'Các bài thi về Sinh học',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Tiếng Anh',
                'description' => 'Các bài thi về Tiếng Anh',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];

        DB::table('exam_categories')->insert($categories);
    }
}
