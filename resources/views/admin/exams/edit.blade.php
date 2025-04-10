@extends('layouts.admin')

@section('title', 'Chỉnh sửa đề thi')

@push('styles')
<link href="{{ asset('css/admin.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Chỉnh sửa đề thi</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.exams.update', $exam->id) }}" method="POST" id="examForm">
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
                                            <option value="{{ $category->category_id }}" {{ old('category_id', $exam->category_id) == $category->category_id ? 'selected' : '' }}>
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
                                    <label for="duration">Thời gian làm bài (phút)</label>
                                    <input type="number" class="form-control @error('duration') is-invalid @enderror" 
                                        id="duration" name="duration" value="{{ old('duration', $exam->duration) }}" min="0">
                                    @error('duration')
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

                        <div class="row">
                            <div class="col-12">
                                <h5 class="mt-4">Câu hỏi đã chọn</h5>
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="selectedQuestionsTable">
                                        <thead>
                                            <tr>
                                                <th>STT</th>
                                                <th>Câu hỏi</th>
                                                <th>Độ khó</th>
                                                <th>Thao tác</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($exam->questions as $question)
                                            <tr data-question-id="{{ $question->id }}">
                                                <td class="question-number"></td>
                                                <td>{{ $question->question_text }}</td>
                                                <td>
                                                    <span class="badge bg-{{ $question->difficulty_level === 'easy' ? 'success' : ($question->difficulty_level === 'medium' ? 'warning' : 'danger') }}">
                                                        {{ ucfirst($question->difficulty_level) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-danger btn-sm remove-question">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <div>
                                        <button type="button" class="btn btn-primary" id="addNewQuestion">
                                            <i class="fas fa-plus"></i> Thêm Dòng Câu Hỏi
                                        </button>
                                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#importModal">
                                            <i class="fas fa-file-import"></i> Import Excel
                                        </button>
                                        <a href="{{ route('admin.questions.download-template') }}" class="btn btn-info">
                                            <i class="fas fa-download"></i> Tải File Mẫu
                                        </a>
                                    </div>
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
                                                        value="{{ $question->id }}" 
                                                        class="question-checkbox"
                                                        {{ in_array($question->id, $examQuestions) ? 'checked' : '' }}>
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
                            </div>
                        </div>

                        <div class="text-end mt-3">
                            <button type="submit" class="btn btn-primary">Cập nhật đề thi</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Import Excel -->
<div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="importModalLabel">Import Câu Hỏi từ Excel</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="importForm" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="file" class="form-label">Chọn File CSV</label>
                        <input type="file" class="form-control" id="file" name="file" accept=".csv,.txt" required>
                    </div>
                    <div class="alert alert-info">
                        <h6>Hướng dẫn:</h6>
                        <p class="mb-0">File CSV cần có các cột sau (theo đúng thứ tự):</p>
                        <ul class="mb-0">
                            <li>question_text: Nội dung câu hỏi</li>
                            <li>option_a: Đáp án A</li>
                            <li>option_b: Đáp án B</li>
                            <li>option_c: Đáp án C</li>
                            <li>option_d: Đáp án D</li>
                            <li>correct_answer: Đáp án đúng (A, B, C, D)</li>
                            <li>difficulty_level: Độ khó (easy, medium, hard)</li>
                            <li>explanation: Giải thích (không bắt buộc)</li>
                        </ul>
                        <p class="mt-2 mb-0">
                            <strong>Lưu ý:</strong>
                            <ul class="mb-0">
                                <li>File phải là định dạng CSV (các giá trị phân cách bằng dấu phẩy)</li>
                                <li>Dòng đầu tiên phải là tên các cột</li>
                                <li>Các giá trị không được chứa dấu phẩy</li>
                            </ul>
                        </p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary">Import</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
    const selectAllCheckbox = document.getElementById('select-all');
    const questionCheckboxes = document.querySelectorAll('.question-checkbox');
    const selectedQuestionsTable = document.getElementById('selectedQuestionsTable');
    const selectedQuestions = new Set();
    const importForm = document.getElementById('importForm');
    const examForm = document.getElementById('examForm');
    const addNewQuestionBtn = document.getElementById('addNewQuestion');
    let newQuestionCount = 0;
    let isSubmitting = false;

    // Khởi tạo selectedQuestions từ các câu hỏi đã chọn
    document.querySelectorAll('#selectedQuestionsTable tr[data-question-id]').forEach(row => {
        selectedQuestions.add(row.dataset.questionId);
    });

        // Xử lý nút thêm dòng câu hỏi mới
        if (addNewQuestionBtn) {
        addNewQuestionBtn.addEventListener('click', function() {
            const tbody = selectedQuestionsTable.querySelector('tbody');
            const newRow = document.createElement('tr');
            const questionId = 'new_' + newQuestionCount++;
            newRow.dataset.questionId = questionId;
            
                newRow.innerHTML = `
                <td class="question-number"></td>
                <td>
                    <div class="mb-2">
                        <textarea class="form-control" name="new_questions[${questionId}][question_text]" rows="2" required placeholder="Nhập nội dung câu hỏi"></textarea>
                    </div>
                    <div class="row g-2">
                        <div class="col-md-6 mb-2">
                            <input type="text" class="form-control" name="new_questions[${questionId}][option_a]" placeholder="Đáp án A" required>
                        </div>
                        <div class="col-md-6 mb-2">
                            <input type="text" class="form-control" name="new_questions[${questionId}][option_b]" placeholder="Đáp án B" required>
                        </div>
                        <div class="col-md-6 mb-2">
                            <input type="text" class="form-control" name="new_questions[${questionId}][option_c]" placeholder="Đáp án C" required>
                        </div>
                        <div class="col-md-6 mb-2">
                            <input type="text" class="form-control" name="new_questions[${questionId}][option_d]" placeholder="Đáp án D" required>
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col-md-6 mb-2">
                            <select class="form-select" name="new_questions[${questionId}][correct_answer]" required>
                                <option value="">Chọn đáp án đúng</option>
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="C">C</option>
                            <option value="D">D</option>
                        </select>
                        </div>
                        <div class="col-md-6 mb-2">
                            <select class="form-select" name="new_questions[${questionId}][difficulty_level]" required>
                                <option value="">Chọn độ khó</option>
                            <option value="easy">Dễ</option>
                                <option value="medium">Trung bình</option>
                            <option value="hard">Khó</option>
                        </select>
                        </div>
                    </div>
                    <div class="mb-2">
                        <textarea class="form-control" name="new_questions[${questionId}][explanation]" rows="2" placeholder="Giải thích đáp án (không bắt buộc)"></textarea>
                    </div>
                </td>
                <td>
                    <span class="badge bg-secondary">Mới</span>
                    </td>
                    <td>
                    <button type="button" class="btn btn-danger btn-sm remove-question">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                `;
            
                tbody.appendChild(newRow);
            selectedQuestions.add(questionId);
            updateQuestionNumbers();
        });
    }

    // Xử lý form import
    if (importForm) {
        importForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            
            fetch('{{ route("admin.questions.import") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Thêm các câu hỏi mới vào bảng câu hỏi đã có
                    const questionsTable = document.querySelector('.table-bordered:not(#selectedQuestionsTable) tbody');
                    data.questions.forEach(question => {
                        // Kiểm tra xem câu hỏi đã tồn tại chưa
                        const existingQuestion = document.querySelector(`.question-checkbox[value="${question.id}"]`);
                        if (!existingQuestion) {
                            const newRow = document.createElement('tr');
                            newRow.innerHTML = `
                                <td>
                                    <input type="checkbox" name="existing_questions[]" 
                                        value="${question.id}" 
                                        class="question-checkbox">
                                </td>
                                <td>${question.question_text}</td>
                                <td>
                                    <span class="badge bg-${question.difficulty_level === 'easy' ? 'success' : (question.difficulty_level === 'medium' ? 'warning' : 'danger')}">
                                        ${question.difficulty_level.charAt(0).toUpperCase() + question.difficulty_level.slice(1)}
                                    </span>
                                </td>
                            `;
                            questionsTable.appendChild(newRow);
                            
                            // Tự động chọn câu hỏi mới và thêm event listener
                            const checkbox = newRow.querySelector('.question-checkbox');
                            checkbox.addEventListener('change', function() {
                                if (this.checked) {
                                    selectedQuestions.add(this.value);
                                    addQuestionToTable(this);
                                } else {
                                    selectedQuestions.delete(this.value);
                                    removeQuestionFromTable(this.value);
                                }
                                updateQuestionNumbers();
                            });

                            // Tự động chọn và thêm vào bảng câu hỏi đã chọn
                            checkbox.checked = true;
                            selectedQuestions.add(question.id);
                            addQuestionToTable(checkbox);
                        }
                    });
                    
                    // Đóng modal
                    const modal = bootstrap.Modal.getInstance(document.getElementById('importModal'));
                    modal.hide();
                    
                    // Hiển thị thông báo thành công
                    alert('Import câu hỏi thành công!');

                    // Cập nhật lại số thứ tự
                    updateQuestionNumbers();
                } else {
                    alert('Có lỗi xảy ra: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Có lỗi xảy ra khi import câu hỏi!');
            });
        });
    }

    // Xử lý chọn tất cả
    selectAllCheckbox.addEventListener('change', function() {
        questionCheckboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
            if (this.checked) {
                selectedQuestions.add(checkbox.value);
                addQuestionToTable(checkbox);
            } else {
                selectedQuestions.delete(checkbox.value);
                removeQuestionFromTable(checkbox.value);
            }
        });
        updateQuestionNumbers();
    });

    // Xử lý chọn từng câu hỏi
    questionCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            if (this.checked) {
                selectedQuestions.add(this.value);
                addQuestionToTable(this);
            } else {
                selectedQuestions.delete(this.value);
                removeQuestionFromTable(this.value);
            }
            updateQuestionNumbers();
        });
    });

    // Xử lý xóa câu hỏi
    selectedQuestionsTable.addEventListener('click', function(e) {
        if (e.target.closest('.remove-question')) {
            const row = e.target.closest('tr');
            const questionId = row.dataset.questionId;
            selectedQuestions.delete(questionId);
            row.remove();
            
            // Bỏ chọn checkbox tương ứng
            const checkbox = document.querySelector(`.question-checkbox[value="${questionId}"]`);
            if (checkbox) {
                checkbox.checked = false;
            }
            updateQuestionNumbers();
        }
    });

    // Thêm câu hỏi vào bảng
    function addQuestionToTable(checkbox) {
        const row = checkbox.closest('tr');
        const questionText = row.cells[1].textContent;
        const difficultyLevel = row.cells[2].querySelector('.badge').textContent;
        const difficultyClass = row.cells[2].querySelector('.badge').className;
        
        // Xóa câu hỏi cũ nếu đã tồn tại
        removeQuestionFromTable(checkbox.value);
        
        // Thêm câu hỏi mới
        const newRow = document.createElement('tr');
        newRow.dataset.questionId = checkbox.value;
        newRow.innerHTML = `
            <td class="question-number"></td>
            <td>${questionText}</td>
            <td><span class="${difficultyClass}">${difficultyLevel}</span></td>
            <td>
                <button type="button" class="btn btn-danger btn-sm remove-question">
                    <i class="fas fa-trash"></i>
                </button>
            </td>
        `;
        selectedQuestionsTable.querySelector('tbody').appendChild(newRow);
        updateQuestionNumbers();
    }

    // Xóa câu hỏi khỏi bảng
    function removeQuestionFromTable(questionId) {
        const row = document.querySelector(`#selectedQuestionsTable tr[data-question-id="${questionId}"]`);
        if (row) {
            row.remove();
            updateQuestionNumbers();
        }
    }

    // Cập nhật số thứ tự
    function updateQuestionNumbers() {
        const rows = selectedQuestionsTable.querySelectorAll('tbody tr');
        rows.forEach((row, index) => {
            const numberCell = row.querySelector('.question-number');
            if (numberCell) {
                numberCell.textContent = index + 1;
            }
        });
        }

        // Xử lý khi submit form
        if (examForm) {
            examForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Kiểm tra danh mục
            const categorySelect = document.getElementById('category_id');
            if (!categorySelect.value) {
                alert('Vui lòng chọn danh mục!');
                return;
            }

            // Lấy danh sách câu hỏi đã chọn
            const existingQuestions = Array.from(document.querySelectorAll('input[name="existing_questions[]"]:checked')).map(cb => cb.value);
            
            // Thêm input hidden để gửi danh sách câu hỏi
            if (existingQuestions.length > 0) {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'existing_questions';
                input.value = existingQuestions.join(',');
                this.appendChild(input);
            }

            // Submit form
            this.submit();
        });
    }

    // Log giá trị khi select thay đổi
    const categorySelect = document.getElementById('category_id');
    categorySelect.addEventListener('change', function() {
        console.log('Category value:', this.value);
        console.log('Selected option:', this.options[this.selectedIndex].text);
    });

    // Cập nhật số thứ tự ban đầu
    updateQuestionNumbers();
    });
</script>
@endpush 
@endsection 