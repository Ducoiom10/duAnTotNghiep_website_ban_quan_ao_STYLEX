@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2>Chi Tiết Kho Hàng</h2>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('admin.inventory.warehouses.edit', $warehouse) }}" class="btn btn-warning">Sửa</a>
            <a href="{{ route('admin.inventory.warehouses.index') }}" class="btn btn-secondary">Quay Lại</a>
        </div>
    </div>

    <div class="card p-4">
        <div class="row mb-3">
            <div class="col-md-6">
                <p><strong>Tên Kho:</strong> {{ $warehouse->name }}</p>
                <p><strong>Mã Kho:</strong> {{ $warehouse->code }}</p>
                <p><strong>Loại Kho:</strong> {{ $warehouse->type }}</p>
            </div>
            <div class="col-md-6">
                <p><strong>Trạng Thái:</strong> 
                    <span class="badge bg-{{ $warehouse->operational_status === 'ACTIVE' ? 'success' : 'danger' }}">
                        {{ $warehouse->operational_status }}
                    </span>
                </p>
                <p><strong>Địa Chỉ:</strong> {{ $warehouse->address ?? '-' }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
