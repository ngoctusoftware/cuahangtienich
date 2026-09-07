@extends('layouts.app')
@section('title', 'Đơn hàng của tôi')
@section('content')
<div class="container py-5">
    <h2 class="mb-4">Đơn hàng của tôi</h2>
    <div class="table-responsive">
        <table class="table">
            <thead><tr><th>Mã đơn</th><th>Ngày đặt</th><th>Tổng tiền</th><th>Trạng thái</th></tr></thead>
            <tbody>
            @forelse($orders as $order)
                <tr>
                    <td>{{ $order->order_code }}</td>
                    <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                    <td>{{ number_format($order->total) }}₫</td>
                    <td><span class="badge bg-info">{{ $order->status }}</span></td>
                </tr>
            @empty
                <tr><td colspan="4" class="text-center text-muted">Chưa có đơn hàng nào.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    {{ $orders->links() }}
</div>
@endsection
