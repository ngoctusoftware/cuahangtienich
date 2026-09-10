<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeaderMenuItem;
use App\Models\Language;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HeaderMenuController extends Controller
{
    public function index(): View
    {
        return view('admin.header-menu.index', [
            'menuItems' => HeaderMenuItem::with('translations')->orderBy('sort_order')->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.header-menu.form', [
            'menuItem' => new HeaderMenuItem,
            'languages' => Language::where('is_active', true)->orderBy('sort_order')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $menuItem = HeaderMenuItem::create($this->menuItemData($data, $request));
        $this->syncTranslations($menuItem, $data['translations']);

        return redirect()->route('admin.header-menu.index')->with('success', 'Đã thêm mục menu header.');
    }

    public function edit(HeaderMenuItem $headerMenuItem): View
    {
        $headerMenuItem->load('translations');

        return view('admin.header-menu.form', [
            'menuItem' => $headerMenuItem,
            'languages' => Language::where('is_active', true)->orderBy('sort_order')->get(),
        ]);
    }

    public function update(Request $request, HeaderMenuItem $headerMenuItem): RedirectResponse
    {
        $data = $this->validated($request, $headerMenuItem->id);
        $headerMenuItem->update($this->menuItemData($data, $request));
        $this->syncTranslations($headerMenuItem, $data['translations']);

        return redirect()->route('admin.header-menu.index')->with('success', 'Đã cập nhật menu header.');
    }

    public function destroy(HeaderMenuItem $headerMenuItem): RedirectResponse
    {
        $headerMenuItem->delete();

        return back()->with('success', 'Đã xoá mục menu header.');
    }

    protected function validated(Request $request, ?int $ignoreId = null): array
    {
        return $request->validate([
            'key' => 'required|string|max:100|unique:header_menu_items,key,'.$ignoreId,
            'icon' => 'nullable|string|max:100',
            'link_type' => 'required|in:route,url',
            'link_value' => 'nullable|string|max:255',
            'sort_order' => 'required|integer|min:0',
            'translations' => 'required|array',
            'translations.*.label' => 'required|string|max:100',
        ]);
    }

    protected function menuItemData(array $data, Request $request): array
    {
        return [
            'key' => $data['key'],
            'icon' => $data['icon'] ?? null,
            'link_type' => $data['link_type'],
            'link_value' => $request->boolean('is_category') ? null : ($data['link_value'] ?? null),
            'is_category' => $request->boolean('is_category'),
            'is_active' => $request->boolean('is_active'),
            'sort_order' => $data['sort_order'],
        ];
    }

    protected function syncTranslations(HeaderMenuItem $menuItem, array $translations): void
    {
        foreach ($translations as $languageId => $translation) {
            $menuItem->translations()->updateOrCreate(
                ['language_id' => $languageId],
                ['label' => $translation['label']]
            );
        }
    }
}
