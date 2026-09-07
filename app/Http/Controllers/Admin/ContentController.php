<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Content;
use App\Models\Language;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

// Quản lý nội dung tĩnh: banner trang chủ, giới thiệu, tin tức, chính sách...
class ContentController extends Controller
{
    public function index(): View
    {
        return view('admin.contents.index', ['contents' => Content::with('translations')->latest()->paginate(15)]);
    }

    public function create(): View
    {
        return view('admin.contents.form', ['content' => new Content(), 'languages' => Language::where('is_active', true)->get()]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);

        $content = Content::create([
            'key' => $data['key'],
            'type' => $data['type'],
            'is_active' => $request->boolean('is_active'),
            'image' => $request->hasFile('image') ? $request->file('image')->store('contents', 'public') : null,
        ]);

        $this->syncTranslations($content, $data['translations']);

        return redirect()->route('admin.contents.index')->with('success', 'Đã thêm nội dung.');
    }

    public function edit(Content $content): View
    {
        $content->load('translations');

        return view('admin.contents.form', ['content' => $content, 'languages' => Language::where('is_active', true)->get()]);
    }

    public function update(Request $request, Content $content): RedirectResponse
    {
        $data = $this->validated($request, $content->id);

        $content->update([
            'key' => $data['key'],
            'type' => $data['type'],
            'is_active' => $request->boolean('is_active'),
            'image' => $request->hasFile('image') ? $request->file('image')->store('contents', 'public') : $content->image,
        ]);

        $this->syncTranslations($content, $data['translations']);

        return redirect()->route('admin.contents.index')->with('success', 'Đã cập nhật nội dung.');
    }

    public function destroy(Content $content): RedirectResponse
    {
        $content->delete();

        return back()->with('success', 'Đã xoá nội dung.');
    }

    protected function validated(Request $request, ?int $ignoreId = null): array
    {
        return $request->validate([
            'key' => 'required|string|unique:contents,key,' . $ignoreId,
            'type' => 'required|in:page,block,news',
            'image' => 'nullable|image|max:2048',
            'translations' => 'required|array',
            'translations.*.title' => 'required|string|max:255',
        ]);
    }

    protected function syncTranslations(Content $content, array $translations): void
    {
        foreach ($translations as $languageId => $trans) {
            if (empty($trans['title'])) {
                continue;
            }
            $content->translations()->updateOrCreate(
                ['language_id' => $languageId],
                ['title' => $trans['title'], 'slug' => Str::slug($trans['title']), 'body' => $trans['body'] ?? null]
            );
        }
    }
}
