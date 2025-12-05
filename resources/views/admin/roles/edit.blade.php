@extends('admin.layouts.app')

@section('title', 'Sửa tài khoản Admin/Staff')

@section('content')
<div class="container-fluid">
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Sửa tài khoản Admin/Staff</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.roles.index') }}">Quản lý Admin & Staff</a></li>
                        <li class="breadcrumb-item active">Sửa tài khoản</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Form sửa tài khoản -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Thông tin tài khoản</h4>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.roles.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Họ và tên <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           id="name" name="name" value="{{ old('name', $user->name) }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                           id="email" name="email" value="{{ old('email', $user->email) }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="password" class="form-label">Mật khẩu mới</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                           id="password" name="password" placeholder="Để trống nếu không muốn đổi mật khẩu">
                                    <div class="form-text">Để trống nếu không muốn thay đổi mật khẩu</div>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Vai trò <span class="text-danger">*</span></label>
                                    @php
                                        $adminCount = \App\Models\User::where('role', 1)->count();
                                        $isLastAdmin = $user->role == 1 && $adminCount <= 1;
                                    @endphp
                                    @if($isLastAdmin)
                                        <div class="alert alert-warning mb-2">
                                            <i class="ri-information-line me-2"></i>
                                            <strong>Lưu ý:</strong> Đây là admin cuối cùng, không thể thay đổi vai trò!
                                        </div>
                                    @endif
                                    <div class="d-flex gap-4">
                                        <div class="form-check">
                                            <input class="form-check-input @error('role') is-invalid @enderror" 
                                                   type="radio" name="role" id="role_admin" value="1" 
                                                   {{ old('role', $user->role) == '1' ? 'checked' : '' }}
                                                   {{ $isLastAdmin ? 'disabled' : '' }}>
                                            <label class="form-check-label text-danger {{ $isLastAdmin ? 'text-muted' : '' }}" for="role_admin">
                                                <i class="ri-admin-line me-1"></i>Admin
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input @error('role') is-invalid @enderror" 
                                                   type="radio" name="role" id="role_staff" value="2" 
                                                   {{ old('role', $user->role) == '2' ? 'checked' : '' }}
                                                   {{ $isLastAdmin ? 'disabled' : '' }}>
                                            <label class="form-check-label text-warning {{ $isLastAdmin ? 'text-muted' : '' }}" for="role_staff">
                                                <i class="ri-team-line me-1"></i>Staff
                                            </label>
                                        </div>
                                    </div>
                                    @error('role')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Trạng thái <span class="text-danger">*</span></label>
                                    @if($isLastAdmin)
                                        <div class="alert alert-warning mb-2">
                                            <i class="ri-information-line me-2"></i>
                                            <strong>Lưu ý:</strong> Admin cuối cùng phải ở trạng thái hoạt động!
                                        </div>
                                    @endif
                                    <div class="d-flex gap-4">
                                        <div class="form-check">
                                            <input class="form-check-input @error('status') is-invalid @enderror" 
                                                   type="radio" name="status" id="status_active" value="active" 
                                                   {{ old('status', $user->status) == 'active' ? 'checked' : '' }}>
                                            <label class="form-check-label text-success" for="status_active">
                                                <i class="ri-checkbox-circle-line me-1"></i>Hoạt động
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input @error('status') is-invalid @enderror" 
                                                   type="radio" name="status" id="status_inactive" value="inactive" 
                                                   {{ old('status', $user->status) == 'inactive' ? 'checked' : '' }}
                                                   {{ $isLastAdmin ? 'disabled' : '' }}>
                                            <label class="form-check-label text-warning {{ $isLastAdmin ? 'text-muted' : '' }}" for="status_inactive">
                                                <i class="ri-pause-circle-line me-1"></i>Tạm dừng
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input @error('status') is-invalid @enderror" 
                                                   type="radio" name="status" id="status_blocked" value="blocked" 
                                                   {{ old('status', $user->status) == 'blocked' ? 'checked' : '' }}
                                                   {{ $isLastAdmin ? 'disabled' : '' }}>
                                            <label class="form-check-label text-danger {{ $isLastAdmin ? 'text-muted' : '' }}" for="status_blocked">
                                                <i class="ri-lock-line me-1"></i>Bị khóa
                                            </label>
                                        </div>
                                    </div>
                                    @error('status')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="ri-save-line me-1"></i>Cập nhật tài khoản
                                    </button>
                                    <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary">
                                        <i class="ri-arrow-left-line me-1"></i>Quay lại
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
