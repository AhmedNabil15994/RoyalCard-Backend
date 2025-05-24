<?php $__env->startSection('title', __('coupon::dashboard.coupons.routes.create')); ?>
<?php $__env->startSection('content'); ?>
    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <a href="<?php echo e(url(route('dashboard.home'))); ?>"><?php echo e(__('apps::dashboard.index.title')); ?></a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <a href="<?php echo e(url(route('dashboard.coupons.index'))); ?>">
                            <?php echo e(__('coupon::dashboard.coupons.routes.index')); ?>

                        </a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <a href="#"><?php echo e(__('coupon::dashboard.coupons.routes.create')); ?></a>
                    </li>
                </ul>
            </div>

            <h1 class="page-title"></h1>

            <div class="row">
                <form id="form" role="form" class="form-horizontal form-row-seperated" method="post"
                      enctype="multipart/form-data" action="<?php echo e(route('dashboard.coupons.store')); ?>">
                    <?php echo csrf_field(); ?>
                    <div class="col-md-12">

                        
                        <div class="col-md-3">
                            <div class="panel-group accordion scrollable" id="accordion2">
                                <div class="panel panel-default">

                                    <div id="collapse_2_1" class="panel-collapse in">
                                        <div class="panel-body">
                                            <ul class="nav nav-pills nav-stacked">
                                                <li class="active">
                                                    <a href="#global_setting" data-toggle="tab">
                                                        <?php echo e(__('coupon::dashboard.coupons.form.tabs.general')); ?>

                                                    </a>
                                                </li>

                                            </ul>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        
                        <div class="col-md-9">
                            <div class="tab-content">

                                

                                <div class="tab-pane active fade in" id="global_setting">
                                    <div class="col-md-10">

                                        <div class="form-group">
                                            <label class="col-md-2">
                                                <?php echo e(__('coupon::dashboard.coupons.form.title')); ?>

                                            </label>
                                            <div class="col-md-9">
                                                <input type="text" name="title"
                                                       class="form-control" data-name="title">
                                                <div class="help-block"></div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-2">
                                                <?php echo e(__('coupon::dashboard.coupons.form.code')); ?>

                                            </label>
                                            <div class="col-md-9">
                                                <input type="text" name="code" class="form-control" data-name="code">
                                                <div class="help-block"></div>
                                            </div>
                                        </div>

                                        <?php $products = app('Modules\Catalog\Entities\Product'); ?>
                                        <input type="hidden" name="coupon_flag">
                                        <div class="form-group">
                                            <label class="col-md-2">
                                                <?php echo e(__('coupon::dashboard.coupons.form.products')); ?>

                                            </label>
                                            <div class="col-md-9">
                                                <select name="product_id[]" class="form-control select2" multiple>
                                                    <option value=""></option>
                                                    <?php $__currentLoopData = $products->active()->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($product->id); ?>"><?php echo e($product->title); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                                <div class="help-block"></div>
                                            </div>
                                        </div>
                                        <div class="tabbable" style="margin-bottom: 15px;">
                                            <ul class="nav nav-tabs bg-slate nav-tabs-component">
                                                <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php if(in_array($country->id,setting('supported_countries'))): ?>
                                                        <li class=" <?php echo e($country->id == setting('default_country') ? 'active' : ''); ?>">
                                                            <a href="#colored-rounded-tab-general-<?php echo e($country->id); ?>" data-toggle="tab" aria-expanded="false"> <?php echo e($country->title); ?>

                                                            </a>
                                                        </li>
                                                    <?php endif; ?>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </ul>
                                        </div>
                                        <div class="tab-content">

                                            <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php if(in_array($country->id,setting('supported_countries'))): ?>
                                                    <div class="countryOffer tab-pane <?php if($country->id == setting('default_country')): ?> active <?php endif; ?>" id="colored-rounded-tab-general-<?php echo e($country->id); ?>">
                                                        <div class="form-group selections" style="margin: 0">
                                                            <div class="form-group">
                                                                <label class="col-md-2">
                                                                    <?php echo e(__('coupon::dashboard.coupons.form.discount_type')); ?>

                                                                </label>
                                                                <div class="col-md-9">
                                                                    <div class="mt-radio-inline" style="padding: 0">
                                                                        <label class="mt-radio mt-radio-outline">
                                                                            <?php echo e(__('coupon::dashboard.coupons.form.value')); ?>

                                                                            <input type="radio" name="discount_type[<?php echo e($country->id); ?>]" value="value"
                                                                                   onclick="toggleCouponType('value',this)" checked>
                                                                            <div class="help-block"></div>
                                                                            <span></span>
                                                                        </label>
                                                                        <label class="mt-radio mt-radio-outline">
                                                                            <?php echo e(__('coupon::dashboard.coupons.form.percentage')); ?>

                                                                            <input type="radio" name="discount_type[<?php echo e($country->id); ?>]" value="percentage" onclick="toggleCouponType('percentage',this)">
                                                                            <span></span>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="form-group discount_type value">
                                                                <label class="col-md-2">
                                                                    <?php echo e(__('coupon::dashboard.coupons.form.discount_value')); ?>

                                                                </label>
                                                                <div class="col-md-9">
                                                                    <input type="number" name="discount_value[<?php echo e($country->id); ?>]" class="form-control"
                                                                           data-name="discount_value">
                                                                    <div class="help-block"></div>
                                                                </div>
                                                            </div>

                                                            <div class="form-group discount_type percentage" style="display: none">
                                                                <label class="col-md-2">
                                                                    <?php echo e(__('coupon::dashboard.coupons.form.discount_percentage')); ?> %
                                                                </label>
                                                                <div class="col-md-9">
                                                                    <input type="number" min="0" max="100" name="discount_percentage[<?php echo e($country->id); ?>]"
                                                                           class="form-control" data-name="discount_percentage">
                                                                    <div class="help-block"></div>
                                                                </div>
                                                            </div>
                                                            <?php echo field()->checkBox('add_dates['.$country->id.']' , __('coupon::dashboard.coupons.form.add_dates'),null,['onchange' => 'toggleDate(this)',]); ?>

                                                            <div class="dates_container" style="display: none;">
                                                                <div class="form-group">
                                                                    <label class="col-md-2">
                                                                        <?php echo e(__('coupon::dashboard.coupons.form.start_at')); ?>

                                                                    </label>
                                                                    <div class="col-md-9">
                                                                        <div class="input-group input-medium date time date-picker"
                                                                             data-date-format="yyyy-mm-dd" data-date-start-date="+0d">
                                                                            <input type="text" id="offer-form" class="form-control"
                                                                                   name="start_at[<?php echo e($country->id); ?>]" data-name="start_at">
                                                                            <span class="input-group-btn">
                                                                                <button class="btn default" type="button">
                                                                                    <i class="fa fa-calendar"></i>
                                                                                </button>
                                                                            </span>
                                                                        </div>
                                                                        <div class="help-block" style="color: #e73d4a"></div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="col-md-2">
                                                                        <?php echo e(__('coupon::dashboard.coupons.form.expired_at')); ?>

                                                                    </label>
                                                                    <div class="col-md-9">
                                                                        <div class="input-group input-medium date time date-picker"
                                                                             data-date-format="yyyy-mm-dd" data-date-start-date="+0d">
                                                                            <input type="text" id="offer-form" class="form-control"
                                                                                   name="expired_at[<?php echo e($country->id); ?>]" data-name="expired_at">
                                                                            <span class="input-group-btn">
                                                                                <button class="btn default" type="button">
                                                                                    <i class="fa fa-calendar"></i>
                                                                                </button>
                                                                            </span>
                                                                        </div>
                                                                        <div class="help-block" style="color: #e73d4a"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                        </div>
                                        <hr style="margin-top: 0;">

                                        <div class="form-group">
                                            <label class="col-md-2">
                                                <?php echo e(__('coupon::dashboard.coupons.form.status')); ?>

                                            </label>
                                            <div class="col-md-9">
                                                <input type="checkbox" class="make-switch" id="test" data-size="small"
                                                       name="status">
                                                <div class="help-block"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        
                        <div class="col-md-12">
                            <div class="form-actions">
                                <?php echo $__env->make('apps::dashboard.layouts._ajax-msg', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                <div class="form-group">
                                    <button type="submit" id="submit" class="btn btn-lg blue">
                                        <?php echo e(__('apps::dashboard.buttons.add')); ?>

                                    </button>

                                </div>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('scripts'); ?>

    <script>

        function toggleCouponFlag(flag) {
            switch (flag) {

                case 'categories':
                    $('#categoriesSection').show();
                    $('#productsSection').hide();
                    break;

                case 'products':
                    $('#categoriesSection').hide();
                    $('#productsSection').show();
                    break;

                case '':
                    $('#categoriesSection').hide();
                    $('#productsSection').hide();
                    break;

                default:
                    $('#productsSection').show();
                    break;
            }
        }

        function toggleCouponType(flag,el) {
            $(el).parents('.selections').find('.discount_type').hide();
            $(el).parents('.selections').find('.' + flag).show();
        }

        function toggleDate(el) {
            var checked = $(el).is(':checked');
            if(checked){
                $(el).parents('.form-group').siblings('.dates_container').show();
            }else {
                $(el).parents('.form-group').siblings('.dates_container').hide();
            }
        }

    </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('apps::dashboard.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/ahmed-nabil94/Desktop/PhpstormProjects/RoyalCard-Backend/Modules/Coupon/Resources/views/dashboard/create.blade.php ENDPATH**/ ?>