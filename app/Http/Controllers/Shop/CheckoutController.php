<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Services\CartService;
use App\Services\OrderService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    public function __construct(
        protected CartService $cartService,
        protected OrderService $orderService,
    ) {
    }

    public function index(): View|RedirectResponse
    {
        if (empty($this->cartService->all())) {
            return redirect()->route('cart.index');
        }

        return view('checkout.index', [
            'items' => $this->cartService->all(),
            'total' => $this->cartService->total(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'note' => 'nullable|string',
            'payment_method' => 'required|in:cod,bank_transfer,online',
        ]);

        $order = $this->orderService->checkout($data, auth('customer')->id());

        return redirect()->route('checkout.success', $order->order_code);
    }

    public function success(string $code): View
    {
        return view('checkout.success', ['orderCode' => $code]);
    }
}
