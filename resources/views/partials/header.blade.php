<div class="topbar">
    <div class="container d-flex justify-content-between align-items-center">
        <div class="topbar-info">
            <span><i class="far fa-clock"></i> {{ $setting('working_hours', 'Mon - Sat: 8:00 - 17:30') }}</span>
            <span class="ms-3"><i class="fas fa-phone-alt"></i> {{ $setting('hotline', '0812.119.111') }}</span>
        </div>
        <div class="topbar-actions d-flex align-items-center">
            {{-- Chuyển đổi ngôn ngữ --}}
            <div class="dropdown me-3">
                <button class="btn btn-sm btn-lang dropdown-toggle" data-bs-toggle="dropdown">
                    @foreach($languages ?? [] as $lang)
                        @if($lang->code === app()->getLocale()) {{ $lang->name }} @endif
                    @endforeach
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    @foreach($languages ?? [] as $lang)
                        <li><a class="dropdown-item" href="{{ route('lang.switch', $lang->code) }}">{{ $lang->name }}</a></li>
                    @endforeach
                </ul>
            </div>

            @auth('customer')
                <div class="dropdown me-3">
                    <button class="btn btn-sm btn-outline-light dropdown-toggle" data-bs-toggle="dropdown">
                        <i class="far fa-user"></i> {{ auth('customer')->user()->name }}
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="{{ route('customer.orders') }}">Đơn hàng của tôi</a></li>
                        <li><form method="POST" action="{{ route('customer.logout') }}">@csrf
                            <button class="dropdown-item">Đăng xuất</button></form></li>
                    </ul>
                </div>
            @else
                <a href="{{ route('customer.login') }}" class="btn btn-sm btn-outline-light me-3">
                    <i class="far fa-user"></i> Đăng nhập
                </a>
            @endauth

            <a href="{{ route('cart.index') }}" class="btn btn-sm btn-light position-relative">
                <i class="fas fa-shopping-cart"></i> Giỏ hàng
                <span class="badge rounded-pill bg-danger cart-count">{{ $cartCount ?? 0 }}</span>
            </a>
        </div>
    </div>
</div>

<nav class="navbar navbar-expand-lg main-nav sticky-top">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
            <img src="{{ asset('images/logo.png') }}" alt="{{ $siteName ?? 'ZEK SHOP' }}" height="42" onerror="this.style.display='none'">
            <span class="brand-text ms-2">{{ $siteName ?? 'ZEK SHOP' }}</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainMenu">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainMenu">
            <ul class="navbar-nav ms-auto align-items-lg-center">
                <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Trang chủ</a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Sản phẩm</a>
                    <ul class="dropdown-menu">
                        @foreach($menuCategories ?? [] as $cat)
                            <li><a class="dropdown-item" href="{{ route('products.byCategory', $cat->translation()?->slug) }}">
                                {{ $cat->translation()?->name }}
                            </a></li>
                        @endforeach
                    </ul>
                </li>
                <li class="nav-item"><a class="nav-link" href="{{ route('products.newest') }}">Sản phẩm mới</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('products.bestseller') }}">Bán chạy</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('page.show', 'about-us') }}">Về chúng tôi</a></li>
                <li class="nav-item">
                    <a class="btn btn-cta ms-lg-3" href="{{ route('page.show', 'contact') }}">LIÊN HỆ TƯ VẤN</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
