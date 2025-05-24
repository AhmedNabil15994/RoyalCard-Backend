<section class="container">
	<div class="row">
		
		<?php if($errors->all()): ?>
			<div class="alert alert-danger">
				<ul>
					<a href='#' class="close" data-dismiss="alert" aria-label="close">x</a>
					<?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<li><?php echo e($error); ?></li>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				</ul>
			</div>
		<?php endif; ?>
		
		<?php if(session('msg')): ?>
		    <div class="alert alert-<?php echo e(session('alert')); ?>" align="center">
			        <a href='#' class="close" data-dismiss="alert" aria-label="close">x</a>
			        <h4><?php echo e(session('msg')); ?></h4>
		    </div>
		<?php endif; ?>
	</div>
</section>
<?php /**PATH /home/ahmed-nabil94/Desktop/PhpstormProjects/RoyalCard-Backend/Modules/Apps/Resources/views/dashboard/layouts/_msg.blade.php ENDPATH**/ ?>