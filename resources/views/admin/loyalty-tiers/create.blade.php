@extends('admin.layouts.app')

@section('title', 'Tạo Hạng thành viên mới')

@push('page-css')
    <link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet" type="text/css" />
@endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Tạo hạng thành viên mới</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item active"><a href="{{ route('admin.loyalty-tiers.index') }}">Hạng thành viên</a></li>
                        <li class="breadcrumb-item">Tạo mới</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h4 class="card-title mb-0">Thông tin hạng</h4>
                    <a href="{{ route('admin.loyalty-tiers.index') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="ri-arrow-go-back-line"></i> Quay lại
                    </a>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.loyalty-tiers.store') }}" method="POST">
                        @csrf

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label fw-semibold">Tên Hạng</label>
                                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <label for="min_spend_required" class="form-label fw-semibold">Ngưỡng Chi tiêu Tối thiểu (VNĐ)</label>
                                <input type="number" step="0.01" inputmode="decimal" name="min_spend_required" id="min_spend_required" class="form-control @error('min_spend_required') is-invalid @enderror" value="{{ old('min_spend_required') }}" required>
                                @error('min_spend_required')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <label for="discount_rate" class="form-label fw-semibold">Tỷ lệ Giảm giá (%)</label>
                                <input type="number" step="0.01" name="discount_rate" id="discount_rate" class="form-control @error('discount_rate') is-invalid @enderror" value="{{ old('discount_rate') }}" required>
                                @error('discount_rate')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <a href="{{ route('admin.loyalty-tiers.index') }}" class="btn btn-secondary">
                                <i class="ri-close-line"></i> Hủy
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="ri-save-3-line"></i> Tạo hạng
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
