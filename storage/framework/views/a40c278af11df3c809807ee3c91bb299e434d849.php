<div class="tab-pane fade" id="logo">
    <h3 class="page-title"><?php echo e(__('setting::dashboard.settings.form.tabs.logo')); ?></h3>
    <div class="col-md-10">
        <?php echo field()->file('images[logo]' , __('setting::dashboard.settings.form.logo') , setting('logo') ? url(setting('logo')) : null); ?>

        <?php echo field()->file('images[footer_logo]' , __('setting::dashboard.settings.form.footer_logo') , setting('footer_logo') ? url(setting('footer_logo')) : null); ?>

        <?php echo field()->file('images[favicon]' , __('setting::dashboard.settings.form.favicon') , setting('favicon') ? url(setting('favicon')) : null); ?>

        <?php echo field()->file('images[splash_image]' , __('setting::dashboard.settings.form.splash_image') , setting('splash_image') ? url(setting('splash_image')) : null); ?>

    </div>
</div>
<?php /**PATH /home/ahmed-nabil94/Desktop/PhpstormProjects/RoyalCard-Backend/Modules/Setting/Resources/views/dashboard/tabs/logo.blade.php ENDPATH**/ ?>