<div class="tab-pane fade" id="wallet">
    <h3 class="page-title">{{ __('setting::dashboard.settings.form.tabs.wallet') }}</h3>
    @php
        $supportedCountries = setting('supported_countries');
        sort($supportedCountries, SORT_NATURAL | SORT_FLAG_CASE);
    @endphp
    <div class="col-md-10">
        @foreach($supportedCountries as $supportedCountryId)
            @php
                $country = \Modules\Area\Entities\Country::find($supportedCountryId);
            @endphp
            <h3>{{$country->title}}</h3>
            <div class="form-group">
                <label class="col-md-2">
                    {{ __('setting::dashboard.settings.form.recharge_max_balance') }}
                </label>
                <div class="col-md-9 disParent">
                    <input type="text" class="form-control" name="recharge_max_balance[{{$country?->id}}]" value="{{setting('recharge_max_balance')[$country?->id] ?? ''}}" autocomplete="off" />
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2">
                    {{ __('setting::dashboard.settings.form.wallet_max_balance') }}
                </label>
                <div class="col-md-9 disParent">
                    <input type="text" class="form-control" name="wallet_max_balance[{{$country?->id}}]" value="{{setting('wallet_max_balance')[$country?->id] ?? ''}}" autocomplete="off" />
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2">
                    {{ __('setting::dashboard.settings.form.wallet_min_balance') }}
                </label>
                <div class="col-md-9 disParent">
                    <input type="text" class="form-control" name="wallet_min_balance[{{$country?->id}}]" value="{{setting('wallet_min_balance')[$country?->id] ?? ''}}" autocomplete="off" />
                </div>
            </div>
            <hr>
        @endforeach

    </div>
</div>
