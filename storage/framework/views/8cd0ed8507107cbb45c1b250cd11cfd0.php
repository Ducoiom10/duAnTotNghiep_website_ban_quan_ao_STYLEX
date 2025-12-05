<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-md-6">
            <h4 class="mb-0"><i class="bx bx-error-circle"></i> Xử Lý Hàng Hỏng</h4>
        </div>
        <div class="col-md-6 text-end">
            <a href="<?php echo e(route('admin.inventory.defect.create')); ?>" class="btn btn-success btn-sm">
                <i class="bx bx-plus"></i> Báo Cáo Hàng Hỏng
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
                <strong>Quy trình Xử Lý Hàng Hỏng:</strong>
                <ol class="mb-0 mt-2 ps-3 small">
                    <li>Báo cáo hàng hỏng: Tạo báo cáo với số lượng và mức độ hỏng</li>
                    <li>Đánh giá: Click "Đánh Giá" khi ở trạng thái "Chờ Đánh Giá" - nhập loại lỗi, mô tả, phân loại</li>
                    <li>Phê duyệt: Click "Phê Duyệt" khi ở trạng thái "Chờ Phê Duyệt" - QC xác nhận</li>
                    <li>Hoàn thành: Click "Hoàn Thành" khi ở trạng thái "Đã Phê Duyệt" - nhập chi phí xử lý</li>
                </ol>
            </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-light py-2">
            <h6 class="mb-0">Danh Sách Báo Cáo Hàng Hỏng (<?php echo e($assessments->total()); ?>)</h6>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Sản Phẩm</th>
                            <th class="text-end">Số Lượng</th>
                            <th>Mức Độ</th>
                            <th>Phân Loại</th>
                            <th>Loại Lỗi</th>
                            <th>Trạng Thái</th>
                            <th>Người Báo Cáo</th>
                            <th class="text-end">Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $assessments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $assessment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e($assessment->variant->product->name ?? 'N/A'); ?></td>
                                <td class="text-end"><span class="badge bg-warning"><?php echo e(number_format($assessment->quantity)); ?></span></td>
                                <td>
                                    <span class="badge bg-<?php echo e($assessment->defect_level === 'LIGHT' ? 'info' : ($assessment->defect_level === 'MEDIUM' ? 'warning' : 'danger')); ?>">
                                        <?php echo e($assessment->defect_level); ?>

                                    </span>
                                </td>
                                <td>
                                    <?php if($assessment->classification === 'REWORK'): ?>
                                        <span class="badge bg-primary">Sửa Chữa</span>
                                    <?php elseif($assessment->classification === 'B-GRADE'): ?>
                                        <span class="badge bg-secondary">Hàng Loại B</span>
                                    <?php elseif($assessment->classification === 'SCRAP'): ?>
                                        <span class="badge bg-dark">Tiêu Hủy</span>
                                    <?php else: ?>
                                        <span class="badge bg-light text-dark">-</span>
                                    <?php endif; ?>
                                </td>
                                <td><small><?php echo e($assessment->defect_type ?? '-'); ?></small></td>
                                <td>
                                    <?php if($assessment->status === 'PENDING'): ?>
                                        <span class="badge bg-secondary">Chờ Đánh Giá</span>
                                    <?php elseif($assessment->status === 'ASSESSED'): ?>
                                        <span class="badge bg-warning">Chờ Phê Duyệt</span>
                                    <?php elseif($assessment->status === 'APPROVED'): ?>
                                        <span class="badge bg-info">Đã Phê Duyệt</span>
                                    <?php elseif($assessment->status === 'COMPLETED'): ?>
                                        <span class="badge bg-success">Hoàn Thành</span>
                                    <?php elseif($assessment->status === 'REJECTED'): ?>
                                        <span class="badge bg-danger">Từ Chối</span>
                                    <?php endif; ?>
                                </td>
                                <td><small><?php echo e($assessment->createdBy->name ?? 'N/A'); ?></small></td>
                                <td class="text-end">
                                    <?php if($assessment->status === 'PENDING'): ?>
                                        <a href="<?php echo e(route('admin.inventory.defect.assess', $assessment->id)); ?>" class="btn btn-sm btn-primary" title="Đánh Giá">
                                            <i class="bx bx-check"></i>
                                        </a>
                                    <?php elseif($assessment->status === 'ASSESSED'): ?>
                                        <a href="<?php echo e(route('admin.inventory.defect.assess', $assessment->id)); ?>" class="btn btn-sm btn-warning" title="Phê Duyệt">
                                            <i class="bx bx-check-double"></i>
                                        </a>
                                    <?php elseif($assessment->status === 'APPROVED'): ?>
                                        <a href="<?php echo e(route('admin.inventory.defect.assess', $assessment->id)); ?>" class="btn btn-sm btn-success" title="Hoàn Thành">
                                            <i class="bx bx-check-circle"></i>
                                        </a>
                                    <?php else: ?>
                                        <a href="<?php echo e(route('admin.inventory.defect.assess', $assessment->id)); ?>" class="btn btn-sm btn-secondary" title="Xem Chi Tiết">
                                            <i class="bx bx-show"></i>
                                        </a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="8" class="text-center text-muted py-4">
                                    <i class="bx bx-inbox"></i> Không có báo cáo nào
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-center mt-3">
        <?php echo e($assessments->links()); ?>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\duAnTotNghiep_website_ban_quan_ao_STYLEX-main\resources\views/admin/inventory/defect/index.blade.php ENDPATH**/ ?>