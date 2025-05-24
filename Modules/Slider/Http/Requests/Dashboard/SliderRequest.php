<?php

namespace Modules\Slider\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class SliderRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title.*' => 'required',
            'description.*' => 'required',
            'order' => 'nullable',
            'image' => 'nullable|mimes:jpeg,png,jpg,gif,svg|max:10000',
            'type'  => 'required',
            'link'  => 'required_if:type,==,external',
            'category_id'  => 'required_if:type,==,category',
            'product_id'  => 'required_if:type,==,product',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
