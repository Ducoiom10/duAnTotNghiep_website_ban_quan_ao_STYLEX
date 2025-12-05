@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-md-6">
            <h4 class="mb-0"><i class="bx bx-check"></i> Đếm Kho - {{ $request->variant->product->name }}</h4>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('admin.inventory.count.index') }}" class="btn btn-secondary btn-sm">
                <i class="bx bx-arrow-back"></i> Quay Lại
            </a>
        </div>
    </div>

    <div class="card shadow-sm mb-3">
        <div class="card-header bg-light">
            <h5 class="mb-0">Thông Tin Sản Phẩm & Kho</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Sản Phẩm:</strong> {{ $request->variant->product->name }}</p>
                    <p><strong>SKU:</strong> {{ $request->variant->sku }}</p>
                    <p><strong>Kho:</strong> {{ $request->warehouse->name }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Ngày Tạo:</strong> {{ $request->created_at->format('d/m/Y H:i') }}</p>
                    <p><strong>Người Tạo:</strong> {{ $request->createdBy->name ?? 'N/A' }}</p>
                    <p><strong>Trạng Thái:</strong> <span class="badge bg-warning">{{ $request->status }}</span></p>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm mb-3">
        <div class="card-header bg-light">
            <h5 class="mb-0">Tồn Kho Hiện Tại (Hệ Thống)</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-2 text-center">
                    <p class="text-muted mb-1">Tồn Kho Tổng</p>
                    <h4 class="text-primary">{{ number_format($request->system_qty) }}</h4>
                </div>
                <div class="col-md-2 text-center">
                    <p class="text-muted mb-1">Sẵn Sàng</p>
                    <h4 class="text-success" id="system_available">0</h4>
                </div>
                <div class="col-md-2 text-center">
                    <p class="text-muted mb-1">Đã Đặt</p>
                    <h4 class="text-info" id="system_reserved">0</h4>
                </div>
                <div class="col-md-2 text-center">
                    <p class="text-muted mb-1">Chờ QC</p>
                    <h4 class="text-warning" id="system_quarantine">0</h4>
                </div>
                <div class="col-md-2 text-center">
                    <p class="text-muted mb-1">Hỏng</p>
                    <h4 class="text-danger" id="system_damaged">0</h4>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm mb-3">
        <div class="card-header bg-light">
            <h5 class="mb-0">Chi Tiết Loại Hàng</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-sm table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Loại Hàng</th>
                            <th class="text-end">Số Lượng</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><span class="badge bg-success">Sẵn Sàng</span></td>
                            <td class="text-end"><strong id="detail_available">0</strong></td>
                        </tr>
                        <tr>
                            <td><span class="badge bg-info">Đã Đặt</span></td>
                            <td class="text-end"><strong id="detail_reserved">0</strong></td>
                        </tr>
                        <tr>
                            <td><span class="badge bg-warning">Chờ QC</span></td>
                            <td class="text-end"><strong id="detail_quarantine">0</strong></td>
                        </tr>
                        <tr>
                            <td><span class="badge bg-danger">Hỏng</span></td>
                            <td class="text-end"><strong id="detail_damaged">0</strong></td>
                        </tr>
                        <tr class="table-active">
                            <td><strong>Tổng Cộng</strong></td>
                            <td class="text-end"><strong id="detail_total">0</strong></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-light">
            <h5 class="mb-0">Nhập Kết Quả Đếm</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.inventory.count.confirm-count', $request->id) }}" method="POST" id="countForm">
                @csrf

                <div class="alert alert-info">
                    <strong>Hướng dẫn:</strong> Nhập số lượng thực tế đếm được theo từng loại
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Số Lượng Sẵn Sàng <span class="text-danger">*</span></label>
                        <input type="number" name="available_qty" id="available_qty" class="form-control @error('available_qty') is-invalid @enderror" 
                               value="{{ old('available_qty', 0) }}" min="0">
                        @error('available_qty') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Số Lượng Đã Đặt <span class="text-danger">*</span></label>
                        <input type="number" name="reserved_qty" id="reserved_qty" class="form-control @error('reserved_qty') is-invalid @enderror" 
                               value="{{ old('reserved_qty', 0) }}" min="0">
                        @error('reserved_qty') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Số Lượng Chờ QC <span class="text-danger">*</span></label>
                        <input type="number" name="quarantine_qty" id="quarantine_qty" class="form-control @error('quarantine_qty') is-invalid @enderror" 
                               value="{{ old('quarantine_qty', 0) }}" min="0">
                        @error('quarantine_qty') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Số Lượng Hỏng <span class="text-danger">*</span></label>
                        <input type="number" name="damaged_qty" id="damaged_qty" class="form-control @error('damaged_qty') is-invalid @enderror" 
                               value="{{ old('damaged_qty', 0) }}" min="0">
                        @error('damaged_qty') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div id="defectSection" style="display: none;">
                    <div class="alert alert-warning">
                        <strong>Thông Tin Hàng Hỏng:</strong> Vui lòng nhập chi tiết về hàng hỏng
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Mức Độ Hỏng <span class="text-danger">*</span></label>
                            <select name="defect_level" id="defect_level" class="form-select @error('defect_level') is-invalid @enderror">
                                <option value="">-- Chọn mức độ --</option>
                                <option value="LIGHT" {{ old('defect_level') === 'LIGHT' ? 'selected' : '' }}>Nhẹ (Sửa chữa được)</option>
                                <option value="MEDIUM" {{ old('defect_level') === 'MEDIUM' ? 'selected' : '' }}>Trung Bình (Hạ cấp)</option>
                                <option value="HEAVY" {{ old('defect_level') === 'HEAVY' ? 'selected' : '' }}>Nặng (Phế liệu)</option>
                            </select>
                            @error('defect_level') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Loại Lỗi</label>
                            <select name="defect_type" id="defect_type" class="form-select @error('defect_type') is-invalid @enderror">
                                <option value="">-- Chọn loại lỗi --</option>
                                <option value="SEWING" {{ old('defect_type') === 'SEWING' ? 'selected' : '' }}>Lỗi May</option>
                                <option value="CUTTING" {{ old('defect_type') === 'CUTTING' ? 'selected' : '' }}>Lỗi Cắt</option>
                                <option value="DYEING" {{ old('defect_type') === 'DYEING' ? 'selected' : '' }}>Lỗi Nhuộm</option>
                                <option value="FABRIC" {{ old('defect_type') === 'FABRIC' ? 'selected' : '' }}>Lỗi Vải</option>
                                <option value="SIZE" {{ old('defect_type') === 'SIZE' ? 'selected' : '' }}>Lỗi Kích Thước</option>
                                <option value="OTHER" {{ old('defect_type') === 'OTHER' ? 'selected' : '' }}>Khác</option>
                            </select>
                            @error('defect_type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Mô Tả Lỗi</label>
                        <textarea name="defect_description" id="defect_description" class="form-control @error('defect_description') is-invalid @enderror" 
                                  rows="2" placeholder="Mô tả chi tiết về lỗi...">{{ old('defect_description') }}</textarea>
                        @error('defect_description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="alert alert-info">
                    <strong>Tổng Số Lượng Đếm Được:</strong> <span id="total-display" class="badge bg-primary">0</span>
                    <br><strong>Chênh Lệch:</strong> <span id="difference-display" class="badge bg-warning">0</span>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Người Đếm</label>
                        <input type="text" class="form-control" value="{{ auth()->user()->name }}" disabled>
                        <input type="hidden" name="counted_by" value="{{ auth()->id() }}">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Ghi Chú / Lý Do Kiểm Kê</label>
                    <textarea name="notes" class="form-control @error('notes') is-invalid @enderror" rows="3" placeholder="Ví dụ: Kiểm kê định kỳ, phát hiện mất hàng, ...">{{ old('notes') }}</textarea>
                    @error('notes') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-success">
                        <i class="bx bx-check"></i> Xác Nhận Đếm
                    </button>
                    <a href="{{ route('admin.inventory.count.index') }}" class="btn btn-secondary">
                        <i class="bx bx-x"></i> Hủy
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function updateTotal() {
    const available = parseInt(document.getElementById('available_qty').value) || 0;
    const reserved = parseInt(document.getElementById('reserved_qty').value) || 0;
    const quarantine = parseInt(document.getElementById('quarantine_qty').value) || 0;
    const damaged = parseInt(document.getElementById('damaged_qty').value) || 0;
    const total = available + reserved + quarantine + damaged;
    const systemQty = {{ $request->system_qty ?? 0 }};
    const difference = total - systemQty;
    
    document.getElementById('total-display').textContent = total;
    document.getElementById('difference-display').textContent = (difference >= 0 ? '+' : '') + difference;
    document.getElementById('difference-display').className = difference === 0 ? 'badge bg-success' : (difference > 0 ? 'badge bg-info' : 'badge bg-danger');
    
    const defectSection = document.getElementById('defectSection');
    if (damaged > 0) {
        defectSection.style.display = 'block';
        document.getElementById('defect_level').setAttribute('required', 'required');
    } else {
        defectSection.style.display = 'none';
        document.getElementById('defect_level').removeAttribute('required');
    }
}

document.getElementById('available_qty').addEventListener('input', updateTotal);
document.getElementById('reserved_qty').addEventListener('input', updateTotal);
document.getElementById('quarantine_qty').addEventListener('input', updateTotal);
document.getElementById('damaged_qty').addEventListener('input', updateTotal);

fetch(`/api/v1/warehouses/{{ $request->warehouse_id }}/variants/{{ $request->variant_id }}/stock`)
    .then(r => r.json())
    .then(data => {
        document.getElementById('system_available').textContent = data.available || 0;
        document.getElementById('system_reserved').textContent = data.reserved || 0;
        document.getElementById('system_quarantine').textContent = data.quarantine || 0;
        document.getElementById('system_damaged').textContent = data.damaged || 0;
        
        document.getElementById('detail_available').textContent = data.available || 0;
        document.getElementById('detail_reserved').textContent = data.reserved || 0;
        document.getElementById('detail_quarantine').textContent = data.quarantine || 0;
        document.getElementById('detail_damaged').textContent = data.damaged || 0;
        document.getElementById('detail_total').textContent = (data.available || 0) + (data.reserved || 0) + (data.quarantine || 0) + (data.damaged || 0);
        
        updateTotal();
    })
    .catch(err => console.error('Lỗi tải dữ liệu:', err));
</script>
@endsection
