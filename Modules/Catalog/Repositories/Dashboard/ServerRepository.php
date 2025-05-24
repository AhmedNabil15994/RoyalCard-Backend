<?php

namespace Modules\Catalog\Repositories\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Catalog\Entities\Product;
use Modules\Catalog\Entities\Server;
use Modules\Core\Repositories\Dashboard\CrudRepository;

class ServerRepository extends CrudRepository
{

    public function __construct()
    {
        parent::__construct(Server::class);
        $this->statusAttribute = ['status'];
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

        return $query;
    }

    public function getById($id){
        $id = (int) $id;
        return  $this->model->active()->find($id);
    }
}
