@extends('layouts.admin')

@section('title', 'Quản Lý Đề Thi')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Quản Lý Đề Thi</h1>
        <a href="{{ route('admin.exams.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Thêm Đề Thi Mới
        </a>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Danh sách đề thi</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#importModal">
                    <i class="fas fa-file-import"></i> Import Excel
                </button>
                <a href="{{ route('admin.exams.download-template') }}" class="btn btn-success">
                    <i class="fas fa-download"></i> Tải File Mẫu
                </a>
                <a href="{{ route('admin.exams.create') }}" class="btn btn-info">
                    <i class="fas fa-plus"></i> Thêm Đề Thi
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Tên Đề Thi</th>
                            <th>Danh Mục</th>
                            <th>Độ Khó</th>
                            <th>Thời Gian</th>
                            <th>Điểm Tối Đa</th>
                            <th>Điểm Đạt</th>
                            <th>Trạng Thái</th>
                            <th>Thao Tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($exams as $exam)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $exam->title }}</td>
                                <td>{{ $exam->category->name }}</td>
                                <td>
                                    <span class="badge bg-{{ $exam->difficulty_level === 'easy' ? 'success' : ($exam->difficulty_level === 'medium' ? 'warning' : 'danger') }}">
                                        {{ ucfirst($exam->difficulty_level) }}
                                    </span>
                                </td>
                                <td>{{ $exam->duration }} phút</td>
                                <td>{{ $exam->total_marks }}</td>
                                <td>{{ $exam->passing_marks }}</td>
                                <td>
                                    @if($exam->is_active)
                                        <span class="badge bg-success">Đang Mở</span>
                                    @else
                                        <span class="badge bg-danger">Đã Đóng</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.exams.edit', $exam) }}" class="btn btn-primary btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.exams.destroy', $exam) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" 
                                                    onclick="return confirm('Bạn có chắc chắn muốn xóa đề thi này?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center">Chưa có đề thi nào</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $exams->links() }}
    </div>
</div>

<!-- Modal Import -->
<div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="importModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="importModalLabel">Import Đề Thi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.exams.import') }}" method="POST" enctype="multipart/form-data">
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
                            <li>title: Tiêu đề đề thi</li>
                            <li>description: Mô tả (tùy chọn)</li>
                            <li>duration: Thời gian làm bài (phút)</li>
                            <li>total_marks: Tổng điểm</li>
                            <li>passing_marks: Điểm đạt</li>
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