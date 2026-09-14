<section class="products-section py-5">
    <div class="container">
        <div class="d-flex align-items-end justify-content-between gap-3 mb-4">
            <div class="section-heading section-heading-left">
                <h2>SẢN PHẨM MỚI VỀ</h2>
                <p>Khám phá những sản phẩm mới nhất vừa cập bến tại {{ $siteName ?? 'ZEK SHOP' }}.</p>
                <span class="heading-underline"></span>
            </div>
        </div>
        <div class="home-product-carousel-wrapper">
            <div class="home-product-carousel" data-product-carousel>
                @forelse(($newest ?? []) as $product)
                    @include('products.partials.card', ['product' => $product])
                @empty
                    <p class="text-center text-muted">Chưa có sản phẩm mới.</p>
                @endforelse
            </div>
            <div class="home-product-carousel-controls" aria-label="Điều hướng sản phẩm mới">
                <button type="button" data-carousel-direction="prev" aria-label="Xem sản phẩm mới trước"><i
                        class="fas fa-chevron-left"></i></button>
                <button type="button" data-carousel-direction="next" aria-label="Xem sản phẩm mới tiếp theo"><i
                        class="fas fa-chevron-right"></i></button>
            </div>
        </div>
        <div class="d-flex justify-content-center mt-3">
            <a href="{{ route('products.newest') }}" class="btn btn-outline-primary">Xem tất cả sản phẩm mới</a>
        </div>
    </div>
</section>