<?php $__env->startSection('title', __('authorization::dashboard.roles.routes.index')); ?>
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
                        <a href="#"><?php echo e(__('authorization::dashboard.roles.routes.index')); ?></a>
                    </li>
                </ul>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="portlet light bordered">

                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('add_roles')): ?>
                            <div class="table-toolbar">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="btn-group">
                                            <a href="<?php echo e(url(route('dashboard.roles.create'))); ?>"
                                               class="btn sbold green">
                                                <i class="fa fa-plus"></i> <?php echo e(__('apps::dashboard.buttons.add_new')); ?>

                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>

                        <div class="portlet-title">
                            <div class="caption font-dark">
                                <i class="icon-settings font-dark"></i>
                                <span class="caption-subject bold uppercase">
                                <?php echo e(__('authorization::dashboard.roles.routes.index')); ?>

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
                                    <th><?php echo e(__('authorization::dashboard.roles.datatable.title')); ?></th>
                                    <th><?php echo e(__('authorization::dashboard.roles.datatable.name')); ?></th>
                                    <th><?php echo e(__('authorization::dashboard.roles.datatable.created_at')); ?></th>
                                    <th><?php echo e(__('authorization::dashboard.roles.datatable.options')); ?></th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                        <div class="row">
                            <div class="form-group">
                                <button type="submit" id="deleteChecked" class="btn red btn-sm"
                                        onclick="deleteAllChecked('<?php echo e(url(route('dashboard.roles.deletes'))); ?>')">
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
                    ajax: {
                        url: "<?php echo e(url(route('dashboard.roles.datatable'))); ?>",
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
                        {data: 'name', className: 'dt-center'},
                        {data: 'display_name', className: 'dt-center'},
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
                            title: '<?php echo e(__('authorization::dashboard.roles.datatable.options')); ?>',
                            className: 'dt-center',
                            orderable: false,
                            render: function (data, type, full, meta) {

                                // Edit
                                var editUrl = '<?php echo e(route("dashboard.roles.edit", ":id")); ?>';
                                editUrl = editUrl.replace(':id', data);

                                // Delete
                                var deleteUrl = '<?php echo e(route("dashboard.roles.destroy", ":id")); ?>';
                                deleteUrl = deleteUrl.replace(':id', data);

                                return `
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit_roles')): ?>
                                    <a href="` + editUrl + `" class="btn btn-sm blue" title="Edit">
      			              <i class="fa fa-edit"></i>
      			            </a>
      					<?php endif; ?>

                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete_roles')): ?>
                                        <?php echo csrf_field(); ?>
                                    <a href="javascript:;" onclick="deleteRow('` + deleteUrl + `')" class="btn btn-sm red">
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
                                columns: [1, 2, 3, 4]
                            }
                        },
                        {
                            extend: "print",
                            className: "btn blue btn-outline",
                            text: "<?php echo e(__('apps::dashboard.datatable.print')); ?>",
                            exportOptions: {
                                stripHtml: false,
                                columns: ':visible',
                                columns: [1, 2, 3, 4]
                            }
                        },
                        {
                            extend: "pdf",
                            className: "btn blue btn-outline",
                            text: "<?php echo e(__('apps::dashboard.datatable.pdf')); ?>",
                            exportOptions: {
                                stripHtml: false,
                                columns: ':visible',
                                columns: [1, 2, 3, 4]
                            }
                        },
                        {
                            extend: "excel",
                            className: "btn blue btn-outline",
                            text: "<?php echo e(__('apps::dashboard.datatable.excel')); ?>",
                            exportOptions: {
                                stripHtml: false,
                                columns: ':visible',
                                columns: [1, 2, 3, 4]
                            }
                        },
                        {
                            extend: "colvis",
                            className: "btn blue btn-outline",
                            text: "<?php echo e(__('apps::dashboard.datatable.colvis')); ?>",
                            exportOptions: {
                                stripHtml: false,
                                columns: ':visible',
                                columns: [1, 2, 3, 4]
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

<?php echo $__env->make('apps::dashboard.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/ahmed-nabil94/Desktop/PhpstormProjects/RoyalCard-Backend/Modules/Authorization/Resources/views/dashboard/roles/index.blade.php ENDPATH**/ ?>