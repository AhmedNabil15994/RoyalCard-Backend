<div class="tab-pane fade in support {{$model && $model->id ?  ($model->product_type == 'support' ? '' : 'hidden') : 'hidden'}}" id="servers">
    <div class="form-group">
        <label class="col-md-2">
            {{__('catalog::dashboard.products.form.available_servers')}}
        </label>
        <div class="col-md-9">
            <select name="available_servers[]" class="form-control select2" multiple>
                @foreach($servers as $server)
                    <option value="{{$server->id}}"  {{$model && $model->id  ? (in_array($server->id,json_decode($model->available_servers,true) ?? []) ? 'selected' : '') : ''}}>{{$server->title}}</option>
                @endforeach
            </select>
            <div class="help-block"></div>
        </div>
    </div>
</div>
