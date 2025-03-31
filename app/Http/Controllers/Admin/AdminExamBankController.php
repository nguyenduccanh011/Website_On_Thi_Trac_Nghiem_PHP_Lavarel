<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ExamBank;
use App\Models\Category;
use App\Models\ExamCategory;
use App\Models\Question;
use Illuminate\Http\Request;

class AdminExamBankController extends Controller
{
    public function index()
    {
        $examBanks = ExamBank::with('categories')->paginate(10);
        return view('admin.exam-banks.index', compact('examBanks'));
    }

    public function create()
    {
        $categories = ExamCategory::all();
        $questions = Question::all();
        return view('admin.exam-banks.create', compact('categories', 'questions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_ids' => 'required|array',
            'category_ids.*' => 'exists:exam_categories,category_id',
            'description' => 'nullable|string',
            'difficulty_level' => 'required|in:easy,medium,hard',
            'total_questions' => 'required|integer|min:1',
            'questions' => 'required|array|min:1',
            'questions.*' => 'exists:questions,question_id'
        ]);

        $examBank = ExamBank::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'difficulty_level' => $validated['difficulty_level'],
            'total_questions' => $validated['total_questions']
        ]);

        // Gán các danh mục cho ngân hàng
        $examBank->categories()->attach($validated['category_ids']);

        // Gán các câu hỏi được chọn cho ngân hàng
        foreach ($validated['questions'] as $questionId) {
            Question::where('question_id', $questionId)->update(['exam_bank_id' => $examBank->bank_id]);
        }

        return redirect()->route('admin.exam-banks.index')
            ->with('success', 'Ngân hàng câu hỏi đã được tạo thành công.');
    }

    public function edit(ExamBank $examBank)
    {
        $categories = ExamCategory::all();
        $questions = Question::all();
        $examBank->load('questions'); // Load questions relationship
        return view('admin.exam-banks.edit', compact('examBank', 'categories', 'questions'));
    }

    public function update(Request $request, ExamBank $examBank)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_ids' => 'required|array',
            'category_ids.*' => 'exists:exam_categories,category_id',
            'description' => 'nullable|string',
            'difficulty_level' => 'required|in:easy,medium,hard',
            'total_questions' => 'required|integer|min:1',
            'questions' => 'required|array|min:1',
            'questions.*' => 'exists:questions,question_id'
        ]);

        $examBank->update([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'difficulty_level' => $validated['difficulty_level'],
            'total_questions' => $validated['total_questions']
        ]);

        // Cập nhật danh mục
        $examBank->categories()->sync($validated['category_ids']);

        // Cập nhật câu hỏi
        foreach ($validated['questions'] as $questionId) {
            Question::where('question_id', $questionId)->update(['exam_bank_id' => $examBank->bank_id]);
        }

        return redirect()->route('admin.exam-banks.index')
            ->with('success', 'Ngân hàng câu hỏi đã được cập nhật thành công.');
    }

    public function destroy(ExamBank $examBank)
    {
        $examBank->delete();
        return redirect()->route('admin.exam-banks.index')
            ->with('success', 'Ngân hàng câu hỏi đã được xóa.');
    }
} 