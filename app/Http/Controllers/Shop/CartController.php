<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Services\CartService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
{
    public function __construct(protected CartService $cartService)
    {
    }

    public function index(): View
    {
        return view('cart.index', [
            'items' => $this->cartService->all(),
            'total' => $this->cartService->total(),
        ]);
    }

    public function add(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'nullable|integer|min:1',
        ]);

        $this->cartService->add($data['product_id'], $data['quantity'] ?? 1);

        return back()->with('success', 'Đã thêm sản phẩm vào giỏ hàng.');
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate(['product_id' => 'required|integer', 'quantity' => 'required|integer|min:0']);
        $this->cartService->update($data['product_id'], $data['quantity']);

        return back();
    }

    public function remove(Request $request): RedirectResponse
    {
        $data = $request->validate(['product_id' => 'required|integer']);
        $this->cartService->remove($data['product_id']);

        return back();
    }
}
