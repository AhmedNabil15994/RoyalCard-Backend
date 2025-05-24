<!DOCTYPE html>
<html lang="ar" dir="ltr">
<head>
    <meta charset="utf-8"/>
    <title><?php echo e(__('order::dashboard.orders.show.invoice'). ' #' . $order->id * 34567); ?> || <?php echo e(setting('app_name',locale())); ?></title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport"/>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>"/>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8">
    <link href="https://fonts.googleapis.com/css?family=Cairo" rel="stylesheet" type="text/css"/>
    <link href="<?php echo e(asset('/admin/assets/global/plugins/font-awesome/css/font-awesome.min.css')); ?>" rel="stylesheet" type="text/css"/>
    <link href="<?php echo e(asset('/admin/assets/global/plugins/bootstrap/css/bootstrap.min.css')); ?>" rel="stylesheet" type="text/css"/>
    <link href="<?php echo e(asset('/admin/assets/global/css/components-md-rtl.min.css')); ?>" rel="stylesheet" id="style_components" type="text/css"/>
    <link rel="shortcut icon" href="<?php echo e(setting('favicon') ? asset(setting('favicon')) : ''); ?>"/>

    <style media="all">
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
            line-height: 1.2;
            margin-bottom: 5px;
        }
        .table{
            margin-top: 25px;
        }
        .table-bordered, .table-bordered>tbody>tr>td, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>td,
        .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td, .table-bordered>thead>tr>th{
            border: 2px solid #e7ecf1;
        }
        @media(max-width: 767px){
            img {
                width: 50% !important;
            }
            h2{
                font-size: 20px;
            }
            h4{
                font-size: 11px;
                line-height: 1.2;
            }
            p.tax{
                line-break: anywhere;
            }
            .table thead tr th{
                font-size: 10px !important;
            }
            .table-responsive{
                padding: 0 !important;
            }
            .table{
                margin:0 !important;
            }
            .table td{
                font-size: 12px !important;
            }
        }
    </style>

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

</head>
<body class="page-header-fixed page-sidebar-closed-hide-logo page-content-white page-md">
    <div class="container">
        <div class="portlet light bordered mt-50">
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
                    <div class="col-xs-4">
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
                    <div class="col-xs-4">
                        <h4>
                            <b>
                                Order ID <br>
                                رقم الطلب
                            </b>
                        </h4>
                        <p>
                            #<?php echo e($order['id']); ?>

                        </p>
                    </div>
                    <div class="col-xs-4">
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
                    <div class="col-xs-4">
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
                    <div class="col-xs-4">
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
                    <div class="col-xs-4">
                        <div class="pull-right text-right">
                            <h4>
                                <b>
                                    Tax Registration Number <br>
                                    الرقم الضريبي
                                </b>
                            </h4>
                            <p class="tax">
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
            </div>
        </div>







    </div>
</body>












































































</html>
<?php /**PATH /home/ahmed-nabil94/Desktop/PhpstormProjects/RoyalCard-Backend/Modules/Order/Resources/views/dashboard/orders/invoice.blade.php ENDPATH**/ ?>