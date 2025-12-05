@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2>Thêm Kho Hàng Mới</h2>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.inventory.warehouses.store') }}" method="POST" class="card p-4">
        @csrf
        
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Tên Kho <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                           value="{{ old('name') }}" required>
                    @error('name') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Mã Kho <span class="text-danger">*</span></label>
                    <input type="text" name="code" class="form-control @error('code') is-invalid @enderror" 
                           value="{{ old('code') }}" required>
                    @error('code') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Loại Kho <span class="text-danger">*</span></label>
                    <select name="type" class="form-control @error('type') is-invalid @enderror" required>
                        <option value="">-- Chọn loại --</option>
                        <option value="PHYSICAL" {{ old('type') === 'PHYSICAL' ? 'selected' : '' }}>Kho Vật Lý</option>
                        <option value="VIRTUAL" {{ old('type') === 'VIRTUAL' ? 'selected' : '' }}>Kho Ảo</option>
                        <option value="CONSIGNMENT" {{ old('type') === 'CONSIGNMENT' ? 'selected' : '' }}>Ký Gửi</option>
                        <option value="SCRAP" {{ old('type') === 'SCRAP' ? 'selected' : '' }}>Phế Liệu</option>
                    </select>
                    @error('type') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Trạng Thái <span class="text-danger">*</span></label>
                    <select name="operational_status" class="form-control @error('operational_status') is-invalid @enderror" required>
                        <option value="">-- Chọn trạng thái --</option>
                        <option value="ACTIVE" {{ old('operational_status') === 'ACTIVE' ? 'selected' : '' }}>Hoạt Động</option>
                        <option value="INACTIVE" {{ old('operational_status') === 'INACTIVE' ? 'selected' : '' }}>Không Hoạt Động</option>
                        <option value="MAINTENANCE" {{ old('operational_status') === 'MAINTENANCE' ? 'selected' : '' }}>Bảo Trì</option>
                    </select>
                    @error('operational_status') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Địa Chỉ</label>
            <textarea name="address" class="form-control @error('address') is-invalid @enderror" rows="3">{{ old('address') }}</textarea>
            @error('address') <span class="invalid-feedback">{{ $message }}</span> @enderror
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-success">Thêm Kho</button>
            <a href="{{ route('admin.inventory.warehouses.index') }}" class="btn btn-secondary">Hủy</a>
        </div>
    </form>
</div>
@endsection
