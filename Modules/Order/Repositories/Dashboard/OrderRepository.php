<?php

namespace Modules\Order\Repositories\Dashboard;

use Modules\Core\Traits\RepositorySetterAndGetter;
use Modules\Order\Entities\Order;
use DB;
use Auth;

class OrderRepository
{
    use RepositorySetterAndGetter;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function monthlyOrders()
    {
        $data["orders_dates"] = $this->order->whereHas('orderStatus', function ($query) {
            $query->successPayment();
        });

        $ordersIncome = $this->order->whereHas('orderStatus', function ($query) {
            $query->successPayment();
        });

        if((request()->has('from') && !empty(request()->get('from'))) &&
            (request()->has('to') && !empty(request()->get('to')))){
            $data["orders_dates"] = $data["orders_dates"]->whereDate('created_at', '>=', request()->from)->whereDate('created_at', '<=', request()->to);
            $ordersIncome = $ordersIncome->whereDate('created_at', '>=', request()->from)->whereDate('created_at', '<=', request()->to);
        }

        $data["orders_dates"] = $data["orders_dates"]->select(\DB::raw("DATE_FORMAT(created_at,'%Y-%m') as dates"))
            ->groupBy('dates')
            ->orderBy('created_at','asc')
            ->pluck('dates');


        $ordersIncome = $ordersIncome->select(\DB::raw("sum(total) as profit"))
            ->groupBy(\DB::raw("DATE_FORMAT(created_at, '%Y-%m')"))
            ->orderBy('created_at','asc')
            ->get();

        $data["profits"] = json_encode(array_pluck($ordersIncome, 'profit'));

        return $data;
    }

    public function ordersType()
    {
        $orders = $this->order->with('orderStatus');
        if((request()->has('from') && !empty(request()->get('from'))) &&
            (request()->has('to') && !empty(request()->get('to')))){
            $orders = $orders->whereDate('created_at', '>=', request()->from)->whereDate('created_at', '<=', request()->to);
        }

        $orders = $orders->select("order_status_id", \DB::raw("count(id) as count"))
            ->groupBy('order_status_id')
            ->get();


        foreach ($orders as $order) {
            $status = $order->orderStatus->title;
            $order->type = $status;
        }

        $data["ordersCount"] = json_encode(array_pluck($orders, 'count'));
        $data["ordersType"] = json_encode(array_pluck($orders, 'type'));

        return $data;
    }

    public function completeOrders()
    {
        $orders = $this->order->whereHas('orderStatus', function ($query) {
            $query->successPayment();
        })->count();

        return $orders;
    }

    public function totalProfit()
    {
        return $this->order->whereHas('orderStatus', function ($query) {
            $query->successPayment();
        })->sum('total');
    }

    public function totalTodayProfit()
    {
        return $this->order->whereHas('orderStatus', function ($query) {
            $query->successPayment();
        })
            ->whereDate("created_at", \DB::raw('CURDATE()'))
            ->sum('total');
    }

    public function totalMonthProfit()
    {
        return $this->order->whereHas('orderStatus', function ($query) {
            $query->successPayment();
        })
            ->whereMonth("created_at", date("m"))
            ->whereYear("created_at", date("Y"))
            ->sum('total');
    }

    public function totalYearProfit()
    {
        return $this->order->whereHas('orderStatus', function ($query) {
            $query->successPayment();
        })
            ->whereYear("created_at", date("Y"))
            ->sum('total');
    }

    public function getAll($order = 'id', $sort = 'desc')
    {
        $orders = $this->order->orderBy($order, $sort)->get();
        return $orders;
    }

    public function findById($id)
    {
        $order = $this->order->withDeleted()->find($id);

        return $order;
    }

    public function update($request, $id)
    {
        $order = $this->findById($id);
        $updateData = [
            'support_status_id' => $request['support_status_id'],
            'date' => $request['date'],
            'delivery_time' => $request['time'],
        ];

        if(isset($request['status_id']) && !empty($request['status_id'])){
            $updateData['order_status_id'] = $request['status_id'];
        }

        if(isset($request['support_status_id']) && !empty($request['support_status_id'])){
            if($order->order_status_id == 5 && $request['support_status_id'] == 3){
                $updateData['order_status_id'] = 1;
            }
        }

        $order->update($updateData);

        return true;
    }

    public function updateUnread($id)
    {
        $order = $this->findById($id);

        $order->update([
            'unread' => true,
        ]);
    }

    public function updateDriver($request, $id)
    {
        $order = $this->findById($id);

        $order->driver()->updateOrCreate([
            'user_id' => $request['user_id'],
        ]);

        return true;
    }

    public function restoreSoftDelete($model)
    {
        $model->restore();
    }

    public function delete($id)
    {
        DB::beginTransaction();

        try {
            $model = $this->findById($id);

            if ($model->trashed()):
                $model->forceDelete(); else:
                $model->delete();
            endif;

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function deleteSelected($request)
    {
        DB::beginTransaction();

        try {
            foreach ($request['ids'] as $id) {
                $model = $this->delete($id);
            }

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function QueryTable($request)
    {
        $query = $this->order;
        $order_type = $request->order_type;

        if($request->order_status_id){
            $query= $query->where('order_status_id',$request->order_status_id);
        }

        if (isset($request['search']['value']) && !empty($request['search']['value'])) {
            $query = $query->whereHas('user', function ($q) use ($request) {
                $q->where('mobile','like', '%' .  $request['search']['value'].'%')
                    ->orWhere('email','like', '%' .  $request['search']['value'].'%');
            })->orWhere('id',$request['search']['value']/34567);

        }

        if (isset($request['req']['country_id']) && !empty($request['req']['country_id'])) {
            $query = $query->where('country_id',  $request['req']['country_id']);
        }

        if (isset($request['req']['product_id']) && !empty($request['req']['product_id'])) {
            $query = $query->whereHas('products',function ($q) use ($request){
                $q->where('products.id',$request['req']['product_id']);
            });
        }

        if (isset($request['country_id']) && !empty($request['country_id'])) {
            $query = $query->where('country_id',  $request['country_id']);
        }


        $query = $this->filterDataTable($query, $request);

        return $query;
    }

    public function filterDataTable($query, $request)
    {
        if (isset($request['req']['from']) && $request['req']['from'] != '') {
            $query->whereDate('created_at', '>=', $request['req']['from']);
        }

        if (isset($request['req']['to']) && $request['req']['to'] != '') {
            $query->whereDate('created_at', '<=', $request['req']['to']);
        }

        if (isset($request['req']['deleted']) && $request['req']['deleted'] == 'only') {
            $query->onlyDeleted();
        }

        if (isset($request['req']['deleted']) && $request['req']['deleted'] == 'with') {
            $query->withDeleted();
        }

        if (isset($request['req']['status']) && $request['req']['status'] == '1') {
            $query->active();
        }

        if (isset($request['req']['status']) && $request['req']['status'] == '0') {
            $query->unactive();
        }

        if (isset($request['req']['status_id'])) {
            $query->where('order_status_id', $request['req']['status_id']);
        }

        if (isset($request['req']['product_id'])) {
            $query->whereHas('orderItems', function ($q) use ($request) {
                $q->where('product_id', $request['req']['product_id']);
            });
        }

        if (isset($request['req']['mobile'])) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('mobile','like', '%' .  $request['req']['mobile'].'%');
            });
        }

        if (isset($request['req']['email'])) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('email','like', '%' .  $request['req']['email']. '%');
            });
        }

        if (isset($request->status_id)) {
            $query->where('order_status_id', $request->status_id);
        }
        return $query;
    }
}
