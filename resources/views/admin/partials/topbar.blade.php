<header class="admin-topbar d-flex align-items-center justify-content-between px-4">
    <form class="search-box">
        <i class="fas fa-search"></i>
        <input type="text" placeholder="Tìm kiếm...">
    </form>
    <div class="d-flex align-items-center gap-3">
        <a href="{{ route('home') }}" target="_blank" class="text-white" title="Xem website">
            <i class="fas fa-external-link-alt"></i>
        </a>
        <i class="far fa-bell text-white"></i>
        <div class="dropdown">
            <button class="btn btn-sm topbar-user dropdown-toggle" data-bs-toggle="dropdown">
                <i class="fas fa-user-circle"></i> {{ auth()->user()->name ?? 'Admin' }}
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
                <li><form method="POST" action="{{ route('admin.logout') }}">@csrf
                    <button class="dropdown-item">Đăng xuất</button></form></li>
            </ul>
        </div>
    </div>
</header>
