@extends('layouts.app')

@section('title', 'Lịch Sử Làm Bài')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Lịch Sử Làm Bài</h1>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Đề Thi</th>
                        <th>Môn Học</th>
                        <th>Điểm Số</th>
                        <th>Thời Gian Làm Bài</th>
                        <th>Trạng Thái</th>
                        <th>Thao Tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($attempts as $attempt)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $attempt->exam->exam_name }}</td>
                            <td>{{ $attempt->exam->subject->subject_name }}</td>
                            <td>
                                <span class="badge bg-{{ $attempt->score >= $attempt->exam->passing_marks ? 'success' : 'danger' }}">
                                    {{ number_format($attempt->score, 1) }}/{{ $attempt->exam->total_marks }}
                                </span>
                            </td>
                            <td>{{ $attempt->duration }} phút</td>
                            <td>
                                @if($attempt->score >= $attempt->exam->passing_marks)
                                    <span class="badge bg-success">Đạt</span>
                                @else
                                    <span class="badge bg-danger">Không Đạt</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('exam-attempts.show', $attempt) }}" class="btn btn-info btn-sm">
                                    <i class="fas fa-eye"></i> Chi Tiết
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">Bạn chưa làm bài thi nào</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="d-flex justify-content-center mt-4">
    {{ $attempts->links() }}
</div>
@endsection 