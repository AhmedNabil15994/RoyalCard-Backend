<div class="portlet-title" style="margin-bottom: 25px">
    <div class="caption font-dark">
        <i class="icon-settings font-dark"></i>
        <span class="caption-subject bold uppercase">
            <?php echo e(__('transaction::dashboard.transactions.index.title')); ?>

      </span>
    </div>
</div>
<div class="portlet-body">
    <table class="table table-striped table-bordered table-hover">
        <thead>
        <tr>
            <th>#</th>
            <th><?php echo e(__('transaction::dashboard.transactions.datatable.payment_id')); ?></th>
            <th><?php echo e(__('transaction::dashboard.transactions.datatable.method')); ?></th>
            <th><?php echo e(__('transaction::dashboard.transactions.datatable.result')); ?></th>
            <th><?php echo e(__('transaction::dashboard.transactions.datatable.track_id')); ?></th>
            <th><?php echo e(__('transaction::dashboard.transactions.datatable.ref')); ?></th>
            <th><?php echo e(__('order::dashboard.orders.datatable.total')); ?></th>
            <th><?php echo e(__('transaction::dashboard.transactions.datatable.created_at')); ?></th>
        </tr>
        </thead>
        <tbody>
        <?php $__currentLoopData = $userData['transactions']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($transaction->id); ?></td>
                <td><?php echo e($transaction->payment_id); ?></td>
                <td><?php echo e($transaction->method); ?></td>
                <td><?php echo e($transaction->result); ?></td>
                <td><?php echo e($transaction->track_id); ?></td>
                <td><?php echo e($transaction->ref); ?></td>
                <td><?php echo e(number_format($transaction->order->total,3) . ' ' . $transaction?->order?->country?->currency?->code); ?></td>
                <td><?php echo e($transaction->created_at); ?></td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
</div>
<?php /**PATH /home/ahmed-nabil94/Desktop/PhpstormProjects/RoyalCard-Backend/Modules/User/Resources/views/dashboard/users/form/transactions.blade.php ENDPATH**/ ?>