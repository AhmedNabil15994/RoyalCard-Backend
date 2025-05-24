@extends('apps::dashboard.layouts.app')
@section('title', __('order::dashboard.reports.payments.title'))
@section('content')
<div class="page-content-wrapper">
    <div class="page-content">
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <a href="{{ url(route('dashboard.home')) }}">{{ __('apps::dashboard.index.title') }}</a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <a href="#">{{__('order::dashboard.reports.payments.title')}}</a>
                </li>
            </ul>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="portlet light bordered">

                    {{-- DATATABLE FILTER --}}
                    <div class="row">
                        <div class="portlet box grey-cascade">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="fa fa-gift"></i>
                                    {{__('apps::dashboard.datatable.search')}}
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
                                                                {{__('apps::dashboard.datatable.form.date_range')}}
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
                                                                {{__('order::dashboard.orders.datatable.products')}}
                                                            </label>
                                                            <select name="product_id"
                                                                    id="single"
                                                                    class="form-control select2">
                                                                <option value="">
                                                                    {{__('apps::dashboard.datatable.form.select')}}
                                                                </option>
                                                                @inject('products','Modules\Catalog\Entities\Product')
                                                                @foreach ($products->orderBY('id','desc')->get() as $product)
                                                                    <option value="{{ $product->id }}"
                                                                            @if(request('product_id')== $product->id)
                                                                                selected
                                                                        @endif>
                                                                        {{ $product->title }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="control-label">
                                                                {{__('order::dashboard.orders.datatable.country')}}
                                                            </label>
                                                            <select name="country_id"
                                                                    id="single"
                                                                    class="form-control select2">
                                                                <option value="">
                                                                    {{__('apps::dashboard.datatable.form.select')}}
                                                                </option>
                                                                @foreach ($countries as $code => $country)
                                                                    @if (collect(setting('supported_countries'))->contains($country->id))
                                                                        <option value="{{ $country->id }}">{{ $country->title }}</option>
                                                                    @endif
                                                                @endforeach
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
                                                {{__('apps::dashboard.datatable.search')}}
                                            </button>
                                            <button class="btn btn-sm red btn-outline filter-cancel">
                                                <i class="fa fa-times"></i>
                                                {{__('apps::dashboard.datatable.reset')}}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- END DATATABLE FILTER --}}

                    <div class="portlet-title">
                        <div class="caption font-dark">
                            <i class="icon-settings font-dark"></i>
                            <span class="caption-subject bold uppercase">
                                {{__('order::dashboard.reports.payments.title')}}
                            </span>
                        </div>
                    </div>

                    {{-- DATATABLE CONTENT --}}
                    <div class="portlet-body">
                        <table class="table table-striped table-bordered table-hover"
                            id="dataTable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{__('order::dashboard.orders.datatable.product')}}</th>
                                    <th>{{__('catalog::dashboard.products.datatable.categories')}}</th>
                                    <th>{{__('catalog::dashboard.products.form.type')}}</th>
                                    @foreach ($countries as $code => $country)
                                        @if (collect(Request::get('country_id') ?? setting('default_country'))->contains($country->id))
                                            <th>{{__('catalog::dashboard.products.form.price')}} <span class="currency"> ({{$country->currency->code}}) </span></th>
                                            <th>{{__('catalog::dashboard.products.form.qty')}}</th>
                                            <th>{{__('order::dashboard.reports.datatable.total_before_discount')}} <span class="currency"> ({{$country->currency->code}}) </span></th>
                                            <th>{{__('order::dashboard.reports.datatable.discount')}} <span class="currency"> ({{$country->currency->code}}) </span></th>
                                            <th>{{__('order::dashboard.reports.datatable.tax')}} <span class="currency"> ({{$country->currency->code}}) </span></th>
                                            <th>{{__('order::dashboard.reports.datatable.profit')}} <span class="currency"> ({{$country->currency->code}}) </span></th>
                                            <th>{{__('order::dashboard.reports.datatable.totals')}} <span class="currency"> ({{$country->currency->code}}) </span></th>
                                        @endif
                                    @endforeach

                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('scripts')
@include('apps::dashboard.layouts._js')
<script>
    let columns = [
        {
            data: 'id',className: 'dt-center'
        },
        {
            data: 'title',className: 'dt-center'
        },
        {
            data: 'categories',className: 'dt-center'
        },
        {
            data: 'type',className: 'dt-center'
        },
        {
            data: 'price',className: 'dt-center'
        },
        {
            data: 'qty',className: 'dt-center'
        },
        {
            data: 'total_before_discount',className: 'dt-center'
        },
        {
            data: 'discount',className: 'dt-center'
        },
        {
            data: 'tax',className: 'dt-center'
        },
        {
            data: 'profit',className: 'dt-center'
        },
        {
            data: 'totals',className: 'dt-center'
        },
    ]

    function tableGenerate(data = []) {
        var dataTable =
            $('#dataTable').DataTable({
                ajax: {
                    url: "{{ url(route('dashboard.reports.payments_datatable'))."?country_id=".request()->country_id }}",
                    type: "GET",
                    data: {
                        req: data,
                    },
                },
                "drawCallback": function( settings ) {
                    var api = this.api();
                    let currency;
                    if(api.rows( {page:'current'} ).data()[0]){
                        currency = api.rows( {page:'current'} ).data()[0].currency;
                        $('span.currency').empty().html(" ("+currency+") ");
                    }
                },
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.10.16/i18n/{{ucfirst(LaravelLocalization::getCurrentLocaleName())}}.json"
                },
                stateSave: true,
                processing: true,
                serverSide: true,
                responsive: !0,
                order: [
                    [1, "desc"]
                ],
                columns: columns,
                columnDefs: [
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
                        text: "{{__('apps::dashboard.datatable.pageLength')}}",
                        exportOptions: {
                            stripHtml: false,
                            columns: ':visible',
                            columns: [1, 2, 3, 4, 5]
                        }
                    },
                    {
                        extend: "print",
                        className: "btn blue btn-outline",
                        text: "{{__('apps::dashboard.datatable.print')}}",
                        exportOptions: {
                            stripHtml: false,
                            columns: ':visible',
                            columns: [1, 2, 3, 4, 5]
                        }
                    },
                    {
                        extend: "pdf",
                        className: "btn blue btn-outline",
                        text: "{{__('apps::dashboard.datatable.pdf')}}",
                        exportOptions: {
                            stripHtml: false,
                            columns: ':visible',
                            columns: [1, 2, 3, 4, 5]
                        }
                    },
                    {
                        extend: "excel",
                        className: "btn blue btn-outline ",
                        text: "{{__('apps::dashboard.datatable.excel')}}",
                        exportOptions: {
                            stripHtml: false,
                            columns: ':visible',
                            columns: [1, 2, 3, 4, 5]
                        }
                    },
                    {
                        extend: "colvis",
                        className: "btn blue btn-outline",
                        text: "{{__('apps::dashboard.datatable.colvis')}}",
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

@stop
