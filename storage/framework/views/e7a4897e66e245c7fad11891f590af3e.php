<?php $__env->startSection('title', 'Sản phẩm'); ?>
<?php $__env->startSection('content'); ?>
<div class="panel">
    <div class="panel-header d-flex justify-content-between align-items-center">
        <form class="d-flex gap-2" method="GET">
            <input type="text" name="search" class="form-control form-control-sm" placeholder="Tìm sản phẩm..." value="<?php echo e(request('search')); ?>">
        </form>
        <a href="<?php echo e(route('admin.products.create')); ?>" class="btn btn-admin-primary btn-sm"><i class="fas fa-plus"></i> Thêm sản phẩm</a>
    </div>
    <div class="table-responsive">
        <table class="table mb-0 align-middle">
            <thead><tr><th>Ảnh</th><th>Tên</th><th>Danh mục</th><th>Giá</th><th>Kho</th><th>Nổi bật</th><th>Bán chạy</th><th>Trạng thái</th><th></th></tr></thead>
            <tbody>
                <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><img src="<?php echo e($p->thumbnail ? asset('storage/'.$p->thumbnail) : asset('images/product-placeholder.jpg')); ?>" width="48" height="48" style="object-fit:cover;border-radius:6px"></td>
                        <td><?php echo e($p->translation()?->name); ?></td>
                        <td><?php echo e($p->category->translation()?->name); ?></td>
                        <td><?php echo e(number_format($p->price)); ?>₫</td>
                        <td><?php echo e($p->stock); ?></td>
                        <td><?php echo $p->is_featured ? '<i class="fas fa-check text-success"></i>' : ''; ?></td>
                        <td><?php echo $p->is_bestseller ? '<i class="fas fa-check text-success"></i>' : ''; ?></td>
                        <td><?php echo $p->is_active ? '<span class="badge bg-success">Hoạt động</span>' : '<span class="badge bg-secondary">Ẩn</span>'; ?></td>
                        <td>
                            <a href="<?php echo e(route('admin.products.edit', $p)); ?>" class="btn btn-sm btn-outline-primary"><i class="fas fa-edit"></i></a>
                            <form action="<?php echo e(route('admin.products.destroy', $p)); ?>" method="POST" class="d-inline" onsubmit="return confirm('Xoá sản phẩm này?')">
                                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
    <div class="p-3"><?php echo e($products->links()); ?></div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ntsoftware/Downloads/cuahangtienich-admin-aplomb-theme/cuahangtienich/resources/views/admin/products/index.blade.php ENDPATH**/ ?>