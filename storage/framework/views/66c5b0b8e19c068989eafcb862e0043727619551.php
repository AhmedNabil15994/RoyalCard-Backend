<div class="tab-pane active fade in" id="global_setting">
    <h3 class="page-title"><?php echo e(__('setting::dashboard.settings.form.tabs.general')); ?></h3>
    <div class="col-md-10">
        <div class="form-group">
            <label class="col-md-2">
              <?php echo e(__('setting::dashboard.settings.form.locales')); ?>

            </label>
            <div class="col-md-9">
                <select name="locales[]" id="single" class="form-control select2" multiple="">
                    <?php $__currentLoopData = config('core.available-locales'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $language): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($key); ?>"
                    <?php if(in_array($key,array_keys(config('laravellocalization.supportedLocales')))): ?>
                    selected
                    <?php endif; ?>>
                        <?php echo e($language['native']); ?>

                    </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2">
                <?php echo e(__('setting::dashboard.settings.form.rtl_locales')); ?>

            </label>
            <div class="col-md-9">
                <select name="rtl_locales[]" id="single" class="form-control select2" multiple="">
                    <?php $__currentLoopData = config('core.available-locales'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $language): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($key); ?>"
                    <?php if(in_array($key,config('rtl_locales'))): ?>
                    selected
                    <?php endif; ?>>
                        <?php echo e($language['native']); ?>

                    </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2">
                <?php echo e(__('setting::dashboard.settings.form.default_language')); ?>

            </label>
            <div class="col-md-9">
                <select name="default_locale" id="single" class="form-control select2">
                    <?php $__currentLoopData = config('core.available-locales'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $language): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($key); ?>"
                    <?php if(config('default_locale') == $key): ?>
                    selected
                    <?php endif; ?>>
                        <?php echo e($language['native']); ?>

                    </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
        </div>
        <?php
            $default_country = setting('default_country') ;
        ?>
        <div class="form-group">
            <label class="col-md-2">
                <?php echo e(__('setting::dashboard.settings.form.default_country')); ?>

            </label>
            <div class="col-md-9">
                <select name="default_country" class="form-control select2">
                    <option> Select Value</option>
                    <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $code => $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if(collect(setting('supported_countries'))->contains($country->id)): ?>
                            <option value="<?php echo e($country->id); ?>" <?php echo e($country->id == $default_country ? 'selected' : ''); ?>><?php echo e($country->title); ?></option>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2">
                <?php echo e(__('setting::dashboard.settings.form.supported_countries')); ?>

            </label>
            <div class="col-md-9">
                <select name="supported_countries[]" class="form-control select2" multiple="">
                    <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $code => $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($country->id); ?>"
                            <?php if(collect(setting('supported_countries'))->contains($country->id)): ?>
                                    selected=""<?php endif; ?>>
                            <?php echo e($country->title); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
        </div>

        <?php
            $currencies = \Modules\Area\Entities\CurrencyCode::whereIn('country_id', setting('supported_countries'))->get();
        ?>

        <div class="form-group">
            <label class="col-md-2">
                <?php echo e(__('setting::dashboard.settings.form.default_currency')); ?>

            </label>
            <div class="col-md-9">
                <select name="default_currency" class="form-control select2">
                    <?php $__currentLoopData = $currencies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $code => $currency): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($currency->code); ?>" <?php echo e($currency->code == setting('default_currency') ? 'selected' : ''); ?>>
                            <?php echo e($currency->translate('name','ar')); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-2">
                <?php echo e(__('setting::dashboard.settings.form.supported_currencies')); ?>

            </label>
            <div class="col-md-9">
                <select name="supported_currencies[]" class="form-control select2" multiple="">
                    <?php $__currentLoopData = $currencies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $code => $currency): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($currency->code); ?>"
                                <?php if(in_array($currency->code,setting('supported_currencies') ?? [])): ?>
                                    selected=""
                            <?php endif; ?>>
                            <?php echo e($currency->translate('name','ar')); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
        </div>
        <?php
            $supportedCountries = setting('supported_countries');
            sort($supportedCountries, SORT_NATURAL | SORT_FLAG_CASE);
        ?>
        <?php $__currentLoopData = $supportedCountries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $supportedCountryId): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
                $country = \Modules\Area\Entities\Country::find($supportedCountryId);
            ?>
            <div class="form-group">
                <label class="col-md-2">
                    <?php echo e(__('setting::dashboard.settings.form.tax_in_country',['country' => $country->title])); ?>

                </label>
                <div class="col-md-9 disParent">
                    <input type="text" class="form-control" name="taxes_rates[<?php echo e($country?->id); ?>]" value="<?php echo e(setting('taxes_rates')[$country?->id] ?? ''); ?>" autocomplete="off" />
                    <span class="disabled">%</span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2">
                    <?php echo e(__('setting::dashboard.settings.form.tax_number',['country' => $country->title])); ?>

                </label>
                <div class="col-md-9 disParent">
                    <input type="text" class="form-control" name="tax_number[<?php echo e($country?->id); ?>]" value="<?php echo e(setting('tax_number')[$country?->id] ?? ''); ?>" autocomplete="off" />
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>
<?php /**PATH /home/ahmed-nabil94/Desktop/PhpstormProjects/RoyalCard-Backend/Modules/Setting/Resources/views/dashboard/tabs/general.blade.php ENDPATH**/ ?>