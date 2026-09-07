@extends('admin.layouts.app')
@section('title', $category->exists ? 'Sửa danh mục' : 'Thêm danh mục')
@section('content')
<div class="form-card">
    <h4 class="mb-4">{{ $category->exists ? 'Sửa danh mục' : 'Thêm danh mục' }}</h4>
    <form action="{{ $category->exists ? route('admin.categories.update', $category) : route('admin.categories.store') }}" method="POST">
        @csrf
        @if($category->exists) @method('PUT') @endif

        {{-- Nhập tên/mô tả theo từng ngôn ngữ (tab) --}}
        <ul class="nav nav-tabs mb-3">
            @foreach($languages as $i => $lang)
                <li class="nav-item">
                    <button type="button" class="nav-link {{ $i === 0 ? 'active' : '' }}" data-bs-toggle="tab" data-bs-target="#lang-{{ $lang->id }}">{{ $lang->name }}</button>
                </li>
            @endforeach
        </ul>
        <div class="tab-content mb-4">
            @foreach($languages as $i => $lang)
                @php $trans = $category->translations->firstWhere('language_id', $lang->id); @endphp
                <div class="tab-pane fade {{ $i === 0 ? 'show active' : '' }}" id="lang-{{ $lang->id }}">
                    <div class="mb-3">
                        <label class="form-label">Tên danh mục ({{ $lang->name }})</label>
                        <input type="text" name="translations[{{ $lang->id }}][name]" class="form-control" value="{{ old("translations.{$lang->id}.name", $trans->name ?? '') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Mô tả</label>
                        <textarea name="translations[{{ $lang->id }}][description]" class="form-control" rows="3">{{ old("translations.{$lang->id}.description", $trans->description ?? '') }}</textarea>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Danh mục cha</label>
                <select name="parent_id" class="form-select">
                    <option value="">-- Không có --</option>
                    @foreach($parents as $p)
                        <option value="{{ $p->id }}" {{ old('parent_id', $category->parent_id) == $p->id ? 'selected' : '' }}>{{ $p->translation()?->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Thứ tự</label>
                <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $category->sort_order) }}">
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <div class="form-check">
                    <input type="checkbox" name="is_active" value="1" class="form-check-input" {{ $category->is_active || !$category->exists ? 'checked' : '' }}>
                    <label class="form-check-label">Kích hoạt</label>
                </div>
            </div>
        </div>
        <button class="btn btn-admin-primary mt-4">Lưu danh mục</button>
    </form>
</div>
@endsection
