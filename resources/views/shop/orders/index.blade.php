@extends('shop.layouts.app')
@section('title', 'Don hang cua toi')
@section('content')
<h4 class="mb-3">Don hang cua toi</h4>
<div class="card shadow-sm">
    <table class="table align-middle mb-0">
        <thead><tr><th>Ma don</th><th>Tong tien</th><th>Trang thai</th><th>Thanh toan</th><th>Ngay dat</th><th></th></tr></thead>
        <tbody>
        @forelse ($orders as $order)
            <tr>
                <td>{{ $order->code }}</td>
                <td>{{ number_format($order->total_amount) }}₫</td>
                <td><span class="badge bg-info text-dark">{{ $order->status }}</span></td>
                <td><span class="badge bg-{{ $order->payment_status==='paid'?'success':'warning' }}">{{ $order->payment_status }}</span></td>
                <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                <td><a href="{{ route('orders.show', $order->code) }}" class="btn btn-sm btn-outline-primary">Xem</a></td>
            </tr>
        @empty
            <tr><td colspan="6" class="text-center text-muted py-4">Ban chua co don hang nao.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
<div class="mt-3">{{ $orders->links() }}</div>
@endsection
