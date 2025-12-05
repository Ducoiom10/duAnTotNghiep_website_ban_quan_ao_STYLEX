@extends('client.layouts.app')

@section('title', 'Theo dõi đơn hàng - ' . env('APP_NAME'))

@section('content')
<div class="container p-t-40 p-b-60">
<style>
        .order-track-card{background:#fff;border:1px solid #eee;border-radius:12px;box-shadow:0 8px 24px rgba(0,0,0,.05);padding:24px;max-width:960px;margin:0 auto;}
        .order-track-title{font-weight:800;font-size:22px;margin-bottom:12px;display:flex;align-items:center;gap:10px;}
        .order-track-title:before{content:"";width:6px;height:24px;background:#6777ef;border-radius:6px;}
        .order-track-meta{font-size:14px;color:#555;margin-bottom:16px;}
        .order-badge{display:inline-flex;align-items:center;padding:4px 10px;border-radius:999px;font-size:12px;font-weight:600;}
        .status-pending{background:#fff7e6;color:#d48806;border:1px solid #ffe58f;}
        .status-processing{background:#e6f4ff;color:#1677ff;border:1px solid #91caff;}
        .status-completed{background:#f6ffed;color:#389e0d;border:1px solid #b7eb8f;}
        .status-cancelled{background:#fff1f0;color:#cf1322;border:1px solid #ffa39e;}
        .timeline{margin:20px 0 10px;padding-left:0;list-style:none;position:relative;}
        .timeline:before{content:"";position:absolute;left:12px;top:0;bottom:0;width:2px;background:#f0f0f0;}
        .timeline-item{position:relative;padding-left:32px;padding-bottom:16px;}
        .timeline-item:last-child{padding-bottom:0;}
        .timeline-dot{position:absolute;left:7px;top:3px;width:10px;height:10px;border-radius:50%;background:#d9d9d9;}
        .timeline-item.active .timeline-dot{background:#6777ef;box-shadow:0 0 0 4px rgba(103,119,239,.2);}
        .timeline-title{font-weight:600;font-size:14px;}
        .timeline-time{font-size:12px;color:#888;}
        .order-items{margin-top:20px;border-top:1px solid #eee;padding-top:16px;}
        .order-item-row{display:flex;gap:10px;padding:10px 0;border-bottom:1px dashed #eee;}
        .order-item-row:last-child{border-bottom:none;}
        .order-item-row img{width:56px;height:56px;border-radius:8px;object-fit:cover;}
        .order-item-info{flex:1;min-width:0;}
        .order-item-name{font-weight:600;color:#222;}
        .order-item-attrs{font-size:12px;color:#666;margin-top:2px;white-space:normal;word-break:break-word;}
        .order-item-qty{font-size:13px;color:#333;}
        .order-item-price{text-align:right;font-weight:600;min-width:90px;}
        .order-summary-line{display:flex;justify-content:space-between;margin-top:6px;font-size:14px;}
        .order-summary-total{font-size:16px;font-weight:700;color:#6777ef;margin-top:8px;border-top:1px solid #eee;padding-top:8px;}
        .btn-outline{border:1px solid #d9d9d9;color:#555;background:#fff;border-radius:8px;padding:10px 14px;font-weight:600;text-decoration:none;display:inline-flex;align-items:center;justify-content:center;}
        @media(max-width:767px){
            .order-item-row{flex-wrap:wrap;}
            .order-item-price{text-align:left;}
        }
</style>

    @if(session('success'))
        <div class="alert alert-success" role="alert">{{ session('success') }}</div>
    @elseif(session('error'))
        <div class="alert alert-danger" role="alert">{{ session('error') }}</div>
    @endif

    <div class="order-track-card">
        <h1 class="order-track-title">Trạng thái đơn hàng</h1>

        @if(!$order)
            <p class="order-track-meta">Không tìm thấy đơn hàng. Vui lòng kiểm tra lại đường dẫn hoặc mã đơn.</p>
            <form method="GET" action="{{ route('client.order.track') }}" class="m-t-15">
                <div class="row g-2">
                    <div class="col-md-8">
                        <input type="text" name="code" class="co-input" placeholder="Nhập mã đơn / số điện thoại" required>
                    </div>
                    <div class="col-md-4">
                        <button class="btn-primary-x w-100">Tra cứu đơn hàng</button>
                    </div>
                </div>
    </form>
        @else
            <div class="order-track-meta">
                <div><strong>Mã đơn:</strong> {{ $order->code }}</div>
                <div><strong>Ngày đặt:</strong> {{ $order->created_at?->format('d/m/Y H:i') }}</div>
                <div>
                    <strong>Trạng thái:</strong>
        @php
                        $statusClass = [
                            'pending' => 'status-pending',
                            'processing' => 'status-processing',
                            'shipping' => 'status-processing',
                            'completed' => 'status-completed',
                            'delivered' => 'status-completed',
                            'cancelled' => 'status-cancelled',
                            'returned' => 'status-cancelled',
                        ][$order->status] ?? 'status-pending';

                        $statusLabel = [
                            'pending' => 'Chờ xác nhận',
                            'processing' => 'Vận chuyển',
                            'shipping' => 'Chờ giao hàng',
                            'completed' => 'Hoàn thành',
                            'delivered' => 'Đã giao',
                            'cancelled' => 'Đã hủy',
                            'returned' => 'Trả hàng/Hoàn tiền',
                        ][$order->status] ?? 'Chờ xử lý';
        @endphp
                    <span class="order-badge {{ $statusClass }}">{{ $statusLabel }}</span>
                </div>
                <div style="margin-top:6px;">
                    <strong>Người nhận:</strong> {{ $order->full_name }} - {{ $order->phone }}<br>
                    <strong>Địa chỉ:</strong> {{ $order->address }}, {{ $order->city }}<br>
                    <strong>Phương thức thanh toán:</strong>
                    @if($order->payment_method === 'cod')
                        COD
                    @else
                        Online
                    @endif
                    &nbsp;|&nbsp;
                    <strong>Trạng thái thanh toán:</strong>
                    @switch($order->payment_status)
                        @case('paid') Đã thanh toán @break
                        @case('refunded') Đã hoàn tiền @break
                        @default Chưa thanh toán
                    @endswitch
      </div>
      </div>

            @php
                $timelineSteps = [
                    ['key' => 'pending', 'label' => 'Đã tiếp nhận đơn hàng'],
                    ['key' => 'processing', 'label' => 'Đang chuẩn bị hàng'],
                    ['key' => 'shipping', 'label' => 'Đơn vị vận chuyển đã nhận'],
                    ['key' => 'completed', 'label' => 'Đã giao thành công'],
                ];
                $statusRank = [
                    'pending' => 1,
                    'processing' => 2,
                    'shipping' => 3,
                    'completed' => 4,
                    'delivered' => 4,
                ][$order->status] ?? 0;
            @endphp

            <ul class="timeline">
                <li class="timeline-item {{ $statusRank >= 1 ? 'active' : '' }}">
                    <span class="timeline-dot"></span>
                    <div class="timeline-title">Đã tiếp nhận đơn hàng</div>
                    <div class="timeline-time">{{ $order->created_at?->format('d/m/Y H:i') }}</div>
                </li>
                <li class="timeline-item {{ $statusRank >= 2 ? 'active' : '' }}">
                    <span class="timeline-dot"></span>
                    <div class="timeline-title">Đang chuẩn bị / đóng gói</div>
                    <div class="timeline-time">Đơn hàng đang được xử lý tại kho.</div>
                </li>
                <li class="timeline-item {{ $statusRank >= 3 ? 'active' : '' }}">
                    <span class="timeline-dot"></span>
                    <div class="timeline-title">Đang giao hàng</div>
                    <div class="timeline-time">Đã bàn giao cho đơn vị vận chuyển.</div>
                </li>
                <li class="timeline-item {{ $statusRank >= 4 ? 'active' : '' }}">
                    <span class="timeline-dot"></span>
                    <div class="timeline-title">Đã giao thành công</div>
                    <div class="timeline-time">Cập nhật khi đơn chuyển sang trạng thái hoàn tất</div>
                </li>
                @if(in_array($order->status, ['cancelled','returned']))
                    <li class="timeline-item active">
                        <span class="timeline-dot"></span>
                        <div class="timeline-title">
                            {{ $order->status === 'returned' ? 'Đơn hàng đã trả/hoàn tiền' : 'Đơn hàng đã hủy' }}
                        </div>
                        <div class="timeline-time">Vui lòng liên hệ chăm sóc khách hàng nếu cần hỗ trợ.</div>
                    </li>
                @endif
            </ul>

            <div class="order-items">
                <h5 style="font-weight:700;margin-bottom:8px;">Sản phẩm trong đơn</h5>
            @foreach($order->items as $item)
                    <div class="order-item-row">
                        <img src="{{ $item->product->default_image_url ?? asset('client/images/product/product-01.jpg') }}" alt="IMG">
                        <div class="order-item-info">
                            <div class="order-item-name">{{ $item->product->name ?? 'Sản phẩm' }}</div>
                            @php
                            $parts = [];
                            if($item->variant && $item->variant->size){ $parts[] = 'Size: '.$item->variant->size->name; }
                            if($item->variant && $item->variant->color){ $parts[] = 'Màu: '.$item->variant->color->name; }
                            $textureNames = $item->product && $item->product->relationLoaded('productVariants')
                                ? $item->product->productVariants
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
                            <div class="order-item-attrs">{{ implode(' - ', $parts) }}</div>
                        @endif
                        </div>
                        <div class="order-item-qty">x {{ $item->quantity }}</div>
                        <div class="order-item-price">{{ number_format($item->line_total, 0, ',', '.') }} ₫</div>
                    </div>
            @endforeach

                {{-- Hiển thị form đánh giá nếu đơn hàng đã hoàn thành --}}
                @if($order && in_array($order->status, ['completed', 'delivered']))
                    <div class="m-t-30" style="border-top:2px solid #eee;padding-top:20px;">
                        <h5 style="font-weight:700;margin-bottom:16px;">Đánh giá sản phẩm</h5>
                        @foreach($order->items as $item)
                            @if(!isset($item->is_reviewed) || !$item->is_reviewed)
                                <div class="review-item-card" data-item-id="{{ $item->id }}" style="background:#f9f9f9;border-radius:8px;padding:16px;margin-bottom:12px;">
                                    <div class="d-flex gap-3 align-items-start">
                                        <img src="{{ $item->product->default_image_url ?? asset('client/images/product/product-01.jpg') }}" 
                                             alt="{{ $item->product->name }}" 
                                             style="width:60px;height:60px;border-radius:8px;object-fit:cover;">
                                        <div style="flex:1;">
                                            <div style="font-weight:600;margin-bottom:4px;">{{ $item->product->name }}</div>
                                            <div style="font-size:12px;color:#666;">Số lượng: {{ $item->quantity }}</div>
                                            
                                            <div class="review-form" style="margin-top:12px;">
                                                <div style="margin-bottom:8px;">
                                                    <label style="font-size:13px;font-weight:600;margin-bottom:4px;display:block;">Đánh giá của bạn:</label>
                                                    <div class="star-rating" data-item-id="{{ $item->id }}">
                                                        @for($i = 1; $i <= 5; $i++)
                                                            <span class="star" data-rating="{{ $i }}" style="font-size:20px;color:#ddd;cursor:pointer;margin-right:4px;">★</span>
                                                        @endfor
                                                    </div>
                                                </div>
                                                <textarea class="review-content" 
                                                          data-item-id="{{ $item->id }}" 
                                                          placeholder="Chia sẻ cảm nhận của bạn về sản phẩm này..."
                                                          style="width:100%;min-height:80px;padding:8px;border:1px solid #ddd;border-radius:6px;font-size:13px;resize:vertical;"></textarea>
                                                <button type="button" 
                                                        class="submit-review-btn" 
                                                        data-order-id="{{ $order->id }}" 
                                                        data-item-id="{{ $item->id }}"
                                                        data-product-id="{{ $item->product_id }}"
                                                        data-variant-id="{{ $item->variant_id }}"
                                                        style="margin-top:8px;padding:8px 16px;background:#6777ef;color:#fff;border:none;border-radius:6px;font-weight:600;cursor:pointer;font-size:13px;">
                                                    Gửi đánh giá
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div style="background:#f0f9ff;border-radius:8px;padding:12px;margin-bottom:12px;font-size:13px;color:#1677ff;">
                                    ✓ Bạn đã đánh giá sản phẩm: <strong>{{ $item->product->name }}</strong>
                                </div>
                            @endif
                        @endforeach
                    </div>
                @endif

                <div class="order-summary">
                    <div class="order-summary-line">
                        <span>Tạm tính</span>
                        <span>{{ number_format($order->subtotal, 0, ',', '.') }} ₫</span>
                    </div>
                    @if($order->discount > 0)
                        <div class="order-summary-line" style="color:#28a745;">
                            <span>Giảm giá</span>
                            <span>-{{ number_format($order->discount, 0, ',', '.') }} ₫</span>
                        </div>
                    @endif
                    @if($order->tax_amount > 0)
                        <div class="order-summary-line">
                            <span>Thuế</span>
                            <span>{{ number_format($order->tax_amount, 0, ',', '.') }} ₫</span>
                        </div>
                    @endif
                    @if($order->shipping_fee > 0)
                        <div class="order-summary-line">
                            <span>Phí vận chuyển</span>
                            <span>{{ number_format($order->shipping_fee, 0, ',', '.') }} ₫</span>
                        </div>
                    @endif
                    <div class="order-summary-total">
                        <span>Tổng cộng</span>
                        <span>{{ number_format($order->total, 0, ',', '.') }} ₫</span>
                    </div>
                </div>
            </div>

            <div class="m-t-20 d-flex justify-content-between flex-wrap" style="gap:10px;">
                <a href="{{ route('client.order.list') }}" class="co-hint" style="text-decoration:none;">← Xem lịch sử đơn hàng</a>
                <div class="d-flex gap-2 flex-wrap">
                    @if($order->status === 'pending')
                        <form method="POST" action="{{ route('client.order.cancel', $order) }}" onsubmit="return confirm('Bạn chắc chắn muốn hủy đơn hàng này?');">
                            @csrf
                            <button type="submit" class="btn-outline" style="border:1px solid #ff4d4f;color:#ff4d4f;border-radius:8px;padding:10px 14px;background:#fff;">Hủy đơn hàng</button>
                        </form>
                    @endif
                    <a href="{{ route('home') }}" class="btn-primary-x">Tiếp tục mua sắm</a>
                </div>
      </div>
    @endif
  </div>
</div>

@if($order && in_array($order->status, ['completed', 'delivered']))
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Xử lý đánh giá sao
    document.querySelectorAll('.star-rating').forEach(function(ratingEl) {
        const stars = ratingEl.querySelectorAll('.star');
        let selectedRating = 0;
        
        stars.forEach(function(star, index) {
            star.addEventListener('mouseenter', function() {
                const rating = parseInt(this.dataset.rating);
                highlightStars(stars, rating);
            });
            
            star.addEventListener('click', function() {
                selectedRating = parseInt(this.dataset.rating);
                highlightStars(stars, selectedRating);
                ratingEl.dataset.selectedRating = selectedRating;
            });
        });
        
        ratingEl.addEventListener('mouseleave', function() {
            highlightStars(stars, selectedRating);
        });
    });
    
    function highlightStars(stars, rating) {
        stars.forEach(function(star, index) {
            if (index < rating) {
                star.style.color = '#ffc107';
            } else {
                star.style.color = '#ddd';
            }
        });
    }
    
    // Xử lý submit review
    document.querySelectorAll('.submit-review-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            const orderId = this.dataset.orderId;
            const itemId = this.dataset.itemId;
            const ratingEl = document.querySelector(`.star-rating[data-item-id="${itemId}"]`);
            const contentEl = document.querySelector(`.review-content[data-item-id="${itemId}"]`);
            const rating = ratingEl ? parseInt(ratingEl.dataset.selectedRating || 0) : 0;
            const content = contentEl ? contentEl.value.trim() : '';
            
            if (rating === 0) {
                alert('Vui lòng chọn số sao đánh giá!');
                return;
            }
            
            // Disable button
            this.disabled = true;
            this.textContent = 'Đang gửi...';
            
            // Gửi request
            fetch('/api/reviews', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                },
                body: JSON.stringify({
                    order_id: orderId,
                    order_item_id: itemId,
                    rating: rating,
                    content: content
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message || 'Cảm ơn bạn đã đánh giá!');
                    location.reload();
                } else {
                    alert(data.message || 'Có lỗi xảy ra. Vui lòng thử lại.');
                    this.disabled = false;
                    this.textContent = 'Gửi đánh giá';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Có lỗi xảy ra. Vui lòng thử lại.');
                this.disabled = false;
                this.textContent = 'Gửi đánh giá';
            });
        });
    });
});
</script>
@endif
@endsection