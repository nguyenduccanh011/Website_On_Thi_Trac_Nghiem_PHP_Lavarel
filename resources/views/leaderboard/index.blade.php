@extends('layouts.app')

@section('title', 'Bảng Xếp Hạng')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Bảng Xếp Hạng</h1>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Thứ Hạng</th>
                        <th>Người Dùng</th>
                        <th>Điểm Số</th>
                        <th>Lần Làm Bài Cuối</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($leaderboard as $rank => $entry)
                        <tr class="{{ $entry->user_id === Auth::id() ? 'table-primary' : '' }}">
                            <td>
                                @if($rank < 3)
                                    <span class="badge bg-{{ $rank === 0 ? 'warning' : ($rank === 1 ? 'secondary' : 'danger') }}">
                                        {{ $rank + 1 }}
                                    </span>
                                @else
                                    {{ $rank + 1 }}
                                @endif
                            </td>
                            <td>
                                {{ $entry->user->name }}
                                @if($entry->user_id === Auth::id())
                                    <span class="badge bg-info">Bạn</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-{{ $entry->score >= 8 ? 'success' : ($entry->score >= 6 ? 'warning' : 'danger') }}">
                                    {{ number_format($entry->score, 1) }}
                                </span>
                            </td>
                            <td>{{ $entry->last_attempt_date->format('d/m/Y H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">Chưa có dữ liệu xếp hạng</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="d-flex justify-content-center mt-4">
    {{ $leaderboard->links() }}
</div>
@endsection 