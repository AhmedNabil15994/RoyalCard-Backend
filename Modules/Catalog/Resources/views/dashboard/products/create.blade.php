@extends('apps::dashboard.layouts.app')
@section('title', __('catalog::dashboard.products.routes.create'))
@section('css')
    <style>
        textarea{
            min-height: 150px;
            max-height: 200px;
        }
        .mb-30{
            margin-bottom: 30px;
        }
        .notes{
            margin: 10px 0;
            font-weight: bold;
            color: #777;
            border: 0;
            box-shadow: unset;
        }
        .notes .astric{
            color: red;
            margin: 0 5px;
        }
        .disParent{
            width: 78%;
            position: relative;
        }
        .disabled{
            position: absolute;
            @if(locale() == 'ar')
            left: 15px;
            @else
            right: 15px;
            @endif
            top: 0;
            background: #DDD;
            padding: 7px 2px;
            border-radius: 3px;
        }

        @if(locale() == 'ar')
        .daterangepicker .calendar{
            float:right !important;
        }
        @endif
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
                        <a href="{{ url(route('dashboard.products.index')) }}">
                            {{ __('catalog::dashboard.products.routes.index') }}
                        </a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <a href="#">{{ __('catalog::dashboard.products.routes.create') }}</a>
                    </li>
                </ul>
            </div>

            <h1 class="page-title"></h1>

            <div class="row">
                <form id="form" role="form" class="form-horizontal form-row-seperated" method="post"
                    enctype="multipart/form-data" action="{{ route('dashboard.products.store') }}">
                    @csrf
                    <div class="col-md-12">

                        {{-- RIGHT SIDE --}}
                        <div class="col-md-3">
                            @include('catalog::dashboard.products.components.tabs')
                        </div>

                        {{-- PAGE CONTENT --}}
                        <div class="col-md-6">
                            <div class="tab-content">
                                {{-- CREATE FORM --}}
                                @include('catalog::dashboard.products.components.product_types')

                                @include('catalog::dashboard.products.components.global_setting')

                                @include('catalog::dashboard.products.components.categories')

                                @include('catalog::dashboard.products.components.qty_codes')

                                @include('catalog::dashboard.products.components.servers')

                                @include('catalog::dashboard.products.components.offers')

                                @include('catalog::dashboard.products.components.cashback')
                                {{-- END CREATE FORM --}}
                            </div>
                        </div>

{{--                        <div class="col-md-3 attrs hidden">--}}
{{--                            @include('catalog::dashboard.products.components.physical_attributes')--}}
{{--                        </div>--}}

                        {{-- PAGE ACTION --}}
                        <div class="col-md-12">
                            <div class="form-actions">
                                @include('apps::dashboard.layouts._ajax-msg')
                                <div class="form-group">
                                    <button type="submit" id="submit" class="btn btn-lg blue">
                                        {{ __('apps::dashboard.buttons.add') }}
                                    </button>
                                    <a href="{{ url(route('dashboard.products.index')) }}" class="btn btn-lg red">
                                        {{ __('apps::dashboard.buttons.back') }}
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


@section('scripts')
    <style>
        .bootstrap-switch{
            max-height: 32px;
        }
    </style>
    <script type="text/javascript">
        function toggleCouponType(flag,el) {
            $(el).parents('.selections').find('.discount_type').hide();
            $(el).parents('.selections').find('.' + flag).show();
        }

        function toggleDate(el) {
            var checked = $(el).is(':checked');
            if(checked){
                $(el).parents('.form-group').siblings('.dates_container').show();
            }else {
                $(el).parents('.form-group').siblings('.dates_container').hide();
            }
        }
        $(function () {
            $('#jstree').jstree({
                core: {
                    multiple: true
                },
            });

            $('#jstree').on("changed.jstree", function (e, data) {
                $('#root_category').val(data.selected);
            });

            $('input[name="product_type"]').on('change',function (){
                if($(this).val() === 'digital'){
                    $('.support').addClass('hidden');
                    $('.codes').removeClass('hidden');
                }else{
                    $('.support').removeClass('hidden');
                    $('.codes').addClass('hidden');
                }
            });

            let start = NaN, end = NaN;

            $('#offerDateRange').daterangepicker({
                startDate: start,
                endDate: end,
                ranges: {
                },
                @if (is_rtl() == 'rtl')
                opens: 'left',
                @endif
                buttonClasses: ['btn'],
                applyClass: 'btn-primary',
                cancelClass: 'btn-danger',
                format: 'YYYY-MM-DD',
                separator: 'to',
                locale: {
                    applyLabel: '{{__('apps::dashboard.buttons.save')}}',
                    cancelLabel: '{{__('apps::dashboard.buttons.cancel')}}',
                    fromLabel: 'from',
                    toLabel: 'to',
                    customRangeLabel: '{{__('apps::dashboard.buttons.custom')}}',
                    firstDay: 1
                }
            }, function(start = NaN,end = NaN){

                if ((isNaN(start) && isNaN(end)) || (start == null && end == null)) {

                    $('#offerDateRange span').html('{{__('apps::dashboard.buttons.all')}}');
                    $('input[name="start_at"]').val('');
                    $('input[name="end_at"]').val('');

                } else if (start.isValid() && end.isValid()) {

                    $('#offerDateRange span').html(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
                    $('input[name="start_at"]').val(start.format('YYYY-MM-DD'));
                    $('input[name="end_at"]').val(end.format('YYYY-MM-DD'));
                }
            });

            $('[name="offer_type"]').on('change',function (){
                if ($(this).val() === 'amount') {
                    $('#offerAmountSection').show();
                    $('#offerPercentageSection').hide();
                    $('input[name="offer_percentage"]').val('');
                } else if ($(this).val() === 'percentage') {
                    $('#offerPercentageSection').show();
                    $('#offerAmountSection').hide();
                    $('input[name="offer_price"]').val('');
                }
            })

            // $('input[name="product_type"]').on('change',function (){
            //     if($(this).val() === 'physical'){
            //         $('.attrs').removeClass('hidden');
            //         $('.qty').removeClass('hidden');
            //         $('.codes').addClass('hidden');
            //     }else{
            //         $('.attrs').addClass('hidden');
            //         $('.qty').addClass('hidden');
            //         $('.codes').removeClass('hidden');
            //     }
            // });
        });
    </script>

@endsection
