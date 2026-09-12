@extends('admin.layouts.app')
@section('title', $benefit->exists ? 'Sửa lý do nên chọn' : 'Thêm lý do nên chọn')
@section('content')
<div class="form-card">
    <h4 class="mb-4">{{ $benefit->exists ? 'Sửa lý do nên chọn' : 'Thêm lý do nên chọn' }}</h4>
    <form action="{{ $benefit->exists ? route('admin.store-benefits.update', $benefit) : route('admin.store-benefits.store') }}" method="POST">
        @csrf
        @if($benefit->exists) @method('PUT') @endif
        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <label class="form-label">Icon Font Awesome</label>
                <input type="text" name="icon" class="form-control" placeholder="fas fa-shield-halved" value="{{ old('icon', $benefit->icon ?: 'fas fa-star') }}" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">Thứ tự</label>
                <input type="number" name="sort_order" min="0" class="form-control" value="{{ old('sort_order', $benefit->sort_order) }}">
            </div>
        </div>
        <ul class="nav nav-tabs mb-3">
            @foreach($languages as $i => $language)
                <li class="nav-item"><button type="button" class="nav-link @if($i === 0) active @endif" data-bs-toggle="tab" data-bs-target="#benefit-lang-{{ $language->id }}">{{ $language->name }}</button></li>
            @endforeach
        </ul>
        <div class="tab-content mb-4">
            @foreach($languages as $i => $language)
                @php($translation = $benefit->translations->firstWhere('language_id', $language->id))
                <div class="tab-pane fade @if($i === 0) show active @endif" id="benefit-lang-{{ $language->id }}">
                    <div class="mb-3">
                        <label class="form-label">Tiêu đề ({{ $language->name }})</label>
                        <input type="text" name="translations[{{ $language->id }}][title]" class="form-control" value="{{ old("translations.{$language->id}.title", $translation->title ?? '') }}" required>
                    </div>
                    <div>
                        <label class="form-label">Mô tả</label>
                        <input type="text" name="translations[{{ $language->id }}][description]" class="form-control" value="{{ old("translations.{$language->id}.description", $translation->description ?? '') }}">
                    </div>
                </div>
            @endforeach
        </div>
        <div class="form-check mb-4">
            <input type="checkbox" name="is_active" value="1" class="form-check-input" @checked(old('is_active', $benefit->is_active || !$benefit->exists))>
            <label class="form-check-label">Hiển thị trên website</label>
        </div>
        <button class="btn btn-admin-primary">Lưu nội dung</button>
    </form>
</div>
@endsection
