<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8"/>
    <title>{{__('order::dashboard.orders.show.invoice'). ' #' . $order->id * 34567}} || {{ setting('app_name',locale()) }}</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport"/>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8">
    <link href="https://fonts.googleapis.com/css?family=Cairo" rel="stylesheet" type="text/css"/>
    <link href="{{asset('/admin/assets/global/plugins/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('/admin/assets/global/plugins/bootstrap/css/bootstrap-rtl.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('/admin/assets/global/css/components-md-rtl.min.css')}}" rel="stylesheet" id="style_components" type="text/css"/>
    <link rel="shortcut icon" href="{{ setting('favicon') ? asset(setting('favicon')) : '' }}"/>

    <style>
        body {
            font-family: 'Cairo', sans-serif !important;
            overflow-x: hidden;
        }
        .portlet {
            box-shadow: none !important;
        }
        .portlet.light.bordered {
            border: none !important;
        }
        .dropdown-menu {
            font-family: 'Cairo', sans-serif !important;
        }
        .daterangepicker_input {
            display: none !important;
        }
        table{
            width: 100% !important;
        }
        .mt-50{
            margin-top: 50px;
        }
        html[lang='ar'] .text-right{
            text-align: right !important;
        }
        .printBtn{
            float: left;
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
        }
    </style>

</head>

<body class="page-header-fixed page-sidebar-closed-hide-logo page-content-white page-md">
    <div class="row">
        <div class="col-md-12 text-center mt-50">
            <div class="col-md-8 col-md-offset-2 contentPrint">
                <div class="tab-content">
                    <div class="tab-pane active" id="order">
                        <div class="invoice-content-2 bordered">
                            <div class="col-md-12" style="margin-bottom: 24px;">
                                @php
                                    $method = $order->orderStatus->success_status ? $order->transactions()->whereIn('result',['paid','CAPTURED'])->first()?->method : '';
                                @endphp
                                <center>
                                    <img src="{{setting('logo') ? asset(setting('logo')) : asset('frontend/assets/images/mlogo-dark.png') }}" class="img-responsive" style="margin-bottom: 25px;width:18%" />
                                    <b>{{  __('order::dashboard.orders.show.order_id') }} {{$order['id']}}</b> <br>
                                    <b>
                                        #{{ $order['id'] * 34567 }} -
                                        {{ date('Y-m-d / H:i:s' , strtotime($order->created_at)) }}
                                    </b>
                                </center>
                                @if ($order['type'] == 'cash')
                                    <center>{{__('order::dashboard.orders.show.cash_payment')}}</center>
                                @else
                                    <center>{{  __('order::dashboard.order_statuses.status.'.$order->orderStatus->title) }}</center>
                                @endif
                                @if($method)
                                <center>
                                    <b>{{ __('order::dashboard.order_statuses.payments.'.$method) }}</b>
                                </center>
                                @endif
                                <center>
                                    <b>{{__('order::dashboard.orders.show.order.tax_certificate')}}: 312098037100003</b>
                                </center>
                            </div>

                            @if ($order->user)
                                <div class="row">
                                    <div class="col-xs-12 table-responsive">
                                        <table class="table table-striped table-hover">
                                            <thead>
                                            <tr>
                                                <th class="invoice-title uppercase text-center">
                                                    {{__('order::dashboard.orders.show.username')}}
                                                </th>
                                                <th class="invoice-title uppercase text-center">
                                                    {{__('order::dashboard.orders.show.email')}}
                                                </th>
                                                <th class="invoice-title uppercase text-center">
                                                    {{__('order::dashboard.orders.show.mobile')}}
                                                </th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td class="text-center sbold"> {{ $order->user->name }}</td>
                                                <td class="text-center sbold"> {{ $order->user->email }}</td>
                                                <td class="text-center sbold"> {{ $order->user->mobile }}</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @endif

                            <div class="row">
                                <div class="col-xs-12 table-responsive">
                                    <table class="table table-striped table-hover">
                                        <thead>
                                        <tr>
                                            <th class="invoice-title uppercase text-center">
                                                {{__('order::dashboard.orders.show.order.item')}}
                                            </th>
                                            <th class="invoice-title uppercase text-center">
                                                {{__('order::dashboard.orders.show.order.qty')}}
                                            </th>
                                            <th class="invoice-title uppercase text-center">
                                                {{__('order::dashboard.orders.show.order.course_price')}}
                                            </th>
                                            <th class="invoice-title uppercase text-center hidden-print">
                                                {{__('order::dashboard.orders.datatable.code')}}
                                            </th>
                                            <th class="invoice-title uppercase text-center hidden-print">
                                                {{__('order::dashboard.orders.datatable.account_id')}}
                                            </th>
                                            <th class="invoice-title uppercase text-center hidden-print">
                                                {{__('order::dashboard.orders.datatable.selected_server')}}
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $allDiff = 0;
                                                $subTotal = 0;
                                            @endphp
                                            @foreach ($order->orderItems()->groupBy('product_id')->get() as $item)
                                                @php
                                                    $offer = $item?->offer ?? null;
                                                    $qty = $order->orderItems()->where('product_id',$item->product_id)->count();
                                                    $oldPrice = $item->product->getPrice($order);
                                                    $diff = $oldPrice ? ($oldPrice[0] - $item->total) : 0;
                                                    $allDiff+= ($diff * $qty);
                                                    $subTotal+= $oldPrice[0] * $qty;
                                                @endphp

                                                <tr>
                                                    <td class="text-center sbold">
                                                        <a href="{{route('dashboard.products.edit',['product'=>$item->product_id])}}" target="_blank">{{ $item->product->title }}</a>
                                                    </td>
                                                    <td class="text-center sbold">
                                                        {{ $order->orderItems()->where('product_id',$item->product_id)->count() }}
                                                    </td>
                                                    <td class="text-center sbold">
                                                        {{ $item->total }}
                                                    </td>
                                                    <td class="text-center sbold">
                                                        @foreach($order->orderItems()->where('product_id',$item->product_id)->get() as $itemCode)
                                                            @if(in_array($order->order_status_id,[1,5]))
                                                                {{$itemCode->code}} <br>
                                                            @endif
                                                        @endforeach
                                                    </td>
                                                    <td class="text-center sbold">
                                                        {{$item->account_id}}
                                                    </td>
                                                    <td class="text-center sbold">
                                                        {{$item->server?->title}}
                                                    </td>
                                                    {{--                                                        <td class="text-center hidden-print">--}}
                                                    {{--                                                            <button  class="btn btn-primary btn-icon" data-toggle="modal" data-item="{{$item->code}}" data-target="#qrCode{{$item->id}}">--}}
                                                    {{--                                                                <i class="fa fa-eye"></i>--}}
                                                    {{--                                                            </button>--}}
                                                    {{--                                                        </td>--}}
                                                </tr>
                                            @endforeach
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
                                                {{__('order::dashboard.orders.show.order.subtotal')}}
                                            </th>
                                            <th class="invoice-title uppercase text-center">
                                                {{__('order::dashboard.orders.show.order.off')}}
                                            </th>
                                            <th class="invoice-title uppercase text-center">
                                                {{__('order::dashboard.orders.show.order.tax')}}
                                            </th>
                                            <th class="invoice-title uppercase text-center">
                                                {{__('order::dashboard.orders.show.order.total')}}
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td class="text-center sbold">
                                                {{ number_format($subTotal,3) }} {{ $order->country?->currency?->code ?? '' }}
                                            </td>
                                            <td class="text-center sbold">
                                                {{ number_format($order->discount + $allDiff,3) }} {{ $order->country?->currency?->code ?? '' }}
                                            </td>
                                            <td class="text-center sbold">
                                                {{ number_format(0,3) }} {{ $order->country?->currency?->code ?? '' }}
                                            </td>
                                            <td class="text-center sbold">
                                                {{ $order->total }} {{ $order->country?->currency?->code ?? '' }}
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="row hidden">
                                <div class="portlet light bordered mt-50" style="    border: 1px solid #e7ecf1!important">
                                    <div class="portlet-title">
                                        <div class="caption font-red-sunglo">
                                            <i class="fa fa-archive font-red-sunglo"></i>
                                            <span class="caption-subject bold uppercase">
                                            {{ __('order::dashboard.orders.show.order_history_log') }}
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
                                                                {{ __('order::dashboard.orders.show.result') }}
                                                            </th>
                                                            <th class="invoice-title uppercase text-center">
                                                                {{ __('order::dashboard.orders.show.payment_id') }}
                                                            </th>
                                                            <th class="invoice-title uppercase text-center">
                                                                {{ __('order::dashboard.orders.show.method') }}
                                                            </th>
                                                            <th class="invoice-title uppercase text-center">
                                                                {{ __('order::dashboard.orders.show.tran_id') }}
                                                            </th>
                                                            <th class="invoice-title uppercase text-center">
                                                                {{ __('order::dashboard.orders.show.tran_date') }}
                                                            </th>

                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @foreach ($order->transactions()->orderBy('id', 'desc')->get() as $k => $history)
                                                            <tr id="orderHistory-{{ optional($history->pivot)->id }}">
                                                                <td class="text-center sbold">
                                                                    {{ $history->result ?? '' }}
                                                                </td>
                                                                <td class="text-center sbold">
                                                                    {{ $history->payment_id ?? '' }}
                                                                </td>
                                                                <td class="text-center sbold">
                                                                    {{ ucwords($history->method) ?? '' }}
                                                                </td>
                                                                <td class="text-center sbold">
                                                                    {{ $history->tran_id ?? '' }}
                                                                </td>
                                                                <td class="text-center sbold">
                                                                    {{ $history->created_at ? date('Y-m-d H:i A',strtotime($history->created_at)) : '' }}
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row text-left mt-50">
                                <a class="btn btn-lg blue hidden-print margin-bottom-5 printBtn" onclick="javascript:window.print();">
                                    {{__('apps::dashboard.buttons.print')}}
                                    <i class="fa fa-print"></i>
                                </a>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
