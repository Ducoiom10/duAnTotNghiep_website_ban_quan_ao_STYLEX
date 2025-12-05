<?php $__env->startSection('title','Sửa hãng vận chuyển'); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Sửa hãng vận chuyển</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item active"><a href="<?php echo e(route('admin.shipping_carriers.index')); ?>">Vận chuyển</a></li>
                    <li class="breadcrumb-item">Sửa: <?php echo e($shipping_carrier->name); ?></li>
                </ol>
            </div>

        </div>
    </div>
</div>

<?php if(session('success')): ?> <div class="alert alert-success"><?php echo e(session('success')); ?></div> <?php endif; ?>
<?php if(session('error')): ?>   <div class="alert alert-danger"><?php echo e(session('error')); ?></div>   <?php endif; ?>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h4 class="card-title mb-0">Thông tin hãng</h4>
                <a href="<?php echo e(route('admin.shipping_carriers.index')); ?>" class="btn btn-outline-secondary btn-sm">
                    <i class="ri-arrow-go-back-line"></i> Quay lại
                </a>
            </div>
            <div class="card-body">
                <form action="<?php echo e(route('admin.shipping_carriers.update', $shipping_carrier)); ?>" method="post">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Tên hãng vận chuyển <span class="text-danger">*</span></label>
                            <input type="text"
                                   name="name"
                                   class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   value="<?php echo e(old('name', $shipping_carrier->name)); ?>"
                                   placeholder="VD: Giao Hàng Nhanh">
                            <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Mã hãng (code) <span class="text-danger">*</span></label>
                            <input type="text"
                                   name="code"
                                   class="form-control <?php $__errorArgs = ['code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   value="<?php echo e(old('code', $shipping_carrier->code)); ?>"
                                   placeholder="VD: GHN, GHTK, VNPOST">
                            <?php $__errorArgs = ['code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Phí vận chuyển (VNĐ) <span class="text-danger">*</span></label>
                            <input type="number"
                                   name="fee"
                                   class="form-control <?php $__errorArgs = ['fee'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   value="<?php echo e(old('fee', $shipping_carrier->fee ?? 0)); ?>"
                                   min="0"
                                   step="1000"
                                   placeholder="VD: 25000">
                            <?php $__errorArgs = ['fee'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            <small class="text-muted">Phí ship cố định cho mỗi đơn hàng sử dụng hãng này.</small>
                        </div>

                        <div class="col-md-3 d-flex align-items-end">
                            <div class="form-check mt-2">
                                <input type="checkbox" class="form-check-input" id="active" name="active" value="1" <?php echo e(old('active', $shipping_carrier->active) ? 'checked' : ''); ?>>
                                <label class="form-check-label" for="active">Hoạt động</label>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="<?php echo e(route('admin.shipping_carriers.index')); ?>" class="btn btn-secondary">
                            <i class="ri-close-line"></i> Hủy
                        </a>
                        <button class="btn btn-primary">
                            <i class="ri-save-3-line"></i> Cập nhật
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\LARAGON\laragon\www\DATN\duAnTotNghiep_website_ban_quan_ao_STYLEX\resources\views\admin\shipping_carriers\edit.blade.php ENDPATH**/ ?>