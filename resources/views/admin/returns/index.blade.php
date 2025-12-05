@extends('admin.layouts.app')

@section('title', 'Quản lý Trả/Đổi hàng')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1>Quản lý Trả/Đổi hàng</h1>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('admin.inventory.returns.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Tạo yêu cầu mới
            </a>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>RMA #</th>
                        <th>Đơn hàng</th>
                        <th>Khách hàng</th>
                        <th>Loại</th>
                        <th>Lý do</th>
                        <th>Trạng thái</th>
                        <th>Ngày tạo</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($returns as $return)
                        <tr>
                            <td><strong>{{ $return->rma_number }}</strong></td>
                            <td>{{ $return->order->code }}</td>
                            <td>{{ $return->user->name }}</td>
                            <td>
                                <span class="badge bg-{{ $return->type === 'RETURN' ? 'danger' : 'warning' }}">
                                    {{ $return->type === 'RETURN' ? 'Trả hàng' : 'Đổi hàng' }}
                                </span>
                            </td>
                            <td>{{ $return->reason }}</td>
                            <td>
                                @php
                                    $statusColors = [
                                        'PENDING' => 'secondary',
                                        'APPROVED' => 'info',
                                        'REJECTED' => 'danger',
                                        'RECEIVED' => 'primary',
                                        'QC_PASSED' => 'success',
                                        'QC_FAILED' => 'danger',
                                        'COMPLETED' => 'success',
                                    ];
                                    $statusLabels = [
                                        'PENDING' => 'Chờ duyệt',
                                        'APPROVED' => 'Đã duyệt',
                                        'REJECTED' => 'Từ chối',
                                        'RECEIVED' => 'Đã nhận',
                                        'QC_PASSED' => 'QC Pass',
                                        'QC_FAILED' => 'QC Fail',
                                        'COMPLETED' => 'Hoàn thành',
                                    ];
                                @endphp
                                <span class="badge bg-{{ $statusColors[$return->status] ?? 'secondary' }}">
                                    {{ $statusLabels[$return->status] ?? $return->status }}
                                </span>
                            </td>
                            <td>{{ $return->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                <a href="{{ route('admin.inventory.returns.show', $return->id) }}" class="btn btn-sm btn-info">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-4">Không có yêu cầu trả/đổi hàng</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $returns->links() }}
    </div>
</div>
@endsection
