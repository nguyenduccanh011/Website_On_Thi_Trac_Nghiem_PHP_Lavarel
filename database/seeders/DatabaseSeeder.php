<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ExamCategory;
use App\Models\Exam;
use App\Models\Question;
use App\Models\ExamQuestion;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // Tắt kiểm tra khóa ngoại
        Schema::disableForeignKeyConstraints();

        // Xóa dữ liệu cũ
        DB::table('exam_questions')->truncate();
        DB::table('questions')->truncate();
        DB::table('exams')->truncate();
        DB::table('exam_categories')->truncate();
        DB::table('users')->truncate();

        // Bật lại kiểm tra khóa ngoại
        Schema::enableForeignKeyConstraints();

        // Chạy UsersTableSeeder
        $this->call(UsersTableSeeder::class);

        // Tạo danh mục mẫu
        $categories = [
            ['name' => 'TOEIC', 'description' => 'Bài thi TOEIC'],
            ['name' => 'IELTS', 'description' => 'Bài thi IELTS'],
            ['name' => 'TOEFL', 'description' => 'Bài thi TOEFL'],
        ];

        $createdCategories = [];
        foreach ($categories as $category) {
            $cat = ExamCategory::create($category);
            dump("Created category with ID: " . $cat->category_id);
            $createdCategories[] = $cat;
        }

        // Tạo bài thi mẫu
        $exams = [
            [
                'title' => 'TOEIC Practice Test 1',
                'description' => 'Bài thi TOEIC mẫu 1',
                'category_id' => $createdCategories[0]->category_id,
                'duration' => 120,
                'total_marks' => 990,
                'passing_marks' => 600,
                'is_active' => true
            ],
            [
                'title' => 'IELTS Academic Test 1',
                'description' => 'Bài thi IELTS Academic mẫu 1',
                'category_id' => $createdCategories[1]->category_id,
                'duration' => 180,
                'total_marks' => 9,
                'passing_marks' => 6,
                'is_active' => true
            ]
        ];

        dump("First exam category_id: " . $exams[0]['category_id']);
        dump("Second exam category_id: " . $exams[1]['category_id']);

        $createdExams = [];
        foreach ($exams as $exam) {
            $createdExams[] = Exam::create($exam);
        }

        // Tạo câu hỏi mẫu
        $questions = [
            [
                'exam_id' => $createdExams[0]->exam_id,
                'question_text' => 'What is the capital of France?',
                'option_a' => 'London',
                'option_b' => 'Paris',
                'option_c' => 'Berlin',
                'option_d' => 'Madrid',
                'correct_answer' => 'B',
                'marks' => 1
            ],
            [
                'exam_id' => $createdExams[0]->exam_id,
                'question_text' => 'Which language is most widely spoken in the world?',
                'option_a' => 'English',
                'option_b' => 'Spanish',
                'option_c' => 'Mandarin Chinese',
                'option_d' => 'Hindi',
                'correct_answer' => 'C',
                'marks' => 1
            ],
            [
                'exam_id' => $createdExams[1]->exam_id,
                'question_text' => 'What is the largest planet in our solar system?',
                'option_a' => 'Mars',
                'option_b' => 'Venus',
                'option_c' => 'Jupiter',
                'option_d' => 'Saturn',
                'correct_answer' => 'C',
                'marks' => 1
            ]
        ];

        $createdQuestions = [];
        foreach ($questions as $question) {
            $createdQuestions[] = Question::create($question);
        }

        // Liên kết câu hỏi với bài thi
        $examQuestions = [
            [
                'exam_id' => $createdExams[0]->exam_id,
                'question_id' => $createdQuestions[0]->question_id,
                'question_order' => 1
            ],
            [
                'exam_id' => $createdExams[0]->exam_id,
                'question_id' => $createdQuestions[1]->question_id,
                'question_order' => 2
            ],
            [
                'exam_id' => $createdExams[1]->exam_id,
                'question_id' => $createdQuestions[2]->question_id,
                'question_order' => 1
            ]
        ];

        foreach ($examQuestions as $examQuestion) {
            ExamQuestion::create($examQuestion);
        }
    }
}
