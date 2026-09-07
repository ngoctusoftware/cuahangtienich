<?php $__env->startSection('title', ($settings['site_name'] ?? 'ZEK Agency') . ' - Trang chủ'); ?>

<?php $__env->startSection('content'); ?>


<section class="hero-section">
    <div class="container py-5">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <h1 class="hero-title">
                    <?php echo e($banner->title ?? 'GIẢI PHÁP TOÀN DIỆN CHO SỰ PHÁT TRIỂN DOANH NGHIỆP'); ?>

                </h1>
                <div class="hero-desc">
                    <?php echo $banner->body ?? 'ZEK AGENCY là đơn vị đồng hành cùng sự phát triển của doanh nghiệp – chuyên tư vấn và triển khai các chiến dịch Digital Marketing.'; ?>

                </div>
                <a href="#lien-he" class="btn btn-dark rounded-pill px-4 py-2 mt-3">NHẬN TƯ VẤN</a>
            </div>
            <div class="col-lg-6">
                <div class="hero-image-wrap">
                    <img src="<?php echo e($banner->content->image ?? asset('images/hero-placeholder.jpg')); ?>" alt="Hero" class="img-fluid rounded-4 shadow">
                </div>
            </div>
        </div>
    </div>
    <div class="hero-wave"></div>
</section>


<section class="trusted-section py-4">
    <div class="container text-center">
        <h6 class="text-uppercase fw-bold text-muted mb-4">Được tin tưởng bởi:</h6>
        <div class="d-flex flex-wrap justify-content-center align-items-center gap-5 trusted-logos">
            <?php $__empty_1 = true; $__currentLoopData = $trustedLogos->body ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $logo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <img src="<?php echo e($logo); ?>" alt="logo" height="32">
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <?php for($i = 1; $i <= 8; $i++): ?>
                    <span class="placeholder-logo">LOGO <?php echo e($i); ?></span>
                <?php endfor; ?>
            <?php endif; ?>
        </div>
    </div>
</section>


<section class="products-section py-5">
    <div class="container">
        <h2 class="section-title text-center">SẢN PHẨM NỔI BẬT CỦA CHÚNG TÔI</h2>
        <div class="section-divider mx-auto mb-5"></div>

        <?php $__currentLoopData = [
            ['key' => 'featured', 'label' => 'Sản phẩm nổi bật', 'icon' => 'fa-star'],
            ['key' => 'bestseller', 'label' => 'Sản phẩm bán chạy', 'icon' => 'fa-fire'],
            ['key' => 'newest', 'label' => 'Sản phẩm mới', 'icon' => 'fa-bolt'],
        ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $block): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if(($sections[$block['key']] ?? collect())->isNotEmpty()): ?>
                <div class="mb-5">
                    <h5 class="fw-bold mb-3"><i class="fa-solid <?php echo e($block['icon']); ?> text-primary me-2"></i><?php echo e($block['label']); ?></h5>
                    <div class="row g-4">
                        <?php $__currentLoopData = $sections[$block['key']]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="col-6 col-md-4 col-lg-3">
                                <a href="<?php echo e(route('product.show', $product->translation()?->slug)); ?>" class="text-decoration-none text-dark">
                                    <div class="product-card">
                                        <img src="<?php echo e($product->thumbnail ? asset('storage/'.$product->thumbnail) : asset('images/product-placeholder.jpg')); ?>" class="product-thumb" alt="<?php echo e($product->translation()?->name); ?>">
                                        <div class="p-3">
                                            <div class="product-name"><?php echo e($product->translation()?->name); ?></div>
                                            <div class="product-price mt-1">
                                                <?php if($product->sale_price): ?>
                                                    <span class="text-danger fw-bold"><?php echo e(number_format($product->sale_price)); ?>₫</span>
                                                    <del class="text-muted small ms-1"><?php echo e(number_format($product->price)); ?>₫</del>
                                                <?php else: ?>
                                                    <span class="fw-bold"><?php echo e(number_format($product->price)); ?>₫</span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</section>


<section class="why-section py-5">
    <div class="container">
        <h2 class="section-title text-center">LÝ DO NÊN LỰA CHỌN <?php echo e(strtoupper($settings['site_name'] ?? 'ZEK AGENCY')); ?></h2>
        <div class="section-divider mx-auto mb-5"></div>

        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <p class="text-muted"><?php echo e($whyChooseUs->body ?? ''); ?></p>
                <ul class="list-unstyled why-list">
                    <li><i class="fa-solid fa-circle-check text-success me-2"></i>Đội ngũ nhân sự giàu kinh nghiệm và chuyên môn cao</li>
                    <li><i class="fa-solid fa-circle-check text-success me-2"></i>Mọi dịch vụ triển khai bài bản theo quy trình</li>
                    <li><i class="fa-solid fa-circle-check text-success me-2"></i>Hỗ trợ "20/7" giải quyết kịp thời mọi vấn đề</li>
                    <li><i class="fa-solid fa-circle-check text-success me-2"></i>Cam kết chất lượng và tiến độ giao hàng</li>
                    <li><i class="fa-solid fa-circle-check text-success me-2"></i>Chính sách đổi trả – bảo hành rõ ràng, minh bạch</li>
                </ul>
            </div>
            <div class="col-lg-6 text-center">
                <img src="<?php echo e(asset('images/why-choose-us.svg')); ?>" alt="Why choose us" class="img-fluid" style="max-height:360px">
            </div>
        </div>
    </div>
</section>


<section class="testimonial-section py-5">
    <div class="container">
        <h2 class="section-title text-center">KHÁCH HÀNG NÓI GÌ VỀ CHÚNG TÔI</h2>
        <div class="section-divider mx-auto mb-5"></div>

        <div class="row g-4">
            <?php $__empty_1 = true; $__currentLoopData = $testimonials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="col-md-4">
                    <div class="testimonial-card">
                        <i class="fa-solid fa-quote-left text-primary mb-2"></i>
                        <p><?php echo e($t->translation()?->body); ?></p>
                        <div class="fw-bold mt-3"><?php echo e($t->translation()?->title); ?></div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <?php $__currentLoopData = ['Mrs. Linh Vương - CEO Zeka.vn', 'Mr. Quân Lại - CEO Lavatino', 'Mr. Nam Trần - CEO iSofa']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sample): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-md-4">
                        <div class="testimonial-card">
                            <i class="fa-solid fa-quote-left text-primary mb-2"></i>
                            <p>Dịch vụ hỗ trợ nhiệt tình, đáp ứng đúng yêu cầu, mang lại nhiều giá trị cho công việc kinh doanh.</p>
                            <div class="fw-bold mt-3"><?php echo e($sample); ?></div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        </div>
    </div>
</section>


<section id="lien-he" class="cta-section py-5">
    <div class="container text-center">
        <h2 class="section-title text-white">LIÊN HỆ TƯ VẤN BÁO GIÁ</h2>
        <p class="text-white-50 mb-4">Nhận báo giá các sản phẩm/dịch vụ miễn phí. Đừng để đối thủ vượt mặt bạn trước khi bắt đầu.</p>
        <a href="tel:<?php echo e($settings['hotline'] ?? ''); ?>" class="btn btn-light rounded-pill px-5 py-2 fw-bold">TƯ VẤN NGAY</a>
    </div>
</section>


<?php if($news->isNotEmpty()): ?>
<section class="news-section py-5">
    <div class="container">
        <h2 class="section-title text-center">CẬP NHẬT TIN TỨC TỪ CHUYÊN GIA</h2>
        <div class="section-divider mx-auto mb-5"></div>
        <div class="row g-4">
            <?php $__currentLoopData = $news; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-md-4">
                    <div class="news-card">
                        <?php if($item->image): ?>
                            <img src="<?php echo e(asset('storage/'.$item->image)); ?>" class="news-thumb" alt="">
                        <?php endif; ?>
                        <div class="p-3">
                            <div class="fw-bold"><?php echo e($item->translation()?->title); ?></div>
                            <small class="text-muted"><?php echo e($item->created_at->format('d/m/Y')); ?></small>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>
<?php endif; ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('shop.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ntsoftware/Downloads/cuahangtienich-admin-aplomb-theme/cuahangtienich/resources/views/shop/home.blade.php ENDPATH**/ ?>