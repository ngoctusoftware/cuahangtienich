@extends('shop.layouts.app')
@section('title', 'Trang chu')
@section('content')

<section class="hero">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-7">
                <div class="hero-dates">
                    <i class="bi bi-calendar-event"></i> 19/08 – 05/09/2026
                </div>
                <h1 class="display-title">Chào khai giảng,<br>tiếp hành trang</h1>
                <p class="lede">Ưu đãi đặc biệt mừng năm học 2026-2027 cho các chương trình ôn luyện toàn diện của TAK12 — món quà tiếp thêm tự tin cho các em vào năm học mới.</p>

                <div class="hero-promo">
                    <span class="promo-line1">Áp dụng toàn bộ chương trình</span>
                    <span class="promo-line2">Mua 1 tặng 1</span>
                </div>

                <div class="hero-offers">
                    <a href="https://tak12.com/info/vao-6" class="offer-item">
                        <i class="bi bi-mortarboard"></i>
                        <span>Ôn thi vào 6 — <strong>tặng TOEFL Primary</strong></span>
                    </a>
                    <a href="https://tak12.com/info/hoc-tot" class="offer-item">
                        <i class="bi bi-book"></i>
                        <span>Học tốt Tiếng Anh & Toán — <strong>tặng azVocab</strong></span>
                    </a>
                </div>

                <div>
                    <a class="btn btn-cta" target="_blank" href="https://tak12.com/news/n/2470/mua-1-tang-1-chao-khai-giang-tang-toefl-primary-azvocab/?ref=ttc7mm">
                        <i class="bi bi-bag-check"></i> Xem ưu đãi
                    </a>
                    <a href="https://tak12.com/?ref=ttc7mm" target="_blank" class="btn btn-cta bg-success">
                        <i class="bi bi-list"></i>
                        Xem tất cả khóa học
                    </a>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="hero-media">
                    <img src="{{ asset('/assets/images/KM_TAK12.png') }}" class="hero-img img-fluid" alt="Học sinh TAK12 chào năm học mới">
                    <div class="hero-badge">
                        <span style="font-size:.65rem;">ƯU ĐÃI ĐẾN</span>
                        <span style="font-size:1.15rem;">05/09</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-4">
    <div class="container">
        <div class="row g-3">
            @foreach ($categories->take(3) as $i => $cat)
                <div class="col-md-4">
                    <a href="{{ route('products.index', ['category'=>$cat->slug]) }}" class="feature-box d-block">
                        <img src="https://placehold.co/400x225/f7b500/ffffff?text={{ urlencode($cat->name) }}" alt="{{ $cat->name }}">
                        <div class="caption">{{ $cat->name }}</div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>

<section class="shop-section">
    <div class="container">
        <div class="section-heading">
            <h2>San pham cua chung toi</h2>
            <div class="rule"></div>
            <p class="mb-0">Nhung san pham ban chay, duoc yeu thich nhat tai ShopOnline</p>
        </div>

        <div class="row g-4">
            @foreach ($featuredProducts as $product)
                <div class="col-6 col-md-4 col-lg-3">
                    @include('shop.products._card', ['product' => $product])
                </div>
            @endforeach
        </div>

        <div class="text-center mt-4">
            <a href="{{ route('products.index') }}" class="btn-more">Xem them</a>
        </div>
    </div>
</section>

@foreach ($categories as $index => $cat)
    @php
        $catProducts = $cat->products()->active()->take(4)->get();
    @endphp
    @continue($catProducts->isEmpty())
    <section class="shop-section {{ $index % 2 === 0 ? 'alt' : 'tinted' }}">
        <div class="container">
            <div class="section-heading {{ $index % 2 !== 0 ? 'on-dark' : '' }}">
                <h2>San pham {{ $cat->name }}</h2>
                <div class="rule"></div>
                <p class="mb-0">Nhung san pham noi bat trong danh muc {{ $cat->name }}</p>
            </div>
            <div class="row g-4">
                @foreach ($catProducts as $product)
                    <div class="col-6 col-md-3">
                        @include('shop.products._card', ['product' => $product])
                    </div>
                @endforeach
            </div>
            <div class="text-center mt-4">
                <a href="{{ route('products.index', ['category'=>$cat->slug]) }}" class="btn-more">Xem them</a>
            </div>
        </div>
    </section>
@endforeach
@endsection
