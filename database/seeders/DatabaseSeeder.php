<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\ExamBank;
use App\Models\Question;
use App\Models\Exam;
use App\Models\ExamQuestion;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Hash;

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
        DB::table('exam_banks')->truncate();
        DB::table('categories')->truncate();
        DB::table('users')->truncate();

        // Bật lại kiểm tra khóa ngoại
        Schema::enableForeignKeyConstraints();

        // Tạo tài khoản admin
        User::create([
            'username' => 'admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Tạo tài khoản user thường
        User::create([
            'username' => 'user',
            'email' => 'user@example.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        // Tạo danh mục mẫu
        $categories = [
            ['name' => 'TOEIC', 'description' => 'Bài thi TOEIC'],
            ['name' => 'IELTS', 'description' => 'Bài thi IELTS'],
            ['name' => 'TOEFL', 'description' => 'Bài thi TOEFL'],
        ];

        $createdCategories = [];
        foreach ($categories as $category) {
            $cat = Category::create($category);
            $createdCategories[] = $cat;
        }

        // Tạo ngân hàng đề thi mẫu
        $examBanks = [
            [
                'bank_name' => 'TOEIC Reading Practice',
                'category_id' => $createdCategories[0]->id,
                'description' => 'Ngân hàng câu hỏi đọc hiểu TOEIC',
                'difficulty_level' => 'medium',
                'total_questions' => 0
            ],
            [
                'bank_name' => 'IELTS Writing Practice',
                'category_id' => $createdCategories[1]->id,
                'description' => 'Ngân hàng câu hỏi viết IELTS',
                'difficulty_level' => 'hard',
                'total_questions' => 0
            ]
        ];

        $createdExamBanks = [];
        foreach ($examBanks as $bank) {
            $createdExamBanks[] = ExamBank::create($bank);
        }

        // Tạo câu hỏi mẫu
        $questions = [
            [
                'question_text' => 'What is the capital of France?',
                'option_a' => 'London',
                'option_b' => 'Paris',
                'option_c' => 'Berlin',
                'option_d' => 'Madrid',
                'correct_answer' => 'B',
                'explanation' => 'Paris is the capital city of France.',
                'exam_bank_id' => $createdExamBanks[0]->id,
                'difficulty_level' => 'easy'
            ],
            [
                'question_text' => 'Which language is most widely spoken in the world?',
                'option_a' => 'English',
                'option_b' => 'Spanish',
                'option_c' => 'Mandarin Chinese',
                'option_d' => 'Hindi',
                'correct_answer' => 'C',
                'explanation' => 'Mandarin Chinese is the most widely spoken language in the world.',
                'exam_bank_id' => $createdExamBanks[0]->id,
                'difficulty_level' => 'medium'
            ],
            [
                'question_text' => 'What is the largest planet in our solar system?',
                'option_a' => 'Mars',
                'option_b' => 'Venus',
                'option_c' => 'Jupiter',
                'option_d' => 'Saturn',
                'correct_answer' => 'C',
                'explanation' => 'Jupiter is the largest planet in our solar system.',
                'exam_bank_id' => $createdExamBanks[1]->id,
                'difficulty_level' => 'easy'
            ]
        ];

        $createdQuestions = [];
        foreach ($questions as $question) {
            $createdQuestions[] = Question::create($question);
        }

        // Cập nhật số lượng câu hỏi trong ngân hàng
        foreach ($createdExamBanks as $bank) {
            $bank->total_questions = Question::where('exam_bank_id', $bank->id)->count();
            $bank->save();
        }

        // Tạo đề thi mẫu
        $exams = [
            [
                'exam_name' => 'TOEIC Practice Test 1',
                'category_id' => $createdCategories[0]->id,
                'description' => 'Bài thi TOEIC mẫu 1',
                'time_limit' => 120,
                'total_marks' => 990,
            ],
            [
                'exam_name' => 'IELTS Academic Test 1',
                'category_id' => $createdCategories[1]->id,
                'description' => 'Bài thi IELTS Academic mẫu 1',
                'time_limit' => 180,
                'total_marks' => 9,
            ]
        ];

        $createdExams = [];
        foreach ($exams as $exam) {
            $createdExams[] = Exam::create($exam);
        }

        // Liên kết câu hỏi với đề thi
        $examQuestions = [
            [
                'exam_id' => $createdExams[0]->id,
                'question_id' => $createdQuestions[0]->id,
            ],
            [
                'exam_id' => $createdExams[0]->id,
                'question_id' => $createdQuestions[1]->id,
            ],
            [
                'exam_id' => $createdExams[1]->id,
                'question_id' => $createdQuestions[2]->id,
            ]
        ];

        foreach ($examQuestions as $examQuestion) {
            ExamQuestion::create($examQuestion);
        }
    }
}
