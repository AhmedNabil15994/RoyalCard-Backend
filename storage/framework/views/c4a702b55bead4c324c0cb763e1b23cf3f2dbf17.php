<?php $__env->startSection('title', __('order::dashboard.orders.show.title')); ?>
<?php $__env->startSection('css'); ?>
    <style media="print">
        @page {
            margin: 0;
        }
        @media print {
            a[href]:after {
                content: none !important;
            }
            .contentPrint{
                width: 100%;
            }
            .no-print, .no-print *{
                display: none !important;
            }
            code {
                border-radius: 4px;
                background-color: unset !important;
            }
        }
    </style>
<style>
    .mt-50{
        margin-top: 50px;
    }
    html[lang='ar'] .text-right{
        text-align: right !important;
    }
    code {
        color: #000;
        border-radius: 4px;
        background-color: unset !important;
    }
</style>
<?php $__env->stopSection(); ?>
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
                    <a href="<?php echo e(url(route('dashboard.orders.index'))); ?>">
                        <?php echo e(__('order::dashboard.orders.index.title')); ?>

                    </a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <a href="#"><?php echo e(__('order::dashboard.orders.show.title')); ?></a>
                </li>
            </ul>
        </div>

        <h1 class="page-title"></h1>

        <div class="row">
            <div class="col-md-12">
                <div class="no-print">
                    <div class="col-md-3">
                        <ul class="ver-inline-menu tabbable margin-bottom-10">
                            <li class="active">
                                <a data-toggle="tab" href="#order">
                                    <i class="fa fa-cog"></i> <?php echo e(__('order::dashboard.orders.show.invoice')); ?>

                                </a>
                                <span class="after"></span>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-9 contentPrint">
                    <div class="tab-content">

                        <div class="tab-pane active" id="order">
                            <div class="invoice-content-2 bordered">

                                <div class="col-md-12" style="margin-bottom: 24px;">
                                    <?php
                                        $details = $transaction->getDetails();
                                        $method = $transaction->method;
                                        $user = $transaction?->transaction?->user;
                                        $country = $transaction?->transaction?->country;
                                        $currency = $transaction?->transaction?->country?->currency;

                                        $title = $details['title'];
                                        $type = $details['type'];
                                        $description = $details['description'];
                                    ?>
                                    <center>
                                        <img src="<?php echo e(setting('logo') ? asset(setting('logo')) : asset('frontend/assets/images/mlogo-dark.png')); ?>" class="img-responsive" style="margin-bottom: 25px;width:18%" />
                                        <b><?php echo e($title); ?></b> <br>
                                        <b>
                                            #<?php echo e($transaction->id); ?> -
                                            <?php echo e(date('Y-m-d / H:i:s' , strtotime($transaction->created_at))); ?>

                                        </b>
                                    </center>
                                    <?php if($method): ?>
                                    <center>
                                        <b><?php echo e($method); ?></b>
                                    </center>
                                    <?php endif; ?>
                                    <center>
                                        <b><?php echo e(__('order::dashboard.orders.show.order.tax_certificate')); ?>: 312098037100003</b>
                                    </center>
                                </div>

                                <?php if($user): ?>
                                    <div class="row">
                                        <div class="col-xs-12 table-responsive">
                                            <table class="table table-striped table-hover">
                                                <thead>
                                                    <tr>
                                                        <th class="invoice-title uppercase text-center">
                                                            <?php echo e(__('order::dashboard.orders.show.username')); ?>

                                                        </th>
                                                        <th class="invoice-title uppercase text-center">
                                                            <?php echo e(__('order::dashboard.orders.show.email')); ?>

                                                        </th>
                                                        <th class="invoice-title uppercase text-center">
                                                            <?php echo e(__('order::dashboard.orders.show.mobile')); ?>

                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td class="text-center sbold"> <?php echo e($user->name); ?></td>
                                                        <td class="text-center sbold"> <?php echo e($user->email); ?></td>
                                                        <td class="text-center sbold"> <?php echo e($user->mobile); ?></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <div class="row">
                                    <div class="col-xs-12 table-responsive">
                                        <table class="table table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th class="invoice-title uppercase text-center">
                                                        <?php echo e(__('order::dashboard.orders.datatable.description')); ?>

                                                    </th>
                                                    <th class="invoice-title uppercase text-center">
                                                        <?php echo e(__('order::dashboard.orders.show.order.course_price')); ?>

                                                    </th>
                                                    <?php if($transaction->transaction_type == 'Modules\Order\Entities\Order'): ?>
                                                    <th class="invoice-title uppercase text-center hidden-print">
                                                        <?php echo e(__('order::dashboard.orders.datatable.order')); ?>

                                                    </th>
                                                    <?php else: ?>
                                                    <th class="invoice-title uppercase text-center hidden-print">
                                                        <?php echo e(__('order::dashboard.orders.datatable.wallet')); ?>

                                                    </th>
                                                    <?php endif; ?>
                                                    <th class="invoice-title uppercase text-center hidden-print">
                                                        <?php echo e(__('order::dashboard.orders.datatable.country')); ?>

                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    $allDiff = 0;
                                                    $subTotal = 0;
                                                ?>
                                                <tr>
                                                    <td class="text-center sbold">
                                                        <?php echo e($description); ?>

                                                    </td>
                                                    <td class="text-center sbold">
                                                        <?php echo e(number_format($transaction->recharge_balance,3)); ?>

                                                    </td>
                                                    <?php if($transaction->transaction_type == 'Modules\Order\Entities\Order'): ?>
                                                    <td class="text-center sbold">
                                                        <a href="<?php echo e(route('dashboard.orders.show',['id'=>$transaction->transaction_id])); ?>" target="_blank">
                                                            <?php echo e(__('order::dashboard.orders.show.order_id')); ?> <?php echo e($transaction->transaction_id); ?>

                                                        </a>
                                                    </td>
                                                    <?php else: ?>
                                                    <td class="text-center sbold">
                                                        <a href="<?php echo e(route('dashboard.users.show',['user'=>$transaction->wallet?->user_id])); ?>#wallets" target="_blank">
                                                            <?php echo e(__('order::dashboard.orders.datatable.wallet_no')); ?> <?php echo e($transaction->transaction_id); ?>

                                                        </a>
                                                    </td>
                                                    <?php endif; ?>
                                                    <td class="text-center sbold">
                                                        <?php echo e($country->title); ?>

                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xs-12 table-responsive">
                                        <table class="table table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th class="invoice-title uppercase text-center">
                                                        <?php echo e(__('order::dashboard.orders.show.order.subtotal')); ?>

                                                    </th>
                                                    <th class="invoice-title uppercase text-center">
                                                        <?php echo e(__('order::dashboard.orders.show.order.tax')); ?>

                                                    </th>
                                                    <th class="invoice-title uppercase text-center">
                                                        <?php echo e(__('order::dashboard.orders.show.order.total')); ?>

                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td class="text-center sbold">
                                                        <?php echo e(number_format($transaction->recharge_balance,3)); ?> <?php echo e($currency->code); ?>

                                                    </td>
                                                    <td class="text-center sbold">
                                                        <?php echo e(number_format(0,3)); ?> <?php echo e($currency->code); ?>

                                                    </td>
                                                    <td class="text-center sbold">
                                                        <?php echo e(number_format($transaction->recharge_balance,3)); ?> <?php echo e($currency->code); ?>

                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <?php if($transactionDetails): ?>
                                <div class="row">
                                    <h3>Transaction Details</h3>
                                    <div class="col-md-12">
                                        <?php $__currentLoopData = $transactionDetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php if(is_array($value)): ?>
                                                <?php $__currentLoopData = $value; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key2 => $value2): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php if($value2): ?>
                                                        <code><?php echo e($key2 . ' : ' . $value2); ?></code> <br>
                                                    <?php endif; ?>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php else: ?>
                                                <?php if($value): ?>
                                                    <code><?php echo e($key . ' : ' . $value); ?></code> <br>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-4">
                    <a class="btn btn-lg blue hidden-print margin-bottom-5" onclick="javascript:window.print();">
                        <?php echo e(__('apps::dashboard.buttons.print')); ?>

                        <i class="fa fa-print"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>

<script>
    $('.24_format').timepicker({
        showMeridian: true,
        format: 'hh:mm',
    });

    $('.datepicker').datepicker({
        format: 'yyyy-mm-dd',
        startDate: '0d'
    });

    let item_code = '<?php echo e(request()->item_code); ?>';
    if(item_code != ''){
        $('[data-item="'+item_code+'"]').trigger('click')
    }
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('apps::dashboard.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/ahmed-nabil94/Desktop/PhpstormProjects/RoyalCard-Backend/Modules/User/Resources/views/dashboard/users/wallets/show.blade.php ENDPATH**/ ?>