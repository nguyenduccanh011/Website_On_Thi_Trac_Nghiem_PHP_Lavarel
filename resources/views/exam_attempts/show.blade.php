@extends('layouts.app')

@section('title', 'Làm Bài Thi')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1>{{ $attempt->exam->title }}</h1>
                <div class="timer" id="examTimer">
                    Thời gian còn lại: <span id="timeLeft">{{ $attempt->exam->duration }}:00</span>
                </div>
            </div>
            <div class="alert alert-info">
                <strong>Lưu ý:</strong>
                <ul class="mb-0">
                    <li>Thời gian làm bài: {{ $attempt->exam->duration }} phút</li>
                    <li>Số câu hỏi: {{ $attempt->total_questions }} câu</li>
                    <li>Điểm đạt: {{ $attempt->exam->passing_marks }}/{{ $attempt->exam->total_marks }}</li>
                </ul>
            </div>
        </div>
    </div>

    <form action="{{ route('exam-attempts.submit', $attempt) }}" method="POST" id="examForm">
        @csrf
        <div class="row">
            @foreach($attempt->exam->questions as $index => $question)
            <div class="col-md-12 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Câu {{ $index + 1 }}: {{ $question->question_text }}</h5>
                        <div class="answers mt-3">
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" 
                                       name="answers[{{ $question->question_id }}]" 
                                       id="answerA{{ $question->question_id }}" 
                                       value="A"
                                       required>
                                <label class="form-check-label" for="answerA{{ $question->question_id }}">
                                    {{ $question->option_a }}
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" 
                                       name="answers[{{ $question->question_id }}]" 
                                       id="answerB{{ $question->question_id }}" 
                                       value="B"
                                       required>
                                <label class="form-check-label" for="answerB{{ $question->question_id }}">
                                    {{ $question->option_b }}
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" 
                                       name="answers[{{ $question->question_id }}]" 
                                       id="answerC{{ $question->question_id }}" 
                                       value="C"
                                       required>
                                <label class="form-check-label" for="answerC{{ $question->question_id }}">
                                    {{ $question->option_c }}
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" 
                                       name="answers[{{ $question->question_id }}]" 
                                       id="answerD{{ $question->question_id }}" 
                                       value="D"
                                       required>
                                <label class="form-check-label" for="answerD{{ $question->question_id }}">
                                    {{ $question->option_d }}
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="row mb-4">
            <div class="col-md-12">
                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary btn-lg" onclick="return confirm('Bạn có chắc chắn muốn nộp bài?')">
                        Nộp Bài
                    </button>
                    <a href="{{ route('exams.index') }}" class="btn btn-secondary btn-lg">
                        Thoát
                    </a>
                </div>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Thời gian làm bài (phút)
    let duration = {{ $attempt->exam->duration }};
    let timeLeft = duration * 60; // Chuyển sang giây

    // Cập nhật thời gian mỗi giây
    let timer = setInterval(function() {
        timeLeft--;
        
        // Tính phút và giây
        let minutes = Math.floor(timeLeft / 60);
        let seconds = timeLeft % 60;
        
        // Hiển thị thời gian
        document.getElementById('timeLeft').textContent = 
            minutes.toString().padStart(2, '0') + ':' + 
            seconds.toString().padStart(2, '0');
        
        // Nếu hết thời gian
        if (timeLeft <= 0) {
            clearInterval(timer);
            alert('Hết thời gian làm bài!');
            document.getElementById('examForm').submit();
        }
    }, 1000);
});
</script>
@endpush
@endsection 