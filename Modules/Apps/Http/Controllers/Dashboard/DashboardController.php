<?php

namespace Modules\Apps\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Area\Entities\Country;
use Modules\Authorization\Entities\Role;
use Modules\Catalog\Entities\Product;
use Modules\Course\Entities\Course;
use Modules\Course\Entities\Note;
use Modules\Exam\Entities\Exam;
use Modules\Offer\Entities\Offer;
use Modules\Order\Entities\Order;
use Modules\Order\Entities\OrderItem;
use Modules\Order\Repositories\Dashboard\OrderRepository;
use Modules\Package\Entities\Package;
use Modules\Trainer\Entities\Trainer;
use Modules\User\Entities\User;
use DB;
class DashboardController extends Controller
{
    public function __construct(OrderRepository $order) {
        $this->order = $order;
    }

    public function index(Request $request) {
        $countries = [];
        foreach (Country::whereIn('id',setting('supported_countries'))->get() as $code => $country){
            if (collect(setting('supported_countries'))->contains($country->id)){
                $countries[$country->id] = [
                    'totalOrdersCount' => $this->filterOrder($request,Order::paid()->where('country_id',$country->id))->count(),
                    'activeOrdersCount' => $this->filterOrder($request,Order::payment()->where('country_id',$country->id))->count(),
                    'supportOrdersCount' => $this->filterOrder($request,Order::support()->where('country_id',$country->id))->count(),
                    'income'  => $this->filterOrder($request,Order::paid()->where('country_id',$country->id))->sum('total'),
                    'currency'  => $country?->currency?->code,
                ];
            }
        }

        $data= [
            'totalOrdersCount' => $this->filterOrder($request,Order::paid())->count(),
            'activeOrdersCount' => $this->filterOrder($request,Order::payment())->count(),
            'supportOrdersCount' => $this->filterOrder($request,Order::support())->count(),
            'products'  => Product::count(),
            'countries' => $countries,
        ];

        $chartsData = $this->getChartsData($request);
        $data = array_merge($data,$chartsData);
        return view('apps::dashboard.index',compact('data'));
    }

    private function filter($request, $model)
    {
        return $model->where(function ($query) use ($request) {
            // Search Users by Created Dates
            if ($request->from)
                $query->whereDate('created_at', '>=', $request->from);

            if ($request->to)
                $query->whereDate('created_at', '<=', $request->to);

        });
    }
    private function filterOrder($request, $model)
    {
        return $model->where(function ($query) use ($request) {
            // Search Users by Created Dates
            if ($request->from)
                $query->whereDate('created_at', '>=', $request->from);

            if ($request->to)
                $query->whereDate('created_at', '<=', $request->to);

            if ($request->country_id)
                $query->where('country_id', $request->country_id);
        });
    }

    private function getChartsData($request) {
        $data['userCreated']["userDate"] = User::doesnthave('roles')
            ->where(function ($q){
                if((request()->has('from') && !empty(request()->get('from'))) &&
                    (request()->has('to') && !empty(request()->get('to')))){
                   $q->whereDate('created_at', '>=', request()->from)->whereDate('created_at', '<=', request()->to);
                }
            })
            ->select(DB::raw("DATE_FORMAT(created_at,'%Y-%m') as date"))
            ->groupBy('date')
            ->orderBy('created_at','asc')
            ->pluck('date');

        $userCounter = User::doesnthave('roles')
            ->where(function ($q){
                if((request()->has('from') && !empty(request()->get('from'))) &&
                    (request()->has('to') && !empty(request()->get('to')))){
                    $q->whereDate('created_at', '>=', request()->from)->whereDate('created_at', '<=', request()->to);
                }
            })
            ->select(DB::raw("count(id) as countDate"))
            ->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m')"))
            ->orderBy('created_at','asc')
            ->get();

        $data['userCreated']["countDate"] = json_encode(array_column($userCounter->toArray(), 'countDate'));
        $data['monthlyOrders'] = $this->order->monthlyOrders();

        return $data;
    }
}
