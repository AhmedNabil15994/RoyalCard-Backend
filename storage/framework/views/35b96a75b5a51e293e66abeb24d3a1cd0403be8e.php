<?php $__currentLoopData = $mainCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <ul>
        <li id="<?php echo e($category->id); ?>" data-jstree='{"opened":true}'>
            <?php echo e($category->title); ?>

            <?php if($category->children->count() > 0): ?>
                <?php echo $__env->make('category::dashboard.tree.categories.view',['mainCategories' => $category->children], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php endif; ?>
        </li>
    </ul>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php /**PATH /home/ahmed-nabil94/Desktop/PhpstormProjects/RoyalCard-Backend/Modules/Category/Resources/views/dashboard/tree/categories/view.blade.php ENDPATH**/ ?>