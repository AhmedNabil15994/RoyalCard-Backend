<html>
    <?php $__env->startSection('title',__('authentication::dashboard.login.routes.index')); ?>
    <link rel="stylesheet" href="<?php echo e(asset('admin/assets/pages/css/login.min.css')); ?>">
    <?php echo $__env->make('apps::dashboard.layouts._head_ltr', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <body class="login">
        <div class="content">
            <form class="login-form" action="<?php echo e(route('dashboard.login.post')); ?>" method="POST">
                <?php echo e(csrf_field()); ?>


                <h3 class="form-title font-green"><?php echo e(__('authentication::dashboard.login.routes.index')); ?></h3>
                <div class="form-group<?php echo e($errors->has('email') ? ' has-error' : ''); ?>">
                    <label class="control-label">
                      <?php echo e(__('authentication::dashboard.login.form.email')); ?>

                    </label>
                    <input class="form-control form-control-solid placeholder-no-fix" type="text" value="<?php echo e(old('email')); ?>" name="email"/>
                    <?php if($errors->has('email')): ?>
                    <span class="help-block">
                        <strong><?php echo e($errors->first('email')); ?></strong>
                    </span>
                    <?php endif; ?>
                </div>
                <div class="form-group<?php echo e($errors->has('password') ? ' has-error' : ''); ?>">
                    <label class="control-label">
                      <?php echo e(__('authentication::dashboard.login.form.password')); ?>

                    </label>
                    <input class="form-control form-control-solid placeholder-no-fix" type="password" name="password"/>
                    <?php if($errors->has('password')): ?>
                    <span class="help-block">
                        <strong><?php echo e($errors->first('password')); ?></strong>
                    </span>
                    <?php endif; ?>
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn green uppercase">
                      <?php echo e(__('authentication::dashboard.login.form.btn.login')); ?>

                    </button>
                </div>
            </form>
        </div>
        <?php echo $__env->make('apps::dashboard.layouts._footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php echo $__env->make('apps::dashboard.layouts._jquery', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </body>
</html>
<?php /**PATH /home/ahmed-nabil94/Desktop/PhpstormProjects/RoyalCard-Backend/Modules/Authentication/Resources/views/dashboard/auth/login.blade.php ENDPATH**/ ?>