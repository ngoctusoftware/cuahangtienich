<?php $__env->startSection('title', 'Giỏ hàng - ' . ($siteName ?? 'ZEK SHOP')); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-5">
    <h2 class="mb-4">Giỏ hàng của bạn</h2>

    <?php if(empty($items)): ?>
        <p>Giỏ hàng đang trống. <a href="<?php echo e(route('home')); ?>">Tiếp tục mua sắm</a></p>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>Sản phẩm</th>
                        <th>Đơn giá</th>
                        <th>Số lượng</th>
                        <th>Thành tiền</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $productId => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($item['name']); ?></td>
                            <td><?php echo e(number_format($item['price'])); ?>₫</td>
                            <td style="width: 120px">
                                <form action="<?php echo e(route('cart.update')); ?>" method="POST" class="d-flex">
                                    <?php echo csrf_field(); ?>
                                    <input type="hidden" name="product_id" value="<?php echo e($productId); ?>">
                                    <input type="number" name="quantity" value="<?php echo e($item['quantity']); ?>" min="1"
                                           class="form-control form-control-sm" onchange="this.form.submit()">
                                </form>
                            </td>
                            <td><?php echo e(number_format($item['price'] * $item['quantity'])); ?>₫</td>
                            <td>
                                <form action="<?php echo e(route('cart.remove')); ?>" method="POST">
                                    <?php echo csrf_field(); ?>
                                    <input type="hidden" name="product_id" value="<?php echo e($productId); ?>">
                                    <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-end">
            <div class="cart-summary">
                <div class="d-flex justify-content-between mb-2">
                    <span>Tạm tính:</span>
                    <strong><?php echo e(number_format($total)); ?>₫</strong>
                </div>
                <a href="<?php echo e(route('checkout.index')); ?>" class="btn btn-hero-cta w-100">TIẾN HÀNH THANH TOÁN</a>
            </div>
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ntsoftware/Downloads/cuahangtienich-admin-aplomb-theme/cuahangtienich/resources/views/cart/index.blade.php ENDPATH**/ ?>