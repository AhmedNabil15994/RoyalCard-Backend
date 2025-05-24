<div class="row">
    <div class="form-group">
        <label class="col-md-2">
            {{ __('setting::dashboard.settings.form.supported_country') }}
        </label>
        <div class="col-md-9">
            <select name="payment_gateway[moyasar][country_id]" class="form-control select2">
                <option> Select Country</option>
                @foreach ($countries as $code => $country)
                    @if (collect(setting('supported_countries'))->contains($country->id))
                        <option value="{{ $country->id }}" {{setting('payment_gateway','moyasar.country_id') == $country->id ? 'selected' : ''}}>{{ $country->title }}</option>
                    @endif
                @endforeach
            </select>
        </div>
    </div>
  <div class="col-md-6 col-md-offset-4">
    <div class="form-group">
      <div class="col-md-9">
        <div class="mt-radio-inline">
          <label class="mt-radio mt-radio-outline">
            {{ __('setting::dashboard.settings.form.payment_gateway.payment_mode.test_mode') }}
            <input onchange="paymentModeSwitcher('moyasar_switch','testModelData_moyasar')" type="radio"
              name="payment_gateway[moyasar][payment_mode]" value="test_mode" @if (setting('payment_gateway','moyasar.payment_mode') !='live_mode'
              ) checked @endif>
            <span></span>
          </label>
          <label class="mt-radio mt-radio-outline">
            {{ __('setting::dashboard.settings.form.payment_gateway.payment_mode.live_mode') }}
            <input onchange="paymentModeSwitcher('moyasar_switch','liveModelData_moyasar')" type="radio"
              name="payment_gateway[moyasar][payment_mode]" value="live_mode" @if (setting('payment_gateway','moyasar.payment_mode')=='live_mode' )
              checked @endif>
            <span></span>
          </label>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-7 col-md-offset-2 moyasar_switch" id="testModelData_moyasar"
    style="{{setting('payment_gateway','moyasar.payment_mode') == 'live_mode' ? 'display: none': 'display: block' }}">
    <h3 class="page-title text-center">Moyasar Gateway ( Test Mode )</h3>
      {!! field()->text('payment_gateway[moyasar][test_mode][PUBLISH_KEY]', 'Publish Key',setting('payment_gateway','moyasar.test_mode.PUBLISH_KEY') ?? '') !!}
      {!! field()->text('payment_gateway[moyasar][test_mode][SECRET_KEY]', 'Secret Key',setting('payment_gateway','moyasar.test_mode.SECRET_KEY') ?? '') !!}
  </div>
  <div class="col-md-7 col-md-offset-2 moyasar_switch" id="liveModelData_moyasar"
    style="{{setting('payment_gateway','moyasar.payment_mode') == 'live_mode' ? 'display: block': 'display: none' }}">
    <h3 class="page-title text-center">Moyasar Gateway ( Live Mode )</h3>

      {!! field()->text('payment_gateway[moyasar][live_mode][PUBLISH_KEY]', 'Publish Key', setting('payment_gateway','moyasar.live_mode.PUBLISH_KEY') ?? '') !!}
      {!! field()->text('payment_gateway[moyasar][live_mode][SECRET_KEY]', 'Secret Key', setting('payment_gateway','moyasar.live_mode.SECRET_KEY') ?? '') !!}

  </div>
  <div class="col-md-7 col-md-offset-2">
    @foreach (config('translatable.locales') as $code)

    {!! field()->text('payment_gateway[moyasar][title_'.$code.']',
    __('setting::dashboard.settings.form.payment_gateway.payment_types.payment_title').'-'.$code ,
    setting('payment_gateway','moyasar.title_'.$code)) !!}

    @endforeach
    {!! field()->checkBox('payment_gateway[moyasar][status]', __('setting::dashboard.settings.form.payment_gateway.payment_types.payment_status') , null , [
    (setting('payment_gateway','moyasar.status') == 'on' ? 'checked' : '') => ''
    ]) !!}
  </div>
</div>
