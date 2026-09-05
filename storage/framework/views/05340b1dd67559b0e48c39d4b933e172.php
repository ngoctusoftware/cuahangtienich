<header class="admin-topbar d-flex align-items-center justify-content-between px-4">
    <div class="d-flex align-items-center gap-3">
        <button id="sidebarToggle" class="btn btn-sm d-lg-none topbar-icon-btn" type="button">
            <i class="fas fa-bars"></i>
        </button>
        <form class="search-box d-none d-md-block">
            <i class="fas fa-search"></i>
            <input type="text" placeholder="Tìm kiếm...">
        </form>
    </div>
    <div class="d-flex align-items-center gap-2">
        <a href="<?php echo e(route('home')); ?>" target="_blank" class="topbar-icon-btn" title="Xem website">
            <i class="fas fa-external-link-alt"></i>
        </a>
        <a href="<?php echo e(route('admin.orders.index')); ?>" class="topbar-icon-btn" title="Đơn hàng">
            <i class="far fa-bell"></i>
            <?php if(isset($sidebarPendingOrders)): ?>
                <?php if($sidebarPendingOrders > 0): ?><span class="ping"></span><?php endif; ?>
            <?php endif; ?>
        </a>
        <div class="dropdown">
            <button class="btn btn-sm topbar-user dropdown-toggle" data-bs-toggle="dropdown">
                <span class="avatar-circle"><?php echo e(strtoupper(substr(auth()->user()->name ?? 'A', 0, 1))); ?></span>
                <?php echo e(auth()->user()->name ?? 'Admin'); ?>

            </button>
            <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="<?php echo e(route('admin.profile.edit')); ?>"><i class="fas fa-id-badge me-2"></i>Hồ sơ cá nhân</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><form method="POST" action="<?php echo e(route('admin.logout')); ?>"><?php echo csrf_field(); ?>
                    <button class="dropdown-item"><i class="fas fa-sign-out-alt me-2"></i>Đăng xuất</button></form></li>
            </ul>
        </div>
    </div>
</header>
<?php /**PATH /home/ntsoftware/Downloads/cuahangtienich-admin-aplomb-theme/cuahangtienich/resources/views/admin/partials/topbar.blade.php ENDPATH**/ ?>