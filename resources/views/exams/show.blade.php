@extends('layouts.app')

@section('title', 'Chi Tiết Bài Thi')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h2 class="mb-0">Chi Tiết Bài Thi</h2>
                <div>
                    @auth
                        <a href="{{ route('exams.edit', $exam) }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-edit"></i> Chỉnh Sửa
                        </a>
                    @endauth
                    <a href="{{ route('exams.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> Quay Lại
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="text-center mb-4">
                    <h3>{{ $exam->title }}</h3>
                    <p class="lead">{{ $exam->description }}</p>
                    <div class="badge bg-{{ $exam->is_active ? 'success' : 'danger' }}">
                        {{ $exam->is_active ? 'Đang Mở' : 'Đã Đóng' }}
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <h5 class="card-title">Thông Tin Chung</h5>
                        <ul class="list-unstyled">
                            <li><strong>Danh Mục:</strong> {{ $exam->category->name }}</li>
                            <li><strong>Thời Gian:</strong> {{ $exam->duration }} phút</li>
                            <li><strong>Tổng Điểm:</strong> {{ $exam->total_marks }}</li>
                            <li><strong>Điểm Đạt:</strong> {{ $exam->passing_marks }}</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h5 class="card-title">Thống Kê</h5>
                        <ul class="list-unstyled">
                            <li><strong>Số Câu Hỏi:</strong> {{ $exam->questions->count() }}</li>
                            <li><strong>Số Lần Thi:</strong> {{ $exam->attempts->count() }}</li>
                            <li><strong>Tỷ Lệ Đạt:</strong> {{ $exam->pass_rate ?? 0 }}%</li>
                        </ul>
                    </div>
                </div>

                <div class="mb-4">
                    <h5 class="card-title">Danh Sách Câu Hỏi</h5>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Câu Hỏi</th>
                                    <th>Độ Khó</th>
                                    <th>Điểm Số</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($exam->questions as $question)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $question->question_text }}</td>
                                        <td>
                                            <span class="badge bg-{{ $question->difficulty_level === 'easy' ? 'success' : ($question->difficulty_level === 'medium' ? 'warning' : 'danger') }}">
                                                {{ ucfirst($question->difficulty_level) }}
                                            </span>
                                        </td>
                                        <td>{{ $question->marks }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                @auth
                    @if($exam->is_active)
                        <div class="text-center">
                            <a href="{{ route('exam-attempts.create', $exam) }}" class="btn btn-success">
                                <i class="fas fa-play"></i> Bắt Đầu Làm Bài
                            </a>
                        </div>
                    @endif
                @endauth
            </div>
        </div>
    </div>
</div>
@endsection 