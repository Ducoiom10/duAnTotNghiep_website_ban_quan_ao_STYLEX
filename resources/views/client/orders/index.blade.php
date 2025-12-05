@extends('client.layouts.app')

@section('title', 'Đơn hàng của tôi - ' . env('APP_NAME'))

@section('content')
<div class="container p-t-40 p-b-60">
<style>
        .order-tabs{display:flex;gap:20px;overflow-x:auto;margin-bottom:20px;border-bottom:1px solid #f0f0f0;padding-bottom:5px;}
        .order-tab{position:relative;padding-bottom:10px;font-weight:600;color:#666;text-decoration:none;white-space:nowrap;}
        .order-tab.active{color:#ff4d4f;}
        .order-tab.active:after{content:"";position:absolute;left:0;right:0;bottom:-1px;height:3px;background:#ff4d4f;border-radius:3px;}
        .order-card{background:#fff;border:1px solid #eee;border-radius:12px;padding:18px;margin-bottom:18px;box-shadow:0 6px 18px rgba(0,0,0,.03);}
        .order-card__header{display:flex;flex-wrap:wrap;gap:10px;justify-content:space-between;border-bottom:1px dashed #eee;padding-bottom:10px;margin-bottom:10px;}
        .order-card__status{font-weight:700;color:#ff7a45;}
        .order-card__meta{font-size:13px;color:#666;}
        .order-item{display:flex;gap:12px;padding:10px 0;border-bottom:1px dashed #f0f0f0;}
        .order-item:last-child{border-bottom:none;}
        .order-item img{width:64px;height:64px;border-radius:8px;object-fit:cover;}
        .order-item__info{flex:1;min-width:0;}
        .order-item__name{font-weight:600;color:#222;}
        .order-item__attrs{font-size:12px;color:#666;margin-top:3px;}
        .order-item__price{text-align:right;font-weight:600;}
        .order-card__footer{display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:10px;margin-top:8px;}
        .order-total{font-size:16px;font-weight:700;color:#333;}
        .order-actions{display:flex;gap:10px;align-items:center;flex-wrap:wrap;}
        .order-actions form{margin:0;}
        .btn-outline,
        .btn-primary-x{
            display:inline-flex;
            align-items:center;
            justify-content:center;
            padding:8px 14px;
            border-radius:8px;
            font-weight:600;
            font-size:13px;
            text-decoration:none;
        }
        .btn-outline{border:1px solid #d9d9d9;color:#555;background:#fff;}
        .btn-primary-x{background:#ff4d4f;color:#fff;border:none;}
        @media(max-width:575px){
            .order-tabs{gap:14px;}
            .order-card__header{flex-direction:column;align-items:flex-start;}
            .order-item{flex-wrap:wrap;}
            .order-item__price{text-align:left;}
            .order-card__footer{flex-direction:column;align-items:flex-start;}
}
</style>

    @php
        $tabLinks = [
            null => 'Tất cả',
        ] + $statusTabs;
        $statusLabels = [
            'pending' => 'Chờ xác nhận',
            'processing' => 'Vận chuyển',
            'shipping' => 'Chờ giao hàng',
            'completed' => 'Hoàn thành',
            'cancelled' => 'Đã hủy',
            'returned' => 'Trả hàng/Hoàn tiền',
        ];
            @endphp

    @if(session('success'))
        <div class="alert alert-success" role="alert">{{ session('success') }}</div>
    @elseif(session('error'))
        <div class="alert alert-danger" role="alert">{{ session('error') }}</div>
    @endif

    <div class="order-tabs">
        @foreach($tabLinks as $key => $label)
            <a class="order-tab {{ ($key === null && !$activeStatus) || ($activeStatus === $key) ? 'active' : '' }}"
               href="{{ $key ? route('client.order.list', ['status' => $key]) : route('client.order.list') }}">
                {{ $label }}
            </a>
        @endforeach
    </div>

    @if($orders->isEmpty())
        <div class="order-card">
            <p class="m-b-0">Chưa có đơn hàng nào cho trạng thái này.</p>
        </div>
    @endif

    @foreach($orders as $order)
        <div class="order-card">
            <div class="order-card__header">
                <div>
                    <div class="order-card__status">{{ $statusLabels[$order->status] ?? ucfirst($order->status) }}</div>
                    <div class="order-card__meta">Mã đơn: {{ $order->code }}</div>
                    <div class="order-card__meta">
                        Thanh toán:
                        @if($order->payment_method === 'cod')
                            COD
                        @else
                            Online
                        @endif
                        &nbsp;|&nbsp;
                        Trạng thái:
                        @switch($order->payment_status)
                            @case('paid') Đã thanh toán @break
                            @case('refunded') Đã hoàn tiền @break
                            @default Chưa thanh toán
                        @endswitch
                    </div>
                </div>
                <div class="order-card__meta text-right">
                    Ngày đặt: {{ $order->created_at?->format('d/m/Y H:i') }}
                </div>
            </div>

            @foreach($order->items as $item)
                <div class="order-item">
                    @php
                        $product = $item->product;
                        // Nếu product null, thử load lại với withTrashed
                        if (!$product && $item->product_id) {
                            $product = \App\Models\Product::withTrashed()->find($item->product_id);
                        }
                        $productName = $product ? $product->name : ('Sản phẩm #' . $item->product_id);
                        $productImage = $product ? ($product->default_image_url ?? asset('client/images/product/product-01.jpg')) : asset('client/images/product/product-01.jpg');
                    @endphp
                    <img src="{{ $productImage }}" alt="{{ $productName }}">
                    <div class="order-item__info">
                        <div class="order-item__name">{{ $productName }}</div>
                        @php
                            $parts = [];
                            if($item->variant && $item->variant->size){ $parts[] = 'Size: '.$item->variant->size->name; }
                            if($item->variant && $item->variant->color){ $parts[] = 'Màu: '.$item->variant->color->name; }
                            $textureNames = $product && $product->relationLoaded('productVariants')
                                ? $product->productVariants
                                    ->map(fn($variant) => optional($variant->texture)->name)
                                    ->filter()
                                    ->unique()
                                    ->values()
                                    ->toArray()
                                : [];
                            if(!empty($textureNames)){
                                $parts[] = 'Chất liệu: '.implode(', ', $textureNames);
                            } elseif($item->variant && $item->variant->texture){
                                $parts[] = 'Chất liệu: '.$item->variant->texture->name;
                            }
                        @endphp
                        @if(!empty($parts))
                            <div class="order-item__attrs">{{ implode(' - ', $parts) }}</div>
                        @endif
                        {{-- Hiển thị nút đánh giá cho đơn hàng đã hoàn thành --}}
                        @if(in_array($order->status, ['completed', 'delivered']))
                            <div class="mt-2">
                                @if(isset($item->is_reviewed) && $item->is_reviewed)
                                    <span class="text-success" style="font-size:12px;">
                                        ✓ Đã đánh giá
                                    </span>
                                @else
                                    <button type="button" 
                                            class="btn-review-item" 
                                            data-order-id="{{ $order->id }}"
                                            data-item-id="{{ $item->id }}"
                                            data-product-id="{{ $item->product_id }}"
                                            data-product-name="{{ $productName }}"
                                            style="background:#6777ef;color:#fff;border:none;padding:4px 12px;border-radius:6px;font-size:12px;cursor:pointer;">
                                        ★ Đánh giá
                                    </button>
                                @endif
                            </div>
                        @endif
                    </div>
                    <div class="order-item__price">
                        x {{ $item->quantity }}<br>
                        {{ number_format($item->line_total, 0, ',', '.') }} ₫
                    </div>
                </div>
            @endforeach

            <div class="order-card__footer">
                <div class="order-total">Tổng: {{ number_format($order->total, 0, ',', '.') }} ₫</div>
                <div class="order-actions">
                    <a class="btn-outline" href="{{ route('client.order.track', ['code' => $order->code]) }}">Xem chi tiết</a>
                    @if($order->status === 'pending')
                        <form method="POST" action="{{ route('client.order.cancel', $order) }}" onsubmit="return confirm('Bạn chắc chắn muốn hủy đơn này?');">
                            @csrf
                            <button type="submit" class="btn-outline" style="border-color:#ff4d4f;color:#ff4d4f;">Hủy đơn</button>
                        </form>
                    @endif
                    @if(in_array($order->status, ['completed','delivered']))
                        <a class="btn-primary-x" href="{{ route('client.products.index') }}">Mua lại</a>
                    @endif
                </div>
            </div>
        </div>
    @endforeach
</div>

{{-- Modal đánh giá sản phẩm --}}
<div id="reviewModal" style="display:none;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.5);z-index:99999;align-items:center;justify-content:center;">
    <div style="background:#fff;border-radius:12px;padding:24px;max-width:500px;width:90%;max-height:90vh;overflow-y:auto;position:relative;">
        <button type="button" id="closeReviewModal" style="position:absolute;top:10px;right:10px;background:none;border:none;font-size:24px;cursor:pointer;color:#666;">&times;</button>
        <h5 style="margin-bottom:20px;font-weight:600;">Đánh giá sản phẩm</h5>
        
        <form id="reviewForm" method="POST" action="{{ route('client.order.review') }}">
            @csrf
            <input type="hidden" name="order_id" id="reviewOrderId">
            <input type="hidden" name="order_item_id" id="reviewItemId">
            <input type="hidden" name="rating" id="reviewRating">
            
            <div style="margin-bottom:16px;">
                <strong id="reviewProductName"></strong>
            </div>
            <div style="margin-bottom:16px;">
                <label style="display:block;margin-bottom:8px;font-weight:600;">Đánh giá của bạn:</label>
                <div class="star-rating-review" id="starRatingReview" style="display:flex;gap:4px;">
                    @for($i = 1; $i <= 5; $i++)
                        <span class="star-review" data-rating="{{ $i }}" style="font-size:24px;color:#ddd;cursor:pointer;">★</span>
                    @endfor
                </div>
            </div>
            <div style="margin-bottom:16px;">
                <label style="display:block;margin-bottom:8px;font-weight:600;">Nội dung đánh giá (tùy chọn):</label>
                <textarea name="content" id="reviewContent" rows="4" placeholder="Chia sẻ cảm nhận của bạn về sản phẩm này..." style="width:100%;padding:8px;border:1px solid #ddd;border-radius:6px;font-size:14px;resize:vertical;"></textarea>
            </div>
            <div style="display:flex;gap:10px;justify-content:flex-end;margin-top:20px;">
                <button type="button" id="closeReviewModalBtn" style="padding:8px 16px;background:#f0f0f0;border:none;border-radius:6px;cursor:pointer;font-weight:600;">Đóng</button>
                <button type="submit" id="submitReviewBtn" style="padding:8px 16px;background:#6777ef;color:#fff;border:none;border-radius:6px;cursor:pointer;font-weight:600;">Gửi đánh giá</button>
            </div>
        </form>
    </div>
</div>

<script>
(function() {
    let currentOrderId = null;
    let currentItemId = null;
    let selectedRating = 0;
    let reviewModal = null;

    function openModal() {
        if (reviewModal) {
            reviewModal.style.display = 'flex';
        }
    }

    function closeModal() {
        if (reviewModal) {
            reviewModal.style.display = 'none';
        }
    }

    function highlightStars(rating) {
        document.querySelectorAll('.star-review').forEach(function(star, index) {
            if (index < rating) {
                star.style.color = '#ffc107';
            } else {
                star.style.color = '#ddd';
            }
        });
    }

    function resetStars() {
        document.querySelectorAll('.star-review').forEach(function(star) {
            star.style.color = '#ddd';
        });
    }

    function initReviewModal() {
        reviewModal = document.getElementById('reviewModal');
        if (!reviewModal) {
            console.error('Review modal not found');
            return;
        }

        // Xử lý click nút đánh giá
        const reviewButtons = document.querySelectorAll('.btn-review-item');
        console.log('Found review buttons:', reviewButtons.length);
        
        reviewButtons.forEach(function(btn) {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                console.log('Review button clicked', this.dataset);
                currentOrderId = this.dataset.orderId;
                currentItemId = this.dataset.itemId;
                const productNameEl = document.getElementById('reviewProductName');
                if (productNameEl) {
                    productNameEl.textContent = this.dataset.productName || 'Sản phẩm';
                }
                selectedRating = 0;
                resetStars();
                const contentEl = document.getElementById('reviewContent');
                if (contentEl) {
                    contentEl.value = '';
                }
                openModal();
            });
        });

        // Đóng modal khi click nút đóng
        const closeBtn1 = document.getElementById('closeReviewModal');
        const closeBtn2 = document.getElementById('closeReviewModalBtn');
        if (closeBtn1) closeBtn1.addEventListener('click', closeModal);
        if (closeBtn2) closeBtn2.addEventListener('click', closeModal);
        
        // Đóng modal khi click bên ngoài
        reviewModal.addEventListener('click', function(e) {
            if (e.target === reviewModal) {
                closeModal();
            }
        });

        // Xử lý đánh giá sao
        document.querySelectorAll('.star-review').forEach(function(star) {
            star.addEventListener('mouseenter', function() {
                const rating = parseInt(this.dataset.rating);
                highlightStars(rating);
            });
            
            star.addEventListener('click', function() {
                selectedRating = parseInt(this.dataset.rating);
                highlightStars(selectedRating);
            });
        });

        const starRatingEl = document.getElementById('starRatingReview');
        if (starRatingEl) {
            starRatingEl.addEventListener('mouseleave', function() {
                highlightStars(selectedRating);
            });
        }

        // Xử lý submit review form
        const reviewForm = document.getElementById('reviewForm');
        if (reviewForm) {
            reviewForm.addEventListener('submit', function(e) {
                if (selectedRating === 0) {
                    e.preventDefault();
                    alert('Vui lòng chọn số sao đánh giá!');
                    return false;
                }

                // Set giá trị vào hidden inputs
                document.getElementById('reviewOrderId').value = currentOrderId;
                document.getElementById('reviewItemId').value = currentItemId;
                document.getElementById('reviewRating').value = selectedRating;

                // Disable button để tránh submit nhiều lần
                const submitBtn = document.getElementById('submitReviewBtn');
                if (submitBtn) {
                    submitBtn.disabled = true;
                    submitBtn.textContent = 'Đang gửi...';
                }
            });
        }
    }

    // Khởi tạo khi DOM ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initReviewModal);
    } else {
        initReviewModal();
    }
})();
</script>
@endsection
