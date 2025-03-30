@extends('layouts.app')

@section('title', 'Chi Tiết Chủ Đề Thi')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Chi Tiết Chủ Đề Thi</h4>
                    <div>
                        <a href="{{ route('exam-categories.edit', $category) }}" class="btn btn-primary">
                            <i class="fas fa-edit"></i> Chỉnh Sửa
                        </a>
                        <a href="{{ route('exam-categories.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Quay Lại
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5>Thông Tin Chủ Đề</h5>
                            <table class="table">
                                <tr>
                                    <th>Tên Chủ Đề:</th>
                                    <td>{{ $category->name }}</td>
                                </tr>
                                <tr>
                                    <th>Mô Tả:</th>
                                    <td>{{ $category->description }}</td>
                                </tr>
                                <tr>
                                    <th>Số Bài Thi:</th>
                                    <td>{{ $category->exams->count() }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="mt-4">
                        <h5>Danh Sách Bài Thi</h5>
                        @if($category->exams->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>STT</th>
                                            <th>Tên Bài Thi</th>
                                            <th>Thời Gian</th>
                                            <th>Số Câu Hỏi</th>
                                            <th>Điểm Đạt</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($category->exams as $exam)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $exam->title }}</td>
                                                <td>{{ $exam->duration }} phút</td>
                                                <td>{{ $exam->questions->count() }}</td>
                                                <td>{{ $exam->passing_marks }}/{{ $exam->total_marks }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-center">Chưa có bài thi nào trong chủ đề này</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 