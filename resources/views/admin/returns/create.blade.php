@extends('admin.layouts.app')

@section('title', 'Tạo yêu cầu Trả/Đổi hàng')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1>Tạo yêu cầu Trả/Đổi hàng</h1>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('admin.inventory.returns.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Quay lại
            </a>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Lỗi:</strong>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <form action="{{ route('admin.inventory.returns.store') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Thông tin yêu cầu</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Chọn đơn hàng <span class="text-danger">*</span></label>
                            <select name="order_id" id="orderSelect" class="form-select" required>
                                <option value="">-- Chọn đơn hàng --</option>
                                @foreach ($orders as $order)
                                    <option value="{{ $order->id }}" data-items="{{ json_encode($order->items) }}">
                                        {{ $order->code }} - {{ $order->user->name }} ({{ $order->total }} đ)
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Loại <span class="text-danger">*</span></label>
                                <select name="type" class="form-select" required>
                                    <option value="RETURN">Trả hàng</option>
                                    <option value="EXCHANGE">Đổi hàng</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Lý do <span class="text-danger">*</span></label>
                                <select name="reason" class="form-select" required>
                                    <option value="DEFECTIVE">Sản phẩm bị lỗi</option>
                                    <option value="NOT_AS_DESCRIBED">Không đúng mô tả</option>
                                    <option value="WRONG_SIZE">Size sai</option>
                                    <option value="WRONG_COLOR">Màu sai</option>
                                    <option value="CHANGED_MIND">Thay đổi ý định</option>
                                    <option value="OTHER">Khác</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Mô tả chi tiết</label>
                            <textarea name="reason_description" class="form-control" rows="3" placeholder="Mô tả lý do trả/đổi hàng..."></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Ghi chú</label>
                            <textarea name="notes" class="form-control" rows="2" placeholder="Ghi chú thêm..."></textarea>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Chọn sản phẩm trả/đổi</h5>
                    </div>
                    <div class="card-body">
                        <div id="itemsContainer">
                            <p class="text-muted">Vui lòng chọn đơn hàng trước</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card sticky-top" style="top: 20px;">
                    <div class="card-header">
                        <h5 class="mb-0">Tóm tắt</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <small class="text-muted">Số sản phẩm chọn</small>
                            <div class="h5" id="selectedCount">0</div>
                        </div>
                        <div class="mb-3">
                            <small class="text-muted">Tổng tiền hoàn</small>
                            <div class="h5" id="totalRefund">0 đ</div>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-check-circle"></i> Tạo yêu cầu
                        </button>
                        <a href="{{ route('admin.inventory.returns.index') }}" class="btn btn-secondary w-100 mt-2">
                            <i class="bi bi-x-circle"></i> Hủy
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
document.getElementById('orderSelect').addEventListener('change', function() {
    const option = this.options[this.selectedIndex];
    const items = option.dataset.items ? JSON.parse(option.dataset.items) : [];
    const container = document.getElementById('itemsContainer');

    if (items.length === 0) {
        container.innerHTML = '<p class="text-muted">Không có sản phẩm trong đơn hàng</p>';
        return;
    }

    let html = '<div class="table-responsive"><table class="table table-sm"><thead><tr><th>Sản phẩm</th><th>Số lượng</th><th>Giá</th><th>Tình trạng</th><th></th></tr></thead><tbody>';

    items.forEach((item, index) => {
        html += `
            <tr>
                <td>${item.product?.name || 'N/A'}</td>
                <td>
                    <input type="hidden" name="items[${index}][order_item_id]" value="${item.id}">
                    <input type="number" name="items[${index}][quantity]" class="form-control form-control-sm qty-input" value="1" min="1" max="${item.quantity}">
                </td>
                <td>${item.price} đ</td>
                <td>
                    <select name="items[${index}][condition]" class="form-select form-select-sm">
                        <option value="UNOPENED">Chưa mở</option>
                        <option value="OPENED" selected>Đã mở</option>
                        <option value="DAMAGED">Hỏng</option>
                        <option value="DEFECTIVE">Lỗi</option>
                    </select>
                </td>
                <td>
                    <input type="checkbox" class="form-check-input item-check" data-price="${item.price}" checked>
                </td>
            </tr>
            <tr>
                <td colspan="5">
                    <input type="text" name="items[${index}][notes]" class="form-control form-control-sm" placeholder="Ghi chú sản phẩm...">
                </td>
            </tr>
        `;
    });

    html += '</tbody></table></div>';
    container.innerHTML = html;

    updateSummary();
    document.querySelectorAll('.item-check, .qty-input').forEach(el => {
        el.addEventListener('change', updateSummary);
    });
});

function updateSummary() {
    let count = 0;
    let total = 0;

    document.querySelectorAll('.item-check:checked').forEach(checkbox => {
        const row = checkbox.closest('tr');
        const qty = row.querySelector('.qty-input')?.value || 1;
        const price = checkbox.dataset.price || 0;
        count += parseInt(qty);
        total += parseInt(price) * parseInt(qty);
    });

    document.getElementById('selectedCount').textContent = count;
    document.getElementById('totalRefund').textContent = total.toLocaleString('vi-VN') + ' đ';
}
</script>
@endsection
