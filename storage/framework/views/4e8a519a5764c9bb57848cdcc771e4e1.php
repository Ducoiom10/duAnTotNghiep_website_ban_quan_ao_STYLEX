<?php $__env->startComponent('mail::message'); ?>
# Xin chào <?php echo e($user->name); ?>,

Tài khoản của bạn đã bị **khóa tạm thời** bởi quản trị viên.

Nếu bạn cho rằng đây là sự nhầm lẫn, vui lòng liên hệ với bộ phận hỗ trợ để được trợ giúp.

<?php $__env->startComponent('mail::button', ['url' => config('app.url')]); ?>
Truy cập trang chủ
<?php echo $__env->renderComponent(); ?>

Cảm ơn bạn,<br>
<?php echo e(config('app.name')); ?>

<?php echo $__env->renderComponent(); ?>

<?php /**PATH E:\LARAGON\laragon\www\DATN\duAnTotNghiep_website_ban_quan_ao_STYLEX\resources\views\admin\mails\account_blocked.blade.php ENDPATH**/ ?>