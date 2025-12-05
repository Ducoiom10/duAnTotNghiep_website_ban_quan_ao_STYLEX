
<?php $__env->startSection('title', 'Hoàn tất đặt hàng - ' . env('APP_NAME')); ?>
<?php $__env->startSection('content'); ?>
<div class="container p-t-60 p-b-60">
  <div class="row justify-content-center">
    <div class="col-lg-7">
      <div class="text-center p-5" style="background:#fff;box-shadow:0 4px 18px 0 rgba(0,0,0,0.08);border-radius:12px;">
        <div style="font-size:60px;line-height:1;">🎉</div>
        <h2 class="mtext-105 cl2 m-t-20">Cảm ơn bạn đã đặt hàng!</h2>
        <div class="stext-111 cl6 m-t-16">Đơn hàng của bạn đã được ghi nhận thành công.</div>
        <div class="m-t-18 m-b-24">
          <span class="cl4">Mã đơn hàng:</span> <span style="font-weight:700;color:#6777ef;font-size:22px"><?php echo e($order->code ?? $order->id); ?></span>
        </div>
        <div class="m-b-28">Bạn sẽ nhận được xác nhận qua email hoặc điện thoại đã đăng ký. Nếu cần hỗ trợ, liên hệ <a href="tel:<?php echo e(env('HOTLINE', '0123456789')); ?>" class="cl-primary"><?php echo e(env('HOTLINE', '0123456789')); ?></a></div>
        <a href="/" class="btn-primary-x" style="padding:12px 24px;">Về trang chủ</a>
        <a href="<?php echo e(route('client.order.track')); ?>?code=<?php echo e($order->code ?? $order->id); ?>" class="btn-primary-x m-l-12" style="padding:12px 24px;background:#eef3fb;color:#6777ef;border:1px solid #6777ef;">Theo dõi đơn hàng</a>
      </div>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('client.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\LARAGON\laragon\www\DATN\duAnTotNghiep_website_ban_quan_ao_STYLEX\resources\views\client\checkout\thankyou.blade.php ENDPATH**/ ?>