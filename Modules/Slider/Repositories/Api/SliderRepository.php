<?php

namespace Modules\Slider\Repositories\Api;

use Modules\Slider\Entities\Slider;

class SliderRepository
{
    private $faq;
    public function __construct(Slider $faq)
    {
        $this->faq = $faq;
    }

    public function getAll($request,$order = 'id', $sort = 'desc')
    {
        return $this->faq->active()->orderBy($order, $sort)->get();
    }
}
