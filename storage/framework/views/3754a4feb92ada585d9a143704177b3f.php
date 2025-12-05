<?php $__env->startSection('title', 'Danh sách sản phẩm đã xóa'); ?>
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
                        <li class="breadcrumb-item"><a href="<?php echo e(route('admin.products.trash')); ?>">Danh sách sản phẩm đã
                                xóa</a>
                        </li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h4 class="card-title mb-0">Danh sách sản phẩm đã xóa</h4>
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
                                    <button class="btn btn-success" id="restoreSelected">
                                        <i class=" ri-restart-line"> Khôi phục</i>
                                    </button>
                                    <button class="btn btn-danger" id="deleteSelected">
                                        <i class="ri-delete-bin-2-line"> Xóa nhiều</i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-sm">
                                <div class="d-flex justify-content-sm-end">
                                    <div class="search-box ms-2">
                                        <input type="text" class="form-control search" placeholder="Search...">
                                        <i class="ri-search-line search-icon"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive table-card mt-3 mb-1">
                            <table class="table align-middle table-nowrap" id="customerTable">
                                <thead class="table-light">
                                    <tr>
                                        <th scope="col" style="width: 50px;">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="checkAll"
                                                    value="option">
                                            </div>
                                        </th>
                                        <th data-sort="customer_id">ID</th>
                                        <th data-sort="customer_name">Tên sản phẩm</th>
                                        <th data-sort="email">Ảnh</th>
                                        <th data-sort="cate">Danh mục</th>
                                        <th data-sort="phone">Sản phẩm nổi bật</th>
                                        <th data-sort="date">Trạng thái</th>
                                        <th data-sort="action">Hành động</th>
                                    </tr>
                                </thead>
                                <tbody class="list form-check-all">
                                    <?php $__currentLoopData = $productsDeleted; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <th scope="row">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="chk_child"
                                                        value="<?php echo e($item->id); ?>">
                                                </div>
                                            </th>
                                            <td class="customer_id"><?php echo e($item->id); ?></td>
                                            <td class="customer_name"><?php echo e($item->name); ?></td>
                                            <td class="email">
                                                <img src="<?php echo e(Storage::url($item->thumbnail) ?? 'Không có ảnh'); ?>"
                                                    width="50">
                                            </td>
                                            <td class="customer_name"><?php echo e($item->category->name); ?></td>
                                            <td>
                                                <div class="form-check form-switch form-switch-warning">
                                                    <input disabled class="form-check-input" type="checkbox" role="switch"
                                                        name="is_featured" <?php if($item->is_featured): echo 'checked'; endif; ?>
                                                        onchange="toggleFeature(<?php echo e($item->id); ?>, this.checked)">
                                                </div>
                                            </td>
                                            <td class="status">
                                                <?php if($item->status == 'active'): ?>
                                                    <span
                                                        class="badge bg-success-subtle text-success text-uppercase">Active</span>
                                                <?php else: ?>
                                                    <span
                                                        class="badge bg-warning-subtle text-warning text-uppercase">Inactive</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <div class="d-flex gap-1">
                                                    <div class="edit">
                                                        <form action="<?php echo e(route('admin.products.restore', $item->id)); ?>"
                                                            method="post">
                                                            <?php echo csrf_field(); ?>
                                                            <?php echo method_field('PATCH'); ?>
                                                            <button class="btn btn-sm btn-success edit-item-btn btn-remove"
                                                                data-bs-toggle="modal" data-bs-target="#showModal" data-name="<?php echo e($item->name); ?>">
                                                                <i class="las la-redo-alt"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                    <div class="remove">
                                                        <form method="POST"
                                                            action="<?php echo e(route('admin.products.force-delete', $item->id)); ?>"
                                                            class="d-inline delete-form">
                                                            <?php echo csrf_field(); ?>
                                                            <?php echo method_field('DELETE'); ?>
                                                            <button type="button"
                                                                class="btn btn-sm btn-danger remove-item-btn btn-forcedelete"
                                                                data-name="<?php echo e($item->name); ?>">
                                                                <i class="ri-delete-bin-2-line"></i>
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

                                
                                <?php if($productsDeleted->onFirstPage()): ?>
                                    <a class="page-item pagination-prev disabled" href="javascript:void(0);">Previous</a>
                                <?php else: ?>
                                    <a class="page-item pagination-prev"
                                        href="<?php echo e($productsDeleted->previousPageUrl()); ?>">Previous</a>
                                <?php endif; ?>

                                
                                <ul class="pagination listjs-pagination mb-0">
                                    <?php $__currentLoopData = $productsDeleted->getUrlRange(1, $productsDeleted->lastPage()); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li class="page-item <?php echo e($page == $productsDeleted->currentPage() ? 'active' : ''); ?>">
                                            <a class="page-link" href="<?php echo e($url); ?>"><?php echo e($page); ?></a>
                                        </li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>

                                
                                <?php if($productsDeleted->hasMorePages()): ?>
                                    <a class="page-item pagination-next" href="<?php echo e($productsDeleted->nextPageUrl()); ?>">Next</a>
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

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\LARAGON\laragon\www\DATN\duAnTotNghiep_website_ban_quan_ao_STYLEX\resources\views\admin\products\trash.blade.php ENDPATH**/ ?>