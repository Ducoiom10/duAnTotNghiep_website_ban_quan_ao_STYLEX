@extends('admin.layouts.app')
@section('title', 'Danh sách bài viết đã xóa')
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
                <h4 class="mb-sm-0">Quản lí bài viết đã xóa</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item active"><a href="javascript: void(0);">Quản lí bài viết đã xóa</a></li>
                        <li class="breadcrumb-item">Danh sách bài viết đã xóa</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Danh sách bài viết đã xóa</h4>

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
                                            <th>Ảnh bìa</th>
                                            <th>Tác giả</th>
                                            <th>Danh mục</th>
                                            <th>Trạng thái</th>
                                            <th>Ngày đăng tải</th>
                                            <th>Hành Động</th>
                                    </tr>
                                </thead>
                                <tbody class="list form-check-all">
                                   @foreach ($postsDeleted as $post)
                                            <tr>
                                                <th scope="row">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="itemID"
                                                            value="{{ $post->id }}">
                                                    </div>
                                                </th>

                                                <td class="customer_name">{{ $loop->iteration }}</td>
                                                <td>
                                                    <h6 class="mb-0 text-truncate" style="max-width: 250px;">
                                                        {{ $post->title }}</h6>
                                                </td>
                                                <td>
                                                    <img class="rounded shadow-sm"
                                                        src="{{ Storage::url($post->thumbnail) }}" alt="Hình đại diện"
                                                        width="80" height="50" style="object-fit: cover;">
                                                </td>
                                                <td class="text-danger fw-bold">{{ $post->user->name ?? '' }}</td>
                                                <td>{{ $post->category->name ?? '' }}</td>
                                                <td class="status col-1">
                                                    @if ($post->status === 'published')
                                                        <span class="badge bg-success w-75">
                                                            Xuất bản
                                                        </span>
                                                    @elseif($post->status === 'pending')
                                                        <span class="badge bg-warning w-75">
                                                            Chờ xử lí
                                                        </span>
                                                    @elseif($post->status === 'draft')
                                                        <span class="badge bg-secondary w-75">
                                                            Bản nháp
                                                        </span>
                                                    @elseif($post->status === 'scheduled')
                                                        <span class="badge bg-info w-75">
                                                           Chờ xuất bản
                                                        </span>
                                                    @else
                                                        <span class="badge bg-danger w-75">
                                                            Riêng tư
                                                        </span>
                                                    @endif
                                                </td>

                                                <td>
                                                    {!! $post->published_at
                                                        ? \Carbon\Carbon::parse($post->published_at)->format('d/m/Y')
                                                        : '<span class="btn btn-sm btn-soft-warning">Chưa đăng</span>' !!}
                                                </td>


                                                <td>
                                                           <div class="d-flex gap-1">
                                                    <div class="edit">
                                                        <form action="{{ route('admin.posts.restore', $post->id) }}"
                                                            method="post">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button class="btn btn-sm btn-success edit-item-btn btn-remove"
                                                                data-bs-toggle="modal" data-bs-target="#showModal" data-name="{{ $post->title }}">
                                                                <i class="las la-redo-alt"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                    <div class="remove">
                                                        <form method="POST"
                                                            action="{{ route('admin.posts.force-delete', $post->id) }}"
                                                            class="d-inline delete-form">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="button"
                                                                class="btn btn-sm btn-danger remove-item-btn btn-forcedelete"
                                                                data-name="{{ $post->title }}">
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
                                @if ($postsDeleted->onFirstPage())
                                    <a class="page-item pagination-prev disabled" href="javascript:void(0);">Previous</a>
                                @else
                                    <a class="page-item pagination-prev"
                                        href="{{ $postsDeleted->previousPageUrl() }}">Previous</a>
                                @endif

                                {{-- Các số trang --}}
                                <ul class="pagination listjs-pagination mb-0">
                                    @foreach ($postsDeleted->getUrlRange(1, $postsDeleted->lastPage()) as $page => $url)
                                        <li class="page-item {{ $page == $postsDeleted->currentPage() ? 'active' : '' }}">
                                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                        </li>
                                    @endforeach
                                </ul>

                                {{-- Nút Next --}}
                                @if ($postsDeleted->hasMorePages())
                                    <a class="page-item pagination-next"
                                        href="{{ $postsDeleted->nextPageUrl() }}">Next</a>
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
