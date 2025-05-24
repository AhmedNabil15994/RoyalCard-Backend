<div class="portlet-title" style="margin-bottom: 25px">
    <div class="caption font-dark">
        <i class="icon-settings font-dark"></i>
        <span class="caption-subject bold uppercase">
            <?php echo e(__('user::dashboard.users.update.form.wallets_transactions')); ?>

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
            <th><?php echo e(__('transaction::dashboard.transactions.datatable.type')); ?></th>
            <th><?php echo e(__('transaction::dashboard.transactions.datatable.created_at')); ?></th>
        </tr>
        </thead>
        <tbody>
        <?php $__currentLoopData = $userData['wallets_transactions']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $walletTransaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
                $type = $walletTransaction->method == 'wallet' ? __('user::dashboard.users.update.form.out') : __('user::dashboard.users.update.form.in');
                $total = $walletTransaction->method == 'wallet' ?
                            number_format($walletTransaction->order->total,3) . ' ' . $walletTransaction?->order?->country?->currency?->code :
                                number_format($walletTransaction->recharge_balance, 3) . ' ' . $walletTransaction?->wallet?->country?->currency?->code;
            ?>
            <tr>
                <td><?php echo e($walletTransaction->id); ?></td>
                <td><?php echo e($walletTransaction->payment_id); ?></td>
                <td><?php echo e($walletTransaction->method); ?></td>
                <td><?php echo e($walletTransaction->result == 'paid' ? 'CAPTURED' : $walletTransaction->result); ?></td>
                <td><?php echo e($walletTransaction->track_id); ?></td>
                <td><?php echo e($walletTransaction->ref); ?></td>
                <td><?php echo e($total); ?></td>
                <td><?php echo e($type); ?></td>
                <td><?php echo e($walletTransaction->created_at); ?></td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
</div>
<?php /**PATH /home/ahmed-nabil94/Desktop/PhpstormProjects/RoyalCard-Backend/Modules/User/Resources/views/dashboard/users/form/wallets_transactions.blade.php ENDPATH**/ ?>