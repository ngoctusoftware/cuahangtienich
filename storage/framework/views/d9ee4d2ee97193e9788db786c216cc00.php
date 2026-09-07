<?php $__env->startSection('title', 'Nội dung'); ?>
<?php $__env->startSection('content'); ?>
<div class="panel">
    <div class="panel-header d-flex justify-content-between align-items-center">
        Quản lý nội dung website
        <a href="<?php echo e(route('admin.contents.create')); ?>" class="btn btn-admin-primary btn-sm"><i class="fas fa-plus"></i> Thêm nội dung</a>
    </div>
    <div class="table-responsive">
        <table class="table mb-0">
            <thead><tr><th>Key</th><th>Loại</th><th>Tiêu đề</th><th>Trạng thái</th><th></th></tr></thead>
            <tbody>
                <?php $__currentLoopData = $contents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><code><?php echo e($c->key); ?></code></td>
                        <td><?php echo e($c->type); ?></td>
                        <td><?php echo e($c->translation()?->title); ?></td>
                        <td><?php echo $c->is_active ? '<span class="badge bg-success">Hiển thị</span>' : '<span class="badge bg-secondary">Ẩn</span>'; ?></td>
                        <td>
                            <a href="<?php echo e(route('admin.contents.edit', $c)); ?>" class="btn btn-sm btn-outline-primary"><i class="fas fa-edit"></i></a>
                            <form action="<?php echo e(route('admin.contents.destroy', $c)); ?>" method="POST" class="d-inline" onsubmit="return confirm('Xoá nội dung này?')">
                                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
    <div class="p-3"><?php echo e($contents->links()); ?></div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ntsoftware/Downloads/cuahangtienich-admin-aplomb-theme/cuahangtienich/resources/views/admin/contents/index.blade.php ENDPATH**/ ?>