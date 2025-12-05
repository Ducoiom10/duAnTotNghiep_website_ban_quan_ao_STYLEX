@extends('admin.layouts.app')
@section('title', 'Danh sách người dùng')
@push('page-css')
    <link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet" type="text/css" />

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
@endpush
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Quản lí người dùng</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item active"><a href="javascript: void(0);">Quản lí người dùng</a></li>
                        <li class="breadcrumb-item">Danh sách người dùng</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <div class="row cursor-pointer">
        <!-- Tổng số người dùng (không bao gồm admin) -->
        <div class="col-6 col-md-2 mb-3">
            <div class="card stats-card approved-card">
                <div class="card-body text-center">
                    <div class="stat-icon text-primary">
                        <i class="ri-group-line"></i>
                    </div>
                    <h5 class="card-title text-muted mb-2">Tổng cộng</h5>
                    <h3 class="card-text fw-bold text-primary">
                        {{ ($userCounts->user_count ?? 0) + ($userCounts->staff_count ?? 0) }}</h3>
                </div>
            </div>
        </div>

        <!-- Số Staff -->
        @if (auth()->user()->role == 1)
            <div class="col-6 col-md-2 mb-3">
                <div class="card stats-card approved-card">
                    <div class="card-body text-center">
                        <div class="stat-icon text-warning">
                            <i class="ri-team-line"></i>
                        </div>
                        <h5 class="card-title text-muted mb-2">Staff</h5>
                        <h3 class="card-text fw-bold text-warning">{{ $userCounts->staff_count ?? 0 }}</h3>
                    </div>
                </div>
            </div>
        @endif

        <!-- Số User thường -->
        <div class="col-6 col-md-2 mb-3">
            <div class="card stats-card approved-card">
                <div class="card-body text-center">
                    <div class="stat-icon text-success">
                        <i class="ri-user-line"></i>
                    </div>
                    <h5 class="card-title text-muted mb-2">User</h5>
                    <h3 class="card-text fw-bold text-success">{{ $userCounts->user_count ?? 0 }}</h3>
                </div>
            </div>
        </div>

        <!-- Trạng thái hoạt động -->
        <div class="col-6 col-md-2 mb-3">
            <div class="card stats-card approved-card">
                <div class="card-body text-center">
                    <div class="stat-icon text-success">
                        <i class="ri-checkbox-circle-line"></i>
                    </div>
                    <h5 class="card-title text-muted mb-2">Hoạt động</h5>
                    <h3 class="card-text fw-bold text-success">{{ $userCounts->active_users ?? 0 }}</h3>
                </div>
            </div>
        </div>

        <!-- Trạng thái không hoạt động -->
        <div class="col-6 col-md-2 mb-3">
            <div class="card stats-card approved-card">
                <div class="card-body text-center">
                    <div class="stat-icon text-secondary">
                        <i class="ri-pause-circle-line"></i>
                    </div>
                    <h5 class="card-title text-muted mb-2">Tạm dừng</h5>
                    <h3 class="card-text fw-bold text-secondary">{{ $userCounts->inactive_users ?? 0 }}</h3>
                </div>
            </div>
        </div>

        <!-- Trạng thái bị khóa -->
        <div class="col-6 col-md-2 mb-3">
            <div class="card stats-card approved-card">
                <div class="card-body text-center">
                    <div class="stat-icon text-danger">
                        <i class="ri-lock-line"></i>
                    </div>
                    <h5 class="card-title text-muted mb-2">Bị khóa</h5>
                    <h3 class="card-text fw-bold text-danger">{{ $userCounts->blocked_users ?? 0 }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Instructions -->
    <div class="row">
        <div class="col-12">
            <div class="alert alert-warning border-0" role="alert">
                <h6 class="alert-heading">
                    <i class="ri-information-line me-2"></i>Lưu ý quan trọng
                </h6>
                <p class="mb-0">
                    <strong>Trang này chỉ tạo tài khoản User.</strong>
                    Để tạo Admin hoặc Staff, vui lòng sử dụng trang
                    <a href="{{ route('admin.roles.index') }}" class="alert-link fw-bold">Phân quyền người dùng</a>.
                </p>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h4 class="card-title mb-0">Danh sách người dùng</h4>
                    <button class="btn btn-outline-primary btn-sm" id="toggleFilterBtn">
                        <i class="ri-filter-3-line"></i> Bộ lọc
                    </button>
                </div><!-- end card header -->

                {{-- Form lọc --}}
                <div class="card-body" id="filterForm" style="display: none;">
                    <form action="{{ route('admin.users.index') }}" method="GET">
                        <div class="row g-3">
                            {{-- Họ tên --}}
                            <div class="col-md-3">
                                <label class="form-label fw-semibold">Tên</label>
                                <input type="text" name="name" value="{{ request('name') }}" class="form-control"
                                    placeholder="Nhập tên người dùng">
                            </div>

                            {{-- Email --}}
                            <div class="col-md-3">
                                <label class="form-label fw-semibold">Email</label>
                                <input type="text" name="email" value="{{ request('email') }}" class="form-control"
                                    placeholder="Nhập email">
                            </div>

                            {{-- Số điện thoại --}}
                            <div class="col-md-3">
                                <label class="form-label fw-semibold">Số điện thoại</label>
                                <input type="text" name="phone_number" value="{{ request('phone_number') }}"
                                    class="form-control" placeholder="Nhập số điện thoại">
                            </div>

                            {{-- Trạng thái --}}
                            <div class="col-md-2">
                                <label class="form-label fw-semibold">Trạng thái</label>
                                <select name="status" class="form-select">
                                    <option value="">-- Tất cả --</option>
                                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Hoạt động
                                    </option>
                                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Ngừng
                                        hoạt động</option>
                                    <option value="blocked" {{ request('status') == 'blocked' ? 'selected' : '' }}>Bị Khóa
                                    </option>
                                </select>
                            </div>

                            {{-- Vai trò --}}
                            <div class="col-md-2">
                                <label class="form-label fw-semibold">Vai trò</label>
                                <select name="role" class="form-select">
                                    <option value="">-- Tất cả --</option>
                                    <option value="1" {{ request('role') == '1' ? 'selected' : '' }}>Admin</option>
                                    <option value="2" {{ request('role') == '2' ? 'selected' : '' }}>Staff</option>
                                    <option value="0" {{ request('role') == '0' ? 'selected' : '' }}>User</option>
                                </select>
                            </div>

                            {{-- Nút lọc và reset --}}
                            <div class="col-md-12 d-flex justify-content-end gap-2 mt-2">
                                <button type="submit" class="btn btn-primary btn-sm">
                                    <i class="ri-search-line"></i> Lọc
                                </button>
                                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary btn-sm">
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
                                    <a href="{{ route('admin.users.create') }}" class="btn btn-success add-btn"><i
                                            class="ri-add-line align-bottom me-1"></i> Thêm mới</a>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end mb-3">
                                <form method="GET" action="{{ route('admin.users.index') }}"
                                    class="d-flex align-items-center" style="max-width: 320px;">
                                    <div class="input-group">
                                        <input type="text" name="name" value="{{ request('name') }}"
                                            class="form-control" placeholder="Tìm kiếm User...">
                                        <button class="btn btn-primary" type="submit">
                                            <i class="ri-search-line"></i>
                                        </button>
                                    </div>
                                </form>
                            </div>

                        </div>

                        <div class="table-responsive table-card mt-3 mb-1">
                            <table class="table align-middle table-nowrap" id="customerTable">
                                <thead class="table-light">
                                    <tr>
                                        <th>STT</th>
                                        <th data-sort="customer_name">Tên người dùng</th>
                                        <th data-sort="email">Ảnh</th>
                                        <th data-sort="cate">Email</th>
                                        <th data-sort="phone">Số điện thoại</th>
                                        <th data-sort="phone">Xác minh Email</th>
                                        <th data-sort="phone">Vai trò</th>
                                        <th data-sort="date">Trạng thái</th>
                                        <th data-sort="phone">Ngày tham gia</th>
                                        <th data-sort="action">Hành động</th>
                                    </tr>
                                </thead>
                                <tbody class="list">
                                    @php $stt = ($items->currentPage() - 1) * $items->perPage(); @endphp
                                    @foreach ($items as $item)
                                        <tr>
                                            <td>{{ ++$stt }}</td>
                                            <td class="customer_name">{{ $item->name }}</td>
                                            <td class="email">
                                                <img src="{{ $item->avatar ? asset('storage/' . $item->avatar) : \App\Http\Controllers\Admin\UserController::URLIMAGEDEFAULT }}"
                                                    width="50" height="50" class="user-avatar" alt="Avatar">
                                            </td>
                                            <td class="customer_name">{{ $item->email }}</td>
                                            <td class="phone">{{ $item->phone_number ?? 'Chưa có thông tin' }}</td>
                                            <td>
                                                @if ($item->email_verified_at != null)
                                                    <span class="badge bg-success">
                                                        <i class="ri-check-line me-1"></i>Đã xác minh
                                                    </span>
                                                @else
                                                    <span class="badge bg-danger">
                                                        <i class="ri-close-line me-1"></i>Chưa xác minh
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="phone">
                                                @if ($item->role == 1)
                                                    <span class="badge bg-danger">Admin</span>
                                                @elseif($item->role == 2)
                                                    <span class="badge bg-warning">Staff</span>
                                                @else
                                                    <span class="badge bg-info">User</span>
                                                @endif
                                            </td>
                                            <td class="status">
                                                @if ($item->status == 'active')
                                                    <span
                                                        class="badge bg-success-subtle text-success text-uppercase">Active</span>
                                                @elseif($item->status == 'inactive')
                                                    <span
                                                        class="badge bg-warning-subtle text-warning text-uppercase">Inactive</span>
                                                @else
                                                    <span
                                                        class="badge bg-warning-subtle text-warning text-uppercase">Block</span>
                                                @endif
                                            </td>
                                            <td>
                                                {{ optional($item->created_at)->format('d/m/Y') ?? 'NULL' }}
                                            </td>
                                            <td>
                                                <div class="d-flex gap-1">
                                                    <div class="edit">
                                                        <form action="{{ route('admin.users.edit', $item->id) }}"
                                                            method="get">
                                                            @csrf
                                                            <button class="btn btn-sm btn-warning edit-item-btn">
                                                                <span class="ri-edit-box-line"></span>
                                                            </button>
                                                        </form>
                                                    </div>
                                                    <div class="show">
                                                        <form action="{{ route('admin.users.show', $item->id) }}"
                                                            method="get">
                                                            @csrf
                                                            <button class="btn btn-sm btn-info show-item-btn"
                                                                data-bs-toggle="modal" data-bs-target="#showModal">
                                                                <i class="las la-eye"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                    <div class="remove">
                                                        <form method="POST"
                                                            action="{{ route('admin.users.destroy', $item->id) }}"
                                                            class="d-inline delete-form">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="button"
                                                                class="btn btn-sm btn-danger remove-item-btn btn-delete"
                                                                data-name="{{ $item->name }}">
                                                                <span class="ri-delete-bin-7-line"></span>
                                                            </button>
                                                        </form>

                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
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

                                {{-- Nút Previous --}}
                                @if ($items->onFirstPage())
                                    <a class="page-item pagination-prev disabled" href="javascript:void(0);">Previous</a>
                                @else
                                    <a class="page-item pagination-prev"
                                        href="{{ $items->previousPageUrl() }}">Previous</a>
                                @endif

                                {{-- Các số trang --}}
                                <ul class="pagination listjs-pagination mb-0">
                                    @foreach ($items->getUrlRange(1, $items->lastPage()) as $page => $url)
                                        <li class="page-item {{ $page == $items->currentPage() ? 'active' : '' }}">
                                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                        </li>
                                    @endforeach
                                </ul>

                                {{-- Nút Next --}}
                                @if ($items->hasMorePages())
                                    <a class="page-item pagination-next" href="{{ $items->nextPageUrl() }}">Next</a>
                                @else
                                    <a class="page-item pagination-next disabled" href="javascript:void(0);">Next</a>
                                @endif

                            </div>
                        </div>

                    </div>
                </div><!-- end card -->
            </div>
            <!-- end col -->
        </div>
        <!-- end col -->
    </div>
@endsection
@push('scripts')
    <script>
        $(document).on('change', 'input[name="email_verified"]', function() {
            var userID = $(this).val();
            var isChecked = $(this).is(':checked');

            var updateUrl = "{{ route('admin.users.updateEmailVerified', ':userID') }}".replace(
                ':userID', userID);

            $.ajax({
                type: "PUT",
                url: updateUrl,
                data: {
                    email_verified: isChecked ? userID : ''
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.status === 'success') {
                        toastr.success(response.message);
                    } else if (response.status === 'warning') {
                        toastr.warning(response.message);
                        $('input[value="' + userID + '"]').prop('checked', true);
                    } else {
                        toastr.error(response.message);
                    }
                },
                error: function() {
                    console.error('AJAX Error:', error);
                    console.log('Status:', status);
                    console.log('Response:', xhr.responseText);
                    toastr.error('Có lỗi xảy ra khi cập nhật.');
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#toggleFilterBtn').on('click', function() {
                $('#filterForm').slideToggle(200);
            });
        });
    </script>
@endpush
