<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\ExamAttempt;
use App\Models\Question;
use App\Models\Leaderboard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExamAttemptController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $attempts = ExamAttempt::with(['exam', 'user'])
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('exam_attempts.index', compact('attempts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Exam $exam)
    {
        // Kiểm tra xem người dùng đã làm bài thi này chưa
        $existingAttempt = ExamAttempt::where('user_id', Auth::id())
            ->where('exam_id', $exam->exam_id)
            ->first();

        if ($existingAttempt) {
            return redirect()->route('exam-attempts.show', ['attempt' => $existingAttempt->id])
                ->with('warning', 'Bạn đã làm bài thi này rồi.');
        }

        // Tạo lần làm bài mới
        $attempt = ExamAttempt::create([
            'user_id' => Auth::id(),
            'exam_id' => $exam->exam_id,
            'start_time' => now(),
            'total_questions' => $exam->questions()->count()
        ]);

        return redirect()->route('exam-attempts.show', ['attempt' => $attempt->id])
            ->with('success', 'Bắt đầu làm bài thi.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(ExamAttempt $attempt)
    {
        // Kiểm tra quyền truy cập
        if ($attempt->user_id !== Auth::id()) {
            abort(403);
        }

        // Load dữ liệu với eager loading
        $attempt->load(['exam.questions']);

        // Kiểm tra xem có câu hỏi không
        if (!$attempt->exam || !$attempt->exam->questions || $attempt->exam->questions->isEmpty()) {
            return redirect()->route('exams.index')
                ->with('error', 'Bài thi này chưa có câu hỏi.');
        }

        return view('exam_attempts.show', compact('attempt'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function submit(Request $request, ExamAttempt $attempt)
    {
        // Kiểm tra quyền truy cập
        if ($attempt->user_id !== Auth::id()) {
            abort(403);
        }

        // Kiểm tra thời gian làm bài
        if ($attempt->end_time) {
            return redirect()->back()->with('error', 'Bài thi đã được nộp.');
        }

        $answers = $request->validate([
            'answers' => 'required|array',
            'answers.*' => 'required|in:A,B,C,D'
        ]);

        $correctCount = 0;
        $incorrectCount = 0;

        foreach ($answers['answers'] as $questionId => $selectedAnswer) {
            $question = Question::findOrFail($questionId);
            $isCorrect = $selectedAnswer === $question->correct_answer;

            // Lưu câu trả lời của người dùng
            $attempt->userAnswers()->create([
                'question_id' => $questionId,
                'selected_answer' => $selectedAnswer,
                'is_correct' => $isCorrect
            ]);

            if ($isCorrect) {
                $correctCount++;
            } else {
                $incorrectCount++;
            }
        }

        // Tính điểm
        $totalQuestions = $attempt->total_questions;
        $score = ($correctCount / $totalQuestions) * 100;

        // Cập nhật kết quả bài thi
        $attempt->update([
            'end_time' => now(),
            'score' => $score,
            'correct_answers' => $correctCount,
            'incorrect_answers' => $incorrectCount
        ]);

        // Cập nhật bảng xếp hạng
        $this->updateLeaderboard($attempt);

        return redirect()->route('exam_attempts.show', $attempt)
            ->with('success', 'Bài thi đã được nộp thành công.');
    }

    private function updateLeaderboard(ExamAttempt $attempt)
    {
        $leaderboard = Leaderboard::firstOrCreate([
            'user_id' => $attempt->user_id,
            'exam_id' => $attempt->exam_id
        ]);
        
        $leaderboard->update([
            'score' => $attempt->score,
            'last_attempt_date' => now()
        ]);

        // Cập nhật thứ hạng
        $this->updateRanks();
    }

    private function updateRanks()
    {
        $users = Leaderboard::orderBy('score', 'desc')->get();
        
        foreach ($users as $index => $user) {
            $user->update(['rank' => $index + 1]);
        }
    }
}
