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
                            <label for="name" class="form-label">Tên Ngân Hàng</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name', $examBank->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="category_ids" class="form-label">Danh Mục</label>
                            <select class="form-select @error('category_ids') is-invalid @enderror" 
                                    id="category_ids" name="category_ids[]" multiple required>
                                @foreach($categories as $category)
                                    <option value="{{ $category->category_id }}" 
                                            {{ in_array($category->category_id, old('category_ids', $examBank->categories->pluck('category_id')->toArray())) ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_ids')
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

                <div class="mb-3">
                    <label class="form-label">Câu Hỏi</label>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th style="width: 50px">
                                        <input type="checkbox" id="select-all">
                                    </th>
                                    <th>Nội Dung Câu Hỏi</th>
                                    <th>Độ Khó</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($questions as $question)
                                    <tr>
                                        <td>
                                            <input type="checkbox" name="questions[]" value="{{ $question->question_id }}"
                                                   {{ in_array($question->question_id, old('questions', $examBank->questions->pluck('question_id')->toArray())) ? 'checked' : '' }}>
                                        </td>
                                        <td>{{ $question->question_text }}</td>
                                        <td>
                                            <span class="badge bg-{{ $question->difficulty_level === 'easy' ? 'success' : ($question->difficulty_level === 'medium' ? 'warning' : 'danger') }}">
                                                {{ ucfirst($question->difficulty_level) }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @error('questions')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
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

@push('scripts')
<script>
    document.getElementById('select-all').addEventListener('change', function() {
        var checkboxes = document.getElementsByName('questions[]');
        for (var checkbox of checkboxes) {
            checkbox.checked = this.checked;
        }
    });
</script>
@endpush
@endsection 