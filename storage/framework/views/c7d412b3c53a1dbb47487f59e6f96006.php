<?php $__env->startSection('title', 'Thanh toán - ' . ($siteName ?? 'ZEK SHOP')); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-5">
    <h2 class="mb-4">Thông tin thanh toán</h2>
    <div class="row g-5">
        <div class="col-lg-7">
            <form action="<?php echo e(route('checkout.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="mb-3">
                    <label class="form-label">Họ tên người nhận</label>
                    <input type="text" name="name" class="form-control" value="<?php echo e(old('name', auth('customer')->user()->name ?? '')); ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Số điện thoại</label>
                    <input type="text" name="phone" class="form-control" value="<?php echo e(old('phone', auth('customer')->user()->phone ?? '')); ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Địa chỉ nhận hàng</label>
                    <textarea name="address" class="form-control" rows="3" required><?php echo e(old('address', auth('customer')->user()->address ?? '')); ?></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Ghi chú</label>
                    <textarea name="note" class="form-control" rows="2"></textarea>
                </div>

                <h5 class="mt-4 mb-3">Phương thức thanh toán</h5>
                <div class="form-check mb-2">
                    <input class="form-check-input" type="radio" name="payment_method" value="cod" id="cod" checked>
                    <label class="form-check-label" for="cod"><i class="fas fa-truck me-2"></i>Thanh toán khi nhận hàng (COD)</label>
                </div>
                <div class="form-check mb-2">
                    <input class="form-check-input" type="radio" name="payment_method" value="bank_transfer" id="bank">
                    <label class="form-check-label" for="bank"><i class="fas fa-university me-2"></i>Chuyển khoản ngân hàng</label>
                </div>
                <div class="form-check mb-4">
                    <input class="form-check-input" type="radio" name="payment_method" value="online" id="online">
                    <label class="form-check-label" for="online"><i class="fas fa-credit-card me-2"></i>Thanh toán trực tuyến (VNPay/Momo)</label>
                </div>

                <button type="submit" class="btn btn-hero-cta w-100">ĐẶT HÀNG</button>
            </form>
        </div>
        <div class="col-lg-5">
            <div class="checkout-summary">
                <h5 class="mb-3">Đơn hàng của bạn</h5>
                <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="d-flex justify-content-between mb-2">
                        <span><?php echo e($item['name']); ?> x<?php echo e($item['quantity']); ?></span>
                        <span><?php echo e(number_format($item['price'] * $item['quantity'])); ?>₫</span>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <hr>
                <div class="d-flex justify-content-between fw-bold fs-5">
                    <span>Tổng cộng:</span>
                    <span><?php echo e(number_format($total)); ?>₫</span>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ntsoftware/Downloads/cuahangtienich-admin-aplomb-theme/cuahangtienich/resources/views/checkout/index.blade.php ENDPATH**/ ?>