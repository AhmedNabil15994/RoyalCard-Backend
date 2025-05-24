<div class="tab-pane fade" id="payment_gateway">

  <ul class="nav nav-tabs">
    
    <li class="active">
      <a data-toggle="tab" href="#UPayment">UPayment</a>
    </li>
    <li>
      <a data-toggle="tab" href="#Tap">Tap</a>
    </li>
    <li>
      <a data-toggle="tab" href="#Myfatoorah">Myfatoorah</a>
    </li>
    <li>
      <a data-toggle="tab" href="#Moyasar">Moyasar</a>
    </li>
    <li>
      <a data-toggle="tab" href="#Knet">KNET</a>
    </li>
  </ul>

  <div class="tab-content">
    
    <div id="UPayment" class="tab-pane fade in active">
      <?php echo $__env->make('setting::dashboard.tabs.gatways.upayment', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>

    <div id="Tap" class="tab-pane fade">
      <?php echo $__env->make('setting::dashboard.tabs.gatways.tab', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>

    <div id="Myfatoorah" class="tab-pane fade">
      <?php echo $__env->make('setting::dashboard.tabs.gatways.fatoorah', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>

    <div id="Moyasar" class="tab-pane fade">
       <?php echo $__env->make('setting::dashboard.tabs.gatways.moyasar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>

    <div id="Knet" class="tab-pane fade">
      <?php echo $__env->make('setting::dashboard.tabs.gatways.knet', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>
  </div>
  <hr>
  <div class="row">
    <div class="col-md-7 col-md-offset-3">

      

    </div>
  </div>

</div>

<?php /**PATH /home/ahmed-nabil94/Desktop/PhpstormProjects/RoyalCard-Backend/Modules/Setting/Resources/views/dashboard/tabs/payment_gateway.blade.php ENDPATH**/ ?>