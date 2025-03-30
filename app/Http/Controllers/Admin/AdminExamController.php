<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\ExamCategory;
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
        return view('admin.exams.create', compact('categories'));
    }

    public function store(Request $request)
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

        Exam::create($validated);

        return redirect()->route('admin.exams.index')
            ->with('success', 'Đề thi đã được tạo thành công.');
    }

    public function edit(Exam $exam)
    {
        $categories = ExamCategory::all();
        return view('admin.exams.edit', compact('exam', 'categories'));
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