<?php $__currentLoopData = $mainCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php if(($model && $model->id != $cat->id) || isset($hasRelation)): ?>
		<ul>
			<li id="<?php echo e($cat->id); ?>" data-jstree='{"opened":true <?php if($model->category_id == $cat->id): ?>,"selected":true <?php endif; ?> }'>
				<?php echo e($cat->title); ?>

				<?php if($cat->children->count() > 0): ?>
					<?php echo $__env->make('category::dashboard.tree.categories.edit',['mainCategories' => $cat->children], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
				<?php endif; ?>
			</li>
		</ul>
	<?php endif; ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php /**PATH /home/ahmed-nabil94/Desktop/PhpstormProjects/RoyalCard-Backend/Modules/Category/Resources/views/dashboard/tree/categories/edit.blade.php ENDPATH**/ ?>