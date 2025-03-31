@extends('layouts.admin')

@section('title', 'Quản Lý Câu Hỏi')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Quản Lý Câu Hỏi</h1>
        <a href="{{ route('admin.questions.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Thêm Câu Hỏi Mới
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Câu Hỏi</th>
                            <th>Ngân Hàng</th>
                            <th>Điểm</th>
                            <th>Đáp Án</th>
                            <th>Thao Tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($questions as $question)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ Str::limit($question->question_text, 50) }}</td>
                                <td>{{ $question->examBank ? $question->examBank->name : 'Chưa phân loại' }}</td>
                                <td>{{ $question->marks }}</td>
                                <td>{{ $question->correct_answer }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.questions.edit', $question) }}" class="btn btn-primary btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.questions.destroy', $question) }}" method="POST" class="d-inline">
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
                                <td colspan="6" class="text-center">Chưa có câu hỏi nào</td>
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
</div>
@endsection 