<header class="site-header">
    {{-- Tầng trên: logo / tìm kiếm / liên hệ --}}
    <div class="header-top">
        <div class="header-top-inner container">
            <div class="header-top-row1">
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
            </div>

            <div class="header-contact">
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

            {{-- Chỉ hiển thị ở mobile, nằm ngay cạnh nút hamburger — đúng "vị trí cũ" --}}
            <div class="header-actions-mobile d-flex d-lg-none align-items-center">
                <a href="{{ route('cart.index') }}" class="action-link cart-link">
                    <i class="fas fa-shopping-cart"></i>
                    <span class="cart-badge">{{ $cartCount ?? 0 }}</span>
                </a>

                <div class="dropdown action-dropdown language-item">
                    @php
                        $currentLanguage = collect($languages ?? [])->firstWhere('code', app()->getLocale())
                            ?? collect($languages ?? [])->firstWhere('is_default', true);
                    @endphp
                    <a class="nav-link language-toggle dropdown-toggle" href="#" data-bs-toggle="dropdown">
                        @if ($currentLanguage)
                            <img src="{{ !empty($currentLanguage->flag_icon) ? asset($currentLanguage->flag_icon) : asset('images/' . $currentLanguage->code . '.jpg') }}"
                                alt="{{ $currentLanguage->name }}" style="width:26px; height:auto; border-radius:3px;"
                                onerror="this.style.display='none'">
                        @endif
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        @foreach ($languages ?? [] as $lang)
                            <li>
                                <a class="dropdown-item" href="{{ route('lang.switch', ['code' => $lang->code]) }}">
                                    <img src="{{ !empty($lang->flag_icon) ? asset($lang->flag_icon) : asset('images/' . $lang->code . '.jpg') }}"
                                        alt="{{ $lang->name }}" style="width:26px; height:auto; border-radius:3px;"
                                        onerror="this.style.display='none'">
                                    {{ $lang->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                @auth('customer')
                    <div class="dropdown action-dropdown">
                        <a class="nav-link language-toggle dropdown-toggle" href="#" data-bs-toggle="dropdown">
                            <i class="far fa-user"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="{{ route('customer.orders') }}">
                                    <i class="fas fa-shopping-bag fa-sm"></i>
                                    <span style="font-size:14px;">Đơn hàng của tôi</span>
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('customer.logout') }}">@csrf
                                    <button class="dropdown-item">
                                        <i class="fa fa-sign-out" aria-hidden="true"></i>
                                        <span style="font-size:14px;">Đăng xuất</span>
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @else
                    <a href="{{ route('customer.login') }}" class="action-link">
                        <i class="far fa-user"></i>
                    </a>
                @endauth
            </div>

            <div class="collapse navbar-collapse" id="mainMenu">
                <ul class="navbar-nav align-items-lg-stretch w-100">
                    @foreach($headerMenuItems ?? [] as $menuItem)
                        @if($menuItem->is_category)
                            <li class="nav-item dropdown category-item">
                                <a class="nav-link category-toggle dropdown-toggle" href="#" data-bs-toggle="dropdown">
                                    @if($menuItem->icon)<i class="{{ $menuItem->icon }}"></i>@endif
                                    {{ $menuItem->translation()?->label }}
                                </a>
                                <ul class="dropdown-menu">
                                    @forelse($menuCategories ?? [] as $cat)
                                        <li><a class="dropdown-item" href="{{ route('products.byCategory', $cat->translation()?->slug) }}">{{ $cat->translation()?->name }}</a></li>
                                    @empty
                                        <li><span class="dropdown-item-text text-muted">{{ app()->getLocale() === 'en' ? 'No categories' : 'Chưa có danh mục' }}</span></li>
                                    @endforelse
                                </ul>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link" href="{{ $menuItem->url ?? '#' }}">
                                    @if($menuItem->icon)<i class="{{ $menuItem->icon }}"></i>@endif
                                    {{ $menuItem->translation()?->label }}
                                </a>
                            </li>
                        @endif
                    @endforeach

                    {{-- Giỏ hàng — chỉ hiển thị ở desktop, mobile đã có ở header-actions-mobile bên trên --}}
                    <li class="nav-item ms-lg-auto d-none d-lg-flex align-items-lg-stretch header-actions">
                        <a href="{{ route('cart.index') }}" class="action-link cart-link">
                            <i class="fas fa-shopping-cart"></i>
                            <span class="cart-badge">{{ $cartCount ?? 0 }}</span>
                        </a>
                    </li>

                    {{-- Chuyển đổi ngôn ngữ — chỉ hiển thị ở desktop --}}
                    <li class="nav-item dropdown action-dropdown language-item d-none d-lg-block">
                        @php
                            $currentLanguage = collect($languages ?? [])->firstWhere('code', app()->getLocale())
                                ?? collect($languages ?? [])->firstWhere('is_default', true);
                        @endphp
                        <a class="nav-link language-toggle dropdown-toggle" href="#" data-bs-toggle="dropdown">
                            @if ($currentLanguage)
                                <img src="{{ !empty($currentLanguage->flag_icon) ? asset($currentLanguage->flag_icon) : asset('images/' . $currentLanguage->code . '.jpg') }}"
                                    alt="{{ $currentLanguage->name }}" style="width:30px; height:auto; border-radius:3px;"
                                    onerror="this.style.display='none'">
                            @endif
                        </a>
                        <ul class="dropdown-menu">
                            @foreach ($languages ?? [] as $lang)
                                <li>
                                    <a class="dropdown-item" href="{{ route('lang.switch', ['code' => $lang->code]) }}">
                                        <img src="{{ !empty($lang->flag_icon) ? asset($lang->flag_icon) : asset('images/' . $lang->code . '.jpg') }}"
                                            alt="{{ $lang->name }}" style="width:30px; height:auto; border-radius:3px;"
                                            onerror="this.style.display='none'">
                                        {{ $lang->name }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </li>

                    {{-- Tài khoản — chỉ hiển thị ở desktop --}}
                    @auth('customer')
                        <li class="nav-item dropdown action-dropdown language-item d-none d-lg-block">
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
                        <a href="{{ route('customer.login') }}" class="action-link d-none d-lg-inline-flex">
                            <i class="far fa-user"></i>
                        </a>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>
</header>