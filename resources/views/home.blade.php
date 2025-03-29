@extends('layouts.app')

@section('title', 'Trang Chủ')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-12">
            <h1>Chào mừng đến với Hệ Thống Thi Trực Tuyến</h1>
            <p class="lead">Hệ thống thi trực tuyến với nhiều môn học và bài thi đa dạng.</p>
        </div>
    </div>

    @auth
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Bài Thi Của Bạn</h5>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>Đề Thi</th>
                                        <th>Danh Mục</th>
                                        <th>Điểm Số</th>
                                        <th>Trạng Thái</th>
                                        <th>Thao Tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse(auth()->user()->examAttempts()->latest()->take(5)->get() as $attempt)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $attempt->exam->exam_name }}</td>
                                            <td>{{ $attempt->exam->category->name }}</td>
                                            <td>
                                                @if($attempt->score !== null)
                                                    <span class="badge bg-{{ $attempt->score >= $attempt->exam->passing_marks ? 'success' : 'danger' }}">
                                                        {{ number_format($attempt->score, 1) }}/{{ $attempt->exam->total_marks }}
                                                    </span>
                                                @else
                                                    <span class="badge bg-warning">Chưa hoàn thành</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($attempt->score !== null)
                                                    @if($attempt->score >= $attempt->exam->passing_marks)
                                                        <span class="badge bg-success">Đạt</span>
                                                    @else
                                                        <span class="badge bg-danger">Không Đạt</span>
                                                    @endif
                                                @else
                                                    <span class="badge bg-warning">Đang làm</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('exam-attempts.show', $attempt->id) }}" class="btn btn-info btn-sm">
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
    @endauth

    <div class="row">
        <div class="col-md-12">
            <h2>Bài Thi Mới Nhất</h2>
        </div>
        @foreach($exams as $exam)
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">{{ $exam->title }}</h5>
                        <p class="card-text">
                            <strong>Danh Mục:</strong> {{ $exam->category->name }}<br>
                            <strong>Số Câu:</strong> {{ $exam->questions->count() }}<br>
                            <strong>Thời Gian:</strong> {{ $exam->duration }} phút<br>
                            <strong>Điểm Đạt:</strong> {{ $exam->passing_marks }}/{{ $exam->total_marks }}
                        </p>
                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ route('exams.show', $exam) }}" class="btn btn-primary">Chi Tiết</a>
                            @auth
                                @if($exam->is_active)
                                    <a href="{{ route('exam-attempts.create', $exam) }}" class="btn btn-success">
                                        Làm Bài
                                    </a>
                                @endif
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection 