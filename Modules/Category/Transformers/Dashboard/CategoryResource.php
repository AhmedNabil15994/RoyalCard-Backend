<?php

namespace Modules\Category\Transformers\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
           'id'            => $this->id,
            'title'         => $this->title,
            'category_id'         => $this->category_id,
            'image'         => $this->getFirstMediaUrl('images') ?? '',
            'banner'         => $this->getFirstMediaUrl('banners') ?? '',
            'type'          => $this->category_id ? __('category::dashboard.categories.datatable.child') : __('category::dashboard.categories.datatable.parent'),
           'status'        => $this->status,
           'deleted_at'    => $this->deleted_at,
           'created_at'    => date('d-m-Y' , strtotime($this->created_at)),
       ];
    }
}
