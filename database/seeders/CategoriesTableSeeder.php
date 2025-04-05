<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategoriesTableSeeder extends Seeder
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
                'name' => 'Toán Học',
                'description' => 'Các đề thi môn Toán từ cơ bản đến nâng cao'
            ],
            [
                'name' => 'Vật Lý',
                'description' => 'Các đề thi môn Vật Lý từ cơ bản đến nâng cao'
            ],
            [
                'name' => 'Hóa Học',
                'description' => 'Các đề thi môn Hóa Học từ cơ bản đến nâng cao'
            ],
            [
                'name' => 'Tiếng Anh',
                'description' => 'Các đề thi môn Tiếng Anh từ cơ bản đến nâng cao'
            ],
            [
                'name' => 'Ngữ Văn',
                'description' => 'Các đề thi môn Ngữ Văn từ cơ bản đến nâng cao'
            ]
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
