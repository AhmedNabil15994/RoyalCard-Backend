<?php

namespace Modules\Category\Transformers\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    public function toArray($request)
    {
        $response = [
           'id'            => $this->id,
           'image'         => $this->getFirstMediaUrl('images'),
           'title'         => $this->title,
           'width_ratio'   => $this->width_ratio,
           'height_ratio'   => $this->height_ratio,
       ];

       if(count($this->children)){
            $response['children'] = CategoryResource::collection($this->children);
       }

        return $response;
    }
}
