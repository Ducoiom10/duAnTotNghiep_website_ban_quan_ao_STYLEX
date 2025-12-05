@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-md-6">
            <h4 class="mb-0"><i class="bx bx-plus"></i> Báo Cáo Hàng Hỏng</h4>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('admin.inventory.defect.index') }}" class="btn btn-secondary btn-sm">
                <i class="bx bx-arrow-back"></i> Quay Lại
            </a>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-light">
            <h5 class="mb-0">Thông Tin Hàng Hỏng</h5>
        </div>
        <div class="card-body">
            <div class="alert alert-info">
                <strong>Hướng dẫn:</strong> Nhập thông tin hàng hỏng/lỗi để tạo báo cáo
            </div>

            <form action="{{ route('admin.inventory.defect.store') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Kho Hàng <span class="text-danger">*</span></label>
                        <select name="warehouse_id" class="form-select @error('warehouse_id') is-invalid @enderror" required>
                            <option value="">-- Chọn Kho --</option>
                            @foreach ($warehouses as $warehouse)
                                <option value="{{ $warehouse->id }}" {{ old('warehouse_id') == $warehouse->id ? 'selected' : '' }}>
                                    {{ $warehouse->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('warehouse_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Sản Phẩm <span class="text-danger">*</span></label>
                        <select name="variant_id" class="form-select @error('variant_id') is-invalid @enderror" required>
                            <option value="">-- Chọn Sản Phẩm --</option>
                            @foreach ($variants as $variant)
                                <option value="{{ $variant->id }}" {{ old('variant_id') == $variant->id ? 'selected' : '' }}>
                                    {{ $variant->sku }} - {{ $variant->product->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('variant_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Số Lượng Hỏng <span class="text-danger">*</span></label>
                        <input type="number" name="quantity" class="form-control @error('quantity') is-invalid @enderror" 
                               value="{{ old('quantity') }}" min="1" required>
                        @error('quantity') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Mức Độ Hỏng <span class="text-danger">*</span></label>
                        <select name="defect_level" class="form-select @error('defect_level') is-invalid @enderror" required>
                            <option value="">-- Chọn Mức Độ --</option>
                            <option value="LIGHT" {{ old('defect_level') == 'LIGHT' ? 'selected' : '' }}>Nhẹ (Có thể sửa chữa)</option>
                            <option value="MEDIUM" {{ old('defect_level') == 'MEDIUM' ? 'selected' : '' }}>Trung Bình (Khó sửa chữa)</option>
                            <option value="HEAVY" {{ old('defect_level') == 'HEAVY' ? 'selected' : '' }}>Nặng (Không thể sửa chữa)</option>
                        </select>
                        @error('defect_level') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Mô Tả Chi Tiết</label>
                    <textarea name="description" class="form-control @error('description') is-invalid @enderror" 
                              rows="3" placeholder="Mô tả chi tiết về lỗi/hỏng">{{ old('description') }}</textarea>
                    @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Ghi Chú</label>
                    <textarea name="notes" class="form-control @error('notes') is-invalid @enderror" 
                              rows="2" placeholder="Ghi chú thêm">{{ old('notes') }}</textarea>
                    @error('notes') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-success">
                        <i class="bx bx-save"></i> Lưu Báo Cáo
                    </button>
                    <a href="{{ route('admin.inventory.defect.index') }}" class="btn btn-secondary">
                        <i class="bx bx-x"></i> Hủy
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
