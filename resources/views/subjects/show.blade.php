@extends('layouts.app')

@section('title', 'Chi Tiết Môn Học')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h2 class="mb-0">Chi Tiết Môn Học</h2>
                <div>
                    <a href="{{ route('subjects.edit', $subject) }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-edit"></i> Chỉnh Sửa
                    </a>
                    <a href="{{ route('subjects.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> Quay Lại
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="mb-4">
                    <h5 class="card-title">Thông Tin Chung</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Tên Môn Học:</strong> {{ $subject->subject_name }}</p>
                            <p><strong>Số Đề Thi:</strong> {{ $subject->exams_count }}</p>
                            <p><strong>Số Câu Hỏi:</strong> {{ $subject->questions_count }}</p>
                        </div>
                    </div>
                </div>

                @if($subject->description)
                    <div class="mb-4">
                        <h5 class="card-title">Mô Tả</h5>
                        <p class="card-text">{{ $subject->description }}</p>
                    </div>
                @endif

                <div class="mb-4">
                    <h5 class="card-title">Danh Sách Đề Thi</h5>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Tên Đề Thi</th>
                                    <th>Độ Khó</th>
                                    <th>Thời Gian</th>
                                    <th>Trạng Thái</th>
                                    <th>Thao Tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($subject->exams as $exam)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $exam->exam_name }}</td>
                                        <td>
                                            <span class="badge bg-{{ $exam->difficulty_level === 'easy' ? 'success' : ($exam->difficulty_level === 'medium' ? 'warning' : 'danger') }}">
                                                {{ ucfirst($exam->difficulty_level) }}
                                            </span>
                                        </td>
                                        <td>{{ $exam->duration }} phút</td>
                                        <td>
                                            @if($exam->is_active)
                                                <span class="badge bg-success">Đang Mở</span>
                                            @else
                                                <span class="badge bg-danger">Đã Đóng</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('exams.show', $exam) }}" class="btn btn-info btn-sm">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Chưa có đề thi nào</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="d-flex justify-content-between">
                    <form action="{{ route('subjects.destroy', $subject) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" 
                                onclick="return confirm('Bạn có chắc chắn muốn xóa môn học này?')">
                            <i class="fas fa-trash"></i> Xóa Môn Học
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 