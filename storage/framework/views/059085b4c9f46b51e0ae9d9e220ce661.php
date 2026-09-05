<?php $__env->startSection('title', ($product->translation()?->name ?? 'Sản phẩm') . ' - ' . ($siteName ?? 'ZEK SHOP')); ?>
<?php $__env->startSection('meta_description', $product->translation()?->meta_description); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="<?php echo e(route('products.byCategory', $product->category->translation()?->slug)); ?>"><?php echo e($product->category->translation()?->name); ?></a></li>
            <li class="breadcrumb-item active"><?php echo e($product->translation()?->name); ?></li>
        </ol>
    </nav>

    <div class="row g-5">
        <div class="col-lg-6">
            <div class="product-gallery">
                <img id="mainImage" src="<?php echo e($product->thumbnail ? asset('storage/'.$product->thumbnail) : asset('images/product-placeholder.jpg')); ?>" class="img-fluid rounded mb-3 main-image">
                <div class="d-flex gap-2 flex-wrap">
                    <?php $__currentLoopData = $product->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <img src="<?php echo e(asset('storage/'.$img->path)); ?>" class="thumb-image" onclick="document.getElementById('mainImage').src=this.src">
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <h1 class="product-title"><?php echo e($product->translation()?->name); ?></h1>
            <p class="text-muted">SKU: <?php echo e($product->sku); ?></p>
            <div class="product-price-detail mb-3">
                <?php if($product->sale_price): ?>
                    <span class="price-sale fs-3"><?php echo e(number_format($product->sale_price)); ?>₫</span>
                    <span class="price-old fs-5"><?php echo e(number_format($product->price)); ?>₫</span>
                <?php else: ?>
                    <span class="price-sale fs-3"><?php echo e(number_format($product->price)); ?>₫</span>
                <?php endif; ?>
            </div>
            <p><?php echo e($product->translation()?->short_description); ?></p>

            <form action="<?php echo e(route('cart.add')); ?>" method="POST" class="d-flex align-items-center gap-3 my-4">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="product_id" value="<?php echo e($product->id); ?>">
                <input type="number" name="quantity" value="1" min="1" max="<?php echo e($product->stock); ?>" class="form-control" style="width: 90px">
                <button type="submit" class="btn btn-hero-cta">
                    <i class="fas fa-cart-plus"></i> Thêm vào giỏ hàng
                </button>
            </form>

            <p class="text-success"><i class="fas fa-check"></i> Còn hàng (<?php echo e($product->stock); ?> sản phẩm)</p>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-lg-9">
            <h4>Mô tả chi tiết</h4>
            <div class="product-description">
                <?php echo $product->translation()?->description; ?>

            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ntsoftware/Downloads/cuahangtienich-admin-aplomb-theme/cuahangtienich/resources/views/products/show.blade.php ENDPATH**/ ?>