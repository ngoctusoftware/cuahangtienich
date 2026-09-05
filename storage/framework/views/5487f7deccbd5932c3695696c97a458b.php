<?php $__env->startSection('title', 'Hồ sơ cá nhân'); ?>
<?php $__env->startSection('content'); ?>
<div class="page-header mb-4">
    <h1 class="page-title">Hồ sơ cá nhân</h1>
    <div class="page-subtitle">Cập nhật thông tin đăng nhập của bạn</div>
</div>
<div class="form-card" style="max-width:520px">
    <h4 class="mb-4">Thông tin tài khoản</h4>
    <form method="POST" action="<?php echo e(route('admin.profile.update')); ?>">
        <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
        <div class="mb-3">
            <label class="form-label">Họ tên</label>
            <input type="text" name="name" class="form-control" value="<?php echo e(old('name', $user->name)); ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="text" class="form-control" value="<?php echo e($user->email); ?>" disabled>
        </div>
        <div class="mb-3">
            <label class="form-label">Số điện thoại</label>
            <input type="text" name="phone" class="form-control" value="<?php echo e(old('phone', $user->phone)); ?>">
        </div>
        <hr class="my-4" style="border-color:rgba(255,255,255,.08)">
        <div class="mb-3">
            <label class="form-label">Mật khẩu mới (để trống nếu không đổi)</label>
            <input type="password" name="password" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Nhập lại mật khẩu mới</label>
            <input type="password" name="password_confirmation" class="form-control">
        </div>
        <button class="btn btn-admin-primary mt-2">Lưu thay đổi</button>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ntsoftware/Downloads/cuahangtienich-admin-aplomb-theme/cuahangtienich/resources/views/admin/profile/edit.blade.php ENDPATH**/ ?>