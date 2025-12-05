<?php $__env->startSection('title', 'Báo cáo Tồn kho'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <h2 class="h3 mb-3">Báo cáo & Thống kê Kho hàng</h2>

    <form action="<?php echo e(route('admin.inventory.reports')); ?>" method="GET" class="card p-2 mb-3">
        <div class="row g-2">
            <div class="col-md-2">
                <select name="time_range" class="form-select form-select-sm">
                    <option value="7" <?php echo e($timeRange == 7 ? 'selected' : ''); ?>>7 ngày</option>
                    <option value="30" <?php echo e($timeRange == 30 ? 'selected' : ''); ?>>30 ngày</option>
                    <option value="90" <?php echo e($timeRange == 90 ? 'selected' : ''); ?>>90 ngày</option>
                    <option value="365" <?php echo e($timeRange == 365 ? 'selected' : ''); ?>>1 năm</option>
                </select>
            </div>
            <div class="col-md-4">
                <select name="warehouse_id" class="form-select form-select-sm">
                    <option value="">-- Tất cả Kho --</option>
                    <?php $__currentLoopData = $warehouses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $warehouse): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($warehouse->id); ?>" <?php echo e(request('warehouse_id') == $warehouse->id ? 'selected' : ''); ?>>
                            <?php echo e($warehouse->name); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary btn-sm w-100">
                    <i class="bx bx-search"></i> Lọc
                </button>
            </div>
            <div class="col-md-3">
                <a href="<?php echo e(route('admin.inventory.current-stock')); ?>" class="btn btn-danger btn-sm w-100">
                    <i class="bx bx-alert"></i> Cảnh báo
                </a>
            </div>
        </div>
    </form>

    <div class="row g-3">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header bg-success text-white py-2">
                    <h6 class="mb-0"><i class="fas fa-rocket"></i> Top 5 Bán chạy</h6>
                </div>
                <div class="card-body p-2">
                    <?php if($fastMovingVariants->isEmpty()): ?>
                        <div class="alert alert-info mb-0 small">Không có giao dịch.</div>
                    <?php else: ?>
                        <ul class="list-group list-group-flush small">
                            <?php $__currentLoopData = $fastMovingVariants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $variant): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li class="list-group-item d-flex justify-content-between py-1">
                                    <span>#<?php echo e($loop->iteration); ?> <?php echo e($variant->sku); ?></span>
                                    <span class="badge bg-success"><?php echo e(number_format($variant->total_sold)); ?></span>
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card">
                <div class="card-header bg-info text-white py-2">
                    <h6 class="mb-0"><i class="fas fa-warehouse"></i> Giá trị Tồn kho</h6>
                </div>
                <div class="card-body p-2">
                    <?php if($inventoryValueByWarehouse->isEmpty()): ?>
                        <div class="alert alert-info mb-0 small">Không có dữ liệu.</div>
                    <?php else: ?>
                        <ul class="list-group list-group-flush small">
                            <?php $__currentLoopData = $inventoryValueByWarehouse; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $warehouse): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li class="list-group-item d-flex justify-content-between py-1">
                                    <span><?php echo e($warehouse->name); ?></span>
                                    <span class="badge bg-info"><?php echo e(number_format($warehouse->total_value)); ?>₫</span>
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .card-body { font-size: 0.875rem; }
    .list-group-item { padding: 0.4rem 0.75rem !important; }
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\duAnTotNghiep_website_ban_quan_ao_STYLEX-main\resources\views/admin/inventory/reports.blade.php ENDPATH**/ ?>