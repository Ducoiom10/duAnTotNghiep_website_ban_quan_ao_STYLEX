@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-md-6">
            <h4 class="mb-0"><i class="bx bx-download"></i> Tạo Yêu Cầu Nhập Kho</h4>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('admin.inventory.stock-in.index') }}" class="btn btn-secondary btn-sm">
                <i class="bx bx-arrow-back"></i> Quay Lại
            </a>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('admin.inventory.stock-in.store') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Kho Hàng <span class="text-danger">*</span></label>
                        <select name="warehouse_id" id="warehouse_id" class="form-select @error('warehouse_id') is-invalid @enderror">
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
                        <select name="variant_id" id="variant_id" class="form-select @error('variant_id') is-invalid @enderror">
                            <option value="">-- Chọn Sản Phẩm --</option>
                            @foreach ($variants as $variant)
                                <option value="{{ $variant->id }}" {{ old('variant_id') == $variant->id ? 'selected' : '' }}>
                                    {{ $variant->product->name }} - {{ $variant->sku }}
                                </option>
                            @endforeach
                        </select>
                        @error('variant_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        <small id="stock-info" class="text-muted d-block mt-2"></small>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Mã Lô Hàng <span class="text-danger">*</span></label>
                        <input type="text" name="batch_number" class="form-control @error('batch_number') is-invalid @enderror" 
                               value="{{ old('batch_number') }}">
                        @error('batch_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Số Lượng <span class="text-danger">*</span></label>
                        <input type="number" name="quantity" class="form-control @error('quantity') is-invalid @enderror" 
                               value="{{ old('quantity') }}" min="1">
                        @error('quantity') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Giá Nhập <span class="text-danger">*</span></label>
                        <input type="number" name="cost_price" class="form-control @error('cost_price') is-invalid @enderror" 
                               value="{{ old('cost_price') }}" step="0.01" min="0">
                        @error('cost_price') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Ngày Nhận Hàng</label>
                        <input type="date" name="received_date" class="form-control @error('received_date') is-invalid @enderror" 
                               value="{{ old('received_date', now()->format('Y-m-d')) }}">
                        @error('received_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
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
                    <a href="{{ route('admin.inventory.stock-in.index') }}" class="btn btn-secondary">
                        <i class="bx bx-x"></i> Hủy
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function updateStockInfo() {
    const warehouseId = document.getElementById('warehouse_id').value;
    const variantId = document.getElementById('variant_id').value;
    const stockInfo = document.getElementById('stock-info');

    if (!warehouseId || !variantId) {
        stockInfo.textContent = '';
        return;
    }

    fetch(`/api/v1/warehouses/${warehouseId}/variants/${variantId}/stock`)
        .then(response => response.json())
        .then(data => {
            stockInfo.textContent = `📦 Tồn kho: ${data.on_hand} | Sẵn sàng: ${data.available} | Hỏng: ${data.damaged}`;
        })
        .catch(error => {
            console.error('Error:', error);
            stockInfo.textContent = '';
        });
}

document.getElementById('warehouse_id').addEventListener('change', updateStockInfo);
document.getElementById('variant_id').addEventListener('change', updateStockInfo);
</script>
@endsection
