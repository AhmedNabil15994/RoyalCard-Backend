<?php

namespace Modules\Catalog\Repositories\Dashboard;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Catalog\Entities\Product;
use Modules\Core\Repositories\Dashboard\CrudRepository;

class ProductRepository extends CrudRepository
{

    public function __construct()
    {
        parent::__construct(Product::class);
        $this->statusAttribute = ['status'];
        $this->fileAttribute       = ['image' => 'images'];
    }

    public function QueryTable($request)
    {
        $query = $this->model->where(function ($q) use ($request){
            if (isset($request['search']['value']) && !empty($request['search']['value'])) {
                $q->where(DB::raw('lower(title)'),'LIKE','%'.strtolower($request['search']['value']).'%');
            }
        });

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

        if (isset($request['req']['deleted']) && $request['req']['deleted'] == 'only' ||
            isset($request['req']['show_all_deleted']) && $request['req']['show_all_deleted']) {
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

        return $query;
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();

        $model = $this->findById($id);
        $request->trash_restore ? $this->restoreSoftDelete($model) : null;

        try {
            if ($key = array_search('null', $request->all())) {
                $request->merge([$key => null]);
            }

            $status = $this->handleStatusInRequest($request);
            $data = $request->all();
            if (count($status) > 0) {
                $data = array_merge($data, $status);
            }
            // call the prepareData fuction
            $data = $this->prepareData($data, $request, false);

            $model->update($data);

            // call the callback  fuction
            $this->modelUpdated($model, $request);

            $this->handleFileAttributeInRequest($model, $request, true,'images');

            DB::commit();
            $this->commitedAction($model, $request, "update");
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function prepareData(array $data, Request $request, $is_create = true): array
    {
        if(isset($request->codes) && !empty($request->codes)) {
            $codes = explode("\r\n", $request->codes);
            if(count($codes)){
                $data['codes'] = json_encode($codes);
                $data['qty'] = sizeof($codes);
                $request->codes = $codes;
            }
        }else{
            $data['qty'] = $request->qty;
        }

        if(isset($request->available_servers) && !empty($request->available_servers)) {
            $data['available_servers'] = json_encode($request->available_servers);
        }else{
            $data['available_servers'] = null;
        }

        if(isset($request->prices) && !empty($request->prices)) {
            $data['prices'] = json_encode($request->prices);
        }

        if(isset($request->shipment) && !empty($request->shipment)) {
            $data['shipment'] = json_encode($request->shipment);
        }

        $types = [];
        $values = [];
        $percentages = [];
        if($request->discount_type && !empty($request->discount_type)) {
            foreach ($request->discount_type as $key => $value) {
                $types[$key] = $value;
                $values[$key] = $value == 'value' ? $request->discount_value[$key] : null;
                $percentages[$key] = $value == 'percentage' ? $request->discount_percentage[$key] : null;
            }
            $data['cashback_rate'] = [
                'discount_type' =>  $types,
                'discount_value' =>  $values,
                'discount_percentage' =>  $percentages,
            ];

            return $data;
        }

        return  $data;
    }

    public function modelUpdated($model, $request): void
    {
        if(isset($request->category_id) && !empty($request->category_id)){
            $model->categories()->sync(explode(',',$request->category_id));
        }

        if(isset($request->codes) && !empty($request->codes)) {
            if(count($request->codes)){
                $newCodes = $request->codes;
                if(count($newCodes)){
                    $model->items()->where('status',1)->delete();
                    foreach ($newCodes as $newCode){
                        $model->items()->create([
                            'code'  => $newCode,
                        ]);
                    }
                }

                $model->update(['qty' => $model->items()->where('status',1)->count()]);
            }
        }
//        else{
//            $oldCodes = $model->items()->count();
//            $newCodes = $request->qty - $oldCodes;
//            if($newCodes){
//                for ($i = 0; $i < $newCodes; $i++) {
//                    $model->items()->create([
//                        'code'  => strtoupper(\Str::random(10)),
//                    ]);
//                }
//            }
//
//            $removedCodes = $oldCodes - $request->qty;
//            if(abs($removedCodes)){
//                for ($i = 0; $i < abs($removedCodes); $i++) {
//                    $model->items()->where('status',1)->delete();
//                }
//            }
//            $model->update(['qty'=>$request->qty]);
//        }
        $this->productOffer($model,$request);
    }

    public function modelCreated($model, $request, $is_created = true): void
    {
        if(isset($request->codes) && !empty($request->codes)) {
            if(count($request->codes)){
                foreach ($request->codes as $code){
                    if($code){
                        $model->items()->create([
                            'code'  => $code,
                        ]);
                    }
                }
            }
            $model->update(['qty' => $model->items()->whereIn('status',[1,2])->count()]);
        }else{
            if($request->qty > 0){
                for ($i = 0; $i < $request->qty; $i++) {
                    $model->items()->create([
                        'code'  => strtoupper(\Str::random(10)),
                    ]);
                }
            }
            $model->update(['qty'=>$request->qty]);
        }

        if(isset($request->category_id) && !empty($request->category_id)){
            $model->categories()->sync(explode(',',$request->category_id));
        }

        $this->productOffer($model,$request);
    }

    public function productOffer($model, $request)
    {
        if(isset($request->offers) && !empty($request->offers)) {
            foreach ($request->offers as $country_id => $offer){
                $item = [
                    'country_id' => $country_id,
                    'product_id' => $model->id,
                    'status' =>  true,
                    'price' => null,
                    'percentage' => null,
                    'start_at'  => Carbon::parse($offer['start_at'])->toDateString(),
                    'end_at'    => Carbon::parse($offer['end_at'])->toDateString(),
                ];

                if ($offer['type'] == 'amount') {
                    $item['price'] = $offer['price'];
                } elseif ($offer['type'] == 'percentage') {
                    $item['percentage'] = $offer['percentage'];
                }

                if($item['price'] || $item['percentage']){
                    $model->offers()->updateOrCreate([
                        'country_id' => $country_id,
                        'product_id' => $model->id,
                    ],$item);
                }
            }
        }
    }
}
