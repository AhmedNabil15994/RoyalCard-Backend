<?php $__env->startSection('title', __('authorization::dashboard.roles.routes.create')); ?>
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
                        <a href="<?php echo e(url(route('dashboard.roles.index'))); ?>">
                            <?php echo e(__('authorization::dashboard.roles.routes.index')); ?>

                        </a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <a href="#"><?php echo e(__('authorization::dashboard.roles.routes.create')); ?></a>
                    </li>
                </ul>
            </div>

            <h1 class="page-title"></h1>

            <div class="row">
                <form id="form" role="form" class="form-horizontal form-row-seperated" method="post"
                      enctype="multipart/form-data" action="<?php echo e(route('dashboard.roles.store')); ?>">
                    <?php echo csrf_field(); ?>
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
                                                    <a href="#general" data-toggle="tab">
                                                        <?php echo e(__('authorization::dashboard.roles.form.tabs.general')); ?>

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
                                
                                <div class="tab-pane active fade in" id="general">
                                    <div class="col-md-10">
                                        <div class="form-group">
                                            <label class="col-md-2">
                                                <?php echo e(__('authorization::dashboard.roles.form.name')); ?>

                                            </label>
                                            <div class="col-md-9">
                                                <input type="text" name="name" placeholder="add_user"
                                                       class="form-control" data-name="name">
                                                <div class="help-block"></div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-2">
                                                <?php echo e(__('authorization::dashboard.roles.form.permissions')); ?>

                                            </label>
                                            <div class="col-md-9">
                                                <div class="mt-checkbox-list">
                                                    <ul>

                                                        <?php $__currentLoopData = $permissions->groupBy('category'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $perm): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <li style="list-style-type:none">
                                                                <label class="mt-checkbox">
                                                                    <input type="checkbox" class="permission-group">
                                                                    <strong><?php echo e($key); ?></strong>
                                                                    <span></span>
                                                                </label>
                                                                <ul class="row" style="list-style-type:none">
                                                                    <?php $__currentLoopData = $perm; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                        <li style="list-style-type:none">
                                                                            <label class="mt-checkbox col-md-4">
                                                                                <input class="child" type="checkbox"
                                                                                       name="permission[]"
                                                                                       value="<?php echo e($permission->id); ?>">
                                                                                <?php echo e($permission->display_name); ?>

                                                                                <span></span>
                                                                            </label>
                                                                        </li>
                                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                </ul>
                                                            </li>
                                                            <hr>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </ul>
                                                </div>
                                                <div class="help-block"></div>
                                            </div>
                                        </div>
                                        <?php $__currentLoopData = config('translatable.locales'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $code): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="form-group">
                                                <label class="col-md-2">
                                                    <?php echo e(__('authorization::dashboard.roles.form.key')); ?> - <?php echo e($code); ?>

                                                </label>
                                                <div class="col-md-9">
                                                    <input type="text" name="display_name[<?php echo e($code); ?>]"
                                                           placeholder="users" class="form-control"
                                                           data-name="display_name.<?php echo e($code); ?>">
                                                    <div class="help-block"></div>
                                                </div>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                                    <a href="<?php echo e(url(route('dashboard.roles.index'))); ?>" class="btn btn-lg red">
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
    <script>
        $(document).ready(
            function () {
                $(".permission-group").click(function () {
                    $(this).parents('li').find('.child').prop('checked', this.checked);
                });
            }
        );
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('apps::dashboard.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/ahmed-nabil94/Desktop/PhpstormProjects/RoyalCard-Backend/Modules/Authorization/Resources/views/dashboard/roles/create.blade.php ENDPATH**/ ?>