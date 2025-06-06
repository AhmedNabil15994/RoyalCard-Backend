
<!--[if lt IE 9]>
<script src="{{asset('/admin/assets/global/plugins/respond.min.js')}}"></script>
<script src="{{asset('/admin/assets/global/plugins/excanvas.min.js')}}"></script>
<script src="{{asset('/admin/assets/global/plugins/ie8.fix.min.js')}}"></script>
<![endif]-->
<script src="{{asset('/admin/assets/global/plugins/jquery.min.js')}}" type="text/javascript"></script>
<script src="{{asset('/admin/assets/global/plugins/bootstrap/js/bootstrap.min.js')}}" type="text/javascript"></script>
<script src="{{asset('/admin/assets/global/plugins/js.cookie.min.js')}}" type="text/javascript"></script>
<script src="{{asset('/admin/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js')}}" type="text/javascript"></script>
<script src="{{asset('/admin/assets/global/plugins/jquery.blockui.min.js')}}" type="text/javascript"></script>
<script src="{{asset('/admin/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js')}}" type="text/javascript"></script>
<script src="{{asset('/admin/assets/global/scripts/datatable.js')}}" type="text/javascript"></script>
<script src="{{asset('/admin/assets/global/plugins/datatables/datatables.min.js')}}" type="text/javascript"></script>
<script src="{{asset('/admin/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js')}}" type="text/javascript"></script>
<script src="{{asset('/admin/assets/global/plugins/select2/js/select2.full.min.js')}}"></script>
<script src="{{asset('/admin/assets/global/plugins/moment.min.js')}}" type="text/javascript"></script>
<script src="{{asset('/admin/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js')}}" type="text/javascript"></script>
<script src="{{asset('/admin/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}" type="text/javascript"></script>
<script src="{{asset('/admin/assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js')}}" type="text/javascript"></script>
<script src="{{asset('/admin/assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js')}}" type="text/javascript"></script>
<script src="{{asset('/admin/assets/global/plugins/morris/morris.min.js')}}" type="text/javascript"></script>
<script src="{{asset('/admin/assets/global/plugins/counterup/jquery.waypoints.min.js')}}" type="text/javascript"></script>
<script src="{{asset('/admin/assets/global/plugins/counterup/jquery.counterup.min.js')}}" type="text/javascript"></script>
<script src="{{asset('/admin/assets/global/plugins/jqvmap/jqvmap/data/jquery.vmap.sampledata.js')}}" type="text/javascript"></script>
<script src="{{asset('/admin/assets/global/plugins/cubeportfolio/js/jquery.cubeportfolio.min.js')}}" type="text/javascript"></script>
<script src="{{asset('/admin/assets/global/scripts/app.min.js')}}" type="text/javascript"></script>
<script src="{{asset('/admin/assets/pages/scripts/components-date-time-pickers.min.js')}}" type="text/javascript"></script>
<script src="{{asset('/admin/assets/pages/scripts/portfolio-1.min.js')}}" type="text/javascript"></script>
<script src="{{asset('/admin/assets/pages/scripts/components-select2.min.js')}}" type="text/javascript"></script>
<script src="{{asset('/admin/assets/pages/scripts/dashboard.min.js')}}" type="text/javascript"></script>
<script src="{{asset('/admin/assets/layouts/layout/scripts/layout.min.js')}}" type="text/javascript"></script>
<script src="{{asset('/admin/assets/layouts/layout/scripts/demo.min.js')}}" type="text/javascript"></script>
<script src="{{asset('/admin/assets/layouts/global/scripts/quick-sidebar.min.js')}}" type="text/javascript"></script>
<script src="{{asset('/admin/assets/layouts/global/scripts/quick-nav.min.js')}}" type="text/javascript"></script>

<script src="{{asset('ckeditor5/js/ckeditor.js')}}"></script>
<script src="{{asset('ckeditor5/js/ckEditorScripts.js')}}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.4.0/bootbox.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="{{asset('/admin/js/actions.js')}}" type="text/javascript"></script>
{{-- <script src="//cdn.ckeditor.com/4.6.2/full/ckeditor.js"></script> --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/4.9.5/tinymce.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/jstree.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/emojionearea/3.4.1/emojionearea.min.js"></script>
<script src="{{ url('admin/assets/global/plugins/jquery-nestable/jquery.nestable.js') }}"></script>
{{-- <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.js"></script> --}}
<script src="{{asset('/admin/js/customtiny.js')}}" type="text/javascript"></script>
@stack('start_scripts')
@yield('scripts')
<script>
    @if($errors->all())
        @foreach($errors->all() as $error)
        toastr["error"]("{{$error}}");
    @endforeach
        @endif

        @if(session('msg'))
        toastr['success']("{{session('msg')}}")
    @endif
  // DELETE ROW FROM DATATABLE
  function deleteRow(url)
  {
    var _token  = $('input[name=_token]').val();

    bootbox.confirm({
      message: '{{__('apps::dashboard.messages.delete')}}',
      buttons: {
        confirm: {
          label: '{{__('apps::dashboard.buttons.yes')}}',
          className: 'btn-success'
        },
        cancel: {
          label: '{{__('apps::dashboard.buttons.no')}}',
          className: 'btn-danger'
        }
      },

      callback: function (result) {
        if(result){

          $.ajax({
            method  : 'DELETE',
            url     : url,
            data    : {
              _token  : _token
            },
            success: function(msg) {
              toastr["success"](msg[1]);
              $('#dataTable').DataTable().ajax.reload();
            },
            error: function( msg ) {
              toastr["error"](msg[1]);
              $('#dataTable').DataTable().ajax.reload();
            }
          });

        }
      }
    });
  }

  // DELETE ROW FROM DATATABLE
  function deleteAllChecked(url)
  {
    var someObj = {};
    someObj.fruitsGranted = [];

    $("input:checkbox").each(function(){
      var $this = $(this);

      if($this.is(":checked")){
        someObj.fruitsGranted.push($this.attr("value"));
      }
    });

    var ids = someObj.fruitsGranted;

    bootbox.confirm({
      message: '{{__('apps::dashboard.messages.delete_all')}}',
      buttons: {
        confirm: {
          label: '{{__('apps::dashboard.buttons.yes')}}',
          className: 'btn-success'
        },
        cancel: {
          label: '{{__('apps::dashboard.buttons.no')}}',
          className: 'btn-danger'
        }
      },

      callback: function (result) {
        if(result){

          $.ajax({
            type    : "GET",
            url     : url,
            data    : {
              ids     : ids,
            },
            success: function(msg) {

              if (msg[0] == true){
                toastr["success"](msg[1]);
                $('#dataTable').DataTable().ajax.reload();
              }
              else{
                toastr["error"](msg[1]);
              }

            },
            error: function( msg ) {
              toastr["error"](msg[1]);
              $('#dataTable').DataTable().ajax.reload();
            }
          });

        }
      }
    });
  }
</script>

<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>

<script>
    var audioAlert = new Audio('{{ url('uploads/media/doorbell-5.mp3') }}');

    var pusher = new Pusher('{{env('PUSHER_APP_KEY')}}', {
        cluster: '{{env('PUSHER_APP_CLUSTER')}}',
        forceTLS: true
    });

    pusher.subscribe('{{ config('core.config.constants.DASHBOARD_CHANNEL') }}').bind('{{ config('core.config.constants.DASHBOARD_ACTIVITY_LOG') }}', function (data) {
        if (data.type === 'order') {
            openActivity(data.order);
        }
    });

    function playSound() {
        audioAlert.loop = false;
        audioAlert.play();
    }

    function stopSound() {
        audioAlert.pause();
        audioAlert.currentTime = 0;
    }

    function openActivity(response) {
        playSound();
        var showUrl = "{{route('dashboard.orders.show',['id'=>':id'])}}".replace(':id',response.id);
        swal({
            title: "{{__('apps::dashboard.new_support_order',['id'=>':id'])}}".replace(':id' , response.id),
            icon: "success",
            buttons: true,
            dangerMode: true,
        }).then((done) => {
            if (done) {
                window.location.href = showUrl;
            }
            stopSound();
        });
    }

</script>
<script>

    $(document).ready(function()
    {
        var start;
        var end;

        @if(request()->has('from'))
            start = moment("{{request()->get('from')}}")
        @endif

            @if(request()->has('to'))
            end = moment("{{request()->get('to')}}")
        @endif

        function cb(start, end) {


            if ((isNaN(start) && isNaN(end)) || (start == null && end == null)) {

                $('#reportrange span').html('{{__('apps::dashboard.buttons.datapicker.all')}}');
                $('input[name="from"]').val('');
                $('input[name="to"]').val('');

            } else if (start.isValid() && end.isValid()) {

                $('#reportrange span').html(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
                $('input[name="from"]').val(start.format('YYYY-MM-DD'));
                $('input[name="to"]').val(end.format('YYYY-MM-DD'));
            }
        }

        $('#reportrange').daterangepicker({
            startDate: start,
            endDate: end,
            ranges: {
                '{{__('apps::dashboard.buttons.datapicker.all')}}': [NaN, NaN],
                '{{__('apps::dashboard.buttons.datapicker.today')}}'         : [moment(), moment()],
                '{{__('apps::dashboard.buttons.datapicker.yesterday')}}'     : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                '{{__('apps::dashboard.buttons.datapicker.7days')}}'         : [moment().subtract(6, 'days'), moment()],
                '{{__('apps::dashboard.buttons.datapicker.30days')}}'        : [moment().subtract(29, 'days'), moment()],
                '{{__('apps::dashboard.buttons.datapicker.month')}}'         : [moment().startOf('month'), moment().endOf('month')],
                '{{__('apps::dashboard.buttons.datapicker.last_month')}}'    : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
            },
            @if (is_rtl() == 'rtl')
            opens: 'left',
            @endif
            buttonClasses	 : ['btn'],
            applyClass	   : 'btn-primary',
            cancelClass	   : 'btn-danger',
            format 		     : 'YYYY-MM-DD',
            separator		   : 'to',
            locale: {
                applyLabel		    : '{{__('apps::dashboard.buttons.save')}}',
                cancelLabel		    : '{{__('apps::dashboard.buttons.cancel')}}',
                fromLabel			    : '{{__('apps::dashboard.buttons.from')}}',
                toLabel			      : '{{__('apps::dashboard.buttons.to')}}',
                customRangeLabel	: '{{__('apps::dashboard.buttons.custom')}}',
                firstDay: 1
            }
        }, cb);

        cb(start,end);

    });

</script>

@yield("include_scripts")
