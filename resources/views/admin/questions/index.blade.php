@extends('layouts.admin')

@section('title', 'Quản Lý Câu Hỏi')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Quản lý câu hỏi</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.questions.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Thêm câu hỏi mới
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Câu hỏi</th>
                                    <th>Ngân hàng đề</th>
                                    <th>Độ khó</th>
                                    <th>Trạng thái</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($questions as $question)
                                    <tr>
                                        <td>{{ $question->id }}</td>
                                        <td>{{ Str::limit($question->question_text, 100) }}</td>
                                        <td>{{ $question->examBank ? $question->examBank->name : 'N/A' }}</td>
                                        <td>
                                            <span class="badge badge-{{ 
                                                $question->difficulty_level === 'easy' ? 'success' : 
                                                ($question->difficulty_level === 'medium' ? 'warning' : 'danger') 
                                            }}">
                                                {{ ucfirst($question->difficulty_level) }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge badge-{{ $question->is_active ? 'success' : 'danger' }}">
                                                {{ $question->is_active ? 'Hoạt động' : 'Không hoạt động' }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.questions.edit', $question->id) }}" 
                                               class="btn btn-sm btn-info">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.questions.destroy', $question->id) }}" 
                                                  method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" 
                                                        onclick="return confirm('Bạn có chắc chắn muốn xóa câu hỏi này?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Không có câu hỏi nào</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">
                        {{ $questions->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 