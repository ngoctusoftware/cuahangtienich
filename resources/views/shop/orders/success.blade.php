@extends('shop.layouts.app')
@section('title', 'Dat hang thanh cong')
@section('content')
<section class="shop-section">
<div class="container">
<div class="text-center py-5 bg-white rounded-4 shadow-sm">
    <i class="bi bi-check-circle-fill" style="font-size:4rem; color:var(--brand-red);"></i>
    <h3 class="mt-3 display-title">Dat hang thanh cong!</h3>
    <p class="text-muted">Ma don hang cua ban la <strong>{{ $order->code }}</strong></p>
    <p>Tong tien: <strong class="price-new fs-4">{{ number_format($order->total_amount) }}₫</strong></p>
    <p>Phuong thuc thanh toan: <strong>{{ strtoupper($order->payment_method) }}</strong> ({{ $order->payment_status }})</p>
    <a href="{{ route('products.index') }}" class="cat-pill me-2">Tiep tuc mua sam</a>
    @auth
        <a href="{{ route('orders.show', $order->code) }}" class="btn btn-cta">Xem don hang</a>
    @endauth
</div>
</div>
</section>
@endsection
