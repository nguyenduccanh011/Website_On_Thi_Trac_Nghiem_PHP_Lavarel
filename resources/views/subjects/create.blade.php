@extends('layouts.app')

@section('title', 'Thêm Môn Học Mới')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h2 class="mb-0">Thêm Môn Học Mới</h2>
            </div>
            <div class="card-body">
                <form action="{{ route('subjects.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="subject_name" class="form-label">Tên Môn Học</label>
                        <input type="text" class="form-control @error('subject_name') is-invalid @enderror" 
                               id="subject_name" name="subject_name" value="{{ old('subject_name') }}" required>
                        @error('subject_name')
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

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('subjects.index') }}" class="btn btn-secondary">Quay Lại</a>
                        <button type="submit" class="btn btn-primary">Thêm Môn Học</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection 