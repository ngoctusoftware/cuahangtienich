@extends('shop.layouts.app')
@section('title', 'Don hang cua toi')
@section('content')
<section class="shop-section">
<div class="container">
    <div class="section-heading">
        <h2>Don hang cua toi</h2>
        <div class="rule"></div>
    </div>
    <div class="bg-white rounded-4 shadow-sm p-2">
        <table class="table align-middle mb-0">
            <thead><tr><th>Ma don</th><th>Tong tien</th><th>Trang thai</th><th>Thanh toan</th><th>Ngay dat</th><th></th></tr></thead>
            <tbody>
            @forelse ($orders as $order)
                <tr>
                    <td>{{ $order->code }}</td>
                    <td class="price-new">{{ number_format($order->total_amount) }}₫</td>
                    <td><span class="badge bg-info text-dark">{{ $order->status }}</span></td>
                    <td><span class="badge bg-{{ $order->payment_status==='paid'?'success':'warning' }}">{{ $order->payment_status }}</span></td>
                    <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                    <td><a href="{{ route('orders.show', $order->code) }}" class="btn btn-sm btn-outline-danger">Xem</a></td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-center text-muted py-4">Ban chua co don hang nao.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-3 d-flex justify-content-center">{{ $orders->links() }}</div>
</div>
</section>
@endsection
