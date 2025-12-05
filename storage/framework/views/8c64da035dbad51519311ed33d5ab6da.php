<?php $__env->startSection('title', 'Danh sách banner đã xóa'); ?>
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
                <h4 class="mb-sm-0">Quản lí banner đã xóa</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item active"><a href="javascript: void(0);">Quản lí banner đã xóa</a></li>
                        <li class="breadcrumb-item">Danh sách banner đã xóa</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Danh sách banner đã xóa</h4>

                </div><!-- end card header -->

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
                                          <th>STT</th>
                                            <th>Tiêu đề</th>
                                            <th>Ảnh</th>
                                            <th>Trạng thái</th>
                                            <th>Ngày tạo</th>
                                            <th>Ngày cập nhật</th>
                                            <th>Hành động</th>
                                    </tr>
                                </thead>
                                <tbody class="list form-check-all">
                                   <?php $__currentLoopData = $bannersDeleted; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $banner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr data-id="<?php echo e($banner->id); ?>">
                                                <th scope="row">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="itemID"
                                                            value="<?php echo e($banner->id); ?>" data-id="<?php echo e($banner->id); ?>">
                                                    </div>
                                                </th>
                                                <td class="order"><?php echo e($loop->iteration); ?></td>
                                                <td class="customer_name"><?php echo e($banner->title); ?></td>
                                                <td>
                                                    <?php if($banner->image): ?>
                                                        <img src="<?php echo e(Storage::url($banner->image)); ?>" alt=""
                                                            class="img-thumbnail" style="max-width: 100px">
                                                    <?php else: ?>
                                                        <span class="text-muted">Không có ảnh</span>
                                                    <?php endif; ?>
                                                </td>
                                                <?php if($banner->status): ?>
                                                    <td class="status"><span class="badge bg-success-subtle text-success">
                                                            Hoạt động
                                                        </span></td>
                                                <?php else: ?>
                                                    <td class="status"><span class="badge bg-danger-subtle text-danger">
                                                            Không hoạt động
                                                        </span></td>
                                                <?php endif; ?>

                                                <td class="date"><?php echo e($banner->created_at); ?></td>
                                                <td class="date"><?php echo e($banner->updated_at); ?></td>
                                                <td>
                                                    <div class="d-flex gap-1">
                                                    <div class="edit">
                                                        <form action="<?php echo e(route('admin.banners.restore', $banner->id)); ?>"
                                                            method="post">
                                                            <?php echo csrf_field(); ?>
                                                            <?php echo method_field('PATCH'); ?>
                                                            <button class="btn btn-sm btn-success edit-item-btn btn-remove"
                                                                data-bs-toggle="modal" data-bs-target="#showModal" data-name="<?php echo e($banner->title); ?>">
                                                                <i class="las la-redo-alt"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                    <div class="remove">
                                                        <form method="POST"
                                                            action="<?php echo e(route('admin.banners.force-delete', $banner->id)); ?>"
                                                            class="d-inline delete-form">
                                                            <?php echo csrf_field(); ?>
                                                            <?php echo method_field('DELETE'); ?>
                                                            <button type="button"
                                                                class="btn btn-sm btn-danger remove-item-btn btn-forcedelete"
                                                                data-name="<?php echo e($banner->title); ?>">
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

                                
                                <?php if($bannersDeleted->onFirstPage()): ?>
                                    <a class="page-item pagination-prev disabled" href="javascript:void(0);">Previous</a>
                                <?php else: ?>
                                    <a class="page-item pagination-prev"
                                        href="<?php echo e($bannersDeleted->previousPageUrl()); ?>">Previous</a>
                                <?php endif; ?>

                                
                                <ul class="pagination listjs-pagination mb-0">
                                    <?php $__currentLoopData = $bannersDeleted->getUrlRange(1, $bannersDeleted->lastPage()); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li class="page-item <?php echo e($page == $bannersDeleted->currentPage() ? 'active' : ''); ?>">
                                            <a class="page-link" href="<?php echo e($url); ?>"><?php echo e($page); ?></a>
                                        </li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>

                                
                                <?php if($bannersDeleted->hasMorePages()): ?>
                                    <a class="page-item pagination-next"
                                        href="<?php echo e($bannersDeleted->nextPageUrl()); ?>">Next</a>
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

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\LARAGON\laragon\www\DATN\duAnTotNghiep_website_ban_quan_ao_STYLEX\resources\views\admin\banners\trash.blade.php ENDPATH**/ ?>