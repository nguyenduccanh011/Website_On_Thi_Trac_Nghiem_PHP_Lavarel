@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-12">
            <h1>Dashboard</h1>
            <p class="lead">Chào mừng, {{ Auth::user()->name }}!</p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Bài Thi Đã Làm</h5>
                    <p class="display-4">{{ Auth::user()->examAttempts()->count() }}</p>
                    <a href="{{ route('exam-attempts.index') }}" class="btn btn-primary">Xem Chi Tiết</a>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Bài Thi Đạt</h5>
                    <p class="display-4">{{ Auth::user()->examAttempts()->join('exams', 'exam_attempts.exam_id', '=', 'exams.id')->where('exam_attempts.score', '>=', 'exams.passing_marks')->count() }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Bài Thi Không Đạt</h5>
                    <p class="display-4">{{ Auth::user()->examAttempts()->join('exams', 'exam_attempts.exam_id', '=', 'exams.id')->where('exam_attempts.score', '<', 'exams.passing_marks')->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Bài Thi Gần Đây</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Đề Thi</th>
                                    <th>Độ Khó</th>
                                    <th>Điểm Số</th>
                                    <th>Trạng Thái</th>
                                    <th>Thao Tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse(Auth::user()->examAttempts()->latest()->take(5)->get() as $attempt)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
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
                                        <td>
                                            <a href="{{ route('exam-attempts.show', $attempt) }}" class="btn btn-info btn-sm">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Bạn chưa làm bài thi nào</td>
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