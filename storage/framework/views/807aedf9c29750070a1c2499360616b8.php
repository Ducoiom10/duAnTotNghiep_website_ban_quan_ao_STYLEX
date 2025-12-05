<?php $__env->startSection('title', 'Cập nhật sản phẩm'); ?>

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
            box-shadow: 0 0 0 .2rem rgba(220, 53, 69, .1)
        }

        .variant-thumb {
            max-width: 200px;
            max-height: 200px;
            width: auto;
            height: auto;
            object-fit: contain;
            border-radius: .25rem;
            border: 1px solid #eee
        }

        #product-img {
            max-width: 300px;
            max-height: 300px;
            width: auto;
            height: auto;
            object-fit: contain;
            border-radius: .25rem;
            border: 1px solid #eee
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <?php
        // Select2: set mặc định theo biến thể đang có (unique id)
        $selectedColorIds = old(
            'attr_colors',
            $product->productVariants->pluck('color_id')->unique()->filter()->values()->all(),
        );
        $selectedSizeIds = old(
            'attr_sizes',
            $product->productVariants->pluck('size_id')->unique()->filter()->values()->all(),
        );
        $selectedTextureIds = old(
            'attr_textures',
            $product->productVariants->pluck('texture_id')->unique()->filter()->values()->all(),
        );

        // Giá hiển thị
        $oldPrice = old('price', $product->price ?? 0);
        $oldPriceSale = old('price_sale', $product->price_sale ?? 0);

        // Biến thể để render bảng: ưu tiên old(), nếu không có thì map từ DB (kèm image_url)
        $oldVariants = old('variants');
        if (is_null($oldVariants)) {
            $oldVariants = $product->productVariants
                ->map(function ($v) {
                    return [
                        'id' => $v->id,
                        'color_id' => $v->color_id,
                        'size_id' => $v->size_id,
                        'texture_id' => $v->texture_id,
                        'price' => $v->price,
                        'quantity' => $v->quantity ?? 1,
                        'status' => $v->status,
                        'image_url' => $v->image ? Storage::url($v->image) : null,
                    ];
                })
                ->values()
                ->all();
        }
    ?>

    <div class="row mb-3">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0">Cập nhật sản phẩm</h4>
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="#">Quản lí sản phẩm</a></li>
                    <li class="breadcrumb-item active">Cập nhật</li>
                </ol>
            </div>
        </div>
    </div>

    <form id="product-form" method="POST" action="<?php echo e(route('admin.products.update', $product)); ?>"
        enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>

        
        <div class="card mb-3">
            <div class="card-header">
                <h5 class="mb-0">Thông tin sản phẩm</h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    
                    <div class="col-md-6">
                        <label class="form-label required">Tên sản phẩm <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="product-name" name="name"
                            value="<?php echo e(old('name', $product->name)); ?>" placeholder="Nhập tên sản phẩm">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label required">Slug <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="product-slug" name="slug"
                            value="<?php echo e(old('slug', $product->slug)); ?>" placeholder="Tự sinh theo tên sản phẩm">
                    </div>

                    
                    <div class="col-md-6">
                        <label class="form-label required">Danh mục <span class="text-danger">*</span></label>
                        <select class="form-select" name="category_id" required>
                            <option value="">Chọn danh mục</option>
                            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cate): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($cate->id); ?>"
                                    <?php echo e(old('category_id', $product->category_id) == $cate->id ? 'selected' : ''); ?>>
                                    <?php echo e($cate->name); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Ảnh đại diện</label>
                        <input type="file" id="product-image-input" name="thumbnail" class="form-control"
                            accept="image/*">
                        <div class="d-flex align-items-center gap-3 mt-2">
                            <img id="product-img" class="rounded" style="max-width: 300px; max-height: 300px; width: auto; height: auto;"
                                src="<?php echo e($product->thumbnail ? Storage::url($product->thumbnail) : ''); ?>">
                            <?php if($product->thumbnail): ?>
                                <small class="text-muted">Ảnh hiện tại</small>
                            <?php endif; ?>
                        </div>
                    </div>

                    
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
                                <?php echo e(old('is_active', $product->is_active) == 1 ? 'checked' : ''); ?>>
                            <label class="form-check-label">Hoạt động</label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label d-block">Nổi bật</label>
                        <input type="hidden" name="is_featured" value="0">
                        <div class="form-check form-switch mt-1">
                            <input class="form-check-input" type="checkbox" name="is_featured" value="1"
                                <?php echo e(old('is_featured', $product->is_featured) == 1 ? 'checked' : ''); ?>>
                            <label class="form-check-label">Gắn “Đặc biệt”</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Tiêu đề SEO</label>
                        <input type="text" class="form-control" name="meta_title"
                            value="<?php echo e(old('meta_title', $product->meta_title)); ?>" placeholder="Tiêu đề SEO">
                    </div>

                    
                    <div class="col-12">
                        <label class="form-label">Mô tả sản phẩm</label>
                        <textarea name="description" class="form-control" rows="5" placeholder="Nhập mô tả"><?php echo e(old('description', $product->description)); ?></textarea>
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
                    
                </div>
            </div>
            <div class="card-body">
                <div class="row g-3 mb-3">
                    <div class="col-md-4">
                        <label class="form-label">Màu sắc</label>
                        <select id="attr-colors" class="select2" name="attr_colors[]" multiple
                            data-placeholder="Chọn màu sắc">
                            <?php $__currentLoopData = $colors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($c->id); ?>" data-name="<?php echo e($c->name); ?>"
                                    <?php echo e(in_array($c->id, $selectedColorIds ?? []) ? 'selected' : ''); ?>>
                                    <?php echo e($c->name); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Kích cỡ</label>
                        <select id="attr-sizes" class="select2" name="attr_sizes[]" multiple
                            data-placeholder="Chọn kích cỡ">
                            <?php $__currentLoopData = $sizes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($s->id); ?>" data-name="<?php echo e($s->name); ?>"
                                    <?php echo e(in_array($s->id, $selectedSizeIds ?? []) ? 'selected' : ''); ?>>
                                    <?php echo e($s->name); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Chất liệu</label>
                        <select id="attr-textures" class="select2" name="attr_textures[]" multiple
                            data-placeholder="Chọn chất liệu">
                            <?php $__currentLoopData = $textures; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($t->id); ?>" data-name="<?php echo e($t->name); ?>"
                                    <?php echo e(in_array($t->id, $selectedTextureIds ?? []) ? 'selected' : ''); ?>>
                                    <?php echo e($t->name); ?>

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
                                
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $oldVariants ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $vPrice = $v['price'] ?? 0;
                                    $qty = $v['quantity'] ?? 1;
                                    $status = (int) ($v['status'] ?? 1);
                                    $cName = optional($colors->firstWhere('id', $v['color_id'] ?? null))->name;
                                    $sName = optional($sizes->firstWhere('id', $v['size_id'] ?? null))->name;
                                    $tName = optional($textures->firstWhere('id', $v['texture_id'] ?? null))->name;
                                    $imgUrl = $v['image_url'] ?? null;
                                ?>
                                <tr>
                                    
                                    <?php if(!empty($v['id'])): ?>
                                        <input type="hidden" name="variants[<?php echo e($i); ?>][id]"
                                            value="<?php echo e($v['id']); ?>">
                                    <?php endif; ?>

                                    <td>
                                        <input type="hidden" name="variants[<?php echo e($i); ?>][color_id]"
                                            value="<?php echo e($v['color_id'] ?? ''); ?>">
                                        <span class="badge bg-light text-dark"><?php echo e($cName ?? '—'); ?></span>
                                    </td>
                                    <td>
                                        <input type="hidden" name="variants[<?php echo e($i); ?>][size_id]"
                                            value="<?php echo e($v['size_id'] ?? ''); ?>">
                                        <span class="badge bg-light text-dark"><?php echo e($sName ?? '—'); ?></span>
                                    </td>
                                    <td>
                                        <input type="hidden" name="variants[<?php echo e($i); ?>][texture_id]"
                                            value="<?php echo e($v['texture_id'] ?? ''); ?>">
                                        <span class="badge bg-light text-dark"><?php echo e($tName ?? '—'); ?></span>
                                    </td>
                                    
                                    <td>
                                        <input type="text" class="form-control form-control-sm input-price"
                                            name="variants[<?php echo e($i); ?>][price]"
                                            value="<?php echo e(is_numeric($vPrice) ? number_format((int) $vPrice, 0, ',', '.') : $vPrice); ?>">
                                    </td>
                                    <td>
                                        <input type="number" step="1" class="form-control form-control-sm"
                                            name="variants[<?php echo e($i); ?>][quantity]" value="<?php echo e($qty); ?>">
                                    </td>
                                    <td>
                                        <?php if($imgUrl): ?>
                                            <div class="d-flex align-items-center gap-2 mb-2">
                                                <img src="<?php echo e($imgUrl); ?>" alt="variant-image"
                                                    class="variant-thumb" style="max-width: 200px; max-height: 200px; width: auto; height: auto;">
                                                <small class="text-muted">Ảnh hiện tại</small>
                                            </div>
                                        <?php endif; ?>
                                        <input type="file" class="form-control form-control-sm"
                                            name="variants[<?php echo e($i); ?>][image]" accept="image/*">
                                    </td>
                                    <td class="text-center">
                                        <input type="hidden" name="variants[<?php echo e($i); ?>][status]"
                                            value="0">
                                        <div class="form-check form-switch d-inline-block">
                                            <input class="form-check-input" type="checkbox"
                                                name="variants[<?php echo e($i); ?>][status]" value="1"
                                                <?php echo e($status == 1 ? 'checked' : ''); ?>>
                                        </div>
                                    </td>
                                    
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>

                <small class="text-muted d-block mt-2">Lưu ý: Không thể xoá biến thể đã có. Bạn chỉ có thể thêm biến thể
                    mới.</small>
            </div>
        </div>

        <div class="text-end">
            <button type="submit" class="btn btn-success w-sm mb-3">Cập nhật sản phẩm</button>
        </div>
    </form>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(function() {
            /* === Select2 === */
            $('.select2').select2({
                theme: 'bootstrap-5',
                width: '100%',
                closeOnSelect: false,
                placeholder: function() {
                    return $(this).data('placeholder') || 'Chọn';
                }
            });

            /* === Slug realtime (không ghi đè khi user đã sửa tay) === */
            $('#product-slug').data('touched', <?php echo e(old('slug') ? 'true' : 'false'); ?>);
            $('#product-name').on('input', function() {
                const slug = $(this).val().toLowerCase()
                    .normalize('NFD').replace(/[\u0300-\u036f]/g, '')
                    .replace(/đ/g, 'd').replace(/[^a-z0-9]+/g, '-').replace(/^-+|-+$/g, '');
                if (!$('#product-slug').data('touched')) $('#product-slug').val(slug);
            });
            $('#product-slug').on('input', function() {
                $(this).data('touched', true);
            });

            /* === Giá có dấu . === */
            function fmt(v) {
                return v.replace(/\D/g, '').replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            }
            $(document).on('input', '.input-price', function() {
                this.value = fmt(this.value);
            });
            $('#product-form').on('submit', function() {
                $('.input-price').each(function() {
                    $(this).val($(this).val().replace(/\./g, ''));
                });
            });

            /* === Preview thumbnail === */
            $('#product-image-input').on('change', function() {
                const f = this.files?.[0];
                if (!f) return $('#product-img').attr('src', '');
                const r = new FileReader();
                r.onload = e => $('#product-img').attr('src', e.target.result);
                r.readAsDataURL(f);
            });

            /* === Validate 3 nhóm thuộc tính === */
            function markInvalid($el, invalid) {
                $el.next('.select2').find('.select2-selection').toggleClass('is-invalid', !!invalid);
            }

            function picks($el) {
                return ($el.val() || []).filter(Boolean);
            }

            function validateAttr() {
                const $c = $('#attr-colors'),
                    $s = $('#attr-sizes'),
                    $t = $('#attr-textures');
                const hasC = picks($c).length > 0,
                    hasS = picks($s).length > 0,
                    hasT = picks($t).length > 0;
                const pickedAny = hasC || hasS || hasT,
                    full = hasC && hasS && hasT;
                markInvalid($c, false);
                markInvalid($s, false);
                markInvalid($t, false);
                if (pickedAny && !full) {
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
            $('#attr-colors,#attr-sizes,#attr-textures').on('change', validateAttr);

            /* === Tránh tạo trùng khi Sinh biến thể === */
            function rowKeyFromTr($tr) {
                const c = $tr.find('input[name*="[color_id]"]').val() || '';
                const s = $tr.find('input[name*="[size_id]"]').val() || '';
                const t = $tr.find('input[name*="[texture_id]"]').val() || '';
                return [c, s, t].join('|');
            }

            function collectExistingKeys() {
                const set = new Set();
                $('#variants-table tbody tr').each(function() {
                    set.add(rowKeyFromTr($(this)));
                });
                return set;
            }

            function opts($el) {
                return ($el.val() || []).map(id => ({
                    id,
                    name: $el.find('option[value="' + id + '"]').data('name')
                }));
            }

            $('#btn-generate-variants').on('click', function() {
                const ck = validateAttr();
                if (!ck.ok) {
                    (window.toastr ? toastr.error(ck.msg) : alert(ck.msg));
                    return;
                }

                const C = opts($('#attr-colors')),
                    S = opts($('#attr-sizes')),
                    T = opts($('#attr-textures'));
                const $tb = $('#variants-table tbody');
                let i = $tb.find('tr').length;

                // khoá (color|size|texture) đã có trong bảng (bao gồm biến thể cũ & các dòng mới vừa thêm)
                const exists = collectExistingKeys();

                C.forEach(c => S.forEach(s => T.forEach(t => {
                    const key = [c.id, s.id, t.id].join('|');
                    if (exists.has(key)) return; // đã tồn tại → bỏ qua

                    $tb.append(`
        <tr>
          <td><input type="hidden" name="variants[${i}][color_id]" value="${c.id}"><span class="badge bg-light text-dark">${c.name}</span></td>
          <td><input type="hidden" name="variants[${i}][size_id]" value="${s.id}"><span class="badge bg-light text-dark">${s.name}</span></td>
          <td><input type="hidden" name="variants[${i}][texture_id]" value="${t.id}"><span class="badge bg-light text-dark">${t.name}</span></td>
          <td><input type="text" class="form-control form-control-sm input-price" name="variants[${i}][price]" value="0"></td>
          <td><input type="number" step="1" class="form-control form-control-sm" name="variants[${i}][quantity]" value="1"></td>
          <td><input type="file" class="form-control form-control-sm" name="variants[${i}][image]" accept="image/*"></td>
          <td class="text-center">
            <input type="hidden" name="variants[${i}][status]" value="0">
            <div class="form-check form-switch d-inline-block">
              <input class="form-check-input" type="checkbox" name="variants[${i}][status]" value="1" checked>
            </div>
          </td>
        </tr>
      `);

                    exists.add(key);
                    i++;
                })));
            });

            /* === KHÔNG có xoá dòng, KHÔNG có xoá tất cả theo yêu cầu === */

            // Chỉ validate khi có biến thể trong bảng và khi sinh biến thể mới
            $('#product-form').on('submit', function(e) {
                // Chỉ validate nếu có biến thể trong bảng
                const hasVariants = $('#variants-table tbody tr').length > 0;
                if (hasVariants) {
                    const ck = validateAttr();
                    if (!ck.ok) {
                        e.preventDefault();
                        (window.toastr ? toastr.error(ck.msg) : alert(ck.msg));
                        document.querySelector('#attr-colors').closest('.card').scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                        return false;
                    }
                }
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\LARAGON\laragon\www\DATN\duAnTotNghiep_website_ban_quan_ao_STYLEX\resources\views\admin\products\edit.blade.php ENDPATH**/ ?>