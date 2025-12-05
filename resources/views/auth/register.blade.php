@extends('auth.layout')

@section('title', 'Đăng ký')
@section('page-title', 'Đăng ký')
@section('page-subtitle', 'Tạo tài khoản mới')

@section('content')
    @if(Session::has('success'))
    <script>
        window.addEventListener("DOMContentLoaded", function() {
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: "{{ Session::get('success') }}",
                showConfirmButton: false,
                timer: 5000,
                timerProgressBar: true
            });
        });
    </script>
    @endif

    @if(Session::has('error'))
    <script>
        window.addEventListener("DOMContentLoaded", function() {
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'error',
                title: "{{ Session::get('error') }}",
                showConfirmButton: false,
                timer: 5000,
                timerProgressBar: true
            });
        });
    </script>
    @endif

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Họ và tên</label>
            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                name="name" value="{{ old('name') }}" placeholder="Nhập họ và tên" autofocus>
            @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                name="email" value="{{ old('email') }}" placeholder="Nhập email của bạn">
            @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="phone_number" class="form-label">Số điện thoại</label>
            <input id="phone_number" type="tel" class="form-control @error('phone_number') is-invalid @enderror"
                name="phone_number" value="{{ old('phone_number') }}" placeholder="Nhập số điện thoại">
            @error('phone_number')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Mật khẩu</label>
            <div class="input-group">
                <input id="password" type="password"
                    class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Nhập mật khẩu">
                <button type="button" class="btn btn-outline-secondary toggle-password" data-target="#password">
                    <i class="fa fa-eye"></i>
                </button>
            </div>
            @error('password')
            <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Xác nhận mật khẩu</label>
            <div class="input-group">
                <input id="password_confirmation" type="password"
                    class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" placeholder="Nhập lại mật khẩu">
                <button type="button" class="btn btn-outline-secondary toggle-password" data-target="#password_confirmation">
                    <i class="fa fa-eye"></i>
                </button>
            </div>
            @error('password_confirmation')
            <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="terms" name="terms" required>
            <label class="form-check-label" for="terms">
                Tôi đồng ý với <a href="#" class="text-primary">điều khoản sử dụng</a>
            </label>
        </div>

        <div class="d-grid">
            <button type="submit" class="btn btn-primary">
                Đăng ký
            </button>
        </div>
    </form>
@endsection

@section('footer')
    <p class="mb-0">Đã có tài khoản? <a href="{{ route('loginView') }}">Đăng nhập ngay</a></p>
@endsection

@push('scripts')
<script>
    // Toggle password visibility
    document.querySelectorAll('.toggle-password').forEach(function(button) {
        button.addEventListener('click', function() {
            const target = document.querySelector(this.getAttribute('data-target'));
            const icon = this.querySelector('i');
            
            if (target.type === 'password') {
                target.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                target.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });
    });
</script>
@endpush