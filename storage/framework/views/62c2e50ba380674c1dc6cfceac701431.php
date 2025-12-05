

<?php $__env->startSection('title', 'Đơn hàng của tôi - ' . env('APP_NAME')); ?>

<?php $__env->startSection('content'); ?>
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

    <?php
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
            ?>

    <?php if(session('success')): ?>
        <div class="alert alert-success" role="alert"><?php echo e(session('success')); ?></div>
    <?php elseif(session('error')): ?>
        <div class="alert alert-danger" role="alert"><?php echo e(session('error')); ?></div>
    <?php endif; ?>

    <div class="order-tabs">
        <?php $__currentLoopData = $tabLinks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <a class="order-tab <?php echo e(($key === null && !$activeStatus) || ($activeStatus === $key) ? 'active' : ''); ?>"
               href="<?php echo e($key ? route('client.order.list', ['status' => $key]) : route('client.order.list')); ?>">
                <?php echo e($label); ?>

            </a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    <?php if($orders->isEmpty()): ?>
        <div class="order-card">
            <p class="m-b-0">Chưa có đơn hàng nào cho trạng thái này.</p>
        </div>
    <?php endif; ?>

    <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="order-card">
            <div class="order-card__header">
                <div>
                    <div class="order-card__status"><?php echo e($statusLabels[$order->status] ?? ucfirst($order->status)); ?></div>
                    <div class="order-card__meta">Mã đơn: <?php echo e($order->code); ?></div>
                    <div class="order-card__meta">
                        Thanh toán:
                        <?php if($order->payment_method === 'cod'): ?>
                            COD
                        <?php else: ?>
                            Online
                        <?php endif; ?>
                        &nbsp;|&nbsp;
                        Trạng thái:
                        <?php switch($order->payment_status):
                            case ('paid'): ?> Đã thanh toán <?php break; ?>
                            <?php case ('refunded'): ?> Đã hoàn tiền <?php break; ?>
                            <?php default: ?> Chưa thanh toán
                        <?php endswitch; ?>
                    </div>
                </div>
                <div class="order-card__meta text-right">
                    Ngày đặt: <?php echo e($order->created_at?->format('d/m/Y H:i')); ?>

                </div>
            </div>

            <?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="order-item">
                    <img src="<?php echo e($item->product->default_image_url ?? asset('client/images/product/product-01.jpg')); ?>" alt="IMG">
                    <div class="order-item__info">
                        <div class="order-item__name"><?php echo e($item->product->name ?? 'Sản phẩm'); ?></div>
                        <?php
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
                        ?>
                        <?php if(!empty($parts)): ?>
                            <div class="order-item__attrs"><?php echo e(implode(' - ', $parts)); ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="order-item__price">
                        x <?php echo e($item->quantity); ?><br>
                        <?php echo e(number_format($item->line_total, 0, ',', '.')); ?> ₫
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            <div class="order-card__footer">
                <div class="order-total">Tổng: <?php echo e(number_format($order->total, 0, ',', '.')); ?> ₫</div>
                <div class="order-actions">
                    <a class="btn-outline" href="<?php echo e(route('client.order.track', ['code' => $order->code])); ?>">Xem chi tiết</a>
                    <?php if($order->status === 'pending'): ?>
                        <form method="POST" action="<?php echo e(route('client.order.cancel', $order)); ?>" onsubmit="return confirm('Bạn chắc chắn muốn hủy đơn này?');">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="btn-outline" style="border-color:#ff4d4f;color:#ff4d4f;">Hủy đơn</button>
                        </form>
                    <?php endif; ?>
                    <?php if(in_array($order->status, ['completed','delivered'])): ?>
                        <a class="btn-primary-x" href="<?php echo e(route('client.products.index')); ?>">Mua lại</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('client.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\LARAGON\laragon\www\DATN\duAnTotNghiep_website_ban_quan_ao_STYLEX\resources\views\client\orders\index.blade.php ENDPATH**/ ?>