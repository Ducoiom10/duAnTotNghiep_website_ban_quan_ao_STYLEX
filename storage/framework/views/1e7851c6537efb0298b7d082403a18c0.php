<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-md-6">
            <h4 class="mb-0"><i class="bx bx-transfer"></i> Chuyển Kho</h4>
        </div>
        <div class="col-md-6 text-end">
            <a href="<?php echo e(route('admin.inventory.transfer.create')); ?>" class="btn btn-success btn-sm">
                <i class="bx bx-plus"></i> Tạo Yêu Cầu Chuyển
            </a>
        </div>
    </div>

    <?php if($message = Session::get('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bx bx-check-circle"></i> <?php echo e($message); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if($message = Session::get('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bx bx-x-circle"></i> <?php echo e($message); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="alert alert-info alert-dismissible fade show" role="alert">
        <div class="d-flex gap-2">
            <i class="bx bx-info-circle fs-5 mt-1"></i>
            <div>
                <strong>Quy trình Chuyển Kho:</strong>
                <ol class="mb-0 mt-2 ps-3 small">
                    <li>Tạo yêu cầu chuyển: Chọn kho nguồn, kho đích, sản phẩm, số lượng</li>
                    <li>Xác nhận xuất: Click "Xác Nhận Xuất" khi ở trạng thái "Chờ Xuất" - hàng trừ khỏi kho nguồn</li>
                    <li>Xác nhận nhập: Click "Xác Nhận Nhập" khi ở trạng thái "Đã Xuất" - hàng cộng vào kho đích</li>
                </ol>
            </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-light py-2">
            <h6 class="mb-0">Danh Sách Yêu Cầu Chuyển Kho (<?php echo e($movements->total()); ?>)</h6>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Sản Phẩm</th>
                            <th>Từ Kho</th>
                            <th>Đến Kho</th>
                            <th class="text-end">Số Lượng</th>
                            <th>Ghi Chú</th>
                            <th>Trạng Thái</th>
                            <th class="text-end">Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $movements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $request): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e($request->variant->product->name ?? 'N/A'); ?></td>
                                <td><?php echo e($request->fromWarehouse->name); ?></td>
                                <td><?php echo e($request->toWarehouse->name); ?></td>
                                <td class="text-end"><?php echo e(number_format($request->quantity)); ?></td>
                                <td>
                                    <?php if($request->notes): ?>
                                        <span title="<?php echo e($request->notes); ?>" class="text-truncate d-inline-block" style="max-width: 150px;"><?php echo e($request->notes); ?></span>
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if($request->status === 'PENDING'): ?>
                                        <span class="badge bg-warning">Chờ Xuất</span>
                                    <?php elseif($request->status === 'OUT_CONFIRMED'): ?>
                                        <span class="badge bg-info">Đã Xuất</span>
                                    <?php elseif($request->status === 'COMPLETED'): ?>
                                        <span class="badge bg-success">Hoàn Thành</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-end">
                                    <?php if($request->status === 'PENDING'): ?>
                                        <form action="<?php echo e(route('admin.inventory.transfer.confirm-out', $request->id)); ?>" method="POST" style="display:inline;">
                                            <?php echo csrf_field(); ?>
                                            <button type="submit" class="btn btn-sm btn-info" title="Xác Nhận Xuất" onclick="return confirm('Xác nhận xuất kho?')">
                                                <i class="bx bx-upload"></i>
                                            </button>
                                        </form>
                                    <?php elseif($request->status === 'OUT_CONFIRMED'): ?>
                                        <form action="<?php echo e(route('admin.inventory.transfer.confirm-in', $request->id)); ?>" method="POST" style="display:inline;">
                                            <?php echo csrf_field(); ?>
                                            <button type="submit" class="btn btn-sm btn-success" title="Xác Nhận Nhập" onclick="return confirm('Xác nhận nhập kho?')">
                                                <i class="bx bx-download"></i>
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">
                                    <i class="bx bx-inbox"></i> Không có yêu cầu nào
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-center mt-3">
        <?php echo e($movements->links()); ?>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\duAnTotNghiep_website_ban_quan_ao_STYLEX-main\resources\views/admin/inventory/transfer/index.blade.php ENDPATH**/ ?>