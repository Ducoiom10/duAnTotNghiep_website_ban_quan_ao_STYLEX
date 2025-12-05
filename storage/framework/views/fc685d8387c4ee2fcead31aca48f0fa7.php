<?php $__env->startSection('title', 'Quản lý voucher'); ?>
<?php $__env->startPush('page-css'); ?>
    <link href="<?php echo e(asset('assets/css/custom.css')); ?>" rel="stylesheet" type="text/css" />
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Quản lý voucher</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item active"><a href="javascript:void(0);">Khuyến mãi</a></li>
                    <li class="breadcrumb-item">Voucher</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="col-12 d-flex justify-content-end mb-3">
        <a href="<?php echo e(route('admin.vouchers.create')); ?>" class="btn btn-success"><i class="ri-add-line align-bottom me-1"></i> Tạo voucher</a>
    </div>

    <!-- Stats -->
    <div class="row cursor-pointer mb-3">
        <div class="col-12 col-sm-6 col-md-3 mb-3">
            <div class="card stats-card total-card">
                <div class="card-body text-center">
                    <div class="stat-icon text-primary"><i class="ri-ticket-2-line"></i></div>
                    <h5 class="card-title text-muted mb-2">Tổng số voucher</h5>
                    <h3 class="card-text fw-bold"><?php echo e($stats['total'] ?? 0); ?></h3>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-3 mb-3">
            <div class="card stats-card approved-card">
                <div class="card-body text-center">
                    <div class="stat-icon text-success"><i class="ri-checkbox-circle-line"></i></div>
                    <h5 class="card-title text-muted mb-2">Đang kích hoạt</h5>
                    <h3 class="card-text fw-bold text-success"><?php echo e($stats['active'] ?? 0); ?></h3>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-3 mb-3">
            <div class="card stats-card pending-card">
                <div class="card-body text-center">
                    <div class="stat-icon text-info"><i class="ri-time-line"></i></div>
                    <h5 class="card-title text-muted mb-2">Hiệu lực hiện tại</h5>
                    <h3 class="card-text fw-bold text-info"><?php echo e($stats['valid_now'] ?? 0); ?></h3>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-3 mb-3">
            <div class="card stats-card parent-card">
                <div class="card-body text-center">
                    <div class="stat-icon text-warning"><i class="ri-percent-line"></i></div>
                    <h5 class="card-title text-muted mb-2">Theo loại (%)</h5>
                    <h3 class="card-text fw-bold text-warning"><?php echo e($stats['percent_type'] ?? 0); ?></h3>
                </div>
            </div>
        </div>
    </div>

    

    <div class="col-12">
    <div class="card">
        <div class="card-body table-responsive">
            <table class="table table-striped mb-0">
                <thead>
                    <tr>
                        <th>Mã</th>
                        <th>Loại</th>
                        <th>Giá trị</th>
                        <th>Giảm tối đa</th>
                        <th>Giới hạn lượt</th>
                        <th>Đã dùng</th>
                        <th>Trạng thái</th>
                        <th>Hiệu lực</th>
                        <th class="text-end">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $vouchers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $voucher): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><strong><?php echo e($voucher->code); ?></strong></td>
                            <td><?php echo e($voucher->type === 'percent' ? 'Phần trăm' : 'Cố định'); ?></td>
                            <td>
                                <?php if($voucher->type === 'percent'): ?>
                                    <?php echo e(rtrim(rtrim(number_format($voucher->value, 2), '0'), '.')); ?>%
                                <?php else: ?>
                                    <?php echo e(number_format($voucher->value, 0, ',', '.')); ?> ₫
                                <?php endif; ?>
                            </td>
                            <td><?php echo e($voucher->max_discount_amount ? number_format($voucher->max_discount_amount, 0, ',', '.') . ' ₫' : '—'); ?></td>
                            <td><?php echo e($voucher->usage_limit ?? '—'); ?></td>
                            <td><?php echo e($voucher->used_count); ?></td>
                            <td>
                                <span class="badge <?php echo e($voucher->is_active ? 'bg-success' : 'bg-secondary'); ?>"><?php echo e($voucher->is_active ? 'Kích hoạt' : 'Tắt'); ?></span>
                            </td>
                            <td>
                                <?php if($voucher->starts_at): ?> <?php echo e($voucher->starts_at->format('d/m/Y')); ?> <?php endif; ?>
                                -
                                <?php if($voucher->ends_at): ?> <?php echo e($voucher->ends_at->format('d/m/Y')); ?> <?php endif; ?>
                            </td>
                            <td class="text-end">
                                <a href="<?php echo e(route('admin.vouchers.edit', $voucher)); ?>" class="btn btn-sm btn-outline-primary">Sửa</a>
                                <form action="<?php echo e(route('admin.vouchers.destroy', $voucher)); ?>" method="POST" class="d-inline" onsubmit="return confirm('Xóa voucher này?');">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button class="btn btn-sm btn-outline-danger">Xóa</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr><td colspan="8" class="text-center p-4">Chưa có voucher</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="card-footer"><?php echo e($vouchers->links('pagination::bootstrap-5')); ?></div>
    </div>
    </div>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\LARAGON\laragon\www\DATN\duAnTotNghiep_website_ban_quan_ao_STYLEX\resources\views\admin\vouchers\index.blade.php ENDPATH**/ ?>