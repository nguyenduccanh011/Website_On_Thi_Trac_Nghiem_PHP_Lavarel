@extends('layouts.app')

@section('title', 'Làm Bài Thi')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">{{ $attempt->exam->exam_name }}</h4>
                        <div class="h5 mb-0">Thời gian còn lại: <span id="timeLeft">{{ $attempt->exam->duration * 60 }}</span></div>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('exam-attempts.submit', $attempt) }}" method="POST" id="examForm">
                        @csrf
                        @foreach($attempt->exam->questions as $index => $question)
                            <div class="card mb-4">
                                <div class="card-body">
                                    <h5 class="card-title">Câu {{ $index + 1 }}</h5>
                                    <p class="card-text">{{ $question->question_text }}</p>

                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" 
                                               name="answers[{{ $question->question_id }}]" 
                                               id="option_a_{{ $question->question_id }}" 
                                               value="A" required>
                                        <label class="form-check-label" for="option_a_{{ $question->question_id }}">
                                            A. {{ $question->option_a }}
                                        </label>
                                    </div>

                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" 
                                               name="answers[{{ $question->question_id }}]" 
                                               id="option_b_{{ $question->question_id }}" 
                                               value="B">
                                        <label class="form-check-label" for="option_b_{{ $question->question_id }}">
                                            B. {{ $question->option_b }}
                                        </label>
                                    </div>

                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" 
                                               name="answers[{{ $question->question_id }}]" 
                                               id="option_c_{{ $question->question_id }}" 
                                               value="C">
                                        <label class="form-check-label" for="option_c_{{ $question->question_id }}">
                                            C. {{ $question->option_c }}
                                        </label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" 
                                               name="answers[{{ $question->question_id }}]" 
                                               id="option_d_{{ $question->question_id }}" 
                                               value="D">
                                        <label class="form-check-label" for="option_d_{{ $question->question_id }}">
                                            D. {{ $question->option_d }}
                                        </label>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        <div class="d-flex justify-content-between">
                            <button type="button" class="btn btn-secondary" onclick="history.back()">Quay Lại</button>
                            <button type="submit" class="btn btn-primary" onclick="return confirm('Bạn có chắc chắn muốn nộp bài?')">
                                Nộp Bài
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Thiết lập thời gian làm bài
    let timeLeft = {{ $attempt->exam->duration * 60 }}; // Chuyển đổi phút sang giây
    const timerDisplay = document.getElementById('timeLeft');
    const examForm = document.getElementById('examForm');

    function updateTimer() {
        const minutes = Math.floor(timeLeft / 60);
        const seconds = timeLeft % 60;
        timerDisplay.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;

        if (timeLeft === 0) {
            examForm.submit();
        } else {
            timeLeft--;
            setTimeout(updateTimer, 1000);
        }
    }

    updateTimer();
</script>
@endpush
@endsection 