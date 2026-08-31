@extends('admin.layouts.app')
@section('title', $product->exists ? 'Sua san pham' : 'Them san pham')
@section('content')
<form method="POST" action="{{ $product->exists ? route('admin.products.update', $product) : route('admin.products.store') }}" enctype="multipart/form-data" class="card shadow-sm p-4">
    @csrf
    @if ($product->exists) @method('PUT') @endif

    <div class="row g-3">
        <div class="col-md-8">
            <label class="form-label">Ten san pham</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $product->name) }}" required>
        </div>
        <div class="col-md-4">
            <label class="form-label">Danh muc</label>
            <select name="category_id" class="form-select">
                <option value="">-- Chon danh muc --</option>
                @foreach ($categories as $cat)
                    <option value="{{ $cat->id }}" @selected(old('category_id', $product->category_id) == $cat->id)>{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <label class="form-label">SKU</label>
            <input type="text" name="sku" class="form-control" value="{{ old('sku', $product->sku) }}">
        </div>
        <div class="col-md-4">
            <label class="form-label">Gia goc</label>
            <input type="number" step="0.01" name="price" class="form-control" value="{{ old('price', $product->price) }}" required>
        </div>
        <div class="col-md-4">
            <label class="form-label">Gia khuyen mai (neu co)</label>
            <input type="number" step="0.01" name="sale_price" class="form-control" value="{{ old('sale_price', $product->sale_price) }}">
        </div>
        <div class="col-md-4">
            <label class="form-label">Ton kho</label>
            <input type="number" name="stock" class="form-control" value="{{ old('stock', $product->stock) }}" required>
        </div>
        <div class="col-md-8">
            <label class="form-label">Anh dai dien</label>
            <input type="file" name="thumbnail" class="form-control">
            @if ($product->thumbnail)
                <img src="{{ asset('storage/'.$product->thumbnail) }}" class="mt-2 rounded" width="80">
            @endif
        </div>
        <div class="col-12">
            <label class="form-label">Mo ta</label>
            <textarea name="description" rows="4" class="form-control">{{ old('description', $product->description) }}</textarea>
        </div>
        <div class="col-12 form-check">
            <input type="checkbox" name="is_active" value="1" class="form-check-input" id="is_active" @checked(old('is_active', $product->is_active))>
            <label class="form-check-label" for="is_active">Hien thi tren website</label>
        </div>
    </div>

    <div class="mt-4">
        <button class="btn btn-primary">Luu</button>
        <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">Huy</a>
    </div>
</form>
@endsection
