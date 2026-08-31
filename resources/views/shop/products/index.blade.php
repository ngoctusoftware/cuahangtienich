@extends('shop.layouts.app')
@section('title', 'San pham')
@section('content')
<div class="row">
    <div class="col-md-3">
        <div class="card shadow-sm p-3">
            <h6>Danh muc</h6>
            <ul class="list-unstyled">
                <li class="mb-1"><a href="{{ route('products.index') }}" class="{{ !request('category') ? 'fw-bold' : '' }}">Tat ca</a></li>
                @foreach ($categories as $cat)
                    <li class="mb-1"><a href="{{ route('products.index', ['category'=>$cat->slug]) }}" class="{{ request('category')===$cat->slug ? 'fw-bold' : '' }}">{{ $cat->name }}</a></li>
                @endforeach
            </ul>
        </div>
    </div>
    <div class="col-md-9">
        <div class="row g-3">
            @forelse ($products as $product)
                <div class="col-6 col-lg-4">
                    <div class="card product-card h-100 shadow-sm">
                        <img src="{{ $product->thumbnail ? asset('storage/'.$product->thumbnail) : 'https://placehold.co/400x300?text=San+pham' }}" class="card-img-top">
                        <div class="card-body">
                            <h6 class="card-title">{{ $product->name }}</h6>
                            <p class="text-danger fw-bold mb-2">{{ number_format($product->final_price) }}₫</p>
                            <a href="{{ route('products.show', $product->slug) }}" class="btn btn-sm btn-outline-primary w-100">Xem chi tiet</a>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-muted">Khong tim thay san pham nao.</p>
            @endforelse
        </div>
        <div class="mt-4">{{ $products->links() }}</div>
    </div>
</div>
@endsection
