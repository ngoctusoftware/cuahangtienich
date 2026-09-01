@extends('shop.layouts.app')
@section('title', 'San pham')
@section('content')
<section class="shop-section">
    <div class="container">
        <div class="section-heading">
            <h2>{{ request('q') ? 'Ket qua tim kiem: '.request('q') : 'Tat ca san pham' }}</h2>
            <div class="rule"></div>
        </div>

        <div class="d-flex flex-wrap gap-2 justify-content-center mb-4">
            <a href="{{ route('products.index') }}" class="cat-pill {{ !request('category') ? 'active' : '' }}">Tat ca</a>
            @foreach ($categories as $cat)
                <a href="{{ route('products.index', ['category'=>$cat->slug]) }}" class="cat-pill {{ request('category')===$cat->slug ? 'active' : '' }}">{{ $cat->name }}</a>
            @endforeach
        </div>

        <div class="row g-4">
            @forelse ($products as $product)
                <div class="col-6 col-md-4 col-lg-3">
                    @include('shop.products._card', ['product' => $product])
                </div>
            @empty
                <p class="text-center text-muted">Khong tim thay san pham nao.</p>
            @endforelse
        </div>
        <div class="mt-4 d-flex justify-content-center">{{ $products->links() }}</div>
    </div>
</section>
@endsection
