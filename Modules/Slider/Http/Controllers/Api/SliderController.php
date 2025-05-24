<?php

namespace Modules\Slider\Http\Controllers\Api;

use Illuminate\Http\Request;
use Modules\Apps\Http\Controllers\Api\ApiController;
use Modules\Slider\Entities\Slider;
use Modules\Slider\Repositories\Api\SliderRepository;
use Modules\Slider\Transformers\Api\SliderResource;

class SliderController extends ApiController
{
    function __construct(SliderRepository $slider)
    {
        $this->slider = $slider;
    }

    public function index(Request $request)
    {
        $sliders =  $this->slider->getAll($request);
        return $this->response(SliderResource::collection($sliders));
    }

}
