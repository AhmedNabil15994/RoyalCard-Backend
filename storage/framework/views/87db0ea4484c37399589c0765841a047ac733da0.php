<div class="portlet-title" style="margin-bottom: 25px">
    <div class="caption font-dark">
        <i class="icon-settings font-dark"></i>
        <span class="caption-subject bold uppercase">
            <?php echo e(__('user::dashboard.users.update.form.wallets')); ?>

      </span>
    </div>
</div>
<div class="portlet-body">
    <table class="table table-striped table-bordered table-hover">
        <thead>
        <tr>
            <th>#</th>
            <th><?php echo e(__('user::dashboard.users.update.form.country')); ?></th>
            <th><?php echo e(__('user::dashboard.users.update.form.balance')); ?></th>
            <th><?php echo e(__('transaction::dashboard.transactions.datatable.created_at')); ?></th>
            <th><?php echo e(__('transaction::dashboard.transactions.datatable.options')); ?></th>
        </tr>
        </thead>
        <tbody>
        <?php $__currentLoopData = $userData['wallets']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $wallet): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($wallet->id); ?></td>
                <td><?php echo e($wallet->country->title); ?></td>
                <td><?php echo e(number_format($wallet->balance,3)); ?></td>
                <td><?php echo e($wallet->created_at); ?></td>
                <td>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit_users')): ?>
                        <a href="#" class="btn btn-sm addBalance blue" data-area="<?php echo e($wallet->id); ?>" title="<?php echo e(__('user::dashboard.users.update.form.add_balance')); ?>">
                            <i class="fa fa-edit"></i><?php echo e(__('user::dashboard.users.update.form.add_balance')); ?>

                        </a>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('show_transactions')): ?>
                        <a href="<?php echo e(route('dashboard.wallets.transactions')); ?>?wallet=<?php echo e($wallet->id*34567); ?>" class="btn btn-sm yellow" data-area="<?php echo e($wallet->id); ?>" title="<?php echo e(__('user::dashboard.users.update.form.transactions')); ?>">
                            <i class="fa fa-eye"></i><?php echo e(__('transaction::dashboard.transactions.index.title')); ?>

                        </a>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
</div>

<div class="modal balanceModal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><?php echo e(__('user::dashboard.users.update.form.add_balance')); ?></h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="col-md-2">
                        <?php echo e(__('user::dashboard.users.update.form.balance')); ?>

                    </label>
                    <div class="col-md-9 disParent">
                        <input type="text" class="form-control" name="balance" autocomplete="off" />
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary acceptBalance"><?php echo e(__('user::dashboard.users.update.form.add_balance')); ?></button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo e(__('apps::dashboard.buttons.cancel')); ?></button>
            </div>
        </div>
    </div>
</div>
<?php /**PATH /home/ahmed-nabil94/Desktop/PhpstormProjects/RoyalCard-Backend/Modules/User/Resources/views/dashboard/users/form/wallets.blade.php ENDPATH**/ ?>