<?php $__env->startSection('title', 'Quản lý Trả/Đổi hàng'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1>Quản lý Trả/Đổi hàng</h1>
        </div>
        <div class="col-md-4 text-end">
            <a href="<?php echo e(route('admin.inventory.returns.create')); ?>" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Tạo yêu cầu mới
            </a>
        </div>
    </div>

    <?php if($message = Session::get('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo e($message); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>RMA #</th>
                        <th>Đơn hàng</th>
                        <th>Khách hàng</th>
                        <th>Loại</th>
                        <th>Lý do</th>
                        <th>Trạng thái</th>
                        <th>Ngày tạo</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $returns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $return): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><strong><?php echo e($return->rma_number); ?></strong></td>
                            <td><?php echo e($return->order->code); ?></td>
                            <td><?php echo e($return->user->name); ?></td>
                            <td>
                                <span class="badge bg-<?php echo e($return->type === 'RETURN' ? 'danger' : 'warning'); ?>">
                                    <?php echo e($return->type === 'RETURN' ? 'Trả hàng' : 'Đổi hàng'); ?>

                                </span>
                            </td>
                            <td><?php echo e($return->reason); ?></td>
                            <td>
                                <?php
                                    $statusColors = [
                                        'PENDING' => 'secondary',
                                        'APPROVED' => 'info',
                                        'REJECTED' => 'danger',
                                        'RECEIVED' => 'primary',
                                        'QC_PASSED' => 'success',
                                        'QC_FAILED' => 'danger',
                                        'COMPLETED' => 'success',
                                    ];
                                    $statusLabels = [
                                        'PENDING' => 'Chờ duyệt',
                                        'APPROVED' => 'Đã duyệt',
                                        'REJECTED' => 'Từ chối',
                                        'RECEIVED' => 'Đã nhận',
                                        'QC_PASSED' => 'QC Pass',
                                        'QC_FAILED' => 'QC Fail',
                                        'COMPLETED' => 'Hoàn thành',
                                    ];
                                ?>
                                <span class="badge bg-<?php echo e($statusColors[$return->status] ?? 'secondary'); ?>">
                                    <?php echo e($statusLabels[$return->status] ?? $return->status); ?>

                                </span>
                            </td>
                            <td><?php echo e($return->created_at->format('d/m/Y H:i')); ?></td>
                            <td>
                                <a href="<?php echo e(route('admin.inventory.returns.show', $return->id)); ?>" class="btn btn-sm btn-info">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="8" class="text-center py-4">Không có yêu cầu trả/đổi hàng</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="d-flex justify-content-center mt-4">
        <?php echo e($returns->links()); ?>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\duAnTotNghiep_website_ban_quan_ao_STYLEX-main\resources\views/admin/returns/index.blade.php ENDPATH**/ ?>