@extends('shop.layouts.app')
@section('title', $product->name)
@section('content')
<div class="row g-4">
    <div class="col-md-5">
        <img src="{{ $product->thumbnail ? asset('storage/'.$product->thumbnail) : 'https://placehold.co/500x400?text=San+pham' }}" class="img-fluid rounded shadow-sm">
    </div>
    <div class="col-md-7">
        <h3>{{ $product->name }}</h3>
        <p class="text-muted">Danh muc: {{ $product->category->name ?? '-' }}</p>
        <div class="mb-3">
            @if ($product->sale_price)
                <span class="text-danger fs-3 fw-bold">{{ number_format($product->sale_price) }}₫</span>
                <span class="text-muted text-decoration-line-through ms-2">{{ number_format($product->price) }}₫</span>
            @else
                <span class="text-danger fs-3 fw-bold">{{ number_format($product->price) }}₫</span>
            @endif
        </div>
        <p>{{ $product->description }}</p>
        <p class="text-muted">Con lai: {{ $product->stock }} san pham</p>

        <form method="POST" action="{{ route('cart.add', $product) }}" class="d-flex gap-2 align-items-center">
            @csrf
            <input type="number" name="qty" value="1" min="1" max="{{ $product->stock }}" class="form-control" style="max-width:100px">
            <button class="btn btn-primary" @disabled($product->stock < 1)>
                <i class="bi bi-cart-plus"></i> {{ $product->stock < 1 ? 'Het hang' : 'Them vao gio hang' }}
            </button>
        </form>
    </div>
</div>

@if ($related->count())
<h5 class="mt-5 mb-3">San pham lien quan</h5>
<div class="row g-3">
    @foreach ($related as $item)
        <div class="col-6 col-lg-3">
            <div class="card product-card h-100 shadow-sm">
                <img src="{{ $item->thumbnail ? asset('storage/'.$item->thumbnail) : 'https://placehold.co/400x300?text=San+pham' }}" class="card-img-top">
                <div class="card-body">
                    <h6 class="card-title">{{ $item->name }}</h6>
                    <p class="text-danger fw-bold mb-2">{{ number_format($item->final_price) }}₫</p>
                    <a href="{{ route('products.show', $item->slug) }}" class="btn btn-sm btn-outline-primary w-100">Xem chi tiet</a>
                </div>
            </div>
        </div>
    @endforeach
</div>
@endif
@endsection
