<?php $__env->startSection('title', __('log::dashboard.logs.routes.index')); ?>
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
                        <a href="#"><?php echo e(__('log::dashboard.logs.routes.index')); ?></a>
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
                                        <a href="javascript:;" class="collapse" data-original-title="" title=""> </a>
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    <div id="filter_data_table">
                                        <div class="panel-body">
                                            <form id="formFilter" class="horizontal-form">
                                                <div class="form-body">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label class="control-label">
                                                                    <?php echo e(__('apps::dashboard.datatable.form.date_range')); ?>

                                                                </label>
                                                                <div id="reportrange" class="btn default form-control">
                                                                    <i class="fa fa-calendar"></i> &nbsp;
                                                                    <span> </span>
                                                                    <b class="fa fa-angle-down"></b>
                                                                    <input type="hidden" name="from">
                                                                    <input type="hidden" name="to">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label class="control-label">
                                                                    <?php echo e(__('apps::dashboard.datatable.form.soft_deleted')); ?>

                                                                </label>
                                                                <div class="mt-radio-list">
                                                                    <label class="mt-radio">
                                                                        <?php echo e(__('apps::dashboard.datatable.form.delete_only')); ?>

                                                                        <input type="radio" value="only"
                                                                               name="deleted"/>
                                                                        <span></span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label class="control-label">
                                                                    <?php echo e(__('apps::dashboard.datatable.form.status')); ?>

                                                                </label>
                                                                <div class="mt-radio-list">
                                                                    <label class="mt-radio">
                                                                        <?php echo e(__('apps::dashboard.datatable.form.active')); ?>

                                                                        <input type="radio" value="1" name="status"/>
                                                                        <span></span>
                                                                    </label>
                                                                    <label class="mt-radio">
                                                                        <?php echo e(__('apps::dashboard.datatable.form.unactive')); ?>

                                                                        <input type="radio" value="0" name="status"/>
                                                                        <span></span>
                                                                    </label>
                                                                </div>
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
                                <?php echo e(__('log::dashboard.logs.routes.index')); ?>

                            </span>
                            </div>
                        </div>

                        
                        <div class="portlet-body">
                            <table class="table table-striped table-bordered table-hover" id="dataTable">
                                <thead>
                                <tr>
                                    <th>
                                        <a href="javascript:;" onclick="CheckAll()">
                                            <?php echo e(__('apps::dashboard.buttons.select_all')); ?>

                                        </a>
                                    </th>
                                    <th>#</th>
                                    <th><?php echo e(__('log::dashboard.logs.datatable.title')); ?></th>
                                    <th><?php echo e(__('log::dashboard.logs.datatable.action')); ?></th>
                                    <th><?php echo e(__('log::dashboard.logs.datatable.model')); ?></th>
                                    <th><?php echo e(__('log::dashboard.logs.datatable.user')); ?></th>
                                    <th><?php echo e(__('log::dashboard.logs.datatable.created_at')); ?></th>
                                    <th><?php echo e(__('log::dashboard.logs.datatable.options')); ?></th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                        <div class="row">
                            <div class="form-group">
                                <button type="submit" id="deleteChecked" class="btn red btn-sm"
                                        onclick="deleteAllChecked('<?php echo e(url(route('dashboard.logs-s.deletes'))); ?>')">
                                    <?php echo e(__('apps::dashboard.datatable.delete_all_btn')); ?>

                                </button>
                            </div>
                        </div>
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
                    "createdRow": function (row, data, dataIndex) {
                        if (data["deleted_at"] != null) {
                            $(row).addClass('danger');
                        }
                    },
                    ajax: {
                        url: "<?php echo e(url(route('dashboard.logs-s.datatable'))); ?>",
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
                    order: [[1, "desc"]],
                    columns: [
                        {data: 'id', className: 'dt-center'},
                        {data: 'id', className: 'dt-center'},
                        {data: 'title', className: 'dt-center'},
                        {data: 'action', className: 'dt-center'},
                        {
                            data: "model", className: 'dt-center', orderable: false,
                            render: function (data, type, full, meta) {
                                return '<strong> <?php echo e(__('log::dashboard.logs.datatable.id')); ?> : </strong> ' + data +
                                        '<br>' +
                                        '<strong> <?php echo e(__('log::dashboard.logs.datatable.name')); ?> : </strong> ' + full.model_name
                            }
                        },
                        {
                            data: "user", className: 'dt-center', orderable: false,
                            render: function (data, type, full, meta) {
                                return '<strong> <?php echo e(__('log::dashboard.logs.datatable.id')); ?> : </strong> ' + data.id +
                                        '<br>' +
                                        '<strong> <?php echo e(__('log::dashboard.logs.datatable.name')); ?> : </strong> ' + data.name
                            }
                        },
                        {data: 'created_at', className: 'dt-center'},
                        {data: 'id', responsivePriority: 1},
                    ],
                    columnDefs: [
                        {
                            targets: 0,
                            width: '30px',
                            className: 'dt-center',
                            orderable: false,
                            render: function (data, type, full, meta) {
                                return `<label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                          <input type="checkbox" value="` + data + ` class="group-checkable" name="ids">
                          <span></span>
                        </label>
                      `;
                            },
                        },

                        {
                            targets: -1,
                            width: '13%',
                            title: '<?php echo e(__('log::dashboard.logs.datatable.options')); ?>',
                            className: 'dt-center',
                            orderable: false,
                            render: function (data, type, full, meta) {


                                // Delete
                                var deleteUrl = '<?php echo e(route("dashboard.logs-s.destroy", ":id")); ?>';
                                deleteUrl = deleteUrl.replace(':id', data);

                                return `

                                            <?php echo csrf_field(); ?>
                                            <a href="javascript:;" onclick="deleteRow('` + deleteUrl + `')" class="btn btn-sm red">
                                                <i class="fa fa-trash"></i>
                                            </a>

                                    `;
                            },
                        },
                    ],
                    dom: 'Bfrtip',
                    lengthMenu: [
                        [10, 25, 50, 100, 500],
                        ['10', '25', '50', '100', '500']
                    ],
                    buttons: [
                        {
                            extend: "pageLength", className: "btn blue btn-outline",
                            text: "<?php echo e(__('apps::dashboard.datatable.pageLength')); ?>",
                            exportOptions: {
                                stripHtml: false,
                                columns: ':visible',
                                columns: [1, 2, 3, 4, 5]
                            }
                        },
                        {
                            extend: "print", className: "btn blue btn-outline",
                            text: "<?php echo e(__('apps::dashboard.datatable.print')); ?>",
                            exportOptions: {
                                stripHtml: false,
                                columns: ':visible',
                                columns: [1, 2, 3, 4, 5]
                            }
                        },
                        {
                            extend: "pdf", className: "btn blue btn-outline",
                            text: "<?php echo e(__('apps::dashboard.datatable.pdf')); ?>",
                            exportOptions: {
                                stripHtml: false,
                                columns: ':visible',
                                columns: [1, 2, 3, 4, 5]
                            }
                        },
                        {
                            extend: "excel", className: "btn blue btn-outline ",
                            text: "<?php echo e(__('apps::dashboard.datatable.excel')); ?>",
                            exportOptions: {
                                stripHtml: false,
                                columns: ':visible',
                                columns: [1, 2, 3, 4, 5]
                            }
                        },
                        {
                            extend: "colvis", className: "btn blue btn-outline",
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

        jQuery(document).ready(function () {
            tableGenerate();
        });
    </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('apps::dashboard.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/ahmed-nabil94/Desktop/PhpstormProjects/RoyalCard-Backend/Modules/Log/Resources/views/dashboard/logs/index.blade.php ENDPATH**/ ?>