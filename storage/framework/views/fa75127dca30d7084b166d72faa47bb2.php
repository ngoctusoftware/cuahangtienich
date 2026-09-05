<?php $__env->startSection('title', 'Thanh toán'); ?>
<?php $__env->startSection('content'); ?>
<div class="panel">
    <div class="panel-header">Danh sách thanh toán</div>
    <div class="table-responsive">
        <table class="table mb-0">
            <thead><tr><th>Mã đơn</th><th>Phương thức</th><th>Số tiền</th><th>Mã giao dịch</th><th>Trạng thái</th><th></th></tr></thead>
            <tbody>
                <?php $__currentLoopData = $payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($payment->order->order_code); ?></td>
                        <td><?php echo e($payment->method); ?></td>
                        <td><?php echo e(number_format($payment->amount)); ?>₫</td>
                        <td><?php echo e($payment->transaction_code ?? '—'); ?></td>
                        <td>
                            <form action="<?php echo e(route('admin.payments.updateStatus', $payment)); ?>" method="POST" class="d-flex gap-2">
                                <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
                                <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                                    <?php $__currentLoopData = ['pending'=>'Chờ','paid'=>'Đã thanh toán','failed'=>'Thất bại','refunded'=>'Hoàn tiền']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($key); ?>" <?php echo e($payment->status === $key ? 'selected' : ''); ?>><?php echo e($label); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </form>
                        </td>
                        <td></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
    <div class="p-3"><?php echo e($payments->links()); ?></div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ntsoftware/Downloads/cuahangtienich-admin-aplomb-theme/cuahangtienich/resources/views/admin/payments/index.blade.php ENDPATH**/ ?>