<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Gio hang duoc luu trong session, khong can bang du lieu rieng.
 * Cau truc session('cart') = [ product_id => ['qty' => int] ]
 */
class CartController extends Controller
{
    public function index(): View
    {
        $cart = $this->getCartWithProducts();

        return view('shop.cart.index', ['items' => $cart, 'total' => $this->cartTotal($cart)]);
    }

    public function add(Request $request, Product $product): RedirectResponse
    {
        $qty = max(1, (int) $request->input('qty', 1));
        $cart = session('cart', []);

        $cart[$product->id] = [
            'qty' => ($cart[$product->id]['qty'] ?? 0) + $qty,
        ];

        session(['cart' => $cart]);

        return back()->with('success', 'Da them san pham vao gio hang.');
    }

    public function update(Request $request, int $productId): RedirectResponse
    {
        $qty = max(0, (int) $request->input('qty', 1));
        $cart = session('cart', []);

        if ($qty === 0) {
            unset($cart[$productId]);
        } else {
            $cart[$productId]['qty'] = $qty;
        }

        session(['cart' => $cart]);

        return back()->with('success', 'Da cap nhat gio hang.');
    }

    public function remove(int $productId): RedirectResponse
    {
        $cart = session('cart', []);
        unset($cart[$productId]);
        session(['cart' => $cart]);

        return back()->with('success', 'Da xoa san pham khoi gio hang.');
    }

    private function getCartWithProducts(): array
    {
        $cart = session('cart', []);
        if (empty($cart)) {
            return [];
        }

        $products = Product::whereIn('id', array_keys($cart))->get()->keyBy('id');
        $items = [];

        foreach ($cart as $productId => $data) {
            if (! isset($products[$productId])) {
                continue;
            }
            $product = $products[$productId];
            $items[] = [
                'product' => $product,
                'qty' => $data['qty'],
                'subtotal' => $product->final_price * $data['qty'],
            ];
        }

        return $items;
    }

    private function cartTotal(array $items): float
    {
        return array_sum(array_column($items, 'subtotal'));
    }
}
