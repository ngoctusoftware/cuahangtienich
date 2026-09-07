@extends('shop.layouts.app')

@section('title', ($settings['site_name'] ?? 'ZEK Agency') . ' - Trang chủ')

@section('content')

{{-- ============ HERO BANNER (gradient tím-hồng, dạng wave giống ảnh mẫu) ============ --}}
<section class="hero-section">
    <div class="container py-5">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <h1 class="hero-title">
                    {{ $banner->title ?? 'GIẢI PHÁP TOÀN DIỆN CHO SỰ PHÁT TRIỂN DOANH NGHIỆP' }}
                </h1>
                <div class="hero-desc">
                    {!! $banner->body ?? 'ZEK AGENCY là đơn vị đồng hành cùng sự phát triển của doanh nghiệp – chuyên tư vấn và triển khai các chiến dịch Digital Marketing.' !!}
                </div>
                <a href="#lien-he" class="btn btn-dark rounded-pill px-4 py-2 mt-3">NHẬN TƯ VẤN</a>
            </div>
            <div class="col-lg-6">
                <div class="hero-image-wrap">
                    <img src="{{ $banner->content->image ?? asset('images/hero-placeholder.jpg') }}" alt="Hero" class="img-fluid rounded-4 shadow">
                </div>
            </div>
        </div>
    </div>
    <div class="hero-wave"></div>
</section>

{{-- ============ ĐƯỢC TIN TƯỞNG BỞI (logo strip) ============ --}}
<section class="trusted-section py-4">
    <div class="container text-center">
        <h6 class="text-uppercase fw-bold text-muted mb-4">Được tin tưởng bởi:</h6>
        <div class="d-flex flex-wrap justify-content-center align-items-center gap-5 trusted-logos">
            @forelse($trustedLogos->body ?? [] as $logo)
                <img src="{{ $logo }}" alt="logo" height="32">
            @empty
                @for ($i = 1; $i <= 8; $i++)
                    <span class="placeholder-logo">LOGO {{ $i }}</span>
                @endfor
            @endforelse
        </div>
    </div>
</section>

{{-- ============ SẢN PHẨM NỔI BẬT / BÁN CHẠY / MỚI (thay cho khối "Dịch vụ" trong ảnh gốc) ============ --}}
<section class="products-section py-5">
    <div class="container">
        <h2 class="section-title text-center">SẢN PHẨM NỔI BẬT CỦA CHÚNG TÔI</h2>
        <div class="section-divider mx-auto mb-5"></div>

        @foreach ([
            ['key' => 'featured', 'label' => 'Sản phẩm nổi bật', 'icon' => 'fa-star'],
            ['key' => 'bestseller', 'label' => 'Sản phẩm bán chạy', 'icon' => 'fa-fire'],
            ['key' => 'newest', 'label' => 'Sản phẩm mới', 'icon' => 'fa-bolt'],
        ] as $block)
            @if(($sections[$block['key']] ?? collect())->isNotEmpty())
                <div class="mb-5">
                    <h5 class="fw-bold mb-3"><i class="fa-solid {{ $block['icon'] }} text-primary me-2"></i>{{ $block['label'] }}</h5>
                    <div class="row g-4">
                        @foreach($sections[$block['key']] as $product)
                            <div class="col-6 col-md-4 col-lg-3">
                                <a href="{{ route('product.show', $product->translation()?->slug) }}" class="text-decoration-none text-dark">
                                    <div class="product-card">
                                        <img src="{{ $product->thumbnail ? asset('storage/'.$product->thumbnail) : asset('images/product-placeholder.jpg') }}" class="product-thumb" alt="{{ $product->translation()?->name }}">
                                        <div class="p-3">
                                            <div class="product-name">{{ $product->translation()?->name }}</div>
                                            <div class="product-price mt-1">
                                                @if($product->sale_price)
                                                    <span class="text-danger fw-bold">{{ number_format($product->sale_price) }}₫</span>
                                                    <del class="text-muted small ms-1">{{ number_format($product->price) }}₫</del>
                                                @else
                                                    <span class="fw-bold">{{ number_format($product->price) }}₫</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        @endforeach
    </div>
</section>

{{-- ============ LÝ DO NÊN LỰA CHỌN (why choose us) ============ --}}
<section class="why-section py-5">
    <div class="container">
        <h2 class="section-title text-center">LÝ DO NÊN LỰA CHỌN {{ strtoupper($settings['site_name'] ?? 'ZEK AGENCY') }}</h2>
        <div class="section-divider mx-auto mb-5"></div>

        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <p class="text-muted">{{ $whyChooseUs->body ?? '' }}</p>
                <ul class="list-unstyled why-list">
                    <li><i class="fa-solid fa-circle-check text-success me-2"></i>Đội ngũ nhân sự giàu kinh nghiệm và chuyên môn cao</li>
                    <li><i class="fa-solid fa-circle-check text-success me-2"></i>Mọi dịch vụ triển khai bài bản theo quy trình</li>
                    <li><i class="fa-solid fa-circle-check text-success me-2"></i>Hỗ trợ "20/7" giải quyết kịp thời mọi vấn đề</li>
                    <li><i class="fa-solid fa-circle-check text-success me-2"></i>Cam kết chất lượng và tiến độ giao hàng</li>
                    <li><i class="fa-solid fa-circle-check text-success me-2"></i>Chính sách đổi trả – bảo hành rõ ràng, minh bạch</li>
                </ul>
            </div>
            <div class="col-lg-6 text-center">
                <img src="{{ asset('images/why-choose-us.svg') }}" alt="Why choose us" class="img-fluid" style="max-height:360px">
            </div>
        </div>
    </div>
</section>

{{-- ============ KHÁCH HÀNG NÓI GÌ (testimonials) ============ --}}
<section class="testimonial-section py-5">
    <div class="container">
        <h2 class="section-title text-center">KHÁCH HÀNG NÓI GÌ VỀ CHÚNG TÔI</h2>
        <div class="section-divider mx-auto mb-5"></div>

        <div class="row g-4">
            @forelse($testimonials as $t)
                <div class="col-md-4">
                    <div class="testimonial-card">
                        <i class="fa-solid fa-quote-left text-primary mb-2"></i>
                        <p>{{ $t->translation()?->body }}</p>
                        <div class="fw-bold mt-3">{{ $t->translation()?->title }}</div>
                    </div>
                </div>
            @empty
                @foreach(['Mrs. Linh Vương - CEO Zeka.vn', 'Mr. Quân Lại - CEO Lavatino', 'Mr. Nam Trần - CEO iSofa'] as $sample)
                    <div class="col-md-4">
                        <div class="testimonial-card">
                            <i class="fa-solid fa-quote-left text-primary mb-2"></i>
                            <p>Dịch vụ hỗ trợ nhiệt tình, đáp ứng đúng yêu cầu, mang lại nhiều giá trị cho công việc kinh doanh.</p>
                            <div class="fw-bold mt-3">{{ $sample }}</div>
                        </div>
                    </div>
                @endforeach
            @endforelse
        </div>
    </div>
</section>

{{-- ============ CTA LIÊN HỆ TƯ VẤN ============ --}}
<section id="lien-he" class="cta-section py-5">
    <div class="container text-center">
        <h2 class="section-title text-white">LIÊN HỆ TƯ VẤN BÁO GIÁ</h2>
        <p class="text-white-50 mb-4">Nhận báo giá các sản phẩm/dịch vụ miễn phí. Đừng để đối thủ vượt mặt bạn trước khi bắt đầu.</p>
        <a href="tel:{{ $settings['hotline'] ?? '' }}" class="btn btn-light rounded-pill px-5 py-2 fw-bold">TƯ VẤN NGAY</a>
    </div>
</section>

{{-- ============ TIN TỨC / CẬP NHẬT TỪ CHUYÊN GIA ============ --}}
@if($news->isNotEmpty())
<section class="news-section py-5">
    <div class="container">
        <h2 class="section-title text-center">CẬP NHẬT TIN TỨC TỪ CHUYÊN GIA</h2>
        <div class="section-divider mx-auto mb-5"></div>
        <div class="row g-4">
            @foreach($news as $item)
                <div class="col-md-4">
                    <div class="news-card">
                        @if($item->image)
                            <img src="{{ asset('storage/'.$item->image) }}" class="news-thumb" alt="">
                        @endif
                        <div class="p-3">
                            <div class="fw-bold">{{ $item->translation()?->title }}</div>
                            <small class="text-muted">{{ $item->created_at->format('d/m/Y') }}</small>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

@endsection
