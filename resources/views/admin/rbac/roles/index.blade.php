@extends('admin.layouts.app')
@section('title', 'Quản lý Role')
@section('content')
<div class="container-fluid">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h4>Danh sách Role</h4>
    <a href="{{ route('admin.rbac.roles.create') }}" class="btn btn-primary">Tạo Role</a>
  </div>
  <div class="card">
    <div class="card-body table-responsive">
      <table class="table table-striped align-middle">
        <thead>
          <tr>
            <th>#</th>
            <th>Tên</th>
            <th>Mô tả</th>
            <th>Quyền</th>
            <th>Hành động</th>
          </tr>
        </thead>
        <tbody>
          @foreach($roles as $role)
          <tr>
            <td>{{ $role->id }}</td>
            <td>{{ $role->name }}</td>
            <td>{{ $role->description }}</td>
            <td>
              @foreach($role->permissions as $perm)
                <span class="badge bg-secondary me-1">{{ $perm->name }}</span>
              @endforeach
            </td>
            <td>
              <a class="btn btn-sm btn-warning" href="{{ route('admin.rbac.roles.edit', $role) }}">Sửa</a>
              <form class="d-inline" method="POST" action="{{ route('admin.rbac.roles.destroy', $role) }}">
                @csrf
                @method('DELETE')
                <button class="btn btn-sm btn-danger" onclick="return confirm('Xóa role này?')">Xóa</button>
              </form>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
      <div>
        {{ $roles->links() }}
      </div>
    </div>
  </div>
</div>
@endsection


