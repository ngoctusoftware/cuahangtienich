@extends('layouts.app')

@section('title', ($siteName ?? 'ZEK SHOP') . ' - Trang chủ')

@section('content')
    <?php 
        $heroSlides = [
        [
            'title' => 'GIẢI PHÁP MUA SẮM<br>TOÀN DIỆN CHO BẠN',
            'description' => 'ZEK SHOP mang đến hàng ngàn sản phẩm chất lượng với mức giá tốt nhất, giao hàng nhanh toàn quốc, hỗ trợ đổi trả và thanh toán linh hoạt.',
            'cta_text' => 'MUA SẮM NGAY',
            // 'cta_link' => route('products.newest'),
            'image' => asset('images/banner/inet.jpeg'),
            'bg_class' => 'bg-slide-1',
        ],      
        [
            'title' => 'FLASH SALE 9/9<br>GIẢM ĐẾN 60%',
            'description' => 'Săn deal khủng dịp 9/9, hàng ngàn sản phẩm giảm giá sốc, số lượng có hạn, nhanh tay đặt hàng ngay hôm nay.',
            'cta_text' => 'ĐĂNG KÝ NGAY',
            // 'cta_link' => route('promotions.flashsale'),
            'image' => asset('images/banner/cloudfly.png'),
            'bg_class' => 'bg-slide-2',
        ],
    ];
            ?>
    {{-- HERO CAROUSEL --}}
    {{-- @include('home.banner') --}}
    @include('home.banner', ['slides' => $heroSlides])

    {{-- ĐƯỢC TIN TƯỞNG BỞI --}}
    <section class="trusted-section py-4">
        <div class="container">
            <h6 class="text-uppercase text-center fw-bold mb-4">Được khách hàng tin tưởng</h6>
            <div class="d-flex flex-wrap justify-content-center align-items-center gap-5 brand-logos">
                @for ($i = 1; $i <= 8; $i++)
                    <img src="{{ asset('images/brands/brand-' . $i . '.png') }}" alt="brand" height="36"
                        onerror="this.remove()">
                @endfor
            </div>
        </div>
    </section>

    {{-- SẢN PHẨM NỔI BẬT --}}
    <section class="products-section py-5">
        <div class="container">
            <div class="section-heading text-center mb-5">
                <h2>SẢN PHẨM NỔI BẬT</h2>
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
                    <div class="section-heading mb-4">
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
                <span class="heading-underline"></span>
            </div>
            <div class="row g-4">
                @foreach(($news ?? []) as $item)
                    <div class="col-md-4">
                        <div class="news-card">
                            <img src="{{ $item->image ? asset('storage/' . $item->image) : asset('images/news-placeholder.jpg') }}"
                                class="img-fluid rounded" alt="">
                            <h5 class="mt-3">{{ $item->translation()?->title }}</h5>
                            <small class="text-muted">{{ $item->created_at->format('d/m/Y') }}</small>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

@endsection