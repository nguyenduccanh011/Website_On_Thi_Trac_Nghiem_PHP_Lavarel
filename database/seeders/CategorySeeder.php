<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            [
                'name' => 'Tiếng Anh',
                'description' => 'Các câu hỏi về ngữ pháp, từ vựng và kỹ năng tiếng Anh'
            ],
            [
                'name' => 'Toán Học',
                'description' => 'Các câu hỏi về đại số, hình học và giải tích'
            ],
            [
                'name' => 'Vật Lý',
                'description' => 'Các câu hỏi về cơ học, điện học và quang học'
            ],
            [
                'name' => 'Hóa Học',
                'description' => 'Các câu hỏi về hóa vô cơ, hóa hữu cơ và hóa lý'
            ],
            [
                'name' => 'Sinh Học',
                'description' => 'Các câu hỏi về di truyền, tiến hóa và sinh thái học'
            ]
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
} 