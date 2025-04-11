@extends('layouts.admin')

@section('title', 'Quản Lý Ngân Hàng Câu Hỏi')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Quản Lý Ngân Hàng Câu Hỏi</h1>
        <div class="card-tools">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#importModal">
                <i class="fas fa-file-import"></i> Import Excel
            </button>
            <a href="{{ route('admin.exam-banks.download-template') }}" class="btn btn-success">
                <i class="fas fa-download"></i> Tải File Mẫu
            </a>
            <a href="{{ route('admin.exam-banks.create') }}" class="btn btn-info">
                <i class="fas fa-plus"></i> Thêm Ngân Hàng Đề Thi
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Danh sách ngân hàng đề thi</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Tên Ngân Hàng</th>
                            <th>Danh Mục</th>
                            <th>Độ Khó</th>
                            <th>Số Câu Hỏi</th>
                            <th>Thao Tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($examBanks as $bank)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $bank->name }}</td>
                                <td>
                                    @foreach($bank->categories as $category)
                                        <span class="badge bg-info me-1">{{ $category->name }}</span>
                                    @endforeach
                                </td>
                                <td>
                                    <span class="badge bg-{{ $bank->difficulty_level === 'easy' ? 'success' : ($bank->difficulty_level === 'medium' ? 'warning' : 'danger') }}">
                                        {{ ucfirst($bank->difficulty_level) }}
                                    </span>
                                </td>
                                <td>{{ $bank->total_questions }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.exam-banks.edit', $bank) }}" class="btn btn-primary btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.exam-banks.destroy', $bank) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" 
                                                    onclick="return confirm('Bạn có chắc chắn muốn xóa ngân hàng câu hỏi này?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Chưa có ngân hàng câu hỏi nào</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $examBanks->links() }}
    </div>
</div>

<!-- Modal Import -->
<div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="importModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="importModalLabel">Import Ngân Hàng Đề Thi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.exam-banks.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="file">Chọn File CSV</label>
                        <input type="file" class="form-control-file" id="file" name="file" accept=".csv,.txt" required>
                    </div>
                    <div class="alert alert-info">
                        <h6>Hướng dẫn:</h6>
                        <p>File CSV phải có các cột sau:</p>
                        <ul>
                            <li>name: Tên ngân hàng đề thi</li>
                            <li>description: Mô tả (tùy chọn)</li>
                            <li>is_active: Trạng thái (1: hoạt động, 0: không hoạt động)</li>
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
@endsection 