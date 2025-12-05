<?php $__env->startSection('title', 'Đánh Giá Hàng Hỏng'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-md-6">
            <h4 class="mb-0"><i class="bi bi-check"></i> Đánh Giá Hàng Hỏng - <?php echo e($defect->variant->product->name); ?></h4>
        </div>
        <div class="col-md-6 text-end">
            <a href="<?php echo e(route('admin.inventory.defect.index')); ?>" class="btn btn-secondary btn-sm">
                <i class="bi bi-arrow-left"></i> Quay Lại
            </a>
        </div>
    </div>

    <div class="card shadow-sm mb-3">
        <div class="card-header bg-light">
            <h5 class="mb-0">Thông Tin Báo Cáo</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Sản Phẩm:</strong> <?php echo e($defect->variant->product->name); ?></p>
                    <p><strong>SKU:</strong> <?php echo e($defect->variant->sku); ?></p>
                    <p><strong>Kho:</strong> <?php echo e($defect->warehouse->name); ?></p>
                </div>
                <div class="col-md-6">
                    <p><strong>Số Lượng Hỏng:</strong> <span class="badge bg-warning"><?php echo e(number_format($defect->quantity)); ?></span></p>
                    <p><strong>Mức Độ:</strong> 
                        <span class="badge bg-<?php echo e($defect->defect_level === 'LIGHT' ? 'info' : ($defect->defect_level === 'MEDIUM' ? 'warning' : 'danger')); ?>">
                            <?php echo e($defect->defect_level); ?>

                        </span>
                    </p>
                    <p><strong>Trạng Thái:</strong> <span class="badge bg-primary"><?php echo e($defect->status); ?></span></p>
                </div>
            </div>
            <?php if($defect->description): ?>
                <div class="mt-3">
                    <p><strong>Mô Tả Chi Tiết:</strong></p>
                    <p class="text-muted"><?php echo e($defect->description); ?></p>
                </div>
            <?php endif; ?>
            <div class="mt-3">
                <p><strong>Người Báo Cáo:</strong> <?php echo e($defect->createdBy->name ?? 'N/A'); ?> - <?php echo e($defect->created_at->format('d/m/Y H:i')); ?></p>
            </div>
        </div>
    </div>

    <?php if($defect->status === 'PENDING'): ?>
    <div class="card shadow-sm">
        <div class="card-header bg-light">
            <h5 class="mb-0">Đánh Giá Hàng Hỏng</h5>
        </div>
        <div class="card-body">
            <div class="alert alert-info">
                <strong>Hướng dẫn:</strong> Nhập loại lỗi, mô tả chi tiết và phân loại xử lý hàng hỏng
            </div>

            <form action="<?php echo e(route('admin.inventory.defect.confirm-assess', $defect->id)); ?>" method="POST">
                <?php echo csrf_field(); ?>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Loại Lỗi <span class="text-danger">*</span></label>
                        <input type="text" name="defect_type" class="form-control <?php $__errorArgs = ['defect_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                               placeholder="VD: Nước, Xước, Lỗi may..." value="<?php echo e(old('defect_type', $defect->defect_type)); ?>" required>
                        <?php $__errorArgs = ['defect_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Phân Loại <span class="text-danger">*</span></label>
                        <select name="classification" class="form-select <?php $__errorArgs = ['classification'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                            <option value="">-- Chọn phân loại --</option>
                            <option value="REWORK" <?php echo e(old('classification', $defect->classification) === 'REWORK' ? 'selected' : ''); ?>>Sửa Chữa</option>
                            <option value="B-GRADE" <?php echo e(old('classification', $defect->classification) === 'B-GRADE' ? 'selected' : ''); ?>>Hàng Loại B</option>
                            <option value="SCRAP" <?php echo e(old('classification', $defect->classification) === 'SCRAP' ? 'selected' : ''); ?>>Thanh Lý</option>
                        </select>
                        <?php $__errorArgs = ['classification'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Mô Tả Lỗi <span class="text-danger">*</span></label>
                    <textarea name="defect_description" class="form-control <?php $__errorArgs = ['defect_description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                              rows="3" placeholder="Mô tả chi tiết lỗi..." required><?php echo e(old('defect_description', $defect->defect_description)); ?></textarea>
                    <?php $__errorArgs = ['defect_description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="mb-3">
                    <label class="form-label">Ghi Chú</label>
                    <textarea name="notes" class="form-control <?php $__errorArgs = ['notes'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                              rows="3" placeholder="Ghi chú thêm..."><?php echo e(old('notes', $defect->notes)); ?></textarea>
                    <?php $__errorArgs = ['notes'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-check"></i> Xác Nhận Đánh Giá
                    </button>
                    <a href="<?php echo e(route('admin.inventory.defect.index')); ?>" class="btn btn-secondary">
                        <i class="bi bi-x"></i> Hủy
                    </a>
                </div>
            </form>
        </div>
    </div>

    <?php elseif($defect->status === 'ASSESSED'): ?>
    <div class="card shadow-sm">
        <div class="card-header bg-light">
            <h5 class="mb-0">Phê Duyệt Xử Lý</h5>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-6">
                    <p><strong>Loại Lỗi:</strong> <?php echo e($defect->defect_type); ?></p>
                    <p><strong>Phân Loại:</strong>
                        <?php if($defect->classification === 'REWORK'): ?>
                            <span class="badge bg-primary">Sửa Chữa</span>
                        <?php elseif($defect->classification === 'B-GRADE'): ?>
                            <span class="badge bg-secondary">Hàng Loại B</span>
                        <?php elseif($defect->classification === 'SCRAP'): ?>
                            <span class="badge bg-dark">Thanh Lý</span>
                        <?php endif; ?>
                    </p>
                </div>
                <div class="col-md-6">
                    <p><strong>Người Đánh Giá:</strong> <?php echo e($defect->assessedBy->name ?? 'N/A'); ?></p>
                    <p><strong>Thời Gian:</strong> <?php echo e($defect->updated_at->format('d/m/Y H:i')); ?></p>
                </div>
            </div>

            <div class="mb-3">
                <p><strong>Mô Tả Lỗi:</strong></p>
                <p class="text-muted"><?php echo e($defect->defect_description); ?></p>
            </div>

            <div class="mb-3">
                <p><strong>Ghi Chú:</strong></p>
                <p class="text-muted"><?php echo e($defect->notes ?? 'Không có ghi chú'); ?></p>
            </div>

            <div class="d-flex gap-2">
                <form action="<?php echo e(route('admin.inventory.defect.approve', $defect->id)); ?>" method="POST" style="display: inline;">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-check-circle"></i> Phê Duyệt
                    </button>
                </form>
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal">
                    <i class="bi bi-x-circle"></i> Từ Chối
                </button>
                <a href="<?php echo e(route('admin.inventory.defect.index')); ?>" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Quay Lại
                </a>
            </div>
        </div>
    </div>

    <?php elseif($defect->status === 'APPROVED'): ?>
    <div class="card shadow-sm">
        <div class="card-header bg-light">
            <h5 class="mb-0">Hoàn Thành Xử Lý</h5>
        </div>
        <div class="card-body">
            <div class="alert alert-info">
                <strong>Hướng dẫn:</strong> Nhập chi phí sửa chữa, vật tư và chi phí phát sinh để hoàn thành xử lý
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <p><strong>Loại Lỗi:</strong> <?php echo e($defect->defect_type); ?></p>
                    <p><strong>Phân Loại:</strong>
                        <?php if($defect->classification === 'REWORK'): ?>
                            <span class="badge bg-primary">Sửa Chữa</span>
                        <?php elseif($defect->classification === 'B-GRADE'): ?>
                            <span class="badge bg-secondary">Hàng Loại B</span>
                        <?php elseif($defect->classification === 'SCRAP'): ?>
                            <span class="badge bg-dark">Thanh Lý</span>
                        <?php endif; ?>
                    </p>
                </div>
                <div class="col-md-6">
                    <p><strong>Người Phê Duyệt:</strong> <?php echo e($defect->approvedBy->name ?? 'N/A'); ?></p>
                    <p><strong>Thời Gian:</strong> <?php echo e($defect->updated_at->format('d/m/Y H:i')); ?></p>
                </div>
            </div>

            <form action="<?php echo e(route('admin.inventory.defect.complete', $defect->id)); ?>" method="POST">
                <?php echo csrf_field(); ?>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Chi Phí Sửa Chữa (VNĐ)</label>
                        <input type="number" name="repair_cost" class="form-control <?php $__errorArgs = ['repair_cost'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                               step="1" min="0" value="<?php echo e(old('repair_cost', $defect->repair_cost ?? 0)); ?>" placeholder="0">
                        <?php $__errorArgs = ['repair_cost'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Chi Phí Vật Tư (VNĐ)</label>
                        <input type="number" name="material_cost" class="form-control <?php $__errorArgs = ['material_cost'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                               step="1" min="0" value="<?php echo e(old('material_cost', $defect->material_cost ?? 0)); ?>" placeholder="0">
                        <?php $__errorArgs = ['material_cost'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Chi Phí Phát Sinh (VNĐ)</label>
                        <input type="number" name="other_cost" class="form-control <?php $__errorArgs = ['other_cost'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                               step="1" min="0" value="<?php echo e(old('other_cost', $defect->other_cost ?? 0)); ?>" placeholder="0">
                        <?php $__errorArgs = ['other_cost'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Ghi Chú</label>
                    <textarea name="notes" class="form-control <?php $__errorArgs = ['notes'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                              rows="3" placeholder="Nhập ghi chú..."><?php echo e(old('notes', $defect->notes)); ?></textarea>
                    <?php $__errorArgs = ['notes'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="alert alert-info">
                    <strong>Tổng Chi Phí:</strong> <span class="badge bg-primary" id="total-cost">0 VNĐ</span>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-check"></i> Hoàn Thành
                    </button>
                    <a href="<?php echo e(route('admin.inventory.defect.index')); ?>" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Quay Lại
                    </a>
                </div>
            </form>
        </div>
    </div>

    <?php elseif($defect->status === 'COMPLETED'): ?>
    <div class="card shadow-sm">
        <div class="card-header bg-light">
            <h5 class="mb-0">Đã Hoàn Thành</h5>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-6">
                    <p><strong>Loại Lỗi:</strong> <?php echo e($defect->defect_type); ?></p>
                    <p><strong>Phân Loại:</strong>
                        <?php if($defect->classification === 'REWORK'): ?>
                            <span class="badge bg-primary">Sửa Chữa</span>
                        <?php elseif($defect->classification === 'B-GRADE'): ?>
                            <span class="badge bg-secondary">Hàng Loại B</span>
                        <?php elseif($defect->classification === 'SCRAP'): ?>
                            <span class="badge bg-dark">Thanh Lý</span>
                        <?php endif; ?>
                    </p>
                </div>
                <div class="col-md-6">
                    <p><strong>Người Hoàn Thành:</strong> <?php echo e($defect->completedBy->name ?? 'N/A'); ?></p>
                    <p><strong>Thời Gian:</strong> <?php echo e($defect->updated_at->format('d/m/Y H:i')); ?></p>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4">
                    <p><strong>Chi Phí Sửa Chữa:</strong> <?php echo e(number_format($defect->repair_cost ?? 0)); ?> VNĐ</p>
                </div>
                <div class="col-md-4">
                    <p><strong>Chi Phí Vật Tư:</strong> <?php echo e(number_format($defect->material_cost ?? 0)); ?> VNĐ</p>
                </div>
                <div class="col-md-4">
                    <p><strong>Chi Phí Phát Sinh:</strong> <?php echo e(number_format($defect->other_cost ?? 0)); ?> VNĐ</p>
                </div>
            </div>

            <div class="alert alert-success">
                <strong>Tổng Chi Phí:</strong> <?php echo e(number_format(($defect->repair_cost ?? 0) + ($defect->material_cost ?? 0) + ($defect->other_cost ?? 0))); ?> VNĐ
            </div>

            <div class="mb-3">
                <p><strong>Ghi Chú:</strong></p>
                <p class="text-muted"><?php echo e($defect->notes ?? 'Không có ghi chú'); ?></p>
            </div>

            <a href="<?php echo e(route('admin.inventory.defect.index')); ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Quay Lại
            </a>
        </div>
    </div>

    <?php elseif($defect->status === 'REJECTED'): ?>
    <div class="card shadow-sm">
        <div class="card-header bg-light">
            <h5 class="mb-0">Đã Từ Chối</h5>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-6">
                    <p><strong>Loại Lỗi:</strong> <?php echo e($defect->defect_type); ?></p>
                    <p><strong>Phân Loại:</strong>
                        <?php if($defect->classification === 'REWORK'): ?>
                            <span class="badge bg-primary">Sửa Chữa</span>
                        <?php elseif($defect->classification === 'B-GRADE'): ?>
                            <span class="badge bg-secondary">Hàng Loại B</span>
                        <?php elseif($defect->classification === 'SCRAP'): ?>
                            <span class="badge bg-dark">Thanh Lý</span>
                        <?php endif; ?>
                    </p>
                </div>
                <div class="col-md-6">
                    <p><strong>Người Từ Chối:</strong> <?php echo e($defect->rejectedBy->name ?? 'N/A'); ?></p>
                    <p><strong>Thời Gian:</strong> <?php echo e($defect->updated_at->format('d/m/Y H:i')); ?></p>
                </div>
            </div>

            <div class="alert alert-danger">
                <strong>Lý Do Từ Chối:</strong><br>
                <?php echo e($defect->rejection_reason); ?>

            </div>

            <a href="<?php echo e(route('admin.inventory.defect.index')); ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Quay Lại
            </a>
        </div>
    </div>
    <?php endif; ?>
</div>

<!-- Modal Từ Chối -->
<div class="modal fade" id="rejectModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Từ Chối Đánh Giá</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?php echo e(route('admin.inventory.defect.reject', $defect->id)); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Lý Do Từ Chối <span class="text-danger">*</span></label>
                        <textarea name="rejection_reason" class="form-control <?php $__errorArgs = ['rejection_reason'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                  rows="4" placeholder="Nhập lý do từ chối..." required><?php echo e(old('rejection_reason')); ?></textarea>
                        <?php $__errorArgs = ['rejection_reason'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-danger">Từ Chối</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const repairCostInput = document.querySelector('input[name="repair_cost"]');
    const materialCostInput = document.querySelector('input[name="material_cost"]');
    const otherCostInput = document.querySelector('input[name="other_cost"]');
    const totalCostDisplay = document.getElementById('total-cost');

    function updateTotalCost() {
        if (repairCostInput && materialCostInput && otherCostInput && totalCostDisplay) {
            const repairCost = parseInt(repairCostInput.value) || 0;
            const materialCost = parseInt(materialCostInput.value) || 0;
            const otherCost = parseInt(otherCostInput.value) || 0;
            const total = repairCost + materialCost + otherCost;
            totalCostDisplay.textContent = total.toLocaleString('vi-VN') + ' VNĐ';
        }
    }

    if (repairCostInput) repairCostInput.addEventListener('input', updateTotalCost);
    if (materialCostInput) materialCostInput.addEventListener('input', updateTotalCost);
    if (otherCostInput) otherCostInput.addEventListener('input', updateTotalCost);
    
    updateTotalCost();
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\duAnTotNghiep_website_ban_quan_ao_STYLEX-main\resources\views/admin/inventory/defect/assess.blade.php ENDPATH**/ ?>