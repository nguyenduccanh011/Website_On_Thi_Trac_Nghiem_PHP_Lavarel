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
use Illuminate\Validation\ValidationException;

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
        try {
            // Log request data for debugging
            Log::info('Update ExamBank Request:', [
                'request_data' => $request->all(),
                'current_category_id' => $examBank->category_id
            ]);

            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'is_active' => 'required|boolean',
                'category_id' => 'required|exists:categories,category_id',
                'questions' => 'nullable|array',
                'questions.*' => 'exists:questions,id'
            ]);

            DB::beginTransaction();

            // Log validated data
            Log::info('Validated data:', $validated);

            // Cập nhật thông tin ngân hàng đề
            $examBank->update([
                'name' => $validated['name'],
                'description' => $validated['description'],
                'is_active' => $validated['is_active'],
                'category_id' => $validated['category_id']
            ]);

            // Cập nhật quan hệ many-to-many với questions
            if (isset($validated['questions'])) {
                $examBank->questions()->sync($validated['questions']);
            }

            DB::commit();

            return redirect()->route('admin.exam-banks.index')
                ->with('success', 'Ngân hàng đề thi đã được cập nhật thành công.');
        } catch (ValidationException $e) {
            DB::rollBack();
            Log::error('Validation error:', [
                'errors' => $e->errors(),
                'request_data' => $request->all()
            ]);
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating exam bank:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all()
            ]);
            return back()->with('error', 'Có lỗi xảy ra khi cập nhật ngân hàng đề thi: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy(ExamBank $examBank)
    {
        $examBank->delete();
        return redirect()->route('admin.exam-banks.index')
            ->with('success', 'Ngân hàng câu hỏi đã được xóa.');
    }

    public function addQuestion(Request $request, ExamBank $examBank)
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

        try {
            DB::beginTransaction();

            $question = Question::create([
                'question_text' => $validated['question_text'],
                'option_a' => $validated['option_a'],
                'option_b' => $validated['option_b'],
                'option_c' => $validated['option_c'],
                'option_d' => $validated['option_d'],
                'correct_answer' => $validated['correct_answer'],
                'difficulty_level' => $validated['difficulty_level'],
                'explanation' => $validated['explanation'],
                'exam_bank_id' => $examBank->bank_id,
                'category_id' => $examBank->categories->first()->category_id
            ]);

            $examBank->updateTotalQuestions();

            DB::commit();

            return response()->json([
                'success' => true,
                'question' => $question
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi thêm câu hỏi: ' . $e->getMessage()
            ], 500);
        }
    }

    public function importQuestions(Request $request, ExamBank $examBank)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv|max:2048'
        ]);

        try {
            DB::beginTransaction();

            $import = new QuestionsImport();
            Excel::import($import, $request->file('file'));

            // Cập nhật exam_bank_id và category_id cho các câu hỏi vừa import
            $categoryId = $examBank->categories->first()->category_id;
            Question::whereNull('exam_bank_id')
                   ->latest()
                   ->limit($import->getRowCount())
                   ->update([
                       'exam_bank_id' => $examBank->bank_id,
                       'category_id' => $categoryId
                   ]);

            $examBank->updateTotalQuestions();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Import câu hỏi thành công'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi import câu hỏi: ' . $e->getMessage()
            ], 500);
        }
    }

    public function import(Request $request)
    {
        try {
            $request->validate([
                'file' => 'required|mimes:csv,txt'
            ]);

            $file = $request->file('file');
            $handle = fopen($file->getPathname(), 'r');
            
            // Đọc dòng tiêu đề
            $header = fgetcsv($handle);
            
            // Kiểm tra các cột bắt buộc
            $requiredColumns = ['question_text', 'option_a', 'option_b', 'option_c', 'option_d', 'correct_answer', 'difficulty_level'];
            $missingColumns = array_diff($requiredColumns, $header);
            
            if (!empty($missingColumns)) {
                fclose($handle);
                return back()->with('error', 'File CSV thiếu các cột bắt buộc: ' . implode(', ', $missingColumns));
            }

            $questions = [];
            $rowNumber = 2; // Bắt đầu từ dòng 2 (sau header)
            
            while (($data = fgetcsv($handle)) !== false) {
                $row = array_combine($header, $data);
                
                // Kiểm tra dữ liệu bắt buộc
                if (empty($row['question_text'])) {
                    $rowNumber++;
                    continue;
                }

                $questions[] = [
                    'question_text' => $row['question_text'],
                    'option_a' => $row['option_a'],
                    'option_b' => $row['option_b'],
                    'option_c' => $row['option_c'],
                    'option_d' => $row['option_d'],
                    'correct_answer' => strtoupper($row['correct_answer']),
                    'difficulty_level' => strtolower($row['difficulty_level']),
                    'explanation' => $row['explanation'] ?? null,
                    'created_at' => now(),
                    'updated_at' => now()
                ];
                
                $rowNumber++;
            }
            
            fclose($handle);

            if (empty($questions)) {
                return back()->with('error', 'Không tìm thấy dữ liệu hợp lệ trong file CSV');
            }

            Question::insert($questions);
            
            return back()->with('success', 'Import câu hỏi thành công!');
        } catch (\Exception $e) {
            Log::error('Import exam bank error: ' . $e->getMessage());
            return back()->with('error', 'Có lỗi xảy ra khi import: ' . $e->getMessage());
        }
    }

    public function downloadTemplate()
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="questions_template.csv"',
        ];

        $callback = function() {
            $file = fopen('php://output', 'w');
            
            // Add UTF-8 BOM
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            // Add headers
            fputcsv($file, [
                'question_text',
                'option_a',
                'option_b',
                'option_c',
                'option_d',
                'correct_answer',
                'difficulty_level',
                'explanation'
            ]);
            
            // Add example data
            fputcsv($file, [
                'What is PHP?',
                'Hypertext Preprocessor',
                'Personal Home Page',
                'Programming Home Protocol',
                'None of these',
                'A',
                'easy',
                'PHP is a server-side scripting language'
            ]);
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
} 