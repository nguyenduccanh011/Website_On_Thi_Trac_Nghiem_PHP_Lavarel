<?php

namespace App\Http\Controllers;

use App\Models\ExamCategory;
use Illuminate\Http\Request;

class ExamCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = ExamCategory::paginate(10);
        return view('exam_categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('exam_categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:exam_categories',
            'description' => 'nullable|string'
        ]);

        ExamCategory::create($validated);

        return redirect()->route('exam-categories.index')
            ->with('success', 'Chủ đề thi đã được tạo thành công.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(ExamCategory $examCategory)
    {
        $exams = $examCategory->exams()->paginate(10);
        return view('exam_categories.show', compact('examCategory', 'exams'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(ExamCategory $examCategory)
    {
        return view('exam_categories.edit', compact('examCategory'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ExamCategory $examCategory)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:exam_categories,name,' . $examCategory->category_id . ',category_id',
            'description' => 'nullable|string'
        ]);

        $examCategory->update($validated);

        return redirect()->route('exam-categories.index')
            ->with('success', 'Chủ đề thi đã được cập nhật thành công.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(ExamCategory $examCategory)
    {
        $examCategory->delete();

        return redirect()->route('exam-categories.index')
            ->with('success', 'Chủ đề thi đã được xóa thành công.');
    }
}
