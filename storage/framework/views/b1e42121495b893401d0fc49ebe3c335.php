<?php $__env->startSection('title', 'Quản lý Admin & Staff'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Quản lý Admin & Staff</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">Dashboard</a></li>
                        <li class="breadcrumb-item active">Quản lý Admin & Staff</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <!-- Instructions -->
    <div class="row">
        <div class="col-12">
            <div class="alert alert-info border-0" role="alert">
                <h5 class="alert-heading">
                    <i class="ri-information-line me-2"></i>Hướng dẫn quản lý Admin & Staff
                </h5>
                <p class="mb-2">
                    <strong>Quy trình quản lý Admin & Staff:</strong>
                </p>
                <ol class="mb-0">
                    <li><strong>Quản lý Admin:</strong> Tạo và quản lý tài khoản Admin</li>
                    <li><strong>Quản lý Staff:</strong> Tạo và quản lý tài khoản Staff</li>
                    <li><strong>Thay đổi quyền:</strong> Chọn người dùng → "Thay đổi quyền" → Chọn Admin hoặc Staff</li>
                    <li><strong>Cập nhật hàng loạt:</strong> Chọn nhiều người dùng → "Cập nhật hàng loạt" → Chọn vai trò mới</li>
                </ol>
            </div>
        </div>
    </div>

    <!-- Role Statistics -->
    <div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="card card-animate">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1 overflow-hidden">
                            <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Tổng cộng</p>
                        </div>
                        <div class="flex-shrink-0">
                            <h5 class="text-primary fs-14 mb-0">
                                <i class="ri-arrow-up-s-line fs-13 align-middle"></i>
                            </h5>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mt-3">
                        <div class="flex-grow-1">
                            <h4 class="fs-22 fw-semibold ff-secondary mb-0"><?php echo e($roleStats->total_users ?? 0); ?></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card card-animate">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1 overflow-hidden">
                            <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Admin</p>
                        </div>
                        <div class="flex-shrink-0">
                            <h5 class="text-danger fs-14 mb-0">
                                <i class="ri-arrow-down-s-line fs-13 align-middle"></i>
                            </h5>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mt-3">
                        <div class="flex-grow-1">
                            <h4 class="fs-22 fw-semibold ff-secondary mb-0"><?php echo e($roleStats->admin_count ?? 0); ?></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card card-animate">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1 overflow-hidden">
                            <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Staff</p>
                        </div>
                        <div class="flex-shrink-0">
                            <h5 class="text-warning fs-14 mb-0">
                                <i class="ri-arrow-up-s-line fs-13 align-middle"></i>
                            </h5>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mt-3">
                        <div class="flex-grow-1">
                            <h4 class="fs-22 fw-semibold ff-secondary mb-0"><?php echo e($roleStats->staff_count ?? 0); ?></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Filter and Search -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <div class="search-box">
                                <input type="text" class="form-control search" placeholder="Tìm kiếm theo tên hoặc email..." id="searchInput" value="<?php echo e(request('search')); ?>">
                                <i class="ri-search-line search-icon"></i>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <select class="form-select" id="roleFilter">
                                <option value="">Tất cả quyền</option>
                                <option value="1" <?php echo e(request('role') == '1' ? 'selected' : ''); ?>>Admin</option>
                                <option value="2" <?php echo e(request('role') == '2' ? 'selected' : ''); ?>>Staff</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select class="form-select" id="statusFilter">
                                <option value="">Tất cả trạng thái</option>
                                <option value="active" <?php echo e(request('status') == 'active' ? 'selected' : ''); ?>>Hoạt động</option>
                                <option value="inactive" <?php echo e(request('status') == 'inactive' ? 'selected' : ''); ?>>Chưa kích hoạt</option>
                                <option value="blocked" <?php echo e(request('status') == 'blocked' ? 'selected' : ''); ?>>Đã khóa</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <div class="d-flex gap-2">
                                <a href="<?php echo e(route('admin.roles.create')); ?>" class="btn btn-success">
                                    <i class="ri-add-line me-1"></i> Tạo tài khoản mới
                                </a>
                                <button class="btn btn-primary" id="bulkUpdateBtn" disabled>
                                    <i class="ri-settings-3-line me-1"></i> Cập nhật hàng loạt
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table align-middle text-center table-nowrap" id="roleTable">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col">
                                        <div class="form-check">
                                            <input class="form-check-input fs-15" type="checkbox" id="checkAll">
                                        </div>
                                    </th>
                                    <th scope="col">STT</th>
                                    <th scope="col">Tên</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Quyền hiện tại</th>
                                    <th scope="col">Trạng thái</th>
                                    <th scope="col">Hành động</th>
                                </tr>
                            </thead>
                            <tbody class="list form-check-all">
                                <?php $stt = 0; ?>
                                <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td scope="row">
                                        <div class="form-check">
                                            <input class="form-check-input fs-15" type="checkbox" name="user_ids[]" value="<?php echo e($user->id); ?>">
                                        </div>
                                    </td>
                                    <td class="id"><?php echo e(++$stt); ?></td>
                                    <td class="customer_name"><?php echo e($user->name); ?></td>
                                    <td class="email"><?php echo e($user->email); ?></td>
                                    <td>
                                        <span class="badge bg-<?php echo e($user->role == 1 ? 'danger' : 'warning'); ?>-subtle text-<?php echo e($user->role == 1 ? 'danger' : 'warning'); ?>">
                                            <?php if($user->role == 1): ?>
                                                Admin
                                            <?php elseif($user->role == 2): ?>
                                                Staff
                                            <?php endif; ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-<?php echo e($user->status == 'active' ? 'success' : ($user->status == 'inactive' ? 'warning' : 'danger')); ?>-subtle text-<?php echo e($user->status == 'active' ? 'success' : ($user->status == 'inactive' ? 'warning' : 'danger')); ?>">
                                            <?php if($user->status == 'active'): ?>
                                                Hoạt động
                                            <?php elseif($user->status == 'inactive'): ?>
                                                Chưa kích hoạt
                                            <?php else: ?>
                                                Đã khóa
                                            <?php endif; ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="ri-more-fill align-middle"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li>
                                                    <a href="<?php echo e(route('admin.roles.edit', $user->id)); ?>" class="dropdown-item">
                                                        <i class="ri-edit-line align-bottom me-2 text-primary"></i> Sửa thông tin
                                                    </a>
                                                </li>
                                                <li>
                                                    <button class="dropdown-item change-role" data-user-id="<?php echo e($user->id); ?>" data-current-role="<?php echo e($user->role); ?>">
                                                        <i class="ri-settings-3-line align-bottom me-2 text-muted"></i> Thay đổi quyền
                                                    </button>
                                                </li>
                                                <li>
                                                    <button class="dropdown-item text-danger delete-user" data-user-id="<?php echo e($user->id); ?>" data-user-name="<?php echo e($user->name); ?>" data-user-role="<?php echo e($user->role); ?>">
                                                        <i class="ri-delete-bin-line align-bottom me-2 text-danger"></i> Xóa tài khoản
                                                    </button>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div class="text-muted">
                            Hiển thị <?php echo e($users->firstItem() ?? 0); ?> đến <?php echo e($users->lastItem() ?? 0); ?> trong <?php echo e($users->total()); ?> kết quả
                        </div>
                        <div>
                            <?php echo e($users->appends(request()->query())->links()); ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Change Role Modal -->
<div class="modal fade" id="changeRoleModal" tabindex="-1" aria-labelledby="changeRoleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="changeRoleModalLabel">Thay đổi quyền</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="changeRoleForm">
                    <input type="hidden" id="userId" name="user_id">
                    <div class="mb-3">
                        <label for="newRole" class="form-label">Chọn quyền mới</label>
                        <select class="form-select" id="newRole" name="role" required>
                            <option value="1">Admin</option>
                            <option value="2">Staff</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                <button type="button" class="btn btn-primary" id="confirmRoleChange">Xác nhận</button>
            </div>
        </div>
    </div>
</div>

<!-- Bulk Update Modal -->
<div class="modal fade" id="bulkUpdateModal" tabindex="-1" aria-labelledby="bulkUpdateModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="bulkUpdateModalLabel">Cập nhật quyền hàng loạt</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="bulkUpdateForm">
                    <div class="mb-3">
                        <label for="bulkRole" class="form-label">Chọn quyền mới cho tất cả người dùng đã chọn</label>
                        <select class="form-select" id="bulkRole" name="role" required>
                            <option value="1">Admin</option>
                            <option value="2">Staff</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                <button type="button" class="btn btn-primary" id="confirmBulkUpdate">Xác nhận</button>
            </div>
        </div>
    </div>
</div>

<!-- Delete User Modal -->
<div class="modal fade" id="deleteUserModal" tabindex="-1" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-danger" id="deleteUserModalLabel">
                    <i class="ri-delete-bin-line me-2"></i>Xác nhận xóa tài khoản
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-warning" role="alert">
                    <i class="ri-alert-line me-2"></i>
                    <strong>Cảnh báo:</strong> Hành động này không thể hoàn tác!
                </div>
                <p>Bạn có chắc chắn muốn xóa tài khoản <strong id="deleteUserName"></strong>?</p>
                <p class="text-muted mb-0">Tài khoản sẽ bị xóa hoàn toàn khỏi database và không thể khôi phục.</p>
                <div class="alert alert-info mt-2 mb-0" id="adminWarning" style="display: none;">
                    <i class="ri-information-line me-2"></i>
                    <strong>Lưu ý:</strong> Đây là admin cuối cùng, không thể xóa!
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteUser">
                    <i class="ri-delete-bin-line me-1"></i>Xóa tài khoản
                </button>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
$(document).ready(function() {
    // Check all functionality
    $('#checkAll').on('change', function() {
        $('input[name="user_ids[]"]').prop('checked', this.checked);
        updateBulkUpdateButton();
    });

    $('input[name="user_ids[]"]').on('change', function() {
        updateBulkUpdateButton();
    });

    function updateBulkUpdateButton() {
        const checkedCount = $('input[name="user_ids[]"]:checked').length;
        $('#bulkUpdateBtn').prop('disabled', checkedCount === 0);
    }

    // Change role functionality
    $('.change-role').on('click', function() {
        const userId = $(this).data('user-id');
        const currentRole = $(this).data('current-role');
        
        $('#userId').val(userId);
        $('#newRole').val(currentRole);
        $('#changeRoleModal').modal('show');
    });

    $('#confirmRoleChange').on('click', function() {
        const userId = $('#userId').val();
        const newRole = $('#newRole').val();
        
        $.ajax({
            url: `/admin/roles/${userId}/update-role`,
            method: 'POST',
            data: {
                role: newRole,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    location.reload();
                } else {
                    alert('Có lỗi xảy ra: ' + response.message);
                }
            },
            error: function() {
                alert('Có lỗi xảy ra, vui lòng thử lại sau');
            }
        });
    });

    // Bulk update functionality
    $('#bulkUpdateBtn').on('click', function() {
        $('#bulkUpdateModal').modal('show');
    });

    $('#confirmBulkUpdate').on('click', function() {
        const selectedUsers = $('input[name="user_ids[]"]:checked').map(function() {
            return this.value;
        }).get();
        const newRole = $('#bulkRole').val();
        
        $.ajax({
            url: '/admin/roles/bulk-update',
            method: 'POST',
            data: {
                user_ids: selectedUsers,
                role: newRole,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    location.reload();
                } else {
                    alert('Có lỗi xảy ra: ' + response.message);
                }
            },
            error: function() {
                alert('Có lỗi xảy ra, vui lòng thử lại sau');
            }
        });
    });

    // Delete user functionality
    let userIdToDelete = null;
    
    $(document).on('click', '.delete-user', function() {
        userIdToDelete = $(this).data('user-id');
        const userName = $(this).data('user-name');
        const userRole = $(this).data('user-role');
        
        $('#deleteUserName').text(userName);
        
        // Kiểm tra nếu là admin cuối cùng
        if (userRole == 1) { // Admin
            $.ajax({
                url: '/admin/roles/check-admin-count',
                type: 'GET',
                success: function(response) {
                    if (response.admin_count <= 1) {
                        $('#adminWarning').show();
                        $('#confirmDeleteUser').prop('disabled', true).text('Không thể xóa admin cuối cùng');
                    } else {
                        $('#adminWarning').hide();
                        $('#confirmDeleteUser').prop('disabled', false).html('<i class="ri-delete-bin-line me-1"></i>Xóa tài khoản');
                    }
                }
            });
        } else {
            $('#adminWarning').hide();
            $('#confirmDeleteUser').prop('disabled', false).html('<i class="ri-delete-bin-line me-1"></i>Xóa tài khoản');
        }
        
        $('#deleteUserModal').modal('show');
    });

    $('#confirmDeleteUser').on('click', function() {
        if (!userIdToDelete) {
            alert('Không tìm thấy ID user để xóa!');
            return;
        }
        
        console.log('Deleting user ID:', userIdToDelete);
        console.log('CSRF Token:', $('meta[name="csrf-token"]').attr('content'));
        
        $.ajax({
            url: `/admin/roles/${userIdToDelete}`,
            type: 'DELETE',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                console.log('Response:', response);
                if (response.success) {
                    $('#deleteUserModal').modal('hide');
                    location.reload();
                } else {
                    alert('Có lỗi xảy ra: ' + response.message);
                }
            },
            error: function(xhr, status, error) {
                console.log('Error:', xhr.responseText);
                console.log('Status:', status);
                console.log('Error:', error);
                alert('Có lỗi xảy ra: ' + xhr.responseText);
            }
        });
    });

    // Filter functionality
    $('#searchInput').on('keyup', function() {
        const search = $(this).val();
        const role = $('#roleFilter').val();
        const status = $('#statusFilter').val();
        
        // Reload page with filters
        const url = new URL(window.location);
        if (search) url.searchParams.set('search', search);
        else url.searchParams.delete('search');
        if (role) url.searchParams.set('role', role);
        else url.searchParams.delete('role');
        if (status) url.searchParams.set('status', status);
        else url.searchParams.delete('status');
        
        window.location.href = url.toString();
    });

    $('#roleFilter, #statusFilter').on('change', function() {
        const search = $('#searchInput').val();
        const role = $('#roleFilter').val();
        const status = $('#statusFilter').val();
        
        // Reload page with filters
        const url = new URL(window.location);
        if (search) url.searchParams.set('search', search);
        else url.searchParams.delete('search');
        if (role) url.searchParams.set('role', role);
        else url.searchParams.delete('role');
        if (status) url.searchParams.set('status', status);
        else url.searchParams.delete('status');
        
        window.location.href = url.toString();
    });
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\LARAGON\laragon\www\DATN\duAnTotNghiep_website_ban_quan_ao_STYLEX\resources\views\admin\roles\index.blade.php ENDPATH**/ ?>