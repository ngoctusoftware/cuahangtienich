@extends('layouts.app')
@section('title', 'Đăng ký - ' . ($siteName ?? 'ZEK SHOP'))
@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-5">
            <div class="auth-box">
                <h3 class="mb-4 text-center">Đăng ký tài khoản</h3>
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                        </ul>
                    </div>
                @endif
                <form action="{{ route('customer.register.post') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Họ tên</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Số điện thoại</label>
                        <input type="text" name="phone" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Mật khẩu</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nhập lại mật khẩu</label>
                        <input type="password" name="password_confirmation" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-hero-cta w-100">ĐĂNG KÝ</button>
                </form>
                <p class="text-center mt-3">Đã có tài khoản? <a href="{{ route('customer.login') }}">Đăng nhập</a></p>
            </div>
        </div>
    </div>
</div>
@endsection
