@extends('layouts.app')
@section('title', ($siteName ?? 'ZEK SHOP') . ' - Trang chủ')
@section('content')
<div class="home-page">
    @php
        $heroSlides = $banners->map(function ($banner) {
            $translation = $banner->translation();
            return [
                'eyebrow' => $translation?->eyebrow ?? $banner->eyebrow,
                'title' => $translation?->title ?? $banner->title,
                'description' => $translation?->description ?? $banner->description,
                'cta_text' => $translation?->cta_text ?? $banner->cta_text,
                'cta_link' => $translation?->resolved_link ?? $banner->resolved_link,
                'cta_type' => $banner->cta_type,
                'image' => $banner->image_url,
                'bg_class' => $banner->bg_class,
            ];
        })->all();
    @endphp
    {{-- HERO CAROUSEL --}}
    @include('home.banner', ['slides' => $heroSlides])
    
    {{-- ============================================= Cam kết cửa hàng ============================================ --}}
    @include('home.benefits', ['benefits' => $benefits])
    {{-- SẢN PHẨM NỔI BẬT --}}
    @include('home.featured_products')

    {{-- SẢN PHẨM BÁN CHẠY --}}
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

    {{-- SẢN PHẨM MỚI --}}
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

    {{-- LÝ DO NÊN CHỌN --}}
    <section class="why-section py-5">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-6">
                    <div class="section-heading section-heading-left mb-4">
                        <span class="why-eyebrow">Mua sắm an tâm</span>
                        <h2>LÝ DO NÊN CHỌN {{ strtoupper($siteName ?? 'ZEK SHOP') }}</h2>
                        <span class="heading-underline heading-underline-left"></span>
                    </div>
                    <div class="why-list">
                        @forelse($benefits as $benefit)
                        @php($translation = $benefit->translation())
                        <article class="why-item">
                            <span class="why-item-icon" aria-hidden="true">
                                <i class="{{ $benefit->icon ?: 'fas fa-check' }}"></i>
                            </span>
                            <div class="why-item-content">
                                <h3>{{ $translation?->title }}</h3>
                                @if($translation?->description)
                                    <p>{{ $translation->description }}</p>
                                @endif
                            </div>
                            <span class="why-item-arrow" aria-hidden="true"><i class="fas fa-arrow-right"></i></span>
                        </article>
                        @empty
                        <p class="text-muted">Chưa có thông tin cam kết.</p>
                        @endforelse
                    </div>
                </div>
                <div class="col-lg-6 text-center">
                    <div class="why-visual">
                        <span class="why-visual-orb why-visual-orb-one"></span>
                        <span class="why-visual-orb why-visual-orb-two"></span>
                        <img src="{{ asset('images/why-choose.png') }}" class="img-fluid" alt="Cam kết mua sắm an tâm"
                            onerror="this.style.display='none'">
                        <div class="why-visual-card">
                            <i class="fas fa-heart"></i>
                            <strong>An tâm lựa chọn</strong>
                            <span>Đồng hành cùng bạn trong mọi đơn hàng</span>
                        </div>
                    </div>
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

@push('scripts')
    <script>
        document.querySelectorAll('[data-product-carousel]').forEach((carousel) => {
            const controls = carousel.parentElement?.querySelectorAll('[data-carousel-direction]');
            controls?.forEach((control) => {
                control.addEventListener('click', () => {
                    const distance = carousel.clientWidth * 0.85;
                    carousel.scrollBy({
                        left: control.dataset.carouselDirection === 'next' ? distance : -distance,
                        behavior: 'smooth',
                    });
                });
            });
        });
    </script>
@endpush