@extends('admin.layouts.app')
@section('title', 'Danh sách sản phẩm đã xóa')
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
                <h4 class="mb-sm-0">Quản lí sản phẩm</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item active"><a href="javascript: void(0);">Quản lí sản phẩm</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.products.trash') }}">Danh sách sản phẩm đã
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

                {{-- Form lọc --}}
                <div class="card-body" id="filterForm" style="display: none;">
                    <form action="{{ route('admin.products.index') }}" method="GET">
                        <div class="row g-3">
                            {{-- Họ tên --}}
                            <div class="col-md-3">
                                <label class="form-label fw-semibold">Tên</label>
                                <input type="text" name="name" value="{{ request('name') }}" class="form-control"
                                    placeholder="Nhập tên sản phẩm">
                            </div>

                            {{-- Danh mục --}}
                            <div class="col-md-2">
                                <label class="form-label fw-semibold">Danh mục</label>
                                <select name="category_id" class="form-select">
                                    <option value="">-- Tất cả --</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
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
                                </select>
                            </div>

                            {{-- Sản phẩm nổi bật --}}
                            <div class="col-md-2">
                                <label class="form-label fw-semibold">Sản phẩm nổi bật</label>
                                <select name="is_featured" class="form-select">
                                    <option value="">-- Tất cả --</option>
                                    <option value="1" {{ request('is_featured') == '1' ? 'selected' : '' }}>Có
                                    </option>
                                    <option value="0" {{ request('is_featured') == '0' ? 'selected' : '' }}>Không
                                    </option>
                                </select>
                            </div>


                            {{-- Nút lọc và reset --}}
                            <div class="col-md-12 d-flex justify-content-end gap-2 mt-2">
                                <button type="submit" class="btn btn-primary btn-sm">
                                    <i class="ri-search-line"></i> Lọc
                                </button>
                                <a href="{{ route('admin.products.index') }}" class="btn btn-secondary btn-sm">
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
                                    @foreach ($productsDeleted as $item)
                                        <tr>
                                            <th scope="row">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="chk_child"
                                                        value="{{ $item->id }}">
                                                </div>
                                            </th>
                                            <td class="customer_id">{{ $item->id }}</td>
                                            <td class="customer_name">{{ $item->name }}</td>
                                            <td class="email">
                                                <img src="{{ Storage::url($item->thumbnail) ?? 'Không có ảnh' }}"
                                                    width="50">
                                            </td>
                                            <td class="customer_name">{{ $item->category->name }}</td>
                                            <td>
                                                <div class="form-check form-switch form-switch-warning">
                                                    <input disabled class="form-check-input" type="checkbox" role="switch"
                                                        name="is_featured" @checked($item->is_featured)
                                                        onchange="toggleFeature({{ $item->id }}, this.checked)">
                                                </div>
                                            </td>
                                            <td class="status">
                                                @if ($item->status == 'active')
                                                    <span
                                                        class="badge bg-success-subtle text-success text-uppercase">Active</span>
                                                @else
                                                    <span
                                                        class="badge bg-warning-subtle text-warning text-uppercase">Inactive</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-flex gap-1">
                                                    <div class="edit">
                                                        <form action="{{ route('admin.products.restore', $item->id) }}"
                                                            method="post">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button class="btn btn-sm btn-success edit-item-btn btn-remove"
                                                                data-bs-toggle="modal" data-bs-target="#showModal" data-name="{{ $item->name }}">
                                                                <i class="las la-redo-alt"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                    <div class="remove">
                                                        <form method="POST"
                                                            action="{{ route('admin.products.force-delete', $item->id) }}"
                                                            class="d-inline delete-form">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="button"
                                                                class="btn btn-sm btn-danger remove-item-btn btn-forcedelete"
                                                                data-name="{{ $item->name }}">
                                                                <i class="ri-delete-bin-2-line"></i>
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
                                @if ($productsDeleted->onFirstPage())
                                    <a class="page-item pagination-prev disabled" href="javascript:void(0);">Previous</a>
                                @else
                                    <a class="page-item pagination-prev"
                                        href="{{ $productsDeleted->previousPageUrl() }}">Previous</a>
                                @endif

                                {{-- Các số trang --}}
                                <ul class="pagination listjs-pagination mb-0">
                                    @foreach ($productsDeleted->getUrlRange(1, $productsDeleted->lastPage()) as $page => $url)
                                        <li class="page-item {{ $page == $productsDeleted->currentPage() ? 'active' : '' }}">
                                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                        </li>
                                    @endforeach
                                </ul>

                                {{-- Nút Next --}}
                                @if ($productsDeleted->hasMorePages())
                                    <a class="page-item pagination-next" href="{{ $productsDeleted->nextPageUrl() }}">Next</a>
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
        function toggleFeature(productId, isChecked) {
            const url = "{{ route('admin.products.toggleFeature', ':id') }}".replace(':id', productId);

            fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
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
@endpush
