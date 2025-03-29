<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ExamsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $exams = [
            [
                'title' => 'Kiểm tra Toán học cơ bản',
                'description' => 'Bài kiểm tra kiến thức Toán học cơ bản',
                'category_id' => 1,
                'duration' => 30,
                'total_marks' => 100,
                'passing_marks' => 40,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'title' => 'Kiểm tra Vật lý cơ bản',
                'description' => 'Bài kiểm tra kiến thức Vật lý cơ bản',
                'category_id' => 2,
                'duration' => 45,
                'total_marks' => 100,
                'passing_marks' => 40,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'title' => 'Kiểm tra Hóa học cơ bản',
                'description' => 'Bài kiểm tra kiến thức Hóa học cơ bản',
                'category_id' => 3,
                'duration' => 45,
                'total_marks' => 100,
                'passing_marks' => 40,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];

        DB::table('exams')->insert($exams);
    }
}
