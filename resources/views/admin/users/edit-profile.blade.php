@extends('admin.layouts.app')

@section('title', 'Chỉnh sửa thông tin cá nhân')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18 text-">Chỉnh sửa thông tin cá nhân</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang chủ</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.profile') }}">Thông tin cá nhân</a></li>
                        <li class="breadcrumb-item active">Chỉnh sửa</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow">
                <div class="card-header bg-primary text-white py-3">
                    <div class="d-flex align-items-center">
                        <div class="avatar-circle me-3">
                            <i class="fas fa-user-edit"></i>
                        </div>
                        <div>
                            <h5 class="mb-1 fw-bold ">Chỉnh sửa thông tin cá nhân</h5>
                            <small class="opacity-75">Cập nhật thông tin cá nhân của bạn</small>
                        </div>
                    </div>
                </div>
                <div class="card-body p-4">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Personal Information Section -->
                        <div class="section-header mb-3">
                            <h6 class="text-primary fw-bold mb-2">
                                <i class="fas fa-user-circle me-2"></i>Thông tin cá nhân
                            </h6>
                            <hr class="text-primary opacity-25">
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name" class="form-label fw-semibold text-dark">
                                        <i class="fas fa-user text-primary me-2"></i>Họ và tên
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="fas fa-user text-muted"></i>
                                        </span>
                                        <input type="text" class="form-control border-start-0 @error('name') is-invalid @enderror" 
                                               id="name" name="name" value="{{ old('name', $user->name) }}" 
                                               placeholder="Nhập họ và tên của bạn" required>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label fw-semibold text-dark">
                                        <i class="fas fa-envelope text-primary me-2"></i>Email
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="fas fa-envelope text-muted"></i>
                                        </span>
                                        <input type="email" class="form-control border-start-0 bg-light" 
                                               value="{{ $user->email }}" readonly>
                                        <span class="input-group-text bg-warning text-white">
                                            <i class="fas fa-lock"></i>
                                        </span>
                                    </div>
                                    <div class="form-text text-warning">
                                        <i class="fas fa-info-circle me-1"></i>Email không thể thay đổi
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone_number" class="form-label fw-semibold text-dark">
                                        <i class="fas fa-phone text-primary me-2"></i>Số điện thoại
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="fas fa-phone text-muted"></i>
                                        </span>
                                        <input type="text" class="form-control border-start-0 @error('phone_number') is-invalid @enderror" 
                                               id="phone_number" name="phone_number" value="{{ old('phone_number', $user->phone_number) }}" 
                                               placeholder="Nhập số điện thoại của bạn">
                                        @error('phone_number')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="avatar" class="form-label fw-semibold text-dark">
                                        <i class="fas fa-image text-primary me-2"></i>Ảnh đại diện
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="fas fa-image text-muted"></i>
                                        </span>
                                        <input type="file" class="form-control border-start-0 @error('avatar') is-invalid @enderror" 
                                               id="avatar" name="avatar" accept="image/*" onchange="previewImage(this)">
                                        @error('avatar')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-text text-info">
                                        <i class="fas fa-info-circle me-1"></i>Chọn ảnh JPG, PNG, GIF (tối đa 2MB)
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Avatar & Role Section -->
                        <div class="section-header mb-3 mt-4">
                            <h6 class="text-primary fw-bold mb-2">
                                <i class="fas fa-cog me-2"></i>Thông tin bổ sung
                            </h6>
                            <hr class="text-primary opacity-25">
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label fw-semibold text-dark">
                                        <i class="fas fa-shield-alt text-primary me-2"></i>Vai trò
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="fas fa-shield-alt text-muted"></i>
                                        </span>
                                        <input type="text" class="form-control border-start-0 bg-light" 
                                               value="{{ $user->role == 1 ? 'Quản trị viên' : ($user->role == 2 ? 'Nhân viên' : 'Người dùng') }}" readonly>
                                        <span class="input-group-text bg-info text-white">
                                            <i class="fas fa-lock"></i>
                                        </span>
                                    </div>
                                    <div class="form-text text-info">
                                        <i class="fas fa-info-circle me-1"></i>Vai trò không thể thay đổi
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <!-- Empty column for balance -->
                            </div>
                        </div>


                        <!-- Action Buttons -->
                        <div class="action-buttons mt-4 pt-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <a href="{{ route('admin.profile') }}" class="btn btn-outline-secondary px-4">
                                    <i class="fas fa-arrow-left me-2"></i>Quay lại
                                </a>
                                <button type="submit" class="btn btn-primary px-4">
                                    <i class="fas fa-save me-2"></i>Cập nhật thông tin
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
/* Card Styling */
.card {
    border: none;
    border-radius: 15px;
    overflow: hidden;
}

.card-header {
    border-radius: 0 !important;
    border: none;
    background: #0d6efd !important;
}

/* Avatar Circle in Header */
.avatar-circle {
    width: 40px;
    height: 40px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1rem;
}

/* Section Headers */
.section-header h6 {
    font-size: 1rem;
    letter-spacing: 0.3px;
}

.section-header hr {
    height: 1px;
    margin: 0;
}

/* Form Groups */
.form-group {
    margin-bottom: 1rem;
}

.form-label {
    font-size: 0.9rem;
    margin-bottom: 0.4rem;
}

/* Input Groups */
.input-group-text {
    border-radius: 8px 0 0 8px;
    border: 1px solid #e9ecef;
    background: #f8f9fa !important;
    padding: 0.5rem 0.75rem;
}

.form-control {
    border-radius: 0 8px 8px 0;
    border: 1px solid #e9ecef;
    border-left: none;
    transition: all 0.3s ease;
    padding: 0.5rem 0.75rem;
    font-size: 0.9rem;
}

.form-control:focus {
    border-color: #0d6efd;
    box-shadow: 0 0 0 0.15rem rgba(13, 110, 253, 0.1);
    background: #fff;
}

.form-control.bg-light {
    background: #f8f9fa !important;
}


/* Buttons */
.btn {
    border-radius: 8px;
    font-weight: 500;
    transition: all 0.3s ease;
    font-size: 0.9rem;
    padding: 0.5rem 1rem;
}

.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

.btn-primary {
    background: #0d6efd;
    border: none;
}

.btn-outline-secondary {
    border: 1px solid #6c757d;
    color: #6c757d;
}

.btn-outline-secondary:hover {
    background: #6c757d;
    border-color: #6c757d;
    color: white;
}

/* Alerts */
.alert {
    border-radius: 8px;
    border: none;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    font-size: 0.9rem;
}

/* Form Text */
.form-text {
    font-size: 0.8rem;
    margin-top: 0.3rem;
}

/* Responsive */
@media (max-width: 768px) {
    .card-body {
        padding: 1.5rem !important;
    }
    
    .d-flex.justify-content-between {
        flex-direction: column;
        gap: 0.75rem;
    }
    
    .d-flex.justify-content-between > * {
        width: 100%;
    }
    
}

/* Animation */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.card {
    animation: fadeInUp 0.4s ease-out;
}
</style>
@endpush

@push('scripts')
<script>

    // Thêm click event cho avatar để mở file picker
    document.addEventListener('DOMContentLoaded', function() {
        const fileInput = document.getElementById('avatar');
        
        if (fileInput) {
            // Chỉ giữ lại validation cơ bản
            fileInput.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    const file = this.files[0];
                    
                    // Kiểm tra kích thước file
                    if (file.size > 2 * 1024 * 1024) {
                        alert('File quá lớn! Vui lòng chọn file nhỏ hơn 2MB.');
                        this.value = '';
                        return;
                    }
                    
                    // Kiểm tra loại file
                    const allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
                    if (!allowedTypes.includes(file.type)) {
                        alert('Chỉ chấp nhận file JPG, PNG, GIF!');
                        this.value = '';
                        return;
                    }
                }
            });
        }
    });
</script>
@endpush