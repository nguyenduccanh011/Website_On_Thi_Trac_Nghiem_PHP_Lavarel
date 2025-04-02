<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\ExamCategory;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminExamController extends Controller
{
    public function index()
    {
        $exams = Exam::with('category')->paginate(10);
        return view('admin.exams.index', compact('exams'));
    }

    public function create()
    {
        $categories = ExamCategory::all();
        $questions = Question::all();
        return view('admin.exams.create', compact('categories', 'questions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,category_id',
            'duration' => 'required|integer|min:1',
            'total_marks' => 'required|integer|min:1',
            'passing_marks' => 'required|integer|min:1',
            'difficulty_level' => 'required|in:easy,medium,hard',
            'is_active' => 'boolean',
            'new_questions' => 'required|array|min:1',
            'new_questions.*.question_text' => 'required|string',
            'new_questions.*.option_a' => 'required|string',
            'new_questions.*.option_b' => 'required|string',
            'new_questions.*.option_c' => 'required|string',
            'new_questions.*.option_d' => 'required|string',
            'new_questions.*.correct_answer' => 'required|in:A,B,C,D',
            'new_questions.*.difficulty_level' => 'required|in:easy,medium,hard',
            'new_questions.*.explanation' => 'nullable|string',
            'existing_questions' => 'nullable|array',
            'existing_questions.*' => 'exists:questions,id'
        ]);

        try {
            DB::beginTransaction();

            // Tạo đề thi mới
            $exam = Exam::create([
                'title' => $request->title,
                'description' => $request->description,
                'category_id' => $request->category_id,
                'duration' => $request->duration,
                'total_marks' => $request->total_marks,
                'passing_marks' => $request->passing_marks,
                'difficulty_level' => $request->difficulty_level,
                'is_active' => $request->boolean('is_active', true)
            ]);

            // Thêm câu hỏi mới
            foreach ($request->new_questions as $questionData) {
                $question = Question::create([
                    'question_text' => $questionData['question_text'],
                    'option_a' => $questionData['option_a'],
                    'option_b' => $questionData['option_b'],
                    'option_c' => $questionData['option_c'],
                    'option_d' => $questionData['option_d'],
                    'correct_answer' => $questionData['correct_answer'],
                    'difficulty_level' => $questionData['difficulty_level'],
                    'explanation' => $questionData['explanation'] ?? null
                ]);

                $exam->questions()->attach($question->id);
            }

            // Thêm câu hỏi đã có
            if ($request->has('existing_questions')) {
                $exam->questions()->attach($request->existing_questions);
            }

            DB::commit();

            return redirect()->route('admin.exams.index')
                ->with('success', 'Đề thi đã được tạo thành công.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->with('error', 'Có lỗi xảy ra khi tạo đề thi: ' . $e->getMessage());
        }
    }

    public function edit(Exam $exam)
    {
        $categories = ExamCategory::all();
        $questions = Question::all();
        $examQuestions = $exam->questions()->pluck('questions.id')->toArray();
        
        return view('admin.exams.edit', compact('exam', 'categories', 'questions', 'examQuestions'));
    }

    public function update(Request $request, Exam $exam)
    {
        $validated = $request->validate([
            'exam_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'duration' => 'required|integer|min:1',
            'total_marks' => 'required|integer|min:1',
            'passing_marks' => 'required|integer|min:1',
            'difficulty_level' => 'required|in:easy,medium,hard',
            'category_id' => 'required|exists:categories,category_id',
            'is_active' => 'boolean'
        ]);

        $exam->update($validated);

        return redirect()->route('admin.exams.index')
            ->with('success', 'Đề thi đã được cập nhật thành công.');
    }

    public function destroy(Exam $exam)
    {
        $exam->delete();
        return redirect()->route('admin.exams.index')
            ->with('success', 'Đề thi đã được xóa.');
    }
} 