<section class="products-section bg-light py-5">
    <div class="container">
        <div class="d-flex align-items-end justify-content-between gap-3 mb-4">
            <div class="section-heading section-heading-left">
                <h2>SẢN PHẨM BÁN CHẠY</h2>
                <p>Top sản phẩm đang tạo nên xu hướng mới nhất.</p>
                <span class="heading-underline"></span>
            </div>
        </div>
        <div class="home-product-carousel-wrapper">
            <div class="home-product-carousel" data-product-carousel>
                @forelse(($bestseller ?? []) as $product)
                    @include('products.partials.card', ['product' => $product])
                @empty
                    <p class="text-center text-muted">Chưa có sản phẩm bán chạy.</p>
                @endforelse
            </div>
            <div class="home-product-carousel-controls" aria-label="Điều hướng sản phẩm bán chạy">
                <button type="button" data-carousel-direction="prev" aria-label="Xem sản phẩm bán chạy trước"><i
                        class="fas fa-chevron-left"></i></button>
                <button type="button" data-carousel-direction="next" aria-label="Xem sản phẩm bán chạy tiếp theo"><i
                        class="fas fa-chevron-right"></i></button>
            </div>
        </div>
        <div class="d-flex justify-content-center mt-3">
            <a href="{{ route('products.bestseller') }}" class="btn btn-outline-primary">Xem tất cả sản phẩm bán
                chạy</a>
        </div>
    </div>
</section>