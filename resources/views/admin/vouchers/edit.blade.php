@extends('admin.layouts.app')

@section('title', 'Sửa voucher')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Sửa voucher</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.vouchers.index') }}">Voucher</a></li>
                    <li class="breadcrumb-item active">Chỉnh sửa</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Thông tin voucher</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.vouchers.update', $voucher) }}" method="POST">
                    @method('PUT')
                    @include('admin.vouchers._form', ['voucher' => $voucher])
                </form>
            </div>
        </div>
    </div>
</div>
@endsection


