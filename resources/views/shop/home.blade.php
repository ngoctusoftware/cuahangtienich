@extends('shop.layouts.app')
@section('title', 'Trang chu')
@section('content')

<div class="p-5 mb-4 bg-primary bg-gradient text-white rounded-3">
    <h1 class="display-6 fw-bold">Chao mung den voi ShopOnline</h1>
    <p class="col-md-8 fs-5">Mua sam thoi trang, dien tu, phu kien... voi gia tot nhat, giao hang nhanh, thanh toan online tien loi.</p>
    <a href="{{ route('products.index') }}" class="btn btn-light btn-lg">Xem san pham <i class="bi bi-arrow-right"></i></a>
</div>

<h4 class="mb-3">Danh muc</h4>
<div class="row g-3 mb-5">
    @foreach ($categories as $cat)
        <div class="col-6 col-md-3">
            <a href="{{ route('products.index', ['category' => $cat->slug]) }}" class="text-decoration-none">
                <div class="card text-center py-4 h-100 shadow-sm">
                    <i class="bi bi-grid fs-2 text-primary"></i>
                    <div class="mt-2 text-dark">{{ $cat->name }}</div>
                </div>
            </a>
        </div>
    @endforeach
</div>

<h4 class="mb-3">San pham noi bat</h4>
<div class="row g-3">
    @foreach ($featuredProducts as $product)
        <div class="col-6 col-md-3">
            <div class="card product-card h-100 shadow-sm">
                <img src="{{ $product->thumbnail ? asset('storage/'.$product->thumbnail) : 'https://placehold.co/400x300?text=San+pham' }}" class="card-img-top">
                <div class="card-body">
                    <h6 class="card-title">{{ $product->name }}</h6>
                    <p class="text-danger fw-bold mb-2">{{ number_format($product->final_price) }}₫</p>
                    <a href="{{ route('products.show', $product->slug) }}" class="btn btn-sm btn-outline-primary w-100">Xem chi tiet</a>
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection
