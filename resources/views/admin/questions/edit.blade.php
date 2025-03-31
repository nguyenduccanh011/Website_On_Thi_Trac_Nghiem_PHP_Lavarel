@extends('layouts.admin')

@section('title', 'Chỉnh Sửa Câu Hỏi')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Chỉnh Sửa Câu Hỏi</h1>
        <a href="{{ route('admin.questions.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Quay Lại
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.questions.update', $question) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="exam_id" class="form-label">Đề Thi</label>
                            <select class="form-select @error('exam_id') is-invalid @enderror" 
                                    id="exam_id" name="exam_id" required>
                                <option value="">Chọn Đề Thi</option>
                                @foreach($exams as $exam)
                                    <option value="{{ $exam->exam_id }}" 
                                            {{ old('exam_id', $question->exam_id) == $exam->exam_id ? 'selected' : '' }}>
                                        {{ $exam->title }}
                                    </option>
                                @endforeach
                            </select>
                            @error('exam_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="marks" class="form-label">Điểm</label>
                            <input type="number" class="form-control @error('marks') is-invalid @enderror" 
                                   id="marks" name="marks" value="{{ old('marks', $question->marks) }}" required>
                            @error('marks')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="correct_answer" class="form-label">Đáp Án Đúng</label>
                            <select class="form-select @error('correct_answer') is-invalid @enderror" 
                                    id="correct_answer" name="correct_answer" required>
                                <option value="">Chọn Đáp Án</option>
                                <option value="A" {{ old('correct_answer', $question->correct_answer) == 'A' ? 'selected' : '' }}>A</option>
                                <option value="B" {{ old('correct_answer', $question->correct_answer) == 'B' ? 'selected' : '' }}>B</option>
                                <option value="C" {{ old('correct_answer', $question->correct_answer) == 'C' ? 'selected' : '' }}>C</option>
                                <option value="D" {{ old('correct_answer', $question->correct_answer) == 'D' ? 'selected' : '' }}>D</option>
                            </select>
                            @error('correct_answer')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="question_text" class="form-label">Nội Dung Câu Hỏi</label>
                    <textarea class="form-control @error('question_text') is-invalid @enderror" 
                              id="question_text" name="question_text" rows="3" required>{{ old('question_text', $question->question_text) }}</textarea>
                    @error('question_text')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="option_a" class="form-label">Lựa Chọn A</label>
                            <input type="text" class="form-control @error('option_a') is-invalid @enderror" 
                                   id="option_a" name="option_a" value="{{ old('option_a', $question->option_a) }}" required>
                            @error('option_a')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="option_b" class="form-label">Lựa Chọn B</label>
                            <input type="text" class="form-control @error('option_b') is-invalid @enderror" 
                                   id="option_b" name="option_b" value="{{ old('option_b', $question->option_b) }}" required>
                            @error('option_b')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="option_c" class="form-label">Lựa Chọn C</label>
                            <input type="text" class="form-control @error('option_c') is-invalid @enderror" 
                                   id="option_c" name="option_c" value="{{ old('option_c', $question->option_c) }}" required>
                            @error('option_c')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="option_d" class="form-label">Lựa Chọn D</label>
                            <input type="text" class="form-control @error('option_d') is-invalid @enderror" 
                                   id="option_d" name="option_d" value="{{ old('option_d', $question->option_d) }}" required>
                            @error('option_d')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="explanation" class="form-label">Giải Thích</label>
                    <textarea class="form-control @error('explanation') is-invalid @enderror" 
                              id="explanation" name="explanation" rows="3">{{ old('explanation', $question->explanation) }}</textarea>
                    @error('explanation')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Cập Nhật Câu Hỏi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 