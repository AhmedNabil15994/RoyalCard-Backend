<!DOCTYPE html>
<html lang="<?php echo e(locale()); ?>" dir="<?php echo e(is_rtl()); ?>">

    <?php if(is_rtl() == 'rtl'): ?>
      <?php echo $__env->make('apps::dashboard.layouts._head_rtl', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php else: ?>
      <?php echo $__env->make('apps::dashboard.layouts._head_ltr', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endif; ?>

    <body class="page-header-fixed page-sidebar-closed-hide-logo page-content-white page-md">
        <div class="page-wrapper">

            <?php echo $__env->make('apps::dashboard.layouts._header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

            <div class="clearfix"> </div>

            <div class="page-container">
                <?php echo $__env->make('apps::dashboard.layouts._aside', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                <?php echo $__env->yieldContent('content'); ?>
            </div>

            <?php echo $__env->make('apps::dashboard.layouts._footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>

        <?php echo $__env->make('apps::dashboard.layouts._jquery', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </body>
</html>
<?php /**PATH /home/ahmed-nabil94/Desktop/PhpstormProjects/RoyalCard-Backend/Modules/Apps/Resources/views/dashboard/layouts/app.blade.php ENDPATH**/ ?>