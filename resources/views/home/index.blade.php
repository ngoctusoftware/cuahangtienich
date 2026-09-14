@extends('layouts.app')
@section('title', ($siteName ?? 'ZEK SHOP') . ' - Trang chủ')
@section('content')
<div class="home-page">
    @php
        $heroSlides = $banners->map(function ($banner) {
            $translation = $banner->translation();
            return [
                'eyebrow'     => $translation?->eyebrow ?? $banner->eyebrow,
                'title'       => $translation?->title ?? $banner->title,
                'description' => $translation?->description ?? $banner->description,
                'cta_text'    => $translation?->cta_text ?? $banner->cta_text,
                'cta_link'    => $translation?->resolved_link ?? $banner->resolved_link,
                'cta_type'    => $banner->cta_type,
                'image'       => $banner->image_url,
                'bg_class'    => $banner->bg_class,
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
    @include('home.best_selling_products')
    {{-- SẢN PHẨM MỚI --}}
    @include('home.news_products')
    {{-- LÝ DO NÊN CHỌN --}}
    @include('home.choose_us')
    {{-- Cảm nhận của khách hàng --}}
    @include('home.testimonials')
    {{-- TIN TỨC --}}
    {{-- @include('home.news') --}}
    {{-- CTA LIÊN HỆ --}}
    @include('home.contact_us')
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