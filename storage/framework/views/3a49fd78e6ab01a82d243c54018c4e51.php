<header class="site-header">
    
    <div class="header-top">
        <div class="container d-flex align-items-center justify-content-between flex-wrap gap-3">
            <a class="brand d-flex align-items-center" href="<?php echo e(route('home')); ?>">
                <img src="<?php echo e(asset('images/logo.png')); ?>" alt="<?php echo e($siteName ?? 'MAY PHƯỢNG HOÀNG'); ?>" height="56"
                    onerror="this.style.display='none'">
                <span class="brand-text ms-2">
                    <span class="brand-text-thin">MAY</span>
                    <span class="brand-text-bold"><?php echo e($siteName ?? 'PHƯỢNG HOÀNG'); ?></span>
                </span>
            </a>

            
            <form class="header-search" action="<?php echo e(url('/tim-kiem')); ?>" method="GET">
                <input type="text" name="q" placeholder="Tìm kiếm sản phẩm..." value="<?php echo e(request('q')); ?>">
                <button type="submit" aria-label="Tìm kiếm"><i class="fas fa-search"></i></button>
            </form>

            <div class="header-contact d-none d-lg-flex">
                <div class="contact-item">
                    <i class="fas fa-phone-volume"></i>
                    <div class="contact-text">
                        
                        <span class="contact-value">0982.995.195</span>
                    </div>
                </div>
                <div class="contact-item">
                    <i class="fas fa-envelope"></i>
                    <div class="contact-text">
                        
                        <span class="contact-value">ductho2495@gmail.com</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
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
                            <?php $__empty_1 = true; $__currentLoopData = $menuCategories ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <li>
                                    <a class="dropdown-item"
                                        href="<?php echo e(route('products.byCategory', $cat->translation()?->slug)); ?>">
                                        <?php echo e($cat->translation()?->name); ?>

                                    </a>
                                </li>                                
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <li><span class="dropdown-item-text text-muted">Chưa có danh mục</span></li>
                            <?php endif; ?>
                        </ul>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo e(route('home')); ?>">TRANG CHỦ</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo e(route('page.show', 'about-us')); ?>">GIỚI THIỆU</a>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo e(route('products.newest')); ?>">TIN TỨC</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo e(route('products.bestseller')); ?>">TUYỂN DỤNG</a>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo e(route('page.show', 'contact')); ?>">LIÊN HỆ</a>
                    </li>

                    <li class="nav-item ms-lg-auto d-flex align-items-lg-stretch header-actions">
                        
                        <a href="<?php echo e(route('cart.index')); ?>" class="action-link cart-link">
                            <i class="fas fa-shopping-cart"></i>
                            <span class="cart-badge"><?php echo e($cartCount ?? 0); ?></span>
                        </a>
                        
                    <li class="nav-item dropdown action-dropdown language-item">
                        <a class="nav-link language-toggle dropdown-toggle" href="#" data-bs-toggle="dropdown">
                            <i class="fas fa-bars"></i>
                            <?php $__currentLoopData = $languages ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($lang->code === app()->getLocale()): ?> <?php echo e($lang->name); ?> <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </a>
                        <ul class="dropdown-menu">
                            <?php $__currentLoopData = $languages ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($key > 0 && $key < count($languages) - 1): ?>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                <?php endif; ?>
                                <li>
                                    <a class="dropdown-item" href="<?php echo e(route('lang.switch', $lang->code)); ?>">
                                        <?php echo e($lang->name); ?>

                                    </a>
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </li>
                    
                    <?php if(auth()->guard('customer')->check()): ?>
                        <li class="nav-item dropdown action-dropdown language-item">
                            <a class="nav-link language-toggle dropdown-toggle" href="#" data-bs-toggle="dropdown">
                                <i class="far fa-user"></i>
                                <span class="d-none d-xl-inline"><?php echo e(auth('customer')->user()->name); ?></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item" href="<?php echo e(route('customer.orders')); ?>">
                                        <i class="fas fa-shopping-bag fa-sm"></i>
                                        <span style="font-size:14px;">Đơn hàng của tôi</span>
                                    </a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <form method="POST" action="<?php echo e(route('customer.logout')); ?>"><?php echo csrf_field(); ?>
                                        <button class="dropdown-item">
                                            <i class="fa fa-sign-out" aria-hidden="true"></i>
                                            <span style="font-size:14px;">Đăng xuất</span>
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>

                        
                    <?php else: ?>
                        <a href="<?php echo e(route('customer.login')); ?>" class="action-link">
                            <i class="far fa-user"></i>
                        </a>
                    <?php endif; ?>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header><?php /**PATH /home/ntsoftware/Downloads/cuahangtienich-admin-aplomb-theme/cuahangtienich/resources/views/partials/header.blade.php ENDPATH**/ ?>