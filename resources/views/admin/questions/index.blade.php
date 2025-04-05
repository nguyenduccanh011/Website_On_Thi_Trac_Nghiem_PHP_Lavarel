@extends('layouts.admin')

@section('title', 'Quản Lý Câu Hỏi')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">Quản Lý Câu Hỏi</h4>
                        <div>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#importModal">
                                <i class="fas fa-file-import"></i> Import Excel
                            </button>
                            <a href="{{ route('admin.questions.download-template') }}" class="btn btn-success">
                                <i class="fas fa-download"></i> Tải File Mẫu
                            </a>
                            <a href="{{ route('admin.questions.create') }}" class="btn btn-info">
                                <i class="fas fa-plus"></i> Thêm Câu Hỏi
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Câu hỏi</th>
                                    <th>Ngân hàng đề</th>
                                    <th>Độ khó</th>
                                    <th>Trạng thái</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($questions as $question)
                                    <tr>
                                        <td>{{ $question->id }}</td>
                                        <td>{{ Str::limit($question->question_text, 100) }}</td>
                                        <td>{{ $question->examBank ? $question->examBank->name : 'N/A' }}</td>
                                        <td>
                                            <span class="badge badge-{{ 
                                                $question->difficulty_level === 'easy' ? 'success' : 
                                                ($question->difficulty_level === 'medium' ? 'warning' : 'danger') 
                                            }}">
                                                {{ ucfirst($question->difficulty_level) }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge badge-{{ $question->is_active ? 'success' : 'danger' }}">
                                                {{ $question->is_active ? 'Hoạt động' : 'Không hoạt động' }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.questions.edit', $question->id) }}" 
                                               class="btn btn-sm btn-info">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.questions.destroy', $question->id) }}" 
                                                  method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" 
                                                        onclick="return confirm('Bạn có chắc chắn muốn xóa câu hỏi này?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Không có câu hỏi nào</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">
                        {{ $questions->links() }}
                    </div>
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
            <form action="{{ route('admin.questions.import') }}" method="POST" enctype="multipart/form-data">
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
@endsection 