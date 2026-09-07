<?php $__env->startSection('title', 'Danh mục'); ?>
<?php $__env->startSection('content'); ?>
<div class="panel">
    <div class="panel-header d-flex justify-content-between align-items-center">
        Quản lý danh mục
        <a href="<?php echo e(route('admin.categories.create')); ?>" class="btn btn-admin-primary btn-sm"><i class="fas fa-plus"></i> Thêm danh mục</a>
    </div>
    <div class="table-responsive">
        <table class="table mb-0">
            <thead><tr><th>Tên</th><th>Danh mục cha</th><th>Thứ tự</th><th>Trạng thái</th><th></th></tr></thead>
            <tbody>
                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($cat->translation()?->name); ?></td>
                        <td><?php echo e($cat->parent?->translation()?->name ?? '—'); ?></td>
                        <td><?php echo e($cat->sort_order); ?></td>
                        <td><?php echo $cat->is_active ? '<span class="badge bg-success">Hoạt động</span>' : '<span class="badge bg-secondary">Ẩn</span>'; ?></td>
                        <td>
                            <a href="<?php echo e(route('admin.categories.edit', $cat)); ?>" class="btn btn-sm btn-outline-primary"><i class="fas fa-edit"></i></a>
                            <form action="<?php echo e(route('admin.categories.destroy', $cat)); ?>" method="POST" class="d-inline" onsubmit="return confirm('Xoá danh mục này?')">
                                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
    <div class="p-3"><?php echo e($categories->links()); ?></div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ntsoftware/Downloads/cuahangtienich-admin-aplomb-theme/cuahangtienich/resources/views/admin/categories/index.blade.php ENDPATH**/ ?>