<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\ExamCategory;
use App\Models\Question;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $exams = Exam::with('category')->paginate(10);
        return view('exams.index', compact('exams'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = ExamCategory::all();
        $questions = Question::all();
        return view('exams.create', compact('categories', 'questions'));
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
            'exam_name' => 'required|string|max:255',
            'easy_question_count' => 'required|integer|min:0',
            'medium_question_count' => 'required|integer|min:0',
            'hard_question_count' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:exam_categories,category_id',
            'duration' => 'required|integer|min:1',
            'total_marks' => 'required|integer|min:1',
            'passing_marks' => 'required|integer|min:1',
            'is_active' => 'required|boolean'
        ]);

        // Map exam_name thành title
        $validated['title'] = $validated['exam_name'];
        unset($validated['exam_name']);

        $exam = Exam::create($validated);

        // Tự động chọn câu hỏi ngẫu nhiên theo độ khó
        $this->assignRandomQuestions($exam);

        return redirect()->route('exams.index')
            ->with('success', 'Đề thi đã được tạo thành công.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Exam $exam)
    {
        $exam->load(['category', 'questions']);
        return view('exams.show', compact('exam'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Exam $exam)
    {
        $categories = ExamCategory::all();
        $subjects = Subject::all();
        return view('exams.edit', compact('exam', 'categories', 'subjects'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Exam $exam)
    {
        $validated = $request->validate([
            'exam_name' => 'required|string|max:255',
            'easy_question_count' => 'required|integer|min:0',
            'medium_question_count' => 'required|integer|min:0',
            'hard_question_count' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:exam_categories,category_id'
        ]);

        $exam->update($validated);

        // Cập nhật lại câu hỏi cho đề thi
        $exam->examQuestions()->delete();
        $this->assignRandomQuestions($exam);

        return redirect()->route('exams.index')
            ->with('success', 'Đề thi đã được cập nhật thành công.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Exam $exam)
    {
        $exam->delete();
        return redirect()->route('exams.index')
            ->with('success', 'Đề thi đã được xóa thành công.');
    }

    private function assignRandomQuestions(Exam $exam)
    {
        // Lấy câu hỏi ngẫu nhiên theo độ khó
        $easyQuestions = Question::where('difficulty_level', 'easy')
            ->inRandomOrder()
            ->limit($exam->easy_question_count)
            ->get();

        $mediumQuestions = Question::where('difficulty_level', 'medium')
            ->inRandomOrder()
            ->limit($exam->medium_question_count)
            ->get();

        $hardQuestions = Question::where('difficulty_level', 'hard')
            ->inRandomOrder()
            ->limit($exam->hard_question_count)
            ->get();

        // Gộp tất cả câu hỏi và thêm vào đề thi
        $allQuestions = $easyQuestions->concat($mediumQuestions)->concat($hardQuestions);
        $order = 1;

        foreach ($allQuestions as $question) {
            $exam->examQuestions()->create([
                'question_id' => $question->question_id,
                'question_order' => $order++
            ]);
        }
    }
}
