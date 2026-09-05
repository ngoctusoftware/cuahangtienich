<?php $__env->startSection('title', 'Chi tiết đơn hàng #' . $order->order_code); ?>
<?php $__env->startSection('content'); ?>
<div class="row g-4">
    <div class="col-lg-8">
        <div class="panel">
            <div class="panel-header">Sản phẩm trong đơn</div>
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead><tr><th>Sản phẩm</th><th>Giá</th><th>SL</th><th>Thành tiền</th></tr></thead>
                    <tbody>
                        <?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($item->product_name); ?></td>
                                <td><?php echo e(number_format($item->price)); ?>₫</td>
                                <td><?php echo e($item->quantity); ?></td>
                                <td><?php echo e(number_format($item->line_total)); ?>₫</td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="panel mb-4">
            <div class="panel-header">Thông tin giao hàng</div>
            <div class="p-3">
                <p><strong>Người nhận:</strong> <?php echo e($order->receiver_name); ?></p>
                <p><strong>SĐT:</strong> <?php echo e($order->receiver_phone); ?></p>
                <p><strong>Địa chỉ:</strong> <?php echo e($order->receiver_address); ?></p>
                <p><strong>Ghi chú:</strong> <?php echo e($order->note ?? '—'); ?></p>
                <p><strong>Tổng tiền:</strong> <?php echo e(number_format($order->total)); ?>₫</p>
            </div>
        </div>
        <div class="panel">
            <div class="panel-header">Cập nhật trạng thái</div>
            <form action="<?php echo e(route('admin.orders.updateStatus', $order)); ?>" method="POST" class="p-3">
                <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
                <select name="status" class="form-select mb-3">
                    <?php $__currentLoopData = ['pending'=>'Chờ xử lý','confirmed'=>'Đã xác nhận','shipping'=>'Đang giao','completed'=>'Hoàn thành','cancelled'=>'Đã huỷ']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($key); ?>" <?php echo e($order->status === $key ? 'selected' : ''); ?>><?php echo e($label); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <button class="btn btn-admin-primary w-100">Cập nhật</button>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ntsoftware/Downloads/cuahangtienich-admin-aplomb-theme/cuahangtienich/resources/views/admin/orders/show.blade.php ENDPATH**/ ?>