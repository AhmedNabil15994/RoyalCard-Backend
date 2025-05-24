<?php

namespace WAIntegration\Facades;
use Illuminate\Support\Facades\Facade;

class InstanceFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'Instance';
    }
}
