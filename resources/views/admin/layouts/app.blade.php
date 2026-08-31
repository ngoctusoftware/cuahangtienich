<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Quan tri') | Sales Management</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <style>
        body { background:#f4f6f9; }
        .sidebar { min-height:100vh; background:#1e2a3a; }
        .sidebar a { color:#c9d3de; text-decoration:none; display:block; padding:.6rem 1rem; border-radius:.4rem; }
        .sidebar a:hover, .sidebar a.active { background:#2f3f54; color:#fff; }
        .sidebar .brand { color:#fff; font-weight:700; }
    </style>
</head>
<body>
<div class="d-flex">
    <div class="sidebar p-3" style="width:230px;">
        <div class="brand fs-5 mb-4"><i class="bi bi-shop"></i> Admin Shop</div>
        <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"><i class="bi bi-speedometer2"></i> Tong quan</a>
        <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}"><i class="bi bi-people"></i> Nguoi dung</a>
        <a href="{{ route('admin.roles.index') }}" class="{{ request()->routeIs('admin.roles.*') ? 'active' : '' }}"><i class="bi bi-shield-lock"></i> Phan quyen</a>
        <a href="{{ route('admin.categories.index') }}" class="{{ request()->routeIs('admin.categories.*') ? 'active' : '' }}"><i class="bi bi-tags"></i> Danh muc</a>
        <a href="{{ route('admin.products.index') }}" class="{{ request()->routeIs('admin.products.*') ? 'active' : '' }}"><i class="bi bi-box-seam"></i> San pham</a>
        <a href="{{ route('admin.orders.index') }}" class="{{ request()->routeIs('admin.orders.*') ? 'active' : '' }}"><i class="bi bi-receipt"></i> Don hang</a>
        <a href="{{ route('admin.payments.index') }}" class="{{ request()->routeIs('admin.payments.*') ? 'active' : '' }}"><i class="bi bi-credit-card"></i> Thanh toan</a>
        <hr class="text-secondary">
        <a href="{{ route('shop.home') }}"><i class="bi bi-box-arrow-up-right"></i> Xem website</a>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="btn btn-sm btn-outline-light w-100 mt-2" type="submit"><i class="bi bi-box-arrow-right"></i> Dang xuat</button>
        </form>
    </div>

    <div class="flex-fill p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0">@yield('title')</h4>
            <div class="text-muted">Xin chao, <strong>{{ auth()->user()->name ?? '' }}</strong></div>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </div>
</div>
</body>
</html>
