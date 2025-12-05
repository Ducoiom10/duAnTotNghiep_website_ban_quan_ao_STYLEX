@extends('admin.layouts.app')
@section('title', 'Sửa Role')
@section('content')
<div class="container-fluid">
  <h4 class="mb-3">Sửa Role: {{ $role->name }}</h4>
  <div class="card">
    <div class="card-body">
      <form method="POST" action="{{ route('admin.rbac.roles.update', $role) }}">
        @csrf
        @method('PUT')
        <div class="mb-3">
          <label class="form-label">Tên</label>
          <input type="text" name="name" value="{{ old('name', $role->name) }}" class="form-control">
          @error('name')<div class="text-danger small">{{ $message }}</div>@enderror
        </div>
        <div class="mb-3">
          <label class="form-label">Mô tả</label>
          <input type="text" name="description" value="{{ old('description', $role->description) }}" class="form-control">
        </div>

        <div class="mb-3">
          <label class="form-label">Gán Permission cho Role</label>
          <div class="row">
            @foreach($permissions as $perm)
              <div class="col-md-3 mb-2">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" name="permission_ids[]" value="{{ $perm->id }}" id="perm_{{ $perm->id }}" {{ in_array($perm->id, $assigned) ? 'checked' : '' }}>
                  <label class="form-check-label" for="perm_{{ $perm->id }}">{{ $perm->name }}</label>
                </div>
              </div>
            @endforeach
          </div>
        </div>

        <div class="d-flex gap-2">
          <a href="{{ route('admin.rbac.roles.index') }}" class="btn btn-light">Hủy</a>
          <button class="btn btn-primary" type="submit">Lưu</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection


