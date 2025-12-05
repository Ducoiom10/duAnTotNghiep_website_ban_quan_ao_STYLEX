<?php $__env->startSection('title', 'Quản lí danh mục'); ?>
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

        .category-table th,
        .category-table td {
            vertical-align: middle;
        }
    </style>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Quản lí danh mục</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item active"><a href="javascript: void(0);">Quản lí danh mục</a></li>
                        <li class="breadcrumb-item">Danh sách danh mục</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    
    <!-- Thống kê danh mục -->
    <div class="row cursor-pointer">
        <div class="col-12 col-sm-6 col-md-3 mb-3">
            <div class="card stats-card total-card">
                <div class="card-body text-center">
                    <div class="stat-icon text-primary">
                        <i class="ri-folder-line"></i>
                    </div>
                    <h5 class="card-title text-muted mb-2">Tổng số danh mục</h5>
                    <h3 class="card-text fw-bold"><?php echo e($categoryStats['total_categories'] ?? 0); ?></h3>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-3 mb-3">
            <div class="card stats-card approved-card">
                <div class="card-body text-center">
                    <div class="stat-icon text-success">
                        <i class="ri-checkbox-circle-line"></i>
                    </div>
                    <h5 class="card-title text-muted mb-2">Danh mục hoạt động</h5>
                    <h3 class="card-text fw-bold text-success"><?php echo e($categoryStats['active_categories'] ?? 0); ?></h3>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-3 mb-3">
            <div class="card stats-card pending-card">
                <div class="card-body text-center">
                    <div class="stat-icon text-warning">
                        <i class="ri-pause-circle-line"></i>
                    </div>
                    <h5 class="card-title text-muted mb-2">Danh mục không hoạt động</h5>
                    <h3 class="card-text fw-bold text-warning"><?php echo e($categoryStats['inactive_categories'] ?? 0); ?></h3>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-3 mb-3">
            <div class="card stats-card parent-card">
                <div class="card-body text-center">
                    <div class="stat-icon text-info">
                        <i class="ri-folder-open-line"></i>
                    </div>
                    <h5 class="card-title text-muted mb-2">Danh mục cha</h5>
                    <h3 class="card-text fw-bold text-info"><?php echo e($categoryStats['parent_categories'] ?? 0); ?></h3>
                </div>
            </div>
        </div>
    </div>

<section class="section">
    <?php if(isset($error)): ?>
        <div class="alert alert-danger">
            <strong>Lỗi:</strong> <?php echo e($error); ?>

        </div>
    <?php endif; ?>
    
    <div class="row" id="table-striped">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">Danh sách danh mục</h4>
                    <button type="button" class="btn btn-success add-btn" data-bs-toggle="modal" data-bs-target="#createCategoryModal">
                        <i class="ri-add-line align-bottom me-1"></i> Thêm mới
                    </button>
                    <!-- form add -->
                    <div class="modal fade" id="createCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addCategoryModalLabel">
                                        <i class="bi bi-plus-circle-fill me-2"></i> Thêm Danh Mục Mới
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="addCategoryForm" class="p-2">
                                        <?php echo csrf_field(); ?>
                                        <!-- Tên danh mục -->
                                        <div class="mb-4">
                                            <label for="categoryName" class="form-label fw-semibold">
                                                <i class="bi bi-tag-fill me-2 text-primary"></i> Tên danh mục mới
                                            </label>
                                            <input
                                                type="text"
                                                class="form-control border-0 shadow-sm theme-input"
                                                name="category_name"
                                                placeholder="Nhập tên danh mục">
                                        </div>

                                        <!-- Danh mục cha -->
                                        <div class="mb-3">
                                            <label for="parentCategory" class="form-label fw-semibold">
                                                <i class="bi bi-diagram-3-fill me-2 text-success"></i> Danh mục cha
                                            </label>
                                            <select
                                                class="form-select border-0 shadow-sm theme-input"
                                                name="parent_id" id="parentCategorySelect">
                                                <option selected value="">Không có (Mặc định)</option>
                                                <?php $__currentLoopData = $parentCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($cat->id); ?>"><?php echo e($cat->name); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>

                                        <!-- Danh mục con -->
                                        <div class="mb-3" id="childCategoriesSection" style="display: none;">
                                            <label class="form-label fw-semibold">
                                                <i class="bi bi-list-nested me-2 text-info"></i> Danh mục con
                                            </label>
                                            <div class="border rounded p-3 bg-light" style="max-height: 200px; overflow-y: auto;">
                                                <div id="childCategoriesHeader" class="mb-3">
                                                    <!-- Header sẽ hiển thị danh mục cha được chọn -->
                                                </div>
                                                <div id="childCategoriesList">
                                                    <!-- Danh mục con sẽ được load ở đây -->
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Nút hành động -->
                                        <div class="text-end mt-4">
                                            <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">
                                                <i class="bi bi-x-circle"></i> Hủy
                                            </button>
                                            <button type="submit" class="btn btn-primary px-4 addBtn">
                                                <i class="bi bi-plus-circle"></i> Thêm danh mục
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-content">
                    <section class="section">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive datatable-minimal">
                                    <table class="table table-hover table-lg category-table">
                                        <thead>
                                            <tr>
                                                <th>STT</th>
                                                <th>Danh Mục</th>
                                                <th>Danh Mục Cha</th>
                                                <th>Trạng Thái</th>
                                                <th>Thao Tác</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $stt = ($parentCategories->currentPage() - 1) * $parentCategories->perPage(); ?>
                                            <?php if($parentCategories->count() == 0): ?>
                                                <tr>
                                                    <td colspan="5" class="text-center">
                                                        <div class="alert alert-info">
                                                            <strong>Thông báo:</strong> Chưa có danh mục nào. Hãy thêm danh mục đầu tiên!
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endif; ?>
                                            <?php $__currentLoopData = $parentCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr class=" parent-row" data-parent-id="<?php echo e($category->id); ?>" style="cursor:pointer;">
                                                    <td><?php echo e(++$stt); ?></td>
                                                    <td><strong><i class="bi bi-caret-right-fill toggle-icon me-2"></i><?php echo e($category->name); ?></strong></td>
                                                    <td>—</td>
                                                    <td>
                                                        <?php if($category->status == 1): ?>
                                                            <span class="badge bg-success">Hoạt động</span>
                                                        <?php else: ?>
                                                            <span class="badge bg-secondary">Không hoạt động</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <a href="<?php echo e(route('admin.category.edit', $category->id)); ?>" title="Sửa" class="btn btn-sm btn-warning me-1"><i class="ri-edit-box-line"></i></a>
                                                        <a href="#" title="Xóa" class="btn btn-sm btn-danger delete-category" data-id="<?php echo e($category->id); ?>" data-name="<?php echo e($category->name); ?>" data-children="<?php echo e($category->children->count()); ?>"><i class="ri-delete-bin-7-line"></i></a>
                                                        <form id="delete-cat-<?php echo e($category->id); ?>" action="<?php echo e(route('admin.category.destroy', $category->id)); ?>" method="POST" class="d-none">
                                                            <?php echo csrf_field(); ?>
                                                            <?php echo method_field('DELETE'); ?>
                                                        </form>
                                                    </td>
                                                </tr>

                                                
                                                <?php $__currentLoopData = $category->children; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $child): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <tr class="child-row child-of-<?php echo e($category->id); ?>" style="display:none;">
                                                        <td></td>
                                                        <td style="padding-left: 40px;">↳ <?php echo e($child->name); ?></td>
                                                        <td><?php echo e($category->name); ?></td>
                                                        <td>
                                                            <?php if($child->status == 1): ?>
                                                                <span class="badge bg-success">Hoạt động</span>
                                                            <?php else: ?>
                                                                <span class="badge bg-secondary">Không hoạt động</span>
                                                            <?php endif; ?>
                                                        </td>
                                                            <td>
                                                                <a href="<?php echo e(route('admin.category.edit', $child->id)); ?>" title="Sửa" class="btn btn-sm btn-warning me-1"><i class="ri-edit-box-line"></i></a>
                                                                <a href="#" title="Xóa" class="btn btn-sm btn-danger delete-category" data-id="<?php echo e($child->id); ?>" data-name="<?php echo e($child->name); ?>" data-children="0"><i class="ri-delete-bin-7-line"></i></a>
                                                                <form id="delete-cat-<?php echo e($child->id); ?>" action="<?php echo e(route('admin.category.destroy', $child->id)); ?>" method="POST" class="d-none">
                                                                    <?php echo csrf_field(); ?>
                                                                    <?php echo method_field('DELETE'); ?>
                                                                </form>
                                                            </td>
                                                    </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tbody>
                                    </table>
                                </div>
                                    <?php echo e($parentCategories->links('pagination::bootstrap-5')); ?>

                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    $(document).ready(function() {
        // Thêm danh mục
        $('#addCategoryForm').submit(function(e) {
            e.preventDefault();
            $('.addBtn').prop('disabled', true);
            var formData = $(this).serialize();

            $.ajax({
                url: "<?php echo e(route('admin.category.store')); ?>",
                type: "POST",
                data: formData,
                success: function(res) {
                    if (res.success) {
                        toastr.success(res.msg);
                        setTimeout(function() {
                            location.reload();
                        }, 1500);
                    } else {
                        toastr.error(res.msg);
                    }
                    $('.addBtn').prop('disabled', false);
                },
                error: function() {
                    toastr.error('Có lỗi xảy ra khi thêm danh mục');
                    $('.addBtn').prop('disabled', false);
                }
            });
        });

        // Ẩn/hiện danh mục con
        $(document).on('click', '.parent-row', function(e) {
            if ($(e.target).closest('a').length) return;
            const parentId = $(this).data('parent-id');
            const children = $(`.child-of-${parentId}`);
            const icon = $(this).find('.toggle-icon');

            if (children.is(':visible')) {
                children.hide();
                icon.removeClass('bi-caret-down-fill').addClass('bi-caret-right-fill');
            } else {
                children.show();
                icon.removeClass('bi-caret-right-fill').addClass('bi-caret-down-fill');
            }
        });

        // Xóa danh mục
        $(document).on('click', '.delete-category', function(e) {
            e.preventDefault();
            const id = $(this).data('id');
            const name = $(this).data('name');
            const childrenCount = parseInt($(this).data('children'));
            
            let confirmMessage = `Bạn có chắc chắn muốn xóa danh mục "${name}"?`;
            if (childrenCount > 0) {
                confirmMessage += `\n\nCảnh báo: Danh mục này có ${childrenCount} danh mục con. Tất cả danh mục con cũng sẽ bị xóa!`;
            }
            
            if (confirm(confirmMessage)) {
                $.ajax({
                    url: `/admin/category/${id}`,
                    type: "DELETE",
                    data: {
                        _token: "<?php echo e(csrf_token()); ?>"
                    },
                    success: function(res) {
                        if (res.success) {
                            toastr.success(res.msg);
                            setTimeout(function() {
                                location.reload();
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
        });
    });

    // Function để mở modal thêm danh mục từ sidebar
    function openAddCategoryModal() {
        $('#createCategoryModal').modal('show');
    }

    // Load danh mục con khi chọn danh mục cha
    $('#parentCategorySelect').change(function() {
        const parentId = $(this).val();
        const childSection = $('#childCategoriesSection');
        const childHeader = $('#childCategoriesHeader');
        const childList = $('#childCategoriesList');
        
        if (parentId) {
            // Sử dụng dữ liệu đã có từ server
            const categories = <?php echo json_encode($parentCategories->items(), 15, 512) ?>;
            const selectedCategory = categories.find(cat => cat.id == parentId);
            
            if (selectedCategory) {
                // Hiển thị header với thông tin danh mục cha
                childHeader.html(`
                    <div class="alert alert-info mb-0">
                        <i class="bi bi-info-circle me-2"></i>
                        <strong>Danh mục cha:</strong> ${selectedCategory.name}
                        <span class="badge ${selectedCategory.status == 1 ? 'bg-success' : 'bg-danger'} ms-2">
                            ${selectedCategory.status == 1 ? 'Hoạt động' : 'Không hoạt động'}
                        </span>
                    </div>
                `);
                
                if (selectedCategory.children && selectedCategory.children.length > 0) {
                    let html = '<div class="mt-3"><h6 class="text-muted mb-2"><i class="bi bi-list-ul me-1"></i> Danh sách danh mục con:</h6>';
                    selectedCategory.children.forEach(child => {
                        html += `
                            <div class="d-flex align-items-center mb-2 p-2 bg-white rounded border">
                                <i class="bi bi-arrow-right me-2 text-muted"></i>
                                <span class="text-dark">${child.name}</span>
                                <span class="badge ${child.status == 1 ? 'bg-success' : 'bg-danger'} ms-auto">
                                    ${child.status == 1 ? 'Hoạt động' : 'Không hoạt động'}
                                </span>
                            </div>
                        `;
                    });
                    html += '</div>';
                    childList.html(html);
                } else {
                    childList.html('<div class="mt-3"><p class="text-muted text-center mb-0"><i class="bi bi-inbox me-1"></i> Chưa có danh mục con</p></div>');
                }
                childSection.show();
            }
        } else {
            childSection.hide();
        }
    });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\LARAGON\laragon\www\DATN\duAnTotNghiep_website_ban_quan_ao_STYLEX\resources\views\admin\category\index.blade.php ENDPATH**/ ?>