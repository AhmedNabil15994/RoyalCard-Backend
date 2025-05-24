<?php $__currentLoopData = $mainCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php if(($model && $model->id ) || isset($hasRelation)): ?>
		<ul>
			<li id="<?php echo e($cat->id); ?>" data-jstree='{"opened":true <?php if(in_array($cat->id,$categories)): ?>,"selected":true <?php endif; ?> }'>
				<?php echo e($cat->title); ?>

				<?php if($cat->children->count() > 0): ?>
					<?php echo $__env->make('catalog::dashboard.categories.tree.categories.multi-edit',[
                            'mainCategories' => $cat->children,
                            'model' => $model,
                            'categories' => $categories
                    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
				<?php endif; ?>
			</li>
		</ul>
	<?php endif; ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php /**PATH /home/ahmed-nabil94/Desktop/PhpstormProjects/RoyalCard-Backend/Modules/Catalog/Resources/views/dashboard/categories/tree/categories/multi-edit.blade.php ENDPATH**/ ?>