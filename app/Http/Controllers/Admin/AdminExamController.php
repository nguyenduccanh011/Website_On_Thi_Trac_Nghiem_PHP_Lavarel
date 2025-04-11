<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\ExamCategory;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,category_id',
            'duration' => 'required|integer|min:1',
            'total_marks' => 'required|integer|min:1',
            'passing_marks' => 'required|integer|min:1',
            'difficulty_level' => 'required|in:easy,medium,hard',
            'is_active' => 'boolean',
            'new_questions' => 'required|array|min:1',
            'new_questions.*.question_text' => 'required|string',
            'new_questions.*.option_a' => 'required|string',
            'new_questions.*.option_b' => 'required|string',
            'new_questions.*.option_c' => 'required|string',
            'new_questions.*.option_d' => 'required|string',
            'new_questions.*.correct_answer' => 'required|in:A,B,C,D',
            'new_questions.*.difficulty_level' => 'required|in:easy,medium,hard',
            'new_questions.*.explanation' => 'nullable|string',
            'existing_questions' => 'nullable|array',
            'existing_questions.*' => 'exists:questions,id'
        ]);

        try {
            DB::beginTransaction();

            // Tạo đề thi mới
            $exam = Exam::create([
                'title' => $request->title,
                'description' => $request->description,
                'category_id' => $request->category_id,
                'duration' => $request->duration,
                'total_marks' => $request->total_marks,
                'passing_marks' => $request->passing_marks,
                'difficulty_level' => $request->difficulty_level,
                'is_active' => $request->boolean('is_active', true)
            ]);

            // Thêm câu hỏi mới
            foreach ($request->new_questions as $questionData) {
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

                $exam->questions()->attach($question->id);
            }

            // Thêm câu hỏi đã có
            if ($request->has('existing_questions')) {
                $exam->questions()->attach($request->existing_questions);
            }

            DB::commit();

            return redirect()->route('admin.exams.index')
                ->with('success', 'Đề thi đã được tạo thành công.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->with('error', 'Có lỗi xảy ra khi tạo đề thi: ' . $e->getMessage());
        }
    }

    public function edit(Exam $exam)
    {
        $categories = ExamCategory::all();
        $questions = Question::all();
        $examQuestions = $exam->questions()->pluck('questions.id')->toArray();
        
        return view('admin.exams.edit', compact('exam', 'categories', 'questions', 'examQuestions'));
    }

    public function update(Request $request, Exam $exam)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'duration' => 'required|integer|min:1',
            'total_marks' => 'required|integer|min:1',
            'category_id' => 'required|exists:categories,category_id',
            'is_active' => 'boolean'
        ]);

        try {
            DB::beginTransaction();

            // Cập nhật thông tin đề thi
            $exam->update($validated);

            // Xóa tất cả câu hỏi cũ
            $exam->questions()->detach();

            // Cập nhật câu hỏi mới
            if ($request->has('new_questions') && is_array($request->new_questions)) {
                foreach ($request->new_questions as $questionData) {
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

                    $exam->questions()->attach($question->id);
                }
            }

            // Cập nhật câu hỏi đã có
            if ($request->has('existing_questions')) {
                $existingQuestions = is_array($request->existing_questions) 
                    ? $request->existing_questions 
                    : explode(',', $request->existing_questions);
                
                if (!empty($existingQuestions)) {
                    $exam->questions()->attach($existingQuestions);
                }
            }

            DB::commit();

            return redirect()->route('admin.exams.index')
                ->with('success', 'Đề thi đã được cập nhật thành công.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->with('error', 'Có lỗi xảy ra khi cập nhật đề thi: ' . $e->getMessage());
        }
    }

    public function destroy(Exam $exam)
    {
        $exam->delete();
        return redirect()->route('admin.exams.index')
            ->with('success', 'Đề thi đã được xóa.');
    }

    public function import(Request $request)
    {
        try {
            $request->validate([
                'file' => 'required|mimes:csv,txt'
            ]);

            $file = $request->file('file');
            $handle = fopen($file->getPathname(), 'r');
            
            // Đọc dòng tiêu đề và chuẩn hóa
            $header = fgetcsv($handle);
            
            // Xử lý BOM và chuẩn hóa header
            $header = array_map(function($value) {
                $value = preg_replace('/[\x{FEFF}\x{200B}]/u', '', $value);
                return strtolower(trim($value));
            }, $header);
            
            // Kiểm tra các cột bắt buộc
            $requiredColumns = ['title', 'description', 'duration', 'total_marks', 'passing_marks', 'is_active'];
            $missingColumns = array_diff($requiredColumns, $header);
            
            if (!empty($missingColumns)) {
                fclose($handle);
                return back()->with('error', 'File CSV thiếu các cột bắt buộc: ' . implode(', ', $missingColumns) . '. Các cột hiện có: ' . implode(', ', $header));
            }

            // Đọc dữ liệu
            $exams = [];
            $rowNumber = 2; // Bắt đầu từ dòng 2 (sau header)
            
            while (($data = fgetcsv($handle)) !== false) {
                // Chuẩn hóa dữ liệu
                $data = array_map(function($value) {
                    $value = preg_replace('/[\x{FEFF}\x{200B}]/u', '', $value);
                    return trim($value);
                }, $data);
                
                $row = array_combine($header, $data);
                
                // Kiểm tra dữ liệu bắt buộc
                if (empty($row['title']) || empty($row['duration']) || empty($row['total_marks']) || 
                    empty($row['passing_marks'])) {
                    $rowNumber++;
                    continue;
                }

                $exams[] = [
                    'title' => $row['title'],
                    'description' => $row['description'] ?? null,
                    'duration' => (int)$row['duration'],
                    'total_marks' => (int)$row['total_marks'],
                    'passing_marks' => (int)$row['passing_marks'],
                    'is_active' => (bool)$row['is_active'],
                    'created_at' => now(),
                    'updated_at' => now()
                ];
                
                $rowNumber++;
            }
            
            fclose($handle);

            if (empty($exams)) {
                return back()->with('error', 'Không tìm thấy dữ liệu hợp lệ trong file CSV');
            }

            // Import dữ liệu
            Exam::insert($exams);
            
            return back()->with('success', 'Import đề thi thành công!');
        } catch (\Exception $e) {
            return back()->with('error', 'Có lỗi xảy ra khi import: ' . $e->getMessage());
        }
    }

    public function downloadTemplate()
    {
        $filePath = public_path('templates/exams_template.csv');
        
        if (!file_exists($filePath)) {
            return back()->with('error', 'File mẫu không tồn tại.');
        }

        return response()->download($filePath, 'exams_template.csv');
    }
} 