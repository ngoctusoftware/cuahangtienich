<section class="hero-carousel-section">
    <div id="heroCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="5000">

        {{-- Indicators --}}
        @if(count($slides) > 1)
        <div class="carousel-indicators hero-indicators">
            @foreach($slides as $index => $slide)
                <button type="button"
                        data-bs-target="#heroCarousel"
                        data-bs-slide-to="{{ $index }}"
                        class="{{ $index === 0 ? 'active' : '' }}"
                        aria-current="{{ $index === 0 ? 'true' : 'false' }}"
                        aria-label="Slide {{ $index + 1 }}"></button>
            @endforeach
        </div>
        @endif

        {{-- Slides --}}
        <div class="carousel-inner">
            @foreach($slides as $index => $slide)
                <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                    <div class="hero-slide {{ $slide['bg_class'] ?? '' }}">
                        {{-- Hoạ tiết trang trí: vòng tròn + chấm bi --}}
                        <span class="deco-ring deco-ring-1"></span>
                        <span class="deco-ring deco-ring-2"></span>
                        <span class="deco-ring deco-ring-3"></span>
                        <span class="deco-dots"></span>

                        <div class="container position-relative">
                            <div class="row align-items-center min-vh-hero">

                                {{-- CỘT TRÁI: Nội dung --}}
                                <div class="col-lg-6 col-12">
                                    <div class="hero-content">
                                        @if(!empty($slide['eyebrow']))
                                            <p class="hero-eyebrow">{{ $slide['eyebrow'] }}</p>
                                        @endif

                                        <h1 class="hero-title">
                                            {!! $slide['title'] !!}
                                        </h1>

                                        <p class="hero-desc">
                                            {{ $slide['description'] }}
                                        </p>

                                        @if(($slide['cta_type'] ?? 'link') === 'phone')
                                            <a href="{{ $slide['cta_link'] ?? 'tel:' }}" class="btn-hero-phone">
                                                <span class="btn-hero-phone-icon">
                                                    <i class="bi bi-telephone-fill"></i>
                                                </span>
                                                <span class="btn-hero-phone-text">{{ $slide['cta_text'] }}</span>
                                            </a>
                                        @else
                                            <a href="{{ $slide['cta_link'] ?? '#' }}" class="btn btn-hero-cta">
                                                {{ $slide['cta_text'] ?? 'MUA SẮM NGAY' }}
                                                <i class="bi bi-arrow-right ms-1"></i>
                                            </a>
                                        @endif
                                    </div>
                                </div>

                                {{-- CỘT PHẢI: Ảnh minh họa + bóng phản chiếu --}}
                                <div class="col-lg-6 col-12 text-center">
                                    <div class="hero-image-wrap">
                                        <img src="{{ $slide['image'] }}"
                                             class="hero-image-3d rounded-5"
                                             alt="{{ strip_tags($slide['title']) }}"
                                             onerror="this.closest('.hero-image-wrap').style.display='none'">
                                        <div class="hero-image-shadow"></div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Controls --}}
        @if(count($slides) > 1)
        <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
            <span class="hero-control-icon"><i class="bi bi-chevron-left"></i></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
            <span class="hero-control-icon"><i class="bi bi-chevron-right"></i></span>
            <span class="visually-hidden">Next</span>
        </button>
        @endif

    </div>
</section>

@push('styles')
<style>
    .hero-carousel-section {
        position: relative;
        overflow: hidden;
    }

    .min-vh-hero {
        min-height: 460px;
        padding: 50px 0;
        position: relative;
        z-index: 2;
    }

    .hero-slide {
        background: linear-gradient(120deg, #0b2f7a 0%, #1c62d6 45%, #33a3e8 100%);
        color: #fff;
        position: relative;
        overflow: hidden;
        height: 500px;
    }

    /* đổi màu nền cho từng slide nếu cần */
    .hero-slide.bg-slide-2 {
        background: linear-gradient(120deg, #071d54 0%, #144fc4 45%, #2f9ee0 100%);
        color: #fff;
    }

    /* ---------- HOẠ TIẾT TRANG TRÍ ---------- */
    .deco-ring {
        position: absolute;
        border: 2px solid rgba(255, 255, 255, .18);
        border-radius: 50%;
        z-index: 1;
        pointer-events: none;
    }

    .deco-ring-1 { width: 140px; height: 140px; top: -30px;  left: 6%; }
    .deco-ring-2 { width: 90px;  height: 90px;  bottom: 8%;  left: 16%; }
    .deco-ring-3 { width: 70px;  height: 70px;  bottom: -10px; left: 34%; }

    .deco-dots {
        position: absolute;
        width: 140px;
        height: 100px;
        left: 0;
        bottom: 0;
        background-image: radial-gradient(rgba(255,255,255,.25) 2px, transparent 2px);
        background-size: 14px 14px;
        opacity: .5;
        z-index: 1;
        pointer-events: none;
        -webkit-mask-image: radial-gradient(circle at 0% 100%, #000 60%, transparent 100%);
                mask-image: radial-gradient(circle at 0% 100%, #000 60%, transparent 100%);
    }

    /* ---------- CỘT TRÁI ---------- */
    .hero-content {
        max-width: 560px;
        position: relative;
        z-index: 2;
    }

    .hero-eyebrow {
        font-size: 1.4rem;
        font-weight: 700;
        letter-spacing: .5px;
        text-transform: uppercase;
        color: rgba(255, 255, 255, .92);
        margin-bottom: 4px;
    }

    .hero-title {
        font-size: 3.2rem;
        font-weight: 900;
        line-height: 1.15;
        margin-bottom: 18px;
        text-transform: uppercase;
        color: #ffffff;
        letter-spacing: .5px;
    }

    .hero-desc {
        font-size: 1.05rem;
        font-weight: 500;
        opacity: .92;
        margin-bottom: 30px;
        line-height: 1.6;
        max-width: 480px;
    }

    /* Nút CTA dạng link/text thường */
    .btn-hero-cta {
        display: inline-flex;
        align-items: center;
        background: #ffb600;
        color: #0d1b3d;
        font-weight: 700;
        padding: 14px 34px;
        border-radius: 50px;
        border: none;
        text-transform: uppercase;
        letter-spacing: .5px;
        transition: all .25s ease;
        box-shadow: 0 8px 20px rgba(255, 182, 0, .35);
    }

    .btn-hero-cta:hover {
        background: #ffd35c;
        color: #0d1b3d;
        transform: translateY(-3px);
        box-shadow: 0 12px 26px rgba(255, 182, 0, .45);
    }

    /* Nút CTA dạng pill số điện thoại (giống mẫu SEO) */
    .btn-hero-phone {
        display: inline-flex;
        align-items: center;
        gap: 14px;
        background: linear-gradient(90deg, #5b3df0 0%, #29c7f2 100%);
        color: #fff;
        padding: 8px 26px 8px 8px;
        border-radius: 50px;
        text-decoration: none;
        box-shadow: 0 10px 24px rgba(41, 199, 242, .35);
        transition: all .25s ease;
    }

    .btn-hero-phone:hover {
        color: #fff;
        transform: translateY(-3px);
        box-shadow: 0 14px 30px rgba(41, 199, 242, .5);
    }

    .btn-hero-phone-icon {
        width: 42px;
        height: 42px;
        flex-shrink: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: rgba(255, 255, 255, .18);
        border-radius: 50%;
        font-size: 1.1rem;
    }

    .btn-hero-phone-text {
        font-size: 1.35rem;
        font-weight: 800;
        letter-spacing: .5px;
    }

    /* ---------- CỘT PHẢI: ẢNH + BÓNG PHẢN CHIẾU ---------- */
    .hero-image-wrap {
        position: relative;
        display: inline-block;
        padding-bottom: 30px;
        z-index: 2;
    }

    .hero-image-3d {
        max-width: 92%;
        height: auto;
        position: relative;
        z-index: 2;
        filter: drop-shadow(0 20px 20px rgba(0, 0, 0, .3));
        animation: heroFloat 4s ease-in-out infinite;
        transition: transform .4s ease;
    }

    .hero-image-wrap:hover .hero-image-3d {
        transform: scale(1.02);
    }

    /* bóng đổ hình ellipse mờ dần nằm dưới ảnh minh họa */
    .hero-image-shadow {
        position: absolute;
        left: 50%;
        bottom: 6px;
        width: 60%;
        height: 26px;
        background: radial-gradient(ellipse at center, rgba(0,0,0,.35) 0%, rgba(0,0,0,0) 72%);
        transform: translateX(-50%);
        z-index: 1;
        border-radius: 50%;
        animation: heroShadowPulse 4s ease-in-out infinite;
    }

    @keyframes heroFloat {
        0%, 100% { transform: translateY(0); }
        50%      { transform: translateY(-14px); }
    }

    @keyframes heroShadowPulse {
        0%, 100% { transform: translateX(-50%) scale(1);   opacity: .6; }
        50%      { transform: translateX(-50%) scale(.85); opacity: .35; }
    }

    /* ---------- INDICATORS / CONTROLS ---------- */
    .hero-indicators {
        bottom: 16px;
        z-index: 3;
    }

    .hero-indicators [data-bs-target] {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background-color: rgba(255,255,255,.5);
        border: none;
        margin: 0 5px;
    }

    .hero-indicators .active {
        background-color: #ffb600;
    }

    .carousel-control-prev,
    .carousel-control-next {
        width: 56px;
        opacity: 1;
        z-index: 3;
    }

    .hero-control-icon {
        width: 46px;
        height: 46px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: rgba(255,255,255,.15);
        border-radius: 50%;
        font-size: 1.3rem;
        color: #fff;
        backdrop-filter: blur(4px);
        transition: background .2s ease;
    }

    .carousel-control-prev:hover .hero-control-icon,
    .carousel-control-next:hover .hero-control-icon {
        background: rgba(255,255,255,.3);
    }

    /* ---------- RESPONSIVE ---------- */
    @media (max-width: 991.98px) {
        .min-vh-hero { min-height: auto; padding: 40px 0; }
        .hero-eyebrow { font-size: 1.1rem; }
        .hero-title  { font-size: 2.1rem; }
        .hero-content { max-width: 100%; text-align: center; margin: 0 auto 24px; }
        .hero-desc { margin-left: auto; margin-right: auto; }
        .hero-image-3d { max-width: 78%; }
        .btn-hero-phone { margin: 0 auto; }
    }
</style>
@endpush

@push('scripts')
<script>
    // Tạm dừng carousel khi hover, chạy lại khi rời chuột (nếu muốn override data-bs-interval)
    document.addEventListener('DOMContentLoaded', function () {
        const heroCarouselEl = document.getElementById('heroCarousel');
        if (!heroCarouselEl) return;

        const heroCarousel = bootstrap.Carousel.getOrCreateInstance(heroCarouselEl);

        heroCarouselEl.addEventListener('mouseenter', () => heroCarousel.pause());
        heroCarouselEl.addEventListener('mouseleave', () => heroCarousel.cycle());
    });
</script>
@endpush