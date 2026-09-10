@extends('admin.layouts.app')
@section('title', $menuItem->exists ? 'Sửa menu header' : 'Thêm menu header')
@section('content')
<div class="form-card">
    <h4 class="mb-4">{{ $menuItem->exists ? 'Sửa menu header' : 'Thêm menu header' }}</h4>
    <form action="{{ $menuItem->exists ? route('admin.header-menu.update', $menuItem) : route('admin.header-menu.store') }}" method="POST">
        @csrf
        @if($menuItem->exists) @method('PUT') @endif
        <div class="row g-3 mb-3">
            <div class="col-md-4">
                <label class="form-label">Key</label>
                <input type="text" name="key" class="form-control" value="{{ old('key', $menuItem->key) }}" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Icon Font Awesome (tuỳ chọn)</label>
                <input type="text" name="icon" class="form-control" placeholder="fas fa-home" value="{{ old('icon', $menuItem->icon) }}">
            </div>
            <div class="col-md-4">
                <label class="form-label">Thứ tự</label>
                <input type="number" name="sort_order" min="0" class="form-control" value="{{ old('sort_order', $menuItem->sort_order) }}" required>
            </div>
        </div>
        <div class="row g-3 mb-3">
            <div class="col-md-4">
                <label class="form-label">Kiểu liên kết</label>
                <select name="link_type" class="form-select">
                    <option value="route" @selected(old('link_type', $menuItem->link_type ?: 'route') === 'route')>Tên route</option>
                    <option value="url" @selected(old('link_type', $menuItem->link_type) === 'url')>URL</option>
                </select>
            </div>
            <div class="col-md-8">
                <label class="form-label">Giá trị liên kết</label>
                <input type="text" name="link_value" class="form-control" placeholder="home hoặc https://..." value="{{ old('link_value', $menuItem->link_value) }}">
            </div>
        </div>
        <div class="form-check mb-3">
            <input type="checkbox" name="is_category" value="1" class="form-check-input" @checked(old('is_category', $menuItem->is_category))>
            <label class="form-check-label">Là menu danh mục sản phẩm (hiển thị dropdown)</label>
        </div>
        <ul class="nav nav-tabs mb-3">
            @foreach($languages as $i => $lang)
                <li class="nav-item"><button type="button" class="nav-link @if($i === 0) active @endif" data-bs-toggle="tab" data-bs-target="#menu-lang-{{ $lang->id }}">{{ $lang->name }}</button></li>
            @endforeach
        </ul>
        <div class="tab-content mb-4">
            @foreach($languages as $i => $lang)
                @php $trans = $menuItem->translations->firstWhere('language_id', $lang->id); @endphp
                <div class="tab-pane fade @if($i === 0) show active @endif" id="menu-lang-{{ $lang->id }}">
                    <label class="form-label">Nhãn menu ({{ $lang->name }})</label>
                    <input type="text" name="translations[{{ $lang->id }}][label]" class="form-control" value="{{ old("translations.{$lang->id}.label", $trans->label ?? '') }}" required>
                </div>
            @endforeach
        </div>
        <div class="form-check mb-3">
            <input type="checkbox" name="is_active" value="1" class="form-check-input" @checked(old('is_active', $menuItem->is_active || !$menuItem->exists))>
            <label class="form-check-label">Hiển thị trên website</label>
        </div>
        <button class="btn btn-admin-primary">Lưu menu</button>
    </form>
</div>
@endsection
