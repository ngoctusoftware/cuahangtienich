@extends('shop.layouts.app')
@section('title', 'Don hang '.$order->code)
@section('content')
<section class="shop-section">
<div class="container">
    <div class="section-heading">
        <h2>Chi tiet don hang {{ $order->code }}</h2>
        <div class="rule"></div>
    </div>
    <div class="row g-4">
        <div class="col-md-8">
            <div class="bg-white rounded-4 shadow-sm p-2">
                <table class="table mb-0">
                    <thead><tr><th>San pham</th><th>Gia</th><th>SL</th><th>Thanh tien</th></tr></thead>
                    <tbody>
                    @foreach ($order->items as $item)
                        <tr>
                            <td>{{ $item->product_name }}</td>
                            <td>{{ number_format($item->price) }}₫</td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ number_format($item->subtotal) }}₫</td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot><tr><th colspan="3" class="text-end">Tong cong</th><th class="price-new">{{ number_format($order->total_amount) }}₫</th></tr></tfoot>
                </table>
            </div>
        </div>
        <div class="col-md-4">
            <div class="bg-white rounded-4 shadow-sm p-3 mb-3">
                <p class="mb-1"><strong>Trang thai:</strong> {{ $order->status }}</p>
                <p class="mb-1"><strong>Thanh toan:</strong> {{ $order->payment_status }} ({{ strtoupper($order->payment_method) }})</p>
                <p class="mb-1"><strong>Nguoi nhan:</strong> {{ $order->receiver_name }}</p>
                <p class="mb-1"><strong>SDT:</strong> {{ $order->receiver_phone }}</p>
                <p class="mb-0"><strong>Dia chi:</strong> {{ $order->receiver_address }}</p>
            </div>
            @if ($order->payment_status !== 'paid' && $order->payment_method !== 'cod')
                <a href="{{ route('payment.process', $order->code) }}" class="btn btn-cta w-100">Thanh toan ngay</a>
            @endif
        </div>
    </div>
</div>
</section>
@endsection
