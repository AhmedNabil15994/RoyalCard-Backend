<?php $__env->startSection('title', __('category::dashboard.categories.routes.create')); ?>
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
                        <a href="<?php echo e(url(route('dashboard.categories.index'))); ?>">
                            <?php echo e(__('category::dashboard.categories.routes.index')); ?>

                        </a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <a href="#"><?php echo e(__('category::dashboard.categories.routes.create')); ?></a>
                    </li>
                </ul>
            </div>

            <h1 class="page-title"></h1>

            <div class="row">
                <?php echo Form::model($model,[
                                'url'=> route('dashboard.categories.store'),
                                'id'=>'form',
                                'role'=>'form',
                                'method'=>'POST',
                                'class'=>'form-horizontal form-row-seperated',
                                'files' => true
                                ]); ?>


                    <div class="col-md-12">

                    <div class="col-md-3">
                        <div class="panel-group accordion scrollable" id="accordion2">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title"><a class="accordion-toggle"></a></h4>
                                </div>
                                <div id="collapse_2_1" class="panel-collapse in">
                                    <div class="panel-body">
                                        <ul class="nav nav-pills nav-stacked">
                                            <li class="active">
                                                <a href="#global_setting" data-toggle="tab">
                                                    <?php echo e(__('category::dashboard.categories.form.tabs.general')); ?>

                                                </a>
                                            </li>
                                            <li class="">
                                                <a href="#category_level" data-toggle="tab">
                                                    <?php echo e(__('category::dashboard.categories.form.tabs.category_level')); ?>

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
                            <div class="tab-pane fade in" id="category_level">
                                <h3 class="page-title"><?php echo e(__('category::dashboard.categories.form.tabs.category_level')); ?></h3>
                                <div id="jstree">
                                    <ul>
                                        <li id="null"><?php echo e(__('category::dashboard.categories.form.main_category')); ?></li>
                                    </ul>
                                    <?php echo $__env->make('category::dashboard.tree.categories.view',['mainCategories' => $mainCategories], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                </div>
                            </div>
                            <div class="tab-pane active fade in" id="global_setting">
                                <div class="col-md-10">
                                    <?php echo $__env->make('category::dashboard.categories.form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
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
                                <a href="<?php echo e(url(route('dashboard.categories.index'))); ?>" class="btn btn-lg red">
                                    <?php echo e(__('apps::dashboard.buttons.back')); ?>

                                </a>
                            </div>
                        </div>
                    </div>

                </div>

                <?php echo Form::close(); ?>

            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('scripts'); ?>

    <script type="text/javascript">
        $(function () {


            $('[name="banner_status"]').on('switchChange.bootstrapSwitch', function(e) {
                $('.bannerData').toggleClass('hidden');
            })


            $('#jstree').jstree({
                core: {
                    multiple: false
                }
            });

            $('#jstree').on("changed.jstree", function (e, data) {
                $('#root_category').val(data.selected);
            });

        });
    </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('apps::dashboard.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/ahmed-nabil94/Desktop/PhpstormProjects/RoyalCard-Backend/Modules/Category/Resources/views/dashboard/categories/create.blade.php ENDPATH**/ ?>