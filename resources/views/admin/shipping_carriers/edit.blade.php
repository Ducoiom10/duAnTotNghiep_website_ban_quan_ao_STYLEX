@extends('admin.layouts.app')
@section('title','Sửa hãng vận chuyển')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Sửa hãng vận chuyển</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item active"><a href="{{ route('admin.shipping_carriers.index') }}">Vận chuyển</a></li>
                    <li class="breadcrumb-item">Sửa: {{ $shipping_carrier->name }}</li>
                </ol>
            </div>

        </div>
    </div>
</div>

@if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
@if(session('error'))   <div class="alert alert-danger">{{ session('error') }}</div>   @endif

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h4 class="card-title mb-0">Thông tin hãng</h4>
                <a href="{{ route('admin.shipping_carriers.index') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="ri-arrow-go-back-line"></i> Quay lại
                </a>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.shipping_carriers.update', $shipping_carrier) }}" method="post">
                    @csrf
                    @method('PUT')

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Tên hãng vận chuyển <span class="text-danger">*</span></label>
                            <input type="text"
                                   name="name"
                                   class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name', $shipping_carrier->name) }}"
                                   placeholder="VD: Giao Hàng Nhanh">
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Mã hãng (code) <span class="text-danger">*</span></label>
                            <input type="text"
                                   name="code"
                                   class="form-control @error('code') is-invalid @enderror"
                                   value="{{ old('code', $shipping_carrier->code) }}"
                                   placeholder="VD: GHN, GHTK, VNPOST">
                            @error('code') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Phí vận chuyển (VNĐ) <span class="text-danger">*</span></label>
                            <input type="number"
                                   name="fee"
                                   class="form-control @error('fee') is-invalid @enderror"
                                   value="{{ old('fee', $shipping_carrier->fee ?? 0) }}"
                                   min="0"
                                   step="1000"
                                   placeholder="VD: 25000">
                            @error('fee') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            <small class="text-muted">Phí ship cố định cho mỗi đơn hàng sử dụng hãng này.</small>
                        </div>

                        <div class="col-md-3 d-flex align-items-end">
                            <div class="form-check mt-2">
                                <input type="checkbox" class="form-check-input" id="active" name="active" value="1" {{ old('active', $shipping_carrier->active) ? 'checked' : '' }}>
                                <label class="form-check-label" for="active">Hoạt động</label>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="{{ route('admin.shipping_carriers.index') }}" class="btn btn-secondary">
                            <i class="ri-close-line"></i> Hủy
                        </a>
                        <button class="btn btn-primary">
                            <i class="ri-save-3-line"></i> Cập nhật
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
