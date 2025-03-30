@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-12">
            <h1>Dashboard</h1>
            <p class="lead">Chào mừng, {{ Auth::user()->name }}!</p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3 mb-4">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h5 class="card-title">Tổng Số Người Dùng</h5>
                    <p class="display-4">{{ $stats['total_users'] }}</p>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-light">Xem Chi Tiết</a>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h5 class="card-title">Tổng Số Đề Thi</h5>
                    <p class="display-4">{{ $stats['total_exams'] }}</p>
                    <a href="{{ route('admin.exams.index') }}" class="btn btn-light">Xem Chi Tiết</a>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <h5 class="card-title">Tổng Số Câu Hỏi</h5>
                    <p class="display-4">{{ $stats['total_questions'] }}</p>
                    <a href="{{ route('admin.questions.index') }}" class="btn btn-light">Xem Chi Tiết</a>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <h5 class="card-title">Tổng Số Lần Thi</h5>
                    <p class="display-4">{{ $stats['total_attempts'] }}</p>
                    <a href="{{ route('admin.reports.index') }}" class="btn btn-light">Xem Chi Tiết</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Lần Thi Gần Đây</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Người Dùng</th>
                                    <th>Đề Thi</th>
                                    <th>Độ Khó</th>
                                    <th>Điểm Số</th>
                                    <th>Trạng Thái</th>
                                    <th>Thời Gian</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($stats['recent_attempts'] as $attempt)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $attempt->user->name }}</td>
                                        <td>{{ $attempt->exam->exam_name }}</td>
                                        <td>
                                            <span class="badge bg-{{ $attempt->exam->difficulty_level === 'easy' ? 'success' : ($attempt->exam->difficulty_level === 'medium' ? 'warning' : 'danger') }}">
                                                {{ ucfirst($attempt->exam->difficulty_level) }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $attempt->score >= $attempt->exam->passing_marks ? 'success' : 'danger' }}">
                                                {{ number_format($attempt->score, 1) }}/{{ $attempt->exam->total_marks }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($attempt->score >= $attempt->exam->passing_marks)
                                                <span class="badge bg-success">Đạt</span>
                                            @else
                                                <span class="badge bg-danger">Không Đạt</span>
                                            @endif
                                        </td>
                                        <td>{{ $attempt->created_at->format('d/m/Y H:i') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">Chưa có lần thi nào</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 