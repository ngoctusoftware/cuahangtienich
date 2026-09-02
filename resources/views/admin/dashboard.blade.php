@extends('admin.layouts.app')
@section('title', 'Dashboard')
@section('content')

<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon bg-primary"><i class="fas fa-receipt"></i></div>
            <div>
                <div class="stat-value">{{ $stats['orders_today'] }}</div>
                <div class="stat-label">Đơn hàng hôm nay</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon bg-success"><i class="fas fa-dollar-sign"></i></div>
            <div>
                <div class="stat-value">{{ number_format($stats['revenue_month']) }}₫</div>
                <div class="stat-label">Doanh thu tháng này</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon bg-warning"><i class="fas fa-users"></i></div>
            <div>
                <div class="stat-value">{{ $stats['new_customers'] }}</div>
                <div class="stat-label">Khách hàng mới</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon bg-danger"><i class="fas fa-box"></i></div>
            <div>
                <div class="stat-value">{{ $stats['total_products'] }}</div>
                <div class="stat-label">Tổng sản phẩm</div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="panel">
            <div class="panel-header">Đơn hàng gần đây</div>
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead><tr><th>Mã đơn</th><th>Khách hàng</th><th>Ngày</th><th>Tổng tiền</th><th>Trạng thái</th></tr></thead>
                    <tbody>
                        @foreach($recentOrders as $order)
                            <tr>
                                <td><a href="{{ route('admin.orders.show', $order) }}">{{ $order->order_code }}</a></td>
                                <td>{{ $order->receiver_name }}</td>
                                <td>{{ $order->created_at->format('d/m/Y') }}</td>
                                <td>{{ number_format($order->total) }}₫</td>
                                <td><span class="badge bg-info">{{ $order->status }}</span></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="panel">
            <div class="panel-header">Sản phẩm sắp hết hàng</div>
            <ul class="list-group list-group-flush">
                @foreach($lowStockProducts as $p)
                    <li class="list-group-item d-flex justify-content-between">
                        {{ $p->translation()?->name }}
                        <span class="badge bg-danger">{{ $p->stock }}</span>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endsection
