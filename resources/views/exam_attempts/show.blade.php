@extends('layouts.app')

@section('title', 'Làm Bài Thi')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">{{ $attempt->exam->exam_name }}</h4>
                    <div class="h5 mb-0">
                        ⏰ Thời gian còn lại: <span id="timeLeft" class="fw-bold">--:--</span>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('exam-attempts.submit', $attempt) }}" method="POST" id="examForm">
                        @csrf
                        @foreach($attempt->exam->questions as $index => $question)
                            <div class="mb-4">
                                <h5 class="mb-2">Câu {{ $index + 1 }}:</h5>
                                <p class="mb-3">{{ $question -> question_text}}</p>

                                {{-- Không dùng input hidden, xử lý mặc định bằng JS --}}
                                <div class="answer-group" data-question-id="{{ $question -> id }}">
                                    @foreach(['A', 'B', 'C', 'D'] as $option)
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="radio"
                                                name="answers[{{ $question -> id }}]"
                                                id="option_{{ $question -> id }}"
                                                value="{{ $option }}">
                                            <label class="form-check-label" for="option_{{ $question -> id }}_{{ $option }}">
                                                {{ $option }}. {{ $question->{'option_' . strtolower($option)} }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <hr>
                        @endforeach

                        <div class="d-flex justify-content-between mt-4">
                            <button type="button" class="btn btn-outline-secondary" onclick="history.back()">⬅ Quay Lại</button>
                            <button type="submit" class="btn btn-success" onclick="return confirm('Bạn có chắc chắn muốn nộp bài?')">
                                ✅ Nộp Bài
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Thiết lập đồng hồ đếm ngược
    let timeLeft = {{ $attempt->exam->duration * 60 }};
    const timerDisplay = document.getElementById('timeLeft');
    const examForm = document.getElementById('examForm');

    function updateTimer() {
        const minutes = Math.floor(timeLeft / 60);
        const seconds = timeLeft % 60;
        timerDisplay.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;

        if (timeLeft <= 0) {
            alert('Hết thời gian! Bài làm sẽ được nộp tự động.');
            examForm.submit();
        } else {
            timeLeft--;
            setTimeout(updateTimer, 1000);
        }
    }

    updateTimer();

    // Thêm input no_answer cho các câu chưa chọn khi submit
    examForm.addEventListener('submit', function (e) {
        const answerGroups = document.querySelectorAll('.answer-group');
        answerGroups.forEach(group => {
            const qid = group.getAttribute('data-question-id');
            const selected = group.querySelector('input[type=radio]:checked');
            if (!selected) {
                const hidden = document.createElement('input');
                hidden.type = 'hidden';
                hidden.name = `answers[${qid}]`;
                hidden.value = 'no_answer';
                examForm.appendChild(hidden);
            }
        });
    });
</script>
@endpush
