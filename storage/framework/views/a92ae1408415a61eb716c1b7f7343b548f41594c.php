<div class="tab-pane fade in support <?php echo e($model && $model->id ?  ($model->product_type == 'support' ? '' : 'hidden') : 'hidden'); ?>" id="servers">
    <div class="form-group">
        <label class="col-md-2">
            <?php echo e(__('catalog::dashboard.products.form.available_servers')); ?>

        </label>
        <div class="col-md-9">
            <select name="available_servers[]" class="form-control select2" multiple>
                <?php $__currentLoopData = $servers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $server): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($server->id); ?>"  <?php echo e($model && $model->id  ? (in_array($server->id,json_decode($model->available_servers,true) ?? []) ? 'selected' : '') : ''); ?>><?php echo e($server->title); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <div class="help-block"></div>
        </div>
    </div>
</div>
<?php /**PATH /home/ahmed-nabil94/Desktop/PhpstormProjects/RoyalCard-Backend/Modules/Catalog/Resources/views/dashboard/products/components/servers.blade.php ENDPATH**/ ?>