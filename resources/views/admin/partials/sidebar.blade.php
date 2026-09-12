<aside class="admin-sidebar">
    <div class="sidebar-brand d-flex justify-content-center">
        <img src="{{ asset('images/admin_logo.png') }}" alt="{{ $siteName }}" width="160px" height="160px" onerror="this.style.display='none'">
    </div>
    <nav class="sidebar-nav">
        <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="fas fa-th-large"></i> Dashboard
        </a>

        <div class="sidebar-heading">Nội dung</div>
        <a href="{{ route('admin.settings.index') }}" class="{{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
            <i class="fas fa-sliders-h"></i> Cấu hình chung
        </a>
        <a href="{{ route('admin.header-menu.index') }}" class="{{ request()->routeIs('admin.header-menu.*') ? 'active' : '' }}">
            <i class="fas fa-bars"></i> Menu header
        </a>
        <a href="{{ route('admin.contents.index') }}" class="{{ request()->routeIs('admin.contents.*') ? 'active' : '' }}">
            <i class="fas fa-file-alt"></i> Quản lý nội dung
        </a>
        <a href="{{ route('admin.banners.index') }}" class="{{ request()->routeIs('admin.banners.*') ? 'active' : '' }}">
            <i class="fas fa-images"></i> Quản lý banner
        </a>
        <a href="{{ route('admin.store-benefits.index') }}" class="{{ request()->routeIs('admin.store-benefits.*') ? 'active' : '' }}">
            <i class="fas fa-circle-check"></i> Lý do nên chọn
        </a>
        <a href="{{ route('admin.languages.index') }}" class="{{ request()->routeIs('admin.languages.*') ? 'active' : '' }}">
            <i class="fas fa-language"></i> Ngôn ngữ
        </a>

        <div class="sidebar-heading">Bán hàng</div>
        <a href="{{ route('admin.categories.index') }}" class="{{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
            <i class="fas fa-sitemap"></i> Danh mục
        </a>
        <a href="{{ route('admin.products.index') }}" class="{{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
            <i class="fas fa-box"></i> Sản phẩm
        </a>
        <a href="{{ route('admin.orders.index') }}" class="{{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
            <i class="fas fa-receipt"></i> Đơn hàng
            @isset($sidebarPendingOrders)
                @if($sidebarPendingOrders > 0)<span class="badge-count">{{ $sidebarPendingOrders }}</span>@endif
            @endisset
        </a>
        <a href="{{ route('admin.payments.index') }}" class="{{ request()->routeIs('admin.payments.*') ? 'active' : '' }}">
            <i class="fas fa-credit-card"></i> Thanh toán
        </a>

        <div class="sidebar-heading">Khách hàng</div>
        <a href="{{ route('admin.customer-groups.index') }}" class="{{ request()->routeIs('admin.customer-groups.*') ? 'active' : '' }}">
            <i class="fas fa-layer-group"></i> Nhóm khách hàng
        </a>
        <a href="{{ route('admin.customers.index') }}" class="{{ request()->routeIs('admin.customers.*') ? 'active' : '' }}">
            <i class="fas fa-users"></i> Khách hàng
        </a>

        <div class="sidebar-heading">Hệ thống</div>
        <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
            <i class="fas fa-user-shield"></i> Người dùng
        </a>
        <a href="{{ route('admin.roles.index') }}" class="{{ request()->routeIs('admin.roles.*') ? 'active' : '' }}">
            <i class="fas fa-key"></i> Phân quyền
        </a>
        <a href="{{ route('admin.profile.edit') }}" class="{{ request()->routeIs('admin.profile.*') ? 'active' : '' }}">
            <i class="fas fa-id-badge"></i> Tài khoản của tôi
        </a>
    </nav>
</aside>
