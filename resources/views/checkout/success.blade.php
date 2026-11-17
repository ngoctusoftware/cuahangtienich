@extends('layouts.app')
@section('title', __('storefront.checkout.success_title'))
@section('content')
<div class="container py-5 text-center">
    <i class="fas fa-check-circle text-success" style="font-size: 64px;"></i>
    <h2 class="mt-3">{{ __('storefront.checkout.success_heading') }}</h2>
    <p>{{ __('storefront.checkout.order_code') }} <strong>{{ $orderCode }}</strong></p>
    <p>{{ __('storefront.checkout.confirmation') }}</p>
    <a href="{{ route('home') }}" class="btn btn-hero-cta mt-3">{{ __('storefront.cart.continue_shopping') }}</a>
</div>
@endsection
