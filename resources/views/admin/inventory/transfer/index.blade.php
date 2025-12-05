@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-md-6">
            <h4 class="mb-0"><i class="bx bx-transfer"></i> Chuyển Kho</h4>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('admin.inventory.transfer.create') }}" class="btn btn-success btn-sm">
                <i class="bx bx-plus"></i> Tạo Yêu Cầu Chuyển
            </a>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bx bx-check-circle"></i> {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if ($message = Session::get('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bx bx-x-circle"></i> {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="alert alert-info alert-dismissible fade show" role="alert">
        <div class="d-flex gap-2">
            <i class="bx bx-info-circle fs-5 mt-1"></i>
            <div>
                <strong>Quy trình Chuyển Kho:</strong>
                <ol class="mb-0 mt-2 ps-3 small">
                    <li>Tạo yêu cầu chuyển: Chọn kho nguồn, kho đích, sản phẩm, số lượng</li>
                    <li>Xác nhận xuất: Click "Xác Nhận Xuất" khi ở trạng thái "Chờ Xuất" - hàng trừ khỏi kho nguồn</li>
                    <li>Xác nhận nhập: Click "Xác Nhận Nhập" khi ở trạng thái "Đã Xuất" - hàng cộng vào kho đích</li>
                </ol>
            </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-light py-2">
            <h6 class="mb-0">Danh Sách Yêu Cầu Chuyển Kho ({{ $movements->total() }})</h6>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Sản Phẩm</th>
                            <th>Từ Kho</th>
                            <th>Đến Kho</th>
                            <th class="text-end">Số Lượng</th>
                            <th>Ghi Chú</th>
                            <th>Trạng Thái</th>
                            <th class="text-end">Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($movements as $request)
                            <tr>
                                <td>{{ $request->variant->product->name ?? 'N/A' }}</td>
                                <td>{{ $request->fromWarehouse->name }}</td>
                                <td>{{ $request->toWarehouse->name }}</td>
                                <td class="text-end">{{ number_format($request->quantity) }}</td>
                                <td>
                                    @if ($request->notes)
                                        <span title="{{ $request->notes }}" class="text-truncate d-inline-block" style="max-width: 150px;">{{ $request->notes }}</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($request->status === 'PENDING')
                                        <span class="badge bg-warning">Chờ Xuất</span>
                                    @elseif ($request->status === 'OUT_CONFIRMED')
                                        <span class="badge bg-info">Đã Xuất</span>
                                    @elseif ($request->status === 'COMPLETED')
                                        <span class="badge bg-success">Hoàn Thành</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    @if ($request->status === 'PENDING')
                                        <form action="{{ route('admin.inventory.transfer.confirm-out', $request->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-info" title="Xác Nhận Xuất" onclick="return confirm('Xác nhận xuất kho?')">
                                                <i class="bx bx-upload"></i>
                                            </button>
                                        </form>
                                    @elseif ($request->status === 'OUT_CONFIRMED')
                                        <form action="{{ route('admin.inventory.transfer.confirm-in', $request->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success" title="Xác Nhận Nhập" onclick="return confirm('Xác nhận nhập kho?')">
                                                <i class="bx bx-download"></i>
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">
                                    <i class="bx bx-inbox"></i> Không có yêu cầu nào
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-center mt-3">
        {{ $movements->links() }}
    </div>
</div>
@endsection
