<?php $__env->startSection('title', 'Ngôn ngữ'); ?>
<?php $__env->startSection('content'); ?>
<div class="panel">
    <div class="panel-header d-flex justify-content-between align-items-center">
        Quản lý ngôn ngữ
        <a href="<?php echo e(route('admin.languages.create')); ?>" class="btn btn-admin-primary btn-sm"><i class="fas fa-plus"></i> Thêm ngôn ngữ</a>
    </div>
    <div class="table-responsive">
        <table class="table mb-0">
            <thead><tr><th>Mã</th><th>Tên</th><th>Mặc định</th><th>Kích hoạt</th><th>Thứ tự</th><th></th></tr></thead>
            <tbody>
                <?php $__currentLoopData = $languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($lang->code); ?></td>
                        <td><?php echo e($lang->name); ?></td>
                        <td><?php echo $lang->is_default ? '<span class="badge bg-success">Có</span>' : ''; ?></td>
                        <td><?php echo $lang->is_active ? '<span class="badge bg-info">Bật</span>' : '<span class="badge bg-secondary">Tắt</span>'; ?></td>
                        <td><?php echo e($lang->sort_order); ?></td>
                        <td>
                            <a href="<?php echo e(route('admin.languages.edit', $lang)); ?>" class="btn btn-sm btn-outline-primary"><i class="fas fa-edit"></i></a>
                            <form action="<?php echo e(route('admin.languages.destroy', $lang)); ?>" method="POST" class="d-inline" onsubmit="return confirm('Xoá ngôn ngữ này?')">
                                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ntsoftware/Downloads/cuahangtienich-admin-aplomb-theme/cuahangtienich/resources/views/admin/languages/index.blade.php ENDPATH**/ ?>