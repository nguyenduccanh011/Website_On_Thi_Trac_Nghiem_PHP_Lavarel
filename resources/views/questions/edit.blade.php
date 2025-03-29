@extends('layouts.app')

@section('title', 'Chỉnh Sửa Câu Hỏi')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h2 class="mb-0">Chỉnh Sửa Câu Hỏi</h2>
            </div>
            <div class="card-body">
                <form action="{{ route('questions.update', $question) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="subject_id" class="form-label">Môn Học</label>
                        <select class="form-select @error('subject_id') is-invalid @enderror" 
                                id="subject_id" name="subject_id" required>
                            <option value="">Chọn môn học</option>
                            @foreach($subjects as $subject)
                                <option value="{{ $subject->subject_id }}" 
                                        {{ old('subject_id', $question->subject_id) == $subject->subject_id ? 'selected' : '' }}>
                                    {{ $subject->subject_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('subject_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="question_text" class="form-label">Nội Dung Câu Hỏi</label>
                        <textarea class="form-control @error('question_text') is-invalid @enderror" 
                                  id="question_text" name="question_text" rows="3" required>{{ old('question_text', $question->question_text) }}</textarea>
                        @error('question_text')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="option_a" class="form-label">Đáp Án A</label>
                        <input type="text" class="form-control @error('option_a') is-invalid @enderror" 
                               id="option_a" name="option_a" value="{{ old('option_a', $question->option_a) }}" required>
                        @error('option_a')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="option_b" class="form-label">Đáp Án B</label>
                        <input type="text" class="form-control @error('option_b') is-invalid @enderror" 
                               id="option_b" name="option_b" value="{{ old('option_b', $question->option_b) }}" required>
                        @error('option_b')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="option_c" class="form-label">Đáp Án C</label>
                        <input type="text" class="form-control @error('option_c') is-invalid @enderror" 
                               id="option_c" name="option_c" value="{{ old('option_c', $question->option_c) }}" required>
                        @error('option_c')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="option_d" class="form-label">Đáp Án D</label>
                        <input type="text" class="form-control @error('option_d') is-invalid @enderror" 
                               id="option_d" name="option_d" value="{{ old('option_d', $question->option_d) }}" required>
                        @error('option_d')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="correct_answer" class="form-label">Đáp Án Đúng</label>
                        <select class="form-select @error('correct_answer') is-invalid @enderror" 
                                id="correct_answer" name="correct_answer" required>
                            <option value="">Chọn đáp án đúng</option>
                            <option value="A" {{ old('correct_answer', $question->correct_answer) == 'A' ? 'selected' : '' }}>A</option>
                            <option value="B" {{ old('correct_answer', $question->correct_answer) == 'B' ? 'selected' : '' }}>B</option>
                            <option value="C" {{ old('correct_answer', $question->correct_answer) == 'C' ? 'selected' : '' }}>C</option>
                            <option value="D" {{ old('correct_answer', $question->correct_answer) == 'D' ? 'selected' : '' }}>D</option>
                        </select>
                        @error('correct_answer')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="difficulty_level" class="form-label">Độ Khó</label>
                        <select class="form-select @error('difficulty_level') is-invalid @enderror" 
                                id="difficulty_level" name="difficulty_level" required>
                            <option value="">Chọn độ khó</option>
                            <option value="easy" {{ old('difficulty_level', $question->difficulty_level) == 'easy' ? 'selected' : '' }}>Dễ</option>
                            <option value="medium" {{ old('difficulty_level', $question->difficulty_level) == 'medium' ? 'selected' : '' }}>Trung Bình</option>
                            <option value="hard" {{ old('difficulty_level', $question->difficulty_level) == 'hard' ? 'selected' : '' }}>Khó</option>
                        </select>
                        @error('difficulty_level')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="marks" class="form-label">Điểm Số</label>
                        <input type="number" class="form-control @error('marks') is-invalid @enderror" 
                               id="marks" name="marks" value="{{ old('marks', $question->marks) }}" min="1" required>
                        @error('marks')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('questions.show', $question) }}" class="btn btn-secondary">Quay Lại</a>
                        <button type="submit" class="btn btn-primary">Cập Nhật</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection 