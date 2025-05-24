<div class="tab-pane active fade in" id="global_setting">
    
    <div class="col-md-12">

        <div>
            <div class="tabbable">
                <ul class="nav nav-tabs bg-slate nav-tabs-component">
                    <?php $__currentLoopData = config('laravellocalization.supportedLocales'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $code => $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li class=" <?php echo e(($code == locale()) ? 'active' : ''); ?>">
                            <a href="#colored-rounded-tab-general-<?php echo e($code); ?>" data-toggle="tab" aria-expanded="false"> <?php echo e($lang['native']); ?>

                            </a>
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>

            <div class="tab-content">
                <?php $__currentLoopData = config('laravellocalization.supportedLocales'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $code => $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="tab-pane <?php if($code == locale()): ?> active <?php endif; ?>"
                         id="colored-rounded-tab-general-<?php echo e($code); ?>">
                        <div class="form-group">
                            <label class="col-md-2">
                                <?php echo e(__('catalog::dashboard.products.form.title')); ?>

                            </label>
                            <div class="col-md-9">
                                <input type="text" name="title[<?php echo e($code); ?>]"
                                       class="form-control"
                                       data-name="title.<?php echo e($code); ?>"
                                        value="<?php echo e($model && $model->id ? ($model->getTranslations('title')[$code] ?? '') : ''); ?>">
                                <div class="help-block"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2">
                                <?php echo e(__('catalog::dashboard.products.form.description')); ?>

                            </label>
                            <div class="col-md-9">
                                <textarea name="description[<?php echo e($code); ?>]" class="form-control " data-name="description.<?php echo e($code); ?>"><?php echo e($model && $model->id ? ($model->getTranslations('description')[$code] ?? '') : ''); ?></textarea>
                                <div class="help-block"></div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <hr>
        </div>

        <?php if(auth()->id() == 1): ?>
        <div class="form-group">
            <label class="col-md-2">
                <?php echo e(__('catalog::dashboard.products.form.sku')); ?>

            </label>
            <div class="col-md-9">
                <input type="text" name="sku" class="form-control"
                       value="<?php echo e($model && $model->id ? $model->sku : generateRandomCode()); ?>" data-name="sku">
                <div class="help-block"></div>
            </div>
        </div>
        <?php endif; ?>

        <div class="form-group">
            <label class="col-md-2">
                <?php echo e(__('catalog::dashboard.products.form.user_max_uses')); ?>

            </label>
            <div class="col-md-9">
                <input type="number" min="1" name="user_max_uses" class="form-control"
                       data-name="user_max_uses" value="<?php echo e($model?->user_max_uses); ?>">
                <div class="help-block"></div>
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-2">
                <?php echo e(__('catalog::dashboard.products.form.status')); ?>

            </label>
            <div class="col-md-9">
                <input type="checkbox" class="make-switch" id="test" data-size="small"
                       name="status" <?php echo e($model && $model->id ? ($model->status ? 'checked' : '') : ''); ?>>
                <div class="help-block"></div>
            </div>
        </div>

        <?php echo field()->number('order', __('category::dashboard.categories.form.sort'), ($model && $model->id ? $model->order : 0)); ?>


        <?php echo field()->file('image', __('category::dashboard.categories.form.image'), ($model && $model->id ? $model->getFirstMediaUrl('images') : null)); ?>


    </div>
</div>
<?php /**PATH /home/ahmed-nabil94/Desktop/PhpstormProjects/RoyalCard-Backend/Modules/Catalog/Resources/views/dashboard/products/components/global_setting.blade.php ENDPATH**/ ?>