@extends('shop.layouts.app')
@section('title', $product->name)
@section('content')
@php
    $hasSale = $product->sale_price && $product->sale_price < $product->price;
    $discount = $hasSale ? round((1 - ($product->sale_price / $product->price)) * 100) : null;
@endphp
<section class="shop-section">
<div class="container">
<div class="row g-4 bg-white rounded-4 p-4 shadow-sm">
    <div class="col-md-5">
        <div class="position-relative">
            @if ($hasSale)
                <div class="badge-discount">-{{ $discount }}%</div>
            @endif
            <img src="{{ $product->thumbnail ? asset('storage/'.$product->thumbnail) : 'https://placehold.co/500x400/fdeee8/d6394a?text='.urlencode($product->name) }}" class="img-fluid rounded-3">
        </div>
    </div>
    <div class="col-md-7">
        <h3 class="display-title">{{ $product->name }}</h3>
        <p class="text-muted">Danh muc: {{ $product->category->name ?? '-' }}</p>
        <div class="mb-3">
            @if ($hasSale)
                <span class="price-new fs-3">{{ number_format($product->sale_price) }}₫</span>
                <span class="price-old fs-5 ms-2">{{ number_format($product->price) }}₫</span>
            @else
                <span class="price-new fs-3">{{ number_format($product->price) }}₫</span>
            @endif
        </div>
        <p>{{ $product->description }}</p>
        <p class="text-muted">Con lai: {{ $product->stock }} san pham</p>

        <form method="POST" action="{{ route('cart.add', $product) }}" class="d-flex gap-2 align-items-center">
            @csrf
            <input type="number" name="qty" value="1" min="1" max="{{ $product->stock }}" class="form-control" style="max-width:100px">
            <button class="btn btn-buy" style="max-width:260px;" @disabled($product->stock < 1)>
                <i class="bi bi-cart-plus"></i> {{ $product->stock < 1 ? 'Het hang' : 'Them vao gio hang' }}
            </button>
        </form>
    </div>
</div>

@if ($related->count())
<div class="section-heading mt-5">
    <h2>San pham lien quan</h2>
    <div class="rule"></div>
</div>
<div class="row g-4">
    @foreach ($related as $item)
        <div class="col-6 col-lg-3">
            @include('shop.products._card', ['product' => $item])
        </div>
    @endforeach
</div>
@endif
</div>
</section>
@endsection
