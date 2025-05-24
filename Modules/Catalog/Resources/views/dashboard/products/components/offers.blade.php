<div class="tab-pane fade in" id="offers">
    <div>
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
                        @php
                            $offer = $model && $model->id ? $model->offers()->whereCountryId($country->id)->active()->first() : null;
                        @endphp
                        <div class="form-group">
                            <label class="col-md-2">
                                {{ __('catalog::dashboard.products.form.price_in_country',['country' => $country->title]) }}
                            </label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" value="{{$model && $model->id ? (json_decode($model->prices,true)[$country->id] ?? 0) : ''}}" data-size="small" name="prices[{{$country->id}}]">
                                <div class="help-block"></div>
                            </div>
                        </div>

                        <div class="form-group selections">
                            <span class="offerAmountSection" style="display: {{$offer && $offer?->percentage ? 'none' : ''}}">
                                <label class="col-md-2 col-xs-12">
                                    {{__('catalog::dashboard.products.form.offer_price')}}
                                </label>
                                <div class="col-md-7">
                                    <input type="number" step="0.1" min="0" id="offer-form"
                                           name="offers[{{$country->id}}][price]" class="form-control"
                                           data-name="offer_price" value="{{$offer?->price}}">
                                    <div class="help-block"></div>
                                </div>
                            </span>

                            <span class="offerPercentageSection" style="display: {{($offer && $offer?->price) || !$model->id || ($model->id && !$offer) ? 'none' : '' }}">
                                <label class="col-md-2 col-xs-12">
                                    {{__('catalog::dashboard.products.form.percentage')}}
                                </label>
                                <div class="col-md-7">
                                    <input type="number" step="0.5" min="0" id="offer-percentage-form"
                                           name="offers[{{$country->id}}][percentage]" class="form-control"
                                           data-name="offer_percentage" value="{{$offer?->percentage}}">
                                    <div class="help-block"></div>
                                </div>
                            </span>

                            <select class="form-control input-small inline-selector offer_type" style="padding:0px 0px" name="offers[{{$country->id}}][type]">
                                <option value="amount" {{$offer?->price ? 'selected' : ''}}>
                                    {{ __('catalog::dashboard.products.form.offer_type.amount') }}
                                </option>
                                <option value="percentage" {{$offer?->percentage ? 'selected' : ''}}>
                                    {{ __('catalog::dashboard.products.form.offer_type.percentage') }}
                                </option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2">
                                {{__('catalog::dashboard.products.form.offer_dates')}}
                            </label>
                            <div style="margin: 0 15px" class="col-md-9 btn default offerDateRange">
                                <i class="fa fa-calendar"></i> &nbsp;
                                <span class="date_selected"> {{$offer ? $offer->start_at . ' - ' . $offer->end_at : ''}} </span>
                                <b class="fa fa-angle-down"></b>
                                <input type="hidden" value="{{$offer ? $offer->start_at : ''}}" class="start_at" name="offers[{{$country->id}}][start_at]">
                                <input type="hidden" value="{{$offer ? $offer->end_at : ''}}" class="end_at" name="offers[{{$country->id}}][end_at]">
                                <div class="help-block"></div>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
        <hr>
    </div>
</div>

@section('include_scripts')
    <script>
        $(function (){
            let start = NaN, end = NaN;

            $('.offerDateRange').daterangepicker({
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

                    $(this)[0].element.find('span.date_selected').html('{{__('apps::dashboard.buttons.all')}}');
                    $(this)[0].element.find('.start_at').val('');
                    $(this)[0].element.find('.end_at').val('');

                } else if (start.isValid() && end.isValid()) {
                    $(this)[0].element.find('span.date_selected').html(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
                    $(this)[0].element.find('.start_at').val(start.format('YYYY-MM-DD'));
                    $(this)[0].element.find('.end_at').val(end.format('YYYY-MM-DD'));
                }
            });

            $('.offer_type').on('change',function (){
                if ($(this).val() === 'amount') {
                    $(this).parents('.selections').find('.offerAmountSection').show();
                    $(this).parents('.selections').find('.offerPercentageSection').hide();
                } else if ($(this).val() === 'percentage') {
                    $(this).parents('.selections').find('.offerPercentageSection').show();
                    $(this).parents('.selections').find('.offerAmountSection').hide();
                }
            })
        });
    </script>
@endsection
