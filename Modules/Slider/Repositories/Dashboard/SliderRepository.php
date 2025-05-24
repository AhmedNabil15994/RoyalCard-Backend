<?php

namespace Modules\Slider\Repositories\Dashboard;

use DB;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Modules\Core\Repositories\Dashboard\CrudRepository;

class SliderRepository extends CrudRepository
{

    public function prepareData(array $data, Request $request, $is_create = true): array
    {
        if($data['type'] == 'product'){
            $data['link'] = $data['product_id'];
        }else if($data['type'] == 'category'){
            $data['link'] = $data['category_id'];
        }
        $request['link'] = $data['link'];
        unset($data['product_id']);
        unset($data['category_id']);
        return $data;
    }
}
