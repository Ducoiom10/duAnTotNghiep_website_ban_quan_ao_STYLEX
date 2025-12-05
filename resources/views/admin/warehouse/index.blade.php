@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2>Quản Lý Kho Hàng</h2>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('admin.inventory.warehouses.create') }}" class="btn btn-success">+ Thêm Kho</a>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Tên Kho</th>
                        <th>Mã Kho</th>
                        <th>Loại</th>
                        <th>Trạng Thái</th>
                        <th>Địa Chỉ</th>
                        <th>Hành Động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($warehouses as $warehouse)
                        <tr>
                            <td><strong>{{ $warehouse->name }}</strong></td>
                            <td>{{ $warehouse->code }}</td>
                            <td>{{ $warehouse->type }}</td>
                            <td>
                                <span class="badge bg-{{ $warehouse->operational_status === 'ACTIVE' ? 'success' : 'danger' }}">
                                    {{ $warehouse->operational_status }}
                                </span>
                            </td>
                            <td>{{ $warehouse->address ?? '-' }}</td>
                            <td>
                                <a href="{{ route('admin.inventory.warehouses.edit', $warehouse) }}" class="btn btn-sm btn-warning">Sửa</a>
                                <form action="{{ route('admin.inventory.warehouses.destroy', $warehouse) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Xác nhận xóa?')">Xóa</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">Không có kho hàng nào</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $warehouses->links() }}
    </div>
</div>
@endsection
