@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-md-6">
            <h4 class="mb-0"><i class="bx bx-check"></i> Xác Nhận QC - {{ $request->batch_number }}</h4>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('admin.inventory.stock-out.index') }}" class="btn btn-secondary btn-sm">
                <i class="bx bx-arrow-back"></i> Quay Lại
            </a>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-6">
                    <p><strong>Sản Phẩm:</strong> {{ $request->variant->product->name }}</p>
                    <p><strong>SKU:</strong> {{ $request->variant->sku }}</p>
                    <p><strong>Số Lượng Xuất:</strong> {{ number_format($request->quantity) }}</p>
                    <p><strong>Giá Xuất:</strong> {{ number_format($request->cost_price, 0, ',', '.') }}đ</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Kho:</strong> {{ $request->warehouse->name }}</p>
                    <p><strong>Mã Lô:</strong> {{ $request->batch_number }}</p>
                    <p><strong>Ngày Xuất:</strong> {{ $request->created_at->format('d/m/Y H:i') }}</p>
                    <p><strong>Người Tạo:</strong> {{ $request->createdBy->name ?? 'N/A' }}</p>
                </div>
            </div>

            <form action="{{ route('admin.inventory.stock-out.confirm-qc', $request->id) }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Số Lượng Pass QC <span class="text-danger">*</span></label>
                        <input type="number" name="passed_qty" class="form-control @error('passed_qty') is-invalid @enderror" 
                               value="{{ old('passed_qty', 0) }}" min="0" max="{{ $request->quantity }}" required>
                        @error('passed_qty') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Số Lượng Fail QC <span class="text-danger">*</span></label>
                        <input type="number" name="failed_qty" class="form-control @error('failed_qty') is-invalid @enderror" 
                               value="{{ old('failed_qty', 0) }}" min="0" max="{{ $request->quantity }}" required>
                        @error('failed_qty') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="alert alert-info">
                    <strong>Lưu ý:</strong> Tổng số lượng Pass + Fail phải bằng {{ $request->quantity }}
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Người QC</label>
                        <input type="text" class="form-control" value="{{ auth()->user()->name }}" disabled>
                        <input type="hidden" name="qc_by" value="{{ auth()->id() }}">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Ghi Chú QC</label>
                    <textarea name="notes" class="form-control @error('notes') is-invalid @enderror" rows="3">{{ old('notes') }}</textarea>
                    @error('notes') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-success">
                        <i class="bx bx-check"></i> Xác Nhận QC
                    </button>
                    <a href="{{ route('admin.inventory.stock-out.index') }}" class="btn btn-secondary">
                        <i class="bx bx-x"></i> Hủy
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
