@extends('layouts.app')

@section('title', __('storefront.cart.title') . ' - ' . ($siteName ?? 'ZEK SHOP'))

@section('content')
<div class="container py-5">
    <h2 class="mb-4">{{ __('storefront.cart.heading') }}</h2>

    @if(empty($items))
        <p>{{ __('storefront.cart.empty') }} <a href="{{ route('home') }}">{{ __('storefront.cart.continue_shopping') }}</a></p>
    @else
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>{{ __('storefront.cart.product') }}</th>
                        <th>{{ __('storefront.cart.unit_price') }}</th>
                        <th>{{ __('storefront.cart.quantity') }}</th>
                        <th>{{ __('storefront.cart.line_total') }}</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($items as $productId => $item)
                        <tr>
                            <td>{{ $item['name'] }}</td>
                            <td>{{ number_format($item['price']) }}₫</td>
                            <td style="width: 120px">
                                <form action="{{ route('cart.update') }}" method="POST" class="d-flex">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $productId }}">
                                    <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1"
                                           class="form-control form-control-sm" onchange="this.form.submit()">
                                </form>
                            </td>
                            <td>{{ number_format($item['price'] * $item['quantity']) }}₫</td>
                            <td>
                                <form action="{{ route('cart.remove') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $productId }}">
                                    <button class="btn btn-sm btn-outline-danger" aria-label="{{ __('storefront.cart.remove') }}"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-end">
            <div class="cart-summary">
                <div class="d-flex justify-content-between mb-2">
                    <span>{{ __('storefront.cart.subtotal') }}</span>
                    <strong>{{ number_format($total) }}₫</strong>
                </div>
                <a href="{{ route('checkout.index') }}" class="btn btn-hero-cta w-100">{{ __('storefront.cart.checkout') }}</a>
            </div>
        </div>
    @endif
</div>
@endsection
