<div class="tab-pane fade" id="app_links">
  <h3 class="page-title"><?php echo e(__('app links')); ?></h3>
  <div class="col-md-10">
    <?php echo field()->text('app_links[google_play]' , __('google play') , setting('app_links','google_play') ); ?>

    <?php echo field()->text('app_links[app_store]' , __('app store') , setting('app_links','app_store') ); ?>

    <?php echo field()->text('app_links[app_gallery]' , __('app gallery') , setting('app_links','app_gallery') ); ?>

  </div>
</div>
<?php /**PATH /home/ahmed-nabil94/Desktop/PhpstormProjects/RoyalCard-Backend/Modules/Setting/Resources/views/dashboard/tabs/app_links.blade.php ENDPATH**/ ?>