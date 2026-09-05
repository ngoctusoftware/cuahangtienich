<?php $__env->startSection('title', $role->exists ? 'Sửa vai trò' : 'Thêm vai trò'); ?>
<?php $__env->startSection('content'); ?>
<div class="form-card">
    <h4 class="mb-4"><?php echo e($role->exists ? 'Sửa vai trò' : 'Thêm vai trò'); ?></h4>
    <form action="<?php echo e($role->exists ? route('admin.roles.update', $role) : route('admin.roles.store')); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <?php if($role->exists): ?> <?php echo method_field('PUT'); ?> <?php endif; ?>
        <div class="mb-4">
            <label class="form-label">Tên vai trò</label>
            <input type="text" name="name" class="form-control" value="<?php echo e(old('name', $role->name)); ?>" required>
        </div>

        <label class="form-label">Phân quyền chi tiết</label>
        <?php $__currentLoopData = $permissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group => $items): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="mb-3">
                <div class="fw-bold text-uppercase small text-muted mb-2"><?php echo e($group); ?></div>
                <div class="d-flex flex-wrap gap-3">
                    <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $perm): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="form-check">
                            <input type="checkbox" name="permissions[]" value="<?php echo e($perm->id); ?>" class="form-check-input"
                                   <?php echo e($role->exists && $role->permissions->contains($perm->id) ? 'checked' : ''); ?>>
                            <label class="form-check-label"><?php echo e($perm->slug); ?></label>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        <button class="btn btn-admin-primary mt-3">Lưu vai trò</button>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ntsoftware/Downloads/cuahangtienich-admin-aplomb-theme/cuahangtienich/resources/views/admin/roles/form.blade.php ENDPATH**/ ?>