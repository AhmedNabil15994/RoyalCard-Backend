<div class="tab-pane active fade in" id="global_setting">
    <h3 class="page-title">{{ __('setting::dashboard.settings.form.tabs.general') }}</h3>
    <div class="col-md-10">
        <div class="form-group">
            <label class="col-md-2">
              {{ __('setting::dashboard.settings.form.locales') }}
            </label>
            <div class="col-md-9">
                <select name="locales[]" id="single" class="form-control select2" multiple="">
                    @foreach (config('core.available-locales') as $key => $language)
                    <option value="{{ $key }}"
                    @if (in_array($key,array_keys(config('laravellocalization.supportedLocales'))))
                    selected
                    @endif>
                        {{ $language['native'] }}
                    </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2">
                {{ __('setting::dashboard.settings.form.rtl_locales') }}
            </label>
            <div class="col-md-9">
                <select name="rtl_locales[]" id="single" class="form-control select2" multiple="">
                    @foreach (config('core.available-locales') as $key => $language)
                    <option value="{{ $key }}"
                    @if (in_array($key,config('rtl_locales')))
                    selected
                    @endif>
                        {{ $language['native'] }}
                    </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2">
                {{ __('setting::dashboard.settings.form.default_language') }}
            </label>
            <div class="col-md-9">
                <select name="default_locale" id="single" class="form-control select2">
                    @foreach (config('core.available-locales') as $key => $language)
                    <option value="{{ $key }}"
                    @if (config('default_locale') == $key)
                    selected
                    @endif>
                        {{ $language['native'] }}
                    </option>
                    @endforeach
                </select>
            </div>
        </div>
        @php
            $default_country = setting('default_country') ;
        @endphp
        <div class="form-group">
            <label class="col-md-2">
                {{ __('setting::dashboard.settings.form.default_country') }}
            </label>
            <div class="col-md-9">
                <select name="default_country" class="form-control select2">
                    <option> Select Value</option>
                    @foreach ($countries as $code => $country)
                        @if (collect(setting('supported_countries'))->contains($country->id))
                            <option value="{{ $country->id }}" {{$country->id == $default_country ? 'selected' : '' }}>{{ $country->title }}</option>
                        @endif
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2">
                {{ __('setting::dashboard.settings.form.supported_countries') }}
            </label>
            <div class="col-md-9">
                <select name="supported_countries[]" class="form-control select2" multiple="">
                    @foreach ($countries as $code => $country)
                        <option value="{{ $country->id }}"
                            @if (collect(setting('supported_countries'))->contains($country->id))
                                    selected=""@endif>
                            {{ $country->title }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        @php
            $currencies = \Modules\Area\Entities\CurrencyCode::whereIn('country_id', setting('supported_countries'))->get();
        @endphp

        <div class="form-group">
            <label class="col-md-2">
                {{ __('setting::dashboard.settings.form.default_currency') }}
            </label>
            <div class="col-md-9">
                <select name="default_currency" class="form-control select2">
                    @foreach ($currencies as $code => $currency)
                        <option value="{{ $currency->code }}" {{$currency->code == setting('default_currency') ? 'selected' : ''}}>
                            {{ $currency->translate('name','ar') }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-2">
                {{ __('setting::dashboard.settings.form.supported_currencies') }}
            </label>
            <div class="col-md-9">
                <select name="supported_currencies[]" class="form-control select2" multiple="">
                    @foreach ($currencies as $code => $currency)
                        <option value="{{ $currency->code }}"
                                @if (in_array($currency->code,setting('supported_currencies') ?? []))
                                    selected=""
                            @endif>
                            {{ $currency->translate('name','ar') }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        @php
            $supportedCountries = setting('supported_countries');
            sort($supportedCountries, SORT_NATURAL | SORT_FLAG_CASE);
        @endphp
        @foreach($supportedCountries as $supportedCountryId)
            @php
                $country = \Modules\Area\Entities\Country::find($supportedCountryId);
            @endphp
            <div class="form-group">
                <label class="col-md-2">
                    {{ __('setting::dashboard.settings.form.tax_in_country',['country' => $country->title]) }}
                </label>
                <div class="col-md-9 disParent">
                    <input type="text" class="form-control" name="taxes_rates[{{$country?->id}}]" value="{{setting('taxes_rates')[$country?->id] ?? ''}}" autocomplete="off" />
                    <span class="disabled">%</span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2">
                    {{ __('setting::dashboard.settings.form.tax_number',['country' => $country->title]) }}
                </label>
                <div class="col-md-9 disParent">
                    <input type="text" class="form-control" name="tax_number[{{$country?->id}}]" value="{{setting('tax_number')[$country?->id] ?? ''}}" autocomplete="off" />
                </div>
            </div>
        @endforeach
    </div>
</div>
