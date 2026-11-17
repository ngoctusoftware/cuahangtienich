{{-- TESTIMONIAL --}}
<section class="testimonial-section bg-light py-5">
    <div class="container">
        <div class="section-heading text-center mb-5">
            <h2>{{ __('storefront.home.testimonials_title') }}</h2>
            <p>{{ __('storefront.home.testimonials_description') }}</p>
            <span class="heading-underline"></span>
        </div>
        <div class="row g-4">
            @foreach(($testimonials ?? []) as $t)
            @php($translation = $t->translation())
            @php($rating = (int) data_get($t, 'rating', 5))
            <div class="col-md-4">
                <div class="testimonial-card">
                    <i class="fas fa-quote-left quote-icon" aria-hidden="true"></i>
                    <div class="testimonial-card-top">
                        <div class="d-flex align-items-center">
                            <img src="{{ data_get($t, 'image') ? asset('storage/' . data_get($t, 'image')) : asset('images/avatar-placeholder.jpg') }}"
                                class="rounded-circle testimonial-avatar" width="40" height="40"
                                onerror="this.style.display='none'">
                            <div class="ms-2">
                                <strong>{{ $translation?->title }}</strong>
                                <div class="text-muted small">{{ __('storefront.home.parent') }}</div>
                            </div>
                        </div>
                        <div class="testimonial-rating" aria-label="{{ __('storefront.home.rating', ['rating' => $rating]) }}">
                            @for($star = 1; $star <= 5; $star++)
                                <i class="fas fa-star {{ $star <= $rating ? '' : 'is-empty' }}" aria-hidden="true"></i>
                            @endfor
                        </div>
                    </div>
                    <p>{{ $translation?->body }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>