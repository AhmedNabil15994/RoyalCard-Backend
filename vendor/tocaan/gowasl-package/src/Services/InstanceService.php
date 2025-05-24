<?php

namespace WAIntegration\Services;

use WAIntegration\Contracts\InstanceContract;
use WAIntegration\WAconnection;

class InstanceService implements InstanceContract
{
    public $base = '/instances';
    public function qr()
    {
        return (new WAconnection())->startRequest($this->base.'/qr');
    }
    public function status()
    {
        return (new WAconnection())->startRequest($this->base.'/status');
    }
    public function disconnect()
    {
        return (new WAconnection())->startRequest($this->base.'/disconnect','POST');
    }
    public function clearInstance()
    {
        return (new WAconnection())->startRequest($this->base.'/clearInstance','POST');
    }
    public function clearInstanceData()
    {
        return (new WAconnection())->startRequest($this->base.'/clearInstanceData','POST');
    }
}
