@extends('apps::dashboard.layouts.app')
@section('title', __('user::dashboard.users.update.title'))
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
                    <a href="{{ url(route('dashboard.users.index')) }}">
                        {{__('user::dashboard.users.index.title')}}
                    </a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <a href="#">{{__('user::dashboard.users.update.title')}}</a>
                </li>
            </ul>
        </div>

        <h1 class="page-title"></h1>

        <div class="row">
                 {!! Form::model($model,[
                                    'url'=> route('dashboard.users.update',$model->id),
                                    'id'=>'updateForm',
                                    'role'=>'form',
                                    'method'=>'PUT',

                                    'class'=>'form-horizontal form-row-seperated',
                                    'files' => true
                                    ])!!}


                <div class="col-md-12">

                    {{-- RIGHT SIDE --}}
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
                                                    {{ __('user::dashboard.users.update.form.general') }}
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#orders"
                                                   data-toggle="tab">
                                                    {{__('order::dashboard.orders.index.title')}}
                                                </a>
                                            </li>
{{--                                            <li>--}}
{{--                                                <a href="#transactions"--}}
{{--                                                   data-toggle="tab">--}}
{{--                                                    {{__('transaction::dashboard.transactions.index.title')}}--}}
{{--                                                </a>--}}
{{--                                            </li>--}}
                                            <li>
                                                <a href="#wallets"
                                                   data-toggle="tab">
                                                    {{ __('user::dashboard.users.update.form.wallets') }}
                                                </a>
                                            </li>
{{--                                            <li>--}}
{{--                                                <a href="#wallets_transactions"--}}
{{--                                                   data-toggle="tab">--}}
{{--                                                    {{ __('user::dashboard.users.update.form.wallets_transactions') }}--}}
{{--                                                </a>--}}
{{--                                            </li>--}}
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- PAGE CONTENT --}}
                    <div class="col-md-9">
                        <div class="tab-content">

                            {{-- UPDATE FORM --}}
                            <div class="tab-pane active fade in"
                                id="global_setting">
                                <div class="col-md-10">
                                    @include('user::dashboard.users.form.form')
                                </div>
                            </div>
                            {{-- END UPDATE FORM --}}
                            <div class="tab-pane" id="orders">
                                <div class="col-md-12">
                                    @include('user::dashboard.users.form.orders')
                                </div>
                            </div>
{{--                            <div class="tab-pane" id="transactions">--}}
{{--                                <div class="col-md-12">--}}
{{--                                    @include('user::dashboard.users.form.transactions')--}}
{{--                                </div>--}}
{{--                            </div>--}}
                            <div class="tab-pane" id="wallets">
                                <div class="col-md-12">
                                    @include('user::dashboard.users.form.wallets')
                                </div>
                            </div>
{{--                            <div class="tab-pane" id="wallets_transactions">--}}
{{--                                <div class="col-md-12">--}}
{{--                                    @include('user::dashboard.users.form.wallets_transactions')--}}
{{--                                </div>--}}
{{--                            </div>--}}
                        </div>
                    </div>

                    {{-- PAGE ACTION --}}
                    <div class="col-md-12">
                        <div class="form-actions">
                            @include('apps::dashboard.layouts._ajax-msg')
                            <div class="form-group">
                                <button type="submit"
                                    id="submit"
                                    class="btn btn-lg green">
                                    {{__('apps::dashboard.buttons.edit')}}
                                </button>
                                <a href="{{url(route('dashboard.users.index')) }}"
                                    class="btn btn-lg red">
                                    {{__('apps::dashboard.buttons.back')}}
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>
@stop

@push('start_scripts')
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
                    url: "{{route('dashboard.users.addWalletBalance')}}",
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
@endpush
