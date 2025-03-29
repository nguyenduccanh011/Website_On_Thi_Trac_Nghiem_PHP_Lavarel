@extends('layouts.app')

@section('title', 'Bắt Đầu Làm Bài Thi')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h2 class="mb-0">Bắt Đầu Làm Bài Thi</h2>
            </div>
            <div class="card-body">
                <div class="mb-4">
                    <h5 class="card-title">Thông Tin Đề Thi</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Tên Đề Thi:</strong> {{ $exam->exam_name }}</p>
                            <p><strong>Môn Học:</strong> {{ $exam->subject->subject_name }}</p>
                            <p><strong>Độ Khó:</strong> 
                                <span class="badge bg-{{ $exam->difficulty_level === 'easy' ? 'success' : ($exam->difficulty_level === 'medium' ? 'warning' : 'danger') }}">
                                    {{ ucfirst($exam->difficulty_level) }}
                                </span>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Thời Gian:</strong> {{ $exam->duration }} phút</p>
                            <p><strong>Tổng Điểm:</strong> {{ $exam->total_marks }}</p>
                            <p><strong>Điểm Đạt:</strong> {{ $exam->passing_marks }}</p>
                            <p><strong>Số Câu Hỏi:</strong> {{ $exam->questions_count }}</p>
                        </div>
                    </div>
                </div>

                @if($exam->description)
                    <div class="mb-4">
                        <h5 class="card-title">Mô Tả</h5>
                        <p class="card-text">{{ $exam->description }}</p>
                    </div>
                @endif

                <div class="alert alert-warning">
                    <h5 class="alert-heading"><i class="fas fa-exclamation-triangle"></i> Lưu Ý</h5>
                    <ul class="mb-0">
                        <li>Bạn sẽ có {{ $exam->duration }} phút để hoàn thành bài thi</li>
                        <li>Không thể quay lại câu hỏi trước sau khi đã chuyển sang câu tiếp theo</li>
                        <li>Bài thi sẽ tự động nộp khi hết thời gian</li>
                        <li>Điểm đạt là {{ $exam->passing_marks }}/{{ $exam->total_marks }}</li>
                    </ul>
                </div>

                <form action="{{ route('exam-attempts.store', $exam) }}" method="POST">
                    @csrf
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('exams.show', $exam) }}" class="btn btn-secondary">Quay Lại</a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-play"></i> Bắt Đầu Làm Bài
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection 