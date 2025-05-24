<?php

namespace Modules\Log\Repositories\Dashboard;

use DB;
use Modules\Core\Repositories\Dashboard\CrudRepository;
use Modules\Log\Entities\Activity;

class LogRepository extends CrudRepository
{
    public function __construct()
    {
        parent::__construct(Activity::class);
    }

    public function QueryTable($request)
    {
        $query = $this->model->where('causer_id','!=',null)->where(function ($query) use ($request) {
            $query->where('id', 'like', '%' .strtolower( $request->input('search.value')) . '%');
            $this->appendSearch($query, $request);
            foreach ($this->getModelTranslatable() as $key) {
                $col = $key . '->' . locale();
                $query->orWhere(\Illuminate\Support\Facades\DB::raw('LOWER(' . $key . ')'), 'like', '%' . $request->input('search.value') . '%');
            }
        });


        $query = $this->filterDataTable($query, $request);

        return $query;
    }
}
