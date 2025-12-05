@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-md-6">
            <h4 class="mb-0"><i class="bx bx-list-check"></i> Tạo Yêu Cầu Kiểm Kê</h4>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('admin.inventory.count.index') }}" class="btn btn-secondary btn-sm">
                <i class="bx bx-arrow-back"></i> Quay Lại
            </a>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('admin.inventory.count.store') }}" method="POST">
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
                                    {{ $variant->product->name }} - {{ $variant->sku }}
                                </option>
                            @endforeach
                        </select>
                        @error('variant_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Người Tạo</label>
                        <input type="text" class="form-control" value="{{ auth()->user()->name }}" disabled>
                        <input type="hidden" name="created_by" value="{{ auth()->id() }}">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Ghi Chú</label>
                    <textarea name="notes" class="form-control @error('notes') is-invalid @enderror" rows="3">{{ old('notes') }}</textarea>
                    @error('notes') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-success">
                        <i class="bx bx-check"></i> Tạo Yêu Cầu
                    </button>
                    <a href="{{ route('admin.inventory.count.index') }}" class="btn btn-secondary">
                        <i class="bx bx-x"></i> Hủy
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
