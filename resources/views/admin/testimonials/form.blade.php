@extends('admin.layouts.app')
@section('title', $testimonial->exists ? 'Sửa cảm nhận khách hàng' : 'Thêm cảm nhận khách hàng')
@section('content')
<div class="form-card">
    <h4 class="mb-4">{{ $testimonial->exists ? 'Sửa cảm nhận khách hàng' : 'Thêm cảm nhận khách hàng' }}</h4>
    <form action="{{ $testimonial->exists ? route('admin.testimonials.update', $testimonial) : route('admin.testimonials.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if($testimonial->exists) @method('PUT') @endif
        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <label class="form-label">Key định danh</label>
                <input type="text" name="key" class="form-control" placeholder="testimonial-nguyen-van-a" value="{{ old('key', $testimonial->key) }}" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">Số sao đánh giá</label>
                <input type="number" name="rating" class="form-control" min="1" max="5" value="{{ old('rating', $testimonial->rating ?: 5) }}" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">Ảnh đại diện</label>
                <input type="file" name="image" class="form-control" accept="image/*">
            </div>
        </div>

        @if($testimonial->image)
            <div class="mb-4">
                <img src="{{ asset('storage/' . $testimonial->image) }}" alt="Ảnh đại diện hiện tại" class="rounded-circle" width="64" height="64">
            </div>
        @endif

        <ul class="nav nav-tabs mb-3">
            @foreach($languages as $i => $language)
                <li class="nav-item"><button type="button" class="nav-link @if($i === 0) active @endif" data-bs-toggle="tab" data-bs-target="#testimonial-lang-{{ $language->id }}">{{ $language->name }}</button></li>
            @endforeach
        </ul>
        <div class="tab-content mb-4">
            @foreach($languages as $i => $language)
                @php($translation = $testimonial->translations->firstWhere('language_id', $language->id))
                <div class="tab-pane fade @if($i === 0) show active @endif" id="testimonial-lang-{{ $language->id }}">
                    <div class="mb-3">
                        <label class="form-label">Tên khách hàng ({{ $language->name }})</label>
                        <input type="text" name="translations[{{ $language->id }}][title]" class="form-control" value="{{ old("translations.{$language->id}.title", $translation->title ?? '') }}" required>
                    </div>
                    <div>
                        <label class="form-label">Nội dung đánh giá</label>
                        <textarea name="translations[{{ $language->id }}][body]" class="form-control" rows="6">{{ old("translations.{$language->id}.body", $translation->body ?? '') }}</textarea>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="form-check mb-4">
            <input type="checkbox" name="is_active" value="1" class="form-check-input" @checked(old('is_active', $testimonial->is_active || !$testimonial->exists))>
            <label class="form-check-label">Hiển thị trên website</label>
        </div>
        <button class="btn btn-admin-primary">Lưu cảm nhận</button>
    </form>
</div>
@endsection
