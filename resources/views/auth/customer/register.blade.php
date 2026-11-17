@extends('layouts.app')
@section('title', __('storefront.auth.register') . ' - ' . ($siteName ?? 'ZEK SHOP'))
@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-5">
            <div class="auth-box">
                <h3 class="mb-4 text-center">{{ __('storefront.auth.register_account') }}</h3>
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
                        <label class="form-label">{{ __('storefront.auth.name') }}</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ __('storefront.auth.email') }}</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ __('storefront.auth.phone') }}</label>
                        <input type="text" name="phone" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ __('storefront.auth.password') }}</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ __('storefront.auth.confirm_password') }}</label>
                        <input type="password" name="password_confirmation" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-hero-cta w-100">{{ __('storefront.auth.register') }}</button>
                </form>
                <p class="text-center mt-3">{{ __('storefront.auth.has_account') }} <a href="{{ route('customer.login') }}">{{ __('storefront.auth.login_now') }}</a></p>
            </div>
        </div>
    </div>
</div>
@endsection
