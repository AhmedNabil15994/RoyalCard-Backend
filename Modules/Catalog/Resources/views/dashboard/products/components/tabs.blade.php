<div class="panel-group accordion scrollable" id="accordion2">
    <div class="panel panel-default">
        <div id="collapse_2_1" class="panel-collapse in">
            <div class="panel-body">
                <ul class="nav nav-pills nav-stacked">
                    <li class="active">
                        <a href="#global_setting" data-toggle="tab">
                            {{ __('catalog::dashboard.products.form.tabs.general') }}
                        </a>
                    </li>
                    <li class="">
                        <a href="#categories" data-toggle="tab">
                            {{ __('catalog::dashboard.products.form.tabs.categories') }}
                        </a>
                    </li>
                    <li class="codes {{$model && $model->id ?  ($model->product_type == 'digital' ? '' : 'hidden') : ''}}">
                        <a href="#qty_codes" data-toggle="tab">
                            {{ __('catalog::dashboard.products.form.tabs.qty_codes') }}
                        </a>
                    </li>
                    <li class="support {{$model && $model->id ?  ($model->product_type == 'support' ? '' : 'hidden') : 'hidden'}}">
                        <a href="#servers" data-toggle="tab">
                            {{ __('catalog::dashboard.products.form.tabs.servers') }}
                        </a>
                    </li>
                    <li class="">
                        <a href="#offers" data-toggle="tab">
                            {{ __('catalog::dashboard.products.form.tabs.offers') }}
                        </a>
                    </li>
                    <li class="">
                        <a href="#cashback" data-toggle="tab">
                            {{ __('category::dashboard.categories.form.tabs.cashback') }}
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
