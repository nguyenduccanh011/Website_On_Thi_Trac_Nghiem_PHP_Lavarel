@extends('layouts.admin')

@section('title', 'Thêm Câu Hỏi Mới')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Thêm Câu Hỏi Mới</h1>
        <a href="{{ route('admin.questions.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Quay Lại
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.questions.store') }}" method="POST">
                @csrf
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="difficulty_level" class="form-label">Độ Khó</label>
                            <select class="form-select @error('difficulty_level') is-invalid @enderror" 
                                    id="difficulty_level" name="difficulty_level" required>
                                <option value="">Chọn Độ Khó</option>
                                <option value="easy" {{ old('difficulty_level') == 'easy' ? 'selected' : '' }}>Dễ</option>
                                <option value="medium" {{ old('difficulty_level') == 'medium' ? 'selected' : '' }}>Trung Bình</option>
                                <option value="hard" {{ old('difficulty_level') == 'hard' ? 'selected' : '' }}>Khó</option>
                            </select>
                            @error('difficulty_level')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="correct_answer" class="form-label">Đáp Án Đúng</label>
                            <select class="form-select @error('correct_answer') is-invalid @enderror" 
                                    id="correct_answer" name="correct_answer" required>
                                <option value="">Chọn Đáp Án</option>
                                <option value="A" {{ old('correct_answer') == 'A' ? 'selected' : '' }}>A</option>
                                <option value="B" {{ old('correct_answer') == 'B' ? 'selected' : '' }}>B</option>
                                <option value="C" {{ old('correct_answer') == 'C' ? 'selected' : '' }}>C</option>
                                <option value="D" {{ old('correct_answer') == 'D' ? 'selected' : '' }}>D</option>
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
                              id="question_text" name="question_text" rows="3" required>{{ old('question_text') }}</textarea>
                    @error('question_text')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="option_a" class="form-label">Lựa Chọn A</label>
                            <input type="text" class="form-control @error('option_a') is-invalid @enderror" 
                                   id="option_a" name="option_a" value="{{ old('option_a') }}" required>
                            @error('option_a')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="option_b" class="form-label">Lựa Chọn B</label>
                            <input type="text" class="form-control @error('option_b') is-invalid @enderror" 
                                   id="option_b" name="option_b" value="{{ old('option_b') }}" required>
                            @error('option_b')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="option_c" class="form-label">Lựa Chọn C</label>
                            <input type="text" class="form-control @error('option_c') is-invalid @enderror" 
                                   id="option_c" name="option_c" value="{{ old('option_c') }}" required>
                            @error('option_c')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="option_d" class="form-label">Lựa Chọn D</label>
                            <input type="text" class="form-control @error('option_d') is-invalid @enderror" 
                                   id="option_d" name="option_d" value="{{ old('option_d') }}" required>
                            @error('option_d')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="explanation" class="form-label">Giải Thích</label>
                    <textarea class="form-control @error('explanation') is-invalid @enderror" 
                              id="explanation" name="explanation" rows="3">{{ old('explanation') }}</textarea>
                    @error('explanation')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Lưu Câu Hỏi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 