<?php

namespace Modules\Catalog\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch ($this->getMethod()) {
            // handle creates
            case 'post':
            case 'POST':

                return [
                    'title.*' => 'required',
                    'description.*' => 'nullable',
                    'prices.*' => 'required',
                    'image' =>  'required',
                    'codes' => 'required_if:product_type,==,digital',
                    'qty'   => 'required_if:product_type,==,physical',
                    'product_type'  => 'required',
                    'category_id'   => 'required',
                    'international_code'    => 'required_if:product_type,==,physical',
                    'sku'    => 'required_if:product_type,==,physical',
                    'shipment.weight'    => 'required_if:product_type,==,physical',
                    'shipment.width'    => 'required_if:product_type,==,physical',
                    'shipment.length'    => 'required_if:product_type,==,physical',
                    'shipment.height'    => 'required_if:product_type,==,physical',
                    'order' => 'nullable',
                    'available_servers'   => 'nullable',
                ];

            //handle updates
            case 'put':
            case 'PUT':
                return [
                    'title.*' => 'required',
                    'description.*' => 'nullable',
                    'prices.*' => 'required',
                    'image' =>  'nullable',
//                    'codes' => 'required_if:product_type,==,digital',
//                    'qty'   => 'required_if:product_type,==,physical',
                    'product_type'  => 'required',
                    'category_id'   => 'required',
                    'international_code'    => 'required_if:product_type,==,physical',
                    'sku'    => 'required_if:product_type,==,physical',
                    'shipment.weight'    => 'required_if:product_type,==,physical',
                    'shipment.width'    => 'required_if:product_type,==,physical',
                    'shipment.length'    => 'required_if:product_type,==,physical',
                    'shipment.height'    => 'required_if:product_type,==,physical',
                    'available_servers'   => 'nullable',
                    'order' => 'nullable',
                ];
        }
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
