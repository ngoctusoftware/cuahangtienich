<aside class="admin-sidebar">
    <div class="sidebar-brand">
        <?php if($siteLogo ?? false): ?>
            <img src="<?php echo e(asset('storage/'.$siteLogo)); ?>" alt="<?php echo e($siteName); ?>">
        <?php else: ?>
            <span class="brand-mark"><i class="fas fa-bolt"></i></span>
        <?php endif; ?>
        <span><?php echo e($siteName ?? 'ZEK ADMIN'); ?></span>
    </div>
    <nav class="sidebar-nav">
        <a href="<?php echo e(route('admin.dashboard')); ?>" class="<?php echo e(request()->routeIs('admin.dashboard') ? 'active' : ''); ?>">
            <i class="fas fa-th-large"></i> Dashboard
        </a>

        <div class="sidebar-heading">Nội dung</div>
        <a href="<?php echo e(route('admin.settings.index')); ?>" class="<?php echo e(request()->routeIs('admin.settings.*') ? 'active' : ''); ?>">
            <i class="fas fa-sliders-h"></i> Cấu hình chung
        </a>
        <a href="<?php echo e(route('admin.contents.index')); ?>" class="<?php echo e(request()->routeIs('admin.contents.*') ? 'active' : ''); ?>">
            <i class="fas fa-file-alt"></i> Quản lý nội dung
        </a>
        <a href="<?php echo e(route('admin.languages.index')); ?>" class="<?php echo e(request()->routeIs('admin.languages.*') ? 'active' : ''); ?>">
            <i class="fas fa-language"></i> Ngôn ngữ
        </a>

        <div class="sidebar-heading">Bán hàng</div>
        <a href="<?php echo e(route('admin.categories.index')); ?>" class="<?php echo e(request()->routeIs('admin.categories.*') ? 'active' : ''); ?>">
            <i class="fas fa-sitemap"></i> Danh mục
        </a>
        <a href="<?php echo e(route('admin.products.index')); ?>" class="<?php echo e(request()->routeIs('admin.products.*') ? 'active' : ''); ?>">
            <i class="fas fa-box"></i> Sản phẩm
        </a>
        <a href="<?php echo e(route('admin.orders.index')); ?>" class="<?php echo e(request()->routeIs('admin.orders.*') ? 'active' : ''); ?>">
            <i class="fas fa-receipt"></i> Đơn hàng
            <?php if(isset($sidebarPendingOrders)): ?>
                <?php if($sidebarPendingOrders > 0): ?><span class="badge-count"><?php echo e($sidebarPendingOrders); ?></span><?php endif; ?>
            <?php endif; ?>
        </a>
        <a href="<?php echo e(route('admin.payments.index')); ?>" class="<?php echo e(request()->routeIs('admin.payments.*') ? 'active' : ''); ?>">
            <i class="fas fa-credit-card"></i> Thanh toán
        </a>

        <div class="sidebar-heading">Khách hàng</div>
        <a href="<?php echo e(route('admin.customer-groups.index')); ?>" class="<?php echo e(request()->routeIs('admin.customer-groups.*') ? 'active' : ''); ?>">
            <i class="fas fa-layer-group"></i> Nhóm khách hàng
        </a>
        <a href="<?php echo e(route('admin.customers.index')); ?>" class="<?php echo e(request()->routeIs('admin.customers.*') ? 'active' : ''); ?>">
            <i class="fas fa-users"></i> Khách hàng
        </a>

        <div class="sidebar-heading">Hệ thống</div>
        <a href="<?php echo e(route('admin.users.index')); ?>" class="<?php echo e(request()->routeIs('admin.users.*') ? 'active' : ''); ?>">
            <i class="fas fa-user-shield"></i> Người dùng
        </a>
        <a href="<?php echo e(route('admin.roles.index')); ?>" class="<?php echo e(request()->routeIs('admin.roles.*') ? 'active' : ''); ?>">
            <i class="fas fa-key"></i> Phân quyền
        </a>
        <a href="<?php echo e(route('admin.profile.edit')); ?>" class="<?php echo e(request()->routeIs('admin.profile.*') ? 'active' : ''); ?>">
            <i class="fas fa-id-badge"></i> Tài khoản của tôi
        </a>
    </nav>
</aside>
<?php /**PATH /home/ntsoftware/Downloads/cuahangtienich-admin-aplomb-theme/cuahangtienich/resources/views/admin/partials/sidebar.blade.php ENDPATH**/ ?>