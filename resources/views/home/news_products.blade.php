<section class="products-section py-5">
    <div class="container">
        <div class="d-flex align-items-end justify-content-between gap-3 mb-4">
            <div class="section-heading section-heading-left">
                <h2>{{ __('storefront.home.newest_title') }}</h2>
                <p>{{ __('storefront.home.newest_description', ['store' => $siteName ?? 'ZEK SHOP']) }}</p>
                <span class="heading-underline"></span>
            </div>
        </div>
        <div class="home-product-carousel-wrapper">
            <div class="home-product-carousel" data-product-carousel>
                @forelse(($newest ?? []) as $product)
                    @include('products.partials.card', ['product' => $product])
                @empty
                    <p class="text-center text-muted">{{ __('storefront.home.newest_empty') }}</p>
                @endforelse
            </div>
            <div class="home-product-carousel-controls" aria-label="{{ __('storefront.home.newest_carousel') }}">
                <button type="button" data-carousel-direction="prev" aria-label="{{ __('storefront.home.newest_previous') }}"><i
                        class="fas fa-chevron-left"></i></button>
                <button type="button" data-carousel-direction="next" aria-label="{{ __('storefront.home.newest_next') }}"><i
                        class="fas fa-chevron-right"></i></button>
            </div>
        </div>
        <div class="d-flex justify-content-center mt-3">
            <a href="{{ route('products.newest') }}" class="btn btn-outline-primary">{{ __('storefront.home.newest_all') }}</a>
        </div>
    </div>
</section>