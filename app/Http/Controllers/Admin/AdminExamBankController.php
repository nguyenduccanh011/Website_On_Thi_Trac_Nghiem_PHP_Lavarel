<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ExamBank;
use App\Models\Category;
use App\Models\ExamCategory;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

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
        try {
            DB::beginTransaction();

            // Log dữ liệu đầu vào
            Log::info('ExamBank store request data:', $request->all());

            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'category_ids' => 'required|array',
                'category_ids.*' => 'exists:categories,category_id',
                'description' => 'nullable|string',
                'difficulty_level' => 'required|in:easy,medium,hard',
                'total_questions' => 'required|integer|min:1',
                'new_questions' => 'nullable|array',
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

            // Log dữ liệu đã validate
            Log::info('ExamBank validated data:', $validated);

            // Kiểm tra xem category_ids có tồn tại và có phần tử không
            if (!isset($validated['category_ids']) || empty($validated['category_ids'])) {
                throw new \Exception('Danh mục không được để trống');
            }

            // Tạo ngân hàng câu hỏi mới
            $examBankData = [
                'name' => $validated['name'],
                'slug' => Str::slug($validated['name']),
                'description' => $validated['description'],
                'difficulty_level' => $validated['difficulty_level'],
                'total_questions' => $validated['total_questions'],
                'category_id' => $validated['category_ids'][0] // Lấy category_id đầu tiên từ mảng
            ];

            // Log dữ liệu sẽ tạo
            Log::info('ExamBank data to create:', $examBankData);

            // Kiểm tra xem category_id có tồn tại trong mảng $fillable không
            Log::info('ExamBank fillable fields:', (new ExamBank)->getFillable());

            $examBank = ExamBank::create($examBankData);

            // Log kết quả tạo
            Log::info('ExamBank created:', $examBank->toArray());

            // Gán các danh mục cho ngân hàng
            $examBank->categories()->attach($validated['category_ids']);

            // Thêm câu hỏi mới
            if (isset($validated['new_questions'])) {
                foreach ($validated['new_questions'] as $questionData) {
                    $question = Question::create([
                        'question_text' => $questionData['question_text'],
                        'option_a' => $questionData['option_a'],
                        'option_b' => $questionData['option_b'],
                        'option_c' => $questionData['option_c'],
                        'option_d' => $questionData['option_d'],
                        'correct_answer' => $questionData['correct_answer'],
                        'difficulty_level' => $questionData['difficulty_level'],
                        'explanation' => $questionData['explanation'] ?? null,
                        'exam_bank_id' => $examBank->bank_id,
                        'category_id' => $validated['category_ids'][0] // Thêm category_id cho câu hỏi
                    ]);
                }
            }

            // Thêm câu hỏi đã có
            if (isset($validated['existing_questions']) && is_array($validated['existing_questions'])) {
                foreach ($validated['existing_questions'] as $questionId) {
                    Question::where('id', $questionId)->update([
                        'exam_bank_id' => $examBank->bank_id,
                        'category_id' => $validated['category_ids'][0] // Cập nhật category_id cho câu hỏi
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('admin.exam-banks.index')
                ->with('success', 'Ngân hàng câu hỏi đã được tạo thành công.');
        } catch (\Exception $e) {
            DB::rollBack();
            // Log lỗi
            Log::error('ExamBank creation error: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return back()->withInput()
                ->with('error', 'Có lỗi xảy ra khi tạo ngân hàng câu hỏi: ' . $e->getMessage());
        }
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
            'category_ids.*' => 'exists:categories,category_id',
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
            $requiredColumns = ['name', 'description', 'is_active'];
            $missingColumns = array_diff($requiredColumns, $header);
            
            if (!empty($missingColumns)) {
                fclose($handle);
                return back()->with('error', 'File CSV thiếu các cột bắt buộc: ' . implode(', ', $missingColumns) . '. Các cột hiện có: ' . implode(', ', $header));
            }

            // Đọc dữ liệu
            $examBanks = [];
            $rowNumber = 2; // Bắt đầu từ dòng 2 (sau header)
            
            while (($data = fgetcsv($handle)) !== false) {
                // Chuẩn hóa dữ liệu
                $data = array_map(function($value) {
                    $value = preg_replace('/[\x{FEFF}\x{200B}]/u', '', $value);
                    return trim($value);
                }, $data);
                
                $row = array_combine($header, $data);
                
                // Kiểm tra dữ liệu bắt buộc
                if (empty($row['name'])) {
                    $rowNumber++;
                    continue;
                }

                $examBanks[] = [
                    'name' => $row['name'],
                    'description' => $row['description'] ?? null,
                    'is_active' => (bool)$row['is_active'],
                    'created_at' => now(),
                    'updated_at' => now()
                ];
                
                $rowNumber++;
            }
            
            fclose($handle);

            if (empty($examBanks)) {
                return back()->with('error', 'Không tìm thấy dữ liệu hợp lệ trong file CSV');
            }

            // Import dữ liệu
            ExamBank::insert($examBanks);
            
            return back()->with('success', 'Import ngân hàng đề thi thành công!');
        } catch (\Exception $e) {
            return back()->with('error', 'Có lỗi xảy ra khi import: ' . $e->getMessage());
        }
    }

    public function downloadTemplate()
    {
        $filePath = public_path('templates/exam_banks_template.csv');
        
        if (!file_exists($filePath)) {
            return back()->with('error', 'File mẫu không tồn tại.');
        }

        return response()->download($filePath, 'exam_banks_template.csv');
    }
} 