<?php $__env->startSection('css'); ?>
    <style>
        textarea{
            min-height: 150px;
            max-height: 200px;
        }
        .mb-30{
            margin-bottom: 30px;
        }
        .notes{
            margin: 10px 0;
            font-weight: bold;
            color: #777;
            border: 0;
            box-shadow: unset;
        }
        .notes .astric{
            color: red;
            margin: 0 5px;
        }
        .disParent{
            width: 78%;
            position: relative;
        }
        .disabled{
            position: absolute;
            <?php if(locale() == 'ar'): ?>
            left: 15px;
            <?php else: ?>
            right: 15px;
            <?php endif; ?>
            top: 0;
            background: #DDD;
            padding: 7px 2px;
            border-radius: 3px;
        }

        <?php if(locale() == 'ar'): ?>
        .daterangepicker .calendar{
            float:right !important;
        }
        <?php endif; ?>
    </style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('title', __('catalog::dashboard.products.routes.update')); ?>
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
                        <a href="<?php echo e(url(route('dashboard.products.index'))); ?>">
                            <?php echo e(__('catalog::dashboard.products.routes.index')); ?>

                        </a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <a href="#"><?php echo e(__('catalog::dashboard.products.routes.update')); ?></a>
                    </li>
                </ul>
            </div>

            <h1 class="page-title"></h1>
            <div class="row">
                <form id="updateForm" page="form" class="form-horizontal form-row-seperated" method="post"
                    enctype="multipart/form-data" action="<?php echo e(route('dashboard.products.update', $model->id)); ?>">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>
                    <div class="col-md-12">

                        
                        <div class="col-md-3">
                            <?php echo $__env->make('catalog::dashboard.products.components.tabs', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>

                        
                        <div class="col-md-6">
                            <div class="tab-content">
                                
                                <?php echo $__env->make('catalog::dashboard.products.components.product_types', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                                <?php echo $__env->make('catalog::dashboard.products.components.global_setting', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                                <?php echo $__env->make('catalog::dashboard.products.components.categories', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                                <?php echo $__env->make('catalog::dashboard.products.components.qty_codes', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                                <?php echo $__env->make('catalog::dashboard.products.components.servers', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                                <?php echo $__env->make('catalog::dashboard.products.components.offers', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                                <?php echo $__env->make('catalog::dashboard.products.components.cashback', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                
                            </div>
                        </div>





                        
                        <div class="col-md-12">
                            <div class="form-actions">
                                <?php echo $__env->make('apps::dashboard.layouts._ajax-msg', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                <div class="form-group">
                                    <button type="submit" id="submit" class="btn btn-lg green">
                                        <?php echo e(__('apps::dashboard.buttons.edit')); ?>

                                    </button>
                                    <a href="<?php echo e(url(route('dashboard.products.index'))); ?>" class="btn btn-lg red">
                                        <?php echo e(__('apps::dashboard.buttons.back')); ?>

                                    </a>
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
    <style>
        .bootstrap-switch{
            max-height: 32px;
        }
    </style>
    <script type="text/javascript">
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
        $(function () {

            $('#jstree').jstree({
                // "plugins" : [ "wholerow", "checkbox" ],
                core: {
                    multiple: true
                },
                // checkbox : {
                //     "three_state" : false
                // }
            });

            $('#jstree').on("changed.jstree", function (e, data) {
                $('#root_category').val(data.selected);
            });

            $('input[name="product_type"]').on('change',function (){
                if($(this).val() === 'digital'){
                    $('.support').addClass('hidden');
                    $('.codes').removeClass('hidden');
                }else{
                    $('.support').removeClass('hidden');
                    $('.codes').addClass('hidden');
                }
            });



        });
    </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('apps::dashboard.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/ahmed-nabil94/Desktop/PhpstormProjects/RoyalCard-Backend/Modules/Catalog/Resources/views/dashboard/products/edit.blade.php ENDPATH**/ ?>