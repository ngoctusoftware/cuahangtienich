<footer class="site-footer">
    <div class="container py-5">
        <div class="row g-4">
            <div class="col-lg-4">
                <img src="{{ asset('images/logo-white.png') }}" alt="" height="40" onerror="this.style.display='none'">
                <h5 class="text-white mt-2">{{ $siteName ?? 'ZEK SHOP' }}</h5>
                <p class="mb-1"><i class="fas fa-phone-alt me-2"></i>{{ $setting('hotline', '0812.119.111') }}</p>
                <p class="mb-1"><i class="fas fa-envelope me-2"></i>{{ $setting('email', 'contact@zekshop.vn') }}</p>
                <p class="mb-0"><i class="fas fa-map-marker-alt me-2"></i>{{ $setting('address', '16 Nguyễn Như Kom Tum, Thanh Xuân, Hà Nội') }}</p>
            </div>
            <div class="col-lg-3 col-md-4">
                <h6 class="text-uppercase text-white mb-3">Về chúng tôi</h6>
                <ul class="list-unstyled footer-links">
                    <li><a href="{{ route('page.show', 'gioi-thieu') }}">Giới thiệu</a></li>
                    <li><a href="{{ route('page.show', 'tuyen-dung') }}">Tuyển dụng</a></li>
                    <li><a href="{{ route('page.show', 'chinh-sach-bao-mat') }}">Chính sách bảo mật</a></li>
                    <li><a href="{{ route('page.show', 'chinh-sach-doi-tra') }}">Chính sách đổi trả</a></li>
                </ul>
            </div>
            <div class="col-lg-3 col-md-4">
                <h6 class="text-uppercase text-white mb-3">Danh mục</h6>
                <ul class="list-unstyled footer-links">
                    @foreach($menuCategories ?? [] as $cat)
                        <li><a href="{{ route('products.byCategory', $cat->translation()?->slug) }}">{{ $cat->translation()?->name }}</a></li>
                    @endforeach
                </ul>
            </div>
            <div class="col-lg-2 col-md-4">
                <h6 class="text-uppercase text-white mb-3">Kết nối</h6>
                <div class="social-icons">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-youtube"></i></a>
                    <a href="#"><i class="fab fa-tiktok"></i></a>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom py-3 text-center">
        <small>&copy; {{ date('Y') }} {{ $siteName ?? 'ZEK SHOP' }}. All rights reserved.</small>
    </div>
</footer>
