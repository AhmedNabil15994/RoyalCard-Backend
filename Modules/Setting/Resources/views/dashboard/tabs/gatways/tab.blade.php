
            <div class="row">
                <div class="form-group">
                    <label class="col-md-2">
                        {{ __('setting::dashboard.settings.form.supported_country') }}
                    </label>
                    <div class="col-md-9">
                        <select name="payment_gateway[tap][country_id]" class="form-control select2">
                            <option> Select Country</option>
                            @foreach ($countries as $code => $country)
                                @if (collect(setting('supported_countries'))->contains($country->id))
                                    <option value="{{ $country->id }}" {{setting('payment_gateway','tap.country_id') == $country->id ? 'selected' : ''}}>{{ $country->title }}</option>
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
                                    <input onchange="paymentModeSwitcher('tap_switch','testModelData_tap')" type="radio" name="payment_gateway[tap][payment_mode]" value="test_mode"
                                           @if (setting('payment_gateway','tap.payment_mode') != 'live_mode')
                                           checked
                                            @endif>
                                    <span></span>
                                </label>
                                <label class="mt-radio mt-radio-outline">
                                    {{ __('setting::dashboard.settings.form.payment_gateway.payment_mode.live_mode') }}
                                    <input  onchange="paymentModeSwitcher('tap_switch','liveModelData_tap')" type="radio" name="payment_gateway[tap][payment_mode]" value="live_mode"
                                           @if (setting('payment_gateway','tap.payment_mode') == 'live_mode')
                                           checked
                                            @endif>
                                    <span></span>
                                </label>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="row">
                <div class="col-md-7 col-md-offset-2 tap_switch" id="testModelData_tap"
                     style="{{ setting('payment_gateway','tap.payment_mode') == 'live_mode' ? 'display: none': 'display: block' }}">

                    <h3 class="page-title text-center">Tap Gateway ( Test Mode )</h3>

                    {!! field()->text('payment_gateway[tap][test_mode][API_KEY]', 'API Key', setting('payment_gateway','tap.test_mode.API_KEY') ?? '') !!}
                </div>

                <div class="col-md-7 col-md-offset-2 tap_switch" id="liveModelData_tap"
                     style="{{ setting('payment_gateway','tap.payment_mode') == 'live_mode' ? 'display: block': 'display: none' }}">

                    <h3 class="page-title text-center">Tap Gateway ( Live Mode )</h3>

                    {!! field()->text('payment_gateway[tap][live_mode][API_KEY]', 'API Key',  setting('payment_gateway','tap.live_mode.API_KEY') ?? '') !!}

                </div>
                <div class="col-md-7 col-md-offset-2">
                    @foreach (config('translatable.locales') as $code)

                        {!! field()->text('payment_gateway[tap][title_'.$code.']', __('setting::dashboard.settings.form.payment_gateway.payment_types.payment_title').'-'.$code ,
                        setting('payment_gateway','tap.title_'.$code)) !!}

                    @endforeach
                    {!! field()->checkBox('payment_gateway[tap][status]', __('setting::dashboard.settings.form.payment_gateway.payment_types.payment_status') , null , [
                    (setting('payment_gateway','tap.status') == 'on' ? 'checked' : '') => ''
                    ]) !!}
                </div>
            </div>
