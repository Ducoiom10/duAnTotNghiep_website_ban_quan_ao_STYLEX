<?php $__env->startSection('title', 'Thông tin cá nhân'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Thông tin cá nhân</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">Trang chủ</a></li>
                        <li class="breadcrumb-item active">Thông tin cá nhân</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <img src="<?php echo e($user->avatar ? Storage::url($user->avatar) : \App\Http\Controllers\Admin\UserController::URLIMAGEDEFAULT); ?>" 
                             alt="Avatar" class="rounded-circle" width="150" height="150">
                    </div>
                    <h5><?php echo e($user->name); ?></h5>
                    <p class="text-muted"><?php echo e($user->email); ?></p>
                    <?php if($user->role == 1): ?>
                        <span class="badge bg-danger">Admin</span>
                    <?php elseif($user->role == 2): ?>
                        <span class="badge bg-warning">Staff</span>
                    <?php else: ?>
                        <span class="badge bg-info">User</span>
                    <?php endif; ?>
                    <div class="mt-3">
                        <?php if($user->status == 1): ?>
                            <span class="badge bg-success">Active</span>
                        <?php else: ?>
                            <span class="badge bg-secondary">Inactive</span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Thông tin chi tiết</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Họ và tên</label>
                            <p class="form-control-plaintext"><?php echo e($user->name); ?></p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email</label>
                            <p class="form-control-plaintext"><?php echo e($user->email); ?></p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Số điện thoại</label>
                            <p class="form-control-plaintext"><?php echo e($user->phone_number ?: 'Chưa cập nhật'); ?></p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Vai trò</label>
                            <p class="form-control-plaintext">
                                <?php if($user->role == 1): ?>
                                    Quản trị viên
                                <?php elseif($user->role == 2): ?>
                                    Nhân viên
                                <?php else: ?>
                                    Người dùng
                                <?php endif; ?>
                            </p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Trạng thái</label>
                            <p class="form-control-plaintext">
                                <?php echo e($user->status == 1 ? 'Hoạt động' : 'Không hoạt động'); ?>

                            </p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Ngày tạo</label>
                            <p class="form-control-plaintext"><?php echo e($user->created_at->format('d/m/Y H:i')); ?></p>
                        </div>
                    </div>
                    <div class="mt-3">
                        <a href="<?php echo e(route('admin.profile.edit')); ?>" class="btn btn-primary">
                            <i class="fas fa-edit me-1"></i>Chỉnh sửa thông tin
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\LARAGON\laragon\www\DATN\duAnTotNghiep_website_ban_quan_ao_STYLEX\resources\views\admin\users\profile.blade.php ENDPATH**/ ?>