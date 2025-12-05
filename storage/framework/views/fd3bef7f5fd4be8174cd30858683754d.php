<?php $__env->startComponent('mail::message'); ?>
# Xin chào <?php echo e($user->name); ?>,

Vai trò của bạn trong hệ thống đã được cập nhật:

- **Trước đây:** <?php echo e($oldRole); ?>

- **Hiện tại:** <?php echo e($newRole); ?>


Vui lòng đăng nhập lại để hệ thống cập nhật quyền truy cập của bạn.

<?php $__env->startComponent('mail::button', ['url' => config('app.url')]); ?>
Trang chủ
<?php echo $__env->renderComponent(); ?>

Trân trọng,<br>
<?php echo e(config('app.name')); ?>

<?php echo $__env->renderComponent(); ?>

<?php /**PATH E:\LARAGON\laragon\www\DATN\duAnTotNghiep_website_ban_quan_ao_STYLEX\resources\views\admin\mails\role_changed.blade.php ENDPATH**/ ?>