<?php $__env->startPush('page-css'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('vendor/laraberg/css/laraberg.css')); ?>">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: #0d6efd !important;
            /* xanh dương Bootstrap */
            border: none !important;
            color: #fff !important;
            font-weight: 500;
            border-radius: 6px;
            padding: 3px 8px;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
            color: #fff !important;
            margin-right: 5px;
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Quản lý bài viết</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">Dashboard</a></li>
                            <li class="breadcrumb-item active">Chi tiết bài viết</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">
                            Thông tin bài viết <span class="text-danger"><?php echo e($post->title); ?></span>
                        </h4>
                        <div class="form-check form-switch">
                            <label class="form-check-label" for="isHotSwitch">
                                <?php echo e($post->is_hot ? 'Bài viết hot 🔥' : 'Không hot 🔥'); ?>

                            </label>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Hình đại diện:</label>
                            <img class="img-thumbnail" src="<?php echo e(Storage::url($post->thumbnail)); ?>" alt="Hình đại diện">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Mô tả bài viết:</label>
                            <textarea disabled class="form-control" cols="30" rows="10"><?php echo e(strip_tags(preg_replace('/<!--\s*\/?wp:[^>]+-->/', '', $post->description))); ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nội dung:</label>
                            <textarea disabled class="form-control" cols="30" rows="15"><?php echo e(strip_tags(preg_replace('/<!--\s*\/?wp:[^>]+-->/', '', $post->content))); ?></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Tiêu đề:</label>
                            <p class="text-muted"><?php echo e($post->title); ?></p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Người tạo bài:</label>
                            <p class="text-muted"><?php echo e($post->user->name); ?></p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Trạng thái:</label>
                            <p class="text-muted"><?php echo e(ucfirst($post->status)); ?></p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Ngày xuất bản:</label>
                            <p class="text-muted">
                                <?php echo e($post->published_at ? \Carbon\Carbon::parse($post->published_at)->format('Y/m/d H:i') : 'Chưa xuất bản'); ?>

                            </p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Danh mục:</label>
                            <select class="select2-categories form-control" multiple="multiple" disabled>
                                <option selected><?php echo e($post->category->name ?? ''); ?></option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tags:</label>
                            <select class="select2-tags form-control" multiple="multiple" disabled>
                                <?php $__currentLoopData = $post->tags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option selected><?php echo e($tag->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Đường dẫn thân thiện:</label>
                            <p class="text-muted"><?php echo e($post->slug); ?></p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">View:</label>
                            <p class="text-muted"><?php echo e($post->views); ?> lượt xem</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Ngày tạo bài:</label>
                            <p class="text-muted"><?php echo e($post->created_at ? $post->created_at->format('d/m/Y H:i') : ''); ?></p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Ngày chỉnh sửa:</label>
                            <p class="text-muted"><?php echo e($post->updated_at ? $post->updated_at->format('d/m/Y H:i') : ''); ?></p>
                        </div>
                    </div>
                </div>
                <div class="text-end">
                    <a href="<?php echo e(route('admin.posts.index')); ?>" class="btn btn-warning">Quay lại danh sách</a>
                    <a href="<?php echo e(route('admin.posts.edit', $post->id)); ?>" class="btn btn-primary">Chỉnh sửa bài viết</a>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script src="https://unpkg.com/react@17.0.2/umd/react.production.min.js"></script>
    <script src="https://unpkg.com/react-dom@17.0.2/umd/react-dom.production.min.js"></script>

    <script src="<?php echo e(asset('vendor/laraberg/js/laraberg.js')); ?>"></script>
    <script>
        $(document).ready(function() {
            Laraberg.init('laraberg');

            $('.select2-categories').select2({
                placeholder: 'Không có'
            });

            $('.select2-tags').select2({
                tags: true,
                tokenSeparators: [','],
                placeholder: 'Không có'
            });
        });
    </script>
    <script>
        <?php if (! $__env->hasRenderedOnce('2cc02c01-8830-4f54-b349-82bcd1784b16')): $__env->markAsRenderedOnce('2cc02c01-8830-4f54-b349-82bcd1784b16'); ?>
        let myEditor;
        ClassicEditor.create(document.querySelector('#description'))
            .then(editor => {
                myEditor = editor;
            });

        document.querySelector('#postForm').addEventListener('submit', function() {
            document.querySelector('#description').value = myEditor.getData();
        });
        <?php endif; ?>
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\LARAGON\laragon\www\DATN\duAnTotNghiep_website_ban_quan_ao_STYLEX\resources\views\admin\posts\show.blade.php ENDPATH**/ ?>