@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Sửa Màu Sắc</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.colors.index') }}">Màu Sắc</a></li>
                        <li class="breadcrumb-item active">Sửa</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Sửa Màu: {{ $color->name }}</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.colors.update', $color) }}" method="POST" id="editColorForm">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Tên màu <span class="text-danger">*</span></label>
                                    <input type="text" name="name" id="name" class="form-control"
                                        value="{{ old('name', $color->name) }}" required>
                                    @error('name')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Trạng thái</label>
                                    <div class="d-flex gap-3 mt-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="status" id="active" value="1"
                                                {{ $color->status == 1 ? 'checked' : '' }}>
                                            <label class="form-check-label" for="active">Hoạt động</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="status" id="inactive" value="0"
                                                {{ $color->status == 0 ? 'checked' : '' }}>
                                            <label class="form-check-label" for="inactive">Không hoạt động</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="ri-save-line me-1"></i> Cập nhật
                                    </button>
                                    <a href="{{ route('admin.colors.index') }}" class="btn btn-secondary">
                                        <i class="ri-arrow-left-line me-1"></i> Quay lại
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Form submission with loading
        document.getElementById('editColorForm').addEventListener('submit', function() {
            const submitBtn = this.querySelector('button[type="submit"]');
            submitBtn.innerHTML = '<i class="ri-loader-4-line ri-spin me-1"></i> Đang cập nhật...';
            submitBtn.disabled = true;
        });
    });
</script>
@endsection