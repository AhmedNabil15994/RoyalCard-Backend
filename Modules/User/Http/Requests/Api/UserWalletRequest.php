<?php

namespace Modules\User\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Modules\User\Rule\Api\OldPasswordRule;

class UserWalletRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'balance'          => 'required',
        ];
    }

    public function authorize()
    {
        return true;
    }
}
