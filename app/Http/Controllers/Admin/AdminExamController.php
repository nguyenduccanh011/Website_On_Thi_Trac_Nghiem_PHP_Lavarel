<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\ExamCategory;
use App\Models\Question;
use App\Models\ExamBank;
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
        $examBanks = ExamBank::withCount(['questions' => function($query) {
            $query->select(DB::raw('count(*)'));
        }])->get();
        $questions = Question::all();
        return view('admin.exams.create', compact('categories', 'examBanks', 'questions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,category_id',
            'duration' => 'required|integer|min:1',
            'questions' => 'required|array|min:1',
            'questions.*' => 'exists:questions,id'
        ]);

        try {
            DB::beginTransaction();

            // Tạo đề thi mới
            $exam = Exam::create([
                'title' => $request->title,
                'description' => $request->description,
                'category_id' => $request->category_id,
                'duration' => $request->duration,
                'total_marks' => count($request->questions) * 1, // Mỗi câu 1 điểm
                'passing_marks' => ceil(count($request->questions) * 0.6), // 60% để đậu
                'is_active' => true
            ]);

            // Thêm câu hỏi vào đề thi
            $exam->questions()->attach($request->questions);

            DB::commit();

            return redirect()->route('admin.exams.index')
                ->with('success', 'Đề thi đã được tạo thành công.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->with('error', 'Có lỗi xảy ra khi tạo đề thi: ' . $e->getMessage());
        }
    }

    public function getRandomQuestions(Request $request, ExamBank $examBank)
    {
        $request->validate([
            'easy_count' => 'required|integer|min:0',
            'medium_count' => 'required|integer|min:0',
            'hard_count' => 'required|integer|min:0'
        ]);

        try {
            $easyQuestions = $examBank->questions()
                ->where('difficulty_level', 'easy')
                ->inRandomOrder()
                ->limit($request->easy_count)
                ->get();

            $mediumQuestions = $examBank->questions()
                ->where('difficulty_level', 'medium')
                ->inRandomOrder()
                ->limit($request->medium_count)
                ->get();

            $hardQuestions = $examBank->questions()
                ->where('difficulty_level', 'hard')
                ->inRandomOrder()
                ->limit($request->hard_count)
                ->get();

            $questions = $easyQuestions->concat($mediumQuestions)->concat($hardQuestions);

            return response()->json([
                'success' => true,
                'questions' => $questions
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi lấy câu hỏi: ' . $e->getMessage()
            ], 500);
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
            if ($request->has('questions')) {
                $exam->questions()->attach($request->questions);
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