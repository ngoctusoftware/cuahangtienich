<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\StoreBenefit;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StoreBenefitController extends Controller
{
    public function index(): View
    {
        return view('admin.store-benefits.index', [
            'benefits' => StoreBenefit::with('translations')->orderBy('sort_order')->paginate(15),
        ]);
    }

    public function create(): View
    {
        return view('admin.store-benefits.form', [
            'benefit' => new StoreBenefit,
            'languages' => $this->languages(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $translations = $data['translations'];
        unset($data['translations']);
        $benefit = StoreBenefit::create($data);
        $this->syncTranslations($benefit, $translations);

        return redirect()->route('admin.store-benefits.index')->with('success', 'Đã thêm nội dung lý do nên chọn.');
    }

    public function edit(StoreBenefit $storeBenefit): View
    {
        return view('admin.store-benefits.form', [
            'benefit' => $storeBenefit->load('translations'),
            'languages' => $this->languages(),
        ]);
    }

    public function update(Request $request, StoreBenefit $storeBenefit): RedirectResponse
    {
        $data = $this->validated($request);
        $translations = $data['translations'];
        unset($data['translations']);
        $storeBenefit->update($data);
        $this->syncTranslations($storeBenefit, $translations);

        return redirect()->route('admin.store-benefits.index')->with('success', 'Đã cập nhật nội dung lý do nên chọn.');
    }

    public function destroy(StoreBenefit $storeBenefit): RedirectResponse
    {
        $storeBenefit->delete();

        return back()->with('success', 'Đã xoá nội dung lý do nên chọn.');
    }

    /**
     * @return array<string, mixed>
     */
    protected function validated(Request $request): array
    {
        return $request->validate([
            'icon' => 'required|string|max:100',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
            'translations' => 'required|array',
            'translations.*.title' => 'required|string|max:255',
            'translations.*.description' => 'nullable|string|max:255',
        ]);
    }

    protected function languages()
    {
        return Language::where('is_active', true)->orderBy('sort_order')->get();
    }

    /**
     * @param  array<int|string, array<string, string|null>>  $translations
     */
    protected function syncTranslations(StoreBenefit $benefit, array $translations): void
    {
        foreach ($translations as $languageId => $translation) {
            $benefit->translations()->updateOrCreate(
                ['language_id' => $languageId],
                [
                    'title' => $translation['title'],
                    'description' => $translation['description'] ?? null,
                ],
            );
        }
    }
}
