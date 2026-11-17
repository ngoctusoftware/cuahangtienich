@extends('layouts.app')
@section('title', __('storefront.auth.login') . ' - ' . ($siteName ?? 'ZEK SHOP'))
@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-5">
            <div class="auth-box">
                <h3 class="mb-4 text-center">{{ __('storefront.auth.login') }}</h3>
                @if($errors->any())
                    <div class="alert alert-danger">{{ $errors->first() }}</div>
                @endif
                <form action="{{ route('customer.login.post') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">{{ __('storefront.auth.email') }}</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ __('storefront.auth.password') }}</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-hero-cta w-100">{{ __('storefront.auth.login') }}</button>
                </form>
                <p class="text-center mt-3">{{ __('storefront.auth.no_account') }} <a href="{{ route('customer.register') }}">{{ __('storefront.auth.register_now') }}</a></p>
            </div>
        </div>
    </div>
</div>
@endsection
