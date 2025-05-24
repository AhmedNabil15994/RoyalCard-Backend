<?php
    $config_container = SewidanGetTagConfig('container' , $config);
    $config_label = SewidanGetTagConfig('label' , $config);
    $config_field_div = SewidanGetTagConfig('field_div' , $config);
    $config_field_error = SewidanGetTagConfig('field_error' , $config);
?>

<?php if($config_container): ?>
    <div class="<?php echo e(isset($config_container['class']) ? $config_container['class'] :''); ?> <?php echo e($errors->has($name) ? 'has-error':''); ?>"
         id="<?php echo e($name); ?>_wrap">
        <?php endif; ?>

        <?php if($config_label): ?>
            <label for="<?php echo e($name); ?>" <?php echo isset($config_label['options']) ? sewidanOptionsToStr($config_label['options']) : ''; ?>>
                <?php echo e($label); ?>

                <?php if(isset($field_attributes['required']) && $field_attributes['required']): ?>
                    <span style="color: #f83333;">*</span>
                <?php endif; ?>
            </label>
        <?php endif; ?>

        <?php if($config_field_div): ?>
            <div <?php echo isset($config_field_div['options']) ? sewidanOptionsToStr($config_field_div['options']) : ''; ?>>
                <?php endif; ?>

                <?php echo $__env->make('fields::fields.'. $field_type, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


                <?php if($config_field_error): ?>

                    <span <?php echo isset($config_field_error['options']) ? sewidanOptionsToStr($config_field_error['options']) : ''; ?>>
                        <?php echo e($errors->first($name)); ?>

                    </span>
                <?php endif; ?>

                <?php if($config_field_div): ?>
            </div>
        <?php endif; ?>

        <?php if($config_container): ?>
    </div>
<?php endif; ?>
<?php if(in_array($field_type , ['file','multiFile-upload']) && isset($field_attributes['class']) && strpos($field_attributes['class'],'file_upload_preview')): ?>
    <script>
        if (window.file_upload_preview === undefined) {

            window.file_upload_preview = true;
            document.addEventListener('DOMContentLoaded', function () {
                var head = document.head;
                var body = document.body;
                var link = document.createElement("link");

                link.type = "text/css";
                link.rel = "stylesheet";
                link.href = '/SewidanField/plugins/bootstrap-fileinput/css/fileinput.min.css';
                head.appendChild(link);

                var scripts = [
                    '/SewidanField/plugins/bootstrap-fileinput/js/fileinput.min.js',
                ];
                for (var i = 0; i < 1; i++) {
                    var script = document.createElement("script");
                    script.type = "text/javascript";
                    script.src = scripts[i];
                    body.append(script);
                }

            }, false);
        }
    </script>
<?php endif; ?>
<?php /**PATH /home/ahmed-nabil94/Desktop/PhpstormProjects/RoyalCard-Backend/vendor/mostafasewidan/sewidan-field/src/resources/views/layouts/field-app.blade.php ENDPATH**/ ?>