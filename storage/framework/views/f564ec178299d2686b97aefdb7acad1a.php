<?php $__env->startSection('title', 'Cấu hình chung'); ?>
<?php $__env->startSection('content'); ?>
<div class="form-card">
    <h4 class="mb-4">Cấu hình chung website</h4>
    <form action="<?php echo e(route('admin.settings.update')); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>
        <div class="row g-3">
            <?php $__currentLoopData = $fields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-md-6">
                    <label class="form-label"><?php echo e($label); ?></label>
                    <input type="text" name="<?php echo e($key); ?>" class="form-control" value="<?php echo e($values[$key] ?? ''); ?>">
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <button class="btn btn-admin-primary mt-4">Lưu thay đổi</button>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ntsoftware/Downloads/cuahangtienich-admin-aplomb-theme/cuahangtienich/resources/views/admin/settings/index.blade.php ENDPATH**/ ?>