<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Trang chu')  | ShopOnline</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&family=Playfair+Display:wght@600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('/assets/css/site.css') }}">
    @stack('styles')
</head>
<body>

<div class="topbar">
    <div class="container d-flex justify-content-between align-items-center text-danger py-2 d-flex justify-content-center">
        <marquee behavior="" direction="">
            <h5>
                <strong>
                    <i class="bi bi-fire"></i> 
                    Chào mừng bạn đến với thế giới tiện ích
                </strong>
            </h5>
        </marquee>
        
    </div>
</div>

<header class="site-header">
    <div class="container d-flex flex-wrap align-items-center gap-3">
        <a href="{{ route('shop.home') }}" class="brand-logo me-3">
            <img src="{{ !empty($data) && !empty($data['logo']) ? asset($data['logo']) : '/assets/images/logo.png' }}" alt="" with="100px" height="100px">
        </a>

        <form class="search-form d-flex flex-grow-1 mx-auto" style="max-width:420px;" method="GET" action="{{ route('products.index') }}">
            <input type="search" name="q" class="form-control" placeholder="Tim kiem..." value="{{ request('q') }}">
            <button class="btn"><i class="bi bi-search"></i></button>
        </form>

        <nav class="site-nav d-flex align-items-center gap-3 ms-auto">
            <a href="{{ route('shop.home') }}" class="nav-pill-home">Trang chu</a>
            <a href="{{ route('products.index') }}">San pham</a>
            @auth
                <a href="{{ route('orders.index') }}">Don hang cua toi</a>
            @else
                <a href="{{ route('login') }}">Dang nhap</a>
                <a href="{{ route('register') }}">Dang ky</a>
            @endauth
            <a href="{{ route('cart.index') }}" class="position-relative">
                <i class="bi bi-cart3 fs-5"></i>
                @if (session('cart') && count(session('cart')))
                    <span class="badge rounded-pill bg-danger position-absolute top-0 start-100 translate-middle" style="font-size:.6rem;">{{ count(session('cart')) }}</span>
                @endif
            </a>
            @auth
                <form action="{{ route('logout') }}" method="POST" class="m-0">
                    @csrf
                    <button class="btn btn-sm btn-outline-secondary">Dang xuat</button>
                </form>
            @endauth
        </nav>
    </div>
</header>

{{-- <div class="container mt-4">
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach
            </ul>
        </div>
    @endif
</div> --}}

@yield('content')

<footer class="site-footer pt-5 pb-4">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-3">
                <h6>Ve chung toi</h6>
                <p class="small mb-1">ShopOnline la he thong ban hang online voi da dang san pham, gia tot, giao hang nhanh, thanh toan tien loi.</p>
                <a href="{{ route('products.index') }}" class="small">Xem them <i class="bi bi-arrow-right"></i></a>
            </div>
            <div class="col-md-3">
                <h6>Lien he</h6>
                <p class="small mb-1"><i class="bi bi-geo-alt"></i> Ha Noi, Viet Nam</p>
                <p class="small mb-1"><i class="bi bi-telephone"></i> 0900 000 000</p>
                <p class="small mb-0"><i class="bi bi-envelope"></i> support@shoponline.test</p>
            </div>
            <div class="col-md-3">
                <h6>Danh muc san pham</h6>
                <ul class="list-unstyled small">
                    <li><a href="{{ route('products.index') }}">Tat ca san pham</a></li>
                    <li><a href="{{ route('cart.index') }}">Gio hang</a></li>
                    <li><a href="{{ route('login') }}">Dang nhap / Dang ky</a></li>
                </ul>
            </div>
            <div class="col-md-3">
                <h6>Ho tro thanh toan</h6>
                <ul class="list-unstyled small">
                    <li>Thanh toan khi nhan hang (COD)</li>
                    <li>Thanh toan online qua VNPay</li>
                    <li>Chuyen khoan ngan hang</li>
                </ul>
            </div>
        </div>
    </div>
</footer>
<div class="footer-bottom text-center py-2">
    &copy; {{ date('Y') }} ShopOnline - He thong quan ly ban hang Laravel
</div>

<div class="fab-stack">
    <a href="https://www.facebook.com/ntsoftware" class="fab-btn chat"><i class="bi bi-facebook"></i> Chat Facebook</a>
    <a href="tel:0765132999" class="fab-btn phone"><i class="bi bi-telephone-fill"></i>Nhà Bim Mộc</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
