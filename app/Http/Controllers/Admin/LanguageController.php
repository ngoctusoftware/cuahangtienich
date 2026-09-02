<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Language;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class LanguageController extends Controller
{
    public function index(): View
    {
        $languages = Language::orderBy('sort_order')->get();

        return view('admin.languages.index', compact('languages'));
    }

    public function create(): View
    {
        return view('admin.languages.form', ['language' => new Language()]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        Language::create($data);
        Cache::forget('languages:active');

        return redirect()->route('admin.languages.index')->with('success', 'Đã thêm ngôn ngữ.');
    }

    public function edit(Language $language): View
    {
        return view('admin.languages.form', compact('language'));
    }

    public function update(Request $request, Language $language): RedirectResponse
    {
        $language->update($this->validated($request, $language->id));
        Cache::forget('languages:active');

        return redirect()->route('admin.languages.index')->with('success', 'Đã cập nhật ngôn ngữ.');
    }

    public function destroy(Language $language): RedirectResponse
    {
        $language->delete();
        Cache::forget('languages:active');

        return back()->with('success', 'Đã xoá ngôn ngữ.');
    }

    protected function validated(Request $request, ?int $ignoreId = null): array
    {
        return $request->validate([
            'code' => 'required|string|max:10|unique:languages,code,' . $ignoreId,
            'name' => 'required|string|max:255',
            'flag_icon' => 'nullable|string',
            'is_default' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
            'sort_order' => 'nullable|integer',
        ]);
    }
}
