<?php $__env->startSection('title', 'Thông báo'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Thông báo</h1>
        <?php if($notifications->where('read_at', null)->count() > 0): ?>
            <a href="<?php echo e(route('admin.notifications.mark-all-read')); ?>" class="btn btn-sm btn-primary">Đánh dấu tất cả là đã đọc</a>
        <?php endif; ?>
    </div>

    <div class="card shadow">
        <div class="card-body">
            <?php if($notifications->isEmpty()): ?>
                <div class="alert alert-info">Không có thông báo nào.</div>
            <?php else: ?>
                <div class="list-group">
                    <?php $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notif): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="list-group-item <?php echo e(is_null($notif->read_at) ? 'bg-light' : ''); ?>">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">
                                        <span class="badge bg-<?php echo e($notif->type === 'low_stock' ? 'danger' : 'info'); ?>"><?php echo e($notif->type); ?></span>
                                        <?php echo e($notif->title); ?>

                                    </h6>
                                    <p class="mb-1"><?php echo e($notif->message); ?></p>
                                    <small class="text-muted"><?php echo e($notif->created_at->diffForHumans()); ?></small>
                                </div>
                                <?php if(is_null($notif->read_at)): ?>
                                    <a href="<?php echo e(route('admin.notifications.mark-read', $notif->id)); ?>" class="btn btn-sm btn-outline-primary">Đánh dấu đã đọc</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                <div class="mt-4">
                    <?php echo e($notifications->links()); ?>

                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\duAnTotNghiep_website_ban_quan_ao_STYLEX-main\resources\views/admin/notifications/index.blade.php ENDPATH**/ ?>