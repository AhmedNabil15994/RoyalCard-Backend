<div class="portlet-title" style="margin-bottom: 25px">
    <div class="caption font-dark">
        <i class="icon-settings font-dark"></i>
        <span class="caption-subject bold uppercase">
            <?php echo e(__('order::dashboard.orders.index.title')); ?>

          </span>
    </div>
</div>
<div class="portlet-body">
    <table class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th>#</th>
                <th><?php echo e(__('order::dashboard.orders.datatable.user')); ?></th>
                <th><?php echo e(__('order::dashboard.orders.datatable.mobile')); ?></th>
                <th><?php echo e(__('order::dashboard.orders.datatable.email')); ?></th>
                <th><?php echo e(__('order::dashboard.orders.datatable.total')); ?></th>
                <th><?php echo e(__('order::dashboard.orders.datatable.country')); ?></th>
                <th><?php echo e(__('order::dashboard.orders.datatable.status')); ?></th>
                <th><?php echo e(__('order::dashboard.orders.datatable.created_at')); ?></th>
                <th><?php echo e(__('order::dashboard.orders.datatable.options')); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $userData['orders']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($order->id); ?></td>
                    <td><?php echo e($order?->user?->name); ?></td>
                    <td><?php echo e($order?->user?->mobile); ?></td>
                    <td><?php echo e($order?->user?->email); ?></td>
                    <td><?php echo e($order->total . ' ' . $order?->country?->currency?->code); ?></td>
                    <td><?php echo e($order?->country?->title); ?></td>
                    <td><?php echo e($order?->orderStatus?->title); ?></td>
                    <td><?php echo e($order->created_at); ?></td>
                    <td>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('show_orders')): ?>
                            <a href="<?php echo e(route('dashboard.orders.show',$order->id)); ?>" class="btn btn-sm yellow" target="_blank" title="Show">
                                <i class="fa fa-eye"></i>
                            </a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
</div>
<?php /**PATH /home/ahmed-nabil94/Desktop/PhpstormProjects/RoyalCard-Backend/Modules/User/Resources/views/dashboard/users/form/orders.blade.php ENDPATH**/ ?>