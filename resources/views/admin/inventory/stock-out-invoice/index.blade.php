@extends('admin.layouts.app')

@section('title', 'Hóa đơn xuất kho')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1>Hóa đơn xuất kho</h1>
        </div>
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Số hóa đơn</th>
                        <th>Loại</th>
                        <th>Kho</th>
                        <th>Số sản phẩm</th>
                        <th>Tổng tiền</th>
                        <th>Trạng thái</th>
                        <th>Ngày tạo</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($invoices as $invoice)
                        <tr>
                            <td><strong>{{ $invoice->invoice_number }}</strong></td>
                            <td>
                                <span class="badge bg-{{ $invoice->type === 'CLEARANCE' ? 'warning' : 'info' }}">
                                    {{ $invoice->type === 'CLEARANCE' ? 'Thanh lý' : 'Thường' }}
                                </span>
                            </td>
                            <td>{{ $invoice->warehouse->name }}</td>
                            <td>{{ $invoice->items->sum('quantity') }}</td>
                            <td>{{ number_format($invoice->total_amount) }} đ</td>
                            <td>
                                <span class="badge bg-{{ $invoice->status === 'COMPLETED' ? 'success' : 'secondary' }}">
                                    {{ $invoice->status }}
                                </span>
                            </td>
                            <td>{{ $invoice->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                <a href="{{ route('admin.inventory.stock-out-invoice.show', $invoice->id) }}" class="btn btn-sm btn-info" title="Xem chi tiết">
                                    <i class="bi bi-eye"></i>
                                </a>
                                @if ($invoice->status !== 'COMPLETED')
                                    <form action="{{ route('admin.inventory.stock-out-invoice.complete', $invoice->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Xác nhận hoàn thành hóa đơn?');">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success" title="Hoàn thành">
                                            <i class="bi bi-check-circle"></i>
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">Không có hóa đơn xuất kho</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $invoices->links() }}
    </div>
</div>
@endsection
