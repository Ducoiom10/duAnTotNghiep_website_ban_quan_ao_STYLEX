<?php $__env->startPush('page-css'); ?>
    <!-- plugin css -->
    <link href="<?php echo e(asset('assets/libs/jsvectormap/css/jsvectormap.min.css')); ?>" rel="stylesheet" type="text/css" />
<?php $__env->stopPush(); ?>
<?php $__env->startSection('title', 'Cập nhật banner'); ?>
<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Quản lí banner</h4>

                <div class="page-title-right pe-3">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">Dashboard</a></li>
                        <li class="breadcrumb-item active"><a href="<?php echo e(route('admin.banners.index')); ?>">Danh sách
                                banner</a></li>
                        <li class="breadcrumb-item active"><a href="<?php echo e(route('admin.banners.edit', $banner->id)); ?>">Cập
                                nhật banner</a></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-1">Cập nhật banner</h4>
                    </div>
                    <div class="card-body">
                        <div>
                            <form action="<?php echo e(route('admin.banners.update', $banner->id)); ?>" method="post"
                                enctype="multipart/form-data">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('PUT'); ?>
                                <div class="mb-3">
                                    <label class="form-label">Tiêu đề</label>
                                    <input type="text" name="title" class="form-control" value="<?php echo e($banner->title); ?>">
                                    <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="text-danger"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Chuyển hướng</label>
                                    <input type="text" name="redirect_url" class="form-control"
                                        value="<?php echo e($banner->redirect_url); ?>">
                                    <?php $__errorArgs = ['redirect_url'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="text-danger"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Hình ảnh</label>
                                    <input type="file" name="image" class="form-control">
                                    <img class="mt-2" src="<?php echo e(Storage::url($banner->image)); ?>" alt=""
                                        srcset="" width="200px">
                                    <?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="text-danger"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Nội dung</label>
                                    <input type="text" name="content" class="form-control"
                                        value="<?php echo e($banner->content); ?>">
                                    <?php $__errorArgs = ['content'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="text-danger"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Thứ tự</label>
                                    <input type="int" name="order" class="form-control" value="<?php echo e($banner->order); ?>">
                                    <?php $__errorArgs = ['order'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="text-danger"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Status</label>
                                    <select name="status" class="form-select" value="<?php echo e(old('status')); ?>">
                                        <option value="1" <?php echo $banner->status == 1 ? 'selected' : ''; ?>>
                                            Active
                                        </option>
                                        <option value="0" <?php echo $banner->status == 0 ? 'selected' : ''; ?>>
                                            InActive
                                        </option>
                                    </select>
                                    <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="text-danger"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary">Cập nhật
                                    </button>
                                    <button type="reset" class="btn btn-soft-primary waves-effect waves-light">
                                        Nhập
                                        lại
                                    </button>
                                    <a class="btn btn-dark" href="<?php echo e(route('admin.banners.index')); ?>">Danh
                                        sách</a>
                                </div>
                            </form>
                        </div>
                    </div><!-- end card -->
                </div>
                <!-- end col -->
            </div>
            <!-- end col -->
        </div>


    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\LARAGON\laragon\www\DATN\duAnTotNghiep_website_ban_quan_ao_STYLEX\resources\views\admin\banners\edit.blade.php ENDPATH**/ ?>