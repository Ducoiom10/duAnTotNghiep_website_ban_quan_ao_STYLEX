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
<?php $__env->startSection('title'); ?>
    Danh sách bài viết
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="row cursor-pointer">
        <div class="col-12 col-sm-6 col-md-3 mb-3">
            <div class="card stats-card total-card">
                <div class="card-body text-center">
                    <div class="stat-icon text-primary">
                        <i class="la la-images"></i>
                    </div>
                    <h5 class="card-title text-muted mb-2">Tổng số bài viết</h5>
                    <h3 class="card-text fw-bold"><?php echo e($posts_total ?? 0); ?></h3>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-3 mb-3">
            <div class="card stats-card approved-card">
                <div class="card-body text-center">
                    <div class="stat-icon text-success">
                        <i class="la la-check-circle"></i>
                    </div>
                    <h5 class="card-title text-muted mb-2">Số bài viết đã xuất bản</h5>
                    <h3 class="card-text fw-bold text-success"><?php echo e($posts_published ?? 0); ?></h3>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-3 mb-3">
            <div class="card stats-card pending-card">
                <div class="card-body text-center">
                    <div class="stat-icon text-warning">
                        <i class="la la-ban"></i>
                    </div>
                    <h5 class="card-title text-muted mb-2">Số bài viết nổi bật</h5>
                    <h3 class="card-text fw-bold text-warning"><?php echo e($posts_is_hot ?? 0); ?></h3>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-3 mb-3">
            <div class="card stats-card rejected-card">
                <div class="card-body text-center">
                    <div class="stat-icon text-danger">
                        <i class="la la-trash"></i>
                    </div>
                    <h5 class="card-title text-muted mb-2">Số bài viết đã xóa</h5>
                    <h3 class="card-text fw-bold text-danger"><?php echo e($posts_deleted ?? 0); ?></h3>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Quản lí bài viết</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">Dashboard</a></li>
                            <li class="breadcrumb-item active">Danh sách bài viết</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h4 class="card-title mb-0">Danh sách bài viết</h4>
                        <button class="btn btn-outline-primary btn-sm" id="toggleFilterBtn">
                            <i class="ri-filter-3-line"></i> Bộ lọc
                        </button>
                    </div><!-- end card header -->

                    
                    <div class="card-body" id="filterForm" style="display: none;">
                        <form action="<?php echo e(route('admin.posts.index')); ?>" method="GET">
                            <div class="row g-3">
                                
                                <div class="col-md-3">
                                    <label class="form-label fw-semibold">Tiêu đề</label>
                                    <input type="text" name="title" value="<?php echo e(request('title')); ?>" class="form-control"
                                        placeholder="Nhập tiêu đề banner">
                                </div>

                                
                                <div class="col-md-2">
                                    <label class="form-label fw-semibold">Trạng thái</label>
                                    <select name="status" class="form-select">
                                        <option value="" selected>-- Tất cả --</option>
                                        <option value="1">Hoạt
                                            động
                                        </option>
                                        <option value="0">
                                            Ngừng
                                            hoạt động</option>
                                    </select>
                                </div>

                                
                                <div class="col-md-12 d-flex justify-content-end gap-2 mt-2">
                                    <button type="submit" class="btn btn-primary btn-sm">
                                        <i class="ri-search-line"></i> Lọc
                                    </button>
                                    <a href="<?php echo e(route('admin.posts.index')); ?>" class="btn btn-secondary btn-sm">
                                        <i class="ri-refresh-line"></i> Đặt lại
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="card-body" id="item_List">
                        <div class="listjs-table" id="customerList">
                            <div class="row g-4 mb-3">
                                <div class="col-sm-auto">
                                    <div>
                                        <a href="<?php echo e(route('admin.posts.create')); ?>" class="btn btn-success add-btn"><i
                                                class="ri-add-line align-bottom me-1"></i> Thêm mới</a>
                                        <button class="btn btn-soft-danger" onClick="deleteMultiple()"><i
                                                class="ri-delete-bin-2-line"></i></button>
                                    </div>
                                </div>
                                <div class="col-sm">
                                    <div class="d-flex justify-content-sm-end">
                                        <div class="search-box ms-2">
                                            <input type="text" name="search_full" id="searchFull"
                                                class="form-control search" placeholder="Tìm kiếm..." data-search
                                                value="<?php echo e(request()->input('search_full') ?? ''); ?>">
                                            <button id="search-full" class="ri-search-line search-icon m-0 p-0 border-0"
                                                style="background: none;"></button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="table-responsive table-card mt-3 mb-1">
                                <table class="table align-middle table-nowrap" id="customerTable">
                                    <thead class="table-light">
                                        <tr>
                                            <th scope="col" style="width: 50px;">
                                                <input type="checkbox" id="checkAll">
                                            </th>
                                            <th>STT</th>
                                            <th>Tiêu đề</th>
                                            <th>Ảnh bìa</th>
                                            <th>Tác giả</th>
                                            <th>Danh mục</th>
                                            <th>Trạng thái</th>
                                            <th>Ngày đăng tải</th>
                                            <th>Hành Động</th>
                                        </tr>
                                    </thead>
                                    <tbody class="list">
                                        <?php $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <th scope="row">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="itemID"
                                                            value="<?php echo e($post->id); ?>">
                                                    </div>
                                                </th>

                                                <td class="customer_name"><?php echo e($loop->iteration); ?></td>
                                                <td>
                                                    <h6 class="mb-0 text-truncate" style="max-width: 250px;">
                                                        <?php echo e($post->title); ?></h6>
                                                </td>
                                                <td>
                                                    <img class="rounded shadow-sm"
                                                        src="<?php echo e(Storage::url($post->thumbnail)); ?>" alt="Hình đại diện"
                                                        width="80" height="50" style="object-fit: cover;">
                                                </td>
                                                <td class="text-danger fw-bold"><?php echo e($post->user->name ?? ''); ?></td>
                                                <td><?php echo e($post->category->name ?? ''); ?></td>
                                                <td class="status col-1">
                                                    <?php if($post->status === 'published'): ?>
                                                        <span class="badge bg-success w-75">
                                                            Xuất bản
                                                        </span>
                                                    <?php elseif($post->status === 'pending'): ?>
                                                        <span class="badge bg-warning w-75">
                                                            Chờ xử lí
                                                        </span>
                                                    <?php elseif($post->status === 'draft'): ?>
                                                        <span class="badge bg-secondary w-75">
                                                            Bản nháp
                                                        </span>
                                                    <?php elseif($post->status === 'scheduled'): ?>
                                                        <span class="badge bg-info w-75">
                                                           Chờ xuất bản
                                                        </span>
                                                    <?php else: ?>
                                                        <span class="badge bg-danger w-75">
                                                            Riêng tư
                                                        </span>
                                                    <?php endif; ?>
                                                </td>

                                                <td>
                                                    <?php echo $post->published_at
                                                        ? \Carbon\Carbon::parse($post->published_at)->format('d/m/Y')
                                                        : '<span class="btn btn-sm btn-soft-warning">Chưa đăng</span>'; ?>

                                                </td>


                                                <td>
                                                    <div class="d-flex gap-1">
                                                        <div class="edit">
                                                            <form action="<?php echo e(route('admin.posts.edit', $post->id)); ?>"
                                                                method="get">
                                                                <?php echo csrf_field(); ?>
                                                                <button class="btn btn-sm btn-warning edit-item-btn">
                                                                    <span class="ri-edit-box-line"></span>
                                                                </button>
                                                            </form>
                                                        </div>
                                                        <div class="show">
                                                            <form action="<?php echo e(route('admin.posts.show', $post->id)); ?>"
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
                                                                action="<?php echo e(route('admin.posts.destroy', $post->id)); ?>"
                                                                class="d-inline delete-form">
                                                                <?php echo csrf_field(); ?>
                                                                <?php echo method_field('DELETE'); ?>
                                                                <button type="button"
                                                                    class="btn btn-sm btn-danger remove-item-btn btn-delete"
                                                                    data-name="<?php echo e($post->title); ?>">
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

                                    
                                    <?php if($posts->onFirstPage()): ?>
                                        <a class="page-item pagination-prev disabled"
                                            href="javascript:void(0);">Previous</a>
                                    <?php else: ?>
                                        <a class="page-item pagination-prev"
                                            href="<?php echo e($posts->previousPageUrl()); ?>">Previous</a>
                                    <?php endif; ?>

                                    
                                    <ul class="pagination listjs-pagination mb-0">
                                        <?php $__currentLoopData = $posts->getUrlRange(1, $posts->lastPage()); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <li class="page-item <?php echo e($page == $posts->currentPage() ? 'active' : ''); ?>">
                                                <a class="page-link" href="<?php echo e($url); ?>"><?php echo e($page); ?></a>
                                            </li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </ul>

                                    
                                    <?php if($posts->hasMorePages()): ?>
                                        <a class="page-item pagination-next" href="<?php echo e($posts->nextPageUrl()); ?>">Next</a>
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
        <!-- end row -->

    </div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\LARAGON\laragon\www\DATN\duAnTotNghiep_website_ban_quan_ao_STYLEX\resources\views\admin\posts\index.blade.php ENDPATH**/ ?>