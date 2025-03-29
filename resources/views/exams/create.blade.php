@extends('layouts.app')

@section('title', 'Thêm Bài Thi Mới')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h2 class="mb-0">Thêm Bài Thi Mới</h2>
            </div>
            <div class="card-body">
                <form action="{{ route('exams.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="category_id" class="form-label">Chủ Đề</label>
                        <select class="form-select @error('category_id') is-invalid @enderror" 
                                id="category_id" name="category_id" required>
                            <option value="">Chọn chủ đề</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->category_id }}" {{ old('category_id') == $category->category_id ? 'selected' : '' }}>
                                    {{ $category->category_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="exam_name" class="form-label">Tên Bài Thi</label>
                        <input type="text" class="form-control @error('exam_name') is-invalid @enderror" 
                               id="exam_name" name="exam_name" value="{{ old('exam_name') }}" required>
                        @error('exam_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Mô Tả</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" name="description" rows="3">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="duration" class="form-label">Thời Gian (phút)</label>
                                <input type="number" class="form-control @error('duration') is-invalid @enderror" 
                                       id="duration" name="duration" value="{{ old('duration', 30) }}" min="1" required>
                                @error('duration')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="total_marks" class="form-label">Tổng Điểm</label>
                                <input type="number" class="form-control @error('total_marks') is-invalid @enderror" 
                                       id="total_marks" name="total_marks" value="{{ old('total_marks', 10) }}" min="1" required>
                                @error('total_marks')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="passing_marks" class="form-label">Điểm Đạt</label>
                                <input type="number" class="form-control @error('passing_marks') is-invalid @enderror" 
                                       id="passing_marks" name="passing_marks" value="{{ old('passing_marks', 5) }}" min="1" required>
                                @error('passing_marks')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="is_active" class="form-label">Trạng Thái</label>
                                <select class="form-select @error('is_active') is-invalid @enderror" 
                                        id="is_active" name="is_active" required>
                                    <option value="1" {{ old('is_active', 1) == 1 ? 'selected' : '' }}>Đang Mở</option>
                                    <option value="0" {{ old('is_active') == 0 ? 'selected' : '' }}>Đã Đóng</option>
                                </select>
                                @error('is_active')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Câu Hỏi</label>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>Câu Hỏi</th>
                                        <th>Độ Khó</th>
                                        <th>Điểm Số</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($questions as $question)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $question->question_text }}</td>
                                            <td>
                                                <span class="badge bg-{{ $question->difficulty_level === 'easy' ? 'success' : ($question->difficulty_level === 'medium' ? 'warning' : 'danger') }}">
                                                    {{ ucfirst($question->difficulty_level) }}
                                                </span>
                                            </td>
                                            <td>{{ $question->marks }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('exams.index') }}" class="btn btn-secondary">Quay Lại</a>
                        <button type="submit" class="btn btn-primary">Thêm Bài Thi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection 