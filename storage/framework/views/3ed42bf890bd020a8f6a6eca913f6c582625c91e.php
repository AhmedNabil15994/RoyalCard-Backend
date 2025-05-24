<?php $__env->startSection('title', __('user::dashboard.users.update.title')); ?>
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
                    <a href="<?php echo e(url(route('dashboard.users.index'))); ?>">
                        <?php echo e(__('user::dashboard.users.index.title')); ?>

                    </a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <a href="#"><?php echo e(__('user::dashboard.users.update.title')); ?></a>
                </li>
            </ul>
        </div>

        <h1 class="page-title"></h1>

        <div class="row">
                 <?php echo Form::model($model,[
                                    'url'=> route('dashboard.users.update',$model->id),
                                    'id'=>'updateForm',
                                    'role'=>'form',
                                    'method'=>'PUT',

                                    'class'=>'form-horizontal form-row-seperated',
                                    'files' => true
                                    ]); ?>



                <div class="col-md-12">

                    
                    <div class="col-md-3">
                        <div class="panel-group accordion scrollable"
                            id="accordion2">
                            <div class="panel panel-default">

                                <div id="collapse_2_1"
                                    class="panel-collapse in">
                                    <div class="panel-body">
                                        <ul class="nav nav-pills nav-stacked">
                                            <li class="active">
                                                <a href="#global_setting"
                                                    data-toggle="tab">
                                                    <?php echo e(__('user::dashboard.users.update.form.general')); ?>

                                                </a>
                                            </li>
                                            <li>
                                                <a href="#orders"
                                                   data-toggle="tab">
                                                    <?php echo e(__('order::dashboard.orders.index.title')); ?>

                                                </a>
                                            </li>






                                            <li>
                                                <a href="#wallets"
                                                   data-toggle="tab">
                                                    <?php echo e(__('user::dashboard.users.update.form.wallets')); ?>

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

                            
                            <div class="tab-pane active fade in"
                                id="global_setting">
                                <div class="col-md-10">
                                    <?php echo $__env->make('user::dashboard.users.form.form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                </div>
                            </div>
                            
                            <div class="tab-pane" id="orders">
                                <div class="col-md-12">
                                    <?php echo $__env->make('user::dashboard.users.form.orders', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                </div>
                            </div>





                            <div class="tab-pane" id="wallets">
                                <div class="col-md-12">
                                    <?php echo $__env->make('user::dashboard.users.form.wallets', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                </div>
                            </div>





                        </div>
                    </div>

                    
                    <div class="col-md-12">
                        <div class="form-actions">
                            <?php echo $__env->make('apps::dashboard.layouts._ajax-msg', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            <div class="form-group">
                                <button type="submit"
                                    id="submit"
                                    class="btn btn-lg green">
                                    <?php echo e(__('apps::dashboard.buttons.edit')); ?>

                                </button>
                                <a href="<?php echo e(url(route('dashboard.users.index'))); ?>"
                                    class="btn btn-lg red">
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

<?php $__env->startPush('start_scripts'); ?>
    <script>
        $(function (){
            $(document).on('click','.addBalance',function (){
                let walletId = $(this).data('area');
                $('.balanceModal .acceptBalance').data('area',walletId)
                $('.balanceModal').modal('show');
            });

            $(document).on('click','.balanceModal .acceptBalance',function (){
                let walletId = $(this).data('area');
                let balance = $('.balanceModal input[name="balance"]').val()

                $.ajax({
                    url: "<?php echo e(route('dashboard.users.addWalletBalance')); ?>",
                    type: 'post',
                    data:{
                        '_token': $('meta[name="csrf-token"]').attr('content'),
                        'wallet_id' : walletId,
                        'balance'   : balance
                    },
                    success: function (data){
                        if(data[0]){
                            toastr['success'](data[1])
                            $('.balanceModal').modal('hide');
                        }
                    },
                    error: function (error){
                        toastr['error'](data[1])
                    }
                })
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('apps::dashboard.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/ahmed-nabil94/Desktop/PhpstormProjects/RoyalCard-Backend/Modules/User/Resources/views/dashboard/users/show.blade.php ENDPATH**/ ?>