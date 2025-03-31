<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\ExamCategory;
use App\Models\Question;
use Illuminate\Http\Request;

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
        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'category_id' => 'required|exists:exam_categories,category_id',
                'description' => 'nullable|string',
                'duration' => 'required|integer|min:1',
                'total_marks' => 'required|integer|min:1',
                'passing_marks' => 'required|integer|min:1',
                'difficulty_level' => 'required|in:easy,medium,hard',
                'is_active' => 'boolean',
                'existing_questions' => 'required_without:new_questions|array',
                'existing_questions.*' => 'exists:questions,question_id',
                'new_questions' => 'required_without:existing_questions|array',
                'new_questions.*.question_text' => 'required|string',
                'new_questions.*.option_a' => 'required|string',
                'new_questions.*.option_b' => 'required|string',
                'new_questions.*.option_c' => 'required|string',
                'new_questions.*.option_d' => 'required|string',
                'new_questions.*.correct_answer' => 'required|in:A,B,C,D',
                'new_questions.*.difficulty_level' => 'required|in:easy,medium,hard',
                'new_questions.*.explanation' => 'nullable|string'
            ]);

            // Tạo đề thi mới
            $exam = Exam::create([
                'title' => $validated['title'],
                'category_id' => $validated['category_id'],
                'description' => $validated['description'],
                'duration' => $validated['duration'],
                'total_marks' => $validated['total_marks'],
                'passing_marks' => $validated['passing_marks'],
                'difficulty_level' => $validated['difficulty_level'],
                'is_active' => $request->boolean('is_active', true)
            ]);

            // Thêm các câu hỏi đã có (nếu có)
            if (!empty($validated['existing_questions'])) {
                foreach ($validated['existing_questions'] as $index => $questionId) {
                    $exam->questions()->attach($questionId, ['order_index' => $index + 1]);
                }
            }

            // Thêm các câu hỏi mới
            if (!empty($validated['new_questions'])) {
                foreach ($validated['new_questions'] as $index => $questionData) {
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

                    $exam->questions()->attach($question->question_id, [
                        'order_index' => count($validated['existing_questions'] ?? []) + $index + 1
                    ]);
                }
            }

            return redirect()->route('admin.exams.index')
                ->with('success', 'Đề thi đã được tạo thành công.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Có lỗi xảy ra khi tạo đề thi: ' . $e->getMessage());
        }
    }

    public function edit(Exam $exam)
    {
        $categories = ExamCategory::all();
        $questions = Question::all();
        $examQuestions = $exam->questions()->pluck('questions.question_id')->toArray();
        
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
            'category_id' => 'required|exists:exam_categories,category_id',
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