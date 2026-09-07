@extends('admin.layouts.app')
@section('title', 'Dashboard')
@section('content')

<div class="page-header mb-4 d-flex align-items-center justify-content-between flex-wrap gap-2">
    <div>
        <h1 class="page-title">Dashboard</h1>
        <div class="page-subtitle">Tổng quan hoạt động cửa hàng — {{ now()->translatedFormat('d/m/Y') }}</div>
    </div>
    <a href="{{ route('admin.settings.index') }}" class="btn btn-admin-primary btn-sm">
        <i class="fas fa-cog me-1"></i> Cấu hình chung
    </a>
</div>

{{-- Hàng thống kê nhanh --}}
<div class="row g-4 mb-4">
    <div class="col-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-icon bg-primary"><i class="fas fa-receipt"></i></div>
            <div>
                <div class="stat-value">{{ $stats['orders_today'] }}</div>
                <div class="stat-label">Đơn hàng hôm nay</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-icon bg-success"><i class="fas fa-sack-dollar"></i></div>
            <div>
                <div class="stat-value">{{ number_format($stats['revenue_month']) }}₫</div>
                <div class="stat-label">Doanh thu tháng này</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-icon bg-warning"><i class="fas fa-users"></i></div>
            <div>
                <div class="stat-value">{{ $stats['new_customers'] }}</div>
                <div class="stat-label">Khách hàng mới</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-icon bg-danger"><i class="fas fa-box"></i></div>
            <div>
                <div class="stat-value">{{ $stats['total_products'] }}</div>
                <div class="stat-label">Tổng sản phẩm</div>
            </div>
        </div>
    </div>
</div>

{{-- Doanh thu 6 tháng + Sản phẩm bán chạy nhất --}}
<div class="row g-4 mb-4">
    <div class="col-lg-8">
        <div class="panel h-100">
            <div class="panel-header">
                Doanh thu 6 tháng gần đây
                <span class="muted">{{ $revenueTrend->first()['label'] }} – {{ $revenueTrend->last()['label'] }}</span>
            </div>
            <div class="panel-body">
                <div class="earning-figure">{{ number_format($revenueTrend->last()['value']) }}₫</div>
                <div class="earning-caption">Doanh thu tháng hiện tại</div>
                <div class="chart-wrap mt-2" style="height:260px">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="panel h-100">
            <div class="panel-header">Sản phẩm bán chạy nhất</div>
            <div class="panel-body text-center">
                @if($topProduct)
                    <img src="{{ $topProduct->thumbnail ? asset('storage/'.$topProduct->thumbnail) : asset('images/product-placeholder.jpg') }}"
                         class="popular-product-thumb mb-3" alt="">
                    <div class="fw-bold text-white">{{ $topProduct->translation()?->name ?? $topProduct->sku }}</div>
                    <div class="stars my-1">
                        @for($i = 0; $i < 5; $i++)<i class="fas fa-star"></i>@endfor
                        <span class="text-muted ms-1" style="font-size:11px">{{ $topProduct->category?->translation()?->name }}</span>
                    </div>
                    <div class="row mt-3">
                        <div class="col-6 border-end" style="border-color:rgba(255,255,255,.08) !important">
                            <div class="stat-value" style="font-size:19px">{{ $topProduct->sold_count }}</div>
                            <div class="stat-label">Đã bán</div>
                        </div>
                        <div class="col-6">
                            <div class="stat-value" style="font-size:19px">{{ number_format($topProduct->final_price) }}₫</div>
                            <div class="stat-label">Đơn giá</div>
                        </div>
                    </div>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-outline-primary btn-sm mt-3 w-100">Xem tất cả sản phẩm</a>
                @else
                    <p class="text-muted my-4">Chưa có dữ liệu bán hàng.</p>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- Trạng thái đơn hàng + Sắp hết hàng + Hoạt động gần đây --}}
<div class="row g-4 mb-4">
    <div class="col-lg-4">
        <div class="panel h-100">
            <div class="panel-header">Trạng thái đơn hàng</div>
            <div class="panel-body">
                <div class="chart-wrap" style="height:190px">
                    <canvas id="statusDonut"></canvas>
                </div>
                <div class="donut-legend mt-3">
                    @foreach($orderStatus as $i => $s)
                        <div class="d-flex justify-content-between align-items-center mb-1" style="font-size:12.5px">
                            <span class="text-muted"><span class="dot" style="background:{{ ['#2fbfa3','#34c9ea','#f2b84b','#6fb7ff','#f2637a'][$i % 5] }}"></span>{{ $s['label'] }}</span>
                            <span class="text-white fw-semibold">{{ $s['value'] }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="panel h-100">
            <div class="panel-header">Sản phẩm sắp hết hàng</div>
            <ul class="list-group list-group-flush">
                @forelse($lowStockProducts as $p)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span class="d-flex align-items-center gap-2">
                            <img src="{{ $p->thumbnail ? asset('storage/'.$p->thumbnail) : asset('images/product-placeholder.jpg') }}" class="thumb-mini">
                            {{ $p->translation()?->name ?? $p->sku }}
                        </span>
                        <span class="badge bg-danger">Còn {{ $p->stock }}</span>
                    </li>
                @empty
                    <li class="list-group-item text-muted">Không có sản phẩm sắp hết hàng.</li>
                @endforelse
            </ul>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="panel h-100">
            <div class="panel-header">Hoạt động gần đây</div>
            <div class="panel-body">
                <ul class="timeline">
                    @forelse($activities as $a)
                        <li>
                            <div class="t-time">{{ $a['time']->diffForHumans() }}</div>
                            <div class="t-title">{{ $a['title'] }}</div>
                            <div class="t-desc">{{ $a['desc'] }}</div>
                        </li>
                    @empty
                        <li class="text-muted">Chưa có hoạt động nào.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>

{{-- Đơn hàng gần đây --}}
<div class="panel">
    <div class="panel-header">
        Đơn hàng gần đây
        <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-primary btn-sm">Xem tất cả</a>
    </div>
    <div class="table-responsive">
        <table class="table mb-0">
            <thead><tr><th>Khách hàng</th><th>Mã đơn</th><th>Ngày</th><th>Thanh toán</th><th>Tổng tiền</th><th>Trạng thái</th></tr></thead>
            <tbody>
                @forelse($recentOrders as $order)
                    <tr>
                        <td>
                            <span class="d-flex align-items-center gap-2">
                                <span class="avatar-mini">{{ strtoupper(substr($order->receiver_name ?? 'K', 0, 1)) }}</span>
                                {{ $order->receiver_name }}
                            </span>
                        </td>
                        <td><a href="{{ route('admin.orders.show', $order) }}">{{ $order->order_code }}</a></td>
                        <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                        <td class="text-uppercase" style="font-size:11.5px">{{ $order->payment_method }}</td>
                        <td>{{ number_format($order->total) }}₫</td>
                        <td>
                            @php
                                $statusColor = ['pending' => 'warning', 'confirmed' => 'info', 'shipping' => 'primary', 'completed' => 'success', 'cancelled' => 'danger'][$order->status] ?? 'secondary';
                            @endphp
                            <span class="badge bg-{{ $statusColor }}">{{ $order->status }}</span>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center text-muted py-4">Chưa có đơn hàng nào.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@push('scripts')
<script>
    const revenueLabels = @json($revenueTrend->pluck('label'));
    const revenueData = @json($revenueTrend->pluck('value'));

    new Chart(document.getElementById('revenueChart'), {
        type: 'line',
        data: {
            labels: revenueLabels,
            datasets: [{
                data: revenueData,
                borderColor: '#2fbfa3',
                backgroundColor: (ctx) => {
                    const g = ctx.chart.ctx.createLinearGradient(0, 0, 0, 260);
                    g.addColorStop(0, 'rgba(47,191,163,.45)');
                    g.addColorStop(1, 'rgba(47,191,163,0)');
                    return g;
                },
                fill: true,
                tension: 0.4,
                pointRadius: 3,
                pointBackgroundColor: '#2fbfa3',
                borderWidth: 2,
            }]
        },
        options: {
            plugins: { legend: { display: false } },
            scales: {
                x: { grid: { color: 'rgba(255,255,255,.06)' } },
                y: { grid: { color: 'rgba(255,255,255,.06)' }, ticks: { callback: v => (v/1000) + 'k' } }
            }
        }
    });

    new Chart(document.getElementById('statusDonut'), {
        type: 'doughnut',
        data: {
            labels: @json($orderStatus->pluck('label')),
            datasets: [{
                data: @json($orderStatus->pluck('value')),
                backgroundColor: ['#2fbfa3','#34c9ea','#f2b84b','#6fb7ff','#f2637a'],
                borderWidth: 0,
            }]
        },
        options: {
            cutout: '72%',
            plugins: { legend: { display: false } }
        }
    });
</script>
@endpush
@endsection
