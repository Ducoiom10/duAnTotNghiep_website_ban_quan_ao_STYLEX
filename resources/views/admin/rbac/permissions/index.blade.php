@extends('admin.layouts.app')
@section('title', 'Quản lý Permission')
@section('content')
<div class="container-fluid">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h4>Danh sách Permission</h4>
    <a href="{{ route('admin.rbac.permissions.create') }}" class="btn btn-primary">Tạo Permission</a>
  </div>
  <div class="card">
    <div class="card-body table-responsive">
      <table class="table table-striped align-middle">
        <thead>
          <tr>
            <th>#</th>
            <th>Tên</th>
            <th>Mô tả</th>
            <th>Hành động</th>
          </tr>
        </thead>
        <tbody>
          @foreach($permissions as $permission)
          <tr>
            <td>{{ $permission->id }}</td>
            <td>{{ $permission->name }}</td>
            <td>{{ $permission->description }}</td>
            <td>
              <a class="btn btn-sm btn-warning" href="{{ route('admin.rbac.permissions.edit', $permission) }}">Sửa</a>
              <form class="d-inline" method="POST" action="{{ route('admin.rbac.permissions.destroy', $permission) }}">
                @csrf
                @method('DELETE')
                <button class="btn btn-sm btn-danger" onclick="return confirm('Xóa permission này?')">Xóa</button>
              </form>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
      <div>
        {{ $permissions->links() }}
      </div>
    </div>
  </div>
</div>
@endsection


