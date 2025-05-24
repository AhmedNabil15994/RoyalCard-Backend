<div class="tab-pane fade" id="app">
  <h3 class="page-title"><?php echo e(__('setting::dashboard.settings.form.tabs.app')); ?></h3>
  <div class="col-md-10">
    <?php $__currentLoopData = setting('locales')??[]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="form-group">
      <label class="col-md-2">
        <?php echo e(__('setting::dashboard.settings.form.app_name')); ?> - <?php echo e($key); ?>

      </label>
      <div class="col-md-9">
        <input type="text" class="form-control" name="app_name[<?php echo e($key); ?>]" value="<?php echo e(setting('app_name',$key)); ?>" />
      </div>
    </div>
          <div class="form-group">
              <label class="col-md-2">
                  <?php echo e(__('setting::dashboard.settings.form.office_address')); ?> - <?php echo e($key); ?>

              </label>
              <div class="col-md-9">
                  <input type="text" class="form-control" name="office_address[<?php echo e($key); ?>]" value="<?php echo e(setting('office_address',$key)); ?>" />
              </div>
          </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <div class="form-group">
      <label class="col-md-2">
        <?php echo e(__('setting::dashboard.settings.form.contacts_email')); ?>

      </label>
      <div class="col-md-9">
        <input type="text" class="form-control" name="contact_us[email]" value="<?php echo e(setting('contact_us','email')); ?>" />
      </div>
    </div>
    <div class="form-group">
      <label class="col-md-2">
        <?php echo e(__('setting::dashboard.settings.form.contacts_whatsapp')); ?>

      </label>
      <div class="col-md-9">
        <input type="text" class="form-control" name="contact_us[whatsapp]" value="<?php echo e(setting('contact_us','whatsapp')); ?>" />
      </div>
    </div>
    <div class="form-group">
      <label class="col-md-2">
        <?php echo e(__('setting::dashboard.settings.form.contacts_call_number')); ?>

      </label>
      <div class="col-md-9">
        <input type="text" class="form-control" name="contact_us[call_number]" value="<?php echo e(setting('contact_us','call_number')); ?>" />
      </div>
    </div>
  </div>
</div>
<?php /**PATH /home/ahmed-nabil94/Desktop/PhpstormProjects/RoyalCard-Backend/Modules/Setting/Resources/views/dashboard/tabs/app.blade.php ENDPATH**/ ?>