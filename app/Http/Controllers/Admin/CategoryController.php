<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Language;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(): View
    {
        $categories = Category::with('translations', 'parent.translations')->orderBy('sort_order')->paginate(15);

        return view('admin.categories.index', compact('categories'));
    }

    public function create(): View
    {
        return view('admin.categories.form', [
            'category' => new Category(),
            'languages' => Language::where('is_active', true)->get(),
            'parents' => Category::with('translations')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $category = Category::create([
            'parent_id' => $data['parent_id'] ?? null,
            'sort_order' => $data['sort_order'] ?? 0,
            'is_active' => $request->boolean('is_active'),
        ]);

        $this->syncTranslations($category, $data['translations']);
        $this->forgetCache();

        return redirect()->route('admin.categories.index')->with('success', 'Đã thêm danh mục.');
    }

    public function edit(Category $category): View
    {
        $category->load('translations');

        return view('admin.categories.form', [
            'category' => $category,
            'languages' => Language::where('is_active', true)->get(),
            'parents' => Category::where('id', '!=', $category->id)->with('translations')->get(),
        ]);
    }

    public function update(Request $request, Category $category): RedirectResponse
    {
        $data = $this->validated($request);
        $category->update([
            'parent_id' => $data['parent_id'] ?? null,
            'sort_order' => $data['sort_order'] ?? 0,
            'is_active' => $request->boolean('is_active'),
        ]);

        $this->syncTranslations($category, $data['translations']);
        $this->forgetCache();

        return redirect()->route('admin.categories.index')->with('success', 'Đã cập nhật danh mục.');
    }

    public function destroy(Category $category): RedirectResponse
    {
        $category->delete();
        $this->forgetCache();

        return back()->with('success', 'Đã xoá danh mục.');
    }

    protected function validated(Request $request): array
    {
        return $request->validate([
            'parent_id' => 'nullable|exists:categories,id',
            'sort_order' => 'nullable|integer',
            'translations' => 'required|array',
            'translations.*.name' => 'required|string|max:255',
        ]);
    }

    // Lưu tên/slug/mô tả theo từng ngôn ngữ (bảng category_translations)
    protected function syncTranslations(Category $category, array $translations): void
    {
        foreach ($translations as $languageId => $trans) {
            if (empty($trans['name'])) {
                continue;
            }
            $category->translations()->updateOrCreate(
                ['language_id' => $languageId],
                [
                    'name' => $trans['name'],
                    'slug' => Str::slug($trans['name']),
                    'description' => $trans['description'] ?? null,
                ]
            );
        }
    }

    protected function forgetCache(): void
    {
        Cache::tags(['categories'])->flush();
    }
}
