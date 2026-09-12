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
            <span class="hero-control-icon"><i class="fa fa-arrow-left" aria-hidden="true"></i></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
            <span class="hero-control-icon"><i class="fas fa-arrow-right" aria-hidden="true"></i></span>
            <span class="visually-hidden">Next</span>
        </button>
        @endif

    </div>
</section>
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