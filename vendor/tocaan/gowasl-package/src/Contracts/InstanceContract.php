<?php

namespace WAIntegration\Contracts;

interface InstanceContract
{
    public function qr();
    public function status();
    public function disconnect();
    public function clearInstance();
    public function clearInstanceData();
}
