@extends('admin.layouts.app')
@section('title', $banner->exists ? 'Sửa banner' : 'Thêm banner')
@section('content')
<div class="form-card">
    <h4 class="mb-4">{{ $banner->exists ? 'Sửa banner' : 'Thêm banner' }}</h4>
    <form action="{{ $banner->exists ? route('admin.banners.update', $banner) : route('admin.banners.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if($banner->exists) @method('PUT') @endif
        <div class="row g-3 mb-3">
            <div class="col-md-6">
                <label class="form-label">Thứ tự hiển thị</label>
                <input type="number" name="sort_order" min="0" class="form-control" value="{{ old('sort_order', $banner->sort_order) }}">
            </div>
            <div class="col-md-4">
                <label class="form-label">Ảnh banner {{ !$banner->exists ? '*' : '' }}</label>
                <input type="file" name="image" class="form-control" accept="image/*" {{ !$banner->exists ? 'required' : '' }}>
            </div>
        </div>
        @if($banner->exists)
            <img src="{{ $banner->image_url }}" alt="" class="mb-3 rounded" style="max-width:360px;max-height:160px;object-fit:cover">
        @endif
        <ul class="nav nav-tabs mb-3">
            @foreach($languages as $i => $language)
                <li class="nav-item">
                    <button type="button" class="nav-link @if($i === 0) active @endif" data-bs-toggle="tab" data-bs-target="#banner-lang-{{ $language->id }}">{{ $language->name }}</button>
                </li>
            @endforeach
        </ul>
        <div class="tab-content mb-4">
            @foreach($languages as $i => $language)
                @php
                    $translation = $banner->translations->firstWhere('language_id', $language->id);
                    $fallback = $translation ?: ($i === 0 ? $banner : null);
                @endphp
                <div class="tab-pane fade @if($i === 0) show active @endif" id="banner-lang-{{ $language->id }}">
                    <div class="mb-3">
                        <label class="form-label">Nhãn phụ ({{ $language->name }})</label>
                        <input type="text" name="translations[{{ $language->id }}][eyebrow]" class="form-control" value="{{ old("translations.{$language->id}.eyebrow", $fallback->eyebrow ?? '') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tiêu đề <small>(cho phép &lt;br&gt;)</small></label>
                        <input type="text" name="translations[{{ $language->id }}][title]" class="form-control" value="{{ old("translations.{$language->id}.title", $fallback->title ?? '') }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Mô tả</label>
                        <textarea name="translations[{{ $language->id }}][description]" class="form-control" rows="3">{{ old("translations.{$language->id}.description", $fallback->description ?? '') }}</textarea>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Nhãn nút</label>
                            <input type="text" name="translations[{{ $language->id }}][cta_text]" class="form-control" value="{{ old("translations.{$language->id}.cta_text", $fallback->cta_text ?? '') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Liên kết / số điện thoại</label>
                            <input type="text" name="translations[{{ $language->id }}][cta_link]" class="form-control" value="{{ old("translations.{$language->id}.cta_link", $fallback->cta_link ?? '') }}">
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="row g-3 mb-3">
            <div class="col-md-3">
                <label class="form-label">Kiểu CTA</label>
                <select name="cta_type" class="form-select">
                    <option value="link" @selected(old('cta_type', $banner->cta_type ?: 'link') === 'link')>Liên kết</option>
                    <option value="phone" @selected(old('cta_type', $banner->cta_type) === 'phone')>Gọi điện</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Class nền</label>
                <input type="text" name="bg_class" class="form-control" placeholder="bg-slide-1" value="{{ old('bg_class', $banner->bg_class) }}">
            </div>
        </div>
        <div class="form-check mb-4">
            <input type="checkbox" name="is_active" value="1" class="form-check-input" @checked(old('is_active', $banner->is_active || !$banner->exists))>
            <label class="form-check-label">Hiển thị trên website</label>
        </div>
        <button class="btn btn-admin-primary">Lưu banner</button>
    </form>
</div>
@endsection
