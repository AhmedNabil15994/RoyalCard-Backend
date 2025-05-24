@extends('apps::dashboard.layouts.app')
@section('title','Invoice #' . $order->id * 34567)
@section('css')
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
            code {
                border-radius: 4px;
                background-color: unset !important;
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
    code {
        color: #000;
        border-radius: 4px;
        background-color: unset !important;
    }
</style>
@endsection
@section('content')

<div class="page-content-wrapper">
    <div class="page-content">
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <a href="{{ url(route('dashboard.home')) }}">{{ __('apps::dashboard.index.title') }}</a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <a href="{{ url(route('dashboard.orders.index')) }}">
                        {{__('order::dashboard.orders.index.title')}}
                    </a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <a href="#">{{__('order::dashboard.orders.show.title')}}</a>
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
                                    <i class="fa fa-cog"></i> {{__('order::dashboard.orders.show.invoice')}}
                                </a>
                                <span class="after"></span>
                            </li>
                            <li class="">
                                <a data-toggle="tab" href="#update">
                                    <i class="fa fa-cog"></i> {{__('order::dashboard.orders.show.update')}}
                                </a>
                                <span class="after"></span>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-9 contentPrint">
                    <div class="tab-content">

                        <div class="tab-pane active" dir="{{locale() == 'ar' ? 'rtl' : 'ltr'}}" id="order">
                            <div class="portlet light bordered">
                                <div class="portlet-body">
                                    <div class="row">
                                        @php
                                            $transaction = $order->orderStatus->success_status ? $order->transactions()->whereIn('result',['paid','CAPTURED'])->latest('id')->first() : null;
                                            $method = $order->orderStatus->success_status ? $transaction?->method : '';
                                        @endphp
                                        <div class="col-xs-6">
                                            <h2>
                                                <b>Invoice</b> <br>
                                                <span>فاتورة</span>
                                            </h2>
                                        </div>
                                        <div class="col-xs-6">
                                            <img src="{{setting('logo') ? asset(setting('logo')) : asset('frontend/assets/images/mlogo-dark.png') }}" class="img-responsive pull-right"
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
                                                {{ $order->user->name }} <br>
                                                {{ $order->user->email }} <br>
                                                {{ $order->user->mobile }}
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
                                                #{{$order['id']}} <br>
                                               <b> {{  __('order::dashboard.order_statuses.status.'.$order->orderStatus->title) }}</b>
                                            </p>
                                        </div>
                                        <div class="col-xs-6">
                                            <div class="pull-right text-right">
                                                <h4>
                                                    <b>{{ $order['id'] * 34567 }}</b> <br>
                                                    <b>{{setting('contact_us','call_number')}}</b>
                                                </h4>
{{--                                                <h5><b>{{setting('office_address',locale())}}</b></h5>--}}
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
                                                @if($transaction?->id)
                                                    #{{$transaction?->id}}
                                                @endif
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
                                                {{ date('Y-m-d / H:i:s' , strtotime($order->created_at)) }}
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
                                                    {{setting('tax_number')[$order->country_id] ?? ''}}
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
                                                        <td colspan="2" class="text-center sbold">
                                                            <a href="{{route('dashboard.products.edit',['product'=>$item->product_id])}}" target="_blank">{{ $item->product->title }} </a>
                                                        </td>
                                                        <td class="text-center sbold">
                                                            {{ __('catalog::dashboard.products.form.product_type.'.$item->product->product_type) }} <br>
                                                            @if($item->product->product_type == 'support')
                                                                {{__('order::dashboard.orders.datatable.account_id')}} : {{$item->account_id}}
                                                                <br>
                                                                @if($item->server)
                                                                    {{__('order::dashboard.orders.datatable.selected_server')}} : {{$item->server?->title}}
                                                                    <br>
                                                                @endif
                                                            @else
                                                                @foreach($order->orderItems()->where('product_id',$item->product_id)->get() as $itemCode)
                                                                    @if(in_array($order->order_status_id,[1,5]))
                                                                        {{__('order::dashboard.orders.datatable.code')}}: {{$itemCode->code}} <br>
                                                                    @endif
                                                                @endforeach
                                                            @endif
                                                        </td>
                                                        <td class="text-center sbold">
                                                            {{ $qty }}
                                                        </td>
                                                        <td class="text-center sbold">
                                                            {{ number_format($oldPrice[0],3) }} {{$order->country->currency->code}}
                                                        </td>
                                                        <td class="text-center sbold">
                                                            {{ number_format(($qty * $oldPrice[0]) ,3) }} {{$order->country->currency->code}}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                <tr>
                                                    <td colspan="4"><b>Payment Method </b>(طريقة الدفع)</td>
                                                    <td colspan="2"><b>{{$method ?  __('order::dashboard.order_statuses.payments.'.$method) : '' }}</b></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4"><b>Discount </b>(كوبون الخصم)</td>
                                                    <td colspan="2"><b>{{number_format($order->discount + $allDiff,3)}} {{$order->country->currency->code}}</b></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4"><b>VAT </b>(قيمة الضريبة المضافة)</td>
                                                    <td colspan="2"><b>{{ number_format(0,3) }} {{ $order->country?->currency?->code ?? '' }}</b></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4"><b>Total </b>(اجمالي الطلب)</td>
                                                    <td colspan="2"><b>{{ number_format($order->total,3) }} {{ $order->country?->currency?->code ?? '' }}</b></td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    @if($order->country_id == 195)
                                        <div class="row mt-25">
                                            <div class="col-xs-12">
                                                {!! $order->qr !!}
                                                <h5 style="line-height: 1.8">
                                                    <b>
                                                        The QR code is encoded as per ZATCA e-invoicing requirements.<br>
                                                        رمز الاستجابة السريعة مشفر بحسب متطلبات هيئة الزكاة والضريبة والجمارك للفوترة الالكترونية.
                                                    </b>
                                                </h5>
                                            </div>
                                        </div>
                                    @endif

                                    @if($transactionDetails)
                                        <div class="row">
                                            <h3>Transaction Details</h3>
                                            <div class="col-md-12">
                                                @foreach($transactionDetails as $key => $value)
                                                    @if(is_array($value))
                                                        @foreach($value as $key2 => $value2)
                                                            @if($value2)
                                                                <code>{{$key2 . ' : ' . $value2}}</code> <br>
                                                            @endif
                                                        @endforeach
                                                    @else
                                                        @if($value)
                                                            <code>{{$key . ' : ' . $value}}</code> <br>
                                                        @endif
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class=" text-left mt-25">
                                <a class="btn btn-lg blue hidden-print margin-bottom-5 printBtn" onclick="javascript:window.print();">
                                    {{__('apps::dashboard.buttons.print')}}
                                    <i class="fa fa-print"></i>
                                </a>
                                <div class="clearfix"></div>
                            </div>
                        </div>

                        <div class="tab-pane" id="update">
                            <form id="updateForm" role="form" class="form-horizontal form-row-seperated" method="post" enctype="multipart/form-data" action="{{ route('dashboard.orders.update',$order['id']) }}">
                                @csrf
                                @method('PUT')
                                @if(auth()->user()->hasRole('super-admin'))
                                <div class="form-group">
                                    <label class="col-md-2">
                                        {{__('order::dashboard.orders.show.status')}}
                                        <span class="required" aria-required="true">*</span>
                                    </label>
                                    <div class="col-md-9">
                                        <select name="status_id" id="single" class="form-control select2" data-name="status_id">
                                            <option value=""></option>
                                            @foreach ($statuses as $status)
                                                <option value="{{ $status['id'] }}" {{ $order->order_status_id == $status->id ? 'selected' : '' }}>
                                                    {{ $status->title }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="help-block"></div>
                                    </div>
                                </div>
                                @endif

                                @if($order->order_status_id == 5)
                                <div class="form-group">
                                    @php
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
                                    @endphp
                                    <label class="col-md-2">
                                        {{__('order::dashboard.orders.show.support_status')}}
                                        <span class="required" aria-required="true">*</span>
                                    </label>
                                    <div class="col-md-9">
                                        <select name="support_status_id" id="single" class="form-control select2" data-name="support_status_id">
                                            <option value=""></option>
                                            @foreach ($supportStatuses as $supportStatus)
                                                <option value="{{ $supportStatus['id'] }}" {{ $order->support_status_id == $supportStatus['id'] ? 'selected' : '' }}>
                                                    {{ $supportStatus['title'] }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="help-block"></div>
                                    </div>
                                </div>
                                @endif

                                <div class="col-md-12">
                                    <div class="form-actions">
                                        @include('apps::dashboard.layouts._ajax-msg')
                                        <div class="form-group">
                                            <button type="submit" id="submit" class="btn btn-lg green">
                                                {{__('apps::dashboard.buttons.edit')}}
                                            </button>
                                            <a href="{{url(route('dashboard.orders.index')) }}" class="btn btn-lg red">
                                                {{__('apps::dashboard.buttons.back')}}
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
                                                                {{__('order::dashboard.orders.show.order.total')}}
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
                                                                    @if($history->method == 'wallet')
                                                                        @php $wallet = $order->user->getCountryWallet($order); @endphp
                                                                        {{  __('order::dashboard.orders.datatable.wallet_no') }} {{$wallet->id}}
                                                                    @else
                                                                        {{$history->tran_id}}
                                                                    @endif
                                                                </td>
                                                                <td class="text-center sbold">
                                                                    {{ number_format($history->recharge_balance ?? $history->order->total,3) . ' ' . $order->country->currency->code }}
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
                            </form>

                        </div>
                    </div>
                </div>
            </div>
{{--            <div class="row">--}}
{{--                <div class="col-xs-4">--}}
{{--                    <a class="btn btn-lg blue hidden-print margin-bottom-5" onclick="javascript:window.print();">--}}
{{--                        {{__('apps::dashboard.buttons.print')}}--}}
{{--                        <i class="fa fa-print"></i>--}}
{{--                    </a>--}}
{{--                </div>--}}
{{--            </div>--}}
        </div>
    </div>
</div>

@stop

@section('scripts')

<script>
    $('.24_format').timepicker({
        showMeridian: true,
        format: 'hh:mm',
    });

    $('.datepicker').datepicker({
        format: 'yyyy-mm-dd',
        startDate: '0d'
    });

    let item_code = '{{request()->item_code}}';
    if(item_code != ''){
        $('[data-item="'+item_code+'"]').trigger('click')
    }
</script>

@stop
