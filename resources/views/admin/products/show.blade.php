@extends('admin.layouts.app')
@section('title')
    Chi tiết sản phẩm
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Quản lí sản phẩm</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item active"><a href="javascript: void(0);">Quản lí sản phẩm</a></li>
                        <li class="breadcrumb-item">Danh sách sản phẩm</li>
                        <li class="breadcrumb-item">Chi tiết sản phẩm</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Chi tiết sản phẩm : {{ $product->name }}</h4>
                </div><!-- end card header -->

                <div class="card-body">
                    <div class="container mt-4">

                        <!-- Thông tin sản phẩm -->
                        <div class="card mb-4">
                            <div class="card-header bg-primary text-white">
                                Thông tin sản phẩm
                            </div>
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-md-3 fw-bold">Tên sản phẩm:</div>
                                    <div class="col-md-9">{{ $product->name }}</div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-3 fw-bold">Slug:</div>
                                    <div class="col-md-9">{{ $product->slug }}</div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-3 fw-bold">Danh mục:</div>
                                    <div class="col-md-9">
                                        {{ $product->category->name ?? 'Không có' }}
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-3 fw-bold">Ảnh đại diện:</div>
                                    <div class="col-md-9">
                                        <img src="{{ asset('storage/' . $product->thumbnail) }}" alt="Thumbnail"
                                            class="img-thumbnail" style="max-width:150px;">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-3 fw-bold">Sản phẩm nổi bật:</div>
                                    <div class="col-md-9">
                                       
                                        <div class="form-check form-switch form-switch-warning">
                                            <input disabled class="form-check-input" type="checkbox" role="switch"
                                                @checked($product->is_featured)
                                                >
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-3 fw-bold">Trạng thái:</div>
                                    <div class="col-md-9">
                                        @if ($product->status == 'active')
                                            <span class="badge bg-secondary px-2 py-2">Hoạt động</span>
                                        @else
                                            <span class="badge bg-light px-2 py-2">Ngừng hoạt động</span>
                                        @endif

                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-3 fw-bold">Ngày tạo:</div>
                                    <div class="col-md-9">{{ $product->created_at }}</div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-3 fw-bold">Cập nhật:</div>
                                    <div class="col-md-9">{{ $product->updated_at }}</div>
                                </div>
                            </div>
                        </div>

                        <!-- Mô tả chi tiết -->
                        <div class="card shadow-sm border-0">
                            <div class="card-header bg-primary text-white fw-bold">
                                Mô tả sản phẩm
                            </div>
                            <div class="card-body">
                                <div>
                                    <h6 class="fw-semibold text-muted">Mô tả chi tiết</h6>
                                    <div class="p-3 border rounded bg-light">
                                        {!! $product->description !!}
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary mt-3">Quay lại</a>
                </div><!-- end card-body -->
            </div><!-- end card -->
        </div><!-- end col -->
    </div><!-- end row -->
@endsection
