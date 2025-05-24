<?php $__env->startSection('title', __('slider::dashboard.sliders.routes.update')); ?>
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
                        <a href="<?php echo e(url(route('dashboard.sliders.index'))); ?>">
                            <?php echo e(__('slider::dashboard.sliders.routes.index')); ?>

                        </a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <a href="#"><?php echo e(__('slider::dashboard.sliders.routes.update')); ?></a>
                    </li>
                </ul>
            </div>

            <h1 class="page-title"></h1>

            <div class="row">

                <?php echo Form::model($model,[
                               'url'=> route('dashboard.sliders.update',$model->id),
                               'id'=>'updateForm',
                               'role'=>'form',
                               'page'=>'form',
                               'class'=>'form-horizontal form-row-seperated',
                               'method'=>'PUT',
                               'files' => true
                               ]); ?>

                <div class="col-md-12">

                    <div class="col-md-3">
                        <div class="panel-group accordion scrollable" id="accordion2">
                            <div class="panel panel-default">

                                <div id="collapse_2_1" class="panel-collapse in">
                                    <div class="panel-body">
                                        <ul class="nav nav-pills nav-stacked">

                                            <li class="active">
                                                <a href="#global_setting" data-toggle="tab">
                                                    <?php echo e(__('slider::dashboard.sliders.form.tabs.general')); ?>

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
                                <?php echo $__env->make('slider::dashboard.sliders.form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            </div>

                        </div>
                    </div>

                    
                    <div class="col-md-12">
                        <div class="form-actions">
                            <?php echo $__env->make('apps::dashboard.layouts._ajax-msg', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            <div class="form-group">
                                <button type="submit" id="submit" class="btn btn-lg green">
                                    <?php echo e(__('apps::dashboard.buttons.edit')); ?>

                                </button>
                                <a href="<?php echo e(url(route('dashboard.sliders.index'))); ?>" class="btn btn-lg red">
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

<?php echo $__env->make('apps::dashboard.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/ahmed-nabil94/Desktop/PhpstormProjects/RoyalCard-Backend/Modules/Slider/Resources/views/dashboard/sliders/edit.blade.php ENDPATH**/ ?>