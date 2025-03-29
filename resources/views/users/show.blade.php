@extends('layouts.app')

@section('title', 'Chi Tiết Người Dùng')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h2 class="mb-0">Chi Tiết Người Dùng</h2>
                <div>
                    <a href="{{ route('users.edit', $user) }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-edit"></i> Chỉnh Sửa
                    </a>
                    <a href="{{ route('users.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> Quay Lại
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="mb-4">
                    <h5 class="card-title">Thông Tin Chung</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Họ Tên:</strong> {{ $user->name }}</p>
                            <p><strong>Email:</strong> {{ $user->email }}</p>
                            <p><strong>Vai Trò:</strong> 
                                <span class="badge bg-{{ $user->is_admin ? 'danger' : 'primary' }}">
                                    {{ $user->is_admin ? 'Quản Trị Viên' : 'Người Dùng' }}
                                </span>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Ngày Tham Gia:</strong> {{ $user->created_at->format('d/m/Y H:i') }}</p>
                            <p><strong>Cập Nhật Cuối:</strong> {{ $user->updated_at->format('d/m/Y H:i') }}</p>
                            <p><strong>Trạng Thái:</strong>
                                @if($user->is_active)
                                    <span class="badge bg-success">Hoạt Động</span>
                                @else
                                    <span class="badge bg-danger">Đã Khóa</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <h5 class="card-title">Thống Kê Bài Thi</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-body text-center">
                                    <h6 class="card-title">Tổng Số Lần Làm Bài</h6>
                                    <p class="display-4">{{ $user->attempts_count }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-body text-center">
                                    <h6 class="card-title">Điểm Trung Bình</h6>
                                    <p class="display-4">
                                        @if($user->attempts_count > 0)
                                            {{ number_format($user->average_score, 1) }}
                                        @else
                                            -
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <h5 class="card-title">Lịch Sử Làm Bài</h5>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Đề Thi</th>
                                    <th>Môn Học</th>
                                    <th>Điểm Số</th>
                                    <th>Thời Gian</th>
                                    <th>Chi Tiết</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($user->attempts as $attempt)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $attempt->exam->exam_name }}</td>
                                        <td>{{ $attempt->exam->subject->subject_name }}</td>
                                        <td>
                                            <span class="badge bg-{{ $attempt->score >= $attempt->exam->passing_marks ? 'success' : 'danger' }}">
                                                {{ number_format($attempt->score, 1) }}
                                            </span>
                                        </td>
                                        <td>{{ $attempt->created_at->format('d/m/Y H:i') }}</td>
                                        <td>
                                            <a href="{{ route('exam-attempts.show', $attempt) }}" class="btn btn-info btn-sm">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Chưa có lịch sử làm bài</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="d-flex justify-content-between">
                    <form action="{{ route('users.destroy', $user) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" 
                                onclick="return confirm('Bạn có chắc chắn muốn xóa người dùng này?')">
                            <i class="fas fa-trash"></i> Xóa Người Dùng
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 