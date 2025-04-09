@extends('layouts.app')

@section('title', 'Trang Chủ')

@section('content')
<div class="container">
    {{-- Form tìm kiếm và lọc --}}
    <div class="row mb-4">
        <div class="col-md-12">
            <form method="GET" action="{{ route('home') }}" class="row g-2 align-items-center">
                <div class="col-md-5">
                    <input type="text" name="search" class="form-control" placeholder="Tìm kiếm bài thi..." value="{{ request('search') }}">
                </div>
                <div class="col-md-4">
                    <select name="category" class="form-select">
                        <option value="">Tất cả chủ đề</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->category_id }}" {{ request('category') == $category->category_id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary w-100">Tìm kiếm & Lọc</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Tiêu đề --}}
    <div class="row">
        <div class="col-md-12">
            <h1 class="mb-4">Bài Thi Mới Nhất</h1>
        </div>
    </div>

    {{-- Danh sách bài thi --}}
    <div class="row">
        @forelse($exams as $exam)
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">{{ $exam->title }}</h5>
                        <p class="card-text">{{ $exam->description }}</p>
                        <ul class="list-unstyled">
                            <li><strong>Chủ đề:</strong> {{ $exam->category->name }}</li>
                            <li><strong>Thời gian:</strong> {{ $exam->duration }} phút</li>
                            <li><strong>Số câu hỏi:</strong> {{ $exam->questions->count() }}</li>
                            <li><strong>Điểm đạt:</strong> {{ $exam->passing_marks }}/{{ $exam->total_marks }}</li>
                        </ul>
                        <a href="{{ route('exams.show', $exam) }}" class="btn btn-primary">Xem Chi Tiết</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <p class="text-muted">Không tìm thấy bài thi nào phù hợp với điều kiện lọc.</p>
            </div>
        @endforelse
    </div>

    {{-- Phân trang --}}
    @if($exams->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $exams->links() }} 
        </div>
    @endif
</div>
@endsection
