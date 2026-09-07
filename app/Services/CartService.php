<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Facades\Session;

// Giỏ hàng lưu trong Session (khách chưa đăng nhập cũng dùng được)
class CartService
{
    protected string $sessionKey = 'cart';

    public function add(int $productId, int $quantity = 1): void
    {
        $cart = $this->all();
        $product = Product::findOrFail($productId);

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] += $quantity;
        } else {
            $cart[$productId] = [
                'product_id' => $product->id,
                'name'       => $product->translation()?->name,
                'price'      => $product->final_price,
                'quantity'   => $quantity,
            ];
        }

        Session::put($this->sessionKey, $cart);
    }

    public function update(int $productId, int $quantity): void
    {
        $cart = $this->all();

        if (isset($cart[$productId])) {
            $quantity > 0 ? $cart[$productId]['quantity'] = $quantity : $this->remove($productId);
            Session::put($this->sessionKey, $cart);
        }
    }

    public function remove(int $productId): void
    {
        $cart = $this->all();
        unset($cart[$productId]);
        Session::put($this->sessionKey, $cart);
    }

    public function all(): array
    {
        return Session::get($this->sessionKey, []);
    }

    public function total(): float
    {
        return collect($this->all())->sum(fn ($item) => $item['price'] * $item['quantity']);
    }

    public function clear(): void
    {
        Session::forget($this->sessionKey);
    }
}
