<?php $__env->startSection('title', ($siteName ?? 'ZEK SHOP') . ' - Trang chủ'); ?>

<?php $__env->startSection('content'); ?>


<section class="hero-section">
    <div class="container">
        <div class="row align-items-center min-vh-hero">
            <div class="col-lg-6">
                <h1 class="hero-title">GIẢI PHÁP MUA SẮM<br>TOÀN DIỆN CHO BẠN</h1>
                <p class="hero-desc">
                    <?php echo e($siteName ?? 'ZEK SHOP'); ?> mang đến hàng ngàn sản phẩm chất lượng với mức giá tốt nhất,
                    giao hàng nhanh toàn quốc, hỗ trợ đổi trả và thanh toán linh hoạt.
                </p>
                <a href="<?php echo e(route('products.newest')); ?>" class="btn btn-hero-cta">MUA SẮM NGAY</a>
            </div>
            <div class="col-lg-6 text-center">
                <img src="<?php echo e(asset('images/hero-banner.jpg')); ?>" class="img-fluid rounded-4" alt="Hero" onerror="this.style.display='none'">
            </div>
        </div>
    </div>
</section>


<section class="trusted-section py-4">
    <div class="container">
        <h6 class="text-uppercase text-center fw-bold mb-4">Được khách hàng tin tưởng</h6>
        <div class="d-flex flex-wrap justify-content-center align-items-center gap-5 brand-logos">
            <?php for($i = 1; $i <= 8; $i++): ?>
                <img src="<?php echo e(asset('images/brands/brand-'.$i.'.png')); ?>" alt="brand" height="36" onerror="this.remove()">
            <?php endfor; ?>
        </div>
    </div>
</section>


<section class="products-section py-5">
    <div class="container">
        <div class="section-heading text-center mb-5">
            <h2>SẢN PHẨM NỔI BẬT</h2>
            <span class="heading-underline"></span>
        </div>
        <div class="row g-4">
            <?php $__empty_1 = true; $__currentLoopData = ($featured ?? []); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <?php echo $__env->make('products.partials.card', ['product' => $product], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <p class="text-center text-muted">Chưa có sản phẩm nổi bật.</p>
            <?php endif; ?>
        </div>
    </div>
</section>


<section class="products-section bg-light py-5">
    <div class="container">
        <div class="section-heading text-center mb-5">
            <h2>SẢN PHẨM BÁN CHẠY</h2>
            <span class="heading-underline"></span>
        </div>
        <div class="row g-4">
            <?php $__empty_1 = true; $__currentLoopData = ($bestseller ?? []); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <?php echo $__env->make('products.partials.card', ['product' => $product], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <p class="text-center text-muted">Chưa có sản phẩm bán chạy.</p>
            <?php endif; ?>
        </div>
        <div class="text-center mt-4">
            <a href="<?php echo e(route('products.bestseller')); ?>" class="btn btn-outline-primary">Xem tất cả</a>
        </div>
    </div>
</section>


<section class="products-section py-5">
    <div class="container">
        <div class="section-heading text-center mb-5">
            <h2>SẢN PHẨM MỚI VỀ</h2>
            <span class="heading-underline"></span>
        </div>
        <div class="row g-4">
            <?php $__empty_1 = true; $__currentLoopData = ($newest ?? []); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <?php echo $__env->make('products.partials.card', ['product' => $product], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <p class="text-center text-muted">Chưa có sản phẩm mới.</p>
            <?php endif; ?>
        </div>
    </div>
</section>


<section class="why-section py-5">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <div class="section-heading mb-4">
                    <h2>LÝ DO NÊN CHỌN <?php echo e(strtoupper($siteName ?? 'ZEK SHOP')); ?></h2>
                    <span class="heading-underline heading-underline-left"></span>
                </div>
                <ul class="why-list">
                    <li><i class="fas fa-check-circle"></i> Sản phẩm chính hãng, cam kết chất lượng</li>
                    <li><i class="fas fa-check-circle"></i> Giao hàng nhanh toàn quốc, kiểm tra trước khi thanh toán</li>
                    <li><i class="fas fa-check-circle"></i> Hỗ trợ đổi trả trong 7 ngày</li>
                    <li><i class="fas fa-check-circle"></i> Đa dạng phương thức thanh toán: COD, chuyển khoản, online</li>
                    <li><i class="fas fa-check-circle"></i> Đội ngũ chăm sóc khách hàng 24/7</li>
                </ul>
            </div>
            <div class="col-lg-6 text-center">
                <img src="<?php echo e(asset('images/why-choose.png')); ?>" class="img-fluid" alt="" onerror="this.style.display='none'">
            </div>
        </div>
    </div>
</section>


<section class="testimonial-section bg-light py-5">
    <div class="container">
        <div class="section-heading text-center mb-5">
            <h2>KHÁCH HÀNG NÓI GÌ VỀ CHÚNG TÔI</h2>
            <span class="heading-underline"></span>
        </div>
        <div class="row g-4">
            <?php $__currentLoopData = ($testimonials ?? []); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-md-4">
                    <div class="testimonial-card">
                        <i class="fas fa-quote-left quote-icon"></i>
                        <p><?php echo e($t['content']); ?></p>
                        <div class="d-flex align-items-center mt-3">
                            <img src="<?php echo e($t['avatar']); ?>" class="rounded-circle" width="48" height="48" onerror="this.style.display='none'">
                            <div class="ms-2">
                                <strong><?php echo e($t['name']); ?></strong>
                                <div class="text-muted small"><?php echo e($t['role']); ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>


<section class="cta-section py-5">
    <div class="container text-center">
        <h2 class="text-white mb-3">NHẬN ƯU ĐÃI ĐẶC BIỆT CHO ĐƠN HÀNG ĐẦU TIÊN</h2>
        <p class="text-white-50 mb-4">Đăng ký nhận bản tin để không bỏ lỡ các chương trình khuyến mãi hấp dẫn.</p>
        <a href="<?php echo e(route('products.newest')); ?>" class="btn btn-hero-cta">MUA SẮM NGAY</a>
    </div>
</section>


<section class="news-section py-5">
    <div class="container">
        <div class="section-heading text-center mb-5">
            <h2>TIN TỨC & KHUYẾN MÃI</h2>
            <span class="heading-underline"></span>
        </div>
        <div class="row g-4">
            <?php $__currentLoopData = ($news ?? []); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-md-4">
                    <div class="news-card">
                        <img src="<?php echo e($item->image ? asset('storage/'.$item->image) : asset('images/news-placeholder.jpg')); ?>" class="img-fluid rounded" alt="">
                        <h5 class="mt-3"><?php echo e($item->translation()?->title); ?></h5>
                        <small class="text-muted"><?php echo e($item->created_at->format('d/m/Y')); ?></small>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ntsoftware/Downloads/cuahangtienich-admin-aplomb-theme/cuahangtienich/resources/views/home/index.blade.php ENDPATH**/ ?>