<?php $__env->startSection('title', 'Thêm mới sản phẩm'); ?>

<?php $__env->startPush('styles'); ?>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css"
        rel="stylesheet" />
    <style>
        .card {
            border-width: 2px
        }

        .card-header {
            background: #eef7ff
        }

        .required::after {
            content: " *";
            color: #dc3545
        }

        .input-price {
            text-align: right
        }

        .select2-container--bootstrap-5 .select2-selection {
            min-height: 38px
        }

        .select2-container--bootstrap-5 .select2-selection.is-invalid {
            border-color: #dc3545 !important;
            box-shadow: 0 0 0 .2rem rgba(220, 53, 69, .1);
        }
    </style>
<?php $__env->stopPush(); ?>


<?php $__env->startSection('content'); ?>
    <div class="row mb-3">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0">Thêm mới sản phẩm</h4>
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="#">Quản lí sản phẩm</a></li>
                    <li class="breadcrumb-item active">Thêm mới</li>
                </ol>
            </div>
        </div>
    </div>

    <form id="product-form" method="POST" action="<?php echo e(route('admin.products.store')); ?>" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>

        <div class="card mb-3">
            <div class="card-header">
                <h5 class="mb-0">Thông tin sản phẩm</h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    
                    <div class="col-md-6">
                        <label class="form-label required">Tên sản phẩm <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="product-name" name="name"
                            value="<?php echo e(old('name')); ?>" placeholder="Nhập tên sản phẩm">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label required">Slug <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="product-slug" name="slug"
                            value="<?php echo e(old('slug')); ?>" placeholder="Tự sinh theo tên sản phẩm">
                    </div>

                    
                    <div class="col-md-6">
                        <label class="form-label required">Danh mục <span class="text-danger">*</span></label>
                        <select class="form-select" name="category_id" required>
                            <option value="">Chọn danh mục</option>
                            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cate): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($cate->id); ?>" <?php echo e(old('category_id') == $cate->id ? 'selected' : ''); ?>>
                                    <?php echo e($cate->name); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Ảnh đại diện</label>
                        <input type="file" id="product-image-input" name="thumbnail" class="form-control"
                            accept="image/*">
                        <img id="product-img" class="mt-2 rounded" style="max-height:150px;">
                    </div>

                    
                    <?php
                        $oldPrice = old('price', 0);
                        $oldPriceSale = old('price_sale', 0);
                    ?>
                    <div class="col-md-6">
                        <label class="form-label required">Giá gốc (VND)</label>
                        <input type="text" class="form-control input-price" name="price"
                            value="<?php echo e(is_numeric($oldPrice) ? number_format((int) $oldPrice, 0, ',', '.') : $oldPrice); ?>"
                            required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Giá khuyến mãi (VND)</label>
                        <input type="text" class="form-control input-price" name="price_sale"
                            value="<?php echo e(is_numeric($oldPriceSale) ? number_format((int) $oldPriceSale, 0, ',', '.') : $oldPriceSale); ?>">
                    </div>

                    
                    <div class="col-md-3">
                        <label class="form-label d-block">Trạng thái</label>
                        <input type="hidden" name="is_active" value="0">
                        <div class="form-check form-switch mt-1">
                            <input class="form-check-input" type="checkbox" name="is_active" value="1"
                                <?php echo e(old('is_active', 1) == 1 ? 'checked' : ''); ?>>
                            <label class="form-check-label">Hoạt động</label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label d-block">Nổi bật</label>
                        <input type="hidden" name="is_featured" value="0">
                        <div class="form-check form-switch mt-1">
                            <input class="form-check-input" type="checkbox" name="is_featured" value="1"
                                <?php echo e(old('is_featured', 0) == 1 ? 'checked' : ''); ?>>
                            <label class="form-check-label">Gắn “Đặc biệt”</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Tiêu đề SEO</label>
                        <input type="text" class="form-control" name="meta_title" value="<?php echo e(old('meta_title')); ?>"
                            placeholder="Tiêu đề SEO">
                    </div>

                    
                    <div class="col-12">
                        <label class="form-label">Mô tả sản phẩm</label>
                        <textarea name="description" class="form-control" rows="5" placeholder="Nhập mô tả"><?php echo e(old('description')); ?></textarea>
                    </div>

                </div>
            </div>
        </div>



        <div class="card mb-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Biến thể sản phẩm</h5>
                <div>
                    <button type="button" id="btn-generate-variants" class="btn btn-primary btn-sm">Sinh biến
                        thể</button>
                    <button type="button" id="btn-clear-variants" class="btn btn-outline-danger btn-sm">Xoá tất
                        cả</button>
                </div>
            </div>
            <div class="card-body">
                <div class="row g-3 mb-3">
                    <div class="col-md-4">
                        <label class="form-label">Màu sắc</label>
                        <select id="attr-colors" class="form-select select2" multiple data-placeholder="Chọn màu sắc">
                            <?php $__currentLoopData = $colors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($c->id); ?>" data-name="<?php echo e($c->name); ?>"><?php echo e($c->name); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Kích cỡ</label>
                        <select id="attr-sizes" class="form-select select2" multiple data-placeholder="Chọn kích cỡ">
                            <?php $__currentLoopData = $sizes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($s->id); ?>" data-name="<?php echo e($s->name); ?>"><?php echo e($s->name); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Chất liệu</label>
                        <select id="attr-textures" class="form-select select2" multiple
                            data-placeholder="Chọn chất liệu">
                            <?php $__currentLoopData = $textures; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($t->id); ?>" data-name="<?php echo e($t->name); ?>"><?php echo e($t->name); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered align-middle" id="variants-table">
                        <thead class="table-light text-center">
                            <tr>
                                <th>Màu</th>
                                <th>Size</th>
                                <th>Chất liệu</th>
                                
                                <th>Giá (VND)</th>
                                <th>Số lượng</th>
                                <th>Ảnh</th>
                                <th>Trạng thái</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="text-end">
            <button type="submit" class="btn btn-success w-sm mb-3">Thêm sản phẩm</button>
        </div>

    </form>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(function() {
            /* =========================
             * 1) SELECT2 INIT
             * ========================= */
            $('.select2').select2({
                theme: 'bootstrap-5',
                width: '100%',
                placeholder: function() {
                    return $(this).data('placeholder') || 'Chọn';
                },
                closeOnSelect: false
            });

            /* =========================
             * 2) TỰ SINH SLUG REALTIME
             * ========================= */
            $('#product-name').on('input', function() {
                const slug = $(this).val()
                    .toLowerCase()
                    .normalize('NFD').replace(/[\u0300-\u036f]/g, '')
                    .replace(/đ/g, 'd')
                    .replace(/[^a-z0-9]+/g, '-')
                    .replace(/^-+|-+$/g, '');
                $('#product-slug').val(slug);
            });

            /* =========================
             * 3) GIÁ: HIỂN THỊ DẤU . KHI NHẬP
             * ========================= */
            function formatPrice(v) {
                return v.replace(/\D/g, '').replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            }
            $(document).on('input', '.input-price', function() {
                this.value = formatPrice(this.value);
            });
            // Trước khi submit: bỏ dấu .
            $('#product-form').on('submit', function() {
                $('.input-price').each(function() {
                    $(this).val($(this).val().replace(/\./g, ''));
                });
            });

            /* =========================
             * 4) PREVIEW ẢNH ĐẠI DIỆN
             * ========================= */
            $('#product-image-input').on('change', function() {
                const f = this.files?.[0];
                if (!f) return $('#product-img').attr('src', '');
                const r = new FileReader();
                r.onload = e => $('#product-img').attr('src', e.target.result);
                r.readAsDataURL(f);
            });

            /* =========================
             * 5) HỖ TRỢ VALIDATE 3 NHÓM
             * ========================= */
            // tô/huỷ viền đỏ cho Select2
            function markInvalid($el, invalid) {
                const $sel = $el.next('.select2').find('.select2-selection');
                $sel.toggleClass('is-invalid', !!invalid);
            }
            // lấy mảng id đã chọn
            function getMultiSel($el) {
                return ($el.val() || []).filter(Boolean);
            }

            function validateFullAttributes() {
                const $c = $('#attr-colors');
                const $s = $('#attr-sizes');
                const $t = $('#attr-textures');

                const hasC = getMultiSel($c).length > 0;
                const hasS = getMultiSel($s).length > 0;
                const hasT = getMultiSel($t).length > 0;

                const pickedAny = hasC || hasS || hasT;
                const fullPicked = hasC && hasS && hasT;

                // reset
                markInvalid($c, false);
                markInvalid($s, false);
                markInvalid($t, false);

                if (pickedAny && !fullPicked) {
                    if (!hasC) markInvalid($c, true);
                    if (!hasS) markInvalid($s, true);
                    if (!hasT) markInvalid($t, true);
                    return {
                        ok: false,
                        msg: 'Vui lòng chọn đủ 3 nhóm: Màu sắc, Kích cỡ và Chất liệu.'
                    };
                }
                return {
                    ok: true
                };
            }

            // bỏ highlight khi đổi chọn
            $('#attr-colors, #attr-sizes, #attr-textures').on('change', function() {
                validateFullAttributes();
            });

            /* =========================
             * 6) SINH BIẾN THỂ
             * ========================= */
            function selectedObjects($el) {
                return ($el.val() || []).map(id => ({
                    id,
                    name: $el.find('option[value="' + id + '"]').data('name')
                }));
            }

            $('#btn-generate-variants').on('click', function() {
                const check = validateFullAttributes();
                if (!check.ok) {
                    if (window.toastr) toastr.error(check.msg);
                    else alert(check.msg);
                    return;
                }

                const colors = selectedObjects($('#attr-colors'));
                const sizes = selectedObjects($('#attr-sizes'));
                const textures = selectedObjects($('#attr-textures'));

                const $tbody = $('#variants-table tbody').empty();
                let i = 0;

                colors.forEach(c => sizes.forEach(s => textures.forEach(t => {
                    const row = `
        <tr>
          <td><input type="hidden" name="variants[${i}][color_id]" value="${c.id}"><span class="badge bg-light text-dark">${c.name}</span></td>
          <td><input type="hidden" name="variants[${i}][size_id]" value="${s.id}"><span class="badge bg-light text-dark">${s.name}</span></td>
          <td><input type="hidden" name="variants[${i}][texture_id]" value="${t.id}"><span class="badge bg-light text-dark">${t.name}</span></td>
          <td><input type="text" class="form-control form-control-sm input-price" name="variants[${i}][price]" value="0"></td>
          <td><input type="number" step="1" value="1" class="form-control form-control-sm" name="variants[${i}][quantity]" placeholder="1"></td>
          <td><input type="file" class="form-control form-control-sm" name="variants[${i}][image]" accept="image/*"></td>
          <td class="text-center">
            <input type="hidden" name="variants[${i}][status]" value="0">
            <div class="form-check form-switch d-inline-block">
              <input class="form-check-input" type="checkbox" name="variants[${i}][status]" value="1" checked>
            </div>
          </td>
          <td class="text-center">
            <button type="button" class="btn btn-sm btn-outline-danger btn-remove-variant">
              <i class="ri-delete-bin-line"></i>
            </button>
          </td>
        </tr>`;
                    $tbody.append(row);
                    i++;
                })));
            });

            /* =========================
             * 7) XÓA BIẾN THỂ / XÓA TẤT CẢ
             * ========================= */
            $(document).on('click', '.btn-remove-variant', function() {
                $(this).closest('tr').remove();
            });
            $('#btn-clear-variants').on('click', function() {
                if (confirm('Xoá toàn bộ biến thể?')) $('#variants-table tbody').empty();
            });

            /* =========================
             * 8) CHẶN SUBMIT NẾU THIẾU NHÓM
             * ========================= */
            $('#product-form').on('submit', function(e) {
                const check = validateFullAttributes();
                if (!check.ok) {
                    e.preventDefault();
                    if (window.toastr) toastr.error(check.msg);
                    else alert(check.msg);
                    document.querySelector('#attr-colors').closest('.card').scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                    return false;
                }
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\LARAGON\laragon\www\DATN\duAnTotNghiep_website_ban_quan_ao_STYLEX\resources\views\admin\products\create.blade.php ENDPATH**/ ?>