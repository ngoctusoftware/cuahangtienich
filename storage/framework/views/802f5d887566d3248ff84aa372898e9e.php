<?php $__env->startSection('title', $group->exists ? 'Sửa nhóm' : 'Thêm nhóm'); ?>
<?php $__env->startSection('content'); ?>
<div class="form-card">
    <h4 class="mb-4"><?php echo e($group->exists ? 'Sửa nhóm khách hàng' : 'Thêm nhóm khách hàng'); ?></h4>
    <form action="<?php echo e($group->exists ? route('admin.customer-groups.update', $group) : route('admin.customer-groups.store')); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <?php if($group->exists): ?> <?php echo method_field('PUT'); ?> <?php endif; ?>
        <div class="mb-3">
            <label class="form-label">Tên nhóm</label>
            <input type="text" name="name" class="form-control" value="<?php echo e(old('name', $group->name)); ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">% Chiết khấu</label>
            <input type="number" step="0.01" name="discount_percent" class="form-control" value="<?php echo e(old('discount_percent', $group->discount_percent)); ?>">
        </div>
        <button class="btn btn-admin-primary">Lưu</button>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ntsoftware/Downloads/cuahangtienich-admin-aplomb-theme/cuahangtienich/resources/views/admin/customer-groups/form.blade.php ENDPATH**/ ?>