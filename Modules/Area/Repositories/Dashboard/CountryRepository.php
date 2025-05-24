<?php

namespace Modules\Area\Repositories\Dashboard;

use Modules\Area\Entities\Country;
use Modules\Core\Repositories\Dashboard\CrudRepository;

class CountryRepository extends CrudRepository
{
    //
    public function __construct(Country $model)
    {
        parent::__construct();
        $this->model = $model;
    }
}
