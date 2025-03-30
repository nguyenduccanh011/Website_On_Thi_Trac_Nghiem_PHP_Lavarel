<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\Exam;
use App\Models\Category;
use App\Models\ExamBank;
use Illuminate\Http\Request;

class AdminQuestionController extends Controller
{
    public function index()
    {
        $questions = Question::with(['exam', 'category', 'examBank'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('admin.questions.index', compact('questions'));
    }

    public function create()
    {
        $exams = Exam::all();
        $categories = Category::all();
        $examBanks = ExamBank::all();
        return view('admin.questions.create', compact('exams', 'categories', 'examBanks'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'question_text' => 'required|string',
            'option_a' => 'required|string',
            'option_b' => 'required|string',
            'option_c' => 'required|string',
            'option_d' => 'required|string',
            'correct_answer' => 'required|in:A,B,C,D',
            'explanation' => 'nullable|string',
            'exam_id' => 'nullable|exists:exams,id',
            'exam_bank_id' => 'nullable|exists:exam_banks,id',
            'category_id' => 'required|exists:categories,id',
            'difficulty_level' => 'required|in:easy,medium,hard'
        ]);

        Question::create($validated);

        return redirect()->route('admin.questions.index')
            ->with('success', 'Câu hỏi đã được thêm thành công.');
    }

    public function edit(Question $question)
    {
        $exams = Exam::all();
        $categories = Category::all();
        $examBanks = ExamBank::all();
        return view('admin.questions.edit', compact('question', 'exams', 'categories', 'examBanks'));
    }

    public function update(Request $request, Question $question)
    {
        $validated = $request->validate([
            'question_text' => 'required|string',
            'option_a' => 'required|string',
            'option_b' => 'required|string',
            'option_c' => 'required|string',
            'option_d' => 'required|string',
            'correct_answer' => 'required|in:A,B,C,D',
            'explanation' => 'nullable|string',
            'exam_id' => 'nullable|exists:exams,id',
            'exam_bank_id' => 'nullable|exists:exam_banks,id',
            'category_id' => 'required|exists:categories,id',
            'difficulty_level' => 'required|in:easy,medium,hard'
        ]);

        $question->update($validated);

        return redirect()->route('admin.questions.index')
            ->with('success', 'Câu hỏi đã được cập nhật thành công.');
    }

    public function destroy(Question $question)
    {
        $question->delete();
        return redirect()->route('admin.questions.index')
            ->with('success', 'Câu hỏi đã được xóa thành công.');
    }
} 