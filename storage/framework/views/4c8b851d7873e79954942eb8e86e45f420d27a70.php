<div class="row">
    <div class="mt-radio-inline text-center">
        <label class="mt-radio mt-radio-outline">
            <?php echo e(__('catalog::dashboard.products.form.product_type.digital')); ?>

            <input type="radio" name="product_type" value="digital" <?php echo e($model && $model->id ?  ($model->product_type == 'digital' ? 'checked' : '') : 'checked'); ?>>
            <span></span>
        </label>
        <label class="mt-radio mt-radio-outline hidden">
            <?php echo e(__('catalog::dashboard.products.form.product_type.physical')); ?>

            <input type="radio" name="product_type" value="physical" <?php echo e($model && $model->id ?  ($model->product_type == 'physical' ? 'checked' : '') : ''); ?>>
            <span></span>
        </label>
        <label class="mt-radio mt-radio-outline">
            <?php echo e(__('catalog::dashboard.products.form.product_type.support')); ?>

            <input type="radio" name="product_type" value="support" <?php echo e($model && $model->id ?  ($model->product_type == 'support' ? 'checked' : '') : ''); ?>>
            <span></span>
        </label>
    </div>
</div>
<?php /**PATH /home/ahmed-nabil94/Desktop/PhpstormProjects/RoyalCard-Backend/Modules/Catalog/Resources/views/dashboard/products/components/product_types.blade.php ENDPATH**/ ?>