<?php

namespace Modules\Authentication\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegisterRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'        => 'required',
            'calling_code' => 'nullable|numeric',
            'mobile' =>  'required|unique:users,mobile,'. $this->mobile . '',
//                'required',
////                'unique:users,mobile,'. $mobile,
//                Rule::unique('users','mobile')->where(function ($query) use ($mobile) {
//                    return $query->where('mobile', $mobile);
//                }),
//                'numeric', 'digits_between:3,20',

            'email' => 'nullable|email|unique:users,email',

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
