<?php $__env->startSection('title', ($category?->translation()?->name ?? 'Sản phẩm') . ' - ' . ($siteName ?? 'ZEK SHOP')); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>">Trang chủ</a></li>
            <li class="breadcrumb-item active"><?php echo e($category?->translation()?->name ?? 'Sản phẩm'); ?></li>
        </ol>
    </nav>

    <div class="row g-4">
        <div class="col-lg-3">
            <div class="filter-box">
                <h6 class="text-uppercase fw-bold mb-3">Danh mục</h6>
                <ul class="list-unstyled">
                    <?php $__currentLoopData = $allCategories ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li class="mb-2">
                            <a href="<?php echo e(route('products.byCategory', $cat->translation()?->slug)); ?>"
                               class="<?php echo e(isset($category) && $category->id === $cat->id ? 'fw-bold text-primary' : ''); ?>">
                                <?php echo e($cat->translation()?->name); ?>

                            </a>
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        </div>
        <div class="col-lg-9">
            <div class="row g-4">
                <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <?php echo $__env->make('products.partials.card', ['product' => $product], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p class="text-muted">Không có sản phẩm nào.</p>
                <?php endif; ?>
            </div>
            <div class="mt-4">
                <?php echo e($products->links()); ?>

            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ntsoftware/Downloads/cuahangtienich-admin-aplomb-theme/cuahangtienich/resources/views/products/index.blade.php ENDPATH**/ ?>