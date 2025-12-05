@extends('admin.layouts.app')
@section('title','Thêm hãng vận chuyển')

@section('content')
<div class="container-fluid">
    <h4 class="mb-3">Thêm hãng vận chuyển</h4>

    @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
    @if(session('error'))   <div class="alert alert-danger">{{ session('error') }}</div>   @endif

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.shipping_carriers.store') }}" method="post">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Tên hãng vận chuyển <span class="text-danger">*</span></label>
                    <input type="text"
                           name="name"
                           class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('name') }}"
                           placeholder="VD: Giao Hàng Nhanh">
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Mã hãng (code) <span class="text-danger">*</span></label>
                    <input type="text"
                           name="code"
                           class="form-control @error('code') is-invalid @enderror"
                           value="{{ old('code') }}"
                           placeholder="VD: GHN, GHTK, VNPOST">
                    @error('code') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Phí vận chuyển (VNĐ) <span class="text-danger">*</span></label>
                    <input type="number"
                           name="fee"
                           class="form-control @error('fee') is-invalid @enderror"
                           value="{{ old('fee', 0) }}"
                           min="0"
                           step="1000"
                           placeholder="VD: 25000">
                    @error('fee') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    <small class="text-muted">Phí ship cố định cho mỗi đơn hàng sử dụng hãng này.</small>
                </div>

                <div class="d-flex gap-2">
                    <a href="{{ route('admin.shipping_carriers.index') }}" class="btn btn-secondary">Quay lại</a>
                    <button class="btn btn-primary">Lưu</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
