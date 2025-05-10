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
                                    <label for="duration" class="form-label">Thời gian làm bài (phút)</label>
                                    <input type="number" class="form-control @error('duration') is-invalid @enderror" 
                                           id="duration" name="duration" value="{{ old('duration', $exam->duration) }}" min="1" required>
                                    @error('duration')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <h5>Lấy câu hỏi ngẫu nhiên từ ngân hàng đề</h5>
                                
                                <div class="mb-3">
                                    <label for="exam_bank_id" class="form-label">Ngân hàng đề</label>
                                    <select class="form-select @error('exam_bank_id') is-invalid @enderror" 
                                            id="exam_bank_id" name="exam_bank_id">
                                        <option value="">Chọn ngân hàng đề</option>
                                        @foreach($examBanks as $bank)
                                            <option value="{{ $bank->bank_id }}" 
                                                    data-easy="{{ $bank->questions()->where('difficulty_level', 'easy')->count() }}"
                                                    data-medium="{{ $bank->questions()->where('difficulty_level', 'medium')->count() }}"
                                                    data-hard="{{ $bank->questions()->where('difficulty_level', 'hard')->count() }}">
                                                {{ $bank->name }} ({{ $bank->total_questions }} câu)
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('exam_bank_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="easy_count" class="form-label">Số câu dễ</label>
                                            <input type="number" class="form-control" id="easy_count" name="easy_count" min="0" value="0">
                                            <small class="text-muted">Có sẵn: <span id="available_easy">0</span> câu</small>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="medium_count" class="form-label">Số câu trung bình</label>
                                            <input type="number" class="form-control" id="medium_count" name="medium_count" min="0" value="0">
                                            <small class="text-muted">Có sẵn: <span id="available_medium">0</span> câu</small>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="hard_count" class="form-label">Số câu khó</label>
                                            <input type="number" class="form-control" id="hard_count" name="hard_count" min="0" value="0">
                                            <small class="text-muted">Có sẵn: <span id="available_hard">0</span> câu</small>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <button type="button" class="btn btn-primary" id="getRandomQuestions">
                                        <i class="fas fa-random"></i> Lấy câu hỏi ngẫu nhiên
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div>
                                        <h5 class="mb-0">Câu hỏi đã chọn (<span id="selectedQuestionCount">0</span> câu)</h5>
                                        <small class="text-muted">Tổng số câu hỏi trong đề: <span id="totalQuestions">0</span> câu</small>
                                    </div>
                                    <div>
                                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#importModal">
                                            <i class="fas fa-file-import"></i> Import Excel
                                        </button>
                                        <a href="{{ route('admin.questions.download-template') }}" class="btn btn-info">
                                            <i class="fas fa-download"></i> Tải File Mẫu
                                        </a>
                                    </div>
                                </div>
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
                                                        {{ $question->difficulty_level === 'easy' ? 'Dễ' : ($question->difficulty_level === 'medium' ? 'Trung bình' : 'Khó') }}
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
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-12">
                                <h5>Câu hỏi đã có</h5>
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
                                                    <input type="checkbox" name="questions[]" 
                                                        value="{{ $question->id }}" 
                                                        class="question-checkbox"
                                                        {{ in_array($question->id, $examQuestions) ? 'checked' : '' }}>
                                                </td>
                                                <td>{{ $question->question_text }}</td>
                                                <td>
                                                    <span class="badge bg-{{ $question->difficulty_level === 'easy' ? 'success' : ($question->difficulty_level === 'medium' ? 'warning' : 'danger') }}">
                                                        {{ $question->difficulty_level === 'easy' ? 'Dễ' : ($question->difficulty_level === 'medium' ? 'Trung bình' : 'Khó') }}
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
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const examBankSelect = document.getElementById('exam_bank_id');
    const easyCount = document.getElementById('easy_count');
    const mediumCount = document.getElementById('medium_count');
    const hardCount = document.getElementById('hard_count');
    const getRandomQuestionsBtn = document.getElementById('getRandomQuestions');
    const selectAllCheckbox = document.getElementById('select-all');
    const questionCheckboxes = document.querySelectorAll('.question-checkbox');
    const selectedQuestionsTable = document.getElementById('selectedQuestionsTable');
    const selectedQuestions = new Set();
    const importForm = document.getElementById('importForm');
    const examForm = document.getElementById('examForm');
    const addNewQuestionBtn = document.getElementById('addNewQuestion');
    const totalQuestionsInput = document.getElementById('total_questions');
    let newQuestionCount = 0;
    let isSubmitting = false;

    // Khởi tạo selectedQuestions từ các câu hỏi đã chọn
    document.querySelectorAll('#selectedQuestionsTable tr[data-question-id]').forEach(row => {
        selectedQuestions.add(row.dataset.questionId);
    });

    // Cập nhật số lượng câu hỏi có sẵn khi chọn ngân hàng đề
    examBankSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const easyCount = selectedOption.dataset.easy || 0;
        const mediumCount = selectedOption.dataset.medium || 0;
        const hardCount = selectedOption.dataset.hard || 0;

        document.getElementById('available_easy').textContent = easyCount;
        document.getElementById('available_medium').textContent = mediumCount;
        document.getElementById('available_hard').textContent = hardCount;

        // Cập nhật max value cho các input
        document.getElementById('easy_count').max = easyCount;
        document.getElementById('medium_count').max = mediumCount;
        document.getElementById('hard_count').max = hardCount;
    });

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

            // Lấy tất cả câu hỏi đã chọn từ bảng
            const selectedRows = selectedQuestionsTable.querySelectorAll('tbody tr');
            
            // Kiểm tra số lượng câu hỏi
            if (selectedRows.length === 0) {
                alert('Vui lòng thêm ít nhất một câu hỏi!');
                return;
            }

            // Xóa tất cả input hidden cũ của questions
            document.querySelectorAll('input[name="questions[]"]').forEach(el => el.remove());

            // Thêm input hidden cho mỗi câu hỏi đã chọn
            selectedRows.forEach(row => {
                const questionId = row.dataset.questionId;
                if (questionId) {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'questions[]';
                    input.value = questionId;
                    examForm.appendChild(input);
                }
            });

            // Submit form
            this.submit();
        });
    }

    // Xử lý chọn từng câu hỏi
    questionCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            if (this.checked) {
                addQuestionToTable(this);
            } else {
                removeQuestionFromTable(this.value);
            }
            updateQuestionNumbers();
        });
    });

    // Xử lý lấy câu hỏi ngẫu nhiên
    getRandomQuestionsBtn.addEventListener('click', function() {
        const examBankId = examBankSelect.value;
        if (!examBankId) {
            alert('Vui lòng chọn ngân hàng đề!');
            return;
        }

        const easyCount = document.getElementById('easy_count').value;
        const mediumCount = document.getElementById('medium_count').value;
        const hardCount = document.getElementById('hard_count').value;

        if (easyCount == 0 && mediumCount == 0 && hardCount == 0) {
            alert('Vui lòng nhập số lượng câu hỏi cần lấy!');
            return;
        }

        // Gửi request lấy câu hỏi ngẫu nhiên
        fetch(`/admin/exam-banks/${examBankId}/random-questions`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                easy_count: parseInt(easyCount),
                medium_count: parseInt(mediumCount),
                hard_count: parseInt(hardCount)
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Thêm các câu hỏi mới vào bảng
                data.questions.forEach(question => {
                    if (!selectedQuestions.has(question.id)) {
                        const tbody = selectedQuestionsTable.querySelector('tbody');
                        const row = document.createElement('tr');
                        row.dataset.questionId = question.id;
                        
                        row.innerHTML = `
                            <td class="question-number"></td>
                            <td>${question.question_text}</td>
                            <td>
                                <span class="badge bg-${question.difficulty_level === 'easy' ? 'success' : (question.difficulty_level === 'medium' ? 'warning' : 'danger')}">
                                    ${question.difficulty_level.charAt(0).toUpperCase() + question.difficulty_level.slice(1)}
                                </span>
                            </td>
                            <td>
                                <button type="button" class="btn btn-danger btn-sm remove-question">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        `;
                        
                        tbody.appendChild(row);
                        selectedQuestions.add(question.id);
                        
                        // Tích chọn checkbox tương ứng
                        const checkbox = document.querySelector(`.question-checkbox[value="${question.id}"]`);
                        if (checkbox) {
                            checkbox.checked = true;
                        }
                    }
                });

                updateQuestionNumbers();
                updateTotalQuestions();
                alert('Đã thêm câu hỏi ngẫu nhiên thành công!');
            } else {
                alert('Có lỗi xảy ra: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Có lỗi xảy ra khi lấy câu hỏi ngẫu nhiên!');
        });
    });

    // Xử lý xóa câu hỏi
    selectedQuestionsTable.addEventListener('click', function(e) {
        if (e.target.closest('.remove-question')) {
            const row = e.target.closest('tr');
            const questionId = row.dataset.questionId;
            removeQuestionFromTable(questionId);
        }
    });

    // Xử lý chọn tất cả
    selectAllCheckbox.addEventListener('change', function() {
        questionCheckboxes.forEach(checkbox => {
            if (checkbox.checked !== this.checked) {
                checkbox.checked = this.checked;
                if (this.checked) {
                    addQuestionToTable(checkbox);
                } else {
                    removeQuestionFromTable(checkbox.value);
                }
            }
        });
        updateQuestionNumbers();
        updateTotalQuestions();
    });

    // Thêm câu hỏi vào bảng
    function addQuestionToTable(checkbox) {
        const row = checkbox.closest('tr');
        const questionText = row.cells[1].textContent;
        const difficultyBadge = row.cells[2].querySelector('.badge');
        const difficultyLevel = difficultyBadge.textContent;
        const difficultyClass = difficultyBadge.className;
        
        // Kiểm tra xem câu hỏi đã tồn tại trong bảng chưa
        const existingRow = selectedQuestionsTable.querySelector(`tr[data-question-id="${checkbox.value}"]`);
        if (existingRow) {
            return; // Nếu đã tồn tại thì không thêm nữa
        }
        
        // Thêm câu hỏi mới vào bảng
        const tbody = selectedQuestionsTable.querySelector('tbody');
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
        tbody.appendChild(newRow);
        selectedQuestions.add(checkbox.value);
    }

    // Xóa câu hỏi khỏi bảng
    function removeQuestionFromTable(questionId) {
        const row = selectedQuestionsTable.querySelector(`tr[data-question-id="${questionId}"]`);
        if (row) {
            // Xóa khỏi Set và bảng
            selectedQuestions.delete(questionId);
            row.remove();
            
            // Bỏ chọn checkbox tương ứng
            const checkbox = document.querySelector(`.question-checkbox[value="${questionId}"]`);
            if (checkbox) {
                checkbox.checked = false;
            }
            
            updateQuestionNumbers();
            updateTotalQuestions();
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
        // Cập nhật số câu hỏi đã chọn và tổng số câu hỏi
        const totalQuestions = rows.length;
        document.getElementById('selectedQuestionCount').textContent = totalQuestions;
        document.getElementById('totalQuestions').textContent = totalQuestions;
    }

    // Cập nhật tổng số câu hỏi
    function updateTotalQuestions() {
        const totalQuestions = selectedQuestionsTable.querySelectorAll('tbody tr').length;
        if (totalQuestionsInput) {
            totalQuestionsInput.value = totalQuestions;
        }
    }

    // Cập nhật số thứ tự và tổng số câu hỏi ban đầu
    updateQuestionNumbers();
    updateTotalQuestions();

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
                                    <input type="checkbox" name="questions[]" 
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
                            
                            // Thêm event listener cho checkbox mới
                            const checkbox = newRow.querySelector('.question-checkbox');
                            checkbox.addEventListener('change', function() {
                                if (this.checked) {
                                    addQuestionToTable(this);
                                } else {
                                    removeQuestionFromTable(this.value);
                                }
                                updateQuestionNumbers();
                                updateTotalQuestions();
                            });

                            // Tự động chọn và thêm vào bảng câu hỏi đã chọn
                            checkbox.checked = true;
                            addQuestionToTable(checkbox);
                        }
                    });
                    
                    // Cập nhật số thứ tự và tổng số câu hỏi sau khi import
                    updateQuestionNumbers();
                    updateTotalQuestions();
                    
                    // Đóng modal
                    const modal = bootstrap.Modal.getInstance(document.getElementById('importModal'));
                    modal.hide();
                    
                    // Hiển thị thông báo thành công
                    alert('Import câu hỏi thành công!');
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
});
</script>
@endpush 