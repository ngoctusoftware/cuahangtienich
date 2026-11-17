@extends('layouts.app')

@section('title', __('storefront.checkout.title') . ' - ' . ($siteName ?? 'ZEK SHOP'))

@push('scripts')
    <script src="{{ asset('js/c_editor.js') }}"></script>
@endpush

@section('content')
<div class="container py-5">
    <h2 class="mb-4">{{ __('storefront.checkout.heading') }}</h2>
    <div class="row g-5">
        <div class="col-lg-7">
            <form action="{{ route('checkout.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">{{ __('storefront.checkout.recipient_name') }}</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', auth('customer')->user()->name ?? '') }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">{{ __('storefront.checkout.phone') }}</label>
                    <input type="text" name="phone" class="form-control" value="{{ old('phone', auth('customer')->user()->phone ?? '') }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">{{ __('storefront.checkout.address') }}</label>
                    <textarea name="address" class="form-control experiences" rows="3" required>{{ old('address', auth('customer')->user()->address ?? '') }}</textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">{{ __('storefront.checkout.note') }}</label>
                    <textarea name="note" class="form-control experiences" rows="2"></textarea>
                </div>

                <h5 class="mt-4 mb-3">{{ __('storefront.checkout.payment_method') }}</h5>
                <div class="form-check mb-2">
                    <input class="form-check-input" type="radio" name="payment_method" value="cod" id="cod" checked>
                    <label class="form-check-label" for="cod"><i class="fas fa-truck me-2"></i>{{ __('storefront.checkout.cod') }}</label>
                </div>
                <div class="form-check mb-2">
                    <input class="form-check-input" type="radio" name="payment_method" value="bank_transfer" id="bank">
                    <label class="form-check-label" for="bank"><i class="fas fa-university me-2"></i>{{ __('storefront.checkout.bank_transfer') }}</label>
                </div>
                <div class="form-check mb-4">
                    <input class="form-check-input" type="radio" name="payment_method" value="online" id="online">
                    <label class="form-check-label" for="online"><i class="fas fa-credit-card me-2"></i>{{ __('storefront.checkout.online') }}</label>
                </div>

                <button type="submit" class="btn btn-hero-cta w-100">{{ __('storefront.checkout.place_order') }}</button>
            </form>
        </div>
        <div class="col-lg-5">
            <div class="checkout-summary">
                <h5 class="mb-3">{{ __('storefront.checkout.order_heading') }}</h5>
                @foreach($items as $item)
                    <div class="d-flex justify-content-between mb-2">
                        <span>{{ $item['name'] }} x{{ $item['quantity'] }}</span>
                        <span>{{ number_format($item['price'] * $item['quantity']) }}₫</span>
                    </div>
                @endforeach
                <hr>
                <div class="d-flex justify-content-between fw-bold fs-5">
                    <span>{{ __('storefront.checkout.total') }}</span>
                    <span>{{ number_format($total) }}₫</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
