<?php $__env->startSection('title','Invoice #' . $order->id * 34567); ?>
<?php $__env->startSection('css'); ?>
    <style media="print">
        @page {
            size  : auto;
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
            .portlet.mt-50{
                margin-top: 10px;
            }
        }
    </style>
<style>
    body {
        font-family: 'Cairo', sans-serif !important;
        overflow-x: hidden;
    }
    table{
        width: 100% !important;
    }
    .mt-50{
        margin-top: 50px;
    }
    .mt-25{
        margin-top: 25px;
    }
    .printBtn{
        float: left;
    }
    p{
        color : #555;
        margin-bottom: 10px;
    }
    h4{
        font-size: 14px;
        letter-spacing: 1px;
        line-height: 1.4;
        margin-bottom: 5px;
    }
    .table{
        margin-top: 25px;
    }
    .table-bordered, .table-bordered>tbody>tr>td, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>td,
    .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td, .table-bordered>thead>tr>th{
        border: 2px solid #e7ecf1;
    }
    .portlet.light.bordered{
        border: 1px solid #e7ecf1 !important;
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
                            <li class="">
                                <a data-toggle="tab" href="#update">
                                    <i class="fa fa-cog"></i> <?php echo e(__('order::dashboard.orders.show.update')); ?>

                                </a>
                                <span class="after"></span>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-9 contentPrint">
                    <div class="tab-content">

                        <div class="tab-pane active" dir="<?php echo e(locale() == 'ar' ? 'rtl' : 'ltr'); ?>" id="order">
                            <div class="portlet light bordered">
                                <div class="portlet-body">
                                    <div class="row">
                                        <?php
                                            $transaction = $order->orderStatus->success_status ? $order->transactions()->whereIn('result',['paid','CAPTURED'])->latest('id')->first() : null;
                                            $method = $order->orderStatus->success_status ? $transaction?->method : '';
                                        ?>
                                        <div class="col-xs-6">
                                            <h2>
                                                <b>Invoice</b> <br>
                                                <span>فاتورة</span>
                                            </h2>
                                        </div>
                                        <div class="col-xs-6">
                                            <img src="<?php echo e(setting('logo') ? asset(setting('logo')) : asset('frontend/assets/images/mlogo-dark.png')); ?>" class="img-responsive pull-right"
                                                 style="width:20%" />
                                            <div class="clearfix"></div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-xs-3">
                                            <h4>
                                                <b>
                                                    Bill to <br>
                                                    بيانات العميل
                                                </b>
                                            </h4>
                                            <p>
                                                <?php echo e($order->user->name); ?> <br>
                                                <?php echo e($order->user->email); ?> <br>
                                                <?php echo e($order->user->mobile); ?>

                                            </p>
                                        </div>
                                        <div class="col-xs-3">
                                            <h4>
                                                <b>
                                                    Order ID <br>
                                                    رقم الطلب
                                                </b>
                                            </h4>
                                            <p>
                                                #<?php echo e($order['id']); ?> <br>
                                               <b> <?php echo e(__('order::dashboard.order_statuses.status.'.$order->orderStatus->title)); ?></b>
                                            </p>
                                        </div>
                                        <div class="col-xs-6">
                                            <div class="pull-right text-right">
                                                <h4>
                                                    <b><?php echo e($order['id'] * 34567); ?></b> <br>
                                                    <b><?php echo e(setting('contact_us','call_number')); ?></b>
                                                </h4>

                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-xs-3">
                                            <h4>
                                                <b>
                                                    Transaction ID <br>
                                                    رقم العملية
                                                </b>
                                            </h4>
                                            <p>
                                                <?php if($transaction?->id): ?>
                                                    #<?php echo e($transaction?->id); ?>

                                                <?php endif; ?>
                                            </p>
                                        </div>
                                        <div class="col-xs-3">
                                            <h4>
                                                <b>
                                                    Order Date <br>
                                                    تاريخ الطلب
                                                </b>
                                            </h4>
                                            <p>
                                                <?php echo e(date('Y-m-d / H:i:s' , strtotime($order->created_at))); ?>

                                            </p>
                                        </div>
                                        <div class="col-xs-6">
                                            <div class="pull-right text-right">
                                                <h4>
                                                    <b>
                                                        Tax Registration Number <br>
                                                        الرقم الضريبي
                                                    </b>
                                                </h4>
                                                <p>
                                                    <?php echo e(setting('tax_number')[$order->country_id] ?? ''); ?>

                                                </p>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-xs-12 table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                <tr>
                                                    <th colspan="2" class="invoice-title uppercase text-center">
                                                        <b>Product Name</b> <br>
                                                        اسم المنتج
                                                    </th>
                                                    <th class="invoice-title uppercase text-center">
                                                        <b>Product Type</b> <br>
                                                        نوع المنتج
                                                    </th>
                                                    <th class="invoice-title uppercase text-center">
                                                        <b>Quantity</b> <br>
                                                        الكمية
                                                    </th>
                                                    <th class="invoice-title uppercase text-center">
                                                        <b>Price</b> <br>
                                                        السعر
                                                    </th>
                                                    <th class="invoice-title uppercase text-center">
                                                        <b>Total</b> <br>
                                                        المجموع العام
                                                    </th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                    $allDiff = 0;
                                                    $subTotal = 0;
                                                ?>
                                                <?php $__currentLoopData = $order->orderItems()->groupBy('product_id')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php
                                                        $offer = $item?->offer ?? null;
                                                        $qty = $order->orderItems()->where('product_id',$item->product_id)->count();
                                                        $oldPrice = $item->product->getPrice($order);
                                                        $diff = $oldPrice ? ($oldPrice[0] - $item->total) : 0;
                                                        $allDiff+= ($diff * $qty);
                                                        $subTotal+= $oldPrice[0] * $qty;
                                                    ?>

                                                    <tr>
                                                        <td colspan="2" class="text-center sbold">
                                                            <a href="<?php echo e(route('dashboard.products.edit',['product'=>$item->product_id])); ?>" target="_blank"><?php echo e($item->product->title); ?> </a>
                                                        </td>
                                                        <td class="text-center sbold">
                                                            <?php echo e(__('catalog::dashboard.products.form.product_type.'.$item->product->product_type)); ?> <br>
                                                            <?php if($item->product->product_type == 'support'): ?>
                                                                <?php echo e(__('order::dashboard.orders.datatable.account_id')); ?> : <?php echo e($item->account_id); ?>

                                                                <br>
                                                                <?php if($item->server): ?>
                                                                    <?php echo e(__('order::dashboard.orders.datatable.selected_server')); ?> : <?php echo e($item->server?->title); ?>

                                                                    <br>
                                                                <?php endif; ?>
                                                            <?php else: ?>
                                                                <?php $__currentLoopData = $order->orderItems()->where('product_id',$item->product_id)->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $itemCode): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                    <?php if(in_array($order->order_status_id,[1,5])): ?>
                                                                        <?php echo e(__('order::dashboard.orders.datatable.code')); ?>: <?php echo e($itemCode->code); ?> <br>
                                                                    <?php endif; ?>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td class="text-center sbold">
                                                            <?php echo e($qty); ?>

                                                        </td>
                                                        <td class="text-center sbold">
                                                            <?php echo e(number_format($oldPrice[0],3)); ?> <?php echo e($order->country->currency->code); ?>

                                                        </td>
                                                        <td class="text-center sbold">
                                                            <?php echo e(number_format(($qty * $oldPrice[0]) ,3)); ?> <?php echo e($order->country->currency->code); ?>

                                                        </td>
                                                    </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td colspan="4"><b>Payment Method </b>(طريقة الدفع)</td>
                                                    <td colspan="2"><b><?php echo e($method ?  __('order::dashboard.order_statuses.payments.'.$method) : ''); ?></b></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4"><b>Discount </b>(كوبون الخصم)</td>
                                                    <td colspan="2"><b><?php echo e(number_format($order->discount + $allDiff,3)); ?> <?php echo e($order->country->currency->code); ?></b></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4"><b>VAT </b>(قيمة الضريبة المضافة)</td>
                                                    <td colspan="2"><b><?php echo e(number_format(0,3)); ?> <?php echo e($order->country?->currency?->code ?? ''); ?></b></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4"><b>Total </b>(اجمالي الطلب)</td>
                                                    <td colspan="2"><b><?php echo e(number_format($order->total,3)); ?> <?php echo e($order->country?->currency?->code ?? ''); ?></b></td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <?php if($order->country_id == 195): ?>
                                        <div class="row mt-25">
                                            <div class="col-xs-12">
                                                <?php echo $order->qr; ?>

                                                <h5 style="line-height: 1.8">
                                                    <b>
                                                        The QR code is encoded as per ZATCA e-invoicing requirements.<br>
                                                        رمز الاستجابة السريعة مشفر بحسب متطلبات هيئة الزكاة والضريبة والجمارك للفوترة الالكترونية.
                                                    </b>
                                                </h5>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    
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
                            <div class=" text-left mt-25">
                                <a class="btn btn-lg blue hidden-print margin-bottom-5 printBtn" onclick="javascript:window.print();">
                                    <?php echo e(__('apps::dashboard.buttons.print')); ?>

                                    <i class="fa fa-print"></i>
                                </a>
                                <div class="clearfix"></div>
                            </div>
                        </div>

                        <div class="tab-pane" id="update">
                            <form id="updateForm" role="form" class="form-horizontal form-row-seperated" method="post" enctype="multipart/form-data" action="<?php echo e(route('dashboard.orders.update',$order['id'])); ?>">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('PUT'); ?>
                                <?php if(auth()->user()->hasRole('super-admin')): ?>
                                <div class="form-group">
                                    <label class="col-md-2">
                                        <?php echo e(__('order::dashboard.orders.show.status')); ?>

                                        <span class="required" aria-required="true">*</span>
                                    </label>
                                    <div class="col-md-9">
                                        <select name="status_id" id="single" class="form-control select2" data-name="status_id">
                                            <option value=""></option>
                                            <?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($status['id']); ?>" <?php echo e($order->order_status_id == $status->id ? 'selected' : ''); ?>>
                                                    <?php echo e($status->title); ?>

                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                        <div class="help-block"></div>
                                    </div>
                                </div>
                                <?php endif; ?>

                                <?php if($order->order_status_id == 5): ?>
                                <div class="form-group">
                                    <?php
                                        $supportStatuses = [
                                            ['id'   => 1 , 'title' => __('order::dashboard.orders.show.support_statuses.new')],
                                            ['id'   => 2 , 'title' => __('order::dashboard.orders.show.support_statuses.in_progress')],
                                            ['id'   => 3 , 'title' => __('order::dashboard.orders.show.support_statuses.done')],
                                            ['id'   => 4 , 'title' => __('order::dashboard.orders.show.support_statuses.cancelled')],
                                        ];

                                        if(!auth()->user()->hasRole('super-admin') /*|| (!auth()->user()->hasRole('super-admin') && $order->support_status_id != 3)*/){
                                            $supportStatuses = [
                                                ['id'   => 3 , 'title' => __('order::dashboard.orders.show.support_statuses.done')],
                                            ];
                                        }
                                    ?>
                                    <label class="col-md-2">
                                        <?php echo e(__('order::dashboard.orders.show.support_status')); ?>

                                        <span class="required" aria-required="true">*</span>
                                    </label>
                                    <div class="col-md-9">
                                        <select name="support_status_id" id="single" class="form-control select2" data-name="support_status_id">
                                            <option value=""></option>
                                            <?php $__currentLoopData = $supportStatuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $supportStatus): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($supportStatus['id']); ?>" <?php echo e($order->support_status_id == $supportStatus['id'] ? 'selected' : ''); ?>>
                                                    <?php echo e($supportStatus['title']); ?>

                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                        <div class="help-block"></div>
                                    </div>
                                </div>
                                <?php endif; ?>

                                <div class="col-md-12">
                                    <div class="form-actions">
                                        <?php echo $__env->make('apps::dashboard.layouts._ajax-msg', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                        <div class="form-group">
                                            <button type="submit" id="submit" class="btn btn-lg green">
                                                <?php echo e(__('apps::dashboard.buttons.edit')); ?>

                                            </button>
                                            <a href="<?php echo e(url(route('dashboard.orders.index'))); ?>" class="btn btn-lg red">
                                                <?php echo e(__('apps::dashboard.buttons.back')); ?>

                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <div class="portlet light bordered mt-50" style="    border: 1px solid #e7ecf1!important">
                                    <div class="portlet-title">
                                        <div class="caption font-red-sunglo">
                                            <i class="fa fa-archive font-red-sunglo"></i>
                                            <span class="caption-subject bold uppercase">
                                            <?php echo e(__('order::dashboard.orders.show.order_history_log')); ?>

                                        </span>
                                        </div>
                                    </div>
                                    <div class="portlet-body">
                                        <div class="no-print row">
                                            <div class="col-md-12">
                                                <div class="table-responsive">
                                                    <table class="table table-striped table-hover">
                                                        <thead>
                                                        <tr>
                                                            <th class="invoice-title uppercase text-center">
                                                                <?php echo e(__('order::dashboard.orders.show.result')); ?>

                                                            </th>
                                                            <th class="invoice-title uppercase text-center">
                                                                <?php echo e(__('order::dashboard.orders.show.payment_id')); ?>

                                                            </th>
                                                            <th class="invoice-title uppercase text-center">
                                                                <?php echo e(__('order::dashboard.orders.show.method')); ?>

                                                            </th>
                                                            <th class="invoice-title uppercase text-center">
                                                                <?php echo e(__('order::dashboard.orders.show.tran_id')); ?>

                                                            </th>
                                                            <th class="invoice-title uppercase text-center">
                                                                <?php echo e(__('order::dashboard.orders.show.order.total')); ?>

                                                            </th>
                                                            <th class="invoice-title uppercase text-center">
                                                                <?php echo e(__('order::dashboard.orders.show.tran_date')); ?>

                                                            </th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <?php $__currentLoopData = $order->transactions()->orderBy('id', 'desc')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $history): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <tr id="orderHistory-<?php echo e(optional($history->pivot)->id); ?>">
                                                                <td class="text-center sbold">
                                                                    <?php echo e($history->result ?? ''); ?>

                                                                </td>
                                                                <td class="text-center sbold">
                                                                    <?php echo e($history->payment_id ?? ''); ?>

                                                                </td>
                                                                <td class="text-center sbold">
                                                                    <?php echo e(ucwords($history->method) ?? ''); ?>

                                                                </td>
                                                                <td class="text-center sbold">
                                                                    <?php if($history->method == 'wallet'): ?>
                                                                        <?php $wallet = $order->user->getCountryWallet($order); ?>
                                                                        <?php echo e(__('order::dashboard.orders.datatable.wallet_no')); ?> <?php echo e($wallet->id); ?>

                                                                    <?php else: ?>
                                                                        <?php echo e($history->tran_id); ?>

                                                                    <?php endif; ?>
                                                                </td>
                                                                <td class="text-center sbold">
                                                                    <?php echo e(number_format($history->recharge_balance ?? $history->order->total,3) . ' ' . $order->country->currency->code); ?>

                                                                </td>
                                                                <td class="text-center sbold">
                                                                    <?php echo e($history->created_at ? date('Y-m-d H:i A',strtotime($history->created_at)) : ''); ?>

                                                                </td>
                                                            </tr>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
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

<?php echo $__env->make('apps::dashboard.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/ahmed-nabil94/Desktop/PhpstormProjects/RoyalCard-Backend/Modules/Order/Resources/views/dashboard/orders/show.blade.php ENDPATH**/ ?>