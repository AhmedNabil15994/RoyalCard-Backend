<?php

namespace Modules\Order\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Core\Traits\DataTable;
use Modules\Order\Repositories\Dashboard\ReportRepository;
use Modules\Order\Transformers\Dashboard\CustomerSalesResource;
use Modules\Order\Transformers\Dashboard\PaymentSalesResource;
use Modules\Order\Transformers\Dashboard\ProductSalesResource;

class ReportController extends Controller
{

    public function __construct(ReportRepository $repository)
    {
        $this->report = $repository;
    }


    public function customers()
    {
        return view('order::dashboard.reports.customers');
    }

    public function customers_datatable(Request $request)
    {
        $datatable = DataTable::drawTable($request, $this->report->QueryCustomers($request));
        $datatable['data'] = CustomerSalesResource::collection($datatable['data']);
        return Response()->json($datatable);
    }

    public function products()
    {
        return view('order::dashboard.reports.products');
    }

    public function products_datatable(Request $request)
    {
        $datatable = DataTable::drawTable($request, $this->report->QueryProducts($request));
        $datatable['data'] = ProductSalesResource::collection($datatable['data']);
        return Response()->json($datatable);
    }

    public function payments()
    {
        return view('order::dashboard.reports.payments');
    }

    public function payments_datatable(Request $request)
    {
        $datatable = DataTable::drawTable($request, $this->report->QueryPayments($request));
        $datatable['data'] = PaymentSalesResource::collection($datatable['data']);
        return Response()->json($datatable);
    }
}
