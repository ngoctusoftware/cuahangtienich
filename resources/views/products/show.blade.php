@extends('layouts.app')

@section('title', ($product->translation()?->name ?? 'Sản phẩm') . ' - ' . ($siteName ?? 'ZEK SHOP'))
@section('meta_description', $product->translation()?->meta_description)

@section('content')
<div class="container py-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('products.byCategory', $product->category->translation()?->slug) }}">{{ $product->category->translation()?->name }}</a></li>
            <li class="breadcrumb-item active">{{ $product->translation()?->name }}</li>
        </ol>
    </nav>

    <div class="row g-5">
        <div class="col-lg-6">
            <div class="product-gallery">
                <img id="mainImage" src="{{ $product->thumbnail ? asset('storage/'.$product->thumbnail) : asset('images/product-placeholder.jpg') }}" class="img-fluid rounded mb-3 main-image">
                <div class="d-flex gap-2 flex-wrap">
                    @foreach($product->images as $img)
                        <img src="{{ asset('storage/'.$img->path) }}" class="thumb-image" onclick="document.getElementById('mainImage').src=this.src">
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <h1 class="product-title">{{ $product->translation()?->name }}</h1>
            <p class="text-muted">SKU: {{ $product->sku }}</p>
            <div class="product-price-detail mb-3">
                @if($product->sale_price)
                    <span class="price-sale fs-3">{{ number_format($product->sale_price) }}₫</span>
                    <span class="price-old fs-5">{{ number_format($product->price) }}₫</span>
                @else
                    <span class="price-sale fs-3">{{ number_format($product->price) }}₫</span>
                @endif
            </div>
            <p>{{ $product->translation()?->short_description }}</p>

            <form action="{{ route('cart.add') }}" method="POST" class="d-flex align-items-center gap-3 my-4">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}" class="form-control" style="width: 90px">
                <button type="submit" class="btn btn-hero-cta">
                    <i class="fas fa-cart-plus"></i> Thêm vào giỏ hàng
                </button>
            </form>

            <p class="text-success"><i class="fas fa-check"></i> Còn hàng ({{ $product->stock }} sản phẩm)</p>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-lg-9">
            <h4>Mô tả chi tiết</h4>
            <div class="product-description">
                {!! $product->translation()?->description !!}
            </div>
        </div>
    </div>
</div>
@endsection
