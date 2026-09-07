<?php $__env->startSection('title', $category->exists ? 'Sửa danh mục' : 'Thêm danh mục'); ?>
<?php $__env->startSection('content'); ?>
<div class="form-card">
    <h4 class="mb-4"><?php echo e($category->exists ? 'Sửa danh mục' : 'Thêm danh mục'); ?></h4>
    <form action="<?php echo e($category->exists ? route('admin.categories.update', $category) : route('admin.categories.store')); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <?php if($category->exists): ?> <?php echo method_field('PUT'); ?> <?php endif; ?>

        
        <ul class="nav nav-tabs mb-3">
            <?php $__currentLoopData = $languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li class="nav-item">
                    <button type="button" class="nav-link <?php echo e($i === 0 ? 'active' : ''); ?>" data-bs-toggle="tab" data-bs-target="#lang-<?php echo e($lang->id); ?>"><?php echo e($lang->name); ?></button>
                </li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
        <div class="tab-content mb-4">
            <?php $__currentLoopData = $languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php $trans = $category->translations->firstWhere('language_id', $lang->id); ?>
                <div class="tab-pane fade <?php echo e($i === 0 ? 'show active' : ''); ?>" id="lang-<?php echo e($lang->id); ?>">
                    <div class="mb-3">
                        <label class="form-label">Tên danh mục (<?php echo e($lang->name); ?>)</label>
                        <input type="text" name="translations[<?php echo e($lang->id); ?>][name]" class="form-control" value="<?php echo e(old("translations.{$lang->id}.name", $trans->name ?? '')); ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Mô tả</label>
                        <textarea name="translations[<?php echo e($lang->id); ?>][description]" class="form-control" rows="3"><?php echo e(old("translations.{$lang->id}.description", $trans->description ?? '')); ?></textarea>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Danh mục cha</label>
                <select name="parent_id" class="form-select">
                    <option value="">-- Không có --</option>
                    <?php $__currentLoopData = $parents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($p->id); ?>" <?php echo e(old('parent_id', $category->parent_id) == $p->id ? 'selected' : ''); ?>><?php echo e($p->translation()?->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Thứ tự</label>
                <input type="number" name="sort_order" class="form-control" value="<?php echo e(old('sort_order', $category->sort_order)); ?>">
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <div class="form-check">
                    <input type="checkbox" name="is_active" value="1" class="form-check-input" <?php echo e($category->is_active || !$category->exists ? 'checked' : ''); ?>>
                    <label class="form-check-label">Kích hoạt</label>
                </div>
            </div>
        </div>
        <button class="btn btn-admin-primary mt-4">Lưu danh mục</button>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ntsoftware/Downloads/cuahangtienich-admin-aplomb-theme/cuahangtienich/resources/views/admin/categories/form.blade.php ENDPATH**/ ?>