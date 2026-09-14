<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Content;
use App\Models\Language;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Illuminate\View\View;

class TestimonialController extends Controller
{
    public function index(): View
    {
        return view('admin.testimonials.index', [
            'testimonials' => Content::with('translations')
                ->where('type', 'testimonial')
                ->latest()
                ->paginate(15),
        ]);
    }

    public function create(): View
    {
        return view('admin.testimonials.form', [
            'testimonial' => new Content(['type' => 'testimonial', 'rating' => 5, 'is_active' => true]),
            'languages' => $this->languages(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $translations = $data['translations'];
        unset($data['translations']);

        $testimonial = Content::create([
            'key' => $data['key'],
            'type' => 'testimonial',
            'rating' => $data['rating'] ?? 5,
            'is_active' => $request->boolean('is_active'),
            'image' => $request->hasFile('image')
                ? $request->file('image')->store('contents', 'public')
                : null,
        ]);

        $this->syncTranslations($testimonial, $translations);
        Cache::tags(['contents'])->flush();

        return redirect()->route('admin.testimonials.index')->with('success', 'Đã thêm cảm nhận khách hàng.');
    }

    public function edit(Content $testimonial): View
    {
        $this->ensureTestimonial($testimonial);

        return view('admin.testimonials.form', [
            'testimonial' => $testimonial->load('translations'),
            'languages' => $this->languages(),
        ]);
    }

    public function update(Request $request, Content $testimonial): RedirectResponse
    {
        $this->ensureTestimonial($testimonial);
        $data = $this->validated($request, $testimonial->id);
        $translations = $data['translations'];
        unset($data['translations']);

        $testimonial->update([
            'key' => $data['key'],
            'rating' => $data['rating'] ?? 5,
            'is_active' => $request->boolean('is_active'),
            'image' => $request->hasFile('image')
                ? $request->file('image')->store('contents', 'public')
                : $testimonial->image,
        ]);

        $this->syncTranslations($testimonial, $translations);
        Cache::tags(['contents'])->flush();

        return redirect()->route('admin.testimonials.index')->with('success', 'Đã cập nhật cảm nhận khách hàng.');
    }

    public function destroy(Content $testimonial): RedirectResponse
    {
        $this->ensureTestimonial($testimonial);
        $testimonial->delete();
        Cache::tags(['contents'])->flush();

        return back()->with('success', 'Đã xoá cảm nhận khách hàng.');
    }

    /**
     * @return array<string, mixed>
     */
    protected function validated(Request $request, ?int $ignoreId = null): array
    {
        return $request->validate([
            'key' => 'required|string|max:255|unique:contents,key,'.$ignoreId,
            'rating' => 'required|integer|min:1|max:5',
            'image' => 'nullable|image|max:2048',
            'translations' => 'required|array',
            'translations.*.title' => 'required|string|max:255',
            'translations.*.body' => 'nullable|string',
        ]);
    }

    protected function languages()
    {
        return Language::where('is_active', true)->orderBy('sort_order')->get();
    }

    /**
     * @param  array<int|string, array<string, string|null>>  $translations
     */
    protected function syncTranslations(Content $testimonial, array $translations): void
    {
        foreach ($translations as $languageId => $translation) {
            $testimonial->translations()->updateOrCreate(
                ['language_id' => $languageId],
                [
                    'title' => $translation['title'],
                    'slug' => Str::slug($translation['title']),
                    'body' => $translation['body'] ?? null,
                ],
            );
        }
    }

    protected function ensureTestimonial(Content $testimonial): void
    {
        abort_unless($testimonial->type === 'testimonial', 404);
    }
}
