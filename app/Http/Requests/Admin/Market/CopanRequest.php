<?php

namespace App\Http\Requests\Admin\Market;

use Illuminate\Foundation\Http\FormRequest;

class CopanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'status' => 'required|numeric|in:0,1',
            'type' => 'required|numeric|in:0,1',
            'code' => 'required|max:120|min:2|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي., ]+$/u',
            'amount_type' => 'required|numeric|in:0,1',
            'amount' => [(request()->amount_type == 0) ? 'max:100' : '' , 'required', 'numeric'],
            'discount_ceiling' => 'required_if:amount_type, 0',
            'start_date' => 'required|numeric',
            'end_date' => 'required|numeric',
            'user_id' => 'required_if:type,1|exists:users,id|numeric|min:1',
        ];
    }

    public function attributes()
    {
        return [
            'code' => 'کد تخفیف',
            'amount' => 'مقدار تخفیف',
            'amount_type' => 'نوع تخفیف' ,  
            'user_id' => 'کاربر',
            'type' => 'نوع کوپن',
        ];
    }
}
