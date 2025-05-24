<div class="tab-pane active fade in" id="global_setting">
    {{-- <h3 class="page-title">{{__('coupon::dashboard.coupons.form.tabs.general')}}</h3> --}}
    <div class="col-md-12">

        <div>
            <div class="tabbable">
                <ul class="nav nav-tabs bg-slate nav-tabs-component">
                    @foreach (config('laravellocalization.supportedLocales') as $code => $lang)
                        <li class=" {{ ($code == locale()) ? 'active' : '' }}">
                            <a href="#colored-rounded-tab-general-{{$code}}" data-toggle="tab" aria-expanded="false"> {{ $lang['native'] }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="tab-content">
                @foreach (config('laravellocalization.supportedLocales') as $code => $lang)
                    <div class="tab-pane @if ($code == locale()) active @endif"
                         id="colored-rounded-tab-general-{{ $code }}">
                        <div class="form-group">
                            <label class="col-md-2">
                                {{ __('catalog::dashboard.products.form.title') }}
                            </label>
                            <div class="col-md-9">
                                <input type="text" name="title[{{ $code }}]"
                                       class="form-control"
                                       data-name="title.{{ $code }}"
                                        value="{{$model && $model->id ? ($model->getTranslations('title')[$code] ?? '') : ''}}">
                                <div class="help-block"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2">
                                {{ __('catalog::dashboard.products.form.description') }}
                            </label>
                            <div class="col-md-9">
                                <textarea name="description[{{ $code }}]" class="form-control " data-name="description.{{ $code }}">{{$model && $model->id ? ($model->getTranslations('description')[$code] ?? '') : ''}}</textarea>
                                <div class="help-block"></div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <hr>
        </div>

        @if(auth()->id() == 1)
        <div class="form-group">
            <label class="col-md-2">
                {{__('catalog::dashboard.products.form.sku')}}
            </label>
            <div class="col-md-9">
                <input type="text" name="sku" class="form-control"
                       value="{{ $model && $model->id ? $model->sku : generateRandomCode() }}" data-name="sku">
                <div class="help-block"></div>
            </div>
        </div>
        @endif

        <div class="form-group">
            <label class="col-md-2">
                {{ __('catalog::dashboard.products.form.user_max_uses') }}
            </label>
            <div class="col-md-9">
                <input type="number" min="1" name="user_max_uses" class="form-control"
                       data-name="user_max_uses" value="{{$model?->user_max_uses}}">
                <div class="help-block"></div>
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-2">
                {{ __('catalog::dashboard.products.form.status') }}
            </label>
            <div class="col-md-9">
                <input type="checkbox" class="make-switch" id="test" data-size="small"
                       name="status" {{$model && $model->id ? ($model->status ? 'checked' : '') : ''}}>
                <div class="help-block"></div>
            </div>
        </div>

        {!! field()->number('order', __('category::dashboard.categories.form.sort'), ($model && $model->id ? $model->order : 0)) !!}

        {!! field()->file('image', __('category::dashboard.categories.form.image'), ($model && $model->id ? $model->getFirstMediaUrl('images') : null)) !!}

    </div>
</div>
