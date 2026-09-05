<?php $__env->startSection('title', $product->exists ? 'Sửa sản phẩm' : 'Thêm sản phẩm'); ?>
<?php $__env->startSection('content'); ?>
<div class="form-card">
    <h4 class="mb-4"><?php echo e($product->exists ? 'Sửa sản phẩm' : 'Thêm sản phẩm'); ?></h4>
    <form action="<?php echo e($product->exists ? route('admin.products.update', $product) : route('admin.products.store')); ?>" method="POST" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        <?php if($product->exists): ?> <?php echo method_field('PUT'); ?> <?php endif; ?>

        <ul class="nav nav-tabs mb-3">
            <?php $__currentLoopData = $languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li class="nav-item">
                    <button type="button" class="nav-link <?php echo e($i === 0 ? 'active' : ''); ?>" data-bs-toggle="tab" data-bs-target="#lang-<?php echo e($lang->id); ?>"><?php echo e($lang->name); ?></button>
                </li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
        <div class="tab-content mb-4">
            <?php $__currentLoopData = $languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php $trans = $product->translations->firstWhere('language_id', $lang->id); ?>
                <div class="tab-pane fade <?php echo e($i === 0 ? 'show active' : ''); ?>" id="lang-<?php echo e($lang->id); ?>">
                    <div class="mb-3">
                        <label class="form-label">Tên sản phẩm (<?php echo e($lang->name); ?>)</label>
                        <input type="text" name="translations[<?php echo e($lang->id); ?>][name]" class="form-control" value="<?php echo e(old("translations.{$lang->id}.name", $trans->name ?? '')); ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Mô tả ngắn</label>
                        <textarea name="translations[<?php echo e($lang->id); ?>][short_description]" class="form-control" rows="2"><?php echo e(old("translations.{$lang->id}.short_description", $trans->short_description ?? '')); ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Mô tả chi tiết</label>
                        <textarea name="translations[<?php echo e($lang->id); ?>][description]" class="form-control" rows="6"><?php echo e(old("translations.{$lang->id}.description", $trans->description ?? '')); ?></textarea>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label">Danh mục</label>
                <select name="category_id" class="form-select" required>
                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($cat->id); ?>" <?php echo e(old('category_id', $product->category_id) == $cat->id ? 'selected' : ''); ?>><?php echo e($cat->translation()?->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">Mã SKU</label>
                <input type="text" name="sku" class="form-control" value="<?php echo e(old('sku', $product->sku)); ?>" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Ảnh đại diện</label>
                <input type="file" name="thumbnail" class="form-control">
            </div>
            <div class="col-md-4">
                <label class="form-label">Giá gốc</label>
                <input type="number" name="price" class="form-control" value="<?php echo e(old('price', $product->price)); ?>" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Giá khuyến mãi</label>
                <input type="number" name="sale_price" class="form-control" value="<?php echo e(old('sale_price', $product->sale_price)); ?>">
            </div>
            <div class="col-md-4">
                <label class="form-label">Tồn kho</label>
                <input type="number" name="stock" class="form-control" value="<?php echo e(old('stock', $product->stock)); ?>">
            </div>
            <div class="col-md-4">
                <div class="form-check">
                    <input type="checkbox" name="is_featured" value="1" class="form-check-input" <?php echo e($product->is_featured ? 'checked' : ''); ?>>
                    <label class="form-check-label">Sản phẩm nổi bật</label>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-check">
                    <input type="checkbox" name="is_bestseller" value="1" class="form-check-input" <?php echo e($product->is_bestseller ? 'checked' : ''); ?>>
                    <label class="form-check-label">Sản phẩm bán chạy</label>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-check">
                    <input type="checkbox" name="is_active" value="1" class="form-check-input" <?php echo e($product->is_active || !$product->exists ? 'checked' : ''); ?>>
                    <label class="form-check-label">Kích hoạt</label>
                </div>
            </div>
        </div>
        <button class="btn btn-admin-primary mt-4">Lưu sản phẩm</button>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ntsoftware/Downloads/cuahangtienich-admin-aplomb-theme/cuahangtienich/resources/views/admin/products/form.blade.php ENDPATH**/ ?>