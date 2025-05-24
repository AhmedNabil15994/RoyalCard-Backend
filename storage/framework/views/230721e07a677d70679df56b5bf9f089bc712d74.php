<?php $__env->startSection('title', __('order::dashboard.orders.index.title')); ?>
<?php $__env->startSection('content'); ?>
<div class="page-content-wrapper">
    <div class="page-content">
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <a href="<?php echo e(url(route('dashboard.home'))); ?>"><?php echo e(__('apps::dashboard.index.title')); ?></a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <a href="#"><?php echo e(__('order::dashboard.orders.index.title')); ?></a>
                </li>
            </ul>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="portlet light bordered">

                    
                    <div class="row">
                        <div class="portlet box grey-cascade">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="fa fa-gift"></i>
                                    <?php echo e(__('apps::dashboard.datatable.search')); ?>

                                </div>
                                <div class="tools">
                                    <a href="javascript:;"
                                        class="collapse"
                                        data-original-title=""
                                        title=""> </a>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <div id="filter_data_table">
                                    <div class="panel-body">
                                        <form id="formFilter"
                                            class="horizontal-form">
                                            <div class="form-body">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="control-label">
                                                                <?php echo e(__('apps::dashboard.datatable.form.date_range')); ?>

                                                            </label>
                                                            <div id="reportrange"
                                                                class="btn default form-control">
                                                                <i class="fa fa-calendar"></i> &nbsp;
                                                                <span> </span>
                                                                <b class="fa fa-angle-down"></b>
                                                                <input type="hidden"
                                                                    name="from">
                                                                <input type="hidden"
                                                                    name="to">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="control-label">
                                                                <?php echo e(__('order::dashboard.orders.datatable.email')); ?>

                                                            </label>
                                                            <input type="email" name="email" placeholder="<?php echo e(__('order::dashboard.orders.datatable.email')); ?>" value="<?php echo e(old('email')); ?>" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="control-label">
                                                                <?php echo e(__('order::dashboard.orders.datatable.mobile')); ?>

                                                            </label>
                                                            <input type="text" name="mobile" placeholder="<?php echo e(__('order::dashboard.orders.datatable.mobile')); ?>" value="<?php echo e(old('mobile')); ?>" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="control-label">
                                                                <?php echo e(__('order::dashboard.orders.datatable.status')); ?>

                                                            </label>
                                                            <select name="status_id"
                                                                id="single"
                                                                class="form-control">
                                                                <option value="">
                                                                    <?php echo e(__('apps::dashboard.datatable.form.select')); ?>

                                                                </option>
                                                                <?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <option value="<?php echo e($status['id']); ?>"
                                                                    <?php if(request('status_id')==$status['id']): ?>
                                                                    selected
                                                                    <?php endif; ?>>
                                                                    <?php echo e($status->title); ?>

                                                                </option>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="control-label">
                                                                <?php echo e(__('order::dashboard.orders.datatable.country')); ?>

                                                            </label>
                                                            <select name="country_id"
                                                                    id="single"
                                                                    class="form-control select2">
                                                                <option value="">
                                                                    <?php echo e(__('apps::dashboard.datatable.form.select')); ?>

                                                                </option>
                                                                <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $code => $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                    <?php if(collect(setting('supported_countries'))->contains($country->id)): ?>
                                                                        <option value="<?php echo e($country->id); ?>"><?php echo e($country->title); ?></option>
                                                                    <?php endif; ?>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                        <div class="form-actions">
                                            <button class="btn btn-sm green btn-outline filter-submit margin-bottom"
                                                id="search">
                                                <i class="fa fa-search"></i>
                                                <?php echo e(__('apps::dashboard.datatable.search')); ?>

                                            </button>
                                            <button class="btn btn-sm red btn-outline filter-cancel">
                                                <i class="fa fa-times"></i>
                                                <?php echo e(__('apps::dashboard.datatable.reset')); ?>

                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    

                    <div class="portlet-title">
                        <div class="caption font-dark">
                            <i class="icon-settings font-dark"></i>
                            <span class="caption-subject bold uppercase">
                                <?php echo e(__('order::dashboard.orders.index.title')); ?>

                            </span>
                        </div>
                    </div>

                    
                    <div class="portlet-body">
                        <table class="table table-striped table-bordered table-hover"
                            id="dataTable">
                            <thead>
                                <tr>
                                    <th>
                                        <a href="javascript:;"
                                            onclick="CheckAll()">
                                            <?php echo e(__('apps::dashboard.buttons.select_all')); ?>

                                        </a>
                                    </th>
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
                        </table>
                    </div>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete_bulk_orders')): ?>
                    <div class="row">
                        <div class="form-group">
                            <button type="submit"
                                id="deleteChecked"
                                class="btn red btn-sm"
                                onclick="deleteAllChecked('<?php echo e(url(route('dashboard.orders.deletes'))); ?>')">
                                <?php echo e(__('apps::dashboard.datatable.delete_all_btn')); ?>

                            </button>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>

<script>
    function tableGenerate(data = '') {

        var dataTable =
            $('#dataTable').DataTable({
                ajax: {
                    url: "<?php echo e(url(route('dashboard.orders.datatable'))."?country_id=".request()->country_id); ?>",
                    type: "GET",
                    data: {
                        req: data,
                    },
                },
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.10.16/i18n/<?php echo e(ucfirst(LaravelLocalization::getCurrentLocaleName())); ?>.json"
                },
                stateSave: true,
                processing: true,
                serverSide: true,
                responsive: !0,
                order: [
                    [1, "desc"]
                ],
                columns: [
                    {
                        data: 'id',className: 'dt-center'
                    },
                    {
                        data: 'id',className: 'dt-center'
                    },
                    {
                        data: 'username',className: 'dt-center'
                    },
                    {
                        data: 'mobile',className: 'dt-center'
                    },
                    {
                        data: 'email',className: 'dt-center'
                    },
                    {
                        data: 'total',className: 'dt-center'
                    },
                    {
                        data: 'country',className: 'dt-center'
                    },
                    {
                        data: 'order_status_id',className: 'dt-center'
                    },
                    {
                        data: 'created_at',className: 'dt-center'
                    },
                    {
                        data: 'id',responsivePriority: 1
                    },
                ],
                columnDefs: [
                    {
                        targets: 0,
                        width: '30px',
                        className: 'dt-center',
                        orderable: false,
                        render: function(data, type, full, meta) {
                            return `<label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                          <input type="checkbox" value="` + data + ` class="group-checkable" name="ids">
                          <span></span>
                        </label>
                      `;
                        },
                    },
                    {
                        targets: -1,
responsivePriority:1,
                        width: '13%',
                        title: '<?php echo e(__('order::dashboard.orders.datatable.options')); ?>',
                        className: 'dt-center',
                        orderable: false,
                        render: function(data, type, full, meta) {

                            // Show
                            var showUrl = '<?php echo e(route("dashboard.orders.show", ":id")); ?>';
                            showUrl = showUrl.replace(':id', data);

                            return `
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('show_orders')): ?>
          						<a href="` + showUrl + `" class="btn btn-sm btn-warning" title="Show">
          			              <i class="fa fa-eye"></i>
          			            </a>
		                    <?php endif; ?>`;

                        },
                    },
                ],
                dom: 'Bfrtip',
                lengthMenu: [
                    [10, 25, 50, 100, 500],
                    ['10', '25', '50', '100', '500']
                ],
                buttons: [{
                        extend: "pageLength",
                        className: "btn blue btn-outline",
                        text: "<?php echo e(__('apps::dashboard.datatable.pageLength')); ?>",
                        exportOptions: {
                            stripHtml: false,
                            columns: ':visible',
                            columns: [1, 2, 3, 4, 5]
                        }
                    },
                    {
                        extend: "print",
                        className: "btn blue btn-outline",
                        text: "<?php echo e(__('apps::dashboard.datatable.print')); ?>",
                        exportOptions: {
                            stripHtml: false,
                            columns: ':visible',
                            columns: [1, 2, 3, 4, 5]
                        }
                    },
                    {
                        extend: "pdf",
                        className: "btn blue btn-outline",
                        text: "<?php echo e(__('apps::dashboard.datatable.pdf')); ?>",
                        exportOptions: {
                            stripHtml: false,
                            columns: ':visible',
                            columns: [1, 2, 3, 4, 5]
                        }
                    },
                    {
                        extend: "excel",
                        className: "btn blue btn-outline ",
                        text: "<?php echo e(__('apps::dashboard.datatable.excel')); ?>",
                        exportOptions: {
                            stripHtml: false,
                            columns: ':visible',
                            columns: [1, 2, 3, 4, 5]
                        }
                    },
                    {
                        extend: "colvis",
                        className: "btn blue btn-outline",
                        text: "<?php echo e(__('apps::dashboard.datatable.colvis')); ?>",
                        exportOptions: {
                            stripHtml: false,
                            columns: ':visible',
                            columns: [1, 2, 3, 4, 5]
                        }
                    }
                ]
            });
    }

    jQuery(document).ready(function() {
        tableGenerate();
    });
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('apps::dashboard.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/ahmed-nabil94/Desktop/PhpstormProjects/RoyalCard-Backend/Modules/Order/Resources/views/dashboard/orders/index.blade.php ENDPATH**/ ?>