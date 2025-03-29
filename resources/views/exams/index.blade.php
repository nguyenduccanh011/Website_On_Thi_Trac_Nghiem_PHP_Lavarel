@extends('layouts.app')

@section('title', 'Danh Sách Bài Thi')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Danh Sách Bài Thi</h1>
    @auth
        <a href="{{ route('exams.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Thêm Bài Thi Mới
        </a>
    @endauth
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Tên Bài Thi</th>
                        <th>Danh Mục</th>
                        <th>Số Câu Hỏi</th>
                        <th>Thời Gian</th>
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
                            <td>{{ $exam->questions->count() }}</td>
                            <td>{{ $exam->duration }} phút</td>
                            <td>{{ $exam->passing_marks }}/{{ $exam->total_marks }}</td>
                            <td>
                                @if($exam->is_active)
                                    <span class="badge bg-success">Đang Mở</span>
                                @else
                                    <span class="badge bg-danger">Đã Đóng</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('exams.show', $exam) }}" class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @auth
                                        <a href="{{ route('exam-attempts.create', $exam) }}" class="btn btn-success btn-sm">
                                            <i class="fas fa-pencil-alt"></i> Làm Bài
                                        </a>
                                        <a href="{{ route('exams.edit', $exam) }}" class="btn btn-primary btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('exams.destroy', $exam) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" 
                                                    onclick="return confirm('Bạn có chắc chắn muốn xóa bài thi này?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    @endauth
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">Chưa có bài thi nào</td>
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
@endsection 