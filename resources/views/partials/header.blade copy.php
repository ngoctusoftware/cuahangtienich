<header class="site-header">
    {{-- Tầng trên: logo / tìm kiếm / liên hệ --}}
    <div class="header-top">
        <div class="container d-flex align-items-center justify-content-between flex-wrap gap-3">
            <a class="brand d-flex align-items-center" href="{{ route('home') }}">
                <img src="{{ !empty($settings['site_logo']) ? asset($settings['site_logo']) : '/images/logo.png' }}"
                    alt="{{ !empty($settings['site_name']) ? $settings['site_name'] : env('APP_NAME') }}" width="100px"
                    height="auto" onerror="this.style.display='none'">
            </a>

            {{-- Ô tìm kiếm: đổi action bên dưới thành route tìm kiếm thực tế của bạn --}}
            <form class="header-search" action="{{ url('/tim-kiem') }}" method="GET">
                <input type="text" name="q" placeholder="Tìm kiếm sản phẩm..." value="{{ request('q') }}">
                <button type="submit" aria-label="Tìm kiếm"><i class="fas fa-search"></i></button>
            </form>

            <div class="header-contact d-none d-lg-flex">
                <div class="contact-item">
                    <i class="fas fa-phone-volume"></i>
                    <div class="contact-text">
                        <span class="contact-value text-dark">
                            {{ !empty($settings['hotline']) ? $settings['hotline'] : '1900 0000' }}
                        </span>
                    </div>
                </div>
                <div class="contact-item">
                    <i class="fas fa-envelope"></i>
                    <div class="contact-text">
                        <span class="contact-value text-dark">
                            {{ !empty($settings['email']) ? $settings['email'] : 'info@yourwebsite.com' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Tầng dưới: menu chính --}}
    <nav class="navbar navbar-expand-lg main-nav sticky-top">
        <div class="container">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainMenu">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mainMenu">
                <ul class="navbar-nav align-items-lg-stretch w-100">
                    <li class="nav-item dropdown category-item">
                        <a class="nav-link category-toggle dropdown-toggle" href="#" data-bs-toggle="dropdown">
                            <i class="fas fa-bars"></i> DANH MỤC SẢN PHẨM
                        </a>
                        <ul class="dropdown-menu">
                            @forelse($menuCategories ?? [] as $cat)
                                <li>
                                    <a class="dropdown-item"
                                        href="{{ route('products.byCategory', $cat->translation()?->slug) }}">
                                        {{ $cat->translation()?->name }}
                                    </a>
                                </li>
                            @empty
                                <li><span class="dropdown-item-text text-muted">Chưa có danh mục</span></li>
                            @endforelse
                        </ul>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">TRANG CHỦ</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('page.show', 'about-us') }}">GIỚI THIỆU</a>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('products.newest') }}">TIN TỨC</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('products.bestseller') }}">TUYỂN DỤNG</a>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('page.show', 'contact') }}">LIÊN HỆ</a>
                    </li>

                    {{-- Giỏ hàng --}}
                    <li class="nav-item ms-lg-auto d-flex align-items-lg-stretch header-actions">
                        <a href="{{ route('cart.index') }}" class="action-link cart-link">
                            <i class="fas fa-shopping-cart"></i>
                            <span class="cart-badge">{{ $cartCount ?? 0 }}</span>
                        </a>
                    {{-- Chuyển đổi ngôn ngữ --}}
                    <li class="nav-item dropdown action-dropdown language-item">
                        {{-- Hiển thị ngôn ngữ hiện tại và cung cấp menu thả xuống để chuyển đổi giữa các ngôn ngữ có sẵn. --}}
                        <a class="nav-link language-toggle dropdown-toggle" href="#" data-bs-toggle="dropdown">
                            @foreach ($languages ?? [] as $lang)
                                @if ($lang->code === app()->getLocale() && $lang->code == 'vi')
                                    <img src="{{ !empty($lang->flag_icon) ? asset($lang->flag_icon) : '/images/vi.jpg' }}"
                                        width="30px" height="auto" onerror="this.style.display='none'">
                                @elseif($lang->code === app()->getLocale() && $lang->code == 'en')
                                    <img src="{{ !empty($lang->flag_icon) ? asset($lang->flag_icon) : '/images/en.jpg' }}"
                                        width="30px" height="auto" onerror="this.style.display='none'">
                                @endif
                            @endforeach
                        </a>
                        <ul class="dropdown-menu">                            
                            @foreach ($languages ?? [] as $key => $lang)
                                @if ($key > 0 && $key < count($languages) - 1)
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                @endif
                                <li>
                                    <a class="dropdown-item" href="{{ route('lang.switch', $lang->code) }}">                                        
                                        @if ($lang->code == 'vi')
                                            <img src="{{ !empty($lang->flag_icon) ? asset($lang->flag_icon) : '/images/vi.jpg' }} "width="30px" height="auto" onerror="this.style.display='none'">
                                        @elseif($lang->code == 'en')
                                            <img src="{{ !empty($lang->flag_icon) ? asset($lang->flag_icon) : '/images/en.jpg' }} "width="30px" height="auto" onerror="this.style.display='none'">
                                        @endif
                                        {{ $lang->name }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                    {{-- Tài khoản --}}
                    @auth('customer')
                        <li class="nav-item dropdown action-dropdown language-item">
                            <a class="nav-link language-toggle dropdown-toggle" href="#" data-bs-toggle="dropdown">
                                <i class="far fa-user"></i>
                                <span class="d-none d-xl-inline">{{ auth('customer')->user()->name }}</span>
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item" href="{{ route('customer.orders') }}">
                                        <i class="fas fa-shopping-bag fa-sm"></i>
                                        <span style="font-size:14px;">Đơn hàng của tôi</span>
                                    </a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <form method="POST" action="{{ route('customer.logout') }}">@csrf
                                        <button class="dropdown-item">
                                            <i class="fa fa-sign-out" aria-hidden="true"></i>
                                            <span style="font-size:14px;">Đăng xuất</span>
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <a href="{{ route('customer.login') }}" class="action-link">
                            <i class="far fa-user"></i>
                        </a>
                    @endauth
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>
<style>
    .contact-item .fa-phone-volume,
    .contact-item .fa-envelope {
        display: inline-block;
        animation: shake 0.4s ease-in-out infinite;
    }

    @keyframes shake {

        0%,
        100% {
            transform: rotate(0deg);
        }

        25% {
            transform: rotate(-10deg);
        }

        75% {
            transform: rotate(10deg);
        }
    }
</style>
