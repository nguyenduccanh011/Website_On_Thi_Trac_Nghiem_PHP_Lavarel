<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Exam;
use App\Models\Category;

class ExamsTableSeeder extends Seeder
{
    public function run()
    {
        $categoryIds = Category::pluck('category_id')->toArray();

        $exams = [
            [
                'title' => 'Đề thi Toán lớp 10 - Học kỳ 1',
                'description' => 'Đề thi môn Toán lớp 10 học kỳ 1 năm học 2023-2024',
                'duration' => 90,
                'total_marks' => 100,
                'passing_marks' => 50,
                'is_active' => true
            ],
            [
                'title' => 'Đề thi Vật Lý lớp 11 - Học kỳ 2',
                'description' => 'Đề thi môn Vật Lý lớp 11 học kỳ 2 năm học 2023-2024',
                'duration' => 60,
                'total_marks' => 100,
                'passing_marks' => 50,
                'is_active' => true
            ],
            [
                'title' => 'Đề thi Hóa Học lớp 12 - Học kỳ 1',
                'description' => 'Đề thi môn Hóa Học lớp 12 học kỳ 1 năm học 2023-2024',
                'duration' => 90,
                'total_marks' => 100,
                'passing_marks' => 50,
                'is_active' => true
            ],
            [
                'title' => 'Đề thi Tiếng Anh lớp 10 - Học kỳ 2',
                'description' => 'Đề thi môn Tiếng Anh lớp 10 học kỳ 2 năm học 2023-2024',
                'duration' => 60,
                'total_marks' => 100,
                'passing_marks' => 50,
                'is_active' => true
            ],
            [
                'title' => 'Đề thi Ngữ Văn lớp 11 - Học kỳ 1',
                'description' => 'Đề thi môn Ngữ Văn lớp 11 học kỳ 1 năm học 2023-2024',
                'duration' => 120,
                'total_marks' => 100,
                'passing_marks' => 50,
                'is_active' => true
            ]
        ];

        foreach ($exams as $index => $exam) {
            $exam['category_id'] = $categoryIds[$index % count($categoryIds)];
            Exam::create($exam);
        }
    }
} 