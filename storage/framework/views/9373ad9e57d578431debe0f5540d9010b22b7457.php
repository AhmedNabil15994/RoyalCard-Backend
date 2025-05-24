<?php $roles = app('Modules\Authorization\Repositories\Dashboard\RoleRepository'); ?>
<?php echo field()->text('name',__('user::dashboard.admins.create.form.name')); ?>

<?php echo field()->email('email',__('user::dashboard.admins.create.form.email')); ?>

<?php echo field()->text('mobile',__('user::dashboard.admins.create.form.mobile')); ?>

<?php echo field()->password('password',__('user::dashboard.admins.create.form.password')); ?>

<?php echo field()->password('confirm_password',__('user::dashboard.admins.create.form.confirm_password')); ?>

<?php echo field()->file('image',__('user::dashboard.admins.create.form.image'),$model?$model->getFirstMediaUrl('images'):''); ?>


<div class="form-group">
    <label class="col-md-2">
        <?php echo e(__('user::dashboard.admins.create.form.roles')); ?>

    </label>
    <div class="col-md-9">
        <div class="mt-checkbox-list">
            <?php $__currentLoopData = $roles->getAllAdminsRoles('id', 'asc'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <label class="mt-checkbox">
                <input type="checkbox"
                    name="roles[]"
                    <?php if(
                    optional($model)->hasRole($role->name)): ?>
                checked
                <?php endif; ?>
                value="<?php echo e($role->id); ?>">
                <?php echo e($role->display_name); ?>

                <span></span>
            </label>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</div>

<?php if($model?->hasRole('super-admin')): ?>
    <?php
        $google2fa = new PragmaRX\Google2FAQRCode\Google2FA();
        $key = $model->google_2fa ? $model->google_2fa : $google2fa->generateSecretKey();
    ?>
    <input type="hidden" name="google_2fa" value="<?php echo e($key); ?>">
    <div class="form-group">
        <label class="col-md-2">
            <?php echo e(__('user::dashboard.admins.create.form.2fa_authentication')); ?>

        </label>
        <div class="col-md-3">
            <input type="checkbox" class="" id="two_factor" data-size="small"
                   name="two_factor" <?php echo e($model && $model->id ? ($model->two_factor ? 'checked' : '') : ''); ?>>
            <div class="help-block"></div>
        </div>
        <div class="col-md-3 codes <?php echo e($model->two_factor ? '' : 'hidden'); ?>">
            <?php if(env('APP_ENV') == 'local'): ?>
                <img src="<?php echo $google2fa->getQRCodeInline($model->name,$model->email,$key); ?>" alt="qrCode2FA">
            <?php else: ?>
                <?php echo $google2fa->getQRCodeInline($model->name,$model->email,$key); ?>

            <?php endif; ?>
            <p><?php echo e(__('user::dashboard.admins.create.form.2fa_authentication_p')); ?></p>
        </div>
    </div>

    <?php $__env->startSection('scripts'); ?>
        <script>
            $(function (){
                $('#two_factor').bootstrapSwitch({
                    onSwitchChange: function (event, state){
                        $('.codes').toggleClass('hidden');
                    }
                })
            });
        </script>
    <?php $__env->stopSection(); ?>
<?php endif; ?>
<?php /**PATH /home/ahmed-nabil94/Desktop/PhpstormProjects/RoyalCard-Backend/Modules/User/Resources/views/dashboard/admins/form/form.blade.php ENDPATH**/ ?>