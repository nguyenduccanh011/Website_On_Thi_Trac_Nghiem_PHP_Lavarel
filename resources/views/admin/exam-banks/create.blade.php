@extends('layouts.admin')

@section('title', 'Thêm Ngân Hàng Câu Hỏi Mới')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Thêm Ngân Hàng Câu Hỏi Mới</h1>
        <a href="{{ route('admin.exam-banks.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Quay Lại
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.exam-banks.store') }}" method="POST">
                @csrf
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="bank_name" class="form-label">Tên Ngân Hàng</label>
                            <input type="text" class="form-control @error('bank_name') is-invalid @enderror" 
                                   id="bank_name" name="bank_name" value="{{ old('bank_name') }}" required>
                            @error('bank_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="category_id" class="form-label">Danh Mục</label>
                            <select class="form-select @error('category_id') is-invalid @enderror" 
                                    id="category_id" name="category_id" required>
                                <option value="">Chọn Danh Mục</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->category_id }}" {{ old('category_id') == $category->category_id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

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
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="total_questions" class="form-label">Số Câu Hỏi</label>
                            <input type="number" class="form-control @error('total_questions') is-invalid @enderror" 
                                   id="total_questions" name="total_questions" value="{{ old('total_questions') }}" required>
                            @error('total_questions')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Mô Tả</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" 
                              id="description" name="description" rows="3">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Chọn Câu Hỏi</label>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th style="width: 50px;">Chọn</th>
                                    <th>Câu Hỏi</th>
                                    <th>Độ Khó</th>
                                    <th>Đáp Án Đúng</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($questions as $question)
                                    <tr>
                                        <td>
                                            <div class="form-check">
                                                <input class="form-check-input question-checkbox" type="checkbox" 
                                                       name="questions[]" value="{{ $question->question_id }}"
                                                       {{ in_array($question->question_id, old('questions', [])) ? 'checked' : '' }}>
                                            </div>
                                        </td>
                                        <td>{{ $question->question_text }}</td>
                                        <td>
                                            <span class="badge bg-{{ $question->difficulty_level === 'easy' ? 'success' : ($question->difficulty_level === 'medium' ? 'warning' : 'danger') }}">
                                                {{ ucfirst($question->difficulty_level) }}
                                            </span>
                                        </td>
                                        <td>{{ $question->correct_answer }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @error('questions')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Lưu Ngân Hàng
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 