@extends('layouts.admin')

@section('title', 'Chỉnh Sửa Ngân Hàng Câu Hỏi')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Chỉnh Sửa Ngân Hàng Câu Hỏi</h1>
        <a href="{{ route('admin.exam-banks.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Quay Lại
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.exam-banks.update', $examBank) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="bank_name" class="form-label">Tên Ngân Hàng</label>
                            <input type="text" class="form-control @error('bank_name') is-invalid @enderror" 
                                   id="bank_name" name="bank_name" value="{{ old('bank_name', $examBank->bank_name) }}" required>
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
                                    <option value="{{ $category->id }}" 
                                            {{ old('category_id', $examBank->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->category_name }}
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
                                <option value="easy" {{ old('difficulty_level', $examBank->difficulty_level) == 'easy' ? 'selected' : '' }}>Dễ</option>
                                <option value="medium" {{ old('difficulty_level', $examBank->difficulty_level) == 'medium' ? 'selected' : '' }}>Trung Bình</option>
                                <option value="hard" {{ old('difficulty_level', $examBank->difficulty_level) == 'hard' ? 'selected' : '' }}>Khó</option>
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
                                   id="total_questions" name="total_questions" value="{{ old('total_questions', $examBank->total_questions) }}" required>
                            @error('total_questions')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Mô Tả</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" 
                              id="description" name="description" rows="3">{{ old('description', $examBank->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Cập Nhật Ngân Hàng
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 