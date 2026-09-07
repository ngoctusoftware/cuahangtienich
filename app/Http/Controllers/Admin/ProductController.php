<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Language;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(Request $request): View
    {
        $products = Product::with('translations', 'category.translations')
            ->when($request->search, fn ($q) => $q->whereHas('translations', fn ($t) => $t->where('name', 'like', "%{$request->search}%")))
            ->latest()->paginate(15);

        return view('admin.products.index', compact('products'));
    }

    public function create(): View
    {
        return view('admin.products.form', [
            'product' => new Product(),
            'categories' => Category::with('translations')->get(),
            'languages' => Language::where('is_active', true)->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);

        $product = Product::create([
            'category_id' => $data['category_id'],
            'sku' => $data['sku'],
            'price' => $data['price'],
            'sale_price' => $data['sale_price'] ?? null,
            'stock' => $data['stock'] ?? 0,
            'is_featured' => $request->boolean('is_featured'),
            'is_bestseller' => $request->boolean('is_bestseller'),
            'is_active' => $request->boolean('is_active'),
            'thumbnail' => $this->handleThumbnail($request),
        ]);

        $this->syncTranslations($product, $data['translations']);
        $this->forgetCache();

        return redirect()->route('admin.products.index')->with('success', 'Đã thêm sản phẩm.');
    }

    public function edit(Product $product): View
    {
        $product->load('translations');

        return view('admin.products.form', [
            'product' => $product,
            'categories' => Category::with('translations')->get(),
            'languages' => Language::where('is_active', true)->get(),
        ]);
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $data = $this->validated($request, $product->id);

        $product->update([
            'category_id' => $data['category_id'],
            'sku' => $data['sku'],
            'price' => $data['price'],
            'sale_price' => $data['sale_price'] ?? null,
            'stock' => $data['stock'] ?? 0,
            'is_featured' => $request->boolean('is_featured'),
            'is_bestseller' => $request->boolean('is_bestseller'),
            'is_active' => $request->boolean('is_active'),
            'thumbnail' => $this->handleThumbnail($request) ?: $product->thumbnail,
        ]);

        $this->syncTranslations($product, $data['translations']);
        $this->forgetCache();

        return redirect()->route('admin.products.index')->with('success', 'Đã cập nhật sản phẩm.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();
        $this->forgetCache();

        return back()->with('success', 'Đã xoá sản phẩm.');
    }

    protected function validated(Request $request, ?int $ignoreId = null): array
    {
        return $request->validate([
            'category_id' => 'required|exists:categories,id',
            'sku' => 'required|string|unique:products,sku,' . $ignoreId,
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0|lt:price',
            'stock' => 'nullable|integer|min:0',
            'thumbnail' => 'nullable|image|max:2048',
            'translations' => 'required|array',
            'translations.*.name' => 'required|string|max:255',
        ]);
    }

    protected function handleThumbnail(Request $request): ?string
    {
        if (!$request->hasFile('thumbnail')) {
            return null;
        }

        // Lưu ảnh vào storage/app/public/products, truy cập qua asset('storage/products/...')
        return $request->file('thumbnail')->store('products', 'public');
    }

    protected function syncTranslations(Product $product, array $translations): void
    {
        foreach ($translations as $languageId => $trans) {
            if (empty($trans['name'])) {
                continue;
            }
            $product->translations()->updateOrCreate(
                ['language_id' => $languageId],
                [
                    'name' => $trans['name'],
                    'slug' => Str::slug($trans['name']) . '-' . $product->id,
                    'short_description' => $trans['short_description'] ?? null,
                    'description' => $trans['description'] ?? null,
                ]
            );
        }
    }

    protected function forgetCache(): void
    {
        Cache::tags(['products'])->flush();
    }
}
