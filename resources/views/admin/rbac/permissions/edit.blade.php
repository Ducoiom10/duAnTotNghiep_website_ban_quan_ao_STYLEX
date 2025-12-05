@extends('admin.layouts.app')
@section('title', 'Sửa Permission')
@section('content')
<div class="container-fluid">
  <h4 class="mb-3">Sửa Permission: {{ $permission->name }}</h4>
  <div class="card">
    <div class="card-body">
      <form method="POST" action="{{ route('admin.rbac.permissions.update', $permission) }}">
        @csrf
        @method('PUT')
        <div class="mb-3">
          <label class="form-label">Tên</label>
          <input type="text" name="name" value="{{ old('name', $permission->name) }}" class="form-control">
          @error('name')<div class="text-danger small">{{ $message }}</div>@enderror
        </div>
        <div class="mb-3">
          <label class="form-label">Mô tả</label>
          <input type="text" name="description" value="{{ old('description', $permission->description) }}" class="form-control">
        </div>
        <div class="d-flex gap-2">
          <a href="{{ route('admin.rbac.permissions.index') }}" class="btn btn-light">Hủy</a>
          <button class="btn btn-primary" type="submit">Lưu</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection


