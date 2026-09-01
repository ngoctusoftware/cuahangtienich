@php
    $hasSale = $product->sale_price && $product->sale_price < $product->price;
    $discount = $hasSale ? round((1 - ($product->sale_price / $product->price)) * 100) : null;
@endphp
<div class="product-card h-100">
    @if ($hasSale)
        <div class="badge-discount">-{{ $discount }}%</div>
    @endif
    <a href="{{ route('products.show', $product->slug) }}" class="card-img-wrap d-block">
        <img src="{{ $product->thumbnail ? asset('storage/'.$product->thumbnail) : 'https://placehold.co/400x400/fdeee8/d6394a?text='.urlencode($product->name) }}" alt="{{ $product->name }}">
    </a>
    <div class="card-body">
        <a href="{{ route('products.show', $product->slug) }}" class="product-name">{{ $product->name }}</a>
        <div class="mt-2">
            @if ($hasSale)
                <span class="price-old">{{ number_format($product->price) }}₫</span>
                <span class="price-new">{{ number_format($product->sale_price) }}₫</span>
            @else
                <span class="price-new">{{ number_format($product->price) }}₫</span>
            @endif
        </div>
        <form method="POST" action="{{ route('cart.add', $product) }}">
            @csrf
            <input type="hidden" name="qty" value="1">
            <button class="btn btn-buy" @disabled($product->stock < 1)>{{ $product->stock < 1 ? 'Het hang' : 'Mua ngay' }}</button>
        </form>
    </div>
</div>
