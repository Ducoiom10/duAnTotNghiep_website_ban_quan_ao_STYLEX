@extends('admin.layouts.app')
@section('title', 'Tạo Permission')
@section('content')
<div class="container-fluid">
  <h4 class="mb-3">Tạo Permission</h4>
  <div class="card">
    <div class="card-body">
      <form method="POST" action="{{ route('admin.rbac.permissions.store') }}">
        @csrf
        <div class="mb-3">
          <label class="form-label">Tên</label>
          <input type="text" name="name" value="{{ old('name') }}" class="form-control">
          @error('name')<div class="text-danger small">{{ $message }}</div>@enderror
        </div>
        <div class="mb-3">
          <label class="form-label">Mô tả</label>
          <input type="text" name="description" value="{{ old('description') }}" class="form-control">
        </div>
        <div class="d-flex gap-2">
          <a href="{{ route('admin.rbac.permissions.index') }}" class="btn btn-light">Hủy</a>
          <button class="btn btn-primary" type="submit">Tạo</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection


