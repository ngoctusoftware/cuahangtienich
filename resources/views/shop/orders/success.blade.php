@extends('shop.layouts.app')
@section('title', 'Dat hang thanh cong')
@section('content')
<div class="text-center py-5">
    <i class="bi bi-check-circle-fill text-success" style="font-size:4rem;"></i>
    <h3 class="mt-3">Dat hang thanh cong!</h3>
    <p class="text-muted">Ma don hang cua ban la <strong>{{ $order->code }}</strong></p>
    <p>Tong tien: <strong class="text-danger">{{ number_format($order->total_amount) }}₫</strong></p>
    <p>Phuong thuc thanh toan: <strong>{{ strtoupper($order->payment_method) }}</strong> ({{ $order->payment_status }})</p>
    <a href="{{ route('products.index') }}" class="btn btn-outline-primary mt-3">Tiep tuc mua sam</a>
    @auth
        <a href="{{ route('orders.show', $order->code) }}" class="btn btn-primary mt-3">Xem don hang</a>
    @endauth
</div>
@endsection
