
<?php echo field()->langNavTabs(); ?>


<div class="tab-content">
    <?php $__currentLoopData = config('laravellocalization.supportedLocales'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $code => $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="tab-pane fade in <?php echo e(($code == locale()) ? 'active' : ''); ?>"
             id="first_<?php echo e($code); ?>">
            <?php echo field()->text('title['.$code.']',
            __('category::dashboard.categories.form.title').'-'.$code ,
                    $model->getTranslation('title' , $code),
                  ['data-name' => 'title.'.$code]
             ); ?>

        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>


<div class="form-group">
    <label class="col-md-2">
        <?php echo e(__('category::dashboard.categories.form.color')); ?>

    </label>
    <div class="col-md-3">
        <input type="color" name="color" class="form-control" data-name="color" value="<?php echo e($model->color ?? "#1888c9"); ?>">
        <div class="help-block"></div>
    </div>
</div>

<div class="form-group">
    <label class="col-md-2">
        <?php echo e(__('category::dashboard.categories.form.width_ratio')); ?>

    </label>
    <div class="col-md-9">
        <select class="form-control select2" name="width_ratio">
            <option value="1x" <?php echo e($model?->id ? ($model?->width_ratio && $model?->width_ratio == '1X' ? 'selected' : '') : 'selected'); ?>>1X</option>
            <option value="2x" <?php echo e($model?->width_ratio && $model?->width_ratio == '2X' ? 'selected' : ''); ?>>2X</option>
        </select>
        <div class="help-block"></div>
    </div>
</div>

<div class="form-group">
    <label class="col-md-2">
        <?php echo e(__('category::dashboard.categories.form.height_ratio')); ?>

    </label>
    <div class="col-md-9">
        <select class="form-control select2" name="height_ratio">
            <option value="1x" <?php echo e($model?->id ? ($model?->height_ratio && $model?->height_ratio == '1X' ? 'selected' : '') : 'selected'); ?>>1X</option>
            <option value="2x" <?php echo e($model?->height_ratio && $model?->height_ratio == '2X' ? 'selected' : ''); ?>>2X</option>
        </select>
        <div class="help-block"></div>
    </div>
</div>

<?php echo field()->file('image', __('category::dashboard.categories.form.image'), $model->getFirstMediaUrl('images')); ?>

<?php echo field()->number('order', __('category::dashboard.categories.form.sort')); ?>

<?php echo field()->checkBox('status', __('category::dashboard.categories.form.status')); ?>

<?php if($model->trashed()): ?>
    <?php echo field()->checkBox('trash_restore', __('category::dashboard.categories.form.restore')); ?>

<?php endif; ?>
<?php echo Form::hidden('category_id' , null ,['id' => 'root_category']); ?>

<?php /**PATH /home/ahmed-nabil94/Desktop/PhpstormProjects/RoyalCard-Backend/Modules/Category/Resources/views/dashboard/categories/form.blade.php ENDPATH**/ ?>