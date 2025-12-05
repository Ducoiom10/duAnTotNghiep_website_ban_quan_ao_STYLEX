<?php $__env->startSection('title', 'Sửa tài khoản Admin/Staff'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Sửa tài khoản Admin/Staff</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo e(route('admin.roles.index')); ?>">Quản lý Admin & Staff</a></li>
                        <li class="breadcrumb-item active">Sửa tài khoản</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Form sửa tài khoản -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Thông tin tài khoản</h4>
                </div>
                <div class="card-body">
                    <?php if($errors->any()): ?>
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><?php echo e($error); ?></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <form action="<?php echo e(route('admin.roles.update', $user->id)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Họ và tên <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                           id="name" name="name" value="<?php echo e(old('name', $user->name)); ?>" required>
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
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                           id="email" name="email" value="<?php echo e(old('email', $user->email)); ?>" required>
                                    <?php $__errorArgs = ['email'];
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
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="password" class="form-label">Mật khẩu mới</label>
                                    <input type="password" class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                           id="password" name="password" placeholder="Để trống nếu không muốn đổi mật khẩu">
                                    <div class="form-text">Để trống nếu không muốn thay đổi mật khẩu</div>
                                    <?php $__errorArgs = ['password'];
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
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Vai trò <span class="text-danger">*</span></label>
                                    <?php
                                        $adminCount = \App\Models\User::where('role', 1)->count();
                                        $isLastAdmin = $user->role == 1 && $adminCount <= 1;
                                    ?>
                                    <?php if($isLastAdmin): ?>
                                        <div class="alert alert-warning mb-2">
                                            <i class="ri-information-line me-2"></i>
                                            <strong>Lưu ý:</strong> Đây là admin cuối cùng, không thể thay đổi vai trò!
                                        </div>
                                    <?php endif; ?>
                                    <div class="d-flex gap-4">
                                        <div class="form-check">
                                            <input class="form-check-input <?php $__errorArgs = ['role'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                                   type="radio" name="role" id="role_admin" value="1" 
                                                   <?php echo e(old('role', $user->role) == '1' ? 'checked' : ''); ?>

                                                   <?php echo e($isLastAdmin ? 'disabled' : ''); ?>>
                                            <label class="form-check-label text-danger <?php echo e($isLastAdmin ? 'text-muted' : ''); ?>" for="role_admin">
                                                <i class="ri-admin-line me-1"></i>Admin
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input <?php $__errorArgs = ['role'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                                   type="radio" name="role" id="role_staff" value="2" 
                                                   <?php echo e(old('role', $user->role) == '2' ? 'checked' : ''); ?>

                                                   <?php echo e($isLastAdmin ? 'disabled' : ''); ?>>
                                            <label class="form-check-label text-warning <?php echo e($isLastAdmin ? 'text-muted' : ''); ?>" for="role_staff">
                                                <i class="ri-team-line me-1"></i>Staff
                                            </label>
                                        </div>
                                    </div>
                                    <?php $__errorArgs = ['role'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Trạng thái <span class="text-danger">*</span></label>
                                    <?php if($isLastAdmin): ?>
                                        <div class="alert alert-warning mb-2">
                                            <i class="ri-information-line me-2"></i>
                                            <strong>Lưu ý:</strong> Admin cuối cùng phải ở trạng thái hoạt động!
                                        </div>
                                    <?php endif; ?>
                                    <div class="d-flex gap-4">
                                        <div class="form-check">
                                            <input class="form-check-input <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                                   type="radio" name="status" id="status_active" value="active" 
                                                   <?php echo e(old('status', $user->status) == 'active' ? 'checked' : ''); ?>>
                                            <label class="form-check-label text-success" for="status_active">
                                                <i class="ri-checkbox-circle-line me-1"></i>Hoạt động
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                                   type="radio" name="status" id="status_inactive" value="inactive" 
                                                   <?php echo e(old('status', $user->status) == 'inactive' ? 'checked' : ''); ?>

                                                   <?php echo e($isLastAdmin ? 'disabled' : ''); ?>>
                                            <label class="form-check-label text-warning <?php echo e($isLastAdmin ? 'text-muted' : ''); ?>" for="status_inactive">
                                                <i class="ri-pause-circle-line me-1"></i>Tạm dừng
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                                   type="radio" name="status" id="status_blocked" value="blocked" 
                                                   <?php echo e(old('status', $user->status) == 'blocked' ? 'checked' : ''); ?>

                                                   <?php echo e($isLastAdmin ? 'disabled' : ''); ?>>
                                            <label class="form-check-label text-danger <?php echo e($isLastAdmin ? 'text-muted' : ''); ?>" for="status_blocked">
                                                <i class="ri-lock-line me-1"></i>Bị khóa
                                            </label>
                                        </div>
                                    </div>
                                    <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="ri-save-line me-1"></i>Cập nhật tài khoản
                                    </button>
                                    <a href="<?php echo e(route('admin.roles.index')); ?>" class="btn btn-secondary">
                                        <i class="ri-arrow-left-line me-1"></i>Quay lại
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\LARAGON\laragon\www\DATN\duAnTotNghiep_website_ban_quan_ao_STYLEX\resources\views\admin\roles\edit.blade.php ENDPATH**/ ?>