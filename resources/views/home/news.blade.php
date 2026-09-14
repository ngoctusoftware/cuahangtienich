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