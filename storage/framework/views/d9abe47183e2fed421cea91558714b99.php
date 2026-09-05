<?php $__env->startSection('title', $content->exists ? 'Sửa nội dung' : 'Thêm nội dung'); ?>
<?php $__env->startSection('content'); ?>
<div class="form-card">
    <h4 class="mb-4"><?php echo e($content->exists ? 'Sửa nội dung' : 'Thêm nội dung'); ?></h4>
    <form action="<?php echo e($content->exists ? route('admin.contents.update', $content) : route('admin.contents.store')); ?>" method="POST" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        <?php if($content->exists): ?> <?php echo method_field('PUT'); ?> <?php endif; ?>
        <div class="row g-3 mb-3">
            <div class="col-md-6">
                <label class="form-label">Key (định danh, vd: home-banner, about-us)</label>
                <input type="text" name="key" class="form-control" value="<?php echo e(old('key', $content->key)); ?>" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">Loại</label>
                <select name="type" class="form-select">
                    <option value="page" <?php echo e($content->type === 'page' ? 'selected' : ''); ?>>Trang</option>
                    <option value="block" <?php echo e($content->type === 'block' ? 'selected' : ''); ?>>Khối nội dung</option>
                    <option value="news" <?php echo e($content->type === 'news' ? 'selected' : ''); ?>>Tin tức</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Ảnh đại diện</label>
                <input type="file" name="image" class="form-control">
            </div>
        </div>

        <ul class="nav nav-tabs mb-3">
            <?php $__currentLoopData = $languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li class="nav-item">
                    <button type="button" class="nav-link <?php echo e($i === 0 ? 'active' : ''); ?>" data-bs-toggle="tab" data-bs-target="#lang-<?php echo e($lang->id); ?>"><?php echo e($lang->name); ?></button>
                </li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
        <div class="tab-content mb-4">
            <?php $__currentLoopData = $languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php $trans = $content->translations->firstWhere('language_id', $lang->id); ?>
                <div class="tab-pane fade <?php echo e($i === 0 ? 'show active' : ''); ?>" id="lang-<?php echo e($lang->id); ?>">
                    <div class="mb-3">
                        <label class="form-label">Tiêu đề (<?php echo e($lang->name); ?>)</label>
                        <input type="text" name="translations[<?php echo e($lang->id); ?>][title]" class="form-control" value="<?php echo e(old("translations.{$lang->id}.title", $trans->title ?? '')); ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nội dung</label>
                        <textarea name="translations[<?php echo e($lang->id); ?>][body]" class="form-control" rows="8"><?php echo e(old("translations.{$lang->id}.body", $trans->body ?? '')); ?></textarea>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <div class="form-check mb-3">
            <input type="checkbox" name="is_active" value="1" class="form-check-input" <?php echo e($content->is_active || !$content->exists ? 'checked' : ''); ?>>
            <label class="form-check-label">Hiển thị trên website</label>
        </div>
        <button class="btn btn-admin-primary">Lưu nội dung</button>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ntsoftware/Downloads/cuahangtienich-admin-aplomb-theme/cuahangtienich/resources/views/admin/contents/form.blade.php ENDPATH**/ ?>