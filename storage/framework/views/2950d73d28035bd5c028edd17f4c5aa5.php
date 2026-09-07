<?php $__env->startSection('title', 'Nhóm khách hàng'); ?>
<?php $__env->startSection('content'); ?>
<div class="panel">
    <div class="panel-header d-flex justify-content-between align-items-center">
        Nhóm khách hàng
        <a href="<?php echo e(route('admin.customer-groups.create')); ?>" class="btn btn-admin-primary btn-sm"><i class="fas fa-plus"></i> Thêm nhóm</a>
    </div>
    <div class="table-responsive">
        <table class="table mb-0">
            <thead><tr><th>Tên nhóm</th><th>% Chiết khấu</th><th>Số khách</th><th></th></tr></thead>
            <tbody>
                <?php $__currentLoopData = $groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $g): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($g->name); ?></td>
                        <td><?php echo e($g->discount_percent); ?>%</td>
                        <td><?php echo e($g->customers_count); ?></td>
                        <td>
                            <a href="<?php echo e(route('admin.customer-groups.edit', $g)); ?>" class="btn btn-sm btn-outline-primary"><i class="fas fa-edit"></i></a>
                            <form action="<?php echo e(route('admin.customer-groups.destroy', $g)); ?>" method="POST" class="d-inline" onsubmit="return confirm('Xoá nhóm này?')">
                                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ntsoftware/Downloads/cuahangtienich-admin-aplomb-theme/cuahangtienich/resources/views/admin/customer-groups/index.blade.php ENDPATH**/ ?>