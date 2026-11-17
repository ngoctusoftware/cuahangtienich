    <section class="products-section py-5">
        <div class="container">
            <div class="d-flex align-items-end justify-content-between gap-3 mb-4">
                <div class="section-heading section-heading-left">                    
                    <h2>{{ __('storefront.home.featured_title') }}</h2>
                    <p>{{ __('storefront.home.featured_description') }}</p>
                    <span class="heading-underline"></span>
                </div>
            </div>
            <div class="home-product-carousel-wrapper">
                <div class="home-product-carousel" data-product-carousel>
                    @forelse(($featured ?? []) as $product)
                        @include('products.partials.card', ['product' => $product])
                    @empty
                        <p class="text-center text-muted">{{ __('storefront.home.featured_empty') }}</p>
                    @endforelse
                </div>
                <div class="home-product-carousel-controls" aria-label="{{ __('storefront.home.featured_carousel') }}">
                    <button type="button" data-carousel-direction="prev" aria-label="{{ __('storefront.home.featured_previous') }}"><i
                            class="fas fa-chevron-left"></i></button>
                    <button type="button" data-carousel-direction="next" aria-label="{{ __('storefront.home.featured_next') }}"><i
                            class="fas fa-chevron-right"></i></button>
                </div>
            </div>
            <div class="d-flex justify-content-center mt-3">
                <a href="{{ route('products.featured') }}" class="btn btn-outline-primary">{{ __('storefront.home.featured_all') }}</a>
            </div>
        </div>
    </section>