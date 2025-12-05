<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-md-6">
            <h4 class="mb-0"><i class="bx bx-history"></i> Lịch Sử Kho</h4>
        </div>
    </div>

    <div class="card shadow-sm mb-3">
        <div class="card-body">
            <form method="GET" class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Kho Hàng</label>
                    <select name="warehouse_id" class="form-select">
                        <option value="">-- Tất Cả --</option>
                        <?php $__currentLoopData = $warehouses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $warehouse): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($warehouse->id); ?>" <?php echo e(request('warehouse_id') == $warehouse->id ? 'selected' : ''); ?>>
                                <?php echo e($warehouse->name); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Hành Động</label>
                    <select name="action" class="form-select">
                        <option value="">-- Tất Cả --</option>
                        <option value="IN" <?php echo e(request('action') === 'IN' ? 'selected' : ''); ?>>Nhập</option>
                        <option value="OUT" <?php echo e(request('action') === 'OUT' ? 'selected' : ''); ?>>Xuất</option>
                        <option value="TRANSFER" <?php echo e(request('action') === 'TRANSFER' ? 'selected' : ''); ?>>Chuyển</option>
                        <option value="ADJUSTMENT" <?php echo e(request('action') === 'ADJUSTMENT' ? 'selected' : ''); ?>>Điều Chỉnh</option>
                    </select>
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bx bx-search"></i> Tìm Kiếm
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-light py-2">
            <h6 class="mb-0">Danh Sách Lịch Sử Giao Dịch (<?php echo e($logs->total()); ?>)</h6>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Ngày</th>
                            <th>Sản Phẩm</th>
                            <th>Kho</th>
                            <th>Hành Động</th>
                            <th class="text-end">Trước</th>
                            <th class="text-end">Thay Đổi</th>
                            <th class="text-end">Sau</th>
                            <th>Tham Chiếu</th>
                            <th>Người Thực Hiện</th>
                            <th>Ghi Chú</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $logs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e($log->created_at->format('d/m/Y H:i')); ?></td>
                                <td><?php echo e($log->variant->product->name ?? 'N/A'); ?></td>
                                <td><?php echo e($log->warehouse->name); ?></td>
                                <td>
                                    <?php if($log->action === 'IN'): ?>
                                        <span class="badge bg-success">Nhập</span>
                                    <?php elseif($log->action === 'OUT'): ?>
                                        <span class="badge bg-danger">Xuất</span>
                                    <?php elseif($log->action === 'TRANSFER'): ?>
                                        <span class="badge bg-info">Chuyển</span>
                                    <?php elseif($log->action === 'ADJUSTMENT'): ?>
                                        <span class="badge bg-warning">Điều Chỉnh</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-end"><?php echo e(number_format($log->quantity_before)); ?></td>
                                <td class="text-end">
                                    <span class="<?php echo e($log->quantity_change > 0 ? 'text-success' : 'text-danger'); ?>">
                                        <?php echo e($log->quantity_change > 0 ? '+' : ''); ?><?php echo e(number_format($log->quantity_change)); ?>

                                    </span>
                                </td>
                                <td class="text-end"><?php echo e(number_format($log->quantity_after)); ?></td>
                                <td>
                                    <small><?php echo e($log->reference_type); ?>: <?php echo e($log->reference_id); ?></small>
                                </td>
                                <td><?php echo e($log->user->name ?? 'N/A'); ?></td>
                                <td><?php echo e($log->notes); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="10" class="text-center text-muted py-4">
                                    <i class="bx bx-inbox"></i> Không có lịch sử nào
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-center mt-3">
        <?php echo e($logs->links()); ?>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\duAnTotNghiep_website_ban_quan_ao_STYLEX-main\resources\views/admin/inventory/log-history.blade.php ENDPATH**/ ?>