@extends('layouts.admin')

@section('title', 'Thêm Ngân Hàng Câu Hỏi Mới')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Thêm Ngân Hàng Câu Hỏi Mới</h1>
        <a href="{{ route('admin.exam-banks.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Quay Lại
        </a>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Thêm Ngân Hàng Đề Thi Mới</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#importQuestionsModal">
                    <i class="fas fa-file-import"></i> Import Câu Hỏi
                </button>
                <a href="{{ route('admin.questions.template') }}" class="btn btn-info">
                    <i class="fas fa-download"></i> Tải File Mẫu
                </a>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.exam-banks.store') }}" method="POST">
                @csrf
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="bank_name" class="form-label">Tên Ngân Hàng</label>
                            <input type="text" class="form-control @error('bank_name') is-invalid @enderror" 
                                   id="bank_name" name="bank_name" value="{{ old('bank_name') }}" required>
                            @error('bank_name')
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
                            <label for="total_questions" class="form-label">Số Câu Hỏi</label>
                            <input type="number" class="form-control @error('total_questions') is-invalid @enderror" 
                                   id="total_questions" name="total_questions" value="{{ old('total_questions') }}" required>
                            @error('total_questions')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
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

                <div class="mb-3">
                    <label class="form-label">Chọn Câu Hỏi</label>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th style="width: 50px;">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="select-all">
                                        </div>
                                    </th>
                                    <th>Câu Hỏi</th>
                                    <th>Độ Khó</th>
                                    <th>Đáp Án Đúng</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($questions as $question)
                                    <tr>
                                        <td>
                                            <div class="form-check">
                                                <input class="form-check-input question-checkbox" type="checkbox" 
                                                       name="questions[]" value="{{ $question->question_id }}"
                                                       {{ in_array($question->question_id, old('questions', [])) ? 'checked' : '' }}>
                                            </div>
                                        </td>
                                        <td>{{ $question->question_text }}</td>
                                        <td>
                                            <span class="badge bg-{{ $question->difficulty_level === 'easy' ? 'success' : ($question->difficulty_level === 'medium' ? 'warning' : 'danger') }}">
                                                {{ ucfirst($question->difficulty_level) }}
                                            </span>
                                        </td>
                                        <td>{{ $question->correct_answer }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @error('questions')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Lưu Ngân Hàng
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Import Questions -->
<div class="modal fade" id="importQuestionsModal" tabindex="-1" aria-labelledby="importQuestionsModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="importQuestionsModalLabel">Import Câu Hỏi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="importQuestionsForm" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="questions_file">Chọn File CSV</label>
                        <input type="file" class="form-control" id="questions_file" name="file" accept=".csv,.txt" required>
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
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary">Import</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        // Xử lý checkbox chọn tất cả
        $('#select-all').on('change', function() {
            $('.question-checkbox').prop('checked', $(this).prop('checked'));
        });

        // Xử lý form import
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
                            const checkbox = document.querySelector(`input[name="questions[]"][value="${question.id}"]`);
                            if (checkbox) {
                                checkbox.checked = true;
                            }
                        });
                        
                        // Đóng modal
                        var modal = bootstrap.Modal.getInstance(document.getElementById('importQuestionsModal'));
                        modal.hide();
                        
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