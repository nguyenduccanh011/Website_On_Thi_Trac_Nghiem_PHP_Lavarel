@extends('layouts.app')

@section('title', 'Lịch Sử Thi')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-12">
            <h1>Lịch Sử Thi</h1>
            <p class="lead">Danh sách các bài thi bạn đã làm.</p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Đề Thi</th>
                                    <th>Danh Mục</th>
                                    <th>Thời Gian Bắt Đầu</th>
                                    <th>Thời Gian Nộp</th>
                                    <th>Điểm Số</th>
                                    <th>Trạng Thái</th>
                                    <th>Thao Tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($attempts as $attempt)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $attempt->exam->title }}</td>
                                        <td>{{ $attempt->exam->category->name }}</td>
                                        <td>{{ $attempt->start_time->format('d/m/Y H:i') }}</td>
                                        <td>
                                            @if($attempt->end_time)
                                                {{ $attempt->end_time->format('d/m/Y H:i') }}
                                            @else
                                                Chưa nộp
                                            @endif
                                        </td>
                                        <td>
                                            @if($attempt->score !== null)
                                                <span class="badge bg-{{ $attempt->score >= $attempt->exam->passing_marks ? 'success' : 'danger' }}">
                                                    {{ number_format($attempt->score, 1) }}/{{ $attempt->exam->total_marks }}
                                                </span>
                                            @else
                                                <span class="badge bg-warning">Chưa hoàn thành</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($attempt->end_time)
                                                @if($attempt->score >= $attempt->exam->passing_marks)
                                                    <span class="badge bg-success">Đạt</span>
                                                @else
                                                    <span class="badge bg-danger">Không Đạt</span>
                                                @endif
                                            @else
                                                <span class="badge bg-warning">Đang làm</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('exam-attempts.show', $attempt) }}" class="btn btn-info btn-sm">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">Bạn chưa làm bài thi nào</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $attempts->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 