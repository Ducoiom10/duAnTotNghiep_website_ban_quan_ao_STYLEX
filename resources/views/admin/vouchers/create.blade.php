@extends('admin.layouts.app')

@section('title', 'Tạo voucher')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Tạo voucher</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.vouchers.index') }}">Voucher</a></li>
                    <li class="breadcrumb-item active">Tạo mới</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.vouchers.store') }}" method="POST">
                    @include('admin.vouchers._form')
                </form>
            </div>
        </div>
    </div>
</div>
@endsection


