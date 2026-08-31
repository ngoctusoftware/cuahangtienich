<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Trang chu')  | Shop Online</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <style>
        .navbar-brand { font-weight:700; }
        .product-card img { height:200px; object-fit:cover; }
        footer { background:#1e2a3a; color:#c9d3de; }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="{{ route('shop.home') }}"><i class="bi bi-shop"></i> ShopOnline</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav1"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="nav1">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link" href="{{ route('products.index') }}">San pham</a></li>
            </ul>
            <form class="d-flex me-2" method="GET" action="{{ route('products.index') }}">
                <input class="form-control" type="search" name="q" placeholder="Tim san pham..." value="{{ request('q') }}">
            </form>
            <ul class="navbar-nav align-items-lg-center gap-2">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('cart.index') }}"><i class="bi bi-cart3"></i> Gio hang
                        @if (session('cart') && count(session('cart')))
                            <span class="badge bg-danger">{{ count(session('cart')) }}</span>
                        @endif
                    </a>
                </li>
                @auth
                    @if (auth()->user()->isAdmin())
                        <li class="nav-item"><a class="nav-link" href="{{ route('admin.dashboard') }}"><i class="bi bi-speedometer2"></i> Quan tri</a></li>
                    @endif
                    <li class="nav-item"><a class="nav-link" href="{{ route('orders.index') }}"><i class="bi bi-receipt"></i> Don hang cua toi</a></li>
                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button class="btn btn-outline-secondary btn-sm">Dang xuat ({{ auth()->user()->name }})</button>
                        </form>
                    </li>
                @else
                    <li class="nav-item"><a class="btn btn-outline-primary btn-sm" href="{{ route('login') }}">Dang nhap</a></li>
                    <li class="nav-item"><a class="btn btn-primary btn-sm" href="{{ route('register') }}">Dang ky</a></li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-4">
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

    @yield('content')
</div>

<footer class="mt-5 py-4">
    <div class="container text-center small">&copy; {{ date('Y') }} ShopOnline - He thong quan ly ban hang Laravel</div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
