<?php $__env->startSection('title', __('notification::dashboard.notifications.routes.index')); ?>
<?php $__env->startSection('content'); ?>
    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <a href="<?php echo e(url(route('dashboard.home'))); ?>"><?php echo e(__('apps::dashboard.home.title')); ?></a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <a href="#"><?php echo e(__('notification::dashboard.notifications.routes.index')); ?></a>
                    </li>
                </ul>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="portlet light bordered">

                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('send_notifications')): ?>
                        <div class="table-toolbar">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="btn-group">
                                        <a href="<?php echo e(url(route('dashboard.notifications.create'))); ?>"
                                           class="btn sbold green">
                                            <i class="fa fa-plus"></i> <?php echo e(__('notification::dashboard.notifications.routes.create')); ?>

                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>

                        
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
                                                                    <label class="mt-radio">
                                                                        <?php echo e(__('apps::dashboard.datatable.form.with_deleted')); ?>

                                                                        <input type="radio" value="with"
                                                                               name="deleted"/>
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
                                <?php echo e(__('notification::dashboard.notifications.routes.index')); ?>

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
                                    <th><?php echo e(__('notification::dashboard.notifications.datatable.added_by')); ?></th>
                                    <th><?php echo e(__('notification::dashboard.notifications.datatable.title')); ?></th>
                                    <th><?php echo e(__('notification::dashboard.notifications.datatable.body')); ?></th>
                                    <th><?php echo e(__('notification::dashboard.notifications.datatable.type')); ?></th>
                                    <th><?php echo e(__('notification::dashboard.notifications.datatable.send_at')); ?></th>
                                    <th><?php echo e(__('notification::dashboard.notifications.datatable.is_sent')); ?></th>
                                    <th><?php echo e(__('notification::dashboard.notifications.datatable.created_at')); ?></th>
                                    <th><?php echo e(__('notification::dashboard.notifications.datatable.options')); ?></th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                        <div class="row">
                            <div class="form-group">
                                <button type="submit" id="deleteChecked" class="btn red btn-sm"
                                        onclick="deleteAllChecked('<?php echo e(url(route('dashboard.notifications.deletes'))); ?>')">
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
                        url: "<?php echo e(url(route('dashboard.notifications.datatable'))); ?>",
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
                        {data: 'user_id', className: 'dt-center', orderable: false},
                        {data: 'title', className: 'dt-center', orderable: false},
                        {data: 'body', className: 'dt-center', orderable: false},
                        {data: 'model', className: 'dt-center', orderable: false},
                        {data: 'send_at', className: 'dt-center', orderable: false},
                        {data: 'is_sent', className: 'dt-center', orderable: false},
                        {data: 'created_at', className: 'dt-center'},
                        {data: 'id'},
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
                            title: '<?php echo e(__('notification::dashboard.notifications.datatable.options')); ?>',
                            className: 'dt-center',
                            orderable: false,
                            render: function (data, type, full, meta) {

                                // Delete
                                var deleteUrl = '<?php echo e(route("dashboard.notifications.destroy", ":id")); ?>';
                                deleteUrl = deleteUrl.replace(':id', data);

                                return `
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete_notifications')): ?>
                                        <?php echo csrf_field(); ?><a href="javascript:;" onclick="deleteRow('` + deleteUrl + `')" class="btn btn-sm red">
                                            <i class="fa fa-trash"></i>
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
                    buttons: [
                        {
                            extend: "pageLength",
                            className: "btn blue btn-outline",
                            text: "<?php echo e(__('apps::dashboard.datatable.pageLength')); ?>",
                            exportOptions: {
                                stripHtml: false,
                                columns: ':visible',
                                columns: [1, 2, 3, 4, 5, 6]
                            }
                        },
                        {
                            extend: "print",
                            className: "btn blue btn-outline",
                            text: "<?php echo e(__('apps::dashboard.datatable.print')); ?>",
                            exportOptions: {
                                stripHtml: false,
                                columns: ':visible',
                                columns: [1, 2, 3, 4, 5, 6]
                            }
                        },
                        {
                            extend: "pdf",
                            className: "btn blue btn-outline",
                            text: "<?php echo e(__('apps::dashboard.datatable.pdf')); ?>",
                            exportOptions: {
                                stripHtml: false,
                                columns: ':visible',
                                columns: [1, 2, 3, 4, 5, 6]
                            }
                        },
                        {
                            extend: "excel",
                            className: "btn blue btn-outline ",
                            text: "<?php echo e(__('apps::dashboard.datatable.excel')); ?>",
                            exportOptions: {
                                stripHtml: false,
                                columns: ':visible',
                                columns: [1, 2, 3, 4, 5, 6]
                            }
                        },
                        {
                            extend: "colvis",
                            className: "btn blue btn-outline",
                            text: "<?php echo e(__('apps::dashboard.datatable.colvis')); ?>",
                            exportOptions: {
                                stripHtml: false,
                                columns: ':visible',
                                columns: [1, 2, 3, 4, 5, 6]
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

<?php echo $__env->make('apps::dashboard.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/ahmed-nabil94/Desktop/PhpstormProjects/RoyalCard-Backend/Modules/Notification/Resources/views/dashboard/notifications/index.blade.php ENDPATH**/ ?>