<div class="col-lg-3 col-md-4 col-6">
    <div class="product-card">
        <a href="<?php echo e(route('products.show', $product->translation()?->slug)); ?>" class="product-thumb">
            <img src="<?php echo e($product->thumbnail ? asset('storage/'.$product->thumbnail) : asset('images/product-placeholder.jpg')); ?>"
                 class="img-fluid" alt="<?php echo e($product->translation()?->name); ?>">
            <?php if($product->sale_price): ?>
                <span class="badge-sale">
                    -<?php echo e(round((1 - $product->sale_price / $product->price) * 100)); ?>%
                </span>
            <?php endif; ?>
        </a>
        <div class="product-info">
            <h6 class="product-name">
                <a href="<?php echo e(route('products.show', $product->translation()?->slug)); ?>"><?php echo e($product->translation()?->name); ?></a>
            </h6>
            <div class="product-price">
                <?php if($product->sale_price): ?>
                    <span class="price-sale"><?php echo e(number_format($product->sale_price)); ?>₫</span>
                    <span class="price-old"><?php echo e(number_format($product->price)); ?>₫</span>
                <?php else: ?>
                    <span class="price-sale"><?php echo e(number_format($product->price)); ?>₫</span>
                <?php endif; ?>
            </div>
            <form action="<?php echo e(route('cart.add')); ?>" method="POST" class="mt-2">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="product_id" value="<?php echo e($product->id); ?>">
                <button type="submit" class="btn btn-add-cart w-100">
                    <i class="fas fa-cart-plus"></i> Thêm vào giỏ
                </button>
            </form>
        </div>
    </div>
</div>
<?php /**PATH /home/ntsoftware/Downloads/cuahangtienich-admin-aplomb-theme/cuahangtienich/resources/views/products/partials/card.blade.php ENDPATH**/ ?>