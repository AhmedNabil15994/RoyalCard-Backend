@foreach ($mainCategories as $cat)
    @if (($model && $model->id ) || isset($hasRelation))
		<ul>
			<li id="{{$cat->id}}" data-jstree='{"opened":true @if (in_array($cat->id,$categories)),"selected":true @endif }'>
				{{$cat->title}}
				@if($cat->children->count() > 0)
					@include('catalog::dashboard.categories.tree.categories.multi-edit',[
                            'mainCategories' => $cat->children,
                            'model' => $model,
                            'categories' => $categories
                    ])
				@endif
			</li>
		</ul>
	@endif
@endforeach
