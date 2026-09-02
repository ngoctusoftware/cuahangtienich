<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'orders_today'   => Order::whereDate('created_at', today())->count(),
            'revenue_month'  => Order::whereMonth('created_at', now()->month)->where('status', '!=', 'cancelled')->sum('total'),
            'new_customers'  => Customer::whereMonth('created_at', now()->month)->count(),
            'total_products' => Product::count(),
        ];

        $recentOrders = Order::latest()->limit(8)->get();
        $lowStockProducts = Product::with('translations')->where('stock', '<=', 5)->limit(6)->get();

        return view('admin.dashboard', compact('stats', 'recentOrders', 'lowStockProducts'));
    }
}
