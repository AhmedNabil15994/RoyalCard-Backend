<div class="tab-pane fade" id="other">
  <h3 class="page-title"><?php echo e(__('setting::dashboard.settings.form.tabs.other')); ?></h3>
  <div class="col-md-10">
    <div class="form-group">
      <label class="col-md-2">
        <?php echo e(__('setting::dashboard.settings.form.about_us')); ?>

      </label>
      <div class="col-md-9">
        <select name="other[about_us]" id="single" class="form-control select2">
          <option value=""></option>
          <?php $__currentLoopData = $pages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <option value="<?php echo e($page['id']); ?>" <?php echo e(( setting('other','about_us')==$page->id) ? ' selected="" ' : ''); ?>>
            <?php echo e($page->title); ?>

          </option>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
      </div>
    </div>
    <div class="form-group">
      <label class="col-md-2">
        <?php echo e(__('setting::dashboard.settings.form.privacy_policy')); ?>

      </label>
      <div class="col-md-9">
        <select name="other[privacy_policy]" id="single" class="form-control select2">
          <option value=""></option>
          <?php $__currentLoopData = $pages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

          <option value="<?php echo e($page['id']); ?>" <?php echo e(( setting('other','privacy_policy')==$page->id) ? ' selected="" ' : ''); ?>>
            <?php echo e($page->title); ?>

          </option>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
      </div>
    </div>
    <div class="form-group">
      <label class="col-md-2">
        <?php echo e(__('setting::dashboard.settings.form.terms')); ?>

      </label>
      <div class="col-md-9">
        <select name="other[terms]" id="single" class="form-control select2">
          <option value=""></option>
          <?php $__currentLoopData = $pages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <option value="<?php echo e($page['id']); ?>" <?php echo e((setting('other','terms')==$page->id) ? ' selected="" ' : ''); ?>>
            <?php echo e($page->title); ?>

          </option>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
      </div>
    </div>
    <div class="form-group">
      <label class="col-md-2">
        <?php echo e(__('setting::dashboard.settings.form.force_update')); ?>

      </label>
      <div class="col-md-9">
        <div class="mt-radio-inline">
          <label class="mt-radio mt-radio-outline"> Yes
            <input type="radio" name="other[force_update]" value="1" <?php if(setting('other','force_update')==1): ?> checked <?php endif; ?>>
            <span></span>
          </label>
          <label class="mt-radio mt-radio-outline">
            No
            <input type="radio" name="other[force_update]" value="0" <?php if(setting('other','force_update')==0): ?> checked <?php endif; ?>>
            <span></span>
          </label>
        </div>
      </div>
    </div>
  </div>
</div>
<?php /**PATH /home/ahmed-nabil94/Desktop/PhpstormProjects/RoyalCard-Backend/Modules/Setting/Resources/views/dashboard/tabs/other.blade.php ENDPATH**/ ?>