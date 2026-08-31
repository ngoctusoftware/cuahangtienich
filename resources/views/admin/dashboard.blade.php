@extends('admin.layouts.app')
@section('title', 'Tong quan')
@section('content')
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card shadow-sm"><div class="card-body">
            <div class="text-muted small">San pham</div>
            <div class="fs-3 fw-bold">{{ $stats['total_products'] }}</div>
        </div></div>
    </div>
    <div class="col-md-3">
        <div class="card shadow-sm"><div class="card-body">
            <div class="text-muted small">Don hang</div>
            <div class="fs-3 fw-bold">{{ $stats['total_orders'] }}</div>
        </div></div>
    </div>
    <div class="col-md-3">
        <div class="card shadow-sm"><div class="card-body">
            <div class="text-muted small">Nguoi dung</div>
            <div class="fs-3 fw-bold">{{ $stats['total_users'] }}</div>
        </div></div>
    </div>
    <div class="col-md-3">
        <div class="card shadow-sm"><div class="card-body">
            <div class="text-muted small">Doanh thu (da thanh toan)</div>
            <div class="fs-4 fw-bold text-success">{{ number_format($stats['revenue']) }}₫</div>
        </div></div>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-header">Don hang gan day</div>
    <div class="card-body p-0">
        <table class="table mb-0">
            <thead><tr><th>Ma don</th><th>Nguoi nhan</th><th>Tong tien</th><th>Trang thai</th><th>Thanh toan</th><th>Ngay</th></tr></thead>
            <tbody>
            @foreach ($recentOrders as $order)
                <tr>
                    <td><a href="{{ route('admin.orders.show', $order) }}">{{ $order->code }}</a></td>
                    <td>{{ $order->receiver_name }}</td>
                    <td>{{ number_format($order->total_amount) }}₫</td>
                    <td><span class="badge bg-secondary">{{ $order->status }}</span></td>
                    <td><span class="badge bg-{{ $order->payment_status === 'paid' ? 'success' : 'warning' }}">{{ $order->payment_status }}</span></td>
                    <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
