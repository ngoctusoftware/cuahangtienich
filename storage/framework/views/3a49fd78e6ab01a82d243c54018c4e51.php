<div class="topbar">
    <div class="container d-flex justify-content-between align-items-center">
        <div class="topbar-info">
            <span><i class="far fa-clock"></i> <?php echo e($setting('working_hours', 'Mon - Sat: 8:00 - 17:30')); ?></span>
            <span class="ms-3"><i class="fas fa-phone-alt"></i> <?php echo e($setting('hotline', '0812.119.111')); ?></span>
        </div>
        <div class="topbar-actions d-flex align-items-center">
            
            <div class="dropdown me-3">
                <button class="btn btn-sm btn-lang dropdown-toggle" data-bs-toggle="dropdown">
                    <?php $__currentLoopData = $languages ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($lang->code === app()->getLocale()): ?> <?php echo e($lang->name); ?> <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <?php $__currentLoopData = $languages ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><a class="dropdown-item" href="<?php echo e(route('lang.switch', $lang->code)); ?>"><?php echo e($lang->name); ?></a></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>

            <?php if(auth()->guard('customer')->check()): ?>
                <div class="dropdown me-3">
                    <button class="btn btn-sm btn-outline-light dropdown-toggle" data-bs-toggle="dropdown">
                        <i class="far fa-user"></i> <?php echo e(auth('customer')->user()->name); ?>

                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="<?php echo e(route('customer.orders')); ?>">Đơn hàng của tôi</a></li>
                        <li><form method="POST" action="<?php echo e(route('customer.logout')); ?>"><?php echo csrf_field(); ?>
                            <button class="dropdown-item">Đăng xuất</button></form></li>
                    </ul>
                </div>
            <?php else: ?>
                <a href="<?php echo e(route('customer.login')); ?>" class="btn btn-sm btn-outline-light me-3">
                    <i class="far fa-user"></i> Đăng nhập
                </a>
            <?php endif; ?>

            <a href="<?php echo e(route('cart.index')); ?>" class="btn btn-sm btn-light position-relative">
                <i class="fas fa-shopping-cart"></i> Giỏ hàng
                <span class="badge rounded-pill bg-danger cart-count"><?php echo e($cartCount ?? 0); ?></span>
            </a>
        </div>
    </div>
</div>

<nav class="navbar navbar-expand-lg main-nav sticky-top">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="<?php echo e(route('home')); ?>">
            <img src="<?php echo e(asset('images/logo.png')); ?>" alt="<?php echo e($siteName ?? 'ZEK SHOP'); ?>" height="42" onerror="this.style.display='none'">
            <span class="brand-text ms-2"><?php echo e($siteName ?? 'ZEK SHOP'); ?></span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainMenu">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainMenu">
            <ul class="navbar-nav ms-auto align-items-lg-center">
                <li class="nav-item"><a class="nav-link" href="<?php echo e(route('home')); ?>">Trang chủ</a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Sản phẩm</a>
                    <ul class="dropdown-menu">                               
                        <?php if(!empty($menuCategories)): ?>
                            <?php $__currentLoopData = $menuCategories ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><a class="dropdown-item" href="<?php echo e(route('products.byCategory', $cat->translation()?->slug)); ?>">
                                    <?php echo e($cat->translation()?->name); ?>

                                </a></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>                            
                        <?php endif; ?>
                    </ul>
                </li>
                <li class="nav-item"><a class="nav-link" href="<?php echo e(route('products.newest')); ?>">Sản phẩm mới</a></li>
                <li class="nav-item"><a class="nav-link" href="<?php echo e(route('products.bestseller')); ?>">Bán chạy</a></li>
                <li class="nav-item"><a class="nav-link" href="<?php echo e(route('page.show', 'about-us')); ?>">Về chúng tôi</a></li>
                <li class="nav-item">
                    <a class="btn btn-cta ms-lg-3" href="<?php echo e(route('page.show', 'contact')); ?>">LIÊN HỆ TƯ VẤN</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<?php /**PATH /home/ntsoftware/Downloads/cuahangtienich-admin-aplomb-theme/cuahangtienich/resources/views/partials/header.blade.php ENDPATH**/ ?>