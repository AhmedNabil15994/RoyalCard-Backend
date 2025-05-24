@extends('apps::dashboard.layouts.app')
@section('title', __('order::dashboard.orders.show.title'))
@section('css')
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
                        </ul>
                    </div>
                </div>
                <div class="col-md-9 contentPrint">
                    <div class="tab-content">

                        <div class="tab-pane active" id="order">
                            <div class="invoice-content-2 bordered">

                                <div class="col-md-12" style="margin-bottom: 24px;">
                                    @php
                                        $details = $transaction->getDetails();
                                        $method = $transaction->method;
                                        $user = $transaction?->transaction?->user;
                                        $country = $transaction?->transaction?->country;
                                        $currency = $transaction?->transaction?->country?->currency;

                                        $title = $details['title'];
                                        $type = $details['type'];
                                        $description = $details['description'];
                                    @endphp
                                    <center>
                                        <img src="{{setting('logo') ? asset(setting('logo')) : asset('frontend/assets/images/mlogo-dark.png') }}" class="img-responsive" style="margin-bottom: 25px;width:18%" />
                                        <b>{{ $title}}</b> <br>
                                        <b>
                                            #{{ $transaction->id  }} -
                                            {{ date('Y-m-d / H:i:s' , strtotime($transaction->created_at)) }}
                                        </b>
                                    </center>
                                    @if($method)
                                    <center>
                                        <b>{{ $method }}</b>
                                    </center>
                                    @endif
                                    <center>
                                        <b>{{__('order::dashboard.orders.show.order.tax_certificate')}}: 312098037100003</b>
                                    </center>
                                </div>

                                @if ($user)
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
                                                        <td class="text-center sbold"> {{ $user->name }}</td>
                                                        <td class="text-center sbold"> {{ $user->email }}</td>
                                                        <td class="text-center sbold"> {{ $user->mobile }}</td>
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
                                                        {{__('order::dashboard.orders.datatable.description')}}
                                                    </th>
                                                    <th class="invoice-title uppercase text-center">
                                                        {{__('order::dashboard.orders.show.order.course_price')}}
                                                    </th>
                                                    @if($transaction->transaction_type == 'Modules\Order\Entities\Order')
                                                    <th class="invoice-title uppercase text-center hidden-print">
                                                        {{__('order::dashboard.orders.datatable.order')}}
                                                    </th>
                                                    @else
                                                    <th class="invoice-title uppercase text-center hidden-print">
                                                        {{__('order::dashboard.orders.datatable.wallet')}}
                                                    </th>
                                                    @endif
                                                    <th class="invoice-title uppercase text-center hidden-print">
                                                        {{__('order::dashboard.orders.datatable.country')}}
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $allDiff = 0;
                                                    $subTotal = 0;
                                                @endphp
                                                <tr>
                                                    <td class="text-center sbold">
                                                        {{$description}}
                                                    </td>
                                                    <td class="text-center sbold">
                                                        {{ number_format($transaction->recharge_balance,3) }}
                                                    </td>
                                                    @if($transaction->transaction_type == 'Modules\Order\Entities\Order')
                                                    <td class="text-center sbold">
                                                        <a href="{{route('dashboard.orders.show',['id'=>$transaction->transaction_id])}}" target="_blank">
                                                            {{  __('order::dashboard.orders.show.order_id') }} {{$transaction->transaction_id}}
                                                        </a>
                                                    </td>
                                                    @else
                                                    <td class="text-center sbold">
                                                        <a href="{{route('dashboard.users.show',['user'=>$transaction->wallet?->user_id])}}#wallets" target="_blank">
                                                            {{  __('order::dashboard.orders.datatable.wallet_no') }} {{$transaction->transaction_id}}
                                                        </a>
                                                    </td>
                                                    @endif
                                                    <td class="text-center sbold">
                                                        {{$country->title}}
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
                                                        {{__('order::dashboard.orders.show.order.subtotal')}}
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
                                                        {{ number_format($transaction->recharge_balance,3) }} {{ $currency->code }}
                                                    </td>
                                                    <td class="text-center sbold">
                                                        {{ number_format(0,3) }} {{ $currency->code }}
                                                    </td>
                                                    <td class="text-center sbold">
                                                        {{ number_format($transaction->recharge_balance,3) }} {{ $currency->code }}
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

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
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-4">
                    <a class="btn btn-lg blue hidden-print margin-bottom-5" onclick="javascript:window.print();">
                        {{__('apps::dashboard.buttons.print')}}
                        <i class="fa fa-print"></i>
                    </a>
                </div>
            </div>
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
