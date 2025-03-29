@extends('layouts.app')

@section('title', 'Danh Sách Câu Hỏi')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Danh Sách Câu Hỏi</h1>
    <a href="{{ route('questions.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Thêm Câu Hỏi Mới
    </a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Nội Dung</th>
                        <th>Môn Học</th>
                        <th>Độ Khó</th>
                        <th>Điểm Số</th>
                        <th>Đáp Án Đúng</th>
                        <th>Thao Tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($questions as $question)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ Str::limit($question->question_text, 100) }}</td>
                            <td>{{ $question->subject->subject_name }}</td>
                            <td>
                                <span class="badge bg-{{ $question->difficulty_level === 'easy' ? 'success' : ($question->difficulty_level === 'medium' ? 'warning' : 'danger') }}">
                                    {{ ucfirst($question->difficulty_level) }}
                                </span>
                            </td>
                            <td>{{ $question->marks }}</td>
                            <td>{{ $question->correct_answer }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('questions.show', $question) }}" class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('questions.edit', $question) }}" class="btn btn-primary btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('questions.destroy', $question) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" 
                                                onclick="return confirm('Bạn có chắc chắn muốn xóa câu hỏi này?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">Chưa có câu hỏi nào</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="d-flex justify-content-center mt-4">
    {{ $questions->links() }}
</div>
@endsection 