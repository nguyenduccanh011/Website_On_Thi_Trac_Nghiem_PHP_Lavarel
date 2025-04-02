<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\Exam;
use App\Models\Category;
use App\Models\ExamBank;
use App\Imports\QuestionsImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

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
        $examBanks = ExamBank::all();
        return view('admin.questions.create', compact('examBanks'));
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
            'difficulty_level' => 'required|in:easy,medium,hard',
            'explanation' => 'nullable|string'
        ]);

        $question = Question::create([
            'question_text' => $validated['question_text'],
            'option_a' => $validated['option_a'],
            'option_b' => $validated['option_b'],
            'option_c' => $validated['option_c'],
            'option_d' => $validated['option_d'],
            'correct_answer' => $validated['correct_answer'],
            'difficulty_level' => $validated['difficulty_level'],
            'explanation' => $validated['explanation']
        ]);

        return response()->json([
            'success' => true,
            'question' => $question
        ]);
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
        return response()->json([
            'success' => true
        ]);
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,txt',
        ]);

        try {
            $file = $request->file('file');
            $handle = fopen($file->getPathname(), 'r');
            
            // Đọc dòng đầu tiên làm header
            $header = fgetcsv($handle);
            
            // Chuyển header thành key
            $header = array_map(function($value) {
                return strtolower(trim($value));
            }, $header);
            
            // Đọc từng dòng dữ liệu
            while (($row = fgetcsv($handle)) !== false) {
                $data = array_combine($header, $row);
                
                Question::create([
                    'question_text' => $data['question_text'],
                    'option_a' => $data['option_a'],
                    'option_b' => $data['option_b'],
                    'option_c' => $data['option_c'],
                    'option_d' => $data['option_d'],
                    'correct_answer' => strtoupper($data['correct_answer']),
                    'difficulty_level' => strtolower($data['difficulty_level']),
                    'explanation' => $data['explanation'] ?? null,
                ]);
            }
            
            fclose($handle);
            
            return redirect()->route('admin.questions.index')
                ->with('success', 'Câu hỏi đã được import thành công.');
        } catch (\Exception $e) {
            return back()->with('error', 'Có lỗi xảy ra khi import: ' . $e->getMessage());
        }
    }

    public function downloadTemplate()
    {
        $headers = [
            'Content-Type' => 'application/vnd.ms-excel',
            'Content-Disposition' => 'attachment; filename="questions_template.xlsx"'
        ];

        return response()->download(public_path('templates/questions_template.xlsx'), 'questions_template.xlsx', $headers);
    }
} 