<div class="row">
    <div class="form-group">
        <label class="col-md-2">
            <?php echo e(__('setting::dashboard.settings.form.supported_country')); ?>

        </label>
        <div class="col-md-9">
            <select name="payment_gateway[upayment][country_id]" class="form-control select2">
                <option> Select Country</option>
                <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $code => $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if(collect(setting('supported_countries'))->contains($country->id)): ?>
                        <option value="<?php echo e($country->id); ?>" <?php echo e(setting('payment_gateway','upayment.country_id') == $country->id ? 'selected' : ''); ?>><?php echo e($country->title); ?></option>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
    </div>
  <div class="col-md-6 col-md-offset-4">
    <div class="form-group">
      <div class="col-md-9">
        <div class="mt-radio-inline">
          <label class="mt-radio mt-radio-outline">
            <?php echo e(__('setting::dashboard.settings.form.payment_gateway.payment_mode.test_mode')); ?>

            <input onchange="paymentModeSwitcher('upay_switch','testModelData_upay')" type="radio" name="payment_gateway[upayment][payment_mode]"
              value="test_mode" <?php if(setting('payment_gateway','upayment.payment_mode') !='live_mode' ): ?> checked <?php endif; ?>>
            <span></span>
          </label>
          <label onchange="paymentModeSwitcher('upay_switch','liveModelData_upay')" class="mt-radio mt-radio-outline">
            <?php echo e(__('setting::dashboard.settings.form.payment_gateway.payment_mode.live_mode')); ?>

            <input type="radio" name="payment_gateway[upayment][payment_mode]" value="live_mode"
              <?php if(setting('payment_gateway','upayment.payment_mode')=='live_mode' ): ?> checked <?php endif; ?>>
            <span></span>
          </label>
        </div>
      </div>
    </div>

  </div>
</div>

<div class="row">
  <div class="col-md-7 col-md-offset-2 upay_switch" id="testModelData_upay"
    style="<?php echo e(setting('payment_gateway','upayment.payment_mode') == 'live_mode' ? 'display: none': 'display: block'); ?>">

    <h3 class="page-title text-center">UPayment Gateway ( Test Mode )</h3>
    <div class="form-group">
      <label>
        <?php echo e(__('setting::dashboard.settings.form.payment_gateway.upayment.merchant_id')); ?>

      </label>
      <input type="text" class="form-control" name="payment_gateway[upayment][test_mode][MERCHANT_ID]"
        value="<?php echo e(setting('payment_gateway','upayment.test_mode.MERCHANT_ID') ?? ''); ?>" />
    </div>

    <div class="form-group">
      <label>
        <?php echo e(__('setting::dashboard.settings.form.payment_gateway.upayment.api_key')); ?>

      </label>
      <input type="text" class="form-control" name="payment_gateway[upayment][test_mode][API_KEY]"
        value="<?php echo e(setting('payment_gateway','upayment.test_mode.API_KEY') ?? ''); ?>" />
    </div>

    <div class="form-group">
      <label>
        <?php echo e(__('setting::dashboard.settings.form.payment_gateway.upayment.username')); ?>

      </label>
      <input type="text" class="form-control" name="payment_gateway[upayment][test_mode][USERNAME]"
        value="<?php echo e(setting('payment_gateway','upayment.test_mode.USERNAME') ?? ''); ?>" />
    </div>

    <div class="form-group">
      <label>
        <?php echo e(__('setting::dashboard.settings.form.payment_gateway.upayment.password')); ?>

      </label>
      <input type="text" class="form-control" name="payment_gateway[upayment][test_mode][PASSWORD]"
        value="<?php echo e(setting('payment_gateway','upayment.test_mode.PASSWORD') ?? ''); ?>" />
    </div>

    <div class="form-group">
      <label>
        charges
      </label>
      <input type="text" class="form-control" name="payment_gateway[upayment][test_mode][charges]"
        value="<?php echo e(setting('payment_gateway','upayment.test_mode.charges') ?? ''); ?>" />
    </div>

    <div class="form-group">
      <label>
        cc_charges
      </label>
      <input type="text" class="form-control" name="payment_gateway[upayment][test_mode][cc_charges]"
        value="<?php echo e(setting('payment_gateway','upayment.test_mode.cc_charges') ?? ''); ?>" />
    </div>
  </div>

  <div class="col-md-7 col-md-offset-2 upay_switch" id="liveModelData_upay"
    style="<?php echo e(setting('payment_gateway','upayment.payment_mode') == 'live_mode' ? 'display: block': 'display: none'); ?>">

    <h3 class="page-title text-center">UPayment Gateway ( Live Mode )</h3>
    <div class="form-group">
      <label>
        <?php echo e(__('setting::dashboard.settings.form.payment_gateway.upayment.merchant_id')); ?>

      </label>
      <input type="text" class="form-control" name="payment_gateway[upayment][live_mode][MERCHANT_ID]"
        value="<?php echo e(setting('payment_gateway','upayment.live_mode.MERCHANT_ID') ?? ''); ?>" />
    </div>

    <div class="form-group">
      <label>
        <?php echo e(__('setting::dashboard.settings.form.payment_gateway.upayment.api_key')); ?>

      </label>
      <input type="text" class="form-control" name="payment_gateway[upayment][live_mode][API_KEY]"
        value="<?php echo e(setting('payment_gateway','upayment.live_mode.API_KEY') ?? ''); ?>" />
    </div>

    <div class="form-group">
      <label>
        <?php echo e(__('setting::dashboard.settings.form.payment_gateway.upayment.username')); ?>

      </label>
      <input type="text" class="form-control" name="payment_gateway[upayment][live_mode][USERNAME]"
        value="<?php echo e(setting('payment_gateway','upayment.live_mode.USERNAME') ?? ''); ?>" />
    </div>

    <div class="form-group">
      <label>
        <?php echo e(__('setting::dashboard.settings.form.payment_gateway.upayment.password')); ?>

      </label>
      <input type="text" class="form-control" name="payment_gateway[upayment][live_mode][PASSWORD]"
        value="<?php echo e(setting('payment_gateway','upayment.live_mode.PASSWORD') ?? ''); ?>" />
    </div>

    <div class="form-group">
      <label>
        <?php echo e(__('setting::dashboard.settings.form.payment_gateway.upayment.iban')); ?>

      </label>
      <input type="text" class="form-control" name="payment_gateway[upayment][live_mode][IBAN]"
        value="<?php echo e(setting('payment_gateway','upayment.live_mode.IBAN') ?? ''); ?>" />
    </div>

    <div class="form-group">
      <label>
        charges
      </label>
      <input type="text" class="form-control" name="payment_gateway[upayment][live_mode][charges]"
        value="<?php echo e(setting('payment_gateway','upayment.live_mode.charges') ?? ''); ?>" />
    </div>

    <div class="form-group">
      <label>
        cc_charges
      </label>
      <input type="text" class="form-control" name="payment_gateway[upayment][live_mode][cc_charges]"
        value="<?php echo e(setting('payment_gateway','upayment.live_mode.cc_charges') ?? ''); ?>" />
    </div>

  </div>
  <div class="col-md-7 col-md-offset-2">

    <?php $__currentLoopData = config('translatable.locales'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $code): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php echo field('payment_search_inputs')->text('payment_gateway[upayment][title_'.$code.']',
    __('setting::dashboard.settings.form.payment_gateway.payment_types.payment_title').'-'.$code ,
    setting('payment_gateway','upayment.title_'.$code)); ?>


    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php echo field()->checkBox('payment_gateway[upayment][status]', __('setting::dashboard.settings.form.payment_gateway.payment_types.payment_status') , null , [
    (setting('payment_gateway','upayment.status') == 'on' ? 'checked' : '') => ''
    ]); ?>

  </div>
</div>
<?php /**PATH /home/ahmed-nabil94/Desktop/PhpstormProjects/RoyalCard-Backend/Modules/Setting/Resources/views/dashboard/tabs/gatways/upayment.blade.php ENDPATH**/ ?>