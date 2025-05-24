<div class="tab-pane fade" id="wallet">
    <h3 class="page-title"><?php echo e(__('setting::dashboard.settings.form.tabs.wallet')); ?></h3>
    <?php
        $supportedCountries = setting('supported_countries');
        sort($supportedCountries, SORT_NATURAL | SORT_FLAG_CASE);
    ?>
    <div class="col-md-10">
        <?php $__currentLoopData = $supportedCountries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $supportedCountryId): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
                $country = \Modules\Area\Entities\Country::find($supportedCountryId);
            ?>
            <h3><?php echo e($country->title); ?></h3>
            <div class="form-group">
                <label class="col-md-2">
                    <?php echo e(__('setting::dashboard.settings.form.recharge_max_balance')); ?>

                </label>
                <div class="col-md-9 disParent">
                    <input type="text" class="form-control" name="recharge_max_balance[<?php echo e($country?->id); ?>]" value="<?php echo e(setting('recharge_max_balance')[$country?->id] ?? ''); ?>" autocomplete="off" />
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2">
                    <?php echo e(__('setting::dashboard.settings.form.wallet_max_balance')); ?>

                </label>
                <div class="col-md-9 disParent">
                    <input type="text" class="form-control" name="wallet_max_balance[<?php echo e($country?->id); ?>]" value="<?php echo e(setting('wallet_max_balance')[$country?->id] ?? ''); ?>" autocomplete="off" />
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2">
                    <?php echo e(__('setting::dashboard.settings.form.wallet_min_balance')); ?>

                </label>
                <div class="col-md-9 disParent">
                    <input type="text" class="form-control" name="wallet_min_balance[<?php echo e($country?->id); ?>]" value="<?php echo e(setting('wallet_min_balance')[$country?->id] ?? ''); ?>" autocomplete="off" />
                </div>
            </div>
            <hr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    </div>
</div>
<?php /**PATH /home/ahmed-nabil94/Desktop/PhpstormProjects/RoyalCard-Backend/Modules/Setting/Resources/views/dashboard/tabs/wallet.blade.php ENDPATH**/ ?>