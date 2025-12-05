<?php $__env->startSection('title'); ?>
    Thêm mới bài viết
<?php $__env->stopSection(); ?>
<?php $__env->startPush('page-css'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('vendor/laraberg/css/laraberg.css')); ?>">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <style>
        .form-card {
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .form-card:hover {
            box-shadow: 0 0 25px rgba(0, 0, 0, 0.1);
        }

        .form-card .card-header {
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            padding: 15px 20px;
        }

        .form-card .card-body {
            padding: 20px;
        }

        .card-title {
            font-weight: 600;
            font-size: 16px;
        }

        .form-label {
            font-weight: 500;
            margin-bottom: 8px;
            color: #495057;
        }

        .form-control {
            border-radius: 6px;
            padding: 10px 15px;
            border: 1px solid #dee2e6;
        }

        .form-control:focus {
            box-shadow: 0 0 0 0.15rem rgba(13, 110, 253, 0.15);
        }

        .btn-publish {
            padding: 10px 24px;
            font-weight: 500;
            letter-spacing: 0.3px;
            transition: all 0.3s;
        }

        .select2-container .select2-selection--single,
        .select2-container--default .select2-selection--multiple {
            height: 42px;
            border-radius: 6px;
            border: 1px solid #dee2e6;
            padding: 6px 8px;
        }

        .thumbnail-preview-container {
            background-color: #f8f9fa;
            border: 1px dashed #ced4da;
            border-radius: 6px;
            text-align: center;
            padding: 20px;
            margin-top: 10px;
            transition: all 0.3s;
        }

        .thumbnail-preview-container:hover {
            background-color: #f1f3f5;
        }
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
                    <h4 class="mb-sm-0"><?php echo e($subTitle ?? ''); ?></h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">Dasboard</a></li>
                            <li class="breadcrumb-item active"><?php echo e($title ?? ''); ?></li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <form action="<?php echo e(route('admin.posts.store')); ?>" method="POST" enctype="multipart/form-data" id="postForm">
            <?php echo csrf_field(); ?>
            <div class="row">
                <div class="col-lg-8">
                    <div class="card form-card mb-4">
                        <div class="card-header d-flex align-items-center">
                            <h4 class="card-title mb-0">
                                <i class="ri-article-line me-1"></i> Thông tin bài viết
                            </h4>
                        </div>
                        <div class="card-body">
                            <div class="mb-4">
                                <label for="title" class="form-label">Tiêu đề</label>
                                <input type="text" id="title" class="form-control"
                                    placeholder="Nhập tiêu đề bài viết..." value="<?php echo e(old('title')); ?>" name="title">
                                <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="text-danger mt-2"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Hình ảnh đại diện</label>
                                <input type="file" name="thumbnail" id="imageInput" accept="image/*"
                                    class="form-control">
                                <div class="thumbnail-preview-container" id="thumbnailContainer">
                                    <img id="imagePreview" style="display: none; max-width: 100%; max-height: 250px;">
                                    <div id="uploadPlaceholder">
                                        <i class="ri-image-add-line fs-3 mb-2"></i>
                                        <p>Tải lên hình ảnh đại diện cho bài viết</p>
                                    </div>
                                </div>
                                <?php $__errorArgs = ['thumbnail'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="text-danger mt-2"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="mb-4">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <label class="form-label mb-0">Mô tả bài viết</label>
                                </div>
                                <textarea name="description" id="description" hidden></textarea>
                                <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="text-danger mt-2"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div>
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <label for="laraberg" class="form-label">Nội dung bài viết</label>
                                </div>
                                <textarea id="laraberg" name="content" hidden><?php echo e(old('content')); ?></textarea>
                                <?php $__errorArgs = ['content'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="text-danger mt-2"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card form-card mb-4">
                        <div class="card-header d-flex align-items-center">
                            <h4 class="card-title mb-0">
                                <i class="ri-settings-3-line me-1"></i> Xuất bản
                            </h4>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Trạng thái</label>
                                <select class="form-select" name="status" id="post-status">
                                    <option value="published">Xuất bản ngay</option>
                                    <option value="draft">Lưu nháp</option>
                                    <option value="scheduled">Hẹn giờ xuất bản</option>
                                </select>
                            </div>

                            <div class="mb-3" id="published-date-container" style="display: none;">
                                <label class="form-label">Ngày xuất bản</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="ri-calendar-event-line"></i></span>
                                    <input type="datetime-local" name="published_at" class="form-control"
                                        value="<?php echo e(old('published_at') ?? now()->format('Y-m-d\TH:i')); ?>">
                                </div>
                            </div>

                            <div class="d-grid mt-4">
                                <button type="submit" class="btn btn-primary btn-publish">
                                    <i class="ri-send-plane-fill me-1"></i> Xuất bản bài viết
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="card form-card mb-4">
                        <div class="card-header d-flex align-items-center">
                            <h4 class="card-title mb-0">
                                <i class="ri-folder-line me-1"></i> Danh mục
                            </h4>
                        </div>
                        <div class="card-body">
                            <select class="select2-categories form-control" name="category_id"
                                data-placeholder="Chọn danh mục">
                                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($category->id); ?>"
                                        <?php echo e(in_array($category->id, (array) old('category_id', [])) ? 'selected' : ''); ?>>
                                        <?php echo e($category->name); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php $__errorArgs = ['category_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="text-danger mt-2"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>

                    <div class="card form-card mb-4">
                        <div class="card-header d-flex align-items-center">
                            <h4 class="card-title mb-0">
                                <i class="ri-price-tag-3-line me-1"></i> Thẻ
                            </h4>
                        </div>
                        <div class="card-body">
                            <select class="select2-tags form-control" name="tags[]"
                                data-placeholder="Chọn hoặc tạo thẻ mới" multiple="multiple">
                                <?php $__currentLoopData = $tags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($tag->name); ?>"
                                        <?php echo e(in_array($tag->id, old('tags', [])) ? 'selected' : ''); ?>>
                                        <?php echo e($tag->name); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <div class="mt-2 text-muted small">
                                <i class="ri-information-line me-1"></i> Nhập tên thẻ và nhấn Enter để tạo thẻ mới
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script src="https://unpkg.com/react@17.0.2/umd/react.production.min.js"></script>
    <script src="https://unpkg.com/react-dom@17.0.2/umd/react-dom.production.min.js"></script>
    <script src="<?php echo e(asset('vendor/laraberg/js/laraberg.js')); ?>"></script>
        <script>
        <?php if (! $__env->hasRenderedOnce('95f7e1dc-1ae8-46b2-bf89-cca222bc2105')): $__env->markAsRenderedOnce('95f7e1dc-1ae8-46b2-bf89-cca222bc2105'); ?>
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
    <script>
        $('#post-status').on('change', function() {
            if ($(this).val() === 'scheduled') {
                $('#published-date-container').slideDown(200);
                if (!$('input[name="published_at"]').val()) {
                    const now = new Date();
                    const year = now.getFullYear();
                    const month = String(now.getMonth() + 1).padStart(2, '0');
                    const day = String(now.getDate()).padStart(2, '0');
                    const hours = String(now.getHours()).padStart(2, '0');
                    const minutes = String(now.getMinutes()).padStart(2, '0');
                    $('input[name="published_at"]').val(`${year}-${month}-${day}T${hours}:${minutes}`);
                }
            } else {
                $('#published-date-container').slideUp(200);
            }
        });

        $(document).ready(function() {
            if ($('#post-status').val() === 'scheduled') {
                $('#published-date-container').show();
            }

            let editorInstance;
            let selectedAiType = '';
            let currentEditingSection = 'description';
            let currentAjaxRequest = null;

            Laraberg.init('laraberg', {
                height: '600px',
                mediaUpload: handleMediaUpload
            });

            function handleMediaUpload(file) {
                return new Promise((resolve, reject) => {
                    if (file && file instanceof File) {
                        resolve({
                            id: new Date().getTime(),
                            url: URL.createObjectURL(file)
                        });
                    } else {
                        reject(new Error('Invalid file object'));
                    }
                });
            }

            $('#imageInput').on('change', function(e) {
                const file = e.target.files[0];
                if (file && file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function() {
                        $('#imagePreview').attr('src', reader.result).show();
                        $('#uploadPlaceholder').hide();
                    };
                    reader.readAsDataURL(file);
                } else {
                    $('#imagePreview').hide();
                    $('#uploadPlaceholder').show();
                }
            });

            $('#postForm').on('submit', function() {
                var content = Laraberg.getContent();
                $('textarea[name="content"]').val(content);
            });

            $('.select2-categories').select2({
                placeholder: 'Chọn danh mục',
                allowClear: true,
                width: '100%',
                dropdownParent: $('.select2-categories').parent()
            });

            $('.select2-tags').select2({
                tags: true,
                tokenSeparators: [','],
                placeholder: 'Chọn hoặc tạo thẻ mới',
                width: '100%',
                dropdownParent: $('.select2-tags').parent()
            });

            ClassicEditor.create($('#ckeditor-classic')[0], {
                    toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', '|',
                        'outdent', 'indent', '|', 'blockQuote', 'insertTable', 'undo', 'redo'
                    ],
                })
                .then(editor => {
                    editorInstance = editor;
                    editor.ui.view.editable.element.style.height = "200px";
                })
                .catch(console.error);
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\LARAGON\laragon\www\DATN\duAnTotNghiep_website_ban_quan_ao_STYLEX\resources\views\admin\posts\create.blade.php ENDPATH**/ ?>