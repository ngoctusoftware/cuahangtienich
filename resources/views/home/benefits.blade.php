<section class="home-benefits" aria-label="Cam kết của cửa hàng">
    <div class="container">
        <div class="home-benefits-grid">
            @foreach($benefits as $benefit)
            @php($translation = $benefit->translation())
            <div class="home-benefit">
                <span class="home-benefit-icon"><i class="{{ $benefit->icon }}"></i></span>
                <div class="home-benefit-copy">
                    <strong>{{ $translation?->title }}</strong>
                    <span>{{ $translation?->description }}</span>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>