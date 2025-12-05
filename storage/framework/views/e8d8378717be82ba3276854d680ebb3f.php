<?php $__env->startSection('title', 'Chỉnh sửa Hạng thành viên: ' . $loyaltyTier->name); ?>

<?php $__env->startPush('page-css'); ?>
    <link href="<?php echo e(asset('assets/css/custom.css')); ?>" rel="stylesheet" type="text/css" />
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Chỉnh sửa hạng thành viên</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item active"><a href="<?php echo e(route('admin.loyalty-tiers.index')); ?>">Hạng thành viên</a></li>
                        <li class="breadcrumb-item">Chỉnh sửa: <?php echo e($loyaltyTier->name); ?></li>
                    </ol>
                </div>

            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h4 class="card-title mb-0">Thông tin hạng</h4>
                    <a href="<?php echo e(route('admin.loyalty-tiers.index')); ?>" class="btn btn-outline-secondary btn-sm">
                        <i class="ri-arrow-go-back-line"></i> Quay lại
                    </a>
                </div>
                <div class="card-body">
                    <form action="<?php echo e(route('admin.loyalty-tiers.update', $loyaltyTier)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label fw-semibold">Tên Hạng</label>
                                <input type="text" name="name" id="name" class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('name', $loyaltyTier->name)); ?>" required>
                                <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="col-md-3">
                                <label for="min_spend_required" class="form-label fw-semibold">Ngưỡng Chi tiêu Tối thiểu (VNĐ)</label>
                                <input type="number" step="0.01" inputmode="decimal" name="min_spend_required" id="min_spend_required" class="form-control <?php $__errorArgs = ['min_spend_required'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('min_spend_required', (float) $loyaltyTier->min_spend_required)); ?>" required>
                                <?php $__errorArgs = ['min_spend_required'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="col-md-3">
                                <label for="discount_rate" class="form-label fw-semibold">Tỷ lệ Giảm giá (%)</label>
                                <input type="number" step="0.01" name="discount_rate" id="discount_rate" class="form-control <?php $__errorArgs = ['discount_rate'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('discount_rate', $loyaltyTier->discount_rate)); ?>" required>
                                <?php $__errorArgs = ['discount_rate'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <a href="<?php echo e(route('admin.loyalty-tiers.index')); ?>" class="btn btn-secondary">
                                <i class="ri-close-line"></i> Hủy
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="ri-save-3-line"></i> Cập nhật
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\LARAGON\laragon\www\DATN\duAnTotNghiep_website_ban_quan_ao_STYLEX\resources\views\admin\loyalty-tiers\edit.blade.php ENDPATH**/ ?>