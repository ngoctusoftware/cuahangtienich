
<header class="site-header">
    <div class="container d-flex align-items-center justify-content-between py-3">
        <a href="<?php echo e(route('home')); ?>" class="brand d-flex align-items-center gap-2 text-decoration-none">
            <span class="brand-badge"><i class="fa-solid fa-bolt"></i></span>
            <span>
                <span class="brand-name d-block">ZEK AGENCY</span>
                <small class="brand-sub d-block">Digital performance marketing</small>
            </span>
        </a>

        <nav class="d-none d-lg-flex align-items-center gap-4">
            <a href="<?php echo e(route('home')); ?>">KHO GIAO DIỆN</a>
            <?php $__currentLoopData = $categories ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e(route('category.show', $cat->translation()?->slug)); ?>">
                    <?php echo e(strtoupper($cat->translation()?->name)); ?>

                </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <a href="#">BÁO GIÁ</a>
            <a href="#">CHIA SẺ</a>
            <a href="#">VỀ CHÚNG TÔI</a>
        </nav>

        <div class="d-flex align-items-center gap-3">
            <div class="d-none d-md-flex align-items-center gap-2 text-muted small">
                <i class="fa-regular fa-clock"></i>
                Mon - Sat: 8:00 - 17:30
            </div>

            
            <div class="dropdown">
                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
                    <?php echo e(strtoupper(app()->getLocale())); ?>

                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="<?php echo e(route('lang.switch', 'vi')); ?>">Tiếng Việt</a></li>
                    <li><a class="dropdown-item" href="<?php echo e(route('lang.switch', 'en')); ?>">English</a></li>
                </ul>
            </div>

            <a href="<?php echo e(route('cart.index')); ?>" class="btn btn-light position-relative">
                <i class="fa-solid fa-cart-shopping"></i>
            </a>

            <a href="#lien-he" class="btn btn-primary rounded-pill px-4">LIÊN HỆ TƯ VẤN</a>
        </div>
    </div>
</header>
<?php /**PATH /home/ntsoftware/Downloads/cuahangtienich-admin-aplomb-theme/cuahangtienich/resources/views/shop/partials/header.blade.php ENDPATH**/ ?>