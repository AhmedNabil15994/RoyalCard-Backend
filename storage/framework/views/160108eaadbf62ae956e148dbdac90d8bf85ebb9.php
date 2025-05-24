<?php $__env->startSection('title', __('user::dashboard.users.update.form.wallets_transactions')); ?>
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
                    <a href="#"><?php echo e(__('user::dashboard.users.update.form.wallets_transactions')); ?></a>
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
                                                                <?php echo e(__('user::dashboard.users.datatable.clients')); ?>

                                                            </label>
                                                            <select name="user_id"
                                                                    id="single"
                                                                    class="form-control select2">
                                                                <option value="">
                                                                    <?php echo e(__('apps::dashboard.datatable.form.select')); ?>

                                                                </option>
                                                                <?php $__currentLoopData = $clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                    <option value="<?php echo e($client->id); ?>"
                                                                            <?php if(request('user_id')==$client->id): ?>
                                                                                selected
                                                                        <?php endif; ?>>
                                                                        <?php echo e($client->name . "\r\n" . $client->mobile); ?>

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
                                <?php echo e(__('user::dashboard.users.update.form.wallets_transactions')); ?>

                            </span>
                        </div>
                    </div>

                    
                    <div class="portlet-body">
                        <table class="table table-striped table-bordered table-hover"
                            id="dataTable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th><?php echo e(__('user::dashboard.users.datatable.name')); ?></th>
                                    <th><?php echo e(__('transaction::dashboard.transactions.datatable.payment_id')); ?></th>
                                    <th><?php echo e(__('transaction::dashboard.transactions.datatable.method')); ?></th>
                                    <th><?php echo e(__('transaction::dashboard.transactions.datatable.result')); ?></th>
                                    <th><?php echo e(__('transaction::dashboard.transactions.datatable.track_id')); ?></th>
                                    <th><?php echo e(__('catalog::dashboard.brands.datatable.description')); ?></th>
                                    <th><?php echo e(__('transaction::dashboard.transactions.datatable.ref')); ?></th>
                                    <th><?php echo e(__('order::dashboard.orders.datatable.total')); ?></th>
                                    <th><?php echo e(__('order::dashboard.orders.datatable.country')); ?></th>
                                    <th><?php echo e(__('transaction::dashboard.transactions.datatable.created_at')); ?></th>
                                    <th><?php echo e(__('transaction::dashboard.transactions.datatable.options')); ?></th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>

<script>
    function tableGenerate(data='') {

      var dataTable =
      $('#dataTable').DataTable({
          "createdRow": function( row, data, dataIndex ) {
             if ( data["deleted_at"] != null ) {
                $(row).addClass('danger');
             }
          },
          ajax : {
              url   : "<?php echo e(url(route('dashboard.wallets.transactions_datatable'))); ?>",
              type  : "GET",
              data  : {
                  req : data,
              },
          },
          language: {
              url:"//cdn.datatables.net/plug-ins/1.10.16/i18n/<?php echo e(ucfirst(LaravelLocalization::getCurrentLocaleName())); ?>.json"
          },
          stateSave: true,
          processing: true,
          serverSide: true,
          responsive: !0,
          order     : [[ 0 , "desc" ]],
          columns: [
      			{data: 'id' 		 	        , className: 'dt-center'},
      			{data: 'user_id' 			      , className: 'dt-center', orderable: false},
                {data: 'payment_id' 			, className: 'dt-center'},
                {data: 'method' 			    , className: 'dt-center'},
                {data: 'result' 			    , className: 'dt-center'},
                {data: 'track_id' 			  , className: 'dt-center'},
                {data: 'description' 			      , className: 'dt-center' , orderable: false},
                {data: 'ref' 			        , className: 'dt-center'},
                {data: 'balance' 			        , className: 'dt-center', orderable: false},
                {data: 'country_id' 			        , className: 'dt-center', orderable: false},
                {data: 'created_at' 		  , className: 'dt-center'},
                {data: 'id',responsivePriority: 1},
      		],
          columnDefs: [
              {
                  targets: -1,
                  responsivePriority: 1,
                  width: '13%',
                  title: '<?php echo e(__('user::dashboard.users.datatable.options')); ?>',
                  className: 'dt-center',
                  orderable: false,
                  render: function(data, type, full, meta) {
                      // Show
                      var showUrl = '<?php echo e(route("dashboard.wallets.transactions.show", ":id")); ?>';
                      showUrl = showUrl.replace(':id', data);

                      return `<a href="`+showUrl+`" class="btn btn-sm yellow" title="Invoice">
                                  <i class="fa fa-file"></i>
                                </a>
                            `;
                  },
              },
          ],
          dom: 'Bfrtip',
          lengthMenu: [
              [ 10, 25, 50 , 100 , 500 ],
              [ '10', '25', '50', '100' , '500']
          ],
          buttons:[
            {
                extend: "pageLength",
              className: "btn blue btn-outline",
              text: "<?php echo e(__('apps::dashboard.datatable.pageLength')); ?>",
              exportOptions: {
                  stripHtml: true,
                  columns: ':visible',
                  columns: [ 1 , 2 , 3 , 4 , 5 , 6]
              }
            },
            {
                extend: "print",
                className: "btn blue btn-outline" ,
                text: "<?php echo e(__('apps::dashboard.datatable.print')); ?>",
                exportOptions: {
                    stripHtml : false,
                    columns: ':visible',
                    columns: [ 1 , 2 , 3 , 4 , 5 , 6]
                }
            },
            {
                extend: "pdf",
                className: "btn blue btn-outline" ,
                text: "<?php echo e(__('apps::dashboard.datatable.pdf')); ?>",
                exportOptions: {
                    stripHtml : false,
                    columns: ':visible',
                    columns: [ 1 , 2 , 3 , 4 , 5 , 6]
                }
            },
            {
                extend: "excel",
                className: "btn blue btn-outline " ,
                text: "<?php echo e(__('apps::dashboard.datatable.excel')); ?>",
                exportOptions: {
                    stripHtml : false,
                    columns: ':visible',
                    columns: [ 1 , 2 , 3 , 4 , 5 , 6]
                }
            },
            {
                extend: "colvis",
                className: "btn blue btn-outline",
                text: "<?php echo e(__('apps::dashboard.datatable.colvis')); ?>",
                exportOptions: {
                    stripHtml : false,
                    columns: ':visible',
                    columns: [ 1 , 2 , 3 , 4 , 5 , 6]
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

<?php echo $__env->make('apps::dashboard.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/ahmed-nabil94/Desktop/PhpstormProjects/RoyalCard-Backend/Modules/User/Resources/views/dashboard/users/wallets_transactions.blade.php ENDPATH**/ ?>