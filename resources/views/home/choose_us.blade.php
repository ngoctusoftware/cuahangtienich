<section class="why-section py-5">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <div class="section-heading section-heading-left mb-4">
                    <span class="why-eyebrow">{{ __('storefront.home.why_eyebrow') }}</span>
                    <h2>{{ __('storefront.home.why_title') }}</h2>
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
                    <p class="text-muted">{{ __('storefront.home.why_empty') }}</p>
                    @endforelse
                </div>
            </div>
            <div class="col-lg-6 text-center">
                <div class="why-visual">
                    <span class="why-visual-orb why-visual-orb-one"></span>
                    <span class="why-visual-orb why-visual-orb-two"></span>
                    <img src="{{ asset('images/why-choose.png') }}" class="img-fluid" alt="{{ __('storefront.home.why_image_alt') }}"
                        onerror="this.style.display='none'">
                    <div class="why-visual-card">
                        <i class="fas fa-heart"></i>
                        <strong>{{ __('storefront.home.why_card_title') }}</strong>
                        <span>{{ __('storefront.home.why_card_description') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>