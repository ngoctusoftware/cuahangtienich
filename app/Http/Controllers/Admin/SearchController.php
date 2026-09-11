<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class SearchController extends Controller
{
    public function __invoke(Request $request): View
    {
        $data = $request->validate([
            'q' => ['nullable', 'string', 'max:100'],
        ]);
        $query = trim($data['q'] ?? '');

        return view('admin.search.index', [
            'query' => $query,
            'products' => $query !== '' && $this->canSearch('products.view')
                ? $this->products($query)
                : collect(),
            'categories' => $query !== '' && $this->canSearch('categories.view')
                ? $this->categories($query)
                : collect(),
            'orders' => $query !== '' && $this->canSearch('orders.view')
                ? $this->orders($query)
                : collect(),
        ]);
    }

    private function products(string $query): Collection
    {
        return Product::with('translations', 'category.translations')
            ->where(function ($products) use ($query) {
                $products->where('sku', 'like', "%{$query}%")
                    ->orWhereHas('translations', fn ($translations) => $translations->where('name', 'like', "%{$query}%"));
            })
            ->latest()
            ->limit(8)
            ->get();
    }

    private function categories(string $query): Collection
    {
        return Category::with('translations')
            ->whereHas('translations', fn ($translations) => $translations->where('name', 'like', "%{$query}%"))
            ->orderBy('sort_order')
            ->limit(8)
            ->get();
    }

    private function orders(string $query): Collection
    {
        return Order::with('customer')
            ->where(function ($orders) use ($query) {
                $orders->where('order_code', 'like', "%{$query}%")
                    ->orWhere('receiver_name', 'like', "%{$query}%")
                    ->orWhere('receiver_phone', 'like', "%{$query}%")
                    ->orWhereHas('customer', function ($customers) use ($query) {
                        $customers->where('name', 'like', "%{$query}%")
                            ->orWhere('phone', 'like', "%{$query}%")
                            ->orWhere('email', 'like', "%{$query}%");
                    });
            })
            ->latest()
            ->limit(8)
            ->get();
    }

    private function canSearch(string $permission): bool
    {
        $user = request()->user();

        return $user?->hasRole('super-admin') || $user?->hasPermission($permission);
    }
}
