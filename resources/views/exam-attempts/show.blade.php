@extends('layouts.app')

@section('title', 'Chi Tiết Bài Thi')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">{{ $exam->title }}</h4>
                        <div class="text-end">
                            <div class="badge bg-primary">Thời gian còn lại: <span id="timer">00:00</span></div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <form id="examForm" action="{{ route('exam-attempts.submit', $examAttempt->id) }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <h5>Hướng dẫn:</h5>
                            <ul>
                                <li>Bạn có {{ $exam->duration }} phút để hoàn thành bài thi</li>
                                <li>Mỗi câu hỏi chỉ có một đáp án đúng</li>
                                <li>Bạn có thể điều hướng giữa các câu hỏi bằng nút "Câu trước" và "Câu sau"</li>
                                <li>Đảm bảo nộp bài trước khi hết thời gian</li>
                            </ul>
                        </div>

                        <div class="questions">
                            @foreach($questions as $question)
                            <div class="question-block" id="question_{{ $question->id }}" style="display: none;">
                                <div class="mb-4">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <h5 class="mb-0">Câu {{ $loop->iteration }}</h5>
                                        <span class="badge bg-{{ $question->difficulty_level === 'easy' ? 'success' : ($question->difficulty_level === 'medium' ? 'warning' : 'danger') }}">
                                            {{ ucfirst($question->difficulty_level) }}
                                        </span>
                                    </div>
                                    <p class="mb-3">{{ $question->question_text }}</p>
                                    
                                    <div class="options">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="radio" 
                                                   name="answers[{{ $question->id }}]" 
                                                   id="option_a_{{ $question->id }}" 
                                                   value="A"
                                                   {{ isset($userAnswers[$question->id]) && $userAnswers[$question->id] === 'A' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="option_a_{{ $question->id }}">
                                                A. {{ $question->option_a }}
                                            </label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="radio" 
                                                   name="answers[{{ $question->id }}]" 
                                                   id="option_b_{{ $question->id }}" 
                                                   value="B"
                                                   {{ isset($userAnswers[$question->id]) && $userAnswers[$question->id] === 'B' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="option_b_{{ $question->id }}">
                                                B. {{ $question->option_b }}
                                            </label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="radio" 
                                                   name="answers[{{ $question->id }}]" 
                                                   id="option_c_{{ $question->id }}" 
                                                   value="C"
                                                   {{ isset($userAnswers[$question->id]) && $userAnswers[$question->id] === 'C' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="option_c_{{ $question->id }}">
                                                C. {{ $question->option_c }}
                                            </label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="radio" 
                                                   name="answers[{{ $question->id }}]" 
                                                   id="option_d_{{ $question->id }}" 
                                                   value="D"
                                                   {{ isset($userAnswers[$question->id]) && $userAnswers[$question->id] === 'D' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="option_d_{{ $question->id }}">
                                                D. {{ $question->option_d }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <button type="button" class="btn btn-secondary" id="prevQuestion" style="display: none;">Câu trước</button>
                            <button type="button" class="btn btn-primary" id="nextQuestion">Câu sau</button>
                        </div>

                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-success">Nộp bài</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const questions = document.querySelectorAll('.question-block');
    const prevBtn = document.getElementById('prevQuestion');
    const nextBtn = document.getElementById('nextQuestion');
    let currentQuestion = 0;

    // Lưu trữ đáp án đã chọn
    const answers = {};

    function showQuestion(index) {
        questions.forEach(q => q.style.display = 'none');
        questions[index].style.display = 'block';
        
        prevBtn.style.display = index === 0 ? 'none' : 'block';
        nextBtn.style.display = index === questions.length - 1 ? 'none' : 'block';

        // Khôi phục đáp án đã chọn cho câu hỏi hiện tại
        const currentQuestionId = questions[index].id.split('_')[1];
        if (answers[currentQuestionId]) {
            const radioButton = document.querySelector(`input[name="answers[${currentQuestionId}]"][value="${answers[currentQuestionId]}"]`);
            if (radioButton) {
                radioButton.checked = true;
            }
        }
    }

    // Lưu đáp án khi chọn
    questions.forEach(question => {
        const questionId = question.id.split('_')[1];
        const radioButtons = question.querySelectorAll('input[type="radio"]');
        radioButtons.forEach(radio => {
            radio.addEventListener('change', function() {
                answers[questionId] = this.value;
            });
        });
    });

    prevBtn.addEventListener('click', () => {
        if (currentQuestion > 0) {
            currentQuestion--;
            showQuestion(currentQuestion);
        }
    });

    nextBtn.addEventListener('click', () => {
        if (currentQuestion < questions.length - 1) {
            currentQuestion++;
            showQuestion(currentQuestion);
        }
    });

    // Hiển thị câu hỏi đầu tiên
    showQuestion(0);

    // Xử lý nộp bài
    const form = document.getElementById('examForm');
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Kiểm tra xem đã trả lời hết các câu hỏi chưa
        const unansweredQuestions = [];
        questions.forEach((q, index) => {
            const questionId = q.id.split('_')[1];
            if (!answers[questionId]) {
                unansweredQuestions.push(index + 1);
            }
        });

        if (unansweredQuestions.length > 0) {
            if (confirm(`Bạn chưa trả lời các câu hỏi sau: ${unansweredQuestions.join(', ')}. Bạn có muốn nộp bài không?`)) {
                this.submit();
            }
        } else {
            if (confirm('Bạn có chắc chắn muốn nộp bài?')) {
                this.submit();
            }
        }
    });
});
</script>
@endpush
@endsection 