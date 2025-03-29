@extends('layouts.app')

@section('title', 'Danh Sách Người Dùng')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Danh Sách Người Dùng</h1>
    <a href="{{ route('users.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Thêm Người Dùng Mới
    </a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Tên</th>
                        <th>Email</th>
                        <th>Vai Trò</th>
                        <th>Số Lần Làm Bài</th>
                        <th>Điểm Trung Bình</th>
                        <th>Trạng Thái</th>
                        <th>Thao Tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <span class="badge bg-{{ $user->is_admin ? 'danger' : 'primary' }}">
                                    {{ $user->is_admin ? 'Quản Trị Viên' : 'Người Dùng' }}
                                </span>
                            </td>
                            <td>{{ $user->attempts_count }}</td>
                            <td>
                                @if($user->attempts_count > 0)
                                    {{ number_format($user->average_score, 1) }}
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                @if($user->is_active)
                                    <span class="badge bg-success">Hoạt Động</span>
                                @else
                                    <span class="badge bg-danger">Đã Khóa</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('users.show', $user) }}" class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('users.edit', $user) }}" class="btn btn-primary btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('users.destroy', $user) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" 
                                                onclick="return confirm('Bạn có chắc chắn muốn xóa người dùng này?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">Chưa có người dùng nào</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="d-flex justify-content-center mt-4">
    {{ $users->links() }}
</div>
@endsection 