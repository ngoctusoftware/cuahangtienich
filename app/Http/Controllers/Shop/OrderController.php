<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(Request $request): View
    {
        $orders = $request->user()->orders()->latest()->paginate(10);

        return view('shop.orders.index', compact('orders'));
    }

    public function show(Request $request, string $code): View
    {
        $order = $request->user()->orders()
            ->where('code', $code)
            ->with('items', 'payments')
            ->firstOrFail();

        return view('shop.orders.show', compact('order'));
    }
}
