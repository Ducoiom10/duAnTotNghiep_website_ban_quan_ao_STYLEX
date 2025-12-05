@extends('admin.layouts.app')
@section('title', 'Chi tiết đánh giá')

@push('page-css')
    <link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet" type="text/css" />
    <style>
        .review-detail-card {
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 24px;
            background: #fff;
        }
        .review-rating {
            display: flex;
            gap: 4px;
            align-items: center;
        }
        .star {
            color: #ffc107;
            font-size: 24px;
        }
        .star.empty {
            color: #e2e8f0;
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Chi tiết đánh giá</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang chủ</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.reviews.index') }}">Quản lý đánh giá</a></li>
                        <li class="breadcrumb-item active">Chi tiết</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="review-detail-card">
                <div class="d-flex justify-content-between align-items-start mb-4">
                    <div>
                        <h5 class="mb-2">Thông tin người đánh giá</h5>
                        <p class="mb-1"><strong>Tên:</strong> {{ $review->user->name ?? 'N/A' }}</p>
                        <p class="mb-1"><strong>Email:</strong> {{ $review->user->email ?? 'N/A' }}</p>
                        <p class="mb-0"><strong>Ngày đánh giá:</strong> {{ $review->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                    <div>
                        <span class="badge bg-{{ $review->status === 'approved' ? 'success' : ($review->status === 'pending' ? 'warning' : 'danger') }}">
                            @if($review->status === 'pending')
                                Chờ duyệt
                            @elseif($review->status === 'approved')
                                Đã duyệt
                            @else
                                Đã từ chối
                            @endif
                        </span>
                    </div>
                </div>

                <hr>

                <div class="mb-4">
                    <h5 class="mb-3">Đánh giá</h5>
                    <div class="review-rating mb-3">
                        @for($i = 1; $i <= 5; $i++)
                            <span class="star {{ $i <= $review->rating ? '' : 'empty' }}">★</span>
                        @endfor
                        <span style="margin-left:12px;font-weight:600;font-size:18px;">{{ $review->rating }}/5</span>
                    </div>
                    @if($review->content)
                        <div class="p-3 bg-light rounded">
                            {{ $review->content }}
                        </div>
                    @else
                        <p class="text-muted">Không có nội dung đánh giá</p>
                    @endif
                </div>

                <hr>

                <div class="mb-4">
                    <h5 class="mb-3">Thông tin sản phẩm</h5>
                    <p class="mb-1"><strong>Tên sản phẩm:</strong> {{ $review->product->name ?? 'N/A' }}</p>
                    @if($review->productVariant)
                        <p class="mb-1"><strong>Biến thể:</strong> {{ $review->productVariant->attribute_summary ?? 'N/A' }}</p>
                    @endif
                    @if($review->order_id)
                        <p class="mb-0"><strong>Mã đơn hàng:</strong> {{ $review->order->code ?? 'N/A' }}</p>
                    @endif
                </div>

                @if($review->media && $review->media->count() > 0)
                    <hr>
                    <div class="mb-4">
                        <h5 class="mb-3">Hình ảnh đánh giá</h5>
                        <div class="row g-3">
                            @foreach($review->media as $media)
                                <div class="col-md-3">
                                    <img src="{{ asset('storage/' . $media->path) }}" 
                                         alt="Review image" 
                                         class="img-fluid rounded"
                                         style="max-height:200px;object-fit:cover;">
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                @if($review->experiences && $review->experiences->count() > 0)
                    <hr>
                    <div class="mb-4">
                        <h5 class="mb-3">Trải nghiệm</h5>
                        <ul class="list-unstyled">
                            @foreach($review->experiences as $experience)
                                <li class="mb-2">
                                    <i class="ri-check-line text-success"></i> {{ $experience->description }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="d-flex gap-2 mt-4">
                    <a href="{{ route('admin.reviews.index') }}" class="btn btn-secondary">
                        <i class="ri-arrow-left-line"></i> Quay lại
                    </a>
                    <form action="{{ route('admin.reviews.destroy', $review->id) }}" 
                          method="POST" 
                          style="display:inline;"
                          onsubmit="return confirm('Bạn chắc chắn muốn xóa đánh giá này?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="ri-delete-bin-line"></i> Xóa đánh giá
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

