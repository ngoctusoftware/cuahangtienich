<?php $__env->startSection('title', 'Phân quyền'); ?>
<?php $__env->startSection('content'); ?>
<div class="panel">
    <div class="panel-header d-flex justify-content-between align-items-center">
        Quản lý vai trò & phân quyền
        <a href="<?php echo e(route('admin.roles.create')); ?>" class="btn btn-admin-primary btn-sm"><i class="fas fa-plus"></i> Thêm vai trò</a>
    </div>
    <div class="table-responsive">
        <table class="table mb-0">
            <thead><tr><th>Tên vai trò</th><th>Số người dùng</th><th></th></tr></thead>
            <tbody>
                <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($role->name); ?></td>
                        <td><?php echo e($role->users_count); ?></td>
                        <td>
                            <a href="<?php echo e(route('admin.roles.edit', $role)); ?>" class="btn btn-sm btn-outline-primary"><i class="fas fa-edit"></i></a>
                            <?php if($role->slug !== 'super-admin'): ?>
                            <form action="<?php echo e(route('admin.roles.destroy', $role)); ?>" method="POST" class="d-inline" onsubmit="return confirm('Xoá vai trò này?')">
                                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                            </form>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ntsoftware/Downloads/cuahangtienich-admin-aplomb-theme/cuahangtienich/resources/views/admin/roles/index.blade.php ENDPATH**/ ?>