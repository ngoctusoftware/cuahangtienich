<?php $__env->startSection('title', $customer->exists ? 'Sửa khách hàng' : 'Thêm khách hàng'); ?>
<?php $__env->startSection('content'); ?>
<div class="form-card">
    <h4 class="mb-4"><?php echo e($customer->exists ? 'Sửa khách hàng' : 'Thêm khách hàng'); ?></h4>
    <form action="<?php echo e($customer->exists ? route('admin.customers.update', $customer) : route('admin.customers.store')); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <?php if($customer->exists): ?> <?php echo method_field('PUT'); ?> <?php endif; ?>
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Họ tên</label>
                <input type="text" name="name" class="form-control" value="<?php echo e(old('name', $customer->name)); ?>" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="<?php echo e(old('email', $customer->email)); ?>" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Số điện thoại</label>
                <input type="text" name="phone" class="form-control" value="<?php echo e(old('phone', $customer->phone)); ?>">
            </div>
            <div class="col-md-6">
                <label class="form-label">Nhóm khách hàng</label>
                <select name="customer_group_id" class="form-select">
                    <option value="">-- Không có --</option>
                    <?php $__currentLoopData = $groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $g): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($g->id); ?>" <?php echo e(old('customer_group_id', $customer->customer_group_id) == $g->id ? 'selected' : ''); ?>><?php echo e($g->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">Mật khẩu <?php echo e($customer->exists ? '(để trống nếu không đổi)' : ''); ?></label>
                <input type="password" name="password" class="form-control" <?php echo e($customer->exists ? '' : 'required'); ?>>
            </div>
            <div class="col-md-6 d-flex align-items-end">
                <div class="form-check">
                    <input type="checkbox" name="is_active" value="1" class="form-check-input" <?php echo e($customer->is_active || !$customer->exists ? 'checked' : ''); ?>>
                    <label class="form-check-label">Kích hoạt tài khoản</label>
                </div>
            </div>
        </div>
        <button class="btn btn-admin-primary mt-4">Lưu</button>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ntsoftware/Downloads/cuahangtienich-admin-aplomb-theme/cuahangtienich/resources/views/admin/customers/form.blade.php ENDPATH**/ ?>