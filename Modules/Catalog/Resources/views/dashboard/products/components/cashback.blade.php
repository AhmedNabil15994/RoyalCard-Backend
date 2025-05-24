<div class="tab-pane fade in" id="cashback">
    <div class="tabbable" style="margin-bottom: 15px;">
        <ul class="nav nav-tabs bg-slate nav-tabs-component">
            @foreach($countries as $country)
                @if(in_array($country->id,setting('supported_countries')))
                    <li class=" {{ $country->id == setting('default_country') ? 'active' : '' }}">
                        <a href="#colored-rounded-tab-cashback-{{$country->id}}" data-toggle="tab" aria-expanded="false"> {{ $country->title }}
                        </a>
                    </li>
                @endif
            @endforeach
        </ul>
    </div>
    @php
        $cashback_rate =  $model->id ? ($model->cashback_rates ?? [])   : [];
    @endphp
    <div class="tab-content">
        @foreach($countries as $country)
            @if(in_array($country->id,setting('supported_countries')))
                <div class="countryOffer tab-pane @if ($country->id == setting('default_country')) active @endif" id="colored-rounded-tab-cashback-{{ $country->id }}">
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
                                               onclick="toggleCouponType('value',this)" {{!$model->id ? 'checked':
                                                (isset($cashback_rate['discount_type'][$country->id]) && $cashback_rate['discount_type'][$country->id] == 'value' ? 'checked' : '')
                                            }}>
                                        <div class="help-block"></div>
                                        <span></span>
                                    </label>
                                    <label class="mt-radio mt-radio-outline">
                                        {{__('coupon::dashboard.coupons.form.percentage')}}
                                        <input type="radio" name="discount_type[{{$country->id}}]" value="percentage" onclick="toggleCouponType('percentage',this)"
                                            {{$model->id && isset($cashback_rate['discount_type'][$country->id]) && $cashback_rate['discount_type'][$country->id] == 'percentage' ? 'checked' : ''}}>
                                        <span></span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group discount_type value" style="display: {{$model->id ? (isset($cashback_rate['discount_type'][$country->id]) && $cashback_rate['discount_type'][$country->id] == 'value' ? '' : 'none') : ''}}">
                            <label class="col-md-2">
                                {{__('coupon::dashboard.coupons.form.discount_value')}}
                            </label>
                            <div class="col-md-9">
                                <input type="number" name="discount_value[{{$country->id}}]" class="form-control"
                                       data-name="discount_value" value="{{$model->id && isset($cashback_rate['discount_value'][$country->id]) ? $cashback_rate['discount_value'][$country->id] : ''}}">
                                <div class="help-block"></div>
                            </div>
                        </div>

                        <div class="form-group discount_type percentage" style="display: {{!$model->id ? 'none':
                                                (isset($cashback_rate['discount_type'][$country->id]) && $cashback_rate['discount_type'][$country->id] == 'value' ? 'none' : '')}}">
                            <label class="col-md-2">
                                {{__('coupon::dashboard.coupons.form.discount_percentage')}} %
                            </label>
                            <div class="col-md-9">
                                <input type="number" min="0" max="100" name="discount_percentage[{{$country->id}}]"
                                       class="form-control" data-name="discount_percentage" value="{{$model->id && isset($cashback_rate['discount_percentage'][$country->id]) ? $cashback_rate['discount_percentage'][$country->id] : ''}}">
                                <div class="help-block"></div>
                            </div>
                        </div>

                        {{--                    <div class="form-group">--}}
                        {{--                        <label class="col-md-2">--}}
                        {{--                            {{__('coupon::dashboard.coupons.form.add_dates')}}--}}
                        {{--                        </label>--}}
                        {{--                        <div class="col-md-9">--}}
                        {{--                            <input type="checkbox" class="make-switch" data-size="small" onchange="toggleDate(this)"--}}
                        {{--                                   name="add_dates[{{$country->id}}]" {{$model->id ?(isset($model->start_at_dates[$country->id]) &&  isset($model->expired_at_dates[$country->id]) ? 'checked' : '') : ''  }}>--}}
                        {{--                            <div class="help-block"></div>--}}
                        {{--                        </div>--}}
                        {{--                    </div>--}}


                        {{--                    <div class="dates_container" style="display: {{$model->id ? (isset($model->start_at_dates[$country->id]) &&  $model->start_at_dates[$country->id] ? '' : 'none') : 'none'}};">--}}
                        {{--                        <div class="form-group">--}}
                        {{--                            <label class="col-md-2">--}}
                        {{--                                {{__('coupon::dashboard.coupons.form.start_at')}}--}}
                        {{--                            </label>--}}
                        {{--                            <div class="col-md-9">--}}
                        {{--                                <div class="input-group input-medium date time date-picker"--}}
                        {{--                                     data-date-format="yyyy-mm-dd" data-date-start-date="+0d">--}}
                        {{--                                    <input type="text" id="offer-form" class="form-control"--}}
                        {{--                                           name="start_at[{{$country->id}}]" data-name="start_at" value="{{$model->id && isset($model->start_at_dates[$country->id]) ? $model->start_at_dates[$country->id]: ''}}">--}}
                        {{--                                    <span class="input-group-btn">--}}
                        {{--                                        <button class="btn default" type="button">--}}
                        {{--                                            <i class="fa fa-calendar"></i>--}}
                        {{--                                        </button>--}}
                        {{--                                    </span>--}}
                        {{--                                </div>--}}
                        {{--                                <div class="help-block" style="color: #e73d4a"></div>--}}
                        {{--                            </div>--}}
                        {{--                        </div>--}}
                        {{--                        <div class="form-group">--}}
                        {{--                            <label class="col-md-2">--}}
                        {{--                                {{__('coupon::dashboard.coupons.form.expired_at')}}--}}
                        {{--                            </label>--}}
                        {{--                            <div class="col-md-9">--}}
                        {{--                                <div class="input-group input-medium date time date-picker"--}}
                        {{--                                     data-date-format="yyyy-mm-dd" data-date-start-date="+0d">--}}
                        {{--                                    <input type="text" id="offer-form" class="form-control"--}}
                        {{--                                           name="expired_at[{{$country->id}}]" data-name="expired_at" value="{{$model->id && isset($model->expired_at_dates[$country->id]) ? $model->expired_at_dates[$country->id]: ''}}">--}}
                        {{--                                    <span class="input-group-btn">--}}
                        {{--                                        <button class="btn default" type="button">--}}
                        {{--                                            <i class="fa fa-calendar"></i>--}}
                        {{--                                        </button>--}}
                        {{--                                    </span>--}}
                        {{--                                </div>--}}
                        {{--                                <div class="help-block" style="color: #e73d4a"></div>--}}
                        {{--                            </div>--}}
                        {{--                        </div>--}}
                        {{--                    </div>--}}
                    </div>
                </div>
            @endif
        @endforeach

    </div>

</div>
@section('start_scripts')
    <script>



    </script>
@endsection
