<div class="tab-pane fade in" id="categories">
    <div class="tab-content">
        <div class="tab-pane active fade in" id="category_level">
            <input type="hidden" id="root_category" name="category_id">
            <div id="jstree">
                @if($model && $model->id)
                    @include('catalog::dashboard.categories.tree.categories.multi-edit',[
                        'mainCategories' => $mainCategories,
                        'model' => $model,
                        'categories' => $model->productCategories()->pluck('category_id')->toArray()
                    ])
                @else
                @include('category::dashboard.tree.categories.edit',['mainCategories' => $mainCategories])
                @endif
            </div>
        </div>
    </div>
</div>
