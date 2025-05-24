<div class="tab-pane fade in" id="qty_codes">
    <div class="tab-content">
        <div class="tab-pane active fade in" id="qty_codes">
            <div class="form-group qty {{$model && $model->id ?  ($model->product_type == 'digital' ? 'hidden' : '') : 'hidden'}}">
                <label class="col-md-2">
                    {{ __('catalog::dashboard.products.form.qty') }}
                </label>
                <div class="col-md-9">
                    <input type="number" class="form-control" id="qty" data-size="small" name="qty" value="{{$model && $model->id ? $model->qty : ''}}">
                    <div class="help-block"></div>
                </div>
            </div>

            <div class="form-group codes {{$model && $model->id ?  ($model->product_type == 'physical' ? 'hidden' : '') : ''}}">
                <label class="col-md-2">
                    {{ __('catalog::dashboard.products.form.codes') }}
                </label>
                <div class="col-md-9">
                    <textarea name="codes" class="form-control " data-name="codes" placeholder="{{ __('catalog::dashboard.products.form.codes') }}" >{{$model && $model->id ? implode("\r\n",$model->activeItems()->pluck('code')->toArray()??[]) : ''}}</textarea>
                    <p class="notes"><span class="astric">(*)</span>{{ __('catalog::dashboard.products.form.codes_notes') }}</p>
                    <div class="help-block"></div>
                </div>
            </div>
        </div>
    </div>
</div>
