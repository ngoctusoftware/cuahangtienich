<?php $__env->startSection('title', 'Khách hàng'); ?>
<?php $__env->startSection('content'); ?>
<div class="panel">
    <div class="panel-header d-flex justify-content-between align-items-center">
        <form method="GET"><input type="text" name="search" class="form-control form-control-sm" placeholder="Tìm khách hàng..." value="<?php echo e(request('search')); ?>"></form>
        <a href="<?php echo e(route('admin.customers.create')); ?>" class="btn btn-admin-primary btn-sm"><i class="fas fa-plus"></i> Thêm khách hàng</a>
    </div>
    <div class="table-responsive">
        <table class="table mb-0">
            <thead><tr><th>Tên</th><th>Email</th><th>SĐT</th><th>Nhóm</th><th>Trạng thái</th><th></th></tr></thead>
            <tbody>
                <?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($c->name); ?></td>
                        <td><?php echo e($c->email); ?></td>
                        <td><?php echo e($c->phone); ?></td>
                        <td><?php echo e($c->group?->name ?? '—'); ?></td>
                        <td><?php echo $c->is_active ? '<span class="badge bg-success">Hoạt động</span>' : '<span class="badge bg-secondary">Khoá</span>'; ?></td>
                        <td>
                            <a href="<?php echo e(route('admin.customers.edit', $c)); ?>" class="btn btn-sm btn-outline-primary"><i class="fas fa-edit"></i></a>
                            <form action="<?php echo e(route('admin.customers.destroy', $c)); ?>" method="POST" class="d-inline" onsubmit="return confirm('Xoá khách hàng này?')">
                                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
    <div class="p-3"><?php echo e($customers->links()); ?></div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ntsoftware/Downloads/cuahangtienich-admin-aplomb-theme/cuahangtienich/resources/views/admin/customers/index.blade.php ENDPATH**/ ?>