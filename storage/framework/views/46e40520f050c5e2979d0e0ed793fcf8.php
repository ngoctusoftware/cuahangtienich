<?php $__env->startSection('title', $language->exists ? 'Sửa ngôn ngữ' : 'Thêm ngôn ngữ'); ?>
<?php $__env->startSection('content'); ?>
<div class="form-card">
    <h4 class="mb-4"><?php echo e($language->exists ? 'Sửa ngôn ngữ' : 'Thêm ngôn ngữ'); ?></h4>
    <form action="<?php echo e($language->exists ? route('admin.languages.update', $language) : route('admin.languages.store')); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <?php if($language->exists): ?> <?php echo method_field('PUT'); ?> <?php endif; ?>
        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label">Mã ngôn ngữ (vi, en...)</label>
                <input type="text" name="code" class="form-control" value="<?php echo e(old('code', $language->code)); ?>" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Tên hiển thị</label>
                <input type="text" name="name" class="form-control" value="<?php echo e(old('name', $language->name)); ?>" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Thứ tự</label>
                <input type="number" name="sort_order" class="form-control" value="<?php echo e(old('sort_order', $language->sort_order)); ?>">
            </div>
            <div class="col-md-6">
                <div class="form-check">
                    <input type="checkbox" name="is_default" value="1" class="form-check-input" <?php echo e($language->is_default ? 'checked' : ''); ?>>
                    <label class="form-check-label">Ngôn ngữ mặc định</label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-check">
                    <input type="checkbox" name="is_active" value="1" class="form-check-input" <?php echo e($language->is_active || !$language->exists ? 'checked' : ''); ?>>
                    <label class="form-check-label">Kích hoạt</label>
                </div>
            </div>
        </div>
        <button class="btn btn-admin-primary mt-4">Lưu</button>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ntsoftware/Downloads/cuahangtienich-admin-aplomb-theme/cuahangtienich/resources/views/admin/languages/form.blade.php ENDPATH**/ ?>