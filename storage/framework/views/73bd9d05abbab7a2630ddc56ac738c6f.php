<?php $__env->startSection('title', 'Đặt hàng thành công'); ?>
<?php $__env->startSection('content'); ?>
<div class="container py-5 text-center">
    <i class="fas fa-check-circle text-success" style="font-size: 64px;"></i>
    <h2 class="mt-3">Đặt hàng thành công!</h2>
    <p>Mã đơn hàng của bạn: <strong><?php echo e($orderCode); ?></strong></p>
    <p>Chúng tôi sẽ liên hệ xác nhận đơn hàng trong thời gian sớm nhất.</p>
    <a href="<?php echo e(route('home')); ?>" class="btn btn-hero-cta mt-3">Tiếp tục mua sắm</a>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ntsoftware/Downloads/cuahangtienich-admin-aplomb-theme/cuahangtienich/resources/views/checkout/success.blade.php ENDPATH**/ ?>