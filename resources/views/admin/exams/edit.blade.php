@extends('layouts.admin')

@section('title', 'Chỉnh sửa đề thi')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Chỉnh sửa đề thi</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.exams.update', $exam) }}" method="POST" id="examForm">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="title" class="form-label">Tên đề thi</label>
                                    <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                        id="title" name="title" value="{{ old('title', $exam->title) }}" required>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="category_id" class="form-label">Danh mục</label>
                                    <select class="form-select @error('category_id') is-invalid @enderror" 
                                        id="category_id" name="category_id" required>
                                        <option value="">Chọn danh mục</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id', $exam->category_id) == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="description" class="form-label">Mô tả</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" 
                                        id="description" name="description" rows="3">{{ old('description', $exam->description) }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="time_limit" class="form-label">Thời gian làm bài (phút)</label>
                                    <input type="number" class="form-control @error('time_limit') is-invalid @enderror" 
                                        id="time_limit" name="time_limit" value="{{ old('time_limit', $exam->time_limit) }}" min="0">
                                    @error('time_limit')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="total_marks" class="form-label">Tổng điểm</label>
                                    <input type="number" class="form-control @error('total_marks') is-invalid @enderror" 
                                        id="total_marks" name="total_marks" value="{{ old('total_marks', $exam->total_marks) }}" min="0">
                                    @error('total_marks')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="card mt-4">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Câu hỏi</h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <button type="button" class="btn btn-primary" id="addNewQuestion">
                                        <i class="fas fa-plus"></i> Thêm Dòng Câu Hỏi
                                    </button>
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-bordered" id="newQuestionsTable">
                                        <thead>
                                            <tr>
                                                <th>STT</th>
                                                <th>Câu hỏi</th>
                                                <th>Đáp án A</th>
                                                <th>Đáp án B</th>
                                                <th>Đáp án C</th>
                                                <th>Đáp án D</th>
                                                <th>Đáp án đúng</th>
                                                <th>Độ khó</th>
                                                <th>Giải thích</th>
                                                <th>Thao tác</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($exam->questions as $index => $question)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td><textarea class="form-control" name="new_questions[{{ $index }}][question_text]" rows="2" required>{{ $question->question_text }}</textarea></td>
                                                <td><input type="text" class="form-control" name="new_questions[{{ $index }}][option_a]" value="{{ $question->option_a }}" required></td>
                                                <td><input type="text" class="form-control" name="new_questions[{{ $index }}][option_b]" value="{{ $question->option_b }}" required></td>
                                                <td><input type="text" class="form-control" name="new_questions[{{ $index }}][option_c]" value="{{ $question->option_c }}" required></td>
                                                <td><input type="text" class="form-control" name="new_questions[{{ $index }}][option_d]" value="{{ $question->option_d }}" required></td>
                                                <td>
                                                    <select class="form-select" name="new_questions[{{ $index }}][correct_answer]" required>
                                                        <option value="">Chọn</option>
                                                        <option value="A" {{ $question->correct_answer == 'A' ? 'selected' : '' }}>A</option>
                                                        <option value="B" {{ $question->correct_answer == 'B' ? 'selected' : '' }}>B</option>
                                                        <option value="C" {{ $question->correct_answer == 'C' ? 'selected' : '' }}>C</option>
                                                        <option value="D" {{ $question->correct_answer == 'D' ? 'selected' : '' }}>D</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <select class="form-select" name="new_questions[{{ $index }}][difficulty_level]" required>
                                                        <option value="">Chọn</option>
                                                        <option value="easy" {{ $question->difficulty_level == 'easy' ? 'selected' : '' }}>Dễ</option>
                                                        <option value="medium" {{ $question->difficulty_level == 'medium' ? 'selected' : '' }}>Trung Bình</option>
                                                        <option value="hard" {{ $question->difficulty_level == 'hard' ? 'selected' : '' }}>Khó</option>
                                                    </select>
                                                </td>
                                                <td><textarea class="form-control" name="new_questions[{{ $index }}][explanation]" rows="2">{{ $question->explanation }}</textarea></td>
                                                <td>
                                                    <button type="button" class="btn btn-danger btn-sm delete-row">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <h5 class="mt-4">Câu hỏi đã có</h5>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>
                                                    <input type="checkbox" id="select-all">
                                                </th>
                                                <th>Câu hỏi</th>
                                                <th>Độ khó</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($questions as $question)
                                            <tr>
                                                <td>
                                                    <input type="checkbox" name="existing_questions[]" 
                                                        value="{{ $question->question_id }}" 
                                                        {{ in_array($question->question_id, $examQuestions) ? 'checked' : '' }}>
                                                </td>
                                                <td>{{ $question->question_text }}</td>
                                                <td>
                                                    @switch($question->difficulty_level)
                                                        @case('easy')
                                                            <span class="badge bg-success">Dễ</span>
                                                            @break
                                                        @case('medium')
                                                            <span class="badge bg-warning">Trung Bình</span>
                                                            @break
                                                        @case('hard')
                                                            <span class="badge bg-danger">Khó</span>
                                                            @break
                                                    @endswitch
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">Cập nhật đề thi</button>
                            <a href="{{ route('admin.exams.index') }}" class="btn btn-secondary">Hủy</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Xử lý sự kiện khi trang được tải
    document.addEventListener('DOMContentLoaded', function() {
        // Xử lý nút thêm dòng câu hỏi mới
        const addNewQuestionBtn = document.getElementById('addNewQuestion');
        if (addNewQuestionBtn) {
            let questionCount = {{ count($exam->questions) }};
            
            // Xóa các event listener cũ nếu có
            const newBtn = addNewQuestionBtn.cloneNode(true);
            addNewQuestionBtn.parentNode.replaceChild(newBtn, addNewQuestionBtn);
            
            newBtn.addEventListener('click', function() {
                const tbody = document.querySelector('#newQuestionsTable tbody');
                const newRow = document.createElement('tr');
                newRow.innerHTML = `
                    <td>${questionCount + 1}</td>
                    <td><textarea class="form-control" name="new_questions[${questionCount}][question_text]" rows="2" required></textarea></td>
                    <td><input type="text" class="form-control" name="new_questions[${questionCount}][option_a]" required></td>
                    <td><input type="text" class="form-control" name="new_questions[${questionCount}][option_b]" required></td>
                    <td><input type="text" class="form-control" name="new_questions[${questionCount}][option_c]" required></td>
                    <td><input type="text" class="form-control" name="new_questions[${questionCount}][option_d]" required></td>
                    <td>
                        <select class="form-select" name="new_questions[${questionCount}][correct_answer]" required>
                            <option value="">Chọn</option>
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="C">C</option>
                            <option value="D">D</option>
                        </select>
                    </td>
                    <td>
                        <select class="form-select" name="new_questions[${questionCount}][difficulty_level]" required>
                            <option value="">Chọn</option>
                            <option value="easy">Dễ</option>
                            <option value="medium">Trung Bình</option>
                            <option value="hard">Khó</option>
                        </select>
                    </td>
                    <td><textarea class="form-control" name="new_questions[${questionCount}][explanation]" rows="2"></textarea></td>
                    <td>
                        <button type="button" class="btn btn-danger btn-sm delete-row">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                `;
                tbody.appendChild(newRow);
                questionCount++;
            });
        }

        // Xử lý nút xóa dòng
        document.addEventListener('click', function(e) {
            if (e.target.closest('.delete-row')) {
                if (confirm('Bạn có chắc chắn muốn xóa dòng này?')) {
                    e.target.closest('tr').remove();
                }
            }
        });

        // Xử lý checkbox chọn tất cả
        const selectAllCheckbox = document.getElementById('select-all');
        if (selectAllCheckbox) {
            selectAllCheckbox.addEventListener('change', function() {
                const checkboxes = document.getElementsByName('existing_questions[]');
                for (let checkbox of checkboxes) {
                    checkbox.checked = this.checked;
                }
            });
        }

        // Xử lý form submit
        const examForm = document.getElementById('examForm');
        if (examForm) {
            examForm.addEventListener('submit', function(e) {
                const newQuestions = document.querySelectorAll('#newQuestionsTable tbody tr');
                const existingQuestions = document.querySelectorAll('input[name="existing_questions[]"]:checked');
                
                if (newQuestions.length === 0 && existingQuestions.length === 0) {
                    e.preventDefault();
                    alert('Vui lòng thêm ít nhất một câu hỏi mới hoặc chọn câu hỏi đã có.');
                    return;
                }
            });
        }
    });
</script>
@endpush 