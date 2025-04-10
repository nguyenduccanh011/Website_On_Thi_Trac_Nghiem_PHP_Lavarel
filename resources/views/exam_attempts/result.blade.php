@extends('layouts.app')

@section('title', 'Kết Quả Bài Thi')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Kết Quả Bài Thi: {{ $attempt->exam->exam_name }}</h4>
                </div>
                <div class="card-body">
                    <!-- Thông tin tổng quan -->
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <div class="card bg-light">
                                <div class="card-body text-center">
                                    <h5 class="card-title">Điểm Số</h5>
                                    <h2 class="display-4 {{ $attempt->score >= $attempt->exam->passing_marks ? 'text-success' : 'text-danger' }}">
                                        {{ number_format($attempt->score, 1) }}/{{ $attempt->exam->total_marks }}
                                    </h2>
                                    @if($attempt->score >= $attempt->exam->passing_marks)
                                        <span class="badge bg-success">Đạt</span>
                                    @else
                                        <span class="badge bg-danger">Không Đạt</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-light">
                                <div class="card-body text-center">
                                    <h5 class="card-title">Câu Đúng</h5>
                                    <h2 class="display-4 text-success">{{ $attempt->correct_answers }}</h2>
                                    <p class="mb-0">trên {{ $attempt->total_questions }} câu</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-light">
                                <div class="card-body text-center">
                                    <h5 class="card-title">Câu Sai</h5>
                                    <h2 class="display-4 text-danger">{{ $attempt->incorrect_answers }}</h2>
                                    <p class="mb-0">trên {{ $attempt->total_questions }} câu</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Chi tiết từng câu hỏi -->
                    <h5 class="mb-3">Chi Tiết Bài Làm</h5>
                    @foreach($attempt->exam->questions as $index => $question)
                        @php
                            $userAnswer = $attempt->userAnswers->where('question_id', $question->id)->first();
                            $isCorrect = $userAnswer ? $userAnswer->is_correct : false;
                        @endphp
                        <div class="card mb-3 {{ $isCorrect ? 'border-success' : 'border-danger' }}">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h6 class="mb-0">Câu {{ $index + 1 }}</h6>
                                @if($isCorrect)
                                    <span class="badge bg-success">Đúng</span>
                                @else
                                    <span class="badge bg-danger">Sai</span>
                                @endif
                            </div>
                            <div class="card-body">
                                <p class="card-text">{{ $question->question_text }}</p>
                                
                                <div class="options">
                                    @if(!$userAnswer || !$userAnswer->selected_answer)
                                        <div class="alert alert-warning mb-3">
                                            <strong>Chú ý:</strong> Bạn chưa chọn đáp án nào cho câu hỏi này.
                                        </div>
                                    @endif

                                    @foreach(['A', 'B', 'C', 'D'] as $option)
                                        @php
                                            $optionText = $question->{'option_' . strtolower($option)};
                                            $isSelected = $userAnswer && $userAnswer->selected_answer === $option;
                                            $isCorrectAnswer = $question->correct_answer === $option;
                                        @endphp
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="radio" 
                                                disabled
                                                {{ $isSelected ? 'checked' : '' }}
                                                {{ $isCorrectAnswer ? 'checked' : '' }}>
                                            <label class="form-check-label {{ $isSelected ? ($isCorrect ? 'text-success' : 'text-danger') : ($isCorrectAnswer ? 'text-success' : '') }}">
                                                {{ $optionText }}
                                                @if($isSelected)
                                                    <span class="badge bg-{{ $isCorrect ? 'success' : 'danger' }}">Bạn chọn</span>
                                                @endif
                                                @if($isCorrectAnswer && !$isSelected)
                                                    <span class="badge bg-success">Đáp án đúng</span>
                                                @endif
                                            </label>
                                        </div>
                                    @endforeach
                                </div>

                            </div>
                        </div>
                    @endforeach

                    <div class="text-center mt-4">
                        <a href="{{ route('exam-attempts.index') }}" class="btn btn-primary">Quay Lại Danh Sách Bài Thi</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 