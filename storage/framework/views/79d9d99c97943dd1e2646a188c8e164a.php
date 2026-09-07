<?php $__env->startSection('title', 'Đơn hàng của tôi'); ?>
<?php $__env->startSection('content'); ?>
<div class="container py-5">
    <h2 class="mb-4">Đơn hàng của tôi</h2>
    <div class="table-responsive">
        <table class="table">
            <thead><tr><th>Mã đơn</th><th>Ngày đặt</th><th>Tổng tiền</th><th>Trạng thái</th></tr></thead>
            <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($order->order_code); ?></td>
                    <td><?php echo e($order->created_at->format('d/m/Y H:i')); ?></td>
                    <td><?php echo e(number_format($order->total)); ?>₫</td>
                    <td><span class="badge bg-info"><?php echo e($order->status); ?></span></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="4" class="text-center text-muted">Chưa có đơn hàng nào.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php echo e($orders->links()); ?>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ntsoftware/Downloads/cuahangtienich-admin-aplomb-theme/cuahangtienich/resources/views/auth/customer/orders.blade.php ENDPATH**/ ?>