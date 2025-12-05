@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Thêm Chất Liệu Mới</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.textures.index') }}">Chất Liệu</a></li>
                        <li class="breadcrumb-item active">Thêm mới</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Thông tin Chất Liệu</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.textures.store') }}" method="POST" id="createTextureForm">
                        @csrf
                        
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Tên chất liệu <span class="text-danger">*</span></label>
                                    <input type="text" name="name" id="name" class="form-control" 
                                           value="{{ old('name') }}" required>
                                    @error('name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <!-- Hidden input để mặc định status = 1 (hoạt động) -->
                        <input type="hidden" name="status" value="1">

                        <div class="row">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="description" class="form-label">Mô tả</label>
                                    <textarea name="description" id="description" class="form-control" rows="3" 
                                              placeholder="Nhập mô tả cho chất liệu...">{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="ri-save-line me-1"></i> Lưu
                                    </button>
                                    <a href="{{ route('admin.textures.index') }}" class="btn btn-secondary">
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
    document.getElementById('createTextureForm').addEventListener('submit', function() {
        const submitBtn = this.querySelector('button[type="submit"]');
        submitBtn.innerHTML = '<i class="ri-loader-4-line ri-spin me-1"></i> Đang lưu...';
        submitBtn.disabled = true;
    });
});
</script>
@endsection
