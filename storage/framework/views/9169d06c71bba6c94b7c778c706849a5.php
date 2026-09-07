<?php $__env->startSection('title', ($content->translation()?->title ?? '') . ' - ' . ($siteName ?? 'ZEK SHOP')); ?>
<?php $__env->startSection('content'); ?>
<div class="container py-5">
    <h1 class="mb-4"><?php echo e($content->translation()?->title); ?></h1>
    <div class="page-body">
        <?php echo $content->translation()?->body; ?>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ntsoftware/Downloads/cuahangtienich-admin-aplomb-theme/cuahangtienich/resources/views/pages/show.blade.php ENDPATH**/ ?>