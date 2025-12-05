<?php $__env->startSection('title', 'Danh sách sản phẩm'); ?>
<?php $__env->startPush('page-css'); ?>
    <link href="<?php echo e(asset('assets/css/custom.css')); ?>" rel="stylesheet" type="text/css" />

    <style>
        .stat-card {
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s, box-shadow 0.3s;
            height: 150px;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        }

        .stat-icon {
            font-size: 1.5rem;
            margin-bottom: 10px;
        }

        .user-table th,
        .user-table td {
            vertical-align: middle;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }
    </style>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Quản lí sản phẩm</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item active"><a href="javascript: void(0);">Quản lí sản phẩm</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo e(route('admin.products.index')); ?>">Danh sách sản phẩm</a>
                        </li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <div class="row cursor-pointer">
        <div class="col-12 col-sm-6 col-md-3 mb-3">
            <div class="card stats-card total-card">
                <div class="card-body text-center">
                    <div class="stat-icon text-primary">
                        <i class="ri-shopping-bag-line"></i>
                    </div>
                    <h5 class="card-title text-muted mb-2">Tổng số sản phẩm</h5>
                    <h3 class="card-text fw-bold"><?php echo e($productCounts->total_products ?? 0); ?></h3>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-3 mb-3">
            <div class="card stats-card approved-card">
                <div class="card-body text-center">
                    <div class="stat-icon text-success">
                        <i class="ri-checkbox-circle-line"></i>
                    </div>
                    <h5 class="card-title text-muted mb-2">Số sản phẩm hoạt động</h5>
                    <h3 class="card-text fw-bold text-success"><?php echo e($productCounts->active_products ?? 0); ?></h3>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-3 mb-3">
            <div class="card stats-card pending-card">
                <div class="card-body text-center">
                    <div class="stat-icon text-warning">
                        <i class="ri-pause-circle-line"></i>
                    </div>
                    <h5 class="card-title text-muted mb-2">Số sản phẩm không hoạt động</h5>
                    <h3 class="card-text fw-bold text-warning"><?php echo e($productCounts->inactive_products ?? 0); ?></h3>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-3 mb-3">
            <div class="card stats-card rejected-card">
                <div class="card-body text-center">
                    <div class="stat-icon text-danger">
                        <i class="ri-star-line"></i>
                    </div>
                    <h5 class="card-title text-muted mb-2">Tổng số sản phẩm nổi bật</h5>
                    <h3 class="card-text fw-bold text-danger"><?php echo e($productCounts->featured_products ?? 0); ?></h3>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h4 class="card-title mb-0">Danh sách sản phẩm</h4>
                    <button class="btn btn-outline-primary btn-sm" id="toggleFilterBtn">
                        <i class="ri-filter-3-line"></i> Bộ lọc
                    </button>
                </div><!-- end card header -->

                
                <div class="card-body" id="filterForm" style="display: none;">
                    <form action="<?php echo e(route('admin.products.index')); ?>" method="GET">
                        <div class="row g-3">
                            
                            <div class="col-md-3">
                                <label class="form-label fw-semibold">Tên</label>
                                <input type="text" name="name" value="<?php echo e(request('name')); ?>" class="form-control"
                                    placeholder="Nhập tên sản phẩm">
                            </div>

                            
                            <div class="col-md-2">
                                <label class="form-label fw-semibold">Danh mục</label>
                                <select name="category_id" class="form-select">
                                    <option value="">-- Tất cả --</option>
                                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($category->id); ?>"
                                            <?php echo e(request('category_id') == $category->id ? 'selected' : ''); ?>>
                                            <?php echo e($category->name); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>

                            
                            <div class="col-md-2">
                                <label class="form-label fw-semibold">Trạng thái</label>
                                <select name="status" class="form-select">
                                    <option value="">-- Tất cả --</option>
                                    <option value="active" <?php echo e(request('status') == 'active' ? 'selected' : ''); ?>>Hoạt động
                                    </option>
                                    <option value="inactive" <?php echo e(request('status') == 'inactive' ? 'selected' : ''); ?>>Ngừng
                                        hoạt động</option>
                                </select>
                            </div>

                            
                            <div class="col-md-2">
                                <label class="form-label fw-semibold">Sản phẩm nổi bật</label>
                                <select name="is_featured" class="form-select">
                                    <option value="">-- Tất cả --</option>
                                    <option value="1" <?php echo e(request('is_featured') == '1' ? 'selected' : ''); ?>>Có
                                    </option>
                                    <option value="0" <?php echo e(request('is_featured') == '0' ? 'selected' : ''); ?>>Không
                                    </option>
                                </select>
                            </div>


                            
                            <div class="col-md-12 d-flex justify-content-end gap-2 mt-2">
                                <button type="submit" class="btn btn-primary btn-sm">
                                    <i class="ri-search-line"></i> Lọc
                                </button>
                                <a href="<?php echo e(route('admin.products.index')); ?>" class="btn btn-secondary btn-sm">
                                    <i class="ri-refresh-line"></i> Đặt lại
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-body">
                    <div class="listjs-table" id="customerList">
                        <div class="row g-4 mb-3">
                            <div class="col-sm-auto">
                                <div>
                                    <a href="<?php echo e(route('admin.products.create')); ?>" class="btn btn-success add-btn"><i
                                            class="ri-add-line align-bottom me-1"></i> Thêm mới</a>
                                    <button class="btn btn-soft-danger" onClick="deleteMultiple()"><i
                                            class="ri-delete-bin-2-line"></i></button>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end ">
                                <form method="GET" action="<?php echo e(route('admin.products.index')); ?>"
                                    class="d-flex align-items-center" style="max-width: 320px;">
                                    <div class="input-group">
                                        <input type="text" name="name" value="<?php echo e(request('name')); ?>"
                                            class="form-control" placeholder="Tìm kiếm sản phẩm...">
                                        <button class="btn btn-primary" type="submit">
                                            <i class="ri-search-line"></i>
                                        </button>
                                    </div>
                                </form>
                            </div>




                        </div>

                        <div class="table-responsive table-card mt-3 mb-1">
                            <table class="table align-middle text-center table-nowrap" id="customerTable">
                                <thead class="table-light">
                                    <tr>

                                        <th data-sort="customer_id">ID</th>
                                        <th data-sort="customer_name">Tên sản phẩm</th>
                                        <th data-sort="email">Ảnh</th>
                                        <th data-sort="cate">Danh mục</th>
                                        <th data-sort="variants">Biến thể</th>
                                        <th data-sort="phone">Sản phẩm nổi bật</th>
                                        <th data-sort="date">Trạng thái</th>
                                        <th data-sort="action">Hành động</th>
                                    </tr>
                                </thead>
                                <tbody class="list form-check-all">
                                    <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>

                                            <td class="customer_id"><?php echo e($item->id); ?></td>
                                            <td class="customer_name"><?php echo e($item->name); ?></td>
                                            <td class="email">
                                                <img src="<?php echo e($item->thumbnail_url); ?>" width="50" height="50"
                                                    class="rounded" alt="Product Image"
                                                    style="object-fit: cover; background-color: #f8f9fa;">
                                            </td>
                                            <td class="customer_name"><?php echo e($item->category->name); ?></td>
                                            <td class="text-center">
                                                <span class="badge bg-info-subtle text-info">
                                                    <?php echo e($item->productVariants ? $item->productVariants->count() : 0); ?> biến
                                                    thể
                                                </span>
                                                <?php if($item->productVariants && $item->productVariants->count() > 0): ?>
                                                    <br><small class="text-muted">
                                                        <?php $__currentLoopData = $item->productVariants->take(2); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $variant): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <?php echo e($variant->color->name ?? 'N/A'); ?>-<?php echo e($variant->size->name ?? 'N/A'); ?>-<?php echo e($variant->texture->name ?? 'N/A'); ?><?php echo e(!$loop->last ? ', ' : ''); ?>

                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </small>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-center">
                                                <div class="form-check text-center form-switch form-switch-warning">
                                                    <input class="form-check-input" type="checkbox" role="switch"
                                                        name="is_featured" <?php if($item->is_featured): echo 'checked'; endif; ?>
                                                        onchange="toggleFeature(<?php echo e($item->id); ?>, this.checked)">
                                                </div>
                                            </td>
                                            <td class="status">
                                                <?php if($item->is_active == 1): ?>
                                                    <span class="badge bg-success-subtle text-success text-uppercase">Hoạt
                                                        động</span>
                                                <?php else: ?>
                                                    <span class="badge bg-warning-subtle text-warning text-uppercase">Ngừng
                                                        hoạt động</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <div class="d-flex gap-1">
                                                    <div class="edit">
                                                        <form action="<?php echo e(route('admin.products.edit', $item->id)); ?>"
                                                            method="get">
                                                            <?php echo csrf_field(); ?>
                                                            <button class="btn btn-sm btn-warning edit-item-btn">
                                                                <span class="ri-edit-box-line"></span>
                                                            </button>
                                                        </form>
                                                    </div>
                                                    <div class="show">
                                                        <form action="<?php echo e(route('admin.products.show', $item->id)); ?>"
                                                            method="get">
                                                            <?php echo csrf_field(); ?>
                                                            <button class="btn btn-sm btn-info show-item-btn"
                                                                data-bs-toggle="modal" data-bs-target="#showModal">
                                                                <i class="las la-eye"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                    <div class="remove">
                                                        <form method="POST"
                                                            action="<?php echo e(route('admin.products.destroy', $item->id)); ?>"
                                                            class="d-inline delete-form">
                                                            <?php echo csrf_field(); ?>
                                                            <?php echo method_field('DELETE'); ?>
                                                            <button type="button"
                                                                class="btn btn-sm btn-danger remove-item-btn btn-delete"
                                                                data-name="<?php echo e($item->name); ?>">
                                                                <span class="ri-delete-bin-7-line"></span>
                                                            </button>
                                                        </form>

                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                            <div class="noresult" style="display: none">
                                <div class="text-center">
                                    <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop"
                                        colors="primary:#121331,secondary:#08a88a"
                                        style="width:75px;height:75px"></lord-icon>
                                    <h5 class="mt-2">Sorry! No Result Found</h5>
                                    <p class="text-muted mb-0">We've searched more than 150+ Orders We did not find any
                                        orders for you search.</p>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <div class="pagination-wrap hstack gap-2">

                                
                                <?php if($items->onFirstPage()): ?>
                                    <a class="page-item pagination-prev disabled" href="javascript:void(0);">Previous</a>
                                <?php else: ?>
                                    <a class="page-item pagination-prev"
                                        href="<?php echo e($items->previousPageUrl()); ?>">Previous</a>
                                <?php endif; ?>

                                
                                <ul class="pagination listjs-pagination mb-0">
                                    <?php $__currentLoopData = $items->getUrlRange(1, $items->lastPage()); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li class="page-item <?php echo e($page == $items->currentPage() ? 'active' : ''); ?>">
                                            <a class="page-link" href="<?php echo e($url); ?>"><?php echo e($page); ?></a>
                                        </li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>

                                
                                <?php if($items->hasMorePages()): ?>
                                    <a class="page-item pagination-next" href="<?php echo e($items->nextPageUrl()); ?>">Next</a>
                                <?php else: ?>
                                    <a class="page-item pagination-next disabled" href="javascript:void(0);">Next</a>
                                <?php endif; ?>

                            </div>
                        </div>

                    </div>
                </div><!-- end card -->
            </div>
            <!-- end col -->
        </div>
        <!-- end col -->
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
    <script>
        function toggleFeature(productId, isChecked) {
            const url = "<?php echo e(route('admin.products.toggleFeature', ':id')); ?>".replace(':id', productId);

            fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                    },
                    body: JSON.stringify({
                        is_featured: isChecked ? 1 : 0
                    })
                })
                .then(res => res.json())
                .then(data => {
                    toastr.success(data.message);
                })
                .catch(err => {
                    toastr.error('Lỗi cập nhật trạng thái sản phẩm!');
                    console.error('Toggle failed:', err);
                });
        }
    </script>

    <script>
        $(document).ready(function() {
            $('#toggleFilterBtn').on('click', function() {
                $('#filterForm').slideToggle(200);
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\duAnTotNghiep_website_ban_quan_ao_STYLEX-main\resources\views/admin/products/index.blade.php ENDPATH**/ ?>