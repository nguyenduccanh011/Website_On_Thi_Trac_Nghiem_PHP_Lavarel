@extends('layouts.app')

@section('title', 'Danh Sách Môn Học')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Danh Sách Môn Học</h1>
    <a href="{{ route('subjects.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Thêm Môn Học Mới
    </a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Tên Môn Học</th>
                        <th>Mô Tả</th>
                        <th>Số Đề Thi</th>
                        <th>Số Câu Hỏi</th>
                        <th>Thao Tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($subjects as $subject)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $subject->subject_name }}</td>
                            <td>{{ Str::limit($subject->description, 100) }}</td>
                            <td>{{ $subject->exams_count }}</td>
                            <td>{{ $subject->questions_count }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('subjects.show', $subject) }}" class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('subjects.edit', $subject) }}" class="btn btn-primary btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('subjects.destroy', $subject) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" 
                                                onclick="return confirm('Bạn có chắc chắn muốn xóa môn học này?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Chưa có môn học nào</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="d-flex justify-content-center mt-4">
    {{ $subjects->links() }}
</div>
@endsection 