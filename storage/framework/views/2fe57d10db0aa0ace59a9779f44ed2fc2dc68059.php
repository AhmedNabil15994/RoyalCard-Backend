<div class="tab-pane fade" id="mail">
    <h3 class="page-title"><?php echo e(__('setting::dashboard.settings.form.tabs.mail')); ?></h3>
    <div class="col-md-10">
        <div class="form-group">
            <label class="col-md-2">
                <?php echo e(__('setting::dashboard.settings.form.mail_driver')); ?>

            </label>
            <div class="col-md-9">
                <input type="text" class="form-control" name="env[MAIL_DRIVER]" value="<?php echo e(env('MAIL_DRIVER')); ?>" autocomplete="off" />
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2">
                <?php echo e(__('setting::dashboard.settings.form.mail_encryption')); ?>

            </label>
            <div class="col-md-9">
                <input type="text" class="form-control" name="env[MAIL_ENCRYPTION]" value="<?php echo e(env('MAIL_ENCRYPTION')); ?>" autocomplete="off" />
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2">
                <?php echo e(__('setting::dashboard.settings.form.mail_host')); ?>

            </label>
            <div class="col-md-9">
                <input type="text" class="form-control" name="env[MAIL_HOST]" value="<?php echo e(env('MAIL_HOST')); ?>" autocomplete="off" />
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2">
                <?php echo e(__('setting::dashboard.settings.form.mail_port')); ?>

            </label>
            <div class="col-md-9">
                <input type="text" class="form-control" name="env[MAIL_PORT]" value="<?php echo e(env('MAIL_PORT')); ?>" autocomplete="off" />
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2">
                <?php echo e(__('setting::dashboard.settings.form.mail_from')); ?>

            </label>
            <div class="col-md-9">
                <input type="email" class="form-control" name="env[MAIL_FROM_ADDRESS]" value="<?php echo e(env('MAIL_FROM_ADDRESS')); ?>" autocomplete="off" />
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-2">
                <?php echo e(__('setting::dashboard.settings.form.mail_name_from')); ?>

            </label>
            <div class="col-md-9">
                <input type="text" class="form-control" name="env[MAIL_FROM_NAME]" value="<?php echo e(env('MAIL_FROM_NAME')); ?>" autocomplete="off" />
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-2">
              <?php echo e(__('setting::dashboard.settings.form.mail_username')); ?>

            </label>
            <div class="col-md-9">
                <input type="string" class="form-control" name="env[MAIL_USERNAME]" value="<?php echo e(env('MAIL_USERNAME')); ?>" autocomplete="off" />
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2">
                <?php echo e(__('setting::dashboard.settings.form.mail_password')); ?>

            </label>
            <div class="col-md-9">
                <input type="text" class="form-control" name="env[MAIL_PASSWORD]" value="<?php echo e(env('MAIL_PASSWORD')); ?>" autocomplete="off" />
            </div>
        </div>
    </div>
</div>
<?php /**PATH /home/ahmed-nabil94/Desktop/PhpstormProjects/RoyalCard-Backend/Modules/Setting/Resources/views/dashboard/tabs/mail.blade.php ENDPATH**/ ?>