<?php

namespace Modules\Slider\Transformers\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class SliderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'image' => $this->getFirstMediaUrl('images'),
            'title' => $this->title,
            'type' => $this->type,
            'link' => $this->link,
            'description' => strip_tags($this->description),
        ];
    }
}
