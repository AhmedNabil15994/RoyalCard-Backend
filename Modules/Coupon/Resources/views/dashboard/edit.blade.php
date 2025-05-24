@extends('apps::dashboard.layouts.app')
@section('title', __('coupon::dashboard.coupons.routes.update'))
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
                        <a href="{{ url(route('dashboard.coupons.index')) }}">
                            {{__('coupon::dashboard.coupons.routes.index')}}
                        </a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <a href="#">{{__('coupon::dashboard.coupons.routes.update')}}</a>
                    </li>
                </ul>
            </div>

            <h1 class="page-title"></h1>

            <div class="row">
                <form id="updateForm" page="form" class="form-horizontal form-row-seperated" method="post"
                      enctype="multipart/form-data" action="{{route('dashboard.coupons.update',$coupon->id)}}">
                    @csrf
                    @method('PUT')
                    <div class="col-md-12">

                        {{-- RIGHT SIDE --}}
                        <div class="col-md-3">
                            <div class="panel-group accordion scrollable" id="accordion2">
                                <div class="panel panel-default">

                                    <div id="collapse_2_1" class="panel-collapse in">
                                        <div class="panel-body">
                                            <ul class="nav nav-pills nav-stacked">
                                                <li class="active">
                                                    <a href="#global_setting" data-toggle="tab">
                                                        {{ __('coupon::dashboard.coupons.form.tabs.general') }}
                                                    </a>
                                                </li>

                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- PAGE CONTENT --}}
                        <div class="col-md-9">
                            <div class="tab-content">

                                {{-- CREATE FORM --}}

                                <div class="tab-pane active fade in" id="global_setting">
                                    <div class="col-md-10">
                                        <div class="form-group">
                                            <label class="col-md-2">
                                                {{__('coupon::dashboard.coupons.form.title')}}
                                            </label>
                                            <div class="col-md-9">
                                                <input type="text" name="title"
                                                       class="form-control" data-name="title"
                                                       value="{{$coupon->title}}">
                                                <div class="help-block"></div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-2">
                                                {{__('coupon::dashboard.coupons.form.code')}}
                                            </label>
                                            <div class="col-md-9">
                                                <input type="text" name="code" value="{{$coupon->code}}"
                                                       class="form-control" data-name="code">
                                                <div class="help-block"></div>
                                            </div>
                                        </div>
                                        @inject('products','Modules\Catalog\Entities\Product')
                                        <input type="hidden" name="coupon_flag" value="products">
                                        <div class="form-group">
                                            <label class="col-md-2">
                                                {{__('coupon::dashboard.coupons.form.products')}}
                                            </label>
                                            <div class="col-md-9">
                                                <select name="product_id[]" class="form-control select2" multiple>
                                                    <option value=""></option>
                                                    @foreach($products->active()->get() as $product)
                                                        <option value="{{$product->id}}" {{$coupon->products->contains($product->id) ? 'selected' : ''}}>{{$product->title}}</option>
                                                    @endforeach
                                                </select>
                                                <div class="help-block"></div>
                                            </div>
                                        </div>
                                        <div class="tabbable" style="margin-bottom: 15px;">
                                            <ul class="nav nav-tabs bg-slate nav-tabs-component">
                                                @foreach($countries as $country)
                                                    @if(in_array($country->id,setting('supported_countries')))
                                                        <li class=" {{ $country->id == setting('default_country') ? 'active' : '' }}">
                                                            <a href="#colored-rounded-tab-general-{{$country->id}}" data-toggle="tab" aria-expanded="false"> {{ $country->title }}
                                                            </a>
                                                        </li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                        </div>

                                        <div class="tab-content">
                                            @foreach($countries as $country)
                                                @if(in_array($country->id,setting('supported_countries')))
                                                    <div class="countryOffer tab-pane @if ($country->id == setting('default_country')) active @endif" id="colored-rounded-tab-general-{{ $country->id }}">
                                                        <div class="form-group selections" style="margin: 0">
                                                            <div class="form-group">
                                                                <label class="col-md-2">
                                                                    {{__('coupon::dashboard.coupons.form.discount_type')}}
                                                                </label>
                                                                <div class="col-md-9">
                                                                    <div class="mt-radio-inline" style="padding: 0">
                                                                        <label class="mt-radio mt-radio-outline">
                                                                            {{__('coupon::dashboard.coupons.form.value')}}
                                                                            <input type="radio" name="discount_type[{{$country->id}}]" value="value"
                                                                                   onclick="toggleCouponType('value',this)"
                                                                                {{count($coupon->types) && isset($coupon->types[$country->id]) && $coupon->types[$country->id]  == 'value' ? 'checked' : '' }}>
                                                                            <div class="help-block"></div>
                                                                            <span></span>
                                                                        </label>
                                                                        <label class="mt-radio mt-radio-outline">
                                                                            {{__('coupon::dashboard.coupons.form.percentage')}}
                                                                            <input type="radio" name="discount_type[{{$country->id}}]" value="percentage" onclick="toggleCouponType('percentage',this)"
                                                                                {{count($coupon->types) && isset($coupon->types[$country->id]) && $coupon->types[$country->id]  == 'percentage' ? 'checked' : '' }}>
                                                                            <span></span>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="form-group discount_type value" style="display: {{count($coupon->types) && isset($coupon->types[$country->id]) && $coupon->types[$country->id]  == 'value' ? '' : 'none' }}">
                                                                <label class="col-md-2">
                                                                    {{__('coupon::dashboard.coupons.form.discount_value')}}
                                                                </label>
                                                                <div class="col-md-9">
                                                                    <input type="number" name="discount_value[{{$country->id}}]" value="{{$coupon->values[$country->id] ?? ''}}" class="form-control"
                                                                           data-name="discount_value">
                                                                    <div class="help-block"></div>
                                                                </div>
                                                            </div>

                                                            <div class="form-group discount_type percentage" style="display: {{count($coupon->types) && isset($coupon->types[$country->id]) && $coupon->types[$country->id]  == 'percentage' ? '' : 'none' }}">
                                                                <label class="col-md-2">
                                                                    {{__('coupon::dashboard.coupons.form.discount_percentage')}} %
                                                                </label>
                                                                <div class="col-md-9">
                                                                    <input type="number" min="0" max="100" name="discount_percentage[{{$country->id}}]" value="{{$coupon->percentages[$country->id] ?? ''}}"
                                                                           class="form-control" data-name="discount_percentage">
                                                                    <div class="help-block"></div>
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label class="col-md-2">
                                                                    {{__('coupon::dashboard.coupons.form.add_dates')}}
                                                                </label>
                                                                <div class="col-md-9">
                                                                    <input type="checkbox" class="make-switch" data-size="small"
                                                                           name="add_dates[{{$country->id}}]" {{ isset( $coupon->start_at_dates[$country->id]) && isset($coupon->expired_at_dates[$country->id]) ? 'checked' : ''  }}>
                                                                    <div class="help-block"></div>
                                                                </div>
                                                            </div>

                                                            <div class="dates_container" style="display: {{ isset( $coupon->start_at_dates[$country->id]) && isset($coupon->expired_at_dates[$country->id])  ? '' : 'none'}};">
                                                                <div class="form-group">
                                                                    <label class="col-md-2">
                                                                        {{__('coupon::dashboard.coupons.form.start_at')}}
                                                                    </label>
                                                                    <div class="col-md-9">
                                                                        <div class="input-group input-medium date time date-picker"
                                                                             data-date-format="yyyy-mm-dd" data-date-start-date="+0d">
                                                                            <input type="text" id="offer-form" class="form-control"
                                                                                   name="start_at[{{$country->id}}]" data-name="start_at" value="{{$coupon->start_at_dates[$country->id] ?? ''}}">
                                                                            <span class="input-group-btn">
                                                                                <button class="btn default" type="button">
                                                                                    <i class="fa fa-calendar"></i>
                                                                                </button>
                                                                            </span>
                                                                        </div>
                                                                        <div class="help-block" style="color: #e73d4a"></div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="col-md-2">
                                                                        {{__('coupon::dashboard.coupons.form.expired_at')}}
                                                                    </label>
                                                                    <div class="col-md-9">
                                                                        <div class="input-group input-medium date time date-picker"
                                                                             data-date-format="yyyy-mm-dd" data-date-start-date="+0d">
                                                                            <input type="text" id="offer-form" class="form-control"
                                                                                   name="expired_at[{{$country->id}}]" data-name="expired_at" value="{{$coupon->expired_at_dates[$country->id] ?? ''}}">
                                                                            <span class="input-group-btn">
                                                                                <button class="btn default" type="button">
                                                                                    <i class="fa fa-calendar"></i>
                                                                                </button>
                                                                            </span>
                                                                        </div>
                                                                        <div class="help-block" style="color: #e73d4a"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach

                                        </div>
                                        <hr style="margin-top: 0;">

                                        <div class="form-group">
                                            <label class="col-md-2">
                                                {{__('coupon::dashboard.coupons.form.status')}}
                                            </label>
                                            <div class="col-md-9">
                                                <input type="checkbox" class="make-switch" id="test" data-size="small"
                                                       name="status" {{($coupon->status == 1) ? ' checked="" ' : ''}}>
                                                <div class="help-block"></div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                {{-- END CREATE FORM --}}
                            </div>
                        </div>

                        {{-- PAGE ACTION --}}
                        <div class="col-md-12">
                            <div class="form-actions">
                                @include('apps::dashboard.layouts._ajax-msg')
                                <div class="form-group">
                                    <button type="submit" id="submit" class="btn btn-lg green">
                                        {{__('apps::dashboard.buttons.edit')}}
                                    </button>

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

    <script>
        function toggleCouponFlag(flag) {
            switch (flag) {

                case 'categories':
                    $('#categoriesSection').show();
                    $('#productsSection').hide();
                    break;

                case 'products':
                    $('#categoriesSection').hide();
                    $('#productsSection').show();
                    break;

                case '':
                    $('#categoriesSection').hide();
                    $('#productsSection').hide();
                    break;

                default:
                    break;
            }
        }

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
    </script>

@endsection
