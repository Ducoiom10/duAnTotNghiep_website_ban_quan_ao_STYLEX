<?php $__env->startSection('content'); ?>
<div class="page-title">
    <h1>Sửa Danh Mục</h1>
    <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
            <nav aria-label="breadcrumb" class="breadcrumb-header">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">Home</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo e(route('admin.categories.index')); ?>">Danh mục</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Sửa danh mục</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<section class="section">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">
                        <i class="bi bi-pencil-square me-2"></i> Sửa Danh Mục: <?php echo e($category->name); ?>

                    </h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <form id="updateCategoryForm" action="<?php echo e(route('admin.category.update', $category->id)); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('PUT'); ?>

                            <div class="mb-4">
                                <label for="name" class="form-label fw-semibold">Tên danh mục</label>
                                <input type="text" class="form-control" id="name" name="category_name" value="<?php echo e(old('category_name', $category->name)); ?>" required>
                            </div>

                            <div class="mb-4">
                                <label for="parent_id" class="form-label fw-semibold">Danh mục cha</label>
                                <select class="form-select" id="parent_id" name="parent_id">
                                    <option value="">Không có (Mặc định)</option>
                                    <?php $__currentLoopData = $selectableCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($cat->id); ?>" <?php echo e(old('parent_id', $category->parent_id) == $cat->id ? 'selected' : ''); ?>>
                                        <?php echo e($cat->name); ?>

                                    </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-semibold d-block">Trạng thái</label>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="status" id="status_active" value="1"
                                        <?php echo e(old('status', $category->status) == 1 ? 'checked' : ''); ?>>
                                    <label class="form-check-label text-success fw-medium" for="status_active">
                                        <i class="bi bi-check-circle me-1"></i> Hoạt động
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="status" id="status_inactive" value="0"
                                        <?php echo e(old('status', $category->status) == 0 ? 'checked' : ''); ?>>
                                    <label class="form-check-label text-danger fw-medium" for="status_inactive">
                                        <i class="bi bi-x-circle me-1"></i> Không hoạt động
                                    </label>
                                </div>
                            </div>


                            <div class="d-flex justify-content-between">
                                <a href="<?php echo e(route('admin.categories.index')); ?>" class="btn btn-secondary">Quay lại</a>
                                <div>
                                    <button type="button" class="btn btn-outline-danger" onclick="deleteCategory()">Xóa</button>
                                    <button type="submit" class="btn btn-primary" id="updateBtn">Cập nhật</button>
                                </div>
                            </div>
                        </form>

                        <form id="delete-form" action="<?php echo e(route('admin.category.destroy', $category->id)); ?>" method="POST" class="d-none">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    $(document).ready(function() {
        // Cập nhật danh mục
        $('#updateCategoryForm').submit(function(e) {
            e.preventDefault();
            $('#updateBtn').prop('disabled', true);
            var formData = $(this).serialize();

            $.ajax({
                url: "<?php echo e(route('admin.category.update', $category->id)); ?>",
                type: "POST",
                data: formData,
                success: function(res) {
                    if (res.success) {
                        toastr.success(res.msg);
                        setTimeout(function() {
                            window.location.href = "<?php echo e(route('admin.categories.index')); ?>";
                        }, 1500);
                    } else {
                        toastr.error(res.msg);
                    }
                },
                error: function(xhr) {
                    toastr.error('Có lỗi xảy ra khi cập nhật danh mục');
                },
                complete: function() {
                    $('#updateBtn').prop('disabled', false);
                }
            });
        });
    });

    // Xóa danh mục
    function deleteCategory() {
        if (confirm('Bạn có chắc chắn muốn xóa danh mục này? Nếu danh mục có danh mục con, tất cả danh mục con cũng sẽ bị xóa!')) {
            $.ajax({
                url: "<?php echo e(route('admin.category.destroy', $category->id)); ?>",
                type: "DELETE",
                data: {
                    _token: "<?php echo e(csrf_token()); ?>"
                },
                success: function(res) {
                    if (res.success) {
                        toastr.success(res.msg);
                        setTimeout(function() {
                            window.location.href = "<?php echo e(route('admin.categories.index')); ?>";
                        }, 1500);
                    } else {
                        toastr.error(res.msg);
                    }
                },
                error: function(xhr) {
                    toastr.error('Có lỗi xảy ra khi xóa danh mục');
                }
            });
        }
    }
</script>
<?php $__env->stopPush(); ?>




<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\LARAGON\laragon\www\DATN\duAnTotNghiep_website_ban_quan_ao_STYLEX\resources\views\admin\category\edit.blade.php ENDPATH**/ ?>