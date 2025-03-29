@extends('layouts.app')

@section('title', 'Chỉnh Sửa Người Dùng')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h2 class="mb-0">Chỉnh Sửa Người Dùng</h2>
            </div>
            <div class="card-body">
                <form action="{{ route('users.update', $user) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="name" class="form-label">Họ Tên</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               id="name" name="name" value="{{ old('name', $user->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                               id="email" name="email" value="{{ old('email', $user->email) }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Mật Khẩu Mới</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" 
                               id="password" name="password">
                        <small class="text-muted">Để trống nếu không muốn thay đổi mật khẩu</small>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Xác Nhận Mật Khẩu Mới</label>
                        <input type="password" class="form-control" 
                               id="password_confirmation" name="password_confirmation">
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input @error('is_admin') is-invalid @enderror" 
                                   id="is_admin" name="is_admin" value="1" {{ old('is_admin', $user->is_admin) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_admin">Quản Trị Viên</label>
                            @error('is_admin')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input @error('is_active') is-invalid @enderror" 
                                   id="is_active" name="is_active" value="1" {{ old('is_active', $user->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">Tài Khoản Hoạt Động</label>
                            @error('is_active')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('users.show', $user) }}" class="btn btn-secondary">Quay Lại</a>
                        <button type="submit" class="btn btn-primary">Cập Nhật</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection 