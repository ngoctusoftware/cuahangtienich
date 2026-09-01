@extends('shop.layouts.app')
@section('title', 'Dang nhap')
@section('content')
<section class="shop-section">
<div class="container">
<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="bg-white rounded-4 shadow-sm p-4">
            <h4 class="mb-3 text-center display-title">Dang nhap</h4>
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus>
                </div>
                <div class="mb-3">
                    <label class="form-label">Mat khau</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <div class="form-check mb-3">
                    <input type="checkbox" name="remember" class="form-check-input" id="remember">
                    <label class="form-check-label" for="remember">Ghi nho dang nhap</label>
                </div>
                <button class="btn btn-cta w-100">Dang nhap</button>
            </form>
            <p class="text-center mt-3 mb-0">Chua co tai khoan? <a href="{{ route('register') }}" style="color:var(--brand-red)">Dang ky ngay</a></p>
        </div>
    </div>
</div>
</div>
</section>
@endsection
