@extends('admin.layouts.app')

@section('content')
<div class="page-title">
    <h1>Thêm mức thuế</h1>
    <nav aria-label="breadcrumb" class="breadcrumb-header">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.tax_rates.index') }}">Thuế</a></li>
            <li class="breadcrumb-item active" aria-current="page">Thêm mới</li>
        </ol>
    </nav>
</div>

<div class="page-content">
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.tax_rates.store') }}" novalidate>
                @csrf

                <div class="mb-3">
                    <label class="form-label">Tên mức thuế</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('name') }}" placeholder="VD: VAT 10%">
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Tỷ lệ (0–1)</label>
                    <input type="number" step="0.0001" min="0" max="1"
                           name="rate" class="form-control @error('rate') is-invalid @enderror"
                           value="{{ old('rate') }}" placeholder="VD: 0.1 cho 10%">
                    @error('rate') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="d-flex gap-2">
                    <button class="btn btn-primary" type="submit">
                        <i class="bi bi-check2-circle"></i> Lưu
                    </button>
                    <a class="btn btn-secondary" href="{{ route('admin.tax_rates.index') }}">
                        Hủy
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
