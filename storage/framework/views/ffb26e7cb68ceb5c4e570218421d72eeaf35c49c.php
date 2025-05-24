<?php if(is_rtl() == 'rtl'): ?>
  <script src="<?php echo e(asset('/admin/assets/global/plugins/bootstrap-daterangepicker/daterangepicker-rtl.min.js')); ?>" type="text/javascript"></script>
<?php else: ?>
  <script src="<?php echo e(asset('/admin/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js')); ?>" type="text/javascript"></script>
<?php endif; ?>

<script src="<?php echo e(asset('vendor/datatables/buttons.server-side.js')); ?>"></script>



<script type="text/javascript">
    $(document).ready(function() {
        $(".emojioneArea").emojioneArea();
    });
</script>

<script type="text/javascript">
  $(document).ready(function() {
    $(".emojioneArea").emojioneArea();
  });
</script>

<style>

  .emojionearea .emojionearea-picker.emojionearea-picker-position-top {
  	margin-bottom: -286px!important;
  	right: -14px;
  	z-index: 90000000000000;
  }

  .emojionearea .emojionearea-button.active+.emojionearea-picker-position-top {
      margin-top: 0px!important;
  }
</style>


<script>

  $('.delete').click(function() {
      $(this).closest('.form-group').find($('.' + $(this).data('input'))).val('');
      $(this).closest('.form-group').find($('.' + $(this).data('preview'))).html('');
  });
</script>
<?php echo $__env->yieldPushContent('scripts'); ?>
<?php /**PATH /home/ahmed-nabil94/Desktop/PhpstormProjects/RoyalCard-Backend/Modules/Apps/Resources/views/dashboard/layouts/_js.blade.php ENDPATH**/ ?>