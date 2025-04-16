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
        $questions = Question::with(['exam', 'category', 'examBanks'])
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
            'question_text' => 'required|string|max:1000',
            'option_a' => 'required|string|max:255',
            'option_b' => 'required|string|max:255',
            'option_c' => 'required|string|max:255',
            'option_d' => 'required|string|max:255',
            'correct_answer' => 'required|in:A,B,C,D',
            'explanation' => 'nullable|string|max:1000',
            'difficulty_level' => 'required|in:easy,medium,hard',
        ]);

        Question::create($validated);

        return redirect()->route('admin.questions.index')
            ->with('success', 'Câu hỏi đã được tạo thành công.');
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
            'question_text' => 'required|string|max:1000',
            'option_a' => 'required|string|max:255',
            'option_b' => 'required|string|max:255',
            'option_c' => 'required|string|max:255',
            'option_d' => 'required|string|max:255',
            'correct_answer' => 'required|in:A,B,C,D',
            'explanation' => 'nullable|string|max:1000',
            'difficulty_level' => 'required|in:easy,medium,hard',
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

    public function import(Request $request)
    {
        try {
            $request->validate([
                'file' => 'required|mimes:csv,txt'
            ]);

            $file = $request->file('file');
            $handle = fopen($file->getPathname(), 'r');
            
            if (!$handle) {
                throw new \Exception('Không thể mở file. Vui lòng kiểm tra lại file.');
            }
            
            // Đọc dòng header
            $header = fgetcsv($handle);
            if (!$header) {
                throw new \Exception('File không có dữ liệu hoặc không đúng định dạng.');
            }
            
            $header = array_map('strtolower', $header);
            $requiredColumns = ['question_text', 'option_a', 'option_b', 'option_c', 'option_d', 'correct_answer'];
            
            // Kiểm tra các cột bắt buộc
            foreach ($requiredColumns as $column) {
                if (!in_array($column, $header)) {
                    throw new \Exception("Thiếu cột bắt buộc: {$column}");
                }
            }
            
            $importedQuestions = [];
            $rowNumber = 1; // Bắt đầu từ 1 vì đã đọc header
            
            // Đọc từng dòng dữ liệu
            while (($data = fgetcsv($handle)) !== false) {
                $rowNumber++;
                
                if (count($data) !== count($header)) {
                    throw new \Exception("Dòng {$rowNumber} có số cột không khớp với header.");
                }
                
                $row = array_combine($header, $data);
                
                // Validate dữ liệu
                if (empty($row['question_text'])) {
                    throw new \Exception("Dòng {$rowNumber}: Thiếu nội dung câu hỏi");
                }
                
                if (empty($row['option_a']) || empty($row['option_b']) || 
                    empty($row['option_c']) || empty($row['option_d'])) {
                    throw new \Exception("Dòng {$rowNumber}: Thiếu đáp án");
                }
                
                $correctAnswer = strtoupper(trim($row['correct_answer']));
                if (!in_array($correctAnswer, ['A', 'B', 'C', 'D'])) {
                    throw new \Exception("Dòng {$rowNumber}: Đáp án đúng phải là A, B, C hoặc D");
                }
                
                // Tạo câu hỏi mới
                $question = Question::create([
                    'question_text' => $row['question_text'],
                    'option_a' => $row['option_a'],
                    'option_b' => $row['option_b'],
                    'option_c' => $row['option_c'],
                    'option_d' => $row['option_d'],
                    'correct_answer' => $correctAnswer,
                    'difficulty_level' => $row['difficulty_level'] ?? 'medium',
                    'explanation' => $row['explanation'] ?? null
                ]);
                
                $importedQuestions[] = $question;
            }
            
            fclose($handle);
            
            if (empty($importedQuestions)) {
                throw new \Exception('Không có câu hỏi nào được import. Vui lòng kiểm tra lại file.');
            }
            
            return response()->json([
                'success' => true,
                'questions' => $importedQuestions
            ]);
            
        } catch (\Exception $e) {
            if (isset($handle) && is_resource($handle)) {
                fclose($handle);
            }
            
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function downloadTemplate()
    {
        $filePath = public_path('templates/questions_template.csv');
        
        if (!file_exists($filePath)) {
            return back()->with('error', 'File mẫu không tồn tại.');
        }

        return response()->download($filePath, 'questions_template.csv');
    }
} 