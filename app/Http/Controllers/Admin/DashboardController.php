<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'orders_today'   => Order::whereDate('created_at', today())->count(),
            'revenue_month'  => Order::whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->where('status', '!=', 'cancelled')->sum('total'),
            'new_customers'  => Customer::whereMonth('created_at', now()->month)->count(),
            'total_products' => Product::count(),
        ];

        $recentOrders = Order::with('customer')->latest()->limit(8)->get();
        $lowStockProducts = Product::with('translations')->where('stock', '<=', 5)->orderBy('stock')->limit(5)->get();

        // Doanh thu 6 tháng gần nhất (không tính đơn đã huỷ) — dùng cho biểu đồ đường khu vực
        $months = collect(range(5, 0))->map(fn ($i) => now()->subMonths($i));
        $revenueTrend = $months->map(function ($month) {
            return [
                'label' => 'Th.' . $month->format('n'),
                'value' => (float) Order::whereYear('created_at', $month->year)
                    ->whereMonth('created_at', $month->month)
                    ->where('status', '!=', 'cancelled')
                    ->sum('total'),
            ];
        });

        // Tỉ lệ trạng thái đơn hàng (toàn bộ) — dùng cho biểu đồ donut "Trạng thái đơn hàng"
        $statusLabels = [
            'pending' => 'Chờ xử lý', 'confirmed' => 'Đã xác nhận',
            'shipping' => 'Đang giao', 'completed' => 'Hoàn thành', 'cancelled' => 'Đã huỷ',
        ];
        $statusCounts = Order::select('status', DB::raw('count(*) as total'))->groupBy('status')->pluck('total', 'status');
        $orderStatus = collect($statusLabels)->map(fn ($label, $key) => [
            'label' => $label,
            'value' => (int) ($statusCounts[$key] ?? 0),
        ])->values();

        // Sản phẩm bán chạy nhất theo số lượng đã bán (sold_count) — dùng cho panel "Sản phẩm nổi bật"
        $topProduct = Product::with(['translations', 'category.translations'])
            ->orderByDesc('sold_count')
            ->first();

        // Hoạt động gần đây: gộp đơn hàng mới + khách hàng mới thành 1 dòng thời gian
        $activities = collect()
            ->concat(Order::latest()->limit(4)->get()->map(fn ($o) => [
                'time' => $o->created_at,
                'title' => 'Đơn hàng mới #' . $o->order_code,
                'desc' => $o->receiver_name . ' — ' . number_format($o->total) . '₫',
            ]))
            ->concat(Customer::latest()->limit(3)->get()->map(fn ($c) => [
                'time' => $c->created_at,
                'title' => 'Khách hàng mới đăng ký',
                'desc' => $c->name . ($c->email ? ' — ' . $c->email : ''),
            ]))
            ->sortByDesc('time')
            ->take(6)
            ->values();

        return view('admin.dashboard', compact(
            'stats', 'recentOrders', 'lowStockProducts', 'revenueTrend', 'orderStatus', 'topProduct', 'activities'
        ));
    }
}
