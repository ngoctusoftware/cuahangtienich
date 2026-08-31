<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    public function show(): View|RedirectResponse
    {
        $cart = session('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Gio hang dang trong.');
        }

        $products = Product::whereIn('id', array_keys($cart))->get();
        $total = 0;
        foreach ($products as $product) {
            $total += $product->final_price * $cart[$product->id]['qty'];
        }

        return view('shop.cart.checkout', compact('products', 'cart', 'total'));
    }

    public function placeOrder(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'receiver_name' => ['required', 'string', 'max:255'],
            'receiver_phone' => ['required', 'string', 'max:20'],
            'receiver_address' => ['required', 'string'],
            'note' => ['nullable', 'string'],
            'payment_method' => ['required', 'in:cod,vnpay,momo,bank_transfer'],
        ]);

        $cart = session('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Gio hang dang trong.');
        }

        $products = Product::whereIn('id', array_keys($cart))->lockForUpdate()->get();

        $order = DB::transaction(function () use ($data, $cart, $products) {
            $total = 0;
            foreach ($products as $product) {
                $total += $product->final_price * $cart[$product->id]['qty'];
            }

            $order = Order::create([
                'code' => Order::generateCode(),
                'user_id' => Auth::id(),
                'receiver_name' => $data['receiver_name'],
                'receiver_phone' => $data['receiver_phone'],
                'receiver_address' => $data['receiver_address'],
                'note' => $data['note'] ?? null,
                'total_amount' => $total,
                'status' => Order::STATUS_PENDING,
                'payment_status' => Order::PAYMENT_UNPAID,
                'payment_method' => $data['payment_method'],
            ]);

            foreach ($products as $product) {
                $qty = $cart[$product->id]['qty'];

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'price' => $product->final_price,
                    'quantity' => $qty,
                    'subtotal' => $product->final_price * $qty,
                ]);

                // Tru ton kho
                $product->decrement('stock', min($qty, $product->stock));
            }

            Payment::create([
                'order_id' => $order->id,
                'method' => $data['payment_method'],
                'amount' => $total,
                'status' => Payment::STATUS_PENDING,
            ]);

            return $order;
        });

        session()->forget('cart');

        if ($order->payment_method === 'cod') {
            return redirect()->route('orders.success', $order->code)
                ->with('success', 'Dat hang thanh cong! Thanh toan khi nhan hang (COD).');
        }

        // Cac phuong thuc thanh toan online -> chuyen sang trang thanh toan
        return redirect()->route('payment.process', $order->code);
    }

    public function success(string $code): View
    {
        $order = Order::where('code', $code)->with('items')->firstOrFail();

        return view('shop.orders.success', compact('order'));
    }
}
