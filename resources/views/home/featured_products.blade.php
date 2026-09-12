    <section class="products-section py-5">
        <div class="container">
            <div class="d-flex align-items-end justify-content-between gap-3 mb-4">
                <div class="section-heading section-heading-left">
                    <span class="d-block text-uppercase fw-bold text-primary small mb-2">Được yêu thích nhất</span>
                    <h2>SẢN PHẨM NỔI BẬT</h2>
                    <p>Những lựa chọn được khách hàng tin yêu và săn đón mỗi ngày.</p>
                    <span class="heading-underline"></span>
                </div>
            </div>
            <div class="home-product-carousel-wrapper">
                <div class="home-product-carousel" data-product-carousel>
                    @forelse(($featured ?? []) as $product)
                        @include('products.partials.card', ['product' => $product])
                    @empty
                        <p class="text-center text-muted">Chưa có sản phẩm nổi bật.</p>
                    @endforelse
                </div>
                <div class="home-product-carousel-controls" aria-label="Điều hướng sản phẩm nổi bật">
                    <button type="button" data-carousel-direction="prev" aria-label="Xem sản phẩm nổi bật trước"><i
                            class="fas fa-chevron-left"></i></button>
                    <button type="button" data-carousel-direction="next" aria-label="Xem sản phẩm nổi bật tiếp theo"><i
                            class="fas fa-chevron-right"></i></button>
                </div>
            </div>
            <div class="d-flex justify-content-center mt-3">
                <a href="{{ route('products.featured') }}" class="btn btn-outline-primary">Xem tất cả sản phẩm nổi
                    bật</a>
            </div>
        </div>
    </section>