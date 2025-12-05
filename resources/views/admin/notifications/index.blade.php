@extends('admin.layouts.app')

@section('title', 'Thông báo')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Thông báo</h1>
        @if ($notifications->where('read_at', null)->count() > 0)
            <a href="{{ route('admin.notifications.mark-all-read') }}" class="btn btn-sm btn-primary">Đánh dấu tất cả là đã đọc</a>
        @endif
    </div>

    <div class="card shadow">
        <div class="card-body">
            @if ($notifications->isEmpty())
                <div class="alert alert-info">Không có thông báo nào.</div>
            @else
                <div class="list-group">
                    @foreach ($notifications as $notif)
                        <div class="list-group-item {{ is_null($notif->read_at) ? 'bg-light' : '' }}">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">
                                        <span class="badge bg-{{ $notif->type === 'low_stock' ? 'danger' : 'info' }}">{{ $notif->type }}</span>
                                        {{ $notif->title }}
                                    </h6>
                                    <p class="mb-1">{{ $notif->message }}</p>
                                    <small class="text-muted">{{ $notif->created_at->diffForHumans() }}</small>
                                </div>
                                @if (is_null($notif->read_at))
                                    <a href="{{ route('admin.notifications.mark-read', $notif->id) }}" class="btn btn-sm btn-outline-primary">Đánh dấu đã đọc</a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-4">
                    {{ $notifications->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
