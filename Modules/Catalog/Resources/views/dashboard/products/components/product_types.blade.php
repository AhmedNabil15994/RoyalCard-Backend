<div class="row">
    <div class="mt-radio-inline text-center">
        <label class="mt-radio mt-radio-outline">
            {{ __('catalog::dashboard.products.form.product_type.digital') }}
            <input type="radio" name="product_type" value="digital" {{$model && $model->id ?  ($model->product_type == 'digital' ? 'checked' : '') : 'checked'}}>
            <span></span>
        </label>
        <label class="mt-radio mt-radio-outline hidden">
            {{ __('catalog::dashboard.products.form.product_type.physical') }}
            <input type="radio" name="product_type" value="physical" {{$model && $model->id ?  ($model->product_type == 'physical' ? 'checked' : '') : ''}}>
            <span></span>
        </label>
        <label class="mt-radio mt-radio-outline">
            {{ __('catalog::dashboard.products.form.product_type.support') }}
            <input type="radio" name="product_type" value="support" {{$model && $model->id ?  ($model->product_type == 'support' ? 'checked' : '') : ''}}>
            <span></span>
        </label>
    </div>
</div>
