@extends('admin.layouts.app')
@section('title', $content->exists ? 'Sửa nội dung' : 'Thêm nội dung')
@section('content')
<div class="form-card">
    <h4 class="mb-4">{{ $content->exists ? 'Sửa nội dung' : 'Thêm nội dung' }}</h4>
    <form action="{{ $content->exists ? route('admin.contents.update', $content) : route('admin.contents.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if($content->exists) @method('PUT') @endif
        <div class="row g-3 mb-3">
            <div class="col-md-6">
                <label class="form-label">Key (định danh, vd: home-banner, about-us)</label>
                <input type="text" name="key" class="form-control" value="{{ old('key', $content->key) }}" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">Loại</label>
                <select name="type" class="form-select">
                    <option value="page" {{ $content->type === 'page' ? 'selected' : '' }}>Trang</option>
                    <option value="block" {{ $content->type === 'block' ? 'selected' : '' }}>Khối nội dung</option>
                    <option value="news" {{ $content->type === 'news' ? 'selected' : '' }}>Tin tức</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Ảnh đại diện</label>
                <input type="file" name="image" class="form-control">
            </div>
        </div>

        <ul class="nav nav-tabs mb-3">
            @foreach($languages as $i => $lang)
                <li class="nav-item">
                    <button type="button" class="nav-link {{ $i === 0 ? 'active' : '' }}" data-bs-toggle="tab" data-bs-target="#lang-{{ $lang->id }}">{{ $lang->name }}</button>
                </li>
            @endforeach
        </ul>
        <div class="tab-content mb-4">
            @foreach($languages as $i => $lang)
                @php $trans = $content->translations->firstWhere('language_id', $lang->id); @endphp
                <div class="tab-pane fade {{ $i === 0 ? 'show active' : '' }}" id="lang-{{ $lang->id }}">
                    <div class="mb-3">
                        <label class="form-label">Tiêu đề ({{ $lang->name }})</label>
                        <input type="text" name="translations[{{ $lang->id }}][title]" class="form-control" value="{{ old("translations.{$lang->id}.title", $trans->title ?? '') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nội dung</label>
                        <textarea name="translations[{{ $lang->id }}][body]" class="form-control" rows="8">{{ old("translations.{$lang->id}.body", $trans->body ?? '') }}</textarea>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="form-check mb-3">
            <input type="checkbox" name="is_active" value="1" class="form-check-input" {{ $content->is_active || !$content->exists ? 'checked' : '' }}>
            <label class="form-check-label">Hiển thị trên website</label>
        </div>
        <button class="btn btn-admin-primary">Lưu nội dung</button>
    </form>
</div>
@endsection
