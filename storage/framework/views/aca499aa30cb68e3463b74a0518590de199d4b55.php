<ul class="nav nav-tabs">
    <?php $__currentLoopData = config('translatable.locales'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $code): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <li class="<?php if($code == locale()): ?> active <?php endif; ?>">
            <a data-toggle="tab" href="#<?php echo e($nav_id); ?>_<?php echo e($code); ?>">
                <?php echo e(optional(config('field.locales')[$code]) ? config('field.locales')[$code]['native'] : $code); ?>

            </a>
        </li>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</ul><?php /**PATH /home/ahmed-nabil94/Desktop/PhpstormProjects/RoyalCard-Backend/vendor/mostafasewidan/sewidan-field/src/resources/views/fields/lang-nav-tabs.blade.php ENDPATH**/ ?>