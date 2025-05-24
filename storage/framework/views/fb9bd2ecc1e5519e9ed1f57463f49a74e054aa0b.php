<div class="tab-pane fade in" id="categories">
    <div class="tab-content">
        <div class="tab-pane active fade in" id="category_level">
            <input type="hidden" id="root_category" name="category_id">
            <div id="jstree">
                <?php if($model && $model->id): ?>
                    <?php echo $__env->make('catalog::dashboard.categories.tree.categories.multi-edit',[
                        'mainCategories' => $mainCategories,
                        'model' => $model,
                        'categories' => $model->productCategories()->pluck('category_id')->toArray()
                    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php else: ?>
                <?php echo $__env->make('category::dashboard.tree.categories.edit',['mainCategories' => $mainCategories], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php /**PATH /home/ahmed-nabil94/Desktop/PhpstormProjects/RoyalCard-Backend/Modules/Catalog/Resources/views/dashboard/products/components/categories.blade.php ENDPATH**/ ?>