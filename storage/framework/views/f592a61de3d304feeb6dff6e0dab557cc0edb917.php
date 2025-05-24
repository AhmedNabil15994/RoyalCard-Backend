<?php $categories = app("\Modules\Category\Entities\Category"); ?>
<?php $products = app("\Modules\Catalog\Entities\Product"); ?>
<style>
    .hide-inputs{
        display: none;
    }
</style>
<?php echo field()->langNavTabs(); ?>


<div class="tab-content">
    <?php $__currentLoopData = config('laravellocalization.supportedLocales'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $code => $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="tab-pane fade in <?php echo e(($code == locale()) ? 'active' : ''); ?>"
        id="first_<?php echo e($code); ?>">
        <?php echo field()->text('title['.$code.']',
        __('slider::dashboard.sliders.form.title').'-'.$code ,
        $model->getTranslation('title',$code),
        ['data-name' => 'title.'.$code]
        ); ?>

        <div class="form-group">
            <label for="" class="col-md-2"><?php echo e(__('slider::dashboard.sliders.form.description').'-'.$code); ?></label>
            <div class="col-md-9">
                <textarea name="description[<?php echo e($code); ?>]" rows="8" cols="80" class="form-control <?php echo e(is_rtl($code)); ?>Editor" data-name="description.<?php echo e($code); ?>"><?php echo e($model->description); ?></textarea>
                <div class="help-block"></div>
            </div>
        </div>

    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>

<div class="form-group">
    <label for="" class="col-md-2"><?php echo e(__('slider::dashboard.sliders.form.link_type')); ?></label>
    <div class="col-md-9">
        <select name="type" class="form-control select2">
            <option value="">Select Type</option>
            <option value="external" <?php echo e($model?->type == 'external' ? 'selected' : ''); ?>><?php echo e(__('slider::dashboard.sliders.form.external_link')); ?></option>
            <option value="category" <?php echo e($model?->type == 'category' ? 'selected' : ''); ?>><?php echo e(__('slider::dashboard.sliders.form.categories')); ?></option>
            <option value="product" <?php echo e($model?->type == 'product' ? 'selected' : ''); ?>><?php echo e(__('slider::dashboard.sliders.form.products')); ?></option>
        </select>
        <div class="help-block"></div>
    </div>
</div>


<div class="form-group hide-inputs" id="external-input" style="display: <?php echo e($model?->type == 'external' ? 'block' : 'none'); ?>">
    <label for="" class="col-md-2"><?php echo e(__('slider::dashboard.sliders.form.link')); ?></label>
    <div class="col-md-9">
        <input type="text" class="form-control" value="<?php echo e($model?->type == 'external' && $model?->link ?? ''); ?>" name="link" placeholder="<?php echo e(__('slider::dashboard.sliders.form.link')); ?>">
        <div class="help-block"></div>
    </div>
</div>

<div class="form-group hide-inputs" id="category-input" style="display: <?php echo e($model?->type == 'category' ? 'block' : 'none'); ?>">
    <label for="" class="col-md-2"><?php echo e(__('slider::dashboard.sliders.form.category')); ?></label>
    <div class="col-md-9">
        <select name="category_id" class="form-control select2">
            <option value=""><?php echo e(__('slider::dashboard.sliders.form.category')); ?></option>
            <?php $__currentLoopData = $categories->active()->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($category->id); ?>" <?php echo e($model?->type == 'category' && $model?->link == $category->id ? 'selected' : ''); ?>><?php echo e($category->title); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
        <div class="help-block"></div>
    </div>
</div>

<div class="form-group hide-inputs" id="product-input" style="display: <?php echo e($model?->type == 'product' ? 'block' : 'none'); ?>">
    <label for="" class="col-md-2"><?php echo e(__('slider::dashboard.sliders.form.product')); ?></label>
    <div class="col-md-9">
        <select name="product_id" class="form-control select2">
            <option value=""><?php echo e(__('slider::dashboard.sliders.form.product')); ?></option>
            <?php $__currentLoopData = $products->active()->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($product->id); ?>" <?php echo e($model?->type == 'product' && $model?->link == $product->id ? 'selected' : ''); ?>><?php echo e($product->title); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
        <div class="help-block"></div>
    </div>
</div>

<?php echo field()->number('order', __('slider::dashboard.sliders.form.order')); ?>

<?php echo field()->file('image', __('slider::dashboard.sliders.form.image'), $model->getFirstMediaUrl('images')); ?>

<?php echo field()->checkBox('status', __('slider::dashboard.sliders.form.status')); ?>


<?php if($model->trashed()): ?>
<?php echo field()->checkBox('trash_restore', __('slider::dashboard.sliders.form.restore')); ?>

<?php endif; ?>



<?php $__env->startPush('start_scripts'); ?>
<script>
    $('[name=type]').change(function () {
        $('.hide-inputs').hide();
        $('#' + this.value + '-input').show();
    });
</script>
<?php $__env->stopPush(); ?>
<?php /**PATH /home/ahmed-nabil94/Desktop/PhpstormProjects/RoyalCard-Backend/Modules/Slider/Resources/views/dashboard/sliders/form.blade.php ENDPATH**/ ?>