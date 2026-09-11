@php($translation = $product->translation())

<div class="col-lg-3 col-md-4 col-6">
    <div class="product-card">
        <a @if($translation) href="{{ route('products.show', ['slug' => $translation->slug]) }}" @endif class="product-thumb">
            <img src="{{ $product->thumbnail_url }}"
                 class="img-fluid" alt="{{ $translation?->name }}">
            @if($product->sale_price)
                <span class="badge-sale">
                    -{{ round((1 - $product->sale_price / $product->price) * 100) }}%
                </span>
            @endif
        </a>
        <div class="product-info">
            <h6 class="product-name">
                <a @if($translation) href="{{ route('products.show', ['slug' => $translation->slug]) }}" @endif>{{ $translation?->name }}</a>
            </h6>
            <div class="product-price">
                @if($product->sale_price)
                    <span class="price-sale">{{ number_format($product->sale_price) }}₫</span>
                    <span class="price-old">{{ number_format($product->price) }}₫</span>
                @else
                    <span class="price-sale">{{ number_format($product->price) }}₫</span>
                @endif
            </div>
            <form action="{{ route('cart.add') }}" method="POST" class="mt-2">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <button type="submit" class="btn btn-add-cart w-100">
                    <i class="fas fa-cart-plus"></i> Thêm vào giỏ
                </button>
            </form>
        </div>
    </div>
</div>
