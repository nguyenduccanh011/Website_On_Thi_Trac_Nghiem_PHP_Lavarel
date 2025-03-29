@extends('layouts.app')

@section('title', 'Chi Tiết Câu Hỏi')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h2 class="mb-0">Chi Tiết Câu Hỏi</h2>
                <div>
                    <a href="{{ route('questions.edit', $question) }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-edit"></i> Chỉnh Sửa
                    </a>
                    <a href="{{ route('questions.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> Quay Lại
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="mb-4">
                    <h5 class="card-title">Thông Tin Chung</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Môn Học:</strong> {{ $question->subject->subject_name }}</p>
                            <p><strong>Độ Khó:</strong> 
                                <span class="badge bg-{{ $question->difficulty_level === 'easy' ? 'success' : ($question->difficulty_level === 'medium' ? 'warning' : 'danger') }}">
                                    {{ ucfirst($question->difficulty_level) }}
                                </span>
                            </p>
                            <p><strong>Điểm Số:</strong> {{ $question->marks }}</p>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <h5 class="card-title">Nội Dung Câu Hỏi</h5>
                    <p class="card-text">{{ $question->question_text }}</p>
                </div>

                <div class="mb-4">
                    <h5 class="card-title">Các Đáp Án</h5>
                    <div class="list-group">
                        <div class="list-group-item {{ $question->correct_answer === 'A' ? 'list-group-item-success' : '' }}">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>A.</strong> {{ $question->option_a }}
                                    @if($question->correct_answer === 'A')
                                        <span class="badge bg-success ms-2">Đáp Án Đúng</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item {{ $question->correct_answer === 'B' ? 'list-group-item-success' : '' }}">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>B.</strong> {{ $question->option_b }}
                                    @if($question->correct_answer === 'B')
                                        <span class="badge bg-success ms-2">Đáp Án Đúng</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item {{ $question->correct_answer === 'C' ? 'list-group-item-success' : '' }}">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>C.</strong> {{ $question->option_c }}
                                    @if($question->correct_answer === 'C')
                                        <span class="badge bg-success ms-2">Đáp Án Đúng</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item {{ $question->correct_answer === 'D' ? 'list-group-item-success' : '' }}">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>D.</strong> {{ $question->option_d }}
                                    @if($question->correct_answer === 'D')
                                        <span class="badge bg-success ms-2">Đáp Án Đúng</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @if($question->explanation)
                    <div class="mb-4">
                        <h5 class="card-title">Giải Thích</h5>
                        <p class="card-text">{{ $question->explanation }}</p>
                    </div>
                @endif

                <div class="d-flex justify-content-between">
                    <form action="{{ route('questions.destroy', $question) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" 
                                onclick="return confirm('Bạn có chắc chắn muốn xóa câu hỏi này?')">
                            <i class="fas fa-trash"></i> Xóa Câu Hỏi
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 