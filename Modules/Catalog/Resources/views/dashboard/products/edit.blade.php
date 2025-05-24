@extends('apps::dashboard.layouts.app')
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
@section('title', __('catalog::dashboard.products.routes.update'))
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
                        <a href="#">{{ __('catalog::dashboard.products.routes.update') }}</a>
                    </li>
                </ul>
            </div>

            <h1 class="page-title"></h1>
            <div class="row">
                <form id="updateForm" page="form" class="form-horizontal form-row-seperated" method="post"
                    enctype="multipart/form-data" action="{{ route('dashboard.products.update', $model->id) }}">
                    @csrf
                    @method('PUT')
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

{{--                        <div class="col-md-3 attrs {{$model->product_type == 'digital' ? 'hidden' : ''}}">--}}
{{--                            @include('catalog::dashboard.products.components.physical_attributes')--}}
{{--                        </div>--}}

                        {{-- PAGE ACTION --}}
                        <div class="col-md-12">
                            <div class="form-actions">
                                @include('apps::dashboard.layouts._ajax-msg')
                                <div class="form-group">
                                    <button type="submit" id="submit" class="btn btn-lg green">
                                        {{ __('apps::dashboard.buttons.edit') }}
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
                // "plugins" : [ "wholerow", "checkbox" ],
                core: {
                    multiple: true
                },
                // checkbox : {
                //     "three_state" : false
                // }
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



        });
    </script>

@endsection
