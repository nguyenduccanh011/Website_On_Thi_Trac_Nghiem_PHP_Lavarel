@extends('layouts.app')

@section('title', 'Trang Chủ')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1 class="mb-4">Bài Thi Mới Nhất</h1>
        </div>
    </div>

    <div class="row">
        @foreach($exams as $exam)
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
        @endforeach
    </div>
</div>
@endsection 