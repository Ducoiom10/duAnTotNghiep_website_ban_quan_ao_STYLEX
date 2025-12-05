<?php $__env->startPush('page-css'); ?>
    <!-- plugin css -->
    <link href="<?php echo e(asset('assets/libs/jsvectormap/css/jsvectormap.min.css')); ?>" rel="stylesheet" type="text/css"/>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('title','Thêm mới banner'); ?>
<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 ps-2">Quản lí banner</h4>

                <div class="page-title-right pe-3">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">Dashboard</a></li>
                        <li class="breadcrumb-item active"><a href="<?php echo e(route('admin.banners.index')); ?>">Danh sách
                                banner</a>
                        </li>
                        <li class="breadcrumb-item active"><a href="<?php echo e(route('admin.banners.create')); ?>">Thêm mới
                                banner</a>
                        </li>
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
                        <h4 class="card-title mb-0">Thêm mới banner</h4>
                        <?php if(session()->has('success') && session()->get('success')): ?>
                            <div class="alert alert-success" role="alert">
                                Thao tác thành công
                            </div>
                        <?php endif; ?>
                        <?php if(session()->has('success') && !session()->get('success')): ?>
                            <div class="alert alert-danger" role="alert">
                                <strong>Thao tác không thành công</strong>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="card-body">
                        <div>
                            <form action="<?php echo e(route('admin.banners.store')); ?>" method="post"
                                  enctype="multipart/form-data">
                                <?php echo csrf_field(); ?>
                                <div class="mb-3">
                                    <label class="form-label">Tiêu đề</label>
                                    <input type="text" name="title" class="form-control"
                                           placeholder="Vui lòng nhập tiêu đề..." value="<?php echo e(old('title')); ?>">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Hình ảnh</label>
                                    <input type="file" name="image" class="form-control" id="imageInput">
                                </div>
                                <div class="image-preview-container" style="display:none;">
                                    <img id="imagePreview" src="" alt="Image preview" class="img-fluid mt-2 w-25"/>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Nội dung</label>
                                    <textarea name="content" placeholder="Nhập nội dung..." class="form-control"
                                              value="<?php echo e(old('content')); ?>"></textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Trạng thái</label>
                                    <select name="status" class="form-select" value="<?php echo e(old('status')); ?>">
                                        <option value="" selected>Chọn trạng thái</option>
                                        <option value="1">Active</option>
                                        <option value="0">InActive</option>
                                    </select>
                                </div>
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary">Tạo
                                        mới
                                    </button>
                                    <button type="reset" class="btn btn-soft-primary waves-effect waves-light">Nhập
                                        lại
                                    </button>
                                    <a class="btn btn-dark" href="<?php echo e(route('admin.banners.index')); ?>">Danh sách</a>
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
<?php $__env->startPush('scripts'); ?>
    <script>
        // Lắng nghe sự kiện thay đổi khi người dùng chọn tệp
        document.getElementById("imageInput").addEventListener("change", function (event) {
            const file = event.target.files[0]; // Lấy tệp đã chọn

            if (file) {
                // Tạo URL cho tệp được chọn
                const reader = new FileReader();
                reader.onload = function (e) {
                    // Lấy URL của ảnh
                    const imageUrl = e.target.result;

                    // Cập nhật ảnh xem trước
                    const imagePreview = document.getElementById("imagePreview");
                    imagePreview.src = imageUrl;

                    // Hiển thị phần tử ảnh xem trước
                    document.querySelector(".image-preview-container").style.display = "block";
                };
                reader.readAsDataURL(file); // Đọc tệp ảnh dưới dạng URL
            } else {
                // Nếu không có tệp nào được chọn, ẩn ảnh xem trước
                document.querySelector(".image-preview-container").style.display = "none";
            }
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\LARAGON\laragon\www\DATN\duAnTotNghiep_website_ban_quan_ao_STYLEX\resources\views\admin\banners\create.blade.php ENDPATH**/ ?>