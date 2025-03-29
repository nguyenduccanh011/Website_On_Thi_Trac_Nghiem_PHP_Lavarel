@extends('layouts.app')

@section('title', 'Kết Quả Bài Thi')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h2 class="mb-0">Kết Quả Bài Thi</h2>
            </div>
            <div class="card-body">
                <div class="text-center mb-4">
                    <h3>{{ $attempt->exam->exam_name }}</h3>
                    <div class="display-4 {{ $attempt->score >= $attempt->exam->passing_marks ? 'text-success' : 'text-danger' }}">
                        {{ number_format($attempt->score, 1) }}/{{ $attempt->exam->total_marks }}
                    </div>
                    <p class="lead">
                        @if($attempt->score >= $attempt->exam->passing_marks)
                            <span class="badge bg-success">Đạt</span>
                        @else
                            <span class="badge bg-danger">Không Đạt</span>
                        @endif
                    </p>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <h5 class="card-title">Thông Tin Bài Thi</h5>
                        <ul class="list-unstyled">
                            <li><strong>Môn Học:</strong> {{ $attempt->exam->subject->subject_name }}</li>
                            <li><strong>Thời Gian:</strong> {{ $attempt->exam->duration }} phút</li>
                            <li><strong>Điểm Đạt:</strong> {{ $attempt->exam->passing_marks }}/{{ $attempt->exam->total_marks }}</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h5 class="card-title">Thông Tin Làm Bài</h5>
                        <ul class="list-unstyled">
                            <li><strong>Thời Gian Bắt Đầu:</strong> {{ $attempt->start_time->format('d/m/Y H:i') }}</li>
                            <li><strong>Thời Gian Kết Thúc:</strong> {{ $attempt->end_time->format('d/m/Y H:i') }}</li>
                            <li><strong>Thời Gian Làm Bài:</strong> {{ $attempt->duration }} phút</li>
                        </ul>
                    </div>
                </div>

                <div class="mb-4">
                    <h5 class="card-title">Chi Tiết Câu Trả Lời</h5>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Câu Hỏi</th>
                                    <th>Đáp Án Của Bạn</th>
                                    <th>Đáp Án Đúng</th>
                                    <th>Kết Quả</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($attempt->answers as $answer)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $answer->question->question_text }}</td>
                                        <td>{{ $answer->selected_answer }}</td>
                                        <td>{{ $answer->question->correct_answer }}</td>
                                        <td>
                                            @if($answer->is_correct)
                                                <span class="badge bg-success">Đúng</span>
                                            @else
                                                <span class="badge bg-danger">Sai</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('exam-attempts.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Quay Lại Danh Sách
                    </a>
                    <a href="{{ route('exams.show', $attempt->exam) }}" class="btn btn-primary">
                        <i class="fas fa-eye"></i> Xem Đề Thi
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 