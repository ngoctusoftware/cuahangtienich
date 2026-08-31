<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'total_products' => Product::count(),
            'total_orders' => Order::count(),
            'total_users' => User::count(),
            'revenue' => Order::where('payment_status', Order::PAYMENT_PAID)->sum('total_amount'),
            'pending_orders' => Order::where('status', Order::STATUS_PENDING)->count(),
        ];

        $recentOrders = Order::latest()->take(10)->get();

        return view('admin.dashboard', compact('stats', 'recentOrders'));
    }
}
