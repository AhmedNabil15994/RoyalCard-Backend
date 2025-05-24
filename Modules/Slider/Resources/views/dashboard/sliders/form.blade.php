@inject('categories',"\Modules\Category\Entities\Category")
@inject('products',"\Modules\Catalog\Entities\Product")
<style>
    .hide-inputs{
        display: none;
    }
</style>
{!! field()->langNavTabs() !!}

<div class="tab-content">
    @foreach (config('laravellocalization.supportedLocales') as $code => $lang)
    <div class="tab-pane fade in {{ ($code == locale()) ? 'active' : '' }}"
        id="first_{{$code}}">
        {!! field()->text('title['.$code.']',
        __('slider::dashboard.sliders.form.title').'-'.$code ,
        $model->getTranslation('title',$code),
        ['data-name' => 'title.'.$code]
        ) !!}
        <div class="form-group">
            <label for="" class="col-md-2">{{__('slider::dashboard.sliders.form.description').'-'.$code}}</label>
            <div class="col-md-9">
                <textarea name="description[{{$code}}]" rows="8" cols="80" class="form-control {{is_rtl($code)}}Editor" data-name="description.{{$code}}">{{ $model->description }}</textarea>
                <div class="help-block"></div>
            </div>
        </div>

    </div>
    @endforeach
</div>

<div class="form-group">
    <label for="" class="col-md-2">{{__('slider::dashboard.sliders.form.link_type')}}</label>
    <div class="col-md-9">
        <select name="type" class="form-control select2">
            <option value="">Select Type</option>
            <option value="external" {{$model?->type == 'external' ? 'selected' : ''}}>{{__('slider::dashboard.sliders.form.external_link')}}</option>
            <option value="category" {{$model?->type == 'category' ? 'selected' : ''}}>{{__('slider::dashboard.sliders.form.categories')}}</option>
            <option value="product" {{$model?->type == 'product' ? 'selected' : ''}}>{{__('slider::dashboard.sliders.form.products')}}</option>
        </select>
        <div class="help-block"></div>
    </div>
</div>


<div class="form-group hide-inputs" id="external-input" style="display: {{$model?->type == 'external' ? 'block' : 'none'}}">
    <label for="" class="col-md-2">{{__('slider::dashboard.sliders.form.link')}}</label>
    <div class="col-md-9">
        <input type="text" class="form-control" value="{{$model?->type == 'external' && $model?->link ?? ''}}" name="link" placeholder="{{__('slider::dashboard.sliders.form.link')}}">
        <div class="help-block"></div>
    </div>
</div>

<div class="form-group hide-inputs" id="category-input" style="display: {{$model?->type == 'category' ? 'block' : 'none'}}">
    <label for="" class="col-md-2">{{__('slider::dashboard.sliders.form.category')}}</label>
    <div class="col-md-9">
        <select name="category_id" class="form-control select2">
            <option value="">{{__('slider::dashboard.sliders.form.category')}}</option>
            @foreach($categories->active()->get() as $category)
                <option value="{{$category->id}}" {{$model?->type == 'category' && $model?->link == $category->id ? 'selected' : ''}}>{{$category->title}}</option>
            @endforeach
        </select>
        <div class="help-block"></div>
    </div>
</div>

<div class="form-group hide-inputs" id="product-input" style="display: {{$model?->type == 'product' ? 'block' : 'none'}}">
    <label for="" class="col-md-2">{{__('slider::dashboard.sliders.form.product')}}</label>
    <div class="col-md-9">
        <select name="product_id" class="form-control select2">
            <option value="">{{__('slider::dashboard.sliders.form.product')}}</option>
            @foreach($products->active()->get() as $product)
                <option value="{{$product->id}}" {{$model?->type == 'product' && $model?->link == $product->id ? 'selected' : ''}}>{{$product->title}}</option>
            @endforeach
        </select>
        <div class="help-block"></div>
    </div>
</div>

{!! field()->number('order', __('slider::dashboard.sliders.form.order')) !!}
{!! field()->file('image', __('slider::dashboard.sliders.form.image'), $model->getFirstMediaUrl('images')) !!}
{!! field()->checkBox('status', __('slider::dashboard.sliders.form.status')) !!}

@if ($model->trashed())
{!! field()->checkBox('trash_restore', __('slider::dashboard.sliders.form.restore')) !!}
@endif



@push('start_scripts')
<script>
    $('[name=type]').change(function () {
        $('.hide-inputs').hide();
        $('#' + this.value + '-input').show();
    });
</script>
@endpush
