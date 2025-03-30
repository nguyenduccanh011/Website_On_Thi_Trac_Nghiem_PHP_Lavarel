<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ExamBank;
use App\Models\Category;
use Illuminate\Http\Request;

class AdminExamBankController extends Controller
{
    public function index()
    {
        $examBanks = ExamBank::with('category')->paginate(10);
        return view('admin.exam-banks.index', compact('examBanks'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.exam-banks.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'bank_name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'difficulty_level' => 'required|in:easy,medium,hard',
            'total_questions' => 'required|integer|min:1'
        ]);

        ExamBank::create($validated);

        return redirect()->route('admin.exam-banks.index')
            ->with('success', 'Ngân hàng câu hỏi đã được tạo thành công.');
    }

    public function edit(ExamBank $examBank)
    {
        $categories = Category::all();
        return view('admin.exam-banks.edit', compact('examBank', 'categories'));
    }

    public function update(Request $request, ExamBank $examBank)
    {
        $validated = $request->validate([
            'bank_name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'difficulty_level' => 'required|in:easy,medium,hard',
            'total_questions' => 'required|integer|min:1'
        ]);

        $examBank->update($validated);

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