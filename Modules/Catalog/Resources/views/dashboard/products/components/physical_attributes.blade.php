<div class="form-group">
    <div class="blog-single-sidebar bordered blog-container">
        @include('catalog::dashboard.products.components.barcodefield')

        <div class="form-group">

            <div class="col-md-6 text-left">
                <label>{{__('catalog::dashboard.products.form.weight')}} - KG</label>
                <input type="number"
                       placeholder="{{__('catalog::dashboard.products.form.weight')}}"
                       class="form-control" data-name="shipment.weight"
                       value="{{$model && $model->id ? $model->shipment->weight : ''}}"
                       name="shipment[weight]">
                <div class="help-block"></div>
            </div>

            <div class="col-md-6 text-left">
                <label>{{__('catalog::dashboard.products.form.width')}} - cm</label>
                <input type="number"
                       placeholder="{{__('catalog::dashboard.products.form.width')}}"
                       data-name="shipment.width" class="form-control"
                       value="{{$model && $model->id ? $model->shipment->width : ''}}"
                       name="shipment[width]">
                <div class="help-block"></div>
            </div>

            <div class="col-md-6 text-left">
                <label>{{__('catalog::dashboard.products.form.length')}} - cm</label>
                <input type="number"
                       placeholder="{{__('catalog::dashboard.products.form.length')}}"
                       data-name="shipment.length" class="form-control"
                       value="{{$model && $model->id ? $model->shipment->length : ''}}"
                       name="shipment[length]">
                <div class="help-block"></div>
            </div>

            <div class="col-md-6 text-left">
                <label>{{__('catalog::dashboard.products.form.height')}} - cm</label>
                <input type="number"
                       placeholder="{{__('catalog::dashboard.products.form.height')}}"
                       class="form-control" data-name="shipment.height"
                       value="{{$model && $model->id ? $model->shipment->height : ''}}"
                       name="shipment[height]">
                <div class="help-block"></div>
            </div>

        </div>

        <div id="select_countries"
             style="display:block">

        </div>
    </div>
</div>
