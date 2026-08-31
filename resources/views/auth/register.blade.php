@extends('shop.layouts.app')
@section('title', 'Dang ky')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card shadow-sm p-4">
            <h4 class="mb-3 text-center">Dang ky tai khoan</h4>
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Ho ten</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" required autofocus>
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">So dien thoai</label>
                    <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
                </div>
                <div class="mb-3">
                    <label class="form-label">Mat khau</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Nhap lai mat khau</label>
                    <input type="password" name="password_confirmation" class="form-control" required>
                </div>
                <button class="btn btn-primary w-100">Dang ky</button>
            </form>
            <p class="text-center mt-3 mb-0">Da co tai khoan? <a href="{{ route('login') }}">Dang nhap</a></p>
        </div>
    </div>
</div>
@endsection
