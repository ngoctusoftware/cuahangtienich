<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Language;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class BannerController extends Controller
{
    public function index(): View
    {
        return view('admin.banners.index', [
            'banners' => Banner::with('translations')->orderBy('sort_order')->latest()->paginate(15),
        ]);
    }

    public function create(): View
    {
        return view('admin.banners.form', [
            'banner' => new Banner,
            'languages' => Language::where('is_active', true)->orderBy('sort_order')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $data['image'] = 'storage/'.$request->file('image')->store('banners', 'public');
        $data['is_active'] = $request->boolean('is_active');
        $translations = $data['translations'];
        unset($data['translations'], $data['eyebrow'], $data['title'], $data['description'], $data['cta_text'], $data['cta_link']);
        $data = array_merge($this->legacyFields($translations), $data);

        $banner = Banner::create($data);
        $this->syncTranslations($banner, $translations);

        return redirect()->route('admin.banners.index')->with('success', 'Đã thêm banner.');
    }

    public function edit(Banner $banner): View
    {
        return view('admin.banners.form', [
            'banner' => $banner->load('translations'),
            'languages' => Language::where('is_active', true)->orderBy('sort_order')->get(),
        ]);
    }

    public function update(Request $request, Banner $banner): RedirectResponse
    {
        $data = $this->validated($request, false);
        $data['is_active'] = $request->boolean('is_active');
        $translations = $data['translations'];
        unset($data['translations'], $data['eyebrow'], $data['title'], $data['description'], $data['cta_text'], $data['cta_link']);
        $data = array_merge($this->legacyFields($translations), $data);

        if ($request->hasFile('image')) {
            $this->deleteUploadedImage($banner->image);
            $data['image'] = 'storage/'.$request->file('image')->store('banners', 'public');
        } else {
            unset($data['image']);
        }

        $banner->update($data);
        $this->syncTranslations($banner, $translations);

        return redirect()->route('admin.banners.index')->with('success', 'Đã cập nhật banner.');
    }

    public function destroy(Banner $banner): RedirectResponse
    {
        $this->deleteUploadedImage($banner->image);
        $banner->delete();

        return back()->with('success', 'Đã xoá banner.');
    }

    /**
     * @return array<string, mixed>
     */
    protected function validated(Request $request, bool $imageRequired = true): array
    {
        return $request->validate([
            'cta_type' => 'required|in:link,phone',
            'image' => ($imageRequired ? 'required' : 'nullable').'|image|max:4096',
            'bg_class' => 'nullable|string|max:100',
            'sort_order' => 'nullable|integer|min:0',
            'translations' => 'required|array',
            'translations.*.title' => 'required|string|max:255',
            'translations.*.eyebrow' => 'nullable|string|max:255',
            'translations.*.description' => 'nullable|string|max:1000',
            'translations.*.cta_text' => 'nullable|string|max:100',
            'translations.*.cta_link' => 'nullable|string|max:500',
        ]);
    }

    /**
     * @param  array<int|string, array<string, string|null>>  $translations
     */
    protected function syncTranslations(Banner $banner, array $translations): void
    {
        foreach ($translations as $languageId => $translation) {
            $banner->translations()->updateOrCreate(
                ['language_id' => $languageId],
                [
                    'eyebrow' => $translation['eyebrow'] ?? null,
                    'title' => $translation['title'],
                    'description' => $translation['description'] ?? null,
                    'cta_text' => $translation['cta_text'] ?? null,
                    'cta_link' => $translation['cta_link'] ?? null,
                ],
            );
        }
    }

    /**
     * Keep the original banner columns populated for backwards compatibility.
     *
     * @param  array<int|string, array<string, string|null>>  $translations
     * @return array<string, string|null>
     */
    protected function legacyFields(array $translations): array
    {
        $translation = reset($translations);

        return [
            'eyebrow' => $translation['eyebrow'] ?? null,
            'title' => $translation['title'],
            'description' => $translation['description'] ?? null,
            'cta_text' => $translation['cta_text'] ?? null,
            'cta_link' => $translation['cta_link'] ?? null,
        ];
    }

    protected function deleteUploadedImage(string $image): void
    {
        if (str_starts_with($image, 'storage/')) {
            Storage::disk('public')->delete(substr($image, 8));
        }
    }
}
