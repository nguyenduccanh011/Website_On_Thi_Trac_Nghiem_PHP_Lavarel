@extends('layouts.app')

@section('title', 'Chỉnh Sửa Bài Thi')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h2 class="mb-0">Chỉnh Sửa Bài Thi</h2>
            </div>
            <div class="card-body">
                <form action="{{ route('exams.update', $exam) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="subject_id" class="form-label">Môn Học</label>
                        <select class="form-select @error('subject_id') is-invalid @enderror" 
                                id="subject_id" name="subject_id" required>
                            <option value="">Chọn môn học</option>
                            @foreach($subjects as $subject)
                                <option value="{{ $subject->subject_id }}" 
                                        {{ old('subject_id', $exam->subject_id) == $subject->subject_id ? 'selected' : '' }}>
                                    {{ $subject->subject_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('subject_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="exam_name" class="form-label">Tên Bài Thi</label>
                        <input type="text" class="form-control @error('exam_name') is-invalid @enderror" 
                               id="exam_name" name="exam_name" value="{{ old('exam_name', $exam->exam_name) }}" required>
                        @error('exam_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Mô Tả</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" name="description" rows="3">{{ old('description', $exam->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="duration" class="form-label">Thời Gian (phút)</label>
                                <input type="number" class="form-control @error('duration') is-invalid @enderror" 
                                       id="duration" name="duration" value="{{ old('duration', $exam->duration) }}" min="1" required>
                                @error('duration')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="total_marks" class="form-label">Tổng Điểm</label>
                                <input type="number" class="form-control @error('total_marks') is-invalid @enderror" 
                                       id="total_marks" name="total_marks" value="{{ old('total_marks', $exam->total_marks) }}" min="1" required>
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
                                       id="passing_marks" name="passing_marks" value="{{ old('passing_marks', $exam->passing_marks) }}" min="1" required>
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
                                    <option value="1" {{ old('is_active', $exam->is_active) == 1 ? 'selected' : '' }}>Đang Mở</option>
                                    <option value="0" {{ old('is_active', $exam->is_active) == 0 ? 'selected' : '' }}>Đã Đóng</option>
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
                                    @foreach($exam->questions as $question)
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
                        <a href="{{ route('exams.show', $exam) }}" class="btn btn-secondary">Quay Lại</a>
                        <button type="submit" class="btn btn-primary">Cập Nhật</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection 