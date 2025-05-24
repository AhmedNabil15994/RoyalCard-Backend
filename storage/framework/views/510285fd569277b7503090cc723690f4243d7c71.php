<?php $__env->startSection('title', __('apps::dashboard.index.title')); ?>
<?php $__env->startSection('css'); ?>
    <style>
        .mb-25{
            margin-bottom: 25px !important;
        }
    </style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <a href="<?php echo e(url(route('dashboard.home'))); ?>">
                            <?php echo e(__('apps::dashboard.index.title')); ?>

                        </a>
                    </li>
                </ul>
            </div>
            <h1 class="page-title"> <?php echo e(__('apps::dashboard.index.welcome')); ?> ,
                <small><b style="color:red"><?php echo e(Auth::user()->name); ?> </b></small>
            </h1>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('show_statistics')): ?>
                <div class="portlet light bordered">
                    <div class="portlet-title tabbable-line">
                        <div class="caption">
                            <i class="icon-bubbles font-dark hide"></i>
                            <span class="caption-subject font-dark bold uppercase">
                                <?php echo e(__('apps::dashboard.datatable.form.date_range')); ?>

                            </span>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div id="filter_data_table">
                            <div class="panel-body row">
                                <div class="col-xs-12">
                                    <form class="horizontal-form">
                                        <div class="form-body">
                                            <div class="row">
                                                <div class="col-md-9">
                                                    <div class="row">
                                                        <div class="form-group col-md-6">
                                                            <div id="reportrange" class="btn default form-control">
                                                                <i class="fa fa-calendar"></i> &nbsp;
                                                                <span> </span>
                                                                <b class="fa fa-angle-down"></b>
                                                                <input type="hidden" name="from">
                                                                <input type="hidden" name="to">
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <select name="country_id" id="country_id" class="form-control select2">
                                                                <option value=""<?php echo e(__('order::dashboard.orders.datatable.country')); ?></option>
                                                                <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $code => $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                    <?php if(collect(setting('supported_countries'))->contains($country->id)): ?>
                                                                        <option value="<?php echo e($country->id); ?>" <?php echo e(request()->country_id == $country->id ? 'selected' : ''); ?>><?php echo e($country->title); ?></option>
                                                                    <?php endif; ?>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-actions col-md-3">

                                                    <button class="btn btn-sm green btn-outline filter-submit margin-bottom"
                                                            type="submit">
                                                        <i class="fa fa-search"></i>
                                                        <?php echo e(__('apps::dashboard.datatable.search')); ?>

                                                    </button>
                                                    <a class="btn btn-sm red btn-outline filter-cancel"
                                                       href="<?php echo e(url(route('dashboard.home'))); ?>">
                                                        <i class="fa fa-times"></i>
                                                        <?php echo e(__('apps::dashboard.datatable.reset')); ?>

                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="portlet light bordered col-lg-12">
                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 mb-25">
                            <a class="dashboard-stat dashboard-stat-v2 blue" href="<?php echo e(url(route('dashboard.products.index'))); ?>">
                                <div class="visual">
                                    <i class="fa fa-building-o"></i>
                                </div>
                                <div class="details">
                                    <div class="number">
                                        <span data-counter="counterup" data-value="<?php echo e($data['products']); ?>"><?php echo e($data['products']); ?></span>
                                    </div>
                                    <div class="desc"><?php echo e(__('apps::dashboard.index.statistics.products')); ?></div>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 mb-25">
                            <a class="dashboard-stat dashboard-stat-v2 yellow" href="<?php echo e(url(route('dashboard.orders.index'))); ?>">
                                <div class="visual">
                                    <i class="fa fa-building-o"></i>
                                </div>
                                <div class="details">
                                    <div class="number">
                                        <span data-counter="counterup" data-value="<?php echo e($data['totalOrdersCount']); ?>"><?php echo e($data['totalOrdersCount']); ?></span>
                                    </div>
                                    <div class="desc"><?php echo e(__('apps::dashboard.index.statistics.orders')); ?></div>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 mb-25">
                            <a class="dashboard-stat dashboard-stat-v2 orange"  href="<?php echo e(url(route('dashboard.orders.active_orders'))); ?>">
                                <div class="visual">
                                    <i class="fa fa-building-o"></i>
                                </div>
                                <div class="details">
                                    <div class="number">
                                        <span data-counter="counterup" data-value="<?php echo e($data['activeOrdersCount']); ?>"><?php echo e($data['activeOrdersCount']); ?></span>
                                    </div>
                                    <div class="desc"><?php echo e(__('apps::dashboard.index.statistics.active_orders')); ?></div>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 mb-25">
                            <a class="dashboard-stat dashboard-stat-v2 green"  href="<?php echo e(url(route('dashboard.orders.incomplete_orders'))); ?>">
                                <div class="visual">
                                    <i class="fa fa-building-o"></i>
                                </div>
                                <div class="details">
                                    <div class="number">
                                        <span data-counter="counterup" data-value="<?php echo e($data['supportOrdersCount']); ?>"><?php echo e($data['supportOrdersCount']); ?></span>
                                    </div>
                                    <div class="desc"><?php echo e(__('apps::dashboard.index.statistics.support_orders')); ?></div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $code => $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if(collect(Request::get('country_id') ?? setting('supported_countries'))->contains($country->id)): ?>
                        <div class="row">
                            <div class="portlet light bordered col-lg-12">
                                <div class="portlet-header" style="margin-bottom: 25px">
                                    <h3><?php echo e(__('apps::dashboard.index.statistics.country_statistics',['country' => $country->title])); ?></h3>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 mb-25">
                                    <a class="dashboard-stat dashboard-stat-v2 yellow" href="<?php echo e(url(route('dashboard.orders.index'))); ?>">
                                        <div class="visual">
                                            <i class="fa fa-building-o"></i>
                                        </div>
                                        <div class="details">
                                            <div class="number">
                                                <span data-counter="counterup" data-value="<?php echo e($data['countries'][$country->id]['totalOrdersCount']); ?>"><?php echo e($data['countries'][$country->id]['totalOrdersCount']); ?></span>
                                            </div>
                                            <div class="desc"><?php echo e(__('apps::dashboard.index.statistics.orders')); ?></div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 mb-25">
                                    <a class="dashboard-stat dashboard-stat-v2 orange"  href="<?php echo e(url(route('dashboard.orders.active_orders')).'?country_id='.$country->id); ?>">
                                        <div class="visual">
                                            <i class="fa fa-building-o"></i>
                                        </div>
                                        <div class="details">
                                            <div class="number">
                                                <span data-counter="counterup" data-value="<?php echo e($data['countries'][$country->id]['activeOrdersCount']); ?>"><?php echo e($data['countries'][$country->id]['activeOrdersCount']); ?></span>
                                            </div>
                                            <div class="desc"><?php echo e(__('apps::dashboard.index.statistics.active_orders')); ?></div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 mb-25">
                                    <a class="dashboard-stat dashboard-stat-v2 green"  href="<?php echo e(url(route('dashboard.orders.incomplete_orders')).'?country_id='.$country->id); ?>">
                                        <div class="visual">
                                            <i class="fa fa-building-o"></i>
                                        </div>
                                        <div class="details">
                                            <div class="number">
                                                <span data-counter="counterup" data-value="<?php echo e($data['countries'][$country->id]['supportOrdersCount']); ?>"><?php echo e($data['countries'][$country->id]['supportOrdersCount']); ?></span>
                                            </div>
                                            <div class="desc"><?php echo e(__('apps::dashboard.index.statistics.support_orders')); ?></div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 mb-25">
                                    <a class="dashboard-stat dashboard-stat-v2 blue" href="<?php echo e(url(route('dashboard.reports.payments')).'?country_id='.$country->id); ?>">
                                        <div class="visual">
                                            <i class="fa fa-building-o"></i>
                                        </div>
                                        <div class="details">
                                            <div class="number">
                                                <span data-counter="counterup" data-value="<?php echo e($data['countries'][$country->id]['income']); ?>"><?php echo e($data['countries'][$country->id]['income']); ?></span>
                                            </div>
                                            <div class="desc"><?php echo e(__('apps::dashboard.index.statistics.totals') . " ( " . $data['countries'][$country->id]['currency'] . " ) "); ?></div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <hr  style="margin: 0">
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="portlet light portlet-fit bordered">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class=" icon-layers font-green"></i>
                                    <span class="caption-subject font-green bold uppercase">
                                <?php echo e(__('apps::dashboard.home.statistics.title')); ?>

                            </span>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <div class="mt-element-card mt-card-round mt-element-overlay">
                                    <div class="row">
                                        <div class="general-item-list">

                                            <div class="col-md-6">
                                                <b class="page-title">
                                                    <?php echo e(__('apps::dashboard.home.statistics.users_created_at')); ?>

                                                </b>
                                                <canvas id="myChart2" width="540" height="270"></canvas>
                                            </div>

                                            <div class="col-md-6">
                                                <b class="page-title">
                                                    <?php echo e(__('apps::dashboard.home.statistics.orders_monthly')); ?>

                                                </b>
                                                <canvas id="monthlyOrders" width="540" height="270"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
    <?php echo $__env->make('apps::dashboard.layouts._js', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js"></script>

    <script>
        // USERS COUNT BY DATE
        var ctx = document.getElementById("myChart2").getContext('2d');
        var labels = <?php echo $data['userCreated']['userDate']; ?>;
        var countDate = <?php echo $data['userCreated']['countDate']; ?>;
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: '<?php echo e(__('apps::dashboard.home.statistics.users_created_at')); ?>',
                    data: countDate,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54 , 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75 , 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255,99,132,1)',
                        'rgba(54 , 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75 , 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });


        var ctx = document.getElementById("monthlyOrders");
        var labels = <?php echo $data['monthlyOrders']['orders_dates']; ?>;
        var count = <?php echo $data['monthlyOrders']['profits']; ?>;
        var data = {
            labels: labels,
            datasets: [{
                label: "<?php echo e(__('apps::dashboard.home.statistics.orders_monthly')); ?>",
                fill: false,
                lineTension: 0.1,
                backgroundColor: "#36A2EB",
                borderColor: "#36A2EB",
                borderCapStyle: 'butt',
                borderDash: [],
                borderDashOffset: 0.0,
                borderJoinStyle: 'miter',
                pointBorderColor: "#36A2EB",
                pointBackgroundColor: "#fff",
                pointBorderWidth: 1,
                pointHoverRadius: 5,
                pointHoverBackgroundColor: "#36A2EB",
                pointHoverBorderColor: "#FFCE56",
                pointHoverBorderWidth: 2,
                pointRadius: 1,
                pointHitRadius: 10,
                data: count,
                spanGaps: false,
            }]
        };
        var myLineChart = new Chart(ctx, {
            type: 'line',
            label: labels,
            data: data,
            options: {
                animation: {
                    animateScale: true
                }
            }
        });


    </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('apps::dashboard.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/ahmed-nabil94/Desktop/PhpstormProjects/RoyalCard-Backend/Modules/Apps/Resources/views/dashboard/index.blade.php ENDPATH**/ ?>