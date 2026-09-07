@extends('admin.layouts.app')
@section('title', $product->exists ? 'Sửa sản phẩm' : 'Thêm sản phẩm')
@section('content')
<div class="form-card">
    <h4 class="mb-4">{{ $product->exists ? 'Sửa sản phẩm' : 'Thêm sản phẩm' }}</h4>
    <form action="{{ $product->exists ? route('admin.products.update', $product) : route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if($product->exists) @method('PUT') @endif

        <ul class="nav nav-tabs mb-3">
            @foreach($languages as $i => $lang)
                <li class="nav-item">
                    <button type="button" class="nav-link {{ $i === 0 ? 'active' : '' }}" data-bs-toggle="tab" data-bs-target="#lang-{{ $lang->id }}">{{ $lang->name }}</button>
                </li>
            @endforeach
        </ul>
        <div class="tab-content mb-4">
            @foreach($languages as $i => $lang)
                @php $trans = $product->translations->firstWhere('language_id', $lang->id); @endphp
                <div class="tab-pane fade {{ $i === 0 ? 'show active' : '' }}" id="lang-{{ $lang->id }}">
                    <div class="mb-3">
                        <label class="form-label">Tên sản phẩm ({{ $lang->name }})</label>
                        <input type="text" name="translations[{{ $lang->id }}][name]" class="form-control" value="{{ old("translations.{$lang->id}.name", $trans->name ?? '') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Mô tả ngắn</label>
                        <textarea name="translations[{{ $lang->id }}][short_description]" class="form-control" rows="2">{{ old("translations.{$lang->id}.short_description", $trans->short_description ?? '') }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Mô tả chi tiết</label>
                        <textarea name="translations[{{ $lang->id }}][description]" class="form-control" rows="6">{{ old("translations.{$lang->id}.description", $trans->description ?? '') }}</textarea>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label">Danh mục</label>
                <select name="category_id" class="form-select" required>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->translation()?->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">Mã SKU</label>
                <input type="text" name="sku" class="form-control" value="{{ old('sku', $product->sku) }}" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Ảnh đại diện</label>
                <input type="file" name="thumbnail" class="form-control">
            </div>
            <div class="col-md-4">
                <label class="form-label">Giá gốc</label>
                <input type="number" name="price" class="form-control" value="{{ old('price', $product->price) }}" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Giá khuyến mãi</label>
                <input type="number" name="sale_price" class="form-control" value="{{ old('sale_price', $product->sale_price) }}">
            </div>
            <div class="col-md-4">
                <label class="form-label">Tồn kho</label>
                <input type="number" name="stock" class="form-control" value="{{ old('stock', $product->stock) }}">
            </div>
            <div class="col-md-4">
                <div class="form-check">
                    <input type="checkbox" name="is_featured" value="1" class="form-check-input" {{ $product->is_featured ? 'checked' : '' }}>
                    <label class="form-check-label">Sản phẩm nổi bật</label>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-check">
                    <input type="checkbox" name="is_bestseller" value="1" class="form-check-input" {{ $product->is_bestseller ? 'checked' : '' }}>
                    <label class="form-check-label">Sản phẩm bán chạy</label>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-check">
                    <input type="checkbox" name="is_active" value="1" class="form-check-input" {{ $product->is_active || !$product->exists ? 'checked' : '' }}>
                    <label class="form-check-label">Kích hoạt</label>
                </div>
            </div>
        </div>
        <button class="btn btn-admin-primary mt-4">Lưu sản phẩm</button>
    </form>
</div>
@endsection
