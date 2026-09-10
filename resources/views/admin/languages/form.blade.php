@extends('admin.layouts.app')
@section('title', $language->exists ? 'Sửa ngôn ngữ' : 'Thêm ngôn ngữ')
@section('content')
<div class="form-card">
    <h4 class="mb-4">{{ $language->exists ? 'Sửa ngôn ngữ' : 'Thêm ngôn ngữ' }}</h4>
    <form action="{{ $language->exists ? route('admin.languages.update', $language) : route('admin.languages.store') }}" method="POST">
        @csrf
        @if($language->exists) @method('PUT') @endif
        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label">Mã ngôn ngữ (vi, en, ja...)</label>
                <input type="text" name="code" class="form-control" value="{{ old('code', $language->code) }}" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Tên bản địa</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $language->name) }}" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Thứ tự</label>
                <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $language->sort_order) }}">
            </div>
            <div class="col-md-4">
                <label class="form-label">Tên tiếng Anh</label>
                <input type="text" name="name_en" class="form-control" value="{{ old('name_en', $language->name_en) }}">
            </div>
            <div class="col-md-4">
                <label class="form-label">Locale (vi-VN, en-US...)</label>
                <input type="text" name="locale" class="form-control" value="{{ old('locale', $language->locale) }}" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Hướng chữ</label>
                <select name="direction" class="form-select" required>
                    <option value="ltr" {{ old('direction', $language->direction ?: 'ltr') === 'ltr' ? 'selected' : '' }}>Trái sang phải (LTR)</option>
                    <option value="rtl" {{ old('direction', $language->direction) === 'rtl' ? 'selected' : '' }}>Phải sang trái (RTL)</option>
                </select>
            </div>
            <div class="col-md-6">
                <div class="form-check">
                    <input type="checkbox" name="is_default" value="1" class="form-check-input" {{ $language->is_default ? 'checked' : '' }}>
                    <label class="form-check-label">Ngôn ngữ mặc định</label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-check">
                    <input type="checkbox" name="is_active" value="1" class="form-check-input" {{ $language->is_active || !$language->exists ? 'checked' : '' }}>
                    <label class="form-check-label">Kích hoạt</label>
                </div>
            </div>
        </div>
        <button class="btn btn-admin-primary mt-4">Lưu</button>
    </form>
</div>
@endsection
