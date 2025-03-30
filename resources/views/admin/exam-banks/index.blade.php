@extends('layouts.admin')

@section('title', 'Quản Lý Ngân Hàng Câu Hỏi')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Quản Lý Ngân Hàng Câu Hỏi</h1>
        <a href="{{ route('admin.exam-banks.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Thêm Ngân Hàng Mới
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
                            <th>Tên Ngân Hàng</th>
                            <th>Danh Mục</th>
                            <th>Độ Khó</th>
                            <th>Số Câu Hỏi</th>
                            <th>Thao Tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($examBanks as $bank)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $bank->bank_name }}</td>
                                <td>{{ $bank->category->category_name }}</td>
                                <td>
                                    <span class="badge bg-{{ $bank->difficulty_level === 'easy' ? 'success' : ($bank->difficulty_level === 'medium' ? 'warning' : 'danger') }}">
                                        {{ ucfirst($bank->difficulty_level) }}
                                    </span>
                                </td>
                                <td>{{ $bank->total_questions }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.exam-banks.edit', $bank) }}" class="btn btn-primary btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.exam-banks.destroy', $bank) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" 
                                                    onclick="return confirm('Bạn có chắc chắn muốn xóa ngân hàng câu hỏi này?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Chưa có ngân hàng câu hỏi nào</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $examBanks->links() }}
    </div>
</div>
@endsection 