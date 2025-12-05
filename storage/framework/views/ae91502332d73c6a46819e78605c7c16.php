<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-md-6">
            <h4 class="mb-0"><i class="bx bx-check"></i> Xác Nhận QC - <?php echo e($request->batch_number); ?></h4>
        </div>
        <div class="col-md-6 text-end">
            <a href="<?php echo e(route('admin.inventory.stock-out.index')); ?>" class="btn btn-secondary btn-sm">
                <i class="bx bx-arrow-back"></i> Quay Lại
            </a>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-6">
                    <p><strong>Sản Phẩm:</strong> <?php echo e($request->variant->product->name); ?></p>
                    <p><strong>SKU:</strong> <?php echo e($request->variant->sku); ?></p>
                    <p><strong>Số Lượng Xuất:</strong> <?php echo e(number_format($request->quantity)); ?></p>
                    <p><strong>Giá Xuất:</strong> <?php echo e(number_format($request->cost_price, 0, ',', '.')); ?>đ</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Kho:</strong> <?php echo e($request->warehouse->name); ?></p>
                    <p><strong>Mã Lô:</strong> <?php echo e($request->batch_number); ?></p>
                    <p><strong>Ngày Xuất:</strong> <?php echo e($request->created_at->format('d/m/Y H:i')); ?></p>
                    <p><strong>Người Tạo:</strong> <?php echo e($request->createdBy->name ?? 'N/A'); ?></p>
                </div>
            </div>

            <form action="<?php echo e(route('admin.inventory.stock-out.confirm-qc', $request->id)); ?>" method="POST">
                <?php echo csrf_field(); ?>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Số Lượng Pass QC <span class="text-danger">*</span></label>
                        <input type="number" name="passed_qty" class="form-control <?php $__errorArgs = ['passed_qty'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                               value="<?php echo e(old('passed_qty', 0)); ?>" min="0" max="<?php echo e($request->quantity); ?>" required>
                        <?php $__errorArgs = ['passed_qty'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Số Lượng Fail QC <span class="text-danger">*</span></label>
                        <input type="number" name="failed_qty" class="form-control <?php $__errorArgs = ['failed_qty'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                               value="<?php echo e(old('failed_qty', 0)); ?>" min="0" max="<?php echo e($request->quantity); ?>" required>
                        <?php $__errorArgs = ['failed_qty'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>

                <div class="alert alert-info">
                    <strong>Lưu ý:</strong> Tổng số lượng Pass + Fail phải bằng <?php echo e($request->quantity); ?>

                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Người QC</label>
                        <input type="text" class="form-control" value="<?php echo e(auth()->user()->name); ?>" disabled>
                        <input type="hidden" name="qc_by" value="<?php echo e(auth()->id()); ?>">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Ghi Chú QC</label>
                    <textarea name="notes" class="form-control <?php $__errorArgs = ['notes'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" rows="3"><?php echo e(old('notes')); ?></textarea>
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
                        <i class="bx bx-check"></i> Xác Nhận QC
                    </button>
                    <a href="<?php echo e(route('admin.inventory.stock-out.index')); ?>" class="btn btn-secondary">
                        <i class="bx bx-x"></i> Hủy
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\duAnTotNghiep_website_ban_quan_ao_STYLEX-main\resources\views/admin/inventory/stock-out/qc.blade.php ENDPATH**/ ?>