<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-md-6">
            <h4 class="mb-0"><i class="bx bx-list-check"></i> Kiểm Kê</h4>
        </div>
        <div class="col-md-6 text-end">
            <a href="<?php echo e(route('admin.inventory.count.create')); ?>" class="btn btn-success btn-sm">
                <i class="bx bx-plus"></i> Tạo Yêu Cầu Kiểm Kê
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
                <strong>Quy trình Kiểm Kê:</strong>
                <ol class="mb-0 mt-2 ps-3 small">
                    <li>Tạo yêu cầu kiểm kê: Chọn kho, chọn sản phẩm cần kiểm</li>
                    <li>Đếm kho: Click "Đếm Kho" khi ở trạng thái "Chờ Đếm" - nhập số lượng thực tế (sẵn sàng, đã đặt, chờ QC, hỏng)</li>
                    <li>Xác nhận điều chỉnh: Click "Xác Nhận Điều Chỉnh" khi ở trạng thái "Đã Đếm" - hệ thống cập nhật tồn kho</li>
                </ol>
            </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-light py-2">
            <h6 class="mb-0">Danh Sách Yêu Cầu Kiểm Kê (<?php echo e($requests->total()); ?>)</h6>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Sản Phẩm</th>
                            <th class="text-end">Tồn Hệ Thống</th>
                            <th class="text-end">Tồn Thực Tế</th>
                            <th class="text-end">Chênh Lệch</th>
                            <th class="text-center">Sẵn Sàng</th>
                            <th class="text-center">Đã Đặt</th>
                            <th class="text-center">Chờ QC</th>
                            <th class="text-center">Hỏng</th>
                            <th>Trạng Thái</th>
                            <th>Người Đếm</th>
                            <th class="text-end">Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $requests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $request): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e($request->variant->product->name ?? 'N/A'); ?></td>
                                <td class="text-end"><?php echo e(number_format($request->system_qty)); ?></td>
                                <td class="text-end"><?php echo e($request->physical_qty ? number_format($request->physical_qty) : '-'); ?></td>
                                <td class="text-end">
                                    <?php if($request->difference !== null): ?>
                                        <span class="badge <?php echo e($request->difference > 0 ? 'bg-success' : ($request->difference < 0 ? 'bg-danger' : 'bg-secondary')); ?>">
                                            <?php echo e($request->difference > 0 ? '+' : ''); ?><?php echo e(number_format($request->difference)); ?>

                                        </span>
                                    <?php else: ?>
                                        -
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <small><?php echo e($request->available_qty !== null ? number_format($request->available_qty) : '-'); ?></small>
                                </td>
                                <td class="text-center">
                                    <small><?php echo e($request->reserved_qty !== null ? number_format($request->reserved_qty) : '-'); ?></small>
                                </td>
                                <td class="text-center">
                                    <small><?php echo e($request->quarantine_qty !== null ? number_format($request->quarantine_qty) : '-'); ?></small>
                                </td>
                                <td class="text-center">
                                    <small><?php echo e($request->damaged_qty !== null ? number_format($request->damaged_qty) : '-'); ?></small>
                                </td>
                                <td>
                                    <?php if($request->status === 'PENDING'): ?>
                                        <span class="badge bg-warning">Chờ Đếm</span>
                                    <?php elseif($request->status === 'COUNTED'): ?>
                                        <span class="badge bg-info">Đã Đếm</span>
                                    <?php elseif($request->status === 'CONFIRMED'): ?>
                                        <span class="badge bg-success">Hoàn Thành</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <small><?php echo e($request->countedBy?->name ?? '-'); ?></small>
                                </td>
                                <td class="text-end">
                                    <?php if($request->status === 'PENDING'): ?>
                                        <a href="<?php echo e(route('admin.inventory.count.count', $request->id)); ?>" class="btn btn-sm btn-info" title="Đếm Kho">
                                            <i class="bx bx-check"></i>
                                        </a>
                                    <?php elseif($request->status === 'COUNTED'): ?>
                                        <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#adjustmentModal<?php echo e($request->id); ?>" title="Xác Nhận Điều Chỉnh">
                                            <i class="bx bx-check-double"></i>
                                        </button>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">Hoàn Thành</span>
                                    <?php endif; ?>
                                </td>
                            </tr>

                            <?php if($request->status === 'COUNTED'): ?>
                                <div class="modal fade" id="adjustmentModal<?php echo e($request->id); ?>" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Xác Nhận Điều Chỉnh Kho</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <form action="<?php echo e(route('admin.inventory.count.confirm-adjustment', $request->id)); ?>" method="POST">
                                                <?php echo csrf_field(); ?>
                                                <div class="modal-body">
                                                    <p class="text-muted small mb-3">Sản phẩm: <strong><?php echo e($request->variant->product->name); ?></strong></p>
                                                    <div class="mb-3">
                                                        <label class="form-label">Số Lượng Sẵn Sàng <span class="text-danger">*</span></label>
                                                        <input type="number" name="available_qty" class="form-control" value="<?php echo e($request->available_qty ?? 0); ?>" min="0" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Số Lượng Đã Đặt <span class="text-danger">*</span></label>
                                                        <input type="number" name="reserved_qty" class="form-control" value="<?php echo e($request->reserved_qty ?? 0); ?>" min="0" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Số Lượng Chờ QC <span class="text-danger">*</span></label>
                                                        <input type="number" name="quarantine_qty" class="form-control" value="<?php echo e($request->quarantine_qty ?? 0); ?>" min="0" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Số Lượng Hỏng <span class="text-danger">*</span></label>
                                                        <input type="number" name="damaged_qty" class="form-control" value="<?php echo e($request->damaged_qty ?? 0); ?>" min="0" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Ghi Chú</label>
                                                        <textarea name="notes" class="form-control" rows="2" placeholder="Ghi chú thêm..."><?php echo e($request->notes); ?></textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                                    <button type="submit" class="btn btn-success">Xác Nhận</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="11" class="text-center text-muted py-4">
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
        <?php echo e($requests->links()); ?>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\duAnTotNghiep_website_ban_quan_ao_STYLEX-main\resources\views/admin/inventory/count/index.blade.php ENDPATH**/ ?>