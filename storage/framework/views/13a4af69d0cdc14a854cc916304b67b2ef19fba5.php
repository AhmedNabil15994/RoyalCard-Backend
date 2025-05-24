
<?php echo field()->langNavTabs(); ?>


<div class="tab-content">
    <?php $__currentLoopData = config('laravellocalization.supportedLocales'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $code => $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="tab-pane fade in <?php echo e(($code == locale()) ? 'active' : ''); ?>"
             id="first_<?php echo e($code); ?>">
            <?php echo field()->text('title['.$code.']',
            __('catalog::dashboard.servers.form.title').'-'.$code ,
                    $model->getTranslation('title' , $code),
                  ['data-name' => 'title.'.$code]
             ); ?>

        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>

<?php echo field()->number('order', __('catalog::dashboard.servers.form.sort')); ?>

<?php echo field()->checkBox('status', __('catalog::dashboard.servers.form.status')); ?>

<?php if($model->trashed()): ?>
    <?php echo field()->checkBox('trash_restore', __('catalog::dashboard.servers.form.restore')); ?>

<?php endif; ?>
<?php /**PATH /home/ahmed-nabil94/Desktop/PhpstormProjects/RoyalCard-Backend/Modules/Catalog/Resources/views/dashboard/servers/form.blade.php ENDPATH**/ ?>