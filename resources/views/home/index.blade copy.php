@extends('layouts.app')

@section('title', ($siteName ?? 'ZEK SHOP') . ' - Trang chủ')

@push('styles')
<style>
    .home-page {
        --home-ink: #172033;
        --home-muted: #697386;
        --home-primary: #6d28d9;
        --home-secondary: #ec4899;
        background: #fbfbfe;
        color: var(--home-ink);
    }

    .home-page .products-section,
    .home-page .why-section,
    .home-page .testimonial-section,
    .home-page .news-section {
        padding: 88px 0 !important;
    }

    .home-page .section-heading {
        max-width: 680px;
        margin-left: auto;
        margin-right: auto;
    }

    .home-page .section-heading h2 {
        color: var(--home-ink);
        font-size: clamp(1.65rem, 2.5vw, 2.35rem);
        font-weight: 800;
        letter-spacing: -.04em;
        margin-bottom: 14px;
    }

    .home-page .section-heading p {
        color: var(--home-muted);
        font-size: 1.05rem;
        margin-bottom: 0;
    }

    .home-page .heading-underline {
        background: linear-gradient(90deg, var(--home-primary), var(--home-secondary));
        border-radius: 999px;
        display: block;
        height: 4px;
        margin: 0 auto;
        width: 64px;
    }

    .home-page .section-heading-left {
        margin-left: 0;
        margin-right: 0;
        text-align: left;
    }

    .home-page .section-heading-left .heading-underline {
        margin-left: 0;
    }

    .home-benefits {
        background: #fff;
        border-bottom: 1px solid #eeeafe;
        border-top: 1px solid #eeeafe;
    }

    .home-benefit {
        align-items: center;
        display: flex;
        gap: 14px;
        height: 100%;
        padding: 22px 18px;
    }

    .home-benefit-icon {
        align-items: center;
        background: #f1eaff;
        border-radius: 16px;
        color: var(--home-primary);
        display: inline-flex;
        flex: 0 0 46px;
        font-size: 1.1rem;
        height: 46px;
        justify-content: center;
        width: 46px;
    }

    .home-benefit strong {
        display: block;
        font-size: .95rem;
        margin-bottom: 3px;
    }

    .home-benefit span {
        color: var(--home-muted);
        font-size: .82rem;
    }

    .home-page .bg-light {
        background: #f5f3ff !important;
    }

    .home-page .product-card,
    .home-page .testimonial-card,
    .home-page .news-card {
        background: #fff;
        border: 1px solid #eeeaf7;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(42, 25, 86, .06);
        overflow: hidden;
        transition: transform .25s ease, box-shadow .25s ease;
    }

    .home-page .product-card:hover,
    .home-page .testimonial-card:hover,
    .home-page .news-card:hover {
        box-shadow: 0 18px 40px rgba(42, 25, 86, .12);
        transform: translateY(-5px);
    }

    .home-page .product-info {
        padding: 18px;
    }

    .home-page .btn-add-cart {
        border-radius: 10px;
        font-weight: 700;
    }

    .home-page .why-section {
        background: #fff;
    }

    .home-page .why-list {
        display: grid;
        gap: 14px;
        list-style: none;
        margin: 28px 0 0;
        padding: 0;
    }

    .home-page .why-list li {
        align-items: center;
        background: #faf9ff;
        border: 1px solid #eeeaf7;
        border-radius: 14px;
        display: flex;
        gap: 12px;
        padding: 14px 16px;
    }

    .home-page .why-list i {
        color: #16a06a;
        font-size: 1.05rem;
    }

    .home-page .testimonial-card,
    .home-page .news-card {
        padding: 26px;
    }

    .home-page .quote-icon {
        color: #c9b5ff;
        font-size: 1.4rem;
    }

    .home-page .cta-section {
        background: linear-gradient(115deg, #25105c, #6d28d9 55%, #ec4899);
        padding: 76px 0 !important;
    }

    .home-page .cta-section h2 {
        font-size: clamp(1.65rem, 3vw, 2.5rem);
        font-weight: 800;
        letter-spacing: -.04em;
    }

    .home-page .btn-hero-cta {
        border-radius: 999px;
        font-weight: 800;
        padding: 13px 26px;
    }

    @media (max-width: 767.98px) {
        .home-page .products-section,
        .home-page .why-section,
        .home-page .testimonial-section,
        .home-page .news-section {
            padding: 58px 0 !important;
        }

        .home-benefit {
            padding: 14px 8px;
        }
    }
</style>
@endpush

@section('content')
<div class="home-page">
    <?php
        $heroSlides = [
            [
                'eyebrow' => 'MUA SẮM THÔNG MINH · SỐNG TRỌN NIỀM VUI',
                'title' => 'GIẢI PHÁP MUA SẮM<br>TOÀN DIỆN CHO BẠN',
                'description' => 'ZEK SHOP mang đến hàng ngàn sản phẩm chất lượng với mức giá tốt nhất, giao hàng nhanh toàn quốc, hỗ trợ đổi trả và thanh toán linh hoạt.',
                'cta_text' => 'MUA SẮM NGAY',
                'cta_link' => route('products.newest'),
                'image' => asset('images/banner/inet.jpeg'),
                'bg_class' => 'bg-slide-1',
            ],
            [
                'eyebrow' => 'ƯU ĐÃI ĐỘC QUYỀN · SỐ LƯỢNG CÓ HẠN',
                'title' => 'FLASH SALE 9/9<br>GIẢM ĐẾN 60%',
                'description' => 'Săn deal khủng dịp 9/9, hàng ngàn sản phẩm giảm giá sốc, số lượng có hạn, nhanh tay đặt hàng ngay hôm nay.',
                'cta_text' => 'ĐĂNG KÝ NGAY',
                'cta_link' => route('products.bestseller'),
                'image' => asset('images/banner/cloudfly.png'),
                'bg_class' => 'bg-slide-2',
            ],
        ];
    ?>
    {{-- HERO CAROUSEL --}}
    @include('home.banner', ['slides' => $heroSlides])

    <section class="home-benefits" aria-label="Cam kết của cửa hàng">
        <div class="container">
            <div class="row g-0">
                <div class="col-md-3 col-6">
                    <div class="home-benefit">
                        <span class="home-benefit-icon"><i class="fas fa-shield-halved"></i></span>
                        <div><strong>Hàng chính hãng</strong><span>An tâm chọn mua</span></div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="home-benefit">
                        <span class="home-benefit-icon"><i class="fas fa-truck-fast"></i></span>
                        <div><strong>Giao hàng nhanh</strong><span>Toàn quốc mỗi ngày</span></div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="home-benefit">
                        <span class="home-benefit-icon"><i class="fas fa-arrows-rotate"></i></span>
                        <div><strong>Đổi trả dễ dàng</strong><span>Hỗ trợ trong 7 ngày</span></div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="home-benefit">
                        <span class="home-benefit-icon"><i class="fas fa-headset"></i></span>
                        <div><strong>Hỗ trợ tận tâm</strong><span>Luôn sẵn sàng 24/7</span></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- SẢN PHẨM NỔI BẬT --}}
    <section class="products-section py-5">
        <div class="container">
            <div class="section-heading text-center mb-5">
                <span class="d-block text-uppercase fw-bold text-primary small mb-2">Được yêu thích nhất</span>
                <h2>SẢN PHẨM NỔI BẬT</h2>
                <p>Những lựa chọn được khách hàng tin yêu và săn đón mỗi ngày.</p>
                <span class="heading-underline"></span>
            </div>
            <div class="row g-4">
                @forelse(($featured ?? []) as $product)
                    @include('products.partials.card', ['product' => $product])
                @empty
                    <p class="text-center text-muted">Chưa có sản phẩm nổi bật.</p>
                @endforelse
            </div>
        </div>
    </section>

    {{-- SẢN PHẨM BÁN CHẠY --}}
    <section class="products-section bg-light py-5">
        <div class="container">
            <div class="section-heading text-center mb-5">
                <h2>SẢN PHẨM BÁN CHẠY</h2>
                <p>Top sản phẩm đang tạo nên xu hướng mới nhất.</p>
                <span class="heading-underline"></span>
            </div>
            <div class="row g-4">
                @forelse(($bestseller ?? []) as $product)
                    @include('products.partials.card', ['product' => $product])
                @empty
                    <p class="text-center text-muted">Chưa có sản phẩm bán chạy.</p>
                @endforelse
            </div>
            <div class="text-center mt-4">
                <a href="{{ route('products.bestseller') }}" class="btn btn-outline-primary">Xem tất cả</a>
            </div>
        </div>
    </section>

    {{-- SẢN PHẨM MỚI --}}
    <section class="products-section py-5">
        <div class="container">
            <div class="section-heading text-center mb-5">
                <h2>SẢN PHẨM MỚI VỀ</h2>
                <p>Khám phá những sản phẩm mới nhất vừa cập bến tại {{ $siteName ?? 'ZEK SHOP' }}.</p>
                <span class="heading-underline"></span>
            </div>
            <div class="row g-4">
                @forelse(($newest ?? []) as $product)
                    @include('products.partials.card', ['product' => $product])
                @empty
                    <p class="text-center text-muted">Chưa có sản phẩm mới.</p>
                @endforelse
            </div>
        </div>
    </section>

    {{-- LÝ DO NÊN CHỌN --}}
    <section class="why-section py-5">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-6">
                    <div class="section-heading section-heading-left mb-4">
                        <span class="d-block text-uppercase fw-bold text-primary small mb-2">Mua sắm an tâm</span>
                        <h2>LÝ DO NÊN CHỌN {{ strtoupper($siteName ?? 'ZEK SHOP') }}</h2>
                        <span class="heading-underline heading-underline-left"></span>
                    </div>
                    <ul class="why-list">
                        <li><i class="fas fa-check-circle"></i> Sản phẩm chính hãng, cam kết chất lượng</li>
                        <li><i class="fas fa-check-circle"></i> Giao hàng nhanh toàn quốc, kiểm tra trước khi thanh toán
                        </li>
                        <li><i class="fas fa-check-circle"></i> Hỗ trợ đổi trả trong 7 ngày</li>
                        <li><i class="fas fa-check-circle"></i> Đa dạng phương thức thanh toán: COD, chuyển khoản, online
                        </li>
                        <li><i class="fas fa-check-circle"></i> Đội ngũ chăm sóc khách hàng 24/7</li>
                    </ul>
                </div>
                <div class="col-lg-6 text-center">
                    <img src="{{ asset('images/why-choose.png') }}" class="img-fluid" alt=""
                        onerror="this.style.display='none'">
                </div>
            </div>
        </div>
    </section>

    {{-- TESTIMONIAL --}}
    <section class="testimonial-section bg-light py-5">
        <div class="container">
            <div class="section-heading text-center mb-5">
                <h2>KHÁCH HÀNG NÓI GÌ VỀ CHÚNG TÔI</h2>
                <p>Trải nghiệm thật, chia sẻ thật từ cộng đồng khách hàng.</p>
                <span class="heading-underline"></span>
            </div>
            <div class="row g-4">
                @foreach(($testimonials ?? []) as $t)
                    <div class="col-md-4">
                        <div class="testimonial-card">
                            <i class="fas fa-quote-left quote-icon"></i>
                            <p>{{ $t['content'] }}</p>
                            <div class="d-flex align-items-center mt-3">
                                <img src="{{ $t['avatar'] }}" class="rounded-circle" width="48" height="48"
                                    onerror="this.style.display='none'">
                                <div class="ms-2">
                                    <strong>{{ $t['name'] }}</strong>
                                    <div class="text-muted small">{{ $t['role'] }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- CTA LIÊN HỆ --}}
    <section class="cta-section py-5">
        <div class="container text-center">
            <h2 class="text-white mb-3">NHẬN ƯU ĐÃI ĐẶC BIỆT CHO ĐƠN HÀNG ĐẦU TIÊN</h2>
            <p class="text-white-50 mb-4">Đăng ký nhận bản tin để không bỏ lỡ các chương trình khuyến mãi hấp dẫn.</p>
            <a href="{{ route('products.newest') }}" class="btn btn-hero-cta">MUA SẮM NGAY</a>
        </div>
    </section>

    {{-- TIN TỨC --}}
    <section class="news-section py-5">
        <div class="container">
            <div class="section-heading text-center mb-5">
                <h2>TIN TỨC & KHUYẾN MÃI</h2>
                <p>Cập nhật ưu đãi và những thông tin hữu ích dành riêng cho bạn.</p>
                <span class="heading-underline"></span>
            </div>
            <div class="row g-4">
                @foreach(($news ?? []) as $item)
                    <div class="col-md-4">
                        <div class="news-card">
                            <img src="{{ $item->image ? asset('images/' . $item->image) : asset('images/news-placeholder.jpg') }}"
                                class="img-fluid rounded" alt="">
                            <h5 class="mt-3">{{ $item->translation()?->title }}</h5>
                            <small class="text-muted">{{ $item->created_at->format('d/m/Y') }}</small>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
</div>

@endsection