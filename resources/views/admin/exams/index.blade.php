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

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
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
                                <td>{{ $exam->exam_name }}</td>
                                <td>{{ $exam->category->category_name }}</td>
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
@endsection 