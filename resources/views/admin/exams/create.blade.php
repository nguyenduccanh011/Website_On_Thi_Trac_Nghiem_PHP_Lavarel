@extends('layouts.admin')

@section('title', 'Thêm Đề Thi Mới')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Thêm Đề Thi Mới</h1>
        <a href="{{ route('admin.exams.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Quay Lại
        </a>
    </div>

    <form action="{{ route('admin.exams.store') }}" method="POST" id="examForm">
        @csrf
        
        <div class="card mb-4">
            <div class="card-header">
                <h3 class="card-title">Thêm Đề Thi Mới</h3>
                <div class="card-tools">
                <h5 class="card-title mb-0">Thông Tin Đề Thi</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="title" class="form-label">Tên Đề Thi</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                   id="title" name="title" value="{{ old('title') }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="category_id" class="form-label">Danh Mục</label>
                            <select class="form-select @error('category_id') is-invalid @enderror" 
                                    id="category_id" name="category_id" required>
                                <option value="">Chọn Danh Mục</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->category_id }}" {{ old('category_id') == $category->category_id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="difficulty_level" class="form-label">Độ Khó</label>
                            <select class="form-select @error('difficulty_level') is-invalid @enderror" 
                                    id="difficulty_level" name="difficulty_level" required>
                                <option value="">Chọn Độ Khó</option>
                                <option value="easy" {{ old('difficulty_level') == 'easy' ? 'selected' : '' }}>Dễ</option>
                                <option value="medium" {{ old('difficulty_level') == 'medium' ? 'selected' : '' }}>Trung Bình</option>
                                <option value="hard" {{ old('difficulty_level') == 'hard' ? 'selected' : '' }}>Khó</option>
                            </select>
                            @error('difficulty_level')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="duration" class="form-label">Thời gian làm bài (phút)</label>
                            <input type="number" class="form-control @error('duration') is-invalid @enderror" 
                                   id="duration" name="duration" value="{{ old('duration') }}" min="1" required>
                            @error('duration')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="total_marks" class="form-label">Tổng điểm</label>
                            <input type="number" class="form-control @error('total_marks') is-invalid @enderror" 
                                id="total_marks" name="total_marks" value="{{ old('total_marks') }}" min="1" required>
                            @error('total_marks')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="passing_marks" class="form-label">Điểm Đạt</label>
                            <input type="number" class="form-control @error('passing_marks') is-invalid @enderror" 
                                   id="passing_marks" name="passing_marks" value="{{ old('passing_marks') }}" required>
                            @error('passing_marks')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input @error('is_active') is-invalid @enderror" 
                                       id="is_active" name="is_active" value="1" {{ old('is_active') ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">Đề Thi Đang Mở</label>
                                @error('is_active')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Mô Tả</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" 
                              id="description" name="description" rows="3">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Câu Hỏi Mới</h5>
                <button type="button" class="btn btn-success" id="addNewQuestion">
                    <i class="fas fa-plus"></i> Thêm Dòng Câu Hỏi
                </button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="newQuestionsTable">
                        <thead>
                            <tr>
                                <th style="width: 50px">STT</th>
                                <th>Nội Dung Câu Hỏi</th>
                                <th>Lựa Chọn A</th>
                                <th>Lựa Chọn B</th>
                                <th>Lựa Chọn C</th>
                                <th>Lựa Chọn D</th>
                                <th>Đáp Án</th>
                                <th>Độ Khó</th>
                                <th>Giải Thích</th>
                                <th style="width: 50px">Xóa</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Dòng trống mặc định sẽ được thêm bằng JavaScript -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Câu Hỏi Đã Có</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 50px">
                                    <input type="checkbox" id="select-all">
                                </th>
                                <th>Nội Dung Câu Hỏi</th>
                                <th>Độ Khó</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($questions as $question)
                                <tr>
                                    <td>
                                        <input type="checkbox" name="existing_questions[]" value="{{ $question->id }}"
                                               {{ in_array($question->id, old('existing_questions', [])) ? 'checked' : '' }}>
                                    </td>
                                    <td>{{ $question->question_text }}</td>
                                    <td>
                                        <span class="badge bg-{{ $question->difficulty_level === 'easy' ? 'success' : ($question->difficulty_level === 'medium' ? 'warning' : 'danger') }}">
                                            {{ ucfirst($question->difficulty_level) }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @error('existing_questions')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="text-end mb-4">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Lưu Đề Thi
            </button>
        </div>
    </form>
</div>

<!-- Modal Import Questions -->
<div class="modal fade" id="importQuestionsModal" tabindex="-1" role="dialog" aria-labelledby="importQuestionsModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="importQuestionsModalLabel">Import Câu Hỏi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="importQuestionsForm" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="questions_file">Chọn File CSV</label>
                        <input type="file" class="form-control-file" id="questions_file" name="file" accept=".csv,.txt" required>
                    </div>
                    <div class="alert alert-info">
                        <h6>Hướng dẫn:</h6>
                        <p>File CSV phải có các cột sau:</p>
                        <ul>
                            <li>question_text: Nội dung câu hỏi</li>
                            <li>option_a: Đáp án A</li>
                            <li>option_b: Đáp án B</li>
                            <li>option_c: Đáp án C</li>
                            <li>option_d: Đáp án D</li>
                            <li>correct_answer: Đáp án đúng (A, B, C, D)</li>
                            <li>difficulty_level: Độ khó (easy, medium, hard)</li>
                            <li>explanation: Giải thích (tùy chọn)</li>
                        </ul>
                        <p>Lưu ý:</p>
                        <ul>
                            <li>File phải là định dạng CSV (các giá trị phân cách bằng dấu phẩy)</li>
                            <li>Dòng đầu tiên phải là tên các cột</li>
                            <li>Giá trị có chứa dấu phẩy phải đặt trong dấu ngoặc kép</li>
                        </ul>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary">Import</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Lưu trữ dữ liệu câu hỏi từ PHP
    const questionsData = @json($questions);

    document.addEventListener('DOMContentLoaded', function() {
        // Xử lý nút thêm dòng câu hỏi mới
        const addNewQuestionBtn = document.getElementById('addNewQuestion');
        if (addNewQuestionBtn) {
            // Xóa các event listener cũ nếu có
            const newBtn = addNewQuestionBtn.cloneNode(true);
            addNewQuestionBtn.parentNode.replaceChild(newBtn, addNewQuestionBtn);
            
            newBtn.addEventListener('click', function() {
                addEmptyRow();
            });
        }

        // Xử lý checkbox chọn tất cả
        const selectAllCheckbox = document.getElementById('select-all');
        if (selectAllCheckbox) {
            selectAllCheckbox.addEventListener('change', function() {
                const checkboxes = document.querySelectorAll('input[name="existing_questions[]"]');
                checkboxes.forEach(checkbox => {
                    checkbox.checked = this.checked;
                    if (this.checked) {
                        addSelectedQuestionToForm(checkbox.value);
                    } else {
                        removeQuestionFromForm(checkbox.value);
                    }
                });
            });
        }

        // Xử lý checkbox chọn từng câu hỏi
        const questionCheckboxes = document.querySelectorAll('input[name="existing_questions[]"]');
        questionCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                if (this.checked) {
                    addSelectedQuestionToForm(this.value);
                } else {
                    removeQuestionFromForm(this.value);
                }
            });
        });
    });

    let questionCount = 0;

    function addEmptyRow() {
        const tbody = document.querySelector('#newQuestionsTable tbody');
        const newRow = document.createElement('tr');
        newRow.innerHTML = `
            <td>${tbody.children.length + 1}</td>
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

        // Thêm xử lý sự kiện xóa dòng
        const deleteBtn = newRow.querySelector('.delete-row');
        deleteBtn.addEventListener('click', function() {
            newRow.remove();
        });
    }

    // Hàm thêm câu hỏi đã chọn vào form
    function addSelectedQuestionToForm(questionId) {
        const questionRow = document.querySelector(`tr[data-question-id="${questionId}"]`);
        if (!questionRow) {
            const selectedQuestion = questionsData.find(q => q.id == questionId);
            if (selectedQuestion) {
                const tbody = document.querySelector('#newQuestionsTable tbody');
                const newRow = document.createElement('tr');
                newRow.setAttribute('data-question-id', questionId);
                newRow.innerHTML = `
                    <td>${tbody.children.length + 1}</td>
                    <td><textarea class="form-control" name="new_questions[${questionCount}][question_text]" rows="2" required>${selectedQuestion.question_text}</textarea></td>
                    <td><input type="text" class="form-control" name="new_questions[${questionCount}][option_a]" value="${selectedQuestion.option_a}" required></td>
                    <td><input type="text" class="form-control" name="new_questions[${questionCount}][option_b]" value="${selectedQuestion.option_b}" required></td>
                    <td><input type="text" class="form-control" name="new_questions[${questionCount}][option_c]" value="${selectedQuestion.option_c}" required></td>
                    <td><input type="text" class="form-control" name="new_questions[${questionCount}][option_d]" value="${selectedQuestion.option_d}" required></td>
                    <td>
                        <select class="form-select" name="new_questions[${questionCount}][correct_answer]" required>
                            <option value="">Chọn</option>
                            <option value="A" ${selectedQuestion.correct_answer === 'A' ? 'selected' : ''}>A</option>
                            <option value="B" ${selectedQuestion.correct_answer === 'B' ? 'selected' : ''}>B</option>
                            <option value="C" ${selectedQuestion.correct_answer === 'C' ? 'selected' : ''}>C</option>
                            <option value="D" ${selectedQuestion.correct_answer === 'D' ? 'selected' : ''}>D</option>
                        </select>
                    </td>
                    <td>
                        <select class="form-select" name="new_questions[${questionCount}][difficulty_level]" required>
                            <option value="">Chọn</option>
                            <option value="easy" ${selectedQuestion.difficulty_level === 'easy' ? 'selected' : ''}>Dễ</option>
                            <option value="medium" ${selectedQuestion.difficulty_level === 'medium' ? 'selected' : ''}>Trung Bình</option>
                            <option value="hard" ${selectedQuestion.difficulty_level === 'hard' ? 'selected' : ''}>Khó</option>
                        </select>
                    </td>
                    <td><textarea class="form-control" name="new_questions[${questionCount}][explanation]" rows="2">${selectedQuestion.explanation || ''}</textarea></td>
                    <td>
                        <button type="button" class="btn btn-danger btn-sm delete-row">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                `;
                tbody.appendChild(newRow);
                questionCount++;

                // Thêm xử lý sự kiện xóa dòng
                const deleteBtn = newRow.querySelector('.delete-row');
                deleteBtn.addEventListener('click', function() {
                    newRow.remove();
                    // Bỏ chọn checkbox tương ứng
                    const checkbox = document.querySelector(`input[name="existing_questions[]"][value="${questionId}"]`);
                    if (checkbox) {
                        checkbox.checked = false;
                    }
                });
            }
        }
    }

    // Hàm xóa câu hỏi khỏi form
    function removeQuestionFromForm(questionId) {
        const questionRow = document.querySelector(`tr[data-question-id="${questionId}"]`);
        if (questionRow) {
            questionRow.remove();
        }
    }

    $(document).ready(function() {
        $('#importQuestionsForm').on('submit', function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            
            $.ajax({
                url: '{{ route("admin.questions.import") }}',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.success) {
                        // Thêm các câu hỏi đã import vào form
                        response.questions.forEach(function(question) {
                            addSelectedQuestionToForm(question.id);
                        });
                        
                        // Đóng modal
                        $('#importQuestionsModal').modal('hide');
                        
                        // Hiển thị thông báo thành công
                        alert('Import câu hỏi thành công!');
                    } else {
                        alert('Có lỗi xảy ra: ' + response.message);
                    }
                },
                error: function(xhr) {
                    alert('Có lỗi xảy ra khi import câu hỏi!');
                }
            });
        });
    });
</script>
@endpush
@endsection 