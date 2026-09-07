<?php $__env->startSection('title', $user->exists ? 'Sửa người dùng' : 'Thêm người dùng'); ?>
<?php $__env->startSection('content'); ?>
<div class="form-card">
    <h4 class="mb-4"><?php echo e($user->exists ? 'Sửa người dùng' : 'Thêm người dùng'); ?></h4>
    <form action="<?php echo e($user->exists ? route('admin.users.update', $user) : route('admin.users.store')); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <?php if($user->exists): ?> <?php echo method_field('PUT'); ?> <?php endif; ?>
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Họ tên</label>
                <input type="text" name="name" class="form-control" value="<?php echo e(old('name', $user->name)); ?>" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="<?php echo e(old('email', $user->email)); ?>" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Mật khẩu <?php echo e($user->exists ? '(để trống nếu không đổi)' : ''); ?></label>
                <input type="password" name="password" class="form-control" <?php echo e($user->exists ? '' : 'required'); ?>>
            </div>
            <div class="col-md-6 d-flex align-items-end">
                <div class="form-check">
                    <input type="checkbox" name="is_active" value="1" class="form-check-input" <?php echo e($user->is_active || !$user->exists ? 'checked' : ''); ?>>
                    <label class="form-check-label">Kích hoạt tài khoản</label>
                </div>
            </div>
            <div class="col-12">
                <label class="form-label">Vai trò</label>
                <div class="d-flex flex-wrap gap-3">
                    <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="form-check">
                            <input type="checkbox" name="roles[]" value="<?php echo e($role->id); ?>" class="form-check-input"
                                   <?php echo e($user->roles->contains($role->id) ? 'checked' : ''); ?>>
                            <label class="form-check-label"><?php echo e($role->name); ?></label>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
        <button class="btn btn-admin-primary mt-4">Lưu</button>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ntsoftware/Downloads/cuahangtienich-admin-aplomb-theme/cuahangtienich/resources/views/admin/users/form.blade.php ENDPATH**/ ?>