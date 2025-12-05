<?php $__env->startPush('page-css'); ?>
    <!-- plugin css -->
    <link href="<?php echo e(asset('assets/libs/jsvectormap/css/jsvectormap.min.css')); ?>" rel="stylesheet" type="text/css" />
<?php $__env->stopPush(); ?>
<?php $__env->startSection('title','Chi tiết banner'); ?>
<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Chi tiết Banner</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo e(route('admin.banners.index')); ?>">Danh sách Banner</a></li>
                    <li class="breadcrumb-item active">Chi tiết Banner</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">

    <div class="row">
        <!-- Thông tin chi tiết -->
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header border-bottom">
                    <h5 class="mb-0">Thông tin Banner</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-start">
                            <span><strong>Tiêu đề:</strong></span>
                            <span class="text-end"><?php echo e($banner->title); ?></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-start">
                            <span><strong>Đường dẫn:</strong></span>
                            <span class="text-end">
                                <a href="<?php echo e($banner->redirect_url); ?>" target="_blank">
                                    <?php echo e($banner->redirect_url); ?>

                                </a>
                            </span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-start">
                            <span><strong>Nội dung:</strong></span>
                            <span class="text-end"><?php echo e($banner->content); ?></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-start">
                            <span><strong>Thứ tự hiển thị:</strong></span>
                            <span class="text-end"><?php echo e($banner->order); ?></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-start">
                            <span><strong>Trạng thái:</strong></span>
                            <span class="text-end">
                                <?php if($banner->status): ?>
                                    <span class="badge bg-success">Hoạt động</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary">Không hoạt động</span>
                                <?php endif; ?>
                            </span>
                        </li>
                    </ul>

                    <div class="mt-4">
                        <a href="<?php echo e(route('admin.banners.index')); ?>" class="btn btn-outline-secondary me-2">
                            <i class="la la-arrow-left me-1"></i> Trở về danh sách
                        </a>
                        <a href="<?php echo e(route('admin.banners.edit', $banner->id)); ?>" class="btn btn-warning">
                            <i class="la la-edit me-1"></i> Chỉnh sửa
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Ảnh Banner -->
        <div class="col-lg-4">
            <div class="card shadow-sm border-0">
                <div class="card-header border-bottom">
                    <h5 class="mb-0">Ảnh Banner</h5>
                </div>
                <div class="card-body text-center">
                    <?php if($banner->image): ?>
                        <img src="<?php echo e(Storage::url($banner->image)); ?>" alt="Banner" class="img-fluid">

                    <?php else: ?>
                        <div class="text-muted fst-italic">Chưa có ảnh</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>




<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\LARAGON\laragon\www\DATN\duAnTotNghiep_website_ban_quan_ao_STYLEX\resources\views\admin\banners\show.blade.php ENDPATH**/ ?>